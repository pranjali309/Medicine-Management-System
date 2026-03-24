<?php
session_start();
include('../includes/db.php'); 

// Check if user is logged in
$profile_photo = "uploads/default.png"; // Default image
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT profile_photo FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!empty($user['profile_photo'])) {
        $profile_photo = $user['profile_photo'];
    }
}

include('../includes/connect.php');

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($con, $_GET['search']);
    $select_products = "SELECT * FROM products WHERE product_name LIKE '%$search_query%' ORDER BY created_at DESC";
} else {
    $select_products = "SELECT * FROM products ORDER BY created_at DESC";
}

$result_products = mysqli_query($con, $select_products);


if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to view your cart!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = [];
$grand_total = 0;

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT c.product_id, c.quantity, p.product_title, p.price, p.product_image1, p.stock_quantity 
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $grand_total += $row['price'] * $row['quantity'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    <body>
<style>
    
    .navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
        font-weight: 500;
      }
      .navbar-light .navbar-brand{
        color: #000;
        font-size: 25px;
        
        font-weight: 700;
        letter-spacing: 2px;
      }
      
      .w-100{
        height: 100vh;
      }
      .nav-link:hover {
            color:rgb(36, 179, 241) !important;
        }
        .containers {
    margin-top: 10%; /* Navbar ani container madhil space */
    margin-bottom: 10%; /* Footer cha space maintain kara */
}

        
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <div class="d-flex align-items-center me-4">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="d-flex align-items-center text-decoration-none">
                <img src="<?php echo $profile_photo; ?>" alt="Profile Photo" class="rounded-circle" width="40" height="40">
            </a>
        <?php endif; ?>
    </div>
    <a class="navbar-brand" href="home.php"><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link active" href="product_page1.php">Product</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
      </ul>
      <form class="d-flex" action="product_page1.php" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" required>
        <button class="btn btn-outline-success me-2" type="submit">Search</button>
      </form>
      <a href="wishlist.php" class="btn"><i class="bi bi-suit-heart-fill text-danger"></i></a>
      <a href="cart.php" class="btn"><i class="bi bi-cart-fill"></i></a>
      <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>">
            <i class="bi bi-person-fill"></i>
      </a>
    </div>
  </div>
</nav>


<div class="containers">
    <h1 class="text-center mb-4">Shopping Cart</h1>

    <?php if (!empty($cart_items)) { ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><img src="../uploads/<?php echo htmlspecialchars($item['product_image1'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($item['product_title'] ?? 'No Title'); ?>" width="80"></td>
                            <td><?php echo htmlspecialchars($item['product_title'] ?? 'No Title'); ?></td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary update-cart" data-id="<?php echo $item['product_id']; ?>" data-action="decrease">-</button>
                                <span id="quantity_<?php echo $item['product_id']; ?>"><?php echo $item['quantity']; ?></span>
                                <button class="btn btn-sm btn-outline-secondary update-cart" data-id="<?php echo $item['product_id']; ?>" data-action="increase">+</button>
                            </td>
                            <td>₹<span id="total_<?php echo $item['product_id']; ?>"><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span></td>
                            <td>
                                <a href="remove_from_cart.php?product_id=<?php echo $item['product_id']; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Grand Total: ₹<span id="grand_total"><?php echo number_format($grand_total, 2); ?></span></h4>
            <form action="checkout.php" method="POST">
                <button type="submit" class="btn btn-success">Proceed to Checkout</button>
            </form>
        </div>

    <?php } else { ?>
        <p class="text-center text-danger">Your cart is empty.</p>
    <?php } ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".update-cart").click(function() {
        let product_id = $(this).data("id");
        let action = $(this).data("action");
        let quantityElement = $("#quantity_" + product_id);
        let totalElement = $("#total_" + product_id);
        let grandTotalElement = $("#grand_total");
        let currentQuantity = parseInt(quantityElement.text());

        // Prevent decreasing below 1
        if (action === "decrease" && currentQuantity <= 1) {
            return;
        }

        $.ajax({
            url: "update_cart.php",
            type: "POST",
            data: { product_id: product_id, action: action },
            dataType: "json",
            success: function(response) {
                console.log(response); // Debugging - Console मध्ये response print होईल

                if (response.success) {
                    quantityElement.text(response.quantity);
                    totalElement.text( + response.total_price);
                    grandTotalElement.text( + response.grand_total);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error: ", error);
                alert("Error updating cart. Please try again.");
            }
        });
    });
});
</script>

      
<!-- footer -->
<?php include("footer.php"); ?>

</body>
</html>
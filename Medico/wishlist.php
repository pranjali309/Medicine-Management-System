<?php
session_start();
include('../includes/db.php');

// Check if user is logged in
$profile_photo = "uploads/default.png"; // Default profile image
$wishlist_items = []; // Initialize wishlist array

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user's profile photo
    $sql = "SELECT profile_photo FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!empty($user['profile_photo'])) {
        $profile_photo = $user['profile_photo'];
    }

    // Fetch wishlist items from database
    $wishlist_query = "SELECT product_id FROM wishlist WHERE user_id = ?";
    $stmt = $conn->prepare($wishlist_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $wishlist_result = $stmt->get_result();

    while ($row = $wishlist_result->fetch_assoc()) {
        $wishlist_items[] = $row['product_id']; // Store product IDs in array
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }
        .wishlist-card {
            border-radius: 10px;
            background: #fff;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .wishlist-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
        .wishlist-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .wishlist-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            gap: 8px;
        }
        .wishlist-container {
            margin-top: 100px; /* Moves the heading lower */
            margin-bottom: 70px; /* Adds space before the footer */
        }
        

    </style>
</head>
<body>
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

<div class="container mt-5">
<h1 class="text-center" style="margin-top: 80px; margin-bottom: 30px;">My Wishlist</h1>


    <div class="row g-4">
        <?php
        if (!empty($wishlist_items)) {
            foreach ($wishlist_items as $product_id) {
                $query = "SELECT * FROM products WHERE product_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    echo "<div class='col-lg-4 col-md-6'>
                            <div class='wishlist-card shadow-sm'>
                                <img src='../uploads/{$row['product_image1']}' alt='{$row['product_name']}'>
                                <h5 class='mt-3 fw-bold'>{$row['product_name']}</h5>
                                <p class='text-success fw-bold'>₹{$row['price']}</p>
                                <div class='wishlist-actions'>
                                    <a href='product_details.php?product_id={$product_id}' class='btn btn-outline-primary'>View</a>
                                    <a href='add_to_cart.php?product_id={$product_id}' class='btn btn-outline-success'>Move to Cart</a>
                                    <a href='remove_from_wishlist.php?product_id={$product_id}' class='btn btn-outline-danger'>Remove</a>
                                </div>
                            </div>
                        </div>";
                }
                $stmt->close();
            }
        } else {
            echo "<p class='text-center text-danger'>Your wishlist is empty.</p>";
        }
        ?>
    </div>
</div>
<!-- footer -->
<?php include("footer.php"); ?>
</body>
</html>

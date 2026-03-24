<?php


session_start();
include('../includes/db.php'); // Database connection

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
      body {
        /* background: #f1f1ff;
    height: 100%; */
    /* display: flex;
    flex-direction: column; */
    /* font-family: 'Poppins'; */
    font-family: 'Arial', sans-serif;
}


 /* navbar */
.navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
        font-family: 'Poppins';
      }
.navbar {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
}

.navbar-nav .nav-link {
    font-weight: 500;
    transition: color 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover, 
.navbar-nav .nav-link.active {
    color: #ff9800;
}
.container {
    flex: 1;
}

.product-card {
    border-radius: 10px;
    background: #fff;
    padding: 15px;
    text-align: center;
    transition: transform 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.product-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

footer {
    text-align: center;
    padding: 20px;
    background-color: #f8f9fa;
    width: 100%;
    position: relative;
}

        
    </style>
</head>


<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
    <div class="d-flex align-items-center me-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="d-flex align-items-center text-decoration-none">
                        <img src="<?php echo $profile_photo; ?>" alt="Profile Photo" class="rounded-circle" width="40" height="40">
                        
                    </a>
                <?php else: ?>
                    <!-- <a href="login.php" class="btn btn-primary"></a> -->
                <?php endif; ?>
            </div>
        <a class="navbar-brand" href="home.php"><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link " href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link active" href="product_page1.php">Product</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            </ul>
            <form class="d-flex" action="product_page1.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" required>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <a href="wishlist.php" class="btn"><i class="bi bi-suit-heart-fill text-danger"></i></a>
            <a href="cart.php" class="btn"><i class="bi bi-cart-fill"></i></a>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>" class="btn">
                <i class="bi bi-person-fill"></i>
            </a>
        </div>
    </div>
</nav>
<div class="container mt-5 pt-5 text-center w-100">
    <h1 class="mb-4 pb-2">Our Products</h1>


    <div class="row g-4">
        <?php
        if (mysqli_num_rows($result_products) > 0) {
            while ($row = mysqli_fetch_assoc($result_products)) {
                $product_id = $row['product_id'];
                $product_name = $row['product_name']; // Ensure consistent column name
                $product_price = $row['price']; // Ensure consistent column name
                $product_image1 = $row['product_image1'];
                $upload_dir = "../uploads/";

                echo "
                <div class='col-lg-4 col-md-6'>
                    <div class='product-card shadow-sm'>
                        <img src='$upload_dir$product_image1' alt='$product_name'>
                        <h5 class='mt-3 fw-bold'>$product_name</h5>
                        <p class='text-success fw-bold'>₹$product_price</p>
                        <div class='product-actions'>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-outline-primary'>
                                <i class='bi bi-eye-fill'></i> View Details
                            </a>
                            <a href='add_to_cart.php?product_id=$product_id' class='btn btn-outline-success'>
                                <i class='bi bi-cart-plus'></i> Add to Cart
                            </a>
                            <a href='add_to_wishlist.php?product_id=$product_id' class='btn btn-outline-danger'>
                                <i class='bi bi-heart-fill'></i> Wishlist
                            </a>
                        </div>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p class='text-center text-danger'>No products found for '$search_query'.</p>";
        }
        ?>
    </div>
   
</div>


</div>

<?php include 'footer.php'; ?>
</body>
</html>
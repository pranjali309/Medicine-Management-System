<?php
include('../includes/connect.php');

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$search = "";

// Check if a search query is present
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $query = "SELECT * FROM products WHERE product_title LIKE '%$search%' OR product_description LIKE '%$search%'";
} else {
    $query = "SELECT * FROM products";
}

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
    background-color: #eef2f7;
    font-family: 'Poppins', sans-serif;
}

.product-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
}

.product-image img {
    width: 100%;
    height: 250px; /* Adjust height as needed */
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.product-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

.btn {
    flex-grow: 1;
    text-align: center;
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top ">
  <div class="container">
    <a class="navbar-brand" href="#"><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="product.php">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a>
        </li>
      </ul>
      
      <form class="d-flex " action="product.php" method="">
    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" required>
    <button class="btn btn-outline-success me-2" type="submit">Search</button>
  </form>
        <a href="add_to_wishlist.php"><li class="btn" > <i class="bi bi-suit-heart"   ></i></li></a>
        <a href="add_to_cart.php"><li class="btn" ><i class="bi bi-cart-fill" ></i></li></a>
        <a href="admin_area\index.php"><li class="btn"><i class="bi bi-person-fill"></i></li></a>
    </div>
  </div>
</nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Our Products</h1>
        <div class="row">
        <div class="row">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="product-card p-3">
                    <div class="product-image">
                        <img src="../uploads/<?php echo $row['product_image1']; ?>" alt="<?php echo $row['product_title']; ?>">
                    </div>
                    <h5 class="mt-3"><?php echo $row['product_title']; ?></h5>
                    <p class="text-muted"><?php echo $row['product_description']; ?></p>
                    <p><strong>Price: ₹<?php echo $row['product_price']; ?></strong></p>
                    <div class="product-actions mt-3">
                        <button class="btn btn-outline-success add-to-cart" data-id="<?php echo $row['product_id']; ?>">
                        <a href="add_to_cart.php"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                        </button>
                        <button class="btn btn-outline-warning View" data-id="<?php echo $row['product_id']; ?>" >
                        <a href="add_to_wishlist.php">
                        <i class="fas fa-heart"></i>View Details</a>
                        </button>
                        <button class="btn btn-outline-danger wishlist" data-id="<?php echo $row['product_id']; ?>" >
                        <a href="add_to_wishlist.php">
                            <i class="fas fa-heart"></i></a>
                        </button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <h3 class="text-center text-danger">No products found for "<?php echo htmlspecialchars($search); ?>"</h3>
    <?php endif; ?>
</div>
  
</div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Add to cart functionality
        $('.add-to-cart').on('click', function () {
            const productId = $(this).data('id');
            $.post('add_to_cart.php', { product_id: productId }, function (response) {
                alert(response.message);
            }, 'json');
        });

        // Add to wishlist functionality
        $('.wishlist').on('click', function () {
            const productId = $(this).data('id');
            $.post('add_to_wishlist.php', { product_id: productId }, function (response) {
                alert(response.message);
            }, 'json');
        });

        $('.view_details').on('click', function () {
            const productId = $(this).data('id');
            $.post('product_details.php', { product_id: productId }, function (response) {
                alert(response.message);
            }, 'json');
        });
    </script>
    
</body>
</html>
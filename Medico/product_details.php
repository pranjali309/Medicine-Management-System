<?php
session_start();
include('../includes/db.php');

$profile_photo = "uploads/default.png";
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

// Check if product ID is provided
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo "<script>alert('Invalid product ID'); window.location.href='view_products.php';</script>";
    exit();
}

$product_id = intval($_GET['product_id']);

// Fetch product details
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Product not found'); window.location.href='view_products.php';</script>";
    exit();
}

$product = $result->fetch_assoc();

// Fetch related products (same category)
$related_query = "SELECT * FROM products WHERE category_id = ? AND product_id != ? LIMIT 4";
$related_stmt = $con->prepare($related_query);
$related_stmt->bind_param("ii", $product['category_id'], $product_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 30px;
        }

        .product-container {
            max-width: 950px;
            display: flex;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-top: 90px;
        }

        .product-image {
            width: 50%;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .product-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .product-details {
            width: 50%;
            padding: 25px;
            background: #fff;
        }

        .product-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product-info, .product-desc {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f;
            margin-bottom: 10px;
        }

        .product-discount {
            font-size: 18px;
            text-decoration: line-through;
            color: #777;
            margin-left: 10px;
        }

        .stock-status {
            font-size: 16px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 15px;
        }
        

/* Buttons Styling */
.btn-container .btn {
    flex: 1;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    transition: 0.3s ease-in-out;
    border: none;
}
      

        .btn {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s ease-in-out;
        }
        .add-to-cart {
    background: #28a745;
    color: white;
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.add-to-cart:hover {
    background: #218838;
    transform: scale(1.05);
}

.wishlist {
    background: #ffcc00;
    color: black;
    box-shadow: 0 4px 8px rgba(255, 204, 0, 0.3);
}

.wishlist:hover {
    background: #e0a800;
    transform: scale(1.05);
}

.buy-now {
    background: #007bff;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.buy-now:hover {
    background: #0056b3;
    transform: scale(1.05);
}

        .back-btn {
            display: inline-block;
            padding: 12px 18px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            background: #6c757d;
            color: white;
            border-radius: 5px;
            margin-top: 20px;
            transition: 0.3s ease-in-out;
        }

        .back-btn:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        .related-products {
            max-width: 950px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .related-title { font-size: 22px; font-weight: bold; margin-bottom: 20px; color: #333; }

        .related-items {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

       /* View Details Button */
.related-card a {
    display: block;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 12px;
    font-size: 15px;
    font-weight: bold;
    border-radius: 8px;
    transition: 0.3s ease-in-out;
    text-decoration: none;
    margin: 10px auto;
    width: 80%;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 91, 187, 0.3);
}

.related-card a:hover {
    background: linear-gradient(135deg, #0056b3, #003d80);
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 91, 187, 0.4);
}


        .related-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .related-card p {
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .related-card a {
            display: block;
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
            text-decoration: none;
        }


.d-flex {
    margin-left: 10px; /* Adds space between Search Bar and Navbar links */
}




        .related-card a:hover { background: #0056b3; }
        .navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
        font-weight: 500;
      }
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
        /* Reduce search button size */
.d-flex .btn-outline-success {
    padding: 6px 10px; /* Adjust padding to reduce size */
    font-size: 14px;
}

/* Reduce spacing between heart, cart, and login icons */
.navbar .btn {
    padding: 5px 10px; /* Reduce padding */
    font-size: 20px; /* Keep icon size consistent */
    margin-right: 1px; /* Reduce margin between icons */
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
                <?php else: ?>
                    <!-- <a href="login.php" class="btn btn-primary"></a> -->
                <?php endif; ?>
            </div>
    <a class="navbar-brand" href="home.php"><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active btn-outline-secondary" aria-current="page" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="product_page1.php">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex" action="product_page1.php" method="GET">
    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" required>
    <button class="btn btn-outline-success me-1" type="submit">Search</button>
  </form>
        <a href="wishlist.php"><li class="btn" > <i class="bi bi-suit-heart-fill text-danger"></i></a>
        <a href="cart.php"><li class="btn" ><i class="bi bi-cart-fill" ></i></li></a>
        <!-- <a href="login.php"><li class="btn"><i class="bi bi-person-fill"></i></li></a> -->
        <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>">
            <i class="bi bi-person-fill"></i>
        </a>
    </div>
  </div>

</nav>

    <div class="product-container">
        <div class="product-image">
            <img src="../uploads/<?php echo htmlspecialchars($product['product_image1']); ?>" alt="Product Image">
        </div>

         <!-- Product Details -->
         <div class="product-details">
            <h2 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <p class="product-desc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <p class="product-info"><strong>Medicine Type:</strong> <?php echo htmlspecialchars($product['medicine_type']); ?></p>
            <p class="product-info"><strong>Dosage Info:</strong> <?php echo htmlspecialchars($product['dosage_info']); ?></p>
            <p class="product-info"><strong>Prescription Required:</strong> <?php echo htmlspecialchars($product['prescription_required']); ?></p>
            <p class="product-info"><strong>Manufacturer:</strong> <?php echo htmlspecialchars($product['manufacturer']); ?></p>
            <p class="product-info"><strong>Storage Instructions:</strong> <?php echo nl2br(htmlspecialchars($product['storage_instructions'])); ?></p>
            <p class="product-info"><strong>Side Effects:</strong> <?php echo nl2br(htmlspecialchars($product['side_effects'])); ?></p>
            <p class="product-price">₹<?php echo htmlspecialchars($product['price']); ?>
                <?php if (!empty($product['discount_price'])) { ?>
                    <span class="product-discount">₹<?php echo htmlspecialchars($product['discount_price']); ?></span>
                <?php } ?>
            </p>
            <p class="stock-status">Stock: <?php echo htmlspecialchars($product['stock_quantity']); ?> Available</p>
            
            <div class="btn-container">
                <a href="add_to_cart.php?product_id=<?php echo $product_id; ?>" class="btn add-to-cart">Add to Cart</a>
                <a href="add_to_wishlist.php?product_id=<?php echo $product_id; ?>" class="btn wishlist">Add to Wishlist</a>
                <a href="checkout.php?product_id=<?php echo $product_id; ?>" class="btn buy-now">Buy Now</a>
            </div>
        </div>
    </div>

    <div class="related-products">
        <h2 class="related-title">Related Products</h2>
        <div class="related-items">
            <?php while ($row = $related_result->fetch_assoc()) { ?>
                <div class="related-card">
                    <img src="../uploads/<?php echo htmlspecialchars($row['product_image1']); ?>" alt="Related Product">
                    <p><?php echo htmlspecialchars($row['product_name']); ?></p>
                    <a href="product_details.php?product_id=<?php echo $row['product_id']; ?>">View Details</a>
                </div>
            <?php } ?>
        </div>
    </div>
    
<!-- footer -->
<?php include("footer.php"); ?>

</body>
</html>
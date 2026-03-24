<?php
include('../includes/connect.php');

// Fetch products from the database
$select_products = "SELECT * FROM products ORDER BY created_at DESC";


$result_products = mysqli_query($con, $select_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #eef2f7;
        }
        .product-card {
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-card .btn-group {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 10px;
        }
        .product-card .btn {
            flex: 1;
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Our Products</h1>
        <div class="row g-4">
            <?php
            if (mysqli_num_rows($result_products) > 0) {
                while ($row = mysqli_fetch_assoc($result_products)) {
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_price = $row['product_price'];
                    $product_image1 = $row['product_image1'];
                    $upload_dir = "../uploads/";
                    echo "
                    <div class='col-lg-4 col-md-6'>
                        <div class='product-card shadow-sm'>
                            <img src='$upload_dir$product_image1' alt='$product_title'>
                            <h5 class='mt-3 fw-bold'>$product_title</h5>
                            <p class='text-success fw-bold'>₹$product_price</p>
                            <div class='btn-group'>
                                <a href='product_details.php?product_id=$product_id' class='btn btn-primary'>View Details</a>
                                <a href='add_to_cart.php?product_id=$product_id' class='btn btn-success'>Add to Cart</a>
                                <a href='add_to_wishlist.php?product_id=$product_id' class='btn btn-danger'>Add to Wishlist</a>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center'>No products available right now. Please check back later!</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

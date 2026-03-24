<?php
session_start();
include('../includes/db.php'); // Ensure the database connection is included

if (!isset($_GET['product_id'])) {
    echo "<script>alert('Invalid product!'); window.location.href='product_page1.php';</script>";
    exit();
}

$product_id = intval($_GET['product_id']); // Ensure it's a valid integer

if (!isset($conn)) {
    die("Database connection error: " . mysqli_connect_error());
}

if (isset($_SESSION['user_id'])) {
    // User is logged in, store cart in the database
    $user_id = $_SESSION['user_id'];

    // Check if product already exists in the cart
    $check_query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_query);

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Product already in the cart!'); window.location.href='product_page1.php';</script>";
    } else {
        // Insert new product into the cart
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insert_query);

        if (!$stmt) {
            die("SQL error: " . $conn->error);
        }

        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();

        echo "<script>alert('Product added to the cart!'); window.location.href='product_page1.php';</script>";
    }
    $stmt->close();
} else {
    // User is not logged in, store cart in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (array_key_exists($product_id, $_SESSION['cart'])) {
        echo "<script>alert('Product already in the cart!'); window.location.href='product_page1.php';</script>";
    } else {
        $_SESSION['cart'][$product_id] = 1; // Add new product
        echo "<script>alert('Product added to the cart!'); window.location.href='product_page1.php';</script>";
    }
}
?>

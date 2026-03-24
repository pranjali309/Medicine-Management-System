<?php
session_start();

include('../includes/connect.php');
// Check if product ID is passed
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Initialize the cart session if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in the cart
    if (array_key_exists($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$product_id] += 1; // Increase quantity
    } else {
        $_SESSION['cart'][$product_id] = 1; // Add new product
    }

    echo "<script>alert('Product added to cart!'); window.location.href='product_page1.php';</script>";
} else {
    echo "<script>alert('Invalid product!'); window.location.href='product_page1.php';</script>";
}
?>

<?php
session_start();
include('../includes/connect.php');

// Check if product ID is passed
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Initialize the wishlist session if not set
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    // Add product to wishlist if not already added
    if (!in_array($product_id, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $product_id;
        echo "<script>alert('Product added to wishlist!'); window.location.href='product_page1.php';</script>";
    } else {
        echo "<script>alert('Product already in wishlist!'); window.location.href='product_page1.php';</script>";
    }
} else {
    echo "<script>alert('Invalid product!'); window.location.href='product_page1.php';</script>";
}
?>

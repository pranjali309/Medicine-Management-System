<?php
session_start();
include('../includes/db.php'); // Ensure the database connection is included

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to modify your cart!'); window.location.href='login.php';</script>";
    exit();
}

if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo "<script>alert('Invalid product ID!'); window.location.href='cart.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['product_id']);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Remove product from the cart
$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    echo "<script>alert('Product removed from cart!'); window.location.href='cart.php';</script>";
} else {
    echo "<script>alert('Error removing product!'); window.location.href='cart.php';</script>";
}

$stmt->close();
$conn->close();
?>
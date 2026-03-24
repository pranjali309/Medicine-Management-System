<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id > 0) {
    $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $user_id, $product_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Item removed from wishlist!'); window.location.href='wishlist.php';</script>";
    } else {
        echo "<script>alert('Error removing item!');</script>";
    }
    $stmt->close();
}
?>

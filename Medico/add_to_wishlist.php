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
    // Check if the product is already in the wishlist
    $check_query = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Add to wishlist
        $insert_query = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $user_id, $product_id);
        if ($stmt->execute()) {
            echo "<script>alert('Added to wishlist!');window.location.href='product_page1.php';</script>";
             
        } else {
            echo "<script>alert('Error adding to wishlist!');window.location.href='product_page1.php';</script>";
        }
    } else {
        echo "<script>alert('Item is already in your wishlist!');window.location.href='product_page1.php';</script>";
    }
    $stmt->close();
}
?>

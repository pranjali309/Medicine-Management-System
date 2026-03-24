<?php
include('../includes/connect.php');

if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];

    // Get the product image file
    $query = "SELECT product_image1 FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $product_image1 = $row['product_image1'];
        unlink("../uploads/" . $product_image1); // Delete the image file
    }

    // Delete query
    $delete_query = "DELETE FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='view_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product');</script>";
    }
}
?>
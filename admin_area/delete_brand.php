<?php
include('../includes/connect.php');

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_query = "DELETE FROM `brands` WHERE brand_id = $delete_id";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Brand deleted successfully');</script>";
        echo "<script>window.location.href = 'view_brands.php';</script>";
    } else {
        echo "<script>alert('Error deleting brand');</script>";
    }
} else {
    echo "<script>window.location.href = 'view_brands.php';</script>";
}
?>

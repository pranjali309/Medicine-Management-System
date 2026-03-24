<?php
include('../includes/connect.php');

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $delete_query = "DELETE FROM categories WHERE category_id = $category_id";
    mysqli_query($con, $delete_query);
    header('Location: view_categories.php');
}
?>

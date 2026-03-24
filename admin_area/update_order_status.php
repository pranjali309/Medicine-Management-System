<?php
include('../includes/db_connection.php');

if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
    $order_id = intval($_POST['order_id']);
    $order_status = mysqli_real_escape_string($con, $_POST['order_status']);

    $query = "UPDATE orders SET order_status = '$order_status' WHERE order_id = $order_id";
    mysqli_query($con, $query);
}

header("Location: order_list.php");
exit();
?>

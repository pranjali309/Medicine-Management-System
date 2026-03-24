<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Invalid Order ID");
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Check if the order belongs to the user and is still pending
$query = "SELECT order_status FROM orders WHERE order_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order || $order['order_status'] !== 'pending') {
    die("Order cannot be cancelled.");
}

// Update the order status to 'cancelled'
$update_query = "UPDATE orders SET order_status = 'cancelled' WHERE order_id = ? AND user_id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("ii", $order_id, $user_id);
if ($stmt->execute()) {
    echo "<script>alert('Order Cancelled Successfully!'); window.location.href='my_orders.php';</script>";
} else {
    echo "Error cancelling order: " . $conn->error;
}
$stmt->close();
?>


<?php
session_start();
include('../includes/connect.php');

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>alert('Invalid order request!'); window.location.href='index.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details securely
$order_query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = mysqli_prepare($con, $order_query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo "<script>alert('Order not found!'); window.location.href='index.php';</script>";
    exit();
}

// Update order status to 'processing'
$update_query = "UPDATE orders SET order_status = 'processing' WHERE order_id = ?";
$update_stmt = mysqli_prepare($con, $update_query);
mysqli_stmt_bind_param($update_stmt, "i", $order_id);
mysqli_stmt_execute($update_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COD Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 text-center">
    <h2 class="text-success">🎉 Order Confirmed!</h2>
    <p>Your Cash on Delivery order has been successfully placed.</p>
    <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
    <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
    <p><strong>Payment Method:</strong> Cash on Delivery</p>
    <p>We will process your order soon. You will receive a call for delivery confirmation.</p>

    <a href="product_page1.php" class="btn btn-primary">Continue Shopping</a>
</div>
</body>
</html>

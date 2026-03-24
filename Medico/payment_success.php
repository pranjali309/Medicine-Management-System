<?php
session_start();
include('../includes/connect.php');

// Validate order ID
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = mysqli_prepare($con, $order_query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

// Check if order exists
if (!$order) {
    echo "<script>alert('Order not found!'); window.location.href='index.php';</script>";
    exit();
}

// Update order status to 'processing' and payment status to 'paid'
$update_query = "UPDATE orders SET order_status = 'processing', payment_status = 'paid' WHERE order_id = ?";
$update_stmt = mysqli_prepare($con, $update_query);
mysqli_stmt_bind_param($update_stmt, "i", $order_id);
mysqli_stmt_execute($update_stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-success">🎉 Payment Successful!</h2>
        
        <div class="card p-4">
            <h4>Order Details</h4>
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Total Paid:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
            <p><strong>Payment Status:</strong> <span class="badge bg-success">Paid</span></p>
            <p><strong>Order Status:</strong> <span class="badge bg-warning"><?php echo ucfirst($order['order_status']); ?></span></p>
        </div>

        <div class="alert alert-success text-center mt-4">
            <h5>Thank you for your order! We will update you when it ships. 🚚</h5>
            <a href="product_page1.php" class="btn btn-primary mt-3">Continue Shopping</a>
            <a href="online_bill.php?order_id=<?php echo $order_id; ?>" class="btn btn-primary mt-3">View Invoice</a>
        </div>
    </div>
</body>
</html>

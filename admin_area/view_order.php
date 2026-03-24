<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>alert('Invalid order ID'); window.location.href='order_list.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$query = "SELECT o.*, u.full_name, u.email, u.phone, u.address 
          FROM orders o 
          JOIN users u ON o.user_id = u.user_id 
          WHERE o.order_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<script>alert('Order not found!'); window.location.href='order_list.php';</script>";
    exit();
}

// Fetch ordered products
$product_query = "SELECT oi.product_id, p.product_title, p.product_image1, oi.quantity, oi.price 
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.product_id
                  WHERE oi.order_id = ?";
$stmt = $con->prepare($product_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$products = $stmt->get_result();

$stmt = $con->prepare($product_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="styles.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        .status { font-weight: bold; }
        .status-paid { color: green; }
        .status-pending { color: orange; }
        .status-failed { color: red; }
        .table img { width: 50px; height: 50px; object-fit: cover; }
        .back-btn { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Order Details</h2>
    <table class="table table-bordered">
        <tr><th>Order ID</th><td><?= $order['order_id']; ?></td></tr>
        <tr><th>Customer</th><td><?= $order['full_name']; ?> (<?= $order['email']; ?>)</td></tr>
        <tr><th>Phone</th><td><?= $order['phone']; ?></td></tr>
        <tr><th>Address</th><td><?= $order['address']; ?></td></tr>
        <tr><th>Total Price</th><td>₹<?= $order['total_price']; ?></td></tr>
        <tr><th>Payment Method</th><td><?= $order['payment_method']; ?></td></tr>
        <tr><th>Payment Status</th>
            <td class="status status-<?= strtolower($order['payment_status']); ?>">
                <?= ucfirst($order['payment_status']); ?>
            </td>
        </tr>
        <tr><th>Order Date</th><td><?= $order['order_date']; ?></td></tr>
    </table>

    <h3 class="mt-4">Ordered Products</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= $product['product_title']; ?></td>
                    <td><img src="../uploads/<?= $product['product_image1']; ?>" alt="<?= $product['product_title']; ?>"></td>
                    <td><?= $product['quantity']; ?></td>
                    <td>₹<?= $product['price']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="order_list.php" class="btn btn-secondary back-btn">Back to Orders</a>
</div>

</body>
</html>

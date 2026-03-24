<?php
include('../includes/db_connection.php'); // Database connection

// Check if order_id is set
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Invalid Order ID");
}
$order_id = intval($_GET['order_id']);

// Fetch order details
$query = "SELECT * FROM orders WHERE order_id = $order_id";
$result = mysqli_query($con, $query);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    die("Order not found");
}

// Update order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_status = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];
    
    $update_query = "UPDATE orders SET order_status = '$order_status', payment_status = '$payment_status' WHERE order_id = $order_id";
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Order updated successfully!'); window.location.href='order_list.php';</script>";
    } else {
        echo "Error updating order: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ffefba, #ffffff);
            padding: 50px;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background: linear-gradient(to right, #007BFF, #0056b3);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #0056b3, #004085);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Edit Order</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="order_status" class="form-label">Order Status:</label>
                <select name="order_status" id="order_status" class="form-control">
                    <option value="pending" <?= ($order['order_status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="processing" <?= ($order['order_status'] == 'processing') ? 'selected' : '' ?>>Processing</option>
                    <option value="shipped" <?= ($order['order_status'] == 'shipped') ? 'selected' : '' ?>>Shipped</option>
                    <option value="delivered" <?= ($order['order_status'] == 'delivered') ? 'selected' : '' ?>>Delivered</option>
                    <option value="cancel" <?= ($order['order_status'] == 'cancel') ? 'selected' : '' ?>>Cancelled</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status:</label>
                <select name="payment_status" id="payment_status" class="form-control">
                    <option value="pending" <?= ($order['payment_status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="paid" <?= ($order['payment_status'] == 'paid') ? 'selected' : '' ?>>Paid</option>
                    <option value="failed" <?= ($order['payment_status'] == 'failed') ? 'selected' : '' ?>>Failed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Update Order</button>
            <a href="order_list.php" class="btn btn-secondary w-100">Back to Orders</a>
        </form>
    </div>
</body>
</html>

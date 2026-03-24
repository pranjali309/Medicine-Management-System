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

// Check if order exists
if (!$order) {
    echo "<script>alert('Order not found!'); window.location.href='index.php';</script>";
    exit();
}

// Fetch ordered items securely
$order_items_query = "SELECT oi.*, p.product_title, p.product_image1, p.price 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.product_id 
                      WHERE oi.order_id = ?";
$item_stmt = mysqli_prepare($con, $order_items_query);
mysqli_stmt_bind_param($item_stmt, "i", $order_id);
mysqli_stmt_execute($item_stmt);
$order_items_result = mysqli_stmt_get_result($item_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bill-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            border-radius: 10px;
        }
        .print-btn {
            margin-top: 10px;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="bill-container">
    <h2 class="text-center">🛍️ Sagar Medico - Invoice</h2>
    <hr>
    <h4>Customer Details</h4>
    <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p>
    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
    <p><strong>Payment Method:</strong> <span class="badge bg-warning">Cash on Delivery</span></p>
    
    <h4>Ordered Items</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_price = 0;
            while ($item = mysqli_fetch_assoc($order_items_result)): 
                $subtotal = $item['quantity'] * $item['price'];
                $total_price += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                    <td><img src="../uploads/<?php echo htmlspecialchars($item['product_image1']); ?>" width="50"></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                    <td>₹<?php echo number_format($subtotal, 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4 class="text-end">Total Amount: <strong>₹<?php echo number_format($total_price, 2); ?></strong></h4>

    <button class="btn btn-primary print-btn" onclick="window.print();">🖨️ Print Bill</button>
    <a href="cod_confirmation.php?order_id=<?php echo $order_id; ?>" class="btn btn-success print-btn">Next ➡️</a>
</div>

</body>
</html>

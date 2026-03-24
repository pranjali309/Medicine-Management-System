<?php
session_start();
include('../includes/connect.php');

// Validate order ID
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>alert('Invalid request!'); </script>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $con->prepare($order_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "<script>alert('Order not found!'); </script>";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch ordered items
$order_items_query = "SELECT oi.*, p.product_title, p.product_image1 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.product_id 
                      WHERE oi.order_id = ?";
$stmt = $con->prepare($order_items_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
    <style>
        .receipt-container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h2 {
            color: #007bff;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
        }
        .receipt-footer button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="receipt-container">
            <div class="receipt-header">
                <h2>🧾 Payment Receipt</h2>
                <p>Thank you for your order! Here is your receipt.</p>
            </div>
            <hr>
            <h5><strong>Order ID:</strong> <?php echo $order['order_id']; ?></h5>
            <h5><strong>Date:</strong> <?php echo date("d M Y, h:i A", strtotime($order['order_date'])); ?></h5>
            <h5><strong>Customer Name:</strong> <?php echo $order['full_name']; ?></h5>
            <h5><strong>Email:</strong> <?php echo $order['email']; ?></h5>
            <h5><strong>Phone:</strong> <?php echo $order['phone']; ?></h5>
            <h5><strong>Shipping Address:</strong> <?php echo $order['address']; ?></h5>
            <hr>
            <h4>Ordered Items:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    while ($item = $order_items_result->fetch_assoc()): 
                        $total_price = $item['price'] * $item['quantity'];
                        $grand_total += $total_price;
                    ?>
                        <tr>
                            <td><?php echo $item['product_title']; ?></td>
                            <td><img src="../uploads/<?php echo $item['product_image1']; ?>" width="50"></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                            <td>₹<?php echo number_format($total_price, 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <h3 class="text-end"><strong>Grand Total:</strong> ₹<?php echo number_format($grand_total, 2); ?></h3>
            <hr>
            <h5><strong>Payment Status:</strong> <span class="badge bg-success">Paid</span></h5>
            <h5><strong>Order Status:</strong> <span class="badge bg-warning"><?php echo ucfirst($order['order_status']); ?></span></h5>
            <div class="receipt-footer">
                <button class="btn btn-primary" onclick="printReceipt()">🖨 Print Receipt</button>
                <a href="product_page1.php" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>
    </div>
</body>
</html>

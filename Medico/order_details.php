<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: my_orders.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GET['order_id']);

// ✅ Fetch Order Details
$order_query = "SELECT order_id, order_date, total_price, payment_method, order_status FROM orders WHERE user_id = ? AND order_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("ii", $user_id, $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "<script>alert('Order not found!'); window.location.href='my_orders.php';</script>";
    exit();
}

$order = $order_result->fetch_assoc();
$stmt->close();

// ✅ Handle Order Cancellation (Only if status is Pending)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    if ($order['order_status'] == 'pending') {
        $update_query = "UPDATE orders SET order_status = 'cancelled' WHERE order_id = ? AND user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $order_id, $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Order has been cancelled.'); window.location.href='order_details.php?order_id=$order_id';</script>";
        } else {
            echo "<script>alert('Error cancelling order. Try again.');</script>";
        }
        $stmt->close();
    }
}

// ✅ Fetch Ordered Items
$item_query = "SELECT oi.product_id, oi.quantity, oi.price, p.product_title, p.product_image1 
               FROM order_items oi
               JOIN products p ON oi.product_id = p.product_id
               WHERE oi.order_id = ?";
$stmt = $conn->prepare($item_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #eef2f7; font-family: 'Poppins', sans-serif; }
        .container { margin-top: 80px; }
        .order-summary { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .status { padding: 5px 10px; border-radius: 5px; font-weight: bold; }
        .pending { background: #ffcc00; color: black; }
        .processing { background: #17a2b8; color: white; }
        .shipped { background: #007bff; color: white; }
        .delivered { background: #28a745; color: white; }
        .cancelled { background: #dc3545; color: white; }
        .product-card { display: flex; align-items: center; background: white; padding: 10px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .product-card img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; margin-right: 15px; }
        .btn-cancel { background: #dc3545; color: white; padding: 10px 15px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-cancel:hover { background: #c82333; }
        .back-btn { display: inline-block; margin-top: 15px; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; }
        .back-btn:hover { background: #545b62; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Order Details</h2>

    <div class="order-summary">
        <h5>Order ID: <?php echo $order['order_id']; ?></h5>
        <p><strong>Date:</strong> <?php echo date("d M Y", strtotime($order['order_date'])); ?></p>
        <p><strong>Total Price:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Payment Method:</strong> <?php echo ucfirst($order['payment_method']); ?></p>
        <p>
            <strong>Status:</strong>
            <?php 
                $status_class = "";
                switch ($order['order_status']) {
                    case 'pending': $status_class = 'pending'; break;
                    case 'processing': $status_class = 'processing'; break;
                    case 'shipped': $status_class = 'shipped'; break;
                    case 'delivered': $status_class = 'delivered'; break;
                    case 'cancelled': $status_class = 'cancelled'; break;
                    default: $status_class = ''; 
                }
            ?>
            <span class="status <?php echo $status_class; ?>"><?php echo ucfirst($order['order_status']); ?></span>
        </p>

        <!-- ✅ Cancel Order Button (Only if status is Pending) -->
        <?php if ($order['order_status'] == 'pending') { ?>
            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                <button type="submit" name="cancel_order" class="btn-cancel">Cancel Order</button>
            </form>
        <?php } ?>
    </div>

    <h4 class="mt-4">Ordered Items</h4>

    <?php if ($items_result->num_rows > 0) { ?>
        <?php while ($item = $items_result->fetch_assoc()) { ?>
            <div class="product-card">
                <img src="../uploads/<?php echo $item['product_image1']; ?>" alt="<?php echo $item['product_title']; ?>">
                <div>
                    <h5><?php echo $item['product_title']; ?></h5>
                    <p>Price: ₹<?php echo number_format($item['price'], 2); ?></p>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-center text-danger">No items found for this order.</p>
    <?php } ?>

    <a href="my_orders.php" class="back-btn">Back to Orders</a>
</div>

</body>
</html>

<?php $stmt->close(); ?>

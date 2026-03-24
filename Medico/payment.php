<?php
session_start();
include('../includes/connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to proceed to payment!'); window.location.href='login.php';</script>";
    exit();
}

// Check if order ID & total price exist
if (!isset($_POST['order_id']) || !isset($_POST['total_price'])) {
    echo "<script>alert('Invalid access!'); window.location.href='checkout.php';</script>";
    exit();
}

$order_id = intval($_POST['order_id']);
$total_price = floatval($_POST['total_price']);

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = '$order_id'";
$order_result = mysqli_query($con, $order_query);

if (!$order_result || mysqli_num_rows($order_result) == 0) {
    echo "<script>alert('Order not found!'); window.location.href='checkout.php';</script>";
    exit();
}

$order = mysqli_fetch_assoc($order_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-primary">Secure Payment</h2>
        
        <div class="card p-4">
            <h4>Order Summary</h4>
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Total Amount:</strong> ₹<?php echo number_format($total_price, 2); ?></p>
        </div>

        <div class="card p-4 mt-4">
            <h4>Enter Payment Details</h4>
            <form action="process_payment.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Cardholder Name</label>
                    <input type="text" name="card_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Card Number</label>
                    <input type="text" name="card_number" class="form-control" required pattern="[0-9]{16}" title="Enter a valid 16-digit card number">
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Expiry Date</label>
                        <input type="month" name="expiry_date" class="form-control" required>
                    </div>
                    <div class="col">
                        <label class="form-label">CVV</label>
                        <input type="text" name="cvv" class="form-control" required pattern="[0-9]{3}" title="Enter a valid 3-digit CVV">
                    </div>
                </div>
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <button type="submit" class="btn btn-success w-100">Make Payment</button>
            </form>
        </div>
    </div>
</body>
</html>

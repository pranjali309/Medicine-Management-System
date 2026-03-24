<?php
session_start();
include('../includes/connect.php');

// Debugging - Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("❌ User not logged in!");
}

$user_id = $_SESSION['user_id'];

// Check if form is submitted
if (!isset($_POST['order_id']) || !isset($_POST['total_price'])) {
    die("❌ Invalid payment attempt!");
}

$order_id = intval($_POST['order_id']);
$total_price = floatval($_POST['total_price']);
$payment_method = "stripe"; 
$payment_status = "paid";

// Debugging Output
echo "Order ID: $order_id, Total Price: $total_price, User ID: $user_id<br>";

// Start Transaction
$con->begin_transaction();

try {
    // 1️⃣ Update `orders` Table
    $update_query = "UPDATE orders SET payment_status = ?, payment_method = ? WHERE order_id = ?";
    $stmt = $con->prepare($update_query);
    if (!$stmt) {
        throw new Exception("Prepare failed (orders update): " . $con->error);
    }
    $stmt->bind_param("ssi", $payment_status, $payment_method, $order_id);
    if (!$stmt->execute()) {
        throw new Exception("Order update failed: " . $stmt->error);
    }
    $stmt->close();
    echo "✅ Order updated successfully!<br>";

    // 2️⃣ Insert into `payments` Table
    $insert_payment = "INSERT INTO payments (order_id, user_id, payment_amount, payment_method, payment_status, payment_date) 
                   VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $con->prepare($insert_payment);
if (!$stmt) {
    throw new Exception("Prepare failed (insert payments): " . $con->error);
}
$stmt->bind_param("iidss", $order_id, $user_id, $total_price, $payment_method, $payment_status);

    if (!$stmt->execute()) {
        throw new Exception("Payment insert failed: " . $stmt->error);
    }
    $stmt->close();
    echo "✅ Payment inserted successfully!<br>";

    // 3️⃣ Commit Transaction
    $con->commit();

    // Redirect to success page
    echo "<script>alert('✅ Payment Successful!'); window.location.href='payment_success.php?order_id=$order_id';</script>";
    exit();

} catch (Exception $e) {
    $con->rollback();
    die("❌ Payment failed: " . $e->getMessage());
}
?>

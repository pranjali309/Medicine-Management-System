<?php
session_start();
include('../includes/connect.php');

// Ensure database connection
if (!isset($con) || $con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to place an order!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $full_name = mysqli_real_escape_string($con, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
    $order_date = date('Y-m-d H:i:s');

    // Fetch cart items
    $cart_query = "SELECT c.product_id, c.quantity, p.price 
                   FROM cart c
                   JOIN products p ON c.product_id = p.product_id
                   WHERE c.user_id = ?";

    $stmt = $con->prepare($cart_query);
    if (!$stmt) {
        die("SQL Error: " . $con->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    $cart_items = [];
    while ($row = $cart_result->fetch_assoc()) {
        $cart_items[] = $row;
    }
    $stmt->close();

    // Check if cart is empty
    if (empty($cart_items)) {
        echo "<script>alert('Your cart is empty!'); window.location.href='cart.php';</script>";
        exit();
    }

    // Start transaction
    $con->begin_transaction();

    try {
        // Insert order
        $insert_order = "INSERT INTO orders (user_id, full_name, email, phone, address, total_price, order_date, order_status, payment_status) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', 'pending')";

        $stmt = $con->prepare($insert_order);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("issssds", $user_id, $full_name, $email, $phone, $address, $total_price, $order_date);

        if (!$stmt->execute()) {
            throw new Exception("Order insert failed: " . $stmt->error);
        }

        $order_id = $stmt->insert_id;
        $stmt->close();

        // ✅ Add Notification for Admin (NEW CODE)
        $notification_message = "🛒 New order placed by User ID: $user_id (Order ID: $order_id)";
        $insert_notification = "INSERT INTO notifications (message, status) VALUES (?, 'unread')";

        $stmt = $con->prepare($insert_notification);
        if ($stmt) {
            $stmt->bind_param("s", $notification_message);
            $stmt->execute();
            $stmt->close();
        }

        // Insert order items
        $insert_order_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($insert_order_item);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }

        foreach ($cart_items as $item) {
            $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            if (!$stmt->execute()) {
                throw new Exception("Order item insert failed: " . $stmt->error);
            }
        }
        $stmt->close();

        // Clear the user's cart after order placement
        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($clear_cart);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Cart clear failed: " . $stmt->error);
        }
        $stmt->close();

        // Commit transaction
        $con->commit();

        // Redirect to order confirmation page
        echo "<script>alert('Order placed successfully!'); window.location.href='order_confirmation.php?order_id=$order_id';</script>";
    } catch (Exception $e) {
        $con->rollback();
        echo "<script>alert('Order failed: " . $e->getMessage() . "'); window.location.href='checkout.php';</script>";
    }
}
?>

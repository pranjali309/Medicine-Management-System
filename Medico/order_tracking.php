<?php
include('../includes/db.php');

$order_status = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = trim($_POST['order_id']);

    if (empty($order_id)) {
        $error_message = "⚠️ Please enter a valid Order ID.";
    } else {
        $query = "SELECT order_id, full_name, phone, total_price, payment_method, payment_status, order_date, order_status 
                  FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
            $order_status = "<b>📦 Order ID:</b> " . $order['order_id'] . "<br>
                            <b>👤 Customer:</b> " . $order['full_name'] . "<br>
                            <b>📞 Phone:</b> " . $order['phone'] . "<br>
                            <b>💰 Total Amount:</b> ₹" . number_format($order['total_price'], 2) . "<br>
                            <b>💳 Payment Method:</b> " . ucfirst($order['payment_method']) . "<br>
                            <b>💲 Payment Status:</b> " . ucfirst($order['payment_status']) . "<br>
                            <b>🗓️ Order Date:</b> " . $order['order_date'] . "<br>
                            <b>🚀 Order Status:</b> <span style='color:green;'>" . ucfirst($order['order_status']) . "</span>";
        } else {
            $error_message = "❌ No order found with this Order ID.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking - Sagar Medico</title>
    <style>
   body { 
    font-family: 'Poppins', sans-serif; 
    background: #f1f1ff; /* Corrected background color */
    text-align: center; 
    padding: 50px;
    margin: 0; /* Remove default margin */
}

.tracking-container { 
    background: white;
    padding: 30px; 
    max-width: 500px; 
    margin: auto; 
    border-radius: 10px; 
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); /* Increased box shadow for better visibility */
    text-align: left; /* Align text to the left inside the container */
    margin-bottom: 30px; /* Add space below the tracking container */
}

input { 
    width: 90%; 
    padding: 10px; 
    margin: 10px 0; 
    border: 1px solid #ccc; 
    border-radius: 5px;
    font-size: 16px; /* Increased font size for better readability */
}

button { 
    background: #004085; 
    color: white; 
    padding: 12px 20px; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer; 
    font-size: 16px; /* Increased button font size */
    transition: background 0.3s ease; /* Smooth transition for button color change */
}

button:hover { 
    background: #002752; 
}

.order-status { 
    margin-top: 20px; 
    font-size: 16px; 
    font-weight: bold; 
    color: green; 
    text-align: left; 
    padding: 10px; 
    background: #e7f5e7; 
    border-left: 5px solid #28a745; 
}

.error-message { 
    color: red; 
    font-weight: bold; 
    margin-top: 10px; 
    text-align: left; 
    padding: 10px; 
    background: #f8d7da; 
    border-left: 5px solid #dc3545;
}

/* Footer Styling */
footer {
    background: #f8f9fa; /* Light gray background for footer */
    text-align: center; 
    padding: 20px; 
    margin-top: 30px; /* Add space above footer */
    font-size: 14px; 
}


    </style>
</head>
<body>
    <div class="tracking-container">
        <h2>Track Your Order</h2>
        <p>Enter your Order ID below to track your shipment.</p>
        <form method="POST">
            <input type="number" name="order_id" placeholder="Enter Order ID" required>
            <button type="submit">Track Order</button>
        </form>

        <?php if (!empty($order_status)): ?>
            <p class="order-status"><?= $order_status; ?></p>
        <?php elseif (!empty($error_message)): ?>
            <p class="error-message"><?= $error_message; ?></p>
        <?php endif; ?>
    </div>
    <!-- footer -->
<?php include("footer.php"); ?>
</body>
</html>

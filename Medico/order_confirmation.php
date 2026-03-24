<?php
session_start();
include('../includes/connect.php');

// Validate order ID
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>alert('Invalid order request!'); window.location.href='index.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = '$order_id'";
$order_result = mysqli_query($con, $order_query);

if (!$order_result || mysqli_num_rows($order_result) == 0) {
    echo "<script>alert('Order not found!'); window.location.href='index.php';</script>";
    exit();
}

$order = mysqli_fetch_assoc($order_result);

// Fetch ordered items
$order_items_query = "SELECT oi.*, p.product_title, p.product_image1 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.product_id 
                      WHERE oi.order_id = '$order_id'";
$order_items_result = mysqli_query($con, $order_items_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container-main {
            width: 100%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .option {
            display: block;
            background: #fff;
            padding: 10px;
            margin: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }
        .option input {
            margin-right: 10px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center text-success">Order Placed Successfully!</h2>
        <div class="card p-4">
            <h4>Order Details</h4>
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
             <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p> 
            <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
            <p><strong>Status:</strong> <span class="badge bg-warning"><?php echo $order['order_status']; ?></span></p>
            <p><strong>Payment Status:</strong> 
                <span class="badge <?php echo ($order['payment_status'] === 'paid') ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo ucfirst($order['payment_status']); ?>
                </span>
            </p>
        </div>

        <div class="card p-4 mt-4">
            <h4>Ordered Items</h4>
            <table class="table">
                <thead>
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
    <td><?php echo htmlspecialchars($item['product_title'] ?? 'No Name'); ?></td>
    <td><img src="../uploads/<?php echo htmlspecialchars($item['product_image1'] ?? 'default.jpg'); ?>" width="50"></td>
    <td><?php echo htmlspecialchars($item['quantity'] ?? '0'); ?></td>
    <td>₹<?php echo number_format($item['price'] ?? 0, 2); ?></td>
    <td>₹<?php echo number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2); ?></td>
</tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php if ($order['payment_status'] === 'pending'): ?>
            <div class="container-main">
                <h2>Select Payment Method</h2>
                <form id="payment-form" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                    
                    <label class="option">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <span>Cash on Delivery</span>
                    </label>

                    <label class="option">
                        <input type="radio" name="payment_method" value="online">
                        <span>Online Payment</span>
                    </label>

                    <button type="submit" class="btn btn-success w-100">Proceed to Payment</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-success text-center mt-4">
                <h5>Thank you! Your payment has been received.</h5>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById("payment-form")?.addEventListener("submit", function(event) {
            event.preventDefault();

            let selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
            let orderId = "<?php echo $order_id; ?>";
            
            if (selectedPayment === "cod") {
                window.location.href = "print_bill.php?order_id=" + orderId;
            } else {
                this.action = "payment.php";
                this.submit();
            }
        });
    </script>
</body>
</html>
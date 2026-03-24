<?php
session_start();
include('../includes/db.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to proceed to checkout!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = [];

// Fetch cart items from the database
$query = "SELECT c.product_id, c.quantity, p.product_title, p.price, p.product_image1 
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";


$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

// If cart is empty, redirect back
if (empty($cart_items)) {
    echo "<script>alert('Your cart is empty!'); window.location.href='cart.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Checkout</h2>
        
        <div class="card p-4">
            <h4>Cart Summary</h4>
            <table class="table">
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
                    <?php foreach ($cart_items as $product): ?>
                        <tr>
    <td><?php echo htmlspecialchars($product['product_title'] ?? ''); ?></td>
    <td><img src="../uploads/<?php echo htmlspecialchars($product['product_image1'] ?? 'default.jpg'); ?>" width="50"></td>
    <td><?php echo htmlspecialchars($product['quantity'] ?? '0'); ?></td>
    <td>₹<?php echo number_format($product['price'] ?? 0, 2); ?></td>
    <td>₹<?php echo number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 0), 2); ?></td>
</tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="fw-bold">Total Amount: ₹<?php echo number_format($total_price, 2); ?></p>
        </div>

        <div class="card p-4 mt-4">
            <h4>Shipping Details</h4>
            <form action="place_order.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required pattern="[0-9]{10}" title="Enter a valid 10-digit phone number">
                </div>
                <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" required>

                </div>
                <?php foreach ($cart_items as $item): ?>
                    <input type="hidden" name="product_id[]" value="<?php echo $item['product_id']; ?>">
                    <input type="hidden" name="quantity[]" value="<?php echo $item['quantity']; ?>">
                <?php endforeach; ?>
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <button type="submit" class="btn btn-success w-100">Place Order</button>
            </form>
        </div>
    </div>
</body>
</html>

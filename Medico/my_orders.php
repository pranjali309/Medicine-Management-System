<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch User Profile Photo
$profile_photo = "uploads/default.png"; // Default image
$sql = "SELECT profile_photo FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!empty($user['profile_photo'])) {
    $profile_photo = $user['profile_photo'];
}

// ✅ Fetch Orders
$order_query = "SELECT order_id, order_date, total_price, order_status FROM orders WHERE user_id = ? ORDER BY order_date DESC";

$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 60px;
            display: flex;
            gap: 20px;
            margin-left: 10%;
        }
        /* Back Button */
        .back-button {
            position: absolute;
            top: 40%;
            left: 0px;
            background: #0077b6;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
        }
        .back-button:hover {
            background: #005f8e;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar h3 {
            text-align: center;
            color: #0077b6;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 12px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
            text-align: center;
            cursor: pointer;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            width: 100%;
        }
        .sidebar ul li:hover, .sidebar ul li.active {
            background: #0077b6;
            color: white;
        }
        .sidebar ul li:hover a, .sidebar ul li.active a {
            color: white;
        }
        
        /* Orders Content */
        .orders-content {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .order-table th, .order-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .order-table th {
            background: #0077b6;
            color: white;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .pending { background: #ffcc00; color: black; }
        .processing { background: #17a2b8; color: white; }
        .shipped { background: #007bff; color: white; }
        .delivered { background: #28a745; color: white; }
        .cancelled { background: #dc3545; color: white; }
        .view-btn, .cancel-btn {
            background: #0077b6;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .cancel-btn {
            background: #dc3545;
        }
        .view-btn:hover {
            background: #005f8e;
        }
        .cancel-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
<!-- Back Button -->
<a href="home.php" class="back-button"> ← Back to Home</a>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>My Account</h3>
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li class="active"><a href="my_orders.php">Orders</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="payments.php">Subscriptions</a></li>
            <li><a href="help.php">Help & Support</a></li>
            <li><a href="account_actions.php">Account Actions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Orders Content -->
    <div class="orders-content">
        <h2 class="text-center">My Orders</h2>

        <?php if ($orders->num_rows > 0) { ?>
            <table class="order-table">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($order = $orders->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo date("d M Y", strtotime($order['order_date'])); ?></td>
                        <td>₹<?php echo number_format($order['total_price'], 2); ?></td>
                        <td><span class="status <?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                        <td>
                            <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="view-btn">View</a>
                            <?php if ($order['order_status'] == 'pending') { ?>
                                <a href="cancel_order.php?order_id=<?php echo $order['order_id']; ?>" class="cancel-btn">Cancel</a>

                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</div>

</body>
</html>

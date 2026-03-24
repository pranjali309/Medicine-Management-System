<?php
session_start();
include('../includes/db.php');

// Fetch unread notifications
$query = "SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC";
$result = $conn->query($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        .notification-badge {
            position: absolute;
            top: 5px;
            right: 10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 3px 8px;
            font-size: 12px;
        }
      /* admin */
.sidebar { position: fixed; width: 250px; height: 100vh; background: #2d3a4b; padding: 20px; color: #fff; }
        .sidebar a { display: block; padding: 10px; color: #fff; text-decoration: none; border-radius: 5px; margin-bottom: 10px; }
        .sidebar a:hover { background: #1abc9c; }
        .link.active {
    color: #1abc9c;
}
        /* ===== Admin Panel Header ===== */

.admin {
            background: linear-gradient(to right, #E6E6FA, #F8F9FA);
    width: 100%;
    padding: 15px 0;
    position: absolute; /* Place it at the top */
    top: 0;
    left: 0;
    text-align: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000; /* Keep it above other content */
    position: fixed;
}
.navbar-brand{
    font-size: 170%;
}
.admin h2 {
    font-size: 28px;
    font-weight: bold;
    color: #2d3a4b;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0; /* Remove default margin */
    margin-left: 20%;
}
  
/* ===== Sidebar ===== */
.sidebar {
    position: fixed;
    width: 250px;
    height: 100vh;
    background: #2d3a4b;
    padding: 20px;
    color: white;
    /* top: 50px; Admin Panel header खाली */
    left: 0;
    overflow-y: auto;
    /* flex-direction: top; */
}

.sidebar a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #1abc9c;
}
.main{
    max-width: 800px;
    /* margin: auto; */
    background: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
    margin-top: 10%;
    margin-left: 30%;
}
    </style>
</head>
<body class="bg-light">
<div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <!-- <h2>Admin Panel</h2> -->
        <a href="insert_product.php"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
        <a href="insert_categories.php" class="link active"><i class="fa fa-list"></i> Insert Categories</a>
        <a href="view_categories.php"><i class="fa fa-tags"></i> View Categories</a>
        <a href="order_list.php"><i class="fa fa-credit-card"></i> All Orders</a>
        <a href="payment_list.php"><i class="fa fa-credit-card"></i> All Payments</a>
        <a href="user_list.php"><i class="fa fa-users"></i> List Users</a>
        <a href="contact_view.php"><i class="fa fa-box"></i> View Messages</a>
        <a href="notifications.php">
    <i class="fa fa-bell"></i> Notifications 
    <span id="notificationCount" class="badge bg-danger"></span>
</a>
        <a href="../Medico/logout.php" class="btn btn-danger w-80 mt-3">Logout</a>
    </div>
<div class="container">
<div class="admin">
    <h2 >Admin Panel</h2>
</div>
<div class="main ">
    <h3 class="text-center">📢 Admin Notifications</h3>

    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <strong>Recent Notifications</strong>
            <button class="btn btn-sm btn-light" onclick="markAllRead()">Mark All Read</button>
        </div>
        
        <ul class="list-group list-group-flush" id="notificationList">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?php echo htmlspecialchars($row['message']); ?></span>
                    <small class="text-muted"><?php echo $row['created_at']; ?></small>
                    <button class="btn btn-sm btn-danger" onclick="markRead(<?php echo $row['id']; ?>)">Mark as Read</button>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<script>
// Fetch notifications in real-time
function fetchNotifications() {
    $.ajax({
        url: "fetch_notifications.php",
        method: "GET",
        dataType: "json",
        success: function(data) {
            $("#notificationCount").text(data.count > 0 ? data.count : "");

            let notificationList = $("#notificationList");
            notificationList.empty();

            if (data.notifications.length > 0) {
                data.notifications.forEach(function (notif) {
                    notificationList.append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${notif.message}</span>
                            <small class="text-muted">${notif.time}</small>
                            <button class="btn btn-sm btn-danger" onclick="markRead(${notif.id})">Mark as Read</button>
                        </li>
                    `);
                });
            } else {
                notificationList.html('<li class="list-group-item text-center text-muted">No new notifications.</li>');
            }
        }
    });
}

// Mark a single notification as read
function markRead(id) {
    $.ajax({
        url: "mark_notification.php",
        method: "POST",
        data: { id: id },
        success: function() {
            fetchNotifications();
        }
    });
}

// Mark all notifications as read
function markAllRead() {
    $.ajax({
        url: "mark_all_notifications.php",
        method: "POST",
        success: function() {
            fetchNotifications();
        }
    });
}

// Auto-refresh notifications every 5 seconds
setInterval(fetchNotifications, 5000);
fetchNotifications();
</script>

</body>
</html>

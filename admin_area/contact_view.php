<?php
include('../includes/dbc_connect.php'); // Database connection


// Pagination settings
$limit = 10; // Number of messages per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch messages with pagination
$sql = "SELECT id, name, phone, address, message, ip_address, created_at, reply FROM messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count total messages for pagination
$total_sql = "SELECT COUNT(id) AS total FROM messages";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_messages = $total_row['total'];
$total_pages = ceil($total_messages / $limit);


// Fetch messages from the database
// $sql = "SELECT id, name, phone, address, message, ip_address, created_at, reply FROM messages ORDER BY created_at DESC";
// $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        /* .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        } */
        h2 {
            text-align: center;
            color: #333;
        }
        .table {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
        }
        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-reply {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-reply:hover {
            background-color: #218838;
        }
        /* Navigation Buttons Wrapper */
.nav-buttons {
    display: flex;
    justify-content: left; /* Align to left */
    align-items: center;
    margin: 20px;
    gap: 10px; /* Space between buttons */
}

/* Individual Button */
.nav-buttons .btn {
    background: none; /* No background */
    border: none; /* No border */
    font-size: 24px; /* Bigger icon */
    color: black; /* Black color */
    cursor: pointer;
    transition: color 0.3s;
}

/* Hover Effect */
.nav-buttons .btn:hover {
    color: gray; /* Slight color change */
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
.admin h1 {
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
    max-width: 1000px;
            /* margin: auto; */
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-left: 17%;
           
}
h2 {
    text-align: center;
    color: #333;
    margin-top: 20px; 
}

.sidebar .btn {
    background-color:rgb(246, 70, 39);

}
.link.active {
    color: #1abc9c;
}

    </style>
</head>
<body>
<div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <!-- <h2>Admin Panel</h2> -->
        <a href="insert_product.php"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
        <a href="insert_categories.php"><i class="fa fa-list"></i> Insert Categories</a>
        <a href="view_categories.php"><i class="fa fa-tags"></i> View Categories</a>
        <a href="order_list.php"><i class="fa fa-credit-card"></i> All Orders</a>
        <a href="payment_list.php" ><i class="fa fa-credit-card"></i> All Payments</a>
        <a href="user_list.php" ><i class="fa fa-users"></i> List Users</a>
        <a href="contact_view.php" class="link active"><i class="fa fa-box"></i> View Messages</a>
        <a href="notifications.php">
    <i class="fa fa-bell"></i> Notifications 
    <span id="notificationCount" class="badge bg-danger"></span>
</a>
        <a href="../Medico/logout.php" class="btn btn-danger w-80 mt-3">Logout</a>
    </div>
<!-- <div class="nav-buttons">
        <a href="index3.php"><button class="btn" onclick="goPrevious()">❮</button></a>
      <a href="#"><button class="btn" onclick="goNext()">❯</button></a>
    </div> -->

    <div class="container mt-5">
    <div class="admin">
    <h1 >Admin Panel</h1>
</div>
<div class="main">
        <h2>View Messages</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Message</th>
                    <th>IP Address</th>
                    <th>Date</th>
                    <th>Reply</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                            <td><?= htmlspecialchars($row['ip_address']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <?php if (!empty($row['reply'])): ?>
                                    <span class="text-success"><?= htmlspecialchars($row['reply']) ?></span>
                                <?php else: ?>
                                    <a href="reply_message.php?id=<?= $row['id'] ?>">
                                        <button class="btn-reply">Reply</button>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
         <!-- Pagination -->
         <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
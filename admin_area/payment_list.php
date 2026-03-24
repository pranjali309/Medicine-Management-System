<?php
include('../includes/db_connection.php');

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$filter = isset($_GET['payment_filter']) ? mysqli_real_escape_string($con, $_GET['payment_filter']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$query = "SELECT order_id, user_id, full_name, total_price, payment_method, payment_status, order_date FROM orders WHERE 1";

if ($search) {
    $query .= " AND (order_id LIKE '%$search%' OR user_id LIKE '%$search%' OR full_name LIKE '%$search%')";
}
if ($filter) {
    $query .= " AND payment_status = '$filter'";
}
if ($start_date && $end_date) {
    $query .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
}

$total_query = "SELECT COUNT(order_id) AS total FROM orders WHERE 1";

$result = mysqli_query($con, $query . " ORDER BY order_date DESC LIMIT $limit OFFSET $offset");
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment List</title>
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
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background: linear-gradient(to right, #E6E6FA, #F8F9FA); */

            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .nav-buttons {
            margin-bottom: 20px;
        }
        .btn {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            /* background-color: #007BFF; */
            color: white;
        }
        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-left: 19%;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #e9ecef;
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
    /* left: 10%; */
    /* margin-left: 15%;
    max-width: 1000px; */
            /* margin: auto; */
            /* background: white; */
            padding: 20px;
            /* box-shadow: 0px 0px 20px rgba(0,0,0,0.1); */
            border-radius: 10px;
            margin-top: 5%;
            /* background: linear-gradient(to right, #E6E6FA, #F8F9FA); */
}
.sidebar .btn {
    background-color:rgb(246, 70, 39);

}
.link.active {
    color: #1abc9c;
}
.status-paid {
    color: green !important;
    font-weight: bold;
    text-align: center;
    display: table-cell;
    vertical-align: middle;
}

.status-pending {
    color: orange !important;
    font-weight: bold;
    text-align: center;
    display: table-cell;
    vertical-align: middle;
}

.status-failed {
    color: red !important;
    font-weight: bold;
    text-align: center;
    display: table-cell;
    vertical-align: middle;
}
.search-container {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Move to the left */
    gap: 10px; /* Space between elements */
    margin-left: 30%; /* Adjust left spacing */
}



</style>
</head>
<body>

<!-- <div class="nav-buttons">
    <a href="order_list.php"><button class="btn">❮ Back to Orders</button></a>
</div> -->
<div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
       
        <a href="insert_product.php"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
        <a href="insert_categories.php"><i class="fa fa-list"></i> Insert Categories</a>
        <a href="view_categories.php"><i class="fa fa-tags"></i> View Categories</a>
        <a href="order_list.php"><i class="fa fa-credit-card"></i> All Orders</a>
        <a href="payment_list.php" class="link active"><i class="fa fa-credit-card"></i> All Payments</a>
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
    <h1 >Admin Panel</h1>
</div>
    <div class="main">
<h2>Payment List</h2>
    
<form method="GET" class="search-container mb-3">
    <input type="text" name="search" class="form-control w-25" placeholder="Search Orders" value="<?= $search; ?>">
    <select name="payment_filter" class="form-select w-25">
        <option value="">All</option>
        <option value="paid" <?= $filter == 'paid' ? 'selected' : ''; ?>>Paid</option>
        <option value="pending" <?= $filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="failed" <?= $filter == 'failed' ? 'selected' : ''; ?>>Failed</option>
    </select>
    <input type="date" name="start_date" class="form-control w-25" value="<?= $start_date; ?>">
    <input type="date" name="end_date" class="form-control w-25" value="<?= $end_date; ?>">
    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<a href="export_payments.php?search=<?= urlencode($search) ?>&payment_filter=<?= urlencode($filter) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>" class="btn btn-success mb-3">
    Export Payments as CSV
</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Order Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['order_id']; ?></td>
                    <td><?= $row['user_id']; ?></td>
                    <td><?= $row['full_name']; ?></td>
                    <td>₹<?= $row['total_price']; ?></td>
                    <td><?= $row['payment_method']; ?></td>
                    <td class="<?php 
    $status = strtolower($row['payment_status']);
    if ($status == 'paid') {
        echo 'status-paid';
    } elseif ($status == 'pending') {
        echo 'status-pending';
    } elseif ($status == 'failed') {
        echo 'status-failed';
    } 
?>">
    <?= ucfirst($row['payment_status']); ?>
</td>


                    <td><?= $row['order_date']; ?></td>
                    <td><button class="btn btn-info btn-sm view-order" data-id="<?= $row['order_id']; ?>">View</button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<script>
    document.querySelectorAll('.view-order').forEach(button => {
        button.addEventListener('click', function() {
            let orderId = this.getAttribute('data-id');
            window.location.href = 'view_order.php?order_id=' + orderId;
        });
    });
</script>
</div>
</div>
</body>
</html>
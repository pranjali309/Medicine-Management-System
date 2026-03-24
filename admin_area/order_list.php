<?php
include('../includes/db_connection.php'); // Database connection

// Number of records per page
$records_per_page = 10;

// Get the current page number from URL, default is 1
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = intval($_GET['page']);
} else {
    $current_page = 1;
}

// Calculate the starting point for the query
$start_from = ($current_page - 1) * $records_per_page;

// Get total number of records
$total_query = "SELECT COUNT(*) FROM orders";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_array($total_result);
$total_records = $total_row[0];

// Get total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch paginated records
$query = "SELECT * FROM orders ORDER BY order_date DESC LIMIT $start_from, $records_per_page";
$result = mysqli_query($con, $query);

$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$payment_status = isset($_GET['payment_status']) ? mysqli_real_escape_string($con, $_GET['payment_status']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Modify query based on filters
$query = "SELECT * FROM orders WHERE 1";

if ($search) {
    $query .= " AND (order_id LIKE '%$search%' OR full_name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($payment_status) {
    $query .= " AND payment_status = '$payment_status'";
}
if ($start_date && $end_date) {
    $query .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
}

$query .= " ORDER BY order_date DESC LIMIT $start_from, $records_per_page";
$result = mysqli_query($con, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 2%;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }
        th {
            /* background: #007BFF; */
            color: black;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #e9ecef;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 8px 12px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            background: #007BFF;
            color: white;
        }
        .pagination a:hover {
            background: #0056b3;
        }
        .pagination .active {
            background: #0056b3;
        }
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
    
    margin-left: 17%;
    /* max-width: 1000px; */
            /* margin: auto; */
            /* background: white; */
            padding: 20px;
            /* box-shadow: 0px 0px 20px rgba(0,0,0,0.1); */
            border-radius: 10px;
            margin-top: 4%;
            /*  background: linear-gradient(to right, #E6E6FA, #F8F9FA); */

}
.sidebar .btn {
    background-color:rgb(246, 70, 39);

}
.link.active {
    
    color: #1abc9c;
}
td.text-center .btn {
    min-width: 100px;  
    text-align: center; 
}

td.text-center .d-flex {
    justify-content: center;  
    flex-wrap: wrap; 
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
        <a href="order_list.php" class="link active"><i class="fa fa-credit-card"></i> All Orders</a>
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
    <h1 >Admin Panel</h1>
</div>
    <div class="main">
<h2>Order List</h2>

<form method="GET" class="d-flex mb-3">
    <input type="text" name="search" class="form-control w-25" placeholder="Search Order" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <select name="payment_status" class="form-select w-25 ms-2">
        <option value="">All Payments</option>
        <option value="paid" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'paid' ? 'selected' : ''; ?>>Paid</option>
        <option value="pending" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="failed" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
    </select>
    <input type="date" name="start_date" class="form-control w-25 ms-2" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
    <input type="date" name="end_date" class="form-control w-25 ms-2" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
    <button type="submit" class="btn btn-primary ms-2">Filter</button>
</form>
<a href="export_orders.php?search=<?= urlencode($search) ?>&payment_status=<?= urlencode($payment_status) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>" class="btn btn-success mb-3">
    Export Orders as CSV
</a>



<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Order Date</th>
            <th>Order Status</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>
        
    <?php while ($row = mysqli_fetch_assoc($result)) { 
    // var_dump($row);
        // Order Status Logic
        if (strcasecmp($row['payment_method'], 'cod') == 0 && strcasecmp($row['payment_status'], 'pending') == 0) {
            $order_status = "Processing";
        } elseif (strcasecmp($row['payment_method'], 'stripe') == 0 && strcasecmp($row['payment_status'], 'paid') == 0) {
            $order_status = "Confirmed";
        } else {
            $order_status = $row['order_status'];
        }
    ?>
        <tr>
            <td><?= $row['order_id'] ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['full_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['address'] ?></td>
            <td>₹<?= $row['total_price'] ?></td>
            <td><?= $row['payment_method'] ?></td>
            <td><?= $row['payment_status'] ?></td>
            <td><?= $row['order_date'] ?></td>
            <td><?= $order_status ?></td> <!-- Updated Order Status -->
            <td class="text-center">
    <div class="d-flex flex-column flex-md-row gap-1">
        <a href="edit_order.php?order_id=<?= $row['order_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="payment_list.php?full_name=<?= urlencode($row['full_name']) ?>" class="btn btn-primary btn-sm">View Payments</a>
        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal<?= $row['order_id']; ?>">View</button>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderModal<?= $row['order_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order #<?= $row['order_id']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Customer:</strong> <?= $row['full_name']; ?> (<?= $row['email']; ?>)</p>
                    <p><strong>Phone:</strong> <?= $row['phone']; ?></p>
                    <p><strong>Address:</strong> <?= $row['address']; ?></p>
                    <p><strong>Total Price:</strong> ₹<?= $row['total_price']; ?></p>
                    <p><strong>Payment Method:</strong> <?= $row['payment_method']; ?></p>
                    <p><strong>Payment Status:</strong> <?= ucfirst($row['payment_status']); ?></p>
                    <p><strong>Order Date:</strong> <?= $row['order_date']; ?></p>
                </div>
            </div>
        </div>
    </div>
</td>

        </tr>
    <?php } ?>
</tbody>


</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($current_page > 1) { ?>
        <a href="order_list.php?page=<?= $current_page - 1 ?>">« Prev</a>
    <?php } ?>
    
    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="order_list.php?page=<?= $i ?>" class="<?= ($i == $current_page) ? 'active' : '' ?>"><?= $i ?></a>
    <?php } ?>
    
    <?php if ($current_page < $total_pages) { ?>
        <a href="order_list.php?page=<?= $current_page + 1 ?>">Next »</a>
    <?php } ?>
</div>
</div>
</div>
<!-- Bootstrap JS (Required for Modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
session_start();
include('../includes/db.php');

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';
$sort_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';

// Query for user list with search and sorting
$query = "SELECT user_id, full_name, email, phone, address, profile_photo, created_at FROM users ";
if ($search) {
    $query .= "WHERE full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' ";
}
$query .= "ORDER BY $sort_by $sort_order LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

// Count total users for pagination
$total_query = "SELECT COUNT(user_id) AS total FROM users";
if ($search) {
    $total_query .= " WHERE full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
}
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $limit);
?>



<!DOCTYPE html>
<html lang="en">
<a id="top"></a>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <!-- Link to the external CSS file -->
    <!-- <link rel="stylesheet" href="path/to/style.css"> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
    <style>/* General Page Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #E6E6FA, #F8F9FA);
    margin: 0;
    padding-top: 80px; /* Space for fixed admin header */
}
.navbar-brand{
    font-size: 170%;
}

/* Sidebar Styling */
.sidebar {
    position: fixed;
    width: 250px;
    height: 100vh;
    background: #2d3a4b;
    padding: 20px;
    color: white;
    left: 0;
    overflow-y: auto;
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

.sidebar .btn {
    background-color: rgb(246, 70, 39);
}

/* Admin Header Styling */
.admin {
    background: linear-gradient(to right, #E6E6FA, #F8F9FA);
    width: 100%;
    padding: 15px 0;
    position: fixed;
    top: 0;
    left: 0;
    text-align: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    height: 80px; /* Fixed height for the admin header */
    width: 100%;
}

.admin h1 {
    font-size: 28px;
    font-weight: bold;
    color: #2d3a4b;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0;
    margin-left: 20%;
}

/* Main Content Styling */
.main {
    background: rgba(255, 255, 255, 0.9);
    padding: 40px;
    padding-top: 120px; /* Add space for fixed admin header */
    border-radius: 10px;
    box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 1200px;
    text-align: center;
    margin-top: -6%;
    position: relative;
    margin-left: 20%;
    min-height: 400px; /* Ensure minimum height for the main content */
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: #4fc3f7;
    color: white;
}

img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #4fc3f7;
}

/* Buttons Styling */
.btn {
    padding: 8px 12px;
    background: #29b6f6;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    transition: 0.3s;
    display: inline-block;
    margin-top: 10px;
}

.btn:hover {
    background: #0288d1;
}

/* Pagination Styling */
.pagination {
    margin-top: 20px;  /* Add some space from the content above */
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-link {
    color: #0288d1;
    font-weight: bold;
}

.pagination .page-link:hover {
    background-color: #0288d1;
    color: white;
}

/* Search Form Styling */
.small-search {
    width: 200px;
    height: 30px;
    font-size: 14px;
}

.action-buttons {
    display: flex;
    justify-content: space-evenly;
    gap: 10px;
}

/* Modal Styling */
.modal-content {
    width: 100%;
    border-radius: 10px;
}

.modal-header {
    background-color: #f5f5f5;
}

.modal-footer {
    background-color: #f5f5f5;
}

/* Additional Styling */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Hover Effects for Sidebar Links */
.sidebar a:hover {
    background-color: #1abc9c;
}
/* Adjust the size of the search input and buttons */
.small-search {
    width: 300px;   /* Adjust the width of the search input */
    height: 40px;   /* Adjust height to match button */
    font-size: 14px; /* Adjust font size */
}

.form-control {
    width: auto; /* Allow the width to adjust based on content */
}

/* Adjust spacing between the search input and the button */
.d-flex .btn {
    margin-right: 10px;  /* Spacing between input and button */
}

    

.d-flex .btn {
    margin-right: 10px;  /* Adjust spacing between buttons */
}


</style>

<div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
    <a href="insert_product.php"><i class="fa fa-cogs"></i> Insert Products</a>
    <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
    <a href="insert_categories.php"><i class="fa fa-list"></i> Insert Categories</a>
    <a href="view_categories.php"><i class="fa fa-tags"></i> View Categories</a>
    <a href="order_list.php"><i class="fa fa-credit-card"></i> All Orders</a>
    <a href="payment_list.php" ><i class="fa fa-credit-card"></i> All Payments</a>
    <a href="user_list.php" class="link active"><i class="fa fa-users"></i> List Users</a>
    <a href="contact_view.php"><i class="fa fa-box"></i> View Messages</a>
    <a href="notifications.php">
    <i class="fa fa-bell"></i> Notifications 
    <span id="notificationCount" class="badge bg-danger"></span>
</a>
    <a href="../Medico/logout.php" class="btn btn-danger w-80 mt-3">Logout</a>
</div>

<div class="container">
    <div class="admin">
        <h1>Admin Panel</h1>
    </div>

    <div class="main">
        <h2>User List</h2>
       
       <!-- Search Form Section -->
<form method="GET" action="#top" class="mb-3 d-flex justify-content-start align-items-center">
    <!-- Search Input Field -->
    <input type="text" name="search" class="form-control small-search me-2" placeholder="Search users..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    
    <!-- Search Button -->
    <button type="submit" class="btn btn-primary btn-sm">Search</button>
    
    <!-- Clear Button (if search is active) -->
    <?php if (isset($_GET['search']) && !empty($_GET['search'])) { ?>
        <a href="user_list.php" class="btn btn-secondary btn-sm ms-2">Clear</a>
    <?php } ?>
</form>

       <!-- Sorting and Download CSV Button Section -->
<div class="d-flex justify-content-start align-items-center mb-3">
    <!-- Download CSV Button -->
    <a href="export_users.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>" class="btn btn-success btn-sm">Download CSV</a>
    <!-- Sorting Buttons -->
    <a href="?order_by=full_name&sort=ASC&page=<?php echo $page; ?>" class="btn btn-light btn-sm me-2">Sort by Name ↑</a>
    <a href="?order_by=full_name&sort=DESC&page=<?php echo $page; ?>" class="btn btn-light btn-sm me-2">Sort by Name ↓</a>
    <a href="?order_by=created_at&sort=ASC&page=<?php echo $page; ?>" class="btn btn-light btn-sm me-2">Sort by Date ↑</a>
    <a href="?order_by=created_at&sort=DESC&page=<?php echo $page; ?>" class="btn btn-light btn-sm me-2">Sort by Date ↓</a>

    
</div>
        <!-- User Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Profile Photo</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Registered Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { 
                    $profile_photo = !empty($row['profile_photo']) 
                        ? 'http://localhost/MedicoProject/Medico/' . $row['profile_photo'] 
                        : 'http://localhost/MedicoProject/Medico/uploads/default-avatar.png';
                ?>
                    <tr>
                        <td><img src="<?php echo $profile_photo; ?>" width="50" height="50" style="border-radius:50%; object-fit: cover; border: 2px solid #4fc3f7;"></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td class="action-buttons">
                            <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#userModal<?php echo $row['user_id']; ?>">View</button>
                        </td>
                    </tr>

                    <!-- User Details Modal -->
                    <div class="modal fade" id="userModal<?php echo $row['user_id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">User Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="<?php echo $profile_photo; ?>" width="120" height="120" class="rounded-circle border border-primary mb-3">
                                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                                    <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                                    <p><strong>Registered Date:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </tbody>
        </table>

       <!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center">
        <!-- Previous Page Link -->
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&order_by=<?php echo $sort_by; ?>&sort=<?php echo $sort_order; ?>">Previous</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        <?php endif; ?>

        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&order_by=<?php echo $sort_by; ?>&sort=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next Page Link -->
        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&order_by=<?php echo $sort_by; ?>&sort=<?php echo $sort_order; ?>">Next</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>

    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

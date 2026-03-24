<?php
include('../includes/connect.php');

// Fetch all categories from the database
$select_query = "SELECT * FROM categories";
$result_query = mysqli_query($con, $select_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
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
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #E6E6FA, #F8F9FA);

    padding: 20px;
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
.btn-primary {
            background-color: #007bff;
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
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
    margin-left: 20%;
    max-width: 1000px;
            /* margin: auto; */
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-top: 5%;
}

</style>
<body>
<!-- <div class="nav-buttons">
        <a href="index3.php"><button class="btn" onclick="goPrevious()">❮</button></a>
      <a href="order_list.php"><button class="btn" onclick="goNext()">❯</button></a>
    </div> -->
    <div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <!-- <h2>Admin Panel</h2> -->
        <a href="insert_product.php"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
        <a href="insert_categories.php" ><i class="fa fa-list"></i> Insert Categories</a>
        <a href="view_categories.php" class="link active"><i class="fa fa-tags"></i> View Categories</a>
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
    <div class="container mt-2">
    <div class="admin">
    <h2 >Admin Panel</h2>
</div>
    <div class="main">
        <h1 class="text-center mb-4">View Categories</h1>

        <!-- Table to display categories -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Category ID</th>
                    <th>Category Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display categories
                if (mysqli_num_rows($result_query) > 0) {
                    while ($row = mysqli_fetch_assoc($result_query)) {
                        $category_title = $row['category_title'];
                        $category_id = $row['category_id'];
                        echo "<tr>
                                <td>$category_id</td>
                                <td>$category_title</td>
                                <td>
                                    <a href='view_products.php?category_id=$category_id' class='btn btn-info btn-sm'>View Products</a>
                                    <a href='edit_category.php?category_id=$category_id' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_category.php?category_id=$category_id' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this category?');\">Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No categories found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="insert_categories.php" class="btn btn-primary">Add New Category</a>
    </div>
    </div>
</body>

</html>

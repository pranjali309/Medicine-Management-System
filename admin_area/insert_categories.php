<?php
include('../includes/connect.php');

if (isset($_POST['insert_cat'])) {
    // Sanitize the user input to prevent XSS (cross-site scripting)
    $category_title = mysqli_real_escape_string($con, $_POST['cat_title']);
    
    // Check if the category already exists using prepared statements
    $select_query = "SELECT * FROM categories WHERE category_title = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $category_title);
    mysqli_stmt_execute($stmt);
    $result_select = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_select) > 0) {
        echo "<script>alert('This category already exists');</script>";
    } else {
        // Insert new category if it doesn't exist using prepared statements
        $insert_query = "INSERT INTO categories (category_title) VALUES (?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, 's', $category_title);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Category inserted successfully');</script>";
        } else {
            echo "<script>alert('Error inserting category');</script>";
        }
    }

    // Close prepared statements
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Categories</title>
    
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
    background: linear-gradient(to right, #E6E6FA, #F8F9FA);
    margin: 0;
    padding: 20px;
}
/* .container {
    max-width: 600px;
    margin: auto;
    background: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
} */
h2 {
    text-align: center;
    color:black;
    margin-bottom: 20px;
}
.input-group {
    margin-bottom: 15px;
}
.input-group-text {
    background-color: #17a2b8;
    color: white;
    border: none;
}
.form-control {
    border-radius: 5px;
}
.btn-insert {
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}
.btn-insert:hover {
    background-color: #0056b3;
}

/* Navigation Buttons */
.nav-buttons {
    display: flex;
    justify-content: left;
    align-items: center;
    margin: 20px;
    gap: 10px;
}
.nav-buttons .btn {
    background: none;
    border: none;
    font-size: 24px;
    color: black;
    cursor: pointer;
    transition: color 0.3s;
}
.nav-buttons .btn:hover {
    color: gray;
}
/* Align buttons side by side */
.action-buttons {
    display: flex;
    justify-content: center; /* Center align buttons */
    gap: 10px; /* Space between buttons */
    margin-top: 20px;
}

/* Reduce Button Size */
.action-buttons .btn-insert,
.action-buttons .btn.view {
    background-color: #007bff; /* Blue for Insert */
    color: white;
    border: none;
    padding: 8px 14px; /* Reduced padding */
    font-size: 14px; /* Reduced font size */
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
    text-decoration: none;
    width: 35%; /* Set equal width for both buttons */
    text-align: center;
}

/* Hover Effect */
.action-buttons .btn-insert:hover {
    background-color: #0056b3; /* Darker Blue */
}

/* View Categories Button - Green */
.action-buttons .btn.view {
    background-color: #28a745; /* Green */
}

.action-buttons .btn.view:hover {
    background-color: #218838; /* Darker Green */
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
    max-width: 600px;
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
<body>
<!-- <div class="nav-buttons">
    <a href="index3.php"><button class="btn">❮</button></a>
    <a href="view_categories.php"><button class="btn">❯</button></a>
</div> -->
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
<div class="main">
    <h2>Insert Categories</h2>
    <form action="" method="post">
        <div class="input-group mb-3">
            <!-- <span class="input-group-text"><i class="fa-solid fa-receipt"></i></span> -->
            <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" required>
        </div>
        <div class="action-buttons">
        <button type="submit" class="btn-insert" name="insert_cat">Insert Category</button>
        <a href="view_categories.php" class="btn view">View Category</a>
        </div>
    </form>
</div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

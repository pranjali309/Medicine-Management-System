<?php
include('../includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
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
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            
        } */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 10%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            margin-right: 5px;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-primary {
            background-color: #007bff;
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
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
/* Increase Actions Column Width */
th:last-child, td:last-child {
    min-width: 150px; /* Adjust width as needed */
    white-space: nowrap; /* Prevent text from wrapping */
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
    /* left: 10%; */
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
    <!-- <div class="nav-buttons">
    <a href="index3.php"><button class="btn">❮</button></a>
    <a href="insert_categories.php"><button class="btn">❯</button></a>
</div> -->
</head>
<body>
<div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <!-- <h2>Admin Panel</h2> -->
        <a href="insert_product.php"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"class="link active"><i class="fa fa-box"></i> View Products</a>
        <a href="insert_categories.php"><i class="fa fa-list"></i> Insert Categories</a>
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
        <h2 class="text-center">View Products</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Discount Price</th>
                    <th>Expiry Date</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetch_products = "SELECT * FROM products ORDER BY created_at DESC";
                $result = mysqli_query($con, $fetch_products);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>₹" . $row['price'] . "</td>";
                        echo "<td>₹" . ($row['discount_price'] ?? '-') . "</td>";
                        echo "<td>" . $row['expiry_date'] . "</td>";
                        echo "<td>" . $row['stock_quantity'] . "</td>";
                        echo "<td><img src='../uploads/" . $row['product_image1'] . "' alt='" . $row['product_name'] . "'></td>";
                        echo "<td>
                                <a href='update_product.php?edit_id=" . $row['product_id'] . "' class='btn btn-warning btn-sm'>Update</a>
                                <a href='delete_product.php?delete_id=" . $row['product_id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="insert_product.php" class="btn btn-primary">Add New Product</a>
    </div>
    </div>
</body>
</html>
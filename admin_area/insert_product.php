<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link rel="stylesheet" href="style.css">
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
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: whitesmoke;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        /* body { font-family: 'Poppins', sans-serif; background: #f4f6f9; color: #333; } */
        .sidebar { position: fixed; width: 250px; height: 100vh; background: #2d3a4b; padding: 20px; color: #fff; }
        .sidebar a { display: block; padding: 10px; color: #fff; text-decoration: none; border-radius: 5px; margin-bottom: 10px; }
        .sidebar a:hover { background: #1abc9c; }
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
.link.active {
    color: #1abc9c;
}
/* ===== Main Content Layout ===== */
.main-content {
    margin-left: 270px; /* Sidebar width */
    margin-top: 80px; /* Admin panel height */
    padding: 20px;
}

/* ===== Container Styling ===== */
.container {
    max-width: 800px;
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    margin: auto;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-top: 20px;
    
}

/* ===== Heading ===== */
.container h2 {
    text-align: center;
    color: #2d3a4b;
    margin-bottom: 20px;
    font-weight: bold;
}

/* ===== Labels ===== */
label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
    color: #333;
}

/* ===== Input Fields, Select, Textarea ===== */
input, select, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

/* ===== Action Buttons ===== */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 15px; 
    margin-top: 20px;
}

.action-buttons .btn {
    background-color: #007bff; 
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
    text-decoration: none;
    font-weight: bold;
}

/* ===== Hover Effect ===== */
.action-buttons .btn:hover {
    background-color: #0056b3; /* Dark Blue */
}

/* ===== View Products Button - Different Color ===== */
.action-buttons .btn.view {
    background-color: #28a745; /* Green */
}

.action-buttons .btn.view:hover {
    background-color: #218838; /* Darker Green */
}

/* ===== Responsive Design ===== */
@media screen and (max-width: 768px) {
    .sidebar {
        width: 220px;
    }

    .main-content {
        margin-left: 240px;
    }

    .container {
        width: 90%;
        padding: 20px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .action-buttons .btn {
        width: 100%;
    }
}

    </style>
</head>
<body>
<div class="sidebar fixed-top">
    <a class="navbar-brand" href="index3.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <!-- <h2>Admin Panel</h2> -->
        <a href="insert_product.php " class="link active"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
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
   
    
    <!-- Main Content -->
     
     
    <div class="main-content">
    <div class="admin">
    <h2 >Admin Panel</h2>
</div>

        <div class="container">
            <h2>Insert New Product</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label>Product Name:</label>
                <input type="text" name="product_name" required>

                <label>Description:</label>
                <textarea name="description" required></textarea>

                <label>Category:</label>
                <select name="category_id" required>
                    <option value="">Select a Category</option>
                    <?php
                        include('../includes/connect.php');
                        $select_query = "SELECT * FROM categories";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            echo "<option value='{$row['category_id']}'>{$row['category_title']}</option>";
                        }
                    ?>
                </select>

                <label>Medicine Type:</label>
                <input type="text" name="medicine_type" required>

                <label>Dosage Information:</label>
                <input type="text" name="dosage_info" required>

                <label>Prescription Required:</label>
                <select name="prescription_required" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>

                <label>Manufacturer:</label>
                <input type="text" name="manufacturer" required>

                <label>Storage Instructions:</label>
                <textarea name="storage_instructions" required></textarea>

                <label>Side Effects:</label>
                <textarea name="side_effects"></textarea>

                <label>Price:</label>
                <input type="number" name="price" step="0.01" required>

                <label>Discount Price (Optional):</label>
                <input type="number" name="discount_price" step="0.01">

                <label>Expiry Date:</label>
                <input type="date" name="expiry_date" required>

                <label>Stock Quantity:</label>
                <input type="number" name="stock_quantity" required>

                <label>Product Image:</label>
                <input type="file" name="product_image1" required>

                <div class="action-buttons">
                    <button type="submit" name="insert_product" class="btn">Insert Product</button>
                    <a href="view_products.php" class="btn view">View Products</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

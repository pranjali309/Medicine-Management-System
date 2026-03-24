<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: whitesmoke;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        /* Header */
        .header {
            width: 100%;
            background: linear-gradient(to right, #eef2f3, #d9e2ec);
            color: black;
            text-align: center;
            padding: 15px 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        /* Layout */
        .content-wrapper {
            display: flex;
            height: 100%;
            width: 100%;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1e3a5f;
            padding-top: 20px;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #fca311;
        }
        
        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 40px 60px;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
        }
        
        /* Container */
        .container {
            max-width: 1150px;
            background: white;
            padding: 40px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }
        
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #333;
        }
        input, select, textarea {
    width: 100%;
    padding: 14px; /* Input fields मोठे दिसतील */
    margin-top: 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 18px; /* Font size वाढवला */
    transition: 0.3s;
}

        input:focus, select:focus, textarea:focus {
            border-color: #fca311;
            outline: none;
        }
        
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
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn.view {
            background-color: #28a745;
        }
        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="header">Admin Panel</div>
    <div class="content-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="home.php"><b>Sagar Medico</b></a>
            <a href="insert_product.php">Insert Products</a>
            <a href="view_products.php">View Products</a>
            <a href="insert_categories.php">Insert Categories</a>
            <a href="view_categories.php">View Categories</a>
            <a href="order_list.php">All Orders</a>
            <a href="payment_list.php">All Payments</a>
            <a href="user_list.php">List Users</a>
            <a href="contact_view.php">View Messages</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <h2>Insert New Product</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label>Product Name:</label>
                    <input type="text" name="product_name" required>
                    
                    <label>Category:</label>
                    <select name="category_id" required>
                        <option value="">Select a Category</option>
                        <?php
                            include('../includes/connect.php');
                            $result_query = mysqli_query($con, "SELECT * FROM categories");
                            while ($row = mysqli_fetch_assoc($result_query)) {
                                echo "<option value='{$row['category_id']}'>{$row['category_title']}</option>";
                            }
                        ?>
                    </select>
                    
                    <label>Description:</label>
                    <textarea name="description" required></textarea>
                    
                    <label>Medicine Type:</label>
                    <input type="text" name="medicine_type" required>
                    
                    <label>Dosage Info:</label>
                    <input type="text" name="dosage_info" required>
                    
                    <label>Prescription Required:</label>
                    <select name="prescription_required" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    
                    <label>Manufacturer:</label>
                    <input type="text" name="manufacturer" required>
                    
                    <label>Price:</label>
                    <input type="number" name="price" step="0.01" required>
                    
                    <label>Expiry Date:</label>
                    <input type="date" name="expiry_date" required>
                    
                    <label>Product Image:</label>
                    <input type="file" name="product_image1" required>
                    
                    <div class="action-buttons">
                        <button type="submit" name="insert_product" class="btn">Insert Product</button>
                        <a href="view_products.php" class="btn view">View Products</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
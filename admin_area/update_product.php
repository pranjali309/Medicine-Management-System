<?php
include('../includes/connect.php');

if (isset($_GET['edit_id'])) {
    $product_id = $_GET['edit_id'];

    // Fetch product details
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $product_name = $row['product_name'];
        $description = $row['description'];
        $price = $row['price'];
        $discount_price = $row['discount_price'];
        $expiry_date = $row['expiry_date'];
        $stock_quantity = $row['stock_quantity'];
        $product_image1 = $row['product_image1'];
    } else {
        echo "<script>alert('Product not found'); window.location.href='view_products.php';</script>";
        exit();
    }
}

if (isset($_POST['update_product'])) {
    $product_name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $discount_price = $_POST['discount_price'] ?? NULL;
    $expiry_date = $_POST['expiry_date'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handling image update
    if (!empty($_FILES['product_image1']['name'])) {
        $product_image1 = $_FILES['product_image1']['name'];
        $image1_tmp = $_FILES['product_image1']['tmp_name'];
        move_uploaded_file($image1_tmp, "../uploads/" . $product_image1);
    }

    // Update query
    $update_query = "UPDATE products SET product_name=?, description=?, price=?, discount_price=?, expiry_date=?, stock_quantity=?, product_image1=? WHERE product_id=?";
    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssssi", $product_name, $description, $price, $discount_price, $expiry_date, $stock_quantity, $product_image1, $product_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Product updated successfully!'); window.location.href='view_products.php';</script>";
    } else {
        echo "<script>alert('Error updating product');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #E6E6FA, #F8F9FA);
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Product</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="product_name" value="<?php echo $product_name; ?>" required>

            <label>Description:</label>
            <textarea name="description" required><?php echo $description; ?></textarea>

            <label>Price:</label>
            <input type="number" name="price" value="<?php echo $price; ?>" required>

            <label>Discount Price:</label>
            <input type="number" name="discount_price" value="<?php echo $discount_price; ?>">

            <label>Expiry Date:</label>
            <input type="date" name="expiry_date" value="<?php echo $expiry_date; ?>" required>

            <label>Stock Quantity:</label>
            <input type="number" name="stock_quantity" value="<?php echo $stock_quantity; ?>" required>

            <label>Current Image:</label>
            <img src="../uploads/<?php echo $product_image1; ?>" width="50px">
            
            <label>Change Image:</label>
            <input type="file" name="product_image1">

            <button type="submit" name="update_product">Update Product</button>
        </form>
    </div>
</body>
</html>
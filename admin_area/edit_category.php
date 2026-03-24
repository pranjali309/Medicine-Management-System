<?php
include('../includes/connect.php');

// Check if `category_id` is set in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch the category details from the database
    $query = "SELECT * FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_title = $row['category_title'];
    } else {
        echo "<script>alert('Category not found.');</script>";
        echo "<script>window.location.href = 'view_categories.php';</script>";
    }
}

// Handle the form submission to update the category
if (isset($_POST['update_category'])) {
    $updated_title = mysqli_real_escape_string($con, $_POST['category_title']);

    if (!empty($updated_title)) {
        $update_query = "UPDATE categories SET category_title = '$updated_title' WHERE category_id = $category_id";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            echo "<script>alert('Category updated successfully!');</script>";
            echo "<script>window.location.href = 'view_categories.php';</script>";
        } else {
            echo "<script>alert('Error updating category.');</script>";
        }
    } else {
        echo "<script>alert('Category title cannot be empty.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style=" background: linear-gradient(to right, #E6E6FA, #F8F9FA);">
    <div class="container mt-5">
        <h2 class="text-center">Edit Category</h2>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="category_title" class="form-label">Category Title</label>
                <input type="text" name="category_title" id="category_title" class="form-control"
                    value="<?php echo isset($category_title) ? htmlspecialchars($category_title) : ''; ?>" required>
            </div>
            <button type="submit" name="update_category" class="btn btn-success">Update Category</button>
            <a href="view_categories.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>

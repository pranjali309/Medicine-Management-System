<?php
session_start();
include('../includes/db.php'); // Database connection

// Check if user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid user ID.");
}

$user_id = (int)$_GET['id'];

// Fetch user details
$query = "SELECT full_name, email, phone, address, profile_photo FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Handle user update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Handle profile photo upload
    $profile_photo = $user['profile_photo']; // Keep old photo if not changed
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        
        // Check file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                $profile_photo = $target_file;
            }
        }
    }

    // Update user details
    $update_query = "UPDATE users SET full_name = ?, email = ?, phone = ?, address = ?, profile_photo = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $full_name, $email, $phone, $address, $profile_photo, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "User updated successfully!";
        header("Location: user_list.php");
        exit();
    } else {
        $_SESSION['error_msg'] = "Error updating user.";
    }
}

// Handle password reset
if (isset($_POST['reset_password'])) {
    $new_password = password_hash("123456", PASSWORD_BCRYPT); // Hash password

    $password_query = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($password_query);
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Password reset successful! New password: 123456";
        header("Location: edit_user.php?id=$user_id");
        exit();
    } else {
        $_SESSION['error_msg'] = "Error resetting password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <style>
  /* styles.css */
body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 600px;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
}

h2 {
    text-align: center;
    color: #007bff;
}

.alert {
    text-align: center;
}

.form-label {
    font-weight: bold;
}

img {
    display: block;
    margin: 10px auto;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #4fc3f7;
}

.btn {
    padding: 8px 12px;
    font-size: 14px;
    display: inline-block;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.button-group {
    display: flex;
    justify-content: space-between;
    /* gap: 5px; */
}

    </style>
<div class="container mt-5">
    <h2>Edit User</h2>

    <!-- Show success or error messages -->
    <?php if (isset($_SESSION['success_msg'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
    <?php } ?>
    
    <?php if (isset($_SESSION['error_msg'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">
        <!-- Profile Photo -->
        <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            <br>
            <img src="<?php echo !empty($user['profile_photo']) ? $user['profile_photo'] : 'uploads/default-avatar.png'; ?>" 
                 width="100" height="100" style="border-radius:50%; object-fit:cover; border:2px solid #4fc3f7;">
            <input type="file" name="profile_photo" class="form-control mt-2">
        </div>

        <!-- Full Name -->
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>

        <div class="button-group">
    <button type="submit" name="update_user" class="btn btn-success">Update User</button>
    <a href="user_list.php" class="btn btn-secondary">Cancel</a>
    <button type="submit" name="reset_password" class="btn btn-danger">Reset Password</button>
</div>

    </form>
</div>
</body>
</html>

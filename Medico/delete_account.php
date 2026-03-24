<?php
session_start();
include('../includes/db.php');
include 'session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details to get the profile photo
$stmt = $conn->prepare("SELECT profile_photo FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    // Delete profile photo if it's not the default one
    if (!empty($user['profile_photo']) && $user['profile_photo'] !== 'default-avatar.png') {
        $photo_path = $user['profile_photo'];
        if (file_exists($photo_path)) {
            unlink($photo_path);
        }
    }

    // Delete the user from the database
    $delete_query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        session_destroy(); // Destroy session
        echo "<script>alert('Your account has been deleted successfully.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error deleting account. Please try again.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f9ff;
            text-align: center;
            padding: 50px;
        }

        .container {
            max-width: 500px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        h2 {
            color: #d9534f;
        }

        p {
            color: #555;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
        }

        .delete {
            background: #d9534f;
            color: white;
        }

        .delete:hover {
            background: #c9302c;
        }

        .cancel {
            background: #6c757d;
            color: white;
        }

        .cancel:hover {
            background: #545b62;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Account</h2>
    <p>Are you sure you want to delete your account? This action is irreversible.</p>

    <form  method="POST">
        <button type="submit" name="confirm_delete" class="btn delete">Yes, Delete My Account</button>
        <a href="profile.php" class="btn cancel">Cancel</a>
    </form>
</div>

</body>
</html>

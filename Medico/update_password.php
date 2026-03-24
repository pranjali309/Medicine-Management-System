<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to change the password.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        echo "All fields are required.";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "New password and Confirm password do not match.";
        exit();
    }

    // Fetch current password from database
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($current_password, $user['password'])) {
        echo "Incorrect current password.";
        exit();
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password. Please try again.";
    }

    $stmt->close();
}
?>

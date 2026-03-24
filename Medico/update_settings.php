<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update settings.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dark_mode = isset($_POST['dark_mode']) ? (int)$_POST['dark_mode'] : 0;
    $privacy = isset($_POST['privacy']) ? $_POST['privacy'] : 'everyone';

    // Update settings in the database
    $stmt = $conn->prepare("UPDATE users SET dark_mode = ?, privacy_setting = ? WHERE user_id = ?");
    $stmt->bind_param("isi", $dark_mode, $privacy, $user_id);

    if ($stmt->execute()) {
        echo "Settings updated successfully.";
    } else {
        echo "Error updating settings. Please try again.";
    }

    $stmt->close();
}
?>

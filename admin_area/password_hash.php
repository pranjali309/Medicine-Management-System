<?php
include('../includes/db.php'); // db connection

$username = "admin";
$email = "admin@gmail.com";
$plain_password = "Admin@123";

// hash the password
$hashed = password_hash($plain_password, PASSWORD_BCRYPT);

// insert using prepared statement
$sql = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hashed);
if ($stmt->execute()) {
    echo "Admin created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

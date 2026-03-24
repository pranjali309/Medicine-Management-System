<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'mystore';

// Create connection
$con = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

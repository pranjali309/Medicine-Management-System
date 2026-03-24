<?php
$host = "localhost";
$user = "root";  // Change if needed
$pass = "root";      // Change if needed
$db = "mystore";    // Change to your database name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

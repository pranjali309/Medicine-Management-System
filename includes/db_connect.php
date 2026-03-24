<?php
$host = "localhost";
$user = "root"; // Change this if needed
$pass = "root"; // Change this if needed
$dbname = "mystore"; // Your database name

// Create connection
$con = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

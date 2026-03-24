<?php
$host = "localhost";
$user = "root"; // Change if needed
$pass = "root"; // Change if needed
$dbname = "mystore"; // Using the "mysql" database

// Create connection
$con = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>



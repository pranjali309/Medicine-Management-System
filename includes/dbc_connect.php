<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = "root"; // Change if needed
$database = "mystore";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

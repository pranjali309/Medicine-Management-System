<?php
include('../includes/db.php');
$conn->query("UPDATE notifications SET status = 'read'");
?>

<?php
include('../includes/db.php');

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $conn->query("UPDATE notifications SET status = 'read' WHERE id = $id");
}
?>

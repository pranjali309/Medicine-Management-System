<?php
session_start();
include('../includes/db.php'); // Database connection

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=users_list.csv');

$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, ['User ID', 'Full Name', 'Email', 'Phone', 'Address', 'Registered Date']);

// Check if a search query exists
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT user_id, full_name, email, phone, address, created_at FROM users";
if (!empty($search)) {
    $query .= " WHERE full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
}
$query .= " ORDER BY created_at DESC";

$result = $conn->query($query);

// Write user data to CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['user_id'], 
        $row['full_name'], 
        $row['email'], 
        $row['phone'], 
        $row['address'], 
        $row['created_at']
    ]);
}

fclose($output);
exit();
?>

<?php
include('../includes/db_connection.php');

// Set headers for CSV file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=orders.csv');

// Open file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, array('Order ID', 'User ID', 'Full Name', 'Email', 'Phone', 'Address', 'Total Price', 'Payment Method', 'Payment Status', 'Order Date', 'Order Status'));

// Get filters from GET request
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$payment_status = isset($_GET['payment_status']) ? mysqli_real_escape_string($con, $_GET['payment_status']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Construct query with filters
$query = "SELECT * FROM orders WHERE 1";

if ($search) {
    $query .= " AND (order_id LIKE '%$search%' OR full_name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($payment_status) {
    $query .= " AND payment_status = '$payment_status'";
}
if ($start_date && $end_date) {
    $query .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
}

$query .= " ORDER BY order_date DESC";

$result = mysqli_query($con, $query);

// Fetch rows and write to CSV
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
?>

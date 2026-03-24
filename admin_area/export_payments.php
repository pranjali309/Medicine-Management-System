<?php
include('../includes/db_connection.php');

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=filtered_payments.csv');

// Open output stream
$output = fopen('php://output', 'w');

// CSV Headers
fputcsv($output, ['Order ID', 'User ID', 'Full Name', 'Total Price', 'Payment Method', 'Payment Status', 'Order Date']);

// GET Filters
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$filter = isset($_GET['payment_filter']) ? mysqli_real_escape_string($con, $_GET['payment_filter']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Construct filtered query
$query = "SELECT order_id, user_id, full_name, total_price, payment_method, payment_status, order_date FROM orders WHERE 1";

if ($search) {
    $query .= " AND (order_id LIKE '%$search%' OR user_id LIKE '%$search%' OR full_name LIKE '%$search%')";
}
if ($filter) {
    $query .= " AND payment_status = '$filter'";
}
if ($start_date && $end_date) {
    $query .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
}

$query .= " ORDER BY order_date DESC";

$result = mysqli_query($con, $query);

// Write data to CSV
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close file
fclose($output);
exit();
?>

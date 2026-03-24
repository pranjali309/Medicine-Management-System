<?php
include('../includes/db.php');

// Fetch unread notifications count
$count_query = "SELECT COUNT(*) AS total FROM notifications WHERE status = 'unread'";
$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();
$unread_count = $count_row['total'];

// Fetch unread notifications list
$list_query = "SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC";
$list_result = $conn->query($list_query);

$notifications = [];
while ($row = $list_result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['id'],
        'message' => htmlspecialchars($row['message']),
        'time' => date('Y-m-d H:i:s', strtotime($row['created_at']))
    ];
}

// Return data as JSON
echo json_encode([
    'count' => $unread_count,
    'notifications' => $notifications
]);
?>

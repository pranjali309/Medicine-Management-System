<?php
// Database Connection
require_once('../includes/db_connection.php'); 

// Check Database Connection
if (!$con) {
    die(json_encode(["error" => "Database connection failed: " . mysqli_connect_error()]));
}

// ✅ Function to Fetch Latitude & Longitude using Google API
function getCoordinates($address) {
    $address = urlencode($address);
    $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY'; // 🔹 Google API Key टाका

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey";
    $response = file_get_contents($url);
    
    if ($response === FALSE) {
        return ['latitude' => null, 'longitude' => null]; // API Failure
    }

    $json = json_decode($response, true);
    if ($json['status'] == 'OK') {
        return [
            'latitude' => $json['results'][0]['geometry']['location']['lat'],
            'longitude' => $json['results'][0]['geometry']['location']['lng']
        ];
    }

    return ['latitude' => null, 'longitude' => null]; // Invalid Address
}

// ✅ 1️⃣ Orders Status Breakdown
$orderQuery = "SELECT 
    SUM(CASE WHEN LOWER(order_status)='pending' THEN 1 ELSE 0 END) AS pending, 
    SUM(CASE WHEN LOWER(order_status)='processing' THEN 1 ELSE 0 END) AS processing, 
    SUM(CASE WHEN LOWER(order_status)='shipped' THEN 1 ELSE 0 END) AS shipped, 
    SUM(CASE WHEN LOWER(order_status)='delivered' THEN 1 ELSE 0 END) AS delivered, 
    SUM(CASE WHEN LOWER(order_status)='cancelled' THEN 1 ELSE 0 END) AS cancelled 
FROM orders";
$orderResult = mysqli_query($con, $orderQuery);
$orderData = mysqli_fetch_assoc($orderResult);

// ✅ 2️⃣ Monthly Sales Performance
$salesQuery = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(total_price) AS revenue 
FROM orders 
WHERE LOWER(payment_status) IN ('paid', 'completed') 
GROUP BY month 
ORDER BY month ASC";
$salesResult = mysqli_query($con, $salesQuery);
$salesData = mysqli_fetch_all($salesResult, MYSQLI_ASSOC);

// ✅ 3️⃣ Live Orders Count
$liveOrdersQuery = "SELECT COUNT(*) AS live_orders 
FROM orders 
WHERE LOWER(order_status) IN ('pending', 'processing', 'shipped')";
$liveOrdersResult = mysqli_query($con, $liveOrdersQuery);
$liveOrdersData = mysqli_fetch_assoc($liveOrdersResult);

// ✅ 4️⃣ Top-Selling Products
$topProductsQuery = "SELECT p.product_name, SUM(oi.quantity) AS sold 
FROM order_items oi 
JOIN products p ON oi.product_id = p.product_id 
GROUP BY oi.product_id 
ORDER BY sold DESC 
LIMIT 5";
$topProductsResult = mysqli_query($con, $topProductsQuery);
$topProductsData = mysqli_fetch_all($topProductsResult, MYSQLI_ASSOC);

// ✅ 5️⃣ Revenue vs Expenses
$revenueExpenseQuery = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, 
SUM(total_price) AS revenue, 
SUM(total_price) * 0.2 AS expenses 
FROM orders 
WHERE LOWER(payment_status) IN ('paid', 'completed') 
GROUP BY month 
ORDER BY month ASC";
$revenueExpenseResult = mysqli_query($con, $revenueExpenseQuery);
$revenueExpenseData = mysqli_fetch_all($revenueExpenseResult, MYSQLI_ASSOC);

// ✅ 6️⃣ Geographical Sales Data
$geoSalesQuery = "SELECT u.address AS city_name, COUNT(o.order_id) AS sales 
FROM orders o 
JOIN users u ON o.user_id = u.user_id 
WHERE u.address IS NOT NULL AND u.address != '' 
GROUP BY u.address 
ORDER BY sales DESC";
$geoSalesResult = mysqli_query($con, $geoSalesQuery);
$geoSalesData = [];

while ($row = mysqli_fetch_assoc($geoSalesResult)) {
    $coords = getCoordinates($row['city_name']);
    
    if ($coords['latitude'] !== null && $coords['longitude'] !== null) {
        $geoSalesData[] = [
            "city_name" => $row['city_name'],
            "sales" => $row['sales'],
            "latitude" => $coords['latitude'],
            "longitude" => $coords['longitude']
        ];
    }
}

// ✅ 7️⃣ Registered Users Count
$usersQuery = "SELECT COUNT(*) AS registered_users FROM users";
$usersResult = mysqli_query($con, $usersQuery);
$usersData = mysqli_fetch_assoc($usersResult);

// ✅ 8️⃣ New Messages Count
$messagesQuery = "SELECT COUNT(*) AS new_messages FROM messages WHERE reply IS NULL";
$messagesResult = mysqli_query($con, $messagesQuery);
$messagesData = mysqli_fetch_assoc($messagesResult);

// ✅ 9️⃣ Returned Visitors Count
$returnedVisitorsQuery = "SELECT COUNT(*) AS returned_visitors 
FROM users 
WHERE last_login IS NOT NULL 
AND created_at < last_login";
$returnedVisitorsResult = mysqli_query($con, $returnedVisitorsQuery);
$returnedVisitorsData = mysqli_fetch_assoc($returnedVisitorsResult);

// 🔹 Final JSON Response
$response = [
    "orders" => $orderData,
    "sales" => $salesData,
    "liveOrders" => $liveOrdersData['live_orders'],
    "topProducts" => $topProductsData,
    "revenueVsExpenses" => $revenueExpenseData,
    "geoSales" => $geoSalesData,
    "registeredUsers" => $usersData['registered_users'],
    "newMessages" => $messagesData['new_messages'],
    "returnedVisitors" => $returnedVisitorsData['returned_visitors'] 
];

// ✅ Return JSON Response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>

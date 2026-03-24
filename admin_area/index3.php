<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Real-Time Dashboard</title>
     <!-- Leaflet CSS -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; color: #333; }
        .sidebar { 
            position: fixed; width: 250px; height: 100vh; background: #2d3a4b; padding: 20px; color: #fff;
         }
        .sidebar a { 
            display: block; padding: 10px; color: #fff; text-decoration: none; border-radius: 5px; margin-bottom: 10px;
         }
        .sidebar a:hover {
             background: #1abc9c;
             }
             
        .main-content { margin-left: 270px; padding: 20px; }
        .top-info { display: flex; justify-content: space-between; gap: 15px; }
        .info-box { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1); flex: 1; text-align: center; }
        .chart-container { 
    background: #fff; 
    border-radius: 10px; 
    padding: 20px; 
    margin-top: 20px; 
    height: 500px; /* Increased height */
}
#shopMap { 
            height: 500px; 
            border-radius: 10px; 
            margin-top: 20px; 
        }
/* ===== Sidebar ===== */
.sidebar {
    position: fixed;
    width: 250px;
    height: 100vh;
    background: #2d3a4b;
    padding: 20px;
    color: white;
    /* top: 50px; Admin Panel header खाली */
    left: 0;
    overflow-y: auto;
    /* flex-direction: top; */
}

.sidebar a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #1abc9c;
}

.navbar-brand{
    font-size: 170%;
}

        #map { height: 300px; border-radius: 10px; margin-top: 20px; }.chart-container { background: #fff; border-radius: 10px; padding: 20px; margin-top: 20px; height: 400px; }

        .admin {
            background: linear-gradient(to right, #E6E6FA, #F8F9FA);
    width: 100%;
    padding: 15px 0;
    position: absolute; /* Place it at the top */
    top: 0;
    left: 0;
    text-align: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000; /* Keep it above other content */
}

.admin h2 {
    font-size: 28px;
    font-weight: bold;
    color: #2d3a4b;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0; /* Remove default margin */
    margin-left: 20%;
}

/* Add space below admin panel */
.main-content {
    margin-top: 80px; /* Pushes top-info down */
}

.top-info {
    margin-top: 20px; /* Adds space between Admin Panel and Top Info */
}
 </style>
</head>
<body>
<div class="sidebar fixed-top">
    <a class="navbar-brand" href="../Medico/home.php"><b><sup style="color:white;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <!-- <h2>Admin Panel</h2> -->
        <a href="insert_product.php " class="link active"><i class="fa fa-cogs"></i> Insert Products</a>
        <a href="view_products.php"><i class="fa fa-box"></i> View Products</a>
        <a href="insert_categories.php"><i class="fa fa-list"></i> Insert Categories</a>
        <a href="view_categories.php"><i class="fa fa-tags"></i> View Categories</a>
        <a href="order_list.php"><i class="fa fa-credit-card"></i> All Orders</a>
        <a href="payment_list.php"><i class="fa fa-credit-card"></i> All Payments</a>
        <a href="user_list.php"><i class="fa fa-users"></i> List Users</a>
        <a href="contact_view.php"><i class="fa fa-box"></i> View Messages</a>
        <a href="notifications.php">
    <i class="fa fa-bell"></i> Notifications 
    <span id="notificationCount" class="badge bg-danger"></span>
</a>
        <a href="../Medico/logout.php" class="btn btn-danger w-80 mt-3">Logout</a>
    </div>
   
    <div class="main-content">
    <div class="admin">
    <h2>Admin Panel</h2>
</div>

        <div class="top-info">
            <div class="info-box"><h5>Returned Visitors</h5><h3 id="returnedVisitors">0</h3></div>
            <div class="info-box"><h5>New Messages</h5><h3 id="newMessages">0</h3></div>
            <div class="info-box"><h5>Registered Users</h5><h3 id="registeredUsers">0</h3></div>
            <div class="info-box"><h5>Live Orders</h5><h3 id="liveOrders">0</h3></div>
        </div>
        <div class="row">
            <div class="col-md-6 chart-container">
                <h4>Monthly Sales Performance</h4>
                <canvas id="salesPerformanceChart" style="height: 1550px !important;"></canvas>

            </div>
            <div class="col-md-6 chart-container">
                <h4>Order Status Breakdown</h4>
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
        
        <div class="row">

            <div class="col-md-6 chart-container">
                <h4>Top-Selling Products</h4>
                <canvas id="topProductsChart"></canvas>
            </div>
            <div class="col-md-6 chart-container">
                <h4>Revenue vs Expenses</h4>
                <canvas id="revenueExpenseChart"></canvas>
            </div>
        </div>
        <div class="chart-container">
            <h4>Geographical Sales Heatmap</h4>
            <div id="map"></div>
        </div>

        <!-- Add Shop Location Map below Geographical Heatmap -->
    <div class="chart-container">
        <h4>Shop Location</h4>
        <div id="shopMap"></div>
    </div>
        
    </div>
    
    <script>
        // Initialize Leaflet Map for Shop Location
        var shopLocation = [17.7357, 73.9254];  // Coordinates for Sagar Medical

        var map = L.map('shopMap').setView(shopLocation, 12);  // Center map on shop location

        // Add tile layer to map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add marker to indicate the shop location
        L.marker(shopLocation).addTo(map)
            .bindPopup('<b>Sagar Medical</b><br>Ozarde, Tal Wai, Dist Satara, 415803')
            .openPopup();
    </script>
    <script>
        // Initialize Empty Charts
        var orderChart = new Chart(document.getElementById('orderStatusChart').getContext('2d'), {
            type: 'doughnut',
            data: { labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'], datasets: [{ data: [0, 0, 0, 0, 0], backgroundColor: ['#f39c12', '#3498db', '#2ecc71', '#e74c3c', '#d35400'] }] }
        });

        var salesChart = new Chart(document.getElementById('salesPerformanceChart').getContext('2d'), { 
            type: 'line', 
            data: { labels: [], datasets: [{ label: 'Revenue', data: [], borderColor: '#1abc9c', borderWidth: 2 }] } 
        });

        var topProductsChart = new Chart(document.getElementById('topProductsChart').getContext('2d'), { 
            type: 'bar', 
            data: { labels: [], datasets: [{ label: 'Units Sold', data: [], backgroundColor: '#8e44ad' }] } 
        });

        var revenueExpenseChart = new Chart(document.getElementById('revenueExpenseChart').getContext('2d'), {
    type: 'line', // Line chart
    data: {
        labels: [], // Populate with months dynamically
        datasets: [
            {
                label: 'Revenue',
                data: [], // Populate with revenue data dynamically
                borderColor: '#2ecc71', // Green for revenue
                backgroundColor: 'rgba(46, 204, 113, 0.2)', // Transparent green
                fill: true, // Enable area fill
                borderWidth: 2
            },
            {
                label: 'Expenses',
                data: [], // Populate with expenses data dynamically
                borderColor: '#e74c3c', // Red for expenses
                backgroundColor: 'rgba(231, 76, 60, 0.2)', // Transparent red
                fill: true, // Enable area fill
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                stacked: true // Stack the lines
            }
        }
    }
});

    function updateCharts(data) {
        revenueExpenseChart.data.labels = data.revenueVsExpenses.map(item => item.month);
        revenueExpenseChart.data.datasets[0].data = data.revenueVsExpenses.map(item => item.revenue);
        revenueExpenseChart.data.datasets[1].data = data.revenueVsExpenses.map(item => item.expenses);
        revenueExpenseChart.update();
    }
        function updateDashboard() {
    fetch('get_data.php?t=' + new Date().getTime()) // Prevents caching issues
    .then(response => response.json())
    .then(data => {
        document.getElementById("returnedVisitors").textContent = data.returnedVisitors;
        document.getElementById("newMessages").textContent = data.newMessages;
        document.getElementById("registeredUsers").textContent = data.registeredUsers;
        document.getElementById("liveOrders").textContent = data.liveOrders;

        orderChart.data.datasets[0].data = [
            data.orders.pending, 
            data.orders.processing, 
            data.orders.shipped, 
            data.orders.delivered, 
            data.orders.cancelled
        ];
        orderChart.update();

        salesChart.data.labels = data.sales.map(item => item.month);
        salesChart.data.datasets[0].data = data.sales.map(item => item.revenue);
        salesChart.update();

        topProductsChart.data.labels = data.topProducts.map(item => item.product_name);
        topProductsChart.data.datasets[0].data = data.topProducts.map(item => item.sold);
        topProductsChart.update();

        revenueExpenseChart.data.labels = data.revenueVsExpenses.map(item => item.month);
        revenueExpenseChart.data.datasets[0].data = data.revenueVsExpenses.map(item => item.revenue);
        revenueExpenseChart.data.datasets[1].data = data.revenueVsExpenses.map(item => item.expenses);
        revenueExpenseChart.update();

        updateHeatmap(data.geoSales);
    });
}

setInterval(updateDashboard, 5000);
updateDashboard();
  


function updateHeatmap(geoSales) {
    var map = L.map('map').setView([20.5937, 78.9629], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    geoSales.forEach(function (location) {
        L.circleMarker([location.latitude, location.longitude], { color: "#1abc9c", radius: location.sales / 5, fillOpacity: 0.6 })
        .bindPopup(`<b>${location.city_name}</b><br>Sales: ${location.sales}`).addTo(map);
    });
}

setInterval(updateDashboard, 5000);
updateDashboard();
    </script>
    <script>
function fetchNotifications() {
    $.ajax({
        url: "fetch_notifications.php", 
        method: "GET",
        success: function(data) {
            $("#notificationCount").text(data); 
        }
    });
}

setInterval(fetchNotifications, 5000); // Update every 5 seconds
fetchNotifications(); // Run once on page load
</script>

</body>

</html>

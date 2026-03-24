<?php
include('connect.php'); // Database Connection

function fetchTableData($conn, $tableName) {
    $query = "SELECT * FROM $tableName";
    $result = mysqli_query($conn, $query);
    
    echo "<h2>$tableName Table</h2>";
    echo "<table border='1'>
            <tr>";
    
    // Column Headers
    while ($field = mysqli_fetch_field($result)) {
        echo "<th>" . ucfirst(str_replace("_", " ", $field->name)) . "</th>";
    }
    echo "</tr>";

    // Table Data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table><br>";
}

// Call function for each table
fetchTableData($conn, "products");
fetchTableData($conn, "users");
fetchTableData($conn, "orders");
fetchTableData($conn, "billing_history");

?>
<style>
    body { font-family: Arial, sans-serif; text-align: center; }
    table { width: 80%; margin: auto; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid black; }
    th { background: #f2f2f2; }
</style>

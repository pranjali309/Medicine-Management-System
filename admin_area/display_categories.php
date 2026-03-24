<?php
include('../includes/connect.php');
?>

<h2 class="text-center">Categories List</h2>
<table class="table table-bordered text-center">
    <thead class="bg-info text-white">
        <tr>
            <th>S.No</th>
            <th>Category Title</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select_query = "SELECT * FROM categories";
        $result = mysqli_query($con, $select_query);
        $number = 1; // Counter for serial number

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $number . "</td>
                    <td>" . htmlspecialchars($row['category_title'], ENT_QUOTES, 'UTF-8') . "</td>
                  </tr>";
            $number++;
        }
        ?>
    </tbody>
</table>


<?php
include('../includes/connect.php');

if(isset($_POST['insert_brand'])){
    $brand_title = $_POST['brand_title'];

    // Check if the category already exists
    $select_query = "SELECT * FROM `brands` WHERE brand_title = '$brand_title'";
    $result_select = mysqli_query($con, $select_query);

    if(mysqli_num_rows($result_select) > 0){
        echo "<script>alert('This Brand already exists');</script>";
    } else {
        // Insert new category if it doesn't exist
        $insert_query = "INSERT INTO `brands` (brand_title) VALUES ('$brand_title')";
        if(mysqli_query($con, $insert_query)){
            echo "<script>alert('Brands inserted successfully');</script>";
        } else {
            echo "<script>alert('Error inserting Brands');</script>";
        }
    }
}
?>


<h2 class="text-center">Insert Brands</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brands" aria-label="brands"  aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
    
    <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_brand" value="Insert Brands">
         
    </div>
</form>
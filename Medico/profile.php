<?php
session_start();
include('../includes/db.php');
include 'session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details function
function getUserDetails($conn, $user_id) {
    $stmt = $conn->prepare("SELECT full_name, email, phone, address, profile_photo FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fetch user details initially
$user = getUserDetails($conn, $user_id);

$full_name = htmlspecialchars($user['full_name'] ?? '', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars($user['address'] ?? '', ENT_QUOTES, 'UTF-8');
$profile_photo = !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'default-avatar.png';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $new_full_name = trim($_POST['full_name']);
    $new_email = trim($_POST['email']);
    $new_phone = trim($_POST['phone']);
    $new_address = trim($_POST['address']);
    $profile_photo = $user['profile_photo']; // Keep the existing photo by default

    // Check if email is already taken by another user
    $check_email_query = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("si", $new_email, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('This email is already in use. Please use a different email.');</script>";
    } else {
        // Handle profile photo upload
        if (!empty($_FILES['profile_photo']['name'])) {
            $target_dir = "uploads/"; // Ensure this folder exists
            $profile_photo_name = time() . "_" . basename($_FILES["profile_photo"]["name"]);
            $target_file = $target_dir . $profile_photo_name;

            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                $profile_photo = $target_file;
            } else {
                echo "<script>alert('Error uploading photo!');</script>";
            }
        }

        // Update user details including email
        $update_query = "UPDATE users SET full_name=?, email=?, phone=?, address=?, profile_photo=? WHERE user_id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $new_full_name, $new_email, $new_phone, $new_address, $profile_photo, $user_id);

        if ($stmt->execute()) {
            // Re-fetch updated user details after updating
            $user = getUserDetails($conn, $user_id);
            $full_name = htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
            $phone = htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8');
            $address = htmlspecialchars($user['address'], ENT_QUOTES, 'UTF-8');
            $profile_photo = htmlspecialchars($user['profile_photo']);

            echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
        } else {
            echo "<script>alert('Update failed. Please try again.');</script>";
        }
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f9ff;
            margin: 0;
            padding: 0;
        }
         /* Back Button */
         .back-button {
            position: absolute ;
                
            
           top: 40%;
            left: 40px;
            background: #0077b6;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
        }


        .back-button:hover {
            background: #005f8e;
        }

        /* Main Container */
        .container {
            display: flex;
            width: 65%;
            max-width: 900px;
            margin: 50px auto;
            gap: 20px;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 230px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            text-align: center;
            color: #0077b6;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 12px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
            text-align: center;
            cursor: pointer;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            width: 100%;
        }

        .sidebar ul li:hover, .sidebar ul li.active {
            background: #0077b6;
            color: white;
        }

        .sidebar ul li:hover a, .sidebar ul li.active a {
            color: white;
        }

        /* Profile Section */
        .profile-content {
            flex: 1;
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .profile-header img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px black;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header h2 {
            margin: 5px 0;
            font-size: 20px;
            color: #333;
        }

        /* Form Styles */
        form {
            margin-top: 15px;
            text-align: left;
        }

        form label {
            font-weight: 500;
            margin: 8px 0 5px;
            display: block;
            color: #555;
            font-size: 14px;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: #f8f9fa;
            transition: 0.3s;
            outline: none;
        }

        form input:focus, form textarea:focus {
            border-color: #00a8e8;
            background: white;
        }

        /* Buttons */
        .btn {
            
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .update {
            width: 100%;
            background: #28a745; /* Green */
            color: white;
            margin-top: 8px;
            text-align: center;
            display: block;
            text-decoration: none;
            padding: 10px;
        }

        .update:hover {
            background: #218838;
        }

        .delete {
            width: 100%;
            background: #ff4444; /* Red */
            
            color: white;
            margin-top: 8px;
            text-align: center;
            display: block;
            text-decoration: none;
            padding: 10px;
        }

        .delete:hover {
            background: #cc0000;
            
           
        }

        .logout {
            
            background: #1c3faa; /* Dark Blue */
            color: white;
            margin-top: 8px;
            text-align: center;
            display: block;
            text-decoration: none;
            padding: 10px;
        }

        .logout:hover {
            background: #162c69;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
                width: 95%;
            }

            .sidebar {
                width: 100%;
                text-align: center;
            }

            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .sidebar ul li {
                width: 48%;
            }

            .profile-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Back Button -->
<a href="home.php" class="back-button"> ← Back to Home</a>

<div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>My Account</h3>
            <ul>
                <li class="active"><a href="profile.php">Profile</a></li>
                <li><a href="my_orders.php">Orders</a></li>
                <!-- <li><a href="wishlist.php">Wishlist</a></li> -->
                <li><a href="settings.php">Settings</a></li>
                <li><a href="subscribe.php"> Subscriptions Plans</a></li>
                <li><a href="help.php">Help & Support</a></li>
                <li><a href="account_actions.php">Account Actions</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <div class="profile-header">
            <img src="<?php echo $profile_photo; ?>" alt="Profile Photo">
            <h2><?php echo $full_name; ?></h2>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>" required>


            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $phone; ?>" required>

            <label>Address:</label>
            <textarea name="address" required><?php echo $address; ?></textarea>

            <label>Change Profile Photo:</label>
            <input type="file" name="profile_photo" accept="image/*">

            <button type="submit" name="update" class="btn update">Update Profile</button>
        </form>

        <form action="delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
            <button type="submit" name="delete" class="btn delete">Delete Account</button>
        </form>

        <a href="logout.php" class="btn logout">Logout</a>
    </div>
</div>

</body>
</html>









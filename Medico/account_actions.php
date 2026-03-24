<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Actions</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            width: 85%;
            max-width: 1100px;
            margin: 40px auto;
            gap: 20px;
            margin-right: 90px;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
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

        /* Content */
        .content {
            flex: 1;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.12);
        }
        .section {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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
            background: #0077b6;
            color: white;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .btn.deactivate {
            background: #ffcc00;
        }
        .btn.deactivate:hover {
            background: #d4a700;
        }
        .btn.delete {
            background: #ff4444;
        }
        .btn.delete:hover {
            background: #cc0000;
        }
        /* Confirmation Box */
        .confirm-box {
            display: none;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }
        .confirm-box input {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .back-button {
    position: fixed;
    top: 50%;
    left: 2px;
    transform: translateY(-50%);
    background: #0077b6;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s ease;
    text-decoration: none;
}
.back-button:hover {
    background: #005f8e;
}
    </style>
</head>
<body>
    <!-- back button -->
    <a href="home.php" class="back-button">← Back to Home</a>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>My Account</h3>
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="my_orders.php">Orders</a></li>
            <!-- <li><a href="wishlist.php">Wishlist</a></li> -->
            <li><a href="settings.php">Settings</a></li>
            <li><a href="payments.php">Payments & Subscriptions</a></li>
            <li><a href="help.php">Help & Support</a></li>
            <li class="active"><a href="account_actions.php">Account Actions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Account Actions Content -->
    <div class="content">
        <h2>Account Actions</h2>
        <p>Manage your account actions such as deactivation or deletion.</p>

        <!-- Deactivate Account -->
        <div class="section">
            <h4>Deactivate Account</h4>
            <p>You can temporarily deactivate your account. You can reactivate it later by logging in again.</p>
            <button class="btn deactivate" id="deactivateBtn">Deactivate Account</button>
        </div>

        <!-- Delete Account -->
        <div class="section">
            <h4>Delete Account</h4>
            <p><strong>Warning:</strong> Deleting your account is permanent and cannot be undone.</p>
            <button class="btn delete" onclick="showConfirmBox()">Delete Account</button>

            <!-- Confirmation Box -->
            <div class="confirm-box" id="confirmBox">
                <p>Enter your password to confirm:</p>
                <form action="delete_account.php" method="post" onsubmit="return validateDelete()">
                    <input type="password" name="password" id="confirmPassword" placeholder="Enter Password" required>
                    <button type="submit" class="btn delete">Confirm Deletion</button>
                    <button type="button" class="btn" onclick="hideConfirmBox()">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Show confirmation box
    function showConfirmBox() {
        document.getElementById("confirmBox").style.display = "block";
    }

    // Hide confirmation box
    function hideConfirmBox() {
        document.getElementById("confirmBox").style.display = "none";
    }

    // Validate password input
    function validateDelete() {
        let password = document.getElementById("confirmPassword").value;
        if (password.trim() === "") {
            alert("Please enter your password to proceed.");
            return false;
        }
        return confirm("Are you sure you want to delete your account?");
    }

    // Handle account deactivation
    document.getElementById("deactivateBtn").addEventListener("click", function() {
        if (confirm("Are you sure you want to deactivate your account?")) {
            fetch("deactivate_account.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "deactivate=true"
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                window.location.href = "logout.php";
            })
            .catch(error => console.error("Error:", error));
        }
    });
</script>

</body>
</html>

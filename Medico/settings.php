<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT full_name, email, dark_mode FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | My Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    /* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fa;
    color: #333;
    transition: 0.3s;
}
.dark-mode {
    background: #1e1e1e;
    color: white;
}

/* Main Container - Minimum Gap & Equal Height */
.container {
    display: flex;
    width: 80%;
    max-width: 1000px;
    margin: 40px auto;
    gap: 5px; /* Minimum gap */
    align-items: stretch; /* Ensures both sections have the same height */
}

/* Back Button */
.back-button {
            position: absolute ;
                
            
           top: 40%;
            left: 15px;
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

        /* Sidebar */
        .sidebar {
            
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-right: 4%;
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


/* Settings Container - Same Height as Sidebar */
.settings-container {
    flex: 1; /* Takes remaining space */
    background: white;
    padding: 30px;
    border-radius: 0 12px 12px 0; /* Rounded only on the right */
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.12);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Sections */
.section {
    background: white;
    padding: 22px;
    border-radius: 12px;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    transition: 0.3s;
}
.section:hover {
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
}
.section h4 {
    font-weight: bold;
    color: #0077b6;
    margin-bottom: 15px;
}

/* Buttons */
.btn-primary {
    border-radius: 8px;
    font-weight: bold;
    transition: 0.3s;
    background: linear-gradient(135deg, #0077b6, #005f8e);
    border: none;
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    color: white;
}
.btn-primary:hover {
    opacity: 0.85;
    transform: scale(1.02);
}

/* Form Fields */
.form-control {
    border-radius: 8px;
    padding: 12px;
    font-size: 15px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    transition: 0.2s ease-in-out;
}
.form-control:focus {
    border-color: #0077b6;
    box-shadow: 0 0 5px rgba(0, 119, 182, 0.3);
}


/* Dark Mode Enhancements */
.dark-mode .settings-container,
.dark-mode .sidebar,
.dark-mode .section {
    background: #2b2b2b;
    color: white;
}
.dark-mode .form-control {
    background: #333;
    color: white;
    border-color: #555;
}
.dark-mode .form-control:focus {
    border-color: #0077b6;
}
.dark-mode .btn-primary {
    background: linear-gradient(135deg, #0094cc, #0077b6);
}
.dark-mode .sidebar ul li a {
    color: white;
}
.dark-mode .sidebar ul li:hover {
    background: #0077b6;
}

</style>
</head>
<body class="<?php echo $user['dark_mode'] ? 'dark-mode' : ''; ?>">
     <!-- Back Button -->
<a href="home.php" class="back-button"> ← Back to Home</a>

<div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>My Account</h3>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="my_orders.php">Orders</a></li>
                <!-- <li><a href="wishlist.php">Wishlist</a></li> -->
                <li class="active"><a href="settings.php">Settings</a></li>
                <li><a href="subscribe.php">Subscriptions Plans</a></li>
                <li><a href="help.php">Help & Support</a></li>
                <li><a href="account_actions.php">Account Actions</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

<div class="settings-container">
    <h2 class="text-center">Settings</h2>

    <!-- Security -->
    <div class="section" id="security">
        <h4>Security & Login</h4>
        <form id="changePasswordForm">
            <label>Current Password</label>
            <input type="password" class="form-control mb-2" name="current_password" required>

            <label>New Password</label>
            <input type="password" class="form-control mb-2" name="new_password" required>

            <label>Confirm Password</label>
            <input type="password" class="form-control mb-2" name="confirm_password" required>

            <button type="submit" class="btn btn-primary">Update Password</button>
            <p id="passwordMessage" class="text-center mt-2"></p>
        </form>
    </div>

    <!-- Privacy -->
    <div class="section" id="privacy">
        <h4>Privacy</h4>
        <label>Who can see your activity?</label>
        <select class="form-control" id="privacySetting">
            <option value="everyone">Everyone</option>
            <option value="only_me">Only Me</option>
            <option value="friends">Friends</option>
        </select>
    </div>

    <!-- App Settings -->
    <div class="section" id="app-settings">
        <h4>App Settings</h4>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="darkModeToggle" name="dark_mode" <?php if ($user['dark_mode']) echo 'checked'; ?>>
            <label class="form-check-label">Enable Dark Mode</label>
        </div>
    </div>

    <!-- Save Settings Button -->
    <button id="saveSettingsBtn" class="btn btn-primary">Save Settings</button>
    <p id="settingsMessage" class="text-center mt-2"></p>
</div>

<script>
$(document).ready(function() {
    // Update Password
    $("#changePasswordForm").submit(function(e) {
        e.preventDefault();
        $.post("update_password.php", $(this).serialize(), function(response) {
            $("#passwordMessage").html(response);
        });
    });

    // Dark Mode Toggle
    $("#darkModeToggle").change(function() {
        let darkMode = $(this).is(":checked") ? 1 : 0;
        $.post("update_settings.php", { dark_mode: darkMode }, function(response) {
            $("body").toggleClass("dark-mode");
            $("#settingsMessage").html("Dark Mode Updated");
        });
    });

    // Save Settings
    $("#saveSettingsBtn").click(function() {
        let privacy = $("#privacySetting").val();
        let darkMode = $("#darkModeToggle").is(":checked") ? 1 : 0;

        $.post("update_settings.php", { privacy: privacy, dark_mode: darkMode }, function(response) {
            $("#settingsMessage").html(response);
        });
    });
});
</script>

</body>
</html>

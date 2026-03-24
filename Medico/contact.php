<?php
session_start();
include('../includes/db.php');

// Default profile photo
$profile_photo = "uploads/default.png";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT profile_photo FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if (!empty($user['profile_photo'])) {
        $profile_photo = $user['profile_photo'];
    }
}

// Initialize form variables
$name = $phone = $address = $message = "";
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $message = trim($_POST['message']);
    $ip_address = $_SERVER['REMOTE_ADDR'];

    if (empty($name)) {
        $error = "Please enter your name!";
    } elseif (empty($address)) {
        $error = "Please enter your address!";
    } elseif (empty($message)) {
        $error = "Please enter your message!";
    } elseif (strlen($message) < 10) {
        $error = "Message must be at least 10 characters long!";
    } else {
        // Insert the message into the database
        $stmt = $conn->prepare("INSERT INTO messages (name, phone, address, message, ip_address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $phone, $address, $message, $ip_address);
        if ($stmt->execute()) {
            // ✅ Add a notification entry in the database for the admin
            $notification_message = "📩 New message from $name ($phone)";
            $insert_notification = "INSERT INTO notifications (message, status) VALUES (?, 'unread')";
            
            $stmt_notify = $conn->prepare($insert_notification);
            if ($stmt_notify) {
                $stmt_notify->bind_param("s", $notification_message);
                $stmt_notify->execute();
                $stmt_notify->close();
            }

            $success = "Your message has been submitted successfully!";
            $name = $phone = $address = $message = ""; // Clear form fields
        } else {
            $error = "Database Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <style>
        /* navbar */
.navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
        font-family: 'Poppins';
      }
.navbar {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
}

.navbar-nav .nav-link {
    font-weight: 500;
    transition: color 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover, 
.navbar-nav .nav-link.active {
    color: #ff9800;
}
/* Form Container */
.main {
    max-width: 600px; /* Reduce the container width */
  padding-top: 4%;
    margin-left: 25%;
    padding-bottom: 4%;
}

/* Input Filds and Textarea */
.form-control {
    width: 100%; /* Ensure full-width for inputs */
    padding: 8px; /* Reduce padding for more compact form fields */
    font-size: 14px; /* Reduce font size */
    
}

/* Textarea */
textarea.form-control {
    height: 100px; /* Reduce height of the message textarea */
}

/* Button Styling */
.btn {
    padding: 8px 16px;  /* Adjust button padding */
    font-size: 14px; /* Reduce font size for the button */
}

/* Form Labels */
.form-label {
    font-size: 14px;  /* Smaller font size for form labels */
}

    </style>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
    <div class="d-flex align-items-center me-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="d-flex align-items-center text-decoration-none">
                        <img src="<?php echo $profile_photo; ?>" alt="Profile Photo" class="rounded-circle" width="40" height="40">
                        
                    </a>
                <?php else: ?>
                    <!-- <a href="login.php" class="btn btn-primary"></a> -->
                <?php endif; ?>
            </div>
        <a class="navbar-brand" href="home.php"><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link " href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link " href="product_page1.php">Product</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
            </ul>
            <form class="d-flex" action="product_page1.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" required>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <a href="wishlist.php" class="btn"><i class="bi bi-suit-heart-fill text-danger"></i></a>
            <a href="cart.php" class="btn"><i class="bi bi-cart-fill"></i></a>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>" class="btn">
                <i class="bi bi-person-fill"></i>
            </a>
        </div>
    </div>
</nav>

<div class="main mt-5">
    <h2 class="text-center">Contact Us</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"> <?= $error ?> </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"> <?= $success ?> </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4" required><?= htmlspecialchars($message) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Message</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

setInterval(fetchNotifications, 5000); // Update notifications every 5 seconds
fetchNotifications(); // Fetch immediately on page load
</script>
<!-- footer -->
<?php include("footer.php"); ?>
</body>
</html>

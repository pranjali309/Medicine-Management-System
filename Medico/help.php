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
    <title>Help & Support</title>
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
            margin-right: 70px;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            border-radius: 10px;
            padding: 30px;
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
        /* FAQ Section */
        .faq-container {
            margin-top: 20px;
        }
        .faq-item {
            background: #f8f9fa;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .faq-item:hover {
            transform: scale(1.02);
        }
        .faq-question {
            font-weight: bold;
            color: #0077b6;
        }
        .faq-answer {
            display: none;
            margin-top: 10px;
            color: #333;
            transition: max-height 0.4s ease-in-out;
        }
        /* Live Chat */
        .chat-box {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .chat-box input {
            width: 80%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .chat-box .send-btn {
            width: 15%;
            padding: 8px;
            background: #0077b6;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        /* Back Button (Left Side Center) */
.back-button {
    position: fixed;
    top: 50%;
    left: 0px;
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
            <li><a href="payments.php">Subscriptions Plans</a></li>
            <li class="active"><a href="help.php">Help & Support</a></li>
            <li><a href="account_actions.php">Account Actions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Help & Support Content -->
    <div class="content">
        <h2>Help & Support</h2>
        <p>If you need any help, you can contact our support team.</p>

        <h4>Contact Us</h4>
        <p>Email: <a href="mailto:sagarmedico@example.com">sagarmedico29@example.com</a></p>
        <p>Phone: +91 9234567890</p>

        <!-- FAQ Section -->
        <h4>Frequently Asked Questions</h4>
        <div class="faq-container">
            <div class="faq-item">
                <p class="faq-question">How do I reset my password?</p>
                <p class="faq-answer">Go to the login page and click on 'Forgot Password'. Follow the instructions.</p>
            </div>
            <div class="faq-item">
                <p class="faq-question">How can I update my profile information?</p>
                <p class="faq-answer">Go to 'Profile' and click on 'Edit'. You can update your details and save changes.</p>
            </div>
            <div class="faq-item">
                <p class="faq-question">What payment methods do you accept?</p>
                <p class="faq-answer">We accept Credit Cards, PayPal, and UPI payments.</p>
            </div>
            <div class="faq-item">
                <p class="faq-question">How can I track my order?</p>
                <p class="faq-answer">Go to 'My Orders' and click on the order ID to track your shipment.</p>
            </div>
            <div class="faq-item">
                <p class="faq-question">How do I request a refund?</p>
                <p class="faq-answer">Contact support with your order ID, and we will process your refund request.</p>
            </div>
        </div>

        <!-- Live Chat -->
        <h4>Live Chat</h4>
        <div class="chat-box">
            <input type="text" id="chatInput" placeholder="Ask a question..." />
            <button class="send-btn" onclick="sendMessage()">Send</button>
            <p id="chatResponse" style="margin-top: 10px; color: #0077b6;"></p>
        </div>
    </div>
</div>

<script>
    // FAQ Toggle Script
    document.querySelectorAll(".faq-item").forEach(item => {
        item.addEventListener("click", () => {
            let answer = item.querySelector(".faq-answer");
            answer.style.display = (answer.style.display === "block") ? "none" : "block";
        });
    });

    // Live Chat Simulation
    function sendMessage() {
        let userMessage = document.getElementById("chatInput").value.toLowerCase();
        let response = "Our support team will contact you soon.";
        if (userMessage.includes("refund")) response = "Please check the Payments & Subscriptions section for refund details.";
        if (userMessage.includes("order")) response = "Go to 'My Orders' to track your shipment.";
        if (userMessage.includes("password")) response = "Click 'Forgot Password' on the login page to reset your password.";
        document.getElementById("chatResponse").innerText = response;
    }
</script>

</body>
</html>

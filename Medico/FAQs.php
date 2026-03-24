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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
        }
        .container {
    width: 90%;
    max-width: 1000px;
    margin: 20px auto; /* Reduced margin */
    padding: 20px;
}
        .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.12);
        }
        h2 {
            text-align: center;
            color: #004085;
        }
        .contact-info {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .contact-info a {
            color: #0077b6;
            text-decoration: none;
            font-weight: bold;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }

        .faq-container {
            margin-top: 20px;
        }
        .faq-item {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }
        .faq-item:hover {
            transform: scale(1.02);
        }
        .faq-question {
            font-size: 18px;
            font-weight: 600;
            color: #004085;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-answer {
            display: none;
            margin-top: 10px;
            color: #333;
            font-size: 16px;
            line-height: 1.5;
        }

         /* Live Chat Styling */
        
.chat-box {
    margin-top: 0px; /* Reduced margin from top */
    padding: 15px; /* Reduced padding */
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 750px; /* Reduced width */
    margin-left: auto;
    margin-right: auto;
    padding-bottom: 60px;
    padding-top: 60px;
    margin-bottom: 6%;
}

.chat-box input {
    width: 80%; /* Adjusted input width */
    padding: 8px; /* Reduced padding */
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-right: 10px;
    font-size: 14px;
}

.chat-box .send-btn {
    width: 15%;
    padding: 8px; /* Reduced padding */
    background: #004085;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
}

.chat-box .send-btn:hover {
    background: #002752;
}

#chatResponse {
    margin-top: 10px;
    color: #0077b6;
    font-weight: bold;
}
h3 {
    text-align: center; /* Center the text */
    color: #004085; /* Optional: You can adjust the color if needed */
    margin-top: 20px; /* Optional: You can adjust the top margin for spacing */
}

    </style>
</head>
<body>


<div class="container">
    <div class="content">
        <h2>Frequently Asked Questions ❓</h2>
        

        <div class="faq-container">
            <div class="faq-item"><p class="faq-question">🔑 How do I reset my password? <span>+</span></p>
                <p class="faq-answer">Go to the login page and click 'Forgot Password'.</p>
            </div>
            <div class="faq-item"><p class="faq-question">📍 How can I change my delivery address? <span>+</span></p>
                <p class="faq-answer">You can change it before placing an order in the 'Profile' section.</p>
            </div>
            <div class="faq-item"><p class="faq-question">📦 What happens if my order is lost? <span>+</span></p>
                <p class="faq-answer">Contact support immediately. We will initiate a replacement/refund.</p>
            </div>
            <div class="faq-item"><p class="faq-question">💳 Why was my payment declined? <span>+</span></p>
                <p class="faq-answer">Ensure correct details, sufficient balance, and check with your bank.</p>
            </div>
            <div class="faq-item"><p class="faq-question">💰 How long does a refund take? <span>+</span></p>
                <p class="faq-answer">Refunds take 5-7 business days to reflect in your account.</p>
            </div>
            <div class="faq-item"><p class="faq-question">🚮 How can I delete my account? <span>+</span></p>
                <p class="faq-answer">Send a request to customer support to delete your account permanently.</p>
            </div>
            <div class="faq-item"><p class="faq-question">💊 Do I need a prescription for all medicines? <span>+</span></p>
                <p class="faq-answer">No, only prescription drugs require a valid doctor's prescription.</p>
            </div>
            <div class="faq-item"><p class="faq-question">⏳ How long does delivery take? <span>+</span></p>
                <p class="faq-answer">Delivery usually takes 2-5 business days depending on your location.</p>
            </div>
            <div class="faq-item"><p class="faq-question">💡 Can I track my order? <span>+</span></p>
                <p class="faq-answer">Yes, you can track your order in the 'My Orders' section.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll(".faq-item").forEach(item => {
        item.addEventListener("click", () => {
            let answer = item.querySelector(".faq-answer");
            let icon = item.querySelector("span");
            if (answer.style.display === "block") {
                answer.style.display = "none";
                icon.textContent = "+";
            } else {
                answer.style.display = "block";
                icon.textContent = "-";
            }
        });
    });
</script>

<h3>Live Chat</h3>
        <div class="chat-box">
            <input type="text" id="chatInput" placeholder="Ask a question..." />
            <button class="send-btn" onclick="sendMessage()">Send</button>
            <p id="chatResponse"></p>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll(".faq-item").forEach(item => {
        item.addEventListener("click", () => {
            let answer = item.querySelector(".faq-answer");
            let icon = item.querySelector("span");
            if (answer.style.display === "block") {
                answer.style.display = "none";
                icon.textContent = "+";
            } else {
                answer.style.display = "block";
                icon.textContent = "-";
            }
        });
    });
</script>
<!-- footer -->
<?php include("footer.php"); ?>

</body>
</html>

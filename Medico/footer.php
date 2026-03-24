<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sagar Medico Footer</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        /* Footer Styling */
        footer {
            background: #F0F8FF;

            color: #002752;
            padding: 50px 5%;
            text-align: center;
            /* #DDE7F2 */
        }
        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: auto;
            text-align: left;
        }
        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 12px;
            color: #004085;
            font-weight: 600;
            transition: 0.3s ease-in-out;
        }
        .footer-column ul {
            list-style: none;
            padding: 0;
        }
        .footer-column ul li {
            margin-bottom: 8px;
        }
        .footer-column ul li a {
            text-decoration: none;
            color: #002752;
            font-size: 15px;
            transition: 0.3s;
            font-weight: 500;
        }
        /* Electric Blue Glow Effect */
        .footer-column ul li a:hover,
        .footer-column h3:hover,
        .footer-column p:hover {
            text-shadow: 0px 0px 12px rgba(0, 191, 255, 0.9); /* Electric Blue Glow */
            color: black;
        }
        .subscribe-box {
            display: flex;
            align-items: center;
            border: 1px solid #004085;
            padding: 5px;
            border-radius: 5px;
            background: white;
        }
        .subscribe-box input {
            flex: 1;
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
        }
        .subscribe-box button {
            background: #004085;
            border: none;
            color: white;
            padding: 8px 12px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }
        .subscribe-box button:hover {
            background-color: #003366;
            box-shadow: 0px 0px 12px rgba(0, 191, 255, 0.9); /* Electric Blue Glow */
        }
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 15px;
        }
        .social-icons a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            color: #004085;
            border-radius: 50%;
            font-size: 18px;
            text-decoration: none;
            transition: 0.3s ease-in-out;
        }
        .social-icons a:hover {
            background-color: #002752;
            color: white;
            box-shadow: 0px 0px 10px rgba(0, 31, 63, 0.8); /* Keep Blue Glow for Social Icons */
        }
        .payment-methods {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .payment-methods img {
            width: 50px;
            transition: 0.3s ease-in-out;
        }
        .payment-methods img:hover {
            transform: scale(1.1);
            box-shadow: 0px 0px 12px rgba(0, 191, 255, 0.9); /* Electric Blue Glow */
        }
        .footer-bottom {
            margin-top: 30px;
            font-size: 14px;
            color: #001f3f;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>Sagar Medico</h3>
                <p>
                    <a href="https://maps.app.goo.gl/XNQ8dXodypda9goS7" target="_blank" style="color: inherit; text-decoration: none;">
                        <i class="fas fa-map-marker-alt"></i> Sagar Medical, Ozarde, Tal Wai, Dist Satara, 415803
                    </a>
                </p>
                <div class="working-hours">
                    <h3>Working Hours</h3>
                    <p>Open 24 Hours, 7 Days a Week</p>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="FAQs.php">FAQs</a></li>
                    <li><a href="order_tracking.php">Order Tracking</a></li>
                    <li><a href="terms_conditions.php">Terms & Conditions</a></li>
                    <li><a href="privacy_policy.php">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Help & Support</h3>
                <p><i class="fas fa-phone"></i> +91 9518590420</p>
                <!-- <p><i class="fas fa-envelope"></i> support@sagarmedico29.com</p> -->
                <p><i class="fas fa-envelope"></i> <a href="mailto:sagarmedico@example.com" style="color: black;">sagarmedico29@example.com</a></p>
            </div>
            <div class="footer-column">
                <h3>Stay Connected</h3>
                <p>Enter your email to receive updates & discounts.</p>
                <!-- Subscribe Box -->
<div class="subscribe-box">
    <input type="email" id="newsletter-input" placeholder="Your Email">
    <button onclick="subscribeNewsletter()">SUBMIT</button>
</div>
<p id="success-message" style="color: green; font-weight: bold; display: none; margin-top: 10px;"></p>

                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://wa.me/919518590430" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
                <div class="payment-methods">
                    <img src="images/visa.svg" alt="Visa">
                    <img src="images/MasterCard_Logo.svg" alt="Mastercard">
                    <img src="images/paypal.svg" alt="PayPal">
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Sagar Medico. All rights reserved.</p>
        </div>
    </footer>
    <!-- JavaScript Code -->
    
<script>
    function subscribeNewsletter() {
        var emailInput = document.getElementById("newsletter-input").value;
        var messageBox = document.getElementById("success-message");

        if (emailInput.trim() === "") {
            messageBox.style.color = "red";
            messageBox.innerHTML = "⚠️ Please enter your email before submitting!";
            messageBox.style.display = "block";

            setTimeout(() => {
                messageBox.style.display = "none";
            }, 2000); // Message disappears after 3 seconds
        } else {
            messageBox.style.color = "green";
            messageBox.innerHTML = "🎉 Great choice! You're now part of our community. Stay tuned for exclusive updates! ✨📩";
            messageBox.style.display = "block";

            document.getElementById("newsletter-input").value = ""; // Clear input field

            setTimeout(() => {
                messageBox.style.display = "none";
            }, 3000); // Message disappears after 5 seconds
        }
    }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Subscription Plans</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .wrapper {
    display: flex;
    max-width: 1200px;
    width: 100%;
    gap: 30px;
    margin-left: 130px; /* Move wrapper slightly to the right */
}


        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
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
            flex-grow: 1;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .plans-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .plan {
            background: white;
            color: #333;
            padding: 20px;
            border-radius: 15px;
            width: 280px;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease-in-out;
        }
        .plan:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
        }
        /* Plan Title Color */
.plan h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #0077b6 ;/* Changed to blue */
}

/* Price Color */
.price {
    font-size: 22px;
    font-weight: bold;
    color: #005f8e; /* Changed to Dark Red */
    margin-bottom: 15px;
}

/* Buttons */
.btn {
    display: inline-block;
    background: #0077b6;
    color: white; /* Ensuring button text remains white */
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    margin-top: 15px;
    transition: 0.3s;
}
.btn:hover {
    background: #005f8e;
    transform: scale(1.05);
}

        .features {
            list-style: none;
            padding: 0;
            text-align: left;
            font-size: 14px;
        }
        .features li {
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
        }
        .features li::before {
            content: "✔";
            color: #333;
            font-weight: bold;
            position: absolute;
            left: 0;
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

        /* Responsive */
        @media (max-width: 1024px) {
            .wrapper {
                flex-direction: column;
                align-items: center;
            }
            .sidebar {
                width: 100%;
                text-align: center;
            }
            .plans-container {
                justify-content: center;
            }
            .back-button {
                right: 10px; /* Adjust for smaller screens */
            }
        }
    </style>
</head>
<body>

    <a href="home.php" class="back-button">← Back to Home</a>

    <div class="wrapper">
        <div class="sidebar">
            <h3>My Account</h3>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="my_orders.php">Orders</a></li>
                <!-- <li><a href="wishlist.php">Wishlist</a></li> -->
                <li><a href="settings.php">Settings</a></li>
                <li class="active"><a href="subscribe.php">Subscriptions Plans</a></li>
                <li><a href="help.php">Help & Support</a></li>
                <li><a href="account_actions.php">Account Actions</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <h1>Choose Your Medicine Subscription Plan</h1>
            <div class="plans-container">
                <div class="plan">
                    <h2>Basic Plan</h2>
                    <p class="price">₹499 / Month</p>
                    <ul class="features">
                        <li>📦 Monthly Medicine Delivery</li>
                        <li>❌ No Discount on Medicines</li>
                        <li>📞 Standard Customer Support</li>
                        <li>👨‍⚕️ Basic Health Consultation</li>
                    </ul>
                    <a href="subscription_form.html?plan=basic" class="btn">Get Started</a>
                </div>
                <div class="plan">
                    <h2>Standard Plan</h2>
                    <p class="price">₹999 / Month</p>
                    <ul class="features">
                        <li>📦 Bi-Weekly Medicine Delivery</li>
                        <li>💰 10% Discount on Medicines</li>
                        <li>⚡ Priority Customer Support</li>
                        <li>🩺 Monthly Doctor Consultation</li>
                    </ul>
                    <a href="subscription_form.html?plan=standard" class="btn">Subscribe Now</a>
                </div>
                <div class="plan">
                    <h2>Premium Plan</h2>
                    <p class="price">₹1,999 / Month</p>
                    <ul class="features">
                        <li>📦 Weekly Medicine Delivery</li>
                        <li>💰 20% Discount on Medicines</li>
                        <li>⏳ 24/7 Priority Support</li>
                        <li>👨‍⚕️ Unlimited Doctor Consultation</li>
                        <li>🩺 Free Health Checkups</li>
                    </ul>
                    <a href="subscription_form.html?plan=premium" class="btn">Upgrade Now</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

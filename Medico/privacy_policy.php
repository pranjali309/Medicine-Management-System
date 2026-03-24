<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Sagar Medico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            /* font-family: 'Poppins', sans-serif; */
            font-family: 'Arial', sans-serif;
            background: #eef2f7;
            color: #333;
            /* text-align: center; */
            padding: 50px 10px;
        }
        /* .container {
            max-width: 900px; 
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        } */
        .brand-name {
            font-size: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #004085;
            margin-bottom: 5px;
        }
        .small-heading {
            font-size: 22px;
            font-weight: 500;
            text-transform: uppercase;
            color: #FFB800;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        h3 {
            color: #004085;
            margin-top: 20px;
            font-size: 24px;
            font-weight: 600;
            text-align: left;
        }
        /* p, ul {
            font-size: 16px;
            line-height: 1.8;
            text-align: left;
            color: #333;
        }
        ul {
            padding-left: 20px;
        }
        ul li {
            margin: 8px 0;
        }
        a {
            color: #FFB800;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        } */
        .last-updated {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        /* navbar */
.navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
       
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
.bg-light {
    width: 100%;
}
.main{
     max-width: 900px; 
             margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 6%;
            margin-bottom: 4%;
}


    </style>
</head>
<body>
<!-- Navbar -->
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
                <li class="nav-item"><a class="nav-link active" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="product_page1.php">Product</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
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
<div class="main">
<div class="container">
    <h1 class="brand-name">Sagar Medico</h1>
    <h2 class="small-heading">Privacy & Policy</h2>

    <h3>📜 Introduction</h3>
    <p>Welcome to *Sagar Medico*. Your privacy is important to us.  
    This policy explains how we collect, use, protect, and share your personal information.  
    By using our website, you agree to the terms outlined below.</p>

    <h3>1. Information We Collect</h3>
    <ul>
        <li>👤 *Personal Data:* Name, Email, Phone Number, Address</li>
        <li>💳 *Payment Data:* Securely processed via Razorpay, Stripe, PayPal</li>
        <li>📦 *Order Data:* Purchase history, order tracking details</li>
        <li>🌐 *Technical Data:* IP Address, Browser Type, Cookies</li>
        <li>🎯 *Marketing Data:* Newsletter preferences, promotional offers</li>
    </ul>

    <h3>2. How We Use Your Data</h3>
    <ul>
        <li>🛒 *Order Processing & Delivery*</li>
        <li>📩 *Sending Notifications & Offers*</li>
        <li>🔐 *Fraud Prevention & Security*</li>
        <li>📊 *Improving User Experience & Personalization*</li>
        <li>🔔 *Marketing & Promotions (Only with Consent)*</li>
    </ul>

    <h3>3. Data Retention Policy</h3>
    <p>We retain personal data only as long as necessary:</p>
    <ul>
        <li>🛍 *Order Data:* Stored for 3 years for order history and customer support.</li>
        <li>💳 *Payment Details:* Not stored on our servers.</li>
        <li>🔔 *Marketing Data:* Stored until you opt-out.</li>
    </ul>

    <h3>4. How We Protect Your Information</h3>
    <ul>
        <li>🔒 *SSL Encryption* for secure transactions</li>
        <li>🚫 *No Storage of Card Details* (We use tokenization for security)</li>
        <li>🛡 *Regular Security Audits* to prevent breaches</li>
    </ul>

    <h3>5. Data Breach Policy</h3>
    <p>If a data breach occurs, we will:</p>
    <ul>
        <li>📢 Notify affected users within 72 hours.</li>
        <li>🛡 Work with security experts to fix vulnerabilities.</li>
        <li>⚖ Comply with legal requirements for data protection.</li>
    </ul>

    <h3>6. International Data Transfers</h3>
    <p>We may transfer your data outside India for secure processing, always ensuring GDPR compliance.</p>

    <h3>7. User Consent & Preferences</h3>
    <p>You have full control over your data:</p>
    <ul>
        <li>📑 *Request a copy* of your personal data</li>
        <li>✏ *Edit or update* your information</li>
        <li>🚫 *Request account deletion*</li>
        <li>🔕 *Opt-out of marketing emails* anytime</li>
    </ul>

    <h3>8. Contact Us</h3>
    <p>📧 Email: <a href="mailto:support@sagarmedico.com">support@sagarmedico.com</a></p>
    <p>📞 Phone: +91 9876543210</p>
    <p>🏢 Address: Sagar Medico, Ozarde, Tal Wai, Dist Satara, 415803</p>

    <p class="last-updated">📅 Last Updated: <b>March 2025</b></p>
</div>
</div>
<!-- footer -->
<?php include("footer.php"); ?>
</body>
</html>
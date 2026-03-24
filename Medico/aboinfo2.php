<?php 
session_start();
include('../includes/db.php');
// Check if user is logged in
$profile_photo = "uploads/default.png"; // Default image
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT profile_photo FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!empty($user['profile_photo'])) {
        $profile_photo = $user['profile_photo']; // Set user profile photo
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Medical Shop Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* General Page Styles */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #74ebd5, #acb6e5);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    /* height: 100vh; */
    /* height: 100%; */
}
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

/* 3D Container */
.container-main {
    width: 90%;
    max-width: 1000px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
    transition: transform 0.3s ease-in-out;
    margin-top: 10%;
}

/* Header */
header h1 {
    font-size: 28px;
    text-transform: uppercase;
    color: #fff;
    text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
}

header p {
    font-size: 18px;
    color: #f1f1f1;
}

/* 3D Article Sections */
.article {
    background: rgba(255, 255, 255, 0.3);
    padding: 15px;
    margin: 15px 0;
    border-radius: 10px;
    box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

/* Hover Effect for 3D Lift */
.article:hover {
    transform: translateY(-10px);
    box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.3);
}

/* Contact Section */
.contact {
    background: rgba(0, 0, 0, 0.1);
    padding: 15px;
    border-radius: 10px;
    color: #fff;
    transition: transform 0.3s ease-in-out;
}

/* Hover Effect for Contact Section */
.contact:hover {
    transform: translateY(-10px);
    box-shadow: 5px 5px 30px rgba(255, 255, 255, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 15px;
    }
}
.video-container {
    width: 60%;
    height: 30%;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

video {
    width: 100%;
    border-radius: 8px;
}

.controls {
    margin-top: 10px;
}

button {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
}

button:hover {
    background: #0056b3;
}
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
    <div class="d-flex align-items-center me-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="d-flex align-items-center text-decoration-none">
                        <img src="<?php echo $profile_photo; ?>" alt="Profile Photo" class="rounded-circle" width="40" height="40">
                        
                    </a>
                <?php else: ?>
                  
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

    
    <div class="container-main">
        <header>
            <h1>Welcome to Sagar Medico</h1>
            <p>Your Trusted Medical Store</p>
        </header>
        <div class="video-container">
        <video id="myVideo">
            <source src="images\abo1.mp4" type="video/mp4">
            
        </video>

        <div class="controls">
            <button onclick="playVideo()">▶ Play</button>
            <button onclick="pauseVideo()">⏸ Pause</button>
        </div>
        <script>
        var video = document.getElementById("myVideo");

        function playVideo() {
            video.play();
        }

        function pauseVideo() {
            video.pause();
        }
    </script>
    </div>

        <div class="article">
            <h2>About Us</h2>
            <p>Sagar Medico is your one-stop destination for all your healthcare needs. We provide a wide range of pharmaceutical products, wellness essentials, and medical equipment to ensure you and your family stay healthy.</p>
        </div>

        <div class="article">
            <h2>Our Products & Services</h2>
            <ul>
                <li>✔ Prescription Medicines</li>
                <li>✔ Over-the-Counter (OTC) Medicines</li>
                <li>✔ Healthcare & Wellness Products</li>
                <li>✔ Medical Equipment</li>
                <li>✔ Baby Care & Hygiene Products</li>
            </ul>
        </div>

        <!-- <div class="contact">
            <h2>Contact Us</h2>
            <p>📍 Address: [Your Shop Address]</p>
            <p>📞 Phone: [Your Contact Number]</p>
            <p>📧 Email: [Your Email Address]</p>
        </div> -->
        <?php include("footer.php"); ?>
    </div>

    <script src="script.js"></script>
    <!-- <script>
        // Add a small rotation effect on mouse move
document.querySelector('.container').addEventListener('mousemove', (e) => {
    let x = (window.innerWidth / 2 - e.pageX) / 20;
    let y = (window.innerHeight / 2 - e.pageY) / 20;
    e.target.style.transform = rotateY(${x}deg) rotateX(${y}deg);
});

// Reset rotation on mouse leave
document.querySelector('.container').addEventListener('mouseleave', (e) => {
    e.target.style.transform = "rotateY(0deg) rotateX(0deg)";
});

    </script> -->
    <!-- footer -->
 <!--  -->
    
</body>
</html>
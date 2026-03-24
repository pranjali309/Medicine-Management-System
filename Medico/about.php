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
    <title>About Us - Sagar Medico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins';
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
        .carousel-caption {
            /* position: relative; */
            text-align: center;
            color: white;
            /* background: url('images/pharmacy-bg.jpg') no-repeat center center/cover;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center; */
            margin-top: 220%;
        }
        .carousel-caption h1 {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }
        .carousel-caption p {
            /* font-size: 3rem; */
            font-weight: bold;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
        }
        .card:hover {
            transform: scale(1.05);
            transition: 0.3s;
        }
        .footer {
            background: #87CEEB;
            color: white;
            text-align: center;
            padding: 20px;
        }
        @media (min-aspect-ratio:16/9) {
    .background-clip{
        width: 100%;
        height: auto;
    }
}

@media (max-aspect-ratio:16/9) {
    .background-clip{
        width: auto;
        height: 100%;
    }
} 
    .about-img img{
             
              border-radius:10px ;
              
            }
    </style>
</head>
<body>
<div class="container-main ">
      <video autoplay loop muted plays-inline class="background-clip">
        <source src="images\v1.mp4" type="video/mp4">
      </video>
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
    <div>
    <div class=" carousel-caption ">      
      <h1><b>About Sagar Medico</b></h1>
      <p>"Health is a priceless wealth Invest while you can..."</p>
    </div>
  </div>
    <!-- Hero Section -->
    <!-- <section class="hero-section">
        <div>
            <h1>About Sagar Medico</h1>
            <p>Your Trusted Pharmacy for Quality Medicines</p>
        </div>
    </section> -->

    <!-- Our Mission -->
    <section class="container py-5">
        <h2 class="text-center mb-4">Our Mission</h2>
        <p class="text-center"><b>We are dedicated to providing high-quality, affordable, and authentic medicines with fast delivery and expert advice.</b></p>
        <div class="row">
      <div class="col-lg-4 col-md-12 col-12">
        <div class="about-img">
          <!-- <img src="images\ph2.jpg" alt="" class="img-fluid"> -->
          <video autoplay loop muted plays-inline class="background-clip">
        <source src="images/Ab1.mp4" type="video/mp4">
      </video>
        </div>
      </div>
      <div class="col-lg-8 col-md-12 col-12 ps-lg-5 ">
        <div class="about-text">
          <!-- <h2>We Provide Best Quality</h2> -->
          <p>Best Quality Products – We offer only genuine and certified medicines from trusted pharmaceutical brands.<br>
 Wide Range of Medicines – From prescription drugs to over-the-counter medications, we have everything you need.<br>
 Affordable Pricing – Competitive prices with special discounts for regular customers.<br>
 Expert Advice – Our trained pharmacists are available to guide you with the right medications and health tips.<br>
 Home Delivery – Convenient and fast home delivery services for your ease.<br>
 Hygienic & Well-Stocked – A clean, well-maintained store with a fresh stock of medicines.<br>
          </p>
          <a href="AbInfo.php" class="btn btn-warning">Learn More</a>
        </div>
      </div>
    </div>
    </section>

    <!-- Why Choose Us -->
    <section class="container text-center py-5">
        <h2>Why Choose Us?</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <i class="bi bi-truck fs-1 text-primary"></i>
                    <h4>Free & Fast Delivery</h4>
                    <p>Get your medicines delivered quickly at no extra cost.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <i class="bi bi-heart-pulse fs-1 text-danger"></i>
                    <h4>Trusted Medicines</h4>
                    <p>We provide only certified and high-quality pharmaceuticals.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <i class="bi bi-shield-check fs-1 text-success"></i>
                    <h4>100% Secure</h4>
                    <p>Your health is our priority, with secure and reliable services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Testimonials -->
    <section class="container py-5">
        <h2 class="text-center mb-4">What Our Customers Say</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <p>"Fast delivery and authentic medicines! Highly recommended."</p>
                    <h5 class="text-end">- Rahul S.</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <p>"Excellent customer support and affordable pricing."</p>
                    <h5 class="text-end">- Priya M.</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <p>"Best pharmacy with a great range of medicines and health products."</p>
                    <h5 class="text-end">- Anjali K.</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include("footer.php"); ?>
   </div> 
</body>
</html>
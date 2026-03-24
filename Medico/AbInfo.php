<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remote Tech Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
            /* body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        } */
        *{
    margin: 0;
    padding: 0;
	box-sizing: border-box;
    font-family: 'Poppins';
}  
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
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
        .post-job {
            background-color: #007bff;
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .post-job:hover {
            transform: translateY(-3px);
        }
       
        .categories {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        .category {
            background: #fff;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .category:hover {
            transform: scale(1.1);
        }
        .job-category {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .job-card {
            background: #eef3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .job-card:hover {
            transform: translateY(-3px);
        }
        .badge {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }
        .newsletter {
            text-align: center;
            background: #0056b3;
            color: white;
            padding: 30px;
            box-shadow: 0 -10px 20px rgba(0, 0, 0, 0.2);
        }
        .newsletter input {
            padding: 15px;
            width: 250px;
            border: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .newsletter button {
            padding: 15px 20px;
            border: none;
            background-color: #ffcc00;
            color: #333;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }
        .newsletter button:hover {
            transform: translateY(-3px);
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #fff;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
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
#blog {
    background-color: #f8f9fa;
    padding: 40px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

#blog h2 {
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 10px;
}

#blog p {
    font-size: 16px;
    color: #555;
    margin-bottom: 15px;
}

#blog a {
    display: inline-block;
    font-size: 16px;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease-in-out;
}

#blog a:hover {
    color: #0056b3;
    text-decoration: underline;
}
#faq {
    background-color: #f9f9f9;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

#faq h2 {
    font-size: 26px;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
}

#faq p {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 10px;
}

#faq p strong {
    color: #333;
    font-size: 18px;
    display: block;
    margin-top: 15px;
}
#carouselExampleSlidesOnly {
    max-width: 800px; /* Adjust width as needed */
    margin: 20px auto; /* Centering the carousel */
    border-radius: 10px; /* Soft rounded edges */
    overflow: hidden; /* Ensures images don't overflow */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    perspective: 1000px; /* Adds depth for 3D effect */
}

.carousel-inner {
    display: flex;
    transform-style: preserve-3d; /* Enables 3D transformations */
}

.carousel-item {
    transition: transform 1s ease-in-out;
    transform: rotateY(15deg) scale(1.05); /* Slight rotation for 3D look */
}

.carousel-item.active {
    transform: rotateY(0deg) scale(1); /* Center image appears normal */
}

.carousel-inner img {
    height: 400px; /* Adjust height as needed */
    object-fit: cover; /* Ensures images cover the area without distortion */
    border-radius: 10px;
    transition: transform 0.5s ease-in-out;
}

/* Optional: Add shadow to make it pop */
.carousel-item.active img {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
}
/* Section Styling */
.info-section {
    text-align: center;
    padding: 60px 20px;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.container {
    max-width: 1000px;
    margin: auto;
}

h2 {
    font-size: 32px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.intro-text {
    font-size: 18px;
    color: #555;
    margin-bottom: 40px;
}

/* Info Boxes */
.info-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.info-box {
    background: #fff;
    padding: 20px;
    width: 30%;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.info-box:hover {
    transform: scale(1.05);
}

.info-box img {
    width: 100%;
    height: 180px;
    border-radius: 10px;
    object-fit: cover;
}

h3 {
    font-size: 22px;
    margin-top: 15px;
    color: #007bff;
}

.info-box p {
    font-size: 16px;
    color: #666;
    margin-top: 10px;
}

/* FontAwesome Icons */
h3 i {
    margin-right: 10px;
    color: #28a745;
}

/* Responsive Design */
@media (max-width: 900px) {
    .info-content {
        flex-direction: column;
        align-items: center;
    }

    .info-box {
        width: 80%;
        margin-bottom: 20px;
    }
}
.about-img img{
             
             border-radius:10px ;
             
           }
           .about-text{
            font-size: 130%;
           }
           
    </style>
</head>
<body>
<div class="container-main ">
      <video autoplay loop muted plays-inline class="background-clip">
        <source src="images/Ab1.mp4" type="video/mp4">
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
<section class="container py-5">
        <h2 class="text-center mb-4"><b>Welcome to Sagar Medico: Your Trusted Medical Shop</b></h2>
        <!-- <p class="text-center"><b>We are dedicated to providing high-quality, affordable, and authentic medicines with fast delivery and expert advice.</b></p> -->
        <div class="row">
      <div class="col-lg-4 col-md-12 col-12">
        <div class="about-img">
          <img src="images\ph2.jpg" alt="" class="img-fluid">
        </div>
      </div>
      <div class="col-lg-8 col-md-12 col-12 ps-lg-5 ">
        <div class="about-text">
          <!-- <h2>We Provide Best Quality</h2> -->
          <p>Sagar Medico is your one-stop destination for all your healthcare needs.
           We provide a wide range of pharmaceutical products, wellness essentials, and medical equipment to ensure you and your family stay healthy. 
           Our mission is to deliver high-quality medicines and healthcare products with convenience and affordability.
           We also offer expert consultation services to guide customers in selecting the right medications and health products.
          </p>
          <!-- <a href="AbInfo.php" class="btn btn-warning">Learn More</a> -->
        </div>
      </div>
    </div>
    </section>
<section id="blog">
        <h2>Health Blog</h2>
        <p>Stay updated with the latest health tips and medical news.</p>
        <p><a href="aboinfo2.php">Read Our Latest Articles</a></p>
    </section>
<div>
    <div class=" carousel-caption ">      
    <h1><b>About Us</b></h1>
        <p>Sagar Medico is dedicated to providing high-quality medicines and healthcare services to ensure a healthier community.</p>
        <p>We have been serving our customers with trust and care for over a decade.</p>a priceless wealth Invest while you can..."</p>
    </div>
  </div>
 
   
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
  
    <div class="carousel-item active">
      <img src="images/abo1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/pho3.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item ">
      <!-- <img src="images/pho1.jpg" class="d-block w-100" alt="..."> -->
      <video autoplay loop muted plays-inline class="background-clip">
        <source src="images\abo2.mp4" type="video/mp4">
      </video>
    </div>
  </div>
</div>

    <section class="categories">
        <div class="category">Android</div>
        <div class="category">Angular</div>
        <div class="category">AWS</div>
        <div class="category">Back-End</div>
        <div class="category">Blockchain</div>
    </section>
    <section id="faq">
        <h2>Frequently Asked Questions</h2>
        <p><strong>How can I order medicines online?</strong></p>
        <p>You can browse our products, add them to your cart, and place an order through our website.</p>
        <p><strong>Do you provide home delivery?</strong></p>
        <p>Yes, we offer home delivery services in select locations.</p>
    </section>
    <section class="info-section">
        <div class="container">
            <h2>About Our Services</h2>
            <p class="intro-text">We provide high-quality healthcare products and services. Learn more about our offerings below.</p>
            
            <div class="info-content">
                <div class="info-box">
                    <img src="images\ph1.jpg" alt="Service 1">
                    <h3><i class="fas fa-pills"></i> Online Pharmacy</h3>
                    <p>Order medicines online and get them delivered to your doorstep quickly.</p>
                </div>
                
                <div class="info-box">
                    <img src="images\pho3.jpg" alt="Service 2">
                    <h3><i class="fas fa-truck-medical"></i> Home Delivery</h3>
                    <p>Fast and secure medicine delivery to ensure you never run out of essentials.</p>
                </div>

                <div class="info-box">
                    <img src="images\ph2.jpg" alt="Service 3">
                    <h3><i class="fas fa-user-md"></i> 24/7 Consultation</h3>
                    <p>Consult with professional doctors anytime via our platform.</p>
                </div>
            </div>
        </div>
    </section>
    <?php include("footer.php"); ?>
    
</body>
</html>
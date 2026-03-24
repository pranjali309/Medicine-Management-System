<?php 

include 'header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
      *{
        font-family: montserrat;
      }
      body{
        background: flfbff;
      }
      .section-padding{
        padding: 100px 0;
      }
      .carousel-item{
        height: 100vh;
        min-height: 300px;
      }
      .carousel-caption{
        bottom: 220px;
        z-index: 2;
      }
      .carousel-caption h5{
        font-size: 45px;
       
        letter-spacing: 2px;
        margin-top: 25px;
      
      }
      .carousel-caption p{
        width: 60%;
        margin: auto;
        font-size: 18px;
        line-height: 1.9;
      }
      .carousel-inner::before{
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
      }
      /* .navbar-nav a{
        font-size: 15px;
        text-transform: uppercase;
        font-weight: 500;
      }
      .navbar-light .navbar-brand{
        color: #000;
        font-size: 25px;
        
        font-weight: 700;
        letter-spacing: 2px;
      }
      
      .w-100{
        height: 100vh;
      }
      .nav-link:hover {
            color:rgb(36, 179, 241) !important;
        } */
        
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
                    <!-- <a href="login.php" class="btn btn-primary"></a> -->
                <?php endif; ?>
            </div>
        <a class="navbar-brand" href="home.php"><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link " href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link " href="product_page1.php">Product</a></li>
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
<div id="carouselExampleAutomaticCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
    <button type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
  </div>
  <div class="carousel-inner" style="border-radius:19px;">
    <div class="carousel-item active">
      <img src="images\img1.avif" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
      <h5><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></h5>
      <p><a href="login.php" class="btn btn-warning">Shop Now</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/imge2.jpg" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
      <h5><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></h5>
        <p><a href="login.php" class="btn btn-warning">Shop Now</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\img5.jpg" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
      <h5><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></h5>
        <p><a href="login.php" class="btn btn-warning">Shop Now</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\img6.webp" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
      <h5><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></h5>
        <p><a href="login.php" class="btn btn-warning">Shop Now</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\imge3.jpg" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
      <h5><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></h5>
        <p><a href="login.php" class="btn btn-warning">Shop Now</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\imge4.jpg" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
      <h5><b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b></h5>
        <p><a href="login.php" class="btn btn-warning">Shop Now</a></p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutomaticCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
  <div class="card " >
  <img src="images\pho1.jpg" class="card-img" alt="..." style="border-radius:130px;padding:50px;">
  <div class="card-img-overlay" style="text-align:center; margin-top: 298px; font-size:large;">
  <p ><a href="contact.php" class="btn btn-warning" style="font-size:17px;"><i class="bi bi-telephone-fill"></i>   Call us and Order</a></p>
  <h5 style="color:black; font-size:190%;"> Working 24 Hours</h5>
  </div>
</div>
  <main>
  <div id="carouselExampleDark" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4" aria-label="Slide 5"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="5" aria-label="Slide 6"></button>
  </div>
  <div class="carousel-inner">
  <div class="carousel-item" data-bs-interval="2000">
      <img src="images\back.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5><i>What our customers have to say</i></h5>
      <br>
      <br>
        <h1>Used the app and found it easy to use</h1>
        <p>Excellent app. Have used this regularly and found it very easy to use. All info is readily available and the response after order placement for validation of medicines required was prompt</p>
      </div>
    </div>
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="images\back.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5><i>What our customers have to say</i></h5>
      <br>
      <br>
        <h1>Doctors are very professional and customer friendly</h1>
        <p>Perfect. The more I use this app, the more I fall in love with it. Doctors are very professional and customer friendly.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="images\back.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5><i>What our customers have to say</i></h5>
      <br>
      <br>
        <h1>Best , Very customer friendly app by nature</h1>
        <p>Truemeds is the best... during the Lockdown, this app does not reduce the discount, which shows the customer-friendly nature of the sagar medico. Thank You!!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\back.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5><i>What our customers have to say</i></h5>
      <br>
      <br>
        <h1>Truly Affordable</h1>
        <p>Affordable medicines on this app. Truemeds is true.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="images\back.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5><i>What our customers have to say</i></h5>
      <br>
      <br>
        <h1>App shows affordable substitutes which is really appreciable.</h1>
        <p>I found the app very useful and easy to use, when anyone adds medicine it also shows affordable substitutes which is really appreciable. Very few companies really care for customer like Trumeds.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="images\back.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5><i>What our customers have to say</i></h5>
      <br>
      <br>
        <h1>Could upload prescriptions easily</h1>
        <p>Loved the experience of ordering medicines from TrueMeds. Great UX and could upload prescriptions easily. The doctor called within 15 mins to confirm and suggest substitutes. Very prompt and professional, keep it up.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
 </main> 
 <!-- footer -->
 <?php include("footer.php"); ?>
</body>
</html>






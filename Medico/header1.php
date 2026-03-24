<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/db.php');

// Default profile image
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * {
            font-family: Montserrat, sans-serif;
        }

        .navbar {
            background: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .navbar-nav .nav-link {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
            color: black;
        }

        .navbar-nav .nav-link:hover {
            color: rgb(36, 179, 241);
        }

        .profile-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: #fff;
        }

        .btn i {
            font-size: 20px;
            color: black;
        }

        .btn i:hover {
            color: #007bff;
        }

        .navbar-toggler {
            border: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container">
    <div class="d-flex align-items-center me-4">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="profile.php" class="d-flex align-items-center text-decoration-none">
          <img src="<?php echo $profile_photo; ?>" alt="Profile Photo" class="profile-photo">
        </a>
      <?php endif; ?>
    </div>
    <a class="navbar-brand" href="home.php">
      <b><sup style="color:black;">Sagar<i class="bi bi-heart-pulse-fill"></i></sup></b><b class="text-warning">Medico</b>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active btn-outline-secondary" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link active" href="product_page1.php">Product</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
      </ul>
      <form class="d-flex" action="product_page1.php" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" required>
        <button class="btn btn-outline-success me-2" type="submit">Search</button>
      </form>
      <a href="wishlist.php" class="btn"><i class="bi bi-suit-heart-fill text-danger"></i></a>
      <a href="cart.php" class="btn"><i class="bi bi-cart-fill"></i></a>
      <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>">
        <i class="bi bi-person-fill"></i>
      </a>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

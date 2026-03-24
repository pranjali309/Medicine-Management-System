<?php
session_start();
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Profile photo upload handling
    $profile_photo = NULL;
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if not exists
        }
        $profile_photo = $target_dir . time() . "_" . basename($_FILES["profile_photo"]["name"]);
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $profile_photo);
    }

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone, address, profile_photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $email, $password, $phone, $address, $profile_photo);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['address'] = $address;
            $_SESSION['profile_photo'] = $profile_photo;
            header("Location: profile.php");
            exit();
        } else {
            $error = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Global Styles */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #fdfbfb, #ebedee);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Form Container */
.form-container {
    background: rgba(255, 255, 255, 0.7);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    width: 400px;
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.form-container:hover {
    transform: scale(1.03);
}

/* Form Header */
h2 {
    color: #333;
    margin-bottom: 15px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

/* Input Fields */
label {
    font-weight: bold;
    display: block;
    text-align: left;
    margin: 10px 0 5px;
    color: #555;
}

input, textarea {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.8);
    color: #333;
    outline: none;
    box-shadow: inset 3px 3px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

input:focus, textarea:focus {
    background: rgba(255, 255, 255, 1);
    box-shadow: inset 4px 4px 10px rgba(0, 0, 0, 0.15);
}

/* Profile Photo Upload */
.profile-photo-label {
    font-weight: bold;
    display: block;
    text-align: left;
    margin: 10px 0 5px;
    color: #555;
}

.profile-photo-input {
    display: block;
    width: 100%;
    padding: 8px;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Button Styling */
.btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #81d4fa, #4fc3f7);
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.15);
}

.btn:hover {
    background: linear-gradient(135deg, #4fc3f7, #29b6f6);
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Error Message */
.error {
    color: #e57373;
    font-weight: bold;
    background: rgba(255, 0, 0, 0.1);
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 10px;
}

/* Login Link */
p {
    color: #555;
    margin-top: 10px;
    font-size: 14px;
}

p a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

p a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <h2>Register</h2>

            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Phone:</label>
            <input type="text" name="phone" required>

            <label>Address:</label>
            <textarea name="address" required></textarea>

            <label>Profile Photo:</label>
            <input type="file" name="profile_photo" accept="image/*">

            <button type="submit" class="btn">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
<?php
session_start();
include('../includes/db.php'); // Database connection

$error = ""; // Error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Check in users table
        $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];

                 // ✅ Update last_login field
                 $updateLogin = "UPDATE users SET last_login = NOW() WHERE user_id = ?";
                 $stmt = $conn->prepare($updateLogin);
                 $stmt->bind_param("i", $user['user_id']);
                 $stmt->execute();

                 
                header("Location: profile.php"); // Redirect to User Profile
                exit();
            }
        }

        // Check in admin table
        $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE email = ?");

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_name'] = $admin['username'];
                header("Location: ../admin_area/index3.php"); 
                exit();
                
            }
        }

        $error = "Invalid email or password!";
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 { color: #333; margin-bottom: 15px; }
        .input-group {
            position: relative;
            margin: 15px 0;
        }
        .input-group input {
            width: 80%;
            padding: 12px 40px 12px 12px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
        }
        .input-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            cursor: pointer;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #81c784, #66bb6a);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .error {
            color: #e57373;
            font-weight: bold;
            background: rgba(255, 0, 0, 0.1);
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

        <form action="login.php" method="post">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p><a href="forgot_password.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
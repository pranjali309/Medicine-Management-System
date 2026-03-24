<?php
session_start();
include('../includes/db.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update password in the database
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
            $stmt->bind_param("ss", $hashed_password, $email);

            if ($stmt->execute()) {
                $message = "Password updated successfully!";
                echo "<script>
                        alert('Password updated successfully!');
                        window.location.href = 'login.php';
                      </script>";
                exit();
            } else {
                $message = "Error updating password!";
            }
        } else {
            $message = "Passwords do not match!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.03);
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .input-group {
            margin: 12px 0;
            text-align: left;
        }
        .input-group label {
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 5px;
            outline: none;
            background: #f9f9f9;
        }
        .input-group input:focus {
            border-color: #66bb6a;
            box-shadow: 0 0 5px rgba(102, 187, 106, 0.5);
        }
        .error {
            color: #e57373;
            font-weight: bold;
            background: rgba(255, 0, 0, 0.1);
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .success {
            color: #388e3c;
            font-weight: bold;
            background: rgba(56, 142, 60, 0.1);
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #81c784, #66bb6a);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        button:hover {
            background: linear-gradient(135deg, #66bb6a, #4caf50);
            transform: translateY(-2px);
        }
        p {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if (!empty($message)) {
            $class = strpos($message, "successfully") !== false ? "success" : "error";
            echo "<p class='$class'>$message</p>";
        } ?>
        <form method="POST">
            <div class="input-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>New Password:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="input-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit">Save</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>

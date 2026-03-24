<?php
include('../includes/dbc_connect.php'); // Database connection

// Get message ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request.");
}

$message_id = intval($_GET['id']);

// Fetch the message details
$sql = "SELECT id, name, message FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();
$stmt->close();

if (!$message) {
    die("Message not found.");
}

// Handle reply submission
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = trim($_POST['reply']);

    if (empty($reply)) {
        $error = "Reply cannot be empty!";
    } else {
        $update_sql = "UPDATE messages SET reply = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $reply, $message_id);
        if ($stmt->execute()) {
            $success = "Reply sent successfully!";
        } else {
            $error = "Database Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .container-main {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container-main">
    <h2 class="text-center">Reply to Message</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">User Name</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($message['name']) ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">User Message</label>
            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($message['message']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Your Reply</label>
            <textarea name="reply" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Reply</button>
    </form>
</div>

</body>
</html>
<?php
session_start();
include('../includes/db.php');

header('Content-Type: application/json');

$response = ["success" => false, "message" => "Something went wrong!"];

if (!isset($_SESSION['user_id'])) {
    $response["message"] = "Please log in first!";
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['action'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $action = $_POST['action'];

    // Get current quantity
    $query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result || $result->num_rows === 0) {
        $response["message"] = "Product not found in cart!";
        echo json_encode($response);
        exit();
    }

    $row = $result->fetch_assoc();
    $current_quantity = $row['quantity'];
    $stmt->close();

    // Get product stock
    $query = "SELECT price, stock_quantity FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $price = $product_data['price'];
    $stock_quantity = $product_data['stock_quantity'];

    // Update quantity based on action
    if ($action === 'increase') {
        if ($current_quantity >= $stock_quantity) {
            $response["message"] = "Cannot add more than available stock!";
            echo json_encode($response);
            exit();
        }
        $new_quantity = $current_quantity + 1;
    } elseif ($action === 'decrease') {
        if ($current_quantity > 1) {
            $new_quantity = $current_quantity - 1;
        } else {
            $response["message"] = "Quantity cannot be less than 1!";
            echo json_encode($response);
            exit();
        }
    } else {
        echo json_encode($response);
        exit();
    }

    // Update cart quantity
    $update_query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
    $stmt->execute();
    $stmt->close();

    // Calculate new total and grand total
    $total_price = $price * $new_quantity;

    $query = "SELECT SUM(p.price * c.quantity) AS grand_total FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $grand_total = $stmt->get_result()->fetch_assoc()['grand_total'];
    $stmt->close();

    $response = [
        "success" => true,
        "quantity" => $new_quantity,
        "total_price" => number_format($total_price, 2),
        "grand_total" => number_format($grand_total, 2)
    ];
}

echo json_encode($response);
?>

<?php
session_start();
include './connect.php';

// Check if the order ID is passed in the URL
if (!isset($_GET['order_id'])) {
    header("Location: index.php"); // Redirect to home if order_id is not provided
    exit;
}

// Retrieve the order ID
$orderId = $_GET['order_id'];

// Check if an order confirmation message exists
$orderConfirmedMessage = isset($_SESSION['order_confirmed']) ? $_SESSION['order_confirmed'] : "";

// Unset the confirmation message after displaying it to avoid resubmission
unset($_SESSION['order_confirmed']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Include your CSS file -->
</head>
<body>

    <!-- Order Confirmation Message -->
    <?php if ($orderConfirmedMessage): ?>
        <div style="text-align: center; padding: 20px; background-color: #4CAF50; color: white; font-size: 18px;">
            <?php echo $orderConfirmedMessage; ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <h2>Your order (ID: <?php echo $orderId; ?>) has been confirmed.</h2>
        <p>Thank you for shopping with us! You will receive an email confirmation soon.</p>
        <a href="index.php">Go to Home Page</a>
    </div>

</body>
</html>

<?php
session_start();
include './connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customQuantity = isset($_POST['customQuantity']) && $_POST['quantity'] === 'custom' ? $_POST['customQuantity'] : $quantity;

    // Add product to cart session
    $_SESSION['cart'][] = [
        'product_id' => $product_id,
        'quantity' => $customQuantity
    ];

    // Return a success response
    echo json_encode(['status' => 'success', 'message' => 'Product added to cart Successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

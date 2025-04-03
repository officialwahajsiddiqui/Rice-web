<?php
session_start();  // Ensure session is started
include './connect.php'; // Ensure the connection file is included

// Check if the cart is set and is an array
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialize as an empty array if not set
}

// Define total amount
$totalAmount = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $productId = $cartItem['product_id'];
        $quantity = $cartItem['quantity'];

        // Query to get product price
        $productQuery = $conn->query("SELECT p_price FROM products WHERE p_id = $productId");
        if ($productQuery->num_rows > 0) {
            $product = $productQuery->fetch_assoc();
            $totalAmount += $product['p_price'] * $quantity;
        }
    }
}

// Example: Delivery charges based on order amount
if ($totalAmount < 5000) {
    if (!empty($_SESSION['cart'])) {
        $deliveryCharges = 250; // Rs. 250 if the total amount is less than Rs. 5000
    } else {
        $deliveryCharges = 0; // Rs. 0 if the cart is empty
    }
} else {
    $deliveryCharges = 200; // Rs. 200 if the total amount is 5000 or more
}

// Process the order when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user details (from session or POST)
    $userName = $_POST['user_name'];
    $userEmail = $_POST['user_email'];
    $userAddress = $_POST['user_address'];
    $userPhone = $_POST['user_phone'];
    $userMessage = $_POST['user_message'];

    // Begin transaction to ensure the order and cart are processed securely
    $conn->begin_transaction();

    try {
        // Insert the order into the orders table
        $stmt = $conn->prepare("INSERT INTO orders (total_amount, name, email, address, phone, message, order_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("dsssss", $totalAmount, $userName, $userEmail, $userAddress, $userPhone, $userMessage);
        $stmt->execute();

        // Get the order ID
        $orderId = $stmt->insert_id;

        // Insert cart items into order_items table
        foreach ($_SESSION['cart'] as $cartItem) {
            $productId = $cartItem['product_id'];
            $quantity = $cartItem['quantity'];

            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $orderId, $productId, $quantity);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();

        // Clear the cart after successful order
        unset($_SESSION['cart']);

        // Set a session variable for the confirmation message
        $_SESSION['order_confirmed'] = "Your order has been placed successfully!";
        header("Location: checkout.php");
        exit;

    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ecommerce, market, shop, mart, cart, deal, multipurpose, marketplace">
    <meta name="description" content="Carrot - Multipurpose eCommerce HTML Template.">
    <meta name="author" content="ashishmaraviya">
    <title>Carrot - Multipurpose eCommerce HTML Template</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/img/logo/favicon.png">
    <!-- Icon CSS -->
    <link rel="stylesheet" href="assets/css/vendor/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/vendor/remixicon.css">
    <!-- Vendor -->
    <link rel="stylesheet" href="assets/css/vendor/animate.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/vendor/aos.min.css">
    <link rel="stylesheet" href="assets/css/vendor/range-slider.css">
    <link rel="stylesheet" href="assets/css/vendor/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/vendor/jquery.slick.css">
    <link rel="stylesheet" href="assets/css/vendor/slick-theme.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="body-bg-6">
    <!-- Loader -->
    <div id="cr-overlay">
        <span class="loader"></span>
    </div>

    <!-- Header -->
    <?php include "Header.php"; ?>

    <!-- Mobile menu -->
    <?php include "components/Mobile_menu.php"; ?>

    <!-- Breadcrumb -->
    <section class="section-breadcrumb">
        <div class="cr-breadcrumb-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cr-breadcrumb-title">
                            <h2>Checkout</h2>
                            <span><a href="index.html">Home</a> - Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Checkout section -->
    <section class="cr-checkout-section padding-tb-100">
        <div class="container">
            <div class="row">
                <?php if (isset($_SESSION['order_confirmed'])): ?>
                    <div style="text-align: center; padding: 20px; background-color: #4CAF50; color: white; font-size: 18px;">
                        <?php echo $_SESSION['order_confirmed']; ?>
                    </div>
                    <?php unset($_SESSION['order_confirmed']); // Clear message after showing it ?>
                <?php endif; ?>

                <!-- Sidebar Area Start -->
                <div class="cr-checkout-rightside col-lg-4 col-md-12">
                    <div class="cr-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="cr-sidebar-block">
    <div class="cr-sb-title">
        <h3 class="cr-sidebar-title">Summary</h3>
    </div>
    <div class="cr-sb-block-content">
        <div class="cr-checkout-summary">
            <div>
                <span class="text-left">Sub-Total</span>
                <span class="text-right">
                    Rs.<?php echo number_format($_SESSION['order_summary']['totalAmount'] ?? $totalAmount, 2); ?>
                </span>
            </div>
            <div>
                <span class="text-left">Delivery Charges</span>
                <span class="text-right">
                    Rs.<?php echo number_format($_SESSION['order_summary']['deliveryCharges'] ?? $deliveryCharges, 2); ?>
                </span>
            </div>
            <div class="cr-checkout-summary-total">
                <span class="text-left">Total Amount</span>
                <span class="text-right">
                    Rs.<?php echo number_format($_SESSION['order_summary']['grandTotal'] ?? ($totalAmount + $deliveryCharges), 2); ?>
                </span>
            </div>
        </div>
        <div class="cr-checkout-pro">
            <?php
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    $productId = $cartItem['product_id'];
                    $quantity = $cartItem['quantity'];

                    $productQuery = $conn->query("SELECT * FROM products WHERE p_id = $productId");
                    $product = $productQuery->fetch_assoc();
                    ?>
                    <div class="col-sm-12 mb-6">
                        <div class="cr-product-inner">
                            <div class="cr-pro-image-outer">
                                <div class="cr-pro-image">
                                    <a href="product-details.php?id=<?php echo $product['p_id']; ?>" class="image">
                                        <img class="main-image" src="<?php echo './uploads/' . $product['p_image']; ?>" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="cr-pro-content cr-product-details">
                                <h5 class="cr-pro-title">
                                    <a href="product-details.php?id=<?php echo $product['p_id']; ?>">
                                        <?php echo $product['p_name']; ?>
                                    </a>
                                </h5>
                                <p class="cr-price">
                                    <span class="new-price">Rs.<?php echo number_format($product['p_price'], 2); ?></span>
                                    <span class="quantity">x <?php echo $quantity; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<p>No items in cart or the order has been processed.</p>";
            } ?>
        </div>
    </div>
</div>

                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
                <!-- Sidebar Area End -->

                <!-- Checkout content Start -->
                <div class="cr-checkout-leftside col-lg-8 col-md-12 m-t-991">
                    <div class="cr-checkout-content">
                        <div class="cr-checkout-inner">
                            <div class="cr-checkout-wrap">
                                <div class="cr-checkout-block cr-check-bill">
                                    <h3 class="cr-checkout-title">Billing Details</h3>
                                    <div class="cr-bl-block-content">
                                        <div class="cr-check-bill-form mb-minus-24">
                                            <form action="" method="post">
                                                <span class="cr-bill-wrap cr-bill-half">
                                                    <label>Name</label>
                                                    <input type="text" name="user_name" placeholder="Enter your name" required>
                                                </span>
                                                <span class="cr-bill-wrap cr-bill-half">
                                                    <label>Email</label>
                                                    <input type="email" name="user_email" placeholder="Enter your email" required>
                                                </span>
                                                <span class="cr-bill-wrap">
                                                    <label>Address</label>
                                                    <input type="text" name="user_address" placeholder="Address Line 1" required>
                                                </span>
                                                <span class="cr-bill-wrap cr-bill-half">
                                                    <label>Phone</label>
                                                    <input type="text" name="user_phone" placeholder="Phone Number" required>
                                                </span>
                                                <span class="cr-bill-wrap cr-bill-half">
                                                    <label>Message (optional)</label>
                                                    <input type="text" name="user_message" placeholder="Message">
                                                </span>
                                                <button type="submit" class="cr-button mt-30">Place Order</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Checkout content End -->
            </div>
        </div>
    </section>
    <!-- Checkout section End -->

    <!-- Footer -->
    <?php include 'Footer.php'; ?>


    <!-- Tab to top -->
    <a href="#Top" class="back-to-top result-placeholder">
        <i class="ri-arrow-up-line"></i>
        <div class="back-to-top-wrap">
            <svg viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
            </svg>
        </div>
    </a>

    <!-- Vendor Custom -->
    <script src="assets/js/vendor/jquery-3.6.4.min.js"></script>
    <script src="assets/js/vendor/jquery.zoom.min.js"></script>
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="assets/js/vendor/mixitup.min.js"></script>
    <script src="assets/js/vendor/range-slider.js"></script>
    <script src="assets/js/vendor/aos.min.js"></script>
    <script src="assets/js/vendor/swiper-bundle.min.js"></script>
    <script src="assets/js/vendor/slick.min.js"></script>

    <!-- Main Custom -->
    <script src="assets/js/main.js"></script>
</body>
</html>

    
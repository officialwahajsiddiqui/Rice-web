<?php
session_start();
include './connect.php'; // Ensure the connection file is included

// Check if cart is empty
$cartEmpty = empty($_SESSION['cart']);
$message = $cartEmpty ? "Your cart is empty." : "";

// Check if a delete request has been made
if (isset($_GET['delete'])) {
    $productIdToDelete = $_GET['delete'];
    
    // Loop through the cart and find the product to delete
    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if ($cartItem['product_id'] == $productIdToDelete) {
            // Remove the item from the cart
            unset($_SESSION['cart'][$key]);
            break; // Exit the loop after finding and removing the item
        }
    }

    // Re-index the cart array after removing an item
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    
    // Redirect to refresh the cart page and display the updated cart
    header("Location: cart.php");
    exit;
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

    <!-- Header -->
    <?php include "Header.php"; ?>

    <!-- Cart Section -->
    <section class="section-cart padding-t-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cr-cart-content">
                        <form action="">
                            <div class="cr-table-content">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($cartEmpty) {
                                            echo "<tr><td colspan='5' style='text-align:center;'>$message</td></tr>";
                                        } else {
                                            $totalAmount = 0;

                                            // Loop through each item in the cart and fetch details from the database
                                            foreach ($_SESSION['cart'] as $cartItem) {
                                                $productId = $cartItem['product_id'];
                                                $quantity = $cartItem['quantity'];

                                                // Query the database to fetch product details
                                                $productQuery = $conn->query("SELECT * FROM products WHERE p_id = $productId");
                                                if ($productQuery->num_rows > 0) {
                                                    $product = $productQuery->fetch_assoc();
                                                    $productTotal = $product['p_price'] * $quantity;
                                                    $totalAmount += $productTotal;
                                        ?>
                                        <tr>
                                            <td class="cr-cart-name">
                                                <a href="javascript:void(0)">
                                                    <img src="<?= './uploads/' . $product ['p_image'] ?>" alt="<?= $product['p_name'] ?>" class="cr-cart-img">
                                                    <?= $product['p_name'] ?>
                                                </a>
                                            </td>
                                            <td class="cr-cart-price">
                                                <span class="amount">Rs.<?= number_format($product['p_price'], 2) ?></span>
                                            </td>
                                            <td class="cr-cart-qty">
                                                <span class="amount"><?= $quantity ?></span>
                                            </td>
                                            <td class="cr-cart-subtotal">Rs.<?= number_format($productTotal, 2) ?></td>
                                            <td class="cr-cart-remove">
                                                <a href="cart.php?delete=<?= $productId ?>">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cr-cart-update-bottom">
                                        <a href="index.php" class="cr-links">Continue Shopping</a>
                                        <a href="checkout.php" class="cr-button">Check Out</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            // Output the total amount for the cart, only if cart is not empty
            if (!$cartEmpty) {
                echo "<h3>Total Amount: Rs ".number_format($totalAmount, 2)."</h3>";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include "Footer.php"; ?>

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

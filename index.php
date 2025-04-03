<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="keywords" content="ecommerce, market, shop, mart, cart, deal, multipurpose, marketplace">
    <meta name="description" content="Carrot - Multipurpose eCommerce HTML Template.">
    <meta name="author" content="ashishmaraviya"> -->

    <title>Sami & Sons - Rice Trader</title>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<?php
include "./connect.php";
session_start();

// Fetch categories for filter and form
$categories = $conn->query("SELECT * FROM category");

$selectedCategory = isset($_GET["cat_id"]) ? $_GET["cat_id"] : 0;

$productsQuery = "SELECT products.*, category.cat_name FROM products
                  INNER JOIN category ON products.cat_id = category.cat_id
                  WHERE products.popular = 1";

if ($selectedCategory) {
    $productsQuery .= " AND products.cat_id = $selectedCategory";
}

$products = $conn->query($productsQuery);
?>
<body class="body-bg-6">

    <!-- Loader -->
    <div id="cr-overlay">
        <span class="loader"></span>
    </div>

    <!-- Header -->
     <?php 
    include "Header.php";
    ?>

    <!-- Mobile menu -->
    <?php 
    include "./components/Mobile_menu.php";
    ?>
    <!-- Hero slider -->
    <?php 
    include "./components/Hero_slider.php";
    ?>
    <!-- Categories -->
    <?php 
    include "./components/Categories.php";
    ?>

<!-- Popular product -->

<section class="section-popular-product-shape padding-b-100">
    <div class="container" data-aos="fade-up" data-aos-duration="2000">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-30">
                    <div class="cr-banner">
                        <h2>Popular Products</h2>
                    </div>
                    <div class="cr-banner-sub-title">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore lacus vel facilisis.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="product-content row mb-minus-24" id="MixItUpDA2FB7">
            <div class="col-xl-3 col-lg-4 col-12 mb-24">
                <div class="row mb-minus-24 sticky">
                    <div class="col-lg-12 col-sm-6 col-6 cr-product-box banner-480 mb-24">
                        <div class="cr-ice-cubes">
                            <img src="assets/img/product/product-banner.jpg" alt="Product banner">
                            <div class="cr-ice-cubes-contain">
                                <h4 class="title">Juicy</h4>
                                <h5 class="sub-title">Fruits</h5>
                                <span>100% Natural</span>
                                <a href="shop-full-width.php" class="cr-button">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-8 col-12 mb-24">
                <div class="row mb-minus-24">
                    <?php if ($products->num_rows > 0): ?>
                        <?php while ($row = $products->fetch_assoc()): ?>
                            <div class="mix vegetable col-xxl-3 col-xl-4 col-6 cr-product-box mb-24">
                                <div class="cr-product-card">
                                    <div class="cr-product-image">
                                        <div class="cr-image-inner zoom-image-hover">
                                            <img src="<?= './uploads/' . $row['p_image'] ?>" alt="<?= $row["p_name"] ?>">
                                        </div>
                                        <div class="cr-side-view">
                                            <a href="javascript:void(0)" class="wishlist" aria-label="Add to Wishlist">
                                                <i class="ri-heart-line"></i>
                                            </a>
                                            <!-- <a class="model-oraganic-product" data-bs-toggle="modal" href="#quickview_<?= $row["p_id"] ?>" role="button" aria-label="Quick View">
                                                <i class="ri-eye-line"></i>
                                            </a> -->
                                        </div>
                                    </div>
                                    <div class="cr-product-details">
                                        <div class="cr-brand">
                                            <a href="product-full-width.php?p_id=<?= $row['p_id'] ?>"><?= $row["cat_name"] ?></a>
                                            <div class="cr-star">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-line"></i>
                                                <p>(4.5)</p>
                                            </div>
                                        </div>
                                        <a href="product-full-width.php?p_id=<?= $row['p_id'] ?>" class="title"><?= $row["p_name"] ?></a>
                                        <p class="cr-price"><span class="new-price">Rs <?= $row["p_price"] ?></span></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No products available.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>


    <!-- Product banner -->
    <?php 
    include "./components/Product_banner.php";
    ?>

    <!-- Services -->
    <?php 
    include "./components/Services.php";
    ?>
    <!-- Deal -->
    <?php 
    // include "./components/Deal.php";
    ?>                  
    <!-- Popular product -->
    
    <!-- Testimonial -->
    <?php 
    include "./components/Testimonial.php";
    ?>     
    <!-- Blog -->
    
     <!-- include "./components/Blog.php"; -->
    


    <!-- Footer -->
<?php  include "Footer.php" ?>

    <!-- Tab to top -->
    <a href="#Top" class="back-to-top result-placeholder">
        <i class="ri-arrow-up-line"></i>
        <div class="back-to-top-wrap">
            <svg viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
    </a>

    <div class="cr-cart-notify" style="display:none;">
        <p class="compare-note"></p>
    </div>

<script>
       
</script>

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
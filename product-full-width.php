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
    <link rel="shortcut icon" href="assets/img/logo/favicon.png">
    <link rel="stylesheet" href="assets/css/vendor/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/vendor/remixicon.css">
    <link rel="stylesheet" href="assets/css/vendor/animate.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/vendor/aos.min.css">
    <link rel="stylesheet" href="assets/css/vendor/range-slider.css">
    <link rel="stylesheet" href="assets/css/vendor/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/vendor/jquery.slick.css">
    <link rel="stylesheet" href="assets/css/vendor/slick-theme.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<?php
include './connect.php';
session_start();

// Get the product ID from the URL
$productId = isset($_GET['p_id']) ? $_GET['p_id'] : 0;

// Fetch product details along with the category name
$productQuery = "
    SELECT p.*, c.cat_name 
    FROM products p
    JOIN category c ON p.cat_id = c.cat_id
    WHERE p.p_id = $productId
";
$productResult = $conn->query($productQuery);

// If product is found, fetch the details
if ($productResult->num_rows > 0) {
    $product = $productResult->fetch_assoc();
} else {
    // Handle the case where the product is not found
    echo "Product not found!";
    exit;
}
?>


<body class="body-bg-6">

    <!-- Loader -->
    <div id="cr-overlay">
        <span class="loader"></span>
    </div>

    <!-- Header -->
    <?php include "Header.php"; ?>

    <!-- Mobile menu -->
    <?php include "./components/Mobile_menu.php"; ?>

    <!-- Breadcrumb -->
    <section class="section-breadcrumb">
        <div class="cr-breadcrumb-image">   
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cr-breadcrumb-title">
                            <h2>Product</h2>
                            <span><a href="index.html">Home</a> - product</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product -->
    <section class="section-product padding-t-100">
        <div class="container">
            <div class="row mb-minus-24" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                <div class="col-xxl-4 col-xl-5 col-md-6 col-12 mb-24">
                    <div class="vehicle-detail-banner banner-content clearfix">
                        <div class="banner-slider">
                            <div class="slider slider-for">
                                <div class="slider-banner-image">
                                    <div class="zoom-image-hover">
                                        <img src="<?= !empty($product['p_image']) ? './uploads/' . $product['p_image'] : 'default-image.jpg' ?>" alt="<?= $product['p_name'] ?>" class="product-image">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-7 col-md-6 col-12 mb-24">
                    <div class="cr-size-and-weight-contain">
                        <h2 class="heading"><?= $product['p_name'] ?><h2>
                        <p><?= $product['p_description'] ?></p>
                    </div>
                    <div class="cr-size-and-weight">
                        <div class="cr-review-star">
                            <div class="cr-star">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <p>( 75 Review )</p>
                        </div>
                        <div class="list">
                            <ul>
                                <li><label>Brand <span>:</span></label><?= $product['p_brand'] ?></li>
                                <li><label>Category <span>:</span></label> <?= $product['cat_name'] ?></li>
                            </ul>
                        </div>
                        <div class="cr-product-price">
                            <span class="new-price">Rs. <?= $product['p_price'] ?></span>
                        </div>
                        <form class="add-to-cart-form" method="post">
                            <div class="cr-size-weight">
                                <h5><span>Select Quantity</span>/<span>(in kg)</span> :</h5>
                                <div class="cr-select">
                                    <select class="form-select" aria-label="Default select example" id="quantity_<?= $product['p_id'] ?>" name="quantity" onchange="showCustomQuantity(this)">
                                        <option value="1">1 kg</option>
                                        <option value="5">5 kg</option>
                                        <option value="10">10 kg</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                    <input type="number" id="customQuantity" name="customQuantity" placeholder="Enter kg" style="display:none;">
                                    <input type="hidden" name="product_id" value="<?= $product['p_id'] ?>">
                                </div>
                            </div>
                            <div class="cr-add-card">
                                <div class="cr-add-button">
                                    <button type="submit" class="cr-button" name="add_to_cart">Add to Cart</button>
                                </div>
                                <div class="cr-card-icon">
                                    <a href="javascript:void(0)" class="wishlist">
                                        <i class="ri-heart-line"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                <div class="col-12">
                    <div class="cr-paking-delivery">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                        aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="additional-tab" data-bs-toggle="tab"
                                        data-bs-target="#additional" type="button" role="tab" aria-controls="additional"
                                        aria-selected="false">Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                        type="button" role="tab" aria-controls="review"
                                        aria-selected="false">Review</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                 aria-labelledby="description-tab">
                                <div class="cr-tab-content">
                                    <div class="cr-description">
                                        <p><?= $product['p_description'] ?></p>
                                    </div>
                                    <h4 class="heading">Packaging & Delivery</h4>
                                    <div class="cr-description">
                                        <?php include "./components/Services.php"; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                                <div class="cr-tab-content">
                                    <div class="cr-description">
                                        <p><?= $product['p_description'] ?></p>
                                    </div>
                                    <div class="list">
                                        <ul>
                                            <li><label>Brand <span>:</span></label><?= $product['p_brand'] ?></li>
                                            <li><label>Category <span>:</span></label> <?= $product['cat_name'] ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                <div class="cr-tab-content-from">
                                    <div class="post">
                                        <div class="content">
                                            <img src="assets/img/review/1.jpg" alt="review">
                                            <div class="details">
                                                <span class="date">Jan 08, 2024</span>
                                                <span class="name">Oreo Noman</span>
                                            </div>
                                            <div class="cr-t-review-rating">
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error in vero
                                            sapiente doloribus debitis corporis, eaque dicta, repellat amet, illum
                                            adipisci vel
                                            perferendis dolor! quae vero in perferendis provident quis.</p>
                                        <div class="content mt-30">
                                            <img src="assets/img/review/2.jpg" alt="review">
                                            <div class="details">
                                                <span class="date">Mar 22, 2024</span>
                                                <span class="name">Lina Wilson</span>
                                            </div>
                                            <div class="cr-t-review-rating">
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-line"></i>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error in vero
                                            sapiente doloribus debitis corporis, eaque dicta, repellat amet, illum
                                            adipisci vel
                                            perferendis dolor! quae vero in perferendis provident quis.</p>
                                    </div>

                                    <h4 class="heading">Add a Review</h4>
                                    <form action="javascript:void(0)">
                                        <div class="cr-ratting-star">
                                            <span>Your rating :</span>
                                            <div class="cr-t-review-rating">
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-fill"></i>
                                                <i class="ri-star-s-line"></i>
                                                <i class="ri-star-s-line"></i>
                                                <i class="ri-star-s-line"></i>
                                            </div>
                                        </div>
                                        <div class="cr-ratting-input">
                                            <input name="your-name" placeholder="Name" type="text">
                                        </div>
                                        <div class="cr-ratting-input">
                                            <input name="your-email" placeholder="Email*" type="email" required="">
                                        </div>
                                        <div class="cr-ratting-input form-submit">
                                            <textarea name="your-commemt" placeholder="Enter Your Comment"></textarea>
                                            <button class="cr-button" type="submit" value="Submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="cr-cart-notify" style="display:none;">
    <p class="compare-note"></p>
</div>

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
    
</body>

<!-- Main Custom -->
 
<script>
        function showCustomQuantity(select) {
            var customInput = select.nextElementSibling;
            if (select.value === 'custom') {
                customInput.style.display = 'block';
            } else {
                customInput.style.display = 'none';
            }
        }

        $(document).on('submit', '.add-to-cart-form', function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Show Add to Cart success message
                    $('.cr-cart-notify').show();
                    $('.compare-note').text(response.message); // Display success message in notification
                    // Hide the notification after 2 seconds
                    setTimeout(function() {
                        $('.cr-cart-notify').fadeOut();
                    }, 2000); // 2000 ms = 2 seconds
                } else {
                    // Show error message in notification
                    $('.cr-cart-notify').show();
                    $('.compare-note').text(response.message); // Display error message in notification
                    // Hide the notification after 2 seconds
                    setTimeout(function() {
                        $('.cr-cart-notify').fadeOut();
                    }, 2000); // 2000 ms = 2 seconds
                }
            },
            error: function() {
                alert('An error occurred while adding the product to the cart.');
            }
        });
        });
        

    </script>

<script src="assets/js/main.js"></script>


<!-- Mirrored from maraviyainfotech.com/projects/carrot/carrot-v21/carrot-html/product-full-width.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Dec 2024 17:50:44 GMT -->
</html>
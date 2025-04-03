
<!DOCTYPE html>
<html lang="en" dir="ltr">


<!-- Mirrored from maraviyainfotech.com/projects/carrot/carrot-v21/carrot-html/shop-full-width.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Dec 2024 17:50:37 GMT -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<?php
include "./connect.php";
session_start();

// Fetch categories for filter and form
$categories = $conn->query("SELECT * FROM category");

// Fetch products along with their category names
$selectedCategory = isset($_GET["cat_id"]) ? $_GET["cat_id"] : 0;

// Count products based on selected category
$countQuery = "SELECT COUNT(*) AS product_count FROM products";
if ($selectedCategory) {
    $countQuery .= " WHERE cat_id = $selectedCategory";
}
$countResult = $conn->query($countQuery);
$productCount = $countResult->fetch_assoc()['product_count'];

$productsQuery = "SELECT products.*, category.cat_name FROM products
                  INNER JOIN category ON products.cat_id = category.cat_id";

if ($selectedCategory) {
    $productsQuery .= " WHERE products.cat_id = $selectedCategory";
}

$products = $conn->query($productsQuery);
?>

<body class="body-bg-6">

    <!-- Loader -->
    <div id="cr-overlay">
        <span class="loader"></span>
    </div>

    <!-- Header -->
    <?php include "Header.php"; ?>

    <!-- Mobile menu -->
    <div class="cr-sidebar-overlay"></div>
    <div id="cr_mobile_menu" class="cr-side-cart cr-mobile-menu">
        <div class="cr-menu-title">
            <span class="menu-title">My Menu</span>
            <button type="button" class="cr-close">×</button>
        </div>
        <div class="cr-menu-inner">
            <div class="cr-menu-content">
                <ul>
                    <li class="dropdown drop-list">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="dropdown drop-list">
                        <span class="menu-toggle"></span>
                        <a href="javascript:void(0)" class="dropdown-list">Category</a>
                        <ul class="sub-menu">
                            <li><a href="shop-left-sidebar.php">Shop Left sidebar</a></li>
                            <li><a href="shop-right-sidebar.php">Shop Right sidebar</a></li>
                            <li><a href="shop-full-width.php">Full Width</a></li>
                        </ul>
                    </li>
                    <li class="dropdown drop-list">
                        <span class="menu-toggle"></span>
                        <a href="javascript:void(0)" class="dropdown-list">product</a>
                        <ul class="sub-menu">
                            <li><a href="product-full-width.php">product Left sidebar</a></li>
                            <li><a href="product-right-sidebar.php">product Right sidebar</a></li>
                            <li><a href="product-full-width.php">Product Full Width </a></li>
                        </ul>
                    </li>
                    <li class="dropdown drop-list">
                        <span class="menu-toggle"></span>
                        <a href="javascript:void(0)" class="dropdown-list">Pages</a>
                        <ul class="sub-menu">
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="contact-us.php">Contact Us</a></li>
                            <li><a href="cart.php">Cart</a></li>
                            <li><a href="checkout.php">Checkout</a></li>
                            <li><a href="track-order.php">Track Order</a></li>
                            <li><a href="wishlist.php">Wishlist</a></li>
                            <li><a href="faq.php">Faq</a></li>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="policy.php">Policy</a></li>
                        </ul>
                    </li>
                    <li class="dropdown drop-list">
                        <span class="menu-toggle"></span>
                        <a href="javascript:void(0)" class="dropdown-list">Blog</a>
                        <ul class="sub-menu">
                            <li><a href="blog-left-sidebar.php">Left Sidebar</a></li>
                            <li><a href="blog-right-sidebar.php">Right Sidebar</a></li>
                            <li><a href="blog-full-width.php">Full Width</a></li>
                            <li><a href="blog-detail-left-sidebar.php">Detail Left Sidebar</a></li>
                            <li><a href="blog-detail-right-sidebar.php">Detail Right Sidebar</a></li>
                            <li><a href="blog-detail-full-width.php">Detail Full Width</a></li>
                        </ul>
                    </li>
                    <li class="dropdown drop-list">
                        <span class="menu-toggle"></span>
                        <a href="javascript:void(0)">Element</a>
                        <ul class="sub-menu">
                            <li><a href="elements-products.php">Products</a></li>
                            <li><a href="elements-typography.php">Typography</a></li>
                            <li><a href="elements-buttons.php">Buttons</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <section class="section-breadcrumb">
        <div class="cr-breadcrumb-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cr-breadcrumb-title">
                            <h2>Shop</h2>
                            <span> <a href="index.php">Home</a> - Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Categories -->
 
<section class="section-shop padding-tb-50">
    <div class="container">
        <div class="row">
            <div class="col-12" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                <div class="cr-shop-bredekamp">
                    <div class="cr-toggle">
                        <a href="javascript:void(0)" class="gridCol active-grid">
                            <i class="ri-grid-line"></i>
                        </a>
                        <a href="javascript:void(0)" class="gridRow">
                            <i class="ri-list-check-2"></i>
                        </a>
                    </div>
                    <div class="center-content">
                        <!-- <span>We found 29 items for you!</span> -->
    <span id="productCountMessage">We found <?= $productCount ?> items for you!</span>

                    </div>
                    <div class="cr-select">
                        <label>Sort By :</label>
                        <select id="categoryFilter" class="form-select" aria-label="Default select example">
                            <option value="0">All Category</option>
                            <?php while ($row = $categories->fetch_assoc()): ?>
                            <option value="<?=$row["cat_id"] ?>" <?=$selectedCategory == $row["cat_id"] ? "selected" : "" ?>>
                                <?=$row["cat_name"] ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div id="products">
            <div class="row col-50 mb-minus-24">
                <?php while ($row = $products->fetch_assoc()): ?>
                <div class="col-lg-3 col-6 cr-product-box mb-24">
                    
                <div class="cr-product-card">
                        <div class="cr-product-image">
                            <div class="cr-image-inner zoom-image-hover">
                                <img src="<?= './uploads/' . $row['p_image'] ?>" alt="<?=$row["p_name"] ?>">
                            </div>
                            <div class="cr-side-view">
                                <a href="javascript:void(0)" class="wishlist">
                                    <i class="ri-heart-line"></i>
                                </a>
                                <a class="model-oraganic-product" data-bs-toggle="modal" href="#quickview_<?=$row["p_id"] ?>" role="button">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </div>
                        </div>
                        <div class="cr-product-details">
                            <div class="cr-brand">
                                <a href="product-full-width.php?p_id=<?= $row['p_id'] ?>"><?=$row["cat_name"] ?></a>
                                <div class="cr-star">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-line"></i>
                                    <p>(4.5)</p>
                                </div>
                            </div>
                            <a class="title" href="product-full-width.php?p_id=<?= $row['p_id'] ?>"><?=$row["p_name"] ?></a>

                            <p class="cr-price"><span class="new-price">Rs <?=$row["p_price"] ?></span></p>
                        </div>
                    </div>
                </div>

                <!-- Modal Structure for Quick View -->

                <div class="modal fade" id="quickview_<?=$row["p_id"] ?>" tabindex="-1" aria-labelledby="quickviewLabel<?=$row["p_id"] ?>" aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog modal-dialog-centered cr-modal-dialog modal-lg">
                        <div class="modal-content">
                            <button type="button" class="cr-close-model btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12">
                                        <div class="zoom-image-hover modal-border-image">
                                            <img src="<?= './uploads/' . $row['p_image'] ?>" alt="<?=$row["p_name"] ?>" class="product-image">
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <div class="cr-size-and-weight-contain">
                                            <h2 class="heading"><?=$row["p_name"] ?></h2>
                                            <p><?=$row["p_description"] ?></p>
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
                                                <p>(75 Review)</p>
                                            </div>
                                            <div class="cr-product-price">
                                                <span class="new-price">Rs. <?=$row["p_price"] ?></span>
                                            </div>
                                            <form class="add-to-cart-form" method="post">
                                                <div class="cr-size-weight">
                                                    <h5><span>Select Quantity</span>/<span>(in kg)</span> :</h5>
                                                    <div class="cr-select">
                                                        <select class="form-select" aria-label="Default select example" id="quantity_<?= $row['p_id'] ?>" name="quantity" onchange="showCustomQuantity(this)">
                                                            <option value="1">1 kg</option>
                                                            <option value="5">5 kg</option>
                                                            <option value="10">10 kg</option>
                                                            <option value="custom">Custom</option>
                                                        </select>
                                                        <input type="number" id="customQuantity" name="customQuantity" placeholder="Enter kg" style="display:none;">
                                                        <input type="hidden" name="product_id" value="<?= $row['p_id'] ?>">
                                                    </div>
                                                </div>
                                                <div class="cr-add-card">
                                                    <div class="cr-add-button">
                                                        <button type="submit" class="cr-button" name="add_to_cart">Add to Cart</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            <?php endwhile; ?>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <!-- <nav aria-label="..." class="cr-pagination">
     <ul class="pagination">
        <li class="page-item disabled">
            <span class="page-link">Previous</span>
        </li>
        <li class="page-item active" aria-current="page">
            <span class="page-link">1</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
     </ul>
    </nav> -->
</section>

<div class="cr-cart-notify" style="display:none;">
    <p class="compare-note"></p>
</div>

    <!-- Footer -->

    <?php include "Footer.php"; ?>
    <!-- Tab to top -->
    <a href="#Top" class="back-to-top result-placeholder">
        <i class="ri-arrow-up-line"></i>
        <div class="back-to-top-wrap">
            <svg viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
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


<!-- Mirrored from maraviyainfotech.com/projects/carrot/carrot-v21/carrot-html/shop-full-width.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Dec 2024 17:50:37 GMT -->

</html>

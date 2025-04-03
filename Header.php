    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-header">
                        <a href="index.php" class="cr-logo">
                            <img src="assets/img/logo/logo.png" alt="logo" class="logo">
                            <img src="assets/img/logo/dark-logo.png" alt="logo" class="dark-logo">
                        </a>
                        <div class="cr-right-bar">
                            <a href="cart.php" class="cr-right-bar-item ">
                                <i class="ri-shopping-cart-line"></i>
                                <span>Cart</span>
                            </a>
                            <a href="wishlist.php" class="cr-right-bar-item">
                                <i class="ri-heart-3-line"></i>
                                <span>Wishlist</span>
                            </a>
                            <?php
// session_start(); // Start the session to access session variables
?>
<ul class="navbar-nav">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- Show Login button if the user is not logged in -->
        <li class="nav-item">
            <a href="logout.php" class="cr-button">Login</a>
        </li>
    <?php else: ?>
        <!-- Show Account icon if the user is logged in -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle cr-right-bar-item" href="javascript:void(0)">
                <i class="ri-user-3-line"></i>
                <span>Account</span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="profile.php"><?php echo $_SESSION['user_name']; ?></a>
                </li>
                <li>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </li>
            </ul>
        </li>
    <?php endif; ?>
</ul>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cr-fix" id="cr-main-menu-desk">
            <div class="container">
                <div class="cr-menu-list">
                    
                    <nav class="navbar navbar-expand-lg">
                        <a href="javascript:void(0)" class="navbar-toggler shadow-none">
                            <i class="ri-menu-3-line"></i>
                        </a>
                        <div class="cr-header-buttons">
                            <a href="cart.php" class="cr-right-bar-item">
                                <i class="ri-shopping-cart-line"></i>
                            </a>
                            <a href="wishlist.php" class="cr-right-bar-item">
                                <i class="ri-heart-line"></i>
                            </a>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="javascript:void(0)">
                                        <i class="ri-user-3-line"></i>
                                    </a>
                                    <ul class="dropdown-menu">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- Show Register and Login links if the user is not logged in -->
        <li>
            <a class="dropdown-item" href="register.php">Register</a>
        </li>
        <li>
            <a class="dropdown-item" href="login.php">Login</a>
        </li>
    <?php else: ?>
        <!-- Show Account details after user is logged in -->
        <li>
            <a class="dropdown-item" href="profile.php"><?php echo $_SESSION['user_name']; ?></a>
        </li>
        <li>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </li>
    <?php endif; ?>
</ul>
                                </li>
                            </ul>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">
                                        Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="shop-full-width.php">
                                        Products
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                                        Pages
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="contact-us.php">Contact Us</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="cart.php">Cart</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="checkout.php">Checkout</a>
                                        </li>
                                        <!-- <li>
                                            <a class="dropdown-item" href="track-order.php">Track Order</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="wishlist.php">Wishlist</a>
                                        </li> -->
                                        <li>
                                            <a class="dropdown-item" href="faq.php">Faq</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="login.php">Login</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="register.php">Register</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="About.php">
                                        About
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="cr-calling">
                        <i class="ri-phone-line"></i>
                        <a href="javascript:void(0)">+123 ( 456 ) ( 7890 )</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

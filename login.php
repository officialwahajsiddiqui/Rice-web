<!DOCTYPE html>
<html lang="en" dir="ltr">


<!-- Mirrored from maraviyainfotech.com/projects/carrot/carrot-v21/carrot-html/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Dec 2024 17:50:36 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="ecommerce, market, shop, mart, cart, deal, multipurpose, marketplace">
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
<?php
session_start();
require 'connect.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT id, Username, email FROM users WHERE email = ? AND Password = ?");
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $Username, $email);
        $stmt->fetch();

        // Set session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $Username;
        $_SESSION['user_email'] = $email;

        // If "Remember Me" is checked, set cookies
        if ($remember) {
            setcookie('user_email', $email, time() + (86400 * 30), "/"); // 30 days
            setcookie('user_password', $password, time() + (86400 * 30), "/"); // 30 days
        }

        // Redirect to the dashboard or another page
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = 'Invalid Email or Password.';
        header("Location: login.php");
        exit;
    }

    $stmt->close();
}
$conn->close();
?>

<body class="body-bg-6">

    <!-- Loader -->
    <div id="cr-overlay">
        <span class="loader"></span>
    </div>

    <!-- Breadcrumb -->
    <section class="section-breadcrumb">
        <div class="cr-breadcrumb-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cr-breadcrumb-title">
                            <h2>Login</h2>
                            <span> <a href="index.php">Home</a> - Login</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Successfully Message -->
    <?php
    
if (isset($_SESSION['message'])) {
    echo '<div class="cr-cart-notify"><p class="compare-note">' . $_SESSION['message'] . '</p></div>';
    // Unset the message after displaying it
    unset($_SESSION['message']);
}
?>

    <!-- Login -->
    <section class="section-login padding-tb-100">
        <div class="container">
            <div class="row d-none">
                <div class="col-lg-12">
                    <div class="mb-30" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                        <div class="cr-banner">
                            <h2>Login</h2>
                        </div>

                        <div class="cr-banner-sub-title">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore lacus vel facilisis. </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                <div class="cr-login" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                    <div class="form-logo">
                        <img src="assets/img/logo/logo.png" alt="logo">
                    </div>
                    <?php
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .$_SESSION['error'] .'</div>';
    unset($_SESSION['error']);
}
?>

                    <form class="cr-content-form" method="POST">
                        <div class="form-group">
                            <label>Email Address*</label>
                            <input type="email" name="email" placeholder="Enter Your Email" class="cr-form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password*</label>
                            <input type="password" name="password" placeholder="Enter Your Password" class="cr-form-control" required>
                        </div>
                        <div class="remember">
                            <span class="form-group custom">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember Me</label>
                            </span>
                            <a class="link" href="forgot.html">Forgot Password?</a>
                        </div><br>
                        <div class="login-buttons">
                            <button type="submit" class="cr-button">Login</button>
                            <a href="register.php" class="link">
                                Signup?
                            </a>
                        </div>
                    </form>
                </div>

                </div>
            </div>
        </div>
    </section>
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


<!-- Mirrored from maraviyainfotech.com/projects/carrot/carrot-v21/carrot-html/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Dec 2024 17:50:36 GMT -->
</html>
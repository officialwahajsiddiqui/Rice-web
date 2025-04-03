<?php
// Start the session
session_start();
include 'connect.php';

// Initialize message variable
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = mysqli_real_escape_string($conn, $_POST['Username']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email or username already exists
    $check_sql = "SELECT * FROM users WHERE Username = '$Username' OR email = '$email'";
    $result = $conn->query($check_sql);
    if ($result->num_rows > 0) {
        $message = '<div class="alert alert-danger" role="alert">Email already exists!</div>';
    } else {
        // Hash password before saving
        $hashed_password = $Password;

        // Insert data into the database
        $sql = "INSERT INTO users (Username, Password, email) VALUES ('$Username', '$hashed_password', '$email')";

        if ($conn->query($sql) === TRUE) {
            // Save user details in session
            $_SESSION['user_id'] = $conn->insert_id; // Get the last inserted ID
            $_SESSION['Username'] = $Username;
            $_SESSION['email'] = $email;

            // Set success message
            $_SESSION['message'] = "Registration successful! Please log in.";
            header("Location: login.php");
            exit();
        } else {
            $message = '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
        }
    }

    $conn->close();
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
</head>

<body class="body-bg-6">

    <!-- Loader -->
    <div id="cr-overlay">
        <span class="loader"></span>
    </div>

    <!-- Mobile menu -->

    <!-- Breadcrumb -->
    <section class="section-breadcrumb">
        <div class="cr-breadcrumb-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cr-breadcrumb-title">
                            <h2>Register</h2>
                            <span> <a href="index.php">Home</a> - Register</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Register -->
    <section class="section-register padding-tb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cr-register" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                        <div class="form-logo">
                            <img src="assets/img/logo/logo.png" alt="logo">
                        </div>

                        <!-- Display message if exists -->
                        <?php if ($message): ?>
                            <?php echo $message; ?>
                        <?php endif; ?>

                        <form class="cr-content-form" action="register.php" method="POST">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Your Full Name*</label>
                                        <input type="text" name="Username" placeholder="Enter Your First Name" class="cr-form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" name="email" placeholder="Enter Your Email" class="cr-form-control" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="Password" placeholder="Password" class="cr-form-control" required>
                                    </div>
                                </div>
                                <div class="cr-register-buttons">
                                    <button type="submit" class="cr-button">Signup</button>
                                    <a href="login.php" class="link">Have an account?</a>
                                </div>
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

</html>

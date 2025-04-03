<head>
<link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />

</head>
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Secure password hashing
    $country = htmlspecialchars($_POST['country']);
    $city = htmlspecialchars($_POST['city']);
    $birthdate = $_POST['birthdate'];
    $mobile_no = htmlspecialchars($_POST['mobile_no']);
    $image_path = "";

    // Image upload handling
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = mime_content_type($_FILES['profile_image']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            $target_dir = "uploads/";
            $file_name = uniqid() . "_" . basename($_FILES['profile_image']['name']);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            } else {
                die("Error uploading the image.");
            }
        } else {
            die("Invalid image type. Only JPEG and PNG are allowed.");
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO admin_users (name, email, password_hash, country, city, birthdate, mobile_no, image_path) 
                            VALUES (:name, :email, :password_hash, :country, :city, :birthdate, :mobile_no, :image_path)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':mobile_no', $mobile_no);
    $stmt->bindParam(':image_path', $image_path);

    if ($stmt->execute()) {
        echo "Admin user registered successfully.";
    } else {
        echo "Failed to register admin user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<!-- auth-register  21 Nov 2019 04:05:01 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/jquery-selectric/selectric.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="name"> Name</label>
                      <input type="text" class="form-control" name="name" autofocus>
                    </div>
                    <div class="form-group col-6">
                    <label for="email">Email</label>
                    <input  type="email" class="form-control" name="email">
                   </div>
                  </div>
                  <div class="row">
                  <div class="form-group">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                      name="password">
                      <div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                        <!-- </div> -->
                        </div>
                        


                  <div class="row">

                  <div class="form-group col-6">
                      <label for="country">Country (optional)</label>
                      <input type="text" class="form-control" name="country">
                    </div>
                  <div class="form-group col-6">
                      <label for="country">City (optional)</label>
                      <input type="text" class="form-control" name="city">
                    </div>
                  <div class="form-group col-6">
                      <label for="birthdate">Birthdate (optional)</label>
                      <input type="date" class="form-control" name="birthdate">
                    </div>
                  </div>
                  <div class="row">
                  <div class="form-group col-6">
                      <label for="mobile_no">Mobile Number (optional)</label>
                      <input type="text" class="form-control" name="mobile_no">
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    
                    <div class="form-group col-6">
                        <label for="Image">Image</label>
                        <input type="file" name="profile_image" accept="image/*" required><br>
                        </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="register" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                Already Registered? <a href="auth-login">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
 
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/auth-register.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- auth-register  21 Nov 2019 04:05:02 GMT -->
</html>
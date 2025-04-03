
<!DOCTYPE html>
<html lang="en">



<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>
<?php
include 'db.php';

error_reporting(E_ALL);

$message = ''; // Initialize message variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    // Sanitize and validate inputs
    $p_name = htmlspecialchars(trim($_POST['p_name']));
    $p_price = filter_var($_POST['p_price'], FILTER_VALIDATE_FLOAT);
    $p_description = htmlspecialchars(trim($_POST['p_description']));
    $p_brand = htmlspecialchars(trim($_POST['p_brand']));
    $cat_id = $_POST['cat_id']; // Use category ID from the form
    $popular = isset($_POST['popular']) ? 1 : 0;

    // Validate mandatory fields
    if (empty($p_name) || !$p_price || empty($p_description) || empty($p_brand) || empty($cat_id)) {
        $message = "All fields are required!";
    } else {
        // Fetch category name using cat_id
        $stmt = $conn->prepare("SELECT cat_name FROM category WHERE cat_id = :cat_id");
        $stmt->execute([':cat_id' => $cat_id]);
        $category = $stmt->fetch();

        if ($category) {
            $cat_name = $category['cat_name']; // Get the category name from the database

            // Handle image upload
            if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] === 0) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $file_type = $_FILES['p_image']['type'];
                if (in_array($file_type, $allowed_types)) {
                    $target_dir = "../uploads/";
                    
                    // Generate a unique name for the image
                    $extension = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
                    $unique_image_name = uniqid('img_', true) . '.' . $extension;
                    $target_file = $target_dir . $unique_image_name;

                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
                    }

                    if (move_uploaded_file($_FILES['p_image']['tmp_name'], $target_file)) {
                        // Insert product into database
                        $stmt = $conn->prepare("INSERT INTO products 
                            (p_name, p_image, p_price, p_description, p_brand, cat_id, cat_name, popular) 
                            VALUES (:p_name, :p_image, :p_price, :p_description, :p_brand, :cat_id, :cat_name, :popular)");
                        $stmt->execute([
                            ':p_name' => $p_name,
                            ':p_image' => $unique_image_name,
                            ':p_price' => $p_price,
                            ':p_description' => $p_description,
                            ':p_brand' => $p_brand,
                            ':cat_id' => $cat_id, // Insert category ID
                            ':cat_name' => $cat_name, // Insert category name
                            ':popular' => $popular
                        ]);

                        // Add to popular products if marked as popular
                        if ($popular) {
                            $last_id = $conn->lastInsertId();
                            $stmtPopular = $conn->prepare("INSERT INTO popular_products (p_id) VALUES (:p_id)");
                            $stmtPopular->execute([':p_id' => $last_id]);
                        }

                        $message = "Product added successfully!";
                    } else {
                        $message = "Failed to upload image.";
                    }
                } else {
                    $message = "Invalid image type. Allowed types: JPEG, PNG, GIF.";
                }
            } else {
                $message = "Image upload failed. Please try again.";
            }
        } else {
            $message = "Category not found.";
        }
    }
}


// Fetch categories
try {
    $categories = $conn->query("SELECT `cat_id`, `cat_name` FROM `category`")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p style='color:red;'>Failed to fetch categories.</p>";
    error_log($e->getMessage());
}
?>

    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            z-index: 1000;
            text-align: center;
            border-radius: 10px;
        }
        .popup.active {
            display: block;
        }
        .popup button {
            margin-top: 10px;
            padding: 5px 15px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        .popup button:hover {
            background-color: #0056b3;
        }    
  
form {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 500px;
    margin: auto;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

input[type="text"],
input[type="number"],
input[type="file"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
    font-size: 14px;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="file"]:focus,
textarea:focus {
    border-color: #007bff;
    outline: none;
}

textarea {
    height: 100px;
    resize: none;
}

.add-btn {
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
    margin-bottom: 15px;
    display: inline-block;
}

.add-btn:hover {
    background-color: #218838;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Styling for language and progress sections */
.language-progress {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 15px;
    background-color: #f7f7f7;
}

.language-progress label {
    font-size: 14px;
    margin-bottom: 8px;
    color: #555;
}

#progressFields {
    margin-bottom: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea {
        font-size: 13px;
        padding: 8px;
    }

    button[type="submit"] {
        font-size: 15px;
        padding: 8px 12px;
    }

    .add-btn {
        font-size: 14px;
        padding: 8px 12px;
    }
}
       
    </style>


<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li>
              <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
              <span class="badge headerBadge1">
                6 </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
											text-white"> <img alt="image" src="assets/img/users/user-1.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">John
                      Deo</span>
                    <span class="time messege-text">Please check your mail !!</span>
                    <span class="time">2 Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                      Smith</span> <span class="time messege-text">Request for leave
                      application</span>
                    <span class="time">5 Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-5.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                      Ryan</span> <span class="time messege-text">Your payment invoice is
                      generated.</span> <span class="time">12 Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-4.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                      Smith</span> <span class="time messege-text">hii John, I have upload
                      doc
                      related to task.</span> <span class="time">30
                      Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-3.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                      Joshi</span> <span class="time messege-text">Please do as specify.
                      Let me
                      know if you have any query.</span> <span class="time">1
                      Days Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                      Smith</span> <span class="time messege-text">Client Requirements</span>
                    <span class="time">2 Days Ago</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="#" class="dropdown-item dropdown-item-unread"> <span
                    class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                  </span> <span class="dropdown-item-desc"> Template update is
                    available now! <span class="time">2 Min
                      Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="far
												fa-user"></i>
                  </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                      Sugiharto</b> are now friends <span class="time">10 Hours
                      Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-success text-white"> <i
                      class="fas
												fa-check"></i>
                  </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                    moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                      Hours
                      Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-danger text-white"> <i
                      class="fas fa-exclamation-triangle"></i>
                  </span> <span class="dropdown-item-desc"> Low disk space. Let's
                    clean it! <span class="time">17 Hours Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="fas
												fa-bell"></i>
                  </span> <span class="dropdown-item-desc"> Welcome to Otika
                    template! <span class="time">Yesterday</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="<?php echo htmlspecialchars('./uploads/n.jpg'); ?>" class="user-img-radious-style">
              <span class="d-sm-none d-lg-inline-block"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello
                <?php echo htmlspecialchars($admin['name']); ?>
              </div>
              <a href="profile" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> <a href="timeline" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">Otika</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
              <a href="index" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="contact" class="nav-link"><i data-feather="mail"></i><span>Contacts Us</span></a>
            </li>

            <li class="menu-header">Products</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file"></i><span>Products</span></a>
              <ul class="dropdown-menu">
                <li><a href="Addproducts">Add Products</a></li>
                <li><a href="Allproducts">All Products</a></li>
              </ul>
            </li>
          </ul>
        </aside>
      </div>

  <!-- Main Content -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">Add New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="mb-3">
          <label for="p_name" class="form-label">Product Name</label>
          <input type="text" name="p_name" id="p_name" class="form-control" placeholder="Enter product name" required>
        </div>

        <!-- Product Price -->
        <div class="mb-3">
          <label for="p_price" class="form-label">Product Price (PKR)</label>
          <input type="number" name="p_price" id="p_price" class="form-control" placeholder="Enter product price" step="0.01" required>
        </div>

        <!-- Product Description -->
        <div class="mb-3">
          <label for="p_description" class="form-label">Product Description</label>
          <textarea name="p_description" id="p_description" class="form-control" rows="3" placeholder="Enter product description" required></textarea>
        </div>

        <!-- Product Brand -->
        <div class="mb-3">
          <label for="p_brand" class="form-label">Brand</label>
          <input type="text" name="p_brand" id="p_brand" class="form-control" placeholder="Enter product brand" required>
        </div>

        <!-- Categories Dropdown -->
        <label for="cat_id" class="form-label">Category</label>
        <select name="cat_id" id="cat_id" required>
    <option value="" disabled selected>Select a category</option>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category['cat_id']) ?>"><?= htmlspecialchars($category['cat_name']) ?></option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="" disabled>No categories available</option>
    <?php endif; ?>
</select>

        <!-- Product Image -->
        <div class="mb-3">
          <label for="p_image" class="form-label">Upload Product Image</label>
          <input type="file" name="p_image" id="p_image" class="form-control" accept="image/*" required>
        </div>

        <!-- Popular Checkbox -->
        <div class="form-check mb-3">
          <input type="checkbox" name="popular" id="popular" class="form-check-input">
          <label for="popular" class="form-check-label">Mark as Popular Product</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
      </form>
    </div>
  </div>
</div>

<?php include 'justify.php'; ?>
</div>

<footer class="main-footer">
  <div class="footer-left">
    <a href="templateshub.net">Templateshub</a></a>
  </div>
  <div class="footer-right"></div>
</footer>
    </div>
  </div>

  <!-- Popup Div -->
  <div class="popup" id="popup">
        <p id="popup-message"></p>
        <button onclick="closePopup()">OK</button>
    </div>

    <script>
        function closePopup() {
            document.getElementById('popup').classList.remove('active');
        }

        // Show popup message if $message is not empty
        <?php if (!empty($message)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('popup-message').innerText = "<?= $message ?>";
                document.getElementById('popup').classList.add('active');
            });
        <?php endif; ?>
    </script>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- blank  21 Nov 2019 03:54:41 GMT -->
</html>
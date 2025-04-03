<?php
include "../connect.php";
error_reporting(E_ALL);
// Fetch product details for the given product ID
$product = null;
if (isset($_GET["p_id"])) {
    $p_id = $_GET["p_id"];
    $result = $conn->query("SELECT * FROM products WHERE p_id = $p_id");
    $product = $result->fetch_assoc();
}
// Update Product Form Processing
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_product"])) {
    $p_id = $_POST["p_id"];
    $p_name = $_POST["p_name"];
    $p_price = $_POST["p_price"];
    $p_description = $_POST["p_description"];
    $p_brand = $_POST["p_brand"];
    $cat_id = $_POST["cat_id"];
    $popular = isset($_POST["popular"]) ? 1 : 0;
    // Image upload handling
    if (!empty($_FILES["p_image"]["name"])) {
        $p_image = $_FILES["p_image"]["name"];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($p_image);
        move_uploaded_file($_FILES["p_image"]["tmp_name"], $target_file);
        $sql = "UPDATE products SET p_name = '$p_name', p_image = '$target_file', p_price = '$p_price', p_description = '$p_description', p_brand = '$p_brand', cat_id = '$cat_id', popular = '$popular' WHERE p_id = $p_id";
    } else {
        $sql = "UPDATE products SET p_name = '$p_name', p_price = '$p_price', p_description = '$p_description', p_brand = '$p_brand', cat_id = '$cat_id', popular = '$popular' WHERE p_id = $p_id";
    }
    $conn->query($sql);
    // Update popular products
    if ($popular) {
        $conn->query(
            "INSERT INTO popular_products (p_id) VALUES ('$p_id') ON DUPLICATE KEY UPDATE p_id = '$p_id'"
        );
    } else {
        $conn->query("DELETE FROM popular_products WHERE p_id = '$p_id'");
    }
    // Redirect to the products page or display a success message
    header("Location: Allproducts.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Updated Products</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
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


    <body>
      <div id="app">
        <div class="main-wrapper">
          <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <?php
              include 'header.php';
            ?>
            <!-- Main Content -->
            <div class="main-content">
              <section class="section">
                <div class="section-header">
                  <h1>Update Product</h1>
                </div>

                <div class="section-body">
                  <?php if ($product): ?>
                  <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="p_id" value="<?php echo htmlspecialchars(
                                $product[" p_id"] ); ?>">

                    <div class="form-group">
                      <label for="p_name">Product Name</label>
                      <input type="text" id="p_name" name="p_name" value="<?php echo htmlspecialchars(
                                    $product[" p_name"] ); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label for="p_price">Price</label>
                      <input type="text" id="p_price" name="p_price" value="<?php echo htmlspecialchars(
                                    $product[" p_price"] ); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label for="p_description">Description</label>
                      <textarea id="p_description" name="p_description" class="form-control" required><?php echo htmlspecialchars(
                                    $product["p_description"]
                                ); ?></textarea>
                    </div>

                    <div class="form-group">
                      <label for="p_brand">Brand</label>
                      <input type="text" id="p_brand" name="p_brand" value="<?php echo htmlspecialchars(
                                    $product[" p_brand"] ); ?>" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="cat_id">Category</label>
                      <select id="cat_id" name="cat_id" class="form-control">
                        <!-- Populate categories -->
                        <option value="1" <?php echo $product[ "cat_id" ]==1 ? "selected" : "" ; ?>>Category 1</option>
                        <option value="2" <?php echo $product[ "cat_id" ]==2 ? "selected" : "" ; ?>>Category 2</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="p_image">Product Image</label>
                      <input type="file" id="p_image" name="p_image" class="form-control">
                      <?php if ($product["p_image"]): ?>
                      <img src="<?php echo htmlspecialchars(
                                    $product[" p_image"] ); ?>" alt="Product Image" style="max-width: 100px;
                      margin-top: 10px;">
                      <?php endif; ?>
                    </div>

                    <div class="form-group">
                      <input type="checkbox" id="popular" name="popular" <?php echo $product[ "popular" ] ? "checked"
                        : "" ; ?>>
                      <label for="popular">Popular</label>
                    </div>

                    <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
                  </form>
                  <?php else: ?>
                  <p>Product not found.</p>
                  <?php endif; ?>
                </div>
              </section>
            </div>
          </div>
        </div>
        <?php include "justify.php"; ?>
        <footer class="main-footer">
          <div class="footer-left"></div>
          <div class="footer-right"></div>
        </footer>
      </div>
  </div>
  <?php $conn->close(); ?>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
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
<?php
include 'db.php';
error_reporting(E_ALL);

// Fetch products for display
$productsQuery = "SELECT * FROM products";
$statement = $conn->prepare($productsQuery);
$statement->execute();

// Fetch all results
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
            <?php
              include 'header.php';
            ?>
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Product DataTable</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Category ID</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($products as $row): ?>
                          <tr>
                            <td>
                              <?= htmlspecialchars($row['p_id']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($row['p_name']) ?>
                            </td>
                            <td>
                              <img src="<?= htmlspecialchars('../uploads/' . $row['p_image']) ?>"
                                alt="<?= htmlspecialchars($row['p_name']) ?>" style="width: 100px;">
                            </td>
                            <td>
                              <?= htmlspecialchars($row['p_price']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($row['p_description']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($row['p_brand']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($row['cat_id']) ?>
                            </td>
                            <td>
                              <?php if ($row['popular']): ?>
                              <div class="badge badge-success badge-shadow">Popular</div>
                              <?php else: ?>
                              <div class="badge badge-danger badge-shadow">Unpopular</div>
                              <?php endif; ?>
                            </td>
                            <td>
                              <a class="btn btn-primary" href="update.php?p_id=<?= $row['p_id'] ?>">Update</a>
                              <!-- Delete button -->
                              <a class="btn btn-danger" href="delete_product.php?p_id=<?= $row['p_id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>

                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </section>
      </div>
      <?php include 'justify.php'; ?>
      <footer class="main-footer">
        <div class="footer-left"></div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>
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

  <script>
    $(document).ready(function () {
      $('#table-1').DataTable();
    });
  </script>
</body>

</html>
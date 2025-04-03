<!DOCTYPE html>
<html lang="en">


<!-- datatables  21 Nov 2019 03:55:21 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin</title>
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
<style>
  .message-preview {
    position: relative;
    cursor: pointer;
    display: inline-block;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .message-preview:hover .full-message {
    display: inline;
    white-space: normal;
  }

  .full-message {
    display: none;
    white-space: normal;
  }
</style>

<?php
session_start();
include 'db.php'; // Ensure PDO connection

if (!isset($_GET['order_id'])) {
    die("Order ID is required.");
}

$order_id = $_GET['order_id'];

try {
    // Fetch order details
    $orderStmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id");
    $orderStmt->execute(['order_id' => $order_id]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Order not found.");
    }

    // Fetch order items with product details and popularity
    $itemsStmt = $conn->prepare("
        SELECT 
            oi.order_item_id, 
            oi.quantity, 
            p.p_name, 
            p.p_image, 
            p.p_price, 
            p.p_description, 
            p.p_brand, 
            p.cat_name, 
            IF(pp.p_id IS NOT NULL, 'Yes', 'No') AS popular 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.p_id
        LEFT JOIN popular_products pp ON p.p_id = pp.p_id
        WHERE oi.order_id = :order_id
    ");
    $itemsStmt->execute(['order_id' => $order_id]);
    $orderItems = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Check if order items were fetched
    if (empty($orderItems)) {
        die("No items found for this order. Please check your data.");
    }
} catch (PDOException $e) {
    die("Failed to fetch order details: " . $e->getMessage());
}
?>


<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php
              include 'header.php';
            ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">

          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Order Details</h4>
                    <div class="card-header-form">
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th>Id</th>
                          <th>Customer Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Total Amount</th>
                          <th>Order Date</th>
                        </tr>
                        <tr>
                          <td ><?php echo htmlspecialchars($order_id); ?></td>
                          <td><?php echo htmlspecialchars($order['name']); ?></td>
                          <td> <?php echo htmlspecialchars($order['email']); ?></td>
                          <td> <?php echo htmlspecialchars($order['phone']); ?></td>
                          <td> <?php echo htmlspecialchars($order['total_amount']); ?></td>
                          <td> <?php echo htmlspecialchars($order['order_date']); ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<!-- items details -->
<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Order Item Details</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Item Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Category Name</th>
                            <th>Kg/Quantity</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <?php if (!empty($orderItems)): ?>
                          <tbody>
                          <?php foreach ($orderItems as $item): ?>
                         
                          <tr>
                            <td>
                            <?php echo htmlspecialchars($item['order_item_id']); ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($item['p_name']) ?>
                            </td>
                            <td>
                              <img src="<?= htmlspecialchars('../uploads/' . $item['p_image']) ?>"
                                alt="<?= htmlspecialchars($item['p_name']) ?>" style="width: 100px;">
                            </td>
                            <td>
                              <?= htmlspecialchars($item['p_price']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($item['p_description']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($item['p_brand']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($item['cat_name']) ?>
                            </td>
                            <td>
                              <?= htmlspecialchars($item['quantity']) ?>
                            </td>
                            <td>
                              <?php if ($item['popular']): ?>
                              <div class="badge badge-success badge-shadow">Popular</div>
                              <?php else: ?>
                              <div class="badge badge-danger badge-shadow">Unpopular</div>
                              <?php endif; ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                        <?php else: ?>
                          <p>No items found for this order.</p>
                          <?php endif; ?>

                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ------------------------------- -->
        </section>
      </div>


<?php
include 'justify.php';
?>
    </div>


    <footer class="main-footer">
      <div class="footer-left">
        <!-- <a href="templateshub.net">Templateshub</a></a> -->
      </div>
      <div class="footer-right">
      </div>
    </footer>
  </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- <script src="assets/bundles/datatables/datatables.min.js"></script> -->
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/jszip.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
  <script src="assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
  <script src="assets/js/page/datatables.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- datatables  21 Nov 2019 03:55:25 GMT -->

</html>
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
<?php
session_start();
include 'db.php'; // Ensure PDO connection

try {
    // Fetch all orders
    $stmt = $conn->prepare("SELECT * FROM orders ORDER BY order_date DESC");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch orders: " . $e->getMessage());
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
                    <h4>Orders</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <thead>
                          <tr>
                          <th>Order ID</th>
                          <th>Customer Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Total Amount</th>
                          <th>Order Date</th>
                          <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
    <?php
        // Assuming $orders is an array of orders fetched from the database
        if (!empty($orders)) {
            // Loop through each item in the $orders array
            foreach ($orders as $order): 
                echo "<tr>";
                echo "<td>" . htmlspecialchars($order['order_id']) . "</td>";
                echo "<td>" . htmlspecialchars($order['name']) . "</td>";
                echo "<td>" . htmlspecialchars($order["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($order["phone"]) . "</td>";
                echo "<td>" . htmlspecialchars($order["total_amount"]) . "</td>";
                echo "<td>" . date("d M Y, h:i A", strtotime($order["order_date"])) . "</td>";
                echo "<td>";
                echo "<a href='order_details.php?order_id=" . htmlspecialchars($order["order_id"]) . "' class='btn btn-primary'>Details</a>";
                echo "</td>";
                echo "</tr>";
            endforeach;
        } else {
            echo "<tr><td colspan='7'>No data available</td></tr>";
        }
    ?>
</tbody>

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
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
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/jszip.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
  <script src="assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
  <script src="assets/js/page/datatables.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- datatables  21 Nov 2019 03:55:25 GMT -->

</html>
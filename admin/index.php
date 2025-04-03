<!DOCTYPE html>
<html lang="en">

<?php session_start(); ?>

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

// Include the database connection (PDO version)
include 'db.php';

// Fetch total products count
$productCountQuery = "SELECT COUNT(*) as totalProducts FROM products";
$stmt = $conn->prepare($productCountQuery);
$stmt->execute();
$productCountRow = $stmt->fetch(PDO::FETCH_ASSOC);
$totalProducts = $productCountRow['totalProducts'];

// Fetch total orders count
$orderCountQuery = "SELECT COUNT(*) as totalOrders FROM orders";
$stmt = $conn->prepare($orderCountQuery);
$stmt->execute();
$orderCountRow = $stmt->fetch(PDO::FETCH_ASSOC);
$totalOrders = $orderCountRow['totalOrders'];

// Fetch total categories count
$categoryCountQuery = "SELECT COUNT(*) as totalCategories FROM category";
$stmt = $conn->prepare($categoryCountQuery);
$stmt->execute();
$categoryCountRow = $stmt->fetch(PDO::FETCH_ASSOC);
$totalCategories = $categoryCountRow['totalCategories'];

// Query to count the number of contacts
$countQuery = "SELECT COUNT(*) AS total_contacts FROM contacts";
$stmt = $conn->prepare($countQuery);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$totalContacts = $row['total_contacts'];

function fetchContacts($conn) {
  try {
      $query = "SELECT id, name, email, message, created_at FROM contacts ORDER BY created_at DESC";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      die("Error fetching contacts: " . $e->getMessage());
  }
}
$contacts = fetchContacts($conn);

?>

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
          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Total products </h5>
                          <h2 class="mb-3 font-18">
                            <?php  echo $totalProducts;?>
                          </h2>
                          <!-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> -->
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/5.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Orders</h5>
                          <h2 class="mb-3 font-18">
                            <?php echo $totalOrders; ?>
                          </h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Category</h5>
                          <h2 class="mb-3 font-18">
                            <?php  echo "$totalCategories"; ?>
                          </h2>
                          <!-- <p class="mb-0"><span class="col-green">18%</span>
                            Increase</p> -->
                        </div>
                      </div>


                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Contacts</h5>
                          <h2 class="mb-3 font-18">
                            <?php  echo $totalContacts ;?>
                          </h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php
          include 'RevenueChart.php';
          ?>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Recent Contact Messages</h4>
                  <div class="card-header-form">
                    <form method="GET" action="">
                      <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                          <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Message</th>
                          <th>Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($contacts)): ?>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                          <td>
                            <?= htmlspecialchars($contact['id']) ?>
                          </td>
                          <td>
                            <?= htmlspecialchars($contact['name']) ?>
                          </td>
                          <td>
                            <?= htmlspecialchars($contact['email']) ?>
                          </td>
                          <td>
                            <?= htmlspecialchars($contact['message']) ?>
                          </td>
                          <td>
                            <?= date("d M Y", strtotime($contact['created_at'])) ?>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                          <td colspan="6" class="text-center">No data available</td>
                        </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php
          include 'Support.php';
          ?>

        </section>
        <?php include 'justify.php'; ?>

      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->

</html>
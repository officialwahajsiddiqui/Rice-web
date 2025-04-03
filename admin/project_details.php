<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: auth-login"); // Redirect to login if not logged in
    exit();
}

include 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if project ID is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Project ID is required.";
    exit();
}

$projectId = intval($_GET['id']); // Sanitize the input

// Fetch project details
$sqlProject = "SELECT * FROM projects WHERE id = ?";
$stmtProject = $conn->prepare($sqlProject);
$stmtProject->bind_param("i", $projectId);
$stmtProject->execute();
$resultProject = $stmtProject->get_result();
$project = $resultProject->fetch_assoc();

if (!$project) {
    echo "Project not found.";
    exit();
}

// Fetch associated languages and progress values
$sqlDetails = "SELECT * FROM project_details WHERE project_id = ?";
$stmtDetails = $conn->prepare($sqlDetails);
$stmtDetails->bind_param("i", $projectId);
$stmtDetails->execute();
$resultDetails = $stmtDetails->get_result();

// Fetch associated images
$sqlImages = "SELECT * FROM project_images WHERE project_id = ?";
$stmtImages = $conn->prepare($sqlImages);
$stmtImages->bind_param("i", $projectId);
$stmtImages->execute();
$resultImages = $stmtImages->get_result();
?>

<!DOCTYPE html>
<html lang="en">


<!-- carousel  21 Nov 2019 04:04:45 GMT -->

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

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
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
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="assets/img/user.png"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello Sarah Smith</div>
              <a href="profile" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> <a href="timeline" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="auth-login" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
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
            <li class="dropdown">
              <a href="index" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>


            <li class="dropdown">
              <a href="contact" class="nav-link"><i data-feather="mail"></i><span>Contacts Us</span></a>
            </li>

            <li class="menu-header">Projects</li>
            <li class="dropdown active">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file"></i><span>Projects</span></a>
              <ul class="dropdown-menu">
                <li><a href="Addproject">Add Projects</a></li>
                <li><a href="Allprojects">All Projects</a></li>
              </ul>
            </li>


            <!-- <li><a class="nav-link" href="blank"><i data-feather="file"></i><span>Blank Page</span></a></li> -->


            <!-- <li class="menu-header">Pages</li> -->
            <!-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="user-check"></i><span>Auth</span></a>
              <ul class="dropdown-menu">
                <li><a href="auth-login">Login</a></li>
                <li><a href="auth-register">Register</a></li>
                <li><a href="auth-forgot-password">Forgot Password</a></li>
                <li><a href="auth-reset-password">Reset Password</a></li>
                <li><a href="subscribe">Subscribe</a></li>
              </ul>
            </li> -->

          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>
                      <?php echo htmlspecialchars($project['project_name']); ?>
                    </h4>
                    <p>
                      <?php echo date('F d, Y h:i A', strtotime($project['created_at'])); ?>
                    </p>
                  </div>
                  <div class="card-body">
                    <!-- Project Details -->
                    <p><strong>Description:</strong>
                      <?php echo htmlspecialchars($project['Project_Discription']); ?>
                    </p>
                    <p><strong>Project Link:</strong>
                      <a href="<?php echo htmlspecialchars($project['Project_Link']); ?>" target="_blank">
                        <?php echo htmlspecialchars($project['Project_Link']); ?>
                      </a>
                    </p>

                    <!-- Carousel for Project Images -->
                    <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        <?php 
                            $counter = 0;
                            while ($image = $resultImages->fetch_assoc()): 
                            ?>
                        <li data-target="#carouselExampleIndicators3" data-slide-to="<?php echo $counter; ?>"
                          class="<?php echo $counter === 0 ? 'active' : ''; ?>"></li>
                        <?php $counter++; ?>
                        <?php endwhile; ?>
                      </ol>
                      <div class="carousel-inner">
                        <?php 
                            $resultImages->data_seek(0); // Reset result pointer for iteration
                            $counter = 0; 
                            while ($image = $resultImages->fetch_assoc()): 
                            ?>
                        <div class="carousel-item <?php echo $counter === 0 ? 'active' : ''; ?>">
                          <img class="d-block w-100"
                            src="../public/uploads/<?php echo htmlspecialchars($image['image']); ?>"
                            alt="Slide <?php echo $counter + 1; ?>">
                        </div>
                        <?php $counter++; ?>
                        <?php endwhile; ?>
                      </div>
                      <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>

                    <!-- Progress Bars for Languages -->
                    <div class="card-body">
                      <h5>Languages and Progress</h5>
                      <?php if ($resultDetails->num_rows > 0): ?>
                      <?php while ($detail = $resultDetails->fetch_assoc()): ?>
                      <p>
                        <?php echo htmlspecialchars($detail['language']); ?>
                      </p>
                      <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar"
                          style="width: <?php echo $detail['progress_value']; ?>%;"
                          aria-valuenow="<?php echo $detail['progress_value']; ?>" aria-valuemin="0"
                          aria-valuemax="100">
                          <?php echo $detail['progress_value']; ?>%
                        </div>
                      </div>
                      <?php endwhile; ?>
                      <?php else: ?>
                      <p>No language progress details found.</p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


      </div>
      </section>
      <div class="settingSidebar">
        <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
        </a>
        <div class="settingSidebar-body ps-container ps-theme-default">
          <div class=" fade show active">
            <div class="setting-panel-header">Setting Panel
            </div>
            <div class="p-15 border-bottom">
              <h6 class="font-medium m-b-10">Select Layout</h6>
              <div class="selectgroup layout-color w-50">
                <label class="selectgroup-item">
                  <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                  <span class="selectgroup-button">Light</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                  <span class="selectgroup-button">Dark</span>
                </label>
              </div>
            </div>
            <div class="p-15 border-bottom">
              <h6 class="font-medium m-b-10">Sidebar Color</h6>
              <div class="selectgroup selectgroup-pills sidebar-color">
                <label class="selectgroup-item">
                  <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                  <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                    data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                  <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                    data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                </label>
              </div>
            </div>
            <div class="p-15 border-bottom">
              <h6 class="font-medium m-b-10">Color Theme</h6>
              <div class="theme-setting-options">
                <ul class="choose-theme list-unstyled mb-0">
                  <li title="white" class="active">
                    <div class="white"></div>
                  </li>
                  <li title="cyan">
                    <div class="cyan"></div>
                  </li>
                  <li title="black">
                    <div class="black"></div>
                  </li>
                  <li title="purple">
                    <div class="purple"></div>
                  </li>
                  <li title="orange">
                    <div class="orange"></div>
                  </li>
                  <li title="green">
                    <div class="green"></div>
                  </li>
                  <li title="red">
                    <div class="red"></div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="p-15 border-bottom">
              <div class="theme-setting-options">
                <label class="m-b-0">
                  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                    id="mini_sidebar_setting">
                  <span class="custom-switch-indicator"></span>
                  <span class="control-label p-l-10">Mini Sidebar</span>
                </label>
              </div>
            </div>
            <div class="p-15 border-bottom">
              <div class="theme-setting-options">
                <label class="m-b-0">
                  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                    id="sticky_header_setting">
                  <span class="custom-switch-indicator"></span>
                  <span class="control-label p-l-10">Sticky Header</span>
                </label>
              </div>
            </div>
            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
              <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                <i class="fas fa-undo"></i> Restore Default
              </a>
            </div>
          </div>
        </div>
      </div>
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
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- carousel  21 Nov 2019 04:04:46 GMT -->

</html>
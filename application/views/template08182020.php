<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$title?> :: CBHCA Portal</title>
    <!-- plugins:css -->
	<link rel="stylesheet" href="<?=dirname(base_url())?>/assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/css/vendor.bundle.addons.css">
	
	<script src="<?=dirname(base_url())?>/assets/js/jquery-3.5.1.min.js"></script>
	
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="<?=dirname(base_url())?>/assets/images/favicon.png" />
	
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="<?=site_url("dashboard")?>">
            <img src="<?=dirname(base_url())?>/assets/images/dashboard_logo.png" alt="logo" /> </a>
          <a class="navbar-brand brand-logo-mini" href="<?=site_url("dashboard")?>">
            <img src="<?=dirname(base_url())?>/assets/images/logo-mini.svg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block"><span class="text-success"><?=$this->session->userdata('current_schoolyear')?></span> // <?=$title?></li>
            
          </ul>
          
          <ul class="navbar-nav ml-auto">
             <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="<?=site_url("dashboard")?>" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?=dirname(base_url())?>/assets/images/faces/face8.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?=dirname(base_url())?>/assets/images/faces/face8.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><?=$this->session->userdata('current_firstname')?></p>
				  <p class="font-weight-light text-muted mb-0"><?=$this->session->userdata('current_mobileno')?></p>
                  
                </div>
                <a class="dropdown-item" href="<?=site_url("myprofile")?>">My Profile</a>
                <a class="dropdown-item" href="<?=site_url("logout")?>">Log-out<i class="dropdown-item-icon ti-power-off"></i></a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="<?=site_url("dashboard")?>" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="<?=dirname(base_url())?>/assets/images/faces/face8.png" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?=$this->session->userdata('current_firstname')?></p>
                  <p class="designation"><?=$this->session->userdata('current_usertype')?></p>
                </div>
              </a>
            </li>
			
            <?php $this->load->view("menu"); ?>
			
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper"> 
          <div class="row"> 
		  <?php $this->load->view($template); ?>
		  </div>
		  </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020 <a href="http://www.bobhughes.edu.ph/" target="_blank">Bob Hughes Christian Academy</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">support@bobhughes.edu.ph <i class="mdi mdi-heart text-danger"></i>
              </span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=dirname(base_url())?>/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=dirname(base_url())?>/assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?=dirname(base_url())?>/assets/js/shared/off-canvas.js"></script>
    <script src="<?=dirname(base_url())?>/assets/js/shared/misc.js"></script>
    <script src="<?=dirname(base_url())?>/assets/js/jquery.dataTables.min.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
	

	
  </body>
</html>
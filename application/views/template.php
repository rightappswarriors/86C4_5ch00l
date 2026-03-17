<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$title?> :: CBHCA Portal</title>
    <!-- plugins:css -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.addons.css">
  	
	<link rel="stylesheet" href="<?=base_url()?>assets/css/tabs.css">
	<script src="<?=base_url()?>assets/js/tabs.js"></script>
  	
	<script src="<?=base_url()?>assets/js/jquery-3.5.1.min.js"></script>
  	
	<script src="<?=base_url()?>assets/index.global.js"></script>
	
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
  	
	<script>
	
	$(function(){
		
		$(".dropdown-item-schoolyear").on("click",function(){
			
			var sy_id = $(this).attr("id"); 
			var sy_name = $(this).attr("alt");
			
			$("body").css("cursor", "progress");
			$.post( "<?=site_url("dashboard/changesy")?>", { sy_id: sy_id, sy_name: sy_name } );
			setTimeout(function() { location.reload(); }, 2000);
			
		});
		
	});
	
	</script>
	
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="<?=site_url("dashboard")?>">
            <img src="<?=base_url()?>assets/images/dashboard_logo.png" alt="logo" /> </a>
          <a class="navbar-brand brand-logo-mini" href="<?=site_url("dashboard")?>">
            <img src="<?=base_url()?>assets/images/logo-mini.svg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <!-- SCHOOL YEAR Options -->
		  <ul class="navbar-nav">
            <!--<li class="nav-item font-weight-semibold d-none d-lg-block">
				<span class="text-success"><?=$this->session->userdata('current_schoolyear')?></span> // <?=$title?>
			</li>-->
            <li class="nav-item dropdown language-dropdown"> 
              <a class="nav-link dropdown-toggle px-2 d-flex align-items-center" id="LanguageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="d-inline-flex mr-0 mr-md-3">
                   
                </div>
                <span class="text-success" style="font-weight:bold;"><?=$this->session->userdata('current_schoolyear')?></span>
              </a>
              <div style="text-align:center;" class="dropdown-menu dropdown-menu-left navbar-dropdown py-2" aria-labelledby="LanguageDropdown">
				<?php
				$otherschoolyears = $this->session->userdata('other_schoolyears');
				foreach($otherschoolyears as $index_s=>$otherschoolyears):
					if($this->session->userdata('current_schoolyearid')!=$index_s){
					?><a style="line-height:25px;cursor:pointer;" class="dropdown-item-schoolyear" id="<?=$index_s?>" alt="<?=$otherschoolyears?>"><?=$otherschoolyears?></a><br><?php }
				endforeach;
				?>
              </div>
            </li><li style="font-weight:bold;">// <?=$title?></li>
          </ul>
          
		  
		  
          <ul class="navbar-nav ml-auto">
			
             <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="<?=site_url("dashboard")?>" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="Profile image">
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
          <div class="sidebar-toggle-wrap">
            <button class="sidebar-text-toggle sidebar-text-toggle-top" type="button" aria-label="Toggle sidebar text">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="<?=site_url("myprofile")?>" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="profile image">
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
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?=base_url()?>assets/js/shared/off-canvas.js"></script>
    <script src="<?=base_url()?>assets/js/shared/misc.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>
    <script>
      $(function () {
        var sidebarToggleKey = 'sidebarTextHidden';
        var $body = $('body');
        var $sidebarToggle = $('.sidebar-text-toggle');

        if (localStorage.getItem(sidebarToggleKey) === '1') {
          $body.addClass('sidebar-text-hidden');
        }

        $sidebarToggle.on('click', function () {
          $body.toggleClass('sidebar-text-hidden');
          localStorage.setItem(sidebarToggleKey, $body.hasClass('sidebar-text-hidden') ? '1' : '0');
        });
      });
    </script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
	
	<script src="<?=base_url('assets')?>/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url('assets')?>/js/jszip.min.js"></script>
  <script src="<?=base_url('assets')?>/js/pdfmake.min.js"></script>
  <script src="<?=base_url('assets')?>/js/vfs_fonts.js"></script>
  <script src="<?=base_url('assets')?>/js/buttons.html5.min.js"></script>
  
  <?php $this->load->view('support_chat_widget'); ?>
  
  </body>
</html>

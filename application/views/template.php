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
    <link rel="stylesheet" href="<?=base_url()?>assets/css/portal-layout.css">
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
  <?php
    $CI =& get_instance();
    $current_usertype = strtolower((string) $CI->session->userdata('current_usertype'));
    $student_user_id = $CI->session->userdata('current_userid');
    $student_portal_settings = array();
    $body_classes = array();
    $hide_profile_photo = false;
    $hide_mobile_number = false;
    $limit_personal_details = false;
    $remember_sidebar_state = true;

    if ($current_usertype === 'student') {
      $CI->load->model('student_settings_model');
      $student_portal_settings = $CI->student_settings_model->get_or_create_for_user($student_user_id);

      if (!empty($student_portal_settings['dark_mode'])) {
        $body_classes[] = 'student-theme-dark';
      }

      if (!empty($student_portal_settings['compact_layout'])) {
        $body_classes[] = 'student-layout-compact';
      }

      if (!empty($student_portal_settings['high_contrast'])) {
        $body_classes[] = 'student-high-contrast';
      }

      if (!empty($student_portal_settings['reduce_motion'])) {
        $body_classes[] = 'student-reduce-motion';
      }

      if (!empty($student_portal_settings['larger_text']) || ($student_portal_settings['font_size'] ?? '') === 'large') {
        $body_classes[] = 'student-font-large';
      } elseif (($student_portal_settings['font_size'] ?? '') === 'small') {
        $body_classes[] = 'student-font-small';
      }

      if (empty($student_portal_settings['show_welcome_card'])) {
        $body_classes[] = 'student-hide-welcome-card';
      }

      if (!empty($student_portal_settings['compact_dashboard_cards'])) {
        $body_classes[] = 'student-compact-dashboard';
      }

      if (empty($student_portal_settings['emphasize_primary_actions'])) {
        $body_classes[] = 'student-soft-primary-actions';
      }

      $hide_profile_photo = !empty($student_portal_settings['hide_profile_photo']);
      $hide_mobile_number = !empty($student_portal_settings['hide_mobile_number']);
      $limit_personal_details = !empty($student_portal_settings['limit_personal_details']);
      $remember_sidebar_state = !empty($student_portal_settings['remember_sidebar_state']);
    }
  ?>
  <body class="<?=htmlspecialchars(implode(' ', $body_classes), ENT_QUOTES, 'UTF-8')?>" data-sidebar-memory="<?=$remember_sidebar_state ? '1' : '0'?>">
    <?php
    $student_notification_count = 0;
    $student_notification_preview = array();
    $student_notification_tables = array(
      'classroom_students',
      'classroom_classes',
      'classroom_activities',
      'classroom_announcements',
    );
    $student_notifications_ready = true;
    $student_user_id = $this->session->userdata('current_userid');

    if ($current_usertype === 'student') {
      foreach ($student_notification_tables as $table_name) {
        if (!$this->db->table_exists($table_name)) {
          $student_notifications_ready = false;
          break;
        }
      }

      if ($student_notifications_ready) {
        $this->load->model('Classroom_model', 'student_classroom_model');

        if (isset($this->student_classroom_model) && is_object($this->student_classroom_model)) {
          $student_notification_count = $this->student_classroom_model->count_recent_student_notifications($student_user_id, 7);
          $student_notification_preview = $this->student_classroom_model->get_student_notifications($student_user_id, 3);
        }
      }
    }
    ?>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="<?=site_url("dashboard")?>">
            <img src="<?=base_url()?>assets/images/dashboard_logo.png" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="<?=site_url("dashboard")?>">
            <img src="<?=base_url()?>assets/images/logo-mini.svg" alt="logo" />
          </a>
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
                <span class="text-success current-schoolyear-label"><?=$this->session->userdata('current_schoolyear')?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2 schoolyear-dropdown-menu" aria-labelledby="LanguageDropdown">
				<?php
				$otherschoolyears = $this->session->userdata('other_schoolyears');
				foreach($otherschoolyears as $index_s=>$otherschoolyears):
					if($this->session->userdata('current_schoolyearid')!=$index_s){
					?><a class="dropdown-item-schoolyear schoolyear-dropdown-item" id="<?=$index_s?>" alt="<?=$otherschoolyears?>"><?=$otherschoolyears?></a><br><?php }
				endforeach;
				?>
              </div>
            </li><li class="page-title-label">// <?=$title?></li>
          </ul>
          
		  
		  
          <ul class="navbar-nav ml-auto">
			
             <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
               <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                 <?php if ($hide_profile_photo): ?>
                 <span class="profile-avatar-placeholder profile-avatar-placeholder-nav"><i class="mdi mdi-account-circle"></i></span>
                 <?php else: ?>
                 <img class="img-xs rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="Profile image">
                 <?php endif; ?>
               </a>
               <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                 <div class="dropdown-header text-center">
                   <?php if ($hide_profile_photo): ?>
                   <span class="profile-avatar-placeholder profile-avatar-placeholder-menu"><i class="mdi mdi-account-circle"></i></span>
                   <?php else: ?>
                   <img class="img-md rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="Profile image">
                   <?php endif; ?>
                   <p class="mb-1 mt-3 font-weight-bold text-dark profile-name"><?=$this->session->userdata('current_firstname')?></p>
				  <p class="font-weight-bold text-dark mb-0 profile-detail"><?=$this->session->userdata('current_usertype_display') ?: $this->session->userdata('current_usertype')?></p>
				  <?php if (!$limit_personal_details && !$hide_mobile_number): ?>
				  <p class="font-weight-bold text-dark mb-0 profile-detail"><?=$this->session->userdata('current_mobileno')?></p>
				  <?php elseif ($limit_personal_details): ?>
				  <p class="font-weight-bold text-dark mb-0 profile-detail">Private student profile</p>
				  <?php endif; ?>
                     
                 </div>
                 <?php if ($current_usertype === 'student'): ?>
                 <a class="dropdown-item d-flex justify-content-between align-items-center" href="<?=site_url('classroom/student_notifications')?>">
                   <span><i class="mdi mdi-bell-outline mr-2"></i>Notifications</span>
                   <?php if ($student_notification_count > 0): ?>
                   <span class="badge badge-pill badge-danger"><?=$student_notification_count?></span>
                   <?php endif; ?>
                 </a>
                 <?php if (!empty($student_notification_preview)): ?>
                 <div class="notification-preview-list">
                   <?php foreach ($student_notification_preview as $preview_item): ?>
                   <a href="<?=site_url('classroom/student_class/' . $preview_item->class_id)?>" class="notification-preview-item">
                     <div class="notification-preview-title"><?=htmlspecialchars($preview_item->title, ENT_QUOTES, 'UTF-8')?></div>
                     <div class="notification-preview-meta"><?=$preview_item->class_name?><?php if (!empty($preview_item->created_at)): ?> | <?=date('M d', strtotime($preview_item->created_at))?><?php endif; ?></div>
                   </a>
                   <?php endforeach; ?>
                 </div>
                 <?php endif; ?>
                 <?php endif; ?>
                 <a class="dropdown-item" href="<?=site_url("myprofile")?>">My Account</a>
                 <?php if ($current_usertype === 'student'): ?>
                 <a class="dropdown-item d-flex justify-content-between align-items-center" href="<?=site_url("myprofile/settings")?>">
                   <span><i class="mdi mdi-cog-outline mr-2"></i>Settings</span>
                   <i class="mdi mdi-chevron-right"></i>
                 </a>
                 <?php endif; ?>
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
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright Â© <?php echo date("Y"); ?> <a href="http://www.bobhughes.edu.ph/" target="_blank">Bob Hughes Christian Academy</a>. All rights reserved.</span>
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
        var shouldRememberSidebar = $body.data('sidebar-memory') === 1 || $body.data('sidebar-memory') === '1';

        if (shouldRememberSidebar && localStorage.getItem(sidebarToggleKey) === '1') {
          $body.addClass('sidebar-text-hidden');
        } else if (!shouldRememberSidebar) {
          localStorage.removeItem(sidebarToggleKey);
        }

        $sidebarToggle.on('click', function () {
          $body.toggleClass('sidebar-text-hidden');
          if (shouldRememberSidebar) {
            localStorage.setItem(sidebarToggleKey, $body.hasClass('sidebar-text-hidden') ? '1' : '0');
          } else {
            localStorage.removeItem(sidebarToggleKey);
          }
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

 <!-- Enrollment Procedures Modal -->
 <div class="modal fade" id="enrollmentStepsModal" tabindex="-1" role="dialog" aria-labelledby="enrollmentStepsModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content enrollment-modal-content">
       <div class="modal-header bg-gradient-primary text-white enrollment-modal-header">
         <div>
           <h4 class="modal-title font-weight-bold" id="enrollmentStepsModalLabel">
             <i class="mdi mdi-school"></i> Enrollment Procedures
           </h4>
           <p class="mb-0 small">7-Step Guide for New Students & Transferees</p>
         </div>
         <button type="button" class="close text-white enrollment-modal-close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="enrollment-modal-close-icon">&times;</span>
         </button>
       </div>
       <div class="modal-body enrollment-modal-body">
         <div class="enrollment-timeline">
           
           <!-- Online Section -->
           <div class="timeline-section mb-4">
             <div class="d-flex align-items-center mb-3">
               <span class="badge badge-primary badge-pill p-2 mr-2 enrollment-section-badge">
                 <i class="mdi mdi-laptop"></i> ONLINE
               </span>
             </div>
             <div class="step-box">
               <div class="step-number">1</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">Online Registration & Fetcher's ID</h6>
                 <p class="mb-0 text-muted">Register at: <a href="https://portal.bobhughes.edu.ph/" target="_blank" class="text-primary font-weight-bold">portal.bobhughes.edu.ph</a></p>
               </div>
             </div>
           </div>
           
           <!-- In Person Section -->
           <div class="timeline-section">
             <div class="d-flex align-items-center mb-3">
               <span class="badge badge-success badge-pill p-2 mr-2 enrollment-section-badge">
                 <i class="mdi mdi-account-location"></i> IN PERSON
               </span>
             </div>
             
             <div class="step-box">
               <div class="step-number">2</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">Diagnostic Test / Academic Assessment</h6>
                 <p class="mb-0 text-muted">Student undergoes assessment for grade placement</p>
               </div>
             </div>
             
             <div class="step-box">
               <div class="step-number">3</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">Financial Assessment</h6>
                 <p class="mb-0 text-muted">Meet with accounting office for tuition & payment plans</p>
               </div>
             </div>
             
             <div class="step-box">
               <div class="step-number">4</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">Interview with Principal</h6>
                 <p class="mb-0 text-muted">
                   <span class="badge badge-warning text-dark">RR - Grade 3</span> Parents Only
                   <span class="mx-1">|</span>
                   <span class="badge badge-info">Grades 4-12</span> Parents + Students
                 </p>
               </div>
             </div>
             
             <div class="step-box">
               <div class="step-number">5</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">Down Payment</h6>
                 <p class="mb-0 text-muted">Pay <span class="text-success font-weight-bold">PHP 15,000</span> to Accounting Office</p>
               </div>
             </div>
             
             <div class="step-box">
               <div class="step-number">6</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">Submit Documents</h6>
                 <p class="mb-0 text-muted">Submit signed documents & sign for Fetcher's ID</p>
               </div>
             </div>
             
             <div class="step-box">
               <div class="step-number">7</div>
               <div class="step-content">
                 <h6 class="font-weight-bold mb-1">PACeS Issuance</h6>
                 <p class="mb-0 text-muted">Submit enrollment proof to L.C. Supervisor</p>
               </div>
             </div>
           </div>
           
         </div>
       </div>
       <div class="modal-footer enrollment-modal-footer">
         <button type="button" class="btn btn-primary btn-lg btn-block" data-dismiss="modal">
           <i class="mdi mdi-check-circle"></i> Got It!
         </button>
       </div>
     </div>
   </div>
 </div>

 </body>
</html>


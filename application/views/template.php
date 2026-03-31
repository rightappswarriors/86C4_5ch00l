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
  <body>
    <?php
    $current_usertype = strtolower((string) $this->session->userdata('current_usertype'));
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
               <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                 <img class="img-xs rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="Profile image"> </a>
               <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                 <div class="dropdown-header text-center">
                   <img class="img-md rounded-circle" src="<?=base_url()?>assets/images/faces/face8.png" alt="Profile image">
                   <p class="mb-1 mt-3 font-weight-bold text-dark" style="font-size:16px;"><?=$this->session->userdata('current_firstname')?></p>
				  <p class="font-weight-bold text-dark mb-0" style="font-size:14px;"><?=$this->session->userdata('current_usertype_display') ?: $this->session->userdata('current_usertype')?></p>
				  <p class="font-weight-bold text-dark mb-0" style="font-size:14px;"><?=$this->session->userdata('current_mobileno')?></p>
                     
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

 <!-- Enrollment Procedures Modal -->
 <div class="modal fade" id="enrollmentStepsModal" tabindex="-1" role="dialog" aria-labelledby="enrollmentStepsModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
       <div class="modal-header bg-gradient-primary text-white" style="padding: 20px 25px;">
         <div>
           <h4 class="modal-title font-weight-bold" id="enrollmentStepsModalLabel">
             <i class="mdi mdi-school"></i> Enrollment Procedures
           </h4>
           <p class="mb-0 small">7-Step Guide for New Students & Transferees</p>
         </div>
         <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
           <span aria-hidden="true" style="font-size: 28px;">&times;</span>
         </button>
       </div>
       <div class="modal-body" style="padding: 25px;">
         <div class="enrollment-timeline">
           
           <!-- Online Section -->
           <div class="timeline-section mb-4">
             <div class="d-flex align-items-center mb-3">
               <span class="badge badge-primary badge-pill p-2 mr-2" style="font-size: 14px;">
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
               <span class="badge badge-success badge-pill p-2 mr-2" style="font-size: 14px;">
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
       <div class="modal-footer" style="padding: 15px 25px;">
         <button type="button" class="btn btn-primary btn-lg btn-block" data-dismiss="modal">
           <i class="mdi mdi-check-circle"></i> Got It!
         </button>
       </div>
     </div>
   </div>
 </div>

 <style>
 .step-box {
   display: flex;
   align-items: flex-start;
   background: #f8f9fa;
   border-radius: 10px;
   padding: 15px;
   margin-bottom: 12px;
   border-left: 4px solid #4caf50;
   transition: all 0.3s ease;
 }
 .step-box:hover {
   background: #e8f5e9;
   transform: translateX(5px);
   box-shadow: 0 2px 8px rgba(0,0,0,0.1);
 }
 .step-number {
   min-width: 35px;
   height: 35px;
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   color: white;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   font-weight: bold;
   font-size: 16px;
   margin-right: 15px;
 }
 .timeline-section:first-child .step-box {
   border-left-color: #667eea;
 }
 .timeline-section:first-child .step-number {
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
 }
 .bg-gradient-primary {
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
 }
 </style>

 </body>
</html>

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

	<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/template_print.css">
	<?php if (($template ?? '') === 'payments/statement_print'): ?>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/statement_print.css">
	<?php endif; ?>
	
  </head>
  <body>
  
	<!-- Print Header with Actions -->
	<div class="print-header">
		<div class="logo-section">
			<img src="<?=base_url()?>assets/images/logo_portal.png" alt="School Logo">
			<div class="school-info">
				<h4>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</h4>
				<p>55 Katipunan St., Brgy. Calamba, Cebu City 6000</p>
			</div>
		</div>
		<div class="print-actions">
			<button onclick="window.print()" class="print-btn">
				<i class="mdi mdi-printer"></i> Print Receipt
			</button>
			<button onclick="window.history.back()" class="close-btn">
				<i class="mdi mdi-arrow-left"></i> Close
			</button>
		</div>
	</div>
	<div style="margin: 0 30px 25px; border-top: 3px solid #e0e0e0; border-radius: 3px;"></div>

  
    <?php $this->load->view($template); ?>
	
	<script>
	// Optional: Auto-trigger print dialog on page load (uncomment if needed)
	// window.onload = function() {
	//     window.print();
	// };
	</script>
  </body>
</html>

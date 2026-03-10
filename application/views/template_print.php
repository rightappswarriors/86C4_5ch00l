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
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/css/vendor.bundle.addons.css">
  	
  	<link rel="stylesheet" href="<?=dirname(base_url())?>/assets/css/tabs.css">
  	<script src="<?=dirname(base_url())?>/assets/js/tabs.js"></script>
  	
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

	<link rel="stylesheet" href="<?=dirname(base_url())?>/assets/css/Dashboard/template_print.css">
	
	<style>
	/* Print Template Styles */
	.print-header {
		background: #f8f9fa;
		border-bottom: 2px solid #2196f3;
		padding: 15px 20px;
		margin-bottom: 20px;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	
	.print-header .logo-section {
		display: flex;
		align-items: center;
		gap: 15px;
	}
	
	.print-header .logo-section img {
		width: 80px;
		height: auto;
	}
	
	.print-header .school-info h4 {
		margin: 0;
		color: #2196f3;
		font-weight: 700;
	}
	
	.print-header .school-info p {
		margin: 5px 0 0;
		color: #666;
		font-size: 12px;
	}
	
	.print-actions {
		display: flex;
		gap: 10px;
	}
	
	.print-btn {
		background: #2196f3;
		color: white;
		border: none;
		padding: 10px 20px;
		border-radius: 5px;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		font-weight: 500;
		transition: all 0.3s ease;
	}
	
	.print-btn:hover {
		background: #1976d2;
		transform: translateY(-2px);
		box-shadow: 0 4px 10px rgba(33, 150, 243, 0.3);
	}
	
	.close-btn {
		background: #6c757d;
		color: white;
		border: none;
		padding: 10px 20px;
		border-radius: 5px;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		font-weight: 500;
		text-decoration: none;
		transition: all 0.3s ease;
	}
	
	.close-btn:hover {
		background: #5a6268;
		transform: translateY(-2px);
	}
	
	.card{ border:0;padding:0;margin:0; }
	.card .card-body{ padding:3px; }
	
	@media print {
		.print-header,
		.print-actions,
		.close-btn {
			display: none !important;
		}
		
		body {
			padding: 0;
			margin: 0;
		}
		
		.col-xs-12 {
			width: 50%;
			float: left;
		}
		
		.row {
			page-break-inside: avoid;
		}
		
		.card {
			box-shadow: none;
			border: none;
		}
	}
	
	/* Responsive */
	@media (max-width: 768px) {
		.print-header {
			flex-direction: column;
			text-align: center;
			gap: 15px;
		}
		
		.print-actions {
			width: 100%;
			justify-content: center;
		}
	}
	</style>
	
  </head>
  <body>
  
	<!-- Print Header with Actions -->
	<div class="print-header">
		<div class="logo-section">
			<img src="<?=dirname(base_url())?>/assets/images/logo_portal.png" alt="School Logo">
			<div class="school-info">
				<h4>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</h4>
				<p>55 Katipunan St., Brgy. Calamba, Cebu City 6000</p>
			</div>
		</div>
		<div class="print-actions">
			<button onclick="window.print()" class="print-btn">
				<i class="mdi mdi-printer"></i> Print
			</button>
			<button onclick="window.history.back()" class="close-btn">
				<i class="mdi mdi-arrow-left"></i> Back
			</button>
		</div>
	</div>
  
    <?php $this->load->view($template); ?>
	
	<script>
	// Optional: Auto-trigger print dialog on page load (uncomment if needed)
	// window.onload = function() {
	//     window.print();
	// };
	</script>
  </body>
</html>

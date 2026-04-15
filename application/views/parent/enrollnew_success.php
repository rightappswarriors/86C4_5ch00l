<style>
  .enrollment-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 15px 20px;
    font-family: Arial, sans-serif;
    flex-wrap: wrap;
    margin-bottom: 20px;
    background: #f8f9fa;
    border-radius: 8px;
  }

  .enrollment-breadcrumb li {
    list-style: none;
    display: flex;
    align-items: center;
  }

  .enrollment-breadcrumb .step {
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
  }

  .enrollment-breadcrumb .step.current {
    background: #1976d2;
    color: #ffffff;
  }

  .enrollment-breadcrumb .step.passed {
    background: #28a745;
    color: #ffffff;
  }

  .enrollment-breadcrumb .step.pending {
    background: #e9ecef;
    color: #6c757d;
  }

  .enrollment-breadcrumb .arrow {
    color: #adb5bd;
    font-size: 14px;
    margin: 0 2px;
  }

  .enrollment-breadcrumb .step:hover {
    opacity: 0.9;
  }

.content-wrapper {
    margin-top: 0;
  }
</style>
<style>
  .enrollment-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 20px;
    font-family: Arial, sans-serif;
    flex-wrap: wrap;
    margin: 0 auto 20px auto;
    background: #f8f9fa;
    border-radius: 8px;
    max-width: 800px;
  }

  .enrollment-breadcrumb li {
    list-style: none;
    display: flex;
    align-items: center;
  }

  .enrollment-breadcrumb .step {
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
  }

  .enrollment-breadcrumb .step.current {
    background: #1976d2;
    color: #ffffff;
  }

  .enrollment-breadcrumb .step.passed {
    background: #28a745;
    color: #ffffff;
  }

  .enrollment-breadcrumb .step.pending {
    background: #e9ecef;
    color: #6c757d;
  }

  .enrollment-breadcrumb .arrow {
    color: #adb5bd;
    font-size: 14px;
    margin: 0 2px;
  }
</style>

<ol class="enrollment-breadcrumb">
  <li><span class="step passed">1. Register with Handbook</span></li>
  <li><span class="arrow">›</span></li>
  <li><span class="step passed">2. Fill Up Enrollment Form</span></li>
  <li><span class="arrow">›</span></li>
  <li><span class="step current">3. Print Form / Save QR Code</span></li>
</ol>


<div class="content-wrapper">

<div class="col-md-12 grid-margin">
	
	<div class="card">
	  <div class="card-body" style="text-align:center;">
		
		<h3 class="heading text-success" style="text-align:center;">Successfully submitted!</h3>
		<p>The registar will review all the information submitted.  Expect a call for confirmation and for the next step procedures.</p>
		<p><mark><code>Please prepare the necessary requirements below.</code></mark></p>
		
		<!-- QR Code and Print Section -->
		<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
			<div class="col-md-12">
				<div class="card" style="background: #f8f9fa; padding: 20px;">
					<h4 class="text-info">Enrollment Confirmation</h4>
					<p>Scan the QR code below to verify enrollment.</p>
					
					<div style="margin: 20px auto; display: inline-block;">
						<canvas id="qr-success-canvas" style="border: 2px solid #ddd; padding: 10px; border-radius: 8px;"></canvas>
					</div>
					
					<div class="row" style="margin-top: 15px;">
						<div class="col-md-12">
							<?php if($current_usertype != 'Parent'): ?>
							<a href="<?=isset($print_url) ? $print_url : site_url('students/enrollment_receipt/' . $student_id)?>" target="_blank" type="button" class="btn btn-lg btn-info btn-fw"><i class="mdi mdi-printer"></i> Print Enrollment Form</a>
							<?php endif; ?>
							<a href="<?=site_url('students/updateinfo/' . $student_id)?>" type="button" class="btn btn-lg btn-primary btn-fw"><i class="mdi mdi-pencil"></i> Edit Enrollment Form</a>
							<a href="<?=site_url('enroll/view_student_info/' . $student_id)?>" target="_blank" type="button" class="btn btn-lg btn-warning btn-fw"><i class="mdi mdi-eye"></i> View Student Info</a>
							<a href="<?=site_url('enroll/assessment/' . $student_id)?>" type="button" class="btn btn-lg btn-success btn-fw"><i class="mdi mdi-school"></i> Go to Assessment</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
	<div class="col-md-12">
	  <div class="form-group row">
		
		<iframe src="<?=base_url()?>/file/ADMISSION_POLICIES.pdf" width="100%" height="450px">
    	</iframe>
		
	  </div>
	</div>
	</div>
			
	<div class="row">		
		<div class="col-md-6">
			<a href="<?=site_url("students/docs/".$student_id)?>" type="button" class="btn btn-lg btn-success btn-fw"><i class="mdi mdi-file-document"></i>Ready for the requirement(s), upload now!</a>
		</div>
		<div class="col-md-6">
			<a href="<?=site_url("students/enrollnew_form")?>" type="button" class="btn btn-lg btn-primary btn-fw"><i class="mdi mdi-file-document"></i>Enroll another Student</a>
		</div>
	</div>
	
	</div>	
	</div>	
</div>

<!-- QR Code Generation -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	var studentId = <?= $student_id ?>;
	// QR code now contains a URL that redirects to enrollment receipt
	var qrData = "<?= site_url('enroll/enrollment_receipt/') ?>" + studentId;
	var canvas = document.getElementById('qr-success-canvas');
	if(canvas) {
		QRCode.toCanvas(canvas, qrData, { width: 250 }, function(error) {
			if (error) console.error(error);
		});
	}
});
</script>

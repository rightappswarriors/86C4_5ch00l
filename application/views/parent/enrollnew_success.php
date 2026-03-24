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
					<h4 class="text-info">Print Enrollment Form</h4>
					<p>Scan the QR code below or click the button to print your enrollment form.</p>
					
					<div style="margin: 20px auto; display: inline-block;">
						<canvas id="qr-success-canvas" style="border: 2px solid #ddd; padding: 10px; border-radius: 8px;"></canvas>
					</div>
					
					<div class="row" style="margin-top: 15px;">
						<div class="col-md-12">
							<a href="<?=isset($print_url) ? $print_url : site_url('students/enrollment_receipt/' . $student_id)?>" target="_blank" type="button" class="btn btn-lg btn-info btn-fw"><i class="mdi mdi-printer"></i> Print Enrollment Form</a>
							<a href="<?=site_url('enroll/view_student_info/' . $student_id)?>" target="_blank" type="button" class="btn btn-lg btn-warning btn-fw"><i class="mdi mdi-eye"></i> View Student Info</a>
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

<?php 
	
$row = $query->row(); 

$current_schoolyear = $this->session->userdata('current_schoolyear') ?? date('Y');

// Get enrollment info
$enroll_qry = $this->db->query("select * from enrolled where studentid = " . $row->id . " and deleted = 'no' order by addeddate desc limit 1");
$enroll = $enroll_qry->num_rows() > 0 ? $enroll_qry->row() : null;

// Generate QR code data for enrollment receipt
$qr_data_receipt = json_encode([
    'type' => 'ENROLLMENT_RECEIPT',
    'student_id' => $row->id,
    'name' => $row->firstname . ' ' . $row->lastname,
    'grade' => $enroll->gradelevel ?? '',
    'school_year' => $current_schoolyear,
    'status' => $enroll->status ?? 'Pending',
    'date' => date('Y-m-d'),
    'verified' => true
]);

// Generate QR code data for student verification
$qr_data_verify = json_encode([
    'type' => 'STUDENT_VERIFICATION',
    'student_id' => $row->id,
    'name' => $row->firstname . ' ' . $row->lastname,
    'grade' => $enroll->gradelevel ?? '',
    'newold' => $enroll->newold ?? 'new',
    'school_year' => $current_schoolyear,
    'status' => $enroll->status ?? 'Pending',
    'enroll_date' => $enroll->addeddate ?? date('Y-m-d')
]);

$enroll_date = $enroll ? date('F j, Y', strtotime($enroll->addeddate)) : date('F j, Y');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>View Student Info - Review - <?= $row->firstname . " " . $row->lastname ?></title>
	<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: Arial, sans-serif; font-size: 11pt; line-height: 1.2; color: #000; background: #fff; }
		
		.page { width: 8.5in; min-height: 11in; margin: 0 auto; padding: 0.3in; }
		
		.header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #000; padding-bottom: 10px; }
		.header h1 { font-size: 18pt; font-weight: bold; margin-bottom: 5px; }
		.header h2 { font-size: 14pt; font-weight: normal; }
		.header .student-no { font-size: 10pt; color: #666; margin-top: 5px; }
		
		.main-content { display: flex; gap: 20px; }
		.main-content .left-side { flex: 1; }
		.main-content .right-side { width: 180px; text-align: center; }
		
		.profile-box { border: 2px solid #000; padding: 10px; margin-bottom: 15px; }
		.profile-box img { max-width: 150px; max-height: 180px; border: 1px solid #999; }
		.profile-box .no-photo { width: 150px; height: 180px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 10pt; color: #999; border: 1px solid #999; }
		
		.qr-box { border: 2px solid #000; padding: 10px; margin-bottom: 15px; }
		.qr-box canvas { border: 1px solid #000; }
		.qr-box .qr-label { font-size: 9pt; font-weight: bold; margin-top: 5px; }
		.qr-box .scan-instruction { font-size: 8pt; color: #666; margin-top: 3px; }
		
		.status-badge { display: inline-block; padding: 5px 15px; font-size: 12pt; font-weight: bold; border: 2px solid #000; }
		.status-badge.enrolled { background: #008000; color: white; }
		.status-badge.pending { background: #ff6600; color: white; }
		.status-badge.active { background: #2196F3; color: white; }
		
		.info-section { margin-bottom: 15px; }
		.info-section .title { font-weight: bold; font-size: 12pt; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; background: #f0f0f0; }
		.info-section .row { font-size: 10pt; margin-bottom: 4px; }
		.info-section .row .label { display: inline-block; width: 130px; font-weight: bold; }
		.info-section .row .value { display: inline-block; border-bottom: 1px solid #000; min-width: 200px; padding-left: 5px; }
		
		.verification-section { margin-top: 20px; padding: 15px; border: 2px solid #000; text-align: center; }
		.verification-section .title { font-size: 14pt; font-weight: bold; margin-bottom: 10px; }
		.verification-section .verified { color: #008000; font-size: 12pt; font-weight: bold; }
		.verification-section .not-verified { color: #ff0000; font-size: 12pt; font-weight: bold; }
		
		.footer { margin-top: 20px; display: flex; justify-content: space-between; }
		.footer .sig-block { width: 45%; }
		.footer .sig-line { border-bottom: 1px solid #000; margin-top: 30px; }
		.footer .sig-label { font-size: 9pt; margin-top: 5px; text-align: center; }
		
		.date-printed { text-align: center; font-size: 9pt; color: #666; margin-top: 15px; }
		
		/* Enrollment Receipt Styles */
		.receipt-header { text-align: center; margin-bottom: 15px; }
		.receipt-header h1 { font-size: 18pt; font-weight: bold; margin-bottom: 5px; }
		.receipt-header h2 { font-size: 14pt; font-weight: normal; }
		.receipt-header .receipt-no { font-size: 10pt; color: #666; margin-top: 5px; }
		
		.receipt-qr-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; border: 2px solid #000; padding: 15px; }
		.receipt-qr-section .qr-box { text-align: center; }
		.receipt-qr-section .qr-box canvas { border: 1px solid #000; }
		.receipt-qr-section .qr-box .qr-label { font-size: 9pt; font-weight: bold; margin-top: 5px; }
		.receipt-qr-section .receipt-details { flex: 1; margin-left: 20px; }
		.receipt-qr-section .receipt-details .row { font-size: 10pt; margin-bottom: 5px; }
		.receipt-qr-section .receipt-details .row .label { display: inline-block; width: 120px; font-weight: bold; }
		.receipt-qr-section .receipt-details .row .value { font-weight: bold; }
		
		.receipt-status-box { text-align: center; padding: 10px; margin-bottom: 15px; border: 2px solid #000; }
		.receipt-status-box .status { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
		.receipt-status-box .status.enrolled { color: #008000; }
		.receipt-status-box .status.pending { color: #ff6600; }
		
		.receipt-student-info { display: flex; justify-content: space-between; margin-bottom: 15px; }
		.receipt-student-info .info-box { width: 48%; border: 1px solid #000; padding: 10px; }
		.receipt-student-info .info-box .title { font-weight: bold; font-size: 10pt; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 8px; }
		.receipt-student-info .info-box .row { font-size: 10pt; margin-bottom: 3px; }
		.receipt-student-info .info-box .row .label { display: inline-block; width: 100px; font-weight: bold; }
		.receipt-student-info .info-box .row .value { display: inline-block; border-bottom: 1px solid #000; min-width: 150px; }
		
		.receipt-enrollment-details { margin-top: 15px; }
		.receipt-enrollment-details h3 { font-size: 12pt; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; }
		.receipt-enrollment-details .row { font-size: 10pt; margin-bottom: 5px; }
		.receipt-enrollment-details .row .label { display: inline-block; width: 150px; font-weight: bold; }
		.receipt-enrollment-details .row .value { display: inline-block; border-bottom: 1px solid #000; min-width: 200px; }
		
		.receipt-notes { margin-top: 20px; padding: 10px; border: 1px solid #999; font-size: 9pt; font-style: italic; }
		.receipt-notes ul { margin-left: 20px; }
		
		.receipt-footer { margin-top: 30px; display: flex; justify-content: space-between; }
		.receipt-footer .sig-block { width: 40%; text-align: center; }
		.receipt-footer .sig-line { border-bottom: 1px solid #000; margin-top: 30px; }
		.receipt-footer .sig-label { font-size: 9pt; margin-top: 5px; }
		
		/* Tab styles */
		.tab-container { margin-bottom: 20px; }
		.tab-buttons { display: flex; gap: 10px; margin-bottom: 15px; border-bottom: 2px solid #ccc; }
		.tab-buttons button { padding: 12px 24px; font-size: 14px; cursor: pointer; background: #f0f0f0; color: #333; border: none; border-radius: 5px 5px 0 0; margin-bottom: -2px; }
		.tab-buttons button.active { background: #fff; border: 2px solid #ccc; border-bottom: 2px solid #fff; font-weight: bold; }
		.tab-content { display: none; }
		.tab-content.active { display: block; }
		
		@media print {
			body { margin: 0; padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
			.page { width: 100%; min-height: auto; margin: 0; padding: 0.2in; }
			.toolbar { display: none !important; }
			.tab-buttons { display: none !important; }
			@page { size: letter portrait; margin: 0; }
		}
		
		@media screen {
			body { background: #666; padding: 15px; }
			.page { background: #fff; box-shadow: 0 0 8px rgba(0,0,0,0.3); margin-bottom: 15px; }
			.toolbar { text-align: center; padding: 12px; background: #222; color: #fff; position: sticky; top: 0; z-index: 100; }
			.toolbar button { padding: 8px 16px; font-size: 13px; cursor: pointer; background: #2196F3; color: white; border: none; border-radius: 3px; margin: 0 4px; }
			.toolbar button:hover { background: #1976D2; }
			.toolbar a { padding: 8px 16px; font-size: 13px; background: #4CAF50; color: white; text-decoration: none; border-radius: 3px; margin: 0 4px; display: inline-block; }
			.toolbar a:hover { background: #45a049; }
		}
	</style>
</head>
<body>

<div class="toolbar">
	<button onclick="window.print()">PRINT / SAVE PDF</button>
	<button onclick="window.close()">CLOSE</button>
</div>

<div class="page">
	<!-- Tab Navigation -->
	<div class="tab-container">
		<div class="tab-buttons">
			<button class="active" onclick="showTab('student-info')">Student Information</button>
			<button onclick="showTab('enrollment-receipt')">Enrollment Receipt</button>
		</div>
	</div>
	
	<script>
	function showTab(tabName) {
		// Hide all tab contents
		document.querySelectorAll('.tab-content').forEach(function(tab) {
			tab.classList.remove('active');
		});
		// Remove active class from all buttons
		document.querySelectorAll('.tab-buttons button').forEach(function(btn) {
			btn.classList.remove('active');
		});
		// Show selected tab
		document.getElementById(tabName).classList.add('active');
		// Add active class to clicked button
		event.target.classList.add('active');
	}
	
	// Generate QR codes on page load
	document.addEventListener('DOMContentLoaded', function() {
		// Student Info QR - URL to this page for verification
		var qrVerifyData = "<?= site_url('enroll/view_student_info/' . $row->id) ?>";
		var qrVerifyCanvas = document.getElementById('qr-verify-canvas');
		if(qrVerifyCanvas) {
			QRCode.toCanvas(qrVerifyCanvas, qrVerifyData, { width: 150 }, function(error) {
				if (error) console.error(error);
			});
		}
		
		// Enrollment Receipt QR - URL to enrollment receipt
		var qrReceiptData = "<?= site_url('enroll/enrollment_receipt/' . $row->id) ?>";
		var qrReceiptCanvas = document.getElementById('qr-receipt-canvas');
		if(qrReceiptCanvas) {
			QRCode.toCanvas(qrReceiptCanvas, qrReceiptData, { width: 150 }, function(error) {
				if (error) console.error(error);
			});
		}
	});
	</script>
	
	<!-- Student Information Tab -->
	<div id="student-info" class="tab-content active">
		<div class="header">
			<h1>STUDENT INFORMATION</h1>
			<h2>BHCA Christian School</h2>
			<div class="student-no">Student ID: <?= str_pad($row->id, 6, '0', STR_PAD_LEFT) ?></div>
		</div>
		
		<div style="text-align: center; margin-bottom: 15px;">
			<span class="status-badge <?= strtolower($enroll->status ?? 'pending') ?>"><?= strtoupper($enroll->status ?? 'PENDING') ?></span>
		</div>
		
		<div class="main-content">
			<div class="left-side">
				<div class="info-section">
					<div class="title">BASIC INFORMATION</div>
					<div class="row"><span class="label">Full Name:</span><span class="value"><?= strtoupper($row->firstname . " " . $row->lastname) ?></span></div>
					<div class="row"><span class="label">First Name:</span><span class="value"><?= strtoupper($row->firstname ?? '') ?></span></div>
					<div class="row"><span class="label">Last Name:</span><span class="value"><?= strtoupper($row->lastname ?? '') ?></span></div>
					<div class="row"><span class="label">Middle Name:</span><span class="value"><?= strtoupper($row->middlename ?? '') ?></span></div>
					<div class="row"><span class="label">Date of Birth:</span><span class="value"><?= $row->birthdate ? date('F j, Y', strtotime($row->birthdate)) : '' ?></span></div>
					<div class="row"><span class="label">Place of Birth:</span><span class="value"><?= strtoupper($row->placeofbirth ?? '') ?></span></div>
					<div class="row"><span class="label">Gender:</span><span class="value"><?= strtoupper($row->gender ?? '') ?></span></div>
				</div>
				
				<div class="info-section">
					<div class="title">ENROLLMENT DETAILS</div>
					<div class="row"><span class="label">Grade Level:</span><span class="value"><?= strtoupper($enroll->gradelevel ?? '') ?></span></div>
					<div class="row"><span class="label">Student Type:</span><span class="value"><?= strtoupper($enroll->newold ?? 'NEW') ?></span></div>
					<div class="row"><span class="label">School Year:</span><span class="value"><?= $current_schoolyear ?></span></div>
					<div class="row"><span class="label">Enrollment Date:</span><span class="value"><?= $enroll_date ?></span></div>
					<?php if($enroll && $enroll->strand): ?>
					<div class="row"><span class="label">Strand:</span><span class="value"><?= strtoupper($enroll->strand) ?></span></div>
					<?php endif; ?>
				</div>
				
				<div class="info-section">
					<div class="title">ADDRESS</div>
					<div class="row"><span class="label">Street:</span><span class="value"><?= strtoupper($row->street ?? '') ?></span></div>
					<div class="row"><span class="label">Barangay:</span><span class="value"><?= strtoupper($row->barangay ?? '') ?></span></div>
					<div class="row"><span class="label">House No.:</span><span class="value"><?= strtoupper($row->houseno ?? '') ?></span></div>
					<div class="row"><span class="label">City:</span><span class="value"><?= strtoupper($row->city ?? '') ?></span></div>
					<div class="row"><span class="label">Province:</span><span class="value"><?= strtoupper($row->province ?? '') ?></span></div>
					<div class="row"><span class="label">Country:</span><span class="value"><?= strtoupper($row->country ?? '') ?></span></div>
				</div>
				
				<div class="info-section">
					<div class="title">PARENT/GUARDIAN INFORMATION</div>
					<div class="row"><span class="label">Father's Name:</span><span class="value"><?= strtoupper(($row->father_firstname ?? '') . " " . ($row->father_middlename ?? '') . " " . ($row->father_lastname ?? '')) ?></span></div>
					<div class="row"><span class="label">Father's Work:</span><span class="value"><?= strtoupper($row->father_place_work ?? '') ?></span></div>
					<div class="row"><span class="label">Father's Contact:</span><span class="value"><?= $row->father_contact2 ?? '' ?></span></div>
					<div class="row"><span class="label">Mother's Name:</span><span class="value"><?= strtoupper(($row->mother_firstname ?? '') . " " . ($row->mother_middlename ?? '') . " " . ($row->mother_lastname ?? '')) ?></span></div>
					<div class="row"><span class="label">Mother's Work:</span><span class="value"><?= strtoupper($row->mother_place_work ?? '') ?></span></div>
					<div class="row"><span class="label">Mother's Contact:</span><span class="value"><?= $row->mother_contact2 ?? '' ?></span></div>
				</div>
				
				<div class="info-section">
					<div class="title">EMERGENCY CONTACT</div>
					<div class="row"><span class="label">Contact Person:</span><span class="value"><?= strtoupper($row->incaseemergency ?? '') ?></span></div>
					<div class="row"><span class="label">Relationship:</span><span class="value"><?= strtoupper($row->relationship ?? '') ?></span></div>
					<div class="row"><span class="label">Cellphone No.:</span><span class="value"><?= $row->personal_cell ?? '' ?></span></div>
					<div class="row"><span class="label">Home Phone:</span><span class="value"><?= $row->homelandline ?? '' ?></span></div>
				</div>
			</div>
			
			<div class="right-side">
				<div class="profile-box">
					<?php if($profile_pic && strpos($profile_pic, 'default-profile') === false): ?>
					<img src="<?= $profile_pic ?>" alt="Student Photo">
					<?php else: ?>
					<div class="no-photo">NO PHOTO</div>
					<?php endif; ?>
				</div>
				
				<div class="qr-box">
					<canvas id="qr-verify-canvas"></canvas>
					<div class="qr-label">STUDENT QR</div>
					<div class="scan-instruction">Scan to verify enrollment</div>
				</div>
			</div>
		</div>
		
		<div class="verification-section">
			<div class="title">ENROLLMENT VERIFICATION</div>
			<div class="verified">✓ ENROLLMENT VERIFIED</div>
			<div style="font-size: 10pt; margin-top: 5px;">This student is officially enrolled for School Year <?= $current_schoolyear ?></div>
		</div>
		
		<div class="footer">
			<div class="sig-block">
				<div class="sig-line"></div>
				<div class="sig-label">Teacher's Signature</div>
			</div>
			<div class="sig-block">
				<div class="sig-line"></div>
				<div class="sig-label">School Registrar</div>
			</div>
		</div>
		
		<div class="date-printed">Date Printed: <?= date('F j, Y g:i A') ?></div>
	</div>
	
	<!-- Enrollment Receipt Tab -->
	<div id="enrollment-receipt" class="tab-content">
		<div class="receipt-header">
			<h1>ENROLLMENT RECEIPT</h1>
			<h2>BHCA Christian School</h2>
			<div class="receipt-no">Receipt No.: ENR-<?= str_pad($row->id, 6, '0', STR_PAD_LEFT) ?></div>
		</div>
		
		<div class="receipt-status-box">
			<div class="status <?= strtolower($enroll->status ?? 'pending') ?>"><?= strtoupper($enroll->status ?? 'PENDING') ?></div>
		</div>
		
		<div class="receipt-qr-section">
			<div class="qr-box">
				<canvas id="qr-receipt-canvas"></canvas>
				<div class="qr-label">Scan to Verify</div>
			</div>
			<div class="receipt-details">
				<div class="row"><span class="label">Date:</span><span class="value"><?= date('F j, Y') ?></span></div>
				<div class="row"><span class="label">Enrollment Date:</span><span class="value"><?= $enroll_date ?></span></div>
				<div class="row"><span class="label">School Year:</span><span class="value"><?= $current_schoolyear ?></span></div>
				<div class="row"><span class="label">Student Type:</span><span class="value"><?= strtoupper($enroll->newold ?? 'NEW') ?></span></div>
				<div class="row"><span class="label">Grade Level:</span><span class="value"><?= strtoupper($enroll->gradelevel ?? '') ?></span></div>
			</div>
		</div>
		
		<div class="receipt-student-info">
			<div class="info-box">
				<div class="title">STUDENT INFORMATION</div>
				<div class="row"><span class="label">Student ID:</span><span class="value"><?= $row->id ?></span></div>
				<div class="row"><span class="label">Name:</span><span class="value"><?= strtoupper($row->firstname . " " . $row->lastname) ?></span></div>
				<div class="row"><span class="label">Middle Name:</span><span class="value"><?= strtoupper($row->middlename ?? '') ?></span></div>
				<div class="row"><span class="label">Birthdate:</span><span class="value"><?= $row->birthdate ? date('F j, Y', strtotime($row->birthdate)) : '' ?></span></div>
				<div class="row"><span class="label">Gender:</span><span class="value"><?= strtoupper($row->gender ?? '') ?></span></div>
			</div>
			<div class="info-box">
				<div class="title">PARENT/GUARDIAN INFORMATION</div>
				<div class="row"><span class="label">Father:</span><span class="value"><?= strtoupper(($row->father_firstname ?? '') . " " . ($row->father_lastname ?? '')) ?></span></div>
				<div class="row"><span class="label">Mother:</span><span class="value"><?= strtoupper(($row->mother_firstname ?? '') . " " . ($row->mother_lastname ?? '')) ?></span></div>
				<div class="row"><span class="label">Emergency:</span><span class="value"><?= strtoupper($row->incaseemergency ?? '') ?></span></div>
				<div class="row"><span class="label">Contact:</span><span class="value"><?= $row->personal_cell ?? '' ?></span></div>
			</div>
		</div>
		
		<div class="receipt-enrollment-details">
			<h3>ADDRESS INFORMATION</h3>
			<div class="row"><span class="label">Street:</span><span class="value"><?= strtoupper($row->street ?? '') ?></span></div>
			<div class="row"><span class="label">Barangay:</span><span class="value"><?= strtoupper($row->barangay ?? '') ?></span></div>
			<div class="row"><span class="label">City:</span><span class="value"><?= strtoupper($row->city ?? '') ?></span></div>
			<div class="row"><span class="label">Province:</span><span class="value"><?= strtoupper($row->province ?? '') ?></span></div>
		</div>
		
		<div class="receipt-notes">
			<strong>Important Notes:</strong>
			<ul>
				<li>Please present this receipt to your child's teacher during the first day of classes.</li>
				<li>This enrollment is subject to the school's policies and regulations.</li>
				<li>For any inquiries, please contact the school administration.</li>
			</ul>
		</div>
		
		<div class="receipt-footer">
			<div class="sig-block">
				<div class="sig-line"></div>
				<div class="sig-label">Parent/Guardian Signature</div>
			</div>
			<div class="sig-block">
				<div class="sig-line"></div>
				<div class="sig-label">School Representative</div>
			</div>
		</div>
		
		<div class="date-printed">Date Printed: <?= date('F j, Y g:i A') ?></div>
	</div>
</div>

</body>
</html>

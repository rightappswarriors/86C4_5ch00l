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
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/student-view.css?v=<?=time()?>">

<?php 
$is_accounting = ($current_usertype == 'Accounting' || $this->session->userdata('current_usertype') == 'Accounting');
?>

<div class="student-view-container">
<div class="toolbar">
	<?php if($is_accounting): ?>
	<button onclick="printStudentInfo()" class="print-btn"> PRINT APPLICATION FORM</button>
	<button onclick="window.print()" class="print-btn">PRINT ACKNOWLEDGEMENT</button>
	<?php endif; ?>
	<button onclick="closeReviewPage()" class="close-btn">&#10006; CLOSE</button>
	<?php if($is_accounting): ?>
	<span class="access-info"><i class="mdi mdi-account-check"></i> Accounting Access - Can Print</span>
	<?php endif; ?>
</div>

<div class="page">
	<!-- Tab Navigation -->
	<?php if($is_accounting): ?>
	<div class="stu-tab-container">
		<div class="stu-tab-buttons">
			<button class="active" onclick="showTab('student-info')">Student Information</button>
			<button onclick="showTab('enrollment-receipt')">Enrollment Receipt</button>
		</div>
	</div>
	<?php else: ?>
	<div class="stu-tab-container">
		<div class="stu-tab-buttons">
			<button class="active">Student Information</button>
		</div>
	</div>
	<?php endif; ?>
	
	<script>
	function showTab(tabName) {
		// Hide all tab contents
		document.querySelectorAll('.stu-tab-content').forEach(function(tab) {
			tab.classList.remove('active');
		});
		// Remove active class from all buttons
		document.querySelectorAll('.stu-tab-buttons button').forEach(function(btn) {
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
	
	function printStudentInfo() {
		// Hide toolbar and tabs before printing
		var toolbar = document.querySelector('.toolbar');
		var tabs = document.querySelector('.stu-tab-container');
		var originalToolbarDisplay = toolbar.style.display;
		var originalTabsDisplay = tabs.style.display;
		
		toolbar.style.display = 'none';
		tabs.style.display = 'none';
		
		// Print only the student-info tab
		var studentInfo = document.getElementById('student-info');
		var originalDisplay = studentInfo.style.display;
		studentInfo.style.display = 'block';
		
		// Hide enrollment-receipt tab
		var receiptTab = document.getElementById('enrollment-receipt');
		if(receiptTab) receiptTab.style.display = 'none';
		
		window.print();
		
		// Restore after printing
		studentInfo.style.display = originalDisplay;
		if(receiptTab) receiptTab.style.display = '';
		toolbar.style.display = originalToolbarDisplay;
		tabs.style.display = originalTabsDisplay;
	}

	function closeReviewPage() {
		if (window.opener) {
			window.close();
			return;
		}

		if (window.history.length > 1) {
			window.history.back();
			return;
		}

		window.location.href = "<?= site_url('students') ?>";
	}
	</script>
	
	<!-- Student Information Tab -->
	<div id="student-info" class="stu-tab-content active">
		<div class="header">
			<h1>ENROLLMENT APPLICATION FORM</h1>
			<h2>BOB HUGHES CHRISTIAN ACADEMY</h2>
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
					<div class="row"><span class="label">Refered by:</span><span class="value"><?= strtoupper($row->referred_by ?? '') ?></span></div>
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
					<?php if(!empty($row->maidenname)): ?>
					<div class="row"><span class="label">Maiden Name:</span><span class="value"><?= strtoupper($row->maidenname) ?></span></div>
					<?php endif; ?>
					<div class="row"><span class="label">Mother's Work:</span><span class="value"><?= strtoupper($row->mother_place_work ?? '') ?></span></div>
					<div class="row"><span class="label">Mother's Contact:</span><span class="value"><?= $row->mother_contact2 ?? '' ?></span></div>
				</div>
				
				<div class="info-section">
					<div class="title">EMERGENCY CONTACT</div>
					<div class="row"><span class="label">Contact Person:</span><span class="value"><?= strtoupper($row->incaseemergency ?? '') ?></span></div>
					<div class="row"><span class="label">Relationship:</span><span class="value"><?= strtoupper($row->relationship ?? '') ?></span></div>
					<div class="row"><span class="label">Cellphone No.:</span><span class="value"><?= $row->personal_cell ?? '' ?></span></div>
					<div class="row"><span class="label">Home Phone:</span><span class="value"><?= $row->homelandline ?? '' ?></span></div>
					<div class="row"><span class="label">Refered by:</span><span class="value"><?= strtoupper($row->referred_by ?? '') ?></span></div>
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
		
		
		

		
		<div class="date-printed">Date Printed: <?= date('F j, Y g:i A') ?></div>
	</div>
	
	<!-- Enrollment Receipt Tab -->
	<div id="enrollment-receipt" class="stu-tab-content">
		<div class="receipt-header">
			<h1>E-REGISTRATION ACKNOWLEDGEMENT</h1>
			<h2>BOB HUGHES CHRISTIAN ACADEMY</h2>
			<div class="receipt-no">Receipt No.: ENR-<?= str_pad($row->id, 6, '0', STR_PAD_LEFT) ?></div>
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
				<div class="row"><span class="label">Name:</span><span class="value"><?= strtoupper($row->firstname . " " . $row->lastname) ?></span></div>
				<div class="row"><span class="label">Middle Name:</span><span class="value"><?= strtoupper($row->middlename ?? '') ?></span></div>
				<div class="row"><span class="label">Birthdate:</span><span class="value"><?= $row->birthdate ? date('F j, Y', strtotime($row->birthdate)) : '' ?></span></div>
				<div class="row"><span class="label">Gender:</span><span class="value"><?= strtoupper($row->gender ?? '') ?></span></div>
			</div>
			<div class="info-box">
				<div class="title">PARENT/GUARDIAN INFORMATION</div>
				<div class="row"><span class="label">Father:</span><span class="value"><?= strtoupper(($row->father_firstname ?? '') . " " . ($row->father_lastname ?? '')) ?></span></div>
				<?php if(!empty($row->maidenname)): ?>
				<div class="row"><span class="label">Maiden:</span><span class="value"><?= strtoupper($row->maidenname) ?></span></div>
				<?php endif; ?>
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

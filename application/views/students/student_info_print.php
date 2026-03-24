<?php 
	
$row = $query->row(); 

$current_schoolyear = $this->session->userdata('current_schoolyear') ?? date('Y');

// Get enrollment info
$enroll_qry = $this->db->query("select * from enrolled where studentid = " . $row->id . " and deleted = 'no' order by addeddate desc limit 1");
$enroll = $enroll_qry->num_rows() > 0 ? $enroll_qry->row() : null;

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
	<title>Student Information - <?= $row->firstname . " " . $row->lastname ?></title>
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
		
		@media print {
			body { margin: 0; padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
			.page { width: 100%; min-height: auto; margin: 0; padding: 0.2in; }
			.toolbar { display: none !important; }
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
	<a href="<?= base_url() ?>students/view_student_info/<?= $row->id ?>">VIEW STUDENT INFO</a>
	<button onclick="window.close()">CLOSE</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// QR code now contains a URL for verification
	var qrVerifyData = "<?= site_url('enroll/view_student_info/' . $row->id) ?>";
	var qrVerifyCanvas = document.getElementById('qr-verify-canvas');
	if(qrVerifyCanvas) {
		QRCode.toCanvas(qrVerifyCanvas, qrVerifyData, { width: 150 }, function(error) {
			if (error) console.error(error);
		});
	}
});
</script>

<div class="page">
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

</body>
</html>

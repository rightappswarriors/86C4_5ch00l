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

$enroll_date = $enroll ? date('F j, Y', strtotime($enroll->addeddate)) : date('F j, Y');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Enrollment Receipt - <?= $row->firstname . " " . $row->lastname ?></title>
	<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: Arial, sans-serif; font-size: 11pt; line-height: 1.2; color: #000; background: #fff; }
		
		.page { width: 8.5in; min-height: 11in; margin: 0 auto; padding: 0.3in; }
		
		.header { text-align: center; margin-bottom: 15px; }
		.header h1 { font-size: 18pt; font-weight: bold; margin-bottom: 5px; }
		.header h2 { font-size: 14pt; font-weight: normal; }
		.header .receipt-no { font-size: 10pt; color: #666; margin-top: 5px; }
		
		.student-info { display: flex; justify-content: space-between; margin-bottom: 15px; }
		.student-info .info-box { width: 48%; border: 1px solid #000; padding: 10px; }
		.student-info .info-box .title { font-weight: bold; font-size: 10pt; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 8px; }
		.student-info .info-box .row { font-size: 10pt; margin-bottom: 3px; }
		.student-info .info-box .row .label { display: inline-block; width: 100px; font-weight: bold; }
		.student-info .info-box .row .value { display: inline-block; border-bottom: 1px solid #000; min-width: 150px; }
		
		.qr-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; border: 2px solid #000; padding: 15px; }
		.qr-section .qr-box { text-align: center; }
		.qr-section .qr-box canvas { border: 1px solid #000; }
		.qr-section .qr-box .qr-label { font-size: 9pt; font-weight: bold; margin-top: 5px; }
		.qr-section .receipt-details { flex: 1; margin-left: 20px; }
		.qr-section .receipt-details .row { font-size: 10pt; margin-bottom: 5px; }
		.qr-section .receipt-details .row .label { display: inline-block; width: 120px; font-weight: bold; }
		.qr-section .receipt-details .row .value { font-weight: bold; }
		
		.status-box { text-align: center; padding: 10px; margin-bottom: 15px; border: 2px solid #000; }
		.status-box .status { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
		.status-box .status.enrolled { color: #008000; }
		.status-box .status.pending { color: #ff6600; }
		
		.enrollment-details { margin-top: 15px; }
		.enrollment-details h3 { font-size: 12pt; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; }
		.enrollment-details .row { font-size: 10pt; margin-bottom: 5px; }
		.enrollment-details .row .label { display: inline-block; width: 150px; font-weight: bold; }
		.enrollment-details .row .value { display: inline-block; border-bottom: 1px solid #000; min-width: 200px; }
		
		.notes { margin-top: 20px; padding: 10px; border: 1px solid #999; font-size: 9pt; font-style: italic; }
		.notes ul { margin-left: 20px; }
		
		.footer { margin-top: 30px; display: flex; justify-content: space-between; }
		.footer .sig-block { width: 40%; text-align: center; }
		.footer .sig-line { border-bottom: 1px solid #000; margin-top: 30px; }
		.footer .sig-label { font-size: 9pt; margin-top: 5px; }
		
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
	<button onclick="window.close()">CLOSE</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// QR code now contains a URL for verification
	var qrReceiptData = "<?= site_url('enroll/view_student_info/' . $row->id) ?>";
	var qrReceiptCanvas = document.getElementById('qr-receipt-canvas');
	if(qrReceiptCanvas) {
		QRCode.toCanvas(qrReceiptCanvas, qrReceiptData, { width: 150 }, function(error) {
			if (error) console.error(error);
		});
	}
});
</script>

<div class="page">
	<div class="header">
		<h1>ENROLLMENT FORM</h1>
		<h2>BHCA Christian School</h2>
		<div class="receipt-no">Receipt No.: ENR-<?= str_pad($row->id, 6, '0', STR_PAD_LEFT) ?></div>
	</div>
	
	<div class="status-box">
		<div class="status enrolled">ENROLLMENT RECEIVED</div>
	</div>
	
	<div class="qr-section">
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
	
	<div class="student-info">
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
	
	<div class="enrollment-details">
		<h3>ADDRESS INFORMATION</h3>
		<div class="row"><span class="label">Street:</span><span class="value"><?= strtoupper($row->street ?? '') ?></span></div>
		<div class="row"><span class="label">Barangay:</span><span class="value"><?= strtoupper($row->barangay ?? '') ?></span></div>
		<div class="row"><span class="label">City:</span><span class="value"><?= strtoupper($row->city ?? '') ?></span></div>
		<div class="row"><span class="label">Province:</span><span class="value"><?= strtoupper($row->province ?? '') ?></span></div>
	</div>
	
	<div class="notes">
		<strong>Important Notes:</strong>
		<ul>
			<li>Please present this receipt to your child's teacher during the first day of classes.</li>
			<li>This enrollment is subject to the school's policies and regulations.</li>
			<li>For any inquiries, please contact the school administration.</li>
		</ul>
	</div>
	
	<div class="footer">
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

</body>
</html>

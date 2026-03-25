<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );

	$assetBaseUrl = rtrim(dirname(site_url()), '/\\');
	$logoDataUri = '';
	$logoCandidates = array(
		FCPATH . 'assets/images/logo_portal.png',
		FCPATH . 'assets/images/dashboard_logo.png'
	);

	foreach ($logoCandidates as $logoPath) {
		if (is_readable($logoPath)) {
			$logoContent = @file_get_contents($logoPath);
			if ($logoContent !== false) {
				$logoDataUri = 'data:image/png;base64,' . base64_encode($logoContent);
				break;
			}
		}
	}

	$logoSrc = $logoDataUri !== '' ? $logoDataUri : ($assetBaseUrl . '/assets/images/logo_portal.png');
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_details_print.css">

<style>
/* Enhanced Print Styles */
.print-content {
	padding: 20px;
	max-width: 1200px;
	margin: 0 auto;
}

.school-header {
	background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
	color: white;
	padding: 20px;
	border-radius: 10px;
	margin-bottom: 20px;
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.school-header .school-logo img {
	width: 80px;
	height: auto;
}

.school-header .school-details h2 {
	margin: 0;
	font-size: 24px;
	font-weight: 700;
}

.school-header .school-details p {
	margin: 5px 0 0;
	opacity: 0.9;
	font-size: 14px;
}

.card {
	border: 1px solid #e0e0e0;
	border-radius: 10px;
	box-shadow: 0 2px 10px rgba(0,0,0,0.05);
	margin-bottom: 20px;
}

.card-header {
	background: #f8f9fa;
	padding: 15px 20px;
	border-bottom: 2px solid #2196f3;
	border-radius: 10px 10px 0 0;
}

.card-header h3 {
	margin: 0;
	color: #2196f3;
	font-weight: 700;
	font-size: 20px;
}

.card-body {
	padding: 20px;
}

.section-title {
	background: #333;
	color: white;
	text-align: center;
	font-weight: bold;
	padding: 8px 0;
	font-size: 14px;
	margin: 20px 0 15px;
	border-radius: 5px;
}

.info-row {
	display: flex;
	padding: 8px 0;
	border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
	border-bottom: none;
}

.info-label {
	font-weight: 600;
	color: #555;
	min-width: 180px;
	flex: 0 0 180px;
}

.info-value {
	color: #333;
	flex: 1;
}

.info-value.empty {
	color: #999;
	font-style: italic;
}

/* Two column layout */
.info-grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 15px;
}

@media (max-width: 768px) {
	.info-grid {
		grid-template-columns: 1fr;
	}
	
	.school-header {
		flex-direction: column;
		text-align: center;
		gap: 15px;
	}
	
	.info-row {
		flex-direction: column;
	}
	
	.info-label {
		margin-bottom: 3px;
	}
}

@media print {
	.school-header {
		background: none !important;
		color: #333 !important;
		border: 2px solid #333;
	}
	
	.school-header .school-details h2 {
		color: #333 !important;
	}
	
	.section-title {
		background: #eee !important;
		color: #333 !important;
		border: 1px solid #ccc;
	}
	
	.card {
		box-shadow: none;
		border: 1px solid #ccc;
	}
	
	.info-row {
		border-bottom: 1px solid #ddd;
	}
	
	.card-body {
		padding: 10px;
	}
	
	.print-content {
		padding: 0;
	}
}
</style>

<div class="print-content">
	<!-- School Header -->
	<div class="school-header">
		<div class="school-logo">
			<img src="<?= htmlspecialchars($logoSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="School Logo">
		</div>
		<div class="school-details">
			<h2>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</h2>
			<p>A Ministry of Cebu Bible Baptist Church, Inc.</p>
			<p>55 Katipunan St., Brgy. Calamba, Cebu City 6000</p>
			<p>Tel No. 032-422-0700 / 0945 856 8571</p>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h3>ENROLLMENT FORM</h3>
		</div>
		<div class="card-body">
			<?php
			if($this->session->flashdata('message'))
			{
				echo '<div class="text-primary" style="margin-bottom:10px;">
					'.$this->session->flashdata("message").'
				</div>';
			}
			?>
			
			<?=validation_errors()?>
			
			<!-- Student Information -->
			<div class="section-title">STUDENT INFORMATION</div>
			
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">ID Number</div>
					<div class="info-value"><?=$row->studentno ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">LRN</div>
					<div class="info-value"><?=$row->lrn ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">First Name</div>
					<div class="info-value"><?=$row->firstname?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Last Name</div>
					<div class="info-value"><?=$row->lastname?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Middle Name</div>
					<div class="info-value"><?=$row->middlename?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Date of Birth</div>
					<div class="info-value"><?=date("Y-m-d",strtotime($row->birthdate))?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Place of Birth</div>
					<div class="info-value"><?=$row->placeofbirth ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Gender</div>
					<div class="info-value"><?=$row->gender?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Grade Level to Enter</div>
					<div class="info-value"><?=$row->gradelevel?></div>
				</div>
			</div>
			
			<!-- For Senior High -->
			<?php if($row->strand): ?>
			<div class="section-title">FOR SENIOR HIGH</div>
			<div class="info-row">
				<div class="info-label">Strand</div>
				<div class="info-value"><?=$row->strand?></div>
			</div>
			<?php endif; ?>
			
			<!-- For Transferees -->
			<div class="section-title">FOR TRANSFEREES</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">School Name</div>
					<div class="info-value"><?=$row->lastschool ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Year</div>
					<div class="info-value"><?=$row->lastschoolyear ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Grade Level</div>
					<div class="info-value"><?=$row->lastschoolgrade ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
			<!-- Complete Address -->
			<div class="section-title">COMPLETE ADDRESS</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">Street</div>
					<div class="info-value"><?=$row->street?></div>
				</div>
				<div class="info-row">
					<div class="info-label">House No.</div>
					<div class="info-value"><?=$row->houseno ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Barangay</div>
					<div class="info-value"><?=$row->barangay?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Province</div>
					<div class="info-value"><?=$row->province?></div>
				</div>
				<div class="info-row">
					<div class="info-label">City</div>
					<div class="info-value"><?=$row->city?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Country</div>
					<div class="info-value"><?=$row->country?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Home Landline</div>
					<div class="info-value"><?=$row->homelandline ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
			<!-- Father's Information -->
			<div class="section-title">FATHER'S INFORMATION</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">First Name</div>
					<div class="info-value"><?=$row->father_firstname ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Last Name</div>
					<div class="info-value"><?=$row->father_lastname ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Middle Name</div>
					<div class="info-value"><?=$row->father_middlename ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Occupation</div>
					<div class="info-value"><?=$row->father_work ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Place of Employment</div>
					<div class="info-value"><?=$row->father_place_work ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Work Phone No.</div>
					<div class="info-value"><?=$row->father_contact1 ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Personal Cell No.</div>
					<div class="info-value"><?=$row->father_contact2 ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
			<!-- Mother's Information -->
			<div class="section-title">MOTHER'S INFORMATION</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">First Name</div>
					<div class="info-value"><?=$row->mother_firstname ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Last Name</div>
					<div class="info-value"><?=$row->mother_lastname ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Middle Name</div>
					<div class="info-value"><?=$row->mother_middlename ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Occupation</div>
					<div class="info-value"><?=$row->mother_work ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Maiden Name</div>
					<div class="info-value"><?=$row->maidenname ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Place of Employment</div>
					<div class="info-value"><?=$row->mother_place_work ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Work Phone No.</div>
					<div class="info-value"><?=$row->mother_contact1 ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Personal Cell No.</div>
					<div class="info-value"><?=$row->mother_contact2 ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
			<!-- Other Info -->
			<div class="section-title">OTHER INFORMATION</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">E-mail</div>
					<div class="info-value"><?=$row->email ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">FB Private Messenger</div>
					<div class="info-value"><?=$row->fbmessenger ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
			<!-- Emergency Contact -->
			<div class="section-title">EMERGENCY CONTACT (Other Than Parent)</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">Name</div>
					<div class="info-value"><?=$row->incaseemergency ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Relationship to Child</div>
					<div class="info-value"><?=$row->relationship ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Place of Employment</div>
					<div class="info-value"><?=$row->place_employment ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Work Phone No.</div>
					<div class="info-value"><?=$row->work_phone ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Personal Cell No.</div>
					<div class="info-value"><?=$row->personal_cell ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Home Landline No.</div>
					<div class="info-value"><?=$row->other_homelandline ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
			<!-- Church Information -->
			<div class="section-title">CHURCH INFORMATION</div>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">Name</div>
					<div class="info-value"><?=$row->church_name ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Address</div>
					<div class="info-value"><?=$row->church_address ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Telephone No.</div>
					<div class="info-value"><?=$row->church_tel ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Website</div>
					<div class="info-value"><?=$row->church_website ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Pastor's Name</div>
					<div class="info-value"><?=$row->church_pastor ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Date of Salvation</div>
					<div class="info-value"><?=$row->date_salvation ?: '<span class="empty">N/A</span>'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Date of Baptism</div>
					<div class="info-value"><?=$row->date_baptism ?: '<span class="empty">N/A</span>'?></div>
				</div>
			</div>
			
		</div>
	</div> 
	
</div>

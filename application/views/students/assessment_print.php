<?php 
	
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);
	$assessment_copies = array(
		'School Copy',
		"Parent's Copy",
		"Student's Copy"
	);
	
	// ASSESSMENT
	if($query_ass->num_rows()>0){
		
		$row_as = $query_ass->row(); 
		$as_id = $row_as->id;
		
		$indntals = explode(",",$row_as->incidentals);
		$msclns = explode(",",$row_as->miscellaneous);
		
		$tuition = $row_as->tuition;
		$registration = $row_as->registration;
		$total_msclns = array_sum( $msclns );
		$total_indntals = array_sum( $indntals );
		$total_ass = $total_msclns + $total_indntals + $registration + $tuition;
		$paymentenroll = $row_as->payment;
		$balance = $total_ass - $paymentenroll;
		$monthly = $balance/9;
		
		$math = explode(",",$row_as->math);
		$eng = explode(",",$row_as->english);
		$science = explode(",",$row_as->science);
		$sstudies = explode(",",$row_as->socstudies);
		$wbuilding = explode(",",$row_as->wordbuilding);
		$literature = explode(",",$row_as->literature);
		$filipino = explode(",",$row_as->filipino);
		$ap = explode(",",$row_as->ap);
		
	}else{
		
		// Default Value
		$indntals = explode(",",$def_assessment->incidentals_val);
		$msclns = explode(",",$def_assessment->miscellaneous_val);
		
		$tuition = $def_assessment->tuition;
		$registration = $def_assessment->registration;
		$paymentenroll = $def_assessment->payment_enroll;
		
		$total_msclns = array_sum( $msclns );
		$total_indntals = array_sum( $indntals );
		$total_ass = $total_msclns + $total_indntals + $registration + $tuition;
		$balance = $total_ass - $paymentenroll;
		$monthly = $balance/9;
		
		$math = array("","","");
		$eng = array("","","");
		$science = array("","","");
		$sstudies = array("","","");
		$wbuilding = array("","","");
		$literature = array("","");
		$filipino = array("","");
		$ap = array("","");
		$as_id = 0;
		
	}
?>

<style>
/* Assessment Print Styles */
.print-content {
	padding: 20px;
	max-width: 1200px;
	margin: 0 auto;
}

.assessment-copy {
	margin-bottom: 32px;
}

.assessment-copy:last-child {
	margin-bottom: 0;
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

.copy-badge {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	padding: 8px 16px;
	border-radius: 999px;
	background: rgba(255, 255, 255, 0.18);
	border: 1px solid rgba(255, 255, 255, 0.45);
	font-size: 13px;
	font-weight: 700;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	white-space: nowrap;
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

.student-info-box {
	background: #f8f9fa;
	border: 2px solid #2196f3;
	border-radius: 10px;
	padding: 15px 20px;
	margin-bottom: 20px;
}

.student-info-box h4 {
	margin: 0 0 10px;
	color: #2196f3;
}

.card {
	border: 1px solid #e0e0e0;
	border-radius: 10px;
	margin-bottom: 20px;
}

.card-header {
	background: #333;
	color: white;
	padding: 12px 20px;
	border-radius: 10px 10px 0 0;
	font-weight: bold;
}

.card-body {
	padding: 20px;
}

.section-title {
	background: #2196f3;
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
	min-width: 200px;
	flex: 0 0 200px;
}

.info-value {
	color: #333;
	flex: 1;
	font-weight: 500;
}

.info-value.highlight {
	color: #2196f3;
	font-weight: 700;
}

.info-value.total {
	color: #28a745;
	font-weight: 700;
	font-size: 18px;
}

/* Grid for two columns */
.info-grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 15px;
}

/* Table styles */
.print-table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 10px;
}

.print-table th,
.print-table td {
	border: 1px solid #ddd;
	padding: 10px;
	text-align: left;
}

.print-table th {
	background: #f8f9fa;
	font-weight: 600;
}

.print-table .text-right {
	text-align: right;
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
	.assessment-copy {
		page-break-after: always;
		break-after: page;
	}

	.assessment-copy:last-child {
		page-break-after: auto;
		break-after: auto;
	}

	.school-header {
		background: none !important;
		color: #333 !important;
		border: 2px solid #333;
		-webkit-print-color-adjust: exact;
		print-color-adjust: exact;
	}
	
	.school-header .school-details h2 {
		color: #333 !important;
	}
	
	.card-header {
		background: #eee !important;
		color: #333 !important;
		-webkit-print-color-adjust: exact;
		print-color-adjust: exact;
	}
	
	.section-title {
		background: #eee !important;
		color: #333 !important;
		-webkit-print-color-adjust: exact;
		print-color-adjust: exact;
	}
	
	.card {
		box-shadow: none;
		border: 1px solid #ccc;
	}
	
	.info-row {
		border-bottom: 1px solid #ddd;
	}
	
	.print-content {
		padding: 0;
	}
}
</style>

<div class="print-content">
	<?php foreach ($assessment_copies as $copy_label): ?>
	<div class="assessment-copy">
		<!-- School Header -->
		<div class="school-header">
			<div class="school-logo">
				<img src="<?=base_url()?>assets/images/logo_portal.png" alt="School Logo">
			</div>
			<div class="school-details">
				<h2>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</h2>
				<p>A Ministry of Cebu Bible Baptist Church, Inc.</p>
				<p>55 Katipunan St., Brgy. Calamba, Cebu City 6000</p>
				<p>Tel No. 032-422-0700 / 0945 856 8571</p>
			</div>
			<div class="copy-badge"><?=$copy_label?></div>
		</div>

		<!-- Student Info Box -->
		<div class="student-info-box">
			<h4>STUDENT INFORMATION</h4>
			<div class="info-grid">
				<div class="info-row">
					<div class="info-label">Student Name:</div>
					<div class="info-value"><?= $row->lastname . ", " . $row->firstname . " " . $row->middlename ?></div>
				</div>
				<div class="info-row">
					<div class="info-label">Grade Level:</div>
					<div class="info-value"><?=$row->gradelevel?></div>
				</div>
				<div class="info-row">
					<div class="info-label">ID Number:</div>
					<div class="info-value"><?=$row->studentno ?: 'N/A'?></div>
				</div>
				<div class="info-row">
					<div class="info-label">School Year:</div>
					<div class="info-value"><?=date('Y')?></div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				FINANCIAL ASSESSMENT
			</div>
			<div class="card-body">
				
				<!-- Incidentals -->
				<div class="section-title">INCIDENTALS</div>
				<table class="print-table">
					<thead>
						<tr>
							<th>Particulars</th>
							<th class="text-right">Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tindntals = 0;
						foreach($indntals_list as $ind=>$indntals_val):
							if(isset($indntals[$ind]) && $indntals[$ind]>0):
							$tindntals += $indntals[$ind];
						?>
						<tr>
							<td><?=$indntals_val?></td>
							<td class="text-right"><?=number_format($indntals[$ind],2)?></td>
						</tr>
						<?php
							endif;
						endforeach;
						?>
						<tr>
							<td><strong>TOTAL INCIDENTALS</strong></td>
							<td class="text-right"><strong><?=number_format($tindntals,2)?></strong></td>
						</tr>
					</tbody>
				</table>
				
				<!-- Miscellaneous -->
				<div class="section-title">MISCELLANEOUS</div>
				<table class="print-table">
					<thead>
						<tr>
							<th>Particulars</th>
							<th class="text-right">Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tmsclns = 0;
						foreach($msclns_list as $ind=>$msclns_val):
							if(isset($msclns[$ind]) && $msclns[$ind]>0):
							$tmsclns += $msclns[$ind];
						?>
						<tr>
							<td><?=$msclns_val?></td>
							<td class="text-right"><?=number_format($msclns[$ind],2)?></td>
						</tr>
						<?php
							endif;
						endforeach;
						?>
						<tr>
							<td><strong>TOTAL MISCELLANEOUS</strong></td>
							<td class="text-right"><strong><?=number_format($tmsclns,2)?></strong></td>
						</tr>
					</tbody>
				</table>
				
				<!-- Total Computation -->
				<div class="section-title">TOTAL COMPUTATION</div>
				<table class="print-table">
					<tbody>
						<tr>
							<td>TUITION</td>
							<td class="text-right"><?=number_format($tuition,2)?></td>
						</tr>
						<tr>
							<td>REGISTRATION</td>
							<td class="text-right"><?=number_format($registration,2)?></td>
						</tr>
						<tr>
							<td>TOTAL MISCELLANEOUS</td>
							<td class="text-right"><?=number_format($tmsclns,2)?></td>
						</tr>
						<tr>
							<td>TOTAL INCIDENTALS</td>
							<td class="text-right"><?=number_format($tindntals,2)?></td>
						</tr>
						<tr style="background: #e8f5e9;">
							<td><strong>ASSESSMENT TOTAL</strong></td>
							<td class="text-right"><strong class="total"><?=number_format($total_ass,2)?></strong></td>
						</tr>
					</tbody>
				</table>
				
				<!-- Basic Computation -->
				<div class="section-title">BASIC COMPUTATION</div>
				<table class="print-table">
					<tbody>
						<tr>
							<td>Payment upon enrollment</td>
							<td class="text-right"><?=number_format($paymentenroll,2)?></td>
						</tr>
						<tr style="background: #fff3e0;">
							<td><strong>BALANCE</strong></td>
							<td class="text-right"><strong class="highlight"><?=number_format($balance,2)?></strong></td>
						</tr>
						<tr>
							<td><strong>Due every 5th of the month (9 months)</strong></td>
							<td class="text-right"><strong><?=number_format($monthly,2)?></strong></td>
						</tr>
					</tbody>
				</table>
				
			</div>
		</div>

		<!-- PACE Order -->
		<div class="card">
			<div class="card-header">
				PACE ORDER (To Begin Work)
			</div>
			<div class="card-body">
				<table class="print-table">
					<thead>
						<tr>
							<th>Subject</th>
							<th class="text-right">Begin</th>
							<th class="text-right">End</th>
							<th class="text-right">Gaps</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Math</td>
							<td class="text-right"><?=$math[0] ?: '-'?></td>
							<td class="text-right"><?=$math[1] ?: '-'?></td>
							<td class="text-right"><?=$math[2] ?: '-'?></td>
						</tr>
						<tr>
							<td>English</td>
							<td class="text-right"><?=$eng[0] ?: '-'?></td>
							<td class="text-right"><?=$eng[1] ?: '-'?></td>
							<td class="text-right"><?=$eng[2] ?: '-'?></td>
						</tr>
						<tr>
							<td>Science</td>
							<td class="text-right"><?=$science[0] ?: '-'?></td>
							<td class="text-right"><?=$science[1] ?: '-'?></td>
							<td class="text-right"><?=$science[2] ?: '-'?></td>
						</tr>
						<tr>
							<td>Social Studies</td>
							<td class="text-right"><?=$sstudies[0] ?: '-'?></td>
							<td class="text-right"><?=$sstudies[1] ?: '-'?></td>
							<td class="text-right"><?=$sstudies[2] ?: '-'?></td>
						</tr>
						<tr>
							<td>Word Building</td>
							<td class="text-right"><?=$wbuilding[0] ?: '-'?></td>
							<td class="text-right"><?=$wbuilding[1] ?: '-'?></td>
							<td class="text-right"><?=$wbuilding[2] ?: '-'?></td>
						</tr>
						<tr>
							<td>Literature</td>
							<td class="text-right"><?=$literature[0] ?: '-'?></td>
							<td class="text-right"><?=$literature[1] ?: '-'?></td>
							<td class="text-right">-</td>
						</tr>
						<tr>
							<td>Filipino</td>
							<td class="text-right"><?=$filipino[0] ?: '-'?></td>
							<td class="text-right"><?=$filipino[1] ?: '-'?></td>
							<td class="text-right">-</td>
						</tr>
						<tr>
							<td>A.P.</td>
							<td class="text-right"><?=$ap[0] ?: '-'?></td>
							<td class="text-right"><?=$ap[1] ?: '-'?></td>
							<td class="text-right">-</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<!-- Footer -->
		<div style="margin-top: 30px; text-align: center; color: #666; font-size: 12px;">
			<p>Generated on: <?=date('F d, Y h:i A')?></p>
		</div>
	</div>
	<?php endforeach; ?>
</div>

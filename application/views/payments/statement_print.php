<?php 
	
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);
	$can_view_detailed_soa = !empty($can_view_detailed_soa);
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
	
	// ASSESSMENT
	if($query_ass->num_rows()>0){
		
		$row_as = $query_ass->row(); 
		$as_id = $row_as->id;
		
		$indntals = explode(",",$row_as->incidentals);
		$msclns = explode(",",$row_as->miscellaneous);
		
		$oldaccount = $row_as->oldaccount;
		$tuition = $row_as->tuition;
		$prepaidpaces = $row_as->prepaidpaces;
		$balancepaces = number_format(($indntals[0]-$prepaidpaces),2);
		
		$scholarship = $row_as->scholarship;
		$preenrollment = $row_as->preenrollment;
		$fullpayment = $row_as->fullpayment;
		
		$discountedtuition = ($tuition - ($scholarship + $preenrollment + $fullpayment));
		
		$registration = $row_as->registration;
		$total_msclns = array_sum( $msclns );
		$total_indntals = array_sum( $indntals );
		
		$r_m_i = $total_msclns + $total_indntals + $registration;
		$m_scholar_tuition = $tuition/9;
		
		$total_ass = $r_m_i + $tuition;
		$paymentenroll = $row_as->payment;
		
		// PAID Enrollment bills...
		$paid_enrollment = 0;
		if($paid_enroll->num_rows() > 0){
			foreach($paid_enroll->result() as $row_paid_enroll):
				$paid_enrollment += $row_paid_enroll->payment_total;
			endforeach;
		}
		
		// SCHOLAR (regular monthly)
		$monthly_scholar = ($r_m_i - $paid_enrollment)/9;
		
		$balance = $total_ass - $paid_enrollment;
		if($row->gradelevel=="Grade-11" or $row->gradelevel=="Grade-12"){
			$monthly = $balance/4;
		}else{
			$monthly = $balance/9;
		}	
		
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
		
		$oldaccount = "";
		$tuition = $def_assessment->tuition;
		$prepaidpaces = "0.00";
		$balancepaces = "0.00";
		
		$scholarship = $def_assessment->scholarship;
		$preenrollment = $def_assessment->preenrollment;
		$fullpayment = $def_assessment->fullpayment;
		
		$discountedtuition = number_format($tuition - ($scholarship + $preenrollment + $fullpayment),2);
		
		$registration = $def_assessment->registration;
		$paymentenroll = $def_assessment->payment_enroll;
		
		$total_msclns = array_sum( $msclns );
		$total_indntals = array_sum( $indntals );
		$total_ass = $total_msclns + $total_indntals + $registration + $tuition;
		$balance = $total_ass;
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
/* Statement of Account Print Styles */
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

.print-table .text-center {
	text-align: center;
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

	<!-- Student Info Box -->
	<div class="student-info-box">
		<h4>STATEMENT OF ACCOUNT</h4>
		<div class="info-grid">
			<div class="info-row">
				<div class="info-label">Student Name:</div>
				<div class="info-value"><?= $row->lastname . ", " . $row->firstname ?></div>
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

	<div class="row">
	
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					INCIDENTALS
				</div>
				<div class="card-body">
					<?php
					$tindntals = 0;
					foreach($indntals_list as $ind=>$indntals_val):
						if(isset($indntals[$ind]) && $indntals[$ind]>0):
						$tindntals += $indntals[$ind];
					?>
					<div class="info-row">
						<div class="info-label"><?=$indntals_val?></div>
						<div class="info-value text-right"><?=number_format($indntals[$ind])?></div>
					</div>
					<?php
						endif;
					endforeach;
					?>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					MISCELLANEOUS
				</div>
				<div class="card-body">
					<?php
					$tmsclns = 0;
					foreach($msclns_list as $ind=>$msclns_val):
						$misc_value = isset($msclns[$ind]) ? (float) $msclns[$ind] : 0;
						if($misc_value > 0):
						$tmsclns += $misc_value;
						if($can_view_detailed_soa):
					?>
					<div class="info-row">
						<div class="info-label"><?=$msclns_val?></div>
						<div class="info-value text-right"><?=number_format($misc_value,2)?></div>
					</div>
					<?php
						endif;
						endif;
					endforeach;
					if(!$can_view_detailed_soa):
					?>
					<div class="info-row">
						<div class="info-label">Miscellaneous Total</div>
						<div class="info-value text-right"><?=number_format($tmsclns,2)?></div>
					</div>
					<?php endif; ?>
					<hr>
					<table width="100%">
						<tr>
							<td>TUITION</td>
							<td class="text-right"><?=number_format($tuition,2)?></td>
						</tr>
						<tr>
							<td>REGISTRATION</td>
							<td class="text-right"><?=number_format($registration,2)?></td>
						</tr>
						<tr>
							<td>TOTAL MISC</td>
							<td class="text-right"><?=number_format($tmsclns,2)?></td>
						</tr>
						<tr>
							<td>TOTAL INCIDENTALS</td>
							<td class="text-right"><?=number_format($tindntals,2)?></td>
						</tr>
						<tr><td colspan="2"><hr></td></tr>
						<tr>
							<td><strong>TOTAL ASSESSMENT</strong></td>
							<td class="text-right"><strong class="total"><?=number_format($total_ass,2)?></strong></td>
						</tr>
						<tr><td colspan="2"><hr></td></tr>
						<tr>
							<td><strong>MONTHLY OBLIGATION</strong></td>
							<td class="text-right"><strong class="highlight"><?=number_format($monthly,2)?></strong></td>
						</tr>
						<?php
						if($row->scholar=="Yes"){
						?>
						<tr>
							<td><code>MONTHLY OBLIGATION (Parents)</code></td>
							<td class="text-right"><code><?=number_format($monthly_scholar,2)?></code></td>
						</tr>
						<?php
						}
						?>
					</table>
				</div>
			</div>
		</div>
		
	</div>
	
	<?php if($can_view_detailed_soa): ?>
	<!-- Payment History -->
	<div class="card">
		<div class="card-header">
			PAYMENT HISTORY
		</div>
		<div class="card-body">
			<table class="print-table">
				<thead>
					<tr>
						<th class="text-center">Date</th>
						<th>Invoice #</th>
						<th>Description</th>
						<th class="text-right">Amount</th>
						<th class="text-right">Balance</th>
						<th>Comment</th>
					</tr>
				</thead>
				<tbody>
				
				<tr>
					<td colspan="3">&nbsp;</td>
					<td class="text-right"><strong>Beginning Balance</strong></td>
					<td class="text-right"><strong><?=number_format($total_ass,2)?></strong></td>
					<td>&nbsp;</td>
				</tr>
				
				<?php
				$balance = $total_ass;
				if($query_payments->num_rows() > 0)
				{
					$ctr=1;
					foreach($query_payments->result() as $row_payment):
						$balance -= $row_payment->payment_total;
						echo "<tr>";
						echo "<td class=\"text-center\">".date("m/d/y",strtotime($row_payment->payment_date))."</td>";
						echo "<td>".$row_payment->invoice_number."</td>";
						echo "<td>".$row_payment->payment_note."</td>";
						echo "<td class=\"text-right\">".number_format($row_payment->payment_total,2)."</td>";
						echo "<td class=\"text-right\">".number_format($balance,2)."</td>";
						echo "<td></td></tr>";
						
					endforeach;
				}
				
				?>
				  
				</tbody>
				
			</table>
		</div>
	</div>
	<?php endif; ?>
	
	<!-- Footer -->
	<div style="margin-top: 30px; text-align: center; color: #666; font-size: 12px;">
		<p>Generated on: <?=date('F d, Y h:i A')?></p>
	</div>
	
</div>

<?php 
	
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);
	$can_view_detailed_soa = !empty($can_view_detailed_soa);
	$show_items_without_amounts = !empty($show_items_without_amounts);
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
		<table class="student-info-table">
			<tr>
				<td><span class="info-label">Student Name:</span> <span class="info-value"><?= $row->lastname . ", " . $row->firstname ?></span></td>
				<td><span class="info-label">Grade Level:</span> <span class="info-value"><?=$row->gradelevel?></span></td>
			</tr>
			<tr>
				<td><span class="info-label">ID Number:</span> <span class="info-value"><?=$row->studentno ?: 'N/A'?></span></td>
				<td><span class="info-label">School Year:</span> <span class="info-value"><?=date('Y')?></span></td>
			</tr>
		</table>
	</div>

	<div class="soa-print-grid">
	
		<div class="soa-print-col-left">
			<div class="card">
				<div class="card-header" style="text-align: center; color: black !important; font-weight: 900; border: none !important; border-bottom: 1px solid #ddd !important; background: transparent !important; font-size: 14px; padding: 10px 0;">
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
						<div class="info-value text-right"></div>
					</div>
					<?php
						endif;
					endforeach;
					if(!$can_view_detailed_soa && !$show_items_without_amounts):
					?>
					<div class="info-row">
						<div class="info-label">Incidentals Total</div>
						<div class="info-value text-right"><?=number_format($tindntals,2)?></div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="soa-print-col-right">
			<div class="card">
				<div class="card-header" style="text-align: center; color: black !important; font-weight: 900; border: none !important; border-bottom: 1px solid #ddd !important; background: transparent !important; font-size: 14px; padding: 10px 0;">
					MISCELLANEOUS
				</div>
				<div class="card-body">
					<?php
					$tmsclns = 0;
					foreach($msclns_list as $ind=>$msclns_val):
						$misc_value = isset($msclns[$ind]) ? (float) $msclns[$ind] : 0;
						if($misc_value > 0):
						$tmsclns += $misc_value;
					?>
					<div class="info-row">
						<div class="info-label"><?=$msclns_val?></div>
						<div class="info-value text-right"></div>
					</div>
					<?php
						endif;
					endforeach;
					if(!$can_view_detailed_soa && !$show_items_without_amounts):
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
	<div class="print-footer">
		<p>Generated on: <?=date('F d, Y h:i A')?></p>
	</div>
	
</div>

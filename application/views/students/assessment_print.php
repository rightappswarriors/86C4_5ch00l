<?php 
	
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);
	
	$current_schoolyear = $this->session->userdata('current_schoolyear') ?? date('Y');
	
	if($query_ass->num_rows()>0){
		
		$row_as = $query_ass->row(); 
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
		
	}else{
		
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
		
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Financial Assessment - <?= $row->firstname . " " . $row->lastname ?></title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: Arial, sans-serif; font-size: 10pt; line-height: 1.0; color: #000; background: #fff; }
		
		.page { width: 8.5in; min-height: 11in; margin: 0 auto; padding: 0.25in; }
		
		.header { text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 10px; }
		
		.info-row { margin-bottom: 6px; font-size: 10pt; }
		.info-row .label { font-weight: bold; }
		.info-row .field { display: inline-block; border-bottom: 1px solid #000; min-width: 200px; padding: 0 2px; }
		.info-row .small { display: inline-block; border-bottom: 1px solid #000; min-width: 60px; padding: 0 2px; }
		
		.section-title { font-weight: bold; font-size: 10pt; margin-top: 8px; margin-bottom: 4px; }
		
		.fee-row { margin-bottom: 2px; font-size: 9pt; }
		.fee-row .label { display: inline-block; width: 180px; }
		.fee-row .field { display: inline-block; border-bottom: 1px solid #000; min-width: 80px; text-align: right; padding-right: 3px; }
		
		.incidentals-grid { margin-top: 4px; }
		.incidentals-grid .row { display: flex; }
		.incidentals-grid .col { width: 50%; }
		.incidentals-grid .item { font-size: 8pt; margin-bottom: 1px; }
		.incidentals-grid .item .label { display: inline-block; width: 110px; }
		.incidentals-grid .item .field { display: inline-block; border-bottom: 1px solid #000; min-width: 55px; text-align: right; padding-right: 3px; }
		
		.total-line { font-weight: bold; font-size: 10pt; border-top: 1px solid #000; padding-top: 2px; margin-top: 2px; }
		
		.payment-row { margin-bottom: 3px; font-size: 9pt; }
		.payment-row .label { display: inline-block; width: 160px; }
		.payment-row .field { display: inline-block; border-bottom: 1px solid #000; min-width: 80px; text-align: right; padding-right: 3px; }
		
		.agreement { margin-top: 10px; font-size: 7pt; font-style: italic; line-height: 1.2; padding: 5px; border: 1px solid #999; }
		
		.sigs { margin-top: 15px; display: flex; justify-content: space-between; }
		.sigs .sig { width: 45%; }
		.sigs .sig-line { border-bottom: 1px solid #000; margin-top: 20px; }
		.sigs .sig-label { font-size: 8pt; margin-top: 2px; }
		
		@media print {
			body { margin: 0; padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
			.page { width: 100%; min-height: auto; margin: 0; padding: 0.2in; }
			@page { size: letter portrait; margin: 0; }
		}
		
		@media screen {
			body { background: #666; padding: 15px; }
			.page { background: #fff; box-shadow: 0 0 8px rgba(0,0,0,0.3); margin-bottom: 15px; }
			.toolbar { text-align: center; padding: 12px; background: #222; color: #fff; position: sticky; top: 0; z-index: 100; }
			.toolbar button { padding: 8px 16px; font-size: 13px; cursor: pointer; background: #2196F3; color: white; border: none; border-radius: 3px; margin: 0 4px; }
			.toolbar button:hover { background: #1976D2; }
		}
	</style>
</head>
<body>

<div class="toolbar">
	<button onclick="window.print()">PRINT / SAVE PDF</button>
	<button onclick="window.close()">CLOSE</button>
</div>

<div class="page">
	<div class="header">FINANCIAL ASSESSMENT FORM</div>
	
	<div class="info-row">
		<span class="label">NAME:</span>
		<span class="field"><?= strtoupper($row->firstname . " " . $row->lastname) ?></span>
		<span class="label" style="margin-left:20px;">DATE:</span>
		<span class="small"><?= date('m/d/Y') ?></span>
	</div>
	
	<div class="info-row">
		<span class="label">GRADE: (RR-G3/G4-10)</span>
		<span class="small"><?= strtoupper($row->gradelevel) ?></span>
		<span class="label" style="margin-left:20px;">S.Y.:</span>
		<span class="small"><?= $current_schoolyear ?></span>
	</div>
	
	<div class="section-title">TOTAL COMPUTATION</div>
	<div class="fee-row"><span class="label">TUITION</span><span class="field"><?= number_format($tuition, 2) ?></span></div>
	<div class="fee-row"><span class="label">REGISTRATION</span><span class="field"><?= number_format($registration, 2) ?></span></div>
	<div class="fee-row"><span class="label">TOTAL MISCELLANEOUS</span><span class="field"><?= number_format($total_msclns, 2) ?></span></div>
	<div class="fee-row"><span class="label">TOTAL INCIDENTALS</span><span class="field"><?= number_format($total_indntals, 2) ?></span></div>
	
	<div class="section-title">INCIDENTALS</div>
	<div class="incidentals-grid">
		<div class="row">
			<div class="col">
				<?php $half = ceil(count($indntals_list) / 2); for($i = 0; $i < $half && $i < count($indntals_list); $i++): ?>
				<div class="item"><span class="label"><?= $indntals_list[$i] ?></span><span class="field"><?= number_format($indntals[$i] ?? 0, 2) ?></span></div>
				<?php endfor; ?>
			</div>
			<div class="col">
				<?php for($i = $half; $i < count($indntals_list); $i++): ?>
				<div class="item"><span class="label"><?= $indntals_list[$i] ?></span><span class="field"><?= number_format($indntals[$i] ?? 0, 2) ?></span></div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	
	<div class="total-line"><span class="label">TOTAL ASSESSMENT:</span><span class="field"><?= number_format($total_ass, 2) ?></span></div>
	
	<div class="payment-row"><span class="label">Paid upon enrolment:</span><span class="field"><?= number_format($paymentenroll, 2) ?></span></div>
	<div class="payment-row"><span class="label">Balance:</span><span class="field"><?= number_format($balance, 2) ?></span></div>
	<div class="payment-row"><span class="label">Due every 5th of the month:</span><span class="field"><?= number_format($monthly, 2) ?></span></div>
	<div class="payment-row"><span class="label">Payment received by:</span><span class="field"></span></div>
	
	<div class="agreement">
		We the undersigned pledge to abide by the CHURCH-SCHOOL POLICY, DISCIPLINE, RULES AND REGULATIONS and the NO PAYMENT; NO STAMPING OF PACEs policy (1 month overdue) without reservations.
	</div>
	
	<div class="sigs">
		<div class="sig"><div class="sig-line"></div><div class="sig-label">Father's Signature over Printed Name</div></div>
		<div class="sig"><div class="sig-line"></div><div class="sig-label">Mother's Signature Over Printed Name</div></div>
	</div>
</div>

</body>
</html>

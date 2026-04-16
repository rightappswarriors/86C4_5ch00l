<?php 
	
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);
	$can_view_detailed_soa = !empty($can_view_detailed_soa);
	$can_view_soa_amounts = !empty($can_view_soa_amounts);
	$can_print_soa = !empty($can_print_soa);
	$format_soa_amount = function ($amount, $decimals = 2) use ($can_view_soa_amounts) {
		return $can_view_soa_amounts ? number_format((float) $amount, $decimals) : '';
	};
	
	// ASSESSMENT
	if($query_ass->num_rows()>0){
		
		$row_as = $query_ass->row(); 
		$as_id = $row_as->id;
		
		$indntals = explode(",",$row_as->incidentals);
		$msclns = explode(",",$row_as->miscellaneous);
		
		$oldaccount = $row_as->oldaccount;
		$tuition = $row_as->tuition;
		$prepaidpaces = $row_as->prepaidpaces;
		//$balancepaces = $row_as->balancepaces;
		$balancepaces = number_format(($indntals[0]-$prepaidpaces),2);
		
		$scholarship = $row_as->scholarship;
		$preenrollment = $row_as->preenrollment;
		$fullpayment = $row_as->fullpayment;
		
		$discountedtuition = ($tuition - ($scholarship + $preenrollment + $fullpayment));
		
		$registration = $row_as->registration;
		$total_msclns = array_sum( $msclns );
		$total_indntals = array_sum( $indntals );
		//$total_indntals = ($total_indntals - $prepaidpaces);
		//$total_ass = $total_msclns + $total_indntals + $registration + $discountedtuition;
		$total_ass = $total_msclns + $total_indntals + $registration + $tuition;
		$paymentenroll = $row_as->payment;
		//$balance = $total_ass - $paymentenroll;
		
		// PAID Enrollment bills...
		$paid_enrollment = 0;
		if($paid_enroll->num_rows() > 0){
			foreach($paid_enroll->result() as $row_paid_enroll):
				$paid_enrollment += $row_paid_enroll->payment_total;
			endforeach;
		}
		
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
		//$balance = $total_ass - $paymentenroll;
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


<?php $this->load->view("students/menu",$data) ?>
<div class="col-md-12 grid-margin">
	<div class="card">
	  <div class="card-body">
		
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="text-primary flash-message-spaced">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>	
		
		<h3 class="heading soa-heading">Statement of Account</h3>
		
		<div class="row">
			<div class="col-md-12 soa-action-bar">
				<a href="<?=site_url("payments/statement/".$row->id)?>" title="Refresh" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-refresh'></i></a><?php if ($can_print_soa): ?>&nbsp;<a href="<?=site_url("payments/statement_print/".$row->id)?>" title="Print" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-printer'></i></a><?php endif; ?>
			</div>
		</div><br>
		
		<div class="row">
		
			<div class="col-md-4 grid-margin stretch-card">
				<div class="card">
				  <div class="card-body">
					<h4 class="card-title">INCIDENTALS</h4>
					
					<?php
				$tindntals = 0;
				foreach($indntals_list as $ind=>$indntals_val):
					if($indntals[$ind]>0){
					$tindntals += $indntals[$ind];
					if ($can_view_soa_amounts):
				?>
				<div class="row">
					<label class="col-sm-6 col-form-label"><code class="text-info"><?=$indntals_val?></code></label>
					<div class="col-sm-6 text-right"><code class="text-info"><?=$format_soa_amount($indntals[$ind], 0)?></code></div>
				</div>
				<?php
					endif;
					}
				endforeach;
				if (!$can_view_soa_amounts):
				?>
				<div class="row">
					<label class="col-sm-6 col-form-label"><code class="text-info">Incidentals Total</code></label>
					<div class="col-sm-6 text-right"><code class="text-info"><?=number_format($tindntals,2)?></code></div>
				</div>
				<?php endif; ?>
					
				  </div>
				</div>
			</div>

			<div class="col-md-8 grid-margin stretch-card">
				<div class="card">
				  <div class="card-body<?= !$can_view_soa_amounts ? ' soa-misc-card' : '' ?>">
					<h4 class="card-title">MISCELLANEOUS</h4>
					<?php
				$tmsclns = 0;
				foreach($msclns_list as $ind=>$msclns_val):
					$misc_value = isset($msclns[$ind]) ? (float) $msclns[$ind] : 0;
					if($misc_value > 0){
					$tmsclns += $misc_value;
					if ($can_view_soa_amounts):
				?>
				<div class="row">
					<label class="col-sm-6 col-form-label"><code class="text-info"><?=$msclns_val?></code></label>
					<div class="col-sm-6 text-right"><code class="text-info"><?=$format_soa_amount($misc_value)?></code></div>
				</div>
				<?php
					endif;
					}
				endforeach;
				if (!$can_view_soa_amounts):
				?>
				<div class="row">
					<label class="col-sm-6 col-form-label"><code class="text-info">Miscellaneous Total</code></label>
					<div class="col-sm-6 text-right"><code class="text-info"><?=number_format($tmsclns,2)?></code></div>
				</div>
				<?php endif; ?>
					<?php if ($can_view_soa_amounts): ?>
					<hr>
					<?php endif; ?>
					<table width="100%">
						<tr>
							<td width="50%">TUITION</td>
							<td width="50%" class="text-right"><?=number_format($tuition,2)?></td>
						</tr><tr>
							<td>REGISTRATION</td>
							<td class="text-right"><?=number_format($registration,2)?></td>
						</tr><tr>
							<td>TOTAL MISC</td>
							<td class="text-right"><?=number_format($tmsclns,2)?></td>
						</tr><tr>
							<td>TOTAL INCIDENTALS</td>
							<td class="text-right"><?=number_format($tindntals,2)?></td>
						</tr>
						<tr><td colspan="2"><hr><td></td></tr>
						<tr>
							<td><b>TOTAL ASSESSMENT</b></td>
							<td class="text-right"><b><?=number_format($total_ass,2)?></b></td>
						</tr>
						<tr><td colspan="2"><hr><td></td></tr>
						<tr>
							<td>MONTHLY OBLIGATION</td>
							<td class="text-right"><?=number_format($monthly,2)?></td>
						</tr>
					</table>
					
				  </div>
				</div>
			</div>
			
		</div>
		
		
		<?php if ($can_view_detailed_soa): ?>
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="10%">Date</th>
				<th width="15%">Invoice #</th>
				<th width="25%">Description</th>
				<th width="20%">Amount</th>
				<th width="15%">Balance</th>
				<th width="15%">Comment</th>
			  </tr>
			</thead>
			<tbody>
			
			<tr>
			<td colspan="2">&nbsp;</td>
			<td>Beginning Balance</td>
			<td class="text-right" colspan="2"><?=number_format($total_ass,2)?></td>
			<td>&nbsp;</td>
			</tr>
			
			<?php
			$balance = $total_ass;
			if($query_payments->num_rows() > 0)
			{
				$ctr=1;
				foreach($query_payments->result() as $row):
					$balance -= $row->payment_total;
					echo "<tr>";
					echo "<td>".date("m/d/y",strtotime($row->payment_date))."</td>";
					echo "<td>".$row->invoice_number."</td>";
					echo "<td>".$row->payment_note."</td>";
					echo "<td class='text-right'>".number_format($row->payment_total,2)."</td>";
					echo "<td class='text-right'>".number_format($balance,2)."</td>";
					echo "<td></td></tr>";
					
				endforeach;
			}
			
			?>
			  
			</tbody>
			
		  </table>
		</div>
		<?php endif; ?>
		
		
	  </div>
	</div>
</div>

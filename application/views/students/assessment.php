<?php 
	
	$row = $query->row(); 
	$studentid = $row->id;
	$data = array( 'row'  => $row );
	
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);

	$grade_band = function($gradelevel){
		$value = strtoupper(trim((string) $gradelevel));

		if ($value === '') {
			return 'G4-10';
		}

		if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*(?:10|11|12|[4-9])\b/i', $value)) {
			return 'G4-10';
		}

		if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*[1-3]\b/i', $value)) {
			return 'RR-G3';
		}

		$tokens = preg_split('/[^A-Z0-9]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
		if (in_array('RR', $tokens, true) || in_array('ABCS', $tokens, true) || in_array('K1', $tokens, true) || in_array('K2', $tokens, true)) {
			return 'RR-G3';
		}

		if (preg_match('/\b(10|11|12|[4-9])\b/', $value)) {
			return 'G4-10';
		}

		if (preg_match('/(?:GRADE|LEVEL)?\s*-?\s*(\d{1,2})/i', $value, $match)) {
			return ((int) $match[1] <= 3) ? 'RR-G3' : 'G4-10';
		}

		return 'G4-10';
	};

	$g4_10_incidentals = array(
		'PACEs',
		'TLE',
		'HELE',
		'MAPEH',
		'Parent Orientation',
		'Handbook',
		'Goal/Progress Chart Cover',
		'Flags',
		'ID',
		'Notebook',
		'Closing Fee',
		"Fetcher\'s ID",
		"Founder\'s Day",
		'Graduation Fee',
		'Congress Fee',
		'Late Fee',
		'CEM'
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
		$as_id = $row_as->id;
		$promissory_payment = isset($row_as->promissory_payment) && is_numeric($row_as->promissory_payment) ? $row_as->promissory_payment : 0;
		$promissory_monthly = $promissory_payment; // Treated as monthly value directly
		
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
		$promissory_payment = 0;
		$promissory_monthly = 0;
		
	}

	$current_grade_band = $grade_band(isset($row->gradelevel) ? $row->gradelevel : '');
	if($current_grade_band === 'G4-10' && count($indntals_list) === count($g4_10_incidentals)){
		$indntals_list = $g4_10_incidentals;
	}
?>

<style>
.assessment-total-box {
	border: 2px solid #48b8ff;
	padding: 10px 12px 8px;
	margin-top: 10px;
}

.assessment-total-row {
	display: flex;
	align-items: center;
	gap: 10px;
	margin-bottom: 4px;
	font-size: 12px;
}

.assessment-total-row:last-child {
	margin-bottom: 0;
}

.assessment-total-row label {
	width: 170px;
	margin: 0;
	font-weight: 700;
	color: #000;
}

.assessment-total-row.assessment-due-row label {
	color: #1298f6;
}

.assessment-total-input, 
.form-control {
	border: none !important;
	border-bottom: 1px solid #000 !important;
	border-radius: 0 !important;
	background: transparent !important;
	text-align: right;
	font-weight: 700;
	box-shadow: none !important;
	height: 25px !important;
	padding: 2px 0 !important;
}

.form-control:focus {
	outline: none !important;
	border-bottom: 2px solid #1298f6 !important;
	box-shadow: none !important;
}
</style>

<script>
$(function(){	
	
	$('input[type=text]').on('keyup',function(e){
		compute_total();
	});

	$('input[type=text]').on('blur', function() {
		if($(this).val().length == 0) {
			$(this).val("0");
		}
	});
	
	$('input[type=text]').keypress(function(event){
       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault(); //stop character from entering input
       }
		
   });
   
   <?php 
	if($this->session->userdata('current_usertype') == 'Parent'):
	?>
	$("input[type='text']").attr("disabled",true);
	<?php
	endif;
   ?>
	
	$("#chkconfirmed").click(function() {
		$("#btnstatus").attr("disabled", !this.checked);
	});	
	
	$("#btnstatus").click(function(){
		
		window.location.href = '<?=site_url("students/changestatus/Interview/".$row->id)?>';
		
	});
	
});

function saveAndGoToPaces() {
    var form = $('form');
    var originalAction = form.attr('action');
    form.attr('action', '<?=site_url("students/assessment_submit/".$row->id)?>');
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function() {
            window.location.href = '<?=site_url("students/assessment_paces/".$row->id)?>';
        },
        error: function() {
            window.location.href = '<?=site_url("students/assessment_paces/".$row->id)?>';
        }
    });
}

function compute_total(){
	
	var asstotal = 0;
	var sum_indntals = 0;
	var sum_msclns = 0;
	
	// INCIDENTALS
    $("input[name^='indntals']").each(function(){
        sum_indntals += Number($(this).val());
    });
    $("#totalinc").val( humanizeNumber( sum_indntals.toFixed(2) ) );
	
	// MISCELLANEOUS
	$("input[name^='msclns']").each(function(){
        sum_msclns += Number($(this).val());
    });
    $("#totalmisc").val( humanizeNumber( sum_msclns.toFixed(2) ) );
	
	// Total Assessment
	asstotal = Number( $("#tuition").val() ) + Number( $("#registration").val() ) + Number( sum_msclns ) + Number( sum_indntals ) ;
	$("#asstotal").val( humanizeNumber( asstotal.toFixed(2) ) );
	$("#asstotal_hidden").val( asstotal.toFixed(2) );
	
	// BALANCE: Total Assessment minus Payment upon Enrollment
	var balance = Number( asstotal ) - Number( $("#paymentenroll").val() );
	$("#balance").val( humanizeNumber( balance.toFixed(2) ) );
	
	// MONTHLY Due (Balance ÷ 9)
	var monthdue = Number( balance ) / 9;
	$("#monthdue").val( humanizeNumber( monthdue.toFixed(2) ) ); 
	
	// TOTAL AMOUNT: Monthly Due + Monthly Promissory Note Payment
	// We treat the input value as a direct monthly addition.
	var promissoryRaw = $("#promissory_payment").val() || "0";
	var promissoryMonthly = parseFloat(promissoryRaw.replace(/,/g, '')) || 0;
	var totalAmount = monthdue + promissoryMonthly;
	
	$("#monthdue").val( humanizeNumber( totalAmount.toFixed(2) ) ); 
	$("#promissory_monthly").val( humanizeNumber( totalAmount.toFixed(2) ) ); 
	
}

function humanizeNumber(n) {
  n = n.toString()
  while (true) {
    var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
    if (n == n2) break
    n = n2
  }
  return n
}

</script>

<?php $this->load->view("students/menu",$data) ?>

<style>
  .content-wrapper {
    margin-top: 0;
  }
</style>

<div class="content-wrapper">

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
		
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="text-primary" style="margin-bottom:10px;">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>	
		
		<form action="<?=site_url("students/assessment_submit/".$row->id)?>" method="post">
		<input type="hidden" name="as_id" value="<?=$as_id?>">
		
		<h3 class="heading" style="text-align:center;">Assessment</h3>
		
		<br>
		<div class="row">
			<div class="col-md-12" style="text-align:center; margin-bottom: 15px;">
				<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-lg btn-primary">Financial Assessment</a>
				<a href="<?=site_url("students/assessment_paces/".$row->id)?>" class="btn btn-lg btn-info">Pace's Assessment</a>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
<?php
		if($this->session->userdata('current_usertype') == 'Parent'):
		?>	
		<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-refresh'></i></a>	
		<?php endif; ?>
		<?php 
		$allowed_print_roles = array('Accounting', 'Super Admin', 'Admin', 'Registrar');
		if(in_array($this->session->userdata('current_usertype'), $allowed_print_roles)): 
		?>
		<a href="<?=site_url("students/assessment_print/".$row->id)?>" title="Print" class="btn btn-icons btn-secondary btn-rounded" target="_blank"><i class='mdi mdi-printer'></i></a>
		<?php endif; ?>
		<?php 
		$allowed_pace_roles = array('Accounting', 'Super Admin', 'Admin', 'Registrar');
		if(in_array($this->session->userdata('current_usertype'), $allowed_pace_roles)): 
		?>
		<button type="button" onclick="saveAndGoToPaces()" class="btn btn-icons btn-info btn-rounded" title="Save Assessment & Go to PACEs"><i class='mdi mdi-book-open-page-variant'></i></button>
		<a href="<?=site_url("students/assessment_paces/".$row->id)?>" title="Assessment PACEs" class="btn btn-icons btn-secondary btn-rounded" style="display:none;"><i class='mdi mdi-book-open-page-variant'></i></a>
		<?php endif; ?>
		</div>
		</div>

		<div class="row">
		
			<div class="col-md-6">
			<p class="card-description text-info">INCIDENTALS</p>
				<?php
				foreach($indntals_list as $ind=>$indntals_val):
				?>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label"><?=$indntals_val?></label>
					<div class="col-sm-6">
					  <input type="text" name="indntals[]" value="<?=isset($indntals[$ind]) ? $indntals[$ind] : '0'?>" class="form-control" />
					</div>
				</div>
				<?php
				endforeach;
				?>
				
				<?php
				$allowed_update_roles = array('Accounting', 'Super Admin', 'Admin', 'Registrar');
				if(in_array($this->session->userdata('current_usertype'), $allowed_update_roles)):
				?>	
				<div style="margin-top: 15px;">
					<input type="submit" class="btn btn-lg btn-primary" value="UPDATE Assessment">
				</div>
				<?php endif; ?>
			</div>
			
			<div class="col-md-6">
				<?php foreach($msclns_list as $ind=>$msclns_val): ?>
				<input type="hidden" name="msclns[]" value="<?=isset($msclns[$ind]) ? $msclns[$ind] : '0'?>" />
				<?php endforeach; ?>
			  
			  <hr>
			  <p class="card-description text-info">TOTAL COMPUTATION</p>	
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>TUITION</b></label>
				<div class="col-sm-6">
				  <input type="text" id="tuition" name="tuition" value="<?=set_value('tuition',$tuition)?>" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>REGISTRATION</b></label>
				<div class="col-sm-6">
				  <input type="text" id="registration" name="registration" value="<?=set_value('registration',$registration)?>" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>TOTAL MISCELLANEOUS</b></label>
				<div class="col-sm-6">
				  <input type="text" id="totalmisc" name="totalmisc" value="<?=set_value('totalmisc',number_format($total_msclns,2))?>" class="form-control" disabled />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>TOTAL INCIDENTALS</b></label>
				<div class="col-sm-6">
				  <input type="text" id="totalinc" name="totalinc" value="<?=set_value('totalinc',number_format($total_indntals,2))?>" class="form-control" disabled />
				</div>
			  </div>
			  
			  <div class="assessment-total-box">
				<div class="assessment-total-row">
					<label>TOTAL ASSESSMENT:</label>
					<input type="text" id="asstotal" name="asstotal" value="<?=set_value('asstotal',number_format($total_ass,2))?>" class="assessment-total-input" disabled />
					<input type="hidden" id="asstotal_hidden" name="asstotal_hidden" value="<?=$total_ass?>">
				</div>
				<div class="assessment-total-row">
					<label>Paid upon enrollment:</label>
					<input type="text" id="paymentenroll" name="paymentenroll" value="<?=set_value('paymentenroll',$paymentenroll)?>" class="assessment-total-input" />
				</div>
				<div class="assessment-total-row">
					<label>Balance:</label>
					<input type="text" id="balance" name="balance" value="<?=set_value('balance',number_format($balance,2))?>" class="assessment-total-input" disabled/>
				</div>
				<div class="assessment-total-row">
					<label>Due every month:</label>
					<input type="text" id="monthdue" name="monthdue" value="<?=set_value('monthdue',number_format($monthly + $promissory_monthly, 2))?>" class="assessment-total-input" disabled/>
				</div>

				<div class="assessment-total-row">
					<label style="color: #000 !important;">Monthly Promissory Note Payment:</label>
					<input type="text" id="promissory_payment" name="promissory_payment" value="<?=set_value('promissory_payment',$promissory_payment)?>" class="assessment-total-input" />
				</div>

				<div class="assessment-total-row assessment-due-row">
					<label>Total Amount:</label>
					<input type="text" id="promissory_monthly" name="promissory_monthly" value="<?=set_value('promissory_monthly', number_format($monthly + $promissory_monthly, 2))?>" class="assessment-total-input" disabled/>
				</div>

				<div class="assessment-total-row">
					<label>Payment received by:</label>
					<input type="text" value="" class="assessment-total-input" disabled />
				</div>
			  </div>
			  
			</div>
			
		</div>
		
		<br>
		<div class="row">
		
		<?php
		if($this->session->userdata('current_usertype') == 'Parent'):
		?>	
		<div class="col-md-6" style="text-align:left;">
		<div class="form-check form-check-flat">
			  <label class="form-check-label">			  
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> I agree with the Financial Assessment for my student. </label>
			</div>
		<input type="button" href="<?=site_url("students/changestatus/Interview/".$row->id)?>" value="Change Status: For Interview" class="btn btn-lg btn-success" id="btnstatus" disabled>
		<br>
		</div>
		
		<?php
		endif;
		if($this->session->userdata('current_usertype') == 'Registrar'):
		?>
		<div class="col-md-6" style="text-align:left;">
		<input type="submit" class="btn btn-lg btn-primary" value="UPDATE Assessment">
		</div>
		<?php endif; ?>
				
		</div>
		
		</form>
		
	  </div>
	</div> 
	
</div>
</div>
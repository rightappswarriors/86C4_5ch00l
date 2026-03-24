<?php 
	
	$row = $query->row(); 
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

.assessment-total-input {
	width: 120px;
	margin-left: auto;
	border: 0;
	border-bottom: 1px solid #000;
	border-radius: 0;
	background: transparent;
	height: 20px;
	padding: 0;
	text-align: right;
	font-size: 12px;
	font-weight: 700;
	box-shadow: none !important;
}

.assessment-total-input[disabled] {
	background: transparent;
	opacity: 1;
	color: #000;
}
</style>

<script>
$(function(){	
	
	$('input[type=text]').on('keyup',function(e){
		if($(this).val().length == 0) {	
			$(this).val("0");
		}
		compute_total();
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
	
	// BALANCE
	var balance = Number( asstotal ) - Number( $("#paymentenroll").val() );
	$("#balance").val( humanizeNumber( balance.toFixed(2) ) );
	
	// MONTHLY Due
	var monthdue = Number( balance ) / 9;
	$("#monthdue").val( humanizeNumber( monthdue.toFixed(2) ) ); 
	
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
		
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
		<?php 
		if($this->session->userdata('current_usertype') == 'Parent'):
		?>
		<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-refresh'></i></a>	
		<?php endif; ?>
		<a href="<?=site_url("students/assessment_print/".$row->id)?>" title="Print" class="btn btn-icons btn-secondary btn-rounded" target="_blank"><i class='mdi mdi-printer'></i></a>
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
					<label>Paid upon enrolments:</label>
					<input type="text" id="paymentenroll" name="paymentenroll" value="<?=set_value('paymentenroll',$paymentenroll)?>" class="assessment-total-input" />
				</div>
				<div class="assessment-total-row">
					<label>Balance:</label>
					<input type="text" id="balance" name="balance" value="<?=set_value('balance',number_format($balance,2))?>" class="assessment-total-input" disabled/>
				</div>
				<div class="assessment-total-row assessment-due-row">
					<label>Due every 5<sup>th</sup> of the month:</label>
					<input type="text" id="monthdue" name="monthdue" value="<?=set_value('monthdue',number_format($monthly,2))?>" class="assessment-total-input" disabled/>
				</div>
				<div class="assessment-total-row">
					<label>Payment received by:</label>
					<input type="text" value="" class="assessment-total-input" disabled />
				</div>
			  </div>
			  
			</div>
			
		</div>
		
		<div class="row">
		
			<div class="col-md-12">
			<p class="card-description text-info">TO BEGIN PACE WORK: /Ordered PACEs</p>	
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Math #</label>
				<div class="col-sm-3">
				  <input type="text" id="math_begin" name="math_begin" value="<?=set_value('math_begin',$math[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="math_end" name="math_end" value="<?=set_value('math_end',$math[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="math_gaps" name="math_gaps" value="<?=set_value('math_gaps',$math[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">English #</label>
				<div class="col-sm-3">
				  <input type="text" id="eng_begin" name="eng_begin" value="<?=set_value('eng_begin',$eng[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="eng_end" name="eng_end" value="<?=set_value('eng_end',$eng[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="eng_gaps" name="eng_gaps" value="<?=set_value('eng_gaps',$eng[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Science #</label>
				<div class="col-sm-3">
				  <input type="text" id="science_begin" name="science_begin" value="<?=set_value('science_begin',$science[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="science_end" name="science_end" value="<?=set_value('science_end',$science[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="science_gaps" name="science_gaps" value="<?=set_value('science_gaps',$science[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Soc. Studies #</label>
				<div class="col-sm-3">
				  <input type="text" id="sstudies_begin" name="sstudies_begin" value="<?=set_value('sstudies_begin',$sstudies[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="sstudies_end" name="sstudies_end" value="<?=set_value('sstudies_end',$sstudies[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="sstudies_gaps" name="sstudies_gaps" value="<?=set_value('sstudies_gaps',$sstudies[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Word Building #</label>
				<div class="col-sm-3">
				  <input type="text" id="wbuilding_begin" name="wbuilding_begin" value="<?=set_value('wbuilding_begin',$wbuilding[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="wbuilding_end" name="wbuilding_end" value="<?=set_value('wbuilding_end',$wbuilding[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="wbuilding_gaps" name="wbuilding_gaps" value="<?=set_value('wbuilding_gaps',$wbuilding[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Literature #</label>
				<div class="col-sm-3">
				  <input type="text" id="literature_begin" name="literature_begin" value="<?=set_value('literature_begin',$literature[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="literature_end" name="literature_end" value="<?=set_value('literature_end',$literature[1])?>" placeholder="End" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Filipino #</label>
				<div class="col-sm-3">
				  <input type="text" id="filipino_begin" name="filipino_begin" value="<?=set_value('filipino_begin',$filipino[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="filipino_end" name="filipino_end" value="<?=set_value('filipino_end',$filipino[1])?>" placeholder="End" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">A.P. #</label>
				<div class="col-sm-3">
				  <input type="text" id="ap_begin" name="ap_begin" value="<?=set_value('ap_begin',$ap[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="ap_end" name="ap_end" value="<?=set_value('ap_end',$ap[1])?>" placeholder="End" class="form-control" />
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
		<input type="submit" class="btn btn-lg btn-primary" value="UPDATE Assessment & PACEs">
		</div>
		<?php endif; ?>
		
		</div>
		
		</form>
		
	  </div>
	</div> 
	
</div>

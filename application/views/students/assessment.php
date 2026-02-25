<?php 
	
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	$estatus = $row->enrollstatus;
	$def_assessment = $default_ass->row();
	$indntals_list = explode(",",$def_assessment->incidentals);
	$msclns_list = explode(",",$def_assessment->miscellaneous);
	
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
		$balance = $total_ass - $paymentenroll;
		$monthly = $balance/9;
		
		$math = explode(",",$row_as->math);
		$eng = explode(",",$row_as->english);
		$science = explode(",",$row_as->science);
		$sstudies = explode(",",$row_as->socstudies);
		$wbuilding = explode(",",$row_as->wordbuilding);
		
		$literature = explode(",",$row_as->literature);
		$filipino = explode(",",$row_as->filipino);
		$afilipino = explode(",",$row_as->afilipino);
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
		$balance = $total_ass - $paymentenroll;
		$monthly = $balance/9;
		
		$math = array("","","");
		$eng = array("","","");
		$science = array("","","");
		$sstudies = array("","","");
		$wbuilding = array("","","");
		
		$literature = array("","","");
		$filipino = array("","","");
		$afilipino = array("","","");
		$ap = array("","","");
		
		$as_id = 0;
		
	}
?>

<script>
$(function(){	
	
	var balancepace=0;
	$('#paceamount').on('keyup',function(){
		balancepace = Number( $("#paceamount").val() ) - Number( $("#prepaidpaces").val() )
		$("#balancepaces").val( humanizeNumber( balancepace.toFixed(2) ) );
		$("#balancepaces1").val( humanizeNumber( balancepace.toFixed(2) ) );
	});
	
	$('#prepaidpaces').on('keyup',function(){
		balancepace = Number( $("#paceamount").val() ) - Number( $("#prepaidpaces").val() )
		$("#balancepaces").val( humanizeNumber( balancepace.toFixed(2) ) );
		$("#balancepaces1").val( humanizeNumber( balancepace.toFixed(2) ) );
	});
	
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
	var discountedtuition = 0;
	
	// INCIDENTALS
    $("input[name^='indntals']").each(function(){
        sum_indntals += Number($(this).val());
    });
	sum_indntals = sum_indntals - Number( $("#prepaidpaces").val() );
    $("#totalinc").val( humanizeNumber( sum_indntals.toFixed(2) ) );
	
	// MISCELLANEOUS
	$("input[name^='msclns']").each(function(){
        sum_msclns += Number($(this).val());
    });
    $("#totalmisc").val( humanizeNumber( sum_msclns.toFixed(2) ) );
	
	discountedtuition = Number( $("#tuition").val() ) - ( Number($("#scholarship").val()) + Number($("#preenrollment").val()) + Number($("#fullpayment").val()) );
	
	// Total Discounted TUITION
	$("#discountedtuition").val( humanizeNumber( discountedtuition.toFixed(2) ) );

	// Total Assessment
	asstotal = Number( discountedtuition ) + Number( $("#registration").val() ) + Number( sum_msclns ) + Number( sum_indntals ) ;
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
		
		<h3 class="heading" style="text-align:center;">Assessment</h3><br>
		
		
			  <!-- Tab links -->
<div class="tab">
  <a class="tablinks btn btn-lg" onclick="openTabContent(event, 'financial')" id="defaultOpen">Financial Assessment</a>
  <!--<a class="tablinks btn btn-lg" onclick="openTabContent(event, 'prepaid')"> Prepaid Bills </a>-->
  <?php if($this->session->userdata('current_usertype') == 'Accounting' or $this->session->userdata('current_usertype') == 'Admin'): ?><a class="tablinks btn btn-lg" onclick="openTabContent(event, 'oldaccount')">Old/Previous Account</a><?php endif; ?>
  <a class="tablinks btn btn-lg" onclick="openTabContent(event, 'paces')">PACEs Assessment</a>
</div>

<!-- Tab content -->
<div id="financial" class="tabcontent">
  <br>  
  <div class="row">
	
			<div class="col-md-6">
			<p class="card-description text-info">INCIDENTALS</p>
				<?php
				foreach($indntals_list as $ind=>$indntals_val):
					$paceid = '';
					if($ind==0){
						$paceid = " id='paceamount'";
					}
					if($ind==1){
						?>
						<div style="display:none;">
						<div class="form-group row">
						<label class="col-sm-4 col-form-label text-warning">Prepaid PACEs</label>
						<div class="col-sm-6">
						  <input type="text" name="prepaidpaces" id="prepaidpaces" value="<?=$prepaidpaces?>" class="form-control" />
						</div>
						</div>
						<div class="form-group row">
						<label class="col-sm-4 col-form-label text-warning">Balance PACEs</label>
						<div class="col-sm-6">
						  <input type="text" id="balancepaces1" value="<?=$balancepaces?>" class="form-control" disabled />
						  <input type="hidden" name="balancepaces" id="balancepaces" value="<?=$balancepaces?>" class="form-control" />
						</div>
						</div>
						</div>
						<?php
					}
				?>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label"><?=$indntals_val?></label>
					<div class="col-sm-6">
					  <input type="text" name="indntals[]"<?=$paceid?> value="<?=$indntals[$ind]?>" class="form-control" />
					</div>
				</div>
				<?php
				endforeach;
				?>
			</div>
			
			<div class="col-md-6">
			<p class="card-description text-info">MISCELLANEOUS</p>	
				<?php
				foreach($msclns_list as $ind=>$msclns_val):
				?>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label"><?=$msclns_val?></label>
					<div class="col-sm-6">
					  <input type="text" name="msclns[]" value="<?=$msclns[$ind]?>" class="form-control" />
					</div>
				</div>
				<?php
				endforeach;
				?>
			  
			  <hr>
			  <p class="card-description text-info">TOTAL COMPUTATION</p>	
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>TUITION</b></label>
				<div class="col-sm-6">
				  <input type="text" id="tuition" name="tuition" value="<?=set_value('tuition',$tuition)?>" class="form-control" />
				</div>
			  </div>
			  
			   <div style="display:none;">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label text-warning">Scholarship(%)</label>
				<div class="col-sm-6">
				  <input type="text" id="scholarship" name="scholarship" value="<?=set_value('scholarship',$scholarship)?>" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label text-warning">Pre-enrollment(%)</label>
				<div class="col-sm-6">
				  <input type="text" id="preenrollment" name="preenrollment" value="<?=set_value('preenrollment',$preenrollment)?>" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label text-warning">Full-payment(%)</label>
				<div class="col-sm-6">
				  <input type="text" id="fullpayment" name="fullpayment" value="<?=set_value('fullpayment',$fullpayment)?>" class="form-control" />
				</div>
			  </div>
			  </div>
			  
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>Total Discounted TUITION</b></label>
				<div class="col-sm-6">
				  <input type="text" id="discountedtuition" name="discountedtuition" value="<?=set_value('discountedtuition',$discountedtuition)?>" class="form-control" disabled />
				</div>
			  </div>
			  <div class="form-group row">
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
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>ASSESSMENT TOTAL</b></label>
				<div class="col-sm-6">
				  <input type="text" id="asstotal" name="asstotal" style="font-weight:bold;border:2px solid #999" value="<?=set_value('asstotal',number_format($total_ass,2))?>" class="form-control" disabled /> 
				  <input type="hidden" id="asstotal_hidden" name="asstotal_hidden" value="<?=$total_ass?>">
				</div>
			  </div>
			  
			  <hr>
			  <!--<p class="card-description text-info">BASIC COMPUTATION</p>	-->
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label text-warning">Amount to be Paid during Enrollment</label>
				<div class="col-sm-6">
				  <input type="text" id="paymentenroll" name="paymentenroll" value="<?=set_value('paymentenroll',$paymentenroll)?>" class="form-control" />
				</div>
			  </div>
			  
			  <div style="display:none;">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>BALANCE</b></label>
				<div class="col-sm-6">
				  <input type="text" id="balance" name="balance" value="<?=set_value('balance',number_format($balance,2))?>" class="form-control" disabled/>
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-4 col-form-label"><b>Due every 5th of the month:</b></label>
				<div class="col-sm-6">
				  <input type="text" id="monthdue" name="monthdue" value="<?=set_value('monthdue',number_format($monthly,2))?>" class="form-control" disabled/>
				</div>
			  </div>
			  </div>
			  
			</div>
			
		</div>
		
		
  
</div>

<div id="prepaid" class="tabcontent" style="display:none;">
	
	<div class="row">
	
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="15%">#</th>
				<th width="15%">Date</th>
				<th width="30%">Note</th>
				<th width="15%">Paid</th>
				<th width="15%">Amount</th>
			</tr>
			</thead>
			<tbody>
			
			<?php

			if($query_payments->num_rows() > 0)
			{
				$ctr=1;
				foreach($query_payments->result() as $row):
					
					$pnote = strlen($row->payment_note)>30 ? substr($row->payment_note,0,30)."...":$row->payment_note;
					
					$payment_file="";
					if(strlen(trim($row->deposit_file))>0){
						$path_file = './file_upload/payments/'.$row->id;
						$payment_file = "<a href='../../../".$path_file."/".$row->deposit_file."' class='btn btn-icons btn-rounded btn-success'><i class='mdi mdi-attachment'></i></a>";
					}
					
					echo "<tr>";
					echo "<td>".$row->payment_code." ".$payment_file."</td>";
					echo "<td>".date("m/d/y",strtotime($row->payment_date))."</td>";
					echo "<td>".$pnote."</td>";
					echo "<td style='text-align:center'><code>".strtoupper($row->paid)."</code></td>";
					echo "<td style='text-align:center'>".number_format($row->payment_total,2)."</td>";
					echo "</tr>";
					
				endforeach;
			}	

			?>	
					
			  
			</tbody>
			
		  </table>
		</div>
	
	
	</div>
	
</div>

<?php if($this->session->userdata('current_usertype') == 'Accounting' or $this->session->userdata('current_usertype') == 'Admin'): ?>
<div id="oldaccount" class="tabcontent">
		<div class="row">
			<div class="col-md-12">
			<br>
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label"><b>Old Account Details</b></label>
				<div class="col-sm-9">
				  <textarea name="oldaccount" class="form-control" id="oldaccount" style="width:100%"><?=$oldaccount?></textarea>
				</div>
			  </div>
			</div>
		</div>
</div>
<?php else: ?>
<input type="hidden" name="oldaccount" value="<?=$oldaccount?>">
<?php endif; ?>

<div id="paces" class="tabcontent">
<br>
  <div class="row">
		
			<div class="col-md-12">
			<p class="card-description text-info">TO BEGIN PACE WORK:/Ordered PACEs</p>	
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
				</div><div class="col-sm-3">
				  <input type="text" id="literature_gaps" name="literature_gaps" value="<?=set_value('literature_gaps',$literature[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Filipino #</label>
				<div class="col-sm-3">
				  <input type="text" id="filipino_begin" name="filipino_begin" value="<?=set_value('filipino_begin',$filipino[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="filipino_end" name="filipino_end" value="<?=set_value('filipino_end',$filipino[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="filipino_gaps" name="filipino_gaps" value="<?=set_value('filipino_gaps',$filipino[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Alfabetong Filipino #</label>
				<div class="col-sm-3">
				  <input type="text" id="afilipino_begin" name="afilipino_begin" value="<?=set_value('afilipino_begin',$afilipino[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="afilipino_end" name="afilipino_end" value="<?=set_value('afilipino_end',$afilipino[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="afilipino_gaps" name="afilipino_gaps" value="<?=set_value('afilipino_gaps',$afilipino[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">A.P. #</label>
				<div class="col-sm-3">
				<input type="text" id="ap_begin" name="ap_begin" value="<?=set_value('ap_begin',$ap[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="ap_end" name="ap_end" value="<?=set_value('ap_end',$ap[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="ap_gaps" name="ap_gaps" value="<?=set_value('ap_gaps',$ap[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div>
			</div>
		</div>

</div>
		
		
		<br>
		<div class="row">
		
		<?php
		if($estatus=="Assessed" or $estatus=="Pending"){
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
		}
		if( $this->session->userdata('current_usertype') == 'Registrar' or $this->session->userdata('current_usertype') == 'Principal' or $this->session->userdata('current_usertype') == 'Accounting' ):
		?>
		<div class="col-md-6" style="text-align:left;">
		<input type="submit" class="btn btn-lg btn-primary" value="UPDATE Assessment & PACEs">
		</div>
		<?php endif; 
		
		?>
		
		</div>
		
		</form>
		
	  </div>
	  
	</div> 
	
	
	
</div>

<script>
	$(function(){
		//document.getElementById("defaultOpen").style.display = "block";
		$("#financial").css("display","block");
		$("#defaultOpen").addClass("active");
		//evt.currentTarget.className += " active";
	});
</script>
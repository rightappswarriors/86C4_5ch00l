<?php
$row = $query->row(); 
?>
<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnsubmit").attr("disabled", !this.checked);
	});
	
	$("#frmpreenroll").submit(function(){
		$("#btnsubmit").attr("disabled",true);
		return true;
	});
	
});
</script>

<div class="col-lg-12 grid-margin">
	<div class="card">
		<div class="card-body">
		<h3 class="heading" style="text-align:center;">Application for Pre-enrollment</h3><hr>
			<p>This application is for students presently enrolled who desire to return for the <b><u>2021-2022</u></b> academic year.  The registration fee of <b><u>Php 2,500.00</u></b> must accompany application and is not refundable.</p>
			<p>Thank you for reaffirming your confidence in the school staff to assist you in providing a quality Biblical education for your child(ren).  Our commitment is to work with the home but not to assume responsibilities which rightfully belong to parents.  Because of our ministry to homes, all children from the same family are expected to attend the school.</p>
		<hr>
		<?=validation_errors()?>
		
		<form class="formenroll" id="frmpreenroll" action="<?=site_url("students/preenrollnew_submit/".$row->id)?>" method="POST">
		  <p class="card-description text-info"> Please fill-out all the fields. </p>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="firstname" value="<?=set_value('firstname',$row->firstname)?>" class="form-control" disabled />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastname" value="<?=set_value('lastname',$row->lastname)?>" class="form-control" disabled />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="middlename" value="<?=set_value('middlename',$row->middlename)?>" class="form-control" disabled />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Date of Birth</label>
				<div class="col-sm-9">
				  <input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="birthdate" value="<?=set_value('birthdate')?>" placeholder="dd/mm/yyyy" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Birth</label>
				<div class="col-sm-9">
				  <input type="text" name="placeofbirth" value="<?=set_value('placeofbirth')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Grade Level to Enter</label>
				<div class="col-sm-9">
				  <?php
					$options = array(
						'RR' => 'RR-K1', 
						'ABCs' => 'ABCs-K2',
						'Level-1' => 'Level-1',
						'Level-2' => 'Level-2',
						'Level-3' => 'Level-3',
						'Level-4' => 'Level-4',
						'Level-5' => 'Level-5',
						'Level-6' => 'Level-6',
						'Level-7' => 'Level-7',
						'Level-8' => 'Level-8',
						'Level-9' => 'Level-9',
						'Level-10' => 'Level-10',
						'Grade-11' => 'Grade-11',
						'Grade-12' => 'Grade-12'
					);
					$batch = set_value('gradelevel');
					echo form_dropdown('gradelevel', $options, $batch,' class="form-control"');
				  ?>
				</div>
			  </div>
			</div>
		  
		  </div>
		  
		  
		  <p class="card-description text-info"> For Senior High Only</p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Strand</label>
				<div class="col-sm-9">
				  <?php
					$options = array('N/A' => 'N/A','ABM' => 'ABM', 'GAS' => 'GAS','HUMMS' => 'HUMMS', 'STEM' => 'STEM');
					$batch = set_value('strand');
					echo form_dropdown('strand', $options, $batch,' class="form-control"');
				  ?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Complete Address </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Street</label>
				<div class="col-sm-9">
				  <input type="text" name="street" value="<?=set_value('street')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">House No.</label>
				<div class="col-sm-9">
				  <input type="text" name="houseno" value="<?=set_value('houseno')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Barangay</label>
				<div class="col-sm-9">
				  <input type="text" name="barangay" value="<?=set_value('barangay')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Province</label>
				<div class="col-sm-9">
				  <input type="text" name="province" value="<?=set_value('province')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">City</label>
				<div class="col-sm-9">
				  <input type="text" name="city" value="<?=set_value('city')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Country</label>
				<div class="col-sm-9">
				  <input type="text" name="country" value="<?=set_value('country','Philippines')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Home Landline</label>
				<div class="col-sm-9">
				  <input type="text" name="homelandline" value="<?=set_value('homelandline')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Parent's Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Father's Name</label>
				<div class="col-sm-9">
				  <input type="text" name="father_firstname" value="<?=set_value('father_firstname')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Work Phone #</label>
				<div class="col-sm-9">
				  <input type="text" name="father_contact1" value="<?=set_value('father_contact1')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Mother's Name</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_firstname" value="<?=set_value('mother_firstname')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Work Phone #</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_contact1" value="<?=set_value('mother_contact1')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		 
		  <p class="card-description text-info"> Emergency Contact: (Other than Parent) </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label"> Name</label>
				<div class="col-sm-9">
				  <input type="text" name="incaseemergency" value="<?=set_value('incaseemergency')?>" class="form-control" />
				</div>
			  </div>
			</div>
			
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Phone #</label>
				<div class="col-sm-9">
				  <input type="text" name="work_phone" value="<?=set_value('work_phone')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  
		  <p class="card-description text-info"> Church Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Name</label>
				<div class="col-sm-9">
				  <input type="text" name="church_name" value="<?=set_value('church_name')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Pastor's Name</label>
				<div class="col-sm-9">
				  <input type="text" name="church_pastor" value="<?=set_value('church_pastor')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Tel. No.</label>
				<div class="col-sm-9">
				  <input type="text" name="church_tel" value="<?=set_value('church_tel')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Names of other Children in the family </p>
		  <div class="row">
			<div class="col-md-5">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">1/ Name</label>
				<div class="col-sm-9">
				  <input type="text" name="child_name1" value="<?=set_value('child_name1')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Gender</label>
				<div class="col-sm-9">
				  <input type="text" name="child_gender1" value="<?=set_value('child_gender1')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Age</label>
				<div class="col-sm-9">
				  <input type="text" name="child_age1" value="<?=set_value('child_age1')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-5">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">2/ Name</label>
				<div class="col-sm-9">
				  <input type="text" name="child_name2" value="<?=set_value('child_name2')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Gender</label>
				<div class="col-sm-9">
				  <input type="text" name="child_gender2" value="<?=set_value('child_gender2')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Age</label>
				<div class="col-sm-9">
				  <input type="text" name="child_age2" value="<?=set_value('child_age2')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-5">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">3/ Name</label>
				<div class="col-sm-9">
				  <input type="text" name="child_name3" value="<?=set_value('child_name3')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Gender</label>
				<div class="col-sm-9">
				  <input type="text" name="child_gender3" value="<?=set_value('child_gender3')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Age</label>
				<div class="col-sm-9">
				  <input type="text" name="child_age3" value="<?=set_value('child_age3')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-5">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">4/ Name</label>
				<div class="col-sm-9">
				  <input type="text" name="child_name4" value="<?=set_value('child_name4')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Gender</label>
				<div class="col-sm-9">
				  <input type="text" name="child_gender4" value="<?=set_value('child_gender4')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Age</label>
				<div class="col-sm-9">
				  <input type="text" name="child_age4" value="<?=set_value('child_age4')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-5">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">5/ Name</label>
				<div class="col-sm-9">
				  <input type="text" name="child_name5" value="<?=set_value('child_name5')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Gender</label>
				<div class="col-sm-9">
				  <input type="text" name="child_gender5" value="<?=set_value('child_gender5')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Age</label>
				<div class="col-sm-9">
				  <input type="text" name="child_age5" value="<?=set_value('child_age5')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <br>
		  
		<div class="col-lg-12 grid-margin">
			<div class="card">
				<div class="card-body">
				
				<p>"I understand that the school program is an integral part of child training of which I am expected to support.</p>
				<p>I hereby commit to assume my Scriptural responsibility for financial support of the school.</p>
				<p>I understand that my child is expected to take part in the school activities, including P.E. and sponsored trips away from the educational facility, and I absolve the school from liability to me or my child because of injury to my child at properly supervised school activities.</p>
				<p>I agree to uphold and support the high academic standards of the school by providing a place at home for my child to study and by enrouraging my child in the completion of any homework or assignments.</p>
				<p>I appreciate the standards of the school and will not tolerate profanity, obscenity in word or action, dishonor to the Godhead or the Word of God, or disrespect to the staff of the school.  I hereby agree to support regulations published in the school handbook in the applicant's behalf and authorize the school to employ discipline as it deems wise and expedient for the training of my child.</p>
				<p>I understand that the school reserves the right, after a parental conference, to dismiss any child who fails to comply with established regulations and discipline or whose parents do not assume their responsibilities to the school.</p>
				<p>I have read the school handbook, agreed the complete Parent Orientation, signed a Coroporal Correction Consent, and understand and agree to the terms stated on this application."</p>
				
				<hr>
				<p><b>Additional Notes:</b></p>
				<p>Pre-enrollment fee of Php2,500.00 and will be directly applied to tuition.  There will also be a 5% discount applied to your Tuition.</p>
				<p>Pre-enrollment is not re-enrollment.</p>
				<p>Pre-enrollment fee is non-refundable.</p>
				<p>It is advisable to purchase the whole year's PACEs at this time, or on by June 11.  The cost for the first shipping is Php250.00 but subsequent shipping costs will be Php1,150.00 each. (Contact our School Principal Ma'am P. Rustilla)</p>
				
				</div>
			</div>
		</div>
		  
		  
		  <div class="row" style="margin-top:20px;">
		  <div class="col-md-12">
		  <div class="form-group">
		  <h4><code>NOTE: PLEASE make sure all the information you entered above is true and correct.</code></h4>
		  
			<div class="form-check form-check-flat">
			  <label class="form-check-label">
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> I already checked and confirmed the above information is true and correct. </label>
			</div>
		  </div>
		  </div>
		  </div>
		  
		  
		  
		  <input type="submit" class="btn btn-lg btn-success mr-2" id="btnsubmit" name="submit" value="SUBMIT PRE-ENROLLMENT APPLICATION" disabled/>
		  

		</form>
	  </div>
	</div>          

</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">

<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnsubmit").attr("disabled", !this.checked);
	});
	
	$("#frmenroll").submit(function(){
		$("#btnsubmit").attr("disabled",true);
		return true;
	});
	
	// Transferee radio toggle
	$("input[name='newold']").change(function() {
		if(this.value === "transferee") {
			$("#transferee_section").show();
			$("#transferee_fields").show();
		} else {
			$("#transferee_section").hide();
			$("#transferee_fields").hide();
		}
	});
	
	// Initialize transferee section visibility based on radio selection
	var selectedValue = $("input[name='newold']:checked").val();
	if(selectedValue === "transferee") {
		$("#transferee_section").show();
		$("#transferee_fields").show();
	} else {
		$("#transferee_section").hide();
		$("#transferee_fields").hide();
	}
	
});
</script>

<div class="col-lg-12 grid-margin" style="display:none;">
	<div class="card">
		<div class="card-body">
			<p>This form means, you are about to enroll a <code>new, fresh or transferee</code> student into our School System.  Make sure you have all the information requires of this student.
			If you are enrolling an old or returnee student, please click <a href="<?=site_url("students/enrollold_form")?>" class="btn btn-warning">here</a>
			</p>
		</div>
	</div>
</div>

<div class="col-lg-12 grid-margin enroll-main-container">

	<div class="card enroll-card">
	  <div class="card-body p-0">
	 
		<div class="enroll-header">
			<h2><i class="mdi mdi-school"></i> ENROLLMENT FORM</h2>
		</div>
		
		<div style="padding: 1.5rem 2rem;">
		
		<?=validation_errors()?>
		
		<form class="enroll-form" id="frmenroll" action="<?=site_url("students/enrollnew_submit")?>" method="POST">
		  
		  <div class="enroll-instruction">
			<i class="mdi mdi-information-outline"></i> Please fill out all the fields. If not applicable, enter <strong>N/A</strong>.
		  </div>
		  
		  <!-- Student Details Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> STUDENT DETAILS</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">New / Old</label>
					<div class="radio-group">
						<label class="radio-label">
							<input name="newold" value="new" type="radio" <?=set_radio('newold', 'new', TRUE)?>> 
							New Student
						</label>
						<label class="radio-label">
							<input name="newold" value="old" type="radio" <?=set_radio('newold', 'old')?>> 
							Old Student
						</label>
						<label class="radio-label">
							<input name="newold" value="transferee" type="radio" id="is_transferee" <?=set_radio('newold', 'transferee')?>> 
							Transferee
						</label>
					</div>
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" placeholder="Enter First Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Middle Name</label>
					<input type="text" name="middlename" value="<?=set_value('middlename')?>" class="form-control" placeholder="Enter Middle Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" placeholder="Enter Last Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Date of Birth</label>
					<input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="birthdate" value="<?=set_value('birthdate')?>" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Birth</label>
					<input type="text" name="placeofbirth" value="<?=set_value('placeofbirth')?>" class="form-control" placeholder="Enter Place of Birth" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Gender</label>
					<?php
						$options = array('Male' => 'Male', 'Female' => 'Female');
						$batch = set_value('gender');
						echo form_dropdown('gender', $options, $batch,' class="form-control"');
					?>
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Grade Level to Enter</label>
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
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Strand (For Senior High)</label>
					<?php
						$options = array('N/A' => 'N/A','ABM' => 'ABM', 'GAS' => 'GAS','HUMMS' => 'HUMMS', 'STEM' => 'STEM');
						$batch = set_value('strand','N/A');
						echo form_dropdown('strand', $options, $batch,' class="form-control"');
					?>
				</div>
			</div>
		  </div>
		  
		  <!-- For Transferees Section -->
		  <div class="enroll-section" id="transferee_section" style="display:none;">
			<h5 class="enroll-section-title"><i class="mdi mdi-swap-horizontal"></i> FOR TRANSFEREES</h5>
		  </div>
		  
		  <div class="row" id="transferee_fields" style="display:none;">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">School Name</label>
					<input type="text" name="lastschool" value="<?=set_value('lastschool')?>" class="form-control" placeholder="Enter School Name" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label">School Year</label>
					<input type="text" name="lastschoolyear" value="<?=set_value('lastschoolyear')?>" class="form-control" placeholder="Enter Year" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label">Grade Level</label>
					<input type="text" name="lastschoolgrade" value="<?=set_value('lastschoolgrade')?>" class="form-control" placeholder="Enter Grade" />
				</div>
			</div>
		  </div>
		  
		  <!-- Complete Home Address Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-home-map-marker"></i> COMPLETE HOME ADDRESS</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">House No.</label>
					<input type="text" name="houseno" value="<?=set_value('houseno')?>" class="form-control" placeholder="Enter House No." />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Street</label>
					<input type="text" name="street" value="<?=set_value('street')?>" class="form-control" placeholder="Enter Street" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Barangay</label>
					<input type="text" name="barangay" value="<?=set_value('barangay')?>" class="form-control" placeholder="Enter Barangay" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">City</label>
					<input type="text" name="city" value="<?=set_value('city')?>" class="form-control" placeholder="Enter City" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Province</label>
					<input type="text" name="province" value="<?=set_value('province')?>" class="form-control" placeholder="Enter Province" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Country</label>
					<input type="text" name="country" value="<?=set_value('country','Philippines')?>" class="form-control" placeholder="Enter Country" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Home Landline</label>
					<input type="text" name="homelandline" value="<?=set_value('homelandline')?>" class="form-control" placeholder="Enter Landline" />
				</div>
			</div>
		  </div>
		  
		  <!-- Father's & Mother's Information Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> FATHER'S INFORMATION/MOTHER'S INFORMATION</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="form-label">Father Information</label>
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="father_firstname" value="<?=set_value('father_firstname')?>" class="form-control" placeholder="Enter First Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Middle Name</label>
					<input type="text" name="father_middlename" value="<?=set_value('father_middlename')?>" class="form-control" placeholder="Enter Middle Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="father_lastname" value="<?=set_value('father_lastname')?>" class="form-control" placeholder="Enter Last Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Occupation</label>
					<input type="text" name="father_work" value="<?=set_value('father_work')?>" class="form-control" placeholder="Enter Occupation" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Employment</label>
					<input type="text" name="father_place_work" value="<?=set_value('father_place_work')?>" class="form-control" placeholder="Enter Place of Work" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Contact Number</label>
					<input type="text" name="father_contact2" value="<?=set_value('father_contact2')?>" class="form-control" placeholder="Enter Contact Number" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Email</label>
					<input type="text" name="father_email" value="<?=set_value('father_email')?>" class="form-control" placeholder="Enter Email Address" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">FB Messenger</label>
					<input type="text" name="father_fbmessenger" value="<?=set_value('father_fbmessenger')?>" class="form-control" placeholder="Enter FB Messenger Name" />
				</div>
			</div>
		  </div>
		  
		  <!-- Mother's Information Fields (moved into combined section above) -->
		  
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="form-label">Mother Information</label>
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="mother_firstname" value="<?=set_value('mother_firstname')?>" class="form-control" placeholder="Enter First Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Middle Name</label>
					<input type="text" name="mother_middlename" value="<?=set_value('mother_middlename')?>" class="form-control" placeholder="Enter Middle Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="mother_lastname" value="<?=set_value('mother_lastname')?>" class="form-control" placeholder="Enter Last Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Maiden Name</label>
					<input type="text" name="maidenname" value="<?=set_value('maidenname')?>" class="form-control" placeholder="Enter Maiden Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Occupation</label>
					<input type="text" name="mother_work" value="<?=set_value('mother_work')?>" class="form-control" placeholder="Enter Occupation" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Contact Number</label>
					<input type="text" name="mother_contact2" value="<?=set_value('mother_contact2')?>" class="form-control" placeholder="Enter Contact Number" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Employment</label>
					<input type="text" name="mother_place_work" value="<?=set_value('mother_place_work')?>" class="form-control" placeholder="Enter Place of Work" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Email</label>
					<input type="text" name="email" value="<?=set_value('email')?>" class="form-control" placeholder="Enter Email Address" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">FB Messenger</label>
					<input type="text" name="mother_fbmessenger" value="<?=set_value('mother_fbmessenger')?>" class="form-control" placeholder="Enter FB Messenger Name" />
				</div>
			</div>
		  </div>
		  
		  <!-- Emergency Contact Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-phone-in-talk"></i> EMERGENCY CONTACT (Other than Parent)</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Name</label>
					<input type="text" name="incaseemergency" value="<?=set_value('incaseemergency')?>" class="form-control" placeholder="Enter Contact Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Relationship</label>
					<?php
						$options1 = array(
							'Lolo' => 'Lolo', 'Lola' => 'Lola','Aunt' => 'Aunt', 'Uncle' => 'Uncle',
							'Kuya' => 'Kuya', 'Ate' => 'Ate','Yaya' => 'Yaya', 'Guardian' => 'Guardian'
						);
						$batch1 = set_value('relationship');
						echo form_dropdown('relationship', $options1, $batch1,' class="form-control"');
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Contact Number</label>
					<input type="text" name="personal_cell" value="<?=set_value('personal_cell')?>" class="form-control" placeholder="Enter Contact Number" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Employment</label>
					<input type="text" name="place_employment" value="<?=set_value('place_employment')?>" class="form-control" placeholder="Enter Place of Employment" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Parent's Work Phone</label>
					<input type="text" name="work_phone" value="<?=set_value('work_phone')?>" class="form-control" placeholder="Enter Parent's Work Phone" />
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Home Landline</label>
					<input type="text" name="other_homelandline" value="<?=set_value('other_homelandline')?>" class="form-control" placeholder="Enter Home Landline" />
				</div>
			</div>
		  </div>
		  
		  <!-- Church Information Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-church"></i> CHURCH INFORMATION</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Church Name</label>
					<input type="text" name="church_name" value="<?=set_value('church_name')?>" class="form-control" placeholder="Enter Church Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Address</label>
					<input type="text" name="church_address" value="<?=set_value('church_address')?>" class="form-control" placeholder="Enter Church Address" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Pastor's Name</label>
					<input type="text" name="church_pastor" value="<?=set_value('church_pastor')?>" class="form-control" placeholder="Enter Pastor's Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Telephone No.</label>
					<input type="text" name="church_tel" value="<?=set_value('church_tel')?>" class="form-control" placeholder="Enter Telephone No." />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Website</label>
					<input type="text" name="church_website" value="<?=set_value('church_website')?>" class="form-control" placeholder="Enter Website" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Date of Salvation</label>
					<input type="text" name="date_salvation" value="<?=set_value('date_salvation')?>" class="form-control" placeholder="Enter Date of Salvation" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Date of Baptism</label>
					<input type="text" name="date_baptism" value="<?=set_value('date_baptism')?>" class="form-control" placeholder="Enter Date of Baptism" />
				</div>
			</div>
		  </div>
		  
		  <!-- Note Box -->
		  <div class="enroll-note-box">
			<h4><i class="mdi mdi-alert-circle-outline"></i> NOTE: Please make sure all the information you entered above is true and correct.</h4>
			<div class="form-check">
			  <label class="form-check-label">
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> I have reviewed and confirmed that the above information is true and correct.
			  </label>
			</div>
		  </div>
		  
		  <div class="enroll-reminder">
			<i class="mdi mdi-clock-outline"></i> Please check your student assessment section page after 24 hours. You cannot finalize this enrollment process unless you agree with the assessment.
		  </div>
		  
		  <div class="enroll-submit-area">
			<input type="submit" class="btn btn-enroll btn-submit" id="btnsubmit" name="submit" value="ENROLL" disabled/>
		  </div>
		  

		</form>
		
		</div>
	  </div>
	</div>          

</div>

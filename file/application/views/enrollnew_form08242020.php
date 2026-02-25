
<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnsubmit").attr("disabled", !this.checked);
	});
	
	$("#frmenroll").submit(function(){
		$("#btnsubmit").attr("disabled",true);
		return true;
	});
	
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

<div class="col-lg-12 grid-margin">

	<div class="card">
	  <div class="card-body">
	 
		<h3 class="heading" style="text-align:center;">Student Enrollment Form</h3>
		
		<?=validation_errors()?>
		
		<form class="formenroll" id="frmenroll" action="<?=site_url("students/enrollnew_submit")?>" method="POST">
		  <p class="card-description text-info"> Please fill-out all the fields. </p>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">New / Old</label>
				<div class="col-sm-9">
				  
				  <div class="form-check form-check-flat">
					<label class="form-check-label"><input name="newold" value="new" type="radio" class="form-check-input" <?=set_radio('newold', 'new', TRUE)?>> New Student </label>
				  </div>
				  <div class="form-check form-check-flat">
					<label class="form-check-label"><input name="newold" value="old" type="radio" class="form-check-input" <?=set_radio('newold', 'old')?>> Old Student </label>
				  </div>
				  
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="middlename" value="<?=set_value('middlename')?>" class="form-control" />
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
			
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Gender</label>
				<div class="col-sm-9">
				  <!--<select name="gender" class="form-control">
					<option>Male</option>
					<option>Female</option>
				  </select>-->
				  <?php
					$options = array('Male' => 'Male', 'Female' => 'Female');
					$batch = set_value('gender');
					echo form_dropdown('gender', $options, $batch,' class="form-control"');
				  ?>
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
					$options = array('ABM' => 'ABM', 'GAS' => 'GAS','HUMMS' => 'HUMMS', 'STEM' => 'STEM');
					$batch = set_value('strand');
					echo form_dropdown('strand', $options, $batch,' class="form-control"');
				  ?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Last School Attended (For Transferee Only)</p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">School Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastschool" value="<?=set_value('lastschool')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Year</label>
				<div class="col-sm-9">
				  <input type="text" name="lastschoolyear" value="<?=set_value('lastschoolyear')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Grade Level</label>
				<div class="col-sm-9">
				  <input type="text" name="lastschoolgrade" value="<?=set_value('lastschoolgrade')?>" class="form-control" />
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
		  
		  <p class="card-description text-info"> Father's Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="father_firstname" value="<?=set_value('father_firstname')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="father_lastname" value="<?=set_value('father_lastname')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="father_middlename" value="<?=set_value('father_middlename')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Occupation</label>
				<div class="col-sm-9">
				  <input type="text" name="father_work" value="<?=set_value('father_work')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Employment</label>
				<div class="col-sm-9">
				  <input type="text" name="father_place_work" value="<?=set_value('father_place_work')?>" class="form-control" />
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
				<label class="col-sm-3 col-form-label">Personal Cell #</label>
				<div class="col-sm-9">
				  <input type="text" name="father_contact2" value="<?=set_value('father_contact2')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  
		  <p class="card-description text-info"> Mother's Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_firstname" value="<?=set_value('mother_firstname')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_lastname" value="<?=set_value('mother_lastname')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_middlename" value="<?=set_value('mother_middlename')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Occupation</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_work" value="<?=set_value('mother_work')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Maiden Name</label>
				<div class="col-sm-9">
				  <input type="text" name="maidenname" value="<?=set_value('maidenname')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Employment</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_place_work" value="<?=set_value('mother_place_work')?>" class="form-control" />
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
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Personal Cell #</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_contact2" value="<?=set_value('mother_contact2')?>" class="form-control" />
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
				<label class="col-sm-3 col-form-label">Relationship to Child</label>
				<div class="col-sm-9">
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
			  </div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Employment</label>
				<div class="col-sm-9">
				  <input type="text" name="place_employment" value="<?=set_value('place_employment')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Work Phone No.</label>
				<div class="col-sm-9">
				  <input type="text" name="work_phone" value="<?=set_value('work_phone')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label"> Personal Cell No.</label>
				<div class="col-sm-9">
				  <input type="text" name="personal_cell" value="<?=set_value('personal_cell')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Home Landline</label>
				<div class="col-sm-9">
				  <input type="text" name="other_homelandline" value="<?=set_value('other_homelandline')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Other Info </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">E-mail</label>
				<div class="col-sm-9">
				  <input type="text" name="email" value="<?=set_value('email')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">FB Private Messenger Name</label>
				<div class="col-sm-9">
				  <input type="text" name="fbmessenger" value="<?=set_value('fbmessenger')?>" class="form-control" />
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
				<label class="col-sm-3 col-form-label">Address</label>
				<div class="col-sm-9">
				  <input type="text" name="church_address" value="<?=set_value('church_address')?>" class="form-control" />
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
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Website</label>
				<div class="col-sm-9">
				  <input type="text" name="church_website" value="<?=set_value('church_website')?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
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
				<label class="col-sm-3 col-form-label">Date of Salvation</label>
				<div class="col-sm-9">
				  <input type="text" name="date_salvation" value="<?=set_value('date_salvation')?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Date of Baptism</label>
				<div class="col-sm-9">
				  <input type="text" name="date_baptism" value="<?=set_value('date_baptism')?>" class="form-control" />
				</div>
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
		  
		  
		  
		  <input type="submit" class="btn btn-lg btn-success mr-2" id="btnsubmit" name="submit" value="ENROLL NOW" disabled/>
		  

		</form>
	  </div>
	</div>          

</div>
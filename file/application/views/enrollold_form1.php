<?php $row = $query->row(); ?>
<div class="col-lg-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<p>This form means you are enrolling an <code>old, returnee or exisiting student</code> from our database.  Make sure he/she cleared from previous School Years' requirements.
			If you are enrolling new or fresh student, please click <a href="<?=site_url("students/enrollnew_form")?>" class="btn btn-info">here</a>
			</p>
		</div>
	</div>
</div>

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
	 
		<h3 class="heading" style="text-align:center;">Information for Returnee Student</h3>
		
		<?=validation_errors()?>
		
		<form class="form-sample" action="<?=site_url("students/enrollold_submit/".$row->id)?>" method="POST">
		  <p class="card-description text-info"> Personal info (Fields with * are required.) </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="firstname" value="<?=set_value('firstname',$row->firstname)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastname" value="<?=set_value('lastname',$row->lastname)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="middlename" value="<?=set_value('middlename',$row->middlename)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Date of Birth</label>
				<div class="col-sm-9">
				  <input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="birthdate" value="<?=set_value('birthdate',$row->birthdate)?>" placeholder="dd/mm/yyyy" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Birth</label>
				<div class="col-sm-9">
				  <input type="text" name="placeofbirth" value="<?=set_value('placeofbirth',$row->placeofbirth?>" class="form-control" />
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
					$batch = set_value('gender',$row->gender);
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
					$batch = set_value('gradelevel',$row->gradelevel);
					echo form_dropdown('gradelevel', $options, $batch,' class="form-control"');
				  ?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Last School Attended </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">School Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastschool" value="<?=set_value('lastschool',$row->lastschool)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Year</label>
				<div class="col-sm-9">
				  <input type="text" name="lastschoolyear" value="<?=set_value('lastschoolyear',$row->lastschoolyear)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Grade Level</label>
				<div class="col-sm-9">
				  <input type="text" name="lastschoolgrade" value="<?=set_value('lastschoolgrade',$row->lastschoolgrade)?>" class="form-control" />
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <p class="card-description text-info"> Complete Address </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Street</label>
				<div class="col-sm-9">
				  <input type="text" name="street" value="<?=set_value('street',$row->street)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">House No.</label>
				<div class="col-sm-9">
				  <input type="text" name="houseno" value="<?=set_value('houseno',$row->houseno)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Barangay</label>
				<div class="col-sm-9">
				  <input type="text" name="barangay" value="<?=set_value('barangay',$row->barangay)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Province</label>
				<div class="col-sm-9">
				  <input type="text" name="province" value="<?=set_value('province',$row->province)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">City</label>
				<div class="col-sm-9">
				  <input type="text" name="city" value="<?=set_value('city',$row->city)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Country</label>
				<div class="col-sm-9">
				  <input type="text" name="country" value="<?=set_value('country',$row->country)?>" class="form-control" />
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
				  <input type="text" name="father_firstname" value="<?=set_value('father_firstname',$row->father_firstname)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="father_lastname" value="<?=set_value('father_lastname',$row->father_lastname)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="father_middlename" value="<?=set_value('father_middlename',$row->father_middlename)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Occupation</label>
				<div class="col-sm-9">
				  <input type="text" name="father_work" value="<?=set_value('father_work',$row->father_work)?>" class="form-control" />
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
				  <input type="text" name="mother_firstname" value="<?=set_value('mother_firstname',$row->mother_firstnamefirstname)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_lastname" value="<?=set_value('mother_lastname',$row->mother_lastname)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_middlename" value="<?=set_value('mother_middlename',$row->mother_middlename)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Occupation</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_work" value="<?=set_value('mother_work',$row->mother_work)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Maiden Name</label>
				<div class="col-sm-9">
				  <input type="text" name="maidenname" value="<?=set_value('maidenname',$row->maidenname)?>" class="form-control" />
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <p class="card-description text-info"> Guardian's Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="guardian_firstname" value="<?=set_value('guardian_firstname',$row->guardian_firstname?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="guardian_lastname" value="<?=set_value('guardian_lastname',$row->guardian_lastname)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="guardian_middlename" value="<?=set_value('guardian_middlename',$row->guardian_middlename)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Occupation</label>
				<div class="col-sm-9">
				  <input type="text" name="guardian_work" value="<?=set_value('guardian_work',$row->guardian_work)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <p class="card-description text-info"> Incase of Emergency notify: </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Name</label>
				<div class="col-sm-9">
				  <input type="text" name="incaseemergency" value="<?=set_value('incaseemergency',$row->incaseemergency)?>" class="form-control" />
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <p class="card-description text-info"> Contact Numbers </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Tel/Cell No.1</label>
				<div class="col-sm-9">
				  <input type="text" name="contact1" value="<?=set_value('contact1',$row->contact1)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*Tel/Cell No.2</label>
				<div class="col-sm-9">
				  <input type="text" name="contact2" value="<?=set_value('contact2',$row->contact2)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Tel/Cell No.3</label>
				<div class="col-sm-9">
				  <input type="text" name="contact3" value="<?=set_value('contact3',$row->contact3)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">E-mail</label>
				<div class="col-sm-9">
				  <input type="text" name="email" value="<?=set_value('email',$row->email)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div style="text-align:center;margin:0 auto;">
		  <input type="submit" class="btn btn-lg btn-info" name="submit" value="ENROLL Now">
		  </div>

		</form>
	  </div>
	</div> 
	
</div>

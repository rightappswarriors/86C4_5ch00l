<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
?>

<?php $this->load->view("students/menu",$data) ?>

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
	 
		<h3 class="heading" style="text-align:center;">Update Student Information</h3>
		
		<?=validation_errors()?>
		
		<form class="form-sample" action="<?=site_url("students/updateinfo_submit/".$row->id)?>" method="POST">
		  <p class="card-description text-info"> Fields with * are required. </p>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">*New / Old</label>
				<div class="col-sm-9">
				  
				  <div class="form-check form-check-flat">
					<label class="form-check-label"><input name="newold" value="new" type="radio" class="form-check-input" <?=set_radio('newold', 'new', $row->newold=="new"? TRUE:'')?>> New Student </label>
				  </div>
				  <div class="form-check form-check-flat">
					<label class="form-check-label"><input name="newold" value="old" type="radio" class="form-check-input" <?=set_radio('newold', 'old', $row->newold=="old"? TRUE:'')?>> Old Student </label>
				  </div>
				  
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">ID Number</label>
				<div class="col-sm-9">
				  <input type="text" name="studentno" value="<?=set_value('studentno',$row->studentno)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">LRN</label>
				<div class="col-sm-9">
				  <input type="text" name="lrn" value="<?=set_value('lrn',$row->lrn)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
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
				  <input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="birthdate" value="<?=set_value('birthdate',date("Y-m-d",strtotime($row->birthdate)))?>" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Birth</label>
				<div class="col-sm-9">
				  <input type="text" name="placeofbirth" value="<?=set_value('placeofbirth',$row->placeofbirth)?>" class="form-control" />
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
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Home Landline</label>
				<div class="col-sm-9">
				  <input type="text" name="homelandline" value="<?=set_value('homelandline',$row->homelandline)?>" class="form-control" />
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
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Employment</label>
				<div class="col-sm-9">
				  <input type="text" name="father_place_work" value="<?=set_value('father_place_work',$row->father_place_work)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Work Phone #</label>
				<div class="col-sm-9">
				  <input type="text" name="father_contact1" value="<?=set_value('father_contact1',$row->father_contact1)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Personal Cell #</label>
				<div class="col-sm-9">
				  <input type="text" name="father_contact2" value="<?=set_value('father_contact2',$row->father_contact2)?>" class="form-control" />
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
				  <input type="text" name="mother_firstname" value="<?=set_value('mother_firstname',$row->mother_firstname)?>" class="form-control" />
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
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Place of Employment</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_place_work" value="<?=set_value('mother_place_work',$row->mother_place_work)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Work Phone #</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_contact1" value="<?=set_value('mother_contact1',$row->mother_contact1)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Personal Cell #</label>
				<div class="col-sm-9">
				  <input type="text" name="mother_contact2" value="<?=set_value('mother_contact2',$row->mother_contact2)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		 
		  <p class="card-description text-info"> Emergency Contact: (Other than Parent) </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">* Name</label>
				<div class="col-sm-9">
				  <input type="text" name="incaseemergency" value="<?=set_value('incaseemergency',$row->incaseemergency)?>" class="form-control" />
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
					$batch1 = set_value('relationship',$row->relationship);
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
				  <input type="text" name="place_employment" value="<?=set_value('place_employment',$row->place_employment)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Work Phone No.</label>
				<div class="col-sm-9">
				  <input type="text" name="work_phone" value="<?=set_value('work_phone',$row->work_phone)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">* Personal Cell No.</label>
				<div class="col-sm-9">
				  <input type="text" name="personal_cell" value="<?=set_value('personal_cell',$row->personal_cell)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Home Landline</label>
				<div class="col-sm-9">
				  <input type="text" name="other_homelandline" value="<?=set_value('other_homelandline',$row->other_homelandline)?>" class="form-control" />
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
				  <input type="text" name="email" value="<?=set_value('email',$row->email)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">FB Private Messenger Name</label>
				<div class="col-sm-9">
				  <input type="text" name="fbmessenger" value="<?=set_value('fbmessenger',$row->fbmessenger)?>" class="form-control" />
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
				  <input type="text" name="church_name" value="<?=set_value('church_name',$row->church_name)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Address</label>
				<div class="col-sm-9">
				  <input type="text" name="church_address" value="<?=set_value('church_address',$row->church_address)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Tel. No.</label>
				<div class="col-sm-9">
				  <input type="text" name="church_tel" value="<?=set_value('church_tel',$row->church_tel)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Website</label>
				<div class="col-sm-9">
				  <input type="text" name="church_website" value="<?=set_value('church_website',$row->church_website)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Pastor's Name</label>
				<div class="col-sm-9">
				  <input type="text" name="church_pastor" value="<?=set_value('church_pastor',$row->church_pastor)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Date of Salvation</label>
				<div class="col-sm-9">
				  <input type="text" name="date_salvation" value="<?=set_value('date_salvation',$row->date_salvation)?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Date of Baptism</label>
				<div class="col-sm-9">
				  <input type="text" name="date_baptism" value="<?=set_value('date_baptism',$row->date_baptism)?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div style="text-align:center;margin:0 auto;">
		  <input type="submit" class="btn btn-lg btn-success" name="submit" value="UPDATE">
		  </div>

		</form>
	  </div>
	</div> 
	
</div>
<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
?>

<?php $this->load->view("students/menu",$data) ?>

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
	 
		<h3 class="heading" style="text-align:center;">Student Information</h3>
		<hr>
		<?=validation_errors()?>
		
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
		<a href="#" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-printer'></i></a>
		</div>
		</div>
		
		<p class="card-description text-info"> Basic Information </p>	
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">ID Number</label>
				<div class="col-sm-8">
				  <?=$row->studentno?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">LRN</label>
				<div class="col-sm-8">
				  <?=$row->lrn?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">First Name</label>
				<div class="col-sm-8">
				  <?=$row->firstname?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Last Name</label>
				<div class="col-sm-8">
				  <?=$row->lastname?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Middle Name</label>
				<div class="col-sm-8">
				  <?=$row->middlename?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Date of Birth</label>
				<div class="col-sm-8">
				  <?=date("Y-m-d",strtotime($row->birthdate))?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Place of Birth</label>
				<div class="col-sm-8">
				  <?=$row->placeofbirth?>
				</div>
			  </div>
			</div>
			
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Gender</label>
				<div class="col-sm-8">
				  <?=$row->gender?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Grade Level to Enter</label>
				<div class="col-sm-8">
				  <?=$row->gradelevel?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Last School Attended </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">School Name</label>
				<div class="col-sm-8">
				  <?=$row->lastschool?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Year</label>
				<div class="col-sm-8">
				  <?=$row->lastschoolyear?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Grade Level</label>
				<div class="col-sm-8">
				  <?=$row->lastschoolgrade?>
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <p class="card-description text-info"> Complete Address </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Street</label>
				<div class="col-sm-8">
				  <?=$row->street?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">House No.</label>
				<div class="col-sm-8">
				  <?=$row->houseno?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Barangay</label>
				<div class="col-sm-8">
				  <?=$row->barangay?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Province</label>
				<div class="col-sm-8">
				  <?=$row->province?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">City</label>
				<div class="col-sm-8">
				  <?=$row->city?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Country</label>
				<div class="col-sm-8">
				  <?=$row->country?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Home Landline</label>
				<div class="col-sm-8">
				  <?=$row->homelandline?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Father's Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">First Name</label>
				<div class="col-sm-8">
				  <?=$row->father_firstname?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Last Name</label>
				<div class="col-sm-8">
				  <?=$row->father_lastname?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Middle Name</label>
				<div class="col-sm-8">
				  <?=$row->father_middlename?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Occupation</label>
				<div class="col-sm-8">
				  <?=$row->father_work?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Place of Employment</label>
				<div class="col-sm-8">
				  <?=$row->father_place_work?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Work Phone #</label>
				<div class="col-sm-8">
				  <?=$row->father_contact1?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Personal Cell #</label>
				<div class="col-sm-8">
				  <?=$row->father_contact2?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  
		  <p class="card-description text-info"> Mother's Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">First Name</label>
				<div class="col-sm-8">
				  <?=$row->mother_firstname?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Last Name</label>
				<div class="col-sm-8">
				  <?=$row->mother_lastname?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Middle Name</label>
				<div class="col-sm-8">
				  <?=$row->mother_middlename?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Occupation</label>
				<div class="col-sm-8">
				  <?=$row->mother_work?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Maiden Name</label>
				<div class="col-sm-8">
				  <?=$row->maidenname?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Place of Employment</label>
				<div class="col-sm-8">
				  <?=$row->mother_place_work?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Work Phone #</label>
				<div class="col-sm-8">
				  <?=$row->mother_contact1?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Personal Cell #</label>
				<div class="col-sm-8">
				  <?=$row->mother_contact2?>
				</div>
			  </div>
			</div>
		  </div>
		 
		  <p class="card-description text-info"> Emergency Contact: (Other than Parent) </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label"> Name</label>
				<div class="col-sm-8">
				  <?=$row->incaseemergency?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Relationship to Child</label>
				<div class="col-sm-8">
				  <?=$row->relationship?>
				</div>
			  </div>
			  </div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Place of Employment</label>
				<div class="col-sm-8">
				  <?=$row->place_employment?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Work Phone No.</label>
				<div class="col-sm-8">
				  <?=$row->work_phone?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label"> Personal Cell No.</label>
				<div class="col-sm-8">
				  <?=$row->personal_cell?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Home Landline</label>
				<div class="col-sm-8">
				  <?=$row->other_homelandline?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Other Info </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">E-mail</label>
				<div class="col-sm-8">
				  <?=$row->email?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">FB Private Messenger Name</label>
				<div class="col-sm-8">
				  <?=$row->fbmessenger?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <p class="card-description text-info"> Church Information </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Name</label>
				<div class="col-sm-8">
				  <?=$row->church_name?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Address</label>
				<div class="col-sm-8">
				  <?=$row->church_address?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Tel. No.</label>
				<div class="col-sm-8">
				  <?=$row->church_tel?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Website</label>
				<div class="col-sm-8">
				  <?=$row->church_website?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Pastor's Name</label>
				<div class="col-sm-8">
				  <?=$row->church_pastor?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Date of Salvation</label>
				<div class="col-sm-8">
				  <?=$row->date_salvation?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Date of Baptism</label>
				<div class="col-sm-8">
				  <?=$row->date_baptism?>
				</div>
			  </div>
			</div>
		  </div>
		  
	  </div>
	</div> 
	
</div>
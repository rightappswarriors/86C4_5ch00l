<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_details_print.css">

<div class="row m-3">
	<div class="col-xs-12 col-sm-5 text-right p-0 pr-2"><img src="<?=dirname(base_url())?>/assets/images/logo_portal.png" width="100"></div>
	<div class="col-xs-12 col-sm-7 p-0"><p class="p-0"><b>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</b><br>
	a Ministry of Cebu Bible Baptist Church, Inc.<br>
55 Katipunan St., Brgy. Calamba, Cebu City 6000<br>Tel No. 032-422-0700 / 0945 856 8571</p></div>
</div>

<div class="col-lg-12" style="margin-top:5px;">

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
	 
		<h3 class="heading text-center">ENROLLMENT FORM</h3>
		<?=validation_errors()?>
		
		<p class="card-description text-info"> Student Information </p>	
		  
		   <div class="row">
			<div class="col-xs-12 col-sm-3">ID Number</div>
			<div class="col-xs-12 col-sm-3"><?=$row->studentno?></div>
			<div class="col-xs-12 col-sm-3">LRN</div>
			<div class="col-xs-12 col-sm-3"><?=$row->lrn?></div>
		  </div>
		  
		  <div class="row">
			<div class="col-xs-12 col-sm-3">First Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->firstname?></div>
			<div class="col-xs-12 col-sm-3">Last Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->lastname?></div>
		  </div>
		
			<div class="row">
			<div class="col-xs-12 col-sm-3">Middle Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->middlename?></div>
			<div class="col-xs-12 col-sm-3">Date of Birth</div>
			<div class="col-xs-12 col-sm-3"><?=date("Y-m-d",strtotime($row->birthdate))?></div>
		  </div>
		
		<div class="row">
			<div class="col-xs-12 col-sm-3">Place of Birth</div>
			<div class="col-xs-12 col-sm-3"><?=$row->placeofbirth?></div>
		  </div>
		  
		  <div class="row">
			<div class="col-xs-12 col-sm-3">Gender</div>
			<div class="col-xs-12 col-sm-3"><?=$row->gender?></div>
			<div class="col-xs-12 col-sm-3">Grade Level to Enter</div>
			<div class="col-xs-12 col-sm-3"><?=$row->gradelevel?></div>
		  </div>
		
		  <p class="card-description text-info"> For Senior High </p>
		  <div class="row">
			<div class="col-xs-12 col-sm-3">Strand</div>
			<div class="col-xs-12 col-sm-3"><?=$row->strand?></div>
		  </div>
		  
		  <p class="card-description text-info"> For Transferees </p>
		   <div class="row">
			<div class="col-xs-12 col-sm-3">School Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->lastschool?></div>
			<div class="col-xs-12 col-sm-3">Year</div>
			<div class="col-xs-12 col-sm-3"><?=$row->lastschoolyear?></div>
		  </div>
		   <div class="row">
			<div class="col-xs-12 col-sm-3">Grade Level</div>
			<div class="col-xs-12 col-sm-3"><?=$row->lastschoolgrade?></div>
			</div>
		  
		  <p class="card-description text-info"> Complete Address </p>
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Street</div>
			<div class="col-xs-12 col-sm-3"><?=$row->street?></div>
			<div class="col-xs-12 col-sm-3">House No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->houseno?></div>
		</div>	
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Barangay</div>
			<div class="col-xs-12 col-sm-3"><?=$row->barangay?></div>
			<div class="col-xs-12 col-sm-3">Province</div>
			<div class="col-xs-12 col-sm-3"><?=$row->province?></div>
		</div>
		  
		   <div class="row">
		  <div class="col-xs-12 col-sm-3">City</div>
			<div class="col-xs-12 col-sm-3"><?=$row->city?></div>
			<div class="col-xs-12 col-sm-3">Country</div>
			<div class="col-xs-12 col-sm-3"><?=$row->country?></div>
		</div>
		  
		   <div class="row">
		  <div class="col-xs-12 col-sm-3">Home Landline</div>
			<div class="col-xs-12 col-sm-3"><?=$row->homelandline?></div>
			
		</div>
		  
		  <p class="card-description text-info"> Father's Information </p>
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">First Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_firstname?></div>
			<div class="col-xs-12 col-sm-3">Last Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_lastname?></div>
		</div>
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Middle Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_middlename?></div>
			<div class="col-xs-12 col-sm-3">Occupation</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_work?></div>
		</div>
		
		<div class="row">
		  <div class="col-xs-12 col-sm-3">Place of Employment</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_place_work?></div>
			<div class="col-xs-12 col-sm-3">Work Phone No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_contact1?></div>
		</div>
		
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Personal Cell No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->father_contact2?></div>
			
		</div>
		  
		  <p class="card-description text-info"> Mother's Information </p>
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">First Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_firstname?></div>
			<div class="col-xs-12 col-sm-3">Last Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_lastname?></div>
		</div>
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Middle Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_middlename?></div>
			<div class="col-xs-12 col-sm-3">Occupation</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_work?></div>
		</div>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Maiden Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->maidenname?></div>
		</div>
		  
		  <p class="card-description text-info"> Other Info </p>
		  
		   <div class="row">
		  <div class="col-xs-12 col-sm-3">E-mail</div>
			<div class="col-xs-12 col-sm-3"><?=$row->email?></div>
			<div class="col-xs-12 col-sm-3">FB Private Messenger Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->fbmessenger?></div>
		</div>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Place of Employment</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_place_work?></div>
			<div class="col-xs-12 col-sm-3">Work Phone No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_contact1?></div>
		</div>
		  
		 <div class="row">
		  <div class="col-xs-12 col-sm-3">Personal Cell No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->mother_contact2?></div>
		</div>
		 
		  <p class="card-description text-info"> Emergency Contact: (Other than Parent) </p>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->incaseemergency?></div>
			<div class="col-xs-12 col-sm-3">Relathionship to Child</div>
			<div class="col-xs-12 col-sm-3"><?=$row->relationship?></div>
		</div>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Place of Employment</div>
			<div class="col-xs-12 col-sm-3"><?=$row->place_employment?></div>
			<div class="col-xs-12 col-sm-3">Work Phone No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->work_phone?></div>
		</div>
		  
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Personal Cell No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->personal_cell?></div>
			<div class="col-xs-12 col-sm-3">Home Landline No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->other_homelandline?></div>
		</div>
		  
		  <p class="card-description text-info"> Church Information </p>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->church_name?></div>
			<div class="col-xs-12 col-sm-3">Address</div>
			<div class="col-xs-12 col-sm-3"><?=$row->church_address?></div>
		</div>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Telephone No.</div>
			<div class="col-xs-12 col-sm-3"><?=$row->church_tel?></div>
			<div class="col-xs-12 col-sm-3">Website</div>
			<div class="col-xs-12 col-sm-3"><?=$row->church_website?></div>
		</div>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Pastor's Name</div>
			<div class="col-xs-12 col-sm-3"><?=$row->church_pastor?></div>
		</div>
		  
		  <div class="row">
		  <div class="col-xs-12 col-sm-3">Date of Salvation</div>
			<div class="col-xs-12 col-sm-3"><?=$row->date_salvation?></div>
			<div class="col-xs-12 col-sm-3">Date of Baptism</div>
			<div class="col-xs-12 col-sm-3"><?=$row->date_baptism?></div>
		</div>
		  
	  </div>
	</div> 
	
</div>
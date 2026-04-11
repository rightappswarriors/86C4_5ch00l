<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
?>

<?php $this->load->view("students/menu",$data) ?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_details.css">

<div class="col-lg-12 grid-margin stretch-card student-details-page">

	<div class="card student-details-card">
	  <div class="card-body">
	 
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="student-details-flash text-primary">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>
	 
		<h3 class="heading student-details-title">Student Information</h3>
		<?=validation_errors()?>
		<div class="row student-details-toolbar">
		<div class="col-md-12 text-right pb-2">
		<?php if($this->session->userdata('current_usertype') == 'Accounting'): ?>
		<a href="<?=site_url("students/details_print/".$this->uri->segment(3))?>" title="Print" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-printer'></i></a>
		<?php endif; ?>
		</div>
		</div>
		<div class="row student-details-actions">
			<?php if($this->session->userdata('current_usertype') == 'Accounting' or $this->session->userdata('current_usertype') == 'Registrar'):?>
			<div class="col-md-6 student-details-actions-left">							
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle student-details-dropdown" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <code class="text-dark">Change Status:</code> <code class="text-danger"><?=$row->enrollstatus?></code> </button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
						<code><a class="dropdown-item" href="<?=site_url("students/changestatus/Active/".$row->id)?>">Active</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Pending/".$row->id)?>">Pending</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Assessed/".$row->id)?>">Assessed</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Payment/".$row->id)?>">For Payment</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Interview/".$row->id)?>">Admin Interview</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Inactive/".$row->id)?>">Inactive</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Suspended/".$row->id)?>">Suspended</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Terminated/".$row->id)?>">Terminated</a>
						<a class="dropdown-item" href="<?=site_url("students/changestatus/Withdrawn/".$row->id)?>">Withdrawn</a></code>
					</div>
				</div>
			</div>
			<div class="col-md-6 student-details-actions-right">
			<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle student-details-dropdown" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <code class="text-dark">Scholar?</code> <code class="text-danger"><?=$row->scholar?></code> </button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
						<code><a class="dropdown-item" href="<?=site_url("payments/scholar/Yes/".$row->id)?>">Yes</a>
						<a class="dropdown-item" href="<?=site_url("payments/scholar/No/".$row->id)?>">No</a></code>
					</div>
				</div>
			</div>	
			
			<br><br>
			<div class="col-md-6 student-details-actions-right">
			<?php else: ?>
			<div class="col-md-12 student-details-actions-right">
			<?php endif; ?>
				<!--<a href="#" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-printer'></i></a>-->
			</div>
		</div>
		
		<p class="card-description text-info headerinfo"> Basic Information </p>	
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
				<label class="col-sm-4 col-form-label">Father First Name</label>
				<div class="col-sm-8">
				  <?=$row->firstname?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Father Last Name</label>
				<div class="col-sm-8">
				  <?=$row->lastname?>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Father Middle Name</label>
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
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Grade Level to Enter</label>
				<div class="col-sm-8">
				  <?=$row->gradelevel?>
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
			
		  </div>
		  
		  <p class="card-description text-info"> For Senior High </p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Strand</label>
				<div class="col-sm-8">
				  <?=$row->strand?>
				</div>
			  </div>
			</div>
		  </div>	
		  
		  <p class="card-description text-info"> For Transferees </p>
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
		  
		  <p class="card-description text-info"> Father's Information/Mother's Information </p>
		  <div class="parent-info-block">
		  <div class="row">
			<div class="col-md-12">
			  <div class="">
				  <p class="card-description text-info"> Father's Information </p>
				<div class=></div>	
			  </div>
			</div>
		  </div>
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
						<!-- ADDED: Father FB Messenger -->
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">FB Messenger</label>
				<div class="col-sm-8">
				  <?php if(!empty($row->father_fbmessenger)): ?>
				    <?php 
				      $fb_link = $row->father_fbmessenger;
				      if (strpos($fb_link, 'http') === false) {
				          $fb_link = "https://www.facebook.com/search/top/?q=" . urlencode($fb_link);
				      }
				    ?>
				    <a href="<?= $fb_link ?>" target="_blank" style="color:#1877F2;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
				      <i class="mdi mdi-facebook"></i> <?=$row->father_fbmessenger?>
				    </a>
				  <?php else: ?>
				    <span class="text-muted">-</span>
				  <?php endif; ?>
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
		  
		  
		  <div class="row">
			<div class="col-md-12">
			  <div class="">
				<p class="card-description text-info"> Mother's Information </p>
				<div class=""></div>
			  </div>
			</div>
		  </div>
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
			<!-- ADDED: Mother FB Messenger -->
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">FB Messenger</label>
				<div class="col-sm-8">
				  <?php if(!empty($row->mother_fbmessenger)): ?>
				    <?php 
				      $fb_link = $row->mother_fbmessenger;
				      if (strpos($fb_link, 'http') === false) {
				          $fb_link = "https://www.facebook.com/search/top/?q=" . urlencode($fb_link);
				      }
				    ?>
				    <a href="<?= $fb_link ?>" target="_blank" style="color:#1877F2;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
				      <i class="mdi mdi-facebook"></i> <?=$row->mother_fbmessenger?>
				    </a>
				  <?php else: ?>
				    <span class="text-muted">-</span>
				  <?php endif; ?>
				</div>
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
				<label class="col-sm-4 col-form-label">Personal Cell #</label>
				<div class="col-sm-8">
				   <?=$row->mother_contact2?>
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
				  <?=$row->work_phone?>
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
				<label class="col-sm-4 col-form-label">Home Landline</label>
				<div class="col-sm-8">
				  <?=$row->other_homelandline?>
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
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-4 col-form-label">Date of Baptism</label>
				<div class="col-sm-8">
				  <?=$row->date_baptism?>
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
			  
		</div>

	  </div>
	</div> 
	
</div>

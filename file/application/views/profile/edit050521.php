<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
?>

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
		
		<h3 class="heading" style="text-align:center;">My Profile</h3>
		<hr>
		
		<?=validation_errors()?>
		
		<form class="form-sample" action="<?=site_url("myprofile/updateinfo_submit/")?>" method="POST">
		  <p class="card-description text-info"> Basic Information </p>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Mobile No. or Login</label>
				<div class="col-sm-9">
				  <input type="text" name="mobileno" value="<?= $row->mobileno ?>" class="form-control" disabled />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">User Type</label>
				<div class="col-sm-9">
				  <input type="text" name="usertype" value="<?= $row->usertype ?>" class="form-control" disabled />
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="firstname" value="<?= set_value('firstname',$row->firstname) ?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Change Password</label>
				<div class="col-sm-9">
				  <input type="password" name="cpassword" value="" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastname" value="<?= set_value('lastname',$row->lastname) ?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Repeat New Password</label>
				<div class="col-sm-9">
				  <input type="password" name="rpassword" value="" class="form-control" />
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
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
		
		<h3 class="heading" style="text-align:center;">Update User Profile</h3>
		<hr>
		
		<?=validation_errors()?>
		
		<form class="form-sample" action="<?=site_url("users/update_submit/".$this->uri->segment(3))?>" method="POST">
		  <p class="card-description text-info"> Basic Information </p>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Mobile No. or Login</label>
				<div class="col-sm-9">
				  <input type="text" name="mobileno" value="<?= set_value("mobileno",$row->mobileno) ?>" class="form-control" />
				</div>
			  </div>
			</div>
			
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">User Type</label>
				<div class="col-sm-9">
				  <?php
					$user_types = array(
						'' => '-- Select User Type --',
						'Admin' => 'Admin',
						'Registrar' => 'Registrar',
						'Teacher' => 'Teacher',
						'Accounting' => 'Accounting'
					);
					$selected = set_value('usertype', $row->usertype);
					echo form_dropdown('usertype', $user_types, $selected, 'class="form-control"');
				  ?>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Grade Level</label>
				<div class="col-sm-9">
				  <?php
					$options = array(
						'N/A' => 'N/A', 
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
				  ?><br><?php
					$batch1 = set_value('gradelevel1',$row->gradelevel1);
					echo form_dropdown('gradelevel1', $options, $batch1,' class="form-control"');
				  ?>
				</div>
			  </div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="firstname" value="<?= set_value("firstname",$row->firstname) ?>" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastname" value="<?= set_value('lastname',$row->lastname) ?>" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Password</label>
				<div class="col-sm-9">
				  <input type="password" name="cpassword" value="" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Repeat Password</label>
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

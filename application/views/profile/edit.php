<?php
	$row = $query->row();
	$can_self_manage = !empty($can_self_manage);
	$role_label = isset($role_label) ? $role_label : $row->usertype;
	$readonly_attr = $can_self_manage ? '' : 'readonly';
	$disabled_attr = $can_self_manage ? '' : 'disabled';

	$display_value = function ($value) {
		$value = trim((string) $value);
		return $value !== '' ? $value : 'N/A';
	};

	$birthdate_display = 'N/A';
	if (!empty($row->birthdate)) {
		$birth_ts = strtotime($row->birthdate);
		$birthdate_display = $birth_ts ? date("Y-m-d", $birth_ts) : $display_value($row->birthdate);
	}

	$lrn_display = $display_value($row->lrn ?? '');
	$schoolid_display = $display_value($row->school_id ?? '');
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">

<div class="col-lg-12 grid-margin enroll-main-container">

	<div class="card enroll-card">
	  <div class="card-body p-0">
	 
		<div class="enroll-header">
			<h2><i class="mdi mdi-account"></i> MY PROFILE</h2>
		</div>
		
		<div style="padding: 1.5rem 2rem;">
		
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="text-primary" style="margin-bottom:10px;">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>	
		
		<?=validation_errors()?>
		
		<form class="enroll-form" action="<?=site_url("myprofile/updateinfo_submit/")?>" method="POST">
		  
		  <div class="enroll-instruction">
			<?php if($can_self_manage): ?>
				<i class="mdi mdi-shield-account"></i> <?= htmlspecialchars($role_label, ENT_QUOTES, 'UTF-8') ?> access enabled. You can update your own account information here.
			<?php else: ?>
				<i class="mdi mdi-information-outline"></i> Your profile is view-only. Any changes, including password updates, require admin permission first.
			<?php endif; ?>
		  </div>

		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> BASIC INFORMATION</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">Mobile No. or Login</label>
					<input type="text" name="mobileno" value="<?= set_value('mobileno',$row->mobileno) ?>" class="form-control" <?= $can_self_manage ? '' : 'disabled' ?> />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">User Type</label>
					<input type="text" name="usertype" value="<?= htmlspecialchars($role_label, ENT_QUOTES, 'UTF-8') ?>" class="form-control" disabled />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="firstname" value="<?= set_value('firstname',$row->firstname) ?>" class="form-control" placeholder="Enter First Name" <?= $readonly_attr ?> />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="lastname" value="<?= set_value('lastname',$row->lastname) ?>" class="form-control" placeholder="Enter Last Name" <?= $readonly_attr ?> />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">E-mail</label>
					<input type="text" name="emailadd" value="<?= set_value('emailadd',$row->emailadd) ?>" class="form-control" placeholder="Enter Email Address" <?= $readonly_attr ?> />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">Birthdate</label>
					<input type="<?= $can_self_manage ? 'date' : 'text' ?>" name="birthdate" value="<?= set_value('birthdate', !empty($row->birthdate) ? date('Y-m-d', strtotime($row->birthdate)) : '') ?: ($can_self_manage ? '' : $birthdate_display) ?>" class="form-control" <?= $can_self_manage ? '' : 'readonly' ?> />
				</div>
			</div>
		  </div>

		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> LRN AND STUDENT-ID </h5>
		  </div>
		  		
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">LRN</label>
					<input type="text" value="<?= $lrn_display ?>" class="form-control" readonly />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">Student ID</label>
					<input type="text" value="<?= $schoolid_display ?>" class="form-control" readonly />
				</div>
			</div>
		  </div>
		  
		  
		  <div style="text-align:center;margin:0 auto; margin-top: 20px;">
		  <?php if($can_self_manage): ?>
		  	<div class="row">
		  		<div class="col-md-6">
		  			<div class="form-group">
		  				<label class="form-label">New Password</label>
		  				<input type="password" name="cpassword" value="" class="form-control" placeholder="Leave blank to keep current password">
		  			</div>
		  		</div>
		  		<div class="col-md-6">
		  			<div class="form-group">
		  				<label class="form-label">Repeat Password</label>
		  				<input type="password" name="rpassword" value="" class="form-control" placeholder="Repeat new password">
		  			</div>
		  		</div>
		  	</div>
		  	<input type="submit" class="btn btn-lg btn-success" name="submit" value="UPDATE MY PROFILE">
		  <?php else: ?>
		  	<input type="submit" class="btn btn-lg btn-secondary" name="submit" value="ADMIN APPROVAL REQUIRED" disabled>
		  <?php endif; ?>
		  </div>

		</form>
	  </div>
	</div> 
	
</div>

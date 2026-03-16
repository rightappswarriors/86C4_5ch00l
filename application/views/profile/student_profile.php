<?php
	$row = $query->row();

	$display_value = function ($value) {
		$value = trim((string) $value);
		return $value !== '' ? $value : 'N/A';
	};

	$birthdate_display = 'N/A';
	if (!empty($row->birthdate)) {
		$birth_ts = strtotime($row->birthdate);
		$birthdate_display = $birth_ts ? date("F j, Y", $birth_ts) : $display_value($row->birthdate);
	}

	$lrn_display = $display_value($row->lrn ?? '');
	$schoolid_display = $display_value($row->school_id ?? '');
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">
<style>
	.student-profile-container {
		padding: 1.5rem;
	}
	.profile-card {
		border: none;
		border-radius: 16px;
		box-shadow: 0 4px 20px rgba(0,0,0,0.08);
		overflow: hidden;
		background: #fff;
		margin-bottom: 1.5rem;
	}
	.profile-header {
		background: linear-gradient(135deg, #1c45ef 0%, #3b82f6 100%);
		color: white;
		padding: 1.5rem;
		text-align: center;
	}
	.profile-avatar {
		width: 100px;
		height: 100px;
		border-radius: 50%;
		background: white;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 1rem;
		font-size: 3rem;
		color: #1c45ef;
		box-shadow: 0 4px 15px rgba(0,0,0,0.2);
	}
	.profile-header h3 {
		margin: 0;
		font-weight: 700;
	}
	.profile-header p {
		margin: 0.5rem 0 0;
		opacity: 0.9;
		font-size: 0.9rem;
	}
	.profile-body {
		padding: 1.5rem;
	}
	.info-row {
		display: flex;
		align-items: center;
		padding: 1rem 0;
		border-bottom: 1px solid #f3f4f6;
	}
	.info-row:last-child {
		border-bottom: none;
	}
	.info-icon {
		width: 45px;
		height: 45px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 1rem;
		font-size: 1.25rem;
		color: white;
		flex-shrink: 0;
	}
	.info-icon.basic { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); }
	.info-icon.contact { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
	.info-icon.school { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
	.info-icon.password { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
	.info-content {
		flex: 1;
	}
	.info-label {
		font-size: 0.75rem;
		color: #6b7280;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin-bottom: 0.25rem;
	}
	.info-value {
		font-size: 1rem;
		font-weight: 600;
		color: #1f2937;
	}
	.info-value.na {
		color: #9ca3af;
		font-style: italic;
	}
	.edit-btn {
		background: linear-gradient(135deg, #1c45ef 0%, #3b82f6 100%);
		border: none;
		border-radius: 10px;
		padding: 0.6rem 1.25rem;
		font-weight: 600;
		font-size: 0.9rem;
		color: white;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.edit-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
	}
	.edit-form-card {
		display: none;
	}
	.edit-form-card.active {
		display: block;
	}
	.form-group {
		margin-bottom: 1.25rem;
	}
	.form-label {
		display: block;
		font-size: 0.85rem;
		font-weight: 600;
		color: #374151;
		margin-bottom: 0.5rem;
	}
	.form-control {
		width: 100%;
		padding: 0.75rem 1rem;
		border: 2px solid #e5e7eb;
		border-radius: 10px;
		font-size: 0.95rem;
		transition: all 0.3s ease;
	}
	.form-control:focus {
		outline: none;
		border-color: #3b82f6;
		box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
	}
	.form-control:disabled {
		background: #f9fafb;
		color: #6b7280;
	}
	.save-btn {
		background: linear-gradient(135deg, #10b981 0%, #059669 100%);
		border: none;
		border-radius: 10px;
		padding: 0.75rem 2rem;
		font-weight: 600;
		font-size: 1rem;
		color: white;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.save-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
	}
	.cancel-btn {
		background: #6b7280;
		border: none;
		border-radius: 10px;
		padding: 0.75rem 1.5rem;
		font-weight: 600;
		font-size: 1rem;
		color: white;
		cursor: pointer;
		transition: all 0.3s ease;
		margin-right: 0.75rem;
	}
	.cancel-btn:hover {
		background: #4b5563;
	}
	.alert-success {
		background: #d1fae5;
		color: #065f46;
		padding: 1rem;
		border-radius: 10px;
		margin-bottom: 1.5rem;
	}
	.enroll-section-title {
		color: #1c45ef;
		font-weight: 700;
		margin-bottom: 1rem;
		padding-bottom: 0.5rem;
		border-bottom: 2px solid #e5e7eb;
	}
	.grades-card {
		margin-top: 1.5rem;
	}
	.grades-table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 1rem;
	}
	.grades-table th,
	.grades-table td {
		padding: 0.75rem;
		text-align: left;
		border-bottom: 1px solid #e5e7eb;
	}
	.grades-table th {
		background: #f9fafb;
		font-weight: 600;
		color: #374151;
		font-size: 0.85rem;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}
	.grades-table td {
		color: #6b7280;
	}
	.grades-empty {
		text-align: center;
		padding: 2rem;
		color: #9ca3af;
		font-style: italic;
	}
	.grades-empty i {
		font-size: 2.5rem;
		margin-bottom: 0.5rem;
		display: block;
	}
</style>

<div class="col-lg-12 grid-margin student-profile-container">
	<!-- Display Card -->
	<div class="card profile-card" id="displayCard">
		<div class="profile-header">
			<div class="profile-avatar">
				<i class="mdi mdi-account"></i>
			</div>
			<h3><?= $row->firstname ?> <?= $row->lastname ?></h3>
			<p><i class="mdi mdi-school"></i> Student</p>
		</div>
		<div class="profile-body">
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert-success">
					<i class="mdi mdi-check-circle"></i> <?=$this->session->flashdata('message')?>
				</div>
			<?php endif; ?>

			<div class="info-row">
				<div class="info-icon basic">
					<i class="mdi mdi-cellphone"></i>
				</div>
				<div class="info-content">
					<div class="info-label">Mobile No. / Login</div>
					<div class="info-value"><?= $display_value($row->mobileno) ?></div>
				</div>
			</div>

			<div class="info-row">
				<div class="info-icon contact">
					<i class="mdi mdi-email"></i>
				</div>
				<div class="info-content">
					<div class="info-label">Email Address</div>
					<div class="info-value <?= $row->emailadd == '' ? 'na' : '' ?>"><?= $display_value($row->emailadd) ?></div>
				</div>
			</div>

			<div class="info-row">
				<div class="info-icon basic">
					<i class="mdi mdi-cake-variant"></i>
				</div>
				<div class="info-content">
					<div class="info-label">Birthdate</div>
					<div class="info-value"><?= $birthdate_display ?></div>
				</div>
			</div>

			<div class="info-row">
				<div class="info-icon school">
					<i class="mdi mdi-license"></i>
				</div>
				<div class="info-content">
					<div class="info-label">LRN (Learning Reference Number)</div>
					<div class="info-value <?= $lrn_display == 'N/A' ? 'na' : '' ?>"><?= $lrn_display ?></div>
				</div>
			</div>

			<div class="info-row">
				<div class="info-icon school">
					<i class="mdi mdi-identification-card"></i>
				</div>
				<div class="info-content">
					<div class="info-label">Student ID</div>
					<div class="info-value <?= $schoolid_display == 'N/A' ? 'na' : '' ?>"><?= $schoolid_display ?></div>
				</div>
			</div>

			<div style="text-align: center; margin-top: 1.5rem;">
				<button type="button" class="edit-btn" onclick="toggleEditForm()">
					<i class="mdi mdi-pencil"></i> Edit Profile
				</button>
			</div>
		</div>
	</div>

	<!-- Edit Form Card -->
	<div class="card profile-card edit-form-card" id="editCard">
		<div class="profile-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
			<div class="profile-avatar" style="color: #d97706;">
				<i class="mdi mdi-pencil"></i>
			</div>
			<h3>Edit Profile</h3>
			<p>Update your information below</p>
		</div>
		<div class="profile-body">
			<?=validation_errors()?>

			<form class="enroll-form" action="<?=site_url("myprofile/updateinfo_submit/")?>" method="POST">
				<div class="enroll-section">
					<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> BASIC INFORMATION</h5>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Mobile No. or Login</label>
							<input type="text" name="mobileno" value="<?= $row->mobileno ?>" class="form-control" disabled />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">User Type</label>
							<input type="text" name="usertype" value="<?= $row->usertype ?>" class="form-control" disabled />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">First Name</label>
							<input type="text" name="firstname" value="<?= set_value('firstname',$row->firstname) ?>" class="form-control" placeholder="Enter First Name" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Last Name</label>
							<input type="text" name="lastname" value="<?= set_value('lastname',$row->lastname) ?>" class="form-control" placeholder="Enter Last Name" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">E-mail</label>
							<input type="text" name="emailadd" value="<?= set_value('emailadd',$row->emailadd) ?>" class="form-control" placeholder="Enter Email Address" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Birthdate</label>
							<input type="text" value="<?= $birthdate_display ?>" class="form-control" readonly />
						</div>
					</div>
				</div>

				<div class="enroll-section">
					<h5 class="enroll-section-title"><i class="mdi mdi-lock"></i> CHANGE PASSWORD</h5>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">New Password</label>
							<input type="password" name="cpassword" value="" class="form-control" placeholder="Enter New Password" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Repeat New Password</label>
							<input type="password" name="rpassword" value="" class="form-control" placeholder="Repeat New Password" />
						</div>
					</div>
				</div>

				<div style="text-align: center; margin-top: 1.5rem;">
					<button type="button" class="cancel-btn" onclick="toggleEditForm()">
						<i class="mdi mdi-close"></i> Cancel
					</button>
					<button type="submit" class="save-btn" name="submit" value="UPDATE">
						<i class="mdi mdi-check"></i> Save Changes
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
function toggleEditForm() {
	var displayCard = document.getElementById('displayCard');
	var editCard = document.getElementById('editCard');
	
	if (displayCard.style.display === 'none') {
		displayCard.style.display = 'block';
		editCard.classList.remove('active');
	} else {
		displayCard.style.display = 'none';
		editCard.classList.add('active');
	}
}
</script>

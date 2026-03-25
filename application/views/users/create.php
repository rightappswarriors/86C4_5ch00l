<?php
$page_title = 'Create New User';
$page_subtitle = 'Set up login access, identity details, and the role assignment for a new account.';
$submit_label = 'Create Account';
$form_action = site_url("users/create_submit/");
$button_class = 'btn-success';
$user_types = array(
	'' => '-- Select User Type --',
	'Super Admin' => 'Super Admin',
	'Admin' => 'Admin',
	'Registrar' => 'Registrar',
	'Teacher' => 'Teacher',
	'Accounting' => 'Accounting',
	'Parent' => 'Parent',
	'Student' => 'Student'
);
$grade_options = array(
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
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/Dashboard/users_editor.css">

<div class="col-lg-12 grid-margin stretch-card user-editor user-editor-create">
	<div class="card user-editor-card">
		<div class="user-editor-hero user-editor-hero-create">
			<h2><i class="mdi mdi-account-plus"></i> <?= $page_title ?></h2>
			<p><?= $page_subtitle ?></p>
		</div>

		<div class="user-editor-body">
			<?php if($this->session->flashdata('message')): ?>
				<div class="user-alert user-alert-success"><?= $this->session->flashdata("message") ?></div>
			<?php endif; ?>

			<?php if (validation_errors()): ?>
				<div class="user-alert user-alert-error"><?= validation_errors() ?></div>
			<?php endif; ?>

			<form action="<?= $form_action ?>" method="POST">
				<div class="user-section">
					<div class="user-section-title">
						<i class="mdi mdi-shield-account"></i>
						<span>Access And Role</span>
					</div>
					<div class="row">
						<div class="col-md-6 user-field">
							<label>Mobile No. or Login</label>
							<input type="text" name="mobileno" value="<?= set_value("mobileno") ?>" class="form-control" />
						</div>
						<div class="col-md-6 user-field">
							<label>User Type</label>
							<?= form_dropdown('usertype', $user_types, set_value('usertype'), 'class="form-control"') ?>
						</div>
					</div>
				</div>

				<div class="user-section">
					<div class="user-section-title">
						<i class="mdi mdi-account-box-outline"></i>
						<span>Identity Information</span>
					</div>
					<div class="row">
						<div class="col-md-4 user-field">
							<label>First Name</label>
							<input type="text" name="firstname" value="<?= set_value("firstname") ?>" class="form-control" />
						</div>
						<div class="col-md-4 user-field">
							<label>Middle Name</label>
							<input type="text" name="middlename" value="<?= set_value('middlename') ?>" class="form-control" />
						</div>
						<div class="col-md-4 user-field">
							<label>Last Name</label>
							<input type="text" name="lastname" value="<?= set_value('lastname') ?>" class="form-control" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 user-field">
							<label>E-mail</label>
							<input type="text" name="emailadd" value="<?= set_value('emailadd') ?>" class="form-control" />
						</div>
						<div class="col-md-6 user-field">
							<label>Birthdate</label>
							<input type="date" name="birthdate" value="<?= set_value('birthdate') ?>" class="form-control" />
						</div>
					</div>
				</div>

				<div class="user-section">
					<div class="user-section-title">
						<i class="mdi mdi-school"></i>
						<span>Academic Assignment</span>
					</div>
					<div class="row">
						<div class="col-md-6 user-field">
							<label>Primary Grade Level</label>
							<?= form_dropdown('gradelevel', $grade_options, set_value('gradelevel'), 'class="form-control"') ?>
						</div>
						<div class="col-md-6 user-field">
							<label>Secondary Grade Level</label>
							<?= form_dropdown('gradelevel1', $grade_options, set_value('gradelevel1'), 'class="form-control"') ?>
						</div>
					</div>
				</div>

				<div class="user-section">
					<div class="user-section-title">
						<i class="mdi mdi-lock-reset"></i>
						<span>Password Setup</span>
					</div>
					<p class="user-note">Default password values can still be adjusted before saving this account.</p>
					<div class="row">
						<div class="col-md-6 user-field">
							<label>Password</label>
							<input type="password" name="cpassword" value="bhcatemp" class="form-control" />
						</div>
						<div class="col-md-6 user-field">
							<label>Repeat Password</label>
							<input type="password" name="rpassword" value="bhcatemp" class="form-control" />
						</div>
					</div>
				</div>

				<div class="user-actions">
					<a href="<?= site_url('users') ?>" class="btn btn-light border">Back To Users</a>
					<input type="submit" class="btn <?= $button_class ?>" name="submit" value="<?= $submit_label ?>">
				</div>
			</form>
		</div>
	</div>
</div>

<li class="nav-item nav-category">Main Menu</li>

<!-- New Student/Transferee Enrollment Procedures - Shown at Top -->
<li class="nav-item enrollment-procedures-nav">
  <a class="nav-link" href="#" data-toggle="modal" data-target="#enrollmentStepsModal">
	<i class="menu-icon typcn typcn-th-list text-white"></i>
	<span class="menu-title text-white font-weight-bold">Enrollment Procedures</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="<?=site_url("dashboard")?>">
	<i class="menu-icon typcn typcn-document-text"></i>
	<span class="menu-title">Dashboard</span>
  </a>
</li>

<?php if($this->session->userdata('current_usertype') == 'Parent'): ?>

	<?php
	// PARENT
	$query = "select a.*,b.gradelevel,b.status as enrollstatus from students a 
	join enrolled b on b.studentid = a.id where a.user_id = '".$this->session->userdata('current_userid')."' 
	and b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid');
	$query = $this->db->query( $query );
	$strcount = $query->num_rows();
	if($strcount == 0):
	?>

	<!-- FOR PARENT MENU  -->

	<?php if($this->session->userdata('current_schoolyearid') > 0): ?>
	<li class="nav-item">
	  <a class="nav-link" href="<?=site_url("students/enroll_readhandbook")?>">
		<i class="menu-icon typcn typcn-shopping-bag"></i>
		<span class="menu-title">Enroll a Student</span>
	  </a>
	</li>
	<?php else: ?>
	<li class="nav-item">
	  <a class="nav-link" href="#">
		<i class="menu-icon typcn typcn-shopping-bag"></i>
		<span class="menu-title">Enroll a Student</span>
	  </a>
	</li>
	<?php endif; ?>
	
	
	

	<?php else: ?>

		<?php 

		$with_active = 0;
		foreach ($query->result() as $row): 
			
			if($row->enrollstatus=="Active"):
				$with_active = 1;
			endif;

		endforeach; 

		if($with_active):

		?>

			<!-- WITH STUDENT/S already... -->
			<li class="nav-item">
			  <!--<a class="nav-link" href="<?=site_url("students")?>">-->
			  <a class="nav-link" data-toggle="collapse" href="#ui-students" aria-expanded="false" aria-controls="ui-students">
				<i class="menu-icon typcn typcn-coffee"></i>
				<span class="menu-title">Child (<?=$strcount?>)</span>
				<i class="menu-arrow"></i>
			  </a>
			  <div class="collapse" id="ui-students">
				<ul class="nav flex-column sub-menu">
				  <li class="nav-item">
					<a class="nav-link" href="<?=site_url("students")?>">Enrolled List</a>
				  </li>
				  <?php if($this->session->userdata('current_schoolyearid') > 0): ?>
				  <li class="nav-item">
					<a class="nav-link" href="<?=site_url("students/enroll_readhandbook")?>">Enroll a Student</a>
				  </li>
				  <?php else: ?>
				  <li class="nav-item">
					<a class="nav-link" href="#">Enroll a Student</a>
				  </li>
				  <?php endif; ?>
<li class="nav-item">
				  <a class="nav-link" href="<?=site_url("students/fetcher_register")?>">Fetch ID</a>
				  </li>
<li class="nav-item">
				  <a class="nav-link" href="<?=site_url("students/fetcher_list")?>">Fetcher List</a>
				  </li>
				</ul>
			  </div>
			</li>

		
		<?php else: ?>
		
		<!-- FOR PARENT MENU  -->
		<li class="nav-item">
		  <a class="nav-link" href="<?=site_url("students")?>">
			<i class="menu-icon typcn typcn-shopping-bag"></i>
			<span class="menu-title">Child (<?=$strcount?>)</span>
		  </a>
		</li><li class="nav-item">
		  <a class="nav-link" href="<?=site_url("students/enroll_readhandbook")?>">
			<i class="menu-icon typcn typcn-shopping-bag"></i>
			<span class="menu-title">Enroll Student</span>
		  </a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="<?=site_url("students/fetcher_register")?>">
			<i class="menu-icon typcn typcn-credit-card"></i>
			<span class="menu-title">Fetcher's ID Application</span>
		  </a>
		</li>
		
		<?php endif; ?>

		

	<?php endif; ?>
<?php elseif($this->session->userdata('current_usertype') == 'Teacher'): ?>

 <li class="nav-item">
  <a class="nav-link" href="<?=site_url("mystudents")?>">
	<i class="menu-icon typcn typcn-shopping-bag"></i>
	<span class="menu-title">My Students</span>
  </a>
</li>

<?php else: ?>


 <li class="nav-item">
  <a class="nav-link" href="<?=site_url("students")?>">
	<i class="menu-icon typcn typcn-shopping-bag"></i>
	<span class="menu-title">Students</span>
  </a>
</li>

<li class="nav-item nav-item-hidden">
  <a class="nav-link" href="<?=site_url("academics")?>">
	<i class="menu-icon typcn typcn-shopping-bag"></i>
	<span class="menu-title">Academics</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="<?=site_url("interviews")?>">
	<i class="menu-icon typcn typcn-shopping-bag"></i>
	<span class="menu-title">Interview Schedules</span>
  </a>
</li>

<!-- <li class="nav-item">
  <a class="nav-link" href="<?=site_url("interviews/applicants")?>">
	<i class="menu-icon typcn typcn-users"></i>
	<span class="menu-title">Interview Applicants</span>
  </a>
</li> -->

<?php if($this->session->userdata('current_usertype') == 'Accounting'):?>
<li class="nav-item">
  <a class="nav-link" href="<?=site_url("payments")?>">
	<i class="menu-icon typcn typcn-bell"></i>
	<span class="menu-title">Payments</span>
  </a>
</li>
<?php endif; ?>

<?php if(in_array($this->session->userdata('current_usertype'), array('Admin','Accounting','Registrar','Principal'))): ?>
<li class="nav-item">
  <a class="nav-link" href="<?=site_url("students/fetcher_info")?>">
	<i class="menu-icon typcn typcn-credit-card"></i>
	<span class="menu-title">Fetcher Information</span>
  </a>
</li>
<?php endif; ?>

<?php endif; ?>

<?php if(in_array($this->session->userdata('current_usertype_display'), array('Super Admin', 'Admin'))):?>
<?php //if($this->session->userdata('current_userid') == 25):?>

<li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#ui-students" aria-expanded="false" aria-controls="ui-students">
	<i class="menu-icon typcn typcn-coffee"></i>
	<span class="menu-title"> System Users </span>
	<i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="ui-students">
	<ul class="nav flex-column sub-menu">
	  <li class="nav-item">
		<a class="nav-link" href="<?=site_url("users")?>"> Show Users </a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="<?=site_url("users/create")?>">Create New User</a>
	  </li>
	  
	</ul>
  </div>
</li>
<?php endif; ?>

<li class="nav-item">
  <a class="nav-link" target="_blank" href="http://portal.bobhughes.edu.ph/file/BHCA-HandBook-2019-Latest.pdf">
	<i class="menu-icon typcn typcn-shopping-bag"></i>
	<span class="menu-title">Handbook 2019</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="<?=site_url("logout")?>">
	<i class="menu-icon typcn typcn-coffee"></i>
	<span class="menu-title">Log Out</span>
  </a>
</li>

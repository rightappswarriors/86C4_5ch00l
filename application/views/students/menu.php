<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/action_menu.css">

<div class="col-md-12">
<div class="row student-page-header">

<div class="col-sm-10">
    <div class="student-info-card">
        <h3 class="student-summary-name"> <?= $row->firstname . " " . $row->lastname ?> 
            <span class="status-badge status-student-type"><?=$row->newold?> student</span> 
            <span class="status-badge status-interview"><?=$row->enrollstatus?></span>
        </h3>
        <p class="student-summary-meta"><i class="mdi mdi-alert-circle"></i> Issue PACE? <?=$row->ableforpt?></p>
    </div>
</div>
<div class="col-sm-2 student-photo-wrap">
    <img src="<?=$profile_pic?>" class="student-profile-img">
</div>

</div>

<div class="action-menu">

<?php if($this->session->userdata('current_usertype') == 'Parent'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="action-btn action-btn-details"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="action-btn action-btn-assessment"><i class='mdi mdi-calculator'></i>Assessment</a>
<a href="<?=site_url("students/interview/".$row->id)?>" class="action-btn action-btn-interview"><i class='mdi mdi-account-voice'></i>Interview</a>
<a href="<?=site_url("payments/showlist/".$row->id)?>" class="action-btn action-btn-payments"><i class='mdi mdi-credit-card'></i>Payments</a>
<a href="<?=site_url("payments/statement/".$row->id)?>" class="action-btn action-btn-soa"><i class='mdi mdi-file-document-outline'></i>SOA</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="action-btn action-btn-docs"><i class='mdi mdi-folder-upload'></i>Requirements</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="action-btn action-btn-academics"><i class='mdi mdi-school'></i>Academics</a>

<?php elseif($this->session->userdata('current_usertype') == 'Accounting'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="action-btn action-btn-details"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="action-btn action-btn-assessment"><i class='mdi mdi-calculator'></i>Assessment</a>
<a href="<?=site_url("payments/showlist/".$row->id)?>" class="action-btn action-btn-payments"><i class='mdi mdi-credit-card'></i>Payments</a>
<a href="<?=site_url("payments/create/".$row->id)?>" class="action-btn action-btn-create"><i class='mdi mdi-plus-circle'></i>Create Payment</a>
<a href="<?=site_url("payments/statement/".$row->id)?>" class="action-btn action-btn-soa"><i class='mdi mdi-file-document-outline'></i>SOA</a>

<?php elseif($this->session->userdata('current_usertype') == 'Registrar' or $this->session->userdata('current_usertype') == 'Principal'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="action-btn action-btn-details"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/updateinfo/".$row->id)?>" class="action-btn action-btn-update"><i class='mdi mdi-pencil'></i>Update Info</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="action-btn action-btn-assessment"><i class='mdi mdi-calculator'></i>Assessment</a>
<a href="<?=site_url("students/interview/".$row->id)?>" class="action-btn action-btn-interview"><i class='mdi mdi-account-voice'></i>Interview</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="action-btn action-btn-docs"><i class='mdi mdi-folder-upload'></i>Requirements</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="action-btn action-btn-academics"><i class='mdi mdi-school'></i>Academics</a>

<?php elseif($this->session->userdata('current_usertype') == 'Admin'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="action-btn action-btn-details"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="action-btn action-btn-assessment"><i class='mdi mdi-calculator'></i>Assessment</a>
<a href="<?=site_url("students/interview/".$row->id)?>" class="action-btn action-btn-interview"><i class='mdi mdi-account-voice'></i>Interview</a>
<a href="<?=site_url("payments/showlist/".$row->id)?>" class="action-btn action-btn-payments"><i class='mdi mdi-credit-card'></i>Payments</a>
<a href="<?=site_url("payments/statement/".$row->id)?>" class="action-btn action-btn-soa"><i class='mdi mdi-file-document-outline'></i>SOA</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="action-btn action-btn-docs"><i class='mdi mdi-folder-upload'></i>Requirements</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="action-btn action-btn-academics"><i class='mdi mdi-school'></i>Academics</a>

<?php elseif($this->session->userdata('current_usertype') == 'Teacher'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="action-btn action-btn-details"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="action-btn action-btn-academics"><i class='mdi mdi-school'></i>Academics</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="action-btn action-btn-docs"><i class='mdi mdi-folder-upload'></i>Requirements</a>

<?php endif; ?>

</div>

</div>

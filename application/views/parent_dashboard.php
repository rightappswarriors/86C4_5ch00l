<div class="col-md-6 grid-margin" style="display:none;">
	<div class="card">
	  <div class="card-body">
		
	  <div class="media">
		  <i class="mdi mdi-earth icon-md text-info d-flex align-self-start mr-3"></i>
		  <div class="media-body">
			<ul class="list-ticked">
			<li>All payments must be done in the accounting office.</li>
			<li>NO Payment Transaction in this Online Portal.</li>
			</ul>
		  </div>
		</div>
	  
	  </div>
	  
	</div>
</div>
	

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/parent_dashboard.css">
<style>
.parent-dashboard .info-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
}
.parent-dashboard .info-header {
    background: linear-gradient(#1c45ef);
    color: #fff;
    padding: 1.25rem 1.5rem;
}
.parent-dashboard .info-header h4 {
    margin: 0;
    font-weight: 600;
}
.parent-dashboard .card-body {
    padding: 1.5rem;
}
.parent-dashboard .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    font-size: 1rem;
}
.parent-dashboard .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.parent-dashboard .bank-info {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 10px;
    padding: 1.5rem;
    border-left: 4px solid #ec4899;
}
.parent-dashboard .bank-info code {
    background: transparent;
    color: #1f2937;
    font-size: 1rem;
}
</style>

<div class="col-md-12 grid-margin parent-dashboard">
	<div class="card info-card">
	  <div class="info-header">
		<h4 class="mb-0"><i class="mdi mdi-school"></i> Enrollment Information</h4>
	  </div>
	  <div class="card-body">
		<?php
	if($this->session->flashdata('message'))
	{
		echo '<div class="text-danger" style="text-align:center;margin-bottom:10px;">
			'.$this->session->flashdata("message").'
		</div>';
	}
	?>		
		<p style="text-align:center;">
		<?php if($this->session->userdata('current_schoolyearid')==6): ?>
		<a href="<?=site_url("students/enroll_readhandbook")?>" type="button" class="btn btn-lg btn-success btn-fw"><i class="mdi mdi-file-document"></i>Enroll an OLD/NEW Student</a></p>
		<?php else: ?>
		<b>If you want to enroll for SY 2024-2025, please click the drop down menu at the top portion of this page and click SY 2024 - 2025.</b>
		<a href="#" type="button" class="btn btn-lg btn-success btn-fw disabled"><i class="mdi mdi-file-document"></i>Enroll an OLD/NEW Student</a></p>
		<?php endif; ?>
		<hr>
		<h1 class="" style="font-size:18px;font-weight:bold;">You may deposit your payments to the following bank account:</h1>
		
		<code><p class="mb-0">Bank: <b class="text-primary" style="font-size:20px;">CHINA BANK</b></p>
		<p>Pay to: <b class="text-primary" style="font-size:20px;">CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</b><br>Account #: <b class="text-primary" style="font-size:20px;">1071-00001119</b></p></code>
		<hr>
		<p>Please upload a copy or a picture of your proof of payment under <code class="text-primary"><< Payment >></code> Tab of student page details.</p>
		<p>For more than one student with single receipt of transaction, please upload the same copy per student.</p>
		
	  </div>
	</div>
</div>
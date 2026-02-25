<div class="col-md-12" style="text-align:left;margin-bottom:20px;">
<div class="row" style="margin-bottom:20px;">

<div class="col-sm-10">
<h3> <?= $row->firstname . " " . $row->lastname ?> <code style="font-size:14px;"><?=$row->newold?> student</code> <code class="text-info">(<?=$row->enrollstatus?>)</code> <!--<a href="<?=site_url("students/preenroll_form/".$row->id)?>" class="btn btn-md btn-primary">Application for Pre-enrollment</a>--> <code style="font-size:16px;" class="text-danger"><br>Able to take PACE Test: <?=$row->ableforpt?></code></h3>
</div>
<div class="col-sm-2">

	<div class="row" style="text-align:center;margin:0 auto;">
		<img src="<?=$profile_pic?>" style="width:120px;border:5px solid #ccc;">
	</div>

</div>

</div>

<?php if($this->session->userdata('current_usertype') == 'Parent'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-currency-php'></i>Assesment</a>
<a href="<?=site_url("students/interview/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account-box'></i>Interview</a>
<a href="<?=site_url("payments/showlist/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-cash'></i>Payments</a>
<a href="<?=site_url("payments/statement/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account-check'></i>SOA</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-file-document'></i>Requirements/Docs</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-medal'></i>Academics</a>

<?php elseif($this->session->userdata('current_usertype') == 'Accounting'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-currency-php'></i>Assesment</a>
<a href="<?=site_url("payments/showlist/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-cash'></i>Payments</a>
<a href="<?=site_url("payments/create/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-plus'></i>Create Payment</a>
<a href="<?=site_url("payments/statement/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account-check'></i>SOA</a>

<?php elseif($this->session->userdata('current_usertype') == 'Registrar' or $this->session->userdata('current_usertype') == 'Principal'): ?>
<a href="<?=site_url("students/updateinfo/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-pencil'></i>Update Info</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-currency-php'></i>Assesment</a>
<a href="<?=site_url("students/interview/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account-box'></i>Interview</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-file-document'></i>Requirements/Docs</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-medal'></i>Academics</a>

<?php elseif($this->session->userdata('current_usertype') == 'Admin'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-currency-php'></i>Assesment</a>
<a href="<?=site_url("students/interview/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account-box'></i>Interview</a>
<a href="<?=site_url("payments/showlist/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-cash'></i>Payments</a>
<a href="<?=site_url("payments/statement/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account-check'></i>SOA</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-file-document'></i>Requirements/Docs</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-medal'></i>Academics</a>

<?php elseif($this->session->userdata('current_usertype') == 'Teacher'): ?>
<a href="<?=site_url("students/details/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-account'></i>Details</a>
<a href="<?=site_url("students/academics/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-medal'></i>Academics</a>
<a href="<?=site_url("students/docs/".$row->id)?>" class="btn btn-secondary"><i class='mdi mdi-file-document'></i>Requirements/Docs</a>

<?php endif; ?>

</div>
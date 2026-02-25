<div class="col-md-12" style="text-align:left;margin-bottom:20px;">
<h3> <?= $row->firstname . " " . $row->lastname ?> <code style="font-size:14px;"><?=$row->newold?> student</code> </h3>

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
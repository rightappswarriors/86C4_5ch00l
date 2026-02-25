<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	$interviews = explode(",",$row->admininterview);
?>

<?php $this->load->view("students/menu",$data) ?>

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
		
		<h3 class="heading" style="text-align:center;">Admin Interview</h3>
		<hr>
		
		<p>No assessment found!</p>	
		
	  </div>
	</div> 
	
</div>
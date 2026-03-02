<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/accounting_dashboard.css">
<style>
.accounting-dashboard .payment-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
}
.accounting-dashboard .payment-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
    border-radius: 12px 12px 0 0;
}
.accounting-dashboard .payment-header h4 {
    margin: 0;
    font-weight: 600;
}
.accounting-dashboard .card-body {
    padding: 1.5rem;
}
.accounting-dashboard .table thead th {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 12px;
}
.accounting-dashboard .table tbody tr {
    transition: all 0.3s ease;
}
.accounting-dashboard .table tbody tr:hover {
    background: #f0fdf4;
    transform: scale(1.01);
}
.accounting-dashboard .table tbody td {
    padding: 12px;
    vertical-align: middle;
}
.accounting-dashboard .btn-primary {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
}
.accounting-dashboard .btn-primary:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.amount-cell {
    font-weight: 600;
    color: #10b981;
}
</style>

<div class="col-md-8 accounting-dashboard">
<div class="row">
	<div class="col-md-12 grid-margin">
		<div class="card">
		  <div class="card-body">
		  
		  <?php
	if($this->session->flashdata('message'))
	{
		echo '<div class="text-danger" style="text-align:center;margin-bottom:10px;">
			'.$this->session->flashdata("message").'
		</div>';
	}
	?>		
		  
			<div class="d-flex justify-content-between">
			  <h4 class="card-title mb-0">10 Most Recent Payments </h4>
			  <a href="<?=site_url("students")?>" class="btn btn-primary">Show All</a>
			</div>
			<div class="table-responsive">
			    
			<table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="15%">Date</th>
				<th width="50%">Student</th>
				<th width="10%">Paid</th>
				<th width="20%">Amount</th>
			  </tr>
			</thead>
			<tbody>
			
			<?php

			if($query->num_rows() > 0)
			{
				$ctr=1;
				foreach($query->result() as $row):
					
					echo "<tr>";
					//echo "<td>".$row->payment_code."</td>";
					echo "<td>".date("m/d/y",strtotime($row->payment_date))."</td>";
					echo "<td><a href='".site_url("students/details/".$row->student_id)."'>".$row->lastname.", ".$row->firstname."</a></td>";
					//echo "<td><a href='#' data-toggle='modal' data-target='#modalstudent".$row->id."'>".$row->firstname." ".$row->lastname."</a></td>";
					echo "<td style='text-align:center'><code>".strtoupper($row->paid)."</code></td>";
					echo "<td style='text-align:center'>".number_format($row->payment_total,2)."</td>";
					echo "</tr>";
					
					?>
					
					<?php
					
				endforeach;
			}	

			?>	
			  
			</tbody>
			
		  </table>
			  
			</div>
		  </div>
		</div>
	</div>
</div>
</div>
<div class="col-md-4">	
<div class="row">

	<div class="col-md-12 grid-margin stretch-card">
		<div class="card">
		  <div class="card-body">
			<div class="row">
			
				<?php
		
				if($count_newold_students->num_rows() > 0)
				{
					foreach ($count_newold_students->result() as $row2):
						
						$stylec="danger";
						if($row2->newold=="old"){
							$stylec="success";	
						}
						
						?>
						<div class="col-md-6">
						<div class="d-flex align-items-center pb-2">
						<div class="dot-indicator bg-<?=$stylec?> mr-2"></div>
						<p class="mb-0"><a href="<?=site_url("students/newold/".$row2->newold)?>"><?=strtoupper($row2->newold)?></a></p>
						</div>
						<h4 class="font-weight-semibold"><?=$row2->num_newold?></h4>
						<div class="progress progress-md">
						<div class="progress-bar bg-<?=$stylec?>" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
						</div>
						</div>
						<?php	
						
					endforeach;
				}
				
				?>
			
			</div>
		  </div>
		</div>
	  </div>
	
	<div class="col-md-12 grid-margin stretch-card average-price-card">
                    <div class="card text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between pb-2 align-items-center">
						<?php 
						if($count_reenrollments->num_rows() > 0)
						{
							$row_creenroll = $count_reenrollments->row();
							$num_reenroll = $row_creenroll->num_reenrolls;
						}else{ $num_reenroll = 0; }
						?>
                          <h2 class="font-weight-semibold mb-0"><?=$num_reenroll?></h2>
                          <div class="icon-holder">
                            <a href="<?=site_url("preenrollstudents")?>" style="color:#fff;"><i class="mdi mdi-briefcase-outline"></i></a>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between">
                          <h5 class="font-weight-semibold mb-0">Pre-Enrollment Applications</h5>
                          <p class="text-white mb-0"></p>
                        </div>
                      </div>
                    </div>
                  </div>
	
	<div class="col-md-12 grid-margin">
		<div class="card">
		  <div class="card-body">
			<h4 class="card-title">Enrolled Per Level</h4>
			<div class="wrapper">
			
				<?php
		
				if($count_gradelevel_students->num_rows() > 0)
				{
					foreach ($count_gradelevel_students->result() as $row1):
						
						?>
						<div class="d-flex w-100 pt-2">
							<p class="mb-0"><a href="<?=site_url("students/gradelevel/".$row1->gradelevel)?>"><?=$row1->gradelevel?></a></p>
							<div class="wrapper ml-auto d-flex align-items-center">
								<p class="ml-1 mb-0"><?=$row1->num_gradelevel?></p>
							</div>
						</div>
						<?php	
						
					endforeach;
				}
				
				?>
				
			</div>
		  </div>
		</div>
	</div>

</div>
</div>
<script>
$(document).ready(function() {
    $('.table').DataTable( {
        "searching": false,
		"bLengthChange": false,
		"info": false,
		"drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    } );
	
} );
</script>
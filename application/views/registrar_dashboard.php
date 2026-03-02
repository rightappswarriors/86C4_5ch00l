<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/registrar_dashboard.css">
<style>
.registrar-dashboard .enroll-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
}
.registrar-dashboard .enroll-header {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
}
.registrar-dashboard .enroll-header h4 {
    margin: 0;
    font-weight: 600;
}
.registrar-dashboard .card-body {
    padding: 1.5rem;
}
.registrar-dashboard .table thead th {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 12px;
}
.registrar-dashboard .table tbody tr {
    transition: all 0.3s ease;
}
.registrar-dashboard .table tbody tr:hover {
    background: #eef2ff;
    transform: scale(1.01);
}
.registrar-dashboard .table tbody td {
    padding: 12px;
    vertical-align: middle;
}
.registrar-dashboard .btn-primary {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
}
.registrar-dashboard .btn-primary:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
</style>

<div class="col-md-8 registrar-dashboard">
<div class="row">
	<div class="col-md-12 grid-margin">
		<div class="card">
		  <div class="card-body">
			<div class="d-flex justify-content-between">
			  <h4 class="card-title mb-0">10 Most Recent Enrollees </h4>
			  <a href="<?=site_url("students")?>" class="btn btn-primary">Show All</a>
			</div>
			<div class="table-responsive">
			  
			  <table class="table1 table">
	  <thead>
		<tr>
		  <th width="5%">#</th>	
		  <th width="45%">Name</th>
		  <th width="15%">Enroll</th>
		  <th width="15%">Level</th>
		  <th width="20%">Status</th>
		</tr>
	  </thead>
	  <tbody>
		
		<?php
		
		if($query->num_rows() > 0)
		{
			$ctr=1;
			foreach ($query->result() as $row):
				$newold = $row->newold=="old"?"":"&nbsp;<code>".$row->newold."</code>";
				echo "<tr>";
				echo "<td>$ctr</td>";
				echo "<td><a href='".site_url("students/details/".$row->id)."'>".$row->firstname." ".$row->lastname."</a>".$newold."</td>";
				echo "<td>".date("m/d/Y",strtotime($row->dateadded))."</td>";
				echo "<td>".$row->gradelevel."</td>";
				echo "<td class='text-danger'><mark><code>".$row->enrollstatus."</code></mark></td>";
				echo "</tr>";
				$ctr++;
				
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
						
						$stylec = $row2->newold=="old"?"success":"danger";
						
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
    $('.table1').DataTable( {
        "searching": false,
		"bLengthChange": false,
		"info": false,
		"drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    } );
	
} );
</script>
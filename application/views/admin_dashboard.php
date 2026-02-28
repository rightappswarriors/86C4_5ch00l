<style>
.admin-dashboard .enroll-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
}

.admin-dashboard .enroll-header {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #fff;
    padding: 1rem 1.5rem;
    border-radius: 12px 12px 0 0;
}

.admin-dashboard .enroll-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.admin-dashboard .enroll-section {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-radius: 10px;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    border-left: 4px solid #2563eb;
}

.admin-dashboard .enroll-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e40af;
    margin: 0;
}

.admin-dashboard .card-body {
    padding: 1.5rem;
}

.admin-dashboard .table thead th {
    background: #f3f4f6;
    color: #374151;
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
}

.admin-dashboard .table tbody tr:hover {
    background: #f9fafb;
}

.admin-dashboard .btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
}

.admin-dashboard .btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
}
</style>

<div class="col-md-8 admin-dashboard">
<div class="row">
	<div class="col-md-12 grid-margin">
		<div class="enroll-card">
		  <div class="enroll-header">
			<div class="d-flex justify-content-between align-items-center">
			  <h4 class="mb-0">10 Most Recent Enrollees</h4>
			  <a href="<?=site_url("students")?>" class="btn btn-primary">Show All</a>
			</div>
		  </div>
		  <div class="card-body">
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
<div class="col-md-4 admin-dashboard">	
<div class="row">

	<div class="col-md-12 grid-margin stretch-card">
		<div class="enroll-card">
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account-group"></i> Student Count</h5>
		  </div>
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
                    <div class="enroll-card text-white">
                      <div class="enroll-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                          <h4 class="mb-0">Pre-Enrollment Applications</h4>
                          <div class="icon-holder">
                            <a href="<?=site_url("preenrollstudents")?>" style="color:#fff;"><i class="mdi mdi-briefcase-outline"></i></a>
                          </div>
                        </div>
                      </div>
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
		<div class="enroll-card">
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-school"></i> Enrolled Per Level</h5>
		  </div>
		  <div class="card-body">
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
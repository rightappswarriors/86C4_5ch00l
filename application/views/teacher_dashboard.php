<div class="col-md-8">
<div class="row">
	<div class="col-md-12 grid-margin">
		<div class="card">
		  <div class="card-body">
			<div class="d-flex justify-content-between">
			  <h4 class="card-title mb-0">Most Recent Active Students </h4>
			  <a href="<?=site_url("students")?>" class="btn btn-primary">Show All</a>
			</div>
			<div class="table-responsive">
			  
			  <table class="table1 table">
	  <thead>
		<tr>
		  <th width="5%">#</th>	
		  <th width="55%">Name</th>
		  <th width="20%">Level</th>
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
				//echo "<td>".$row->studentno."</td>";
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
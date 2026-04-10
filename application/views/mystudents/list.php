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
	
	<h3 class="heading" style="text-align:center;">My Students </h3>
	
	
	
	<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
		<div id="DataTables_Table_0_filter" class="dataTables_filter">
			<label>Search:<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0"></label>
		</div>
		<table class="table dataTable no-footer" id="DataTables_Table_0" role="grid">
	  <thead>
		<tr role="row">
		  <th width="5%" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 20.125px;">#</th>	
		  <th width="45%" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 461.7px;">Name</th>
		  <th width="10%" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Able for PT?: activate to sort column ascending" style="width: 78.2125px;">Able for PT?</th>
		  <th width="20%" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Level: activate to sort column ascending" style="width: 184.3px;">Level</th>
		  <th width="15%" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 131.137px;">Status</th>
		  <th width="5%" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 40.925px;">Action</th>
		</tr>
	  </thead>
	  <tbody>
		
		<?php
		
		if($query->num_rows() > 0)
		{
			$ctr=1;
			foreach ($query->result() as $row):
				
				$newold = $row->newold=="old"?"":"&nbsp;<code>".$row->newold."</code>";
				$ableforpt = $row->ableforpt=="Yes"?"Yes":"<code class='text-danger'>No</code>";
				$row_class = ($ctr % 2 == 0) ? "even" : "odd";
				echo "<tr role='row' class='$row_class'>";
				echo "<td class='sorting_1'>$ctr</td>";
				echo "<td><a href='".site_url("students/details/".$row->id)."'>".$row->lastname.", ".$row->firstname."</a>".$newold."</td>";
				echo "<td class='text-center'>".$ableforpt."</td>";
				echo "<td>".$row->gradelevel."</td>";
				echo "<td class='text-danger'><mark><code>".$row->enrollstatus."</code></mark></td>";
				echo "<td style='text-align:center'>";
				
				echo "<a href='".site_url("students/details/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-account'></i></a>";
				
				echo "</td>";
				echo "</tr>";
				$ctr++;

			endforeach;
		}
		
		?>
		
	  </tbody>
	</table>
	<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
		<a class="paginate_button previous disabled btn btn-sm" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="-1" id="DataTables_Table_0_previous">Previous</a>
		<span>
			<a class="paginate_button current btn btn-sm" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a>
		</span>
		<a class="paginate_button next btn btn-sm" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" id="DataTables_Table_0_next">Next</a>
	</div>
	</div>
  </div>
</div>
</div>

<script>
$(document).ready(function() {
    $('.table').DataTable( {
        "searching": true,
		"bLengthChange": false,
		"info": false,
		"drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    } );
	
} );
</script>
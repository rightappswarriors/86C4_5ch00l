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
	
	
	
	<table class="table">
	  <thead>
		<tr>
		  <th width="5%">#</th>	
		  <th width="45%">Name</th>
		  <th width="10%">Able for PT?</th>
		  <th width="20%">Level</th>
		  <th width="15%">Status</th>
		  <th width="5%">Action</th>
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
				echo "<tr>";
				echo "<td>$ctr</td>";
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

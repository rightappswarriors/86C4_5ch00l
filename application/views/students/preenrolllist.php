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
	
	<h3 class="heading" style="text-align:center;">Pre-enrolled Student Applications</h3>
	
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
				//$newold = $row->newold=="old"?"":"&nbsp;<code>".$row->newold."</code>";
				echo "<tr>";
				echo "<td>$ctr</td>";
				echo "<td><a href='".site_url("students/details/".$row->id)."'>".$row->firstname." ".$row->lastname."</a></td>";
				//echo "<td>".$row->studentno."</td>";
				echo "<td>".$row->gradelevel."</td>";
				echo "<td class='text-danger'><mark><code></code></mark></td>";
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

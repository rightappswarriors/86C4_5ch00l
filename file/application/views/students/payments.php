<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
?>

<?php $this->load->view("students/menu",$data) ?>

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
	 
		<h3 class="heading" style="text-align:center;">Payments</h3>
		
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th>Payment ID</th>
				<th>Date</th>
				<th>Paid</th>
				<th>Amount</th>
				<th>Action</th>
			  </tr>
			</thead>
			<tbody>
			  
			  
			</tbody>
			
		  </table>
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
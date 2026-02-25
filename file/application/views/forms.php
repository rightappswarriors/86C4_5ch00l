<div class="col-md-12 grid-margin">
	<div class="card">
	  <div class="card-body">
		
		<h3 class="heading" style="text-align:center;">Forms</h3>
		
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
			<a href="#" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-plus'></i></a>
			</div>
		</div>
		
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th>#</th>
				<th>File</th>
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
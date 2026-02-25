<div class="col-md-12 grid-margin">
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
		
		<h3 class="heading" style="text-align:center;">System Users</h3>
	
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="5%">#</th>
				<th width="30%">User</th>
				<th width="40%">Name</th>
				<th width="20%">Type</th>
				<th width="5%">Action</th>
			  </tr>
			</thead>
			<tbody>
			
			<?php

			if($query->num_rows() > 0)
			{
				$ctr=1;
				foreach($query->result() as $row):
					
					echo "<tr>
						<td>".$ctr."</td>
						<td>".$row->mobileno."</td>
						<td><a href='".site_url("users/updateuser/".$row->id)."'>".$row->lastname .", ". $row->firstname ."</a></td>
						<td>".$row->usertype."</td>
						<td><a href='".site_url("users/updateuser/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-pencil'></i></a>&nbsp;<button type='button' class='btn btn-icons btn-secondary btn-rounded' data-toggle='modal' data-target='#modalDelete".$row->id."'><i class='mdi mdi-delete'></i></button></td>
					</tr>";
					
					$ctr++;
				?>
				
				<!-- for modal -->
				<div class="modal fade" id="modalDelete<?=$row->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
				aria-hidden="true" data-backdrop="true">
				  <div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
					<!--Content-->
					<div class="modal-content">
					  <!--Body-->
					  <div class="modal-body">
					  
					  <div class="card" style="border:0;">
						  <div class="card-body">
							
							<h4 class="card-title">Are you sure you want to proceed?</h4>
							<div class="row">
								
							</div>
					  
					  <div class="row">
						<a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>&nbsp;
						<a href="<?=site_url("users/remove_user/".$row->id)?>" class="btn btn-danger">Yes Continue!</a>
					  </div>
					  
					  </div>
					  </div>
					  
					  </div>
					</div>
				  </div>
				</div>
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
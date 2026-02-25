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
		
		<h3 class="heading" style="text-align:center;">Payments</h3>
	
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="5%">ID</th>
				<th width="15%">Date</th>
				<th width="40%">Student</th>
				<th width="10%">Paid</th>
				<th width="25%">Amount</th>
				<th width="5%">Action</th>
			  </tr>
			</thead>
			<tbody>
			
			<?php

			if($query_payments->num_rows() > 0)
			{
				$ctr=1;
				foreach($query_payments->result() as $row):
					
					//$pnote = strlen($row->payment_note)>30 ? substr($row->payment_note,0,30)."...":$row->payment_note;
					
					echo "<tr>";
					echo "<td>".$row->payment_code."</td>";
					echo "<td>".date("m/d/y",strtotime($row->payment_date))."</td>";
					echo "<td><a href='".site_url("students/details/".$row->student_id)."'>".$row->lastname.", ".$row->firstname."</a></td>";
					echo "<td style='text-align:center'><code>".strtoupper($row->paid)."</code></td>";
					echo "<td style='text-align:center'>".number_format($row->payment_total,2)."</td>";
					echo "<td>";
					
					if($this->session->userdata('current_usertype') != 'Parent'):
						echo "<a href='".site_url("payments/update_payment/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-pencil'></i></a>&nbsp;<button type='button' class='btn btn-icons btn-secondary btn-rounded' data-toggle='modal' data-target='#modalDelete".$row->id."'><i class='mdi mdi-delete'></i></button>";
					else:
						echo "<a href='".site_url("payments/update_payment/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-file-document'></i></a>";
						echo "<a href='".site_url("payments/update_payment/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-file-upload'></i></a>";
					endif;
					
					echo "</td></tr>";
					
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
							<a href="<?=site_url("payments/remove_payments/".$row->id."/".$row->student_id)?>" class="btn btn-danger">Yes Continue!</a>
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
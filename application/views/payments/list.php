<style>
.payments-header {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.payments-table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}
.payments-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.payments-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}
.payments-table tbody tr {
    transition: background 0.2s;
}
.payments-table tbody tr:hover {
    background: #f8f9fa;
}
.paid-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}
.paid-yes { background: #28a745; color: white; }
.paid-no { background: #dc3545; color: white; }
.pending-no { background: #ffc107; color: #333; }
.action-buttons .btn {
    margin: 2px;
    padding: 5px 10px;
}
</style>
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
		
		<h3 class="heading payments-header" style="text-align:center;"><i class='mdi mdi-credit-card'></i> Payments</h3>
	
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="5%">#</th>
				<th width="10%">Inv #</th>
				<th width="15%">Date</th>
				<th width="30%">Student</th>
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
					echo "<td>".$row->invoice_number."</td>";
					echo "<td>".date("m/d/y",strtotime($row->payment_date))."</td>";
					echo "<td><a href='".site_url("students/details/".$row->student_id)."'>".$row->lastname.", ".$row->firstname."</a></td>";
					//echo "<td><a href='#' data-toggle='modal' data-target='#modalstudent".$row->id."'>".$row->firstname." ".$row->lastname."</a></td>";
					echo "<td style='text-align:center'><code>".strtoupper($row->paid)."</code></td>";
					echo "<td style='text-align:center'>".number_format($row->payment_total,2)."</td>";
					echo "<td>";
					
					if($this->session->userdata('current_usertype') != 'Parent'):
						echo "<a href='".site_url("payments/print_payment/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-printer'></i></a>&nbsp;<a href='".site_url("payments/update_payment/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-pencil'></i></a>&nbsp;<button type='button' class='btn btn-icons btn-secondary btn-rounded' data-toggle='modal' data-target='#modalDelete".$row->id."'><i class='mdi mdi-delete'></i></button>";
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
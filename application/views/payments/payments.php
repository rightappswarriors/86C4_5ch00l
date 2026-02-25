<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	$studentid = $row->id;
?>

<?php $this->load->view("students/menu",$data) ?>

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
	 
		<h3 class="heading" style="text-align:center;">Payments</h3>
		
		<div class="table-responsive">
		  <table class="table table-striped table-hover">
			<thead>
			  <tr>
				<th width="10%">#</th>
				<th width="10%">Inv #</th>
				<th width="15%">Date</th>
				<th width="25%">Note</th>
				<th width="15%">Paid</th>
				<th width="15%">Amount</th>
				<th width="10%" style='text-align:center'>Action</th>
			  </tr>
			</thead>
			<tbody>
			
			<?php

			if($query_payments->num_rows() > 0)
			{
				$ctr=1;
				foreach($query_payments->result() as $row):
					
					$pnote = strlen($row->payment_note)>30 ? substr($row->payment_note,0,30)."...":$row->payment_note;
					
					$payment_file="";
					if(strlen(trim($row->deposit_file))>0){
						$path_file = './file_upload/payments/'.$row->id;
						$payment_file = "<a href='../../../".$path_file."/".$row->deposit_file."' class='btn btn-icons btn-rounded btn-success'><i class='mdi mdi-attachment'></i></a>";
					}
					
					echo "<tr>";
					echo "<td>".$row->payment_code." ".$payment_file."</td>";
					echo "<td>".$row->invoice_number."</td>";
					echo "<td>".date("m/d/y",strtotime($row->payment_date))."</td>";
					echo "<td>".$pnote."</td>";
					echo "<td style='text-align:center'><code>".strtoupper($row->paid)."</code></td>";
					echo "<td style='text-align:center'>".number_format($row->payment_total,2)."</td>";
					echo "<td>";
					
					if($this->session->userdata('current_usertype') != 'Parent'):
						if($this->session->userdata('current_usertype') != 'Admin'):
						echo "<a href='".site_url("payments/update_payment/".$row->id)."' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-pencil'></i></a>&nbsp;<button type='button' class='btn btn-icons btn-secondary btn-rounded' data-toggle='modal' data-target='#modalDelete".$row->id."'><i class='mdi mdi-delete'></i></button>";
						endif;
					else:
						echo "<a href='".site_url("payments/update_payment/".$row->id)."' title='Show Payment Details' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-file-document'></i></a>&nbsp;<button title='Upload Receipt/Deposit Slip' type='button' class='btn btn-icons btn-secondary btn-rounded' data-toggle='modal' data-target='#modalUpload".$row->id."'><i class='mdi mdi-file-upload'></i></a>";
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
							<a href="<?=site_url("payments/remove_payment/".$row->id."/".$studentid)?>" class="btn btn-danger">Yes Continue!</a>
						  </div>
						  
						  </div>
						  </div>
						  
						  </div>
						</div>
					  </div>
					</div>
					
					<div class="modal fade" id="modalUpload<?=$row->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
					aria-hidden="true" data-backdrop="true">
					  <div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
						<!--Content-->
						<div class="modal-content">
						  <!--Body-->
						  <div class="modal-body">
						  
						  <?= form_open_multipart("payments/deposit_file/".$row->id."/".$studentid) ?>
						  
							  <div class="card" style="border:0;">
								  <div class="card-body">
									
									<h4 class="card-title">Upload File (Payment/Deposit Receipt)</h4>
									<div class="row">
										<input type="file" name="deposit_file">
									</div>
									<br><br>
							  
							  <div class="row">
								<a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>&nbsp;
								<input type="submit" class="btn btn-secondary" value="Upload Receipt"> 
							  </div>
							  
							  </div>
							  </div>
						  
						  </form>
						  
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
        "searching": false,
		"bLengthChange": false,
		"info": false,
		"drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    } );
	
} );
</script> 
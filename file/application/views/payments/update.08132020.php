<?php 

	$row = $query->row(); 
	$data = array( 'row'  => $row );
		
	$row_as = $query_ass->row();
	$def_assessment = $default_ass->row();
	
	$indntals_x = explode(",",$def_assessment->incidentals);
	$msclns_x = explode(",",$def_assessment->miscellaneous);

	$tuition = $def_assessment->tuition;
	$registration = $def_assessment->registration;

	$indntals = explode(",",$row_as->incidentals);
	$msclns = explode(",",$row_as->miscellaneous);
	
	// MASTER
	$row_master = $payment_master->row();
	
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
		
		<h3 class="heading" style="text-align:center;">Update Payment</h3>
		
		<hr>
		<form action="<?=site_url("payments/update_submit/".$row_master->id)?>" method="post">
		
		<div class="row">
			<div class="col-md-4" style="text-align:left;">
			<?php if($this->session->userdata('current_usertype') == 'Accounting'): ?>
			<a href="#" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-printer'></i></a>
			<a href="#" data-toggle='modal' data-target='#modalAddItem' class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-plus'></i></a><br><?php endif; ?>
			</div>
			<div class="col-md-4" style="text-align:left;">
			<div class="form-group row">
					<label class="col-sm-3 col-form-label">Pay #</label>
					<div class="col-sm-9"><input type="text" class="form-control" value="<?=$row_master->payment_code?>" disabled></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Date</label>
					<div class="col-sm-9">
					<input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="payment_date" value="<?=date("Y-m-d",strtotime($row_master->payment_date))?>" placeholder="dd/mm/yyyy" />
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				
				<div class="table-responsive">
				  <table class="table table-striped table-hover">
					<thead>
					  <tr>
						<th width="35%">Item</th>
						<th width="20%">Qty</th>
						<th width="20%">Charge</th>
						<th width="20%">Amount</th>
						<th width="5%"></th>
					  </tr>
					</thead>
					<tbody>
					
					<?php 
					
					$counter = 1;
					foreach($payment_details->result() as $ind=>$row_details):
						
						$type_ = $row_details->type_item;
						$type_x = $row_details->type_item."_x";
						
						$item_type = $row_details->type_item;
						
						if($item_type == "indntals" || $item_type == "msclns"){
							
							$index_ = $row_details->id_item;
							$item_name = $$type_x[ $index_ ];
							$item_price = $row_details->price_item;
							$item_qty = $row_details->qty_item;
							
						}elseif($item_type == "tui_"){
							
							$index_ = "9991";
							$item_name = "Tuition";
							$item_price = $row_details->price_item;
							$item_qty = $row_details->qty_item;
							
						}else{
							
							$index_ = "9990";
							$item_name = "Registration";
							$item_price = $row_details->price_item;
							$item_qty = $row_details->qty_item;
							
						}
						
						$item_amount = $item_price*$item_qty;
						
						echo "<tr><td>".$item_name."<input type='hidden' value='".$index_."' name='id_item[]'><input type='hidden' value='".$item_type."' name='type_item[]'></td><td><input type='text' id='qty_".$index_."_".$counter."' name='qty_item[]' value='".$item_qty."' class='pitem'></td><td><input type='text' id='price_".$index_."_".$counter."' name='price_item[]' value='".$item_price."' class='pitem'></td><td><input type='text' id='amount_".$index_."_".$counter."' name='amount[]' class='item_amount' value='".$item_amount."' disabled></td><td>";
						
						if($this->session->userdata('current_usertype') == 'Accounting'):
							echo "<a href='#' class='btn btndelrow btn-icons btn-rounded btn-secondary'><i class='mdi mdi-delete'></i></a></td></tr>";
						endif; 
						
						$counter++;
						
					endforeach; ?>
					
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right">TOTAL AMOUNT (Php)</td>
							<td colspan="2" style="text-align:left" id="ttamount"><?=number_format($row_master->payment_total,2)?></td>
						</tr>
						<tr style="border:0;">
							<td colspan="3" style="text-align:right;border:0;">VAT (12%)</td>
							<td colspan="2" style="text-align:left;border:0;" id="vatamount"><?=number_format(($row_master->payment_total*.12),2)?></td>
						</tr><tr style="border:0;">
							<td colspan="3" style="text-align:right;border:0;">Paid?</td>
							<td colspan="2" style="text-align:left;border:0;" id="vatamount">
							<?php
								$options = array('no' => 'No', 'yes' => 'Yes');
								$batch = set_value('paid',$row_master->paid);
								echo form_dropdown('paid', $options, $batch,' class="form-control"');
							  ?>
							</td>
						</tr>
					</tfoot>
				  </table>
				  <input type="hidden" name="payment_total" id="payment_total" value="<?=$row_master->payment_total?>">
				</div>
				<hr>
			</div>
			
			
			
			<div class="col-md-8" style="text-align:left;margin-top:10px;">
				<div class="form-group row">
				<label class="col-sm-4 col-form-label">Additional Note:</label>
				<div class="col-sm-8">
				  <textarea style="width:100%" name="payment_note"><?=$row_master->payment_note?></textarea>
				</div>
			  </div>
			</div>
			<?php 
			if($this->session->userdata('current_usertype') == 'Accounting'):
			?>
			<div class="col-md-4" style="text-align:right;margin-top:10px;">
				<input type="submit" value="Update Payment" class="btn btn-lg btn-primary">
			</div>
			<?php endif; ?>
		</div>
		
		</form>
		
	  </div>
	</div> 
	
</div>

<div class="modal fade" id="modalAddItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
				aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
	<!--Content-->
	<div class="modal-content">
	  <!--Body-->
	  <div class="modal-body">
	  
	  <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
				  
                   <form action="<?=site_url("payments/create_submit/".$row->id)?>" method="post">
                      <div class="row">
					  
                        <div class="col-md-6">
						<p class="text-info">Incidentals</p>
                          <div class="form-group">
						  
							<?php
							foreach($indntals_x as $ind => $v_indntals_x):
								?><button type="button" style="margin:2px 0;text-align:left;" id="indntals_<?=$ind?>" class="btnadditem btn btn-secondary"> <?=$v_indntals_x?>(<?=number_format($indntals[$ind])?>)</button>
								<?php
							endforeach;
							?>
						  
                          </div>
                        </div>
						
                        <div class="col-md-6">
                          <p class="text-info">Miscellaneous</p>
						   <div class="form-group">
						   
						   <?php
							foreach($msclns_x as $ind => $v_msclns_x):
								?><button type="button" style="margin:2px 0;text-align:left;" id="msclns_<?=$ind?>" class="btnadditem btn btn-secondary"> <?=$v_msclns_x?>(<?=number_format($msclns[$ind])?>)</button>
								<?php
							endforeach;
							?>
							
						   <hr>	
						   <button type="button" style="margin:2px 0;text-align:left;" ref="tui_" class="btnadditem_ btn btn-secondary"> Tuition(<?=number_format( $tuition/10 )?>)</button>
							
							<button type="button" style="margin:2px 0;text-align:left;" ref="reg_" class="btnadditem_ btn btn-secondary"> Registration(<?=number_format( $registration )?>)</button>
							
						   </div>
                        </div>
						
                      </div>
                    </form>
					
                  </div>
                </div>
              </div>
				<div class="row">
				<div class="col-md-12" style="text-align:center;">
				<a href="#" class="btn btn-lg btn-secondary" data-dismiss="modal">Close Add Item</a>
				</div>
				</div>
	  </div>
	</div>
  </div>
</div>	

<script>
$(document).ready(function() {
	
	var itemCount = <?=$counter?>;
	
    var t = $('.table').DataTable( {
        "searching": false,
		"bLengthChange": false,
		"info": false,
		"bSort": false,
		"paging": false,
		"drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    } );
	
	<?php 
	if($this->session->userdata('current_usertype') == 'Parent'):
	?>
	$("input, textarea, select").attr("disabled",true);
	<?php
	endif;
   ?>
	
	$(".btnadditem").click(function(){
		
		// add new row...
		var item_id = $(this).attr("id");
		var items = item_id.split("_");
		var index_ = items[1];
		var item_ = items[0];
		
		<?php echo 'var indntals = '.json_encode($indntals).';'; ?>
		
		<?php echo 'var indntals_x = '.json_encode($indntals_x).';'; ?>
		
		<?php echo 'var msclns = '.json_encode($msclns).';'; ?>
		
		<?php echo 'var msclns_x = '.json_encode($msclns_x).';'; ?>
		
		var item_selcted;
		var item_price;
		if(item_ == "indntals"){
			item_selcted = indntals_x[index_];
			item_price = indntals[index_];
		}else{
			item_selcted = msclns_x[index_];
			item_price = msclns[index_];
		}
		
		var markup = "<tr><td>"+ item_selcted +"<input type='hidden' value='"+index_+"' name='id_item[]'><input type='hidden' value='"+item_+"' name='type_item[]'></td><td><input type='text' id='qty_"+index_+"_"+itemCount+"' name='qty_item[]' value='1' class='pitem'></td><td><input type='text' id='price_"+index_+"_"+itemCount+"' name='price_item[]' value='"+ item_price +"' class='pitem'></td><td><input type='text' id='amount_"+index_+"_"+itemCount+"' name='amount[]' class='item_amount' value='"+item_price+"' disabled></td><td><a href='#' class='btn btndelrow btn-icons btn-rounded btn-secondary'><i class='mdi mdi-delete'></i></a></td></tr>";
            $(".table tbody").append(markup);	

		itemCount++;
		compute_total();

	});
	
	$(".btnadditem_").click(function(){
		
		// remove default td...
		//$(".odd").remove();
		var slctd = $(this).attr("ref");
		var item_selcted;
		var item_price;
		var index_;
		
		<?php echo 'var reg_ = '.$registration.';'; ?>
		<?php echo 'var tui_ = '.($tuition/10).';'; ?>
		
		if(slctd == "reg_"){
			item_selcted = "Registration";
			index_ = "9990";
			item_price = reg_;
		}else{
			item_selcted = "Tuition";
			item_price = tui_;
			index_ = "9991";
		}
		
		var markup = "<tr><td>"+ item_selcted +"<input type='hidden' value='"+index_+"' name='id_item[]'><input type='hidden' value='"+slctd+"' name='type_item[]'></td><td><input type='text' id='qty_"+index_+"_"+itemCount+"' name='qty_item[]' value='1' class='pitem'></td><td><input type='text' id='price_"+index_+"_"+itemCount+"' name='price_item[]' value='"+ item_price +"' class='pitem'></td><td><input type='text' id='amount_"+index_+"_"+itemCount+"' name='amount[]' class='item_amount' value='"+item_price+"' disabled></td><td><a href='#' class='btn btndelrow btn-icons btn-rounded btn-secondary'><i class='mdi mdi-delete'></i></a></td></tr>";
            $(".table tbody").append(markup);	

		itemCount++;
		compute_total();

	});
	
	$(".table").on("keypress","input",function(){
       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault(); //stop character from entering input
       }
		
   });
	
	$(".table").on("click",".btndelrow",function(){
		
		$(this).closest("tr").remove();
		compute_total();
		return false;
		
	});
	
	$(".table").on("keyup","input",function(){
		
		var item_id = $(this).attr("id");
		var items = item_id.split("_");
		var index_ = items[1];
		var ctr_ = items[2];
		var amount = Number( $("#qty_"+index_+"_"+ctr_).val() ) * Number( $("#price_"+index_+"_"+ctr_).val() );
		$("#amount_"+index_+"_"+ctr_).val( amount );
		compute_total();
		
	});
	
	function compute_total(){
		
		var sum = 0;
		$(".item_amount").each(function(){
			sum += Number($(this).val());
		});
		
		$("#ttamount").html( humanizeNumber( sum.toFixed(2) ) );
		$("#payment_total").val( sum );
		
		var vat = (sum*.12);
		$("#vatamount").html( humanizeNumber( vat.toFixed(2) ) );
		
	}
	
} );


function humanizeNumber(n) {
  n = n.toString()
  while (true) {
    var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
    if (n == n2) break
    n = n2
  }
  return n
}

</script> 
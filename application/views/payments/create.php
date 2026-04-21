<?php

$row = $query->row();
$data = array('row' => $row);

$has_assessment = $query_ass->num_rows() > 0;
$incidentals = array();
$miscellaneous = array();
$incidental_labels = array();
$miscellaneous_labels = array();
$tuition = 0;
$registration = 0;
$payment_enroll = 0;

if ($has_assessment):
	$row_as = $query_ass->row();
	$def_assessment = $default_ass->row();

	$incidental_labels = explode(",", $def_assessment->incidentals);
	$miscellaneous_labels = explode(",", $def_assessment->miscellaneous);
	$incidentals = explode(",", $row_as->incidentals);
	$miscellaneous = explode(",", $row_as->miscellaneous);

	$tuition = $def_assessment->tuition;
	$registration = $def_assessment->registration;
	$payment_enroll = $def_assessment->payment_enroll;
endif;
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/payments_create.css">

<?php $this->load->view("students/menu", $data) ?>

<div class="col-lg-12 grid-margin stretch-card payment-create-page">
	<div class="card payment-create-card">
		<div class="card-body payment-create-card-body">
			<div class="payment-create-header">
				<h3 class="payment-create-title">Create Payment</h3>
				<p class="payment-create-subtitle">Prepare a payment entry, review the total, and save when ready.</p>
			</div>

			<?php if ($has_assessment): ?>
			<form action="<?=site_url("payments/create_submit/" . $row->id)?>" method="post" class="payment-create-form">
				<div class="payment-create-top-label">
					<div class="payment-add-item-heading">
						<h4 class="payment-inline-title">Add payment</h4>
						<p class="payment-inline-subtitle">Select a charge below and it will appear in the payment items table.</p>
					</div>
				</div>

				<div class="payment-charge-panel">
					<div class="row">
						<div class="col-md-6">
							<div class="payment-modal-section payment-inline-section">
								<p class="payment-modal-section-title">Incidentals</p>
								<div class="payment-item-button-list">
									<?php foreach ($incidental_labels as $index => $label): ?>
										<?php if ((float) $incidentals[$index] > 0): ?>
											<button type="button" id="indntals_<?=$index?>" class="btnadditem btn btn-secondary payment-item-button">
												<?=$label?> (<?=number_format($incidentals[$index], 2)?>)
											</button>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="payment-modal-section payment-inline-section">
								<p class="payment-modal-section-title">Miscellaneous</p>
								<div class="payment-item-button-list">
									<?php foreach ($miscellaneous_labels as $index => $label): ?>
										<?php if ((float) $miscellaneous[$index] > 0): ?>
											<button type="button" id="msclns_<?=$index?>" class="btnadditem btn btn-secondary payment-item-button">
												<?=$label?> (<?=number_format($miscellaneous[$index], 2)?>)
											</button>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="payment-modal-section payment-inline-section payment-core-section">
						<p class="payment-modal-section-title">Core Charges</p>
						<div class="payment-item-button-list">
							<button type="button" ref="tui_" class="btnadditem_ btn btn-secondary payment-item-button">Tuition (<?=number_format($tuition / 10, 2)?>)</button>
							<button type="button" ref="reg_" class="btnadditem_ btn btn-secondary payment-item-button">Registration (<?=number_format($registration, 2)?>)</button>
							<button type="button" ref="pay_" class="btnadditem_ btn btn-secondary payment-item-button">Enrollment (<?=number_format($payment_enroll, 2)?>)</button>
						</div>
					</div>
				</div>

				<div class="row payment-create-top">
					<div class="col-md-6">
						<div class="form-group row payment-form-row">
							<label class="col-sm-3 col-form-label">Pay #</label>
							<div class="col-sm-9">
								<input type="text" class="form-control payment-readonly-field" value="" placeholder="Auto" disabled>
							</div>
						</div>

						<div class="form-group row payment-form-row">
							<label class="col-sm-3 col-form-label">Inv. #</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="invoice_number" value="" placeholder="Invoice Number">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group row payment-form-row">
							<label class="col-sm-3 col-form-label">Date</label>
							<div class="col-sm-9">
								<input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="payment_date" value="<?=date("Y-m-d")?>" placeholder="dd/mm/yyyy">
							</div>
						</div>

						<div class="form-group row payment-form-row">
							<label class="col-sm-3 col-form-label">For enroll?</label>
							<div class="col-sm-9">
								<?php
								$options = array('no' => 'No', 'yes' => 'Yes');
								$selected_enroll_option = set_value('enrollpay', 'no');
								echo form_dropdown('enrollpay', $options, $selected_enroll_option, 'class="form-control"');
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="payment-table-panel">
					<div class="payment-table-header">
						<div>
							<h4 class="payment-section-title">Payment Items</h4>
							<p class="payment-section-subtitle">Add assessment charges, then adjust quantity or price if needed.</p>
						</div>	
					</div>

					<div class="table-responsive payment-table-wrap">
						<table class="table table-striped table-hover payment-table">
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
							</tbody>
							<tfoot>
								<tr class="payment-total-row">
									<td colspan="3" class="payment-total-label">TOTAL AMOUNT (Php)</td>
									<td colspan="2" class="payment-total-value" id="ttamount">0.00</td>
								</tr>
								<tr class="payment-vat-row">
									<td colspan="3" class="payment-total-label payment-vat-label">VAT (12%)</td>
									<td colspan="2" class="payment-total-value payment-vat-value" id="vatamount">0.00</td>
								</tr>
							</tfoot>
						</table>
						<input type="hidden" name="payment_total" id="payment_total">
					</div>
				</div>

				<div class="row payment-create-footer">
					<div class="col-md-8">
						<div class="form-group row payment-note-row">
							<label class="col-sm-4 col-form-label">Additional Note:</label>
							<div class="col-sm-8">
								<textarea name="payment_note" class="payment-note-field"></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-4 payment-submit-col">
						<input type="submit" value="Create Payment" class="btn btn-lg btn-primary payment-submit-btn">
					</div>
				</div>
			</form>
			<?php else: ?>
			<div class="alert alert-warning payment-alert">
				No Financial Assessment!
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php if ($has_assessment): ?>
<script>
$(document).ready(function() {
	var itemCount = 1;

	var table = $('.payment-table').DataTable({
		"searching": false,
		"bLengthChange": false,
		"info": false,
		"bSort": false,
		"paging": false,
		"drawCallback": function() {
			$('a.paginate_button').addClass("btn btn-sm");
		}
	});

	$(".btnadditem").click(function() {
		$(".odd").remove();
		$(this).addClass("payment-item-button-selected");

		var itemId = $(this).attr("id");
		var itemParts = itemId.split("_");
		var itemIndex = itemParts[1];
		var itemType = itemParts[0];

		<?='var incidentals = ' . json_encode($incidentals) . ';';?>
		<?='var incidentalLabels = ' . json_encode($incidental_labels) . ';';?>
		<?='var miscellaneous = ' . json_encode($miscellaneous) . ';';?>
		<?='var miscellaneousLabels = ' . json_encode($miscellaneous_labels) . ';';?>

		var selectedItem;
		var selectedPrice;

		if (itemType == "indntals") {
			selectedItem = incidentalLabels[itemIndex];
			selectedPrice = incidentals[itemIndex];
		} else {
			selectedItem = miscellaneousLabels[itemIndex];
			selectedPrice = miscellaneous[itemIndex];
		}

		var markup = "<tr><td>" + selectedItem + "<input type='hidden' value='" + itemIndex + "' name='id_item[]'><input type='hidden' value='" + itemType + "' name='type_item[]'></td><td><input type='text' id='qty_" + itemIndex + "_" + itemCount + "' name='qty_item[]' value='1' class='pitem form-control'></td><td><input type='text' id='price_" + itemIndex + "_" + itemCount + "' name='price_item[]' value='" + selectedPrice + "' class='pitem form-control'></td><td><input type='text' id='amount_" + itemIndex + "_" + itemCount + "' name='amount[]' class='item_amount form-control' value='" + selectedPrice + "' disabled></td><td><a href='#' class='btn btndelrow btn-icons btn-rounded btn-secondary payment-delete-row-btn'><i class='mdi mdi-delete'></i></a></td></tr>";
		$(".payment-table tbody").append(markup);

		itemCount++;
		computeTotal();
	});

	$(".btnadditem_").click(function() {
		$(".odd").remove();
		$(this).addClass("payment-item-button-selected");

		var selectedReference = $(this).attr("ref");
		var selectedItem;
		var selectedPrice;
		var itemIndex;

		<?='var registrationValue = ' . $registration . ';';?>
		<?='var tuitionValue = ' . ($tuition / 10) . ';';?>
		<?='var paymentEnrollValue = ' . $payment_enroll . ';';?>

		if (selectedReference == "reg_") {
			selectedItem = "Registration";
			itemIndex = "9990";
			selectedPrice = registrationValue;
		} else if (selectedReference == "tui_") {
			selectedItem = "Tuition";
			itemIndex = "9991";
			selectedPrice = tuitionValue;
		} else {
			selectedItem = "Enrollment";
			itemIndex = "9992";
			selectedPrice = paymentEnrollValue;
		}

		var markup = "<tr><td>" + selectedItem + "<input type='hidden' value='" + itemIndex + "' name='id_item[]'><input type='hidden' value='" + selectedReference + "' name='type_item[]'></td><td><input type='text' id='qty_" + itemIndex + "_" + itemCount + "' name='qty_item[]' value='1' class='pitem form-control'></td><td><input type='text' id='price_" + itemIndex + "_" + itemCount + "' name='price_item[]' value='" + selectedPrice + "' class='pitem form-control'></td><td><input type='text' id='amount_" + itemIndex + "_" + itemCount + "' name='amount[]' class='item_amount form-control' value='" + selectedPrice + "' disabled></td><td><a href='#' class='btn btndelrow btn-icons btn-rounded btn-secondary payment-delete-row-btn'><i class='mdi mdi-delete'></i></a></td></tr>";
		$(".payment-table tbody").append(markup);

		itemCount++;
		computeTotal();
	});

	$(".payment-table").on("keypress", "input", function() {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			if (event.keyCode !== 8 && event.keyCode !== 46) {
				event.preventDefault();
			}
		}

		if (($(this).val().indexOf('.') != -1) && ($(this).val().substring($(this).val().indexOf('.'), $(this).val().indexOf('.').length).length > 2)) {
			if (event.keyCode !== 8 && event.keyCode !== 46) {
				event.preventDefault();
			}
		}
	});

	$(".payment-table").on("click", ".btndelrow", function() {
		var row = $(this).closest("tr");
		var itemIndex = row.find("input[name='id_item[]']").val();
		var itemType = row.find("input[name='type_item[]']").val();

		row.remove();
		syncSelectedButton(itemType, itemIndex);
		computeTotal();
		return false;
	});

	$(".payment-table").on("keyup", "input", function() {
		var itemId = $(this).attr("id");
		var itemParts = itemId.split("_");
		var itemIndex = itemParts[1];
		var counter = itemParts[2];
		var amount = Number($("#qty_" + itemIndex + "_" + counter).val()) * Number($("#price_" + itemIndex + "_" + counter).val());

		$("#amount_" + itemIndex + "_" + counter).val(amount);
		computeTotal();
	});

	function computeTotal() {
		var sum = 0;

		$(".item_amount").each(function() {
			sum += Number($(this).val());
		});

		var formattedTotal = humanizeNumber(sum.toFixed(2));
		var formattedVat = humanizeNumber((sum * .12).toFixed(2));

		$("#ttamount").html(formattedTotal);
		$("#summary_total").html("Php " + formattedTotal);
		$("#payment_total").val(sum);
		$("#vatamount").html(formattedVat);
	}

	function syncSelectedButton(itemType, itemIndex) {
		var hasRemainingRow = false;

		$(".payment-table tbody tr").each(function() {
			var rowItemIndex = $(this).find("input[name='id_item[]']").val();
			var rowItemType = $(this).find("input[name='type_item[]']").val();

			if (rowItemIndex === itemIndex && rowItemType === itemType) {
				hasRemainingRow = true;
				return false;
			}
		});

		if (hasRemainingRow) {
			return;
		}

		if (itemType === "indntals" || itemType === "msclns") {
			$("#" + itemType + "_" + itemIndex).removeClass("payment-item-button-selected");
			return;
		}

		$(".btnadditem_[ref='" + itemType + "']").removeClass("payment-item-button-selected");
	}
});

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
<?php endif; ?>

<?php
$row = $query->row();
$studentid = $row->id;
$data = array('row' => $row);

$def_assessment = $default_ass->row();
if (!$def_assessment) {
    echo '<div class="alert alert-danger">School year data not found. Please contact the administrator.</div>';
    return;
}

$indntals_list = explode(",", $def_assessment->incidentals);
$msclns_list   = explode(",", $def_assessment->miscellaneous);

$grade_band = function ($gradelevel) {
    $value = strtoupper(trim((string) $gradelevel));
    if ($value === '') return 'G4-10';
    if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*(?:10|11|12|[4-9])\b/i', $value)) return 'G4-10';
    if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*[1-3]\b/i', $value)) return 'RR-G3';

    $tokens = preg_split('/[^A-Z0-9]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
    if (in_array('RR', $tokens, true) || in_array('ABCS', $tokens, true) || in_array('K1', $tokens, true) || in_array('K2', $tokens, true)) return 'RR-G3';
    if (preg_match('/\b(10|11|12|[4-9])\b/', $value)) return 'G4-10';
    if (preg_match('/(?:GRADE|LEVEL)?\s*-?\s*(\d{1,2})/i', $value, $match)) return ((int) $match[1] <= 3) ? 'RR-G3' : 'G4-10';
    return 'G4-10';
};

$g4_10_incidentals = array(
    'PACEs', 'TLE', 'HELE', 'MAPEH', 'Parent Orientation', 'Handbook',
    'Goal/Progress Chart Cover', 'Flags', 'ID', 'Notebook', 'Closing Fee',
    "Fetcher's ID", "Founder's Day", 'Graduation Fee', 'Congress Fee',
    'Late Fee', 'CEM'
);

// ASSESSMENT
if ($query_ass->num_rows() > 0) {
    $row_as = $query_ass->row();
    $as_id = $row_as->id;

    $indntals = explode(",", $row_as->incidentals);
    $msclns   = explode(",", $row_as->miscellaneous);

    $tuition        = $row_as->tuition;
    $registration   = $row_as->registration;
    $paymentenroll  = $row_as->payment;

    $total_msclns   = array_sum($msclns);
    $total_indntals = array_sum($indntals);
    $total_ass      = $total_msclns + $total_indntals + $registration + $tuition;

    $balance          = $total_ass - $paymentenroll;
    $monthly          = $balance / 9;

    $math       = explode(",", $row_as->math);
    $eng        = explode(",", $row_as->english);
    $science    = explode(",", $row_as->science);
    $sstudies   = explode(",", $row_as->socstudies);
    $wbuilding  = explode(",", $row_as->wordbuilding);
    $literature = explode(",", $row_as->literature);
    $filipino   = explode(",", $row_as->filipino);
    $ap         = explode(",", $row_as->ap);

    $promissory_payment = isset($row_as->promissory_payment) && is_numeric($row_as->promissory_payment)
        ? $row_as->promissory_payment : 0;
    $promissory_monthly = $promissory_payment;

} else {
    $indntals = explode(",", $def_assessment->incidentals_val);
    $msclns   = explode(",", $def_assessment->miscellaneous_val);

    $tuition        = $def_assessment->tuition;
    $registration   = $def_assessment->registration;
    $paymentenroll  = $def_assessment->payment_enroll;

    $total_msclns   = array_sum($msclns);
    $total_indntals = array_sum($indntals);
    $total_ass      = $total_msclns + $total_indntals + $registration + $tuition;

    $balance  = $total_ass - $paymentenroll;
    $monthly  = $balance / 9;

    $math = $eng = $science = $sstudies = $wbuilding = array("", "", "");
    $literature = $filipino = $ap = array("", "");

    $as_id = 0;
    $promissory_payment = 0;
    $promissory_monthly = 0;
}

$current_grade_band = $grade_band(isset($row->gradelevel) ? $row->gradelevel : '');
if ($current_grade_band === 'G4-10' && count($indntals_list) === count($g4_10_incidentals)) {
    $indntals_list = $g4_10_incidentals;
}
?>

<style>
    .assessment-total-box {
        border: 2px solid #48b8ff;
        padding: 10px 12px 8px;
        margin-top: 10px;
    }
    .assessment-total-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
        font-size: 12px;
    }
    .assessment-total-row:last-child {
        margin-bottom: 0;
    }
    .assessment-total-row label {
        width: 170px;
        margin: 0;
        font-weight: 700;
        color: #000;
    }
    .assessment-total-row.assessment-due-row label {
        color: #1298f6;
    }
    .assessment-total-input,
    .form-control {
        border: none !important;
        border-bottom: 1px solid #000 !important;
        border-radius: 0 !important;
        background: transparent !important;
        text-align: right;
        font-weight: 700;
        box-shadow: none !important;
        height: 25px !important;
        padding: 2px 0 !important;
    }
    .form-control:focus {
        outline: none !important;
        border-bottom: 2px solid #1298f6 !important;
        box-shadow: none !important;
    }
    .assessment-input-wrapper {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
    }
    .assessment-input-wrapper::before {
        content: "₱";
        position: absolute;
        left: 0;
        bottom: 5px;
        font-weight: 700;
        font-size: 13px;
        color: #000;
    }
    .assessment-due-row .assessment-input-wrapper::before {
        color: #1298f6;
    }
</style>

<script>
$(function () {
    $('input[type=text]').on('keyup blur', function (e) {
        compute_total();
    });

    // Typable friendly: Clear "0" on focus, restore on blur if empty
    $('input[type=text]').on('focus', function () {
        if ($(this).val() === "0") {
            $(this).val("");
        }
    }).on('blur', function () {
        if ($(this).val() === "") {
            $(this).val("0");
            compute_total();
        }
    });

    $('input[type=text]').keypress(function (e) {
        if (e.which != 8 && isNaN(String.fromCharCode(e.which))) e.preventDefault();
    });
    $("#chkconfirmed").click(function () {
        $("#btnstatus").attr("disabled", !this.checked);
    });
    $("#btnstatus").click(function () {
        window.location.href = '<?= site_url("students/changestatus/Interview/" . $row->id) ?>';
    });
    <?php if (in_array($this->session->userdata('current_usertype'), array('Parent', 'Admin'))): ?>
        $("input[type='text']").attr("disabled", true);
    <?php endif; ?>
});

function saveAndGoToPaces() {
    $.ajax({
        url: '<?= site_url("students/assessment/" . $row->id) ?>',
        type: 'POST',
        data: $('form').serialize(),
        success: function () {
            window.location.href = '<?= site_url("students/assessment_paces/" . $row->id) ?>';
        },
        error: function () {
            window.location.href = '<?= site_url("students/assessment_paces/" . $row->id) ?>';
        }
    });
}

function cleanNumber(val) {
    if (!val) return 0;
    return Number(val.toString().replace(/,/g, '')) || 0;
}

function compute_total() {
    var sum_indntals = 0, sum_msclns = 0;
    $("input[name^='indntals']").each(function () {
        sum_indntals += cleanNumber($(this).val());
    });
    $("input[name^='msclns']").each(function () {
        sum_msclns += cleanNumber($(this).val());
    });

    var tuition = cleanNumber($("#tuition").val()),
        registration = cleanNumber($("#registration").val());
    var asstotal = tuition + registration + sum_msclns + sum_indntals;
    var paymentenroll = cleanNumber($("#paymentenroll").val());
    var balance = asstotal - paymentenroll;
    var baseMonthly = balance / 9;
    var promissoryAmount = cleanNumber($("#promissory_payment").val());
    var totalAmount = baseMonthly + promissoryAmount;

    $("#totalinc").val(humanizeNumber(sum_indntals.toFixed(2)));
    $("#totalmisc").val(humanizeNumber(sum_msclns.toFixed(2)));
    $("#asstotal").val(humanizeNumber(asstotal.toFixed(2)));
    $("#asstotal_hidden").val(asstotal.toFixed(2));
    $("#balance").val(humanizeNumber(balance.toFixed(2)));
    $("#monthdue").val(humanizeNumber(totalAmount.toFixed(2)));
    $("#promissory_monthly").val(humanizeNumber(totalAmount.toFixed(2)));
}

function humanizeNumber(n) {
    n = n.toString();
    while (true) {
        var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3');
        if (n == n2) break;
        n = n2;
    }
    return n;
}
</script>

<?php $this->load->view("students/menu", $data); ?>

<div class="content-wrapper" style="margin-top:0">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <?php if ($this->session->flashdata('message')): ?>
                    <div class="text-primary" style="margin-bottom:10px;">
                        <?= $this->session->flashdata("message") ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url("students/assessment/" . $row->id) ?>" method="post">
                    <input type="hidden" name="as_id" value="<?= $as_id ?>">
                    <h3 class="heading" style="text-align:center">Financial Assessment</h3><br>

				<div class="row" style="margin-bottom:15px">
					<div class="col-md-12" style="text-align:center">
						<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-lg btn-primary">Financial Assessment</a>
						<a href="<?=site_url("students/assessment_paces/".$row->id)?>" class="btn btn-lg btn-info">Pace's Assessment</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align:right">
						<?php if ($this->session->userdata('current_usertype') == 'Parent'): ?>
							<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-refresh'></i></a>
						<?php endif; ?>
						<?php
						$allowed_print_roles = array('Accounting', 'Super Admin', 'Admin', 'Registrar');
						if (in_array($this->session->userdata('current_usertype'), $allowed_print_roles)):
						?>
							<a href="<?=site_url("students/assessment_print/".$row->id)?>" title="Print" class="btn btn-icons btn-secondary btn-rounded" target="_blank"><i class='mdi mdi-printer'></i></a>
						<?php endif; ?>
						<?php
						$allowed_pace_roles = array('Accounting', 'Super Admin', 'Registrar');
						if (in_array($this->session->userdata('current_usertype'), $allowed_pace_roles)):
						?>
							<button type="button" onclick="saveAndGoToPaces()" class="btn btn-icons btn-info btn-rounded" title="Save Assessment & Go to PACEs"><i class='mdi mdi-book-open-page-variant'></i></button>
						<?php endif; ?>
					</div>
				</div>

                    <div class="row">
                        <!-- INCIDENTALS -->
                        <div class="col-md-6 incidentals-section">
                            <p class="card-description text-info"><b>INCIDENTALS</b></p>
                            <?php foreach ($indntals_list as $ind => $val): ?>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><?= $val ?></label>
                                    <div class="col-sm-6">
                                        <div class="assessment-input-wrapper">
                                            <input type="text" name="indntals[]"
                                                   value="<?= isset($indntals[$ind]) ? $indntals[$ind] : '0' ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- MISCELLANEOUS + TOTALS -->
                        <div class="col-md-6">
                            <div class="miscellaneous-section">
                                <p class="card-description text-info"><b>MISCELLANEOUS</b></p>
                                <?php foreach ($msclns_list as $ind => $val): ?>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= $val ?></label>
                                        <div class="col-sm-6">
                                            <div class="assessment-input-wrapper">
                                                <input type="text" name="msclns[]"
                                                       value="<?= isset($msclns[$ind]) ? $msclns[$ind] : '0' ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <hr>
                                <p class="card-description text-info"><b>TOTAL COMPUTATION</b></p>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><b>TUITION</b></label>
                                    <div class="col-sm-6">
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="tuition" name="tuition"
                                                   value="<?= set_value('tuition', $tuition) ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><b>REGISTRATION</b></label>
                                    <div class="col-sm-6">
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="registration" name="registration"
                                                   value="<?= set_value('registration', $registration) ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><b>TOTAL MISCELLANEOUS</b></label>
                                    <div class="col-sm-6">
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="totalmisc"
                                                   value="<?= number_format($total_msclns, 2) ?>"
                                                   class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><b>TOTAL INCIDENTALS</b></label>
                                    <div class="col-sm-6">
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="totalinc"
                                                   value="<?= number_format($total_indntals, 2) ?>"
                                                   class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOTAL BOX -->
                                <div class="assessment-total-box">
                                    <div class="assessment-total-row">
                                        <label>TOTAL ASSESSMENT:</label>
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="asstotal"
                                                   value="<?= number_format($total_ass, 2) ?>"
                                                   class="assessment-total-input" disabled>
                                        </div>
                                        <input type="hidden" id="asstotal_hidden" name="asstotal_hidden"
                                               value="<?= $total_ass ?>">
                                    </div>

                                    <div class="assessment-total-row">
                                        <label>Paid upon enrollment:</label>
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="paymentenroll" name="paymentenroll"
                                                   value="<?= set_value('paymentenroll', $paymentenroll) ?>"
                                                   class="assessment-total-input">
                                        </div>
                                    </div>

                                    <div class="assessment-total-row">
                                        <label>Balance:</label>
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="balance"
                                                   value="<?= number_format($balance, 2) ?>"
                                                   class="assessment-total-input" disabled>
                                        </div>
                                    </div>

                                    <div class="assessment-total-row">
                                        <label>Due every month:</label>
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="monthdue"
                                                   value="<?= number_format($monthly + $promissory_monthly, 2) ?>"
                                                   class="assessment-total-input" disabled>
                                        </div>
                                    </div>

                                    <div class="assessment-total-row">
                                        <label style="color:#000!important">Monthly Promissory Note:</label>
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="promissory_payment" name="promissory_payment"
                                                   value="<?= set_value('promissory_payment', $promissory_payment) ?>"
                                                   class="assessment-total-input">
                                        </div>
                                    </div>

                                    <div class="assessment-total-row assessment-due-row">
                                        <label>Total Amount:</label>
                                        <div class="assessment-input-wrapper">
                                            <input type="text" id="promissory_monthly"
                                                   value="<?= number_format($monthly + $promissory_monthly, 2) ?>"
                                                   class="assessment-total-input" disabled>
                                        </div>
                                    </div>

                                    <div class="assessment-total-row">
                                        <label>Payment received by:</label>
                                        <input type="text" value="" class="assessment-total-input" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <?php if ($this->session->userdata('current_usertype') == 'Parent'): ?>
                            <div class="col-md-6" style="text-align:left">
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                        <!-- <input type="checkbox" class="form-check-input" id="chkconfirmed">	 -->
                                        I agree with the Financial Assessment for my student.
                                    </label>
                                <!-- </div>
                                <input type="button"
                                       href="<?= site_url("students/changestatus/Interview/" . $row->id) ?>"
                                       value="Change Status: For Interview"
                                       class="btn btn-lg btn-success" id="btnstatus" disabled><br>
                            </div> -->
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('current_usertype'), array('Accounting', 'Super Admin', 'Registrar'))): ?>
                            <div class="col-md-6" style="text-align:left">
                                <input type="submit" class="btn btn-lg btn-primary" value="UPDATE Assessment">
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
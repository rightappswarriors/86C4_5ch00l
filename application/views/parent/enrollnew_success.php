<?php
/**
 * Enrollment Success Page
 * Shown after a student has been successfully enrolled.
 * Displays QR confirmation, action buttons, and PDF policies.
 */
?>

<link rel="stylesheet" href="<?= base_url() ?>assets/css/enrollment-steps.css">

<!-- Enrollment Step Breadcrumb -->
<ol class="enrollment-breadcrumb">
  <li><span class="step passed"><span class="step-number"><i class="mdi mdi-check"></i></span>Read the Student Handbook</span></li>
  <li><span class="arrow">›</span></li>
  <li><span class="step passed"><span class="step-number"><i class="mdi mdi-check"></i></span>Fill up Enrollment Application Form</span></li>
  <li><span class="arrow">›</span></li>
  <li><span class="step current"><span class="step-number">3</span>Print/Save Enrollment Application Form / Save QR Code</span></li>
</ol>

<div class="content-wrapper">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body" style="text-align: center;">

                <h3 class="heading text-success" style="text-align: center;">Successfully submitted!</h3>
                <p>Please show this to the Registrar/Principal and proceed to step 2: In-person for Diagnostic Test / Academic Assessment.</p>
                <p><mark><code>Please prepare the necessary requirements below.</code></mark></p>

                <!-- QR Code and Action Buttons -->
                <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="card" style="background: #f8f9fa; padding: 20px;">
                            <h4 class="text-info">E-Registration Acknowledgement Slip</h4>
                            <p>Scan the QR code below to verify enrollment.</p>

                            <div class="qr-canvas-wrapper">
                                <canvas id="qr-success-canvas"></canvas>
                            </div>

                            <!-- Primary Action Buttons -->
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-12">
                                    <?php if ($current_usertype != 'Parent'): ?>
                                        <a href="<?= isset($print_url) ? $print_url : site_url('students/enrollment_receipt/' . $student_id) ?>"
                                           target="_blank" type="button" class="btn btn-lg btn-info btn-fw">
                                            <i class="mdi mdi-printer"></i> Print Enrollment Form
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('students/updateinfo/' . $student_id) ?>"
                                       type="button" class="btn btn-lg btn-primary btn-fw">
                                        <i class="mdi mdi-pencil"></i> Edit Enrollment Form
                                    </a>
                                    <a href="<?= site_url('enroll/view_student_info/' . $student_id) ?>"
                                       target="_blank" type="button" class="btn btn-lg btn-warning btn-fw">
                                        <i class="mdi mdi-eye"></i> View Student Info
                                    </a>
                                    <a href="<?= site_url('enroll/assessment/' . $student_id) ?>"
                                       type="button" class="btn btn-lg btn-success btn-fw">
                                        <i class="mdi mdi-school"></i> Go to Assessment
                                    </a>
                                </div>
                            </div>

                            <!-- Secondary Action Buttons -->
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12" style="text-align: center;">
                                    <a href="<?= site_url('students/docs/' . $student_id) ?>"
                                       type="button" class="btn btn-lg btn-success btn-fw">
                                        <i class="mdi mdi-file-document"></i> Ready for the requirement(s), upload now!
                                    </a>
                                    <a href="<?= site_url('students/enrollnew_form') ?>"
                                       type="button" class="btn btn-lg btn-primary btn-fw">
                                        <i class="mdi mdi-file-document"></i> Enroll another Student
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proof of Application Modal -->
                <div class="modal fade" id="proofModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-white">
                                    <i class="mdi mdi-alert-circle"></i> IMPORTANT: Proof of Application
                                </h5>
                            </div>
                            <div class="modal-body">
                                <p style="font-size: 18px;">Please keep proof of your application submission.</p>
                                <p>Present any of the following to the school when requested:</p>
                                <ul class="proof-list">
                                    <li>Printed enrollment form</li>
                                    <li>Screenshot of the QR code</li>
                                    <li>Saved page or PDF copy of this screen</li>
                                </ul>
                                <hr>
                                <p class="text-muted"><em>Click Continue to close this message and view your enrollment confirmation.</em></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-lg btn-success btn-fw" id="btnProofContinue">
                                    <i class="mdi mdi-check-circle"></i> Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admission Policies PDF -->
                <iframe src="<?= base_url() ?>/file/ADMISSION_POLICIES.pdf" width="100%" height="450px"></iframe>

            </div>
        </div>
    </div>
</div>

<!-- QR Code Generation -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var studentId = <?= $student_id ?>;
    var qrData    = "<?= site_url('enroll/enrollment_receipt/') ?>" + studentId;
    var canvas    = document.getElementById('qr-success-canvas');

    if (canvas) {
        QRCode.toCanvas(canvas, qrData, { width: 250 }, function (error) {
            if (error) console.error(error);
        });
    }

    if (window.jQuery && jQuery.fn.modal) {
        jQuery('#proofModal').modal('show');
        jQuery('#btnProofContinue').on('click', function () {
            jQuery('#proofModal').modal('hide');
        });
    }
});
</script>

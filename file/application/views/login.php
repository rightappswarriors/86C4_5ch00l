<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login :: CBHCA Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="/assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/assets/css/shared/style.css">
    <link rel="stylesheet" href="/assets/css/portal-layout.css">
	<link rel="shortcut icon" href="/assets/images/favicon.png" />
  </head>
  <body>

<!-- Enrollment Procedures Modal -->
<div class="modal fade" id="enrollmentStepsModal" tabindex="-1" role="dialog" aria-labelledby="enrollmentStepsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content enrollment-modal-content">
      <div class="modal-header bg-gradient-primary text-white enrollment-modal-header">
        <div>
          <h4 class="modal-title font-weight-bold" id="enrollmentStepsModalLabel">
            <i class="mdi mdi-school"></i> Enrollment Procedures
          </h4>
          <p class="mb-0 small">7-Step Guide for New Students &amp; Transferees</p>
        </div>
        <button type="button" class="close text-white enrollment-modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="enrollment-modal-close-icon">&times;</span>
        </button>
      </div>
      <div class="modal-body enrollment-modal-body">
        <div class="enrollment-timeline">
          
          <!-- Online Section -->
          <div class="timeline-section mb-4">
            <div class="d-flex align-items-center mb-3">
              <span class="badge badge-primary badge-pill p-2 mr-2 enrollment-section-badge">
                <i class="mdi mdi-laptop"></i> ONLINE
              </span>
            </div>
            <div class="step-box">
              <div class="step-number">1</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">Online Registration &amp; Fetcher's ID</h6>
                <p class="mb-0 text-muted">Register at: <a href="https://portal.bobhughes.edu.ph/" target="_blank" class="text-primary font-weight-bold">portal.bobhughes.edu.ph</a></p>
              </div>
            </div>
          </div>
          
          <!-- In Person Section -->
          <div class="timeline-section">
            <div class="d-flex align-items-center mb-3">
              <span class="badge badge-success badge-pill p-2 mr-2 enrollment-section-badge">
                <i class="mdi mdi-account-location"></i> IN PERSON
              </span>
            </div>
            
            <div class="step-box">
              <div class="step-number">2</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">Diagnostic Test / Academic Assessment</h6>
                <p class="mb-0 text-muted">Student undergoes assessment for grade placement</p>
              </div>
            </div>
            
            <div class="step-box">
              <div class="step-number">3</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">Financial Assessment</h6>
                <p class="mb-0 text-muted">Meet with accounting office for tuition &amp; payment plans</p>
              </div>
            </div>
            
            <div class="step-box">
              <div class="step-number">4</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">Interview with Principal</h6>
                <p class="mb-0 text-muted">
                  <span class="badge badge-warning text-dark">RR - Grade 3</span> Parents Only
                  <span class="mx-1">|</span>
                  <span class="badge badge-info">Grades 4-12</span> Parents + Students
                </p>
              </div>
            </div>
            
            <div class="step-box">
              <div class="step-number">5</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">Down Payment</h6>
                <p class="mb-0 text-muted">Pay <span class="text-success font-weight-bold">PHP 15,000</span> to Accounting Office</p>
              </div>
            </div>
            
            <div class="step-box">
              <div class="step-number">6</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">Submit Documents</h6>
                <p class="mb-0 text-muted">Submit signed documents &amp; sign for Fetcher's ID</p>
              </div>
            </div>
            
            <div class="step-box">
              <div class="step-number">7</div>
              <div class="step-content">
                <h6 class="font-weight-bold mb-1">PACeS Issuance</h6>
                <p class="mb-0 text-muted">Submit enrollment proof to L.C. Supervisor</p>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer enrollment-modal-footer">
        <button type="button" class="btn btn-primary btn-lg btn-block" data-dismiss="modal">
          <i class="mdi mdi-check-circle"></i> Got It!
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#enrollmentStepsModal').modal('show');
});
</script>

    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
			<div class="col-lg-4 mx-auto">
			<h2 class="text-center mb-4">Login</h2>
			  <div class="auto-form-wrapper">
			  
			  <?php
                if($this->session->flashdata('message'))
                {
                    echo '
                    <div class="text-danger" style="margin-bottom:10px;">
                        '.$this->session->flashdata("message").'
                    </div>
                    ';
                }
                ?>
			  
                <form method="POST" action="<?=site_url("login/validation")?>">
                  <div class="form-group">
                    <label class="label">Mobile Number</label>
                    <div class="input-group">
                      <input type="text" name="mobileno" value="<?=set_value('mobileno')?>" class="form-control" placeholder="09229631111">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" name="userpass" class="form-control" placeholder="*********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked> Remember me </label>
                    </div>
                    <a href="<?=site_url("login/forgotpass")?>" class="text-small forgot-password text-black">Forgot Password?</a>
                  </div>
				  <div class="form-group">
                    <input type="submit" class="btn btn-primary submit-btn btn-block" name="login" value="Login">
                  </div>
				  
				  <div class="form-group" style="display:none;">
                    <button class="btn btn-block g-login">
                      <img class="mr-3" src="<?=dirname(base_url())?>/portal/assets/images/file-icons/icon-google.svg" alt="">Log in with Google</button>
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">No account yet?</span>
                    <a href="<?=site_url("register")?>" class="text-black text-small">Create new account</a>
                  </div>
                </form>
              </div>
              <ul class="auth-footer" style="display:none;">
                <li>
                  <a href="#">Conditions</a>
                </li>
                <li>
                  <a href="#">Help</a>
                </li>
                <li>
                  <a href="#">Terms</a>
                </li>
              </ul>
              <p class="footer-text text-center" style="margin-top:20px;color:#999;">© 2020 CBHCA Online Portal. All rights reserved.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- inject:js -->
    <script src="/assets/js/shared/off-canvas.js"></script>
    <script src="/assets/js/shared/misc.js"></script>
    <!-- endinject -->
   
  </body>
</html>
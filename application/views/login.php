<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login :: CBHCA Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/shared/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/auth.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/login.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/portal-layout.css">
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
    <style>
    /* === MOBILE: Both panels side-by-side at all times === */
    @media (max-width: 767px) {
      .login-two-col-row {
        flex-wrap: nowrap !important;
        padding: 0.5rem 2% !important;
      }
      .enrollment-col {
        padding-right: 6px !important;
      }
      .enrollment-panel {
        margin-top: 10px !important;
      }
      .enrollment-panel .mb-4 h2 {
        font-size: 0.85rem !important;
      }
      .enrollment-panel .mb-4 p {
        font-size: 0.7rem !important;
        display: none; /* hide subtitle on tiny screens */
      }
      .step-box {
        padding: 6px 8px !important;
        margin-bottom: 6px !important;
      }
      .step-number {
        width: 20px !important;
        height: 20px !important;
        line-height: 20px !important;
        font-size: 10px !important;
        flex-shrink: 0;
      }
      .step-content h6 {
        font-size: 10px !important;
        margin-bottom: 0 !important;
      }
      .step-content p {
        font-size: 9px !important;
        display: none; /* hide sub-description on tiny screens to save space */
      }
      .enrollment-section-badge {
        font-size: 9px !important;
        padding: 3px 5px !important;
      }
      .auth-card {
        padding: 12px 10px !important;
        border-radius: 10px !important;
      }
      .auth-card .school-logo {
        width: 36px !important;
        height: 36px !important;
      }
      .auth-card .school-logo i {
        font-size: 18px !important;
      }
      .auth-card h2 {
        font-size: 13px !important;
      }
      .auth-card p {
        font-size: 10px !important;
      }
      .auth-card .form-label {
        font-size: 10px !important;
        margin-bottom: 2px !important;
      }
      .auth-card .form-control {
        height: 32px !important;
        font-size: 10px !important;
        padding: 4px 6px !important;
      }
      .auth-card .input-group-text {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        font-size: 11px !important;
      }
      .auth-card .form-check-label,
      .auth-card .forgot-password {
        font-size: 9px !important;
      }
      .auth-card .login-method-selector-bottom .form-label { display: none; }
      .auth-card .login-method-btn {
        padding: 4px 6px !important;
        font-size: 9px !important;
      }
      .auth-card .auth-submit-btn {
        height: 32px !important;
        font-size: 11px !important;
        padding: 4px 8px !important;
      }
      .auth-card .api-auths a {
        height: 30px !important;
        font-size: 9px !important;
        padding: 4px 6px !important;
      }
      .auth-card .google-icon { height: 1em !important; width: 1em !important; }
      .auth-card .auth-footer-text p { font-size: 9px !important; }
      .auth-card .auth-divider { margin: 6px 0 !important; }
      .auth-copyright { font-size: 8px !important; margin-top: 4px !important; }
      .login-col { padding-left: 6px !important; }
    }
    </style>
  </head>
  <body>



  <div class="auth-page-logo">
		<a href="<?=site_url()?>">
			<img src="<?=base_url()?>assets/images/logo_portal.png" alt="BHCA Logo">
		</a>
		<h3 class="auth-logo-text">BHCA</h3>
	</div>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <!-- The row serves as the relative container for full width -->
          <div class="row w-100 mx-auto align-items-center justify-content-between login-two-col-row" style="max-width: 1400px; padding: 2rem 5%; flex-wrap: nowrap;">
            
            <!-- Left Side Panel (Enrollment Procedures) -->
            <div class="col-6 d-flex flex-column justify-content-center enrollment-col pr-lg-5 mb-md-0">
              <div class="enrollment-panel w-100 d-flex flex-column" style="background: transparent; margin-top: 100px;">

                <div class="p-0" style="flex-grow: 1;">
                  <div class="mb-4">
                    <h2 class="font-weight-bold mb-1 text-dark" style="font-size: 2rem;">
                      <i class="mdi mdi-school" style="color: #000;"></i> Enrollment Procedures
                    </h2>
                    <p class="mb-0 text-muted" style="font-size: 1.1rem;">7-Step Guide for New Students &amp; Transferees</p>
                  </div>
                  <div class="enrollment-timeline mb-0">
                    <div class="timeline-section mb-3">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-pill p-2 mr-2 enrollment-section-badge">
                          <i class="mdi mdi-laptop"></i> ONLINE
                        </span>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 12px;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">1</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">Online Registration &amp; Fetcher's ID</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">Register at: <a href="https://portal.bobhughes.edu.ph/" target="_blank" class="text-primary font-weight-bold">portal.bobhughes.edu.ph</a></p>
                        </div>
                      </div>
                    </div>
                    <div class="timeline-section mb-0">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-success badge-pill p-2 mr-2 enrollment-section-badge">
                          <i class="mdi mdi-account-location"></i> IN PERSON
                        </span>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 12px;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">2</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">Diagnostic Test / Academic Assessment</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">Student undergoes assessment for grade placement</p>
                        </div>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 12px;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">3</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">Financial Assessment</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">Meet with accounting office for tuition &amp; payment plans</p>
                        </div>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 12px;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">4</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">Interview with Principal</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">
                            <span class="badge badge-warning text-dark">RR - Grade 3</span> Parents Only
                            <span class="mx-1">|</span>
                            <span class="badge badge-info">Grades 4-12</span> Parents + Students
                          </p>
                        </div>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 12px;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">5</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">Down Payment</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">Pay <span class="text-success font-weight-bold">PHP 15,000</span> to Accounting Office</p>
                        </div>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 12px;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">6</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">Submit Documents</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">Submit signed documents &amp; sign for Fetcher's ID</p>
                        </div>
                      </div>
                      <div class="step-box" style="padding: 15px 20px; margin-bottom: 0;">
                        <div class="step-number" style="width: 28px; height: 28px; line-height: 28px; font-size: 14px;">7</div>
                        <div class="step-content">
                          <h6 class="font-weight-bold mb-1" style="font-size: 14px;">PACeS Issuance</h6>
                          <p class="mb-0 text-muted" style="font-size: 13px;">Submit enrollment proof to L.C. Supervisor</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Side Panel (Login Form) -->
            <div class="col-6 d-flex flex-column justify-content-center login-col align-items-lg-end pl-lg-0 mb-md-0">
              <div class="auth-card" style="width: 100%; max-width: 420px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); border-radius: 20px; margin: 0; background: #fff; padding: 50px 40px;">
                <div class="auth-header mb-4 text-center">
                  <div class="school-logo mb-3 mx-auto" style="width: 65px; height: 65px; background: #1976D2; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="mdi mdi-school" style="font-size: 30px;"></i>
                  </div>
                  <h2 class="font-weight-bold text-dark mt-2" style="font-size: 24px;">Welcome Back!</h2>
                  <p class="text-muted" style="font-size: 14px;">Please login to your account</p>
                </div>
                
                <?php
                if($this->session->flashdata('message'))
                {
                    echo '<div class="auth-error">
                        '.$this->session->flashdata("message").'
                    </div>';
                }
                ?>
                
                <form method="POST" action="<?=site_url("login/validation")?>" class="auth-form">
                  <!-- Hidden input to store the selected login method -->
                  <input type="hidden" name="login_type" id="login_type" value="email">
                  <div class="form-group mb-3">
                    <label class="form-label font-weight-bold text-dark small" id="login_identifier_label">Email Address</label>
                    <div class="input-group">
                      <input type="text" name="login_identifier" id="login_identifier" value="<?=set_value('login_identifier')?>" class="form-control bg-light" placeholder="Enter your Email Address" style="border: 1px solid #ebedf2; border-radius: 8px 0 0 8px; height: 46px;">
                      <div class="input-group-append">
                        <span class="input-group-text bg-primary text-white" style="border: none; border-radius: 0 8px 8px 0; width: 46px; justify-content: center;">
                          <i class="mdi mdi-account"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label font-weight-bold text-dark small">Password</label>
                    <div class="input-group">
                      <input type="password" name="userpass" class="form-control bg-light" placeholder="Enter your password" style="border: 1px solid #ebedf2; border-radius: 8px 0 0 8px; height: 46px;">
                      <div class="input-group-append">
                        <span class="input-group-text bg-primary text-white" style="border: none; border-radius: 0 8px 8px 0; width: 46px; justify-content: center;">
                          <i class="mdi mdi-lock"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                   
                  <div class="form-group d-flex justify-content-between align-items-center mt-3 mb-4">
                    <div class="form-check m-0">
                      <input type="checkbox" class="form-check-input" id="rememberMe" checked style="margin-top: 0.2rem;">
                      <label class="form-check-label text-muted small" for="rememberMe" style="margin-left: 5px; cursor: pointer;">Remember me</label>
                    </div>
                    <a href="<?=site_url("login/forgotpass_gate")?>" class="forgot-password text-primary font-weight-bold small">Forgot Password?</a>
                  </div>

                  <!-- Login Method Icon Selector -->
                  <div class="form-group login-method-selector-bottom mb-4">
                    <label class="form-label font-weight-bold text-dark small">Select Login Method</label>
                    <div class="login-method-icons">
                      <button type="button" class="login-method-btn active" data-method="email" title="Login with Email">
                         <span>Email</span>
                      </button>
                      <button type="button" class="login-method-btn" data-method="mobile" title="Login with Phone Number">
                        <span>Phone</span>
                      </button>
                    </div>
                  </div>

                  <div class="form-group login-btn-wrapper mt-2 mb-4">
                    <button type="submit" class="auth-submit-btn btn btn-primary btn-block shadow-sm" name="login" style="border-radius: 8px; height: 46px; font-weight: bold;">
                      <i class="mdi mdi-login mr-2"></i> Login
                    </button>
                  </div>

                  <div class="position-relative text-center my-4">
                    <hr style="border-top: 1px solid #ebedf2;">
                    <span class="text-muted small px-3" style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #fff;">OR</span>
                  </div>

                  <div class="form-group api-auths d-flex flex-column" style="gap: 12px;">
                    <a href="<?= site_url('GoogleAuth/login') ?>" class="btn btn-block btn-outline-secondary d-flex align-items-center justify-content-center shadow-sm" style="height: 46px; border-radius: 8px; background: #fff; color: #555; text-decoration: none;">
                      <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" x="0px" y="0px" class="google-icon mr-2" viewBox="0 0 48 48" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12 c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24 c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657 C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36 c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571 c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                      </svg>
                      <span class="font-weight-bold small">Login with Google</span>
                    </a>
                    <a href="<?= site_url('FacebookAuth/login') ?>" class="btn btn-block btn-outline-secondary d-flex align-items-center justify-content-center shadow-sm m-0" style="height: 46px; border-radius: 8px; background: #fff; color: #1877F2; border-color: #ebedf2; text-decoration: none;">
                      <i class="fa-brands fa-facebook mr-2" style="font-size: 18px;"></i><span class="font-weight-bold small text-dark">Login with Facebook</span>
                    </a>
                  </div>
                  
                  <div class="auth-footer-text text-center mt-4">
                    <p class="mb-2 text-muted small">Don't have an account? <a href="<?=site_url("register")?>" class="font-weight-bold text-primary">Create new account</a></p>
                  </div>
                </form>
              </div>
              <p class="auth-copyright text-center mt-3 text-muted w-100 small">© 2020 CBHCA Online Portal. All rights reserved.</p>
            </div>

          </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>

    <!-- inject:js -->
    <script src="<?=base_url()?>assets/js/shared/off-canvas.js"></script>
    <script src="<?=base_url()?>assets/js/shared/misc.js"></script>
    <script>
      (function () {
        // Login method icon button functionality
        var loginMethodBtns = document.querySelectorAll('.login-method-btn');
        var identifierLabel = document.getElementById('login_identifier_label');
        var identifierInput = document.getElementById('login_identifier');
        var loginTypeInput = document.getElementById('login_type');
        
        if (!loginMethodBtns.length || !identifierLabel || !identifierInput) {
          return;
        }

        var loginConfig = {
          email: {
            label: 'Email Address',
            placeholder: 'Enter your Email Address'
          },
          mobile: {
            label: 'Phone Number',
            placeholder: 'Enter your Phone Number'
          },
          facebook: {
            label: 'Facebook Username',
            placeholder: 'Enter your Facebook Username'
          }
        };

        function applyLoginMethod(method) {
          // Update active button
          loginMethodBtns.forEach(function(btn) {
            btn.classList.remove('active');
            if (btn.dataset.method === method) {
              btn.classList.add('active');
            }
          });
          
          // Update label and placeholder
          var config = loginConfig[method] || loginConfig.email;
          identifierLabel.textContent = config.label;
          identifierInput.placeholder = config.placeholder;
          
          // Update hidden login_type input for form submission
          if (loginTypeInput) {
            loginTypeInput.value = method;
          }
        }

        // Add click event to buttons
        loginMethodBtns.forEach(function(btn) {
          btn.addEventListener('click', function() {
            applyLoginMethod(this.dataset.method);
          });
        });
      })();
    </script>
    <!-- endinject -->
    
    <?php $this->load->view('support_chat_widget'); ?>
   
  </body>
</html>

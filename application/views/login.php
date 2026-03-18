<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login :: CBHCA Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
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
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
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
          <div class="row w-100">
			<div class="col-lg-4 mx-auto">
			  <div class="auth-card"> 
			  <div class="auth-header">
                <div class="school-logo">
                  <i class="mdi mdi-school"></i>
                </div>
			  	<h2>Welcome Back!</h2>
			  	<p>Please login to your account</p>
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
                  <div class="form-group">
                    <label class="form-label" id="login_identifier_label">Email Address</label>
                    <div class="input-group">
                      <input type="text" name="login_identifier" id="login_identifier" value="<?=set_value('login_identifier')?>" class="form-control" placeholder="Enter your Email Address">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-account"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                      <input type="password" name="userpass" class="form-control" placeholder="Enter your password">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                   
                  <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="rememberMe" checked>
                      <label class="form-check-label" for="rememberMe" style="margin-left: 5px;">Remember me</label>
                    </div>
                    <a href="<?=site_url("login/forgotpass_gate")?>" class="forgot-password">Forgot Password?</a>
                  </div>

                  <!-- Login Method Icon Selector below Remember Me -->
                  <div class="form-group login-method-selector-bottom">
                    <label class="form-label">Select Login Method</label>
                    <div class="login-method-icons">
                      <button type="button" class="login-method-btn active" data-method="email" title="Login with Email">
                        <i class="mdi mdi-gmail"></i>
                      </button>
                      <button type="button" class="login-method-btn" data-method="mobile" title="Login with Phone Number">
                        <i class="mdi mdi-phone"></i>
                      </button>
                      <button type="button" class="login-method-btn" data-method="facebook" title="Login with Facebook">
                        <i class="mdi mdi-facebook"></i>
                      </button>
                    </div>
                  </div>

				  <div class="form-group mt-4">
                    <button type="submit" class="auth-submit-btn" name="login">
                      <i class="mdi mdi-login mr-2"></i> Login
                    </button>
                  </div>
				  
				  <div class="auth-divider">
				  	<span>OR</span>
				  </div>
				  
                  <div class="auth-footer-text">
                    <p>Don't have an account? <a href="<?=site_url("register")?>">Create new account</a></p>
                  </div>
                </form>
              </div>
              <p class="auth-copyright">© 2020 CBHCA Online Portal. All rights reserved.</p>
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password :: CBHCA Portal</title>
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
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
    
    <style>
        .auth-form .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            height: auto;
        }
        .auth-form label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        .input-icon .form-control {
            padding-left: 40px;
        }
        .alert-message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .password-requirements {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .password-requirements h6 {
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }
        .password-requirements li {
            margin-bottom: 5px;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
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
          <div class="row w-100">
			<div class="col-lg-4 mx-auto">
			  <div class="auth-card">
			  
			  <div class="auth-header">
                <div class="school-logo">
                  <i class="mdi mdi-lock-reset"></i>
                </div>
			  	<h2>Reset Password</h2>
			  	<p>Create a new password</p>
			  </div>
			  
			  <div class="auth-form">
				  <?php if($this->session->flashdata('message')): ?>
				  <div class="alert-message alert-error">
					  <?=$this->session->flashdata('message')?>
				  </div>
				  <?php endif; ?>
				  
				  <form id="reset-form" action="<?=site_url('login/update_password')?>" method="post">
					  <div class="form-group">
						  <label for="new_password">New Password</label>
						  <div class="input-icon">
							  <i class="mdi mdi-lock-outline"></i>
							  <input type="password" class="form-control" id="new_password" name="new_password" 
								 placeholder="Enter new password" required>
							  <span class="password-toggle" onclick="togglePassword('new_password')">
								  <i class="mdi mdi-eye-off"></i>
							  </span>
						  </div>
					  </div>
					  
					  <div class="form-group">
						  <label for="confirm_password">Confirm Password</label>
						  <div class="input-icon">
							  <i class="mdi mdi-lock-outline"></i>
							  <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
								 placeholder="Confirm new password" required>
							  <span class="password-toggle" onclick="togglePassword('confirm_password')">
								  <i class="mdi mdi-eye-off"></i>
							  </span>
						  </div>
						  <div id="password-match" class="text-danger" style="display: none; margin-top: 5px;">
							  <small><i class="mdi mdi-alert-circle"></i> Passwords do not match</small>
						  </div>
					  </div>
					  
					  <div class="password-requirements">
						<h6><i class="mdi mdi-information-outline"></i> Password Requirements:</h6>
						<ul>
							<li>Minimum 6 characters</li>
							<li>Maximum 12 characters</li>
							<li>Must match the confirmation</li>
						</ul>
					  </div>
					  
					  <div class="form-group mt-4">
						<button type="submit" class="auth-submit-btn btn-block" id="submit-btn">
						  Reset Password
						</button>
					  </div>
					  
					  <div class="form-group mt-3">
						<a href="<?=site_url("login/cancel_reset")?>" class="auth-submit-btn auth-submit-btn-outline btn-block">
						  <i class="mdi mdi-close mr-2"></i> Cancel
						</a>
					  </div>
				  </form>
              </div>
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
    <!-- endinject -->
    
    <script>
        function togglePassword(inputId) {
            var input = $('#' + inputId);
            var icon = input.next('.password-toggle').find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('mdi-eye-off').addClass('mdi-eye');
            } else {
                input.attr('type', 'password');
                icon.removeClass('mdi-eye').addClass('mdi-eye-off');
            }
        }
        
        $(document).ready(function() {
            // Password match validation
            $('#confirm_password').on('input', function() {
                var newPassword = $('#new_password').val();
                var confirmPassword = $(this).val();
                
                if (confirmPassword.length > 0) {
                    if (newPassword === confirmPassword) {
                        $('#password-match').hide();
                    } else {
                        $('#password-match').show();
                    }
                } else {
                    $('#password-match').hide();
                }
            });
            
            $('#new_password').on('input', function() {
                var confirmPassword = $('#confirm_password').val();
                if (confirmPassword.length > 0) {
                    if ($(this).val() === confirmPassword) {
                        $('#password-match').hide();
                    } else {
                        $('#password-match').show();
                    }
                }
            });
            
            // Form submission
            $('#reset-form').on('submit', function(e) {
                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();
                
                if (newPassword.length < 6 || newPassword.length > 12) {
                    e.preventDefault();
                    alert('Password must be between 6 and 12 characters.');
                    return;
                }
                
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                    return;
                }
                
                // Show loading
                $('#submit-btn').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Resetting...');
            });
        });
    </script>
   
  </body>
</html>

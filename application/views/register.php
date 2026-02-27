<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register :: CBHCA Portal</title>
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
  </head>
  <body>
  <div class="auth-page-logo">
		<a href="<?=site_url()?>">
			<img src="<?=base_url()?>assets/images/dashboard_logo.png" alt="BHCA Logo">
		</a>
		<h3 class="auth-logo-text">BHCA</h3>
	</div>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-5 mx-auto">
              <div class="auth-card">
			  
			  <div class="auth-header">
                <div class="school-logo">
                  <i class="mdi mdi-school"></i>
                </div>
			  	<h2>Create Account</h2>
			  	<p>Join CBHCA Portal today</p>
			  </div>
			  
			  <?=validation_errors()?>
			  
                <form method="POST" action="<?=site_url("register/validation")?>" class="auth-form">
                  <div class="form-group">
					<label class="form-label">Mobile Number</label>
                    <div class="input-group">
                      <input type="text" name="mobileno" value="<?=set_value('mobileno')?>" class="form-control" placeholder="09229631111">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-phone"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
                  <div class="form-group">
					<label class="form-label">Email Address</label>
                    <div class="input-group">
                      <input type="email" name="emailadd" value="<?=set_value('emailadd')?>" class="form-control" placeholder="email@sample.com">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-email"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				  <div class="row">
					<div class="col-md-6">
					  <div class="form-group">
						<label class="form-label">First Name</label>
						<div class="input-group">
						  <input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" placeholder="Juan">
						  <div class="input-group-append">
							<span class="input-group-text">
							  <i class="mdi mdi-account"></i>
							</span>
						  </div>
						</div>
					  </div>
					</div>
					<div class="col-md-6">
					  <div class="form-group">
						<label class="form-label">Last Name</label>
						<div class="input-group">
						  <input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" placeholder="Dela Cruz">
						  <div class="input-group-append">
							<span class="input-group-text">
							  <i class="mdi mdi-account"></i>
							</span>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  
                  <div class="form-group">
					<label class="form-label">Password</label>
                    <div class="input-group">
                      <input type="password" name="userpass" value="<?=set_value('userpass')?>" class="form-control" placeholder="Create a password">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Confirm Password</label>
					<div class="input-group">
                      <input type="password" name="repeatpass" value="<?=set_value('repeatpass')?>" class="form-control" placeholder="Confirm your password">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock-check"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                   
                  <div class="form-group mt-4">
                    <button type="submit" class="auth-submit-btn">
                      <i class="mdi mdi-account-plus mr-2"></i> Create Account
                    </button>
                  </div>
				  
                  <div class="auth-footer-text">
                    <p>Already have an account? <a href="<?=site_url("login")?>">Login here</a></p>
                  </div>
                </form>
              </div>
            <p class="auth-copyright">© <?=date("Y")?> CBHCA Online Portal. All rights reserved.</p>
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
  </body>
</html>

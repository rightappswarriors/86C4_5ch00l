<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register :: CBHCA Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?=dirname(base_url())?>/assets/css/shared/style.css">
    <link rel="shortcut icon" href="<?=dirname(base_url())?>/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <h2 class="text-center mb-4">Create New Account</h2>
              <div class="auto-form-wrapper">
			  <?=validation_errors()?>
                <form method="POST" action="<?=site_url("register/validation")?>">
                  <div class="form-group">
				  <label class="label">Your Mobile Number</label>
                    <div class="input-group">
                      <input type="text" name="mobileno" value="<?=set_value('mobileno')?>" class="form-control" placeholder="Ex: 09229631111">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div><div class="form-group">
				  <label class="label">Your E-mail</label>
                    <div class="input-group">
                      <input type="text" name="emailadd" value="<?=set_value('emailadd')?>" class="form-control" placeholder="email@sample.com">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  <div class="form-group">
				  <label class="label">Your First Name</label>
                    <div class="input-group">
                      <input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" placeholder="Juan">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div><div class="form-group">
				  <label class="label">Your Last Name</label>
                    <div class="input-group">
                      <input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" placeholder="Dela Cruz">
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
                      <input type="password" name="userpass" value="<?=set_value('userpass')?>" class="form-control" placeholder="********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Repeat Password</label>
					<div class="input-group">
                      <input type="password" name="repeatpass" value="<?=set_value('repeatpass')?>" class="form-control" placeholder="********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block">Register</button>
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">Already have an account ?</span>
                    <a href="<?=site_url("login")?>" class="text-black text-small">Login</a>
                  </div>
                </form>
              </div>
            <p class="footer-text text-center" style="margin-top:20px;color:#999;">© <?=date("Y")?> CBHCA Online Portal. All rights reserved.</p>
			</div>
			
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=dirname(base_url())?>/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=dirname(base_url())?>/assets/vendors/js/vendor.bundle.addons.js"></script>
	<!-- inject:js -->
    <script src="<?=dirname(base_url())?>/assets/js/shared/off-canvas.js"></script>
    <script src="<?=dirname(base_url())?>/assets/js/shared/misc.js"></script>
    <!-- endinject -->
  </body>
</html>
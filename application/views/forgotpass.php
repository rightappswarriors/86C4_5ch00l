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
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
			<div class="col-lg-4 mx-auto">
			<h2 class="text-center mb-4">Forgot your password?</h2>
			  <div class="auto-form-wrapper" style="margin:0;">
			  
			  <p style="text-align:center;" class="text-primary">Please contact the Registrar's office or one of these numbers for your temporary password. <br><br><span style="color:#000;">(Office hours from 8:00am to 5:00pm)</span> </p>
			  <hr>
			  <p style="text-align:center;">(032) 505-6960 (Office)<br>
			  09458568571 / 09083570905 (Melvie)<br><br>or 09277324510 (I.T.)</p>
			  
				<span class="text-warning">NOTE: We will require your portal's login or the registered mobile number.</span>
                <br><br>
				  <div class="form-group">
                    <a href="<?=site_url("login")?>" class="btn btn-primary submit-btn btn-block" name="login">Login now</a>
                  </div>
				  
				  <div class="form-group" style="display:none;">
                    <button class="btn btn-block g-login">
                      <img class="mr-3" src="<?=base_url()?>assets/images/file-icons/icon-google.svg" alt="">Log in with Google</button>
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
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- inject:js -->
    <script src="<?=base_url()?>assets/js/shared/off-canvas.js"></script>
    <script src="<?=base_url()?>assets/js/shared/misc.js"></script>
    <!-- endinject -->
   
  </body>
</html>
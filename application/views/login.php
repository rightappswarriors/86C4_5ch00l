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
	<link rel="shortcut icon" href="/assets/images/favicon.png" />
  </head>
  <body>
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
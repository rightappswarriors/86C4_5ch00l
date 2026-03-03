<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password Details :: CBHCA Portal</title>
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/shared/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/auth.css">
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
    <style>
      .auth-form .form-group:nth-child(odd) .form-label {
        color: #2d5fb8;
      }
      .auth-form .form-group:nth-child(even) .form-label {
        color: #0b8a7e;
      }
      .auth-form .form-control {
        border: 1px solid #bdd0ea;
        border-radius: 8px;
        min-height: 44px;
        background-color: #f9fcff;
        font-size: 14px;
        color: #2b3a4f;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
      }
      .auth-form .form-control:focus {
        border-color: #2f78ff;
        background-color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(47, 120, 255, 0.16);
      }
      .auth-form .form-control::placeholder {
        color: #8fa2bc;
      }
      .return-link {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
      }
      .return-link:hover {
        color: #4a73e8;
        border-color: #4a73e8;
        background-color: #fff;
      }
      .return-link i {
        font-size: 18px;
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
            <div class="col-lg-6 mx-auto">
              <div class="auth-card">
                <div class="auth-header">
                  <div class="school-logo">
                    <i class="mdi mdi-account-search"></i>
                  </div>
                  <h2>Forgot Password</h2>
                  <p>Please fill up your details first</p>
                </div>

                <?php if($this->session->flashdata('message')): ?>
                  <div class="auth-error">
                    <?=$this->session->flashdata('message')?>
                  </div>
                <?php endif; ?>

                <?=validation_errors()?>

                <form method="POST" action="<?=site_url("login/forgotpass_gate_submit")?>" class="auth-form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">FIRST NAME</label>
                        <input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" placeholder="Enter first name" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">LAST NAME</label>
                        <input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" placeholder="Enter last name" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">MIDDLE NAME <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="middlename" value="<?=set_value('middlename')?>" class="form-control" placeholder="Enter middle name">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">PHONE NUMBER</label>
                        <input type="text" name="mobileno" value="<?=set_value('mobileno')?>" class="form-control" placeholder="e.g. 09123456789" required>
                      </div>
                    </div>
                  </div>

                  <div class="row align-items-end">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label class="form-label">LRN</label>
                        <input type="text" name="lrn" value="<?=set_value('lrn')?>" class="form-control" placeholder="Enter LRN">
                      </div>
                    </div>
                    <div class="col-md-2 text-center">
                      <label class="form-label d-block">OR</label>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label class="form-label">SCHOOL ID</label>
                        <input type="text" name="school_id" value="<?=set_value('school_id')?>" class="form-control" placeholder="Enter school ID">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mt-4">
                    <button type="submit" class="auth-submit-btn">
                      Continue to Forgot Password
                    </button>
                  </div>
                </form>
                
                <div class="text-center mt-3">
                  <a href="<?=site_url('login')?>" class="return-link">
                    <i class="mdi mdi-arrow-left"></i> Return to Login
                  </a>
                </div>
              </div>
              <p class="auth-copyright">© 2020 CBHCA Online Portal. All rights reserved.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
    <script src="<?=base_url()?>assets/js/shared/off-canvas.js"></script>
    <script src="<?=base_url()?>assets/js/shared/misc.js"></script>
  </body>
</html>

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
			<img src="<?=base_url()?>assets/images/logo_portal.png" alt="BHCA Logo">
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
			  <?php
			    // [Team Note - 2026-03-11] Tracks whether the optional student fields should stay open after form reload.
			    $has_student_details = set_value('lrn') || set_value('school_id');
			  ?>
			  
                <form method="POST" action="<?=site_url("register/validation")?>" class="auth-form">
                  
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
				  
				  <div class="form-group">
					<label class="form-label">Mobile Number</label>
                    <div class="input-group">
                      <input type="text" name="mobileno" value="<?=set_value('mobileno')?>" class="form-control" placeholder="09xxxxxxxxx">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-phone"></i>
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
					<label class="form-label">Birthdate</label>
                    <div class="input-group">
                      <input type="date" name="birthdate" value="<?=set_value('birthdate')?>" class="form-control">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-calendar"></i>
                        </span>
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

                  <!-- [Team Note - 2026-03-11] Student account section: toggle opens the optional LRN and School ID fields. -->
                  <div class="student-toggle-card">
                    <div class="student-toggle-copy">
                      <h5>Are you a student?</h5>
                      <p>Click Yes to add your account details.</p>
                    </div>

                    <button
                      type="button"
                      class="student-toggle-btn"
                      id="studentToggleBtn"
                      aria-expanded="<?=$has_student_details ? 'true' : 'false'?>"
                      aria-controls="studentExtraFields">
                      Yes
                    </button>

                    <div
                      class="student-extra-fields<?=$has_student_details ? ' is-open' : ''?>"
                      id="studentExtraFields"
                      <?=$has_student_details ? '' : 'hidden'?>>
                      <div class="form-group mb-2">
                        <label class="form-label">LRN</label>
                        <div class="input-group">
                          <input type="text" name="lrn" value="<?=set_value('lrn')?>" class="form-control" placeholder="Enter your LRN">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="mdi mdi-card-account-details"></i>
                            </span>
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <label class="form-label">School ID</label>
                        <div class="input-group">
                          <input type="text" name="school_id" value="<?=set_value('school_id')?>" class="form-control" placeholder="Enter your School ID">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="mdi mdi-card-bulleted-outline"></i>
                            </span>
                          </div>
                        </div>
                      </div>

                      <div
                        class="student-remove-wrap<?=$has_student_details ? ' is-visible' : ''?>"
                        id="studentRemoveWrap"
                        <?=$has_student_details ? '' : 'hidden'?>>
                        <button
                          type="button"
                          class="student-remove-btn"
                          id="studentRemoveBtn">
                          Remove
                        </button>
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
    <script>
      // [Team Note - 2026-03-11] Student account toggle: shows or hides the optional student identifier fields.
      (function () {
        var toggleButton = document.getElementById('studentToggleBtn');
        var removeWrap = document.getElementById('studentRemoveWrap');
        var removeButton = document.getElementById('studentRemoveBtn');
        var extraFields = document.getElementById('studentExtraFields');
        var lrnInput = document.querySelector('input[name="lrn"]');
        var schoolIdInput = document.querySelector('input[name="school_id"]');

        if (!toggleButton || !removeWrap || !removeButton || !extraFields) {
          return;
        }

        function syncState(isOpen) {
          extraFields.classList.toggle('is-open', isOpen);
          toggleButton.classList.toggle('is-open', isOpen);
          removeWrap.classList.toggle('is-visible', isOpen);
          toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
          extraFields.hidden = !isOpen;
          removeWrap.hidden = !isOpen;
        }

        syncState(extraFields.classList.contains('is-open'));

        toggleButton.addEventListener('click', function () {
          syncState(!extraFields.classList.contains('is-open'));
        });

        removeButton.addEventListener('click', function () {
          if (lrnInput) {
            lrnInput.value = '';
          }

          if (schoolIdInput) {
            schoolIdInput.value = '';
          }

          syncState(false);
        });
      })();
    </script>
    
    <?php $this->load->view('support_chat_widget'); ?>
  </body>
</html>

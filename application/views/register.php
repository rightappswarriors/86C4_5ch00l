<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= isset($role) && $role === 'student' ? 'Student' : 'Parent' ?> Register :: CBHCA Portal</title>
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
      /* Improved Form Styles */
      .form-group {
        margin-bottom: 1.25rem;
      }
      
      .form-label {
        font-weight: 600;
        font-size: 0.875rem;
        color: #4a4a4a;
        margin-bottom: 0.5rem;
        display: block;
      }
      
      .input-group-merged {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease, transform 0.2s ease;
      }
      
      .input-group-merged:focus-within {
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.25);
        transform: translateY(-1px);
      }
      
      .input-group-merged .form-control {
        border: 2px solid #e8e8e8;
        border-right: none;
        padding: 0.75rem 1rem;
        transition: border-color 0.3s ease, background-color 0.3s ease;
      }
      
      .input-group-merged .form-control:focus {
        border-color: #6366f1;
        background-color: #fafafa;
      }
      
      .input-group-merged .input-group-text {
        border: 2px solid #e8e8e8;
        border-left: none;
        background-color: #fff;
        color: #6366f1;
        padding: 0.75rem 1rem;
      }
      
      /* Improved Button Styles */
      .auth-submit-btn {
        border-radius: 8px;
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        letter-spacing: 0.5px;
        text-transform: none;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #274fee 0%, #0ec7ec 100%);
        border: none;
        color: white;
        position: relative;
        overflow: hidden;
      }
      
      .auth-submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #180add 0%, #1ab9dd 100%);
        transition: left 0.3s ease;
        z-index: 0;
      }
      
      .auth-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
      }
      
      .auth-submit-btn:hover::before {
        left: 0;
      }
      
      .auth-submit-btn:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
      }
      
      .auth-submit-btn .btn-text,
      .auth-submit-btn .btn-loader {
        position: relative;
        z-index: 1;
      }
      
      .auth-submit-btn .btn-loader {
        display: none;
      }
      
      .auth-submit-btn.loading .btn-text {
        display: none;
      }
      
      .auth-submit-btn.loading .btn-loader {
        display: inline-block;
      }
      
      /* Student Toggle Card */
      .student-toggle-card {
        background: linear-gradient(135deg, #f0f4ff 0%, #e8f4f8 100%);
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1.5rem;
        border: 1px solid #e0e7ff;
        transition: all 0.3s ease;
      }
      
      .student-toggle-card:hover {
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.12);
      }
      
      .student-toggle-copy h5 {
        color: #65a0ee;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }
      
      .student-toggle-copy p {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0;
      }
      
      .student-toggle-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      
      .student-toggle-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
      }
      
      .student-toggle-btn.is-open {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      }
      
      .student-extra-fields {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed #c7d2fe;
      }
      
      .student-remove-btn {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.75rem;
      }
      
      .student-remove-btn:hover {
        background: #ef4444;
        color: white;
      }
      
      /* Auth Header */
      .auth-header {
        text-align: center;
        margin-bottom: 2rem;
      }
      
      .auth-header .school-logo {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #35a0f1 0%, #0c81db 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
      }
      
      .auth-header .school-logo i {
        font-size: 2rem;
        color: white;
      }
      
      .auth-header h2 {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 0.5rem;
      }
      
      .auth-header p {
        color: #6b7280;
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
            <div class="col-lg-5 mx-auto">
              <div class="auth-card">
			  
			  <div class="auth-header">
                <div class="school-logo">
                  <i class="mdi mdi-school"></i>
                </div>
			  	<h2><?= isset($role) && $role === 'student' ? 'Student Registration' : 'Parent Registration' ?></h2>
			  	<p>Join CBHCA Portal today</p>
			  </div>
			  
			  <?php if ($this->session->flashdata('error')): ?>
			  <div class="alert alert-danger" style="margin-bottom: 20px;">
				<i class="mdi mdi-alert-circle"></i> <?= $this->session->flashdata('error') ?>
			  </div>
			  <?php endif; ?>
			  <?=validation_errors()?>
			  <?php
			    $has_student_details = set_value('lrn') || set_value('school_id');
			    $current_role = isset($role) ? $role : 'parent';
			  ?>
			  
                <form method="POST" action="<?=site_url("register/validation")?>" class="auth-form">
                  <input type="hidden" name="role" value="<?= $current_role ?>">
                  
                  <div class="form-group">
					<label class="form-label">Email Address</label>
                    <div class="input-group input-group-merged">
                      <input type="email" name="emailadd" value="<?=set_value('emailadd')?>" class="form-control form-control-lg" placeholder="email@sample.com">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-email"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				  <div class="form-group">
					<label class="form-label">Mobile Number</label>
                    <div class="input-group input-group-merged">
                      <input type="text" name="mobileno" value="<?=set_value('mobileno')?>" class="form-control form-control-lg" placeholder="09xxxxxxxxx">
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
						<div class="input-group input-group-merged">
						  <input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control form-control-lg" placeholder="Juan">
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
						<div class="input-group input-group-merged">
						  <input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control form-control-lg" placeholder="Dela Cruz">
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
                    <div class="input-group input-group-merged">
                      <input type="date" name="birthdate" value="<?=set_value('birthdate')?>" class="form-control form-control-lg">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-calendar"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
                  <div class="form-group">
					<label class="form-label">Password</label>
                    <div class="input-group input-group-merged">
                      <input type="password" name="userpass" value="<?=set_value('userpass')?>" class="form-control form-control-lg" placeholder="Create a password">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Confirm Password</label>
					<div class="input-group input-group-merged">
                      <input type="password" name="repeatpass" value="<?=set_value('repeatpass')?>" class="form-control form-control-lg" placeholder="Confirm your password">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock-check"></i>
                        </span>
                      </div>
                    </div>
                  </div>

                  <?php if ($current_role === 'student'): ?>
                  <div class="student-toggle-card" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border: 2px solid #6366f1;">
                    <div class="student-toggle-copy">
                      <h5 style="color: #6366f1;">Student Registration</h5>
                      <p>Please provide your LRN or School ID for verification.</p>
                    </div>
                    <div class="form-group mb-2 mt-3">
                      <label class="form-label">LRN (Learner Reference Number)</label>
                      <div class="input-group input-group-merged">
                        <input type="text" name="lrn" value="<?=set_value('lrn')?>" class="form-control form-control-lg" placeholder="Enter your LRN">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="mdi mdi-card-account-details"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group mb-0">
                      <label class="form-label">School ID</label>
                      <div class="input-group input-group-merged">
                        <input type="text" name="school_id" value="<?=set_value('school_id')?>" class="form-control form-control-lg" placeholder="Enter your School ID">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="mdi mdi-card-bulleted-outline"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php else: ?>
                  <div class="student-toggle-card" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #10b981;">
                    <div class="student-toggle-copy">
                      <h5 style="color: #10b981;">Parent Registration</h5>
                      <p>Register as a parent to enroll your child and manage their education.</p>
                    </div>
                  </div>
                  <?php endif; ?>
                   
                  <div class="form-group mt-4">
                    <button type="submit" class="auth-submit-btn btn btn-lg btn-block font-weight-bold transition-btn">
                       <span class="btn-text">
                         <i class="mdi mdi-account-plus mr-2"></i> Create Account
                       </span>
                       <span class="btn-loader">
                         <i class="mdi mdi-loading mdi-spin mr-2"></i> Creating...
                       </span>
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
      </div>
    </div>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
    <script src="<?=base_url()?>assets/js/shared/off-canvas.js"></script>
    <script src="<?=base_url()?>assets/js/shared/misc.js"></script>
    <script>
      document.querySelector('.auth-form').addEventListener('submit', function() {
        var submitBtn = document.querySelector('.auth-submit-btn');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
      });
      
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
          toggleButton.textContent = isOpen ? 'No' : 'Yes';
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

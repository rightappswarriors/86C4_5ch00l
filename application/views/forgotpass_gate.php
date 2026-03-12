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
      
      /* Student Toggle Card */
      .student-toggle-card {
        background: linear-gradient(135deg, #f0f4ff 0%, #e8f4f8 100%);
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1rem;
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
        font-size: 0.95rem;
      }
      
      .student-toggle-copy p {
        color: #6b7280;
        font-size: 0.8rem;
        margin-bottom: 0;
      }
      
      .student-toggle-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 0.4rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.85rem;
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
      
      .student-extra-fields.is-open {
        display: block;
      }
      
      .student-remove-btn {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
      }
      
      .student-remove-btn:hover {
        background: #ef4444;
        color: white;
      }
      
      .student-remove-wrap {
        display: none;
      }
      
      .student-remove-wrap.is-visible {
        display: block;
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
                        <input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" placeholder="Enter first name">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">LAST NAME</label>
                        <input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" placeholder="Enter last name">
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
                        <!-- [Team Note - 2026-03-09] Replaced Phone Number input with Birthdate -->
                        <label class="form-label">BIRTHDATE</label>
                        <input type="date" name="birthdate" value="<?=set_value('birthdate')?>" class="form-control">
                      </div>
                    </div>
                  </div>

                  <?php
                    // [Team Note - 2026-03-11] Tracks whether the optional student fields should stay open after form reload.
                    $has_student_details = set_value('lrn') || set_value('school_id');
                  ?>

                  <!-- Student Toggle Card - Only show for students -->
                  <div class="student-toggle-card">
                    <div class="student-toggle-copy">
                      <h5>Are you a student?</h5>
                      <p>Click Yes if you're a current student to add your account details.</p>
                    </div>

                    <button
                      type="button"
                      class="student-toggle-btn"
                      id="studentToggleBtn"
                      aria-expanded="<?=$has_student_details ? 'true' : 'false'?>">
                      Yes
                    </button>

                    <div
                      class="student-extra-fields<?=$has_student_details ? ' is-open' : ''?>"
                      id="studentExtraFields"
                      <?=$has_student_details ? '' : 'hidden'?>>
                      <div class="row align-items-end">
                        <div class="col-md-5">
                          <div class="form-group mb-0">
                            <label class="form-label">LRN</label>
                            <input type="text" name="lrn" value="<?=set_value('lrn')?>" class="form-control" placeholder="Enter LRN">
                          </div>
                        </div>
                        <div class="col-md-2 text-center">
                          <label class="form-label d-block">OR</label>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group mb-0">
                            <label class="form-label">SCHOOL ID</label>
                            <input type="text" name="school_id" value="<?=set_value('school_id')?>" class="form-control" placeholder="Enter school ID">
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
                          Close
                        </button>
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

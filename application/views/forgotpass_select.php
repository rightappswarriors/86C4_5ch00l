<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Select Account :: CBHCA Portal</title>
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
      .result-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s;
      }
      .result-card:hover {
        border-color: #4a73e8;
        box-shadow: 0 4px 8px rgba(74, 115, 232, 0.2);
      }
      .result-card.selected {
        border-color: #4a73e8;
        background: #f0f4ff;
      }
      .result-card h4 {
        margin: 0 0 10px 0;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
      }
      .result-card .info-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
      }
      .result-card .info-item {
        font-size: 14px;
        color: #666;
      }
      .result-card .info-item strong {
        color: #333;
      }
      .account-type {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
      }
      .account-type.parent {
        background: #e8f5e9;
        color: #2e7d32;
      }
      .account-type.student {
        background: #e3f2fd;
        color: #1565c0;
      }
      .child-info {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
      }
      .child-info h5 {
        margin: 0 0 10px 0;
        color: #555;
        font-size: 14px;
      }
      .child-item {
        background: #f9f9f9;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 8px;
        font-size: 13px;
      }
      .child-item:last-child {
        margin-bottom: 0;
      }
      .btn-reset {
        background: #4a73e8;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
      }
      .btn-reset:hover {
        background: #3a5cc8;
      }
      .btn-reset:disabled {
        background: #ccc;
        cursor: not-allowed;
      }
      .no-parent {
        background: #fff3e0;
        padding: 15px;
        border-radius: 5px;
        color: #e65100;
        font-size: 14px;
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
            <div class="col-lg-8 mx-auto">
              <div class="auth-card">
                <div class="auth-header">
                  <div class="school-logo">
                    <i class="mdi mdi-account-check"></i>
                  </div>
                  <h2>Account Found</h2>
                  <p>Select the account you want to reset password for</p>
                </div>

                <?php if($this->session->flashdata('message')): ?>
                  <div class="auth-error">
                    <?=$this->session->flashdata('message')?>
                  </div>
                <?php endif; ?>

                <?php if($lookup_type === 'parent'): ?>
                  <!-- Parent found - show their info and linked children -->
                  <div class="result-card selected" onclick="selectAccount(<?=$parent->id?>, 'parent')">
                    <h4>
                      <span class="account-type parent">Parent Account</span>
                      <?=htmlspecialchars(trim(($parent->firstname ?? '') . ' ' . ($parent->middlename ?? '') . ' ' . ($parent->lastname ?? '')))?>
                    </h4>
                    <div class="info-row">
                      <div class="info-item"><strong>Phone:</strong> <?=htmlspecialchars($parent->mobileno)?></div>
                      <div class="info-item"><strong>Email:</strong> <?=htmlspecialchars($parent->emailadd ?: 'N/A')?></div>
                    </div>
                    
                    <?php if(!empty($children)): ?>
                      <div class="child-info">
                        <h5><i class="mdi mdi-account-multiple"></i> Linked Children (<?=count($children)?>)</h5>
                        <?php foreach($children as $child): ?>
                          <div class="child-item">
                            <strong><?=htmlspecialchars(trim(($child->firstname ?? '') . ' ' . ($child->lastname ?? '')))?></strong> - 
                            Grade <?=htmlspecialchars($child->gradelevel)?> 
                            (<?=htmlspecialchars($child->enrollstatus)?>)
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>

                <?php elseif($lookup_type === 'student'): ?>
                  <!-- Student found - show student and parent info -->
                  
                  <!-- Student Account Option -->
                  <div class="result-card" onclick="selectAccount(0, 'student')">
                    <h4>
                      <span class="account-type student">Student Account</span>
                      <?=htmlspecialchars(trim(($student->firstname ?? '') . ' ' . ($student->middlename ?? '') . ' ' . ($student->lastname ?? '')))?>
                    </h4>
                    <div class="info-row">
                      <div class="info-item"><strong>LRN:</strong> <?=htmlspecialchars($student->lrn ?: 'N/A')?></div>
                      <div class="info-item"><strong>Student No:</strong> <?=htmlspecialchars($student->studentno ?: 'N/A')?></div>
                      <?php if($enrollment): ?>
                        <div class="info-item"><strong>Grade:</strong> <?=htmlspecialchars($enrollment->gradelevel)?></div>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Parent Account Option -->
                  <?php if($parent): ?>
                    <div class="result-card" onclick="selectAccount(<?=$parent->id?>, 'parent')">
                      <h4>
                        <span class="account-type parent">Parent Account</span>
                        <?=htmlspecialchars(trim(($parent->firstname ?? '') . ' ' . ($parent->middlename ?? '') . ' ' . ($parent->lastname ?? '')))?>
                      </h4>
                      <div class="info-row">
                        <div class="info-item"><strong>Phone:</strong> <?=htmlspecialchars($parent->mobileno)?></div>
                        <div class="info-item"><strong>Email:</strong> <?=htmlspecialchars($parent->emailadd ?: 'N/A')?></div>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="no-parent">
                      <i class="mdi mdi-alert"></i> No parent account linked to this student. You can only reset the student account.
                    </div>
                  <?php endif; ?>

                <?php endif; ?>

                <form method="POST" action="<?=site_url('login/forgotpass_select_account')?>" id="select-form">
                  <input type="hidden" name="user_id" id="selected_user_id" value="">
                  <input type="hidden" name="user_type" id="selected_user_type" value="">
                  
                  <button type="submit" class="btn-reset" id="reset-btn" disabled>
                    <i class="mdi mdi-lock-reset"></i> Continue to Reset Password
                  </button>
                </form>

                <div class="text-center mt-4">
                  <a href="<?=site_url('login/forgotpass_gate')?>" class="return-link">
                    <i class="mdi mdi-arrow-left"></i> Back to Search
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
      function selectAccount(userId, userType) {
        // Remove previous selection from all cards
        var cards = document.querySelectorAll('.result-card');
        for (var i = 0; i < cards.length; i++) {
          cards[i].classList.remove('selected');
        }

        // Set the selected card as highlighted
        event.target.closest('.result-card').classList.add('selected');
        
        // Enable submit button and set values
        document.getElementById('selected_user_id').value = userId;
        document.getElementById('selected_user_type').value = userType;
        document.getElementById('reset-btn').disabled = false;
      }

      // For students without parent, auto-select student on page load
      <?php if($lookup_type === 'student' && empty($parent)): ?>
      window.onload = function() {
        selectAccount('student_<?=$student->id?>', 'student');
      };
      <?php endif; ?>
    </script>
    
    <?php $this->load->view('support_chat_widget'); ?>
  </body>
</html>

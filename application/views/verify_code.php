<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verify Code :: CBHCA Portal</title>
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/shared/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/auth.css">
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
    
    <style>
        .auth-form .form-control { border-radius: 8px; padding: 12px 15px; height: auto; font-size: 18px; text-align: center; letter-spacing: 5px; }
        .auth-form label { font-weight: 500; color: #333; margin-bottom: 8px; }
        .alert-message { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .delivery-info { background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .delivery-info p { margin: 5px 0; color: #555; }
        .delivery-info i { margin-right: 8px; color: #007bff; }
        .countdown { color: #666; font-size: 14px; }
        .resend-link { color: #007bff; cursor: pointer; text-decoration: none; }
        .resend-link:hover { text-decoration: underline; }
        .resend-link.disabled { color: #999; cursor: not-allowed; }
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
                  <i class="mdi mdi-shield-check"></i>
                </div>
                <h2>Verify Your Identity</h2>
                <p>Enter the verification code</p>
              </div>
              
              <div class="auth-form">
                  <?php if($this->session->flashdata('message')): ?>
                  <div class="alert-message alert-error">
                      <?=$this->session->flashdata('message')?>
                  </div>
                  <?php endif; ?>
                  
                  <div class="delivery-info">
                    <p><i class="mdi mdi-email-outline"></i> Email: <strong><?=$masked_email?></strong></p>
                    <p><i class="mdi mdi-cellphone"></i> Phone: <strong><?=$masked_mobile?></strong></p>
                  </div>
                  
                  <form action="<?=site_url('login/verify_code_submit')?>" method="post">
                      <div class="form-group">
                          <label for="code">Verification Code</label>
                          <input type="text" class="form-control" id="code" name="code" placeholder="Enter 6-digit code" maxlength="6" required>
                      </div>
                      
                      <div class="form-group mt-4">
                        <button type="submit" class="auth-submit-btn btn-block">
                          Verify Code
                        </button>
                      </div>
                      
                      <div class="text-center mt-3">
                          <p class="countdown">Resend code in <span id="countdown">60</span> seconds</p>
                          <p><a href="javascript:void(0)" class="resend-link disabled" id="resend-link"><i class="mdi mdi-refresh"></i> Resend Code</a></p>
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
      </div>
    </div>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
    <script src="<?=base_url()?>assets/js/shared/off-canvas.js"></script>
    <script src="<?=base_url()?>assets/js/shared/misc.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#code').focus();
            $('#code').on('input', function(e) { this.value = this.value.replace(/[^0-9]/g, ''); });
            
            var countdownSeconds = 60;
            var countdownInterval;
            
            function startCountdown() {
                countdownSeconds = 60;
                $('#countdown').text(countdownSeconds);
                $('#resend-link').addClass('disabled');
                
                countdownInterval = setInterval(function() {
                    countdownSeconds--;
                    $('#countdown').text(countdownSeconds);
                    if (countdownSeconds <= 0) {
                        clearInterval(countdownInterval);
                        $('#resend-link').removeClass('disabled');
                    }
                }, 1000);
            }
            
            startCountdown();
            
            $('#resend-link').on('click', function() {
                if ($(this).hasClass('disabled')) return;
                
                $.ajax({
                    url: '<?=site_url("login/resend_code")?>',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('A new verification code has been sent.');
                            startCountdown();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
    
    <?php $this->load->view('support_chat_widget'); ?>
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password :: CBHCA Portal</title>
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/shared/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/auth.css">
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png" />
    
    <style>
        .auth-form .form-control { border-radius: 8px; padding: 12px 15px; height: auto; }
        .auth-form label { font-weight: 500; color: #333; margin-bottom: 8px; }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; }
        .input-icon .form-control { padding-left: 40px; }
        .alert-message { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-info { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .loading-spinner { display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-radius: 50%; border-top: 3px solid #007bff; animation: spin 1s linear infinite; margin-right: 10px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        #proceed-btn { display: none; margin-top: 15px; }
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
                  <i class="mdi mdi-lock-question"></i>
                </div>
                <h2>Forgot Password?</h2>
                <p>Enter your email or mobile number</p>
              </div>
              
              <div class="auth-form">
                  <div id="message-container"></div>
                  
                  <form id="forgotpass-form">
                      <div class="form-group">
                          <label for="identifier">Email Address or Mobile Number</label>
                          <div class="input-icon">
                              <i class="mdi mdi-account-outline"></i>
                              <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your email or mobile number" required>
                          </div>
                          <small class="form-text text-muted">Example: john@example.com or 09123456789</small>
                      </div>
                      
                      <div class="form-group mt-4">
                        <button type="submit" class="auth-submit-btn btn-block" id="submit-btn">
                          <span class="btn-text">Send Verification Code</span>
                        </button>
                      </div>
                      
                      <button type="button" id="proceed-btn" class="auth-submit-btn btn-block">
                          <span class="btn-text">Click to Continue</span>
                      </button>
                      
                      <div class="form-group mt-3">
                        <a href="<?=site_url("login")?>" class="auth-submit-btn auth-submit-btn-outline btn-block">
                          <i class="mdi mdi-login mr-2"></i> Back to Login
                        </a>
                      </div>
                      
                      <div class="auth-footer-text">
                        <p>Don't have an account? <a href="<?=site_url("register")?>">Create new account</a></p>
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
    
    <?php $this->load->view('support_chat_widget'); ?>
    
    <script>
        var redirectUrl = '';
        
        $(document).ready(function() {
            $('#forgotpass-form').on('submit', function(e) {
                e.preventDefault();
                
                var identifier = $('#identifier').val().trim();
                var submitBtn = $('#submit-btn');
                var btnText = submitBtn.find('.btn-text');
                
                if (!identifier) {
                    showMessage('Please enter your email or mobile number.', 'error');
                    return;
                }
                
                submitBtn.prop('disabled', true);
                btnText.html('<span class="loading-spinner"></span>Sending...');
                
                $.ajax({
                    url: '<?=site_url("login/check_and_send_code")?>',
                    type: 'POST',
                    data: { identifier: identifier },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showMessage('Verification codes sent!<br>Email: ' + response.email + '<br>Mobile: ' + response.mobile, 'success');
                            redirectUrl = response.redirect;
                            $('#submit-btn').hide();
                            $('#proceed-btn').show();
                            $('#proceed-btn').on('click', function() {
                                window.location.href = redirectUrl;
                            });
                            
                        } else if (response.status === 'not_registered') {
                            showMessage('Account not found. Redirecting to registration...', 'info');
                            setTimeout(function() { window.location.href = response.redirect; }, 2000);
                        } else {
                            showMessage(response.message, 'error');
                            submitBtn.prop('disabled', false);
                            btnText.html('Send Verification Code');
                        }
                    },
                    error: function(xhr, status, error) {
                        showMessage('An error occurred: ' + error, 'error');
                        submitBtn.prop('disabled', false);
                        btnText.html('Send Verification Code');
                    }
                });
            });
            
            function showMessage(message, type) {
                var html = '<div class="alert-message alert-' + type + '">' + message + '</div>';
                $('#message-container').html(html);
            }
        });
    </script>
  </body>
</html>

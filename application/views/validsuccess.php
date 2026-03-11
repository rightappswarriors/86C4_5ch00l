<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registration Successful :: CBHCA Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/flag-icon-css/css/flag-icon.min.css">
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
      /* Success Page Styles */
      .success-page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
      }

      /* Animated background shapes */
      .success-page-wrapper::before,
      .success-page-wrapper::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
      }

      .success-page-wrapper::before {
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        top: -100px;
        left: -100px;
      }

      .success-page-wrapper::after {
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        bottom: -50px;
        right: -50px;
        animation-delay: -3s;
      }

      @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
      }

      .success-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-width: 450px;
        width: 90%;
        position: relative;
        z-index: 1;
        animation: slideUp 0.6s ease-out;
      }

      @keyframes slideUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        animation: scaleIn 0.5s ease-out 0.3s both;
      }

      @keyframes scaleIn {
        from {
          opacity: 0;
          transform: scale(0);
        }
        to {
          opacity: 1;
          transform: scale(1);
        }
      }

      .success-icon i {
        font-size: 3rem;
        color: white;
        animation: checkDraw 0.4s ease-out 0.6s both;
      }

      @keyframes checkDraw {
        from {
          opacity: 0;
          transform: scale(0);
        }
        to {
          opacity: 1;
          transform: scale(1);
        }
      }

      .success-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
      }

      .success-message {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
      }

      .login-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.875rem 2rem;
        background: linear-gradient(135deg, #274fee 0%, #0ec7ec 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
      }

      .login-btn::before {
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

      .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
      }

      .login-btn:hover::before {
        left: 0;
      }

      .login-btn span {
        position: relative;
        z-index: 1;
      }

      .login-btn i {
        position: relative;
        z-index: 1;
        margin-left: 0.5rem;
      }

      .success-footer {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
      }

      .success-footer p {
        color: #9ca3af;
        font-size: 0.875rem;
        margin-bottom: 0;
      }

      .success-footer a {
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
      }

      .success-footer a:hover {
        color: #4f46e5;
      }

      /* Confetti animation */
      .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #f00;
        animation: confetti-fall 3s ease-in-out infinite;
      }

      @keyframes confetti-fall {
        0% {
          transform: translateY(-100vh) rotate(0deg);
          opacity: 1;
        }
        100% {
          transform: translateY(100vh) rotate(720deg);
          opacity: 0;
        }
      }
    </style>
  </head>
  <body>
    <div class="success-page-wrapper">
      <!-- Confetti pieces -->
      <div class="confetti" style="left: 10%; background: #10b981; animation-delay: 0s;"></div>
      <div class="confetti" style="left: 20%; background: #6366f1; animation-delay: 0.2s;"></div>
      <div class="confetti" style="left: 30%; background: #f59e0b; animation-delay: 0.4s;"></div>
      <div class="confetti" style="left: 40%; background: #ec4899; animation-delay: 0.1s;"></div>
      <div class="confetti" style="left: 50%; background: #10b981; animation-delay: 0.3s;"></div>
      <div class="confetti" style="left: 60%; background: #6366f1; animation-delay: 0.5s;"></div>
      <div class="confetti" style="left: 70%; background: #f59e0b; animation-delay: 0.15s;"></div>
      <div class="confetti" style="left: 80%; background: #ec4899; animation-delay: 0.35s;"></div>
      <div class="confetti" style="left: 90%; background: #10b981; animation-delay: 0.25s;"></div>

      <div class="success-card">
        <div class="success-icon">
          <i class="mdi mdi-check"></i>
        </div>
        
        <h1 class="success-title">Account Created!</h1>
        
        <p class="success-message">
          Congratulations! Your account has been successfully created. You can now log in to access the CBHCA Portal.
        </p>
        
        <a href="<?=site_url("login")?>" class="login-btn">
          <span>Proceed to Login</span>
          <i class="mdi mdi-arrow-right"></i>
        </a>
        
        <div class="success-footer">
          <p>Need help? <a href="<?=site_url()?>">Contact Support</a></p>
        </div>
      </div>
    </div>
  </body>
</html>

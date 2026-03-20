<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Select Account Type :: CBHCA Portal</title>
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
      /* Role Selection Page Styles */
      .role-selection-container {
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
      }

      .role-header {
        text-align: center;
        margin-bottom: 2.5rem;
      }

      .role-header .school-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
      }

      .role-header .school-logo i {
        font-size: 2.5rem;
        color: white;
      }

      .role-header h1 {
        color: #1f2937;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 0.5rem;
      }

      .role-header p {
        color: #6b7280;
        font-size: 1.1rem;
      }

      .role-cards-wrapper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
      }

      @media (max-width: 768px) {
        .role-cards-wrapper {
          grid-template-columns: 1fr;
        }
      }

      .role-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem 2rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        text-decoration: none;
        display: block;
        border: 2px solid transparent;
      }

      .role-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      }

      /* Parent Card Styles */
      .role-card.parent-card {
        border-color: #10b981;
      }

      .role-card.parent-card:hover {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
      }

      .role-card.parent-card .role-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      }

      /* Student Card Styles */
      .role-card.student-card {
        border-color: #6366f1;
      }

      .role-card.student-card:hover {
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
      }

      .role-card.student-card .role-icon {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
      }

      .role-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
      }

      .role-card:hover .role-icon {
        transform: scale(1.05);
      }

      .role-icon i {
        font-size: 2.75rem;
        color: white;
      }

      .role-card h2 {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
      }

      .role-card p {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
      }

      .role-card .role-arrow {
        margin-top: 1.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
      }

      .role-card.parent-card .role-arrow {
        color: #10b981;
      }

      .role-card.student-card .role-arrow {
        color: #6366f1;
      }

      .role-card:hover .role-arrow {
        gap: 0.75rem;
      }

      .role-card .role-arrow i {
        transition: transform 0.3s ease;
      }

      .role-card:hover .role-arrow i {
        transform: translateX(5px);
      }

      .back-link {
        text-align: center;
        margin-top: 2rem;
      }

      .back-link a {
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
      }

      .back-link a:hover {
        color: #374151;
        transform: translateX(-5px);
      }

      .auth-page-logo {
        position: absolute;
        top: 20px;
        left: 30px;
        z-index: 1000;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 4px;
      }

      .auth-page-logo a {
        display: block;
      }

      .auth-page-logo img {
        width: 90px;
        height: auto;
      }

      .auth-page-logo .auth-logo-text {
        font-size: 60px;
        line-height: 1;
        font-weight: 600;
        color: #2196f3;
        margin: 0;
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
                
                <div class="role-header">
                  <div class="school-logo" style="background: linear-gradient(135deg, #35a0f1 0%, #0c81db 100%);">
                    <i class="mdi mdi-account-multiple-plus"></i>
                  </div>
                  <h1>Create Your Account</h1>
                  <p>Select your account type to get started</p>
                </div>

                <div class="role-cards-wrapper">
                  <!-- Parent Card -->
                  <a href="<?=site_url('register/parent')?>" class="role-card parent-card">
                    <div class="role-icon">
                      <i class="mdi mdi-account-heart"></i>
                    </div>
                    <h2>Parent</h2>
                    <p>Register as a parent to enroll your child and manage their academic progress.</p>
                    <span class="role-arrow">
                      Register as Parent <i class="mdi mdi-arrow-right"></i>
                    </span>
                  </a>

                  <!-- Student Card -->
                  <a href="<?=site_url('register/student')?>" class="role-card student-card">
                    <div class="role-icon">
                      <i class="mdi mdi-school"></i>
                    </div>
                    <h2>Student</h2>
                    <p>Register as a student to access your enrolled subjects and view grades.</p>
                    <span class="role-arrow">
                      Register as Student <i class="mdi mdi-arrow-right"></i>
                    </span>
                  </a>
                </div>

                <div class="back-link">
                  <a href="<?=site_url('login')?>">
                    <i class="mdi mdi-arrow-left"></i> Back to Login
                  </a>
                </div>

              </div>
              <p class="auth-copyright text-center">© <?=date("Y")?> CBHCA Online Portal. All rights reserved.</p>
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

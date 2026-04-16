<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'BOB HUGHES CHRISTIAN ACADEMY' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdi/font@6.5.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">
    <style>
      body { 
        background: #f5f5f5;
        background-image: linear-gradient(135deg, #4a148c 0%, #7b1fa2 100%);
        min-height: 100vh;
        padding: 20px;
      }
      .enroll-container { 
        max-width: 900px; 
        margin: 0 auto;
      }
      .card { 
        border-radius: 20px; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.3); 
        border: none;
      }
      .card-header { 
        background: #4a148c; 
        color: white; 
        border-radius: 20px 20px 0 0 !important;
        padding: 20px;
      }
      .card-header h2 {
        margin: 0;
      }
      .btn-primary { 
        background: #4a148c; 
        border-color: #4a148c; 
      }
      .btn-primary:hover { 
        background: #311b92; 
        border-color: #311b92; 
      }
      .btn-submit {
        background: #28a745;
        border-color: #28a745;
        padding: 12px 40px;
        border-radius: 25px;
        font-size: 16px;
      }
      .btn-submit:hover {
        background: #218838;
        border-color: #218838;
      }
    </style>
  </head>
  <body>
    <div class="enroll-container">
      <div class="card">
        <div class="card-header p-3 text-center">
          <h4 class="mb-0"><i class="mdi mdi-school"></i> BOB HUGHES CHRISTIAN ACADEMY - Enrollment</h4>
        </div>
        <div class="card-body">
          <?php if($this->session->flashdata('message')): ?>
            <div class="alert alert-info"><?= $this->session->flashdata('message') ?></div>
          <?php endif; ?>
          
          <?php if(isset($template)): ?>
            <?php 
              $view_data = [];
              if(isset($data)) $view_data = $data;
              $view_content = $this->load->view($template, $view_data, true);
              echo $view_content;
            ?>
          <?php else: ?>
            <p>Loading...</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/classroom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.join-class-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: #333;
}

.join-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.join-header {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: #fff;
    padding: 30px;
    text-align: center;
}

.join-header h3 {
    margin: 0 0 10px 0;
    font-weight: 600;
}

.join-header p {
    margin: 0;
    opacity: 0.9;
}

.join-body {
    padding: 30px;
}

.join-form {
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-group label .required {
    color: #e74c3c;
}

.form-control {
    width: 100%;
    padding: 14px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    outline: none;
}

.btn-join {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: #fff;
    border: none;
    padding: 14px 30px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
}

.btn-join:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.help-text {
    text-align: center;
    color: #666;
    font-size: 14px;
    margin-top: 20px;
    padding: 15px;
    background: #e3f2fd;
    border-radius: 8px;
}

.help-text i {
    color: #2196F3;
    margin-right: 5px;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    border: 1px solid #1976D2;
    color: #ffffff;
}

.alert-error {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffeeba;
    color: #856404;
}

.info-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #2196F3;
}

.info-box h4 {
    margin: 0 0 10px 0;
    color: #333;
}

.info-box p {
    margin: 0;
    color: #666;
}

.class-preview {
    display: none;
    background: #f0fdf4;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
    border: 2px solid #10b981;
}

.class-preview.show {
    display: block;
}

.class-preview h4 {
    margin: 0 0 10px 0;
    color: #059669;
}

.class-preview p {
    margin: 5px 0;
    color: #333;
}

.class-preview .teacher {
    color: #666;
    font-size: 14px;
}
</style>

<div class="join-class-container">
    <div class="join-card">
        <div class="join-header">
            <h3><i class="fas fa-door-open"></i> Join a Class</h3>
            <p>Enter the class code provided by your teacher</p>
        </div>
        
        <div class="join-body">
            <?php if($this->session->flashdata('message')): ?>
                <?php $message = $this->session->flashdata('message'); ?>
                <?php $is_error = strpos($message, 'error') !== false || strpos($message, 'Error') !== false || strpos($message, 'Failed') !== false; ?>
                <?php $is_warning = strpos($message, 'already') !== false || strpos($message, 'Already') !== false; ?>
                <div class="alert <?=$is_error ? 'alert-error' : ($is_warning ? 'alert-warning' : 'alert-success')?>">
                    <?=$message?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?=$this->session->flashdata('success')?>
                </div>
            <?php endif; ?>
            
            <div class="info-box">
                <h4><i class="fas fa-info-circle"></i> How to join a class</h4>
                <p>1. Ask your teacher for the class code<br>
                2. Enter the 6-character code below<br>
                3. Click "Join Class" to enroll</p>
            </div>
            
            <?=form_open('classroom/process_join', 'class="join-form"')?>
            
            <div class="form-group">
                <label>Class Code <span class="required">*</span></label>
                <input type="text" name="class_code" id="classCode" class="form-control" 
                       placeholder="e.g., ABC123" 
                       maxlength="6" 
                       required
                       onkeyup="this.value = this.value.toUpperCase(); checkClassCode()">
            </div>
            
            <div id="classPreview" class="class-preview">
                <h4><i class="fas fa-check-circle"></i> Class Found!</h4>
                <p class="class-name"><strong></strong></p>
                <p class="subject"></p>
                <p class="teacher"></p>
            </div>
            
            <button type="submit" class="btn-join">
                <i class="fas fa-sign-in-alt"></i> Join Class
            </button>
            
            <?=form_close()?>
            
            <div class="help-text">
                <i class="fas fa-question-circle"></i>
                Can't find the class code? Ask your teacher to provide it.
            </div>
        </div>
    </div>
</div>

<script>
function checkClassCode() {
    var code = document.getElementById('classCode').value;
    var preview = document.getElementById('classPreview');
    
    if (code.length === 6) {
        // Make AJAX call to check class
        fetch('<?=site_url('classroom/check_class_code')?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'class_code=' + code
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                preview.classList.add('show');
                preview.querySelector('.class-name strong').textContent = data.class_name;
                preview.querySelector('.subject').textContent = 'Subject: ' + data.subject_name;
                preview.querySelector('.teacher').textContent = 'Teacher: ' + data.teacher_name;
            } else {
                preview.classList.remove('show');
            }
        });
    } else {
        preview.classList.remove('show');
    }
}
</script>

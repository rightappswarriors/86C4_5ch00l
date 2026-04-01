<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/student_join_class.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

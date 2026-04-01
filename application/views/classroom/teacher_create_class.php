<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_create_class.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="create-class-container">
    <?php if(isset($_GET['modal']) && $_GET['modal'] == 'true'): ?>
        <!-- Hidden when in modal mode - close handled by parent -->
    <?php else: ?>
    <a href="<?=site_url('dashboard')?>" class="back-link" style="display:inline-flex; align-items:center; gap:5px; color:#667eea; text-decoration:none; margin-bottom:15px;">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <?php endif; ?>
    <div class="class-form-card">
        <div class="class-form-header">
            <h3><i class="fas fa-plus-circle"></i> Create New Class</h3>
            <p style="margin: 10px 0 0 0; opacity: 0.9; font-size: 14px;">Fill in the details to create a new online class</p>
        </div>
        
        <div class="class-form-body">
            <?php if($this->session->flashdata('message')): ?>
                <?php $message = $this->session->flashdata('message'); ?>
                <?php $is_error = strpos($message, 'error') !== false || strpos($message, 'Error') !== false || strpos($message, 'Failed') !== false; ?>
                <div class="alert <?=$is_error ? 'alert-error' : 'alert-success'?>" id="formMessage">
                    <?=$message?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success" id="formMessage">
                    <?=$this->session->flashdata('success')?>
                </div>
            <?php endif; ?>
            
            <?=form_open('classroom/save_class', 'class="class-form" id="createClassForm"')?>
            
            <div class="form-group">
                <label>Class Name <span class="required">*</span></label>
                <input type="text" name="class_name" class="form-control" placeholder="e.g., Grade 10 - Mathematics" required>
            </div>
            
            <div class="form-group">
                <label>Subject Name <span class="required">*</span></label>
                <input type="text" name="subject_name" class="form-control" placeholder="e.g., Advanced Mathematics" required>
            </div>
            
            <div class="form-group">
                <label>Room</label>
                <input type="text" name="room" class="form-control" placeholder="e.g., Room 301">
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" placeholder="Add a description for your class (optional)"></textarea>
            </div>
            
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <i class="fas fa-save"></i> Create Class
                </button>
                <button type="button" class="btn-cancel" onclick="closeCreateClassModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
            
            <?=form_close()?>
        </div>
    </div>
</div>

<script>
// Check if we're in modal mode and add modal-mode class
var isModalMode = window.location.search.includes('modal=true');
if (isModalMode) {
    document.querySelector('.create-class-container').classList.add('modal-mode');
}

// Handle form submission
$('#createClassForm').on('submit', function(e) {
    var form = $(this);
    var submitBtn = $('#btnSubmit');
    
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
    
    // Let the form submit normally, we'll handle the redirect
    // After submission, the controller will redirect to classroom/teacher
});

// Handle after page load (post-redirect from save_class)
$(document).ready(function() {
    var successMessage = $('.alert-success').text();
    
    if (successMessage && successMessage.includes('created successfully')) {
        // Class was created successfully
        if (isModalMode) {
            // Refresh parent modal (My Classes) and close this modal
            setTimeout(function() {
                if (window.parent && window.parent.$) {
                    // Refresh the teacher classes iframe
                    var classesFrame = window.parent.$('#teacherClassesModal iframe');
                    if (classesFrame.length) {
                        classesFrame.attr('src', '<?=site_url('classroom/teacher')?>');
                    }
                    // Close this create class modal
                    window.parent.$('#teacherCreateClassModal').removeClass('show');
                }
            }, 1500);
        }
    }
});

function closeCreateClassModal() {
    if (window.parent && window.parent.$) {
        window.parent.$('#teacherCreateClassModal').removeClass('show');
    } else {
        window.location.href = '<?=site_url('classroom/teacher')?>';
    }
}
</script>

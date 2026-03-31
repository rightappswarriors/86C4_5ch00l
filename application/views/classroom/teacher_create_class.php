<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/classroom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.create-class-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: "roboto", sans-serif;
}

.class-form-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.class-form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 25px 30px;
}

.class-form-header h3 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.class-form-body {
    padding: 30px;
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
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-cancel {
    background: #6c757d;
    color: #fff;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-error {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}
</style>

<div class="create-class-container">
    <a href="<?=site_url('dashboard')?>" class="back-link" style="display:inline-flex; align-items:center; gap:5px; color:#667eea; text-decoration:none; margin-bottom:15px;">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <div class="class-form-card">
        <div class="class-form-header">
            <h3><i class="fas fa-plus-circle"></i> Create New Class</h3>
            <p style="margin: 10px 0 0 0; opacity: 0.9; font-size: 14px;">Fill in the details to create a new online class</p>
        </div>
        
        <div class="class-form-body">
            <?php if($this->session->flashdata('message')): ?>
                <?php $message = $this->session->flashdata('message'); ?>
                <?php $is_error = strpos($message, 'error') !== false || strpos($message, 'Error') !== false || strpos($message, 'Failed') !== false; ?>
                <div class="alert <?=$is_error ? 'alert-error' : 'alert-success'?>">
                    <?=$message?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?=$this->session->flashdata('success')?>
                </div>
            <?php endif; ?>
            
            <?=form_open('classroom/save_class', 'class="class-form"')?>
            
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
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Create Class
                </button>
                <a href="<?=site_url('classroom/teacher')?>" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
            
            <?=form_close()?>
        </div>
    </div>
</div>

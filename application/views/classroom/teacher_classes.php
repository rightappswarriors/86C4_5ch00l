<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/classroom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.teacher-classes-container {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.page-header h2 {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.btn-create {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: none;
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: #fff;
}

.class-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.class-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.class-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 20px;
    position: relative;
}

.class-card-header h4 {
    margin: 0 0 5px 0;
    font-weight: 600;
}

.class-card-header .subject {
    opacity: 0.9;
    font-size: 14px;
}

.class-code-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255,255,255,0.2);
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1px;
}

.class-card-body {
    padding: 20px;
}

.class-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-item i {
    color: #667eea;
    font-size: 18px;
}

.info-item .label {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
}

.info-item .value {
    font-weight: 600;
    color: #333;
}

.class-actions {
    display: flex;
    gap: 10px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    flex-wrap: wrap;
}

.btn-action {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
    border: none;
}

.btn-view {
    background: #667eea;
    color: #fff;
}

.btn-view:hover {
    background: #5568d3;
    color: #fff;
}

.btn-delete {
    background: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background: #c82333;
    color: #fff;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.empty-state i {
    font-size: 60px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h4 {
    color: #666;
    margin-bottom: 10px;
}

.empty-state p {
    color: #999;
    margin-bottom: 20px;
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

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: #fff;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 20px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h4 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-close {
    background: none;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    opacity: 0.8;
}

.modal-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 25px;
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
    min-height: 100px;
    resize: vertical;
}

.btn-modal-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-modal-cancel {
    background: #6c757d;
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-cancel:hover {
    background: #5a6268;
}

.modal-footer {
    padding: 15px 25px 25px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.back-link {
    color: #667eea;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 20px;
    font-weight: 500;
}

.back-link:hover {
    color: #5568d3;
}
</style>

<div class="teacher-classes-container">
    <a href="<?=site_url('dashboard')?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    
    <div class="page-header">
        <h2><i class="fas fa-chalkboard"></i> My Classes</h2>
        <button class="btn-create" onclick="openModal()">
            <i class="fas fa-plus"></i> Create Class
        </button>
    </div>
    
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?=$this->session->flashdata('success')?>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-error">
            <?=$this->session->flashdata('error')?>
        </div>
    <?php endif; ?>
    
    <?php if($classes->num_rows() > 0): ?>
        <?php foreach($classes->result() as $class): ?>
            <div class="class-card">
                <div class="class-card-header">
                    <h4><?=$class->class_name?></h4>
                    <div class="subject"><?=$class->subject_name?></div>
                    <div class="class-code-badge">
                        <i class="fas fa-code"></i> <?=$class->class_code?>
                    </div>
                </div>
                <div class="class-card-body">
                    <div class="class-info">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <div class="label">Teacher</div>
                                <div class="value"><?=$class->teacher_name?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-door-open"></i>
                            <div>
                                <div class="label">Room</div>
                                <div class="value"><?=$class->room ?: 'Not specified'?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <div>
                                <div class="label">Created</div>
                                <div class="value"><?=date('M d, Y', strtotime($class->created_at))?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <div class="label">Status</div>
                                <div class="value"><?=ucfirst($class->status)?></div>
                            </div>
                        </div>
                    </div>
                    <?php if($class->description): ?>
                        <p style="color: #666; margin-bottom: 15px;"><?=$class->description?></p>
                    <?php endif; ?>
                    <div class="class-actions">
                        <a href="<?=site_url('classroom/teacher_class/'.$class->id)?>" class="btn-action btn-view">
                            <i class="fas fa-eye"></i> View Class
                        </a>
                        <a href="<?=site_url('classroom/delete_class/'.$class->id)?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to archive this class?')">
                            <i class="fas fa-archive"></i> Archive
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-chalkboard"></i>
            <h4>No Classes Yet</h4>
            <p>You haven't created any classes. Start by creating your first class!</p>
            <button class="btn-create" onclick="openModal()">
                <i class="fas fa-plus"></i> Create Your First Class
            </button>
        </div>
    <?php endif; ?>
</div>

<!-- Create Class Modal -->
<div id="createClassModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-plus-circle"></i> Create New Class</h4>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <?=form_open('classroom/save_class')?>
            
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
            
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-modal-submit">
                    <i class="fas fa-save"></i> Create Class
                </button>
            </div>
            
            <?=form_close()?>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('createClassModal').classList.add('show');
}

function closeModal() {
    document.getElementById('createClassModal').classList.remove('show');
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}
</script>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_classes.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="teacher-classes-container">
    <div class="page-header">
        <h2><i class="fas fa-chalkboard"></i> My Classes</h2>
        <a href="<?=site_url('classroom/create_class')?>" class="btn-create">
            <i class="fas fa-plus"></i> Create Class
        </a>
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
        <div class="classes-header">
            <h3>My Classes (<?=$classes->num_rows()?>)</h3>
            <a href="<?=site_url('classroom/create_class')?>" class="btn-create">
                <i class="fas fa-plus"></i> Create New Class
            </a>
        </div>
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
                        <button class="btn-action btn-view" onclick="viewClass(<?=$class->id?>)">
                            <i class="fas fa-eye"></i> View Class
                        </button>
                        <button class="btn-action btn-archive" onclick="archiveClass(<?=$class->id?>)">
                            <i class="fas fa-archive"></i> Archive
                        </button>
                        <button class="btn-action btn-delete-class" onclick="deleteClass(<?=$class->id?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
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

<!-- View Class Modal -->
<div id="viewClassModal" class="modal">
    <div class="modal-content" style="max-width: 90%; width: 1000px;">
        <div class="modal-header">
            <h4><i class="fas fa-chalkboard"></i> Class Details</h4>
            <button class="modal-close" onclick="closeViewClassModal()">&times;</button>
        </div>
        <div class="modal-body" style="padding: 0; max-height: 75vh; overflow-y: auto;">
            <iframe id="classViewFrame" src="" style="width: 100%; height: 75vh; border: none;" loading="lazy" title="Class View"></iframe>
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

function viewClass(classId) {
    document.getElementById('classViewFrame').src = '<?=site_url('classroom/teacher_class_view/')?>' + classId + '?modal=true';
    document.getElementById('viewClassModal').classList.add('show');
}

function closeViewClassModal() {
    document.getElementById('viewClassModal').classList.remove('show');
}

function archiveClass(classId) {
    if (confirm('Are you sure you want to archive this class?')) {
        window.location.href = '<?=site_url('classroom/delete_class/')?>' + classId;
    }
}

function deleteClass(classId) {
    if (confirm('Are you sure you want to permanently delete this class? This will also delete all students and activities in this class.')) {
        window.location.href = '<?=site_url('classroom/permanent_delete_class/')?>' + classId;
    }
}

// Check URL for created parameter and auto-refresh
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('created') === '1') {
        // Class was just created, refresh and show success
        // Remove the query param to clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
        
        // Show success message with Create Another Class button
        setTimeout(function() {
            $('.teacher-classes-container').prepend(
                '<div class="alert alert-success">' +
                    '<div style="display: flex; justify-content: space-between; align-items: center;">' +
                        '<span>Class created successfully! Share this code with your students.</span>' +
                        '<button class="btn-create-another" onclick="openModal()">' +
                            '<i class="fas fa-plus"></i> Create Another Class' +
                        '</button>' +
                    '</div>' +
                '</div>'
            );
        }, 100);
    }
});

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}
</script>

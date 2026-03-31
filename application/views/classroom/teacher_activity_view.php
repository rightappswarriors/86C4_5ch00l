<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/classroom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.activity-submissions-container {
    padding: 20px;
    font-family: "roboto", sans-serif;
}

.back-link {
    color: #667eea;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 20px;
}

.back-link:hover {
    color: #5568d3;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
}

.page-header h2 {
    margin: 0 0 10px 0;
}

.activity-details {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
}

.submission-table {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    overflow: hidden;
}

.submission-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.submission-table thead th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.submission-table tbody tr {
    border-bottom: 1px solid #eee;
    transition: background 0.3s;
}

.submission-table tbody tr:hover {
    background: #f8f9fa;
}

.submission-table tbody td {
    padding: 15px;
    vertical-align: middle;
}

.student-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.student-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
}

.file-cell a {
    color: #667eea;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.file-cell a:hover {
    text-decoration: underline;
}

.grade-badge {
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 13px;
    font-weight: 600;
}

.grade-badge.pending {
    background: #fff3cd;
    color: #856404;
}

.grade-badge.graded {
    background: #d4edda;
    color: #155724;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
}

.status-badge.submitted {
    background: #d1ecf1;
    color: #0c5460;
}

.status-badge.graded {
    background: #d4edda;
    color: #155724;
}

.btn-grade {
    background: #667eea;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

.btn-grade:hover {
    background: #5568d3;
}

/* Grade Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
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
}

.modal-close {
    background: none;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
}

.modal-body {
    padding: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
}

.btn-submit {
    background: #667eea;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.btn-cancel {
    background: #6c757d;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 60px;
    color: #ddd;
    margin-bottom: 20px;
}
</style>

<div class="activity-submissions-container">
    <a href="<?=site_url('classroom/teacher')?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to My Classes
    </a>
    
    <div class="page-header">
        <h2><i class="fas fa-tasks"></i> <?=$activity->title?></h2>
        <p>Submissions from students</p>
        <div class="activity-details">
            <div><strong>Description:</strong> <?=$activity->description ?: 'No description'?></div>
            <div><strong>Due Date:</strong> <?=$activity->due_date ? date('M d, Y g:i A', strtotime($activity->due_date)) : 'No due date'?></div>
            <div><strong>Points:</strong> <?=$activity->points ?: 'No points assigned'?></div>
        </div>
    </div>
    
    <table class="submission-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>File</th>
                <th>Submitted</th>
                <th>Status</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($submissions->num_rows() > 0): ?>
                <?php foreach($submissions->result() as $sub): ?>
                    <tr>
                        <td>
                            <div class="student-cell">
                                <div class="student-avatar">
                                    <?=strtoupper(substr($sub->student_name, 0, 1))?>
                                </div>
                                <div><?=$sub->student_name?></div>
                            </div>
                        </td>
                        <td class="file-cell">
                            <?php if($sub->file_path): ?>
                                <a href="<?=base_url($sub->file_path)?>" target="_blank">
                                    <i class="fas fa-file"></i> <?=$sub->file_name?>
                                </a>
                            <?php else: ?>
                                <span style="color: #999;">No file</span>
                            <?php endif; ?>
                        </td>
                        <td><?=date('M d, Y g:i A', strtotime($sub->submitted_at))?></td>
                        <td>
                            <span class="status-badge <?=$sub->status?>"><?=ucfirst($sub->status)?></span>
                        </td>
                        <td>
                            <?php if($sub->grade): ?>
                                <span class="grade-badge graded"><?=$sub->grade?>/<?=$activity->points ?: 100?></span>
                            <?php else: ?>
                                <span class="grade-badge pending">Not graded</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn-grade" onclick="openGradeModal(<?=$sub->id?>, '<?=addslashes($sub->student_name)?>', <?=$sub->grade?>)">
                                <i class="fas fa-star"></i> Grade
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h4>No Submissions Yet</h4>
                            <p>Waiting for students to submit their work</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Grade Modal -->
<div id="gradeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-star"></i> Grade Submission</h4>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p id="studentName" style="margin-bottom: 15px; font-weight: 500;"></p>
            <?=form_open('classroom/grade_submission')?>
                <input type="hidden" name="submission_id" id="submissionId">
                <input type="hidden" name="activity_id" value="<?=$activity->id?>">
                <div class="form-group">
                    <label>Grade (Points)</label>
                    <input type="number" name="grade" id="gradeInput" class="form-control" placeholder="Enter grade" min="0" max="<?=$activity->points?:100?>">
                </div>
                <div class="form-group">
                    <label>Feedback</label>
                    <textarea name="feedback" class="form-control" rows="3" placeholder="Optional feedback for student"></textarea>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Submit Grade</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<script>
function openGradeModal(submissionId, studentName, currentGrade) {
    document.getElementById('submissionId').value = submissionId;
    document.getElementById('studentName').textContent = 'Grading: ' + studentName;
    document.getElementById('gradeInput').value = currentGrade || '';
    document.getElementById('gradeModal').classList.add('show');
}

function closeModal() {
    document.getElementById('gradeModal').classList.remove('show');
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}
</script>

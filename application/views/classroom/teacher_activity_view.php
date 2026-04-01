<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_activity_view.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container">
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
    <?php endif; ?>
    
<div class="activity-submissions-container">

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

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/classroom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.class-view-container {
    padding: 20px;
    font-family: "roboto", sans-serif;
}

.class-header {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: #fff;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    position: relative;
}

.class-header h2 {
    margin: 0 0 10px 0;
    font-weight: 600;
}

.class-header .subject {
    opacity: 0.9;
    font-size: 16px;
    margin-bottom: 15px;
}

.class-code-display {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.2);
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 2px;
}

.back-link {
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 15px;
    opacity: 0.9;
}

.back-link:hover {
    opacity: 1;
    color: #fff;
}

.stats-bar {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    text-align: center;
}

.stat-card i {
    font-size: 30px;
    color: #2196F3;
    margin-bottom: 10px;
}

.stat-card .number {
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.stat-card .label {
    font-size: 13px;
    color: #666;
    text-transform: uppercase;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
}

@media (max-width: 992px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

.card-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
}

.section-header {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h4 {
    margin: 0;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-header h4 i {
    color: #2196F3;
}

.section-body {
    padding: 20px;
}

.announcement-item {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    background: #f8f9fa;
    border-left: 4px solid #667eea;
}

.announcement-item:last-child {
    margin-bottom: 0;
}

.announcement-item.important {
    border-left-color: #f39c12;
    background: #fffbf0;
}

.announcement-item.urgent {
    border-left-color: #e74c3c;
    background: #fff5f5;
}

.announcement-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.announcement-content {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
}

.announcement-meta {
    font-size: 12px;
    color: #999;
}

.activity-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-info h5 {
    margin: 0 0 5px 0;
    color: #333;
    font-weight: 600;
}

.activity-info p {
    margin: 0;
    font-size: 13px;
    color: #666;
}

.activity-meta {
    text-align: right;
}

.activity-meta .due-date {
    font-size: 12px;
    color: #666;
}

.activity-meta .points {
    font-size: 12px;
    color: #667eea;
    font-weight: 600;
}

.student-list {
    max-height: 400px;
    overflow-y: auto;
}

.student-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
}

.student-item:last-child {
    border-bottom: none;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.student-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
}

.student-name {
    font-weight: 500;
    color: #333;
}

.student-joined {
    font-size: 12px;
    color: #999;
}

.btn-remove {
    background: #dc3545;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
}

.btn-remove:hover {
    background: #c82333;
}

.btn-submit-activity {
    background: #2196F3;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-submit-activity:hover {
    background: #1976D2;
}

/* Modal Styles */
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
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
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
    color: #333;
    font-family: "roboto", sans-serif;
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

.btn-modal-submit {
    background: #2196F3;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.btn-modal-cancel {
    background: #6c757d;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.empty-list {
    text-align: center;
    padding: 30px;
    color: #999;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
}
</style>

<div class="class-view-container">
    <a href="<?=site_url('classroom/teacher')?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to My Classes
    </a>
    
    <div class="class-header">
        <h2><?=$class->class_name?></h2>
        <div class="subject"><?=$class->subject_name?></div>
        <div class="class-code-display">
            <i class="fas fa-code"></i>
            <?=$class->class_code?>
            <span style="font-size: 12px;">(Share with students)</span>
        </div>
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
    
    <div class="stats-bar">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <div class="number"><?=$stats['student_count']?></div>
            <div class="label">Students</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-tasks"></i>
            <div class="number"><?=$stats['activity_count']?></div>
            <div class="label">Activities</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-bullhorn"></i>
            <div class="number"><?=$stats['announcement_count']?></div>
            <div class="label">Announcements</div>
        </div>
    </div>
    
    <div class="content-grid">
        <div>
            <!-- Meetings Section -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-video"></i> Scheduled Meetings</h4>
                    <button class="btn-submit-activity" onclick="openModal('meetingModal')">
                        <i class="fas fa-plus"></i> Schedule Meeting
                    </button>
                </div>
                <div class="section-body">
                    <?php 
                    $today_meetings = $this->classroom_model->get_today_meetings($class->id);
                    $upcoming_meetings = $this->classroom_model->get_upcoming_meetings($class->id);
                    ?>
                    <?php if($today_meetings->num_rows() > 0): ?>
                        <div class="meeting-section">
                            <h5 class="text-success mb-3"><i class="fas fa-calendar-check"></i> Today's Meetings</h5>
                            <?php foreach($today_meetings->result() as $meeting): ?>
                                <div class="meeting-item today">
                                    <div class="meeting-time">
                                        <span class="time-badge"><?=date('g:i A', strtotime($meeting->start_time))?></span>
                                    </div>
                                    <div class="meeting-info">
                                        <h5><?=$meeting->title?></h5>
                                        <p><span class="platform-badge"><i class="fas fa-video"></i> <?=$meeting->meeting_platform?></span></p>
                                        <?php if($meeting->meeting_link): ?>
                                            <a href="<?=$meeting->meeting_link?>" target="_blank" class="btn-join-meeting">
                                                <i class="fas fa-video"></i> Join Meeting
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="meeting-actions">
                                        <a href="<?=site_url('classroom/cancel_meeting/'.$meeting->id.'/'.$class->id)?>" class="btn-cancel-meeting" onclick="return confirm('Cancel this meeting?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if($upcoming_meetings->num_rows() > 0): ?>
                        <div class="meeting-section">
                            <h5 class="mb-3"><i class="fas fa-calendar"></i> Upcoming Meetings</h5>
                            <?php foreach($upcoming_meetings->result() as $meeting): ?>
                                <div class="meeting-item">
                                    <div class="meeting-date">
                                        <span class="date-badge"><?=date('M d', strtotime($meeting->scheduled_date))?></span>
                                        <span class="time-small"><?=date('g:i A', strtotime($meeting->start_time))?></span>
                                    </div>
                                    <div class="meeting-info">
                                        <h5><?=$meeting->title?></h5>
                                        <p><span class="platform-badge"><i class="fas fa-video"></i> <?=$meeting->meeting_platform?></span></p>
                                        <?php if($meeting->meeting_link): ?>
                                            <a href="<?=$meeting->meeting_link?>" target="_blank" class="btn-join-meeting">
                                                <i class="fas fa-external-link-alt"></i> Join
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="meeting-actions">
                                        <a href="<?=site_url('classroom/cancel_meeting/'.$meeting->id.'/'.$class->id)?>" class="btn-cancel-meeting" onclick="return confirm('Cancel this meeting?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-list">
                            <i class="fas fa-calendar-plus" style="font-size: 40px; color: #ddd; margin-bottom: 10px;"></i>
                            <p>No upcoming meetings scheduled</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Activities Section -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-tasks"></i> Activities & Assignments</h4>
                    <button class="btn-submit-activity" onclick="openModal('activityModal')">
                        <i class="fas fa-plus"></i> Add Activity
                    </button>
                </div>
                <div class="section-body">
                    <?php if($activities->num_rows() > 0): ?>
                        <?php foreach($activities->result() as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-info">
                                    <h5><?=$activity->title?></h5>
                                    <p><?=substr($activity->description, 0, 100)?><?=strlen($activity->description) > 100 ? '...' : ''?></p>
                                </div>
                                <div class="activity-meta">
                                    <?php if($activity->due_date): ?>
                                        <div class="due-date">
                                            <i class="fas fa-calendar"></i>
                                            Due: <?=date('M d, Y', strtotime($activity->due_date))?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($activity->points): ?>
                                        <div class="points"><?=$activity->points?> pts</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-list">
                            <i class="fas fa-tasks" style="font-size: 40px; color: #ddd; margin-bottom: 10px;"></i>
                            <p>No activities yet. Create your first activity!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Announcements Section -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-bullhorn"></i> Announcements</h4>
                    <button class="btn-submit-activity" onclick="openModal('announcementModal')">
                        <i class="fas fa-plus"></i> Post Announcement
                    </button>
                </div>
                <div class="section-body">
                    <?php if($announcements->num_rows() > 0): ?>
                        <?php foreach($announcements->result() as $announcement): ?>
                            <div class="announcement-item <?=$announcement->priority?>">
                                <div class="announcement-title"><?=$announcement->title?></div>
                                <div class="announcement-content"><?=$announcement->content?></div>
                                <div class="announcement-meta">
                                    Posted on <?=date('M d, Y g:i A', strtotime($announcement->created_at))?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-list">
                            <i class="fas fa-bullhorn" style="font-size: 40px; color: #ddd; margin-bottom: 10px;"></i>
                            <p>No announcements yet. Post your first announcement!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div>
            <!-- Students List -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-users"></i> Enrolled Students</h4>
                </div>
                <div class="section-body">
                    <div class="student-list">
                        <?php if($students->num_rows() > 0): ?>
                            <?php foreach($students->result() as $student): ?>
                                <div class="student-item">
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            <?=strtoupper(substr($student->student_name, 0, 1))?>
                                        </div>
                                        <div>
                                            <div class="student-name"><?=$student->student_name?></div>
                                            <div class="student-joined">Joined <?=date('M d, Y', strtotime($student->joined_at))?></div>
                                        </div>
                                    </div>
                                    <button class="btn-remove" onclick="removeStudent(<?=$class->id?>, <?=$student->student_id?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-list">
                                <p>No students enrolled yet</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcement Modal -->
<div id="announcementModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-bullhorn"></i> Post Announcement</h4>
            <button class="modal-close" onclick="closeModal('announcementModal')">&times;</button>
        </div>
        <div class="modal-body">
            <?=form_open('classroom/create_announcement')?>
                <input type="hidden" name="class_id" value="<?=$class->id?>">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Content *</label>
                    <textarea name="content" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority" class="form-control">
                        <option value="normal">Normal</option>
                        <option value="important">Important</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('announcementModal')">Cancel</button>
                    <button type="submit" class="btn-modal-submit">Post Announcement</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<!-- Activity Modal -->
<div id="activityModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-tasks"></i> Create Activity</h4>
            <button class="modal-close" onclick="closeModal('activityModal')">&times;</button>
        </div>
        <div class="modal-body">
            <?=form_open('classroom/create_activity')?>
                <input type="hidden" name="class_id" value="<?=$class->id?>">
                <div class="form-group">
                    <label>Activity Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Due Date</label>
                    <input type="datetime-local" name="due_date" class="form-control">
                </div>
                <div class="form-group">
                    <label>Points</label>
                    <input type="number" name="points" class="form-control" placeholder="e.g., 100">
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('activityModal')">Cancel</button>
                    <button type="submit" class="btn-modal-submit">Create Activity</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<!-- Meeting Modal -->
<div id="meetingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-video"></i> Schedule Meeting</h4>
            <button class="modal-close" onclick="closeModal('meetingModal')">&times;</button>
        </div>
        <div class="modal-body">
            <?=form_open('classroom/create_meeting')?>
                <input type="hidden" name="class_id" value="<?=$class->id?>">
                <div class="form-group">
                    <label>Meeting Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Math Class - Lecture 1" required>
                </div>
                <div class="form-group">
                    <label>Platform</label>
                    <select name="meeting_platform" class="form-control">
                        <option value="Google Meet">Google Meet</option>
                        <option value="Zoom">Zoom</option>
                        <option value="Microsoft Teams">Microsoft Teams</option>
                        <option value="Facebook Messenger">Facebook Messenger</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Meeting Link</label>
                    <input type="url" name="meeting_link" class="form-control" placeholder="https://meet.google.com/...">
                </div>
                <div class="form-group">
                    <label>Date *</label>
                    <input type="date" name="scheduled_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Start Time *</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" name="end_time" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Meeting agenda or notes"></textarea>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('meetingModal')">Cancel</button>
                    <button type="submit" class="btn-modal-submit">Schedule Meeting</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('show');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

function removeStudent(classId, studentId) {
    if (confirm('Are you sure you want to remove this student from the class?')) {
        window.location.href = '<?=site_url('classroom/remove_student/')?>' + classId + '/' + studentId;
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}
</script>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_class_view.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="class-view-container">
    <?php if(isset($_GET['modal']) && $_GET['modal'] == 'true'): ?>
        <!-- Hidden when in modal mode - back navigation handled by parent -->
    <?php else: ?>
    <a href="<?=site_url('dashboard')?>" class="back-link" style="display:inline-flex; align-items:center; gap:5px; color:#667eea; text-decoration:none; margin-bottom:15px;">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <?php endif; ?>
    
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

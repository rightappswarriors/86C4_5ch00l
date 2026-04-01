<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/student_class_view.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="class-view-container">
    <a href="<?=site_url('dashboard')?>" class="back-link" style="display:inline-flex; align-items:center; gap:5px; color:#10b981; text-decoration:none; margin-bottom:15px;">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    
    <div class="class-header">
        <h2><?=$class->class_name?></h2>
        <div class="subject"><?=$class->subject_name?></div>
        <div class="teacher-info">
            <i class="fas fa-user"></i> Teacher: <?=$class->teacher_name?>
            <?php if($class->room): ?>
                | <i class="fas fa-door-open"></i> Room: <?=$class->room?>
            <?php endif; ?>
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
    
    <div class="content-grid">
        <div>
            <!-- Meetings Section -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-video"></i> Scheduled Meetings</h4>
                </div>
                <div class="section-body">
                    <?php 
                    $student_id = $this->session->userdata('id');
                    $this->db->where('class_id', $class->id);
                    $this->db->where('scheduled_date >=', date('Y-m-d'));
                    $this->db->where('status', 'scheduled');
                    $this->db->order_by('scheduled_date', 'ASC');
                    $this->db->order_by('start_time', 'ASC');
                    $meetings = $this->db->get('classroom_meetings');
                    ?>
                    <?php if($meetings->num_rows() > 0): ?>
                        <?php foreach($meetings->result() as $meeting): ?>
                            <?php 
                            $is_today = $meeting->scheduled_date == date('Y-m-d');
                            ?>
                            <div class="meeting-item <?=$is_today ? 'today' : ''?>">
                                <div class="meeting-date">
                                    <?php if($is_today): ?>
                                        <span class="date-badge" style="background: #10b981;">Today</span>
                                        <span class="time-small"><?=date('g:i A', strtotime($meeting->start_time))?></span>
                                    <?php else: ?>
                                        <span class="date-badge"><?=date('M d', strtotime($meeting->scheduled_date))?></span>
                                        <span class="time-small"><?=date('g:i A', strtotime($meeting->start_time))?></span>
                                    <?php endif; ?>
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
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-list">
                            <i class="fas fa-calendar-minus" style="font-size: 40px; color: #ddd; margin-bottom: 10px;"></i>
                            <p>No upcoming meetings scheduled</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Activities Section -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-tasks"></i> Activities & Assignments</h4>
                </div>
                <div class="section-body">
                    <?php if($activities->num_rows() > 0): ?>
                        <?php 
                        $student_id = $this->session->userdata('id');
                        foreach($activities->result() as $activity): 
                            // Check if student submitted
                            $this->db->where('activity_id', $activity->id);
                            $this->db->where('student_id', $student_id);
                            $submission = $this->db->get('classroom_submissions');
                            $submission_row = $submission->num_rows() > 0 ? $submission->row() : null;
                            
                            // Calculate due date status
                            $due_status = 'normal';
                            if($activity->due_date) {
                                $due = strtotime($activity->due_date);
                                $now = time();
                                if($now > $due) {
                                    $due_status = 'overdue';
                                } elseif(($due - $now) < 86400 * 2) {
                                    $due_status = 'upcoming';
                                }
                            }
                        ?>
                            <div class="activity-item">
                                <div class="activity-header">
                                    <div class="activity-title"><?=$activity->title?></div>
                                    <?php if($activity->due_date): ?>
                                        <div class="activity-due <?=$due_status?>">
                                            <i class="fas fa-clock"></i>
                                            Due: <?=date('M d, g:i A', strtotime($activity->due_date))?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($activity->description): ?>
                                    <div class="activity-description"><?=$activity->description?></div>
                                <?php endif; ?>
                                <div class="activity-meta">
                                    <div>
                                        <?php if($activity->points): ?>
                                            <span class="activity-points"><?=$activity->points?> points</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if($submission_row): ?>
                                            <span class="activity-status <?=$submission_row->status?>">
                                                <?php if($submission_row->grade): ?>
                                                    <i class="fas fa-star"></i> Graded: <?=$submission_row->grade?>
                                                <?php else: ?>
                                                    <i class="fas fa-check"></i> Submitted
                                                <?php endif; ?>
                                            </span>
                                        <?php else: ?>
                                            <button class="btn-submit" onclick="openSubmitModal(<?=$activity->id?>, '<?=addslashes($activity->title)?>')">
                                                <i class="fas fa-upload"></i> Submit
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-list">
                            <i class="fas fa-tasks"></i>
                            <p>No activities yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Announcements Section -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-bullhorn"></i> Announcements</h4>
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
                            <i class="fas fa-bullhorn"></i>
                            <p>No announcements yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div>
            <!-- Class Info -->
            <div class="card-section">
                <div class="section-header">
                    <h4><i class="fas fa-info-circle"></i> Class Information</h4>
                </div>
                <div class="section-body">
                    <div style="margin-bottom: 15px;">
                        <label style="font-size: 12px; color: #666; text-transform: uppercase;">Class Code</label>
                        <div style="font-weight: 600; font-size: 18px; letter-spacing: 2px;"><?=$class->class_code?></div>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-size: 12px; color: #666; text-transform: uppercase;">Subject</label>
                        <div style="font-weight: 500;"><?=$class->subject_name?></div>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-size: 12px; color: #666; text-transform: uppercase;">Teacher</label>
                        <div style="font-weight: 500;"><?=$class->teacher_name?></div>
                    </div>
                    <?php if($class->room): ?>
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 12px; color: #666; text-transform: uppercase;">Room</label>
                            <div style="font-weight: 500;"><?=$class->room?></div>
                        </div>
                    <?php endif; ?>
                    <?php if($class->description): ?>
                        <div>
                            <label style="font-size: 12px; color: #666; text-transform: uppercase;">Description</label>
                            <div style="font-weight: 500;"><?=$class->description?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Activity Modal -->
<div id="submitModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-upload"></i> Submit Activity</h4>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p id="activityTitle" style="font-weight: 600; margin-bottom: 15px;"></p>
            <?=form_open('classroom/submit_activity/', 'enctype="multipart/form-data"')?>
                <input type="hidden" name="activity_id" id="activityId">
                <div class="form-group">
                    <label>Upload File</label>
                    <label class="file-upload" for="fileInput">
                        <input type="file" name="submission_file" id="fileInput" onchange="updateFileName(this)">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to select a file</p>
                        <p id="fileName" style="font-size: 12px; margin-top: 5px;"></p>
                    </label>
                </div>
                <div class="form-group">
                    <label>Comment (Optional)</label>
                    <textarea name="comment" class="form-control" rows="2" placeholder="Add a note for your teacher"></textarea>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fas fa-upload"></i> Submit
                    </button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<script>
function openSubmitModal(activityId, title) {
    document.getElementById('activityId').value = activityId;
    document.getElementById('activityTitle').textContent = 'Submitting: ' + title;
    document.getElementById('submitModal').classList.add('show');
}

function closeModal() {
    document.getElementById('submitModal').classList.remove('show');
    document.getElementById('fileName').textContent = '';
}

function updateFileName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileName').textContent = input.files[0].name;
    }
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}
</script>

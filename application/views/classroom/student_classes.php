<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/student_classes.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="student-classes-container">
    <div class="page-header">
        <h2><i class="fas fa-school"></i> My Classes</h2>
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
                                <div class="label">Joined</div>
                                <div class="value"><?=date('M d, Y', strtotime($class->joined_at))?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <div class="label">Status</div>
                                <div class="value"><?=ucfirst($class->enrollment_status)?></div>
                            </div>
                        </div>
                    </div>
                    <?php if($class->description): ?>
                        <p style="color: #666; margin-bottom: 15px;"><?=$class->description?></p>
                    <?php endif; ?>
                    <div class="class-actions">
                        <a href="<?=site_url('classroom/student_class/'.$class->id)?>" class="btn-action btn-view">
                            <i class="fas fa-eye"></i> View Class
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-school"></i>
            <h4>No Classes Yet</h4>
            <p>You haven't joined any classes. Join a class using the class code from your teacher!</p>
            <a href="<?=site_url('classroom/student_join')?>" class="btn-join">
                <i class="fas fa-plus"></i> Join a Class
            </a>
        </div>
    <?php endif; ?>
</div>

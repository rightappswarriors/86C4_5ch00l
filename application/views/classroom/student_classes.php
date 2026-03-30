<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/classroom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.student-classes-container {
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

.btn-join {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
}

.btn-join:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    color: #fff;
}

.class-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    border-left: 5px solid #10b981;
}

.class-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.class-card-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    padding: 20px;
}

.class-card-header h4 {
    margin: 0 0 5px 0;
    font-weight: 600;
}

.class-card-header .subject {
    opacity: 0.9;
    font-size: 14px;
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
    color: #10b981;
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
    background: #10b981;
    color: #fff;
}

.btn-view:hover {
    background: #059669;
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
</style>

<div class="student-classes-container">
    <div class="page-header">
        <h2><i class="fas fa-school"></i> My Classes</h2>
        <a href="<?=site_url('classroom/student_join')?>" class="btn-join">
            <i class="fas fa-plus"></i> Join Class
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

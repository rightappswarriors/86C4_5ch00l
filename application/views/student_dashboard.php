<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/parent_dashboard.css">
<style>
.student-dashboard .info-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
}
.student-dashboard .info-header {
    background: linear-gradient(135deg, #1c45ef 0%, #3b82f6 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
}
.student-dashboard .info-header h4 {
    margin: 0;
    font-weight: 600;
}
.student-dashboard .card-body {
    padding: 1.5rem;
}
.student-dashboard .btn-primary {
    background: linear-gradient(135deg, #1c45ef 0%, #3b82f6 100%);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    font-size: 1rem;
}
.student-dashboard .btn-primary:hover {
    background: linear-gradient(135deg, #1e3a8a 0%, #1c45ef 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.student-dashboard .quick-links {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 10px;
    padding: 1.5rem;
    border-left: 4px solid #0ea5e9;
}
.student-dashboard .quick-links h5 {
    color: #0369a1;
    font-weight: 600;
    margin-bottom: 1rem;
}
.student-dashboard .quick-link-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 5rem;
    border-bottom: 1px solid #bae6fd;
    color: #075985;
    text-decoration: none;
    transition: all 0.3s ease;
}
.student-dashboard .quick-link-item:last-child {
    border-bottom: none;
}
.student-dashboard .quick-link-item:hover {
    color: #0284c7;
    transform: translateX(5px);
}
.student-dashboard .quick-link-item i {
    margin-right: 0.75rem;
    font-size: 1.25rem;
}
.student-dashboard .welcome-card {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 12px;
    padding: 2rem;
    color: white;
    margin-bottom: 1.5rem;
}
.student-dashboard .welcome-card h3 {
    margin: 0 0 0.5rem 0;
    font-weight: 700;
}
.student-dashboard .welcome-card p {
    margin: 0;
    opacity: 0.9;
}
.student-dashboard .stat-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
    transition: transform 0.3s ease;
}
.student-dashboard .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.student-dashboard .stat-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    padding: 1rem 1.5rem;
}
.student-dashboard .stat-header h5 {
    margin: 0;
    font-weight: 600;
}
.student-dashboard .stat-body {
    padding: 1.5rem;
    text-align: center;
}
.student-dashboard .stat-body .stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
}
.student-dashboard .stat-body .stat-label {
    color: #6b7280;
    font-size: 0.875rem;
}
</style>

<div class="col-md-12 grid-margin student-dashboard">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <h3><i class="mdi mdi-school"></i> Welcome, Student!</h3>
        <p>Your student portal - Access your grades, enrollment status, and more.</p>
    </div>

    <!-- Quick Links Card -->
    <div class="card info-card">
        <div class="info-header">
            <h4 class="mb-0"><i class="mdi mdi-link"></i> Quick Links</h4>
        </div>
        <div class="card-body">
            <div class="quick-links">
                <a href="<?=site_url('myprofile')?>" class="quick-link-item">
                    <i class="mdi mdi-account"></i> My Profile
                </a>
                <a href="#" class="quick-link-item">
                    <i class="mdi mdi-school"></i> My Enrolled Subjects
                </a>
                <a href="#" class="quick-link-item">
                    <i class="mdi mdi-chart-line"></i> My Grades
                </a>
                <a href="#" class="quick-link-item">
                    <i class="mdi mdi-calendar-clock"></i> Class Schedule
                </a>
            </div>
        </div>
    </div>

    <!-- Enrollment Status Card -->
    <div class="card info-card">
        <div class="info-header">
            <h4 class="mb-0"><i class="mdi mdi-file-document"></i> Enrollment Status</h4>
        </div>
        <div class="card-body">
            <?php if($this->session->flashdata('message')): ?>
                <div class="text-danger" style="text-align:center;margin-bottom:10px;">
                    <?=$this->session->flashdata('message')?>
                </div>
            <?php endif; ?>
            
            <p style="text-align:center;">
                <a href="#" type="button" class="btn btn-lg btn-primary btn-fw">
                    <i class="mdi mdi-eye"></i> View Enrollment Details
                </a>
            </p>
            
            <hr>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="stat-header">
                            <h5><i class="mdi mdi-book"></i> Subjects</h5>
                        </div>
                        <div class="stat-body">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Enrolled Subjects</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="stat-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <h5><i class="mdi mdi-gauge"></i> Status</h5>
                        </div>
                        <div class="stat-body">
                            <div class="stat-number">-</div>
                            <div class="stat-label">Enrollment Status</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Important Notices Card -->
    <div class="card info-card">
        <div class="info-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <h4 class="mb-0"><i class="mdi mdi-information"></i> Important Notices</h4>
        </div>
        <div class="card-body">
            <ul class="list-ticked">
                <li>Please regularly check your grades and class schedule.</li>
                <li>Contact your adviser for any concerns about your subjects.</li>
                <li>For payment concerns, please proceed to the accounting office.</li>
            </ul>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/student_dashboard.css">

<?php
// Summary values below are used by the quick-action cards we added for student self-service pages.
$subject_count = isset($current_student_subject_count) ? (int) $current_student_subject_count : 0;
$payment_count = isset($current_student_payments_count) ? (int) $current_student_payments_count : 0;
$enrollment_status = isset($current_student->enrollstatus) ? $current_student->enrollstatus : 'Pending';
$grade_level = isset($current_student->gradelevel) ? $current_student->gradelevel : '-';
$status_class = 'status-pending';
if (strtolower((string) $enrollment_status) === 'active') {
    $status_class = 'status-enrolled';
} elseif (strtolower((string) $enrollment_status) === 'inactive') {
    $status_class = 'status-not-enrolled';
}
?>

<div class="col-md-12 grid-margin student-dashboard">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <h3><i class="mdi mdi-school"></i> Welcome, Student!</h3>
        <p>Your student portal - Quickly access your grades, schedule, subjects, and more.</p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="card info-card">
        <div class="info-header">
            <h4 class="mb-0"><i class="mdi mdi-rocket-launch"></i> Quick Actions</h4>
        </div>
        <div class="card-body">
            <div class="row g-4 quick-actions-row"> <!-- Changed from g-3 to g-4 -->
                <div class="col-6 col-md-4">
                    <a href="<?=site_url('myprofile/grades')?>" class="action-btn action-grades">
                        <i class="mdi mdi-chart-line"></i>
                        <span>My Grades</span>
                        <small style="opacity:0.8;font-size:0.7rem;">View your grades</small>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="<?=site_url('myprofile/schedule')?>" class="action-btn action-schedule">
                        <i class="mdi mdi-calendar-clock"></i>
                        <span>Class Schedule</span>
                        <small style="opacity:0.8;font-size:0.7rem;">Daily timetable</small>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="<?=site_url('myprofile/subjects')?>" class="action-btn action-subjects">
                        <i class="mdi mdi-book-open-page-variant"></i>
                        <span>My Subjects</span>
                        <small style="opacity:0.8;font-size:0.7rem;"><?=$subject_count?> Subjects enrolled</small>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="<?=site_url('myprofile')?>" class="action-btn action-profile">
                        <i class="mdi mdi-account-circle"></i>
                        <span>My Profile</span>
                        <small style="opacity:0.8;font-size:0.7rem;">Edit your info</small>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="<?=site_url('myprofile/payments')?>" class="action-btn action-payment">
                        <i class="mdi mdi-credit-card"></i>
                        <span>Payments</span>
                        <small style="opacity:0.8;font-size:0.7rem;"><?=$payment_count?> Transactions</small>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="<?=site_url('myprofile/enrollment')?>" class="action-btn action-enrollment">
                        <i class="mdi mdi-file-document"></i>
                        <span>Enrollment</span>
                        <small style="opacity:0.8;font-size:0.7rem;">Status: <?=$enrollment_status?></small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Status Card -->
    <div class="card info-card">
        <div class="info-header">
            <h4 class="mb-0"><i class="mdi mdi-clipboard-check"></i> Enrollment Status</h4>
        </div>
        <div class="card-body">
            <?php if($this->session->flashdata('message')): ?>
                <div class="text-danger" style="text-align:center;margin-bottom:10px;">
                    <?=$this->session->flashdata('message')?>
                </div>
            <?php endif; ?>
            
            <div class="text-center mb-4">
                <span class="status-badge <?=$status_class?>">
                    <i class="mdi mdi-check-circle"></i> <?=$enrollment_status?>
                </span>
            </div>
            
            <p style="text-align:center;">
                <a href="<?=site_url('myprofile/enrollment')?>" type="button" class="btn btn-primary">
                    <i class="mdi mdi-eye"></i> View Enrollment Details
                </a>
            </p>
            
            <hr>
            
            <div class="row text-center">
                <div class="col-6">
                    <h5 class="text-muted mb-2"><i class="mdi mdi-book"></i> Subjects</h5>
                    <h3 class="fw-bold"><?=$subject_count?></h3>
                    <small class="text-muted">Enrolled Subjects</small>
                </div>
                <div class="col-6">
                    <h5 class="text-muted mb-2"><i class="mdi mdi-gauge"></i> Grade Level</h5>
                    <h3 class="fw-bold"><?=$grade_level?></h3>
                    <small class="text-muted">Current Level</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Information Card -->
    <div class="card info-card">
        <div class="info-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <h4 class="mb-0"><i class="mdi mdi-cash-multiple"></i> Payment Information</h4>
        </div>
        <div class="card-body">
            <p>For payment concerns, please proceed to the accounting office or deposit to the following bank account:</p>
            
            <div class="bank-info">
                <code>
                    <p class="mb-1"><strong>Pay to:</strong> <span class="text-primary">CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</span></p>
                    <p class="mb-1"><strong>Bank:</strong> <span class="text-primary">CHINA BANK</span></p>
                    <p class="mb-0"><strong>Account #:</strong> <span class="text-primary">1071-00001119</span></p>
                </code>
            </div>
            
            <hr>
            
            <p class="mb-0"><i class="mdi mdi-information text-info"></i> For payment concerns, please proceed to the accounting office.</p>
        </div>
    </div>

    <!-- Important Notices Card -->
    <div class="card info-card">
        <div class="info-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <h4 class="mb-0"><i class="mdi mdi-bell-ring"></i> Important Notices</h4>
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

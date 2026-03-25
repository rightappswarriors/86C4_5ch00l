<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/admin_dashboard.css">

<!-- Top Stats Row -->
<div class="col-12">
    <div class="row">
        <!-- Total Students Card -->
        <div class="col-md-3">
            <div class="enroll-card stat-card stat-card-primary">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="mdi mdi-account-group"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Students</p>
                        <?php 
                        $total_students = 0;
                        if($count_newold_students->num_rows() > 0){
                            foreach($count_newold_students->result() as $r){ $total_students += $r->num_newold; }
                        }
                        ?>
                        <h3 class="stat-number"><?=$total_students?></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- New Students Card -->
        <div class="col-md-3">
            <div class="enroll-card stat-card stat-card-success">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="mdi mdi-account-plus"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">New Students</p>
                        <?php 
                        $new_students = 0;
                        if($count_newold_students->num_rows() > 0){
                            foreach($count_newold_students->result() as $r){ 
                                if($r->newold != 'old'){ $new_students = $r->num_newold; }
                            }
                        }
                        ?>
                        <h3 class="stat-number"><?=$new_students?></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Old Students Card -->
        <div class="col-md-3">
            <div class="enroll-card stat-card stat-card-info">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="mdi mdi-account-check"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Old Students</p>
                        <?php 
                        $old_students = 0;
                        if($count_newold_students->num_rows() > 0){
                            foreach($count_newold_students->result() as $r){ 
                                if($r->newold == 'old'){ $old_students = $r->num_newold; }
                            }
                        }
                        ?>
                        <h3 class="stat-number"><?=$old_students?></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pre-Enrollment Card -->
        <div class="col-md-3">
            <div class="enroll-card stat-card stat-card-warning">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="mdi mdi-file-document"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Pre-Enrollment</p>
                        <?php 
                        $num_reenroll = 0;
                        if($count_reenrollments->num_rows() > 0){
                            $row_creenroll = $count_reenrollments->row();
                            $num_reenroll = $row_creenroll->num_reenrolls;
                        }
                        ?>
                        <h3 class="stat-number"><?=$num_reenroll?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="col-12">
    <div class="row">
        <!-- Recent Enrollees Table - Main Content -->
        <div class="col-md-8">
            <div class="enroll-card">
                <div class="enroll-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="mdi mdi-clock-outline mr-2"></i>10 Most Recent Enrollees</h4>
                        <a href="<?=site_url("students")?>" class="btn btn-light btn-sm">View All <i class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table1 table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>	
                                    <th width="40%">Student Name</th>
                                    <th width="18%">Enrollment Date</th>
                                    <th width="17%">Grade Level</th>
                                    <th width="20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($query->num_rows() > 0)
                                {
                                    $ctr=1;
                                    foreach ($query->result() as $row):
                                        $newold = $row->newold=="old"?"":"&nbsp;<span class='badge badge-info'>".$row->newold."</span>";
                                        echo "<tr>";
                                        echo "<td class='text-center text-muted'>$ctr</td>";
                                        echo "<td><a href='".site_url("students/details/".$row->id)."'>".$row->firstname." ".$row->lastname."</a>".$newold."</td>";
                                        echo "<td>".date("m/d/Y",strtotime($row->dateadded))."</td>";
                                        echo "<td><span class='badge badge-light'>".$row->gradelevel."</span></td>";
                                        echo "<td><span class='badge badge-danger'>".$row->enrollstatus."</span></td>";
                                        echo "</tr>";
                                        $ctr++;
                                    endforeach;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar - Right Column -->
        <div class="col-md-4">
            <!-- Student Count by Type -->
            <div class="enroll-card">
                <div class="enroll-section">
                    <h5 class="enroll-section-title"><i class="mdi mdi-account-group"></i> Student Count</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        if($count_newold_students->num_rows() > 0)
                        {
                            foreach ($count_newold_students->result() as $row2):
                                $stylec = "danger";
                                if($row2->newold=="old"){
                                    $stylec = "success";	
                                }
                                ?>
                                <div class="col-6">
                                    <div class="d-flex align-items-center pb-2">
                                        <div class="dot-indicator bg-<?=$stylec?> mr-2"></div>
                                        <p class="mb-0 font-weight-semibold"><a href="<?=site_url("students/newold/".$row2->newold)?>"><?=strtoupper($row2->newold)?></a></p>
                                    </div>
                                    <h4 class="font-weight-bold text-<?=$stylec?>"><?=$row2->num_newold?></h4>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-<?=$stylec?>" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemmax="100"></div>
                                    </div>
                                </div>
                                <?php	
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- Pre-Enrollment Card -->
            <div class="enroll-card">
                <div class="enroll-header-gradient">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="mdi mdi-briefcase-outline mr-2"></i>Pre-Enrollment</h4>
                        <a href="<?=site_url("preenrollstudents")?>" class="btn btn-light btn-sm"><i class="mdi mdi-eye"></i></a>
                    </div>
                </div>
                <div class="card-body text-center py-4">
                    <h1 class="font-weight-bold text-success mb-0"><?=$num_reenroll?></h1>
                    <p class="text-muted mb-0">Applications</p>
                </div>
            </div>
            
            <!-- Enrolled Per Level -->
            <div class="enroll-card">
                <div class="enroll-section">
                    <h5 class="enroll-section-title"><i class="mdi mdi-school"></i> Enrolled Per Level</h5>
                </div>
                <div class="card-body">
                    <div class="level-list">
                        <?php
                        if($count_gradelevel_students->num_rows() > 0)
                        {
                            foreach ($count_gradelevel_students->result() as $row1):
                                ?>
                                <div class="d-flex w-100 py-2 border-bottom">
                                    <p class="mb-0 font-weight-medium"><a href="<?=site_url("students/gradelevel/".$row1->gradelevel)?>" class="text-dark"><?=$row1->gradelevel?></a></p>
                                    <div class="ml-auto">
                                        <span class="badge badge-primary badge-pill"><?=$row1->num_gradelevel?></span>
                                    </div>
                                </div>
                                <?php	
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.table1').DataTable( {
        "searching": false,
        "bLengthChange": false,
        "info": false,
        "drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    });
});
</script>

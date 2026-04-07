<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_dashboard.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/teacher_dashboard_classroom.css">
<style>
.teacher-dashboard .student-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
    margin-bottom: 1.5rem;
}
.teacher-dashboard .student-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
}
.teacher-dashboard .student-header h4 {
    margin: 0;
    font-weight: 600;
}
.teacher-dashboard .card-body {
    padding: 1.5rem;
}
.teacher-dashboard .table thead th {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 12px;
}
.teacher-dashboard .table tbody tr {
    transition: all 0.3s ease;
}
.teacher-dashboard .table tbody tr:hover {
    background: #fffbeb;
    transform: scale(1.01);
}
.teacher-dashboard .table tbody td {
    padding: 12px;
    vertical-align: middle;
}
.teacher-dashboard .table-responsive {
    overflow-x: scroll;
    scrollbar-color: #b3b3b3 #e3e3e3;
    scrollbar-width: thin;
}
.teacher-dashboard .table-responsive::-webkit-scrollbar {
    height: 11px;
}
.teacher-dashboard .table-responsive::-webkit-scrollbar-track {
    background: #e3e3e3;
}
.teacher-dashboard .table-responsive::-webkit-scrollbar-thumb {
    background: #b3b3b3;
}
.teacher-dashboard .table-responsive::-webkit-scrollbar-thumb:hover {
    background: #b3b3b3;
}
.teacher-dashboard .table-responsive::-webkit-scrollbar-button {
    background: #e3e3e3;
}
.teacher-dashboard .btn-primary {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
}
.teacher-dashboard .btn-primary:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
</style>


<div class="col-md-8 teacher-dashboard">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Most Recent Active Students </h4>
                        <a href="<?=site_url("students")?>" class="btn btn-primary">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table1 table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>	
                                    <th width="55%">Name</th>
                                    <th width="20%">Level</th>
                                    <th width="20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($query->num_rows() > 0)
                                {
                                    $ctr=1;
                                    foreach ($query->result() as $row):
                                        $newold = $row->newold=="old"?"":"&nbsp;<code>".$row->newold."</code>";
                                        echo "<tr>";
                                        echo "<td>$ctr</td>";
                                        echo "<td><a href='".site_url("students/details/".$row->id)."'>".$row->firstname." ".$row->lastname."</a>".$newold."</td>";
                                        echo "<td>".$row->gradelevel."</td>";
                                        echo "<td class='text-danger'><mark><code>".$row->enrollstatus."</code></mark></td>";
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
    </div>
</div>

<div class="col-md-4">	
    <div class="row">
    
        <!-- Classroom Section -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card" style="background: #0d6efd;">
                <div class="card-body">
                    <h4 class="card-title text-white"><i class="fas fa-chalkboard"></i> Classroom</h4>
                    <p class="text-white mb-3">Manage your online classes</p>
                    <button class="btn btn-light" id="btnMyClasses">
                        <i class="fas fa-list"></i> My Classes
                    </button>
                    <button class="btn btn-light ml-2" id="btnCreateClass">
                        <i class="fas fa-plus"></i> Create
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Gradebook Section -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                <div class="card-body">
                    <h4 class="card-title text-white"><i class="fas fa-book"></i> Gradebook</h4>
                    <p class="text-white mb-3">Manage your students grades</p>
                    <a href="<?=site_url('academics/gradebook')?>" class="btn btn-light">
                        <i class="fas fa-list"></i> My Gradebook
                    </a>
                </div>
            </div>
        </div>
    
        <!-- New/Old Students -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php
                        if($count_newold_students->num_rows() > 0)
                        {
                            foreach ($count_newold_students->result() as $row2):
                                $stylec="danger";
                                if($row2->newold=="old"){
                                    $stylec="success";	
                                }
                                ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center pb-2">
                                        <div class="dot-indicator bg-<?=$stylec?> mr-2"></div>
                                        <p class="mb-0"><a href="<?=site_url("students/newold/".$row2->newold)?>"><?=strtoupper($row2->newold)?></a></p>
                                    </div>
                                    <h4 class="font-weight-semibold"><?=$row2->num_newold?></h4>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-<?=$stylec?>" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
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
    
        <!-- Enrolled Per Level -->
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Enrolled Per Level</h4>
                    <div class="wrapper">
                        <?php
                        if($count_gradelevel_students->num_rows() > 0)
                        {
                            foreach ($count_gradelevel_students->result() as $row1):
                                ?>
                                <div class="d-flex w-100 pt-2">
                                    <p class="mb-0"><a href="<?=site_url("students/gradelevel/".$row1->gradelevel)?>"><?=$row1->gradelevel?></a></p>
                                    <div class="wrapper ml-auto d-flex align-items-center">
                                        <p class="ml-1 mb-0"><?=$row1->num_gradelevel?></p>
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

<!-- Teacher Classroom Section Wrapper -->
<div class="teacher-classroom-modal">

<!-- Teacher Classes Modal -->
<div id="teacherClassesModal" class="modal">
    <div class="modal-content" style="max-width: 90%; width: 1000px;">
        <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div>
                <h4 style="color: white; margin: 0;" id="teacherClassesModalLabel">
                    <i class="fas fa-chalkboard" style="color: white;"></i> My Classes
                </h4>
                <p style="color: white; margin: 5px 0 0 0; font-size: 0.85rem;">View and manage your classes</p>
            </div>
            <button type="button" class="modal-close" onclick="closeTeacherClassesModal()" style="color: white; opacity: 1;">
                &times;
            </button>
        </div>
        <div class="modal-body" style="padding: 0; max-height: 70vh; overflow-y: auto;">
            <iframe id="teacherClassesFrame" src="<?=site_url('classroom/teacher')?>" style="width: 100%; height: 70vh; border: none;" loading="lazy" title="My Classes"></iframe>
        </div>
    </div>
</div>

<!-- Teacher Create Class Modal -->
<div id="teacherCreateClassModal" class="modal">
    <div class="modal-content" style="max-width: 90%; width: 1000px;">
        <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div>
                <h4 style="color: white; margin: 0;" id="teacherCreateClassModalLabel">
                    <i class="fas fa-plus-circle" style="color: white;"></i> Create New Class
                </h4>
                <p style="color: white; margin: 5px 0 0 0; font-size: 0.85rem;">Create a new class for your students</p>
            </div>
            <button type="button" class="modal-close" onclick="closeTeacherCreateClassModal()" style="color: white; opacity: 1;">
                &times;
            </button>
        </div>
        <div class="modal-body" style="padding: 0; max-height: 70vh; overflow-y: auto;">
            <iframe id="createClassFrame" src="<?=site_url('classroom/create_class')?>?modal=true" style="width: 100%; height: 70vh; border: none;" loading="lazy" title="Create Class"></iframe>
        </div>
    </div>
</div>


<script>
// Check URL for created parameter and update iframe src
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('created') === '1') {
        // Update iframe src to include created parameter
        var iframe = document.getElementById('teacherClassesFrame');
        if (iframe) {
            iframe.src = '<?=site_url('classroom/teacher')?>?created=1';
        }
        // Show the classes modal
        $('#teacherClassesModal').addClass('show');
    }
});

// Modal button click handlers
$('#btnMyClasses').on('click', function() {
    var iframe = document.getElementById('teacherClassesFrame');
    if (iframe && iframe.src.indexOf('created=1') === -1) {
        iframe.src = '<?=site_url('classroom/teacher')?>';
    }
    $('#teacherClassesModal').addClass('show');
});

$('#btnCreateClass').on('click', function() {
    $('#teacherCreateClassModal').addClass('show');
});

function openGradebookModal() {
    // Redirect to gradebook page
    window.location.href = '<?=site_url('academics/gradebook')?>';
}

function openTeacherClassesModal() {
    $('#teacherClassesModal').addClass('show');
}

function closeTeacherClassesModal() {
    $('#teacherClassesModal').removeClass('show');
}

function openTeacherCreateClassModal() {
    $('#teacherCreateClassModal').addClass('show');
}

function closeTeacherCreateClassModal() {
    $('#teacherCreateClassModal').removeClass('show');
}

$(document).ready(function() {
    $('.table1').DataTable( {
        "searching": false,
        "bLengthChange": false,
        "info": false,
        "drawCallback": function () {
            $('a.paginate_button').addClass("btn btn-sm");
        }
    } );
    
    // Close modal when clicking outside
    $('#teacherClassesModal, #teacherCreateClassModal').on('click', function(event) {
        if (event.target === this) {
            $(this).removeClass('show');
        }
    });
} );
</script>

</div> <!-- End teacher-classroom-modal -->

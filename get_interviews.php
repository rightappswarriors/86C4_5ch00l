<?php
header('Content-Type: application/json');

// Database connection - adjust these to match your setup
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'bbccolle_beta_bhcaportal';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$date = isset($_POST['date']) ? $_POST['date'] : (isset($_GET['date']) ? $_GET['date'] : null);

if (!$date) {
    echo json_encode(['success' => false, 'message' => 'Date required']);
    exit;
}

$stmt = $conn->prepare("
    select a.id as studentid, a.firstname, a.middlename, a.lastname,
           b.interviewdate, b.interviewtime, b.slot_duration, b.schoolyear,
           e.gradelevel as grade
    from students a
    join interviewsched b on b.studentid = a.id
    left join enrolled e on e.studentid = a.id and e.schoolyear = b.schoolyear and e.deleted = 'no'
    where b.status = 1 
    and b.interviewdate = ?
    order by b.interviewtime asc
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();

$interviews = [];
while ($row = $result->fetch_object()) {
    $fullname = trim($row->firstname . ' ' . ($row->middlename ? $row->middlename . ' ' : '') . $row->lastname);
    
    $interviews[] = [
        'studentid' => $row->studentid,
        'student_name' => $fullname,
        'grade' => $row->grade ?: 'New',
        'section' => '',
        'interviewtime' => date('h:i A', strtotime($row->interviewtime)),
        'interviewdate' => $row->interviewdate,
        'schoolyear' => $row->schoolyear,
        'duration' => $row->slot_duration,
        'parent_name' => '',
        'parent_contact' => ''
    ];
}

echo json_encode([
    'success' => true,
    'date' => $date,
    'count' => count($interviews),
    'interviews' => $interviews
]);

$stmt->close();
$conn->close();
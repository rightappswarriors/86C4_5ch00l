<?php
header('Content-Type: application/json');

$date = isset($_POST['date']) ? $_POST['date'] : '';

if(!$date) {
    echo json_encode(['success' => false, 'message' => 'Date required']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'bbccolle_beta_bhcaportal');

if($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$stmt = $conn->prepare("
    SELECT a.id as studentid, a.firstname, a.middlename, a.lastname, a.grade, a.section,
           b.interviewdate, b.interviewtime, b.slot_duration, b.schoolyear,
           c.firstname as parentfname, c.lastname as parentlname, c.mobileno
    FROM students a
    JOIN interviewsched b ON b.studentid = a.id
    LEFT JOIN register c ON c.id = a.user_id
    WHERE b.status = 1 
    AND b.interviewdate = ?
    ORDER BY b.interviewtime ASC
");

$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();

$interviews = [];
while($row = $result->fetch_object()) {
    $fullname = trim($row->firstname . ' ' . ($row->middlename ? $row->middlename . ' ' : '') . $row->lastname);
    $parent_contact = $row->mobileno ? $row->mobileno : '';
    
    $interviews[] = [
        'studentid' => $row->studentid,
        'student_name' => $fullname,
        'grade' => $row->grade,
        'section' => $row->section,
        'interviewtime' => date('h:i A', strtotime($row->interviewtime)),
        'interviewdate' => $row->interviewdate,
        'schoolyear' => $row->schoolyear,
        'duration' => $row->slot_duration,
        'parent_name' => ($row->parentfname || $row->parentlname) ? trim($row->parentfname . ' ' . $row->parentlname) : '',
        'parent_contact' => $parent_contact
    ];
}

$stmt->close();
$conn->close();

echo json_encode([
    'success' => true,
    'date' => $date,
    'count' => count($interviews),
    'interviews' => $interviews
]);
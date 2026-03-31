<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('message', 'You need to be logged in to access the classroom.');
            redirect('login');
        }
        $this->load->model('classroom_model');
        $this->load->library('upload');
    }

    // =====================
    // TEACHER METHODS
    // =====================

    // Teacher dashboard - list all classes
    public function teacher_index()
    {
        $teacher_id = $this->session->userdata('current_userid');
        $data['classes'] = $this->classroom_model->get_teacher_classes($teacher_id);
        $data['title'] = 'My Classes';
        $this->load->view('classroom/teacher_classes', $data);
    }

    // Create new class form
    public function create_class()
    {
        $data['title'] = 'Create New Class';
        $this->load->view('classroom/teacher_create_class', $data);
    }

    // Save new class
    public function save_class()
    {
        $teacher_id = $this->session->userdata('current_userid');
        $teacher_name = $this->session->userdata('current_firstname') . ' ' . $this->session->userdata('lastname');

        $this->form_validation->set_rules('class_name', 'Class Name', 'required|trim');
        $this->form_validation->set_rules('subject_name', 'Subject Name', 'required|trim');
        $this->form_validation->set_rules('room', 'Room', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create_class();
            return;
        }

        $data = array(
            'class_name' => $this->input->post('class_name'),
            'subject_name' => $this->input->post('subject_name'),
            'teacher_name' => $teacher_name,
            'teacher_id' => $teacher_id,
            'room' => $this->input->post('room'),
            'description' => $this->input->post('description')
        );

        if ($this->classroom_model->create_class($data)) {
            $this->session->set_flashdata('success', 'Class created successfully! Share this code with your students.');
            redirect('classroom/teacher');
        } else {
            $this->session->set_flashdata('error', 'Failed to create class. Please try again.');
            redirect('classroom/create_class');
        }
    }

    // View class details (teacher view)
    public function teacher_class_view($class_id)
    {
        $teacher_id = $this->session->userdata('current_userid');
        $class = $this->classroom_model->get_class($class_id);
        
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/teacher');
            return;
        }
        
        $class_data = $class->row();
        
        // Verify the teacher owns this class
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to view this class');
            redirect('classroom/teacher');
            return;
        }
        
        $data['class'] = $class_data;
        $data['students'] = $this->classroom_model->get_class_students($class_id);
        $data['announcements'] = $this->classroom_model->get_class_announcements($class_id);
        $data['activities'] = $this->classroom_model->get_class_activities($class_id);
        $data['stats'] = $this->classroom_model->get_class_stats($class_id);
        $data['title'] = $data['class']->class_name;
        
        // Load meetings data for the view
        $data['today_meetings'] = $this->classroom_model->get_today_meetings($class_id);
        $data['upcoming_meetings'] = $this->classroom_model->get_upcoming_meetings($class_id);
        
        $this->load->view('classroom/teacher_class_view', $data);
    }

    // Create announcement
    public function create_announcement()
    {
        $class_id = $this->input->post('class_id');
        $teacher_id = $this->session->userdata('current_userid');

        // Verify the teacher owns this class
        $class = $this->classroom_model->get_class($class_id);
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/teacher');
            return;
        }
        
        $class_data = $class->row();
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to post announcements in this class');
            redirect('classroom/teacher');
            return;
        }

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill in all required fields');
            redirect('classroom/teacher_class/' . $class_id);
            return;
        }

        $data = array(
            'class_id' => $class_id,
            'teacher_id' => $teacher_id,
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'priority' => $this->input->post('priority') ?? 'normal'
        );

        if ($this->classroom_model->create_announcement($data)) {
            $this->session->set_flashdata('success', 'Announcement posted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to post announcement');
        }
        redirect('classroom/teacher_class/' . $class_id);
    }

    // Create activity
    public function create_activity()
    {
        $class_id = $this->input->post('class_id');
        $teacher_id = $this->session->userdata('current_userid');

        // Verify the teacher owns this class
        $class = $this->classroom_model->get_class($class_id);
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/teacher');
            return;
        }
        
        $class_data = $class->row();
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to create activities in this class');
            redirect('classroom/teacher');
            return;
        }

        $this->form_validation->set_rules('title', 'Activity Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill in all required fields');
            redirect('classroom/teacher_class/' . $class_id);
            return;
        }

        $data = array(
            'class_id' => $class_id,
            'teacher_id' => $teacher_id,
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'due_date' => $this->input->post('due_date') ? $this->input->post('due_date') : NULL,
            'points' => $this->input->post('points') ? $this->input->post('points') : NULL
        );

        if ($this->classroom_model->create_activity($data)) {
            $this->session->set_flashdata('success', 'Activity created successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to create activity');
        }
        redirect('classroom/teacher_class/' . $class_id);
    }

    // View activity submissions
    public function activity_submissions($activity_id)
    {
        $teacher_id = $this->session->userdata('current_userid');
        $activity = $this->classroom_model->get_activity($activity_id);
        
        if ($activity->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Activity not found');
            redirect('classroom/teacher');
            return;
        }
        
        $activity_data = $activity->row();
        
        // Get the class to verify ownership
        $class = $this->classroom_model->get_class($activity_data->class_id);
        $class_data = $class->row();
        
        // Verify the teacher owns this class
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to view this activity');
            redirect('classroom/teacher');
            return;
        }

        $data['activity'] = $activity_data;
        $data['submissions'] = $this->classroom_model->get_activity_submissions($activity_id);
        $data['title'] = $data['activity']->title . ' - Submissions';
        
        $this->load->view('classroom/teacher_activity_view', $data);
    }

    // Grade submission
    public function grade_submission()
    {
        $teacher_id = $this->session->userdata('current_userid');
        $submission_id = $this->input->post('submission_id');
        $activity_id = $this->input->post('activity_id');
        $grade = $this->input->post('grade');
        $feedback = $this->input->post('feedback');

        // Get the activity to find the class
        $activity = $this->classroom_model->get_activity($activity_id);
        if ($activity->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Activity not found');
            redirect('classroom/teacher');
            return;
        }
        
        $activity_data = $activity->row();
        
        // Get the class to verify ownership
        $class = $this->classroom_model->get_class($activity_data->class_id);
        $class_data = $class->row();
        
        // Verify the teacher owns this class
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to grade this submission');
            redirect('classroom/teacher');
            return;
        }

        if ($this->classroom_model->grade_submission($submission_id, $grade, $feedback)) {
            $this->session->set_flashdata('success', 'Submission graded successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to grade submission');
        }
        redirect('classroom/activity_submissions/' . $activity_id);
    }

    // Create meeting
    public function create_meeting()
    {
        $class_id = $this->input->post('class_id');
        $teacher_id = $this->session->userdata('current_userid');

        // Verify the teacher owns this class
        $class = $this->classroom_model->get_class($class_id);
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/teacher');
            return;
        }
        
        $class_data = $class->row();
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to create meetings in this class');
            redirect('classroom/teacher');
            return;
        }

        $this->form_validation->set_rules('title', 'Meeting Title', 'required|trim');
        $this->form_validation->set_rules('scheduled_date', 'Date', 'required|trim');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill in all required fields');
            redirect('classroom/teacher_class/' . $class_id);
            return;
        }

        $data = array(
            'class_id' => $class_id,
            'teacher_id' => $teacher_id,
            'title' => $this->input->post('title'),
            'meeting_link' => $this->input->post('meeting_link'),
            'meeting_platform' => $this->input->post('meeting_platform') ?? 'Google Meet',
            'scheduled_date' => $this->input->post('scheduled_date'),
            'start_time' => $this->input->post('start_time'),
            'end_time' => $this->input->post('end_time') ?: NULL,
            'description' => $this->input->post('description'),
            'is_recurring' => $this->input->post('is_recurring') ?? 'no'
        );

        if ($this->classroom_model->create_meeting($data)) {
            $this->session->set_flashdata('success', 'Meeting scheduled successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to create meeting');
        }
        redirect('classroom/teacher_class/' . $class_id);
    }

    // Cancel meeting
    public function cancel_meeting($meeting_id, $class_id)
    {
        if ($this->classroom_model->delete_meeting($meeting_id)) {
            $this->session->set_flashdata('success', 'Meeting cancelled');
        } else {
            $this->session->set_flashdata('error', 'Failed to cancel meeting');
        }
        redirect('classroom/teacher_class/' . $class_id);
    }

    // Remove student from class
    public function remove_student($class_id, $student_id)
    {
        $teacher_id = $this->session->userdata('current_userid');
        
        // Verify the teacher owns this class
        $class = $this->classroom_model->get_class($class_id);
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/teacher');
            return;
        }
        
        $class_data = $class->row();
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to remove students from this class');
            redirect('classroom/teacher');
            return;
        }

        if ($this->classroom_model->remove_student($class_id, $student_id)) {
            $this->session->set_flashdata('success', 'Student removed from class');
        } else {
            $this->session->set_flashdata('error', 'Failed to remove student');
        }
        redirect('classroom/teacher_class/' . $class_id);
    }

    // Delete class
    public function delete_class($class_id)
    {
        $teacher_id = $this->session->userdata('current_userid');
        
        // Verify the teacher owns this class
        $class = $this->classroom_model->get_class($class_id);
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/teacher');
            return;
        }
        
        $class_data = $class->row();
        if ($class_data->teacher_id != $teacher_id) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this class');
            redirect('classroom/teacher');
            return;
        }

        if ($this->classroom_model->delete_class($class_id)) {
            $this->session->set_flashdata('success', 'Class archived successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to archive class');
        }
        redirect('classroom/teacher');
    }

    // =====================
    // STUDENT METHODS
    // =====================

    // Student join class
    public function student_join()
    {
        $data['title'] = 'Join a Class';
        $this->load->view('classroom/student_join_class', $data);
    }

    // Process join class
    public function process_join()
    {
        $class_code = $this->input->post('class_code');
        $student_id = $this->session->userdata('current_userid');
        $student_name = $this->session->userdata('current_firstname') . ' ' . $this->session->userdata('lastname');

        $this->form_validation->set_rules('class_code', 'Class Code', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please enter a class code');
            redirect('classroom/student_join');
            return;
        }

        // Get class by code
        $class = $this->classroom_model->get_class_by_code($class_code);
        
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found. Please check the code and try again.');
            redirect('classroom/student_join');
            return;
        }

        $class_row = $class->row();
        $result = $this->classroom_model->join_class($class_row->id, $student_id, $student_name);

        if ($result['status'] == 'success') {
            $this->session->set_flashdata('success', $result['message'] . ' Class: ' . $class_row->class_name);
        } elseif ($result['status'] == 'already_joined') {
            $this->session->set_flashdata('warning', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }
        
        redirect('classroom/student_classes');
    }

    // Student my classes
    public function student_classes()
    {
        $student_id = $this->session->userdata('current_userid');
        if (empty($student_id)) {
            $this->session->set_flashdata('error', 'Please login to view your classes');
            redirect('login');
            return;
        }
        $data['classes'] = $this->classroom_model->get_student_classes($student_id);
        $data['title'] = 'My Classes';
        $this->load->view('classroom/student_classes', $data);
    }

    // Student notifications feed
    public function student_notifications()
    {
        $student_id = $this->session->userdata('current_userid');
        if (empty($student_id)) {
            $this->session->set_flashdata('error', 'Please login to view your notifications');
            redirect('login');
            return;
        }

        $data['title'] = 'Notifications';
        $data['template'] = 'classroom/student_notifications';
        $data['notifications'] = $this->classroom_model->get_student_notifications($student_id, 25);

        $this->load->view('template', $data);
    }

    // Student class view
    public function student_class_view($class_id)
    {
        $student_id = $this->session->userdata('current_userid');
        
        $class = $this->classroom_model->get_class($class_id);
        
        if ($class->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Class not found');
            redirect('classroom/student_classes');
            return;
        }

        // Check if student is enrolled
        $this->db->where('class_id', $class_id);
        $this->db->where('student_id', $student_id);
        $this->db->where('status', 'active');
        $enrollment = $this->db->get('classroom_students');
        
        if ($enrollment->num_rows() == 0) {
            $this->session->set_flashdata('error', 'You are not enrolled in this class');
            redirect('classroom/student_classes');
            return;
        }

        $data['class'] = $class->row();
        $data['announcements'] = $this->classroom_model->get_class_announcements($class_id);
        $data['activities'] = $this->classroom_model->get_class_activities($class_id);
        $data['title'] = $data['class']->class_name;
        
        $this->load->view('classroom/student_class_view', $data);
    }

    // Submit activity
    public function submit_activity($activity_id)
    {
        $student_id = $this->session->userdata('current_userid');
        $student_name = $this->session->userdata('current_firstname') . ' ' . $this->session->userdata('lastname');
        
        // Get activity to find class_id
        $activity = $this->classroom_model->get_activity($activity_id);
        
        if ($activity->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Activity not found');
            redirect('classroom/student_classes');
            return;
        }
        
        $activity_row = $activity->row();
        
        // Check if student already submitted
        $submission = $this->classroom_model->get_student_submission($activity_id, $student_id);
        
        if ($_FILES['submission_file']['name']) {
            $config['upload_path'] = './file_upload/classroom/';
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|txt|jpg|jpeg|png|gif';
            $config['max_size'] = 10240; // 10MB
            $config['file_name'] = time() . '_' . $_FILES['submission_file']['name'];
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('submission_file')) {
                $upload_data = $this->upload->data();
                
                $data = array(
                    'activity_id' => $activity_id,
                    'student_id' => $student_id,
                    'student_name' => $student_name,
                    'file_path' => 'file_upload/classroom/' . $upload_data['file_name'],
                    'file_name' => $upload_data['file_name'],
                    'comment' => $this->input->post('comment')
                );
                
                $this->classroom_model->submit_activity($data);
                $this->session->set_flashdata('success', 'Activity submitted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to upload file: ' . $this->upload->display_errors());
            }
        } else {
            $this->session->set_flashdata('error', 'Please select a file to upload');
        }
        
        redirect('classroom/student_class/' . $activity_row->class_id);
    }

    // =====================
    // AJAX METHODS
    // =====================

    // Check class code exists
    public function check_class_code()
    {
        $class_code = $this->input->post('class_code');
        $class = $this->classroom_model->get_class_by_code($class_code);
        
        if ($class->num_rows() > 0) {
            $row = $class->row();
            echo json_encode(array(
                'exists' => true,
                'class_name' => $row->class_name,
                'subject_name' => $row->subject_name,
                'teacher_name' => $row->teacher_name
            ));
        } else {
            echo json_encode(array('exists' => false));
        }
    }
}

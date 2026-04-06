<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gradebook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('message', 'You need to be logged in to access the page.');
            redirect('login');
        }

        $allowed = array('teacher', 'admin');
        $usertype = strtolower((string) $this->session->userdata('current_usertype'));
        if (!in_array($usertype, $allowed, true)) {
            $this->session->set_flashdata('error', 'You do not have permission to access this page.');
            redirect('dashboard');
        }

        $this->load->model('gradebook_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $teacher_id = (int) $this->session->userdata('current_userid');
        $schoolyear_id = (int) $this->session->userdata('current_schoolyearid');
        $selected_tab = $this->input->get('tab') ?: 'setup';
        $selected_activity_id = (int) $this->input->get('activity_id');
        $schema_ready = $this->gradebook_model->gradebook_tables_exist();

        $gradebooks = array();
        $gradebook = null;
        if ($schema_ready) {
            $gradebooks = $this->gradebook_model->get_teacher_gradebooks($teacher_id, $schoolyear_id);
            $gradebook_id = (int) $this->input->get('gradebook_id');
            if ($gradebook_id > 0) {
                $gradebook = $this->gradebook_model->get_gradebook($gradebook_id, $teacher_id);
            }

            if (!$gradebook) {
                $gradebook = $this->gradebook_model->get_latest_gradebook($teacher_id, $schoolyear_id);
            }
        }

        $students = array();
        $activities = array();
        $activity_sheet = array();
        $selected_activity = null;
        $overview = array();
        $category_summary = array();
        $results = array('rows' => array(), 'average' => null, 'highest' => null, 'lowest' => null, 'at_risk' => array(), 'top_performers' => array());
        $competencies = array();
        $feedback_history = array();

        if ($gradebook) {
            $gradebook_id = (int) $gradebook['id'];
            $students = $this->gradebook_model->get_gradebook_students($gradebook_id);
            $activities = $this->gradebook_model->get_gradebook_activities($gradebook_id);
            $overview = $this->gradebook_model->get_gradebook_overview($gradebook_id);
            $category_summary = $this->gradebook_model->get_category_summary($gradebook_id);
            $results = $this->gradebook_model->compute_results($gradebook_id, $this->input->get('method') === 'deped' ? 'deped' : 'standard');
            $competencies = $this->gradebook_model->get_competency_summary($gradebook_id);
            $feedback_history = $this->gradebook_model->get_feedback_history($gradebook_id);

            if ($selected_activity_id > 0) {
                $selected_activity = $this->gradebook_model->get_activity($selected_activity_id, $gradebook_id);
            }

            if (!$selected_activity && !empty($activities)) {
                $selected_activity = $activities[0];
            }

            if ($selected_activity) {
                $activity_sheet = $this->gradebook_model->get_activity_score_sheet($selected_activity['id'], $gradebook_id);
            }
        }

        $data = array(
            'title' => 'Gradebook',
            'template' => 'academics/gradebook',
            'schema_ready' => $schema_ready,
            'selected_tab' => $selected_tab,
            'gradebooks' => $gradebooks,
            'gradebook' => $gradebook,
            'students' => $students,
            'activities' => $activities,
            'selected_activity' => $selected_activity,
            'activity_sheet' => $activity_sheet,
            'overview' => $overview,
            'category_summary' => $category_summary,
            'results' => $results,
            'competencies' => $competencies,
            'feedback_history' => $feedback_history,
        );

        $this->load->view('template', $data);
    }

    public function save_gradebook()
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $this->form_validation->set_rules('class_name', 'Class Name', 'required|trim');
        $this->form_validation->set_rules('subject_name', 'Subject', 'required|trim');
        $this->form_validation->set_rules('term_system', 'Term System', 'required|trim');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('academics/gradebook?tab=setup');
            return;
        }

        $ww_weight = (float) $this->input->post('ww_weight');
        $pt_weight = (float) $this->input->post('pt_weight');
        $qa_weight = (float) $this->input->post('qa_weight');

        if (round($ww_weight + $pt_weight + $qa_weight, 2) !== 100.00) {
            $this->session->set_flashdata('error', 'Grading weights must total exactly 100%.');
            redirect('academics/gradebook?tab=setup');
            return;
        }

        $payload = array(
            'schoolyear_id' => (int) $this->session->userdata('current_schoolyearid'),
            'schoolyear_label' => (string) $this->session->userdata('current_schoolyear'),
            'class_name' => trim((string) $this->input->post('class_name')),
            'subject_name' => trim((string) $this->input->post('subject_name')),
            'term_system' => trim((string) $this->input->post('term_system')),
            'ww_weight' => $ww_weight,
            'pt_weight' => $pt_weight,
            'qa_weight' => $qa_weight,
        );

        $gradebook_id = $this->gradebook_model->save_gradebook(
            (int) $this->session->userdata('current_userid'),
            $payload,
            (int) $this->input->post('gradebook_id')
        );

        $this->session->set_flashdata('success', 'Gradebook configuration saved successfully.');
        $this->redirect_to_gradebook($gradebook_id, 'students');
    }

    public function import_students()
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $gradebook_id = (int) $this->input->post('gradebook_id');
        $gradebook = $this->require_gradebook($gradebook_id);
        if (!$gradebook) {
            return;
        }

        $identifiers = preg_split('/\r\n|\r|\n/', (string) $this->input->post('student_identifiers'));
        if (!empty($_FILES['student_csv']['tmp_name'])) {
            $identifiers = array_merge($identifiers, $this->gradebook_model->parse_csv_identifiers($_FILES['student_csv']['tmp_name']));
        }

        $result = $this->gradebook_model->import_students($gradebook_id, (int) $gradebook['schoolyear_id'], $identifiers);
        $message = $result['imported'] . ' student(s) imported';

        if ($result['updated'] > 0) {
            $message .= ', ' . $result['updated'] . ' refreshed';
        }

        if (!empty($result['not_found'])) {
            $message .= '. Not found: ' . implode(', ', $result['not_found']);
        }

        $this->session->set_flashdata('success', $message . '.');
        $this->redirect_to_gradebook($gradebook_id, 'students');
    }

    public function update_student_status($gradebook_id, $gradebook_student_id, $status)
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $gradebook = $this->require_gradebook((int) $gradebook_id);
        if (!$gradebook) {
            return;
        }

        if ($this->gradebook_model->update_student_status($gradebook_id, $gradebook_student_id, $status)) {
            $this->session->set_flashdata('success', 'Student status updated.');
        } else {
            $this->session->set_flashdata('error', 'Unable to update student status.');
        }

        $this->redirect_to_gradebook((int) $gradebook_id, 'students');
    }

    public function create_activity()
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $gradebook_id = (int) $this->input->post('gradebook_id');
        $gradebook = $this->require_gradebook($gradebook_id);
        if (!$gradebook) {
            return;
        }

        $this->form_validation->set_rules('title', 'Activity Title', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        $this->form_validation->set_rules('total_points', 'Total Points', 'required|numeric');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->redirect_to_gradebook($gradebook_id, 'activities');
            return;
        }

        $activity_id = $this->gradebook_model->create_activity($gradebook_id, array(
            'title' => trim((string) $this->input->post('title')),
            'category' => strtoupper(trim((string) $this->input->post('category'))),
            'activity_type' => trim((string) $this->input->post('activity_type')),
            'total_points' => (float) $this->input->post('total_points'),
            'due_date' => trim((string) $this->input->post('due_date')),
            'competency_tag' => trim((string) $this->input->post('competency_tag')),
        ));

        $this->session->set_flashdata('success', 'Activity created successfully.');
        $this->redirect_to_gradebook($gradebook_id, 'scores', array('activity_id' => $activity_id));
    }

    public function save_scores()
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $gradebook_id = (int) $this->input->post('gradebook_id');
        $activity_id = (int) $this->input->post('activity_id');
        $gradebook = $this->require_gradebook($gradebook_id);
        if (!$gradebook) {
            return;
        }

        $scores = (array) $this->input->post('scores');
        if ($this->gradebook_model->save_scores($activity_id, $gradebook_id, $scores)) {
            $this->session->set_flashdata('success', 'Scores saved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to save scores.');
        }

        $this->redirect_to_gradebook($gradebook_id, 'scores', array('activity_id' => $activity_id));
    }

    public function save_feedback()
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $gradebook_id = (int) $this->input->post('gradebook_id');
        $gradebook = $this->require_gradebook($gradebook_id);
        if (!$gradebook) {
            return;
        }

        $this->form_validation->set_rules('gradebook_student_id', 'Student', 'required|integer');
        $this->form_validation->set_rules('feedback_type', 'Feedback Type', 'required|trim');
        $this->form_validation->set_rules('comment', 'Comment', 'required|trim');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->redirect_to_gradebook($gradebook_id, 'feedback');
            return;
        }

        $this->gradebook_model->save_feedback($gradebook_id, array(
            'gradebook_student_id' => (int) $this->input->post('gradebook_student_id'),
            'activity_id' => (int) $this->input->post('activity_id'),
            'feedback_type' => trim((string) $this->input->post('feedback_type')),
            'comment' => trim((string) $this->input->post('comment')),
        ));

        $this->session->set_flashdata('success', 'Feedback saved successfully.');
        $this->redirect_to_gradebook($gradebook_id, 'feedback');
    }

    public function report($gradebook_id, $type = 'class_record')
    {
        if (!$this->ensure_schema_ready()) {
            return;
        }

        $gradebook = $this->require_gradebook((int) $gradebook_id);
        if (!$gradebook) {
            return;
        }

        $method = $this->input->get('method') === 'deped' ? 'deped' : 'standard';
        if ($type === 'report_card') {
            $report = $this->gradebook_model->build_report_card_report($gradebook_id, $method);
            $filename = 'report_card_' . $gradebook_id . '.csv';
        } else {
            $report = $this->gradebook_model->build_class_record_report($gradebook_id, $method);
            $filename = 'class_record_' . $gradebook_id . '.csv';
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, $report['headers']);
        foreach ($report['rows'] as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }

    private function require_gradebook($gradebook_id)
    {
        $gradebook = $this->gradebook_model->get_gradebook((int) $gradebook_id, (int) $this->session->userdata('current_userid'));
        if (!$gradebook) {
            $this->session->set_flashdata('error', 'Gradebook not found.');
            redirect('academics/gradebook');
            return null;
        }

        return $gradebook;
    }

    private function redirect_to_gradebook($gradebook_id, $tab, $extra = array())
    {
        $params = array_merge(array(
            'gradebook_id' => (int) $gradebook_id,
            'tab' => $tab,
        ), $extra);

        redirect('academics/gradebook?' . http_build_query($params));
    }

    private function ensure_schema_ready()
    {
        if ($this->gradebook_model->gradebook_tables_exist()) {
            return true;
        }

        $this->session->set_flashdata('error', 'Import the gradebook SQL schema first before using the gradebook backend.');
        redirect('academics/gradebook');
        return false;
    }
}

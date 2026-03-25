<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myprofile extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('profile_model');
		$this->load->model('students_model');
		$this->load->model('payments_model');

	}
	
	public function index()
	{
		$query = $this->profile_model->getInfo();
		$row = $query->num_rows() > 0 ? $query->row() : null;
		$can_self_manage = $this->can_manage_own_profile($row);
		$role_label = $this->get_role_label($row);
		if ($this->is_super_admin_account($row)) {
			$this->session->set_userdata('current_usertype_display', 'Super Admin');
		} elseif ($row && trim((string) $row->usertype) !== '') {
			$this->session->set_userdata('current_usertype_display', $row->usertype);
		} else {
			$this->session->set_userdata('current_usertype_display', $this->session->userdata('current_usertype'));
		}

		// Menu
		if($this->session->userdata('current_usertype') != 'Parent'):
			
		endif;
		
		$data = array(
		'title'     =>   'My Profile',
		'template'   =>   'profile/edit',
		'query' => $query,
		'can_self_manage' => $can_self_manage,
		'role_label' => $role_label
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function updateinfo_submit()
	{
		$query = $this->profile_model->getInfo();
		$row = $query->num_rows() > 0 ? $query->row() : null;

		if (!$this->can_manage_own_profile($row)) {
			$this->session->set_flashdata('message', "Changes to your profile, including password updates, require admin permission first.");
			redirect("myprofile");
			return;
		}

		$this->form_validation->set_rules('mobileno', 'Mobile No. or Login', 'required|trim');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('emailadd', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('birthdate', 'Birthdate', 'trim');
		$this->form_validation->set_rules('cpassword', 'New Password', 'trim|matches[rpassword]');
		$this->form_validation->set_rules('rpassword', 'Repeat Password', 'trim');
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');

		if (!$this->form_validation->run()) {
			$this->index();
			return;
		}

		$data = array(
			'mobileno' => trim((string) $this->input->post('mobileno')),
			'firstname' => trim((string) $this->input->post('firstname')),
			'lastname' => trim((string) $this->input->post('lastname')),
			'emailadd' => trim((string) $this->input->post('emailadd')),
			'birthdate' => trim((string) $this->input->post('birthdate')),
		);

		if (strlen(trim((string) $this->input->post('cpassword'))) > 0) {
			$data['userpass'] = md5($this->input->post('cpassword'));
		}

		$this->profile_model->updateinfo($data);
		$this->session->set_userdata('current_firstname', $data['firstname']);
		$this->session->set_userdata('current_mobileno', $data['mobileno']);
		if ($this->is_super_admin_account($row)) {
			$this->session->set_userdata('current_usertype_display', 'Super Admin');
		}

		$this->session->set_flashdata('message', "Successfully updated your profile.");
		redirect("myprofile");
	}
	
	public function grades()
	{
		$student = $this->get_current_student();
		$learning_data = $this->get_learning_data($student);

		$data = array(
			'title'     =>   'My Grades',
			'template'   =>   'profile/grades',
			'student' => $student,
			'assessment' => $learning_data['assessment'],
			'subjects' => $learning_data['subjects'],
			'pace_progress' => $learning_data['pace_progress'],
			'conventional_subjects' => $learning_data['conventional_subjects']
		);
		
		$this->load->view('template', $data);
	}
	
	public function schedule()
	{
		$student = $this->get_current_student();
		$learning_data = $this->get_learning_data($student);

		$data = array(
			'title'     =>   'Class Schedule',
			'template'   =>   'profile/schedule',
			'student' => $student,
			'subjects' => $learning_data['subjects'],
			'pace_progress' => $learning_data['pace_progress'],
			'conventional_subjects' => $learning_data['conventional_subjects']
		);
		
		$this->load->view('template', $data);
	}

	public function subjects()
	{
		// Student quick-action page added for the dashboard "My Subjects" card.
		$student = $this->get_current_student();
		$query_ass = $this->empty_query();
		$query_academics = $this->empty_query();

		if (!empty($student->has_student_record)) {
			$enroll_id = $student->enroll_id;
			$query_ass = $this->students_model->assessment_check($enroll_id);
			$query_academics = $this->students_model->getStudentAcademics($enroll_id);
		}

		$data = array(
			'title' => 'My Subjects',
			'template' => 'profile/subjects',
			'student' => $student,
			'subjects' => $this->build_subject_list($query_ass, $query_academics),
			'query_academics' => $query_academics
		);

		$this->load->view('template', $data);
	}

	public function payments()
	{
		// Student quick-action page added for the dashboard "Payments" card.
		$student = $this->get_current_student();
		$query_payments = !empty($student->has_student_record)
			? $this->payments_model->getStudentPayments($student->id)
			: $this->empty_query();
		$total_amount = 0;
		$paid_count = 0;

		foreach ($query_payments->result() as $payment) {
			$total_amount += (float) $payment->payment_total;
			if (strtolower((string) $payment->paid) === 'yes') {
				$paid_count++;
			}
		}

		$data = array(
			'title' => 'Payments',
			'template' => 'profile/payments',
			'student' => $student,
			'query_payments' => $query_payments,
			'total_amount' => $total_amount,
			'paid_count' => $paid_count
		);

		$this->load->view('template', $data);
	}

	public function enrollment()
	{
		// Student quick-action page added for the dashboard "Enrollment" card.
		$student = $this->get_current_student();
		$query_ass = $this->empty_query();
		$query_academics = $this->empty_query();

		if (!empty($student->has_student_record)) {
			$enroll_id = $student->enroll_id;
			$query_ass = $this->students_model->assessment_check($enroll_id);
			$query_academics = $this->students_model->getStudentAcademics($enroll_id);
		}

		$subjects = $this->build_subject_list($query_ass, $query_academics);
		$assessment = $query_ass->num_rows() > 0 ? $query_ass->row() : null;

		$data = array(
			'title' => 'Enrollment',
			'template' => 'profile/enrollment',
			'student' => $student,
			'subjects' => $subjects,
			'assessment' => $assessment
		);

		$this->load->view('template', $data);
	}

	private function get_current_student()
	{
		// Shared resolver for the new student-facing My Profile pages.
		// It first tries a real enrolled student record, then falls back to portal profile data.
		$query = $this->students_model->getCurrentStudentRecord();
		if ($query->num_rows() > 0) {
			$student = $query->row();
			$student->has_student_record = true;
			return $student;
		}

		$profile = $this->profile_model->getInfo();
		$row = $profile->num_rows() > 0 ? $profile->row() : new stdClass();

		$student = new stdClass();
		$student->id = 0;
		$student->enroll_id = 0;
		$student->firstname = isset($row->firstname) ? $row->firstname : $this->session->userdata('current_firstname');
		$student->lastname = isset($row->lastname) ? $row->lastname : '';
		$student->gradelevel = '-';
		$student->enrollstatus = 'No active enrollment';
		$student->strand = '-';
		$student->newold = 'Portal';
		$student->ableforpt = 'N/A';
		$student->scholar = 'No';
		$student->studentno = isset($row->school_id) && strlen(trim((string) $row->school_id)) > 0 ? $row->school_id : '-';
		$student->lrn = isset($row->lrn) && strlen(trim((string) $row->lrn)) > 0 ? $row->lrn : '-';
		$student->has_student_record = false;

		return $student;
	}

	private function empty_query()
	{
		// Small helper so the new pages can render empty states without redirecting.
		return $this->db->query("SELECT 1 WHERE 0");
	}

	private function is_super_admin_account($row = null)
	{
		$current_userid = (int) $this->session->userdata('current_userid');
		$current_mobileno = trim((string) $this->session->userdata('current_mobileno'));
		if ($current_userid === 120 || strtolower($current_mobileno) === 'noieadmin') {
			return true;
		}

		if ($row) {
			$row_usertype = trim((string) $row->usertype);
			$row_mobileno = trim((string) $row->mobileno);
			if ($row_usertype === 'Super Admin' || strtolower($row_mobileno) === 'noieadmin') {
				return true;
			}
		}

		return false;
	}

	private function can_manage_own_profile($row = null)
	{
		if ($this->is_super_admin_account($row)) {
			return true;
		}

		$current_usertype = (string) $this->session->userdata('current_usertype');
		if ($current_usertype === 'Admin') {
			return true;
		}

		if ($row && trim((string) $row->usertype) === 'Admin') {
			return true;
		}

		return false;
	}

	private function get_role_label($row = null)
	{
		if ($this->is_super_admin_account($row)) {
			return 'Super Admin';
		}

		if ($row && trim((string) $row->usertype) !== '') {
			return $row->usertype;
		}

		return (string) $this->session->userdata('current_usertype');
	}

	private function get_learning_data($student)
	{
		$query_ass = $this->empty_query();
		$query_academics = $this->empty_query();

		if (!empty($student->has_student_record)) {
			$enroll_id = (int) $student->enroll_id;
			$query_ass = $this->students_model->assessment_check($enroll_id);
			$query_academics = $this->students_model->getStudentAcademics($enroll_id);
		}

		return array(
			'query_ass' => $query_ass,
			'query_academics' => $query_academics,
			'assessment' => $query_ass->num_rows() > 0 ? $query_ass->row() : null,
			'subjects' => $this->build_subject_list($query_ass, $query_academics),
			'pace_progress' => $this->build_pace_progress($query_ass, $query_academics),
			'conventional_subjects' => $this->build_conventional_subjects($query_academics)
		);
	}

	private function build_subject_list($query_ass, $query_academics = null)
	{
		$subjects = array();

		if ($query_ass && $query_ass->num_rows() > 0) {
			$row_ass = $query_ass->row();
			$assessment_subjects = array(
				'math' => 'Math',
				'english' => 'English',
				'science' => 'Science',
				'socstudies' => 'Social Studies',
				'wordbuilding' => 'Word Building',
				'literature' => 'Literature',
				'filipino' => 'Filipino',
				'afilipino' => 'Alfabetong Filipino',
				'ap' => 'Araling Panlipunan'
			);

			foreach ($assessment_subjects as $field => $label) {
				if (!empty($row_ass->$field) && trim(str_replace(',', '', $row_ass->$field)) !== '') {
					$subjects[] = $label;
				}
			}
		}

		if ($query_academics && $query_academics->num_rows() > 0) {
			$row_ac = $query_academics->row();
			$conventional_subjects = array(
				'speech' => 'Speech',
				'music' => 'Music',
				'bible' => 'Bible',
				'esp' => 'EsP',
				'tle' => 'TLE',
				'mapeh' => 'MAPEH',
				'mapeh_music' => 'MAPEH Music',
				'arts' => 'Arts',
				'pe' => 'P.E.',
				'health' => 'Health'
			);

			foreach ($conventional_subjects as $field => $label) {
				if (property_exists($row_ac, $field) && strlen(trim((string) $row_ac->$field)) > 0) {
					$subjects[] = $label;
				}
			}
		}

		$subjects = array_values(array_unique($subjects));
		sort($subjects);

		return $subjects;
	}

	private function build_pace_progress($query_ass, $query_academics = null)
	{
		$progress = array();
		$assessment = $query_ass && $query_ass->num_rows() > 0 ? $query_ass->row() : null;
		$academics = $query_academics && $query_academics->num_rows() > 0 ? $query_academics->row() : null;

		if (!$assessment) {
			return $progress;
		}

		$subject_map = array(
			'math' => array('label' => 'Math', 'academic_field' => 'math'),
			'english' => array('label' => 'English', 'academic_field' => 'eng'),
			'science' => array('label' => 'Science', 'academic_field' => 'science'),
			'socstudies' => array('label' => 'Social Studies', 'academic_field' => 'sstudies'),
			'wordbuilding' => array('label' => 'Word Building', 'academic_field' => 'wbuilding'),
			'literature' => array('label' => 'Literature', 'academic_field' => 'literature'),
			'filipino' => array('label' => 'Filipino', 'academic_field' => 'filipino'),
			'afilipino' => array('label' => 'Alfabetong Filipino', 'academic_field' => 'afilipino'),
			'ap' => array('label' => 'Araling Panlipunan', 'academic_field' => 'ap')
		);

		foreach ($subject_map as $assessment_field => $config) {
			$assigned = $this->parse_assessment_slots(isset($assessment->$assessment_field) ? $assessment->$assessment_field : '');
			if (count($assigned['paces']) === 0) {
				continue;
			}

			$entries = $this->parse_academic_entries(
				($academics && isset($academics->{$config['academic_field']})) ? $academics->{$config['academic_field']} : ''
			);

			$grades = array();
			foreach ($entries as $entry) {
				if ($entry['grade_numeric'] !== null) {
					$grades[] = $entry['grade_numeric'];
				}
			}

			$latest_entry = count($entries) > 0 ? end($entries) : null;
			$progress[] = array(
				'label' => $config['label'],
				'assigned_label' => $assigned['label'],
				'assigned_count' => count($assigned['paces']),
				'recorded_count' => count($entries),
				'average_grade' => count($grades) > 0 ? round(array_sum($grades) / count($grades), 2) : null,
				'latest_grade' => $latest_entry ? $latest_entry['grade'] : '',
				'latest_quarter' => $latest_entry ? $latest_entry['quarter'] : '',
				'latest_date' => $latest_entry ? $latest_entry['date'] : ''
			);
		}

		return $progress;
	}

	private function build_conventional_subjects($query_academics)
	{
		$subjects = array();
		if (!$query_academics || $query_academics->num_rows() === 0) {
			return $subjects;
		}

		$row = $query_academics->row();
		$subject_map = array(
			'speech' => 'Speech',
			'music' => 'Music',
			'bible' => 'Bible',
			'esp' => 'EsP',
			'tle' => 'TLE',
			'mapeh' => 'MAPEH',
			'mapeh_music' => 'MAPEH Music',
			'arts' => 'Arts',
			'pe' => 'P.E.',
			'health' => 'Health'
		);

		foreach ($subject_map as $field => $label) {
			$value = isset($row->$field) ? trim((string) $row->$field) : '';
			if ($value === '') {
				continue;
			}

			$quarters = array_map('trim', explode(',', $value));
			$quarters = array_pad($quarters, 4, '');
			$has_value = false;
			foreach ($quarters as $quarter_value) {
				if ($quarter_value !== '') {
					$has_value = true;
					break;
				}
			}

			if ($has_value) {
				$subjects[] = array(
					'label' => $label,
					'quarters' => array_slice($quarters, 0, 4)
				);
			}
		}

		return $subjects;
	}

	private function parse_assessment_slots($value)
	{
		$value = trim((string) $value);
		$parts = array_pad(explode(',', $value), 3, '');
		$paces = array();

		$start = (int) trim($parts[0]);
		$end = (int) trim($parts[1]);
		if ($start > 0 && $end >= $start) {
			for ($pace = $start; $pace <= $end; $pace++) {
				$paces[] = (string) $pace;
			}
		}

		$gaps = preg_split('/\s+/', trim($parts[2]), -1, PREG_SPLIT_NO_EMPTY);
		foreach ($gaps as $gap) {
			$gap = trim($gap);
			if ($gap !== '' && !in_array($gap, $paces, true)) {
				$paces[] = $gap;
			}
		}

		sort($paces, SORT_NATURAL);

		return array(
			'paces' => $paces,
			'label' => count($paces) > 0 ? implode(', ', $paces) : 'Not assigned'
		);
	}

	private function parse_academic_entries($value)
	{
		$value = trim((string) $value);
		if ($value === '') {
			return array();
		}

		$entries = array();
		$chunks = explode(',', $value);
		foreach ($chunks as $chunk) {
			$chunk = trim($chunk);
			if ($chunk === '') {
				continue;
			}

			$parts = array_pad(explode('|', $chunk), 4, '');
			$grade_numeric = is_numeric($parts[1]) ? (float) $parts[1] : null;
			$entries[] = array(
				'pace' => trim($parts[0]),
				'grade' => trim($parts[1]),
				'grade_numeric' => $grade_numeric,
				'date' => trim($parts[2]),
				'quarter' => trim($parts[3])
			);
		}

		usort($entries, function ($left, $right) {
			return strnatcmp($left['pace'], $right['pace']);
		});

		return $entries;
	}
	
}

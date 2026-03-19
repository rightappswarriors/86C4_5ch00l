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
		// Menu
		if($this->session->userdata('current_usertype') != 'Parent'):
			
		endif;
		
		$data = array(
		'title'     =>   'My Profile',
		'template'   =>   'profile/edit',
		'query' => $this->profile_model->getInfo()
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function updateinfo_submit()
	{
		$this->session->set_flashdata('message', "Changes to your profile, including password updates, require admin permission first.");
		redirect("myprofile");
	}
	
	public function grades()
	{
		$data = array(
			'title'     =>   'My Grades',
			'template'   =>   'profile/grades'
		);
		
		$this->load->view('template', $data);
	}
	
	public function schedule()
	{
		$data = array(
			'title'     =>   'Class Schedule',
			'template'   =>   'profile/schedule'
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
	
}

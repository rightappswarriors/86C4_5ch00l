<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	const REGISTER_REQUIRED_MOBILE_FALLBACK = 'N/A';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('register_model');
		if($this->session->userdata('logged_in')==1){
			redirect("dashboard");
		}
	}
	
	public function index()
	{
		$this->load->view('register');
	}
	
	function validation()
	{
		// [Team Note - 2026-03-09]
		// Registration now requires student credentials (LRN + School ID) instead of Mobile Number.
		$this->set_register_validation_rules();
		
		if($this->form_validation->run())
		{
			$lrn = $this->get_clean_post('lrn');
			$school_id = $this->get_clean_post('school_id');
			$student = $this->find_student_by_credentials($lrn, $school_id);
			if (!$student) {
				$this->session->set_flashdata('message', 'Student record not found for the provided LRN and School ID.');
				$this->index();
				return;
			}
			
			$data = $this->build_register_data($school_id);
			
			$id = $this->register_model->insert($data);
			if($id > 0)
			{
				$this->link_student_to_user($student->id, $id);
				$this->validsuccess();
			}
		}
		else
		{
			$this->index();
		}
	}

	public function validate_student_credentials($lrn)
	{
		$school_id = $this->get_clean_post('school_id');
		if (empty($school_id)) {
			$this->form_validation->set_message('validate_student_credentials', 'School ID is required.');
			return FALSE;
		}

		$student = $this->find_student_by_credentials($lrn, $school_id);
		if (!$student) {
			$this->form_validation->set_message('validate_student_credentials', 'The LRN and School ID do not match any student record.');
			return FALSE;
		}

		if (!empty($student->user_id)) {
			$this->form_validation->set_message('validate_student_credentials', 'This student already has a linked portal account.');
			return FALSE;
		}

		return TRUE;
	}

	private function find_student_by_credentials($lrn, $school_id)
	{
		$this->db->where('lrn', $lrn);
		$this->db->where('studentno', $school_id);
		$this->db->limit(1);
		$query = $this->db->get('students');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}

	private function set_register_validation_rules()
	{
		$this->form_validation->set_rules('lrn', 'LRN', 'required|trim|callback_validate_student_credentials');
		$this->form_validation->set_rules('school_id', 'School ID', 'required|trim');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('emailadd', 'E-mail', 'required|trim|valid_email');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('userpass', 'Password', 'required|trim|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('repeatpass', 'Repeat Password', 'required|trim|matches[userpass]');
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
	}

	private function build_register_data($school_id)
	{
		// [Team Note - 2026-03-09]
		// register.mobileno remains NOT NULL in schema, so School ID is stored as temporary compatibility value.
		$mobile_fallback = $school_id !== '' ? $school_id : self::REGISTER_REQUIRED_MOBILE_FALLBACK;
		return array(
			'emailadd'  => $this->get_clean_post('emailadd'),
			'lastname'  => $this->get_clean_post('lastname'),
			'firstname'  => $this->get_clean_post('firstname'),
			'mobileno'  => $mobile_fallback,
			'userpass' => md5((string) $this->input->post('userpass')),
			'dateadded'  => date("Y-m-d H:i:s")
		);
	}

	private function link_student_to_user($student_id, $user_id)
	{
		$this->db->where('id', $student_id);
		$this->db->limit(1);
		$this->db->update('students', array('user_id' => $user_id));
	}

	private function get_clean_post($key)
	{
		return trim((string) $this->input->post($key, TRUE));
	}
	
	public function validsuccess()
	{
		$this->load->view('validsuccess');
	}

	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
		$this->set_register_validation_rules();
		
		if($this->form_validation->run())
		{
			$data = $this->build_register_data();
			
			$id = $this->register_model->insert($data);
			if($id > 0)
			{
				$this->validsuccess();
			}
		}
		else
		{
			$this->index();
		}
	}

	private function set_register_validation_rules()
	{
		// Both email and mobile are now required for registration
		$this->form_validation->set_rules('emailadd', 'Email Address', 'required|trim|valid_email');
		$this->form_validation->set_rules('mobileno', 'Mobile Number', 'required|trim|min_length[11]|max_length[15]');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('birthdate', 'Birthdate', 'required|trim');
		$this->form_validation->set_rules('userpass', 'Password', 'required|trim|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('repeatpass', 'Repeat Password', 'required|trim|matches[userpass]');
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
	}

	private function build_register_data()
	{
		return array(
			'emailadd'  => $this->get_clean_post('emailadd'),
			'lastname'  => $this->get_clean_post('lastname'),
			'firstname'  => $this->get_clean_post('firstname'),
			'birthdate'  => $this->get_clean_post('birthdate'),
			'mobileno'  => $this->get_clean_post('mobileno'),
			'userpass' => md5((string) $this->input->post('userpass')),
			'dateadded'  => date("Y-m-d H:i:s"),
			'usertype' => 'Parent',  // Default user type for portal registration
			'status' => 1,  // Active status
			'lrn' => $this->get_clean_post('lrn'),
			'school_id' => $this->get_clean_post('school_id')
		);
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

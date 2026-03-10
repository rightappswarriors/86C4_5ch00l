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
			$register_type = $this->get_clean_post('register_type');
			$contact_value = $this->get_clean_post('contact_value');
			
			$data = $this->build_register_data($register_type, $contact_value);
			
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
		$register_type = $this->get_clean_post('register_type');
		
		if ($register_type === 'mobile') {
			$this->form_validation->set_rules('contact_value', 'Mobile Number', 'required|trim|min_length[11]|max_length[15]');
		} else {
			$this->form_validation->set_rules('contact_value', 'Email Address', 'required|trim|valid_email');
		}
		
		$this->form_validation->set_rules('register_type', 'Register Using', 'required|trim');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('userpass', 'Password', 'required|trim|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('repeatpass', 'Repeat Password', 'required|trim|matches[userpass]');
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
	}

	private function build_register_data($register_type, $contact_value)
	{
		if ($register_type === 'mobile') {
			$emailadd = '';
			$mobileno = $contact_value;
		} else {
			$emailadd = $contact_value;
			$mobileno = '';
		}
		
		return array(
			'emailadd'  => $emailadd,
			'lastname'  => $this->get_clean_post('lastname'),
			'firstname'  => $this->get_clean_post('firstname'),
			'mobileno'  => $mobileno,
			'userpass' => md5((string) $this->input->post('userpass')),
			'dateadded'  => date("Y-m-d H:i:s")
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

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
		$this->form_validation->set_rules('mobileno','Mobile Number','required|trim|min_length[11]|max_length[11]|is_unique[register.mobileno]',
		array('is_unique' => 'This %s is already exists.'));
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('userpass', 'Password', 'required|trim|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('repeatpass', 'Repeat Password', 'required|trim|matches[userpass]');
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$userpass = md5($this->input->post('userpass'));
			$data = array(
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname'),
				'mobileno'  => $this->input->post('mobileno'),
				'userpass' => $userpass,
				'dateadded'  => date("Y-m-d H:i:s")
			);
			
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
	
	public function validsuccess()
	{
		$this->load->view('validsuccess');
	}

	
}

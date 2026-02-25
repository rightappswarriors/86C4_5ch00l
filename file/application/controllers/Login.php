<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		
		if($this->session->userdata('logged_in')==1){
			redirect("dashboard");
		}

	}
	
	public function index()
	{
		$this->load->view('login');
	}
	
	public function forgotpass()
	{
		$this->load->view('forgotpass');
	}
	
	function validation()
	{
		$this->form_validation->set_rules('mobileno', 'Mobile Number', 'required|trim');
		$this->form_validation->set_rules('userpass', 'Password', 'required');
		if($this->form_validation->run())
		{
			$result = $this->login_model->can_login($this->input->post('mobileno'), $this->input->post('userpass'));
			if($result)
			{
				redirect("dashboard");
			}
			else
			{
				$message = "Wrong Number or Password!";
				$this->session->set_flashdata('message',$message);	
				$this->index();
			}
		}
		else
		{
			$message = "Wrong Number or Password!";
			$this->session->set_flashdata('message',$message);	
			$this->index();
		}
		
	}

}

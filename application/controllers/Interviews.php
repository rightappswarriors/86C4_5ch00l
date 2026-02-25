<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interviews extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('register_model');

	}
	
	public function index()
	{
		
		$data = array(
		'title'     =>   'Interview Schedules',
		'template'  =>   'interviewscheds',
		'query'		=> $this->register_model->get_schedulesfor_interview()
		);
		
		$this->load->view('template', $data);	
		
	}
	
}

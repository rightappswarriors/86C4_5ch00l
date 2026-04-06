<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academics extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		
		$allowed = array('teacher', 'admin');
		$usertype = strtolower($this->session->userdata('current_usertype'));
		if(!in_array($usertype, $allowed)){
			$this->session->set_flashdata('error', 'You do not have permission to access this page.');
			redirect("dashboard");
		}

	}
	
	public function index()
	{
		$data = array(
		'title'     =>   'ACADEMICS',
		'template'   =>   'academics'
		);
		$this->load->view('template', $data);	
		
	}

	public function gradebook()
	{		
		$data = array(
			'title'     =>   'Gradebook',
			'template'   =>   'academics/gradebook'
		);
		
		$this->load->view('template', $data);	
	}
}

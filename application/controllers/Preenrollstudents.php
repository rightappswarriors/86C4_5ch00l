<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preenrollstudents extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('students_model');

	}
	
	public function index()
	{
		$data = array(
			'title'     =>   'STUDENTS // Pre-enrolled Student Applications',
			'template'   =>   'students/preenrolllist',
			'query' => $this->students_model->preenrolllist()
		);
		
		$this->load->view('template', $data);	
		
	}
	
	
	
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('students_model');
		$this->load->model('payments_model');
	}
	
	public function index()
	{
		//print_r($this->session->userdata);
		
		$this->session->set_flashdata('message', "<span style='font-weight:bold;'>New School Year activated ".$this->session->userdata('current_schoolyear')."</span>");
		
		$usertype = strtolower($this->session->userdata('current_usertype'));
		$data = array(
		'title'     =>   'DASHBOARD',
		'template'   =>   $usertype.'_dashboard'
		);
		
		$data['count_reenrollments'] = $this->students_model->count_reenrollments();
		$data['count_newold_students'] = $this->students_model->count_newold_students();
		$data['count_gradelevel_students'] = $this->students_model->count_gradelevel_students();
		
		if($this->session->userdata('current_usertype') != 'Parent' and $this->session->userdata('current_usertype') != 'Accounting'){
			$data['query'] = $this->students_model->students_list_dashboard();
		}
		if($this->session->userdata('current_usertype') == 'Accounting'){
			$data['query'] = $this->payments_model->getRecentPayments();
		}
		if($this->session->userdata('current_usertype') == 'Teacher'){
			$data['query'] = $this->students_model->getRecentActive();
		}
		
		$this->load->view('template', $data);	
		
	}
	
	public function changesy(){
		
		$this->session->set_userdata('current_schoolyearid', $this->input->post('sy_id') );
		$this->session->set_userdata('current_schoolyear', $this->input->post('sy_name') );
		$this->session->set_flashdata('message', "<span style='font-weight:bold;'>Current School Year activated ".$this->session->userdata('current_schoolyear')."</span>");
		
	}
	
}

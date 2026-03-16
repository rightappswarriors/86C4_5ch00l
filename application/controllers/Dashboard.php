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
		if($this->session->userdata('current_usertype') == 'Student'){
			// Feed the student dashboard cards with live summary data for the new quick-action pages.
			$current_student_query = $this->students_model->getCurrentStudentRecord();
			if ($current_student_query->num_rows() > 0) {
				$current_student = $current_student_query->row();
				$data['current_student'] = $current_student;
				$data['current_student_payments_count'] = $this->payments_model->getStudentPayments($current_student->id)->num_rows();
				$data['current_student_subject_count'] = 0;

				$query_ass = $this->students_model->assessment_check($current_student->enroll_id);
				if ($query_ass->num_rows() > 0) {
					$row_ass = $query_ass->row();
					$fields = array('math','english','science','socstudies','wordbuilding','literature','filipino','afilipino','ap');
					foreach ($fields as $field) {
						if (!empty($row_ass->$field) && trim(str_replace(',', '', $row_ass->$field)) !== '') {
							$data['current_student_subject_count']++;
						}
					}
				}
			}
		}
		
		$this->load->view('template', $data);	
		
	}
	
	public function changesy(){
		
		$this->session->set_userdata('current_schoolyearid', $this->input->post('sy_id') );
		$this->session->set_userdata('current_schoolyear', $this->input->post('sy_name') );
		$this->session->set_flashdata('message', "<span style='font-weight:bold;'>Current School Year activated ".$this->session->userdata('current_schoolyear')."</span>");
		
	}
	
}

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
		$this->load->model('students_model');

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
	
	public function by_date($date = null)
	{
		if($date === null || !$date) {
			$date = date('Y-m-d');
		}
		
		$schoolyear = $this->session->userdata('current_schoolyearid');
		
		$query = $this->db->query("
			select a.*, b.*, c.firstname as parentfname, c.lastname as parentlname 
			from students a
			join interviewsched b on b.studentid = a.id
			left join register c on c.id = a.user_id
			where b.status = 1 
			and b.schoolyear = ? 
			and b.interviewdate = ?
			order by b.interviewtime asc
		", array($schoolyear, $date));
		
		$data = array(
			'title'     =>   'Interview Schedules',
			'template'  =>   'interviewscheds',
			'query'		=> $this->register_model->get_schedulesfor_interview(),
			'selected_date' => $date,
			'date_interviews' => $query
		);
		
		$this->load->view('template', $data);
	}
	
	public function ajax_get_by_date()
	{
		$date = $this->input->post('date');
		
		if(!$date) {
			echo json_encode(['success' => false, 'message' => 'Date required']);
			exit;
		}
		
		$schoolyear = $this->session->userdata('current_schoolyearid');
		
		// Check all interviews in DB for this date regardless of schoolyear
		$debug_query = $this->db->query("
			select a.id as studentid, a.firstname, a.middlename, a.lastname, a.grade, a.section,
			       b.interviewdate, b.interviewtime, b.slot_duration, b.schoolyear,
			       c.firstname as parentfname, c.lastname as parentlname, c.mobileno
			from students a
			join interviewsched b on b.studentid = a.id
			left join register c on c.id = a.user_id
			where b.status = 1 
			and b.interviewdate = ?
			order by b.interviewtime asc
		", array($date));
		
		$interviews = [];
		if($debug_query->num_rows() > 0) {
			foreach($debug_query->result() as $row) {
				$fullname = trim($row->firstname . ' ' . ($row->middlename ? $row->middlename . ' ' : '') . $row->lastname);
				$parent_contact = $row->mobileno ? $row->mobileno : '';
				
				$interviews[] = [
					'studentid' => $row->studentid,
					'student_name' => $fullname,
					'grade' => $row->grade,
					'section' => $row->section,
					'interviewtime' => date('h:i A', strtotime($row->interviewtime)),
					'interviewdate' => $row->interviewdate,
					'schoolyear' => $row->schoolyear,
					'duration' => $row->slot_duration,
					'parent_name' => ($row->parentfname || $row->parentlname) ? trim($row->parentfname . ' ' . $row->parentlname) : '',
					'parent_contact' => $parent_contact
				];
			}
		}
		
		echo json_encode([
			'success' => true,
			'date' => $date,
			'count' => count($interviews),
			'interviews' => $interviews
		]);
		exit;
	}
	
}

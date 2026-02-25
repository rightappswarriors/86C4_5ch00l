<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mystudents extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('mystudents_model');

	}
	
	public function index()
	{
		$data = array(
			'title'     =>   'My Students',
			'template'   =>   'mystudents/list',
			'query' => $this->mystudents_model->mystudents()
		);
		
		$this->load->view('template', $data);	
		
	}
	
	
	
}

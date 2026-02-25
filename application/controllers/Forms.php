<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}

	}
	
	public function index()
	{
		$data = array(
		'title'     =>   'FORMS',
		'template'   =>   'forms'
		);
		$this->load->view('template', $data);	
		
	}
}

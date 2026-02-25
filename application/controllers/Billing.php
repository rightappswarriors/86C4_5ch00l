<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

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
		'title'     =>   'BILLING',
		'template'   =>   'billing'
		);
		$this->load->view('template', $data);	
		
	}
}

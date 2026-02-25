<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myprofile extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('profile_model');

	}
	
	public function index()
	{
		// Menu
		if($this->session->userdata('current_usertype') != 'Parent'):
			
		endif;
		
		$data = array(
		'title'     =>   'My Profile',
		'template'   =>   'profile/edit',
		'query' => $this->profile_model->getInfo()
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function updateinfo_submit()
	{
		$id = $this->session->userdata('current_userid');
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'New Password', 'trim|matches[rpassword]');
		$this->form_validation->set_rules('rpassword', 'Repeat Password', 'trim');
	
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$data = array(
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname')
			);
			
			if( strlen(trim($this->input->post('cpassword')))>0 ){
				$data['userpass'] = md5($this->input->post('cpassword'));
			}
			
			$this->profile_model->updateinfo($data);
			
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated your profile!");
			$this->session->set_userdata('current_firstname', $this->input->post('firstname'));
			redirect("myprofile");
			
			
		}else{
			
			$this->index();
		}		
	}
	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		//$this->load->model('profile_model');
		$this->load->model('users_model');

	}
	
	public function index()
	{
		$data = array(
			'title'     =>   'USERS',
			'template'   =>   'users/list',
			'query' => $this->users_model->getUsers()
		);
		$this->load->view('template', $data);	
		
	}
	
	public function create()
	{
		$data = array(
			'title'     =>   'USERS',
			'template'   =>   'users/create'
			//'query' => $this->users_model->getUsers()
		);
		$this->load->view('template', $data);		
		
	}
	
	public function create_submit()
	{
		$this->form_validation->set_rules('usertype', 'User Type', 'required|trim');
		$this->form_validation->set_rules('mobileno', 'Mobile No./Login', 'required|trim');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'New Password', 'trim|matches[rpassword]');
		$this->form_validation->set_rules('rpassword', 'Repeat Password', 'trim');
	
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$data = array(
				'mobileno'  => $this->input->post('mobileno'),
				'gradelevel'  => $this->input->post('gradelevel'),
				'gradelevel1'  => $this->input->post('gradelevel1'),
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname'),
				'userpass'  => md5($this->input->post('cpassword')),
				'usertype'  => $this->input->post('usertype')
			);
			
			if($this->users_model->create($data)>0):
				//message successful	
				$this->session->set_flashdata('message', "Successfully New User Added!");
				redirect("users/create");
			endif;
			
			
		}else{
			
			$this->index();
		}		
	}
	
	public function remove_user($userid)
	{
		if($this->users_model->remove_user( $userid ))
		{
			$this->session->set_flashdata('message', "Successfully removed!");
			redirect("users");
		}	
		
	}
	
	public function updateuser($userid)
	{
		$data = array(
		'title'     =>   'Update User',
		'template'   =>   'users/edit',
		'query' => $this->users_model->getInfo($userid)
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function update_submit()
	{
		$this->form_validation->set_rules('usertype', 'User Type', 'required|trim');
		$this->form_validation->set_rules('mobileno', 'Mobile No./Login', 'required|trim');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'New Password', 'trim|matches[rpassword]');
		$this->form_validation->set_rules('rpassword', 'Repeat Password', 'trim');
	
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$data = array(
				'mobileno'  => $this->input->post('mobileno'),
				'gradelevel'  => $this->input->post('gradelevel'),
				'gradelevel1'  => $this->input->post('gradelevel1'),
				'usertype'  => $this->input->post('usertype'),
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname')
			);
			
			if( strlen(trim($this->input->post('cpassword')))>0 ){
				$data['userpass'] = md5($this->input->post('cpassword'));
			}
			
			$this->users_model->updateinfo($data,$this->uri->segment(3));
			
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated profile!");
			redirect("users");
			
			
		}else{
			
			$this->index();
		}		
	}
	
}

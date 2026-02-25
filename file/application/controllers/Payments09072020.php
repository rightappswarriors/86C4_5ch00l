<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

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
		$data = array(
			'title'     =>   'PAYMENTS',
			'template'   =>   'payments/list',
			'query_payments' => $this->payments_model->getPayments()
		);
		$this->load->view('template', $data);	
		
	}
	
	public function statement()
	{
		$studentid = $this->uri->segment(3);	
		$data = array(
			'title'     =>   'State of Account',
			'template'   =>   'payments/statement',
			'query' => $this->students_model->search_student_info($studentid)
		);
		$this->load->view('template', $data);	
		
	}
	
	public function showlist(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'PAYMENTS',
			'template'   =>   'payments/payments',
			'query' => $this->students_model->search_student_info( $studentid ),
			'query_payments' => $this->payments_model->getStudentPayments( $studentid )
		);
		$this->load->view('template', $data);		
	}
	
	public function create()
	{
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$data = array(
		'title'     =>   'CREATE PAYMENT',
		'template'   =>   'payments/create',
		'query' => $this->students_model->search_student_info($studentid),
		'query_ass' => $this->students_model->assessment_check($enroll_id),
		'default_ass' => $this->payments_model->default_assessment()
		);
		$this->load->view('template', $data);	
		
	}
	
	public function create_submit($studentid){
		
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		if( $this->input->post('id_item') !== null ){
			
			// PAYMENTS DATA
			$payments_data = array(
				'payment_date' => date("Y-m-d",strtotime($this->input->post('payment_date'))),
				'payment_total' => $this->input->post('payment_total'),
				'payment_note' => $this->input->post('payment_note'),
				'autogen_payment' => 'no',
				'student_id' => $studentid,
				'enroll_id' => $enroll_id,
				'userid'  => $this->session->userdata('current_userid'),
				'dateadded'  => date("Y-m-d H:i:s")
			);
			
			// insert PAYMENT Master
			$payment_id = $this->payments_model->create($payments_data);
			
			// insert PAYMENT Details
			$prices = $this->input->post('price_item');
			$qtys = $this->input->post('qty_item');
			$types = $this->input->post('type_item');
			foreach($this->input->post('id_item') as $ind=>$item){
				
				$details_data = array(
					'payment_id' => $payment_id,
					'type_item' => $types[$ind],
					'id_item' => $item,
					'price_item' => $prices[$ind],
					'qty_item' => $qtys[$ind]
				);
				$this->payments_model->create_payment_details($details_data);
				
			}
			
			$this->session->set_flashdata('message', "Successfully added new payment!");
			redirect("payments/update_payment/".$payment_id);
			
		}else{
			
			$this->create();
			
		}
		
	}
	
	public function update_payment( $payment_id )
	{
		
		$qry_master = $this->payments_model->getPaymentInfo( $payment_id );
		$enroll_id = $qry_master->row()->enroll_id;
		$student_id = $qry_master->row()->student_id;
		
		$data = array(
			'title'     =>   'Payment Details',
			'template'   =>   'payments/update',
			'query' => $this->students_model->search_student_info($student_id),
			'query_ass' => $this->students_model->assessment_check($enroll_id),
			'default_ass' => $this->payments_model->default_assessment(),
			'payment_master' => $qry_master,
			'payment_details' => $this->payments_model->getPaymentDetails( $payment_id )
		);
		$this->load->view('template', $data);	
		
	}
	
	public function update_submit( $payment_id ){
		
		if( $this->input->post('id_item') !== null ){
		
			// PAYMENTS DATA
			$payments_data = array(
				'payment_date' => date("Y-m-d",strtotime($this->input->post('payment_date'))),
				'payment_total' => $this->input->post('payment_total'),
				'payment_note' => $this->input->post('payment_note'),
				'paid' => $this->input->post('paid')
			);
			
			// update PAYMENT Master
			$this->payments_model->update_master($payment_id,$payments_data);
			
			// delete PAYMENT Details
			$this->payments_model->remove_payment_details($payment_id);
			
			// replace or insert PAYMENT Details
			$prices = $this->input->post('price_item');
			$qtys = $this->input->post('qty_item');
			$types = $this->input->post('type_item');
			foreach($this->input->post('id_item') as $ind=>$item){
				
				$details_data = array(
					'payment_id' => $payment_id,
					'type_item' => $types[$ind],
					'id_item' => $item,
					'price_item' => $prices[$ind],
					'qty_item' => $qtys[$ind]
				);
				$this->payments_model->create_payment_details($details_data);
				
			}
			
			$this->session->set_flashdata('message', "Successfully updated payment!");
			redirect("payments/update_payment/".$payment_id);
			
		}else{
			
			redirect("payments/update_payment/".$payment_id);
			
		}
		
	}
	
	public function remove_payment( $id )
	{
		if($this->payments_model->removePayment( $id )){
			$this->session->set_flashdata('message', "Successfully removed payment!");
			redirect("payments/showlist/".$this->uri->segment(4));
		}
	}
	
	public function remove_payments( $id )
	{
		if($this->payments_model->removePayment( $id )){
			$this->session->set_flashdata('message', "Successfully removed payment!");
			redirect("payments");
		}
	}
	
	public function deposit_file( $payment_id ){
		
		$student_id = $this->uri->segment(4);
		
		$path_target = './file_upload/payments/'.$payment_id;
		if(!is_dir( $path_target )){
			mkdir( $path_target ,0777,TRUE);
		}
		
		$config['upload_path'] = $path_target;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
		$config['max_size'] = 6000;
		
		$this->load->library('upload',$config);
		
		$err=0;
		// FILE UPLOAD...
		if( !empty( $_FILES['deposit_file']['name'] ) )
		{	
			if( !$this->upload->do_upload('deposit_file') )
			{				
				$err=1;	
			}else{
				
				$data['deposit_file'] = str_replace(" ","_",$_FILES['deposit_file']['name']);
				// update if already uploaded before
				$this->payments_model->deposit_file( $data,$payment_id );
				
			}
		}
		
		if($err==1){
			
			//message error
			$this->session->set_flashdata('message', $this->upload->display_errors());
			
		}else{
			
			// message success
			$this->session->set_flashdata('message', "Successfully uploaded!");
			
		}
		redirect("payments/showlist/".$student_id);
		
	}
	
}

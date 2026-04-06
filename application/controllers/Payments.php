<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	private const USER_TYPE_ADMIN = 'Admin';
	private const USER_TYPE_ACCOUNTING = 'Accounting';
	private const USER_TYPE_PRINCIPAL = 'Principal';
	private const USER_TYPE_REGISTRAR = 'Registrar';
	private const USER_TYPE_PARENT = 'Parent';
	private const PRINT_BLOCK_MESSAGE = 'Printing the SOA is not available for this account.';
	
	//private $profile_pic;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('students_model');
		$this->load->model('payments_model');
		//$this->profile_pic = 'default-profile.jpg';
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
	
	public function print_payment(){
		
		$paymentid = $this->uri->segment(3);
		
		$query = $this->payments_model->getPaymentById($paymentid);
		
		if($query->num_rows() > 0){
			$data = array(
				'title'     =>   'Payment Receipt',
				'template'   =>   'payments/payment_print',
				'payment' => $query->row()
			);
			$this->load->view('template_print', $data);	
		} else {
			redirect('payments');
		}
	}
	
	public function statement()
	{
		$studentid = $this->uri->segment(3);
		$data = $this->build_statement_data($studentid);
		$data['template'] = 'payments/statement';
		$this->load->view('template', $data);	
		
	}
	
	public function statement_print()
	{
		$studentid = $this->uri->segment(3);

		if (!$this->can_print_soa()) {
			$this->redirect_to_statement($studentid, self::PRINT_BLOCK_MESSAGE);
		}

		$data = $this->build_statement_data($studentid);
		$data['template'] = 'payments/statement_print';
		$this->load->view('template_print', $data);	
		
	}
	
	public function showlist(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'PAYMENTS',
			'template'   =>   'payments/payments',
			'query' => $this->students_model->search_student_info( $studentid ),
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
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
		'profile_pic' => $this->students_model->profile_pic( $studentid ),
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
				'invoice_number' => $this->input->post('invoice_number'),
				'payment_note' => $this->input->post('payment_note'),
				'autogen_payment' => 'no',
				'student_id' => $studentid,
				'enrollpay' => $this->input->post('enrollpay'),
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
			'profile_pic' => $this->students_model->profile_pic( $student_id ),
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
				'invoice_number' => $this->input->post('invoice_number'),
				'payment_note' => $this->input->post('payment_note'),
				'enrollpay' => $this->input->post('enrollpay'),
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
	
	public function ableforpt()
	{
		$this->payments_model->ableforpt();
		$this->session->set_flashdata('message', "Successfully updated!");
		redirect("students");
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
	
	public function scholar()
	{
		$studentid = $this->uri->segment(4);	
		$enroll_id = $this->students_model->enroll_info($studentid);
		$yesno = $this->uri->segment(3);	
		if($this->payments_model->scholar($yesno,$enroll_id))
		{
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated!");
			redirect("students/details/".$studentid);
		}
	}

	private function can_view_detailed_soa()
	{
		return $this->current_user_type() === self::USER_TYPE_ADMIN;
	}

	private function can_print_soa()
	{
		return in_array($this->current_user_type(), $this->printable_user_types(), true);
	}

	private function current_user_type()
	{
		return (string) $this->session->userdata('current_usertype');
	}

	private function build_statement_data($studentid)
	{
		$enroll_id = $this->students_model->enroll_info($studentid);

		return array(
			'title' => 'State of Account',
			'query' => $this->students_model->search_student_info($studentid),
			'profile_pic' => $this->students_model->profile_pic($studentid),
			'query_ass' => $this->students_model->assessment_check($enroll_id),
			'default_ass' => $this->payments_model->default_assessment(),
			'query_payments' => $this->payments_model->getStudentPaymentsPaid($studentid, $enroll_id),
			'paid_enroll' => $this->payments_model->getStudentPaymentsPaidEnroll($studentid, $enroll_id),
			'can_view_detailed_soa' => $this->can_view_detailed_soa(),
			'can_print_soa' => $this->can_print_soa()
		);
	}

	private function printable_user_types()
	{
		return array(
			self::USER_TYPE_ADMIN,
			self::USER_TYPE_ACCOUNTING,
			self::USER_TYPE_PRINCIPAL,
			self::USER_TYPE_REGISTRAR
		);
	}

	private function redirect_to_statement($studentid, $message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('payments/statement/' . $studentid);
	}
	
}

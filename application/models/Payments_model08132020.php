<?php
class Payments_model extends CI_Model
{
	function create($data)
	{
		$this->db->insert('payments', $data);
		$id = $this->db->insert_id();
		
		//construct the code...
		$code = "P".date("y").sprintf("%04s",$id);
		
		//update Master Payment with the code...
		$data = array( 'payment_code' => $code );
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('payments', $data);
		
		return $id;
		
	}
	
	function create_payment_details($data)
	{
		return $this->db->insert('payment_details', $data);
	}

	function default_assessment(){
		
		$query = $this->db->query("select * from schoolyear where id = ".$this->session->userdata('current_schoolyearid'));
		return $query;
	}
	
	function getPaymentInfo($id){
		return $this->db->query("select * from payments where id = $id");
	}
	
	function getPaymentDetails($id){
		return $this->db->query("select * from payment_details where payment_id = $id");
	}
	
	function update_master($id,$data){
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('payments', $data);	
	}
	
	function removePayment($id){
		$data = array( 'deleted' => "yes" );
		$this->db->where('id', $id);
		$this->db->limit(1);
		return $this->db->update('payments', $data);	
	}
	
	function remove_payment_details($id){
		$this->db->where("payment_id",$id);
		$this->db->delete("payment_details");
	}
	
	function getStudentPayments( $student_id ){
		
		return $this->db->query("select * from payments where deleted = 'no' and student_id = ".$student_id." order by id desc");
		
	}
	
	function getPayments(){
		
		return $this->db->query("select a.*,b.firstname,b.lastname from payments a 
		left join students b on b.id = a.student_id 
		where deleted = 'no' order by id desc");
		
	}
	
	function deposit_file( $data, $payment_id )
	{
		$this->db->where("id",$payment_id);	
		return $this->db->update('payments',$data);
	}

}

?>
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
	
	function scholar($yesno,$enroll_id)
	{
		$data = array( 'scholar' => $yesno );
		$this->db->where('id', $enroll_id);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}
	
	function create_payment_details($data)
	{
		return $this->db->insert('payment_details', $data);
	}

	function default_assessment(){
		
		$query = $this->db->query("select * from schoolyear where id = ".$this->session->userdata('current_schoolyearid'));
		if($query->num_rows() == 0){
			$query = $this->db->query("select * from schoolyear where status = 1 order by id desc limit 1");
		}
		return $query;
	}
	
	function getPaymentInfo($id){
		return $this->db->query("select * from payments where id = $id");
	}
	
	function getEnrollPay($id){
		return $this->db->query("select * from payments where autogen_payment = 'yes' and deleted = 'no' and enroll_id = $id");
	}
	
	function getEnrollId($id){
		$qry = $this->db->query("select id from enrolled where studentid = $id limit 1");
		$row = $qry->row();
		return $row->id;
	}
	
	function getEnrollPayment($id){
		$qry = $this->db->query("select * from assessment where enroll_id = $id limit 1");
		if($qry->num_rows() > 0):
			$row = $qry->row();
			return $row->payment;
		else:
			return 0;
		endif;
	}
	
	function getEnrollPaymentcheck($id){
		return $this->db->query("select * from assessment where enroll_id = $id limit 1");
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
	
	function getStudentPaymentsPaid( $student_id,$enroll_id ){
		
		return $this->db->query("select * from payments where deleted = 'no' and enroll_id = ".$enroll_id." and student_id = ".$student_id." and paid = 'yes' order by payment_date asc");
		
	}
	
	function getStudentPaymentsPaidEnroll( $student_id,$enroll_id ){
		
		return $this->db->query("select * from payments where deleted = 'no' and enroll_id = ".$enroll_id." and enrollpay = 'yes' and student_id = ".$student_id." and paid = 'yes' order by payment_date asc");
		
	}
	
	function getStudentPayments( $student_id ){
		
		return $this->db->query("select * from payments where deleted = 'no' and student_id = ".$student_id." order by payment_date asc");
		
	}
	
	function getPrepaids($enroll_id){
		return $this->db->query("select * from payments 
		where deleted = 'no' and enroll_id = ".$enroll_id." and payment_date <= '".date("2020-08-01")."'
		order by id desc");
	}
	
	function getPayments(){
		
		return $this->db->query("select a.*,b.firstname,b.lastname from payments a 
		left join students b on b.id = a.student_id 
		left join enrolled c on c.id = a.enroll_id  
		where c.schoolyear = ".$this->session->userdata('current_schoolyearid')." and a.deleted = 'no' order by a.id desc limit 10");
		
	}
	
	function getPaymentById($id){
		return $this->db->query("select a.*,b.firstname,b.lastname from payments a 
		left join students b on b.id = a.student_id 
		left join enrolled c on c.id = a.enroll_id  
		where a.id = $id and a.deleted = 'no'");
	}
	
	function getRecentPayments(){
		
		return $this->db->query("select a.*,b.firstname,b.lastname from payments a 
		left join students b on b.id = a.student_id 
		left join enrolled c on c.id = a.enroll_id  
		where c.schoolyear = ".$this->session->userdata('current_schoolyearid')." and a.deleted = 'no' order by a.id desc limit 10");
		
	}
	
	function deposit_file( $data, $payment_id )
	{
		$this->db->where("id",$payment_id);	
		return $this->db->update('payments',$data);
	}
	
	function ableforpt()
	{
		$data_ = array( 
			'ableforpt' => $this->uri->segment(4)
		);
		$this->db->where("id",$this->uri->segment(3));
		$this->db->limit(1);
		return $this->db->update('enrolled',$data_);
	}

	function update_assessment_balance($payment_id, $action = 'subtract', $enroll_id = null) {
		$payment_details = $this->db->query("SELECT * FROM payment_details WHERE payment_id = ?", array($payment_id));
		
		if (!$enroll_id) {
			$payment = $this->db->query("SELECT * FROM payments WHERE id = ?", array($payment_id))->row();
			if (!$payment) return;
			$enroll_id = $payment->enroll_id;
		}

		$assessment = $this->db->query("SELECT * FROM assessment WHERE enroll_id = ?", array($enroll_id))->row();
		if (!$assessment) return;

		$incidentals = explode(",", $assessment->incidentals);
		$miscellaneous = explode(",", $assessment->miscellaneous);
		$tuition = $assessment->tuition;
		$registration = $assessment->registration;
		$payment_enroll = $assessment->payment;

		foreach($payment_details->result() as $pd) {
			$amount = $pd->price_item * $pd->qty_item;
			if ($action == 'add') {
				$amount = $amount;
			} else {
				$amount = -$amount;
			}

			if ($pd->type_item == 'indntals') {
				if (isset($incidentals[$pd->id_item])) $incidentals[$pd->id_item] += $amount;
			} else if ($pd->type_item == 'msclns') {
				if (isset($miscellaneous[$pd->id_item])) $miscellaneous[$pd->id_item] += $amount;
			} else if ($pd->type_item == 'tui_') {
				$tuition += $amount;
			} else if ($pd->type_item == 'reg_') {
				$registration += $amount;
			} else if ($pd->type_item == 'pay_') {
				$payment_enroll += $amount;
			}
		}

		$data = array(
			'incidentals' => implode(",", $incidentals),
			'miscellaneous' => implode(",", $miscellaneous),
			'tuition' => $tuition,
			'registration' => $registration,
			'payment' => $payment_enroll
		);

		$this->db->where('id', $assessment->id);
		$this->db->update('assessment', $data);
	}
	
	function getPaidItems($enroll_id){
		return $this->db->query("SELECT pd.type_item, pd.id_item, SUM(pd.price_item * pd.qty_item) as total_paid
			FROM payment_details pd
			JOIN payments p ON p.id = pd.payment_id
			WHERE p.enroll_id = ? AND p.deleted = 'no'
			GROUP BY pd.type_item, pd.id_item", array($enroll_id));
	}

}

?>
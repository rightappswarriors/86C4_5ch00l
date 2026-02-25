<?php
class Students_model extends CI_Model
{
	function enrollnew($data)
	{
		$this->db->insert('students', $data);
		$studentid = $this->db->insert_id();
		
		//also add to enrolled TABLE with Pending Status.
		$data_enroll = array(
			'studentid' => $studentid,
			'gradelevel' => $this->input->post('gradelevel'),
			'schoolyear' => $this->session->userdata('current_schoolyearid'),
			'status' => 'Pending',
			'deleted' => 'no',
			'newold' => $this->input->post('newold'),
			'addeddate' => date("Y-m-d H:i:s")
		);
		$this->db->insert('enrolled',$data_enroll);
		
		return $studentid;
	}
	
	function assessment_submit($data)
	{
		return $this->db->insert('assessment', $data);
	}
	
	function assessment_update($as_id,$data)
	{
		$this->db->where("id",$as_id);
		$this->db->limit(1);
		return $this->db->update('assessment', $data);
	}
	
	function enrollold($data)
	{
		$studentid = $this->uri->segment(3);
		$this->db->where('id', $studentid);
		$this->db->update('students', $data);
		
		//also add to enrolled TABLE with Pending Status.
		$data_enroll = array(
			'studentid' => $studentid,
			'gradelevel' => $this->input->post('gradelevel'),
			'schoolyear' => $this->session->userdata('current_schoolyearid'),
			'status' => 'Pending',
			'newold' => 'old',
			'addeddate' => date("Y-m-d H:i:s")
		);
		$this->db->insert('enrolled',$data_enroll);
		
		return $studentid;
	}
	
	function updateinfo($data)
	{
		$studentid = $this->uri->segment(3);
		$this->db->where('id', $studentid);
		$this->db->limit(1);
		$this->db->update('students', $data);	
		
		// enrolled for NEW/OLD field...
		$data_ = array( 
			'newold' => $this->input->post('newold'), 
			'gradelevel' => $this->input->post('gradelevel'),
			'strand' => $this->input->post('strand')
		);
		$studentid = $this->uri->segment(3);
		$this->db->where('studentid', $studentid);
		$this->db->limit(1);
		$this->db->update('enrolled', $data_);
		
		return $studentid;
	}
	
	function changestatus($status,$studentid)
	{
		$data = array( 'status' => $status );
		$data[strtolower($status)."_date"] = date("Y-m-d H:i:s");
		$this->db->where('studentid', $studentid);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}
	
	function changelevel($level,$studentid)
	{
		$data = array( 'gradelevel' => $level );
		$this->db->where('studentid', $studentid);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}
	
	function students_newold($newold)
	{
		$thisnewold = " and b.newold = '$newold'";
		$query = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
		c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
		join enrolled b on b.studentid = a.id 
		left join register c on c.id = a.user_id 
		where b.deleted = 'no'$thisnewold and b.schoolyear = ".$this->session->userdata('current_schoolyearid')." order by b.id asc ";
		return $this->db->query( $query );	
	}
	
	function students_list()
	{

		// $query = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus from students a 
		// join enrolled b on b.studentid = a.id where a.user_id = '".$this->session->userdata('current_userid')."' 
		// and b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid')." order by b.id asc";

		// $withstatus = "";
		// if($this->session->userdata('current_usertype') != 'Parent'){
			// if($this->uri->segment(3)){
				// $statsearch = $this->uri->segment(3);
				// if($statsearch!="All"){
					// $withstatus = " and b.status = '".$statsearch."'";
				// }else{
					// $withstatus = "";
				// }
			// }else{
				
				// if($this->session->userdata('current_usertype') == 'Admin'){
					// $withstatus = " and b.status = 'Interview'";
				// }
				// if($this->session->userdata('current_usertype') == 'Registrar'){
					// $withstatus = " and b.status = 'Pending'";
				// }	
				
			// }
			// $query = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
			// c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			// join enrolled b on b.studentid = a.id 
			// left join register c on c.id = a.user_id 
			// where b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid').$withstatus." order by b.id asc ";
		// }
		
		$withstatus = "";
		if($this->uri->segment(3)){
			$statsearch = $this->uri->segment(3);
			if($statsearch!="All"){
				$withstatus = " and b.status = '".$statsearch."'";
			}
		}
		
		$query = "select a.*, b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a join enrolled b on b.studentid = a.id left join register c on c.id = a.user_id where b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid').$withstatus." order by b.id asc ";
		return $this->db->query( $query );	
	}
	
	function bygradelevel()
	{
		
		$withlevel = " and b.gradelevel = '".$this->uri->segment(3)."'";
		$query = "select a.*,b.gradelevel,b.newold,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid').$withlevel. " order by b.id asc ";
		
		return $query = $this->db->query( $query );	
	}
	
	function students_list_dashboard()
	{
		// REGISTRAR
		//if($this->session->userdata('current_usertype') == 'Registrar' || $this->session->userdata('current_usertype') == 'Admin'){
			$query = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid'). " order by b.id desc limit 10";
		//}
		
		return $query = $this->db->query( $query );	
	}
	
	function search_student_info($id)
	{
		$query = "select a.*,c.oldaccount,b.status as enrollstatus, b.strand,b.gradelevel,b.newold,b.admininterview from students a left join enrolled b on b.studentid = a.id left join assessment c on c.enroll_id = b.id where a.id = $id and b.deleted = 'no'";	
		return $this->db->query($query);
	}
	
	function count_newold_students(){
		return $this->db->query("select count(*) as num_newold, newold from enrolled where deleted = 'no' and schoolyear = ".$this->session->userdata('current_schoolyearid')." group by newold");
	}
	
	function enroll_info( $id ){
		$query = $this->db->query("select id from enrolled where deleted = 'no' and studentid = ".$id." and schoolyear = ".$this->session->userdata('current_schoolyearid'));
		return $query->row()->id;
	}
	
	function assessment_check( $enroll_id ){
		$query = $this->db->query("select * from assessment where enroll_id = ".$enroll_id);
		return $query;
	}
	
	function getRecentActive(){
		$str_qry = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid'). " and b.status = 'Active' 
			order by b.active_date desc limit 10";
		$query = $this->db->query( $str_qry );
		return $query;
	}
	
	function count_gradelevel_students(){
		return $this->db->query("select count(*) as num_gradelevel, gradelevel from enrolled where deleted = 'no' and schoolyear = ".$this->session->userdata('current_schoolyearid')." group by gradelevel");
	}
	
	function remove_enroll($id=null){
		$data = array( 'deleted' => "yes" );
		$this->db->where('studentid', $id);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}
	
	function update_interview($interviews,$studentid)
	{
		$data = array( 'admininterview' => $interviews );
		$this->db->where('studentid', $studentid);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}

}

?>
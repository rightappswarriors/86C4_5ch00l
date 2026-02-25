<?php
class Register_model extends CI_Model
{
	function insert($data)
	{
		$this->db->insert('register', $data);
		return $this->db->insert_id();
	}
	
	function interview_schedule($data){
		
		//check if already taken
		$itime = $data['interviewtime'];
		$idate = $data['interviewdate'];
		$sy = $data['schoolyear'];
		$qry = "select * from interviewsched where schoolyear = '$sy' 
		and interviewtime = '$itime' and interviewdate = '$idate' and status = 1";
		$query = $this->db->query( $qry );
		
		if( $query->num_rows()>1 ){
			
			return 0;
			
		}else{
			
			$this->db->insert('interviewsched', $data);
			return 1;
			
		}
		
	}
    
    function interview_schedule_update($data,$studentid,$schoolyear){
		
		//check if already taken
		$itime = $data['interviewtime'];
		$idate = $data['interviewdate'];
		$qry = "select * from interviewsched where schoolyear = '$schoolyear' 
		and interviewtime = '$itime' and interviewdate = '$idate' and status = 1";
		$query = $this->db->query( $qry );
		
		if( $query->num_rows()>1 ){
			
			return 0;
			
		}else{
			
            $this->db->where("studentid",$studentid);
            $this->db->where("schoolyear",$schoolyear);
            $this->db->limit(1);
			$this->db->update('interviewsched', $data);
			return 1;
			
		}
		
	}
	
	function get_interview_schedule($studentid,$schoolyear){
		
		$qry = "select * from interviewsched where schoolyear = '$schoolyear' 
		and studentid = '$studentid' and status = 1 limit 1";
		$query = $this->db->query( $qry );
		if( $query->num_rows()>0 ){
			
			$row=$query->row();
            
            if($this->session->userdata('current_usertype') == 'Registrar' or $this->session->userdata('current_usertype') == 'Admin'):
            
            return date("Y-m-d@H:00:00",strtotime($row->interviewdate." ".$row->interviewtime));
            
            else:
            
			return date("F d,Y l @h:i A",strtotime($row->interviewdate." ".$row->interviewtime));
			
            endif;
            
		}else{
			
			return 0;
			
		}
		
	}
	
	function get_schedulesfor_interview(){
		
		$query = "select a.*,b.* from students a 
		join interviewsched b on b.studentid = a.id 
		left join register c on c.id = a.user_id 
		where b.status = 1 and b.schoolyear = " . $this->session->userdata('current_schoolyearid') . " order by b.id asc ";
		return $this->db->query($query);
		
	}

}

?>
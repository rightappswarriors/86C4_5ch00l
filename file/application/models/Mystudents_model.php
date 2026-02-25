<?php
class Mystudents_model extends CI_Model
{
	
	function mystudents()
	{	
	
		// get teachers own students grade level
		$qry = $this->db->query("select gradelevel,gradelevel1 from register where id = ".$this->session->userdata('current_userid'));
		$row = $qry->row(); 
		
		$glevel = $row->gradelevel;
		$glevel1 = $row->gradelevel1;
		
		if($glevel1 != "N/A")
		{
			$filter_grade_level = "and (b.gradelevel = '".$glevel."' or b.gradelevel = '".$glevel1."')";
		}else{
			$filter_grade_level = "and b.gradelevel = '".$glevel."'";
		}
		
		$qry = "select a.*,b.id as enroll_id,b.ableforpt,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = ".$this->session->userdata('current_schoolyearid'). "  
			$filter_grade_level 
			order by a.lastname asc,a.firstname asc";
		return $this->db->query( $qry );	
	}
	
}

?>
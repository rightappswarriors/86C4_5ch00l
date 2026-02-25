<?php
class Login_model extends CI_Model
{
	function can_login($mobileno, $userpass)
	{
		$this->db->where('mobileno', $mobileno);
		$this->db->where('userpass', md5($userpass));
		$this->db->where('status',1);
		$query = $this->db->get('register');
		if($query->num_rows() > 0)
		{
			
			$row = $query->row();
			
			// SESSIONS STARTS...
			$this->session->set_userdata('logged_in', 1);
			$this->session->set_userdata('current_userid', $row->id);
			$this->session->set_userdata('current_firstname', $row->firstname);
			$this->session->set_userdata('current_mobileno', $row->mobileno);
			$this->session->set_userdata('current_usertype', $row->usertype); // Parent, Registrar, Admin... and etc.
			
			// GET CURRENT SCHOOL YEAR...
			$this->db->where('isactive',1);
			$this->db->where('status',1);
			$query1 = $this->db->get('schoolyear');
			if($query1->num_rows() > 0)
			{
				$row1 = $query1->row();	
				$this->session->set_userdata('current_schoolyearid', $row1->id);
				$this->session->set_userdata('current_schoolyear', $row1->schoolyear);
			}
			
			// UPDATE USER LAST Login
			$data1 = array( 'lastlogin'  => date("Y-m-d H:i:s") );
			$this->db->where('id',$row->id);
			$this->db->limit(1);
			$this->db->update('register',$data1);
			
			return $row->id;
			
		}
		else
		{
			return 0;
		}
	}

}

?>
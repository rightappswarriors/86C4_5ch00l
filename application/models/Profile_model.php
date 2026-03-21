<?php
class Profile_model extends CI_Model
{
	function getInfo()
	{
		$current_userid = $this->session->userdata('current_userid');
		$this->db->select('register.*');
		//$this->db->select("COALESCE(NULLIF(register.school_id, ''), register.school_id) AS school_id", FALSE);
		$this->db->from('register');
		$this->db->where('register.id', $current_userid);

		return $this->db->get();
	}
	
	function updateinfo($data)
	{
		$this->db->where('id', $this->session->userdata('current_userid'));
		return $this->db->update('register', $data);
	}

}

?>

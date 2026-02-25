<?php
class Profile_model extends CI_Model
{
	function getInfo()
	{
		$this->db->where('id', $this->session->userdata('current_userid'));
		return $this->db->get('register');
	}
	
	function updateinfo($data)
	{
		$this->db->where('id', $this->session->userdata('current_userid'));
		return $this->db->update('register', $data);
	}

}

?>
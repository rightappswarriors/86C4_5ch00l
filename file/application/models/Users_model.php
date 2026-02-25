<?php
class Users_model extends CI_Model
{
	function create($data)
	{
		$this->db->insert('register', $data);
		return $this->db->insert_id();
		
	}
	
	function getUsers(){
		
		return $this->db->query("select * from register where status = 1 order by lastname asc");
		
	}
	
	function getInfo($userid)
	{
		$this->db->where('id', $userid);
		return $this->db->get('register');
	}
	
	function updateinfo($data,$userid)
	{
		$this->db->where('id', $userid);
		return $this->db->update('register', $data);
	}
	
}

?>
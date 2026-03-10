<?php
class Profile_model extends CI_Model
{
	function getInfo()
	{
		$current_userid = $this->session->userdata('current_userid');

		$this->db->select('register.*');
		$this->db->select('students.lrn AS lrn');
		// [Team Note - 2026-03-10]
		// Prefer new school_id column; fallback to legacy studentno for compatibility.
		$this->db->select("COALESCE(NULLIF(students.school_id, ''), students.studentno) AS studentno", FALSE);
		$this->db->from('register');
		$this->db->join('students', 'students.user_id = register.id', 'left');
		$this->db->where('register.id', $current_userid);
		$this->db->order_by('students.id', 'DESC');
		$this->db->limit(1);

		return $this->db->get();
	}
	
	function updateinfo($data)
	{
		$this->db->where('id', $this->session->userdata('current_userid'));
		return $this->db->update('register', $data);
	}

}

?>

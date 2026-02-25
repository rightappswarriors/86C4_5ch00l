<?php
class Files_model extends CI_Model
{
	function insert($data)
	{
		$this->db->insert('filedocs', $data);
		return $this->db->insert_id();
	}
	
	function getStudentFiles( $student_id )
	{
		$this->db->where("student_id",$student_id);	
		return $this->db->get('filedocs');
	}
	
	function update_file( $data, $student_id )
	{
		$this->db->where("student_id",$student_id);	
		return $this->db->update('filedocs',$data);
	}

}

?>
<?php
class Students_model extends CI_Model
{

	function preenrollnew($data)
	{
		$this->db->insert('preenrollstudents', $data);
		return $this->db->insert_id();
	}

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
		$this->db->insert('enrolled', $data_enroll);

		return $studentid;
	}

	function assessment_submit($data)
	{
		return $this->db->insert('assessment', $data);
	}

	function assessment_update($as_id, $data)
	{
		$this->db->where("id", $as_id);
		$this->db->limit(1);
		return $this->db->update('assessment', $data);
	}

	function academics_update($data)
	{
		$this->db->where("enroll_id", $data['enroll_id']);
		$this->db->where("student_id", $data['student_id']);
		$this->db->limit(1);
		$this->db->update('academics', $data);

		//add new
		if ($this->db->affected_rows() > 0) {
			// UPDATE happens...
			return 1;
		} else {
			// ADD THEM...
			return $this->db->insert('academics', $data);
		}

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
		$this->db->insert('enrolled', $data_enroll);

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

	function changestatus($status, $studentid)
	{
		$data = array('status' => $status);
		$data[strtolower($status) . "_date"] = date("Y-m-d H:i:s");
		$this->db->where('studentid', $studentid);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}

	function changelevel($level, $studentid)
	{
		$data = array('gradelevel' => $level);
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
		where b.deleted = 'no'$thisnewold 
		and b.schoolyear = " . $this->session->userdata('current_schoolyearid') . " order by b.id asc ";
		return $this->db->query($query);
	}

	function students_list(){
        
        $parent_search = "";
		if ($this->session->userdata('current_usertype') == 'Parent') {
			$parent_search = " and a.user_id = '" . $this->session->userdata('current_userid') . "'";
		}

		$withstatus = "";
		if ($this->uri->segment(3)) {
			$statsearch = $this->uri->segment(3);
			if ($statsearch != "All") {
				$withstatus = " and b.status = '" . $statsearch . "'";
			}
		}
        
        $query = "select a.*,b.ableforpt,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno 
            from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no'".$parent_search." and b.schoolyear = ".$this->session->userdata('current_schoolyearid').$withstatus." order by b.id asc";
        
        return $this->db->query($query);
        
    }
    
	function students_list_oldMORE()
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

		$parent_search = "";
		if ($this->session->userdata('current_usertype') == 'Parent') {
			$parent_search = " and a.user_id = '" . $this->session->userdata('current_userid') . "'";
		}

		$withstatus = "";
		if ($this->uri->segment(3)) {
			$statsearch = $this->uri->segment(3);
			if ($statsearch != "All") {
				$withstatus = " and b.status = '" . $statsearch . "'";
			}
		}

		$query = "
		SELECT a.*, 
			b.id AS enroll_id, 
			b.ableforpt, 
			b.newold, 
			b.gradelevel, 
			b.status AS enrollstatus,
			b.scholar AS isScholar, 
			c.firstname AS user_firstname, 
			c.lastname AS user_lastname, 
			c.lastlogin AS user_lastlogin, 
			c.mobileno AS user_mobileno, 
			d.incidentals,
			d.miscellaneous,
			d.tuition,
			d.scholarship,
			d.preenrollment,
			d.fullpayment,
			d.registration,
			d.payment,
			d.prepaidpaces,
			d.balancepaces,
			d.asstotal,
			d.monthlydue,
			d.oldaccount,
			(
				SELECT SUM(p.payment_total)
				FROM payments p
				WHERE p.student_id = a.id AND p.enroll_id = b.id AND p.deleted = 'no' AND p.enrollpay = 'yes' AND p.paid = 'yes'
				GROUP BY p.student_id, p.enroll_id
			) AS downPayment,
			(
				SELECT SUM(p.payment_total)
				FROM payments p
				WHERE p.student_id = a.id AND p.enroll_id = b.id AND p.deleted = 'no' AND p.enrollpay = 'no' AND p.paid = 'yes'
				GROUP BY p.student_id, p.enroll_id
			) AS nonDownPayment
		FROM students a 
		JOIN enrolled b ON b.studentid = a.id 
		LEFT JOIN register c ON c.id = a.user_id 
		JOIN (
			SELECT enroll_id, MAX(lastupdate) AS latest_lastupdate
			FROM assessment
			GROUP BY enroll_id
		) latest_assessment ON latest_assessment.enroll_id = b.id
		JOIN assessment d ON d.enroll_id = b.id AND d.lastupdate = latest_assessment.latest_lastupdate
		WHERE b.deleted = 'no'".$parent_search." 
		AND b.schoolyear = ".$this->session->userdata('current_schoolyearid').$withstatus." 
		ORDER BY b.id ASC;";

        $query1 = $this->db->query($query);
        //echo $this->db->last_query();
		return $query1;
	}

	function bygradelevel()
	{

		$withlevel = " and b.gradelevel = '" . $this->uri->segment(3) . "'";
		$query = "select a.*,b.id as enroll_id,b.ableforpt,b.gradelevel,b.newold,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = " . $this->session->userdata('current_schoolyearid') . $withlevel . " order by b.id asc ";

		return $query = $this->db->query($query);
	}

	function preenrolllist()
	{

		$query = "select a.*,b.* from preenrollstudents a left join students b on a.studentid = b.id 
		where a.status = 1 and a.schoolyear = " . $this->session->userdata('current_schoolyearid') . " order by a.id desc";
		return $query = $this->db->query($query);
	}

	function students_list_dashboard()
	{
		// REGISTRAR
		//if($this->session->userdata('current_usertype') == 'Registrar' || $this->session->userdata('current_usertype') == 'Admin'){
		$query = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = " . $this->session->userdata('current_schoolyearid') . " order by b.id desc limit 10";
		//}

		return $query = $this->db->query($query);
	}

	function count_reenrollments()
	{
		return $this->db->query("select count(*) as num_reenrolls from preenrollstudents where status = '1' and schoolyear = " . $this->session->userdata('current_schoolyearid') . " group by schoolyear");
	}

	function students_count_status()
	{
		return $this->db->query("select count(*) as num_status, status from enrolled where deleted = 'no' and schoolyear = " . $this->session->userdata('current_schoolyearid') . " group by status");
	}

	function search_student_info($id)
	{
		$query = "select a.*,c.oldaccount,b.ableforpt,b.scholar,b.status as enrollstatus, b.strand,b.gradelevel,b.newold,b.admininterview from students a left join enrolled b on b.studentid = a.id left join assessment c on c.enroll_id = b.id where a.id = $id and b.deleted = 'no'";
		return $this->db->query($query);
	}

	function count_newold_students()
	{
		return $this->db->query("select count(*) as num_newold, newold from enrolled where deleted = 'no' and status != 'Inactive' and schoolyear = " . $this->session->userdata('current_schoolyearid') . " group by newold");
	}

	function enroll_info($id)
	{
		$query = $this->db->query("select id from enrolled where deleted = 'no' and studentid = " . $id . " and schoolyear = " . $this->session->userdata('current_schoolyearid'));
		return $query->row()->id;
	}

	function assessment_check($enroll_id)
	{
		$query = $this->db->query("select * from assessment where enroll_id = " . $enroll_id);
		return $query;
	}

	function profile_pic($studentid)
	{
		$profile_pic = dirname(base_url()) . "/assets/images/default-profile.jpg";
		$query = $this->db->query("select file8 from filedocs where student_id = " . $studentid . " limit 1");
		if ($query->num_rows() > 0) {

			$row = $query->row();
			if (strlen(trim($row->file8)) > 0) {
				$path_file = './file_upload/' . $studentid;
				$profile_pic = "../../../" . $path_file . "/" . $row->file8;
			}

		}
		return $profile_pic;
	}

	function getRecentActive()
	{
		$str_qry = "select a.*,b.newold,b.gradelevel,b.status as enrollstatus, c.firstname as user_firstname, 
			c.lastname as user_lastname, c.lastlogin as user_lastlogin, c.mobileno as user_mobileno from students a 
			join enrolled b on b.studentid = a.id 
			left join register c on c.id = a.user_id 
			where b.deleted = 'no' and b.schoolyear = " . $this->session->userdata('current_schoolyearid') . " and b.status = 'Active' 
			order by b.active_date desc limit 10";
		$query = $this->db->query($str_qry);
		return $query;
	}

	function count_gradelevel_students()
	{
		return $this->db->query("select count(*) as num_gradelevel, gradelevel from enrolled where deleted = 'no' and status != 'Inactive' and schoolyear = " . $this->session->userdata('current_schoolyearid') . " group by gradelevel");
	}

	function getStudentAcademics($enroll_id)
	{
		return $this->db->query("select a.*,b.firstname,b.lastname from academics a left join register b on b.id = a.user_id where a.enroll_id = " . $enroll_id);
	}

	function remove_enroll($id = null)
	{
		$data = array('deleted' => "yes");
		$this->db->where('studentid', $id);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}

	function update_interview($interviews, $studentid)
	{
		$data = array('admininterview' => $interviews);
		$this->db->where('studentid', $studentid);
		$this->db->limit(1);
		return $this->db->update('enrolled', $data);
	}

}

?>
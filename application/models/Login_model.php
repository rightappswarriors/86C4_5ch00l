<?php
class Login_model extends CI_Model
{
	// [Team Note - 2026-03-09]
	// Main login entry supports new identifier types while keeping old mobile-based signature compatible.
	function can_login($login_type, $login_identifier, $userpass = null)
	{
		// Backward compatibility for old signature: can_login($mobileno, $userpass)
		if ($userpass === null) {
			$userpass = $login_identifier;
			$login_identifier = $login_type;
			$login_type = 'mobile';
		}

		$user = $this->find_user_for_login($login_type, trim((string)$login_identifier), $userpass);
		if (!$user) {
			return 0;
		}

		$this->set_user_session($user);
		$this->set_schoolyear_session();
		$this->update_last_login($user->id);

		return $user->id;
	}

	function can_login_google($email)
	{
		$email = trim((string)$email);
		if ($email === '') {
			return 0;
		}

		$this->db->where('emailadd', $email);
		$this->db->where('status', 1);
		$this->db->limit(1);
		$query = $this->db->get('register');
		if ($query->num_rows() === 0) {
			return 0;
		}

		$user = $query->row();
		$this->set_user_session($user);
		$this->set_schoolyear_session();
		$this->update_last_login($user->id);

		return $user->id;
	}

	private function find_user_for_login($login_type, $login_identifier, $userpass)
	{
		$this->db->where('userpass', md5($userpass));
		$this->db->where('status', 1);

		if ($login_type === 'email') {
			$this->db->where('emailadd', $login_identifier);
		} elseif ($login_type === 'lrn' || $login_type === 'school_id') {
			$user_id = $this->resolve_user_id_from_student($login_type, $login_identifier);
			if (empty($user_id)) {
				return null;
			}
			$this->db->where('id', $user_id);
		} elseif ($login_type === 'mobile') {
			$this->db->where('mobileno', $login_identifier);
		} elseif ($login_type === 'username') {
			$this->db->where('mobileno', $login_identifier);
		} else {
			$this->db->where('mobileno', $login_identifier);
		}

		$query = $this->db->get('register');
		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return null;
	}

	private function resolve_user_id_from_student($login_type, $login_identifier)
	{
		// [Team Note - 2026-03-09]
		// LRN/School ID login resolves the related parent/user account via students.user_id.
		if ($login_type === 'lrn') {
			$this->db->where('lrn', $login_identifier);
		} else {
			$this->apply_school_id_filter($login_identifier);
		}

		$this->db->limit(1);
		$query = $this->db->get('students');
		if ($query->num_rows() === 0) {
			return null;
		}

		$student = $query->row();
		if (empty($student->user_id)) {
			return null;
		}

		return $student->user_id;
	}

	private function apply_school_id_filter($identifier)
	{
		// [Team Note - 2026-03-10]
		// Prefer new school_id column, keep fallback to legacy studentno values.
		$this->db->group_start();
		$this->db->where('school_id', $identifier);
		$this->db->or_where('studentno', $identifier);
		$this->db->group_end();
	}

	private function set_user_session($user)
	{
		$rawUsertype = (string) $user->usertype;
		$effectiveUsertype = $rawUsertype === 'Super Admin' ? 'Admin' : $rawUsertype;

		$this->session->set_userdata('logged_in', 1);
		$this->session->set_userdata('current_userid', $user->id);
		$this->session->set_userdata('current_firstname', $user->firstname);
		$this->session->set_userdata('current_mobileno', $user->mobileno);
		$this->session->set_userdata('current_usertype', $effectiveUsertype);
		$this->session->set_userdata('current_usertype_display', $rawUsertype);
	}

	private function set_schoolyear_session()
	{
		$this->db->where('status', 1);
		$query = $this->db->get('schoolyear');
		if ($query->num_rows() === 0) {
			return;
		}

		$other_schoolyears = array();
		foreach ($query->result() as $row) {
			if ($row->isactive == 1) {
				$this->session->set_userdata('current_schoolyearid', $row->id);
				$this->session->set_userdata('current_schoolyear', $row->schoolyear);
			}
			$other_schoolyears[$row->id] = $row->schoolyear;
		}
		$this->session->set_userdata('other_schoolyears', $other_schoolyears);
	}

	private function update_last_login($user_id)
	{
		$data = array('lastlogin' => date("Y-m-d H:i:s"));
		$this->db->where('id', $user_id);
		$this->db->limit(1);
		$this->db->update('register', $data);
	}

}

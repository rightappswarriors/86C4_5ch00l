<?php
class Register_model extends CI_Model
{
	/**
	 * [Team Note - 2026-04-20]
	 * Get pre-enrollment applicants for interview scheduling
	 * @param int $schoolyear - School year
	 * @return array - List of pre-enrollment applicants
	 */
	function get_preenroll_applicants($schoolyear = null)
	{
		if ($schoolyear === null) {
			$schoolyear = $this->session->userdata('current_schoolyearid');
			if (!$schoolyear) {
				$schoolyear = date('Y');
			}
		}
		
		$query = $this->db->query("
			SELECT DISTINCT 
				s.id as studentid,
				s.firstname,
				s.middlename,
				s.lastname,
				p.gradelevel as grade,
				p.dateadded,
				p.status as pre_status
			FROM preenrollstudents p
			JOIN students s ON s.id = p.studentid
			WHERE p.schoolyear = ? AND p.status = 1
			ORDER BY p.dateadded DESC
		", array($schoolyear));
		
		return $query->result();
	}
	
	/**
	 * [Team Note - 2026-04-20]
	 * Schedule interview for pre-enrollment applicant
	 * @param int $studentid - Student ID
	 * @param string $date - Interview date
	 * @param string $time - Interview time
	 * @param int $duration - Slot duration in minutes
	 * @param int $schoolyear - School year
	 * @return bool - Success or failure
	 */
	function schedule_preenroll_interview($studentid, $date, $time, $duration = 30, $schoolyear = null)
	{
		if ($schoolyear === null) {
			$schoolyear = $this->session->userdata('current_schoolyearid');
			if (!$schoolyear) {
				$schoolyear = date('Y');
			}
		}
		
		// Check if student already has scheduled interview
		$this->db->where('studentid', $studentid);
		$this->db->where('schoolyear', $schoolyear);
		$this->db->where('status', 1);
		$existing = $this->db->get('interviewsched');
		
		if ($existing->num_rows() > 0) {
			// Update existing schedule
			$this->db->where('studentid', $studentid);
			$this->db->where('schoolyear', $schoolyear);
			$this->db->where('status', 1);
			$data = array(
				'interviewdate' => $date,
				'interviewtime' => $time,
				'slot_duration' => $duration,
				'submitted' => date('Y-m-d H:i:s')
			);
			return $this->db->update('interviewsched', $data);
		} else {
			// Insert new schedule
			$data = array(
				'studentid' => $studentid,
				'schoolyear' => $schoolyear,
				'interviewdate' => $date,
				'interviewtime' => $time,
				'slot_duration' => $duration,
				'status' => 1,
				'submitted' => date('Y-m-d H:i:s')
			);
			return $this->db->insert('interviewsched', $data);
		}
	}
	
	function insert($data)
	{
		$this->db->insert('register', $data);
		return $this->db->insert_id();
	}

	/**
	 * Check if a student is enrolled in the system using LRN or School ID
	 * @param string $lrn - Learner Reference Number
	 * @param string $school_id - School ID
	 * @return bool - true if student exists, false otherwise
	 */
	function is_student_enrolled($lrn, $school_id)
	{
		if (empty($lrn) && empty($school_id)) {
			return false;
		}

		// Query students table joined with enrolled table to check enrollment status
		$this->db->select('students.*');
		$this->db->from('students');
		$this->db->join('enrolled', 'enrolled.studentid = students.id');
		$this->db->where('enrolled.deleted', 'no');
		
		if (!empty($lrn)) {
			$this->db->where('students.lrn', $lrn);
		}
		
		if (!empty($school_id)) {
			$this->db->or_where('students.school_id', $school_id);
		}
		
		$query = $this->db->get();
		
		return ($query->num_rows() > 0);
	}

	/**
	 * Get student info by LRN or School ID
	 * @param string $lrn - Learner Reference Number
	 * @param string $school_id - School ID
	 * @return object|null - student record or null
	 */
	function get_student_by_identifier($lrn, $school_id)
	{
		if (empty($lrn) && empty($school_id)) {
			return null;
		}

		// Query students table joined with enrolled table to check enrollment status
		$this->db->select('students.*');
		$this->db->from('students');
		$this->db->join('enrolled', 'enrolled.studentid = students.id');
		$this->db->where('enrolled.deleted', 'no');
		
		if (!empty($lrn)) {
			$this->db->where('students.lrn', $lrn);
		}
		
		if (!empty($school_id)) {
			$this->db->or_where('students.school_id', $school_id);
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return null;
	}
	
	function interview_schedule($data){

		$itime = $data['interviewtime'];
		$idate = $data['interviewdate'];
		$sy = $data['schoolyear'];
		$slot_duration = isset($data['slot_duration']) ? (int)$data['slot_duration'] : 30; // default 30 minutes

		// New booking window
		$new_start = $idate . ' ' . $itime;
		$new_end_ts = strtotime($new_start) + ($slot_duration * 60);
		$new_end = date('Y-m-d H:i:s', $new_end_ts);

		// Check for conflicts: existing_start < new_end AND existing_end > new_start
		$sql = "SELECT COUNT(*) as count FROM interviewsched
				WHERE schoolyear = ?
				AND interviewdate = ?
				AND status = 1
				AND (
					STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s') < ?
					AND DATE_ADD(STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s'), INTERVAL slot_duration MINUTE) > ?
				)";

		$count_qry = $this->db->query($sql, array($sy, $idate, $new_end, $new_start));
		$conflicts = $count_qry->num_rows() > 0 ? (int)$count_qry->row()->count : 0;

		if($conflicts > 0) {
			return 0; // Time conflict detected
		} else {
			$data['slot_duration'] = $slot_duration;
			$this->db->insert('interviewsched', $data);
			return 1;
		}


	}
	
    
    function interview_schedule_update($data, $studentid, $schoolyear) {

		$itime = $data['interviewtime'];
		$idate = $data['interviewdate'];
		$slot_duration = isset($data['slot_duration']) ? (int)$data['slot_duration'] : 30;

		// Check time conflicts (excluding this student's existing booking)
		$start = $idate . ' ' . $itime;
		$end_ts = strtotime($start) + ($slot_duration * 60);
		$end = date('Y-m-d H:i:s', $end_ts);

		$sql = "SELECT COUNT(*) as count FROM interviewsched
				WHERE schoolyear = ?
				AND interviewdate = ?
				AND status = 1
				AND studentid != ?
				AND (
					STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s') < ?
					AND DATE_ADD(STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s'), INTERVAL slot_duration MINUTE) > ?
				)";

		$count_qry = $this->db->query($sql, array($schoolyear, $idate, $studentid, $end, $start));
		$conflicts = $count_qry->num_rows() > 0 ? (int)$count_qry->row()->count : 0;

		if($conflicts > 0) {
			return 0; // Time conflict detected
		}

		// Update
		$update_data = array(
			'interviewdate' => $idate,
			'interviewtime' => $itime,
			'slot_duration' => $slot_duration
		);

		$this->db->where('studentid', $studentid);
		$this->db->where('schoolyear', $schoolyear);
		$this->db->limit(1);
		$this->db->update('interviewsched', $update_data);

		return 1;

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

	/**
	 * Check if a specific time slot is available (no conflicts)
	 * @param string $date - Y-m-d
	 * @param string $time - H:i:s
	 * @param int $duration - duration in minutes
	 * @param int $exclude_studentid - optional student to exclude from check (for updates)
	 * @param int $schoolyear
	 * @return bool - true if available
	 */
	function is_slot_available($date, $time, $duration, $exclude_studentid = null, $schoolyear = null) {
		if($schoolyear === null) {
			$schoolyear = $this->session->userdata('current_schoolyearid');
		}

		$start = $date . ' ' . $time;
		$end_ts = strtotime($start) + ($duration * 60);
		$end = date('Y-m-d H:i:s', $end_ts);

		$sql = "SELECT COUNT(*) as count FROM interviewsched
				WHERE schoolyear = ?
				AND interviewdate = ?
				AND status = 1
				AND (
					STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s') < ?
					AND DATE_ADD(STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s'), INTERVAL slot_duration MINUTE) > ?
				)";

		$params = array($schoolyear, $date, $end, $start);
		if($exclude_studentid) {
			$sql .= " AND studentid != ?";
			$params[] = $exclude_studentid;
		}

		$qry = $this->db->query($sql, $params);
		$count = $qry->num_rows() > 0 ? (int)$qry->row()->count : 0;
		return ($count == 0);
	}

	/**
	 * Get slot duration for a student's existing booking
	 * @param int $studentid
	 * @param int $schoolyear
	 * @return int duration in minutes
	 */
	function get_slot_duration($studentid, $schoolyear) {
		$qry = $this->db->query("SELECT slot_duration FROM interviewsched WHERE studentid = ? AND schoolyear = ? AND status = 1 LIMIT 1", array($studentid, $schoolyear));
		if($qry->num_rows() > 0) {
			return (int)$qry->row()->slot_duration;
		}
		return 30; // default
	}

	/**
	 * Get all booked time ranges for a date (to display occupied blocks)
	 * @param string $date
	 * @param int $schoolyear
	 * @return array of objects with start_dt, end_dt, student name
	 */
	function get_booked_slots($date, $schoolyear = null) {
		if($schoolyear === null) {
			$schoolyear = $this->session->userdata('current_schoolyearid');
		}

		$query = $this->db->query("
			SELECT i.*, s.firstname, s.lastname,
			       STR_TO_DATE(CONCAT(i.interviewdate,' ',i.interviewtime), '%Y-%m-%d %H:%i:%s') as start_dt,
			       DATE_ADD(STR_TO_DATE(CONCAT(i.interviewdate,' ',i.interviewtime), '%Y-%m-%d %H:%i:%s'), INTERVAL i.slot_duration MINUTE) as end_dt
			FROM interviewsched i
			JOIN students s ON s.id = i.studentid
			WHERE i.schoolyear = ? AND i.interviewdate = ? AND i.status = 1
			ORDER BY i.interviewtime ASC
		", array($schoolyear, $date));

		return $query->result();
	}

	/**
	 * Get status of all standard time slots for a date
	 * @param string $date
	 * @param int $schoolyear
	 * @return array of slots with 'time', 'label', 'available' => bool
	 */
	function get_time_slots_status($date, $schoolyear = null) {
		if($schoolyear === null) {
			$schoolyear = $this->session->userdata('current_schoolyearid');
		}

		$standard_slots = array(
			'08:00:00' => '8:00 AM',
			'09:00:00' => '9:00 AM',
			'10:00:00' => '10:00 AM',
			'11:00:00' => '11:00 AM',
			'13:00:00' => '1:00 PM',
			'14:00:00' => '2:00 PM',
			'15:00:00' => '3:00 PM',
			'16:00:00' => '4:00 PM'
		);

		$booked = $this->get_booked_slots($date, $schoolyear);

		$result = array();
		foreach($standard_slots as $time_val => $label) {
			$slot_start = strtotime($date . ' ' . $time_val);
			$slot_end = $slot_start + (30 * 60); // assume 30 min default for check, but actual bookings have varying durations

			// For each slot, check if any booked interval overlaps.
			// We need to consider each booking's actual duration.
			$is_available = true;
			foreach($booked as $booking) {
				$book_start = strtotime($booking->start_dt);
				$book_end = strtotime($booking->end_dt);
				// Overlap if slot_start < book_end AND slot_end > book_start
				if(($slot_start < $book_end) && ($slot_end > $book_start)) {
					$is_available = false;
					break;
				}
			}

			$result[] = array(
				'time' => $time_val,
				'label' => $label,
				'available' => $is_available
			);
		}

		return $result;
	}

	function get_available_timeslots($date, $schoolyear = null) {
		if($schoolyear === null) {
			$schoolyear = $this->session->userdata('current_schoolyearid');
		}
		
		$standard_slots = array(
			'08:00:00' => '8:00 AM',
			'09:00:00' => '9:00 AM',
			'10:00:00' => '10:00 AM',
			'11:00:00' => '11:00 AM',
			'13:00:00' => '1:00 PM',
			'14:00:00' => '2:00 PM',
			'15:00:00' => '3:00 PM',
			'16:00:00' => '4:00 PM'
		);
		
		$booked = $this->get_booked_slots($date, $schoolyear);
		
		$result = array();
		foreach($standard_slots as $time_val => $label) {
			$slot_start = strtotime($date . ' ' . $time_val);
			$slot_end = $slot_start + (30 * 60);
			
			$is_booked = false;
			foreach($booked as $booking) {
				$book_start = strtotime($booking->start_dt);
				$book_end = strtotime($booking->end_dt);
				if(($slot_start < $book_end) && ($slot_end > $book_start)) {
					$is_booked = true;
					break;
				}
			}
			
			$result[] = array(
				'time' => $time_val,
				'label' => $label,
				'available' => !$is_booked,
				'capacity' => 1,
				'booked' => $is_booked ? 1 : 0,
				'is_full' => $is_booked
			);
		}
		
		return $result;
	}

}
?>
<?php
class Forgotpass_model extends CI_Model {
    
    /**
     * Check if email or mobile number exists
     */
    function check_user_exists($identifier) {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $this->db->where('emailadd', $identifier);
        } else {
            $this->db->where('mobileno', $identifier);
        }
        
        $this->db->where('status', 1);
        $query = $this->db->get('register');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    
    /**
     * Generate and store verification code
     */
    function generate_verification_code($user_id, $email, $mobile) {
        $code = sprintf("%06d", mt_rand(0, 999999));
        
        // Delete existing codes
        $this->db->where('user_id', $user_id);
        $this->db->delete('password_reset_codes');
        
        // Insert new code
        $data = array(
            'user_id' => $user_id,
            'email' => $email,
            'mobile' => $mobile,
            'code' => $code,
            'created_at' => date("Y-m-d H:i:s"),
            'expires_at' => date("Y-m-d H:i:s", strtotime("+30 minutes")),
            'status' => 1
        );
        
        $this->db->insert('password_reset_codes', $data);
        
        return $code;
    }
    
    /**
     * Verify the code
     */
    function verify_code($code, $identifier) {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $this->db->where('emailadd', $identifier);
        } else {
            $this->db->where('mobileno', $identifier);
        }
        $this->db->where('status', 1);
        $query = $this->db->get('register');
        
        if ($query->num_rows() == 0) {
            return false;
        }
        
        $user = $query->row();
        
        $this->db->where('user_id', $user->id);
        $this->db->where('code', $code);
        $this->db->where('status', 1);
        $this->db->where('expires_at >=', date("Y-m-d H:i:s"));
        $code_query = $this->db->get('password_reset_codes');
        
        if ($code_query->num_rows() > 0) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Update password
     */
    function update_password($user_id, $new_password) {
        $data = array(
            'userpass' => md5($new_password)
        );
        
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $result = $this->db->update('register', $data);
        
        if ($result) {
            $this->db->where('user_id', $user_id);
            $this->db->update('password_reset_codes', array('status' => 0));
        }
        
        return $result;
    }
    
    /**
     * Verify parent identity by name and phone number
     * Returns parent info and their linked children
     */
    function verify_parent_identity($firstname, $lastname, $middlename, $mobileno) {
        // Find parent account - middle name is optional
        $this->db->where('LOWER(firstname)', strtolower($firstname));
        $this->db->where('LOWER(lastname)', strtolower($lastname));
        $this->db->where('mobileno', $mobileno);
        $this->db->where('usertype', 'Parent');
        $this->db->where('status', 1);
        
        // If middle name provided, also match it
        if (!empty($middlename)) {
            $this->db->where('LOWER(middlename)', strtolower($middlename));
        }
        
        $query = $this->db->get('register');
        
        // If no match with middle name, try without it
        if ($query->num_rows() == 0 && !empty($middlename)) {
            $this->db->where('LOWER(firstname)', strtolower($firstname));
            $this->db->where('LOWER(lastname)', strtolower($lastname));
            $this->db->where('mobileno', $mobileno);
            $this->db->where('usertype', 'Parent');
            $this->db->where('status', 1);
            $query = $this->db->get('register');
        }
        
        if ($query->num_rows() == 0) {
            return array('status' => 'not_found', 'message' => 'Parent account not found with these details.');
        }
        
        $parent = $query->row();
        
        // Get children (students) linked to this parent
        $this->db->select('students.*, enrolled.gradelevel, enrolled.status as enrollstatus, enrolled.schoolyear');
        $this->db->from('students');
        $this->db->join('enrolled', 'enrolled.studentid = students.id');
        $this->db->where('students.user_id', $parent->id);
        $this->db->where('enrolled.deleted', 'no');
        $this->db->order_by('enrolled.id', 'desc');
        $students_query = $this->db->get();
        
        $children = $students_query->result();
        
        return array(
            'status' => 'success',
            'parent' => $parent,
            'children' => $children
        );
    }
    
    /**
     * Verify student identity by LRN or School ID
     * Returns student info and their parent account
     */
    function verify_student_identity($identifier) {
        // Try to find by LRN first
        $this->db->where('lrn', $identifier);
        $query = $this->db->get('students');
        
        if ($query->num_rows() == 0) {
            // Try by student number (school_id)
            $this->db->where('studentno', $identifier);
            $query = $this->db->get('students');
        }
        
        if ($query->num_rows() == 0) {
            return array('status' => 'not_found', 'message' => 'Student not found with this LRN or School ID.');
        }
        
        $student = $query->row();
        
        // Get parent account
        $parent = null;
        if ($student->user_id) {
            $this->db->where('id', $student->user_id);
            $this->db->where('status', 1);
            $parent_query = $this->db->get('register');
            if ($parent_query->num_rows() > 0) {
                $parent = $parent_query->row();
            }
        }
        
        // Get enrollment info
        $this->db->where('studentid', $student->id);
        $this->db->where('deleted', 'no');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $enroll_query = $this->db->get('enrolled');
        $enrollment = $enroll_query->row();
        
        return array(
            'status' => 'success',
            'student' => $student,
            'parent' => $parent,
            'enrollment' => $enrollment
        );
    }
}

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
     * Check if password_reset_codes table exists, create if not
     */
    private function ensure_password_reset_table() {
        $table_name = 'password_reset_codes';
        
        // Check if table exists
        if (!$this->db->table_exists($table_name)) {
            // Create the table
            $this->load->dbforge();
            
            $fields = array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
                'user_id' => array('type' => 'INT', 'constraint' => 11),
                'email' => array('type' => 'VARCHAR', 'constraint' => 255),
                'mobile' => array('type' => 'VARCHAR', 'constraint' => 20),
                'code' => array('type' => 'VARCHAR', 'constraint' => 10),
                'created_at' => array('type' => 'DATETIME'),
                'expires_at' => array('type' => 'DATETIME'),
                'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1, 'comment' => '1=active, 0=used/expired')
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('user_id');
            $this->dbforge->add_key('code');
            $this->dbforge->add_key('status');
            $this->dbforge->add_key('expires_at');
            $this->dbforge->create_table($table_name, TRUE);
        }
    }
    
    /**
     * Generate and store verification code
     */
    function generate_verification_code($user_id, $email, $mobile) {
        // Ensure table exists
        $this->ensure_password_reset_table();
        
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
     * Verify parent identity by name and child birthdate
     * Returns parent info and their linked children
     */
    function verify_parent_identity($firstname, $lastname, $middlename, $birthdate) {
        // [Team Note - 2026-03-09]
        // Parent lookup flow now uses child Birthdate instead of parent Phone Number.
        $parent = $this->find_parent_by_identity($firstname, $lastname, $middlename, $birthdate);
        if (!$parent) {
            return array('status' => 'not_found', 'message' => 'Parent account not found with these details.');
        }
        
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

    private function find_parent_by_identity($firstname, $lastname, $middlename, $birthdate)
    {
        // [Team Note - 2026-03-09]
        // Supports optional middle name: tries exact match first, then fallback without middle name.
        
        // First try: Find by student birthdate (existing logic)
        $query = $this->build_parent_identity_query($firstname, $lastname, $middlename, $birthdate)->get();
        if ($query->num_rows() == 0 && !empty($middlename)) {
            $query = $this->build_parent_identity_query($firstname, $lastname, '', $birthdate)->get();
        }
        if ($query->num_rows() == 0) {
            // Second try: Find by parent name and birthdate directly (for users without linked students)
            $this->db->reset_query();
            $this->db->where('LOWER(firstname)', strtolower($firstname));
            $this->db->where('LOWER(lastname)', strtolower($lastname));
            $this->db->where('birthdate', $birthdate);
            $this->db->where('usertype', 'Parent');
            $this->db->where('status', 1);
            if (!empty($middlename)) {
                $this->db->where('LOWER(middlename)', strtolower($middlename));
            }
            $query = $this->db->get('register');
            
            if ($query->num_rows() == 0 && !empty($middlename)) {
                $this->db->reset_query();
                $this->db->where('LOWER(firstname)', strtolower($firstname));
                $this->db->where('LOWER(lastname)', strtolower($lastname));
                $this->db->where('birthdate', $birthdate);
                $this->db->where('usertype', 'Parent');
                $this->db->where('status', 1);
                $query = $this->db->get('register');
            }
        }
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();
    }

    private function build_parent_identity_query($firstname, $lastname, $middlename, $birthdate)
    {
        // Use subquery approach to avoid MySQL error 1056 with JOIN and GROUP BY
        // First, get student user_ids that match the birthdate
        $this->db->reset_query();
        $this->db->select('user_id');
        $this->db->from('students');
        $this->db->where('birthdate', $birthdate);
        $student_subquery = $this->db->get_compiled_select();
        
        // Final query - get register entries that match name AND have a child with the given birthdate
        $this->db->reset_query();
        $this->db->select('register.*');
        $this->db->from('register');
        $this->db->where('LOWER(register.firstname)', strtolower($firstname));
        $this->db->where('LOWER(register.lastname)', strtolower($lastname));
        $this->db->where('register.usertype', 'Parent');
        $this->db->where('register.status', 1);
        if (!empty($middlename)) {
            $this->db->where('LOWER(register.middlename)', strtolower($middlename));
        }
        $this->db->where("register.id IN ($student_subquery)", NULL, FALSE);
        
        return $this->db;
    }
}

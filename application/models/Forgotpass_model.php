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
     * Verify parent identity by name
     * Returns parent info and their linked children
     */
    function verify_parent_identity($firstname, $lastname) {
        $parent = $this->find_parent_by_identity($firstname, $lastname);
        if (!$parent) {
            return array('status' => 'not_found', 'message' => 'Account not found with these details.');
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
        // [Team Note - 2026-03-13] First check in register table for students who registered online
        $this->db->where('lrn', $identifier);
        $this->db->or_where('school_id', $identifier);
        $this->db->where('usertype', 'Student');
        $this->db->where('status', 1);
        $register_query = $this->db->get('register');
        
        if ($register_query->num_rows() > 0) {
            // Found student in register table (online registration)
            $student_account = $register_query->row();
            return array(
                'status' => 'success',
                'student' => $student_account,
                'parent' => null,
                'enrollment' => null
            );
        }
        
        // Try to find by LRN in students table
        $this->db->where('lrn', $identifier);
        $query = $this->db->get('students');
        
        if ($query->num_rows() == 0) {
            $query = $this->find_student_by_school_id($identifier);
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

    private function find_student_by_school_id($identifier)
    {
        // [Team Note - 2026-03-10]
        // Prefer new school_id column, keep fallback to legacy studentno values.
        $this->db->group_start();
        $this->db->where('school_id', $identifier);
        $this->db->or_where('studentno', $identifier);
        $this->db->group_end();
        return $this->db->get('students');
    }

    private function find_parent_by_identity($firstname, $lastname)
    {
        $this->db->where('LOWER(firstname)', strtolower($firstname));
        $this->db->where('LOWER(lastname)', strtolower($lastname));
        $this->db->where('status', 1);
        $this->db->group_start();
        $this->db->where('usertype', 'Parent');
        $this->db->or_where('usertype', 'Student');
        $this->db->group_end();
        $query = $this->db->get('register');
        
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();
    }
}

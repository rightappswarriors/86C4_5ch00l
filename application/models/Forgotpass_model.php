<?php
class Forgotpass_model extends CI_Model {
    
    /**
     * Check if email or mobile number exists in the register table
     * @param string $identifier - can be email or mobile number
     * @return object|false - returns user row if found, false otherwise
     */
    function check_user_exists($identifier) {
        // Check if it's an email or mobile number
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            // It's an email
            $this->db->where('emailadd', $identifier);
        } else {
            // It's a mobile number
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
     * Generate a verification code and store it in the database
     * @param int $user_id - the user ID
     * @param string $email - user's email
     * @param string $mobile - user's mobile number
     * @return string - the generated verification code
     */
    function generate_verification_code($user_id, $email, $mobile) {
        // Generate a 6-digit verification code
        $code = sprintf("%06d", mt_rand(0, 999999));
        
        // Delete any existing verification codes for this user
        $this->db->where('user_id', $user_id);
        $this->db->delete('password_reset_codes');
        
        // Insert new verification code
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
     * Verify if the code is valid
     * @param string $code - the verification code
     * @param string $identifier - email or mobile number
     * @return object|false - returns user row if valid, false otherwise
     */
    function verify_code($code, $identifier) {
        // First, get the user
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
        
        // Now check the verification code
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
     * Update user password
     * @param int $user_id - the user ID
     * @param string $new_password - the new password (plain text, will be hashed)
     * @return boolean
     */
    function update_password($user_id, $new_password) {
        $data = array(
            'userpass' => md5($new_password)
        );
        
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $result = $this->db->update('register', $data);
        
        if ($result) {
            // Invalidate all verification codes for this user
            $this->db->where('user_id', $user_id);
            $this->db->update('password_reset_codes', array('status' => 0));
        }
        
        return $result;
    }
    
    /**
     * Mark code as used
     * @param int $user_id
     * @param string $code
     */
    function mark_code_used($user_id, $code) {
        $this->db->where('user_id', $user_id);
        $this->db->where('code', $code);
        $this->db->update('password_reset_codes', array('status' => 0));
    }
}

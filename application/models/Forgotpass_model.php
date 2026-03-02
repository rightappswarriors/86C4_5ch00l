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
}

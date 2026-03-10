<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('Forgotpass_model');
        
        if($this->session->userdata('logged_in')==1){
            redirect("dashboard");
        }
    }
    
    public function index()
    {
        $this->load->view('login');
    }
    
    public function forgotpass()
    {
        $this->load->view('forgotpass');
    }

    public function forgotpass_gate()
    {
        $this->load->view('forgotpass_gate');
    }

    public function forgotpass_gate_submit()
    {
        // [Team Note - 2026-03-09]
        // Forgot Password gate now validates parent identity using Birthdate instead of Phone Number.
        // Set form validation - middle name is optional
        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('middlename', 'Middle Name', 'trim');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required|trim');
        $this->form_validation->set_rules('lrn', 'LRN', 'trim');
        $this->form_validation->set_rules('school_id', 'School ID', 'trim');
        $this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');

        // Get form inputs
        $firstname = trim($this->input->post('firstname'));
        $lastname = trim($this->input->post('lastname'));
        $middlename = trim($this->input->post('middlename'));
        $birthdate = trim($this->input->post('birthdate'));
        $lrn = trim($this->input->post('lrn'));
        $school_id = trim($this->input->post('school_id'));
        
        // Check if form validation passes
        if (!$this->form_validation->run()) {
            $this->load->view('forgotpass_gate');
            return;
        }
        
        // Determine if this is a parent or student lookup
        // Parent: needs firstname, lastname, birthdate at minimum
        $is_parent_lookup = !empty($firstname) && !empty($lastname) && !empty($birthdate);
        // Student: needs LRN or School ID
        $is_student_lookup = !empty($lrn) || !empty($school_id);
        
        try {
            if ($is_parent_lookup) {
                // Verify parent identity and get their children
                $result = $this->Forgotpass_model->verify_parent_identity(
                    $firstname, 
                    $lastname, 
                    $middlename,
                    $birthdate
                );
                
                if ($result['status'] === 'not_found') {
                    $this->session->set_flashdata('message', $result['message']);
                    $this->load->view('forgotpass_gate');
                    return;
                }
                
                // Store data in session for the selection step
                $this->session->set_userdata('forgotpass_parent_data', $result['parent']);
                $this->session->set_userdata('forgotpass_children', $result['children']);
                $this->session->set_userdata('forgotpass_type', 'parent');
                
                // Show results page
                $data['parent'] = $result['parent'];
                $data['children'] = $result['children'];
                $data['lookup_type'] = 'parent';
                $this->load->view('forgotpass_select', $data);
                return;
            } 
            elseif ($is_student_lookup) {
                // Verify student by LRN or School ID and get parent
                $identifier = !empty($lrn) ? $lrn : $school_id;
                $result = $this->Forgotpass_model->verify_student_identity($identifier);
                
                if ($result['status'] === 'not_found') {
                    $this->session->set_flashdata('message', $result['message']);
                    $this->load->view('forgotpass_gate');
                    return;
                }
                
                // Store data in session
                $this->session->set_userdata('forgotpass_student_data', $result['student']);
                $this->session->set_userdata('forgotpass_parent', $result['parent']);
                $this->session->set_userdata('forgotpass_type', 'student');
                
                // Show results page
                $data['student'] = $result['student'];
                $data['parent'] = $result['parent'];
                $data['enrollment'] = $result['enrollment'];
                $data['lookup_type'] = 'student';
                $this->load->view('forgotpass_select', $data);
                return;
            } 
            else {
                // Neither properly filled
                $this->session->set_flashdata('message', 'Please provide either parent details (First Name, Last Name, Birthdate) OR student LRN/School ID.');
                $this->load->view('forgotpass_gate');
                return;
            }
        } catch (Exception $e) {
            log_message('error', 'Forgotpass error: ' . $e->getMessage());
            $this->session->set_flashdata('message', 'An error occurred. Please try again or contact the school administrator.');
            $this->load->view('forgotpass_gate');
            return;
        }
    }
    
    /**
     * Process the selected account for password reset
     */
    public function forgotpass_select_account()
    {
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');
        
        if (empty($user_id)) {
            $this->session->set_flashdata('message', 'Please select an account to reset password.');
            redirect('login/forgotpass_gate');
            return;
        }
        
        $user = null;
        
        // Check if it's a student account (prefixed with 'student_')
        if (strpos($user_id, 'student_') === 0) {
            $student_id = str_replace('student_', '', $user_id);
            
            // Get student info and check if they have a portal account
            $this->db->where('id', $student_id);
            $student_query = $this->db->get('students');
            
            if ($student_query->num_rows() == 0) {
                $this->session->set_flashdata('message', 'Student not found.');
                redirect('login/forgotpass_gate');
                return;
            }
            
            $student = $student_query->row();
            
            // Check if student has a user_id (portal account)
            if (empty($student->user_id)) {
                $this->session->set_flashdata('message', 'This student does not have a portal account. Please contact the school.');
                redirect('login/forgotpass_gate');
                return;
            }
            
            // Get the parent account linked to student
            $this->db->where('id', $student->user_id);
            $this->db->where('status', 1);
            $query = $this->db->get('register');
            
            if ($query->num_rows() == 0) {
                $this->session->set_flashdata('message', 'Parent account not found.');
                redirect('login/forgotpass_gate');
                return;
            }
            
            $user = $query->row();
        } else {
            // It's a regular parent account
            $this->db->where('id', $user_id);
            $this->db->where('status', 1);
            $query = $this->db->get('register');
            
            if ($query->num_rows() == 0) {
                $this->session->set_flashdata('message', 'User not found.');
                redirect('login/forgotpass_gate');
                return;
            }
            
            $user = $query->row();
        }
        
        // Generate verification code
        $code = $this->Forgotpass_model->generate_verification_code(
            $user->id, 
            $user->emailadd, 
            $user->mobileno
        );
        
        // Try to send email
        try {
            $this->load->library('phpmailer');
            @$this->phpmailer->send_verification_code($user->emailadd, $code, $user->firstname . ' ' . $user->lastname);
        } catch (Exception $e) {}
        
        // Try to send SMS
        try {
            $this->load->library('sms');
            @$this->sms->send_verification_code($user->mobileno, $code);
        } catch (Exception $e) {}
        
        // Store session data for password reset
        $this->session->set_userdata('reset_user_id', $user->id);
        $this->session->set_userdata('reset_identifier', $user->emailadd ?: $user->mobileno);
        $this->session->set_userdata('reset_email', $user->emailadd);
        $this->session->set_userdata('reset_mobile', $user->mobileno);
        
        // Redirect to verify code page
        redirect('login/verify_code');
    }
    
    /**
     * Check if user exists and send verification code (AJAX)
     */
    public function check_and_send_code()
    {
        $identifier = $this->input->post('identifier');
        
        if (empty($identifier)) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter your email or mobile number.'));
            return;
        }
        
        // Check if user exists
        $user = $this->Forgotpass_model->check_user_exists($identifier);
        
        if (!$user) {
            echo json_encode(array(
                'status' => 'not_registered',
                'message' => 'Account not found. Redirecting to registration...',
                'redirect' => site_url('register')
            ));
            return;
        }
        
        // Generate verification code
        $code = $this->Forgotpass_model->generate_verification_code(
            $user->id, 
            $user->emailadd, 
            $user->mobileno
        );
        
        // Try to send email
        try {
            $this->load->library('phpmailer');
            @$this->phpmailer->send_verification_code($user->emailadd, $code, $user->firstname . ' ' . $user->lastname);
        } catch (Exception $e) {}
        
        // Try to send SMS
        try {
            $this->load->library('sms');
            @$this->sms->send_verification_code($user->mobileno, $code);
        } catch (Exception $e) {}
        
        // Store session data
        $this->session->set_userdata('reset_user_id', $user->id);
        $this->session->set_userdata('reset_identifier', $identifier);
        $this->session->set_userdata('reset_email', $user->emailadd);
        $this->session->set_userdata('reset_mobile', $user->mobileno);
        
        $masked_email = $this->mask_email($user->emailadd);
        $masked_mobile = $this->mask_mobile($user->mobileno);
        
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Code: ' . $code . ' (Email/SMS may not be configured)',
            'email' => $masked_email,
            'mobile' => $masked_mobile,
            'redirect' => site_url('login/verify_code'),
            'debug_code' => $code
        ));
    }
    
    /**
     * Display verification code page
     */
    public function verify_code()
    {
        if (!$this->session->userdata('reset_user_id')) {
            redirect('login/forgotpass_gate');
            return;
        }
        
        $data['email'] = $this->session->userdata('reset_email');
        $data['mobile'] = $this->session->userdata('reset_mobile');
        $data['masked_email'] = $this->mask_email($data['email']);
        $data['masked_mobile'] = $this->mask_mobile($data['mobile']);
        
        $this->load->view('verify_code', $data);
    }
    
    /**
     * Verify the code submitted by user
     */
    public function verify_code_submit()
    {
        $code = $this->input->post('code');
        $identifier = $this->session->userdata('reset_identifier');
        
        if (empty($code)) {
            $this->session->set_flashdata('message', 'Please enter the verification code.');
            redirect('login/verify_code');
            return;
        }
        
        $user = $this->Forgotpass_model->verify_code($code, $identifier);
        
        if ($user) {
            $this->session->set_userdata('verified_user_id', $user->id);
            $this->session->set_userdata('verified_code', $code);
            redirect('login/reset_password');
        } else {
            $this->session->set_flashdata('message', 'Invalid or expired verification code.');
            redirect('login/verify_code');
        }
    }
    
    /**
     * Display reset password form
     */
    public function reset_password()
    {
        if (!$this->session->userdata('verified_user_id')) {
            redirect('login/forgotpass_gate');
            return;
        }
        
        $this->load->view('reset_password');
    }
    
    /**
     * Update the password
     */
    public function update_password()
    {
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');
        
        $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('reset_password');
            return;
        }
        
        $user_id = $this->session->userdata('verified_user_id');
        $result = $this->Forgotpass_model->update_password($user_id, $new_password);
        
        if ($result) {
            $session_data = array('reset_user_id', 'reset_identifier', 'reset_email', 'reset_mobile', 'verified_user_id', 'verified_code');
            $this->session->unset_userdata($session_data);
            
            $this->session->set_flashdata('success', 'Password reset successful! Please login with your new password.');
            redirect('login');
        } else {
            $this->session->set_flashdata('message', 'Failed to update password. Please try again.');
            redirect('login/reset_password');
        }
    }
    
    /**
     * Resend verification code
     */
    public function resend_code()
    {
        $identifier = $this->session->userdata('reset_identifier');
        
        if (!$identifier) {
            echo json_encode(array('status' => 'error', 'message' => 'Session expired.'));
            return;
        }
        
        $user = $this->Forgotpass_model->check_user_exists($identifier);
        
        if (!$user) {
            echo json_encode(array('status' => 'error', 'message' => 'User not found.'));
            return;
        }
        
        $code = $this->Forgotpass_model->generate_verification_code($user->id, $user->emailadd, $user->mobileno);
        
        echo json_encode(array('status' => 'success', 'message' => 'New code: ' . $code, 'debug_code' => $code));
    }
    
    /**
     * Cancel password reset
     */
    public function cancel_reset()
    {
        $session_data = array('reset_user_id', 'reset_identifier', 'reset_email', 'reset_mobile', 'verified_user_id', 'verified_code');
        $this->session->unset_userdata($session_data);
        redirect('login');
    }
    
    private function mask_email($email)
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];
        if (strlen($name) <= 2) {
            $masked = $name[0] . '***';
        } else {
            $masked = $name[0] . str_repeat('*', strlen($name) - 2) . $name[strlen($name) - 1];
        }
        return $masked . '@' . $domain;
    }
    
    private function mask_mobile($mobile)
    {
        $length = strlen($mobile);
        if ($length <= 4) return $mobile;
        return substr($mobile, 0, 2) . str_repeat('*', $length - 4) . substr($mobile, -2);
    }
    
    function validation()
    {
        // [Team Note - 2026-03-09]
        // Login now supports multiple identifiers: LRN, School ID, Email Address, or Phone Number.
        $this->form_validation->set_rules('login_type', 'Login Type', 'required|in_list[lrn,school_id,email,mobile]');
        $this->form_validation->set_rules('login_identifier', 'Login Identifier', 'required|trim');
        $this->form_validation->set_rules('userpass', 'Password', 'required');
        if($this->form_validation->run())
        {
            $login_type = $this->input->post('login_type', TRUE);
            $login_identifier = trim($this->input->post('login_identifier', TRUE));
            $result = $this->login_model->can_login($login_type, $login_identifier, $this->input->post('userpass'));
            if($result)
            {
                redirect("dashboard");
            }
            else
            {
                $message = "Wrong login details or password!";
                $this->session->set_flashdata('message',$message);    
                $this->index();
            }
        }
        else
        {
            $message = "Wrong login details or password!";
            $this->session->set_flashdata('message',$message);    
            $this->index();
        }
    }
}

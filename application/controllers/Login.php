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
            redirect('login/forgotpass');
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
            redirect('login/forgotpass');
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
        $this->form_validation->set_rules('mobileno', 'Mobile Number', 'required|trim');
        $this->form_validation->set_rules('userpass', 'Password', 'required');
        if($this->form_validation->run())
        {
            $result = $this->login_model->can_login($this->input->post('mobileno'), $this->input->post('userpass'));
            if($result)
            {
                redirect("dashboard");
            }
            else
            {
                $message = "Wrong Number or Password!";
                $this->session->set_flashdata('message',$message);    
                $this->index();
            }
        }
        else
        {
            $message = "Wrong Number or Password!";
            $this->session->set_flashdata('message',$message);    
            $this->index();
        }
    }
}

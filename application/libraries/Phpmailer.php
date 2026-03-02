<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phpmailer {
    
    private $email;
    private $config;
    
    public function __construct() {
        $CI =& get_instance();
        $CI->config->load('email_sms_config', true);
        
        $this->config = array(
            'protocol' => $CI->config->item('email.protocol', 'email_sms_config'),
            'smtp_host' => $CI->config->item('email.smtp_host', 'email_sms_config'),
            'smtp_port' => $CI->config->item('email.smtp_port', 'email_sms_config'),
            'smtp_user' => $CI->config->item('email.smtp_user', 'email_sms_config'),
            'smtp_pass' => $CI->config->item('email.smtp_pass', 'email_sms_config'),
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => true
        );
        
        $CI->load->library('email', $this->config);
        $this->email =& $CI->email;
    }
    
    public function send_verification_code($to, $code, $name = 'User') {
        $subject = 'Password Reset Verification Code - BHCA Portal';
        
        $message = '
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"><title>Password Reset</title></head>
        <body style="font-family: Arial; padding: 20px;">
            <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px;">
                <h2>BHCA Portal - Password Reset</h2>
                <p>Hello <strong>'.htmlspecialchars($name).'</strong>,</p>
                <p>Your verification code is:</p>
                <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 32px; font-weight: bold; letter-spacing: 5px;">'.$code.'</div>
                <p>This code will expire in 30 minutes.</p>
            </div>
        </body>
        </html>';
        
        if (!empty($this->config['smtp_user']) && strpos($this->config['smtp_user'], 'your-') === false) {
            $this->email->clear();
            $this->email->from($this->config['smtp_user'], 'BHCA Portal');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            if(!@$this->email->send()) {
                return false;
            }
            return true;
        }
        return false;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email Library for sending verification codes via Gmail
 */
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
            'mailtype' => $CI->config->item('email.mailtype', 'email_sms_config'),
            'charset' => $CI->config->item('email.charset', 'email_sms_config'),
            'newline' => $CI->config->item('email.newline', 'email_sms_config'),
            'wordwrap' => true
        );
        
        $CI->load->library('email', $this->config);
        $this->email =& $CI->email;
    }
    
    /**
     * Send verification code via email
     */
    public function send_verification_code($to, $code, $name = 'User') {
        $subject = 'Password Reset Verification Code - BHCA Portal';
        
        $message = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Password Reset Verification</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #333;">BHCA Portal</h1>
                    <p style="color: #666;">Password Reset Verification</p>
                </div>
                
                <p>Hello <strong>' . htmlspecialchars($name) . '</strong>,</p>
                
                <p>We received a request to reset your password. Please use the verification code below:</p>
                
                <div style="background-color: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px;">
                    <span style="font-size: 32px; font-weight: bold; color: #007bff; letter-spacing: 5px;">' . $code . '</span>
                </div>
                
                <p><strong>Important:</strong></p>
                <ul style="color: #666;">
                    <li>This code will expire in 30 minutes</li>
                    <li>If you did not request a password reset, please ignore this email</li>
                </ul>
                
                <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
                
                <p style="color: #999; font-size: 12px; text-align: center;">
                    This is an automated message from BHCA Portal.
                </p>
            </div>
        </body>
        </html>
        ';
        
        // Only try to send if SMTP is properly configured
        if (!empty($this->config['smtp_user']) && strpos($this->config['smtp_user'], 'your-') === false) {
            $this->email->clear();
            $this->email->from($this->config['smtp_user'], 'BHCA Portal');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            
            if(!@$this->email->send()) {
                log_message('error', 'Email sending failed');
                return false;
            }
            return true;
        }
        
        // If not configured, return false silently
        return false;
    }
}

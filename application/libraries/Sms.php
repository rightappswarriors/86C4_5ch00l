<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms {
    
    private $provider;
    private $twilio_config;
    private $semaphore_config;
    
    public function __construct() {
        $CI =& get_instance();
        $CI->config->load('email_sms_config', true);
        
        $this->provider = $CI->config->item('sms.provider', 'email_sms_config');
        
        $this->twilio_config = array(
            'account_sid' => $CI->config->item('sms.twilio.account_sid', 'email_sms_config'),
            'auth_token' => $CI->config->item('sms.twilio.auth_token', 'email_sms_config'),
            'twilio_number' => $CI->config->item('sms.twilio.twilio_number', 'email_sms_config')
        );
        
        $this->semaphore_config = array(
            'api_key' => $CI->config->item('sms.semaphore.api_key', 'email_sms_config'),
            'sender_name' => $CI->config->item('sms.semaphore.sender_name', 'email_sms_config')
        );
    }
    
    public function send_verification_code($to, $code) {
        $formatted_phone = $this->format_phone_number($to);
        $message = 'Your BHCA Portal password reset code is: ' . $code . '. This expires in 30 minutes.';
        
        if ($this->provider === 'twilio') {
            return $this->send_via_twilio($formatted_phone, $message);
        } else {
            return $this->send_via_semaphore($formatted_phone, $message);
        }
    }
    
    private function send_via_twilio($to, $message) {
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $this->twilio_config['account_sid'] . '/Messages.json';
        
        $data = array('To' => $to, 'From' => $this->twilio_config['twilio_number'], 'Body' => $message);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_USERPWD, $this->twilio_config['account_sid'] . ':' . $this->twilio_config['auth_token']);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return ($http_code == 201 || $http_code == 200);
    }
    
    private function send_via_semaphore($to, $message) {
        $url = 'https://api.semaphore.co/api/v4/sms';
        
        $data = array('apikey' => $this->semaphore_config['api_key'], 'sendername' => $this->semaphore_config['sender_name'], 'number' => $to, 'message' => $message);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return ($http_code == 200 || $http_code == 201);
    }
    
    private function format_phone_number($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) == '0') {
            $phone = '63' . substr($phone, 1);
        }
        if (substr($phone, 0, 1) != '+') {
            $phone = '+' . $phone;
        }
        return $phone;
    }
}

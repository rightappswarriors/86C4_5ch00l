<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email and SMS Configuration for Password Reset
 */

/* ==========================================
   EMAIL CONFIGURATION (Gmail SMTP)
   ========================================== */

$config['email']['protocol'] = 'smtp';
$config['email']['smtp_host'] = 'ssl://smtp.gmail.com';
$config['email']['smtp_port'] = 465;
$config['email']['smtp_user'] = 'velezvincent72@gmail.com';    // Your Gmail address
$config['email']['smtp_pass'] = 'YOUR-16-CHAR-APP-PASSWORD';       // CHANGE: Your Gmail App Password
$config['email']['mailtype'] = 'html';
$config['email']['charset'] = 'utf-8';
$config['email']['newline'] = "\r\n";

/* ==========================================
   SMS CONFIGURATION
   ========================================== */

// Choose SMS provider: 'twilio' or 'semaphore'
$config['sms']['provider'] = 'semaphore';

// Twilio Configuration (if using Twilio)
$config['sms']['twilio']['account_sid'] = 'your-twilio-account-sid';
$config['sms']['twilio']['auth_token'] = 'your-twilio-auth-token';
$config['sms']['twilio']['twilio_number'] = '+1234567890';

// Semaphore SMS Configuration (Philippines)
$config['sms']['semaphore']['api_key'] = 'your-semaphore-api-key';
$config['sms']['semaphore']['sender_name'] = 'BHCA Portal';

/* ==========================================
   PASSWORD RESET SETTINGS
   ========================================== */

$config['password_reset']['code_expiry_minutes'] = 30;
$config['password_reset']['code_length'] = 6;

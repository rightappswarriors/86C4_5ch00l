<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Email and SMS Configuration for Password Reset */

$config['email']['protocol'] = 'smtp';
$config['email']['smtp_host'] = 'smtp-relay.brevo.com';
$config['email']['smtp_port'] = 587;
$config['email']['smtp_user'] = 'a4d55d001@smtp-brevo.com';
$config['email']['smtp_pass'] = 'xsmtpsib-5d71eb5874d05b53fc19126d0ad0fe150147683095c88fa103e3734d087d9307-vuCpCh7ZAbpNg6LL';
$config['email']['mailtype'] = 'html';
$config['email']['charset'] = 'utf-8';
$config['email']['newline'] = "\r\n";

$config['sms']['provider'] = 'semaphore';
$config['sms']['twilio']['account_sid'] = 'your-twilio-account-sid';
$config['sms']['twilio']['auth_token'] = 'your-twilio-auth-token';
$config['sms']['twilio']['twilio_number'] = '+1234567890';
$config['sms']['semaphore']['api_key'] = 'your-semaphore-api-key';
$config['sms']['semaphore']['sender_name'] = 'BHCA Portal';

$config['password_reset']['code_expiry_minutes'] = 30;
$config['password_reset']['code_length'] = 6;
# Forgot Password System Setup Guide

## Overview
This forgot password system allows users to reset their password using either their email address or mobile number. If the user is not registered, they are redirected to the registration page. If registered, a verification code is sent to both their email and phone number.

## Files Created/Modified

### Controllers
- `application/controllers/Login.php` - Updated with forgot password functionality

### Models
- `application/models/Forgotpass_model.php` - New model for password reset operations

### Views
- `application/views/forgotpass.php` - Updated forgot password form
- `application/views/verify_code.php` - Verification code input page
- `application/views/reset_password.php` - New password form
- `application/views/login.php` - Updated to show success messages

### Libraries
- `application/libraries/Phpmailer.php` - Email sending library
- `application/libraries/Sms.php` - SMS sending library (Twilio/Semaphore)

### Configuration
- `application/config/email_sms_config.php` - Email and SMS configuration

### Database
- `file_upload/password_reset_codes.sql` - SQL to create verification codes table

---

## Setup Instructions

### Step 1: Configure Email and SMS Settings

Edit `application/config/email_sms_config.php` and update the following:

#### For Gmail:
```php
$config['email']['smtp_user'] = 'your-email@gmail.com';    // Your Gmail address
$config['email']['smtp_pass'] = 'your-app-password';       // Gmail App Password
```

**To get a Gmail App Password:**
1. Go to Google Account > Security
2. Enable 2-Step Verification
3. Go to App Passwords
4. Create new app password for "Mail"

#### For SMS (Choose one):

**Option A: Semaphore SMS (Philippines)**
```php
$config['sms']['provider'] = 'semaphore';
$config['sms']['semaphore']['api_key'] = 'your-semaphore-api-key';
$config['sms']['semaphore']['sender_name'] = 'BHCA Portal';
```

**Option B: Twilio**
```php
$config['sms']['provider'] = 'twilio';
$config['sms']['twilio']['account_sid'] = 'your-twilio-account-sid';
$config['sms']['twilio']['auth_token'] = 'your-twilio-auth-token';
$config['sms']['twilio']['twilio_number'] = '+1234567890';
```

### Step 2: Create Database Table

Run the SQL in `file_upload/password_reset_codes.sql` in your database:

```sql
CREATE TABLE IF NOT EXISTS `password_reset_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active, 0=used/expired',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `code` (`code`),
  KEY `status` (`status`),
  KEY `expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores password reset verification codes';
```

---

## How It Works

### 1. User clicks "Forgot Password"
- User enters email OR mobile number
- System checks if the user exists in the database

### 2. User Not Found
- If not registered, user is redirected to the registration page

### 3. User Found
- System generates a 6-digit verification code
- Code is stored in database with 30-minute expiry
- Code is sent to user's email (via Gmail SMTP)
- Code is sent to user's phone (via Twilio or Semaphore)
- User is redirected to verification code page

### 4. Verification
- User enters the 6-digit code
- System validates the code
- If valid, user can set new password

### 5. Password Reset
- User enters new password (6-12 characters)
- Password is updated in database (MD5 hashed)
- All verification codes for that user are invalidated
- User is redirected to login with success message

---

## Flow Diagram

```
┌─────────────────┐
│  Forgot Password│
│      Page       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Enter Email/    │
│ Mobile Number   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐     ┌─────────────────┐
│  User Exists?  │────►│   Not Found     │
└────────┬────────┘     └────────┬────────┘
         │ Yes                   │
         ▼                       ▼
┌─────────────────┐     ┌─────────────────┐
│ Generate Code   │     │  Redirect to     │
│ Send to Email   │     │  Registration   │
│ Send to Phone   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Verify Code   │
│     Page        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Code Valid?  │
└────────┬────────┘
         │
    Yes  │  No
         ▼
┌─────────────────┐
│ Reset Password │
│     Page       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Update Password│
│ Redirect Login │
└─────────────────┘
```

---

## Troubleshooting

### Email Not Sending
1. Check Gmail credentials in config
2. Make sure App Password is correct (not regular password)
3. Check if less secure app access is enabled (if not using App Password)

### SMS Not Sending
1. Check Twilio/Semaphore credentials
2. Verify phone number format (+63 for Philippines)
3. Check API key and sender name

### Code Not Working
1. Verify database table was created
2. Check if code has expired (30 minutes)
3. Clear browser cache and try again

---

## Security Notes

1. **HTTPS Required**: Always use HTTPS in production
2. **Code Expiry**: Codes expire after 30 minutes
3. **One-time Use**: Each code can only be used once
4. **Rate Limiting**: Consider adding rate limiting to prevent abuse
5. **Password Policy**: Minimum 6, maximum 12 characters

---

## Support

For issues or questions, please check the code comments or contact the developer.

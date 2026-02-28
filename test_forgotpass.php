<?php
/**
 * Simple test script to debug forgot password functionality
 * Run this at: http://localhost/86C4_5ch00l/test_forgotpass.php
 */

// Load CodeIgniter
define('BASEPATH', dirname(__FILE__) . '/');
require_once dirname(__FILE__) . '/index.php';

echo "<h1>Forgot Password Debug Test</h1>";

echo "<h2>1. Database Connection</h2>";
$CI =& get_instance();
$CI->load->database();

if ($CI->db->conn_id) {
    echo "<p style='color:green'>✓ Database connected</p>";
} else {
    echo "<p style='color:red'>✗ Database NOT connected</p>";
    echo "<p>Error: " . $CI->db->error_message() . "</p>";
    exit;
}

echo "<h2>2. Check Tables</h2>";

// Check register table
$query = $CI->db->query("SHOW TABLES LIKE 'register'");
if ($query->num_rows() > 0) {
    echo "<p style='color:green'>✓ register table exists</p>";
    
    // Check if there are users
    $users = $CI->db->get('register');
    echo "<p>Number of users: " . $users->num_rows() . "</p>";
    
    if ($users->num_rows() > 0) {
        echo "<h3>Sample User:</h3>";
        $user = $users->row();
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    }
} else {
    echo "<p style='color:red'>✗ register table does NOT exist</p>";
}

// Check password_reset_codes table
$query = $CI->db->query("SHOW TABLES LIKE 'password_reset_codes'");
if ($query->num_rows() > 0) {
    echo "<p style='color:green'>✓ password_reset_codes table exists</p>";
} else {
    echo "<p style='color:orange'>✗ password_reset_codes table does NOT exist - CREATING NOW...</p>";
    
    $sql = "CREATE TABLE IF NOT EXISTS `password_reset_codes` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($CI->db->query($sql)) {
        echo "<p style='color:green'>✓ Table created successfully!</p>";
    } else {
        echo "<p style='color:red'>✗ Failed to create table</p>";
    }
}

echo "<h2>3. Test User Lookup</h2>";
echo "<form method='post'>";
echo "<input type='text' name='identifier' placeholder='Enter email or mobile number' style='width:300px; padding:10px;'>";
echo "<button type='submit' style='padding:10px;'>Test Lookup</button>";
echo "</form>";

if (!empty($_POST['identifier'])) {
    $identifier = $_POST['identifier'];
    
    // Check if it's email or mobile
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $CI->db->where('emailadd', $identifier);
    } else {
        $CI->db->where('mobileno', $identifier);
    }
    
    $CI->db->where('status', 1);
    $query = $CI->db->get('register');
    
    if ($query->num_rows() > 0) {
        echo "<p style='color:green'>✓ User FOUND!</p>";
        $user = $query->row();
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        echo "<h2>4. Test Code Generation</h2>";
        
        // Generate code
        $code = sprintf("%06d", mt_rand(0, 999999));
        
        // Insert code
        $data = array(
            'user_id' => $user->id,
            'email' => $user->emailadd,
            'mobile' => $user->mobileno,
            'code' => $code,
            'created_at' => date("Y-m-d H:i:s"),
            'expires_at' => date("Y-m-d H:i:s", strtotime("+30 minutes")),
            'status' => 1
        );
        
        if ($CI->db->insert('password_reset_codes', $data)) {
            echo "<p style='color:green'>✓ Code generated and saved!</p>";
            echo "<p><strong>Verification Code: " . $code . "</strong></p>";
            echo "<p><em>(In production, this would be sent to email and phone)</em></p>";
        } else {
            echo "<p style='color:red'>✗ Failed to save code</p>";
        }
        
    } else {
        echo "<p style='color:red'>✗ User NOT found</p>";
    }
}

echo "<hr>";
echo "<p><a href='" . site_url('login/forgotpass') . "'>Go to Forgot Password Page</a></p>";

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Create the password_reset_codes table
     * Access this at: yoursite.com/index.php/setup/create_table
     */
    public function create_table()
    {
        // Create table using CodeIgniter's DB Forge
        $this->load->dbforge();
        
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'mobile' => array(
                'type' => 'VARCHAR',
                'constraint' => 20
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 10
            ),
            'created_at' => array(
                'type' => 'DATETIME'
            ),
            'expires_at' => array(
                'type' => 'DATETIME'
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => '1=active, 0=used/expired'
            )
        );
        
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('code');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('expires_at');
        
        if ($this->dbforge->create_table('password_reset_codes', TRUE)) {
            echo '<h1 style="color: green;">✓ Success!</h1>';
            echo '<p>The <code>password_reset_codes</code> table has been created successfully.</p>';
            echo '<p>You can now use the forgot password feature.</p>';
            echo '<p><a href="' . site_url('login/forgotpass') . '">Go to Forgot Password</a></p>';
        } else {
            echo '<h1 style="color: red;">✗ Error!</h1>';
            echo '<p>Failed to create table. Please check your database connection.</p>';
        }
    }
    
    /**
     * Check database connection and table status
     */
    public function status()
    {
        echo '<h2>Database Status</h2>';
        
        // Check database connection
        if ($this->db->conn_id) {
            echo '<p style="color: green;">✓ Database connected</p>';
        } else {
            echo '<p style="color: red;">✗ Database not connected</p>';
            return;
        }
        
        // Check if table exists
        if ($this->db->table_exists('password_reset_codes')) {
            echo '<p style="color: green;">✓ Table <code>password_reset_codes</code> exists</p>';
        } else {
            echo '<p style="color: orange;">✗ Table <code>password_reset_codes</code> does not exist</p>';
            echo '<p><a href="' . site_url('setup/create_table') . '">Create the table</a></p>';
        }
        
        // Check register table
        if ($this->db->table_exists('register')) {
            echo '<p style="color: green;">✓ Table <code>register</code> exists</p>';
        } else {
            echo '<p style="color: red;">✗ Table <code>register</code> does not exist</p>';
        }
        
        echo '<p><a href="' . site_url('login') . '">Go to Login</a></p>';
    }
}

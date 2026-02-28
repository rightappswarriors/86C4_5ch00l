<?php
/**
 * CodeIgniter IDE Helper stubs
 * This file helps IDEs (VSCode with Intelephense, PhpStorm, etc.) recognize CodeIgniter classes and methods
 * Place this file in: application/config/.phpstorm.meta.php
 */

/**
 * @property CI_DB $db
 * @property CI_Email $email
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_Config $config
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Cache $cache
 * @property CI_Cart $cart
 * @property CI_Encryption $encryption
 * @property CI_FTP $ftp
 * @property CI_Image_lib $image_lib
 * @property CI_Migration $migration
 * @property CI_Pagination $pagination
 * @property CI_Table $table
 * @property CI_User_agent $user_agent
 * @property CI_URI $uri
 * @property CI_Router $router
 * @property CI_Profiler $profiler
 * @property CI_Lang $lang
 * @property CI_Model $model
 */
class CI_Controller {
	public $db;
	public $email;
	public $session;
	public $form_validation;
	public $upload;
	public $config;
	public $load;
	public $input;
	public $output;
	public $cache;
	public $cart;
	public $encryption;
	public $ftp;
	public $image_lib;
	public $migration;
	public $pagination;
	public $table;
	public $user_agent;
	public $uri;
	public $router;
	public $profiler;
	public $lang;
	public $dbforge;
	public $login_model;
	public $Forgotpass_model;
	public $phpmailer;
	public $sms;
}

/**
 * @property CI_DB $db
 * @property CI_Config $config
 * @property CI_Loader $load
 * @property CI_Email $email
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Cache $cache
 */
class CI_Model {}

class CI_DBForge {}

class CI_Loader {
    public function model($model, $name = '', $db_conn = false) {}
    public function view($view, $vars = array(), $return = false) {}
    public function library($library = '', $params = null, $object_name = null) {}
    public function helper($helpers = array()) {}
    public function database($params = '', $query_builder_override = null) {}
    public function config($file = '', $use_sections = false, $fail_gracefully = false) {}
}

class CI_Session {
    public function set_userdata($data, $value = null) {}
    public function userdata($item) {}
    public function unset_userdata($data) {}
    public function flashdata($item) {}
    public function set_flashdata($data, $value = null) {}
}

class CI_Input {
    public function post($index = null, $xss_clean = null) {}
    public function get($index = null, $xss_clean = null) {}
    public function server($index = null, $xss_clean = null) {}
    public function ip_address() {}
    public function user_agent() {}
}

class CI_Form_validation {
    public function set_rules($field, $label = '', $rules = '') {}
    public function run($group = '') {}
    public function error($field = '', $prefix = '', $suffix = '') {}
    public function error_array() {}
    public function set_message($field, $msg) {}
    public function set_error_delimiters($prefix = '<p>', $suffix = '</p>') {}
}

class CI_Email {
    public function from($from, $name = '') {}
    public function to($to) {}
    public function cc($cc) {}
    public function bcc($bcc) {}
    public function subject($subject) {}
    public function message($body) {}
    public function send($auto_clear = true) {}
    public function clear($clearAttachments = false) {}
    public function attach($filename, $disposition = '') {}
}

class CI_Output {
    public function set_output($output) {}
    public function get_output() {}
    public function set_content_type($mime_type, $charset = null) {}
    public function get_content_type() {}
    public function set_header($header, $replace = true) {}
    public function enable_profiler($enable = true) {}
}

class CI_URI {
    public function segment($n, $no_result = null) {}
    public function uri_string() {}
    public function total_segments() {}
    public function segment_array() {}
}

class CI_Config {
    public function item($item, $index = '') {}
    public function set_item($item, $value) {}
    public function load($file = '', $use_sections = false, $fail_gracefully = false) {}
    public function slash_item($item) {}
}

class CI_Router {
    public function fetch_class() {}
    public function fetch_method() {}
    public function fetch_directory() {}
}

class CI_Lang {
    public function load($langfile, $idiom = '', $return = false, $add_suffix = true, $alt_path = '') {}
    public function line($line, $log_errors = true) {}
}

class CI_DB {}

function &get_instance() {}

function site_url($uri = '') {
    return '';
}

function base_url($uri = '') {
    return '';
}

function redirect($uri = '', $method = 'location', $code = null) {}

function current_url() {
    return '';
}

function uri_string() {
    return '';
}

function form_open($action = '', $attributes = array(), $hidden = array()) {}

function form_close($extra = '') {}

function form_input($data = '', $value = '', $extra = '') {}

function form_password($data = '', $value = '', $extra = '') {}

function form_submit($data = '', $value = '', $extra = '') {}

function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {}

function validation_errors($prefix = '', $suffix = '') {}

function set_value($field = '', $default = '') {}

function set_select($field = '', $value = '', $default = false) {}

function set_checkbox($field = '', $value = '', $default = false) {}

function set_radio($field = '', $value = '', $default = false) {}

function log_message($level, $message) {}

function show_error($message, $heading = 'An Error Was Encountered', $status_code = 500) {}

function show_404($page = '', $log_error = true) {}

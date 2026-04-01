<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_settings_model extends CI_Model
{
	protected $table = 'student_settings';
	protected static $table_ready = false;

	public function __construct()
	{
		parent::__construct();
		$this->ensure_table();
	}

	public function get_defaults()
	{
		return array(
			'dark_mode' => 0,
			'font_size' => 'medium',
			'compact_layout' => 0,
			'default_landing_page' => 'dashboard',
			'default_schoolyear_id' => null,
			'remember_sidebar_state' => 1,
			'high_contrast' => 0,
			'reduce_motion' => 0,
			'larger_text' => 0,
			'hide_mobile_number' => 0,
			'hide_profile_photo' => 0,
			'limit_personal_details' => 0,
			'show_welcome_card' => 1,
			'compact_dashboard_cards' => 0,
			'emphasize_primary_actions' => 1,
		);
	}

	public function get_or_create_for_user($student_user_id)
	{
		$student_user_id = (int) $student_user_id;
		$row = $this->db
			->where('student_user_id', $student_user_id)
			->get($this->table)
			->row_array();

		if (!$row) {
			$data = $this->get_defaults();
			$data['student_user_id'] = $student_user_id;
			$this->db->insert($this->table, $data);
			$row = $this->db
				->where('student_user_id', $student_user_id)
				->get($this->table)
				->row_array();
		}

		return $this->normalize_row($row);
	}

	public function save_for_user($student_user_id, array $data)
	{
		$student_user_id = (int) $student_user_id;
		$settings = $this->normalize_input($data);
		$settings['student_user_id'] = $student_user_id;

		$exists = $this->db
			->select('id')
			->where('student_user_id', $student_user_id)
			->get($this->table)
			->num_rows() > 0;

		if ($exists) {
			$this->db->where('student_user_id', $student_user_id)->update($this->table, $settings);
		} else {
			$this->db->insert($this->table, $settings);
		}

		return $this->get_or_create_for_user($student_user_id);
	}

	protected function normalize_row($row)
	{
		$defaults = $this->get_defaults();
		$row = is_array($row) ? $row : array();
		$settings = array_merge($defaults, $row);

		$boolean_fields = array(
			'dark_mode',
			'compact_layout',
			'remember_sidebar_state',
			'high_contrast',
			'reduce_motion',
			'larger_text',
			'hide_mobile_number',
			'hide_profile_photo',
			'limit_personal_details',
			'show_welcome_card',
			'compact_dashboard_cards',
			'emphasize_primary_actions',
		);

		foreach ($boolean_fields as $field) {
			$settings[$field] = (int) !empty($settings[$field]);
		}

		$settings['default_schoolyear_id'] = $settings['default_schoolyear_id'] !== null && $settings['default_schoolyear_id'] !== ''
			? (int) $settings['default_schoolyear_id']
			: null;

		return $settings;
	}

	protected function normalize_input(array $data)
	{
		$defaults = $this->get_defaults();
		$font_sizes = array('small', 'medium', 'large');
		$landing_pages = array('dashboard', 'grades', 'schedule', 'subjects', 'payments', 'enrollment', 'settings');

		return array(
			'dark_mode' => !empty($data['dark_mode']) ? 1 : 0,
			'font_size' => in_array($data['font_size'] ?? '', $font_sizes, true) ? $data['font_size'] : $defaults['font_size'],
			'compact_layout' => !empty($data['compact_layout']) ? 1 : 0,
			'default_landing_page' => in_array($data['default_landing_page'] ?? '', $landing_pages, true) ? $data['default_landing_page'] : $defaults['default_landing_page'],
			'default_schoolyear_id' => isset($data['default_schoolyear_id']) && $data['default_schoolyear_id'] !== '' ? (int) $data['default_schoolyear_id'] : null,
			'remember_sidebar_state' => !empty($data['remember_sidebar_state']) ? 1 : 0,
			'high_contrast' => !empty($data['high_contrast']) ? 1 : 0,
			'reduce_motion' => !empty($data['reduce_motion']) ? 1 : 0,
			'larger_text' => !empty($data['larger_text']) ? 1 : 0,
			'hide_mobile_number' => !empty($data['hide_mobile_number']) ? 1 : 0,
			'hide_profile_photo' => !empty($data['hide_profile_photo']) ? 1 : 0,
			'limit_personal_details' => !empty($data['limit_personal_details']) ? 1 : 0,
			'show_welcome_card' => !empty($data['show_welcome_card']) ? 1 : 0,
			'compact_dashboard_cards' => !empty($data['compact_dashboard_cards']) ? 1 : 0,
			'emphasize_primary_actions' => !empty($data['emphasize_primary_actions']) ? 1 : 0,
		);
	}

	protected function ensure_table()
	{
		if (self::$table_ready) {
			return;
		}

		$sql = "
			CREATE TABLE IF NOT EXISTS `{$this->table}` (
				`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				`student_user_id` BIGINT(20) NOT NULL,
				`dark_mode` TINYINT(1) NOT NULL DEFAULT 0,
				`font_size` VARCHAR(20) NOT NULL DEFAULT 'medium',
				`compact_layout` TINYINT(1) NOT NULL DEFAULT 0,
				`default_landing_page` VARCHAR(50) NOT NULL DEFAULT 'dashboard',
				`default_schoolyear_id` INT NULL DEFAULT NULL,
				`remember_sidebar_state` TINYINT(1) NOT NULL DEFAULT 1,
				`high_contrast` TINYINT(1) NOT NULL DEFAULT 0,
				`reduce_motion` TINYINT(1) NOT NULL DEFAULT 0,
				`larger_text` TINYINT(1) NOT NULL DEFAULT 0,
				`hide_mobile_number` TINYINT(1) NOT NULL DEFAULT 0,
				`hide_profile_photo` TINYINT(1) NOT NULL DEFAULT 0,
				`limit_personal_details` TINYINT(1) NOT NULL DEFAULT 0,
				`show_welcome_card` TINYINT(1) NOT NULL DEFAULT 1,
				`compact_dashboard_cards` TINYINT(1) NOT NULL DEFAULT 0,
				`emphasize_primary_actions` TINYINT(1) NOT NULL DEFAULT 1,
				`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uniq_student_user_id` (`student_user_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
		";

		$this->db->query($sql);
		self::$table_ready = true;
	}
}

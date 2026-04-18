<?php
/**
 * Principal Account Creator Script
 * Run this file once from browser: http://yourdomain.com/create_principal.php
 * DELETE immediately after use!
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_principal extends CI_Controller {

	public function index()
	{
		// SECURITY: Only allow local access or delete after use
		if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
			die('Access denied. Run locally only.');
		}

		// Load database
		$ci =& get_instance();
		$ci->load->database();

		// Check if Principal already exists
		$existing = $ci->db->get_where('register', ['usertype' => 'Principal', 'deleted' => 'no'])->row();
		if ($existing) {
			// Reset existing Principal account
			$reset_data = [
				'userpass' => md5('Pr1nc1p@l2025'),
				'lastlogin' => date('Y-m-d H:i:s')
			];
			$ci->db->where('id', $existing->id);
			$ci->db->update('register', $reset_data);

			echo "Principal account reset successfully:<br>";
			echo "Username (Mobile): <strong>" . htmlspecialchars($existing->mobileno) . "</strong><br>";
			echo "Password: <strong>Pr1nc1p@l2025</strong><br><br>";
			echo "Full name: " . htmlspecialchars($existing->firstname . ' ' . $existing->lastname) . "<br><br>";
			echo "<strong style='color:red;'>DELETE this file after use!</strong>";
			return;
		}

		// Create new Principal account (fallback - shouldn't happen)
		$data = [
			'mobileno' => '09951234567',
			'emailadd' => 'principal@bhca.edu.ph',
			'firstname' => 'Maria',
			'middlename' => 'Santos',
			'lastname' => 'Rustila',
			'birthdate' => '1980-01-15',
			'userpass' => md5('Pr1nc1p@l2025'),
			'usertype' => 'Principal',
			'gradelevel' => 'N/A',
			'gradelevel1' => 'N/A',
			'dateadded' => date('Y-m-d H:i:s'),
			'lastlogin' => date('Y-m-d H:i:s'),
			'deleted' => 'no',
			'status' => 1,
			'lrn' => '',
			'school_id' => ''
		];
		$ci->db->insert('register', $data);

		echo "<strong>Principal Account Ready!</strong><br><br>";
		echo "Login Credentials:<br>";
		echo "&nbsp;&nbsp;Username (Mobile): <strong>" . htmlspecialchars($existing->mobileno) . "</strong><br>";
		echo "&nbsp;&nbsp;Password: <strong>Pr1nc1p@l2025</strong><br><br>";
		echo "Full name: " . htmlspecialchars($existing->firstname . ' ' . $existing->lastname) . "<br>";
		echo "<strong style='color:red;'>Important: Delete this file after confirming!</strong>";
	}
}

/* USAGE:
1. Upload this file to your CodeIgniter root (same level as application/ folder)
2. Visit: http://portal.bobhughes.edu.ph/create_principal.php
3. Account will be created automatically
4. DELETE the file after successful creation
*/

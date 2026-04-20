<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

	//private $profile_pic;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('students_model');
		$this->load->model('payments_model');
		$this->load->model('register_model');
		$this->load->model('files_model');
		
		//$this->profile_pic = 'default-profile.jpg';
		
		$method = $this->router->fetch_method();
		$mutative_methods = array('enrollnew_submit', 'preenrollnew_submit', 'enrollnew_success', 'preenroll_success', 'updateinfo_submit', 'assessment_submit', 'academics_submit', 'remove_enroll', 'docs_submit', 'changelevel');
		if (in_array($method, $mutative_methods) && $this->session->userdata('current_usertype_display') === 'Admin') {
			$this->session->set_flashdata('message', "Spectator Admins are not allowed to apply changes.");
			redirect("students");
			exit;
		}
	}

	private function get_student_row($studentid)
	{
		$studentid = (int) $studentid;
		if ($studentid <= 0) {
			return null;
		}

		$query = $this->students_model->search_student_info($studentid);
		if (!$query || $query->num_rows() === 0) {
			return null;
		}

		return $query->row();
	}

	private function ensure_student_edit_access($studentid)
	{
		$student = $this->get_student_row($studentid);
		if (!$student) {
			show_404();
		}

		if ($this->session->userdata('current_usertype') === 'Parent'
			&& (int) $student->user_id !== (int) $this->session->userdata('current_userid')) {
			$this->session->set_flashdata('message', 'You are not allowed to edit this enrollment form.');
			redirect('students');
		}

		return $student;
	}
	
	public function index()
	{
		$data = array(
			'title'     =>   'STUDENTS',
			'template'   =>   'students/list',
			'query' => $this->students_model->students_list(),
			'students_count_status' => $this->students_model->students_count_status()
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function fetcher_register()
	{
		$data = array(
			'title'     =>   "Fetcher's ID Application",
			'template'   =>   'students/fetch_registration'
		);
		
		$this->load->view('template', $data);
	}
	
	public function fetcher_id_submit()
	{
		$fetcher = $this->input->post('fetcher');
		$student = $this->input->post('student');
		$notes = $this->input->post('notes');
		
		$fetcher_json = json_encode($fetcher);
		$student_json = json_encode($student);
		
		$data = array(
			'fetcher_data' => $fetcher_json,
			'student_data' => $student_json,
			'notes' => $notes,
			'registered_date' => date("Y-m-d H:i:s")
		);
		
		$insert_id = $this->students_model->fetcher_register($data);
		
		$this->session->set_flashdata('message', "Fetcher's ID Application submitted successfully!");
		redirect("students/fetcher_print/" . $insert_id);
	}
	
	public function fetcher_list()
	{
		$data = array(
			'title'     =>   "Fetcher's ID Applications",
			'template'   =>   'students/fetcher_list',
			'query' => $this->students_model->fetcher_registration_list()
		);
		
		$this->load->view('template', $data);
	}
	
	public function fetcher_print()
	{
		$id = $this->uri->segment(3);
		$record = $this->students_model->get_fetcher_registration($id);

		if (!$record) {
			show_404();
		}

		$data = array(
			'title'     =>   "Fetcher's ID Application",
			'record' => $record
		);

		$this->load->view('students/fetch_registration_print', $data);
	}

	public function fetcher_info()
	{
		// Restrict access to specific roles only
		$allowed_roles = ['Admin', 'Accounting', 'Registrar', 'Principal'];
		$user_role = $this->session->userdata('current_usertype');

		if (!in_array($user_role, $allowed_roles)) {
			show_error('Unauthorized Access', 403);
			return;
		}

		$data = array(
			'title'     => "Fetcher Information",
			'template'  => 'students/fetcher_info',
			'query' => $this->students_model->fetcher_registration_list()
		);

		$this->load->view('template', $data);
	}

	public function newold()
	{
		$data = array(
			'title'     =>   'STUDENTS',
			'template'   =>   'students/list',
			'query' => $this->students_model->students_newold($this->uri->segment(3))
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function gradelevel()
	{
		$data = array(
			'title'     =>   'STUDENTS',
			'template'   =>   'students/gradelevel',
			'query' => $this->students_model->bygradelevel()
		);
		
		$this->load->view('template', $data);	
		
	}
	
	public function preenroll_form()
	{
		$studentid = $this->uri->segment(3);
		$data = array(
		'title'     =>   'STUDENTS // Pre-enrollment Application',
		'template'   =>   'preenroll_form',
		'query' => $this->students_model->search_student_info($studentid)
		);
		$this->load->view('template', $data);	
		
	}
	
	public function enrollnew()
	{
		$data = array(
		'title'     =>   'STUDENTS // Enroll',
		'template'   =>   'enrollnew'
		);
		$this->load->view('template', $data);	
		
	}
	
	public function enroll_readhandbook()
	{
		$data = array(
		'title'     =>   'STUDENTS // Enroll',
		'template'   =>   'enroll_readhandbook'
		);
		$this->load->view('template', $data);	
		
	}
	
	public function enrollnew_form()
	{
		$data = array(
		'title'     =>   'STUDENTS // Enroll Student',
		'template'   =>   'enrollnew_form'
		);
		$this->load->view('template', $data);	
		
	}
	
	public function enrollnew_submit()
	{
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim');
		$this->form_validation->set_rules('birthdate', 'Date of Birth', 'required|trim');
		$this->form_validation->set_rules('referred_by', 'Refered by', 'required|trim');
		$this->form_validation->set_rules('street', 'Street', 'required|trim');
		$this->form_validation->set_rules('barangay', 'Barangay', 'required|trim');
		$this->form_validation->set_rules('incaseemergency', 'Emergency Contact', 'required|trim');
		$this->form_validation->set_rules('personal_cell', 'Emergency Cell', 'required|trim');
		
		$this->form_validation->set_rules('province', 'Province', 'required|trim');
		$this->form_validation->set_rules('country', 'Country', 'required|trim');
		$this->form_validation->set_rules('lastschool', 'Previous School Name', 'trim');
		$this->form_validation->set_rules('lastschoolyear', 'Last School Year Attended', 'trim');
		$this->form_validation->set_rules('lastschoolgrade', 'Previous Grade Level', 'trim');
		
		$this->form_validation->set_rules('father_firstname', 'Father Firstname', 'required|trim');
		$this->form_validation->set_rules('father_lastname', 'Father Lastname', 'required|trim');
		$this->form_validation->set_rules('father_middlename', 'Father Middlename', 'required|trim');
		$this->form_validation->set_rules('father_place_work', 'Father Place of Work', 'required|trim');
		$this->form_validation->set_rules('father_contact1', 'Father Contact1', 'trim');
		$this->form_validation->set_rules('father_contact2', 'Father Contact2', 'required|trim');
		$this->form_validation->set_rules('father_email', 'Father Email', 'required|trim|valid_email');
		
		$this->form_validation->set_rules('mother_firstname', 'Mother Firstname', 'required|trim');
		$this->form_validation->set_rules('mother_lastname', 'Mother Lastname', 'required|trim');
		$this->form_validation->set_rules('mother_middlename', 'Mother Middlename', 'required|trim');
		$this->form_validation->set_rules('mother_place_work', 'Mother Place of Work', 'required|trim');
		$this->form_validation->set_rules('mother_contact1', 'Mother Contact1', 'trim');
		$this->form_validation->set_rules('mother_contact2', 'Mother Contact2', 'required|trim');
		$this->form_validation->set_rules('email', 'Mother Email', 'required|trim|valid_email');
		
		
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$data = array(
				'lastname'  => $this->input->post('lastname') ?: '',
				'firstname'  => $this->input->post('firstname') ?: '',
				'middlename'  => $this->input->post('middlename') ?: '',
				'birthdate'  => $this->input->post('birthdate') ?: '',
				'placeofbirth'  => $this->input->post('placeofbirth') ?: '',
				'gender'  => $this->input->post('gender') ?: '',
				'referred_by'  => $this->input->post('referred_by') ?: '',
				'street'  => $this->input->post('street') ?: '',
				'barangay'  => $this->input->post('barangay') ?: '',
				'houseno'  => $this->input->post('houseno') ?: '',
				'city'  => $this->input->post('city') ?: '',
				'province'  => $this->input->post('province') ?: '',
				'country'  => $this->input->post('country') ?: '',
				'lastschool'  => $this->input->post('lastschool') ?: '',
				'lastschoolyear'  => $this->input->post('lastschoolyear') ?: '',
				'lastschoolgrade'  => $this->input->post('lastschoolgrade') ?: '',
				'father_firstname'  => $this->input->post('father_firstname') ?: '',
				'father_lastname'  => $this->input->post('father_lastname') ?: '',
				'father_middlename'  => $this->input->post('father_middlename') ?: '',
				'father_work'  => $this->input->post('father_work') ?: '',
				'father_place_work'  => $this->input->post('father_place_work') ?: '',
				'father_contact1'  => $this->input->post('father_contact1') ?: '',
				'father_contact2'  => $this->input->post('father_contact2') ?: '',
				'email'  => $this->input->post('email') ?: '',
				'father_email'  => $this->input->post('father_email') ?: '',
				'father_fbmessenger'  => $this->input->post('father_fbmessenger') ?: '',
				'mother_fbmessenger'  => $this->input->post('mother_fbmessenger') ?: '',
				'mother_firstname'  => $this->input->post('mother_firstname') ?: '',
				'mother_lastname'  => $this->input->post('mother_lastname') ?: '',
				'mother_work'  => $this->input->post('mother_work') ?: '',
				'mother_place_work'  => $this->input->post('mother_place_work') ?: '',
				'mother_contact1'  => $this->input->post('mother_contact1') ?: '',
				'mother_contact2'  => $this->input->post('mother_contact2') ?: '',
				'mother_middlename'  => $this->input->post('mother_middlename') ?: '',
				'maidenname'  => $this->input->post('maidenname') ?: '',
				'incaseemergency'  => $this->input->post('incaseemergency') ?: '',
				'place_employment'  => $this->input->post('place_employment') ?: '',
				'work_phone'  => $this->input->post('work_phone') ?: '',
				'personal_cell'  => $this->input->post('personal_cell') ?: '',
				'homelandline'  => $this->input->post('homelandline') ?: '',
				'other_homelandline'  => $this->input->post('other_homelandline') ?: '',
				'fbmessenger'  => $this->input->post('fbmessenger') ?: '',
				'relationship'  => $this->input->post('relationship') ?: '',
				'church_name'  => $this->input->post('church_name') ?: '',
				'church_address'  => $this->input->post('church_address') ?: '',
				'church_tel'  => $this->input->post('church_tel') ?: '',
				'church_pastor'  => $this->input->post('church_pastor') ?: '',
				'church_website'  => $this->input->post('church_website') ?: '',
				'date_salvation'  => $this->input->post('date_salvation') ?: '',
				'date_baptism'  => $this->input->post('date_baptism') ?: '',
				'user_id'  => $this->session->userdata('current_userid'),
				'dateadded'  => date("Y-m-d H:i:s"),
				
				// Additional database fields that are NOT NULL but not in form
				'studentno' => '',
				'lrn' => '',
				'father_address' => '',
				'mother_address' => '',
				'guardian_firstname' => '',
				'guardian_lastname' => '',
				'guardian_address' => '',
				'guardian_work' => '',
				'contact1' => '',
				'contact2' => '',
				'contact3' => '',
				'guardian_middlename' => '',
			);
			
			$id = $this->students_model->enrollnew($data);
			if($id > 0)
			{
				//message successful	
				$this->session->set_flashdata('message', "Successfully added new student!");
				
				redirect("students/enrollnew_success/".$id);
			}
		}
		else
		{
			$this->enrollnew_form();
		}	
		
	}
	
	public function preenrollnew_submit()
	{
		
		$studentid = $this->uri->segment(3);
		//$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		//$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		//$this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim');
		$this->form_validation->set_rules('birthdate', 'Date of Birth', 'required|trim');
		$this->form_validation->set_rules('street', 'Street', 'required|trim');
		$this->form_validation->set_rules('barangay', 'Barangay', 'required|trim');
		$this->form_validation->set_rules('incaseemergency', 'Emergency Contact', 'required|trim');
		//$this->form_validation->set_rules('personal_cell', 'Emergency Cell', 'required|trim');
		//$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$data = array(
				'birthdate'  => $this->input->post('birthdate'),
				'placeofbirth'  => $this->input->post('placeofbirth'),
				'gradelevel'  => $this->input->post('gradelevel'),
				'strand'  => $this->input->post('strand'),
				'street'  => $this->input->post('street'),
				'barangay'  => $this->input->post('barangay'),
				'houseno'  => $this->input->post('houseno'),
				'city'  => $this->input->post('city'),
				'province'  => $this->input->post('province'),
				'country'  => $this->input->post('country'),
				'father_firstname'  => $this->input->post('father_firstname'),
				'father_contact1'  => $this->input->post('father_contact1') ?: '',
				'mother_firstname'  => $this->input->post('mother_firstname'),
				'mother_contact1'  => $this->input->post('mother_contact1') ?: '',
				'incaseemergency'  => $this->input->post('incaseemergency'),
				'work_phone'  => $this->input->post('work_phone'),
				'homelandline'  => $this->input->post('homelandline'),
				'church_name'  => $this->input->post('church_name'),
				'church_tel'  => $this->input->post('church_tel'),
				'church_pastor'  => $this->input->post('church_pastor'),
				'child_name1'  => $this->input->post('child_name1'),
				'child_gender1'  => $this->input->post('child_gender1'),
				'child_age1'  => $this->input->post('child_age1'),
				'child_name2'  => $this->input->post('child_name2'),
				'child_gender2'  => $this->input->post('child_gender2'),
				'child_age2'  => $this->input->post('child_age2'),
				'child_name3'  => $this->input->post('child_name3'),
				'child_gender3'  => $this->input->post('child_gender3'),
				'child_age3'  => $this->input->post('child_age3'),
				'child_name4'  => $this->input->post('child_name4'),
				'child_gender4'  => $this->input->post('child_gender4'),
				'child_age4'  => $this->input->post('child_age4'),
				'child_name5'  => $this->input->post('child_name5'),
				'child_gender5'  => $this->input->post('child_gender5'),
				'child_age5'  => $this->input->post('child_age5'),
				'schoolyear' => $this->session->userdata('current_schoolyearid'),
				'user_id'  => $this->session->userdata('current_userid'),
				'studentid'  => $studentid,
				'dateadded'  => date("Y-m-d H:i:s")
			);
			
			$this->students_model->preenrollnew($data);
			$this->session->set_flashdata('message', "Application successfully submitted!");
			redirect("students/preenroll_success/".$studentid);
	
		}
		else
		{
			$this->preenroll_form();
		}	
		
	}
	
	public function enrollnew_success($id)
	{
		// Get enrollment info
		$enroll_qry = $this->db->query("select * from enrolled where studentid = " . $id . " and deleted = 'no' order by addeddate desc limit 1");
		$enroll = $enroll_qry->num_rows() > 0 ? $enroll_qry->row() : null;
		
		$current_schoolyear = $this->session->userdata('current_schoolyear') ?? date('Y');
		
		// Get student info
		$student = $this->students_model->search_student_info($id)->row();
		
		// Generate print URL - simpler is better for QR scanning
		$print_url = site_url("students/enrollment_receipt/" . $id);
		
		// Generate QR code with just the URL - larger size for better scanning
		$qr_code_url = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=" . urlencode($print_url);
		
		$data = array(
		'title'     =>   'STUDENTS // Enroll Student',
		'template'   =>   'parent/enrollnew_success',
		'student_id'   =>   $id,
		'qr_code_url' => $qr_code_url,
		'print_url' => $print_url,
		'current_usertype' => $this->session->userdata('current_usertype')
		);
		$this->load->view('template', $data);	
	}
	
	public function preenroll_success($id)
	{
		$data = array(
		'title'     =>   'STUDENTS // Pre-enrollment Application',
		'template'   =>   'parent/preenroll_success',
		'student_id'   =>   $id,
		);
		$this->load->view('template', $data);	
	}
	
	public function updateinfo(){
		$studentid = $this->uri->segment(3);
		$this->ensure_student_edit_access($studentid);
		$data = array(
			'title'     =>   'STUDENTS // Update Student Information',
			'template'   =>   'students/updateinfo',
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
			'query' => $this->students_model->search_student_info($studentid)
		);
		$this->load->view('template', $data);	
	}
	
	public function assessment(){
		
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$data = array(
			'title'     =>   'STUDENTS // Registrar Assessment',
			'template'   =>   'students/assessment',
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
			'query' => $this->students_model->search_student_info( $studentid ),
			'query_ass' => $this->students_model->assessment_check( $enroll_id ),
			'query_payments' => $this->payments_model->getPrepaids( $enroll_id ),
			'default_ass' => $this->payments_model->default_assessment()
		);
		
		$this->load->view('template', $data);	
	}
	
	public function details(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Student Information',
			'template'   =>   'students/details',
			'query' => $this->students_model->search_student_info($studentid),
			'profile_pic' => $this->students_model->profile_pic( $studentid )
		);
		$this->load->view('template', $data);		
	}
	
	public function details_print(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Student Information',
			'template'   =>   'students/details_print',
			'query' => $this->students_model->search_student_info($studentid),
			'profile_pic' => $this->students_model->profile_pic( $studentid )
		);
		$this->load->view('template_print', $data);		
}
	
	public function assessment_print(){
		
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$data = array(
			'title'     =>   'STUDENTS // Assessment Print',
			'query' => $this->students_model->search_student_info($studentid),
			'query_ass' => $this->students_model->assessment_check( $enroll_id ),
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
			'default_ass' => $this->payments_model->default_assessment()
		);
		
$this->load->view('students/assessment_print', $data);
	}
	
	public function assessment_paces(){
		
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$data = array(
			'title'     =>   'STUDENTS // Assessment PACEs',
			'template'   =>   'students/assessment_paces',
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
			'query' => $this->students_model->search_student_info( $studentid ),
			'query_ass' => $this->students_model->assessment_check( $enroll_id )
		);
		
		$this->load->view('template', $data);	
	}
	
	public function assessment_paces_submit(){
		
		$studentid = $this->uri->segment(3);
		$as_id = $this->input->post('as_id');
		
		$math = $this->input->post('math_begin').','.$this->input->post('math_end').','.$this->input->post('math_gaps');
		$english = $this->input->post('eng_begin').','.$this->input->post('eng_end').','.$this->input->post('eng_gaps');
		$science = $this->input->post('science_begin').','.$this->input->post('science_end').','.$this->input->post('science_gaps');
		$socstudies = $this->input->post('sstudies_begin').','.$this->input->post('sstudies_end').','.$this->input->post('sstudies_gaps');
		$wordbuilding = $this->input->post('wbuilding_begin').','.$this->input->post('wbuilding_end').','.$this->input->post('wbuilding_gaps');
		$literature = $this->input->post('literature_begin').','.$this->input->post('literature_end');
		$filipino = $this->input->post('filipino_begin').','.$this->input->post('filipino_end');
		$ap = $this->input->post('ap_begin').','.$this->input->post('ap_end');
		
		$pace_data = array(
			'math' => $math,
			'english' => $english,
			'science' => $science,
			'socstudies' => $socstudies,
			'wordbuilding' => $wordbuilding,
			'literature' => $literature,
			'filipino' => $filipino,
			'ap' => $ap,
			'lastupdate' => date("Y-m-d H:i:s")
		);
		
		if($as_id > 0){
			$this->db->where('id', $as_id);
			$this->db->update('assessment', $pace_data);
		}
		
		$this->session->set_flashdata('message', 'PACEs Updated Successfully!');
		redirect('students/assessment_paces/'.$studentid);
	}
	
	public function enrollment_receipt()
	{
		$studentid = $this->uri->segment(3);
		$query = $this->students_model->search_student_info($studentid);
		$studentid = $this->uri->segment(3);
		$query = $this->students_model->search_student_info($studentid);
		
		if($query->num_rows() > 0) {
			$row = $query->row();
			$enroll_id = $this->students_model->enroll_info($studentid);
			
			$data = array(
				'title'     =>   'Enrollment Receipt',
				'template'   =>   'students/enrollment_receipt',
				'query' => $query,
				'enroll_id' => $enroll_id
			);
			
			$this->load->view('template', $data);
		} else {
			redirect('students');
		}
	}

	// Landing page to view student info and enrollment receipt for review
	public function view_student_info()
	{
		$studentid = $this->uri->segment(3);
		$query = $this->students_model->search_student_info($studentid);
		
		if($query->num_rows() > 0) {
			$enroll_id = $this->students_model->enroll_info($studentid);
			
			$data = array(
				'title'     =>   'View Student Info - Review',
				'template'   =>   'students/view_student_info',
				'query' => $query,
				'enroll_id' => $enroll_id,
				'profile_pic' => $this->students_model->profile_pic($studentid),
				'current_usertype' => $this->session->userdata('current_usertype')
			);
			
			$this->load->view('template', $data);
		} else {
			redirect('students');
		}
	}
	
	public function payments(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Payments',
			'template'   =>   'students/payments',
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
			'query' => $this->students_model->search_student_info($studentid)
		);
		$this->load->view('template', $data);		
	}
	
	public function assessment_submit(){
		
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$indntals_val = "";
		foreach($this->input->post('indntals') as $indntals){
			$indntals_val .= $indntals . ",";
		}
		$msclns_val = "";
		foreach($this->input->post('msclns') as $msclns){
			$msclns_val .= $msclns . ",";
		}
		
		$data = array(
			'incidentals' => $indntals_val,
			'miscellaneous' => $msclns_val,
			'oldaccount' => $this->input->post('oldaccount'),
			'tuition' => $this->input->post('tuition'),
			'registration' => $this->input->post('registration'),
			'payment' => $this->input->post('paymentenroll'),
			'asstotal' => $this->input->post('asstotal_hidden'),
			'lastupdate'  => date("Y-m-d H:i:s")
		);
		
		$as_id = $this->input->post("as_id");
		if($as_id>0){
			$this->students_model->assessment_update($as_id,$data);
			
			// change status to ASSESED
			// =========== TEMPORARY Not Functional ==================
			//$this->students_model->changestatus('Assessed',$studentid);
			// =========== TEMPORARY Not Functional ==================
			
		}else{

			$data['enroll_id'] = $enroll_id;
			$data['dateadded'] = date("Y-m-d H:i:s");
			$this->students_model->assessment_submit($data);
		
		}
		
		//message successful	
		$this->session->set_flashdata('message', "Successfully updated!");
		redirect("students/assessment/".$studentid);
		
	}
	
	public function academics(){
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$data = array(
			'title'     		=> 'STUDENTS // Academics',
			'template'   		=> 'students/academics',
			'profile_pic' 		=> $this->students_model->profile_pic( $studentid ),
			'query' 			=> $this->students_model->search_student_info($studentid),
			'query_ass' 		=> $this->students_model->assessment_check( $enroll_id ),
			//'query_payments' 	=> $this->payments_model->getPrepaids( $enroll_id ),
			'default_ass' 		=> $this->payments_model->default_assessment(),
			'query_academics' 	=> $this->students_model->getStudentAcademics($enroll_id)
		);
		$this->load->view('template', $data);	
	}
	
	public function academics_submit(){
		
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->students_model->enroll_info($studentid);
		
		$math_grade			= $this->input->post('math_grade');
		$math_date			= $this->input->post('math_date');
		$math_qtr			= $this->input->post('math_qtr');
		$math_data 			= "";
		if(!empty($math_grade)){
		foreach($math_grade as $ind=>$mathgrade){
			$math_data 		.= $ind."|".$mathgrade."|".$math_date[$ind]."|".$math_qtr[$ind].",";
		}}
		
		$eng_grade			= $this->input->post('eng_grade');
		$eng_date			= $this->input->post('eng_date');
		$eng_qtr			= $this->input->post('eng_qtr');
		$eng_data 			= "";
		if(!empty($eng_grade)){
		foreach($eng_grade as $ind=>$enggrade){
			$eng_data 		.= $ind."|".$enggrade."|".$eng_date[$ind]."|".$eng_qtr[$ind].",";
		}}
		
		$science_grade		= $this->input->post('science_grade');
		$science_date		= $this->input->post('science_date');
		$science_qtr		= $this->input->post('science_qtr');
		$science_data 		= "";
		if(!empty($science_grade)){
		foreach($science_grade as $ind=>$sciencegrade){
			$science_data 		.= $ind."|".$sciencegrade."|".$science_date[$ind]."|".$science_qtr[$ind].",";
		}}
		
		$sstudies_grade		= $this->input->post('sstudies_grade');
		$sstudies_date		= $this->input->post('sstudies_date');
		$sstudies_qtr		= $this->input->post('sstudies_qtr');
		$sstudies_data 		= "";
		if(!empty($sstudies_grade)){
		foreach($sstudies_grade as $ind=>$sstudiesgrade){
			$sstudies_data 		.= $ind."|".$sstudiesgrade."|".$sstudies_date[$ind]."|".$sstudies_qtr[$ind].",";
		}}
		
		$wbuilding_grade	= $this->input->post('wbuilding_grade');
		$wbuilding_date		= $this->input->post('wbuilding_date');
		$wbuilding_qtr		= $this->input->post('wbuilding_qtr');
		$wbuilding_data 	= "";
		if(!empty($wbuilding_grade)){
		foreach($wbuilding_grade as $ind=>$wbuildinggrade){
			$wbuilding_data 	.= $ind."|".$wbuildinggrade."|".$wbuilding_date[$ind]."|".$wbuilding_qtr[$ind].",";
		}}
		
		$literature_grade	= $this->input->post('literature_grade');
		$literature_date	= $this->input->post('literature_date');
		$literature_qtr		= $this->input->post('literature_qtr');
		$literature_data 	= "";
		if(!empty($literature_grade)){
		foreach($literature_grade as $ind=>$literaturegrade){
			$literature_data 	.= $ind."|".$literaturegrade."|".$literature_date[$ind]."|".$literature_qtr[$ind].",";
		}}
		
		$filipino_grade		= $this->input->post('filipino_grade');
		$filipino_date		= $this->input->post('filipino_date');
		$filipino_qtr		= $this->input->post('filipino_qtr');
		$filipino_data 		= "";
		if(!empty($filipino_grade)){
		foreach($filipino_grade as $ind=>$filipinograde){
			$filipino_data 		.= $ind."|".$filipinograde."|".$filipino_date[$ind]."|".$filipino_qtr[$ind].",";
		}}
		
		$afilipino_grade		= $this->input->post('afilipino_grade');
		$afilipino_date		= $this->input->post('afilipino_date');
		$afilipino_qtr		= $this->input->post('afilipino_qtr');
		$afilipino_data 		= "";
		if(!empty($afilipino_grade)){
		foreach($afilipino_grade as $ind=>$afilipinograde){
			$afilipino_data 		.= $ind."|".$afilipinograde."|".$afilipino_date[$ind]."|".$afilipino_qtr[$ind].",";
		}}
		
		$ap_grade			= $this->input->post('ap_grade');
		$ap_date			= $this->input->post('ap_date');
		$ap_qtr				= $this->input->post('ap_qtr');
		$ap_data 			= "";
		if(!empty($ap_grade)){
		foreach($ap_grade as $ind=>$apgrade){
			$ap_data 		.= $ind."|".$apgrade."|".$ap_date[$ind]."|".$ap_qtr[$ind].",";
		}}
		
		//CONVENTIONAL...
		$speechs 			= implode(",",$this->input->post('speech'));
		$musics 			= implode(",",$this->input->post('music'));
		$bibles 			= implode(",",$this->input->post('bible'));
		$esps 				= implode(",",$this->input->post('esp'));
		$tles 				= implode(",",$this->input->post('tle'));
		$mapehs 			= implode(",",$this->input->post('mapeh'));
		$mapeh_musics 		= implode(",",$this->input->post('mapeh_music'));
		$artss 				= implode(",",$this->input->post('arts'));
		$pes 				= implode(",",$this->input->post('pe'));
		$healths 			= implode(",",$this->input->post('health'));
		
		$data = array(
			'student_id'	=> $studentid,
			'enroll_id'		=> $enroll_id,
			'math' 			=> $math_data,
			'eng' 			=> $eng_data,
			'science'		=> $science_data,
			'sstudies' 		=> $sstudies_data,
			'wbuilding'		=> $wbuilding_data,
			'literature'	=> $literature_data,
			'filipino'		=> $filipino_data,
			'afilipino'		=> $afilipino_data,
			'ap'			=> $ap_data,
			'speech' 		=> $speechs,
			'music' 		=> $musics,
			'bible' 		=> $bibles,
			'esp' 			=> $esps,
			'tle' 			=> $tles,
			'mapeh' 		=> $mapehs,
			'mapeh_music' 	=> $mapeh_musics,
			'arts'			=> $artss,
			'pe' 			=> $pes,
			'health' 		=> $healths,
			'lastupdate'  	=> date("Y-m-d H:i:s"),
			'user_id'  		=> $this->session->userdata('current_userid')
		);
		
		if($this->students_model->academics_update($data) > 0)
		{
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated!");
			redirect("students/academics/".$studentid);
		}
		
		
	}
	
	public function updateinfo_submit()
	{
		$studentid = $this->uri->segment(3);
		$existing_student = $this->ensure_student_edit_access($studentid);

		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim');
		$this->form_validation->set_rules('birthdate', 'Date of Birth', 'required|trim');
		$this->form_validation->set_rules('street', 'Street', 'required|trim');
		$this->form_validation->set_rules('barangay', 'barangay', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'trim'); 
		
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			$is_parent = $this->session->userdata('current_usertype') === 'Parent';
			
			$data = array(
				'studentno'  => $is_parent ? $existing_student->studentno : $this->input->post('studentno'),
				'lrn'  => $is_parent ? $existing_student->lrn : $this->input->post('lrn'),
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname'),
				'middlename'  => $this->input->post('middlename'),
				'birthdate'  => $this->input->post('birthdate'),
				'placeofbirth'  => $this->input->post('placeofbirth'),
				//'gradelevel'  => $this->input->post('gradelevel'),
				'gender'  => $this->input->post('gender'),
				'street'  => $this->input->post('street'),
				'barangay'  => $this->input->post('barangay'),
				'houseno'  => $this->input->post('houseno'),
				'city'  => $this->input->post('city'),
				'province'  => $this->input->post('province'),
				'country'  => $this->input->post('country'),
				'lastschool'  => $this->input->post('lastschool'),
				'lastschoolyear'  => $this->input->post('lastschoolyear'),
				'lastschoolgrade'  => $this->input->post('lastschoolgrade'),
				'father_firstname'  => $this->input->post('father_firstname'),
				'father_lastname'  => $this->input->post('father_lastname'),
				'father_middlename'  => $this->input->post('father_middlename'),
				'father_work'  => $this->input->post('father_work'),
				'father_place_work'  => $this->input->post('father_place_work'),
				'father_contact1'  => $this->input->post('father_contact1') ?: '',
				'father_contact2'  => $this->input->post('father_contact2') ?: '',
				'email'  => $this->input->post('email'),
				'mother_firstname'  => $this->input->post('mother_firstname'),
				'mother_lastname'  => $this->input->post('mother_lastname'),
				'mother_work'  => $this->input->post('mother_work'),
				'mother_place_work'  => $this->input->post('mother_place_work'),
				'mother_contact1'  => $this->input->post('mother_contact1') ?: '',
				'mother_contact2'  => $this->input->post('mother_contact2') ?: '',
				'mother_fbmessenger'  => $this->input->post('mother_fbmessenger') ?: '',
				'mother_middlename'  => $this->input->post('mother_middlename'),
				'maidenname'  => $this->input->post('maidenname'),
				'incaseemergency'  => $this->input->post('incaseemergency'),
				'place_employment'  => $this->input->post('place_employment'),
				'work_phone'  => $this->input->post('work_phone'),
				'personal_cell'  => $this->input->post('personal_cell'),
				'homelandline'  => $this->input->post('homelandline'),
				'other_homelandline'  => $this->input->post('other_homelandline'),
				'fbmessenger'  => $this->input->post('fbmessenger'),
				'relationship'  => $this->input->post('relationship'),
				'church_name'  => $this->input->post('church_name'),
				'church_address'  => $this->input->post('church_address'),
				'church_tel'  => $this->input->post('church_tel'),
				'church_pastor'  => $this->input->post('church_pastor'),
				'church_website'  => $this->input->post('church_website'),
				'date_salvation'  => $this->input->post('date_salvation'),
				'date_baptism'  => $this->input->post('date_baptism'),
				//'user_id'  => $this->session->userdata('current_userid'),
				'lastupdate'  => date("Y-m-d H:i:s")
			);
			
			if($this->students_model->updateinfo($data) > 0)
			{
				//message successful	
				$this->session->set_flashdata('message', "Successfully updated student information!");
				redirect("enroll/view_student_info/" . $studentid);
			}
		}
		else
		{
			$this->updateinfo();
		}
	}
	
	public function changestatus()
	{
		$studentid = $this->uri->segment(4);	
		$status = $this->uri->segment(3);	
		if($this->students_model->changestatus($status,$studentid))
		{
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated enrollment status!");
			redirect("students");
		}
	}
	
	public function changestatus_admin()
	{
		$studentid = $this->uri->segment(4);	
		$status = $this->uri->segment(3);	
		if($this->students_model->changestatus($status,$studentid))
		{
			$enroll_id = $this->payments_model->getEnrollId($studentid);
			// CHECK IF Paid First Payment already...
			$qry_firstpay = $this->payments_model->getEnrollPay($enroll_id);
			if($qry_firstpay->num_rows() == 0){
				
				// CREATE ENROLLMENT PAYMENT...
				$payment_enrollment = $this->payments_model->getEnrollPayment($enroll_id);
				$payments_data = array(
					'payment_date' => date("Y-m-d"),
					'payment_total' => $payment_enrollment,
					'payment_note' => 'Enrollment',
					'autogen_payment' => 'yes',
					'student_id' => $studentid,
					'enroll_id' => $enroll_id,
					'userid'  => $this->session->userdata('current_userid'),
					'dateadded'  => date("Y-m-d H:i:s")
				);
				// insert PAYMENT Master
				$payment_id = $this->payments_model->create($payments_data);	
				$details_data = array(
					'payment_id' => $payment_id,
					'type_item' => 'pay_',
					'id_item' => '9992',
					'price_item' => $payment_enrollment,
					'qty_item' => 1
				);
				$this->payments_model->create_payment_details($details_data);
				
			}
			
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated enrollment status!");
			redirect("students");
		}
	}
	
	public function changelevel()
	{
		$studentid = $this->uri->segment(4);	
		$level = $this->uri->segment(3);	
		if($this->students_model->changelevel($level,$studentid))
		{
			//message successful	
			$this->session->set_flashdata('message', "Successfully updated grade level!");
			redirect("students");
		}
	}
	
	public function search_result_oldstudent()
	{
		$txtfirstname = $this->input->post('txtfirstname');
		$txtlastname = $this->input->post('txtlastname');
		$txtmiddlename = $this->input->post('txtmiddlename');
		$query = "select a.*, schoolyearenrolled.status as enrollstatus from students a 
		left join (select status,schoolyear,studentid 
		from enrolled where schoolyear = ".$this->session->userdata('current_schoolyearid').")as schoolyearenrolled 
		on schoolyearenrolled.studentid = a.id 
		where (a.firstname like '%$txtfirstname%' and a.lastname like '%$txtlastname%' and a.middlename like '%$txtmiddlename%') group by a.id";
		$query = $this->db->query( $query );
		if($query->num_rows() > 0)
		{
			echo "<p>Match found (".$query->num_rows().") item/s... Please choose from the result.</p>";
			foreach ($query->result() as $row):
				if(strlen(trim($row->enrollstatus))>0)
				{
					echo "<a href='".site_url("students/enrollold_form1/".$row->id)."' class='btn btn-lg btn-secondary btn-rounded btn-fw disabled' disabled>
					<i class='mdi mdi-check'></i>".$row->firstname." ".$row->lastname."
					<br><code class='text-muted'>Enrolled(<span class='text-danger'>".$row->enrollstatus."</span>)</code></a>";
				}else{
					echo "<a href='".site_url("students/enrollold_form1/".$row->id)."' class='btn btn-lg btn-secondary btn-rounded btn-fw'>
					<i class='mdi mdi-check'></i>".$row->firstname." ".$row->lastname."
					<br><code class='text-muted'>Not yet enrolled</code></a>";
				}
			endforeach;
		}else{
			echo "<p class='text-danger'>NOTE: Make sure you type correctly.  If match not found, please enroll him/her as NEW Student.</p>";
		}
		
	}
	
	public function remove_enroll($id = null){
		
		if($this->students_model->remove_enroll( $id ))
		{
			//message successful	
			$this->session->set_flashdata('message', "Successfully removed!");
			redirect("students");
		}
		
	}
	
	public function docs(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Attachments',
			'template'   =>   'students/docs',
			'profile_pic' => $this->students_model->profile_pic( $studentid ),
			'query' => $this->students_model->search_student_info( $studentid ),
			'query_docs' => $this->files_model->getStudentFiles( $studentid )
		);
		$this->load->view('template', $data);	
		
	}
	
	public function docs_submit( $student_id )
	{
		
		$path_target = './file_upload/'.$student_id;
		if(!is_dir( $path_target )){
			mkdir( $path_target ,0777,TRUE);
		}
		
		$config['upload_path'] = $path_target;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
		$config['max_size'] = 6000;
		
		$this->load->library('upload',$config);
		
		$err=0;
		$withfile=0;
		
		if(!$this->input->post("isuploadedbefore")){
			$data = array( 
				'student_id' => $student_id, 
				'file1' => '', 
				'file2' => '', 
				'file3' => '', 
				'file4' => '', 
				'file5' => '', 
				'file6' => '',
				'file7' => '',
				'file8' => '',
				'dateadded' => date("Y-m-d H:i:s")
			);
		}
		
		// FILE 1
		if( !empty( $_FILES['file1']['name'] ) )
		{	
			if( !$this->upload->do_upload('file1') )
			{				
				$err=1;	
			}else{
				$data['file1'] = str_replace(" ","_",$_FILES['file1']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		// FILE 2
		if( !empty( $_FILES['file2']['name'] ) )
		{	
			if( !$this->upload->do_upload('file2') )
			{				
				$err=1;	
			}else{
				$data['file2'] = str_replace(" ","_",$_FILES['file2']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		// FILE 3
		if( !empty( $_FILES['file3']['name'] ) )
		{	
			if( !$this->upload->do_upload('file3') )
			{				
				$err=1;	
			}else{
				$data['file3'] = str_replace(" ","_",$_FILES['file3']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		// FILE 4
		if( !empty( $_FILES['file4']['name'] ) )
		{	
			if( !$this->upload->do_upload('file4') )
			{				
				$err=1;	
			}else{
				$data['file4'] = str_replace(" ","_",$_FILES['file4']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		// FILE 5
		if( !empty( $_FILES['file5']['name'] ) )
		{	
			if( !$this->upload->do_upload('file5') )
			{				
				$err=1;	
			}else{
				$data['file5'] = str_replace(" ","_",$_FILES['file5']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		// FILE 6
		if( !empty( $_FILES['file6']['name'] ) )
		{	
			if( !$this->upload->do_upload('file6') )
			{				
				$err=1;	
			}else{
				$data['file6'] = str_replace(" ","_",$_FILES['file6']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		// FILE 7
		if( !empty( $_FILES['file7']['name'] ) )
		{	
			if( !$this->upload->do_upload('file7') )
			{				
				$err=1;	
			}else{
				$data['file7'] = str_replace(" ","_",$_FILES['file7']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		
		// FILE 8
		if( !empty( $_FILES['file8']['name'] ) )
		{	
			if( !$this->upload->do_upload('file8') )
			{				
				$err=1;	
			}else{
				$data['file8'] = str_replace(" ","_",$_FILES['file8']['name']);
				$withfile=1;
				// update if already uploaded before
				if($this->input->post("isuploadedbefore")){
					$this->files_model->update_file( $data,$student_id );
				}
			}
		}
		
		if($err==1){
			
			//message error
			$this->session->set_flashdata('message', $this->upload->display_errors());
			
		}else{
			
			if($withfile){
				if(!$this->input->post("isuploadedbefore")){
					// INSERT NEW
					if($this->files_model->insert( $data )){
						//message successful	
						$this->session->set_flashdata('message', "Successfully uploaded!");
					}
				}else{
					// UPDATE THE EXISTING TABLE
					$this->session->set_flashdata('message', "Successfully uploaded!");
				}
			}else{
				
				//message no file selected
				$this->session->set_flashdata('message', "You have no file selected.");
				
			}
			
		}
		redirect("students/docs/".$student_id);
		
	}
	
	public function interview(){
		
		$studentid = $this->uri->segment(3);
		$enroll_id = $this->payments_model->getEnrollId($studentid);
		
		$data = array(
				'title'     =>   'STUDENTS // Admin Interview',
				'template'   =>   'students/interview_noass',
				'profile_pic' => $this->students_model->profile_pic( $studentid ),
				'query' => $this->students_model->search_student_info( $studentid )
			);
		
		//echo $this->payments_model->getEnrollPayment($enroll_id)
		$qry = $this->payments_model->getEnrollPaymentcheck($enroll_id);
		if($qry->num_rows() > 0){
			$data['template'] = 'students/interview';
		}
		
		$this->load->view('template', $data);	
		
	}
	
	public function interview_schedule(){

	$studentid = $this->input->post("studentid");
		$sdate = $this->input->post("ddate");
		$stime = $this->input->post("ttime");
		$slot_duration = $this->input->post("slot_duration");
		$schoolyear = $this->session->userdata('current_schoolyearid');
		if (!$schoolyear) {
			$schoolyear = date('Y');
		}

		// Deactivate any existing active schedule for this student (preserve history)
		$this->db->where('studentid', $studentid);
		$this->db->where('schoolyear', $schoolyear);
		$this->db->where('status', 1);
		$this->db->update('interviewsched', array('status' => 0));

		$data = array(
			'studentid'		=> $studentid,
			'schoolyear'	=> $schoolyear,
			'interviewdate'	=> $sdate,
			'interviewtime' => $stime,
			'slot_duration'	=> $slot_duration ? (int)$slot_duration : 30,
			'submitted' 	=> date("Y-m-d h:i:s")
		);

		$result = $this->register_model->interview_schedule($data);
		echo json_encode(array('success' => $result == 1));

	}
    
    public function interview_schedule_update(){

		$studentid = $this->input->post("studentid");
		$sdate = $this->input->post("ddate");
		$stime = $this->input->post("ttime");
		$slot_duration = $this->input->post("slot_duration");
		$schoolyear = $this->session->userdata('current_schoolyearid');
		if (!$schoolyear) {
			$schoolyear = date('Y');
		}

		$data = array(
			'interviewdate'	=> $sdate,
			'interviewtime' => $stime
		);
		// Only update duration if explicitly provided
		if (!empty($slot_duration)) {
			$data['slot_duration'] = (int)$slot_duration;
		}

		$result = $this->register_model->interview_schedule_update($data,$studentid,$schoolyear);
		echo json_encode(array('success' => $result == 1));

	}
	
	public function get_interview_schedule(){

		$studentid = $this->input->post("studentid");
		$schoolyear = $this->session->userdata('current_schoolyearid');

		echo $this->register_model->get_interview_schedule($studentid,$schoolyear);

	}

	/**
	 * AJAX endpoint to get available slots for a date
	 * Returns JSON: {success: true, slots: [{time, label, available, capacity, booked, is_full}]}
	 */
	public function ajax_get_available_slots() {
		$date = $this->input->post('date');
		$schoolyear = $this->session->userdata('current_schoolyearid');

		if(empty($date)) {
			echo json_encode(array('success' => false, 'message' => 'Date is required'));
			return;
		}

		$slots = $this->register_model->get_available_timeslots($date, $schoolyear);
		echo json_encode(array('success' => true, 'slots' => $slots));
	}

	/**
	 * AJAX endpoint to check if a specific time slot is available
	 * Considers interview duration for overlap detection
	 */
	public function ajax_check_slot() {
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$slot_duration = $this->input->post('slot_duration') ? (int)$this->input->post('slot_duration') : 30;
		$studentid = $this->input->post('studentid'); // exclude self when updating
		$schoolyear = $this->session->userdata('current_schoolyearid');

		if(empty($date) || empty($time)) {
			echo json_encode(array('success' => false, 'message' => 'Date and time required'));
			return;
		}

		// Compute requested time window
		$start = $date . ' ' . $time;
		$end_ts = strtotime($start) + ($slot_duration * 60);
		$end = date('Y-m-d H:i:s', $end_ts);

		// Check for any overlapping bookings
		$sql = "SELECT COUNT(*) as count FROM interviewsched
				WHERE schoolyear = ?
				AND interviewdate = ?
				AND status = 1
				AND (
					STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s') < ?
					AND DATE_ADD(STR_TO_DATE(CONCAT(interviewdate,' ',interviewtime), '%Y-%m-%d %H:%i:%s'), INTERVAL slot_duration MINUTE) > ?
				)";

		$params = array($schoolyear, $date, $end, $start);
		if(!empty($studentid)) {
			$sql .= " AND studentid != ?";
			$params[] = $studentid;
		}

		$qry = $this->db->query($sql, $params);
		$conflicts = $qry->num_rows() > 0 ? (int)$qry->row()->count : 0;

		$available = ($conflicts == 0);

		echo json_encode(array(
			'success' => true,
			'available' => $available,
			'conflicts' => $conflicts,
			'duration' => $slot_duration
		));
	}

	
	function interview_submit()
	{

		$this->form_validation->set_rules('interview[]', 'Options', 'required');
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');

		$interviews = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

		if($this->form_validation->run())
		{

			foreach($this->input->post('interview') as $interview){
				$interviews[$interview-1] = 1;
			}

			$intval = "";
			foreach($interviews as $key => $int){
				$intval .= $key<19?$int.",":$int;
			}
			$id = $this->uri->segment(3);
			$this->students_model->update_interview($intval,$id);

		}else{

		}

		$this->session->set_flashdata('message', "Successfully updated!");
		redirect("students/interview/".$this->uri->segment(3));

	}

	/**
	 * Remove interview schedule for a student
	 */
	public function remove_interview_schedule($studentid) {
		$schoolyear = $this->session->userdata('current_schoolyearid');
		// Soft delete: set status = 0 instead of hard delete
		$this->db->where('studentid', $studentid);
		$this->db->where('schoolyear', $schoolyear);
		$this->db->where('status', 1);
		$this->db->update('interviewsched', array('status' => 0));

		$this->session->set_flashdata('message', "Interview schedule removed!");
		redirect("students/interview/".$studentid);
	}

}

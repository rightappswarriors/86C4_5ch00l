<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', "You need to be logged in to access the page.");
			redirect("login");
		}
		$this->load->model('students_model');
		$this->load->model('payments_model');
		$this->load->model('files_model');

	}
	
	public function index()
	{
		$data = array(
			'title'     =>   'STUDENTS',
			'template'   =>   'students/list',
			'query' => $this->students_model->students_list()
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
		$this->form_validation->set_rules('street', 'Street', 'required|trim');
		$this->form_validation->set_rules('barangay', 'Barangay', 'required|trim');
		$this->form_validation->set_rules('incaseemergency', 'Emergency Contact', 'required|trim');
		$this->form_validation->set_rules('personal_cell', 'Emergency Cell', 'required|trim');
		//$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		
		$this->form_validation->set_error_delimiters('<div class="text-danger" style="margin-bottom:10px;">', '</div>');
		
		if($this->form_validation->run())
		{
			
			$data = array(
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname'),
				'middlename'  => $this->input->post('middlename'),
				'birthdate'  => $this->input->post('birthdate'),
				'gender'  => $this->input->post('gender'),
				'street'  => $this->input->post('street'),
				'barangay'  => $this->input->post('street'),
				'houseno'  => $this->input->post('houseno'),
				'city'  => $this->input->post('city'),
				'province'  => $this->input->post('province'),
				'country'  => $this->input->post('country'),
				'father_firstname'  => $this->input->post('father_firstname'),
				'father_lastname'  => $this->input->post('father_lastname'),
				'father_middlename'  => $this->input->post('father_middlename'),
				'father_work'  => $this->input->post('father_work'),
				'father_place_work'  => $this->input->post('father_place_work'),
				'father_contact1'  => $this->input->post('father_contact1'),
				'father_contact2'  => $this->input->post('father_contact2'),
				'email'  => $this->input->post('email'),
				'mother_firstname'  => $this->input->post('mother_firstname'),
				'mother_lastname'  => $this->input->post('mother_lastname'),
				'mother_work'  => $this->input->post('mother_work'),
				'mother_place_work'  => $this->input->post('mother_place_work'),
				'mother_contact1'  => $this->input->post('mother_contact1'),
				'mother_contact2'  => $this->input->post('mother_contact2'),
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
				'user_id'  => $this->session->userdata('current_userid'),
				'dateadded'  => date("Y-m-d H:i:s")
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
	
	public function enrollnew_success($id)
	{
		$data = array(
		'title'     =>   'STUDENTS // Enroll Student',
		'template'   =>   'parent/enrollnew_success',
		'student_id'   =>   $id,
		);
		$this->load->view('template', $data);	
	}
	
	public function updateinfo(){
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Update Student Information',
			'template'   =>   'students/updateinfo',
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
			'query' => $this->students_model->search_student_info( $studentid ),
			'query_ass' => $this->students_model->assessment_check( $enroll_id ),
			'default_ass' => $this->payments_model->default_assessment()
		);
		
		$this->load->view('template', $data);	
	}
	
	public function details(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Student Information',
			'template'   =>   'students/details',
			'query' => $this->students_model->search_student_info($studentid)
		);
		$this->load->view('template', $data);		
	}
	
	public function payments(){
		
		$studentid = $this->uri->segment(3);
		$data = array(
			'title'     =>   'STUDENTS // Payments',
			'template'   =>   'students/payments',
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
		$math = $this->input->post("math_begin").",".$this->input->post("math_end").",".$this->input->post("math_gaps");
		$english = $this->input->post("english_begin").",".$this->input->post("english_end").",".$this->input->post("english_gaps");
		$science = $this->input->post("science_begin").",".$this->input->post("science_end").",".$this->input->post("science_gaps");
		$socstudies = $this->input->post("socstudies_begin").",".$this->input->post("socstudies_end").",".$this->input->post("socstudies_gaps");
		$wordbuilding = $this->input->post("wordbuilding_begin").",".$this->input->post("wordbuilding_end").",".$this->input->post("wordbuilding_gaps");
		$literature = $this->input->post("literature_begin").",".$this->input->post("literature_end").",".$this->input->post("literature_gaps");
		$filipino = $this->input->post("filipino_begin").",".$this->input->post("filipino_end").",".$this->input->post("filipino_gaps");
		$ap = $this->input->post("ap_begin").",".$this->input->post("ap_end").",".$this->input->post("ap_gaps");
		
		$data = array(
			'incidentals' => $indntals_val,
			'miscellaneous' => $msclns_val,
			'tuition' => $this->input->post('tuition'),
			'registration' => $this->input->post('registration'),
			'payment' => $this->input->post('paymentenroll'),
			'asstotal' => $this->input->post('asstotal_hidden'),
			'math' => $math,
			'english' => $english,
			'science' => $science,
			'socstudies' => $socstudies,
			'wordbuilding' => $wordbuilding,
			'literature' => $literature,
			'filipino' => $filipino,
			'ap' => $ap,
			'lastupdate'  => date("Y-m-d H:i:s")
		);
		
		$as_id = $this->input->post("as_id");
		if($as_id>0){
			$this->students_model->assessment_update($as_id,$data);
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
		$data = array(
			'title'     =>   'STUDENTS // Academics',
			'template'   =>   'students/academics',
			'query' => $this->students_model->search_student_info($studentid)
		);
		$this->load->view('template', $data);	
	}
	
	public function updateinfo_submit()
	{
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
			
			$data = array(
				'studentno'  => $this->input->post('studentno'),
				'lrn'  => $this->input->post('lrn'),
				'lastname'  => $this->input->post('lastname'),
				'firstname'  => $this->input->post('firstname'),
				'middlename'  => $this->input->post('middlename'),
				'birthdate'  => $this->input->post('birthdate'),
				//'gradelevel'  => $this->input->post('gradelevel'),
				'gender'  => $this->input->post('gender'),
				'street'  => $this->input->post('street'),
				'barangay'  => $this->input->post('street'),
				'houseno'  => $this->input->post('houseno'),
				'city'  => $this->input->post('city'),
				'province'  => $this->input->post('province'),
				'country'  => $this->input->post('country'),
				'father_firstname'  => $this->input->post('father_firstname'),
				'father_lastname'  => $this->input->post('father_lastname'),
				'father_middlename'  => $this->input->post('father_middlename'),
				'father_work'  => $this->input->post('father_work'),
				'father_place_work'  => $this->input->post('father_place_work'),
				'father_contact1'  => $this->input->post('father_contact1'),
				'father_contact2'  => $this->input->post('father_contact2'),
				'email'  => $this->input->post('email'),
				'mother_firstname'  => $this->input->post('mother_firstname'),
				'mother_lastname'  => $this->input->post('mother_lastname'),
				'mother_work'  => $this->input->post('mother_work'),
				'mother_place_work'  => $this->input->post('mother_place_work'),
				'mother_contact1'  => $this->input->post('mother_contact1'),
				'mother_contact2'  => $this->input->post('mother_contact2'),
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
				redirect("students");
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
		$data = array(
			'title'     =>   'STUDENTS // Admin Interview',
			'template'   =>   'students/interview',
			'query' => $this->students_model->search_student_info( $studentid )
		);
		$this->load->view('template', $data);	
		
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
	
}

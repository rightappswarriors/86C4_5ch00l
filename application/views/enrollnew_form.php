
<style>
/* ── Enrollment Form UI - Based on Reference Image ── */
.enroll-main-container {
    max-width: 100%;
    padding: 20px;
}

.enroll-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    background: #fff;
}

.enroll-header {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #fff;
    text-align: center;
    padding: 1.5rem;
}

.enroll-header h2 {
    margin: 0;
    font-weight: 700;
    font-size: 1.75rem;
    letter-spacing: 1px;
}

/* Blue Section Headers */
.enroll-section {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-radius: 10px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    border-left: 4px solid #2563eb;
}

.enroll-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e40af;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.enroll-section-title .mdi {
    font-size: 1.25rem;
}

/* Row Gutter Spacing - Fix for input alignment */
.enroll-form .row {
    margin-left: -10px;
    margin-right: -10px;
}

.enroll-form .row > div {
    padding-left: 10px;
    padding-right: 10px;
}

/* Form Controls */
.enroll-form .form-group {
    margin-bottom: 1rem;
}

.enroll-form .form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    margin-bottom: 0.35rem;
    display: block;
}

.enroll-form .form-control {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    transition: all 0.2s ease;
    font-size: 0.9rem;
    padding: 0.65rem 0.9rem;
    height: auto;
    background: #fff;
    width: 100%;
}

.enroll-form .form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    outline: none;
}

/* Radio Buttons */
.enroll-form .radio-group {
    display: flex;
    gap: 1.5rem;
    padding-top: 0.3rem;
}

.enroll-form .radio-label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-weight: 500;
    color: #4b5563;
    cursor: pointer;
}

.enroll-form .radio-label input[type="radio"] {
    width: 18px;
    height: 18px;
    accent-color: #2563eb;
}

/* Select Dropdown Styling */
.enroll-form select.form-control {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 12px;
    padding-right: 2.5rem;
}

.photo-placeholder {
    width: 150px;
    height: 150px;
    margin: 0 auto 1rem;
    background: #e5e7eb;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #6b7280;
}

.photo-placeholder .mdi {
    font-size: 3rem;
    margin-bottom: 0.25rem;
}

.photo-placeholder span {
    font-size: 0.8rem;
    font-weight: 500;
}

/* Buttons */
.btn-enroll {
    padding: 0.75rem 3rem;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    border-radius: 8px;
    transition: all 0.2s ease;
    border: none;
}

.btn-next {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
}

.btn-next:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-submit:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Note Box */
.enroll-note-box {
    background: #fef3c7;
    border: 1px solid #f59e0b;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.enroll-note-box h4 {
    margin: 0 0 0.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: #92400e;
}

.enroll-note-box .form-check-label {
    font-weight: 500;
    color: #4b5563;
}

/* Reminder */
.enroll-reminder {
    background: #fee2e2;
    border: 1px solid #fca5a5;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-top: 0.75rem;
    font-size: 0.85rem;
    color: #991b1b;
    font-weight: 500;
}

/* Submit Area */
.enroll-submit-area {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e5e7eb;
    text-align: center;
}

/* Instruction Box */
.enroll-instruction {
    background: #dbeafe;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    color: #1e40af;
    margin-bottom: 1.5rem;
    border: 1px solid #93c5fd;
}

.enroll-instruction .mdi {
    margin-right: 0.35rem;
}

/* Responsive */
@media (max-width: 768px) {
    .enroll-form .row {
        margin-left: -5px;
        margin-right: -5px;
    }
    
    .enroll-form .row > div {
        padding-left: 5px;
        padding-right: 5px;
        margin-bottom: 0.5rem;
    }
    
    .enroll-form .form-control {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
    
    .enroll-form .radio-group {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnsubmit").attr("disabled", !this.checked);
	});
	
	$("#frmenroll").submit(function(){
		$("#btnsubmit").attr("disabled",true);
		return true;
	});
	
});
</script>

<div class="col-lg-12 grid-margin" style="display:none;">
	<div class="card">
		<div class="card-body">
			<p>This form means, you are about to enroll a <code>new, fresh or transferee</code> student into our School System.  Make sure you have all the information requires of this student.
			If you are enrolling an old or returnee student, please click <a href="<?=site_url("students/enrollold_form")?>" class="btn btn-warning">here</a>
			</p>
		</div>
	</div>
</div>

<div class="col-lg-12 grid-margin enroll-main-container">

	<div class="card enroll-card">
	  <div class="card-body p-0">
	 
		<div class="enroll-header">
			<h2><i class="mdi mdi-school"></i> ENROLLMENT FORM</h2>
		</div>
		
		<div style="padding: 1.5rem 2rem;">
		
		<?=validation_errors()?>
		
		<form class="enroll-form" id="frmenroll" action="<?=site_url("students/enrollnew_submit")?>" method="POST">
		  
		  <div class="enroll-instruction">
			<i class="mdi mdi-information-outline"></i> Please fill out all the fields. If not applicable, enter <strong>N/A</strong>.
		  </div>
		  
		  <!-- Student Details Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> STUDENT DETAILS</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">New / Old</label>
					<div class="radio-group">
						<label class="radio-label">
							<input name="newold" value="new" type="radio" <?=set_radio('newold', 'new', TRUE)?>> 
							New Student
						</label>
						<label class="radio-label">
							<input name="newold" value="old" type="radio" <?=set_radio('newold', 'old')?>> 
							Old Student
						</label>
					</div>
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="firstname" value="<?=set_value('firstname')?>" class="form-control" placeholder="Enter First Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Middle Name</label>
					<input type="text" name="middlename" value="<?=set_value('middlename')?>" class="form-control" placeholder="Enter Middle Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="lastname" value="<?=set_value('lastname')?>" class="form-control" placeholder="Enter Last Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Date of Birth</label>
					<input type="date" max="<?=date("Y-m-d")?>" class="form-control" name="birthdate" value="<?=set_value('birthdate')?>" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Birth</label>
					<input type="text" name="placeofbirth" value="<?=set_value('placeofbirth')?>" class="form-control" placeholder="Enter Place of Birth" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Gender</label>
					<?php
						$options = array('Male' => 'Male', 'Female' => 'Female');
						$batch = set_value('gender');
						echo form_dropdown('gender', $options, $batch,' class="form-control"');
					?>
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Grade Level to Enter</label>
					<?php
						$options = array(
							'RR' => 'RR-K1', 
							'ABCs' => 'ABCs-K2',
							'Level-1' => 'Level-1',
							'Level-2' => 'Level-2',
							'Level-3' => 'Level-3',
							'Level-4' => 'Level-4',
							'Level-5' => 'Level-5',
							'Level-6' => 'Level-6',
							'Level-7' => 'Level-7',
							'Level-8' => 'Level-8',
							'Level-9' => 'Level-9',
							'Level-10' => 'Level-10',
							'Grade-11' => 'Grade-11',
							'Grade-12' => 'Grade-12'
						);
						$batch = set_value('gradelevel');
						echo form_dropdown('gradelevel', $options, $batch,' class="form-control"');
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Strand (For Senior High)</label>
					<?php
						$options = array('N/A' => 'N/A','ABM' => 'ABM', 'GAS' => 'GAS','HUMMS' => 'HUMMS', 'STEM' => 'STEM');
						$batch = set_value('strand','N/A');
						echo form_dropdown('strand', $options, $batch,' class="form-control"');
					?>
				</div>
			</div>
		  </div>
		  
		  <!-- For Transferees Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-swap-horizontal"></i> FOR TRANSFEREES</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">School Name</label>
					<input type="text" name="lastschool" value="<?=set_value('lastschool')?>" class="form-control" placeholder="Enter School Name" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label">School Year</label>
					<input type="text" name="lastschoolyear" value="<?=set_value('lastschoolyear')?>" class="form-control" placeholder="Enter Year" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label">Grade Level</label>
					<input type="text" name="lastschoolgrade" value="<?=set_value('lastschoolgrade')?>" class="form-control" placeholder="Enter Grade" />
				</div>
			</div>
		  </div>
		  
		  <!-- Complete Home Address Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-home-map-marker"></i> COMPLETE HOME ADDRESS</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">House No.</label>
					<input type="text" name="houseno" value="<?=set_value('houseno')?>" class="form-control" placeholder="Enter House No." />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Street</label>
					<input type="text" name="street" value="<?=set_value('street')?>" class="form-control" placeholder="Enter Street" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Barangay</label>
					<input type="text" name="barangay" value="<?=set_value('barangay')?>" class="form-control" placeholder="Enter Barangay" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">City</label>
					<input type="text" name="city" value="<?=set_value('city')?>" class="form-control" placeholder="Enter City" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Province</label>
					<input type="text" name="province" value="<?=set_value('province')?>" class="form-control" placeholder="Enter Province" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Country</label>
					<input type="text" name="country" value="<?=set_value('country','Philippines')?>" class="form-control" placeholder="Enter Country" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Home Landline</label>
					<input type="text" name="homelandline" value="<?=set_value('homelandline')?>" class="form-control" placeholder="Enter Landline" />
				</div>
			</div>
		  </div>
		  
		  <!-- Father's Information Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> FATHER'S INFORMATION</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="father_firstname" value="<?=set_value('father_firstname')?>" class="form-control" placeholder="Enter First Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Middle Name</label>
					<input type="text" name="father_middlename" value="<?=set_value('father_middlename')?>" class="form-control" placeholder="Enter Middle Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="father_lastname" value="<?=set_value('father_lastname')?>" class="form-control" placeholder="Enter Last Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Occupation</label>
					<input type="text" name="father_work" value="<?=set_value('father_work')?>" class="form-control" placeholder="Enter Occupation" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Employment</label>
					<input type="text" name="father_place_work" value="<?=set_value('father_place_work')?>" class="form-control" placeholder="Enter Place of Work" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Contact Number</label>
					<input type="text" name="father_contact2" value="<?=set_value('father_contact2')?>" class="form-control" placeholder="Enter Contact Number" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Email</label>
					<input type="text" name="father_email" value="<?=set_value('father_email')?>" class="form-control" placeholder="Enter Email Address" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">FB Messenger</label>
					<input type="text" name="father_fbmessenger" value="<?=set_value('father_fbmessenger')?>" class="form-control" placeholder="Enter FB Messenger Name" />
				</div>
			</div>
		  </div>
		  
		  <!-- Mother's Information Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> MOTHER'S INFORMATION</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">First Name</label>
					<input type="text" name="mother_firstname" value="<?=set_value('mother_firstname')?>" class="form-control" placeholder="Enter First Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Middle Name</label>
					<input type="text" name="mother_middlename" value="<?=set_value('mother_middlename')?>" class="form-control" placeholder="Enter Middle Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Last Name</label>
					<input type="text" name="mother_lastname" value="<?=set_value('mother_lastname')?>" class="form-control" placeholder="Enter Last Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Maiden Name</label>
					<input type="text" name="maidenname" value="<?=set_value('maidenname')?>" class="form-control" placeholder="Enter Maiden Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Occupation</label>
					<input type="text" name="mother_work" value="<?=set_value('mother_work')?>" class="form-control" placeholder="Enter Occupation" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Contact Number</label>
					<input type="text" name="mother_contact2" value="<?=set_value('mother_contact2')?>" class="form-control" placeholder="Enter Contact Number" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Employment</label>
					<input type="text" name="mother_place_work" value="<?=set_value('mother_place_work')?>" class="form-control" placeholder="Enter Place of Work" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Email</label>
					<input type="text" name="email" value="<?=set_value('email')?>" class="form-control" placeholder="Enter Email Address" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">FB Messenger</label>
					<input type="text" name="fbmessenger" value="<?=set_value('fbmessenger')?>" class="form-control" placeholder="Enter FB Messenger Name" />
				</div>
			</div>
		  </div>
		  
		  <!-- Emergency Contact Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-phone-in-talk"></i> EMERGENCY CONTACT (Other than Parent)</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Name</label>
					<input type="text" name="incaseemergency" value="<?=set_value('incaseemergency')?>" class="form-control" placeholder="Enter Contact Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Relationship</label>
					<?php
						$options1 = array(
							'Lolo' => 'Lolo', 'Lola' => 'Lola','Aunt' => 'Aunt', 'Uncle' => 'Uncle',
							'Kuya' => 'Kuya', 'Ate' => 'Ate','Yaya' => 'Yaya', 'Guardian' => 'Guardian'
						);
						$batch1 = set_value('relationship');
						echo form_dropdown('relationship', $options1, $batch1,' class="form-control"');
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Contact Number</label>
					<input type="text" name="personal_cell" value="<?=set_value('personal_cell')?>" class="form-control" placeholder="Enter Contact Number" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Place of Employment</label>
					<input type="text" name="place_employment" value="<?=set_value('place_employment')?>" class="form-control" placeholder="Enter Place of Employment" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Home Landline</label>
					<input type="text" name="other_homelandline" value="<?=set_value('other_homelandline')?>" class="form-control" placeholder="Enter Home Landline" />
				</div>
			</div>
		  </div>
		  
		  <!-- Church Information Section -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-church"></i> CHURCH INFORMATION</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Church Name</label>
					<input type="text" name="church_name" value="<?=set_value('church_name')?>" class="form-control" placeholder="Enter Church Name" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Address</label>
					<input type="text" name="church_address" value="<?=set_value('church_address')?>" class="form-control" placeholder="Enter Church Address" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Pastor's Name</label>
					<input type="text" name="church_pastor" value="<?=set_value('church_pastor')?>" class="form-control" placeholder="Enter Pastor's Name" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Telephone No.</label>
					<input type="text" name="church_tel" value="<?=set_value('church_tel')?>" class="form-control" placeholder="Enter Telephone No." />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Website</label>
					<input type="text" name="church_website" value="<?=set_value('church_website')?>" class="form-control" placeholder="Enter Website" />
				</div>
			</div>
		  </div>
		  
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Date of Salvation</label>
					<input type="text" name="date_salvation" value="<?=set_value('date_salvation')?>" class="form-control" placeholder="Enter Date of Salvation" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Date of Baptism</label>
					<input type="text" name="date_baptism" value="<?=set_value('date_baptism')?>" class="form-control" placeholder="Enter Date of Baptism" />
				</div>
			</div>
		  </div>
		  
		  <!-- Note Box -->
		  <div class="enroll-note-box">
			<h4><i class="mdi mdi-alert-circle-outline"></i> NOTE: Please make sure all the information you entered above is true and correct.</h4>
			<div class="form-check">
			  <label class="form-check-label">
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> I have reviewed and confirmed that the above information is true and correct.
			  </label>
			</div>
		  </div>
		  
		  <div class="enroll-reminder">
			<i class="mdi mdi-clock-outline"></i> Please check your student assessment section page after 24 hours. You cannot finalize this enrollment process unless you agree with the assessment.
		  </div>
		  
		  <div class="enroll-submit-area">
			<input type="submit" class="btn btn-enroll btn-submit" id="btnsubmit" name="submit" value="ENROLL" disabled/>
		  </div>
		  

		</form>
		
		</div>
	  </div>
	</div>          

</div>

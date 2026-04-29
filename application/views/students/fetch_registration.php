<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">
<style>
  .enrollment-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 20px;
    font-family: Arial, sans-serif;
    flex-wrap: wrap;
    margin-bottom: 20px;
    background: #f8f9fa;
    border-radius: 8px;
  }

  .enrollment-breadcrumb li {
    list-style: none;
    display: flex;
    align-items: center;
  }

  .enrollment-breadcrumb .step {
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
  }

  .enrollment-breadcrumb .step.current {
    background: #1976d2;
    color: #ffffff;
  }

  .enrollment-breadcrumb .step.passed {
    background: #28a745;
    color: #ffffff;
  }

  .enrollment-breadcrumb .step.pending {
    background: #e9ecef;
    color: #6c757d;
  }

  .enrollment-breadcrumb .step-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    font-size: 12px;
    margin-right: 6px;
  }

  .enrollment-breadcrumb .step.passed .step-number {
    background: rgba(255,255,255,0.5);
  }

  .enrollment-breadcrumb .arrow {
    color: #adb5bd;
    font-size: 14px;
    margin: 0 2px;
  }

  .enrollment-breadcrumb .step:hover {
    opacity: 0.9;
  }

  .content-wrapper {
    margin-top: 0;
    background: #f5f5f5;
    min-height: 100vh;
    padding: 20px 0;
  }

  .enroll-card {
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
  }
</style>
<ol class="enrollment-breadcrumb">
	<li><a href="<?=site_url('students/enroll_readhandbook')?>" class="step passed"><span class="step-number"><i class="mdi mdi-check"></i></span>Read the Student Handbook</a></li>
	<li><span class="arrow">›</span></li>
	<li><a href="<?=site_url('students/enrollnew_form')?>" class="step passed"><span class="step-number"><i class="mdi mdi-check"></i></span>Fill up Enrollment Application Form</a></li>
	<li><span class="arrow">›</span></li>
	<li><span class="step current"><span class="step-number">3</span>Fetcher ID Application</span></li>
	<li><span class="arrow">›</span></li>
	<li><span class="step pending"><span class="step-number">4</span>Print/Save Enrollment Application Form / Save QR Code</span></li>
</ol>

<div class="col-lg-12 grid-margin enroll-main-container">
	<div class="card enroll-card">
	  <div class="card-body p-0"> 
		<div class="enroll-header">
			<h2><i class="mdi mdi-id-card"></i> FETCHER'S ID APPLICATION</h2>
		</div>
		
		<div style="padding: 1.5rem 2rem;">
		
	<form class="enroll-form" id="frmfetcher" action="<?=site_url("students/fetcher_id_submit")?>" method="POST" enctype="multipart/form-data">
	  
	  <input type="hidden" name="student_id" value="<?=$student_id?>">
	  
	  <div class="enroll-instruction">
		<i class="mdi mdi-information-outline"></i> Please fill out all fields. If not applicable, enter <strong>N/A</strong>.
		  
		  <!-- ========================================== -->
		  <!-- FETCHER INFORMATION SECTION (FIXED 2 SLOTS) -->
		  <!-- ========================================== -->
		  <div class="enroll-section">
			<h5 class="enroll-section-title"><i class="mdi mdi-account-heart"></i> AUTHORIZED FETCHER INFORMATION</h5>
		  </div>
		  
		  <div id="fetcher-sections">
			
		  <!-- FETCHER 1 -->
		  <div class="fetcher-section-wrapper" style="border: 1px dashed #ccc; padding: 15px; border-radius: 5px; margin-bottom: 15px; background: #f9f9f9;">
		  	<h6 style="color: #1e40af; font-weight: bold; border-bottom: 1px solid #1e40af; padding-bottom: 5px; margin-bottom: 10px;">FETCHER 1</h6>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">First Name <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[0][firstname]" class="form-control" placeholder="Enter First Name" required>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Middle Name</label>
		  				<input type="text" name="fetcher[0][middlename]" class="form-control" placeholder="Enter Middle Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Last Name <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[0][lastname]" class="form-control" placeholder="Enter Last Name" required>
		  			</div>
		  		</div>
		  	</div>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Relationship to Student <span style="color:red;">*</span></label>
		  				<select name="fetcher[0][relationship]" class="form-control" required>
		  					<option value="">-- Select Relationship --</option>
		  					<option value="Father">Father</option>
		  					<option value="Mother">Mother</option>
		  					<option value="Guardian">Guardian</option>
		  					<option value="Grandfather">Grandfather</option>
		  					<option value="Grandmother">Grandmother</option>
		  					<option value="Uncle">Uncle</option>
		  					<option value="Aunt">Aunt</option>
		  					<option value="Brother">Brother</option>
		  					<option value="Sister">Sister</option>
		  					<option value="Nanny">Nanny/Yaya</option>
		  					<option value="Driver">Driver</option>
		  					<option value="Other">Other</option>
		  				</select>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Contact Number <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[0][contact_number]" class="form-control" placeholder="09xxxxxxxxx" required>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Photo</label>
		  				<input type="file" name="fetcher_1_photo" class="form-control" accept="image/*">
		  				<small class="text-muted">Upload a clear photo (JPG, PNG)</small>
		  			</div>
		  		</div>
		  	</div>
		  </div>
		  
		  <!-- FETCHER 2 (HIDDEN BY DEFAULT) -->
		  <div class="fetcher-section-wrapper" id="fetcher-2-section" style="border: 1px dashed #ccc; padding: 15px; border-radius: 5px; margin-bottom: 15px; background: #f9f9f9; display:none;">
		  	<h6 style="color: #1e40af; font-weight: bold; border-bottom: 1px solid #1e40af; padding-bottom: 5px; margin-bottom: 10px;">FETCHER 2</h6>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">First Name</label>
		  				<input type="text" name="fetcher[1][firstname]" class="form-control" placeholder="Enter First Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Middle Name</label>
		  				<input type="text" name="fetcher[1][middlename]" class="form-control" placeholder="Enter Middle Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Last Name</label>
		  				<input type="text" name="fetcher[1][lastname]" class="form-control" placeholder="Enter Last Name">
		  			</div>
		  		</div>
		  	</div>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Relationship to Student</label>
		  				<select name="fetcher[1][relationship]" class="form-control">
		  					<option value="">-- Select Relationship --</option>
		  					<option value="Father">Father</option>
		  					<option value="Mother">Mother</option>
		  					<option value="Guardian">Guardian</option>
		  					<option value="Grandfather">Grandfather</option>
		  					<option value="Grandmother">Grandmother</option>
		  					<option value="Uncle">Uncle</option>
		  					<option value="Aunt">Aunt</option>
		  					<option value="Brother">Brother</option>
		  					<option value="Sister">Sister</option>
		  					<option value="Nanny">Nanny/Yaya</option>
		  					<option value="Driver">Driver</option>
		  					<option value="Other">Other</option>
		  				</select>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Contact Number</label>
		  				<input type="text" name="fetcher[1][contact_number]" class="form-control" placeholder="09xxxxxxxxx">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Photo</label>
		  				<input type="file" name="fetcher_2_photo" class="form-control" accept="image/*">
		  				<small class="text-muted">Upload a clear photo (JPG, PNG)</small>
		  			</div>
		  		</div>
		  	</div>
		  </div>
		  
		  <!-- FETCHER 3 (HIDDEN BY DEFAULT) -->
		  <div class="fetcher-section-wrapper" id="fetcher-3-section" style="border: 1px dashed #ccc; padding: 15px; border-radius: 5px; margin-bottom: 15px; background: #f9f9f9; display:none;">
		  	<h6 style="color: #28a745; font-weight: bold; border-bottom: 1px solid #28a745; padding-bottom: 5px; margin-bottom: 10px;">FETCHER 3</h6>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">First Name <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[2][firstname]" class="form-control" placeholder="Enter First Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Middle Name</label>
		  				<input type="text" name="fetcher[2][middlename]" class="form-control" placeholder="Enter Middle Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Last Name <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[2][lastname]" class="form-control" placeholder="Enter Last Name">
		  			</div>
		  		</div>
		  	</div>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Relationship to Student <span style="color:red;">*</span></label>
		  				<select name="fetcher[2][relationship]" class="form-control">
		  					<option value="">-- Select Relationship --</option>
		  					<option value="Father">Father</option>
		  					<option value="Mother">Mother</option>
		  					<option value="Guardian">Guardian</option>
		  					<option value="Grandfather">Grandfather</option>
		  					<option value="Grandmother">Grandmother</option>
		  					<option value="Uncle">Uncle</option>
		  					<option value="Aunt">Aunt</option>
		  					<option value="Brother">Brother</option>
		  					<option value="Sister">Sister</option>
		  					<option value="Nanny">Nanny/Yaya</option>
		  					<option value="Driver">Driver</option>
		  					<option value="Other">Other</option>
		  				</select>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Contact Number <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[2][contact_number]" class="form-control" placeholder="09xxxxxxxxx">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Photo</label>
		  				<input type="file" name="fetcher_3_photo" class="form-control" accept="image/*">
		  				<small class="text-muted">Upload a clear photo (JPG, PNG)</small>
		  			</div>
		  		</div>
		  	</div>
		  </div>
		  
		  <!-- FETCHER 4 (HIDDEN BY DEFAULT) -->
		  <div class="fetcher-section-wrapper" id="fetcher-4-section" style="border: 1px dashed #ccc; padding: 15px; border-radius: 5px; margin-bottom: 15px; background: #f9f9f9; display:none;">
		  	<h6 style="color: #6f42c1; font-weight: bold; border-bottom: 1px solid #6f42c1; padding-bottom: 5px; margin-bottom: 10px;">FETCHER 4</h6>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">First Name <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[3][firstname]" class="form-control" placeholder="Enter First Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Middle Name</label>
		  				<input type="text" name="fetcher[3][middlename]" class="form-control" placeholder="Enter Middle Name">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Last Name <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[3][lastname]" class="form-control" placeholder="Enter Last Name">
		  			</div>
		  		</div>
		  	</div>
		  	
		  	<div class="row">
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Relationship to Student <span style="color:red;">*</span></label>
		  				<select name="fetcher[3][relationship]" class="form-control">
		  					<option value="">-- Select Relationship --</option>
		  					<option value="Father">Father</option>
		  					<option value="Mother">Mother</option>
		  					<option value="Guardian">Guardian</option>
		  					<option value="Grandfather">Grandfather</option>
		  					<option value="Grandmother">Grandmother</option>
		  					<option value="Uncle">Uncle</option>
		  					<option value="Aunt">Aunt</option>
		  					<option value="Brother">Brother</option>
		  					<option value="Sister">Sister</option>
		  					<option value="Nanny">Nanny/Yaya</option>
		  					<option value="Driver">Driver</option>
		  					<option value="Other">Other</option>
		  				</select>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Contact Number <span style="color:red;">*</span></label>
		  				<input type="text" name="fetcher[3][contact_number]" class="form-control" placeholder="09xxxxxxxxx">
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<div class="form-group">
		  				<label class="form-label">Photo</label>
		  				<input type="file" name="fetcher_4_photo" class="form-control" accept="image/*">
		  				<small class="text-muted">Upload a clear photo (JPG, PNG)</small>
		  			</div>
		  		</div>
		  	</div>
		  </div>
		  
		  </div>
		  <!-- END FETCHER SECTIONS -->
		  
		  <div class="text-center" style="margin-bottom: 20px;">
		  	<button type="button" class="btn btn-outline-success" id="add-fetcher-btn" style="border-radius: 20px;">
		  		<i class="mdi mdi-plus-circle"></i> Add Another Fetcher
		  	</button>
		  </div>
          
   <!-- ========================================== -->
   <!-- SELECT STUDENT SECTION (DYNAMIC) -->
   <!-- ========================================== -->
   <div class="enroll-section">
   	<h5 class="enroll-section-title"><i class="mdi mdi-account"></i> NAME OF STUDENT</h5>
   </div>
		  
		  <div id="student-sections">
		  <div class="student-section" data-index="0">
		  <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Full Name <span style="color:red;">*</span></label>
					<input type="text" name="student[0][fullname]" class="form-control" placeholder="Enter Full Name" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Grade/Year <span style="color:red;">*</span></label>
					<select name="student[0][grade]" class="form-control" required>
						<option value="">-- Select Grade/Year --</option>
						<option value="K1">K1 (RR)</option>
						<option value="K2">K2 (ABCs)</option>
						<option value="1">Grade 1</option>
						<option value="2">Grade 2</option>
						<option value="3">Grade 3</option>
						<option value="4">Grade 4</option>
						<option value="5">Grade 5</option>
						<option value="6">Grade 6</option>
						<option value="7">Grade 7</option>
						<option value="8">Grade 8</option>
						<option value="9">Grade 9</option>
						<option value="10">Grade 10</option>
						<option value="11">Grade 11</option>
						<option value="12">Grade 12</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-label">Section <span style="color:red;">*</span></label>
					<input type="text" name="student[0][section]" class="form-control" placeholder="Enter Section" required>
				</div>
			</div>
		  </div>
		  </div>
		  </div>
		  
		  <div class="enroll-add-btn">
			<button type="button" class="btn btn-enroll btn-add" id="add-student-btn">
				<i class="mdi mdi-plus"></i> Add another kid
			</button>
		  </div>

		  <!-- Additional Notes Section -->
		  <div class="enroll-section" style="margin-top: 20px;">
			<h5 class="enroll-section-title"><i class="mdi mdi-note-text"></i> ADDITIONAL NOTES</h5>
		  </div>
		  
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="form-label">Special Instructions</label>
					<textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions or notes..."></textarea>
				</div>
			</div>
		  </div>
		  
		  <!-- Note Box -->
		  <div class="enroll-note-box">
			<h4><i class="mdi mdi-alert-circle-outline"></i> NOTE: Please make sure all the information you entered above is true and correct.</h4>
			<div class="form-check">
			  <label class="form-check-label">
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> I have reviewed and confirmed that the above information is true and correct.
			  <i class="input-helper"></i></label>
			</div>
		  </div>
		  
		  <div class="enroll-submit-area">
			<input type="submit" class="btn btn-enroll btn-submit" id="btnsubmit" name="submit" value="SUBMIT" disabled="" />
		  </div>
		  
		</form>
		
	</div>
  
</div>

<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnsubmit").attr("disabled", !this.checked);
	});
	
	$("#frmfetcher").submit(function(){
		$("#btnsubmit").attr("disabled",true);
		return true;
	});

	$("#add-fetcher-btn").click(function() {
		if($("#fetcher-2-section").is(":hidden")) {
			$("#fetcher-2-section").slideDown();
		} else if($("#fetcher-3-section").is(":hidden")) {
			$("#fetcher-3-section").slideDown();
		} else if($("#fetcher-4-section").is(":hidden")) {
			$("#fetcher-4-section").slideDown();
			$(this).hide(); // Hide button after all fetchers are shown
		}
	});

});
 
</script>
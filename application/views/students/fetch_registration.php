<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">

<div class="col-lg-12 grid-margin enroll-main-container">

	<div class="card enroll-card">
	  <div class="card-body p-0">
	 
		<div class="enroll-header">
			<h2><i class="mdi mdi-id-card"></i> FETCHER'S ID APPLICATION</h2>
		</div>
		
		<div style="padding: 1.5rem 2rem;">
		
		<form class="enroll-form" id="frmfetcher" action="<?=site_url("students/fetcher_id_submit")?>" method="POST" enctype="multipart/form-data">
		  
		  <div class="enroll-instruction">
			<i class="mdi mdi-information-outline"></i> Please fill out all fields. If not applicable, enter <strong>N/A</strong>.
		  </div>
		  
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
			
			<!-- FETCHER 2 -->
			<div class="fetcher-section-wrapper" style="border: 1px dashed #ccc; padding: 15px; border-radius: 5px; margin-bottom: 15px; background: #f9f9f9;">
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
			
		  </div>
		  <!-- END FETCHER SECTIONS -->

		  		  
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
	</div>          
 
</div>

<!-- Hidden template for cloning student section -->
<div id="student-template" style="display:none;">
<div class="student-section" data-index="__INDEX__">
<div class="row" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
	<div class="col-md-4">
		<div class="form-group">
			<label class="form-label">Full Name <span style="color:red;">*</span></label>
			<input type="text" name="student[__INDEX__][fullname]" class="form-control" placeholder="Enter Full Name" required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="form-label">Grade/Year <span style="color:red;">*</span></label>
			<select name="student[__INDEX__][grade]" class="form-control" required>
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
			<input type="text" name="student[__INDEX__][section]" class="form-control" placeholder="Enter Section" required>
		</div>
	</div>
</div>
<button type="button" class="btn btn-danger btn-sm" style="margin-top: 5px;" onclick="removeStudent(this)">Remove</button>
</div>
</div>

<!-- REMOVED Fetcher Template since it is now hardcoded -->

<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnsubmit").attr("disabled", !this.checked);
	});
	
	$("#frmfetcher").submit(function(){
		$("#btnsubmit").attr("disabled",true);
		return true;
	});
	
	$("#add-student-btn").click(function() {
		var index = $(".student-section").length;
		var template = $("#student-template").html().replace(/__INDEX__/g, index);
		$("#student-sections").append(template);
	});
	
});

function removeStudent(btn) {
	$(btn).closest(".student-section").remove();
}
</script>
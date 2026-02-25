<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnproceed").attr("disabled", !this.checked);
	});
	
	$("#btnproceed").click(function(){
		window.location.replace("<?=site_url('students/enrollnew_form')?>");
	});
	
	
});
</script>
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
	<h3 class="heading" style="text-align:center;">Student Handbook</h3>
	<p>Please read our Updated Student Handbook before continuing to the Enrollment Process.</p>
	<p>There are some latest updates made by our Academy Administration and Faculties especially under policies. </p>
	<p>Please take time to browse and read our handbook.  This is for benefits of our students to help in their learning process within the Academy.</p>
	
	<div class="row">
	<div class="col-md-12">
	  <div class="form-group row">
		
		<iframe src="<?=base_url()?>/file/BHCA-HandBook-2019-Latest.pdf" width="100%" height="550px">
    </iframe>
		
	  </div>
	</div>
	</div>
	
	<div class="form-check form-check-flat">
			  <label class="form-check-label">
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> Yes! I have read and agree with the Student Handbook. </label>
			</div>
	
	<p><input href="<?=site_url("students/enrollnew_form")?>" id="btnproceed" type="button" class="btn btn-lg btn-block btn-success btn-fw" value="Proceed to the Enrollment Form" disabled>  
	</p>
  </div>
</div>
</div>
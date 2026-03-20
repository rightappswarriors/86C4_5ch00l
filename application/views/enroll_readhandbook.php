<script>
$(function(){
	// Initially disable the checkbox until user scrolls to bottom
	$("#chkconfirmed").prop("disabled", true);
	$("#chkconfirmed").closest(".form-check-label").css("opacity", "0.6");
	$("#scroll-hint").show();
	
	// Function to check scroll position
	function checkScrollPosition() {
		var scrollTop = $(window).scrollTop();
		var docHeight = $(document).height();
		var winHeight = $(window).height();
		
		// If user has scrolled to near bottom (within 100px)
		if (scrollTop + winHeight >= docHeight - 100) {
			$("#chkconfirmed").prop("disabled", false);
			$("#chkconfirmed").closest(".form-check-label").css("opacity", "1");
			$("#scroll-hint").hide();
		}
	}
	
	// Detect scroll on window
	$(window).on("scroll", checkScrollPosition);
	
	// Also try to detect scroll inside iframe if possible
	$("iframe").on("load", function() {
		try {
			var iframeDoc = $("iframe")[0].contentDocument || $("iframe")[0].contentWindow.document;
			$(iframeDoc).on("scroll", checkScrollPosition);
		} catch(e) {
			// Cross-origin - will use window scroll only
		}
	});
	
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
		
		<iframe src="<?=base_url()?>/file/BHCA-HandBook-2019-Latest.pdf" width="100%" height="1200px" style="border:none;">
    	</iframe>
		
	  </div>
	</div>
	</div>
	
	<div class="alert alert-warning" id="scroll-hint">
		<i class="mdi mdi-information"></i> <strong>Please read the handbook before proceeding.</strong> You must scroll to the bottom of the document to enable the checkbox and continue to the enrollment form.
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

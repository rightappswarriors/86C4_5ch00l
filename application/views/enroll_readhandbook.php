<style>
  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ffffff;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
    flex-wrap: wrap;
  }

  .breadcrumb li {
    list-style: none;
    display: flex;
    align-items: center;
  }

  .breadcrumb .step {
    background: #1976d2;
    color: #ffffff;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: 0.3s;
  }

  .breadcrumb .arrow {
    color: #1976d2;
    font-size: 16px;
    font-weight: bold;
  }

  .breadcrumb .step:hover {
    background: #1565c0;
  }
</style>

<ol class="breadcrumb">
  <li><span class="step">Register with Handbook</span></li>
  <li class="arrow">→</li>
  <li><span class="step">Fill Up Enrollment Form</span></li>
  <li class="arrow">→</li>
  <li><span class="step">Print Form / Save QR Code</span></li>
  <li class="arrow">→</li>
  <li><span class="step">Visit School for Assessment</span></li>
</ol>

<script>
$(function(){
	// Show modal on page load
	$('#handbookModal').modal('show');

	// Handle proceed button in modal
	$('#btnReadHandbook').click(function(){
		$('#handbookModal').modal('hide');
	});
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

<!-- Modal Popup -->
<div class="modal fade" id="handbookModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white"><i class="mdi mdi-alert-circle"></i> IMPORTANT: Read the Handbook First</h5>
      </div>
      <div class="modal-body">
        <p style="font-size: 18px;">Read the Handbook first before proceeding to enroll a child.</p>
        <p>Please take time to browse and read our handbook thoroughly. This is for the benefit of our students to help in their learning process within the Academy.</p>
        <p>There are some latest updates made by our Academy Administration and Faculties especially under policies.</p>
        <hr>
        <p class="text-muted"><em>Click the button below to proceed to the Handbook and Enrollment Form.</em></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-success btn-fw" id="btnReadHandbook"><i class="mdi mdi-book-open"></i> Continue to Read the Handbook</button>
      </div>
    </div>
  </div>
</div>

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

<script>
$(function(){
	$("form#frm_search_oldstudent").submit(function(){
		$("#resultdisplay").html("");
		var txtfirstname = $("#txtfirstname").val();
		var txtlastname = $("#txtlastname").val();
		var txtmiddlename = $("#txtmiddlename").val();
		if(txtfirstname.length>0 && txtlastname.length>0 && txtmiddlename.length>0)
		{
			$("#resultdisplay").html("<div class='text-warning'>Loading...</div>");
			$.post("<?=site_url('students/search_result_oldstudent')?>",
			{txtfirstname:txtfirstname,txtlastname:txtlastname,txtmiddlename:txtmiddlename},function(data){
				$("#resultdisplay").html("<div class='text-warning'>Loading...</div>");
				$( "#resultdisplay" ).delay( 1000 ).fadeIn( 400 );
				$("#resultdisplay").html(data);
			});
		}
		return false;
	});
});
</script>

<div class="col-lg-12 grid-margin">
	<div class="card">
		<div class="card-body">
		<h3 class="heading" style="text-align:center;">Enrolling for an old/returnee Student</h3>
		<form class="ml-auto search-form d-none d-md-block" method="POST" id="frm_search_oldstudent">
		  <p class="card-description"> Please enter the information. All fields are required to be fill out for search from our database. </p>
		  <p class="text-warning">Make sure you type the First Name, Last Name and the Middle Name correctly.</p>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">First Name</label>
				<div class="col-sm-9">
				  <input type="text" name="firstname" id="txtfirstname" class="form-control" />
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Last Name</label>
				<div class="col-sm-9">
				  <input type="text" name="lastname" id="txtlastname" class="form-control" />
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Middle Name</label>
				<div class="col-sm-9">
				  <input type="text" name="middlename" id="txtmiddlename" class="form-control" />
				</div>
			  </div>
			</div>
			</div>
			<div class="row">
			<div style="text-align:center;margin:0 auto;">
			  <input type="submit" class="btn btn-lg btn-warning" name="submit" value="Search Now...">
			</div>
			</div>
		</form>
		
		<div id="resultdisplay"></div>
		
		</div>	
	</div>	
</div>	

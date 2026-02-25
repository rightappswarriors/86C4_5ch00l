<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	$interviews = explode(",",$row->admininterview);
?>

<script>
$(function(){
	
	$("#chkconfirmed").click(function() {
		$("#btnstatus").attr("disabled", !this.checked);
	});	
	
});
</script>

<?php $this->load->view("students/menu",$data) ?>

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
		
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="text-primary" style="margin-bottom:10px;">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>	
		
		<h3 class="heading" style="text-align:center;">Admin Interview</h3>
		
		<?php 
		if($this->session->userdata('current_usertype') == 'Admin'):
		?>
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
		<a href="<?=site_url("students/interview/".$row->id)?>" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-refresh'></i></a>	
		</div>
		</div>
		<?php endif; ?>
		
		
		<div class="container mt-3">
		<div class="card stretch-card">
	  <div class="card-header bg-success p-2">Schedule for Interview</div>
	  <div class="card-body">
	  
	  <script>
	  
	  $(function(){
		  
		  $("#interview_info").hide();
		  $("#interview_info_ok").hide();
		  $("#schedinterview_info").hide();
		  
		  var studentid = <?=$this->uri->segment(3)?>;
			  
		  $.post("<?=site_url('students/get_interview_schedule')?>",{ studentid:studentid },function(e){
			
			if(e == '0'){
				
			}else{
                
				$("#frmschedule").hide();
				$("#schedinterview_info").show();
				$("#datetimesched").html( e );
                
                <?php 
                if($this->session->userdata('current_usertype') == 'Registrar' or $this->session->userdata('current_usertype') == 'Admin'):
              
              ?>
                
                let text = e;
                const myArray = text.split("@");
                let ddate = myArray[0];
                let dtime = myArray[1];
                
                //alert(ddate + " " + dtime);
                
                $("#frmscheduleupdate").show();
                $("#schedinterview_info").hide();
                $("#interview_info1").hide();
                
                $("#interviewdate1").val( ddate );
                $("#interviewtime1").val( dtime );
                
                <?php
              
              endif;
                ?>
                
			}
			
		  });		
		  
		  $("#frmschedule").on("submit",function(){
			  
			  $("#btncheckavailability").attr("disabled","true");
			  $("#btncheckavailability").html("Checking...");
			  
			  var txtdate = $("#interviewdate").val();
			  var txttime = $("#interviewtime").val();
			  var student = <?=$this->uri->segment(3)?>;
			  
			  //alert(txtdate + ' ' + txttime + ' ' + student);
			  
			  $.post("<?=site_url('students/interview_schedule')?>",{ ddate:txtdate,ttime:txttime,studentid:student },function(e){
				
				if(e){
					
					$("#interview_info_ok").show();
					$("#frmschedule").hide("slow");
					
					$("#schedinterview_info").show();
					$("#datetimesched").load( "<?=site_url('students/get_interview_schedule')?>",{ studentid:studentid } );
					
				}else{
					
					$("#interview_info").show();
					
					// slot already taken...
					$("#btncheckavailability").attr("disabled","false");
					$("#btncheckavailability").html("Submit");
					
				}
				
				setTimeout(function(){
					$(".alert").hide();
				},8000);
				  
			  });
			  
			  return false;
			  
		  });
          
          
          $("#frmscheduleupdate").on("submit",function(){
			  
			  $("#btncheckavailability1").attr("disabled","true");
			  $("#btncheckavailability1").html("Checking...");
			  
			  var txtdate = $("#interviewdate1").val();
			  var txttime = $("#interviewtime1").val();
			  var student = <?=$this->uri->segment(3)?>;
			  
			  //alert(txtdate + ' ' + txttime + ' ' + student);
			  
			  $.post("<?=site_url('students/interview_schedule_update')?>",{ ddate:txtdate,ttime:txttime,studentid:student },function(e){
				
				if(e){
					
					$("#interview_info_ok").show();
					$("#frmscheduleupdate").hide("slow");
					
					$("#schedinterview_info").show();
					$("#datetimesched").load( "<?=site_url('students/get_interview_schedule')?>",{ studentid:studentid } );
					
				}else{
					
					$("#interview_info").show();
					
					// slot already taken...
					$("#btncheckavailability1").attr("disabled","false");
					$("#btncheckavailability1").html("Submit");
					
				}
				
				setTimeout(function(){
					$(".alert").hide();
				},8000);
				  
			  });
			  
			  return false;
			  
		  });
		  
	  });
	  
	  </script>
	  
	  
	  <form action="" id="frmschedule" method="post">
		<div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-7 col-form-label text-right"><b>Select a date: </b></label>
				<div class="col-sm-5">
				  <input type="date" min="<?=date('Y-m-d')?>" name="interviewdate" id="interviewdate" class="form-control" value="<?=date("Y-m-d",strtotime("+1 week"))?>">
				</div>
			  </div>
			</div>
		</div><div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-7 col-form-label text-right"><b>Convenient Time: </b></label>
				<div class="col-sm-5">
				  <select name="schedtime" id="interviewtime" class="form-control">
				  <?php 
				  foreach(range(intval('07:00:00'),intval('15:00:00')) as $time) {
					  $opt_time = date("H:00:00", mktime($time+1));
					  echo "<option value='$opt_time'>".date("h:00a",strtotime($opt_time))."</option>";
					}
				  ?>
				  </select>
				</div>
			  </div>
			</div>
		</div><div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
			  <label class="col-sm-7 col-form-label">&nbsp;</label>
				<div class="col-sm-5">
				  <button type="submit" id="btncheckavailability" class="btn btn-primary">Submit</button>
				</div>
				
			  </div>
			</div>
			<div class="col-md-12">
				<div class="alert alert-danger" id="interview_info">Sorry, schedule selected is already taken! Please select other date or time.</div>
			</div>
		</div>
		
		</form>
          
          <form action="" id="frmscheduleupdate" method="post" style="display:none;">
		<div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-7 col-form-label text-right"><b>Edit Date: </b></label>
				<div class="col-sm-5">
				  <input type="date" name="interviewdate" id="interviewdate1" class="form-control" value="<?=date("Y-m-d",strtotime("+1 week"))?>">
				</div>
			  </div>
			</div>
		</div><div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
				<label class="col-sm-7 col-form-label text-right"><b>Edit Time: </b></label>
				<div class="col-sm-5">
				  <select name="schedtime" id="interviewtime1" class="form-control">
				  <?php 
				  foreach(range(intval('07:00:00'),intval('15:00:00')) as $time) {
					  $opt_time = date("H:00:00", mktime($time+1));
					  echo "<option value='$opt_time'>".date("h:00a",strtotime($opt_time))."</option>";
					}
				  ?>
				  </select>
				</div>
			  </div>
			</div>
		</div><div class="row">
			<div class="col-md-6">
			  <div class="form-group row">
			  <label class="col-sm-7 col-form-label">&nbsp;</label>
				<div class="col-sm-5">
				  <button type="submit" id="btncheckavailability1" class="btn btn-primary">Update</button>
				</div>
				
			  </div>
			</div>
			<div class="col-md-12">
				<div class="alert alert-danger" id="interview_info1">Sorry, schedule selected is already taken! Please select other date or time.</div>
			</div>
		</div>
		
		</form>
		
		<div class="col-md-12">
			<div class="alert alert-info" id="interview_info_ok">Thank you! Your schedule has been successfully submitted.</div>
		</div>
		
		<div class="col-md-12" id="schedinterview_info">
			<div class="row">
				<div class="col-md-10">
				  <div class="form-group row">
					<label class="col-sm-5 col-form-label text-right"><b>Date and Time: </b></label>
					<div class="col-sm-7 pt-1" id="datetimesched"></div>
				  </div>
				</div>
			</div>
		</div>
		
		</div>
		</div>
		</div>
		
		
		<div class="container mt-3">
		<div class="card stretch-card">
	  <div class="card-header bg-info p-2">To be fill-out during the interview.</div>
	  <div class="card-body">
		
		<p class="card-description text-info"> Check all that apply! </p>
		
		<form action="<?=site_url("students/interview_submit/".$row->id)?>" method="post">
		
		<div class="row">
			<div class="col-md-12">
			<ol>
				<li><b>Church Support</b>
					<ol style="list-style-type:upper-alpha">
						<li>Regular Attendance
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="1" <?=set_checkbox('interview[]', $interviews[0], $interviews[0]==1?TRUE:FALSE)?> class="form-check-input">Sunday School</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="2" <?=set_checkbox('interview[]', $interviews[1], $interviews[1]==1?TRUE:FALSE)?> class="form-check-input">Church Service</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="3" <?=set_checkbox('interview[]', $interviews[2], $interviews[2]==1?TRUE:FALSE)?> class="form-check-input">Youth Ministry</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="4" <?=set_checkbox('interview[]', $interviews[3], $interviews[3]==1?TRUE:FALSE)?> class="form-check-input">Special Events (Missions Conf., Youth Congress (Camp), Church Anniversary, etc.)</label>
							</div></li>
							</ol>
						</li>
						<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="5" <?=set_checkbox('interview[]', $interviews[4], $interviews[4]==1?TRUE:FALSE)?> class="form-check-input">Regular Giving of Tithes and Offerings</label>
							</div></li>
					</ol>
				</li>
				<li><b>Family Support</b>
					<ol style="list-style-type:upper-alpha">
						<li>Spiritual Support
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="6" <?=set_checkbox('interview[]', $interviews[5], $interviews[5]==1?TRUE:FALSE)?> class="form-check-input">Family Devotions</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="7" <?=set_checkbox('interview[]', $interviews[6], $interviews[6]==1?TRUE:FALSE)?> class="form-check-input">Godly Example (Outwardly and Inwardly, i.e. fruit of the Spirit)</label>
							</div></li>
							</ol>
						</li>
						<li>English in the home (as much as possible)
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="8" <?=set_checkbox('interview[]', $interviews[7], $interviews[7]==1?TRUE:FALSE)?> class="form-check-input">Dinner Table</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="9" <?=set_checkbox('interview[]', $interviews[8], $interviews[8]==1?TRUE:FALSE)?> class="form-check-input">Reading Books</label>
							</div></li>
							</ol>
						</li>
					</ol>
				</li>
				<li><b>School Support</b>
					<ol style="list-style-type:upper-alpha">
						<li>Educational Support
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="10" <?=set_checkbox('interview[]', $interviews[9], $interviews[9]==1?TRUE:FALSE)?> class="form-check-input">Willing to co-supervise and co-monitor the progress of our children’s modular distance learning</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="11" <?=set_checkbox('interview[]', $interviews[10], $interviews[10]==1?TRUE:FALSE)?> class="form-check-input">Willing to co-supervise and co-monitor the progress of our children’s online learning.</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="12" <?=set_checkbox('interview[]', $interviews[11], $interviews[11]==1?TRUE:FALSE)?> class="form-check-input">Willing to coach and parent our children through the educational process</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="13" <?=set_checkbox('interview[]', $interviews[12], $interviews[12]==1?TRUE:FALSE)?> class="form-check-input">Attend parent programs (PT conferences, PTFs, Special Events) whether F2F or virtual</label>
							</div></li>
							</ol>
						</li>
						<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="14" <?=set_checkbox('interview[]', $interviews[13], $interviews[13]==1?TRUE:FALSE)?> class="form-check-input">Spiritual (prayer and encouragement)</label>
							</div></li>
					</ol>
				</li>
				<li><b>Furniture and Technical Support</b>
					<ol style="list-style-type:upper-alpha">
						<li>Availability of Technical Equipment
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="15" <?=set_checkbox('interview[]', $interviews[14], $interviews[14]==1?TRUE:FALSE)?> class="form-check-input">Smart Phone</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="16" <?=set_checkbox('interview[]', $interviews[15], $interviews[15]==1?TRUE:FALSE)?> class="form-check-input">Tablet</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="17" <?=set_checkbox('interview[]', $interviews[16], $interviews[16]==1?TRUE:FALSE)?> class="form-check-input">Computer (with Camera and Mic)</label>
							</div></li>
							</ol>
						</li>
						<li>Connectivity
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="18" <?=set_checkbox('interview[]', $interviews[17], $interviews[17]==1?TRUE:FALSE)?> class="form-check-input">Responsible for load and access during school hours</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="19" <?=set_checkbox('interview[]', $interviews[18], $interviews[18]==1?TRUE:FALSE)?> class="form-check-input">Internet access</label>
							</div></li>
							</ol>
						</li>
						<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="20" <?=set_checkbox('interview[]', $interviews[19], $interviews[19]==1?TRUE:FALSE)?> class="form-check-input">Study Space (a place to read write with limited interruptions)</label>
							</div></li>
					</ol>
				</li>
			</ol>
			</div>
		</div>
		
		<div class="row">
		
			<div class="col-md-12" style="text-align:left;">
			<br>
			<?php
			if($this->session->userdata('current_usertype') == 'Parent'):
			?>	
			<div class="form-check form-check-flat">
				<label class="form-check-label">			  
				<input type="checkbox" class="form-check-input" id="chkconfirmed"> I have read all of the above and checked what applies; I do affirm that the above statements are true. </label>
			</div>
			<input type="submit" href="<?=site_url("students/changestatus/Payment/".$row->id)?>" value="Submit" class="btn btn-lg btn-success" id="btnstatus" disabled>
			<?php else: ?>
			<a href="<?=site_url("students/changestatus_admin/Payment/".$row->id)?>" class="btn btn-lg btn-success">Change Status: For Payment</a>
			<?php endif; ?>
			
			</div>
		
		</div>
		
		</form>
		
	  </div>
	  </div>
	  </div>
	  
	  </div>
	</div> 
	
</div>
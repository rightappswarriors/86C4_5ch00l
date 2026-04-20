<?php
	$row = $query->row();
	$data = array( 'row'  => $row );
	$interviews = explode(",",$row->admininterview);

	// Get current interview schedule if exists
	$current_schedule = null;
	$schoolyear = $this->session->userdata('current_schoolyearid');
	$this->load->model('register_model');
	$schedule_info = $this->register_model->get_interview_schedule($row->id, $schoolyear);
	if($schedule_info) {
		// Get the actual schedule record to access capacity if needed
		$sch_qry = $this->db->query("SELECT * FROM interviewsched WHERE studentid = ? AND schoolyear = ? AND status = 1 LIMIT 1", array($row->id, $schoolyear));
		if($sch_qry->num_rows() > 0) {
			$current_schedule = $sch_qry->row();
		}
	}

	// Get all available time slots for the current selected date
	$selected_date = isset($current_schedule) ? date('Y-m-d', strtotime($current_schedule->interviewdate)) : '';
?>

<script>
$(function(){

	$("#chkconfirmed").click(function() {
		$("#btnstatus").attr("disabled", !this.checked);
	});

	// Interview scheduling
	var currentStudentId = <?= $row->id ?>;
	var currentSchedule = <?= isset($current_schedule) ? 'true' : 'false' ?>;
	var schoolyear = <?= $schoolyear ? $schoolyear : 'null' ?>;

	// Date change handler
	$("#interview_date").change(function() {
		var selectedDate = $(this).val();
		if(selectedDate) {
			// Enable time input
			$("#interview_time").prop('disabled', false);
			// Clear previous status
			$("#slot_status").html('');
			$("#slot_capacity_info").text('');
		}
	});

	// Time change handler
	$("#interview_time").change(function() {
		var selectedTime = $(this).val(); // format: "HH:MM"
		var selectedDate = $("#interview_date").val();
		if(selectedDate && selectedTime) {
			checkSlotAvailability(selectedDate, selectedTime);
		}
	});

	// Schedule button click
	$("#btn_schedule").click(function() {
		saveInterviewSchedule();
	});

	function checkSlotAvailability(date, time) {
		var duration = $("#slot_duration").val() || 30;
		// time is in "HH:MM" format from input[type=time], convert to "HH:MM:SS" for server
		var timeWithSeconds = time + ':00';

		$.ajax({
			url: "<?=site_url('students/ajax_check_slot')?>",
			type: "POST",
			data: {
				date: date,
				time: timeWithSeconds,
				slot_duration: duration,
				studentid: currentStudentId
			},
			dataType: "json",
			success: function(response) {
				if(response.success) {
					var infoText = 'Duration: ' + duration + ' minutes';
					$("#slot_capacity_info").text(infoText);

					if(response.available) {
						$("#slot_status").html('<span class="text-success">This time slot is free</span>');
						$("#btn_schedule").prop('disabled', false);
					} else {
						$("#slot_status").html('<span class="text-danger">Time conflict: another interview overlaps with this slot</span>');
						$("#btn_schedule").prop('disabled', true);
					}
				}
			},
			error: function() {
				console.error("Error checking slot");
			}
		});
	}

	function saveInterviewSchedule() {
		var date = $("#interview_date").val();
		var time = $("#interview_time").val(); // "HH:MM"
		var duration = $("#slot_duration").val();

		if(!date || !time) {
			alert("Please select both date and time");
			return false;
		}

		// Convert "HH:MM" to "HH:MM:SS" for server
		var timeWithSeconds = time + ':00';

		var url = "<?=site_url('students/interview_schedule')?>";

		var postData = {
			studentid: currentStudentId,
			ddate: date,
			ttime: timeWithSeconds,
			slot_duration: duration
		};

		$.ajax({
			url: url,
			type: "POST",
			data: postData,
			dataType: "json",
			success: function(response) {
				console.log('Response:', response);
				console.log('Response type:', typeof response);
				var success = (response == 1 || (typeof response === 'object' && response.success));
				if(success) {
					alert("Schedule saved successfully!\nRedirecting...");
					setTimeout(function(){
						window.location.href = "<?= site_url('students/interview') ?>/" + currentStudentId;
					}, 500);
				} else {
					alert("Time conflict: The selected slot overlaps with an existing interview. Please choose another time.");
					checkSlotAvailability(date, time);
				}
			},
			error: function(xhr, status, error) {
				alert("Error saving schedule: " + error + "\nPlease check console for details.");
				console.error('AJAX Error:', status, error);
				console.log('Response Text:', xhr.responseText);
			}
		});
	}

	// Initialize on load if we have a schedule
	$(document).ready(function() {
		<?php if(isset($current_schedule)): ?>
			$("#interview_date").val("<?= date('Y-m-d', strtotime($current_schedule->interviewdate)) ?>");
			// Enable time input since we have a schedule
			$("#interview_time").prop('disabled', false);
			var currentTime = "<?= date('H:i', strtotime($current_schedule->interviewtime)) ?>";
			$("#interview_time").val(currentTime);
			checkSlotAvailability("<?= $current_schedule->interviewdate ?>", currentTime);
		<?php endif; ?>
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
		<hr>
		
		<?php
		if($this->session->userdata('current_usertype') == 'Admin'):
		?>
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
		<a href="<?=site_url("students/interview/".$row->id)?>" class="btn btn-icons btn-secondary btn-rounded"><i class='mdi mdi-refresh'></i></a>
		</div>
		</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-12">
				<div class="card" style="background-color: #f8f9fa; border-left: 4px solid #257e4a; margin-bottom: 20px;">
					<div class="card-body">
						<h4 style="color: #257e4a; margin-top: 0;">Interview Schedule</h4>

		<?php if(isset($current_schedule)):
			// Get slot duration
			$slot_duration = $this->register_model->get_slot_duration($row->id, $schoolyear);
		?>
		<div class="alert alert-info" style="padding: 10px; margin-bottom: 15px;">
			Current Schedule: <strong><?= date('F d, Y', strtotime($current_schedule->interviewdate)) ?></strong>
			at <strong><?= date('h:i A', strtotime($current_schedule->interviewtime)) ?></strong>
			<span style="margin-left: 10px; font-size: 0.9em;">
				(<?= $slot_duration ?> min<?= $slot_duration != 1 ? 's' : '' ?>)
			</span>
		</div>
		<?php endif; ?>

						<?php if($this->session->userdata('current_usertype') == 'Admin' || $this->session->userdata('current_usertype') == 'Registrar'): ?>
						<form id="schedule_form" onsubmit="return false;">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Date</label>
										<input type="date" name="interview_date" id="interview_date"
										       class="form-control"
										       min="<?= date('Y-m-d') ?>"
										       value="<?= isset($current_schedule) ? date('Y-m-d', strtotime($current_schedule->interviewdate)) : '' ?>"
										       required>
									</div>
								</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Time</label>
									<input type="time" name="interview_time" id="interview_time"
									       class="form-control"
									       step="60"
									       value="<?= isset($current_schedule) ? date('H:i', strtotime($current_schedule->interviewtime)) : '' ?>"
									       <?= isset($current_schedule) ? '' : 'disabled' ?>
									       required>
									<small class="text-muted"></small>
								</div>
							</div>
								<?php if($this->session->userdata('current_usertype') == 'Admin'): ?>
								<div class="col-md-2">
									<div class="form-group">
										<label>Duration</label>
										<input type="number" name="slot_duration" id="slot_duration"
										       class="form-control"
										       min="15" max="120" step="15"
										       value="<?= isset($current_schedule) ? $this->register_model->get_slot_duration($row->id, $schoolyear) : 30 ?>">
										<small class="text-muted"></small>
									</div>
								</div>
								<?php endif; ?>
								<div class="col-md-<?= $this->session->userdata('current_usertype') == 'Admin' ? '4' : '6' ?>">
									<div class="form-group">
										<label>&nbsp;</label>
										<div style="padding-top: 8px;">
											<button type="button" id="btn_schedule"
											        class="btn btn-primary">
												Add New Schedule
											</button>
											<?php if(isset($current_schedule)): ?>
											<a href="<?=site_url("students/remove_interview_schedule/".$row->id)?>"
											   class="btn btn-danger"
											   onclick="return confirm('Remove this interview schedule?')">
												Remove
											</a>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div id="slot_status" style="margin-top: 10px; font-weight: bold;"></div>
									<div id="slot_capacity_info" style="margin-top: 5px; color: #666;"></div>
								</div>
							</div>
							<input type="hidden" name="studentid" value="<?= $row->id ?>">
						</form>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>

		<p class="card-description text-info"> Check all that apply! </p>
		
		<form id="admin_interview_form" action="<?=site_url("students/interview_submit/".$row->id)?>" method="post">
		
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
								<input type="checkbox" name="interview[]" value="10" <?=set_checkbox('interview[]', $interviews[9], $interviews[9]==1?TRUE:FALSE)?> class="form-check-input">Willing to co-supervise and co-monitor the progress of our children's modular distance learning</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="11" <?=set_checkbox('interview[]', $interviews[10], $interviews[10]==1?TRUE:FALSE)?> class="form-check-input">Willing to coach and parent our children through the educational process</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="12" <?=set_checkbox('interview[]', $interviews[11], $interviews[11]==1?TRUE:FALSE)?> class="form-check-input">Attend parent programs (PT conferences, PTFs, Special Events) whether F2F or virtual</label>
							</div></li>
							</ol>
						</li>
						<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="13" <?=set_checkbox('interview[]', $interviews[12], $interviews[12]==1?TRUE:FALSE)?> class="form-check-input">Spiritual (prayer and encouragement)</label>
							</div></li>
					</ol>
				</li>
				<li><b>Furniture and Technical Support</b>
					<ol style="list-style-type:upper-alpha">
						<li>Availability of Technical Equipment
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="14" <?=set_checkbox('interview[]', $interviews[13], $interviews[13]==1?TRUE:FALSE)?> class="form-check-input">Smart Phone</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="15" <?=set_checkbox('interview[]', $interviews[14], $interviews[14]==1?TRUE:FALSE)?> class="form-check-input">Tablet</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="16" <?=set_checkbox('interview[]', $interviews[15], $interviews[15]==1?TRUE:FALSE)?> class="form-check-input">Computer (with Camera and Mic)</label>
							</div></li>
							</ol>
						</li>
						<li>Connectivity
							<ol style="list-style-type:lower-alpha">
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="17" <?=set_checkbox('interview[]', $interviews[16], $interviews[16]==1?TRUE:FALSE)?> class="form-check-input">Responsible for load and access during school hours</label>
							</div></li>
							<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="18" <?=set_checkbox('interview[]', $interviews[17], $interviews[17]==1?TRUE:FALSE)?> class="form-check-input">Internet access</label>
							</div></li>
							</ol>
						</li>
						<li><div class="form-check form-check-flat">
								<label class="form-check-label">			  
								<input type="checkbox" name="interview[]" value="19" <?=set_checkbox('interview[]', $interviews[18], $interviews[18]==1?TRUE:FALSE)?> class="form-check-input">Study Space (a place to read write with limited interruptions)</label>
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
			<a href="<?=site_url("students/changestatus/Payment/".$row->id)?>" class="btn btn-lg btn-success">Change Status: For Payment</a>
			<?php endif; ?>
			
			</div>
		
		</div>
		
		</form>
		
	  </div>
	</div> 
	
</div>

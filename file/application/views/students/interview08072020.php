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
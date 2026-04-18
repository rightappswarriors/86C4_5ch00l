<?php 
	
	$row = $query->row(); 
	$studentid = $row->id;
	$data = array( 'row'  => $row );
	
	if($query_ass->num_rows()>0){
		
		$row_as = $query_ass->row(); 
		
		$math = explode(",",$row_as->math);
		$eng = explode(",",$row_as->english);
		$science = explode(",",$row_as->science);
		$sstudies = explode(",",$row_as->socstudies);
		$wbuilding = explode(",",$row_as->wordbuilding);
		$literature = explode(",",$row_as->literature);
		$filipino = explode(",",$row_as->filipino);
		$ap = explode(",",$row_as->ap);
		$as_id = $row_as->id;
		
	}else{
		
		$math = array("","","");
		$eng = array("","","");
		$science = array("","","");
		$sstudies = array("","","");
		$wbuilding = array("","","");
		$literature = array("","");
		$filipino = array("","");
		$ap = array("","");
		$as_id = 0;
		
	}
	
?>

<script>
$(function(){	
	$('input[type=text]').keypress(function(event){
       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault();
       }
   });
   
   <?php 
	if($this->session->userdata('current_usertype') == 'Parent'):
	?>
	$("input[type='text']").attr("disabled",true);
	<?php
	endif;
   ?>
});
</script>

<?php $this->load->view("students/menu",$data) ?>

<style>
  .content-wrapper {
    margin-top: 0;
  }
</style>

<div class="content-wrapper">

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
		
		<form action="<?=site_url("students/assessment_paces_submit/".$row->id)?>" method="post">
		<input type="hidden" name="as_id" value="<?=$as_id?>">
		
		<h3 class="heading" style="text-align:center;">Assessment PACEs</h3>
		
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
				<a href="<?=site_url("students/assessment/".$row->id)?>" class="btn btn-icons btn-secondary btn-rounded" title="Back to Assessment"><i class='mdi mdi-arrow-left'></i></a>
			</div>
		</div>
		
		<br>
		
		<div class="row">
			<div class="col-md-12">
			<p class="card-description text-info">TO BEGIN PACE WORK: /Ordered PACEs</p>	
			  <div class="form-group row">
				<label class="col-sm-3 col-form-label">Math #</label>
				<div class="col-sm-3">
				  <input type="text" id="math_begin" name="math_begin" value="<?=set_value('math_begin',$math[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="math_end" name="math_end" value="<?=set_value('math_end',$math[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="math_gaps" name="math_gaps" value="<?=set_value('math_gaps',$math[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">English #</label>
				<div class="col-sm-3">
				  <input type="text" id="eng_begin" name="eng_begin" value="<?=set_value('eng_begin',$eng[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="eng_end" name="eng_end" value="<?=set_value('eng_end',$eng[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="eng_gaps" name="eng_gaps" value="<?=set_value('eng_gaps',$eng[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Science #</label>
				<div class="col-sm-3">
				  <input type="text" id="science_begin" name="science_begin" value="<?=set_value('science_begin',$science[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="science_end" name="science_end" value="<?=set_value('science_end',$science[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="science_gaps" name="science_gaps" value="<?=set_value('science_gaps',$science[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Soc. Studies #</label>
				<div class="col-sm-3">
				  <input type="text" id="sstudies_begin" name="sstudies_begin" value="<?=set_value('sstudies_begin',$sstudies[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="sstudies_end" name="sstudies_end" value="<?=set_value('sstudies_end',$sstudies[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="sstudies_gaps" name="sstudies_gaps" value="<?=set_value('sstudies_gaps',$sstudies[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Word Building #</label>
				<div class="col-sm-3">
				  <input type="text" id="wbuilding_begin" name="wbuilding_begin" value="<?=set_value('wbuilding_begin',$wbuilding[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="wbuilding_end" name="wbuilding_end" value="<?=set_value('wbuilding_end',$wbuilding[1])?>" placeholder="End" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="wbuilding_gaps" name="wbuilding_gaps" value="<?=set_value('wbuilding_gaps',$wbuilding[2])?>" placeholder="Gaps" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Literature #</label>
				<div class="col-sm-3">
				  <input type="text" id="literature_begin" name="literature_begin" value="<?=set_value('literature_begin',$literature[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="literature_end" name="literature_end" value="<?=set_value('literature_end',$literature[1])?>" placeholder="End" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">Filipino #</label>
				<div class="col-sm-3">
				  <input type="text" id="filipino_begin" name="filipino_begin" value="<?=set_value('filipino_begin',$filipino[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="filipino_end" name="filipino_end" value="<?=set_value('filipino_end',$filipino[1])?>" placeholder="End" class="form-control" />
				</div>
			  </div><div class="form-group row">
				<label class="col-sm-3 col-form-label">A.P. #</label>
				<div class="col-sm-3">
				  <input type="text" id="ap_begin" name="ap_begin" value="<?=set_value('ap_begin',$ap[0])?>" placeholder="Begin" class="form-control" />
				</div><div class="col-sm-3">
				  <input type="text" id="ap_end" name="ap_end" value="<?=set_value('ap_end',$ap[1])?>" placeholder="End" class="form-control" />
				</div>
			  </div>
			</div>
		</div>

		<br>
		<div class="row">
		
		<?php
		if($this->session->userdata('current_usertype') == 'Registrar'):
		?>	
		<div class="col-md-12" style="text-align:left;">
		<input type="submit" class="btn btn-lg btn-primary" value="UPDATE PACEs">
		</div>
		<?php endif; ?>
		
		</div>
		
		</form>
		
	  </div>
	</div> 
	
</div>
</div>
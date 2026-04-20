<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$_maths = array();
	$_engs = array();
	$_sciences = array();
	$_sstudiess = array();
	$_wbuildings = array();
	$_literatures = array();
	$_filipinos = array();
	$_afilipinos = array();
	$_aps = array();
	$lastupdateby = "N/A";
	
	$speech = array('','','','');
	$music = array('','','','');
	$bible = array('','','','');
	$esp = array('','','','');
	$tle = array('','','','');
	$mapeh = array('','','','');
	$mapeh_music = array('','','','');
	$arts = array('','','','');
	$pe = array('','','','');
	$health = array('','','','');
	
	// ASSESSMENT
	if($query_ass->num_rows()>0){
		
		$row_as = $query_ass->row(); 
		$as_id = $row_as->id;
	
		$math = array_pad(explode(",",$row_as->math), 3, "");
		$eng = array_pad(explode(",",$row_as->english), 3, "");
		$science = array_pad(explode(",",$row_as->science), 3, "");
		$sstudies = array_pad(explode(",",$row_as->socstudies), 3, "");
		$wbuilding = array_pad(explode(",",$row_as->wordbuilding), 3, "");
		$literature = array_pad(explode(",",$row_as->literature), 3, "");
		$filipino = array_pad(explode(",",$row_as->filipino), 3, "");
		$afilipino = array_pad(explode(",",$row_as->afilipino), 3, "");
		$ap = array_pad(explode(",",$row_as->ap), 3, "");
		
		// CHECK Academics
		if($query_academics->num_rows()>0){
			$row_ac = $query_academics->row(); 
			
			$maths = explode(",",$row_ac->math);
			foreach($maths as $ind=>$_math){
				$_math_ = explode("|",$_math);
				$_maths[$_math_[0]] = $_math_;
			}
			$engs = explode(",",$row_ac->eng);
			foreach($engs as $ind=>$_eng){
				$_eng_ = explode("|",$_eng);
				$_engs[$_eng_[0]] = $_eng_;
			}
			$sciences = explode(",",$row_ac->science);
			foreach($sciences as $ind=>$_science){
				$_science_ = explode("|",$_science);
				$_sciences[$_science_[0]] = $_science_;
			}
			$sstudiess = explode(",",$row_ac->sstudies);
			foreach($sstudiess as $ind=>$_sstudies){
				$_sstudies_ = explode("|",$_sstudies);
				$_sstudiess[$_sstudies_[0]] = $_sstudies_;
			}
			$wbuildings = explode(",",$row_ac->wbuilding);
			foreach($wbuildings as $ind=>$_wbuilding){
				$_wbuilding_ = explode("|",$_wbuilding);
				$_wbuildings[$_wbuilding_[0]] = $_wbuilding_;
			}
			$literatures = explode(",",$row_ac->literature);
			foreach($literatures as $ind=>$_literature){
				$_literature_ = explode("|",$_literature);
				$_literatures[$_literature_[0]] = $_literature_;
			}
			$filipinos = explode(",",$row_ac->filipino);
			foreach($filipinos as $ind=>$_filipino){
				$_filipino_ = explode("|",$_filipino);
				$_filipinos[$_filipino_[0]] = $_filipino_;
			}
			$afilipinos = explode(",",$row_ac->afilipino);
			foreach($afilipinos as $ind=>$_afilipino){
				$_afilipino_ = explode("|",$_afilipino);
				$_afilipinos[$_afilipino_[0]] = $_afilipino_;
			}
			$aps = explode(",",$row_ac->ap);	
			foreach($aps as $ind=>$_ap){
				$_ap_ = explode("|",$_ap);
				$_aps[$_ap_[0]] = $_ap_;
			}
			
			// Conventional
			if(strlen(trim($row_ac->speech))>0){
				$speech = explode(",",$row_ac->speech);
				$music = explode(",",$row_ac->music);
				$bible = explode(",",$row_ac->bible);
				$esp = explode(",",$row_ac->esp);
				$tle = explode(",",$row_ac->tle);
				$mapeh = explode(",",$row_ac->mapeh);
				$mapeh_music = explode(",",$row_ac->mapeh_music);
				$arts = explode(",",$row_ac->arts);
				$pe = explode(",",$row_ac->pe);
				$health = explode(",",$row_ac->health);
			}
			
			$lastupdateby = $row_ac->lastname.", ".$row_ac->firstname." (".date('m/d/Y h:ia',strtotime($row_ac->lastupdate)).")";
			
		}
		
	}else{
		
		$math = array("","","");
		$eng = array("","","");
		$science = array("","","");
		$sstudies = array("","","");
		$wbuilding = array("","","");
		
		$literature = array("","","");
		$filipino = array("","","");
		$afilipino = array("","","");
		$ap = array("","","");
		$as_id = 0;
		
	}
	
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_academics.css">

<?php $this->load->view("students/menu",$data) ?>

<div class="col-lg-12 grid-margin stretch-card academics-page">

	<div class="card academics-card">
	  <div class="card-body">
	 
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="text-primary" style="margin-bottom:10px;">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>	
	 
		<form action="<?=site_url("students/academics_submit/".$this->uri->segment(3))?>" method="post">
	 
		<h3 class="heading">Academics</h3>
		<br>
		
		<div class="tab">
			<a class="tablinks btn btn-lg" onclick="openTabContent(event, 'paces_tab')" id="defaultOpen"> PACEs Progress </a>
			<a class="tablinks btn btn-lg" onclick="openTabContent(event, 'conventional_tab')"> Conventional </a>
			<a class="tablinks btn btn-lg" onclick="openTabContent(event, 'gradesummary_tab')"> Grade Summary </a>
		</div>
		
		
		<div id="paces_tab" class="tabcontent">
			
			<div class="col-md-12">
			<p class="academics-last-update text-center">Last update made by Mr./Ms. <code><?=$lastupdateby?></code></p>
			<div class="form-group row">
			  
			  <table border="0" class="academics-table academics-table-paces">
			  <!--<thead>
				<th></th>
				<th colspan="20"></th>
			  </thead>-->
			  <tbody>
				<tr style="background-color:#F0F0F0;">
					<td style="border-right:1px solid #ccc;" class="text-center">Math<br><code class="text-primary"></code></td>
					<?php
					$math_ctr_ = 1;
					if(strlen(trim($math[0]))>0 and strlen(trim($math[1]))>0){
						for($math_ctr=$math[0];$math_ctr<=$math[1];$math_ctr++){
							if($math_ctr>0){
							$math_qtr_selected = array_key_exists($math_ctr,$_maths)?$_maths[$math_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-primary"><?=$math_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="math_grade[<?=$math_ctr?>]" value="<?=array_key_exists($math_ctr,$_maths)?$_maths[$math_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="math_date[<?=$math_ctr?>]" value="<?=array_key_exists($math_ctr,$_maths)?$_maths[$math_ctr][2]:""?>" class="form-control" /><input name="math_qtr[<?=$math_ctr?>]" value="1" class="text-warning" type="radio"<?=$math_qtr_selected==1?" checked":""?>>&nbsp;<input name="math_qtr[<?=$math_ctr?>]" value="2" type="radio"<?=$math_qtr_selected==2?" checked":""?>>&nbsp;<input name="math_qtr[<?=$math_ctr?>]" value="3" type="radio"<?=$math_qtr_selected==3?" checked":""?>>&nbsp;<input name="math_qtr[<?=$math_ctr?>]" value="4" type="radio"<?=$math_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$math_ctr_++;
							}
						}
					}
					// GAPS
					if(strlen(trim($math[2]))>0){
						$math_gaps = explode(" ",$math[2]);
						foreach($math_gaps as $math_gaps_item){	
							if($math_gaps_item>0){
							$math_qtr_selected = array_key_exists($math_gaps_item,$_maths)?$_maths[$math_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-primary"><?=$math_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="math_grade[<?=$math_gaps_item?>]" value="<?=array_key_exists($math_gaps_item,$_maths)?$_maths[$math_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="math_date[<?=$math_gaps_item?>]" value="<?=array_key_exists($math_gaps_item,$_maths)?$_maths[$math_gaps_item][2]:""?>" class="form-control" /><input name="math_qtr[<?=$math_gaps_item?>]" value="1" type="radio"<?=$math_qtr_selected==1?" checked":""?>>&nbsp;<input name="math_qtr[<?=$math_gaps_item?>]" value="2" type="radio"<?=$math_qtr_selected==2?" checked":""?>>&nbsp;<input name="math_qtr[<?=$math_gaps_item?>]" value="3" type="radio"<?=$math_qtr_selected==3?" checked":""?>>&nbsp;<input name="math_qtr[<?=$math_gaps_item?>]" value="4" type="radio"<?=$math_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$math_ctr_++;}
						}
					}
					if($math_ctr_ < 20){
						//$math_remain = 20 - $math_ctr_;
						for($math_ctr_1=$math_ctr_;$math_ctr_1<=20;$math_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				<tr>
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">English<br><code class="text-info"></code></td>
					<?php
					$eng_ctr_ = 1;
					if(strlen(trim($eng[0]))>0 and strlen(trim($eng[1]))>0){
						for($eng_ctr=$eng[0];$eng_ctr<=$eng[1];$eng_ctr++){
							if($eng_ctr>0){
							$eng_qtr_selected = array_key_exists($eng_ctr,$_engs)?$_engs[$eng_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-info"><?=$eng_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="eng_grade[<?=$eng_ctr?>]" value="<?=array_key_exists($eng_ctr,$_engs)?$_engs[$eng_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="eng_date[<?=$eng_ctr?>]" value="<?=array_key_exists($eng_ctr,$_engs)?$_engs[$eng_ctr][2]:""?>" class="form-control" /><input name="eng_qtr[<?=$eng_ctr?>]" value="1" type="radio"<?=$eng_qtr_selected==1?" checked":""?>>&nbsp;<input name="eng_qtr[<?=$eng_ctr?>]" value="2" type="radio"<?=$eng_qtr_selected==2?" checked":""?>>&nbsp;<input name="eng_qtr[<?=$eng_ctr?>]" value="3" type="radio"<?=$eng_qtr_selected==3?" checked":""?>>&nbsp;<input name="eng_qtr[<?=$eng_ctr?>]" value="4" type="radio"<?=$eng_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$eng_ctr_++;
							}
						}
					}
					// GAPS
					if(strlen(trim($eng[2]))>0){
						$eng_gaps = explode(" ",$eng[2]);
						foreach($eng_gaps as $eng_gaps_item){	
							if($eng_gaps_item>0){
							$eng_qtr_selected = array_key_exists($eng_gaps_item,$_engs)?$_engs[$eng_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-info"><?=$eng_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="eng_grade[<?=$eng_gaps_item?>]" value="<?=array_key_exists($eng_gaps_item,$_engs)?$_engs[$eng_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="eng_date[<?=$eng_gaps_item?>]" value="<?=array_key_exists($eng_gaps_item,$_engs)?$_engs[$eng_gaps_item][2]:""?>" class="form-control" /><input name="eng_qtr[<?=$eng_gaps_item?>]" value="1" type="radio"<?=$eng_qtr_selected==1?" checked":""?>>&nbsp;<input name="eng_qtr[<?=$eng_gaps_item?>]" value="2" type="radio"<?=$eng_qtr_selected==2?" checked":""?>>&nbsp;<input name="eng_qtr[<?=$eng_gaps_item?>]" value="3" type="radio"<?=$eng_qtr_selected==3?" checked":""?>>&nbsp;<input name="eng_qtr[<?=$eng_gaps_item?>]" value="4" type="radio"<?=$eng_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$eng_ctr_++;}
						}
					}
					if($eng_ctr_ < 20){
						//$eng_remain = 20 - $eng_ctr_;
						for($eng_ctr_1=$eng_ctr_;$eng_ctr_1<=20;$eng_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				<tr style="background-color:#F0F0F0;">
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">Science<br><code class="text-success"></code></td>
					<?php
					$science_ctr_ = 1;
					if(strlen(trim($science[0]))>0 and strlen(trim($science[1]))>0){
						for($science_ctr=$science[0];$science_ctr<=$science[1];$science_ctr++){
							if($science_ctr>0){
							$science_qtr_selected = array_key_exists($science_ctr,$_sciences)?$_sciences[$science_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-success"><?=$science_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="science_grade[<?=$science_ctr?>]" value="<?=array_key_exists($science_ctr,$_sciences)?$_sciences[$science_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="science_date[<?=$science_ctr?>]" value="<?=array_key_exists($science_ctr,$_sciences)?$_sciences[$science_ctr][2]:""?>" class="form-control" /><input name="science_qtr[<?=$science_ctr?>]" value="1" type="radio"<?=$science_qtr_selected==1?" checked":""?>>&nbsp;<input name="science_qtr[<?=$science_ctr?>]" value="2" type="radio"<?=$science_qtr_selected==2?" checked":""?>>&nbsp;<input name="science_qtr[<?=$science_ctr?>]" value="3" type="radio"<?=$science_qtr_selected==3?" checked":""?>>&nbsp;<input name="science_qtr[<?=$science_ctr?>]" value="4" type="radio"<?=$science_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$science_ctr_++;
							}
						}
					}
					// GAPS
					if(strlen(trim($science[2]))>0){
						$science_gaps = explode(" ",$science[2]);
						foreach($science_gaps as $science_gaps_item){	
							if($science_gaps_item>0){
							$science_qtr_selected = array_key_exists($science_gaps_item,$_sciences)?$_sciences[$science_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-success"><?=$science_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="science_grade[<?=$science_gaps_item?>]" value="<?=array_key_exists($science_gaps_item,$_sciences)?$_sciences[$science_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="science_date[<?=$science_gaps_item?>]" value="<?=array_key_exists($science_gaps_item,$_sciences)?$_sciences[$science_gaps_item][2]:""?>" class="form-control" /><input name="science_qtr[<?=$science_gaps_item?>]" value="1" type="radio"<?=$science_qtr_selected==1?" checked":""?>>&nbsp;<input name="science_qtr[<?=$science_gaps_item?>]" value="2" type="radio"<?=$science_qtr_selected==2?" checked":""?>>&nbsp;<input name="science_qtr[<?=$science_gaps_item?>]" value="3" type="radio"<?=$science_qtr_selected==3?" checked":""?>>&nbsp;<input name="science_qtr[<?=$science_gaps_item?>]" value="4" type="radio"<?=$science_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$science_ctr_++;}
						}
					}
					if($science_ctr_ < 20){
						//$science_remain = 20 - $science_ctr_;
						for($science_ctr_1=$science_ctr_;$science_ctr_1<=20;$science_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				
				<tr>
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">Soc Studies<br><code class="text-warning"></code></td>
					<?php
					$sstudies_ctr_ = 1;
					if(strlen(trim($sstudies[0]))>0 and strlen(trim($sstudies[1]))>0){
						for($sstudies_ctr=$sstudies[0];$sstudies_ctr<=$sstudies[1];$sstudies_ctr++){
							if($sstudies_ctr>0){
							$sstudies_qtr_selected = array_key_exists($sstudies_ctr,$_sstudiess)?$_sstudiess[$sstudies_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-warning"><?=$sstudies_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="sstudies_grade[<?=$sstudies_ctr?>]" value="<?=array_key_exists($sstudies_ctr,$_sstudiess)?$_sstudiess[$sstudies_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="sstudies_date[<?=$sstudies_ctr?>]" value="<?=array_key_exists($sstudies_ctr,$_sstudiess)?$_sstudiess[$sstudies_ctr][2]:""?>" class="form-control" /><input name="sstudies_qtr[<?=$sstudies_ctr?>]" value="1" type="radio"<?=$sstudies_qtr_selected==1?" checked":""?>>&nbsp;<input name="sstudies_qtr[<?=$sstudies_ctr?>]" value="2" type="radio"<?=$sstudies_qtr_selected==2?" checked":""?>>&nbsp;<input name="sstudies_qtr[<?=$sstudies_ctr?>]" value="3" type="radio"<?=$sstudies_qtr_selected==3?" checked":""?>>&nbsp;<input name="sstudies_qtr[<?=$sstudies_ctr?>]" value="4" type="radio"<?=$sstudies_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$sstudies_ctr_++;
							}
						}
					}
					// GAPS
					if(strlen(trim($sstudies[2]))>0){
						$sstudies_gaps = explode(" ",$sstudies[2]);
						foreach($sstudies_gaps as $sstudies_gaps_item){	
							if($sstudies_gaps_item>0){
							$sstudies_qtr_selected = array_key_exists($sstudies_gaps_item,$_sstudiess)?$_sstudiess[$sstudies_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-warning"><?=$sstudies_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="sstudies_grade[<?=$sstudies_gaps_item?>]" value="<?=array_key_exists($sstudies_gaps_item,$_sstudiess)?$_sstudiess[$sstudies_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="sstudies_date[<?=$sstudies_gaps_item?>]" value="<?=array_key_exists($sstudies_gaps_item,$_sstudiess)?$_sstudiess[$sstudies_gaps_item][2]:""?>" class="form-control" /><input name="sstudies_qtr[<?=$sstudies_gaps_item?>]" value="1" type="radio"<?=$sstudies_qtr_selected==1?" checked":""?>>&nbsp;<input name="sstudies_qtr[<?=$sstudies_gaps_item?>]" value="2" type="radio"<?=$sstudies_qtr_selected==2?" checked":""?>>&nbsp;<input name="sstudies_qtr[<?=$sstudies_gaps_item?>]" value="3" type="radio"<?=$sstudies_qtr_selected==3?" checked":""?>>&nbsp;<input name="sstudies_qtr[<?=$sstudies_gaps_item?>]" value="4" type="radio"<?=$sstudies_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$sstudies_ctr_++;}
						}
					}
					if($sstudies_ctr_ < 20){
						//$sstudies_remain = 20 - $sstudies_ctr_;
						for($sstudies_ctr_1=$sstudies_ctr_;$sstudies_ctr_1<=20;$sstudies_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				
				<tr style="background-color:#F0F0F0;">
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">WBldg<br><code class="text-danger"></code></td>
					<?php
					$wbuilding_ctr_ = 1;
					if(strlen(trim($wbuilding[0]))>0 and strlen(trim($wbuilding[1]))>0){
						for($wbuilding_ctr=$wbuilding[0];$wbuilding_ctr<=$wbuilding[1];$wbuilding_ctr++){
							if($wbuilding_ctr>0){
							$wbuilding_qtr_selected = array_key_exists($wbuilding_ctr,$_wbuildings)?$_wbuildings[$wbuilding_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-danger"><?=$wbuilding_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="wbuilding_grade[<?=$wbuilding_ctr?>]" value="<?=array_key_exists($wbuilding_ctr,$_wbuildings)?$_wbuildings[$wbuilding_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="wbuilding_date[<?=$wbuilding_ctr?>]" value="<?=array_key_exists($wbuilding_ctr,$_wbuildings)?$_wbuildings[$wbuilding_ctr][2]:""?>" class="form-control" /><input name="wbuilding_qtr[<?=$wbuilding_ctr?>]" value="1" type="radio"<?=$wbuilding_qtr_selected==1?" checked":""?>>&nbsp;<input name="wbuilding_qtr[<?=$wbuilding_ctr?>]" value="2" type="radio"<?=$wbuilding_qtr_selected==2?" checked":""?>>&nbsp;<input name="wbuilding_qtr[<?=$wbuilding_ctr?>]" value="3" type="radio"<?=$wbuilding_qtr_selected==3?" checked":""?>>&nbsp;<input name="wbuilding_qtr[<?=$wbuilding_ctr?>]" value="4" type="radio"<?=$wbuilding_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$wbuilding_ctr_++;
							}
						}
					}
					// GAPS
					if(strlen(trim($wbuilding[2]))>0){
						$wbuilding_gaps = explode(" ",$wbuilding[2]);
						foreach($wbuilding_gaps as $wbuilding_gaps_item){	
							if($wbuilding_gaps_item>0){
							$wbuilding_qtr_selected = array_key_exists($wbuilding_gaps_item,$_wbuildings)?$_wbuildings[$wbuilding_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-danger"><?=$wbuilding_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="wbuilding_grade[<?=$wbuilding_gaps_item?>]" value="<?=array_key_exists($wbuilding_gaps_item,$_wbuildings)?$_wbuildings[$wbuilding_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="wbuilding_date[<?=$wbuilding_gaps_item?>]" value="<?=array_key_exists($wbuilding_gaps_item,$_wbuildings)?$_wbuildings[$wbuilding_gaps_item][2]:""?>" class="form-control" /><input name="wbuilding_qtr[<?=$wbuilding_gaps_item?>]" value="1" type="radio"<?=$wbuilding_qtr_selected==1?" checked":""?>>&nbsp;<input name="wbuilding_qtr[<?=$wbuilding_gaps_item?>]" value="2" type="radio"<?=$wbuilding_qtr_selected==2?" checked":""?>>&nbsp;<input name="wbuilding_qtr[<?=$wbuilding_gaps_item?>]" value="3" type="radio"<?=$wbuilding_qtr_selected==3?" checked":""?>>&nbsp;<input name="wbuilding_qtr[<?=$wbuilding_gaps_item?>]" value="4" type="radio"<?=$wbuilding_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$wbuilding_ctr_++;}
						}
					}
					if($wbuilding_ctr_ < 20){
						//$wbuilding_remain = 20 - $wbuilding_ctr_;
						for($wbuilding_ctr_1=$wbuilding_ctr_;$wbuilding_ctr_1<=20;$wbuilding_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				<tr>
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">Literature<br><code class="text-dark"></code></td>
					<?php
					$literature_ctr_ = 1;
					if(strlen(trim($literature[0]))>0 and strlen(trim($literature[1]))>0){
						for($literature_ctr=$literature[0];$literature_ctr<=$literature[1];$literature_ctr++){
							if($literature_ctr>0){
							$literature_qtr_selected = array_key_exists($literature_ctr,$_literatures)?$_literatures[$literature_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-dark"><?=$literature_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="literature_grade[<?=$literature_ctr?>]" value="<?=array_key_exists($literature_ctr,$_literatures)?$_literatures[$literature_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="literature_date[<?=$literature_ctr?>]" value="<?=array_key_exists($literature_ctr,$_literatures)?$_literatures[$literature_ctr][2]:""?>" class="form-control" /><input name="literature_qtr[<?=$literature_ctr?>]" value="1" type="radio"<?=$literature_qtr_selected==1?" checked":""?>>&nbsp;<input name="literature_qtr[<?=$literature_ctr?>]" value="2" type="radio"<?=$literature_qtr_selected==2?" checked":""?>>&nbsp;<input name="literature_qtr[<?=$literature_ctr?>]" value="3" type="radio"<?=$literature_qtr_selected==3?" checked":""?>>&nbsp;<input name="literature_qtr[<?=$literature_ctr?>]" value="4" type="radio"<?=$literature_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$literature_ctr_++;
							}
						}
					}
					// GAPS
					if(strlen(trim($literature[2]))>0){
						$literature_gaps = explode(" ",$literature[2]);
						foreach($literature_gaps as $literature_gaps_item){	
							if($literature_gaps_item>0){
							$literature_qtr_selected = array_key_exists($literature_gaps_item,$_literatures)?$_literatures[$literature_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-danger"><?=$literature_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="literature_grade[<?=$literature_gaps_item?>]" value="<?=array_key_exists($literature_gaps_item,$_literatures)?$_literatures[$literature_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="literature_date[<?=$literature_gaps_item?>]" value="<?=array_key_exists($literature_gaps_item,$_literatures)?$_literatures[$literature_gaps_item][2]:""?>" class="form-control" /><input name="literature_qtr[<?=$literature_gaps_item?>]" value="1" type="radio"<?=$literature_qtr_selected==1?" checked":""?>>&nbsp;<input name="literature_qtr[<?=$literature_gaps_item?>]" value="2" type="radio"<?=$literature_qtr_selected==2?" checked":""?>>&nbsp;<input name="literature_qtr[<?=$literature_gaps_item?>]" value="3" type="radio"<?=$literature_qtr_selected==3?" checked":""?>>&nbsp;<input name="literature_qtr[<?=$literature_gaps_item?>]" value="4" type="radio"<?=$literature_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$literature_ctr_++;}
						}
					}
					if($literature_ctr_ < 20){
						//$literature_remain = 20 - $literature_ctr_;
						for($literature_ctr_1=$literature_ctr_;$literature_ctr_1<=20;$literature_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				<tr style="background-color:#F0F0F0;">
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">Filipino<br><code class="text-primary"></code></td>
					<?php
					$filipino_ctr_ = 1;
					if(strlen(trim($filipino[0]))>0 and strlen(trim($filipino[1]))>0){
						for($filipino_ctr=$filipino[0];$filipino_ctr<=$filipino[1];$filipino_ctr++){
							if($filipino_ctr>0){
							$filipino_qtr_selected = array_key_exists($filipino_ctr,$_filipinos)?$_filipinos[$filipino_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-primary"><?=$filipino_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="filipino_grade[<?=$filipino_ctr?>]" value="<?=array_key_exists($filipino_ctr,$_filipinos)?$_filipinos[$filipino_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="filipino_date[<?=$filipino_ctr?>]" value="<?=array_key_exists($filipino_ctr,$_filipinos)?$_filipinos[$filipino_ctr][2]:""?>" class="form-control" /><input name="filipino_qtr[<?=$filipino_ctr?>]" value="1" type="radio"<?=$filipino_qtr_selected==1?" checked":""?>>&nbsp;<input name="filipino_qtr[<?=$filipino_ctr?>]" value="2" type="radio"<?=$filipino_qtr_selected==2?" checked":""?>>&nbsp;<input name="filipino_qtr[<?=$filipino_ctr?>]" value="3" type="radio"<?=$filipino_qtr_selected==3?" checked":""?>>&nbsp;<input name="filipino_qtr[<?=$filipino_ctr?>]" value="4" type="radio"<?=$filipino_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$filipino_ctr_++;
							}
						}
					}
					//GAPS
					if(strlen(trim($filipino[2]))>0){
						$filipino_gaps = explode(" ",$filipino[2]);
						foreach($filipino_gaps as $filipino_gaps_item){	
							if($filipino_gaps_item>0){
							$filipino_qtr_selected = array_key_exists($filipino_gaps_item,$_filipinos)?$_filipinos[$filipino_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-danger"><?=$filipino_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="filipino_grade[<?=$filipino_gaps_item?>]" value="<?=array_key_exists($filipino_gaps_item,$_filipinos)?$_filipinos[$filipino_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="filipino_date[<?=$filipino_gaps_item?>]" value="<?=array_key_exists($filipino_gaps_item,$_filipinos)?$_filipinos[$filipino_gaps_item][2]:""?>" class="form-control" /><input name="filipino_qtr[<?=$filipino_gaps_item?>]" value="1" type="radio"<?=$filipino_qtr_selected==1?" checked":""?>>&nbsp;<input name="filipino_qtr[<?=$filipino_gaps_item?>]" value="2" type="radio"<?=$filipino_qtr_selected==2?" checked":""?>>&nbsp;<input name="filipino_qtr[<?=$filipino_gaps_item?>]" value="3" type="radio"<?=$filipino_qtr_selected==3?" checked":""?>>&nbsp;<input name="filipino_qtr[<?=$filipino_gaps_item?>]" value="4" type="radio"<?=$filipino_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$filipino_ctr_++;}
						}
					}
					if($filipino_ctr_ < 20){
						//$filipino_remain = 20 - $filipino_ctr_;
						for($filipino_ctr_1=$filipino_ctr_;$filipino_ctr_1<=20;$filipino_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				<tr style="background-color:#F0F0F0;">
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">Alfabetong Filipino<br><code class="text-primary"></code></td>
					<?php
					$afilipino_ctr_ = 1;
					if(strlen(trim($afilipino[0]))>0 and strlen(trim($afilipino[1]))>0){
						for($afilipino_ctr=$afilipino[0];$afilipino_ctr<=$afilipino[1];$afilipino_ctr++){
							if($afilipino_ctr>0){
							$afilipino_qtr_selected = array_key_exists($afilipino_ctr,$_afilipinos)?$_afilipinos[$afilipino_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-primary"><?=$afilipino_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="afilipino_grade[<?=$afilipino_ctr?>]" value="<?=array_key_exists($afilipino_ctr,$_afilipinos)?$_afilipinos[$afilipino_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="afilipino_date[<?=$afilipino_ctr?>]" value="<?=array_key_exists($afilipino_ctr,$_afilipinos)?$_afilipinos[$afilipino_ctr][2]:""?>" class="form-control" /><input name="afilipino_qtr[<?=$afilipino_ctr?>]" value="1" type="radio"<?=$afilipino_qtr_selected==1?" checked":""?>>&nbsp;<input name="afilipino_qtr[<?=$afilipino_ctr?>]" value="2" type="radio"<?=$afilipino_qtr_selected==2?" checked":""?>>&nbsp;<input name="afilipino_qtr[<?=$afilipino_ctr?>]" value="3" type="radio"<?=$afilipino_qtr_selected==3?" checked":""?>>&nbsp;<input name="afilipino_qtr[<?=$afilipino_ctr?>]" value="4" type="radio"<?=$afilipino_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$afilipino_ctr_++;
							}
						}
					}
					//GAPS
					if(strlen(trim($afilipino[2]))>0){
						$afilipino_gaps = explode(" ",$afilipino[2]);
						foreach($afilipino_gaps as $afilipino_gaps_item){	
							if($afilipino_gaps_item>0){
							$afilipino_qtr_selected = array_key_exists($afilipino_gaps_item,$_afilipinos)?$_afilipinos[$afilipino_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-danger"><?=$afilipino_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="afilipino_grade[<?=$afilipino_gaps_item?>]" value="<?=array_key_exists($afilipino_gaps_item,$_afilipinos)?$_afilipinos[$afilipino_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="afilipino_date[<?=$afilipino_gaps_item?>]" value="<?=array_key_exists($afilipino_gaps_item,$_afilipinos)?$_afilipinos[$afilipino_gaps_item][2]:""?>" class="form-control" /><input name="afilipino_qtr[<?=$afilipino_gaps_item?>]" value="1" type="radio"<?=$afilipino_qtr_selected==1?" checked":""?>>&nbsp;<input name="afilipino_qtr[<?=$afilipino_gaps_item?>]" value="2" type="radio"<?=$afilipino_qtr_selected==2?" checked":""?>>&nbsp;<input name="afilipino_qtr[<?=$afilipino_gaps_item?>]" value="3" type="radio"<?=$afilipino_qtr_selected==3?" checked":""?>>&nbsp;<input name="afilipino_qtr[<?=$afilipino_gaps_item?>]" value="4" type="radio"<?=$afilipino_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$afilipino_ctr_++;}
						}
					}
					if($afilipino_ctr_ < 20){
						//$afilipino_remain = 20 - $afilipino_ctr_;
						for($afilipino_ctr_1=$afilipino_ctr_;$afilipino_ctr_1<=20;$afilipino_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				<tr>
					<td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" class="text-center">AP<br><code class="text-info"></code></td>
					<?php
					$ap_ctr_ = 1;
					if(strlen(trim($ap[0]))>0 and strlen(trim($ap[1]))>0){
						for($ap_ctr=$ap[0];$ap_ctr<=$ap[1];$ap_ctr++){
							if($ap_ctr>0){
							$ap_qtr_selected = array_key_exists($ap_ctr,$_aps)?$_aps[$ap_ctr][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-info"><?=$ap_ctr?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="ap_grade[<?=$ap_ctr?>]" value="<?=array_key_exists($ap_ctr,$_aps)?$_aps[$ap_ctr][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="ap_date[<?=$ap_ctr?>]" value="<?=array_key_exists($ap_ctr,$_aps)?$_aps[$ap_ctr][2]:""?>" class="form-control" /><input name="ap_qtr[<?=$ap_ctr?>]" value="1" type="radio"<?=$ap_qtr_selected==1?" checked":""?>>&nbsp;<input name="ap_qtr[<?=$ap_ctr?>]" value="2" type="radio"<?=$ap_qtr_selected==2?" checked":""?>>&nbsp;<input name="ap_qtr[<?=$ap_ctr?>]" value="3" type="radio"<?=$ap_qtr_selected==3?" checked":""?>>&nbsp;<input name="ap_qtr[<?=$ap_ctr?>]" value="4" type="radio"<?=$ap_qtr_selected==4?" checked":""?>>&nbsp;</td><?php
							$ap_ctr_++;
							}
						}
					}
					//GAPS
					if(strlen(trim($ap[2]))>0){
						$ap_gaps = explode(" ",$ap[2]);
						foreach($ap_gaps as $ap_gaps_item){	
							if($ap_gaps_item>0){
							$ap_qtr_selected = array_key_exists($ap_gaps_item,$_aps)?$_aps[$ap_gaps_item][3]:1;
							?><td style="border-right:1px solid #ccc;border-top:1px solid #ccc;" width="5%" class="text-center"><code class="text-danger"><?=$ap_gaps_item?></code><br><input style="padding:2px;text-align:center" placeholder="%" type="text" name="ap_grade[<?=$ap_gaps_item?>]" value="<?=array_key_exists($ap_gaps_item,$_aps)?$_aps[$ap_gaps_item][1]:""?>" class="form-control" /><br><input style="padding:2px;text-align:center" placeholder="PT" type="text" name="ap_date[<?=$ap_gaps_item?>]" value="<?=array_key_exists($ap_gaps_item,$_aps)?$_aps[$ap_gaps_item][2]:""?>" class="form-control" /><input name="ap_qtr[<?=$ap_gaps_item?>]" value="1" type="radio"<?=$ap_qtr_selected==1?" checked":""?>>&nbsp;<input name="ap_qtr[<?=$ap_gaps_item?>]" value="2" type="radio"<?=$ap_qtr_selected==2?" checked":""?>>&nbsp;<input name="ap_qtr[<?=$ap_gaps_item?>]" value="3" type="radio"<?=$ap_qtr_selected==3?" checked":""?>>&nbsp;<input name="ap_qtr[<?=$ap_gaps_item?>]" value="4" type="radio"<?=$ap_qtr_selected==4?" checked":""?>>&nbsp;</td><?php 
							$ap_ctr_++;}
						}
					}
					if($ap_ctr_ < 20){
						//$ap_remain = 20 - $ap_ctr_;
						for($ap_ctr_1=$ap_ctr_;$ap_ctr_1<=20;$ap_ctr_1++){
							?><td width="5%">&nbsp;</td><?php
						}
					}
					?>
				</tr>
				
				
				
			  </tbody>
			  </table>
			  
			  
			
			  </div>
			  
			 
			</div>
		</div>
		
		<div id="conventional_tab" class="tabcontent">
		
			<div class="col-md-12">
				<p class="academics-last-update text-center">Last update made by Mr./Ms. <code><?=$lastupdateby?></code></p>
				<div class="form-group row">
				  
					<table border="0" width='100%' class="academics-table academics-table-conventional">
						<thead>
							<th width="20%" class="text-center">Subject</th>
							<th width="20%" class="text-center">1st Qtr</th>
							<th width="20%" class="text-center">2nd Qtr</th>
							<th width="20%" class="text-center">3rd Qtr</th>
							<th width="20%" class="text-center">4th Qtr</th>
						</thead>
						<tbody>
						<tr style="background-color:#F0F0F0;">
							<td>SPEECH (E)</td>
							<td><input style="text-align:center" placeholder="%" type="text" name="speech[]" value="<?=$speech[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="speech[]" value="<?=$speech[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="speech[]" value="<?=$speech[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="speech[]" value="<?=$speech[3]?>" class="form-control" /></td>
						</tr><tr>
							<td>MUSIC (E)</td>
							<td><input style="text-align:center" placeholder="%" type="text" name="music[]" value="<?=$music[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="music[]" value="<?=$music[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="music[]" value="<?=$music[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="music[]" value="<?=$music[3]?>" class="form-control" /></td>
						</tr><tr style="background-color:#F0F0F0;">
							<td>BIBLE ELECTIVE</td>
							<td><input style="text-align:center" placeholder="%" type="text" name="bible[]" value="<?=$bible[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="bible[]" value="<?=$bible[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="bible[]" value="<?=$bible[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="bible[]" value="<?=$bible[3]?>" class="form-control" /></td>
						</tr><tr>
							<td>EsP</td>
							<td><input style="text-align:center" placeholder="%" type="text" name="esp[]" value="<?=$esp[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="esp[]" value="<?=$esp[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="esp[]" value="<?=$esp[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="esp[]" value="<?=$esp[3]?>" class="form-control" /></td>
						</tr><tr style="background-color:#F0F0F0;">
							<td>TLE</td>
							<td><input style="text-align:center" placeholder="%" type="text" name="tle[]" value="<?=$tle[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="tle[]" value="<?=$tle[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="tle[]" value="<?=$tle[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="tle[]" value="<?=$tle[3]?>" class="form-control" /></td>
						</tr><tr>
							<td>MAPEH</td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh[]" value="<?=$mapeh[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh[]" value="<?=$mapeh[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh[]" value="<?=$mapeh[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh[]" value="<?=$mapeh[3]?>" class="form-control" /></td>
						</tr><tr>
							<td><code><li>Music</li></code></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh_music[]" value="<?=$mapeh_music[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh_music[]" value="<?=$mapeh_music[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh_music[]" value="<?=$mapeh_music[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="mapeh_music[]" value="<?=$mapeh_music[3]?>" class="form-control" /></td>
						</tr><tr>
							<td><code><li>Arts</li></code></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="arts[]" value="<?=$arts[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="arts[]" value="<?=$arts[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="arts[]" value="<?=$arts[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="arts[]" value="<?=$arts[3]?>" class="form-control" /></td>
						</tr><tr>
							<td><code><li>P.E.</li></code></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="pe[]" value="<?=$pe[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="pe[]" value="<?=$pe[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="pe[]" value="<?=$pe[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="pe[]" value="<?=$pe[3]?>" class="form-control" /></td>
						</tr><tr>
							<td><code><li>Health</li></code></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="health[]" value="<?=$health[0]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="health[]" value="<?=$health[1]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="health[]" value="<?=$health[2]?>" class="form-control" /></td>
							<td><input style="text-align:center" placeholder="%" type="text" name="health[]" value="<?=$health[3]?>" class="form-control" /></td>
						</tr>
						</tbody>
					</table>
				  
				</div>  
			</div>  
		
		</div>
		
		<div id="gradesummary_tab" class="tabcontent">
		<br>
		<p class="academics-empty-state">Grade summary will be available soon.</p>
		</div>
		
		<br>
		<?php 
	  if( $this->session->userdata('current_usertype') == 'Teacher' or $this->session->userdata('current_usertype') == 'Principal'):
		?>
		<div class="col-md-6 academics-actions">
		<input type="submit" class="btn btn-lg btn-primary" value="UPDATE Academics">
		</div>
		<?php endif; ?>
		
		</form>
		
	  </div>
	  
	</div> 
	
</div>

<script>
	$(function(){
		//document.getElementById("defaultOpen").style.display = "block";
		$("#paces_tab").css("display","block");
		$("#defaultOpen").addClass("active");
		//evt.currentTarget.className += " active";
		
		<?php 
		if($this->session->userdata('current_usertype') == 'Parent' or $this->session->userdata('current_usertype') == 'Admin' or $this->session->userdata('current_usertype') == 'Registrar'):?>
		$("input, textarea, select").attr("disabled",true);
		<?php
		endif;
		?>
		
	});
</script>

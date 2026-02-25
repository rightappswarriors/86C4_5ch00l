<?php 
	$row = $query->row(); 
	$data = array( 'row'  => $row );
	
	$file_attached1 = "";
	$file_attached2 = "";
	$file_attached3 = "";
	$file_attached4 = "";
	$file_attached5 = "";
	$file_attached6 = "";
	$file_attached7 = "";
	$file_attached8 = "";
	$isuploadedbefore = 0;
	
	if($query_docs->num_rows()>0){
			
		$isuploadedbefore = 1;
		$path_file = './file_upload/'.$row->id;
		
		$row_docs = $query_docs->row();
		
		if(strlen(trim($row_docs->file1))>0) $file_attached1 = "<a href='../../../".$path_file."/".$row_docs->file1."'>".$row_docs->file1."</a>";
		if(strlen(trim($row_docs->file2))>0) $file_attached2 = "<a href='../../../".$path_file."/".$row_docs->file2."'>".$row_docs->file2."</a>";
		if(strlen(trim($row_docs->file3))>0) $file_attached3 = "<a href='../../../".$path_file."/".$row_docs->file3."'>".$row_docs->file3."</a>";
		if(strlen(trim($row_docs->file4))>0) $file_attached4 = "<a href='../../../".$path_file."/".$row_docs->file4."'>".$row_docs->file4."</a>";
		if(strlen(trim($row_docs->file5))>0) $file_attached5 = "<a href='../../../".$path_file."/".$row_docs->file5."'>".$row_docs->file5."</a>";
		if(strlen(trim($row_docs->file6))>0) $file_attached6 = "<a href='../../../".$path_file."/".$row_docs->file6."'>".$row_docs->file6."</a>";
		if(strlen(trim($row_docs->file7))>0) $file_attached7 = "<a href='../../../".$path_file."/".$row_docs->file7."'>".$row_docs->file7."</a>";
		if(strlen(trim($row_docs->file8))>0) $file_attached8 = "<a href='../../../".$path_file."/".$row_docs->file8."'>".$row_docs->file8."</a>";
		
	}
	
?>

<?php $this->load->view("students/menu",$data) ?>

<div class="col-lg-12 grid-margin stretch-card">

	<div class="card">
	  <div class="card-body">
		
		<?php
		if($this->session->flashdata('message'))
		{
			echo '<div class="text-warning" style="margin-bottom:10px;">
				'.$this->session->flashdata("message").'
			</div>';
		}
		?>	
		
		<h3 class="heading" style="text-align:center;">Requirements/Docs</h3>
		<hr>
		
		<?= form_open_multipart("students/docs_submit/".$row->id) ?>
		<input type="hidden" name="isuploadedbefore" value="<?=$isuploadedbefore?>">
		
		<p>Please upload necessary requirements.</p>
		<p class="text-warning">NOTE: Upload file size not greater than 5mb.  Acceptable file type (.pdf, .docx, .doc, .jpg, .png, .gif).  Don't just take picture the documents.  It should be scanned file or using a SCAN APP on your mobile.<br>
		<br><span class="text-danger" style="font-weight:bold;">PLEASE UPLOAD ONE FILE at a time, especially when file is too large.</span></p>
		
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">PROFILE PHOTO (for ID)</label>
			<div class="col-sm-8">
			  <input type="file" name="file8">
			  <br><?= $file_attached8 ?>
			</div>
		  </div>
		</div>
		<hr>
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">Kindergarten Certificate of Completion for those entering Grade 1.</label>
			<div class="col-sm-8">
			  <input type="file" name="file1">
			  <br><?= $file_attached1 ?>
			</div>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">PSA Birth Certificate</label>
			<div class="col-sm-8">
			  <input type="file" name="file2">
			  <br><?= $file_attached2 ?>
			</div>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">Form 138</label>
			<div class="col-sm-8">
			  <input type="file" name="file3">
			  <br><?= $file_attached3 ?>
			</div>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">Master Record Sheet for students using the SOT System</label>
			<div class="col-sm-8">
			  <input type="file" name="file4">
			  <br><?= $file_attached4 ?>
			</div>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">Certificate of Good Moral Character from school last attended.</label>
			<div class="col-sm-8">
			  <input type="file" name="file5">
			  <br><?= $file_attached5 ?>
			</div>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">Vaccination Record</label>
			<div class="col-sm-8">
			  <input type="file" name="file6">
			  <br><?= $file_attached6 ?>
			</div>
		  </div>
		</div>
		
		<div class="col-md-12">
		  <div class="form-group row">
			<label class="col-sm-4 col-form-label">Clearance from Previous School Year</label>
			<div class="col-sm-8">
			  <input type="file" name="file7">
			  <br><?= $file_attached7 ?>
			</div>
		  </div>
		</div>
		<hr>
		<div class="col-md-12" style="text-align:center;">
			<input type="submit" class="btn btn-lg btn-primary" value="Submit File(s)">
		</div>
		
		</form>
		
	  </div>
	</div> 
	
</div>
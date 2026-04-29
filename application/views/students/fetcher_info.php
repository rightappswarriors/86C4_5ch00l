<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_list.css">

<?php
// Get the query data
$records = $query ? $query : [];
$record_count = count($records);

// Check if we're showing a single record
$is_single_record = ($record_count == 1 && $this->uri->segment(3));
$row = $is_single_record ? $records[0] : null;
?>

<div class="col-lg-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">

			<?php
			if ($this->session->flashdata('message')) {
				echo '<div class="alert alert-success" style="margin-bottom:10px;">
				' . $this->session->flashdata("message") . '
			</div>';
			}
			?>

			<h3 class="students-header" style="text-align:center;">Fetcher Information</h3>
			
			<?php if ($is_single_record): ?>
				<!-- Single Record View -->
				<p class="text-center text-muted mb-4">Detailed view of fetcher application</p>
				
				<?php 
				$fetcher_data = json_decode($row->fetcher_data ?? '[]', true);
				$student_data = json_decode($row->student_data ?? '[]', true);
				$reg_date = date('F j, Y', strtotime($row->registered_date ?? 'now'));
				?>
				
				<div style="max-width: 800px; margin: 0 auto;">
					<!-- Application Info -->
					<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
						<div class="row">
							<div class="col-md-6">
								<strong>Application ID:</strong> #<?= $row->id ?>
							</div>
							<div class="col-md-6">
								<strong>Registered Date:</strong> <?= $reg_date ?>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-6">
								<strong>Number of Fetchers:</strong> <?= count($fetcher_data) ?>
							</div>
							<div class="col-md-6">
								<strong>Number of Students:</strong> <?= count($student_data) ?>
							</div>
						</div>
					</div>
					
					<!-- Fetchers Information -->
					<h4 style="color: #1e40af; border-bottom: 2px solid #1e40af; padding-bottom: 5px;">Authorized Fetchers</h4>
					
					<?php if (!empty($fetcher_data)): ?>
						<?php foreach ($fetcher_data as $index => $fetcher): 
							$full_name = trim(($fetcher['firstname'] ?? '') . ' ' . ($fetcher['middlename'] ?? '') . ' ' . ($fetcher['lastname'] ?? ''));
						?>
						<div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: #fff;">
							<div class="row">
								<div class="col-md-8">
									<h5 style="color: #1e40af; margin: 0 0 10px 0;">Fetcher #<?= $index + 1 ?>: <?= htmlspecialchars($full_name) ?></h5>
									<p style="margin: 5px 0;"><strong>Relationship:</strong> <?= htmlspecialchars($fetcher['relationship'] ?? 'N/A') ?></p>
									<p style="margin: 5px 0;"><strong>Contact:</strong> <?= htmlspecialchars($fetcher['contact_number'] ?? 'N/A') ?></p>
									<p style="margin: 5px 0;"><strong>Email:</strong> <?= htmlspecialchars($fetcher['email'] ?? 'N/A') ?></p>
								</div>
								<div class="col-md-4 text-center">
									<?php if (!empty($fetcher['photo_url'] ?? ($index == 0 ? $row->fetcher_1_photo : ($index == 1 ? $row->fetcher_2_photo : ($index == 2 ? $row->fetcher_3_photo : $row->fetcher_4_photo))))): ?>
										<img src="<?= base_url() ?>assets/images/fetcher_photos/<?= $index == 0 ? $row->fetcher_1_photo : ($index == 1 ? $row->fetcher_2_photo : ($index == 2 ? $row->fetcher_3_photo : $row->fetcher_4_photo)) ?>" 
											 alt="Fetcher Photo" 
											 style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #1e40af; border-radius: 5px;">
									<?php else: ?>
										<div style="width: 100px; height: 100px; border: 2px dashed #ccc; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: #999; font-size: 12px; text-align: center;">
											No Photo<br>Uploaded
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="alert alert-warning">No fetcher information available.</div>
					<?php endif; ?>
					
					<!-- Students Information -->
					<?php if (!empty($student_data)): ?>
					<h4 style="color: #1e40af; border-bottom: 2px solid #1e40af; padding-bottom: 5px; margin-top: 30px;">Authorized Students</h4>
					
					<div class="table-responsive">
						<table class="table table-striped">
							<thead style="background: #1e40af; color: white;">
								<tr>
									<th>Student Name</th>
									<th>Grade/Yr</th>
									<th>Section</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($student_data as $student): ?>
								<tr>
									<td><?= htmlspecialchars($student['fullname'] ?? '') ?></td>
									<td><?= htmlspecialchars($student['grade'] ?? '') ?></td>
									<td><?= htmlspecialchars($student['section'] ?? '') ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php endif; ?>
					
					<!-- Action Buttons -->
					<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
						<a href="<?= site_url("students/fetcher_register/".$row->id) ?>" class="btn btn-primary">
							<i class="mdi mdi-pencil"></i> Edit Fetcher Information
						</a>
						<a href="<?= site_url("students/fetcher_info") ?>" class="btn btn-secondary">
							<i class="mdi mdi-arrow-left"></i> Back to List
						</a>
						<?php if ($this->session->userdata('current_usertype') != 'Parent'): ?>
						<a href="<?= site_url("students/fetcher_print/".$row->id) ?>" target="_blank" class="btn btn-info">
							<i class="mdi mdi-printer"></i> Print Fetcher ID
						</a>
						<?php endif; ?>
					</div>
				</div>
				
			<?php else: ?>
				<!-- List View (Multiple Records) -->
				<p class="text-center text-muted mb-4">Registered fetcher ID applications</p>
				
				<?php if ($this->session->userdata('current_usertype') != 'Parent'): ?>
				<!-- <div class="d-flex justify-content-between" style="margin-bottom: 15px;">
					<a href="<?= site_url("students/fetcher_register") ?>" type="button" class="btn btn-success">
						<i class="mdi mdi-plus"></i> New Application
					</a>
				</div> -->
				<?php endif; ?>

				<table class="table students-table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Application No.</th>
							<th>Fetchers</th>
							<th>Students</th>
							<th>Date Registered</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($record_count > 0):
							$i = 1;
							foreach ($records as $row):
								$fetcher_data = json_decode($row->fetcher_data, true);
								$student_data = json_decode($row->student_data, true);

								$fetcher_count = count($fetcher_data);
								$student_count = count($student_data);

								$fetcher_names = '';
								foreach ($fetcher_data as $f) {
									$fetcher_names .= ($f['firstname'] ?? '') . ' ' . ($f['lastname'] ?? '') . ', ';
								}
								$fetcher_names = rtrim($fetcher_names, ', ');

								$student_names = '';
								foreach ($student_data as $s) {
									$student_names .= ($s['fullname'] ?? '') . ', ';
								}
								$student_names = rtrim($student_names, ', ');
							?>
							<tr>
								<td><?= $i++ ?></td>
								<td>#<?= $row->id ?></td>
								<td><?= htmlspecialchars($fetcher_names) ?></td>
								<td><?= htmlspecialchars($student_names) ?></td>
								<td><?= date('M j, Y', strtotime($row->registered_date)) ?></td>
								<td>
									<a href="<?= site_url("students/fetcher_info/".$row->id) ?>" class="btn btn-primary btn-sm" title="View Details">
										<i class="mdi mdi-eye"></i> View
									</a>
									<?php if ($this->session->userdata('current_usertype') != 'Parent'): ?>
									<a href="<?= site_url("students/fetcher_print/".$row->id) ?>" class="btn btn-info btn-sm" target="_blank" title="Print">
										<i class="mdi mdi-printer"></i> Print
									</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php
							endforeach;
						else:
						?>
						<tr>
							<td colspan="6" style="text-align:center;">No records found.</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			<?php endif; ?>

		</div>
	</div>
</div>
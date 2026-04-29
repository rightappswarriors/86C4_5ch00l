<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_list.css">

<style>
.parent-fetcher-container {
	max-width: 900px;
	margin: 0 auto;
}

.parent-info-box {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white;
	padding: 20px;
	border-radius: 10px;
	margin-bottom: 20px;
	box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.parent-info-box h4 {
	color: white;
	margin: 0 0 10px 0;
	font-size: 18px;
}

.fetcher-card-view {
	border: 2px solid #e1e5e9;
	border-radius: 10px;
	padding: 20px;
	margin-bottom: 20px;
	background: #fff;
	box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.fetcher-card-view h5 {
	color: #2d3748;
	border-bottom: 2px solid #667eea;
	padding-bottom: 10px;
	margin-bottom: 15px;
	font-size: 16px;
}

.info-row {
	display: flex;
	margin-bottom: 10px;
	padding: 8px 0;
	border-bottom: 1px solid #f0f0f0;
}

.info-label {
	width: 140px;
	font-weight: 600;
	color: #4a5568;
	flex-shrink: 0;
}

.info-value {
	flex: 1;
	color: #2d3748;
}

.student-list-box {
	background: #f8f9fa;
	border-radius: 8px;
	padding: 15px;
	margin-top: 15px;
}

.student-item {
	background: white;
	border: 1px solid #e2e8f0;
	border-radius: 6px;
	padding: 12px;
	margin-bottom: 10px;
}

.application-meta {
	background: #f7fafc;
	border-radius: 8px;
	padding: 15px;
	margin-top: 20px;
	font-size: 13px;
	color: #4a5568;
}

.no-records-box {
	text-align: center;
	padding: 40px;
	background: #f8f9fa;
	border-radius: 10px;
	color: #718096;
}

.view-only-badge {
	background: #e2e8f0;
	color: #4a5568;
	padding: 5px 10px;
	border-radius: 20px;
	font-size: 12px;
	font-weight: 600;
	display: inline-block;
	margin-bottom: 15px;
}
</style>

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

			<h3 class="students-header" style="text-align:center;">My Fetcher Information</h3>
			<p class="text-center text-muted mb-4" style="color: #666;">View-only access for parents • Contact school for print requests</p>
			
			<div class="parent-fetcher-container">
				
				<?php if (!empty($user_info)): ?>
				<div class="parent-info-box">
					<h4><i class="mdi mdi-account-circle"></i> Parent Account</h4>
					<p style="margin: 5px 0;"><strong>Name:</strong> <?= htmlspecialchars($user_info->parent_name ?? $user_info->firstname . ' ' . $user_info->lastname) ?></p>
					<p style="margin: 5px 0;"><strong>Email:</strong> <?= htmlspecialchars($user_info->email ?? 'N/A') ?></p>
					<p style="margin: 5px 0;"><strong>Contact:</strong> <?= htmlspecialchars($user_info->contact ?? 'N/A') ?></p>
				</div>
				<?php endif; ?>

				<div class="view-only-badge">
					<i class="mdi mdi-eye"></i> VIEW-ONLY ACCESS
				</div>

				<?php if ($query && count($query) > 0): ?>
				
					<?php foreach ($query as $row): 
						$fetcher_data = json_decode($row->fetcher_data ?? '[]', true);
						$student_data = json_decode($row->student_data ?? '[]', true);
						$reg_date = date('F j, Y', strtotime($row->registered_date ?? 'now'));
					?>
					
					<div class="fetcher-card-view">
						
						<h5>
							<i class="mdi mdi-id-card"></i> 
							Fetcher ID Application #<?= str_pad($row->id, 3, '0', STR_PAD_LEFT) ?>
						</h5>
						
						<div class="application-meta">
							<span><i class="mdi mdi-calendar"></i> Registered: <?= $reg_date ?></span>
							<span style="margin-left: 20px;"><i class="mdi mdi-account-multiple"></i> Fetchers: <?= count($fetcher_data) ?></span>
							<span style="margin-left: 20px;"><i class="mdi mdi-school"></i> Students: <?= count($student_data) ?></span>
						</div>
						
						<?php if (!empty($fetcher_data)): ?>
						
							<h5 style="margin-top: 20px;">
								<i class="mdi mdi-heart"></i> Authorized Fetchers
							</h5>
							
							<?php foreach ($fetcher_data as $index => $fetcher): 
								$full_name = trim(($fetcher['firstname'] ?? '') . ' ' . ($fetcher['middlename'] ?? '') . ' ' . ($fetcher['lastname'] ?? ''));
							?>
							
							<div class="info-row" style="border-left: 3px solid #667eea; padding-left: 15px; margin-left: 0;">
								<div style="width: 100%;">
									<strong><?= $index + 1 ?>. <?= htmlspecialchars($full_name) ?></strong>
									<div style="font-size: 13px; color: #666; margin-top: 5px;">
										<span><i class="mdi mdi-account-tie"></i> Relationship: <?= htmlspecialchars($fetcher['relationship'] ?? 'N/A') ?></span>
										<?php if (!empty($fetcher['contact_number'])): ?>
											<span style="margin-left: 15px;"><i class="mdi mdi-phone"></i> Contact: <?= htmlspecialchars($fetcher['contact_number']) ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							
							<?php if (!empty($fetcher['photo_url']) || !empty($row->{"fetcher_" . ($index + 1) . "_photo"})): ?>
							<div style="margin: 10px 0; text-align: center;">
								<img src="<?= base_url() ?>assets/images/fetcher_photos/<?= $row->{"fetcher_" . ($index + 1) . "_photo"} ?>" 
									 alt="Fetcher Photo" 
									 style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #667eea;">
							</div>
							<?php endif; ?>
							
							<?php endforeach; ?>
							
						<?php else: ?>
							<div class="info-row">
								<div class="info-label">Fetchers:</div>
								<div class="info-value" style="color: #e53e3e;">No fetcher information available</div>
							</div>
						<?php endif; ?>
						
						<?php if (!empty($student_data)): ?>
						
						<div class="student-list-box">
							<h5 style="margin-top: 0; margin-bottom: 15px;">
								<i class="mdi mdi-school"></i> Authorized Students
							</h5>
							
							<?php foreach ($student_data as $student): 
								$full_name = trim($student['fullname'] ?? '');
							?>
							<div class="student-item">
								<strong><?= htmlspecialchars($full_name) ?></strong>
								<div style="font-size: 13px; color: #666; margin-top: 3px;">
									<span><?= htmlspecialchars($student['grade'] ?? '') ?> - <?= htmlspecialchars($student['section'] ?? '') ?></span>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						
						<?php else: ?>
						<div class="student-list-box">
							<p style="margin: 0; color: #e53e3e;">No student information available</p>
						</div>
						<?php endif; ?>
						
						<div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
							<a href="<?= site_url('students/fetcher_register/' . $row->id) ?>" class="btn btn-primary" style="border-radius: 20px;">
								<i class="mdi mdi-pencil"></i> Edit Fetcher Information
							</a>
							<a href="<?= site_url('students/fetcher_infoparents') ?>" class="btn btn-secondary" style="border-radius: 20px;">
								<i class="mdi mdi-arrow-left"></i> Back to All Applications
							</a>
						</div>
						
						<div style="text-align: center; margin-top: 15px; font-size: 11px; color: #a0aec0;">
							<i class="mdi mdi-information-outline"></i> 
							View-only access for parents. To request a printed copy, please contact the school administration.
						</div>
						
					</div>
					
					<?php endforeach; ?>
					
				<?php else: ?>
				
				<div class="no-records-box">
					<i class="mdi mdi-information-outline" style="font-size: 40px; color: #cbd5e0;"></i>
					<h4 style="margin: 10px 0; color: #4a5568;">No Fetcher Applications Found</h4>
					<p style="margin: 0 0 20px 0; color: #718096;">You haven't registered any fetcher applications yet.</p>
					<a href="<?= site_url('students/fetcher_register') ?>" class="btn btn-primary" style="border-radius: 20px;">
						<i class="mdi mdi-plus"></i> Create Your First Fetcher Application
					</a>
				</div>
				
				<?php endif; ?>
				
			</div>
			
		</div>
	</div>
</div>

<script>
$(function() {
	// Add any interactive features here if needed
	console.log('Parent fetcher view loaded');
});
</script>
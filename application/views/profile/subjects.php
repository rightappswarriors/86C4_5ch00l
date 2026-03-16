<?php
$subject_count = count($subjects);
$has_academics = $query_academics->num_rows() > 0;
$row_ac = $has_academics ? $query_academics->row() : null;
?>

<style>
.student-screen {
	background:
		radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 28%),
		linear-gradient(180deg, #fffaf2 0%, #ffffff 100%);
	padding: 0.25rem 0 0;
}
.student-shell {
	border-radius: 22px;
	overflow: hidden;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	background: #fff;
	margin-bottom: 1.5rem;
}
.student-hero {
	background: linear-gradient(135deg, #f59e0b 0%, #d97706 55%, #b45309 100%);
	color: #fff;
	padding: 1.75rem;
	position: relative;
}
.student-hero:before {
	content: "";
	position: absolute;
	inset: 0;
	background: linear-gradient(120deg, rgba(255,255,255,0.18), transparent 40%);
	pointer-events: none;
}
.student-hero-content {
	position: relative;
	z-index: 1;
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
	gap: 1rem;
	flex-wrap: wrap;
}
.student-hero h2 {
	margin: 0 0 .35rem;
	font-weight: 700;
	font-size: 2rem;
}
.student-hero p {
	margin: 0;
	max-width: 680px;
	opacity: 0.92;
}
.hero-chip {
	display: inline-flex;
	align-items: center;
	gap: .45rem;
	background: rgba(255,255,255,0.18);
	border: 1px solid rgba(255,255,255,0.22);
	border-radius: 999px;
	padding: .55rem .9rem;
	font-weight: 600;
	white-space: nowrap;
}
.student-body {
	padding: 1.5rem;
}
.student-metric {
	background: linear-gradient(180deg, #fff9ec 0%, #fff 100%);
	border: 1px solid #f8dfb0;
	border-radius: 18px;
	padding: 1.15rem 1.2rem;
	height: 100%;
}
.student-metric-label {
	color: #7c5b16;
	font-size: .82rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .06em;
	margin-bottom: .45rem;
}
.student-metric-value {
	font-size: 1.7rem;
	font-weight: 700;
	color: #1f2937;
	line-height: 1.1;
}
.student-metric small {
	display: block;
	margin-top: .35rem;
	color: #6b7280;
}
.section-card {
	border: 1px solid #f1e2bf;
	border-radius: 18px;
	background: #fffdfa;
	padding: 1.25rem;
	height: 100%;
}
.section-title {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 1rem;
	margin-bottom: 1rem;
}
.section-title h4 {
	margin: 0;
	font-weight: 700;
	color: #2f2410;
}
.section-kicker {
	color: #9a6b08;
	font-size: .8rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .08em;
}
.subject-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
	gap: .9rem;
}
.subject-tile {
	background: linear-gradient(180deg, #ffffff 0%, #fff7e8 100%);
	border: 1px solid #f3d59a;
	border-radius: 16px;
	padding: 1rem;
	min-height: 115px;
}
.subject-tile-icon {
	width: 42px;
	height: 42px;
	border-radius: 12px;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	background: #fff0c9;
	color: #b45309;
	font-size: 1.2rem;
	margin-bottom: .85rem;
}
.subject-tile h5 {
	margin: 0 0 .25rem;
	font-weight: 700;
	color: #2f2410;
}
.subject-tile p {
	margin: 0;
	color: #6b7280;
	font-size: .9rem;
}
.timeline-card {
	background: #fff;
	border: 1px dashed #efc874;
	border-radius: 16px;
	padding: 1rem;
}
.empty-state {
	border: 1px dashed #e5c57c;
	background: linear-gradient(180deg, #fffaf0 0%, #fff 100%);
	border-radius: 18px;
	padding: 2rem 1.25rem;
	text-align: center;
}
.empty-state i {
	font-size: 2rem;
	color: #d97706;
	margin-bottom: .75rem;
	display: inline-block;
}
.empty-state h5 {
	font-weight: 700;
	margin-bottom: .45rem;
	color: #2f2410;
}
.empty-state p {
	margin: 0;
	color: #6b7280;
}
@media (max-width: 767px) {
	.student-hero h2 { font-size: 1.65rem; }
	.student-body { padding: 1rem; }
}
</style>

<div class="col-md-12 student-screen">
	<div class="student-shell">
		<div class="student-hero">
			<div class="student-hero-content">
				<div>
					<div class="section-kicker">Student Portal</div>
					<h2><i class="mdi mdi-book-open-page-variant"></i> My Subjects</h2>
					<p>Track the subjects currently attached to your active record and see when your academic details were last updated.</p>
				</div>
				<div class="hero-chip">
					<i class="mdi mdi-account-school"></i>
					<span><?=$student->gradelevel ? $student->gradelevel : 'Grade level not set'?></span>
				</div>
			</div>
		</div>

		<div class="student-body">
			<div class="row">
				<div class="col-md-4 grid-margin">
					<div class="student-metric">
						<div class="student-metric-label">Student</div>
						<div class="student-metric-value"><?=$student->firstname?> <?=$student->lastname?></div>
						<small>Viewing the current subject lineup for this account.</small>
					</div>
				</div>
				<div class="col-md-4 grid-margin">
					<div class="student-metric">
						<div class="student-metric-label">Subjects Listed</div>
						<div class="student-metric-value"><?=$subject_count?></div>
						<small>Detected from your enrollment and academics data.</small>
					</div>
				</div>
				<div class="col-md-4 grid-margin">
					<div class="student-metric">
						<div class="student-metric-label">Last Academic Update</div>
						<div class="student-metric-value"><?=$has_academics ? date('M d', strtotime($row_ac->lastupdate)) : 'None'?></div>
						<small>
							<?=$has_academics ? 'Updated by ' . $row_ac->firstname . ' ' . $row_ac->lastname : 'Waiting for adviser or registrar update.'?>
						</small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-8 grid-margin">
					<div class="section-card">
						<div class="section-title">
							<div>
								<div class="section-kicker">Overview</div>
								<h4>Subject Directory</h4>
							</div>
							<div class="hero-chip" style="background:#fff4d8;color:#9a6b08;border-color:#f2d08b;">
								<i class="mdi mdi-format-list-bulleted"></i>
								<span><?=$subject_count?> total</span>
							</div>
						</div>

						<?php if (!empty($subjects)): ?>
							<div class="subject-grid">
								<?php foreach ($subjects as $subject): ?>
									<div class="subject-tile">
										<div class="subject-tile-icon"><i class="mdi mdi-book-education"></i></div>
										<h5><?=$subject?></h5>
										<p>Included in your current enrollment profile.</p>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
							<div class="empty-state">
								<i class="mdi mdi-book-remove-outline"></i>
								<h5>No Subjects Available Yet</h5>
								<p>Your account can open this page now, but the school has not attached subject records to the current enrollment yet.</p>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-lg-4 grid-margin">
					<div class="section-card">
						<div class="section-kicker">Activity</div>
						<h4 class="mb-3">Academic Snapshot</h4>
						<div class="timeline-card mb-3">
							<strong>Status</strong>
							<div class="text-muted mt-1"><?=$student->enrollstatus?></div>
						</div>
						<div class="timeline-card mb-3">
							<strong>Grade Level</strong>
							<div class="text-muted mt-1"><?=$student->gradelevel ? $student->gradelevel : 'Not assigned yet'?></div>
						</div>
						<div class="timeline-card">
							<strong>Update Note</strong>
							<div class="text-muted mt-1">
								<?=$has_academics ? 'Academic data exists for this enrollment.' : 'The page is ready; content will appear once records are added.'?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

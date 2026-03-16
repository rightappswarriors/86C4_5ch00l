<?php
$subject_count = count($subjects);
$status_value = strtolower((string) $student->enrollstatus);
$status_class = 'enroll-pill-neutral';
if ($status_value === 'active') {
	$status_class = 'enroll-pill-success';
} elseif ($status_value === 'pending') {
	$status_class = 'enroll-pill-warning';
} elseif ($status_value === 'inactive') {
	$status_class = 'enroll-pill-danger';
}
?>

<style>
.enrollment-screen {
	background:
		radial-gradient(circle at top right, rgba(239, 68, 68, 0.14), transparent 28%),
		linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
	padding-top: .25rem;
}
.enrollment-shell {
	background: #fff;
	border-radius: 22px;
	overflow: hidden;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	margin-bottom: 1.5rem;
}
.enrollment-hero {
	background: linear-gradient(135deg, #ef4444 0%, #dc2626 60%, #b91c1c 100%);
	color: #fff;
	padding: 1.75rem;
}
.enrollment-hero-wrap {
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
	gap: 1rem;
	flex-wrap: wrap;
}
.enrollment-hero h2 {
	margin: 0 0 .35rem;
	font-weight: 700;
	font-size: 2rem;
}
.enrollment-hero p {
	margin: 0;
	max-width: 720px;
	opacity: .92;
}
.enrollment-chip {
	display: inline-flex;
	align-items: center;
	gap: .45rem;
	padding: .55rem .9rem;
	border-radius: 999px;
	background: rgba(255,255,255,0.16);
	border: 1px solid rgba(255,255,255,0.22);
	font-weight: 600;
}
.enrollment-body {
	padding: 1.5rem;
}
.enroll-stat {
	height: 100%;
	border-radius: 18px;
	padding: 1.15rem 1.2rem;
	background: linear-gradient(180deg, #fff0f0 0%, #ffffff 100%);
	border: 1px solid #f5c2c2;
}
.enroll-stat-label {
	color: #b91c1c;
	font-size: .82rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .06em;
	margin-bottom: .45rem;
}
.enroll-stat-value {
	font-size: 1.7rem;
	font-weight: 700;
	color: #1f2937;
	line-height: 1.1;
}
.enroll-stat small {
	display: block;
	margin-top: .35rem;
	color: #6b7280;
}
.enroll-card {
	border: 1px solid #f4d0d0;
	border-radius: 18px;
	background: #fffdfd;
	padding: 1.25rem;
	height: 100%;
}
.enroll-card h4 {
	margin: 0 0 1rem;
	font-weight: 700;
}
.enroll-list {
	display: grid;
	gap: .85rem;
}
.enroll-item {
	display: flex;
	justify-content: space-between;
	align-items: flex-start;
	gap: 1rem;
	padding-bottom: .85rem;
	border-bottom: 1px solid #f6e3e3;
}
.enroll-item:last-child {
	border-bottom: 0;
	padding-bottom: 0;
}
.enroll-item-label {
	color: #6b7280;
	font-size: .86rem;
	text-transform: uppercase;
	letter-spacing: .06em;
	font-weight: 700;
}
.enroll-item-value {
	text-align: right;
	font-weight: 700;
	color: #111827;
}
.enroll-pill {
	display: inline-flex;
	align-items: center;
	gap: .35rem;
	padding: .42rem .82rem;
	border-radius: 999px;
	font-size: .8rem;
	font-weight: 700;
}
.enroll-pill-success { background: #d1fae5; color: #065f46; }
.enroll-pill-warning { background: #fef3c7; color: #92400e; }
.enroll-pill-danger { background: #fee2e2; color: #991b1b; }
.enroll-pill-neutral { background: #e5e7eb; color: #374151; }
.subject-list {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
	gap: .8rem;
}
.subject-card {
	border: 1px solid #f2caca;
	border-radius: 16px;
	padding: .95rem 1rem;
	background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);
}
.subject-card strong {
	display: block;
	margin-bottom: .25rem;
	color: #7f1d1d;
}
.subject-card span {
	color: #6b7280;
	font-size: .9rem;
}
.enroll-empty {
	border: 1px dashed #ebb4b4;
	background: linear-gradient(180deg, #fff5f5 0%, #fff 100%);
	border-radius: 18px;
	padding: 2rem 1.25rem;
	text-align: center;
}
.enroll-empty i {
	font-size: 2rem;
	color: #dc2626;
	margin-bottom: .8rem;
	display: inline-block;
}
@media (max-width: 767px) {
	.enrollment-hero h2 { font-size: 1.65rem; }
	.enrollment-body { padding: 1rem; }
	.enroll-item { flex-direction: column; }
	.enroll-item-value { text-align: left; }
}
</style>

<div class="col-md-12 enrollment-screen">
	<div class="enrollment-shell">
		<div class="enrollment-hero">
			<div class="enrollment-hero-wrap">
				<div>
					<div class="enroll-stat-label" style="color:#fee2e2;">Student Portal</div>
					<h2><i class="mdi mdi-file-document-outline"></i> Enrollment</h2>
					<p>Review the current enrollment snapshot for this account, including status, identifiers, assessment details, and included subjects.</p>
				</div>
				<div class="enrollment-chip">
					<i class="mdi mdi-school-outline"></i>
					<span><?=$student->gradelevel ? $student->gradelevel : 'No grade level yet'?></span>
				</div>
			</div>
		</div>

		<div class="enrollment-body">
			<div class="row">
				<div class="col-md-4 grid-margin">
					<div class="enroll-stat">
						<div class="enroll-stat-label">Enrollment Status</div>
						<div class="enroll-stat-value">
							<span class="enroll-pill <?=$status_class?>">
								<i class="mdi mdi-check-decagram"></i>
								<?=$student->enrollstatus?>
							</span>
						</div>
						<small><?=$student->newold?> student record</small>
					</div>
				</div>
				<div class="col-md-4 grid-margin">
					<div class="enroll-stat">
						<div class="enroll-stat-label">Listed Subjects</div>
						<div class="enroll-stat-value"><?=$subject_count?></div>
						<small>Subjects currently associated with the page data.</small>
					</div>
				</div>
				<div class="col-md-4 grid-margin">
					<div class="enroll-stat">
						<div class="enroll-stat-label">Assessment Total</div>
						<div class="enroll-stat-value"><?=$assessment ? number_format((float) $assessment->asstotal, 2) : 'N/A'?></div>
						<small><?=$assessment ? 'From the latest assessment summary.' : 'Assessment summary is not available yet.'?></small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 grid-margin">
					<div class="enroll-card">
						<h4>Enrollment Summary</h4>
						<div class="enroll-list">
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Student</div>
									<div class="text-muted">Account holder currently viewing this page</div>
								</div>
								<div class="enroll-item-value"><?=$student->firstname?> <?=$student->lastname?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">School ID</div>
									<div class="text-muted">Portal or student number reference</div>
								</div>
								<div class="enroll-item-value"><?=$student->studentno ? $student->studentno : '-'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">LRN</div>
									<div class="text-muted">Learner reference number</div>
								</div>
								<div class="enroll-item-value"><?=$student->lrn ? $student->lrn : '-'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Strand</div>
									<div class="text-muted">For senior high where applicable</div>
								</div>
								<div class="enroll-item-value"><?=$student->strand ? $student->strand : '-'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Issue PACE</div>
									<div class="text-muted">Academic issuance status</div>
								</div>
								<div class="enroll-item-value"><?=$student->ableforpt ? $student->ableforpt : 'N/A'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Scholar</div>
									<div class="text-muted">Scholarship flag on record</div>
								</div>
								<div class="enroll-item-value"><?=$student->scholar ? $student->scholar : 'No'?></div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6 grid-margin">
					<div class="enroll-card">
						<h4>Assessment Snapshot</h4>
						<div class="enroll-list">
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Grade Level</div>
									<div class="text-muted">Current placement shown in the system</div>
								</div>
								<div class="enroll-item-value"><?=$student->gradelevel ? $student->gradelevel : '-'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Old Account</div>
									<div class="text-muted">Previous balance carried over</div>
								</div>
								<div class="enroll-item-value"><?=$assessment ? number_format((float) $assessment->oldaccount, 2) : 'N/A'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Assessment Total</div>
									<div class="text-muted">Total amount in the latest assessment</div>
								</div>
								<div class="enroll-item-value"><?=$assessment ? number_format((float) $assessment->asstotal, 2) : 'N/A'?></div>
							</div>
							<div class="enroll-item">
								<div>
									<div class="enroll-item-label">Portal Note</div>
									<div class="text-muted">When details are incomplete, the school may still be updating your record.</div>
								</div>
								<div class="enroll-item-value"><?=$assessment ? 'Assessment found' : 'Pending school update'?></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 grid-margin">
					<div class="enroll-card">
						<h4>Included Subjects</h4>
						<?php if (!empty($subjects)): ?>
							<div class="subject-list">
								<?php foreach ($subjects as $subject): ?>
									<div class="subject-card">
										<strong><?=$subject?></strong>
										<span>Included in the current enrollment view.</span>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
							<div class="enroll-empty">
								<i class="mdi mdi-clipboard-remove-outline"></i>
								<h5 class="mb-2">No Subjects Attached Yet</h5>
								<p class="text-muted mb-0">The enrollment page is now available, but there are no subject records linked to this account’s current data yet.</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

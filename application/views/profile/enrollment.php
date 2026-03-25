<?php
$student_name = trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));
$student_name = $student_name !== '' ? $student_name : 'Student';
$subjects = isset($subjects) ? $subjects : array();
?>

<style>
.enrollment-page {
	background: linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
	padding-top: .25rem;
}
.enrollment-shell {
	background: #fff;
	border-radius: 22px;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	overflow: hidden;
	margin-bottom: 1.5rem;
}
.enrollment-hero {
	background: linear-gradient(135deg, #ef4444 0%, #dc2626 55%, #b91c1c 100%);
	color: #fff;
	padding: 1.75rem;
}
.enrollment-body {
	padding: 1.5rem;
}
.enrollment-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
	gap: 1rem;
	margin-bottom: 1rem;
}
.enrollment-card {
	border: 1px solid #fecaca;
	border-radius: 18px;
	padding: 1rem;
	background: #fff5f5;
}
.enrollment-card small {
	display: block;
	text-transform: uppercase;
	font-size: .75rem;
	color: #991b1b;
	margin-bottom: .35rem;
}
.enrollment-card strong {
	font-size: 1rem;
	color: #7f1d1d;
}
.enrollment-list {
	border: 1px solid #fee2e2;
	border-radius: 18px;
	padding: 1rem;
	background: #fff;
}
.enrollment-list ul {
	margin: 0;
	padding-left: 1.25rem;
}
.enrollment-list li {
	margin-bottom: .35rem;
}
.enrollment-empty {
	border: 1px dashed #fca5a5;
	border-radius: 16px;
	padding: 2rem 1rem;
	text-align: center;
	color: #991b1b;
	background: #fff5f5;
}
</style>

<div class="col-md-12 enrollment-page">
	<div class="enrollment-shell">
		<div class="enrollment-hero">
			<h2><i class="mdi mdi-file-document-outline"></i> Enrollment</h2>
			<p>Current enrollment snapshot for <?=htmlspecialchars($student_name)?></p>
		</div>
		<div class="enrollment-body">
			<p><a href="<?=site_url('dashboard')?>"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a></p>

			<div class="enrollment-grid">
				<div class="enrollment-card">
					<small>Status</small>
					<strong><?=htmlspecialchars($student->enrollstatus ?? 'No active enrollment')?></strong>
				</div>
				<div class="enrollment-card">
					<small>Grade Level</small>
					<strong><?=htmlspecialchars($student->gradelevel ?? '-')?></strong>
				</div>
				<div class="enrollment-card">
					<small>Strand</small>
					<strong><?=htmlspecialchars(($student->strand ?? '') !== '' ? $student->strand : '-')?></strong>
				</div>
				<div class="enrollment-card">
					<small>Student Type</small>
					<strong><?=htmlspecialchars(($student->newold ?? '') !== '' ? ucfirst((string) $student->newold) : '-')?></strong>
				</div>
				<div class="enrollment-card">
					<small>Scholar</small>
					<strong><?=htmlspecialchars(($student->scholar ?? '') !== '' ? $student->scholar : 'No')?></strong>
				</div>
				<div class="enrollment-card">
					<small>Interview</small>
					<strong><?=htmlspecialchars(($student->admininterview ?? '') !== '' ? $student->admininterview : 'Pending')?></strong>
				</div>
			</div>

			<div class="enrollment-list">
				<h4>Enrolled Subjects</h4>
				<?php if (count($subjects) > 0): ?>
					<ul>
						<?php foreach ($subjects as $subject): ?>
							<li><?=htmlspecialchars($subject)?></li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<div class="enrollment-empty">
						<i class="mdi mdi-clipboard-remove-outline"></i>
						<div>No subjects are attached to this enrollment yet.</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if (!empty($assessment)): ?>
				<div class="enrollment-list" style="margin-top:1rem;">
					<h4>Assessment Snapshot</h4>
					<ul>
						<li>Registration: <?=number_format((float) $assessment->registration, 2)?></li>
						<li>Enrollment Payment: <?=number_format((float) $assessment->payment, 2)?></li>
						<li>Total Assessment: <?=number_format((float) $assessment->asstotal, 2)?></li>
						<li>Monthly Due: <?=number_format((float) $assessment->monthlydue, 2)?></li>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

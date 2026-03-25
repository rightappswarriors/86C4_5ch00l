<?php
$student_name = trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));
$student_name = $student_name !== '' ? $student_name : 'Student';
$subjects = isset($subjects) ? $subjects : array();
$pace_progress = isset($pace_progress) ? $pace_progress : array();
$conventional_subjects = isset($conventional_subjects) ? $conventional_subjects : array();
?>

<style>
.schedule-page {
	background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
	padding-top: .25rem;
}
.schedule-shell {
	background: #fff;
	border-radius: 22px;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	overflow: hidden;
	margin-bottom: 1.5rem;
}
.schedule-hero {
	background: linear-gradient(135deg, #059669 0%, #10b981 55%, #34d399 100%);
	color: #fff;
	padding: 1.75rem;
}
.schedule-body {
	padding: 1.5rem;
}
.schedule-back {
	display: inline-flex;
	align-items: center;
	gap: .45rem;
	margin-bottom: 1rem;
	font-weight: 600;
}
.schedule-grid {
	display: grid;
	grid-template-columns: 1.2fr .8fr;
	gap: 1rem;
}
.schedule-card {
	border: 1px solid #d1fae5;
	border-radius: 18px;
	padding: 1.1rem;
	background: #fcfffd;
}
.schedule-card h4 {
	margin-bottom: .9rem;
	font-weight: 700;
}
.schedule-list {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
	gap: .75rem;
}
.schedule-pill {
	border-radius: 14px;
	padding: .85rem 1rem;
	background: #ecfdf5;
	border: 1px solid #a7f3d0;
	font-weight: 600;
	color: #065f46;
}
.schedule-note {
	border: 1px dashed #86efac;
	border-radius: 16px;
	padding: 1rem;
	background: #f0fdf4;
	color: #166534;
}
.schedule-table {
	width: 100%;
	border-collapse: collapse;
}
.schedule-table th,
.schedule-table td {
	padding: .75rem;
	border-bottom: 1px solid #e5e7eb;
}
.schedule-table th {
	text-transform: uppercase;
	font-size: .8rem;
	color: #475569;
	background: #f8fafc;
}
.schedule-empty {
	border: 1px dashed #cbd5e1;
	border-radius: 16px;
	padding: 2rem 1rem;
	text-align: center;
	color: #64748b;
	background: #f8fafc;
}
@media (max-width: 900px) {
	.schedule-grid {
		grid-template-columns: 1fr;
	}
}
</style>

<div class="col-md-12 schedule-page">
	<div class="schedule-shell">
		<div class="schedule-hero">
			<h2><i class="mdi mdi-calendar-clock"></i> Class Schedule</h2>
			<p>Learning overview for <?=htmlspecialchars($student_name)?></p>
		</div>
		<div class="schedule-body">
			<a href="<?=site_url('dashboard')?>" class="schedule-back"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a>

			<div class="schedule-grid">
				<div class="schedule-card">
					<h4>Current Subject Load</h4>
					<?php if (count($subjects) > 0): ?>
						<div class="schedule-list">
							<?php foreach ($subjects as $subject): ?>
								<div class="schedule-pill"><?=htmlspecialchars($subject)?></div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<div class="schedule-empty">No enrolled subjects are available yet.</div>
					<?php endif; ?>
				</div>

				<div class="schedule-card">
					<h4>Student Snapshot</h4>
					<table class="schedule-table">
						<tbody>
							<tr><th>Grade Level</th><td><?=htmlspecialchars($student->gradelevel ?? '-')?></td></tr>
							<tr><th>Status</th><td><?=htmlspecialchars($student->enrollstatus ?? 'No active enrollment')?></td></tr>
							<tr><th>PACE Subjects</th><td><?=count($pace_progress)?></td></tr>
							<tr><th>Conventional</th><td><?=count($conventional_subjects)?></td></tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="schedule-card" style="margin-top:1rem;">
				<h4>Published Timetable</h4>
				<div class="schedule-note">
					No dedicated class timetable table exists in the current system yet, so this page shows the student's active learning load and enrollment context instead of fake time slots.
				</div>
			</div>
		</div>
	</div>
</div>

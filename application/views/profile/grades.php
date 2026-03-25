<?php
$student_name = trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));
$student_name = $student_name !== '' ? $student_name : 'Student';
$pace_progress = isset($pace_progress) ? $pace_progress : array();
$conventional_subjects = isset($conventional_subjects) ? $conventional_subjects : array();
$subjects = isset($subjects) ? $subjects : array();
?>

<style>
.student-page {
	background: linear-gradient(180deg, #f6f8ff 0%, #ffffff 100%);
	padding-top: .25rem;
}
.student-shell {
	background: #fff;
	border-radius: 22px;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	overflow: hidden;
	margin-bottom: 1.5rem;
}
.student-hero {
	background: linear-gradient(135deg, #4338ca 0%, #7c3aed 55%, #a855f7 100%);
	color: #fff;
	padding: 1.75rem;
}
.student-hero h2 {
	margin: 0 0 .35rem;
	font-weight: 700;
}
.student-hero p {
	margin: 0;
	opacity: .92;
}
.student-body {
	padding: 1.5rem;
}
.student-back {
	display: inline-flex;
	align-items: center;
	gap: .45rem;
	margin-bottom: 1rem;
	font-weight: 600;
}
.student-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
	gap: 1rem;
	margin-bottom: 1.25rem;
}
.student-stat {
	border: 1px solid #e5e7eb;
	border-radius: 16px;
	padding: 1rem;
	background: #fafbff;
}
.student-stat small {
	display: block;
	color: #64748b;
	margin-bottom: .35rem;
	text-transform: uppercase;
	font-size: .75rem;
}
.student-stat strong {
	font-size: 1rem;
	color: #111827;
}
.student-section {
	border: 1px solid #eef2ff;
	border-radius: 18px;
	padding: 1.1rem;
	margin-bottom: 1rem;
}
.student-section h4 {
	margin-bottom: .9rem;
	font-weight: 700;
}
.student-table {
	width: 100%;
	border-collapse: collapse;
}
.student-table th,
.student-table td {
	padding: .8rem;
	border-bottom: 1px solid #e5e7eb;
	vertical-align: top;
}
.student-table th {
	font-size: .8rem;
	text-transform: uppercase;
	color: #475569;
	background: #f8fafc;
}
.student-empty {
	border: 1px dashed #cbd5e1;
	border-radius: 16px;
	padding: 2rem 1rem;
	text-align: center;
	color: #64748b;
	background: #f8fafc;
}
@media (max-width: 768px) {
	.student-table {
		display: block;
		overflow-x: auto;
	}
}
</style>

<div class="col-md-12 student-page">
	<div class="student-shell">
		<div class="student-hero">
			<h2><i class="mdi mdi-chart-line"></i> My Grades</h2>
			<p>Academic progress and recorded scores for <?=htmlspecialchars($student_name)?></p>
		</div>
		<div class="student-body">
			<a href="<?=site_url('dashboard')?>" class="student-back"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a>

			<div class="student-grid">
				<div class="student-stat">
					<small>Grade Level</small>
					<strong><?=htmlspecialchars($student->gradelevel ?? '-')?></strong>
				</div>
				<div class="student-stat">
					<small>Enrollment Status</small>
					<strong><?=htmlspecialchars($student->enrollstatus ?? 'No active enrollment')?></strong>
				</div>
				<div class="student-stat">
					<small>Subjects Tracked</small>
					<strong><?=count($subjects)?></strong>
				</div>
				<div class="student-stat">
					<small>Student ID</small>
					<strong><?=htmlspecialchars(($student->studentno ?? '') !== '' ? $student->studentno : (($student->school_id ?? '') !== '' ? $student->school_id : '-'))?></strong>
				</div>
			</div>

			<div class="student-section">
				<h4>PACEs Progress</h4>
				<?php if (count($pace_progress) > 0): ?>
					<table class="student-table">
						<thead>
							<tr>
								<th>Subject</th>
								<th>Assigned PACEs</th>
								<th>Recorded</th>
								<th>Average</th>
								<th>Latest Entry</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($pace_progress as $item): ?>
								<tr>
									<td><?=htmlspecialchars($item['label'])?></td>
									<td><?=htmlspecialchars($item['assigned_label'])?></td>
									<td><?=$item['recorded_count']?> / <?=$item['assigned_count']?></td>
									<td><?=$item['average_grade'] !== null ? number_format($item['average_grade'], 2) . '%' : 'No scores yet'?></td>
									<td>
										<?php
										$latest_parts = array();
										if ($item['latest_grade'] !== '') {
											$latest_parts[] = $item['latest_grade'] . '%';
										}
										if ($item['latest_quarter'] !== '') {
											$latest_parts[] = 'Q' . $item['latest_quarter'];
										}
										if ($item['latest_date'] !== '') {
											$latest_parts[] = $item['latest_date'];
										}
										echo count($latest_parts) > 0 ? htmlspecialchars(implode(' | ', $latest_parts)) : 'No entry yet';
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="student-empty">
						<i class="mdi mdi-book-open-page-variant"></i>
						<div>No PACEs assessment has been recorded yet.</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="student-section">
				<h4>Conventional Subjects</h4>
				<?php if (count($conventional_subjects) > 0): ?>
					<table class="student-table">
						<thead>
							<tr>
								<th>Subject</th>
								<th>1st</th>
								<th>2nd</th>
								<th>3rd</th>
								<th>4th</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($conventional_subjects as $item): ?>
								<tr>
									<td><?=htmlspecialchars($item['label'])?></td>
									<?php foreach ($item['quarters'] as $quarter): ?>
										<td><?=htmlspecialchars($quarter !== '' ? $quarter : '-')?></td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="student-empty">
						<i class="mdi mdi-school-outline"></i>
						<div>No conventional subject grades have been posted yet.</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

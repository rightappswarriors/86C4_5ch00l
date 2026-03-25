<?php
$student_name = trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));
$student_name = $student_name !== '' ? $student_name : 'Student';
$subjects = isset($subjects) ? $subjects : array();
?>

<style>
.subjects-page {
	background: linear-gradient(180deg, #fff8ef 0%, #ffffff 100%);
	padding-top: .25rem;
}
.subjects-shell {
	background: #fff;
	border-radius: 22px;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	overflow: hidden;
	margin-bottom: 1.5rem;
}
.subjects-hero {
	background: linear-gradient(135deg, #f59e0b 0%, #ea580c 55%, #c2410c 100%);
	color: #fff;
	padding: 1.75rem;
}
.subjects-body {
	padding: 1.5rem;
}
.subjects-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
	gap: 1rem;
}
.subject-card {
	border: 1px solid #fed7aa;
	border-radius: 18px;
	padding: 1rem;
	background: linear-gradient(180deg, #fff7ed 0%, #ffffff 100%);
}
.subject-card h5 {
	margin: 0 0 .35rem;
	font-weight: 700;
	color: #9a3412;
}
.subject-card p {
	margin: 0;
	color: #7c2d12;
	font-size: .92rem;
}
.subjects-empty {
	border: 1px dashed #fdba74;
	border-radius: 16px;
	padding: 2rem 1rem;
	text-align: center;
	color: #9a3412;
	background: #fff7ed;
}
</style>

<div class="col-md-12 subjects-page">
	<div class="subjects-shell">
		<div class="subjects-hero">
			<h2><i class="mdi mdi-book-open-page-variant"></i> My Subjects</h2>
			<p>Subjects currently linked to <?=htmlspecialchars($student_name)?></p>
		</div>
		<div class="subjects-body">
			<p><a href="<?=site_url('dashboard')?>"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a></p>

			<?php if (count($subjects) > 0): ?>
				<div class="subjects-grid">
					<?php foreach ($subjects as $index => $subject): ?>
						<div class="subject-card">
							<h5><?=htmlspecialchars($subject)?></h5>
							<p>Subject <?=($index + 1)?> in your current enrollment record.</p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<div class="subjects-empty">
					<i class="mdi mdi-book-remove-outline"></i>
					<div>No subjects are attached to the current student record yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

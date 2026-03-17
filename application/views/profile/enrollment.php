<style>
.enrollment-empty-screen {
	background:
		radial-gradient(circle at top right, rgba(239, 68, 68, 0.14), transparent 28%),
		linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
	padding-top: .25rem;
}
.enrollment-empty-shell {
	background: #fff;
	border-radius: 22px;
	overflow: hidden;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	margin-bottom: 1.5rem;
}
.enrollment-empty-hero {
	background: linear-gradient(135deg, #ef4444 0%, #dc2626 60%, #b91c1c 100%);
	color: #fff;
	padding: 1.75rem;
}
.enrollment-empty-hero h2 {
	margin: 0 0 .35rem;
	font-weight: 700;
	font-size: 2rem;
}
.enrollment-empty-hero p {
	margin: 0;
	opacity: .92;
}
.enrollment-empty-body {
	padding: 1.5rem;
}
.enrollment-empty-card {
	border: 1px dashed #ebb4b4;
	border-radius: 18px;
	background: linear-gradient(180deg, #fff5f5 0%, #fff 100%);
	padding: 4rem 1.5rem;
	text-align: center;
}
.enrollment-empty-card i {
	font-size: 2.5rem;
	color: #dc2626;
	margin-bottom: 1rem;
	display: inline-block;
}
.enrollment-empty-card h4 {
	margin-bottom: .5rem;
	font-weight: 700;
	color: #7f1d1d;
}
.enrollment-empty-card p {
	margin: 0;
	color: #6b7280;
}
</style>

<div class="col-md-12 enrollment-empty-screen">
	<div class="enrollment-empty-shell">
		<div class="enrollment-empty-hero">
			<h2><i class="mdi mdi-file-document-outline"></i> Enrollment</h2>
			<p>View your enrollment details here.</p>
		</div>
		<div class="enrollment-empty-body">
			<div class="enrollment-empty-card">
				<i class="mdi mdi-clipboard-remove-outline"></i>
				<h4>Enrollment</h4>
				<p>Enrollment information will appear here.</p>
			</div>
		</div>
	</div>
</div>

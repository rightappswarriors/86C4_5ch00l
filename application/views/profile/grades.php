<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/enrollment.css">
<style>
	.grades-container {
		padding: 1.5rem;
	}
	.grades-card {
		border: none;
		border-radius: 16px;
		box-shadow: 0 4px 20px rgba(0,0,0,0.08);
		overflow: hidden;
		background: #fff;
		margin-bottom: 1.5rem;
	}
	.grades-header {
		background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
		color: white;
		padding: 1.5rem;
		text-align: center;
	}
	.grades-avatar {
		width: 80px;
		height: 80px;
		border-radius: 50%;
		background: white;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 1rem;
		font-size: 2.5rem;
		color: #7c3aed;
		box-shadow: 0 4px 15px rgba(0,0,0,0.2);
	}
	.grades-header h3 {
		margin: 0;
		font-weight: 700;
	}
	.grades-header p {
		margin: 0.5rem 0 0;
		opacity: 0.9;
		font-size: 0.9rem;
	}
	.grades-body {
		padding: 1.5rem;
	}
	.grades-table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 1rem;
	}
	.grades-table th,
	.grades-table td {
		padding: 1rem;
		text-align: left;
		border-bottom: 1px solid #e5e7eb;
	}
	.grades-table th {
		background: #f9fafb;
		font-weight: 600;
		color: #374151;
		font-size: 0.85rem;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}
	.grades-table td {
		color: #6b7280;
	}
	.grades-empty {
		text-align: center;
		padding: 3rem;
		color: #9ca3af;
	}
	.grades-empty i {
		font-size: 3rem;
		margin-bottom: 1rem;
		display: block;
		color: #d1d5db;
	}
	.grades-empty p {
		font-size: 1.1rem;
		margin: 0;
	}
	.back-btn {
		display: inline-flex;
		align-items: center;
		gap: 0.5rem;
		background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
		border: none;
		border-radius: 8px;
		padding: 0.6rem 1.25rem;
		font-weight: 600;
		font-size: 0.9rem;
		color: white;
		cursor: pointer;
		text-decoration: none;
		transition: all 0.3s ease;
		margin-bottom: 1.5rem;
	}
	.back-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
		color: white;
	}
</style>

<div class="col-lg-12 grid-margin grades-container">
	<a href="<?=site_url('students')?>" class="back-btn">
		<i class="mdi mdi-arrow-left"></i> Back to Dashboard
	</a>

	<!-- Grades Display Card -->
	<div class="card grades-card">
		<div class="grades-header">
			<div class="grades-avatar">
				<i class="mdi mdi-school"></i>
			</div>
			<h3>My Grades</h3>
			<p>View your academic performance</p>
		</div>
		<div class="grades-body">
			<table class="grades-table">
				<thead>
					<tr>
						<th>Subject</th>
						<th>Grade</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="3" class="grades-empty">
							<i class="mdi mdi-book-open-page-variant"></i>
							<p>No grades available yet</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

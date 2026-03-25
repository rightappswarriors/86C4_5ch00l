<?php
$student_name = trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));
$student_name = $student_name !== '' ? $student_name : 'Student';
?>

<style>
.payments-page {
	background: linear-gradient(180deg, #f0fdf9 0%, #ffffff 100%);
	padding-top: .25rem;
}
.payments-shell {
	background: #fff;
	border-radius: 22px;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	overflow: hidden;
	margin-bottom: 1.5rem;
}
.payments-hero {
	background: linear-gradient(135deg, #10b981 0%, #059669 55%, #047857 100%);
	color: #fff;
	padding: 1.75rem;
}
.payments-body {
	padding: 1.5rem;
}
.payments-stats {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
	gap: 1rem;
	margin-bottom: 1rem;
}
.payments-stat {
	border: 1px solid #a7f3d0;
	border-radius: 16px;
	padding: 1rem;
	background: #f0fdf4;
}
.payments-stat small {
	display: block;
	text-transform: uppercase;
	font-size: .75rem;
	color: #047857;
	margin-bottom: .35rem;
}
.payments-stat strong {
	font-size: 1.1rem;
	color: #064e3b;
}
.payments-table {
	width: 100%;
	border-collapse: collapse;
}
.payments-table th,
.payments-table td {
	padding: .8rem;
	border-bottom: 1px solid #e5e7eb;
}
.payments-table th {
	text-transform: uppercase;
	font-size: .8rem;
	background: #f8fafc;
	color: #475569;
}
.payments-empty {
	border: 1px dashed #86efac;
	border-radius: 16px;
	padding: 2rem 1rem;
	text-align: center;
	color: #166534;
	background: #f0fdf4;
}
@media (max-width: 768px) {
	.payments-table {
		display: block;
		overflow-x: auto;
	}
}
</style>

<div class="col-md-12 payments-page">
	<div class="payments-shell">
		<div class="payments-hero">
			<h2><i class="mdi mdi-credit-card-outline"></i> Payments</h2>
			<p>Transaction history for <?=htmlspecialchars($student_name)?></p>
		</div>
		<div class="payments-body">
			<p><a href="<?=site_url('dashboard')?>"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a></p>

			<div class="payments-stats">
				<div class="payments-stat">
					<small>Total Transactions</small>
					<strong><?=$query_payments->num_rows()?></strong>
				</div>
				<div class="payments-stat">
					<small>Paid Transactions</small>
					<strong><?=isset($paid_count) ? (int) $paid_count : 0?></strong>
				</div>
				<div class="payments-stat">
					<small>Total Amount</small>
					<strong><?=number_format((float) (isset($total_amount) ? $total_amount : 0), 2)?></strong>
				</div>
			</div>

			<?php if ($query_payments->num_rows() > 0): ?>
				<table class="payments-table">
					<thead>
						<tr>
							<th>Code</th>
							<th>Date</th>
							<th>Amount</th>
							<th>Type</th>
							<th>Status</th>
							<th>Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($query_payments->result() as $payment): ?>
							<tr>
								<td><?=htmlspecialchars($payment->payment_code)?></td>
								<td><?=htmlspecialchars($payment->payment_date)?></td>
								<td><?=number_format((float) $payment->payment_total, 2)?></td>
								<td><?=strtolower((string) $payment->enrollpay) === 'yes' ? 'Enrollment' : 'Other'?></td>
								<td><?=htmlspecialchars(ucfirst((string) $payment->paid))?></td>
								<td><?=htmlspecialchars(trim((string) $payment->payment_note) !== '' ? $payment->payment_note : '-')?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="payments-empty">
					<i class="mdi mdi-cash-remove"></i>
					<div>No payment records are available for this account yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

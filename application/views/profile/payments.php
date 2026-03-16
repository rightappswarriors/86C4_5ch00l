<?php
$transaction_count = $query_payments->num_rows();
$unpaid_count = max($transaction_count - $paid_count, 0);
?>

<style>
.payments-screen {
	background:
		radial-gradient(circle at top right, rgba(16, 185, 129, 0.15), transparent 30%),
		linear-gradient(180deg, #f3fff9 0%, #ffffff 100%);
	padding-top: .25rem;
}
.payments-shell {
	background: #fff;
	border-radius: 22px;
	overflow: hidden;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	margin-bottom: 1.5rem;
}
.payments-hero {
	background: linear-gradient(135deg, #10b981 0%, #059669 60%, #047857 100%);
	color: #fff;
	padding: 1.75rem;
}
.payments-hero-wrap {
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
	flex-wrap: wrap;
	gap: 1rem;
}
.payments-hero h2 {
	margin: 0 0 .35rem;
	font-weight: 700;
	font-size: 2rem;
}
.payments-hero p {
	margin: 0;
	max-width: 680px;
	opacity: .92;
}
.payments-chip {
	display: inline-flex;
	align-items: center;
	gap: .45rem;
	border-radius: 999px;
	padding: .55rem .9rem;
	font-weight: 600;
	background: rgba(255,255,255,0.16);
	border: 1px solid rgba(255,255,255,0.22);
}
.payments-body {
	padding: 1.5rem;
}
.payments-stat {
	border-radius: 18px;
	padding: 1.15rem 1.2rem;
	height: 100%;
	background: linear-gradient(180deg, #effdf5 0%, #ffffff 100%);
	border: 1px solid #baf0d2;
}
.payments-stat-label {
	color: #047857;
	font-size: .82rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .06em;
	margin-bottom: .45rem;
}
.payments-stat-value {
	font-size: 1.7rem;
	font-weight: 700;
	color: #1f2937;
	line-height: 1.1;
}
.payments-stat small {
	display: block;
	margin-top: .35rem;
	color: #6b7280;
}
.payments-card {
	border: 1px solid #d7f4e5;
	border-radius: 18px;
	background: #fcfffd;
	padding: 1.25rem;
}
.payments-card h4 {
	margin: 0;
	font-weight: 700;
}
.payments-table {
	margin: 0;
}
.payments-table thead th {
	border-top: 0;
	border-bottom: 1px solid #d8f0e3;
	color: #047857;
	font-size: .8rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .06em;
}
.payments-table tbody td {
	vertical-align: middle;
	border-color: #eef7f2;
}
.payments-code {
	font-weight: 700;
	color: #065f46;
}
.payments-note {
	color: #374151;
	font-weight: 600;
}
.payments-date {
	color: #6b7280;
	font-size: .92rem;
}
.payment-status {
	display: inline-flex;
	align-items: center;
	gap: .35rem;
	padding: .38rem .75rem;
	border-radius: 999px;
	font-size: .78rem;
	font-weight: 700;
}
.payment-status-yes {
	background: #d1fae5;
	color: #065f46;
}
.payment-status-no {
	background: #fee2e2;
	color: #991b1b;
}
.amount-cell {
	font-weight: 700;
	color: #111827;
}
.summary-stack {
	display: grid;
	gap: .85rem;
}
.summary-tile {
	background: #fff;
	border: 1px dashed #9fe0bf;
	border-radius: 16px;
	padding: 1rem;
}
.empty-payments {
	border: 1px dashed #9fe0bf;
	background: linear-gradient(180deg, #f4fff9 0%, #fff 100%);
	border-radius: 18px;
	padding: 2rem 1.25rem;
	text-align: center;
}
.empty-payments i {
	font-size: 2rem;
	color: #059669;
	margin-bottom: .8rem;
	display: inline-block;
}
@media (max-width: 767px) {
	.payments-hero h2 { font-size: 1.65rem; }
	.payments-body { padding: 1rem; }
}
</style>

<div class="col-md-12 payments-screen">
	<div class="payments-shell">
		<div class="payments-hero">
			<div class="payments-hero-wrap">
				<div>
					<div class="payments-stat-label" style="color:#d1fae5;">Student Portal</div>
					<h2><i class="mdi mdi-credit-card-outline"></i> Payments</h2>
					<p>See your payment entries, posted totals, and a cleaner summary of what has already been marked paid.</p>
				</div>
				<div class="payments-chip">
					<i class="mdi mdi-cash-multiple"></i>
					<span><?=number_format($total_amount, 2)?> recorded</span>
				</div>
			</div>
		</div>

		<div class="payments-body">
			<div class="row">
				<div class="col-md-3 grid-margin">
					<div class="payments-stat">
						<div class="payments-stat-label">Student</div>
						<div class="payments-stat-value"><?=$student->firstname?> <?=$student->lastname?></div>
						<small><?=$student->gradelevel ? $student->gradelevel : 'Grade level not set'?></small>
					</div>
				</div>
				<div class="col-md-3 grid-margin">
					<div class="payments-stat">
						<div class="payments-stat-label">Transactions</div>
						<div class="payments-stat-value"><?=$transaction_count?></div>
						<small>Total payment rows on file.</small>
					</div>
				</div>
				<div class="col-md-3 grid-margin">
					<div class="payments-stat">
						<div class="payments-stat-label">Paid Entries</div>
						<div class="payments-stat-value"><?=$paid_count?></div>
						<small>Items already marked as paid.</small>
					</div>
				</div>
				<div class="col-md-3 grid-margin">
					<div class="payments-stat">
						<div class="payments-stat-label">Unpaid Entries</div>
						<div class="payments-stat-value"><?=$unpaid_count?></div>
						<small>Rows still not tagged as paid.</small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-8 grid-margin">
					<div class="payments-card">
						<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:.75rem;">
							<h4>Payment History</h4>
							<div class="payments-chip" style="background:#effdf5;color:#047857;border-color:#baf0d2;">
								<i class="mdi mdi-receipt-text-outline"></i>
								<span><?=$transaction_count?> entries</span>
							</div>
						</div>

						<?php if ($transaction_count > 0): ?>
							<div class="table-responsive">
								<table class="table payments-table">
									<thead>
										<tr>
											<th>Reference</th>
											<th>Details</th>
											<th>Status</th>
											<th class="text-right">Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($query_payments->result() as $payment): ?>
											<?php $paid = strtolower((string) $payment->paid) === 'yes'; ?>
											<tr>
												<td>
													<div class="payments-code"><?=$payment->payment_code?></div>
													<div class="payments-date"><?=date('M d, Y', strtotime($payment->payment_date))?></div>
												</td>
												<td>
													<div class="payments-note"><?=$payment->payment_note?></div>
													<div class="payments-date">Invoice: <?=$payment->invoice_number ? $payment->invoice_number : 'Not provided'?></div>
												</td>
												<td>
													<span class="payment-status <?=$paid ? 'payment-status-yes' : 'payment-status-no'?>">
														<i class="mdi <?=$paid ? 'mdi-check-circle' : 'mdi-alert-circle-outline'?>"></i>
														<?=strtoupper($payment->paid)?>
													</span>
												</td>
												<td class="text-right amount-cell"><?=number_format($payment->payment_total, 2)?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="empty-payments">
								<i class="mdi mdi-cash-remove"></i>
								<h5 class="mb-2">No Payments Recorded Yet</h5>
								<p class="text-muted mb-0">This page is ready, but there are no payment transactions attached to your account at the moment.</p>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-lg-4 grid-margin">
					<div class="payments-card">
						<h4 class="mb-3">Quick Summary</h4>
						<div class="summary-stack">
							<div class="summary-tile">
								<strong>Recorded Amount</strong>
								<div class="text-muted mt-1">PHP <?=number_format($total_amount, 2)?></div>
							</div>
							<div class="summary-tile">
								<strong>Payment Progress</strong>
								<div class="text-muted mt-1"><?=$paid_count?> paid, <?=$unpaid_count?> not yet paid.</div>
							</div>
							<div class="summary-tile">
								<strong>Portal Note</strong>
								<div class="text-muted mt-1">For official verification or discrepancies, coordinate with the accounting office.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

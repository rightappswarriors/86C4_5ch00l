<style>
.payments-empty-screen {
	background:
		radial-gradient(circle at top right, rgba(16, 185, 129, 0.14), transparent 30%),
		linear-gradient(180deg, #f3fff9 0%, #ffffff 100%);
	padding-top: .25rem;
}
.payments-empty-shell {
	background: #fff;
	border-radius: 22px;
	overflow: hidden;
	box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
	margin-bottom: 1.5rem;
}
.payments-empty-hero {
	background: linear-gradient(135deg, #10b981 0%, #059669 60%, #047857 100%);
	color: #fff;
	padding: 1.75rem;
}
.payments-empty-hero h2 {
	margin: 0 0 .35rem;
	font-weight: 700;
	font-size: 2rem;
}
.payments-empty-hero p {
	margin: 0;
	opacity: .92;
}
.payments-empty-body {
	padding: 1.5rem;
}
.payments-empty-card {
	border: 1px dashed #9fe0bf;
	border-radius: 18px;
	background: linear-gradient(180deg, #f4fff9 0%, #fff 100%);
	padding: 4rem 1.5rem;
	text-align: center;
}
.payments-empty-card i {
	font-size: 2.5rem;
	color: #059669;
	margin-bottom: 1rem;
	display: inline-block;
}
.payments-empty-card h4 {
	margin-bottom: .5rem;
	font-weight: 700;
	color: #14532d;
}
.payments-empty-card p {
	margin: 0;
	color: #6b7280;
}
</style>

<div class="col-md-12 payments-empty-screen">
	<div class="payments-empty-shell">
		<div class="payments-empty-hero">
			<h2><i class="mdi mdi-credit-card-outline"></i> Payments</h2>
			<p>View your payment details here.</p>
		</div>
		<div class="payments-empty-body">
			<div class="payments-empty-card">
				<i class="mdi mdi-cash-remove"></i>
				<h4>Payments</h4>
				<p>Payment information will appear here.</p>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/payment_print.css">

<div class="payment-receipt">
    <div class="receipt-header">
        <h2>PAYMENT RECEIPT</h2>
        <p><strong>Cebu Bob Hughes Christian Academy, Inc.</strong></p>
        <p>55 Katipunan St., Brgy. Calamba, Cebu City 6000</p>
    </div>
    
    <div class="receipt-body">
        <div class="receipt-info">
            <div>
                <p><strong>Receipt No:</strong> <?= $payment->payment_code ?></p>
                <p><strong>Date:</strong> <?= date('F j, Y', strtotime($payment->payment_date)) ?></p>
            </div>
            <div style="text-align: right;">
                <p><strong>Invoice #:</strong> <?= $payment->invoice_number ?></p>
                <p><strong>Status:</strong> <span class="badge-<?= $payment->paid == 'yes' ? 'success' : 'danger' ?>"><?= strtoupper($payment->paid) ?></span></p>
            </div>
        </div>
        
        <table class="receipt-table">
            <tr>
                <th>Student Name</th>
                <td><?= $payment->lastname ?>, <?= $payment->firstname ?></td>
            </tr>
            <tr>
                <th>Payment For</th>
                <td><?= isset($payment->payment_for) ? $payment->payment_for : 'Tuition Payment' ?></td>
            </tr>
            <?php if(!empty($payment->payment_note)): ?>
            <tr>
                <th>Notes</th>
                <td><?= $payment->payment_note ?></td>
            </tr>
            <?php endif; ?>
        </table>
        
        <div class="receipt-total">
            Amount: PHP <?= number_format($payment->payment_total, 2) ?>
        </div>
        
        <div class="receipt-footer">
            <p><strong>Thank you for your payment!</strong></p>
            <p>For concerns, please contact the accounting office.</p>
            <p class="date-printed">Date Printed: <?= date('F j, Y g:i A') ?></p>
        </div>
    </div>
</div>
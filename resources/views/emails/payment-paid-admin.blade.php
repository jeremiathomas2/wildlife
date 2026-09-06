<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Raleway', Arial, sans-serif; background: #f4f1ed; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: #088529; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .body { padding: 30px; color: #111111; }
        .pay-ref { background: #f8f4f0; border-radius: 8px; padding: 16px; margin-bottom: 20px; text-align: center; }
        .pay-ref strong { color: #088529; font-size: 18px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0ebe5; }
        .detail-label { color: #5a3e2b; font-size: 14px; }
        .detail-value { font-weight: 600; color: #111111; font-size: 14px; }
        .cta { display: inline-block; background: #631e08; color: #ffffff; padding: 12px 24px; border-radius: 24px; text-decoration: none; font-weight: 600; font-size: 14px; }
        .footer { background: #f8f4f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #5a3e2b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Payment Received</h1>
        </div>
        <div class="body">
            <p>A customer payment has been received and verified through PesaPal.</p>

            <div class="pay-ref">
                <div class="detail-label">Payment Reference</div>
                <strong>{{ $payment->merchant_reference }}</strong>
            </div>

            <div class="detail-row">
                <span class="detail-label">Customer</span>
                <span class="detail-value">{{ $payment->customer_name }} ({{ $payment->customer_email }})</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Description</span>
                <span class="detail-value">{{ $payment->description }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">{{ $payment->payment_method ?: 'PesaPal' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tracking ID</span>
                <span class="detail-value">{{ $payment->order_tracking_id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount</span>
                <span class="detail-value">{{ \App\Helpers\CurrencyHelper::format($payment->amount, $payment->currency) }}</span>
            </div>

            <p style="text-align: center; margin: 24px 0;">
                <a href="{{ route('admin.payments') }}" class="cta">View Payments in Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p>Tanzania Daily Tours & Safari - Admin Notification</p>
        </div>
    </div>
</body>
</html>
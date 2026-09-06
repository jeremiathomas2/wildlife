<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Raleway', Arial, sans-serif; background: #f4f1ed; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: #631e08; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .body { padding: 30px; color: #111111; }
        .pay-ref { background: #f8f4f0; border-radius: 8px; padding: 16px; margin-bottom: 20px; text-align: center; }
        .pay-ref strong { color: #631e08; font-size: 18px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0ebe5; }
        .detail-label { color: #5a3e2b; font-size: 14px; }
        .detail-value { font-weight: 600; color: #111111; font-size: 14px; }
        .total { background: #f8f4f0; border-radius: 8px; padding: 16px; margin: 20px 0; text-align: center; }
        .total .amount { color: #088529; font-size: 24px; font-weight: 700; }
        .cta { display: inline-block; background: #088529; color: #ffffff; padding: 14px 28px; border-radius: 24px; text-decoration: none; font-weight: 700; font-size: 15px; }
        .footer { background: #f8f4f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #5a3e2b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Complete Your Booking</h1>
        </div>
        <div class="body">
            <p>Hello {{ $payment->customer_name }},</p>
            <p>Thank you for booking with Tanzania Daily Tours & Safari. To confirm your reservation, please complete your payment using the secure link below.</p>

            <div class="pay-ref">
                <div class="detail-label">Payment Reference</div>
                <strong>{{ $payment->merchant_reference }}</strong>
            </div>

            <div class="detail-row">
                <span class="detail-label">Tour</span>
                <span class="detail-value">{{ $payment->description }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Mode</span>
                <span class="detail-value">{{ ucfirst($payment->payment_mode) }}{{ $payment->deposit_percentage > 0 ? ' (' . $payment->deposit_percentage . '%)' : '' }}</span>
            </div>

            <div class="total">
                <div class="detail-label">Amount Due</div>
                <div class="amount">{{ \App\Helpers\CurrencyHelper::format($payment->amount, $payment->currency) }}</div>
            </div>

            <p style="text-align: center; margin: 24px 0;">
                <a href="{{ $payUrl }}" class="cta">Pay Now with PesaPal</a>
            </p>
            <p style="font-size: 12px; color: #5a3e2b; text-align: center;">Secure checkout powered by PesaPal. Credit &amp; debit cards and mobile money accepted.</p>
        </div>
        <div class="footer">
            <p>Tanzania Daily Tours & Safari</p>
            <p>info@tanzaniadailytoursandsafari.com</p>
        </div>
    </div>
</body>
</html>
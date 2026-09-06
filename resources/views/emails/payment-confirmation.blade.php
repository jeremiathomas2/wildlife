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
        .total { background: #f8f4f0; border-radius: 8px; padding: 16px; margin: 20px 0; }
        .total .amount { color: #088529; font-size: 24px; font-weight: 700; }
        .status { display: inline-block; background: #088529; color: #fff; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 16px; }
        .cta { display: inline-block; background: #ff9729; color: #ffffff; padding: 12px 24px; border-radius: 24px; text-decoration: none; font-weight: 600; font-size: 14px; }
        .footer { background: #f8f4f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #5a3e2b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Payment Confirmed 🎉</h1>
        </div>
        <div class="body">
            <p>Hello {{ $payment->customer_name }},</p>
            <p>Thank you! Your payment has been received successfully. Here are your payment details:</p>

            <div class="pay-ref">
                <div class="detail-label">Payment Reference</div>
                <strong>{{ $payment->merchant_reference }}</strong>
            </div>

            <span class="status">PAID</span>

            <div class="detail-row">
                <span class="detail-label">Booking</span>
                <span class="detail-value">{{ $payment->booking?->reference ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tour</span>
                <span class="detail-value">{{ $payment->description }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">{{ $payment->payment_method ?: 'PesaPal' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Mode</span>
                <span class="detail-value">{{ ucfirst($payment->payment_mode) }}{{ $payment->deposit_percentage > 0 ? ' (' . $payment->deposit_percentage . '%)' : '' }}</span>
            </div>
            <div class="detail-row" style="border-bottom: none;">
                <span class="detail-label">Paid On</span>
                <span class="detail-value">{{ $payment->paid_at?->format('F j, Y g:i A') }}</span>
            </div>

            <div class="total">
                <div class="detail-row" style="border-bottom: none; margin: 0; padding: 0;">
                    <span class="detail-label">Amount Paid</span>
                    <span class="amount">{{ \App\Helpers\CurrencyHelper::format($payment->amount, $payment->currency) }}</span>
                </div>
            </div>

            @if($payment->payment_mode === 'deposit')
                <p style="font-size: 13px; color: #5a3e2b;">This is your deposit to confirm the booking. The remaining balance will be arranged with our team before your travel date.</p>
            @endif

            <p style="text-align: center; margin: 24px 0;">
                <a href="mailto:info@tanzaniadailytoursandsafari.com" class="cta">Questions? Contact Us</a>
            </p>
        </div>
        <div class="footer">
            <p>Tanzania Daily Tours & Safari</p>
            <p>info@tanzaniadailytoursandsafari.com</p>
        </div>
    </div>
</body>
</html>
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
        .booking-ref { background: #f8f4f0; border-radius: 8px; padding: 16px; margin-bottom: 20px; text-align: center; }
        .booking-ref strong { color: #631e08; font-size: 18px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0ebe5; }
        .detail-label { color: #5a3e2b; font-size: 14px; }
        .detail-value { font-weight: 600; color: #111111; font-size: 14px; }
        .total { background: #f8f4f0; border-radius: 8px; padding: 16px; margin: 20px 0; }
        .total .amount { color: #088529; font-size: 24px; font-weight: 700; }
        .footer { background: #f8f4f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #5a3e2b; }
        .cta { display: inline-block; background: #ff9729; color: #ffffff; padding: 12px 24px; border-radius: 24px; text-decoration: none; font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmed!</h1>
        </div>
        <div class="body">
            <p>Hello {{ $booking->name }},</p>
            <p>Thank you for booking with Tanzania Daily Tours & Safari. Your booking has been received and is being processed.</p>

            <div class="booking-ref">
                <div class="detail-label">Booking Reference</div>
                <strong>#TDTS-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong>
            </div>

            <div class="detail-row">
                <span class="detail-label">Tour</span>
                <span class="detail-value">{{ $booking->tour_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Travel Date</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->travel_date)->format('F j, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Party Size</span>
                <span class="detail-value">{{ $booking->adults }} adult{{ $booking->adults > 1 ? 's' : '' }}{{ ($booking->children ?? 0) > 0 ? ', ' . $booking->children . ' child' . ($booking->children > 1 ? 'ren' : '') : '' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $booking->country_code }} {{ $booking->phone_number }}</span>
            </div>

            <div class="total">
                <div class="detail-row" style="border-bottom: none; margin: 0; padding: 0;">
                    <span class="detail-label">Total Price</span>
                    <span class="amount">{{ \App\Helpers\CurrencyHelper::format($booking->total_price, $booking->currency) }}</span>
                </div>
            </div>

            <p style="text-align: center; margin: 24px 0;">
                <a href="mailto:info@tanzaniadailytoursandsafari.com" class="cta">Questions? Contact Us</a>
            </p>

            <p style="font-size: 13px; color: #5a3e2b;">Our team will contact you shortly to confirm details and arrange payment.</p>
        </div>
        <div class="footer">
            <p>Tanzania Daily Tours & Safari</p>
            <p>info@tanzaniadailytoursandsafari.com | +255 000 000 000</p>
        </div>
    </div>
</body>
</html>

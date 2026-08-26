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
        .alert-badge { display: inline-block; background: #ff9729; color: #ffffff; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; margin-bottom: 16px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0ebe5; }
        .detail-label { color: #5a3e2b; font-size: 14px; }
        .detail-value { font-weight: 600; color: #111111; font-size: 14px; }
        .total { background: #f8f4f0; border-radius: 8px; padding: 16px; margin: 20px 0; text-align: center; }
        .total .amount { color: #088529; font-size: 24px; font-weight: 700; }
        .cta { display: inline-block; background: #631e08; color: #ffffff; padding: 12px 24px; border-radius: 24px; text-decoration: none; font-weight: 600; font-size: 14px; }
        .footer { background: #f8f4f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #5a3e2b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Booking Received</h1>
        </div>
        <div class="body">
            <span class="alert-badge">Action Required</span>

            <div class="detail-row">
                <span class="detail-label">Booking ID</span>
                <span class="detail-value">#TDTS-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Customer</span>
                <span class="detail-value">{{ $booking->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $booking->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $booking->country_code }} {{ $booking->phone_number }}</span>
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

            <div class="total">
                <div class="detail-label">Total</div>
                <div class="amount">{{ \App\Helpers\CurrencyHelper::format($booking->total_price, $booking->currency) }}</div>
            </div>

            <p style="text-align: center; margin: 24px 0;">
                <a href="{{ route('admin.bookings') }}" class="cta">View in Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p>Tanzania Daily Tours & Safari - Admin Notification</p>
        </div>
    </div>
</body>
</html>

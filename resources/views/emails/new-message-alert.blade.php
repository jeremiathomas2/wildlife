<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Raleway', Arial, sans-serif; background: #f4f1ed; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: #ff9729; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .body { padding: 30px; color: #111111; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0ebe5; }
        .detail-label { color: #5a3e2b; font-size: 14px; }
        .detail-value { font-weight: 600; color: #111111; font-size: 14px; }
        .message-box { background: #f8f4f0; border-radius: 8px; padding: 16px; margin: 20px 0; line-height: 1.6; font-size: 14px; color: #111111; }
        .cta { display: inline-block; background: #631e08; color: #ffffff; padding: 12px 24px; border-radius: 24px; text-decoration: none; font-weight: 600; font-size: 14px; }
        .footer { background: #f8f4f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #5a3e2b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Message</h1>
        </div>
        <div class="body">
            <div class="detail-row">
                <span class="detail-label">From</span>
                <span class="detail-value">{{ $message->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $message->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Subject</span>
                <span class="detail-value">{{ $message->subject }}</span>
            </div>

            <div class="message-box">
                {!! nl2br(e($message->body)) !!}
            </div>

            <p style="text-align: center; margin: 24px 0;">
                <a href="{{ route('admin.messages') }}" class="cta">View in Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p>Tanzania Daily Tours & Safari - Admin Notification</p>
        </div>
    </div>
</body>
</html>

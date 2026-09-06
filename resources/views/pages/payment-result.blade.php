<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $success ? 'Payment Confirmed' : 'Payment Status' }} · Tanzania Daily Tours & Safari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --sand-50:#FBF7EF; --sand-100:#F4ECDC; --coffee-900:#2A1B10; --coffee-700:#4D3422;
            --terracotta-600:#C2592B; --acacia-600:#5E6E3F; --gold-500:#D4A24C;
            --ink:#241408; --ink-soft:#6B5A48; --line:#E4D7C2; --success:#3F6B3F; --danger:#B33A3A;
        }
        *{box-sizing:border-box;}
        body{
            margin:0;font-family:'Raleway',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;
            background:radial-gradient(circle at 15% 20%, rgba(212,162,76,.18), transparent 45%), radial-gradient(circle at 85% 80%, rgba(122,132,80,.18), transparent 45%), var(--coffee-900);
        }
        .card{
            width:100%;max-width:520px;background:var(--sand-50);border-radius:20px;padding:40px 36px;
            box-shadow:0 20px 48px rgba(42,27,16,.18);text-align:center;animation:riseIn .5s cubic-bezier(.2,.8,.2,1);
        }
        @keyframes riseIn{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
        .mark{width:72px;height:72px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;}
        .mark.success{background:linear-gradient(155deg,var(--acacia-600),#7A8450);}
        .mark.failed{background:linear-gradient(155deg,var(--danger),#C2592B);}
        .mark svg{width:34px;height:34px;color:#fff;}
        h1{font-size:24px;margin:0 0 8px;color:var(--coffee-900);}
        .sub{color:var(--ink-soft);font-size:14px;line-height:1.6;margin-bottom:22px;}
        .ref{display:inline-block;background:var(--sand-100);border:1px solid var(--line);border-radius:8px;padding:8px 18px;font-size:14px;font-weight:700;color:var(--coffee-700);margin-bottom:22px;}
        .info{background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px;margin-bottom:22px;}
        .row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed var(--line);font-size:14px;}
        .row:last-child{border-bottom:none;}
        .row span{color:var(--ink-soft);}
        .row b{color:var(--coffee-900);}
        .amount{color:var(--success);font-size:26px;font-weight:800;}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 26px;border-radius:10px;border:none;font-weight:700;font-size:14.5px;cursor:pointer;text-decoration:none;transition:transform .12s, opacity .15s;margin:4px;}
        .btn:active{transform:translateY(1px);}
        .btn-primary{background:var(--terracotta-600);color:#fff;}
        .btn-ghost{background:var(--sand-100);color:var(--coffee-700);border:1.5px solid var(--line);}
        .note{font-size:12.5px;color:var(--ink-soft);margin-top:18px;line-height:1.6;}
    </style>
</head>
<body>
    <div class="card">
        <div class="mark {{ $success ? 'success' : 'failed' }}">
            @if($success)
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            @endif
        </div>
        <h1>{{ $success ? 'Payment Confirmed' : 'Payment Not Completed' }}</h1>
        <p class="sub">{{ $message }}</p>

        <div class="ref">{{ $payment->merchant_reference }}</div>

        <div class="info">
            <div class="row"><span>Booking</span><b>{{ $payment->booking?->reference ?? '—' }}</b></div>
            <div class="row"><span>Tour</span><b>{{ $payment->booking?->tour_name ?? $payment->description }}</b></div>
            <div class="row"><span>Mode</span><b>{{ ucfirst($payment->payment_mode) }}{{ $payment->deposit_percentage > 0 ? ' (' . $payment->deposit_percentage . '%)' : '' }}</b></div>
            <div class="row"><span>Paid</span><b class="amount">{{ \App\Helpers\CurrencyHelper::format($payment->amount, $payment->currency) }}</b></div>
            @if($payment->payment_method)
                <div class="row"><span>Method</span><b>{{ $payment->payment_method }}</b></div>
            @endif
        </div>

        @if(!$success)
            <a class="btn btn-primary" href="{{ route('payments.resume', $payment->merchant_reference) }}">Retry payment</a>
        @endif
        <a class="btn btn-ghost" href="{{ route('home') }}">Back to home</a>

        @if($payment->booking?->email)
            <p class="note">A confirmation email has been sent to {{ $payment->booking->email }}.</p>
        @endif
        <p class="note">Tanzania Daily Tours & Safari · Powered by PesaPal</p>
    </div>
</body>
</html>
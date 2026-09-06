<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled · Tanzania Daily Tours & Safari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --sand-50:#FBF7EF; --sand-100:#F4ECDC; --coffee-900:#2A1B10; --coffee-700:#4D3422;
            --terracotta-600:#C2592B; --ink-soft:#6B5A48; --line:#E4D7C2;
        }
        *{box-sizing:border-box;}
        body{
            margin:0;font-family:'Raleway',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;
            background:radial-gradient(circle at 15% 20%, rgba(212,162,76,.18), transparent 45%), radial-gradient(circle at 85% 80%, rgba(122,132,80,.18), transparent 45%), var(--coffee-900);
        }
        .card{width:100%;max-width:520px;background:var(--sand-50);border-radius:20px;padding:40px 36px;box-shadow:0 20px 48px rgba(42,27,16,.18);text-align:center;animation:riseIn .5s cubic-bezier(.2,.8,.2,1);}
        @keyframes riseIn{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
        .mark{width:72px;height:72px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;background:linear-gradient(155deg,#C2592B,#D4A24C);}
        .mark svg{width:34px;height:34px;color:#fff;}
        h1{font-size:24px;margin:0 0 8px;color:var(--coffee-900);}
        .sub{color:var(--ink-soft);font-size:14px;line-height:1.6;margin-bottom:22px;}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 26px;border-radius:10px;border:none;font-weight:700;font-size:14.5px;cursor:pointer;text-decoration:none;transition:transform .12s, opacity .15s;margin:4px;}
        .btn:active{transform:translateY(1px);}
        .btn-primary{background:var(--terracotta-600);color:#fff;}
        .btn-ghost{background:var(--sand-100);color:var(--coffee-700);border:1.5px solid var(--line);}
        .note{font-size:12.5px;color:var(--ink-soft);margin-top:18px;line-height:1.6;}
    </style>
</head>
<body>
    <div class="card">
        <div class="mark">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </div>
        <h1>Payment Cancelled</h1>
        <p class="sub">Your payment was cancelled. Your booking is still safe — you can complete payment any time.</p>
        @if(session('error'))
            <p class="sub" style="color:#B33A3A;">{{ session('error') }}</p>
        @endif
        <div style="margin-top:6px;">
            <a class="btn btn-primary" href="{{ route('home') }}">Back to home</a>
            <a class="btn btn-ghost" href="{{ route('contact') }}">Contact us</a>
        </div>
        <p class="note">Tanzania Daily Tours & Safari · Powered by PesaPal</p>
    </div>
</body>
</html>
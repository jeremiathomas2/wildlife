<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safari Admin · Tanzania Daily Tours & Safari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root{
            --sand-50:#FBF7EF;
            --sand-100:#F4ECDC;
            --sand-200:#E9DCC0;
            --coffee-900:#2A1B10;
            --coffee-800:#3B2718;
            --coffee-700:#4D3422;
            --coffee-500:#7A5C42;
            --coffee-300:#A98968;
            --terracotta-600:#C2592B;
            --terracotta-500:#D06B3A;
            --terracotta-100:#F6E1D3;
            --acacia-600:#5E6E3F;
            --acacia-500:#7A8450;
            --acacia-100:#E2E7D4;
            --gold-500:#D4A24C;
            --gold-100:#F7E9CB;
            --ink:#241408;
            --ink-soft:#6B5A48;
            --line:#E4D7C2;
            --white:#FFFFFF;
            --danger:#B33A3A;
            --danger-100:#F6DCDA;
            --success:#3F6B3F;
            --radius-sm:8px;
            --radius-md:14px;
            --radius-lg:20px;
            --shadow-sm:0 1px 2px rgba(42,27,16,.08);
            --shadow-md:0 8px 24px rgba(42,27,16,.10);
            --shadow-lg:0 20px 48px rgba(42,27,16,.18);
        }

        *{box-sizing:border-box;}
        html,body{height:100%;}
        body{
            margin:0;
            font-family:'Inter',sans-serif;
            background:
                radial-gradient(circle at 15% 20%, rgba(212,162,76,.18), transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(122,132,80,.18), transparent 45%),
                var(--coffee-900);
            color:var(--ink);
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
        }
        body::before{
            content:"";
            position:absolute;
            inset:0;
            background-image: repeating-linear-gradient(115deg, rgba(255,255,255,.025) 0 2px, transparent 2px 64px);
            pointer-events:none;
        }
        .login-card{
            position:relative;
            width:100%;
            max-width:392px;
            background:var(--sand-50);
            border-radius:var(--radius-lg);
            padding:40px 36px 32px;
            box-shadow:var(--shadow-lg);
            animation:riseIn .5s cubic-bezier(.2,.8,.2,1);
        }
        @keyframes riseIn{
            from{opacity:0;transform:translateY(14px);}
            to{opacity:1;transform:translateY(0);}
        }
        .login-mark{
            width:52px;height:52px;border-radius:14px;
            background:linear-gradient(155deg,var(--terracotta-600),var(--gold-500));
            display:flex;align-items:center;justify-content:center;
            margin-bottom:18px;box-shadow:var(--shadow-sm);
        }
        .login-mark svg{width:28px;height:28px;}
        .login-card h1{
            font-family:'Fraunces',serif;
            font-size:26px;margin-bottom:6px;color:var(--coffee-900);
        }
        .login-sub{
            color:var(--ink-soft);font-size:14px;margin-bottom:26px;line-height:1.5;
        }
        .field{margin-bottom:16px;}
        .field label{
            display:block;font-size:12.5px;font-weight:600;color:var(--coffee-700);margin-bottom:7px;text-transform:uppercase;letter-spacing:.04em;
        }
        .field input{
            width:100%;padding:12px 14px;border:1.5px solid var(--line);border-radius:var(--radius-sm);
            background:var(--white);font-size:14.5px;color:var(--ink);transition:border-color .15s, box-shadow .15s;
        }
        .field input:focus{
            outline:none;border-color:var(--terracotta-500);box-shadow:0 0 0 3px var(--terracotta-100);
        }
        .btn{
            display:inline-flex;align-items:center;justify-content:center;gap:8px;
            padding:12px 20px;border-radius:var(--radius-sm);border:none;
            font-weight:600;font-size:14.5px;transition:transform .12s, box-shadow .12s, background .15s;
            cursor:pointer;
        }
        .btn:active{transform:translateY(1px);}
        .btn-primary{background:var(--terracotta-600);color:#fff;box-shadow:0 6px 16px rgba(194,89,43,.32);}
        .btn-primary:hover{background:var(--terracotta-500);}
        .btn-block{width:100%;}
        .login-error{
            display:none;background:var(--danger-100);color:var(--danger);font-size:13px;font-weight:600;
            padding:10px 12px;border-radius:var(--radius-sm);margin-bottom:14px;
        }
        .login-demo{
            margin-top:18px;padding:12px 14px;background:var(--sand-100);border:1px dashed var(--coffee-300);
            border-radius:var(--radius-sm);font-size:12.5px;color:var(--ink-soft);line-height:1.6;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-mark">
            <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-white_bexcal.png" alt="Tanzania Daily Tours & Safari" style="width: 40px; height: 40px; object-fit: contain;">
        </div>
        <h1>Safari Admin</h1>
        <p class="login-sub">Managing Tanzania Daily Tours & Safari</p>

        @if(session('error'))
            <div class="login-error" style="display:block;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="field">
                <label>Email address</label>
                <input type="email" name="email" placeholder="you@tanzaniadailytours.com" value="@gmail.com" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

         </div>
</body>
</html>

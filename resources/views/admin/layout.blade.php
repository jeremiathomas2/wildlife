<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Safari Admin') · Tanzania Daily Tours & Safari</title>
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
            --sidebar-w:264px;
            --sidebar-w-collapsed:76px;
            --topbar-h:72px;
        }

        *{box-sizing:border-box;}
        html,body{height:100%;}
        body{
            margin:0;
            font-family:'Inter',sans-serif;
            background:var(--sand-50);
            color:var(--ink);
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
        }
        ::selection{background:var(--terracotta-100);color:var(--coffee-900);}
        h1,h2,h3,h4{font-family:'Fraunces',serif;margin:0;color:var(--coffee-900);letter-spacing:-0.01em;}
        p{margin:0;}
        a{color:inherit;text-decoration:none;}
        button{font-family:inherit;cursor:pointer;}
        input,select,textarea{font-family:inherit;}
        .mono{font-family:'JetBrains Mono',monospace;}
        ::-webkit-scrollbar{width:9px;height:9px;}
        ::-webkit-scrollbar-track{background:transparent;}
        ::-webkit-scrollbar-thumb{background:var(--coffee-300);border-radius:10px;}
        ::-webkit-scrollbar-thumb:hover{background:var(--coffee-500);}


        /* Sidebar */
        .sidebar{
            position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);z-index:200;
            background:var(--coffee-900);
            background-image:radial-gradient(circle at 0% 0%, rgba(212,162,76,.10), transparent 55%);
            display:flex;flex-direction:column;
            transition:width .25s ease, transform .25s ease;
            border-right:1px solid rgba(255,255,255,.06);
        }
        .sidebar.collapsed{width:var(--sidebar-w-collapsed);}
        .sb-brand{
            display:flex;align-items:center;gap:12px;padding:22px 20px;
            border-bottom:1px solid rgba(255,255,255,.08);min-height:var(--topbar-h);
        }
        .sb-mark{
            width:38px;height:38px;border-radius:10px;flex:none;
            background:linear-gradient(155deg,var(--terracotta-600),var(--gold-500));
            display:flex;align-items:center;justify-content:center;box-shadow:var(--shadow-sm);
        }
        .sb-mark svg{width:21px;height:21px;}
        .sb-brand-text{overflow:hidden;white-space:nowrap;}
        .sb-brand-text strong{display:block;color:#fff;font-family:'Fraunces',serif;font-size:15.5px;line-height:1.2;}
        .sb-brand-text span{display:block;color:var(--gold-500);font-size:11px;letter-spacing:.06em;text-transform:uppercase;font-weight:600;}
        .sidebar.collapsed .sb-brand-text{display:none;}
        .sb-nav{flex:1;overflow-y:auto;padding:16px 12px;}
        .sb-section-label{
            color:rgba(255,255,255,.32);font-size:10.5px;font-weight:700;letter-spacing:.09em;
            text-transform:uppercase;padding:14px 12px 8px;
        }
        .sidebar.collapsed .sb-section-label{display:none;}
        .sb-item{
            display:flex;align-items:center;gap:13px;padding:11px 12px;border-radius:10px;
            color:rgba(255,255,255,.62);font-size:14px;font-weight:500;margin-bottom:2px;
            position:relative;transition:background .15s,color .15s;white-space:nowrap;
        }
        .sb-item:hover{background:rgba(255,255,255,.06);color:#fff;}
        .sb-item.active{background:rgba(212,162,76,.16);color:var(--gold-500);}
        .sb-item.active::before{
            content:"";position:absolute;left:-12px;top:8px;bottom:8px;width:3px;border-radius:3px;
            background:var(--gold-500);
        }
        .sb-item svg{width:19px;height:19px;flex:none;}
        .sb-item .badge{
            margin-left:auto;background:var(--terracotta-600);color:#fff;font-size:11px;font-weight:700;
            padding:1px 7px;border-radius:20px;
        }
        .sidebar.collapsed .sb-item span:not(.badge){display:none;}
        .sidebar.collapsed .sb-item .badge{display:none;}
        .sidebar.collapsed .sb-item{justify-content:center;}
        .sb-footer{padding:14px 20px 20px;border-top:1px solid rgba(255,255,255,.08);}
        .sb-user{display:flex;align-items:center;gap:11px;}
        .sb-avatar{
            width:36px;height:36px;border-radius:50%;flex:none;
            background:linear-gradient(155deg,var(--acacia-500),var(--acacia-600));
            display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;
        }
        .sb-user-text{overflow:hidden;white-space:nowrap;}
        .sb-user-text strong{display:block;color:#fff;font-size:13.5px;}
        .sb-user-text span{display:block;color:rgba(255,255,255,.5);font-size:11.5px;}
        .sidebar.collapsed .sb-user-text{display:none;}


        /* Main */
        .main{margin-left:var(--sidebar-w);transition:margin-left .25s ease;min-height:100vh;display:flex;flex-direction:column;}
        .sidebar.collapsed ~ .main{margin-left:var(--sidebar-w-collapsed);}
        .topbar{
            position:sticky;top:0;z-index:100;height:var(--topbar-h);
            background:rgba(251,247,239,.86);backdrop-filter:blur(10px);
            border-bottom:1px solid var(--line);
            display:flex;align-items:center;gap:16px;padding:0 28px;
        }
        .tb-toggle{
            width:38px;height:38px;border-radius:10px;border:1.5px solid var(--line);background:var(--white);
            display:flex;align-items:center;justify-content:center;flex:none;
        }
        .tb-toggle svg{width:18px;height:18px;color:var(--coffee-700);}
        .tb-toggle:hover{background:var(--sand-100);}
        .tb-search{
            flex:1;max-width:420px;display:flex;align-items:center;gap:10px;
            background:var(--white);border:1.5px solid var(--line);border-radius:11px;padding:9px 14px;
        }
        .tb-search svg{width:17px;height:17px;color:var(--ink-soft);flex:none;}
        .tb-search input{border:none;outline:none;background:transparent;font-size:14px;width:100%;color:var(--ink);}
        .tb-right{margin-left:auto;display:flex;align-items:center;gap:10px;}
        .tb-iconbtn{
            width:40px;height:40px;border-radius:11px;border:1.5px solid var(--line);background:var(--white);
            display:flex;align-items:center;justify-content:center;position:relative;color:var(--coffee-700);
        }
        .tb-iconbtn:hover{background:var(--sand-100);}
        .tb-iconbtn svg{width:18px;height:18px;}
        .tb-dot{
            position:absolute;top:7px;right:7px;width:8px;height:8px;border-radius:50%;
            background:var(--terracotta-600);border:2px solid var(--sand-50);
        }
        .tb-live{
            display:flex;align-items:center;gap:7px;background:var(--acacia-100);color:var(--acacia-600);
            padding:7px 13px;border-radius:20px;font-size:12.5px;font-weight:700;
        }
        .tb-live::before{
            content:"";width:7px;height:7px;border-radius:50%;background:var(--acacia-600);box-shadow:0 0 0 0 rgba(94,110,63,.5);animation:pulse 2s infinite;
        }
        @keyframes pulse{
            0%{box-shadow:0 0 0 0 rgba(94,110,63,.45);}
            70%{box-shadow:0 0 0 7px rgba(94,110,63,0);}
            100%{box-shadow:0 0 0 0 rgba(94,110,63,0);}
        }
        .view-wrap{padding:28px;flex:1;}
        .view{display:none;animation:fadeUp .35s ease;}
        .view.active{display:block;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);}}
        .view-head{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
        .view-head h2{font-size:27px;}
        .view-head .sub{color:var(--ink-soft);font-size:14px;margin-top:5px;}
        .view-actions{display:flex;gap:10px;flex-wrap:wrap;}


        /* Stats */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px;}
        .stat-card{
            background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);
            padding:20px 20px 18px;box-shadow:var(--shadow-sm);position:relative;overflow:hidden;
        }
        .stat-card::after{content:"";position:absolute;right:-20px;top:-20px;width:90px;height:90px;border-radius:50%;background:var(--stat-tint,var(--terracotta-100));opacity:.5;}
        .stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
        .stat-icon{width:40px;height:40px;border-radius:11px;display:flex;align-items:center;justify-content:center;background:var(--stat-tint,var(--terracotta-100));color:var(--stat-fg,var(--terracotta-600));position:relative;}
        .stat-icon svg{width:20px;height:20px;}
        .stat-trend{font-size:12px;font-weight:700;padding:3px 8px;border-radius:20px;}
        .stat-trend.up{color:var(--success);background:var(--acacia-100);}
        .stat-trend.down{color:var(--danger);background:var(--danger-100);}
        .stat-value{font-family:'Fraunces',serif;font-size:30px;color:var(--coffee-900);position:relative;}
        .stat-label{font-size:13px;color:var(--ink-soft);margin-top:4px;position:relative;}

        .panel-grid{display:grid;grid-template-columns:1.55fr 1fr;gap:18px;margin-bottom:24px;}
        .panel{background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);box-shadow:var(--shadow-sm);overflow:hidden;}
        .panel-head{display:flex;align-items:center;justify-content:space-between;padding:18px 20px 14px;border-bottom:1px solid var(--line);}
        .panel-head h3{font-size:16.5px;}
        .panel-head .link{font-size:12.5px;font-weight:700;color:var(--terracotta-600);cursor:pointer;}
        .panel-body{padding:18px 20px 20px;}

        /* Bar Chart */
        .bars{display:flex;align-items:flex-end;gap:10px;height:170px;padding-top:10px;}
        .bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:8px;height:100%;justify-content:flex-end;}
        .bar{
            width:100%;max-width:30px;border-radius:6px 6px 2px 2px;
            background:linear-gradient(180deg,var(--terracotta-500),var(--terracotta-600));
            transition:height .6s cubic-bezier(.2,.8,.2,1);position:relative;
        }
        .bar-col:nth-child(even) .bar{background:linear-gradient(180deg,var(--gold-500),#bb8636);}
        .bar-label{font-size:11px;color:var(--ink-soft);font-weight:600;}

        .donut-wrap{display:flex;align-items:center;gap:18px;}
        .legend{display:flex;flex-direction:column;gap:10px;flex:1;}
        .legend-item{display:flex;align-items:center;gap:9px;font-size:13px;}
        .legend-dot{width:10px;height:10px;border-radius:3px;flex:none;}
        .legend-item b{margin-left:auto;color:var(--coffee-900);}

        .activity-list{display:flex;flex-direction:column;gap:3px;}
        .activity-row{display:flex;gap:12px;padding:11px 0;border-bottom:1px dashed var(--line);}
        .activity-row:last-child{border-bottom:none;}
        .activity-ico{width:34px;height:34px;border-radius:9px;flex:none;display:flex;align-items:center;justify-content:center;background:var(--sand-100);color:var(--coffee-700);}
        .activity-ico svg{width:16px;height:16px;}
        .activity-text{font-size:13.5px;line-height:1.4;}
        .activity-text b{color:var(--coffee-900);}
        .activity-time{font-size:11.5px;color:var(--ink-soft);margin-top:2px;}


        /* Tables */
        .table-card{background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);box-shadow:var(--shadow-sm);overflow:hidden;}
        .table-toolbar{display:flex;align-items:center;gap:10px;padding:16px 18px;border-bottom:1px solid var(--line);flex-wrap:wrap;}
        .chip-filters{display:flex;gap:8px;flex-wrap:wrap;}
        .chip{padding:7px 14px;border-radius:20px;font-size:12.5px;font-weight:600;background:var(--sand-100);color:var(--coffee-700);border:1px solid transparent;cursor:pointer;}
        .chip.active{background:var(--coffee-900);color:#fff;}
        .table-search{display:flex;align-items:center;gap:8px;background:var(--sand-50);border:1.5px solid var(--line);border-radius:10px;padding:8px 12px;margin-left:auto;min-width:200px;}
        .table-search svg{width:15px;height:15px;color:var(--ink-soft);}
        .table-search input{border:none;background:transparent;outline:none;font-size:13.5px;width:100%;}
        .table-scroll{overflow-x:auto;}
        table{width:100%;border-collapse:collapse;min-width:680px;}
        thead th{
            text-align:left;font-size:11.5px;text-transform:uppercase;letter-spacing:.05em;color:var(--ink-soft);
            padding:12px 18px;border-bottom:1px solid var(--line);background:var(--sand-50);font-weight:700;white-space:nowrap;
        }
        tbody td{padding:14px 18px;border-bottom:1px solid var(--line);font-size:13.8px;color:var(--coffee-800);vertical-align:middle;}
        tbody tr:last-child td{border-bottom:none;}
        tbody tr{transition:background .12s;}
        tbody tr:hover{background:var(--sand-50);}
        .cell-main{display:flex;align-items:center;gap:11px;}
        .thumb{width:42px;height:42px;border-radius:9px;object-fit:cover;flex:none;background:var(--sand-200);}
        .cell-title{font-weight:600;color:var(--coffee-900);}
        .cell-sub{font-size:12px;color:var(--ink-soft);margin-top:1px;}
        .tag{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:700;white-space:nowrap;}
        .tag-green{background:var(--acacia-100);color:var(--acacia-600);}
        .tag-gold{background:var(--gold-100);color:#8a6418;}
        .tag-red{background:var(--danger-100);color:var(--danger);}
        .tag-grey{background:var(--sand-200);color:var(--ink-soft);}
        .row-actions{display:flex;gap:6px;justify-content:flex-end;}
        .row-actions button{width:32px;height:32px;border-radius:8px;border:1px solid var(--line);background:var(--white);display:flex;align-items:center;justify-content:center;color:var(--coffee-700);}
        .row-actions button:hover{background:var(--sand-100);}
        .row-actions button svg{width:14.5px;height:14.5px;}
        .row-actions .danger:hover{background:var(--danger-100);color:var(--danger);border-color:var(--danger-100);}
        .empty-state{padding:60px 20px;text-align:center;color:var(--ink-soft);}
        .empty-state svg{width:46px;height:46px;color:var(--coffee-300);margin-bottom:12px;}
        .empty-state h4{margin-bottom:5px;color:var(--coffee-800);}
        .empty-state p{font-size:13.5px;}


        /* Buttons */
        .btn{
            display:inline-flex;align-items:center;justify-content:center;gap:8px;
            padding:12px 20px;border-radius:var(--radius-sm);border:none;
            font-weight:600;font-size:14.5px;transition:transform .12s, box-shadow .12s, background .15s;
        }
        .btn:active{transform:translateY(1px);}
        .btn-primary{background:var(--terracotta-600);color:#fff;box-shadow:0 6px 16px rgba(194,89,43,.32);}
        .btn-primary:hover{background:var(--terracotta-500);}
        .btn-ghost{background:transparent;color:var(--coffee-700);border:1.5px solid var(--line);}
        .btn-ghost:hover{background:var(--sand-100);}
        .btn-soft{background:var(--sand-100);color:var(--coffee-800);}
        .btn-soft:hover{background:var(--sand-200);}
        .btn-danger{background:var(--danger-100);color:var(--danger);}
        .btn-danger:hover{background:#efc6c2;}
        .btn-sm{padding:8px 13px;font-size:13px;}


        /* Gallery */
        .gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:16px;}
        .gallery-card{position:relative;border-radius:var(--radius-md);overflow:hidden;aspect-ratio:1/1;box-shadow:var(--shadow-sm);border:1px solid var(--line);background:var(--sand-200);}
        .gallery-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s;}
        .gallery-card:hover img{transform:scale(1.06);}
        .gallery-overlay{
            position:absolute;inset:0;background:linear-gradient(180deg,rgba(36,20,8,0) 45%,rgba(36,20,8,.82));
            display:flex;flex-direction:column;justify-content:flex-end;padding:12px;opacity:0;transition:opacity .2s;
        }
        .gallery-card:hover .gallery-overlay{opacity:1;}
        .gallery-cap{color:#fff;font-size:12.5px;font-weight:600;margin-bottom:8px;line-height:1.3;}
        .gallery-actions{display:flex;gap:6px;}
        .gallery-actions button{flex:1;padding:6px;border-radius:7px;border:none;background:rgba(255,255,255,.18);color:#fff;backdrop-filter:blur(4px);font-size:11.5px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:5px;}
        .gallery-actions button:hover{background:rgba(255,255,255,.3);}
        .gallery-badge{position:absolute;top:10px;left:10px;background:rgba(36,20,8,.65);color:#fff;font-size:10.5px;font-weight:700;padding:4px 9px;border-radius:20px;text-transform:uppercase;letter-spacing:.04em;backdrop-filter:blur(4px);}
        .add-tile{
            border:2px dashed var(--coffee-300);border-radius:var(--radius-md);aspect-ratio:1/1;
            display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;color:var(--coffee-500);
            background:var(--sand-100);font-size:12.5px;font-weight:600;cursor:pointer;
        }
        .add-tile:hover{background:var(--sand-200);border-color:var(--terracotta-500);color:var(--terracotta-600);}
        .add-tile svg{width:26px;height:26px;}


        /* Reviews */
        .review-card{display:flex;gap:14px;background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);padding:18px;box-shadow:var(--shadow-sm);margin-bottom:14px;}
        .review-avatar{width:44px;height:44px;border-radius:50%;flex:none;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:15px;background:linear-gradient(155deg,var(--terracotta-600),var(--gold-500));}
        .review-top{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:4px;flex-wrap:wrap;}
        .review-name{font-weight:700;color:var(--coffee-900);font-size:14.5px;}
        .review-tour{font-size:12px;color:var(--ink-soft);margin-top:1px;}
        .review-text{font-size:13.8px;color:var(--coffee-800);line-height:1.55;margin:8px 0 10px;}
        .review-actions{display:flex;gap:8px;}


        /* Messages */
        .msg-layout{display:grid;grid-template-columns:340px 1fr;gap:18px;align-items:start;}
        .msg-list{background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);overflow:hidden;box-shadow:var(--shadow-sm);}
        .msg-item{display:flex;gap:11px;padding:14px 16px;border-bottom:1px solid var(--line);cursor:pointer;position:relative;}
        .msg-item:hover{background:var(--sand-50);}
        .msg-item.active{background:var(--terracotta-100);}
        .msg-item.unread::before{content:"";position:absolute;left:6px;top:50%;transform:translateY(-50%);width:7px;height:7px;border-radius:50%;background:var(--terracotta-600);}
        .msg-item-name{font-weight:700;font-size:13.5px;color:var(--coffee-900);}
        .msg-item-prev{font-size:12px;color:var(--ink-soft);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:230px;}
        .msg-item-time{font-size:10.5px;color:var(--ink-soft);margin-left:auto;flex:none;}
        .msg-detail{background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);box-shadow:var(--shadow-sm);padding:24px;min-height:420px;display:flex;flex-direction:column;}
        .msg-detail-head{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:1px solid var(--line);padding-bottom:16px;margin-bottom:16px;}
        .msg-detail-body{font-size:14.5px;line-height:1.7;color:var(--coffee-800);flex:1;}
        .msg-detail-foot{display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid var(--line);}


        /* Settings */
        .settings-grid{display:grid;grid-template-columns:240px 1fr;gap:24px;align-items:start;}
        .settings-nav{display:flex;flex-direction:column;gap:3px;background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);padding:10px;box-shadow:var(--shadow-sm);}
        .settings-nav button{
            display:flex;align-items:center;gap:10px;text-align:left;padding:11px 13px;border-radius:9px;border:none;background:transparent;
            font-size:13.8px;font-weight:600;color:var(--coffee-700);cursor:pointer;
        }
        .settings-nav button.active{background:var(--sand-100);color:var(--terracotta-600);}
        .settings-nav button svg{width:17px;height:17px;}
        .settings-panel{background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);box-shadow:var(--shadow-sm);padding:26px;}
        .settings-panel h3{font-size:17px;margin-bottom:18px;}
        .settings-pane{display:none;}
        .settings-pane.active{display:block;}
        .field{margin-bottom:16px;}
        .field label{display:block;font-size:12.5px;font-weight:600;color:var(--coffee-700);margin-bottom:7px;text-transform:uppercase;letter-spacing:.04em;}
        .field input,.field select,.field textarea{
            width:100%;padding:12px 14px;border:1.5px solid var(--line);border-radius:var(--radius-sm);
            background:var(--white);font-size:14.5px;color:var(--ink);transition:border-color .15s, box-shadow .15s;
        }
        .field input:focus,.field select:focus,.field textarea:focus{
            outline:none;border-color:var(--terracotta-500);box-shadow:0 0 0 3px var(--terracotta-100);
        }
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
        .toggle-row{display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--line);}
        .toggle-row:last-child{border-bottom:none;}
        .toggle-text strong{display:block;font-size:14px;color:var(--coffee-900);margin-bottom:2px;}
        .toggle-text span{font-size:12.5px;color:var(--ink-soft);}
        .switch{width:42px;height:24px;border-radius:20px;background:var(--sand-200);position:relative;flex:none;border:none;cursor:pointer;transition:background .2s;}
        .switch::after{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:transform .2s;}
        .switch.on{background:var(--acacia-500);}
        .switch.on::after{transform:translateX(18px);}


        /* Modal */
        .modal-backdrop{
            position:fixed;inset:0;background:rgba(36,20,8,.5);backdrop-filter:blur(2px);
            display:none;align-items:flex-start;justify-content:center;z-index:400;padding:40px 20px;overflow-y:auto;
        }
        .modal-backdrop.show{display:flex;}
        .modal{
            background:var(--sand-50);border-radius:var(--radius-lg);width:100%;max-width:560px;
            box-shadow:var(--shadow-lg);animation:riseIn .3s cubic-bezier(.2,.8,.2,1);margin:auto;
        }
        @keyframes riseIn{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
        .modal-head{display:flex;align-items:center;justify-content:space-between;padding:22px 24px;border-bottom:1px solid var(--line);}
        .modal-head h3{font-size:19px;}
        .modal-close{width:34px;height:34px;border-radius:9px;border:1px solid var(--line);background:var(--white);display:flex;align-items:center;justify-content:center;}
        .modal-body{padding:22px 24px;max-height:60vh;overflow-y:auto;}
        .modal-foot{display:flex;justify-content:flex-end;gap:10px;padding:18px 24px;border-top:1px solid var(--line);}


        /* Toast */
        #toastHost{position:fixed;bottom:24px;right:24px;z-index:600;display:flex;flex-direction:column;gap:10px;}
        .toast{
            background:var(--coffee-900);color:#fff;padding:13px 18px;border-radius:11px;font-size:13.5px;font-weight:600;
            box-shadow:var(--shadow-lg);display:flex;align-items:center;gap:10px;min-width:240px;animation:toastIn .3s ease;
        }
        .toast.success{background:var(--acacia-600);}
        .toast.error{background:var(--danger);}
        .toast svg{width:17px;height:17px;flex:none;}
        @keyframes toastIn{from{opacity:0;transform:translateX(20px);}to{opacity:1;transform:translateX(0);}}


        /* Responsive */
        .mobile-overlay{position:fixed;inset:0;background:rgba(36,20,8,.45);z-index:190;display:none;}
        .mobile-overlay.show{display:block;}
        @media (max-width:1180px){
            .stat-grid{grid-template-columns:repeat(2,1fr);}
            .panel-grid{grid-template-columns:1fr;}
            .settings-grid{grid-template-columns:1fr;}
            .msg-layout{grid-template-columns:1fr;}
        }
        @media (max-width:900px){
            .sidebar{transform:translateX(-100%);width:var(--sidebar-w);z-index:300;}
            .sidebar.mobile-open{transform:translateX(0);}
            .main{margin-left:0 !important;}
            .tb-search{display:none;}
        }
        @media (max-width:640px){
            .stat-grid{grid-template-columns:1fr;}
            .view-wrap{padding:16px;}
            .topbar{padding:0 14px;gap:10px;}
            .form-row{grid-template-columns:1fr;}
            .tb-live span{display:none;}
            .view-head h2{font-size:22px;}
        }
        @media (prefers-reduced-motion:reduce){
            *{animation-duration:.001ms !important;transition-duration:.001ms !important;}
        }
    </style>
</head>
<body>
    <div id="app" class="show">
        <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileSidebar()"></div>
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sb-brand">
                <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-white_bexcal.png" alt="Tanzania Daily Tours & Safari" style="width: 38px; height: 38px; border-radius: 10px; flex: none;">
                <div class="sb-brand-text">
                    <strong>Tanzania Daily</strong>
                    <span>Tours & Safari · CMS</span>
                </div>
            </div>
            <nav class="sb-nav">
                <div class="sb-section-label">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="5" rx="1.5"></rect>
                        <rect x="14" y="12" width="7" height="9" rx="1.5"></rect>
                        <rect x="3" y="16" width="7" height="5" rx="1.5"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <div class="sb-section-label">Content</div>
                <a href="{{ route('admin.destinations') }}" class="sb-item {{ request()->routeIs('admin.destinations') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 11 12 4l9 7"></path>
                        <path d="M5 10v10h14V10"></path>
                        <path d="M9 20v-6h6v6"></path>
                    </svg>
                    <span>Destinations</span>
                    <span class="badge" id="navDestCount">{{ $destCount ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.gallery') }}" class="sb-item {{ request()->routeIs('admin.gallery') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.8"></circle>
                        <path d="m21 15-5-5L5 21"></path>
                    </svg>
                    <span>Gallery</span>
                </a>
                <a href="{{ route('admin.reviews') }}" class="sb-item {{ request()->routeIs('admin.reviews') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2.5 15.1 9 22 10 17 15 18.2 22 12 18.6 5.8 22 7 15 2 10 8.9 9"></polygon>
                    </svg>
                    <span>Reviews</span>
                    <span class="badge" id="navReviewCount">{{ $reviewCount ?? 0 }}</span>
                </a>
                <div class="sb-section-label">Operations</div>
                <a href="{{ route('admin.bookings') }}" class="sb-item {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                        <path d="M16 2v4M8 2v4M3 9h18"></path>
                        <path d="m9 14 2 2 4-4"></path>
                    </svg>
                    <span>Bookings</span>
                    <span class="badge" id="navBookingCount">{{ $bookingCount ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.messages') }}" class="sb-item {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"></path>
                    </svg>
                    <span>Messages</span>
                    <span class="badge" id="navMsgCount">{{ $msgCount ?? 0 }}</span>
                </a>
                <div class="sb-section-label">System</div>
                <a href="{{ route('admin.users') }}" class="sb-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Admin Users</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sb-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.7 1.7 0 0 0-1.87-.34 1.7 1.7 0 0 0-1.04 1.56V21a2 2 0 0 1-4 0v-.09A1.7 1.7 0 0 0 9 19.4a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.56-1.04H3a2 2 0 0 1 0-4h.09A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1.04-1.56V3a2 2 0 0 1 4 0v.09A1.7 1.7 0 0 0 15 4.6a1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.56 1.04H21a2 2 0 0 1 0 4h-.09A1.7 1.7 0 0 0 19.4 15Z"></path>
                    </svg>
                    <span>Site Settings</span>
                </a>
            </nav>
            <div class="sb-footer">
                <a href="{{ route('admin.profile') }}" class="sb-user" style="text-decoration:none;">
                    <div class="sb-avatar">
                        {{ $currentAdminUser ? strtoupper(substr($currentAdminUser->name, 0, 2)) : 'AD' }}
                    </div>
                    <div class="sb-user-text">
                        <strong>{{ $currentAdminUser ? $currentAdminUser->name : 'Admin User' }}</strong>
                        <span>{{ $currentAdminUser ? $currentAdminUser->email : 'admin@example.com' }}</span>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main -->
        <div class="main" id="mainArea">
            <header class="topbar">
                <button class="tb-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="7" x2="20" y2="7"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="17" x2="20" y2="17"></line>
                    </svg>
                </button>
                <div class="tb-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Search tours, bookings, guests…">
                </div>
                <div class="tb-right">
                    <div class="tb-live"><span>Site live</span></div>
                    <a class="tb-iconbtn" href="{{ route('home') }}" target="_blank" rel="noopener" aria-label="View live site" title="View live site">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <path d="M15 3h6v6"></path>
                            <path d="M10 14 21 3"></path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="tb-iconbtn" aria-label="Log out" title="Log out">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <div class="view-wrap">
                <!-- Session Messages -->
                @if(session('success'))
                    <div id="toastHost">
                        <div class="toast success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Content -->
                @yield('content')
            </div>
        </div>
    </div>
    <div id="toastHost"></div>
    <script>
        // Auto-logout timer (5 minutes in milliseconds)
        const AUTO_LOGOUT_TIME = 5 * 60 * 1000;
        let autoLogoutTimer;

        // Reset the auto-logout timer on user activity
        function resetAutoLogoutTimer() {
            clearTimeout(autoLogoutTimer);
            autoLogoutTimer = setTimeout(() => {
                // Clear the session on the server side by redirecting to login
                window.location.href = "{{ route('admin.login') }}";
            }, AUTO_LOGOUT_TIME);
        }

        // Add event listeners for user activity
        ['click', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetAutoLogoutTimer, true);
        });

        // Initialize the timer when the page loads
        resetAutoLogoutTimer();

        function toggleSidebar(){
            if(window.innerWidth <= 900){
                document.getElementById('sidebar').classList.toggle('mobile-open');
                document.getElementById('mobileOverlay').classList.toggle('show');
            } else {
                document.getElementById('sidebar').classList.toggle('collapsed');
            }
        }
        function closeMobileSidebar(){
            document.getElementById('sidebar').classList.remove('mobile-open');
            document.getElementById('mobileOverlay').classList.remove('show');
        }

        function toast(msg, type='default'){
            const host = document.getElementById('toastHost');
            const el = document.createElement('div');
            el.className = 'toast ' + (type==='success'?'success':type==='error'?'error':'');
            el.innerHTML = (type==='success' ? '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M20 6 9 17l-5-5\"></path></svg>' : '') + '<span>'+msg+'</span>';
            host.appendChild(el);
            setTimeout(()=>{ el.style.opacity='0'; el.style.transform='translateX(20px)'; el.style.transition='all .25s'; setTimeout(()=>el.remove(),250); }, 3000);
        }

        function openModal(id){ document.getElementById(id).classList.add('show'); }
        function closeModal(id){ document.getElementById(id).classList.remove('show'); }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DentaloveCare') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/denta-love-care-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        /* ── Tokens ────────────────────────────────────────────── */
        :root {
            --blue-dark:   #0a2d6e;
            --blue-mid:    #1a3f8f;
            --blue-light:  #2563eb;
            --blue-hover:  #1d4ed8;
            --blue-active: #e8f0fe;
            --blue-active-text: #1a3f8f;
            --accent:      #06b6d4;
            --bg:          #f0f4ff;
            --bg-card:     #ffffff;
            --text-dark:   #0f172a;
            --text-mid:    #334155;
            --text-muted:  #64748b;
            --border:      #e2e8f0;
            --shadow-sm:   0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md:   0 4px 16px rgba(10,45,110,.08);
            --radius-sm:   8px;
            --radius-md:   12px;
            --radius-lg:   18px;
            --sidebar-w:   240px;

            /* Override Bootstrap */
            --bs-primary:        #2563eb;
            --bs-primary-rgb:    37,99,235;
            --bs-link-color:     #2563eb;
            --bs-link-hover-color: #1d4ed8;
        }

        /* ── Base ──────────────────────────────────────────────── */
        body        { background: var(--bg); color: var(--text-dark); font-size: 13px; line-height: 1.6; overflow-x: hidden; }
        .app-shell  { display: flex; min-height: 100vh; }
        .app-main   { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* ── Sidebar ───────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--blue-dark);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #1e3a7a transparent;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #1e3a7a; border-radius: 4px; }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px 20px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 8px;
        }
        .sidebar-brand-icon {
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            display: grid; place-items: center;
            overflow: hidden;
            background: white;
            flex-shrink: 0;
        }
        .sidebar-brand-icon img { width: 100%; height: 100%; object-fit: contain; }
        .sidebar-brand-text { color: white; }
        .sidebar-brand-text strong { display: block; font-size: 14px; font-weight: 700; line-height: 1.2; }
        .sidebar-brand-text span { font-size: 10px; color: rgba(255,255,255,.55); font-weight: 400; }

        /* Nav sections */
        .nav-section { padding: 0 12px; margin-bottom: 4px; }
        .nav-caption {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
            padding: 16px 8px 6px;
        }

        /* Nav links */
        .sidebar a, .sidebar .nav-link-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.72);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            transition: background .15s, color .15s;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            margin: 1px 0;
        }
        .sidebar a .nav-icon, .sidebar .nav-link-btn .nav-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: grid; place-items: center;
            font-size: 13px;
            flex-shrink: 0;
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.6);
            transition: background .15s, color .15s;
        }
        .sidebar a:hover, .sidebar .nav-link-btn:hover {
            background: rgba(255,255,255,.08);
            color: white;
        }
        .sidebar a:hover .nav-icon, .sidebar .nav-link-btn:hover .nav-icon {
            background: rgba(255,255,255,.12);
            color: white;
        }
        .sidebar a.active {
            background: var(--blue-active);
            color: var(--blue-active-text);
            font-weight: 700;
        }
        .sidebar a.active .nav-icon {
            background: var(--blue-light);
            color: white;
        }

        /* Sidebar promo block */
        .sidebar-promo {
            margin: auto 12px 16px;
            background: linear-gradient(135deg, #1a3f8f 0%, #2563eb 100%);
            border-radius: var(--radius-md);
            padding: 18px 16px;
            border: 1px solid rgba(255,255,255,.12);
        }
        .sidebar-promo h6 { color: white; font-size: 12px; font-weight: 700; margin-bottom: 4px; }
        .sidebar-promo p  { color: rgba(255,255,255,.7); font-size: 10px; margin-bottom: 12px; }
        .sidebar-promo a  {
            display: inline-flex; align-items: center; gap: 6px;
            background: white; color: var(--blue-light);
            padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 700;
            text-decoration: none;
        }
        .sidebar-promo a:hover { background: #f0f4ff; }

        /* ── Topbar ────────────────────────────────────────────── */
        .topbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Search */
        .topbar-search {
            flex: 1;
            max-width: 420px;
            position: relative;
        }
        .topbar-search input {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 9px 14px 9px 38px;
            font-size: 12.5px;
            color: var(--text-dark);
            outline: none;
            transition: border-color .15s;
        }
        .topbar-search input:focus { border-color: var(--blue-light); background: white; }
        .topbar-search .search-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 13px; pointer-events: none;
        }

        /* Topbar right */
        .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }

        .topbar-icon-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: white;
            display: grid; place-items: center;
            color: var(--text-mid);
            cursor: pointer;
            position: relative;
            transition: border-color .15s;
            text-decoration: none;
        }
        .topbar-icon-btn:hover { border-color: var(--blue-light); color: var(--blue-light); }
        .topbar-badge {
            position: absolute; top: -5px; right: -5px;
            background: #ef4444; color: white;
            font-size: 9px; font-weight: 700;
            min-width: 16px; height: 16px;
            border-radius: 8px; display: grid; place-items: center;
            padding: 0 3px; border: 2px solid white;
        }

        /* User chip */
        .topbar-user {
            display: flex; align-items: center; gap: 9px;
            padding: 5px 12px 5px 6px;
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: border-color .15s;
        }
        .topbar-user:hover { border-color: var(--blue-light); }
        .topbar-user-avatar {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--blue-light), var(--accent));
            display: grid; place-items: center;
            color: white; font-size: 13px; font-weight: 700;
            flex-shrink: 0;
        }
        .topbar-user-info strong { display: block; font-size: 12px; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
        .topbar-user-info span   { font-size: 10px; color: var(--text-muted); }

        /* ── App Content ───────────────────────────────────────── */
        .app-content { padding: 28px; flex: 1; }
        .app-content > .container-fluid { padding: 0; }

        /* ── Cards ─────────────────────────────────────────────── */
        .card {
            border-radius: var(--radius-lg) !important;
            border-color: var(--border) !important;
            box-shadow: var(--shadow-sm) !important;
            background: var(--bg-card);
        }
        .card-header {
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
            border-color: var(--border) !important;
            padding: 18px 22px !important;
            background: white;
        }
        .card-title  { font-size: 14px; font-weight: 700; }
        .card-body   { padding: 22px; }

        /* ── Metric Cards ──────────────────────────────────────── */
        .metric-card {
            border-radius: var(--radius-lg) !important;
            padding: 22px;
            height: 100%;
            border: none !important;
            box-shadow: var(--shadow-md) !important;
            overflow: hidden;
            position: relative;
        }
        .metric-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
            pointer-events: none;
        }
        .metric-card.blue   { background: linear-gradient(135deg,#2563eb,#3b82f6); }
        .metric-card.green  { background: linear-gradient(135deg,#059669,#10b981); }
        .metric-card.purple { background: linear-gradient(135deg,#7c3aed,#a78bfa); }
        .metric-card.orange { background: linear-gradient(135deg,#d97706,#f59e0b); }
        .metric-label { font-size: 11px; font-weight: 600; color: rgba(255,255,255,.8); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 10px; }
        .metric-value { font-size: 28px; font-weight: 800; color: white; line-height: 1.1; margin-bottom: 6px; letter-spacing: -1px; }
        .metric-sub   { font-size: 11px; color: rgba(255,255,255,.7); display: flex; align-items: center; gap: 4px; }
        .metric-sub .up   { color: #bbf7d0; }
        .metric-sub .down { color: #fca5a5; }
        .metric-icon-bg {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,.18);
            display: grid; place-items: center;
            font-size: 18px; color: white;
            margin-bottom: 14px;
        }

        /* ── Tables ─────────────────────────────────────────────── */
        .table { --bs-table-color: var(--text-dark); --bs-table-border-color: var(--border); --bs-table-hover-bg: #f8faff; font-size: 12.5px; }
        .table > :not(caption) > * > * { padding: 14px 16px; vertical-align: middle; }
        .table thead th { font-size: 10.5px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .65px; font-weight: 700; background: #f8fafc; white-space: nowrap; }
        .table-responsive { border-radius: 0 0 var(--radius-lg) var(--radius-lg); }

        /* ── Badges ─────────────────────────────────────────────── */
        .badge { padding: 5px 10px; font-weight: 600; border-radius: 6px; font-size: 11px; }
        .badge-status-wait    { background: #fef3c7; color: #92400e; }
        .badge-status-exam    { background: #dbeafe; color: #1e40af; }
        .badge-status-done    { background: #dcfce7; color: #166534; }
        .badge-status-cancel  { background: #fee2e2; color: #991b1b; }
        .badge-status-new     { background: #e0e7ff; color: #3730a3; }
        .badge-paid           { background: #dcfce7; color: #166534; }
        .badge-unpaid         { background: #fee2e2; color: #991b1b; }

        /* ── Buttons ─────────────────────────────────────────────── */
        .btn { border-radius: 9px; font-size: 12.5px; padding: 9px 16px; font-weight: 600; }
        .btn-sm { font-size: 11.5px; padding: 5px 12px; }
        .btn-primary { background: var(--blue-light); border-color: var(--blue-light); }
        .btn-primary:hover { background: var(--blue-hover); border-color: var(--blue-hover); }
        .btn-outline-primary { color: var(--blue-light); border-color: #bfdbfe; }
        .btn-outline-primary:hover { background: var(--blue-light); border-color: var(--blue-light); }

        /* ── Forms ──────────────────────────────────────────────── */
        .form-control, .form-select {
            border-radius: 9px;
            border-color: var(--border);
            min-height: 40px;
            font-size: 13px;
            color: var(--text-dark);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--blue-light);
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-mid); }

        /* ── Hero / Welcome banner ───────────────────────────────── */
        .hero-banner {
            background: linear-gradient(110deg, #0a2d6e 0%, #1a4fbe 45%, #2563eb 70%, #06b6d4 100%);
            border-radius: var(--radius-lg);
            padding: 32px 36px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            right: 180px; top: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            pointer-events: none;
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            right: 60px; top: 20px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(6,182,212,.18);
            pointer-events: none;
        }
        .hero-banner .eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,.65); margin-bottom: 8px; }
        .hero-banner h1 { font-size: clamp(20px, 2.4vw, 28px); font-weight: 800; letter-spacing: -.5px; margin-bottom: 8px; line-height: 1.2; }
        .hero-banner p  { font-size: 13px; color: rgba(255,255,255,.8); max-width: 480px; margin-bottom: 20px; line-height: 1.7; }
        .hero-banner .btn-hero {
            display: inline-flex; align-items: center; gap: 8px;
            background: white; color: var(--blue-light);
            padding: 10px 20px; border-radius: 10px;
            font-size: 13px; font-weight: 700;
            text-decoration: none; border: none;
            transition: transform .15s, box-shadow .15s;
        }
        .hero-banner .btn-hero:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.15); }

        /* ── Hero dekorasi ───────────────────────────────────── */
        /* Overlay foto ruang klinik di sisi kanan */
        .hero-bg-overlay {
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 55%;
            background:
                linear-gradient(to right, #0a2d6e 0%, transparent 40%),
                url('/img/clinic-room.jpg') center/cover no-repeat;
            border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
            opacity: .55;
            pointer-events: none;
        }
        /* Logo klinik */
        .hero-tooth-deco {
            position: absolute;
            right: 22%;
            top: 50%;
            transform: translateY(-50%);
            width: clamp(150px, 18vw, 220px);
            filter: drop-shadow(0 0 24px rgba(6,182,212,.55)) drop-shadow(0 0 6px rgba(255,255,255,.3));
            z-index: 1;
            pointer-events: none;
            animation: toothFloat 4s ease-in-out infinite;
        }
        @keyframes toothFloat {
            0%, 100% { transform: translateY(-50%) translateY(0); }
            50%       { transform: translateY(-50%) translateY(-10px); }
        }
        /* Cincin cahaya di bawah gigi */
        .hero-tooth-deco::after {
            content: '';
            position: absolute;
            bottom: -10px; left: 50%;
            transform: translateX(-50%);
            width: 80%; height: 16px;
            background: radial-gradient(ellipse, rgba(6,182,212,.4) 0%, transparent 70%);
            border-radius: 50%;
        }
        /* Lingkaran dekorasi */
        .hero-circle-1 {
            position: absolute; right: 8%; top: -30px;
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.08);
            pointer-events: none; z-index: 1;
        }
        .hero-circle-2 {
            position: absolute; right: 12%; bottom: -40px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(6,182,212,.12);
            pointer-events: none; z-index: 1;
        }
        /* Tagline kanan bawah */
        .hero-tagline {
            position: absolute; right: 36px; bottom: 28px;
            flex-direction: column; align-items: flex-end;
            z-index: 2; pointer-events: none;
        }
        .hero-tagline span {
            font-size: clamp(11px,1.2vw,15px);
            font-weight: 800; color: rgba(255,255,255,.9);
            letter-spacing: .5px; line-height: 1.4;
            font-style: italic;
        }

        /* ── Shortcut cards ─────────────────────────────────────── */
        .shortcut {
            display: flex; align-items: center; gap: 14px;
            padding: 18px; border-radius: var(--radius-md);
            background: white; border: 1.5px solid var(--border);
            color: var(--text-dark); text-decoration: none; height: 100%;
            transition: border-color .15s, transform .15s, box-shadow .15s;
        }
        .shortcut:hover { border-color: var(--blue-light); transform: translateY(-2px); box-shadow: var(--shadow-md); color: var(--blue-light); }
        .shortcut .sc-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 16px; flex-shrink: 0;
        }
        .shortcut strong { font-size: 12.5px; font-weight: 700; display: block; margin-bottom: 2px; }
        .shortcut small  { font-size: 11px; color: var(--text-muted); }

        /* ── Misc ────────────────────────────────────────────────── */
        .section-label { font-size: 14px; font-weight: 700; color: var(--text-dark); margin: 28px 0 14px; }
        .text-muted { color: var(--text-muted) !important; }
        .page-title { font-size: 20px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; }
        .page-subtitle { font-size: 13px; color: var(--text-muted); }

        /* Promo card */
        .promo-card {
            background: linear-gradient(135deg, #0a2d6e 0%, #2563eb 100%);
            border-radius: var(--radius-lg); padding: 26px 22px;
            color: white; height: 100%;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .promo-card h5 { font-size: 15px; font-weight: 800; color: white; margin-bottom: 6px; }
        .promo-card p  { font-size: 12px; color: rgba(255,255,255,.75); margin-bottom: 18px; }
        .promo-card a  {
            display: inline-flex; align-items: center; gap: 6px;
            background: white; color: var(--blue-light);
            padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 700;
            text-decoration: none;
        }
        .promo-card a:hover { background: #eff6ff; }

        /* Mobile */
        .mobile-menu-btn { display: none; }
        @media (max-width: 1100px) { :root { --sidebar-w: 210px; } .app-content { padding: 20px; } }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed; left: 0; top: 0; height: 100dvh;
                z-index: 1050; transform: translateX(-100%);
                transition: transform .22s cubic-bezier(.4,0,.2,1);
                visibility: hidden;
            }
            .sidebar.is-open { transform: translateX(0); visibility: visible; }
            .mobile-menu-btn { display: grid; place-items: center; width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; border: none; color: var(--text-mid); cursor: pointer; flex-shrink: 0; }
            .nav-backdrop { position: fixed; inset: 0; background: rgba(10,45,110,.45); z-index: 1040; }
            .topbar { padding: 10px 16px; }
            .topbar-search { max-width: none; }
            .app-content { padding: 16px; }
            .hero-badge { display: none; }
        }
        @media (prefers-reduced-motion: reduce) { .sidebar { transition: none; } }
        @media print {
            @page { size: A4; margin: 12mm; }
            body { background: white !important; }
            .sidebar, .topbar, .d-print-none, .btn:not(.tooth-btn), .pagination { display: none !important; }
            .app-shell, .app-main { display: block !important; width: 100% !important; }
            .app-content, .container-fluid { padding: 0 !important; }
            .card { box-shadow: none !important; }
            table { font-size: 9pt; }
            thead { display: table-header-group; }
            tr { break-inside: avoid; }
            .badge { color: black !important; background: #eee !important; }
            a { color: inherit !important; text-decoration: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">

    {{-- ── Sidebar ─────────────────────────────────────────── --}}
    <div id="nav-backdrop" class="nav-backdrop d-none" aria-hidden="true"></div>
    <nav class="sidebar" id="staff-navigation" aria-label="Navigasi petugas">
        <a href="{{ route('pelayanan.dashboard') }}" class="sidebar-brand" style="text-decoration:none;">
            <div class="sidebar-brand-icon"><img src="{{ asset('img/denta-love-care-logo.png') }}" alt="Logo Denta Love Care"></div>
            <div class="sidebar-brand-text">
                <strong>{{ config('app.name', 'DentaloveCare') }}</strong>
                <span>Dental Clinic</span>
            </div>
        </a>

        <div class="nav-section flex-grow-1">
            @yield('sidebar')
        </div>

        <div style="padding:0 12px 16px;">
            <div style="border-top:1px solid rgba(255,255,255,.1);padding-top:14px;color:rgba(255,255,255,.35);font-size:10px;text-align:center;">
                &copy; {{ date('Y') }} {{ config('app.name', 'DentaloveCare') }}
            </div>
        </div>
    </nav>

    {{-- ── Main ────────────────────────────────────────────── --}}
    <div class="app-main">

        {{-- Topbar --}}
        <header class="topbar">
            <button class="mobile-menu-btn" id="nav-toggle" aria-label="Buka navigasi" aria-expanded="false" aria-controls="staff-navigation">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>

            <div class="topbar-search">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" placeholder="Cari pasien, dokter, atau layanan..." aria-label="Pencarian">
            </div>

            <div class="topbar-right">
                @auth
                {{-- Notifikasi --}}
                <div class="topbar-icon-btn" title="Notifikasi">
                    <i class="fa-regular fa-bell" style="font-size:15px;"></i>
                    <span class="topbar-badge">3</span>
                </div>
                @endauth

                {{-- Switch ruang: hanya tampil kalau sudah login --}}
                @auth
                    @if (!request()->routeIs('laporan.*'))
                        <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-primary d-none d-md-flex align-items-center gap-1">
                            <i class="fa-solid fa-chart-line"></i> Laporan
                        </a>
                    @endif
                @endauth

                {{-- User dropdown --}}
                @auth
                <div class="dropdown">
                    <div class="topbar-user" data-bs-toggle="dropdown" aria-expanded="false" role="button" tabindex="0">
                        <div class="topbar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div class="topbar-user-info">
                            <strong>{{ Str::limit(Auth::user()->name, 18) }}</strong>
                            <span>Administrator</span>
                        </div>
                        <i class="fa-solid fa-chevron-down ms-2" style="font-size:10px; color:var(--text-muted);"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width:200px; border-radius:12px;">
                        <li>
                            <div class="px-3 py-2 small text-muted border-bottom">
                                Masuk sebagai<br><strong>{{ Auth::user()->name }}</strong>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-user-pen text-primary me-2"></i> Profil & Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </header>

        {{-- Content --}}
        <main class="app-content">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
    const toggle   = document.getElementById('nav-toggle');
    const nav      = document.getElementById('staff-navigation');
    const backdrop = document.getElementById('nav-backdrop');
    if (!toggle || !nav || !backdrop) return;

    function openMenu()  { nav.classList.add('is-open'); backdrop.classList.remove('d-none'); toggle.setAttribute('aria-expanded','true'); }
    function closeMenu() { nav.classList.remove('is-open'); backdrop.classList.add('d-none'); toggle.setAttribute('aria-expanded','false'); }

    toggle.addEventListener('click', () => nav.classList.contains('is-open') ? closeMenu() : openMenu());
    backdrop.addEventListener('click', closeMenu);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
    window.matchMedia('(min-width: 769px)').addEventListener('change', closeMenu);
})();
</script>
@stack('scripts')
</body>
</html>

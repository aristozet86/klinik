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

        /* ─── Override Bootstrap text-primary → hijau ───────── */
        .text-primary      { color: var(--green-600) !important; }
        .bg-primary        { background-color: var(--green-600) !important; }
        .border-primary    { border-color: var(--green-600) !important; }
        .bg-primary-subtle { background-color: var(--green-50) !important; }

        /* ─── Design Tokens ─────────────────────────────────── */
        :root {
            /* Hijau elegan */
            --green-900:  #052e16;
            --green-800:  #064e1f;
            --green-700:  #15803d;
            --green-600:  #16a34a;
            --green-500:  #22c55e;
            --green-400:  #4ade80;
            --green-100:  #dcfce7;
            --green-50:   #f0fdf4;

            /* Aksen emas/amber untuk kontras elegan */
            --gold:       #d97706;
            --gold-light: #fef3c7;

            /* Surface & teks */
            --bg:         #f4faf6;
            --bg-card:    #ffffff;
            --text-dark:  #0a1f12;
            --text-mid:   #1f4d2e;
            --text-muted: #6b8f72;
            --border:     #d1e8d6;

            /* Shadow */
            --shadow-sm:  0 1px 3px rgba(5,46,22,.06), 0 1px 2px rgba(5,46,22,.04);
            --shadow-md:  0 4px 20px rgba(5,46,22,.10);
            --shadow-lg:  0 8px 32px rgba(5,46,22,.13);

            /* Radius */
            --r-sm:  8px;
            --r-md:  12px;
            --r-lg:  18px;
            --r-xl:  24px;

            /* Sidebar */
            --sidebar-w: 242px;

            /* Bootstrap overrides */
            --bs-primary:         #16a34a;
            --bs-primary-rgb:     22,163,74;
            --bs-link-color:      #16a34a;
            --bs-link-hover-color:#15803d;
        }

        /* ─── Base ───────────────────────────────────────────── */
        body       { background: var(--bg); color: var(--text-dark); font-size: 13px; line-height: 1.65; overflow-x: hidden; }
        .app-shell { display: flex; min-height: 100vh; }
        .app-main  { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* ─── Sidebar ────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--green-900);
            background-image:
                radial-gradient(ellipse at 20% 0%, rgba(21,128,61,.35) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 100%, rgba(5,78,31,.4) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.12) transparent;
        }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 3px; }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 24px 20px 18px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.07);
            margin-bottom: 6px;
        }
        .sidebar-brand-logo {
            width: 40px; height: 40px;
            border-radius: var(--r-sm);
            overflow: hidden;
            background: rgba(255,255,255,.95);
            flex-shrink: 0;
            display: grid; place-items: center;
        }
        .sidebar-brand-logo img { width: 36px; height: 36px; object-fit: contain; }
        .sidebar-brand-text strong { display: block; font-size: 13.5px; font-weight: 800; color: white; line-height: 1.2; letter-spacing: -.2px; }
        .sidebar-brand-text span   { font-size: 10px; color: rgba(255,255,255,.45); font-weight: 400; letter-spacing: .3px; }

        /* Nav */
        .nav-section  { padding: 0 10px; flex: 1; }
        .nav-caption  {
            font-size: 9px; font-weight: 800; letter-spacing: 1.8px;
            text-transform: uppercase; color: rgba(255,255,255,.28);
            padding: 18px 10px 5px;
        }
        .sidebar a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 11px; border-radius: var(--r-sm);
            color: rgba(255,255,255,.65); text-decoration: none;
            font-size: 12.5px; font-weight: 500;
            transition: background .15s, color .15s;
            margin: 1px 0;
        }
        .sidebar a .nav-icon {
            width: 30px; height: 30px; border-radius: 7px;
            display: grid; place-items: center; font-size: 12px;
            flex-shrink: 0;
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.5);
            transition: background .15s, color .15s;
        }
        .sidebar a:hover                    { background: rgba(255,255,255,.07); color: white; }
        .sidebar a:hover .nav-icon          { background: rgba(255,255,255,.13); color: white; }
        .sidebar a.active                   { background: rgba(255,255,255,.12); color: white; font-weight: 700; }
        .sidebar a.active .nav-icon         { background: var(--green-600); color: white; box-shadow: 0 2px 8px rgba(22,163,74,.5); }

        /* Sidebar footer */
        .sidebar-foot {
            padding: 14px 20px 18px;
            border-top: 1px solid rgba(255,255,255,.07);
            font-size: 10px; color: rgba(255,255,255,.28);
            text-align: center;
        }

        /* ─── Topbar ─────────────────────────────────────────── */
        .topbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 11px 26px;
            display: flex; align-items: center; gap: 14px;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar-search {
            flex: 1; max-width: 400px; position: relative;
        }
        .topbar-search input {
            width: 100%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px 8px 36px;
            font-size: 12.5px; color: var(--text-dark);
            outline: none; transition: border-color .15s;
        }
        .topbar-search input:focus { border-color: var(--green-600); background: white; }
        .topbar-search .search-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 12px; pointer-events: none;
        }

        .topbar-right { display: flex; align-items: center; gap: 9px; margin-left: auto; }

        .topbar-icon-btn {
            width: 36px; height: 36px; border-radius: 9px;
            border: 1.5px solid var(--border); background: white;
            display: grid; place-items: center;
            color: var(--text-mid); cursor: pointer; position: relative;
            transition: border-color .15s;
        }
        .topbar-icon-btn:hover { border-color: var(--green-600); color: var(--green-600); }
        .topbar-badge {
            position: absolute; top: -5px; right: -5px;
            background: #ef4444; color: white;
            font-size: 9px; font-weight: 700; min-width: 15px; height: 15px;
            border-radius: 8px; display: grid; place-items: center;
            padding: 0 3px; border: 2px solid white;
        }

        .topbar-user {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 12px 5px 5px;
            background: white; border: 1.5px solid var(--border); border-radius: 10px;
            cursor: pointer; text-decoration: none; transition: border-color .15s;
        }
        .topbar-user:hover { border-color: var(--green-600); }
        .topbar-user-avatar {
            width: 28px; height: 28px; border-radius: 7px;
            background: linear-gradient(135deg, var(--green-700), var(--green-500));
            display: grid; place-items: center;
            color: white; font-size: 12px; font-weight: 800; flex-shrink: 0;
        }
        .topbar-user-info strong { display: block; font-size: 12px; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
        .topbar-user-info span   { font-size: 10px; color: var(--text-muted); }

        /* ─── Content ────────────────────────────────────────── */
        .app-content { padding: 28px; flex: 1; }
        .app-content > .container-fluid { padding: 0; }

        /* ─── Cards ──────────────────────────────────────────── */
        .card {
            border-radius: var(--r-lg) !important;
            border-color: var(--border) !important;
            box-shadow: var(--shadow-sm) !important;
            background: var(--bg-card);
        }
        .card-header {
            border-radius: var(--r-lg) var(--r-lg) 0 0 !important;
            border-color: var(--border) !important;
            padding: 18px 22px !important;
            background: white;
        }
        .card-title { font-size: 14px; font-weight: 700; }
        .card-body  { padding: 22px; }

        /* ─── Metric Cards ───────────────────────────────────── */
        .metric-card {
            border-radius: var(--r-lg) !important;
            padding: 22px; height: 100%;
            border: none !important;
            box-shadow: var(--shadow-md) !important;
            overflow: hidden; position: relative;
        }
        .metric-card::after {
            content: '';
            position: absolute; right: -18px; top: -18px;
            width: 90px; height: 90px; border-radius: 50%;
            background: rgba(255,255,255,.08); pointer-events: none;
        }
        /* Warna hijau elegan */
        .metric-card.green   { background: linear-gradient(135deg,#064e1f,#15803d); }
        .metric-card.teal    { background: linear-gradient(135deg,#134e4a,#0f9488); }
        .metric-card.emerald { background: linear-gradient(135deg,#065f46,#059669); }
        .metric-card.sage    { background: linear-gradient(135deg,#365314,#65a30d); }
        /* Tetap sediakan alias lama */
        .metric-card.blue    { background: linear-gradient(135deg,#064e1f,#15803d); }
        .metric-card.purple  { background: linear-gradient(135deg,#134e4a,#0f9488); }
        .metric-card.orange  { background: linear-gradient(135deg,#365314,#65a30d); }

        .metric-label { font-size: 10.5px; font-weight: 700; color: rgba(255,255,255,.75); text-transform: uppercase; letter-spacing: .7px; margin-bottom: 10px; }
        .metric-value { font-size: 28px; font-weight: 800; color: white; line-height: 1.1; margin-bottom: 7px; letter-spacing: -1px; }
        .metric-sub   { font-size: 11px; color: rgba(255,255,255,.65); display: flex; align-items: center; gap: 4px; }
        .metric-sub .up   { color: #bbf7d0; }
        .metric-sub .down { color: #fca5a5; }
        .metric-icon-bg {
            width: 42px; height: 42px; border-radius: 11px;
            background: rgba(255,255,255,.15);
            display: grid; place-items: center;
            font-size: 17px; color: white; margin-bottom: 14px;
        }

        /* ─── Tables ─────────────────────────────────────────── */
        .table {
            --bs-table-color: var(--text-dark);
            --bs-table-border-color: var(--border);
            --bs-table-hover-bg: var(--green-50);
            font-size: 12.5px;
        }
        .table > :not(caption) > * > * { padding: 13px 15px; vertical-align: middle; }
        .table thead th {
            font-size: 10px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .7px;
            font-weight: 700; background: var(--green-50); white-space: nowrap;
        }
        .table-responsive { border-radius: 0 0 var(--r-lg) var(--r-lg); }

        /* ─── Badges ─────────────────────────────────────────── */
        .badge { padding: 5px 10px; font-weight: 600; border-radius: 6px; font-size: 11px; }
        .badge-status-wait   { background: #fef9c3; color: #854d0e; }
        .badge-status-exam   { background: #d1fae5; color: #065f46; }
        .badge-status-done   { background: #dcfce7; color: #14532d; }
        .badge-status-cancel { background: #fee2e2; color: #991b1b; }
        .badge-status-new    { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-paid          { background: #dcfce7; color: #14532d; }
        .badge-unpaid        { background: #fee2e2; color: #991b1b; }

        /* ─── Buttons ────────────────────────────────────────── */
        .btn { border-radius: 9px; font-size: 12.5px; padding: 9px 16px; font-weight: 600; }
        .btn-sm { font-size: 11.5px; padding: 5px 12px; }
        .btn-primary           { background: var(--green-600); border-color: var(--green-600); color: white; }
        .btn-primary:hover     { background: var(--green-700); border-color: var(--green-700); color: white; }
        .btn-outline-primary   { color: var(--green-700); border-color: #86efac; }
        .btn-outline-primary:hover { background: var(--green-600); border-color: var(--green-600); color: white; }
        .btn-outline-secondary { color: var(--text-mid); border-color: var(--border); }

        /* ─── Forms ──────────────────────────────────────────── */
        .form-control, .form-select {
            border-radius: 9px; border-color: var(--border);
            min-height: 40px; font-size: 13px; color: var(--text-dark);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--green-600);
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
        }
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-mid); }

        /* ─── Hero Banner ────────────────────────────────────── */
        .hero-banner {
            background: linear-gradient(118deg, #052e16 0%, #064e1f 35%, #15803d 65%, #22c55e 100%);
            border-radius: var(--r-lg);
            padding: 32px 36px; color: white;
            position: relative; overflow: hidden; margin-bottom: 24px;
        }
        .hero-banner::before {
            content: '';
            position: absolute; right: 160px; top: -70px;
            width: 280px; height: 280px; border-radius: 50%;
            background: rgba(255,255,255,.04); pointer-events: none;
        }
        .hero-banner::after {
            content: '';
            position: absolute; right: 40px; top: 10px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(74,222,128,.12); pointer-events: none;
        }
        .hero-banner .eyebrow {
            font-size: 10px; font-weight: 700; letter-spacing: 1.6px;
            text-transform: uppercase; color: rgba(255,255,255,.55); margin-bottom: 8px;
        }
        .hero-banner h1 {
            font-size: clamp(19px, 2.4vw, 27px); font-weight: 800;
            letter-spacing: -.5px; margin-bottom: 8px; line-height: 1.2;
        }
        .hero-banner p {
            font-size: 13px; color: rgba(255,255,255,.75);
            max-width: 460px; margin-bottom: 0; line-height: 1.7;
        }

        /* Hero dekorasi */
        .hero-bg-overlay {
            position: absolute; right: 0; top: 0; bottom: 0; width: 50%;
            background:
                linear-gradient(to right, #052e16 0%, transparent 40%),
                url('/img/clinic-room.jpg') center/cover no-repeat;
            border-radius: 0 var(--r-lg) var(--r-lg) 0;
            opacity: .45; pointer-events: none;
        }
        .hero-tooth-deco {
            position: absolute; right: 20%; top: 50%;
            transform: translateY(-50%);
            width: clamp(80px, 11vw, 140px);
            filter: drop-shadow(0 0 22px rgba(74,222,128,.5))
                    drop-shadow(0 0 6px rgba(255,255,255,.25));
            z-index: 1; pointer-events: none;
            animation: floatTooth 4s ease-in-out infinite;
        }
        @keyframes floatTooth {
            0%,100% { transform: translateY(-50%); }
            50%     { transform: translateY(calc(-50% - 10px)); }
        }
        .hero-circle-1 {
            position: absolute; right: 7%; top: -35px;
            width: 150px; height: 150px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.07); pointer-events: none; z-index: 1;
        }
        .hero-circle-2 {
            position: absolute; right: 11%; bottom: -45px;
            width: 100px; height: 100px; border-radius: 50%;
            background: rgba(74,222,128,.1); pointer-events: none; z-index: 1;
        }
        .hero-tagline {
            position: absolute; right: 34px; bottom: 26px;
            flex-direction: column; align-items: flex-end;
            z-index: 2; pointer-events: none;
        }
        .hero-tagline span {
            font-size: clamp(11px,1.1vw,14px);
            font-weight: 800; color: rgba(255,255,255,.85);
            letter-spacing: .4px; line-height: 1.4; font-style: italic;
        }

        /* ─── Shortcuts ──────────────────────────────────────── */
        .shortcut {
            display: flex; align-items: center; gap: 13px;
            padding: 17px; border-radius: var(--r-md);
            background: white; border: 1.5px solid var(--border);
            color: var(--text-dark); text-decoration: none; height: 100%;
            transition: border-color .15s, transform .15s, box-shadow .15s;
        }
        .shortcut:hover { border-color: var(--green-600); transform: translateY(-2px); box-shadow: var(--shadow-md); color: var(--green-700); }
        .shortcut strong { font-size: 12.5px; font-weight: 700; display: block; margin-bottom: 2px; }
        .shortcut small  { font-size: 11px; color: var(--text-muted); }

        /* ─── Promo Card ─────────────────────────────────────── */
        .promo-card {
            background: linear-gradient(135deg, #052e16 0%, #15803d 100%);
            border-radius: var(--r-lg); padding: 26px 22px; color: white;
            height: 100%; display: flex; flex-direction: column; justify-content: space-between;
        }
        .promo-card h5 { font-size: 15px; font-weight: 800; color: white; margin-bottom: 6px; }
        .promo-card p  { font-size: 12px; color: rgba(255,255,255,.7); margin-bottom: 0; }

        /* ─── Misc ───────────────────────────────────────────── */
        .section-label { font-size: 14px; font-weight: 700; color: var(--text-dark); margin: 28px 0 14px; }
        .text-muted    { color: var(--text-muted) !important; }
        .page-title    { font-size: 20px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; }

        /* Laporan card */
        .laporan-card {
            display: flex; align-items: center; gap: 17px;
            padding: 20px 18px; border-radius: 15px;
            border: 1.5px solid rgba(0,0,0,.05);
            transition: transform .18s, box-shadow .18s, border-color .18s;
        }
        .laporan-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: rgba(22,163,74,.25); }
        .laporan-card-icon  { width: 50px; height: 50px; border-radius: 13px; display: grid; place-items: center; font-size: 19px; color: white; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,.12); }
        .laporan-card-body  { flex: 1; min-width: 0; }
        .laporan-card-title { font-size: 14px; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
        .laporan-card-desc  { font-size: 12px; color: var(--text-muted); line-height: 1.5; }
        .laporan-card-arrow { width: 30px; height: 30px; border-radius: 50%; background: rgba(0,0,0,.06); display: grid; place-items: center; font-size: 11px; color: var(--text-muted); flex-shrink: 0; transition: background .15s, color .15s; }
        .laporan-card:hover .laporan-card-arrow { background: var(--green-600); color: white; }

        /* ─── Mobile ─────────────────────────────────────────── */
        .mobile-menu-btn { display: none; }
        @media (max-width: 1100px) { :root { --sidebar-w: 210px; } .app-content { padding: 20px; } }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: 0; top: 0; height: 100dvh; z-index: 1050; transform: translateX(-100%); transition: transform .22s cubic-bezier(.4,0,.2,1); visibility: hidden; }
            .sidebar.is-open { transform: translateX(0); visibility: visible; }
            .mobile-menu-btn { display: grid; place-items: center; width: 36px; height: 36px; border-radius: 8px; background: var(--green-50); border: 1.5px solid var(--border); color: var(--text-mid); cursor: pointer; flex-shrink: 0; }
            .nav-backdrop    { position: fixed; inset: 0; background: rgba(5,46,22,.5); z-index: 1040; }
            .topbar          { padding: 10px 16px; }
            .app-content     { padding: 16px; }
            .hero-tooth-deco, .hero-tagline { display: none !important; }
        }
        @media (prefers-reduced-motion: reduce) { .sidebar { transition: none; } .hero-tooth-deco { animation: none; } }
        @media print {
            @page { size: A4; margin: 12mm; }
            body { background: white !important; }
            .sidebar, .topbar, .d-print-none, .btn:not(.tooth-btn), .pagination { display: none !important; }
            .app-shell, .app-main { display: block !important; width: 100% !important; }
            .app-content, .container-fluid { padding: 0 !important; }
            .card  { box-shadow: none !important; }
            table  { font-size: 9pt; }
            thead  { display: table-header-group; }
            tr     { break-inside: avoid; }
            .badge { color: black !important; background: #eee !important; }
            a      { color: inherit !important; text-decoration: none !important; }
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
            <div class="sidebar-brand-logo">
                <img src="{{ asset('img/denta-love-care-logo.png') }}" alt="Logo">
            </div>
            <div class="sidebar-brand-text">
                <strong>{{ config('app.name', 'DentaloveCare') }}</strong>
                <span>Dental Clinic</span>
            </div>
        </a>

        <div class="nav-section">
            @yield('sidebar')
        </div>

        <div class="sidebar-foot">
            &copy; {{ date('Y') }} {{ config('app.name', 'DentaloveCare') }}
        </div>
    </nav>

    {{-- ── Main ────────────────────────────────────────────── --}}
    <div class="app-main">
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
                <div class="topbar-icon-btn" title="Notifikasi">
                    <i class="fa-regular fa-bell" style="font-size:14px;"></i>
                    <span class="topbar-badge">3</span>
                </div>

                @if (!request()->routeIs('laporan.*'))
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-primary d-none d-md-flex align-items-center gap-1">
                        <i class="fa-solid fa-chart-line"></i> Laporan
                    </a>
                @endif

                <div class="dropdown">
                    <div class="topbar-user" data-bs-toggle="dropdown" aria-expanded="false" role="button" tabindex="0">
                        <div class="topbar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div class="topbar-user-info">
                            <strong>{{ Str::limit(Auth::user()->name, 16) }}</strong>
                            <span>Administrator</span>
                        </div>
                        <i class="fa-solid fa-chevron-down ms-2" style="font-size:9px; color:var(--text-muted);"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width:195px; border-radius:12px;">
                        <li>
                            <div class="px-3 py-2 small text-muted border-bottom">
                                Masuk sebagai<br><strong>{{ Auth::user()->name }}</strong>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-user-pen me-2" style="color:var(--green-600);"></i> Profil & Password
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

    const open  = () => { nav.classList.add('is-open');    backdrop.classList.remove('d-none'); toggle.setAttribute('aria-expanded','true');  };
    const close = () => { nav.classList.remove('is-open'); backdrop.classList.add('d-none');    toggle.setAttribute('aria-expanded','false'); };

    toggle.addEventListener('click', () => nav.classList.contains('is-open') ? close() : open());
    backdrop.addEventListener('click', close);
    document.addEventListener('keydown', e => e.key === 'Escape' && close());
    window.matchMedia('(min-width: 769px)').addEventListener('change', close);
})();
</script>
@stack('scripts')
</body>
</html>

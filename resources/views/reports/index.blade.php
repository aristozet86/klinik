@extends('layouts.laporan')

@section('content')
<div class="container-fluid">

    {{-- ── Hero Banner ─────────────────────────────────────── --}}
    <div class="hero-banner mb-4">
        <div class="hero-bg-overlay"></div>
        <div class="hero-tooth-deco" aria-hidden="true">
            <img src="{{ asset('img/denta-love-care-logo.png') }}" alt="" style="display:block;width:100%;height:auto;border-radius:20px;">
        </div>
        <div class="hero-circle-1"></div>
        <div class="hero-circle-2"></div>
        <div style="position:relative;z-index:2;">
            <div class="eyebrow">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
            <h1>Dashboard Laporan<br>
                <span style="font-weight:500;font-size:72%;opacity:.92;">Analitik & Rekapitulasi <span style="color:#67e8f9;font-size:110%;">↗</span> Klinik</span>
            </h1>
            <p>Data diperbarui langsung dari pendaftaran dan pelayanan.<br>Pilih laporan di bawah untuk melihat detail.</p>
        </div>
        <div class="hero-tagline d-none d-lg-flex" aria-hidden="true">
            <span>Data</span>
            <span>Terpercaya</span>
        </div>
    </div>

    {{-- ── Metric Cards ────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card metric-card green">
                <div class="metric-icon-bg"><i class="fa-solid fa-users"></i></div>
                <div class="metric-label">Total Pasien</div>
                <div class="metric-value">{{ number_format($totalPatients, 0, ',', '.') }}</div>
                <div class="metric-sub"><i class="fa-solid fa-circle-dot" style="color:rgba(255,255,255,.5);font-size:8px;"></i><span style="color:rgba(255,255,255,.75);">Seluruh pasien terdaftar</span></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card metric-card teal">
                <div class="metric-icon-bg"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="metric-label">Total Kunjungan</div>
                <div class="metric-value">{{ number_format($totalVisits, 0, ',', '.') }}</div>
                <div class="metric-sub"><i class="fa-solid fa-circle-dot" style="color:rgba(255,255,255,.5);font-size:8px;"></i><span style="color:rgba(255,255,255,.75);">Semua kunjungan tercatat</span></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card metric-card emerald">
                <div class="metric-icon-bg"><i class="fa-solid fa-chart-line"></i></div>
                <div class="metric-label">Kunjungan Bulan Ini</div>
                <div class="metric-value">{{ number_format($visitsThisMonth, 0, ',', '.') }}</div>
                <div class="metric-sub"><i class="fa-solid fa-arrow-trend-up up"></i><span class="up">Dari awal bulan</span></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card metric-card sage">
                <div class="metric-icon-bg"><i class="fa-solid fa-dollar-sign"></i></div>
                <div class="metric-label">Pendapatan Bulan Ini</div>
                <div class="metric-value" style="font-size:clamp(14px,1.6vw,20px);">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
                <div class="metric-sub"><i class="fa-solid fa-circle-dot" style="color:rgba(255,255,255,.5);font-size:8px;"></i><span style="color:rgba(255,255,255,.75);">Pembayaran lunas</span></div>
            </div>
        </div>
    </div>

    {{-- ── Navigasi Laporan ──────────────────────────────────── --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="section-label mb-0">Navigasi Laporan</h2>
        <span class="text-muted" style="font-size:11px;">Pilih laporan yang ingin ditampilkan</span>
    </div>

    <div class="row g-3">

        {{-- Laporan Kunjungan --}}
        <div class="col-12 col-md-6">
            <a href="{{ route('laporan.kunjungan') }}" class="text-decoration-none">
                <div class="laporan-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <div class="laporan-card-icon" style="background:linear-gradient(135deg,#064e1f,#15803d);">
                        <i class="fa-solid fa-file-waveform"></i>
                    </div>
                    <div class="laporan-card-body">
                        <div class="laporan-card-title">Laporan Kunjungan</div>
                        <div class="laporan-card-desc">Tinjau, filter, dan cetak data kunjungan pasien per periode</div>
                    </div>
                    <div class="laporan-card-arrow">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Grafik Kunjungan --}}
        <div class="col-12 col-md-6">
            <a href="{{ route('laporan.grafik') }}" class="text-decoration-none">
                <div class="laporan-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <div class="laporan-card-icon" style="background:linear-gradient(135deg,#059669,#10b981);">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="laporan-card-body">
                        <div class="laporan-card-title">Grafik Kunjungan</div>
                        <div class="laporan-card-desc">Visualisasi tren dan statistik kunjungan klinik per bulan</div>
                    </div>
                    <div class="laporan-card-arrow">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Laporan Keuangan --}}
        <div class="col-12 col-md-6">
            <a href="{{ route('laporan.keuangan') }}" class="text-decoration-none">
                <div class="laporan-card" style="background:linear-gradient(135deg,#fefce8,#fef9c3);">
                    <div class="laporan-card-icon" style="background:linear-gradient(135deg,#365314,#65a30d);">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div class="laporan-card-body">
                        <div class="laporan-card-title">Laporan Keuangan</div>
                        <div class="laporan-card-desc">Pantau pendapatan, piutang, dan rekapitulasi pembayaran</div>
                    </div>
                    <div class="laporan-card-arrow">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Laporan Tindakan --}}
        <div class="col-12 col-md-6">
            <a href="{{ route('laporan.tindakan') }}" class="text-decoration-none">
                <div class="laporan-card" style="background:linear-gradient(135deg,#f0fdf4,#bbf7d0);">
                    <div class="laporan-card-icon" style="background:linear-gradient(135deg,#065f46,#059669);">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <div class="laporan-card-body">
                        <div class="laporan-card-title">Laporan Tindakan</div>
                        <div class="laporan-card-desc">Tinjau tindakan medis, frekuensi, dan kontribusi pendapatan</div>
                    </div>
                    <div class="laporan-card-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </a>
        </div>

        {{-- Laporan Pendapatan Dokter --}}
        <div class="col-12 col-md-6">
            <a href="{{ route('laporan.dokter') }}" class="text-decoration-none">
                <div class="laporan-card" style="background:linear-gradient(135deg,#ecfdf5,#a7f3d0);">
                    <div class="laporan-card-icon" style="background:linear-gradient(135deg,#064e1f,#22c55e);">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div class="laporan-card-body">
                        <div class="laporan-card-title">Pendapatan Dokter</div>
                        <div class="laporan-card-desc">Rincian jasa dokter vs pendapatan klinik per periode</div>
                    </div>
                    <div class="laporan-card-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </a>
        </div>

    </div>

</div>

@push('styles')
<style>
    .laporan-card {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 22px 20px;
        border-radius: 16px;
        border: 1.5px solid rgba(0,0,0,.06);
        transition: transform .18s, box-shadow .18s, border-color .18s;
    }
    .laporan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(10,45,110,.12);
        border-color: rgba(37,99,235,.25);
    }
    .laporan-card-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: grid; place-items: center;
        font-size: 20px; color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
    }
    .laporan-card-body { flex: 1; min-width: 0; }
    .laporan-card-title {
        font-size: 14px; font-weight: 700;
        color: #0f172a; margin-bottom: 4px;
    }
    .laporan-card-desc {
        font-size: 12px; color: #64748b; line-height: 1.5;
    }
    .laporan-card-arrow {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: rgba(0,0,0,.07);
        display: grid; place-items: center;
        font-size: 12px; color: #64748b;
        flex-shrink: 0;
        transition: background .15s, color .15s;
    }
    .laporan-card:hover .laporan-card-arrow {
        background: var(--green-600, #16a34a);
        color: white;
    }
</style>
@endpush

@endsection

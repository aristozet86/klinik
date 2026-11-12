@extends('layouts.pelayanan')

@section('content')
<div class="container-fluid">

    {{-- ── Hero Banner ─────────────────────────────────────── --}}
    <div class="hero-banner mb-4">
        {{-- Overlay ruang klinik (jika ada gambar) --}}
        <div class="hero-bg-overlay"></div>

        {{-- Logo klinik --}}
        <div class="hero-tooth-deco" aria-hidden="true">
            <img src="{{ asset('img/denta-love-care-logo.png') }}" alt="" style="display:block;width:100%;height:auto;border-radius:20px;">
        </div>

        {{-- Lingkaran dekorasi --}}
        <div class="hero-circle-1"></div>
        <div class="hero-circle-2"></div>

        <div style="position:relative;z-index:2;">
            <div class="eyebrow">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
            <h1>{{ config('app.name', 'DentaloveCare') }}<br>
                <span style="font-weight:500;font-size:72%;opacity:.92;">Klinik Gigi Terpercaya<br>untuk Senyum Lebih Sehat <span style="color:#67e8f9;font-size:110%;">↗</span></span>
            </h1>
            <p>Perawatan modern, dokter profesional,<br>dan pelayanan terbaik untuk Anda.</p>
        </div>

        <div class="hero-tagline d-none d-lg-flex" aria-hidden="true">
            <span>Healthy Smile</span>
            <span>Brighter Life</span>
        </div>
    </div>

    {{-- ── Metric Cards ────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card metric-card blue">
                <div class="metric-icon-bg"><i class="fa-solid fa-users"></i></div>
                <div class="metric-label">Total Pasien</div>
                <div class="metric-value">{{ number_format($totalPasien, 0, ',', '.') }}</div>
                <div class="metric-sub">
                    <i class="fa-solid fa-arrow-trend-up up"></i>
                    <span class="up">Seluruh pasien terdaftar</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card metric-card green">
                <div class="metric-icon-bg"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="metric-label">Janji Temu Hari Ini</div>
                <div class="metric-value">{{ $kunjunganHariIni }}</div>
                <div class="metric-sub">
                    <i class="fa-solid fa-arrow-trend-up up"></i>
                    <span class="up">Kunjungan hari ini</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card metric-card purple">
                <div class="metric-icon-bg"><i class="fa-solid fa-stethoscope"></i></div>
                <div class="metric-label">Menunggu Pemeriksaan</div>
                <div class="metric-value">{{ $menungguPemeriksaan }}</div>
                <div class="metric-sub">
                    <span style="color:rgba(255,255,255,.75);">Antrian aktif hari ini</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card metric-card orange">
                <div class="metric-icon-bg"><i class="fa-solid fa-dollar-sign"></i></div>
                <div class="metric-label">Pendapatan Hari Ini</div>
                <div class="metric-value" style="font-size:clamp(16px,1.8vw,22px);">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                <div class="metric-sub">
                    <i class="fa-solid fa-arrow-trend-up up"></i>
                    <span class="up">Pembayaran lunas</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Body: Tabel + Promo ─────────────────────────────── --}}
    <div class="row g-4">

        {{-- Tabel kunjungan terbaru --}}
        <div class="col-lg-8">
            <div class="card border-0 h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Pasien Terbaru
                    </h5>
                    <a href="{{ route('pelayanan.kunjungan') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="fa-solid fa-arrow-right ms-1" style="font-size:10px;"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentVisits as $i => $rv)
                                    <tr>
                                        <td class="ps-4 text-muted fw-semibold">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#2563eb,#06b6d4);display:grid;place-items:center;color:white;font-weight:700;font-size:13px;flex-shrink:0;">
                                                    {{ strtoupper(substr($rv->patient ? $rv->patient->nama : '?', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold" style="font-size:12.5px;">{{ $rv->patient ? $rv->patient->nama : '-' }}</div>
                                                    <div class="text-muted" style="font-size:10.5px;">{{ $rv->patient ? $rv->patient->no_rm : '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-size:12px;">{{ $rv->tanggal_kunjungan->format('d M Y') }}</div>
                                            <div class="text-muted" style="font-size:10.5px;">{{ $rv->jam_kunjungan ?? '-' }}</div>
                                        </td>
                                        <td>
                                            @if ($rv->status === 'Selesai')
                                                <span class="badge badge-status-done">Selesai</span>
                                            @elseif ($rv->status === 'Sedang Diperiksa')
                                                <span class="badge badge-status-exam">Periksa</span>
                                            @elseif ($rv->status === 'Batal')
                                                <span class="badge badge-status-cancel">Batal</span>
                                            @else
                                                <span class="badge badge-status-wait">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('pelayanan.kunjungan.edit', $rv) }}" class="btn btn-sm btn-primary">
                                                Periksa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-calendar-xmark fs-3 d-block mb-2"></i>
                                            Belum ada kunjungan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: shortcut + promo --}}
        <div class="col-lg-4 d-flex flex-column gap-3">

            {{-- Shortcut Layanan Unggulan --}}
            <div class="card border-0">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fa-solid fa-bolt text-warning me-2"></i>Akses Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach ([
                            ['pelayanan.pendaftaran', 'user-plus',        'Pendaftaran',  'linear-gradient(135deg,#2563eb,#60a5fa)'],
                            ['pelayanan.pemeriksaan', 'stethoscope',      'Pemeriksaan',  'linear-gradient(135deg,#059669,#34d399)'],
                            ['pelayanan.odontogram',  'tooth',            'Odontogram',   'linear-gradient(135deg,#7c3aed,#c4b5fd)'],
                            ['pelayanan.riwayat',     'clock-rotate-left','Rekam Medis',  'linear-gradient(135deg,#d97706,#fcd34d)'],
                        ] as [$route, $icon, $label, $grad])
                        <div class="col-6">
                            <a href="{{ route($route) }}" class="text-decoration-none">
                                <div class="text-center p-3 rounded-3 border" style="transition:.15s;" onmouseover="this.style.borderColor='#2563eb';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='';this.style.transform=''">
                                    <div style="width:44px;height:44px;border-radius:12px;background:{{ $grad }};display:grid;place-items:center;margin:0 auto 10px;font-size:18px;color:white;">
                                        <i class="fa-solid fa-{{ $icon }}"></i>
                                    </div>
                                    <div style="font-size:11.5px;font-weight:700;color:var(--text-dark);">{{ $label }}</div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Promo card --}}
            <div class="promo-card flex-grow-1">
                <div>
                    <div style="font-size:26px;margin-bottom:12px;">🦷</div>
                    <h5>{{ config('app.name', 'DentaloveCare') }}</h5>
                    <p>Solusi Perawatan Gigi<br>untuk Keluarga Anda</p>
                </div>
                <div style="font-size:11px;color:rgba(255,255,255,.5);">&copy; {{ date('Y') }} {{ config('app.name') }}</div>
            </div>

        </div>
    </div>

</div>
@endsection

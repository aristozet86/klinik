@extends('layouts.pelayanan')

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="hero-banner mb-4">
        <div class="hero-bg-overlay"></div>
        <div class="hero-tooth-deco" aria-hidden="true">
            <img src="{{ asset('img/denta-love-care-logo.png') }}" alt="" style="display:block;width:100%;height:auto;border-radius:20px;">
        </div>
        <div class="hero-circle-1"></div>
        <div class="hero-circle-2"></div>

        <div style="position:relative;z-index:2;">
            <div class="eyebrow">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
            <h1>{{ config('app.name', 'Denta Love Care') }}<br>
                <span style="font-weight:500;font-size:72%;opacity:.92;">Klinik Gigi Terpercaya<br>untuk Senyum Lebih Sehat <span style="color:#67e8f9;font-size:110%;">↗</span></span>
            </h1>
            <p>Perawatan modern, dokter profesional,<br>dan pelayanan terbaik untuk Anda.</p>
            <p class="mb-0">Silakan hubungi klinik untuk informasi jadwal dan pendaftaran pasien.</p>
        </div>

        <div class="hero-tagline d-none d-lg-flex" aria-hidden="true">
            <span>Healthy Smile</span>
            <span>Brighter Life</span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="metric-icon-bg" style="position:static;flex:0 0 48px;width:48px;height:48px;background:linear-gradient(135deg,#059669,#34d399);">
                        <i class="fa-solid fa-tooth"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Pelayanan Klinik</h5>
                        <p class="text-muted mb-0">Kami siap membantu menjaga kesehatan gigi dan senyum Anda.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between gap-3 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="metric-icon-bg" style="position:static;flex:0 0 48px;width:48px;height:48px;">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Pendaftaran Pasien</h5>
                            <p class="text-muted mb-0">Daftarkan kunjungan Anda ke Poli Gigi.</p>
                        </div>
                    </div>
                    <a href="{{ route('pelayanan.pendaftaran') }}" class="btn btn-primary flex-shrink-0">
                        Daftar <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

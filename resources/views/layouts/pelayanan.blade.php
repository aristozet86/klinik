@extends('layouts.app')

@section('workspace', 'Pelayanan & Pendaftaran')

@section('sidebar')
    <div class="nav-caption">Menu Utama</div>

    <a href="{{ route('pelayanan.dashboard') }}"
       class="{{ request()->routeIs('pelayanan.dashboard') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
        Dashboard
    </a>

    <a href="{{ route('pelayanan.pendaftaran') }}"
       class="{{ request()->routeIs('pelayanan.pendaftaran*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-user-plus"></i></span>
        Pendaftaran
    </a>

    <a href="{{ route('pelayanan.pasien') }}"
       class="{{ request()->routeIs('pelayanan.pasien', 'pelayanan.pasien.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-hospital-user"></i></span>
        Data Pasien
    </a>

    <a href="{{ route('pelayanan.kunjungan') }}"
       class="{{ (request()->routeIs('pelayanan.kunjungan') || request()->routeIs('pelayanan.kunjungan.*')) ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
        Kunjungan
    </a>

    <a href="{{ route('pelayanan.pemeriksaan') }}"
       class="{{ (request()->routeIs('pelayanan.pemeriksaan') || request()->routeIs('pelayanan.kunjungan.edit') || request()->routeIs('pelayanan.kunjungan.update')) ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-stethoscope"></i></span>
        Pemeriksaan
    </a>

    <a href="{{ route('pelayanan.odontogram') }}"
       class="{{ request()->routeIs('pelayanan.odontogram', 'pelayanan.odontogram.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-tooth"></i></span>
        Odontogram
    </a>

    <a href="{{ route('pelayanan.riwayat') }}"
       class="{{ request()->routeIs('pelayanan.riwayat', 'pelayanan.riwayat.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
        Rekam Medis
    </a>

    <div class="nav-caption" style="margin-top:8px;">Laporan & Analitik</div>

    @auth
        <a href="{{ route('laporan.index') }}"
           class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
            Laporan
        </a>
    @else
        <a href="{{ route('laporan.login') }}">
            <span class="nav-icon"><i class="fa-solid fa-right-to-bracket"></i></span>
            Masuk ke Laporan
        </a>
    @endauth
@endsection

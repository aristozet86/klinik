@extends('layouts.app')

@section('workspace', 'Laporan & Analitik')

@section('sidebar')
    <div class="nav-caption">Pelayanan</div>

    <a href="{{ route('pelayanan.dashboard') }}">
        <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
        Ruang Pelayanan
    </a>

    <div class="nav-caption" style="margin-top:8px;">Laporan & Analitik</div>

    <a href="{{ route('laporan.index') }}"
       class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
        Dashboard Laporan
    </a>

    <a href="{{ route('laporan.kunjungan') }}"
       class="{{ request()->routeIs('laporan.kunjungan') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-file-waveform"></i></span>
        Laporan Kunjungan
    </a>

    <a href="{{ route('laporan.grafik') }}"
       class="{{ request()->routeIs('laporan.grafik') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
        Grafik Kunjungan
    </a>

    <a href="{{ route('laporan.keuangan') }}"
       class="{{ request()->routeIs('laporan.keuangan') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
        Laporan Keuangan
    </a>

    <a href="{{ route('laporan.tindakan') }}"
       class="{{ request()->routeIs('laporan.tindakan') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fa-solid fa-clipboard-check"></i></span>
        Laporan Tindakan
    </a>
@endsection

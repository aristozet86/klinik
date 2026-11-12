@extends('layouts.pelayanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-stethoscope text-primary me-2"></i>Kunjungan Menunggu Pemeriksaan</h3>
            <p class="text-muted mb-0">Pilih kunjungan yang sudah didaftarkan untuk mengisi hasil pemeriksaan medis.</p>
        </div>
        <a href="{{ route('pelayanan.pendaftaran') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus me-1"></i> Pendaftaran Pasien</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pelayanan.pemeriksaan') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label for="tanggal" class="form-label small fw-semibold text-secondary">Tanggal Kunjungan</label>
                    <input id="tanggal" type="date" class="form-control" name="tanggal" value="{{ $date }}">
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label small fw-semibold text-secondary">Cari Pasien (Nama / No. RM)</label>
                    <input id="search" type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Ketik nama atau nomor rekam medis">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i> Cari</button>
                    <a href="{{ route('pelayanan.pemeriksaan') }}" class="btn btn-outline-secondary">Hari ini</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pasien</th>
                        <th>Waktu</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visits as $visit)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $visit->patient->nama }}</div>
                                <small class="text-muted">{{ $visit->patient->no_rm }}</small>
                            </td>
                            <td>{{ $visit->jam_kunjungan ?? '-' }}</td>
                            <td>{{ $visit->keluhan ?: '-' }}</td>
                            <td>
                                @if ($visit->status === 'Sedang Diperiksa')
                                    <span class="badge bg-info text-dark">Sedang Diperiksa</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('pelayanan.kunjungan.edit', $visit) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-stethoscope me-1"></i> Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-calendar-check fs-2 mb-2 d-block"></i>
                                Tidak ada kunjungan yang menunggu pemeriksaan untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($visits->hasPages())
            <div class="p-3 border-top">{{ $visits->links() }}</div>
        @endif
    </div>
</div>
@endsection

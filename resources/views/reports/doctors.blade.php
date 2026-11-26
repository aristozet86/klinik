@extends('layouts.laporan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-user-doctor" style="color:#16a34a;" class="me-2"></i>Laporan Pendapatan Dokter</h3>
            <p class="text-muted mb-0">Rekapitulasi jasa dokter dan pendapatan klinik per periode</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa-solid fa-print me-1"></i> Cetak Laporan
        </button>
    </div>

    {{-- Filter --}}
    <div class="card border-0 mb-4 d-print-none">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.dokter') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('laporan.dokter') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card metric-card blue">
                <div class="metric-icon-bg"><i class="fa-solid fa-sack-dollar"></i></div>
                <div class="metric-label">Total Pendapatan</div>
                <div class="metric-value" style="font-size:clamp(14px,1.6vw,20px);">Rp {{ number_format($grandTotalPendapatan, 0, ',', '.') }}</div>
                <div class="metric-sub"><span style="color:rgba(255,255,255,.75);">Semua kunjungan lunas</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card metric-card purple">
                <div class="metric-icon-bg"><i class="fa-solid fa-user-doctor"></i></div>
                <div class="metric-label">Total Jasa Dokter</div>
                <div class="metric-value" style="font-size:clamp(14px,1.6vw,20px);">Rp {{ number_format($grandTotalJasa, 0, ',', '.') }}</div>
                <div class="metric-sub"><span style="color:rgba(255,255,255,.75);">Dibayarkan ke dokter</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card metric-card green">
                <div class="metric-icon-bg"><i class="fa-solid fa-hospital"></i></div>
                <div class="metric-label">Pendapatan Klinik</div>
                <div class="metric-value" style="font-size:clamp(14px,1.6vw,20px);">Rp {{ number_format($grandPendapatanKlinik, 0, ',', '.') }}</div>
                <div class="metric-sub"><span style="color:rgba(255,255,255,.75);">Setelah jasa dokter</span></div>
            </div>
        </div>
    </div>

    {{-- Tabel per Dokter --}}
    <div class="card border-0">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fa-solid fa-table me-2" style="color:#16a34a;"></i>Rincian per Dokter</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Dokter</th>
                            <th>Spesialisasi</th>
                            <th class="text-end">Jasa/Kunjungan</th>
                            <th class="text-center">Jml Kunjungan</th>
                            <th class="text-end">Total Pendapatan</th>
                            <th class="text-end text-purple">Total Jasa Dokter</th>
                            <th class="text-end text-success pe-4">Pendapatan Klinik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctorStats as $doc)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#064e1f,#22c55e);display:grid;place-items:center;color:white;font-weight:700;font-size:13px;flex-shrink:0;">
                                            {{ strtoupper(substr($doc['nama'], 0, 1)) }}
                                        </div>
                                        <div class="fw-bold">{{ $doc['nama'] }}</div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $doc['spesialisasi'] }}</span></td>
                                <td class="text-end">Rp {{ number_format($doc['jasa_per_kunjungan'], 0, ',', '.') }}</td>
                                <td class="text-center fw-semibold">{{ $doc['total_kunjungan'] }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($doc['total_pendapatan'], 0, ',', '.') }}</td>
                                <td class="text-end fw-semibold" style="color:#7c3aed;">Rp {{ number_format($doc['total_jasa'], 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-success pe-4">Rp {{ number_format($doc['pendapatan_klinik'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada data dokter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($doctorStats->count() > 0)
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="4" class="text-end ps-4">TOTAL KESELURUHAN:</td>
                                <td class="text-end">Rp {{ number_format($grandTotalPendapatan, 0, ',', '.') }}</td>
                                <td class="text-end" style="color:#7c3aed;">Rp {{ number_format($grandTotalJasa, 0, ',', '.') }}</td>
                                <td class="text-end text-success pe-4">Rp {{ number_format($grandPendapatanKlinik, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

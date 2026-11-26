@extends('layouts.pelayanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-user-doctor text-primary me-2"></i>Manajemen Dokter</h3>
            <p class="text-muted mb-0">Kelola data dokter dan jasa dokter per kunjungan</p>
        </div>
        <a href="{{ route('pelayanan.dokter.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Tambah Dokter
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>No. SIP</th>
                            <th>No. HP</th>
                            <th class="text-end">Jasa Dokter</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Total Kunjungan</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#064e1f,#22c55e);display:grid;place-items:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($doctor->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $doctor->nama }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $doctor->spesialisasi }}</span></td>
                                <td class="text-muted small">{{ $doctor->no_sip ?: '-' }}</td>
                                <td class="text-muted small">{{ $doctor->no_hp ?: '-' }}</td>
                                <td class="text-end fw-semibold text-success">
                                    Rp {{ number_format($doctor->jasa_dokter, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if ($doctor->status === 'Aktif')
                                        <span class="badge badge-status-done">Aktif</span>
                                    @else
                                        <span class="badge badge-status-cancel">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center fw-semibold">{{ $doctor->visits_count }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('pelayanan.dokter.edit', $doctor) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        <form action="{{ route('pelayanan.dokter.destroy', $doctor) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus dokter {{ $doctor->nama }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-user-doctor fs-2 d-block mb-2"></i>
                                    Belum ada data dokter. <a href="{{ route('pelayanan.dokter.create') }}">Tambah dokter</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.pelayanan')

@section('content')
<div class="container-fluid" style="max-width:720px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-user-plus text-primary me-2"></i>Tambah Dokter</h3>
            <p class="text-muted mb-0">Isi data dokter dan jasa per kunjungan</p>
        </div>
        <a href="{{ route('pelayanan.dokter.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('pelayanan.dokter.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="dr. Nama Lengkap" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" name="spesialisasi" class="form-control" value="{{ old('spesialisasi', 'Dokter Umum') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor SIP</label>
                        <input type="text" name="no_sip" class="form-control" value="{{ old('no_sip') }}" placeholder="Opsional">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jasa Dokter per Kunjungan (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jasa_dokter" class="form-control" value="{{ old('jasa_dokter', 0) }}" min="0" step="1000" required>
                        </div>
                        <div class="form-text">Bagian pendapatan dokter dari setiap kunjungan pasien</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-save me-1"></i> Simpan Dokter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

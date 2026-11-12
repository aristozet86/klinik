@extends('layouts.pelayanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-user-plus text-primary me-2"></i>Pendaftaran Pasien</h3>
            <p class="text-muted mb-0">Simpan data pasien dan keluhan untuk mencatat kunjungan.</p>
        </div>
        <a href="{{ auth()->check() ? route('pelayanan.kunjungan') : route('pelayanan.dashboard') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Data belum tersimpan. Periksa kembali isian berikut:</strong>
            <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pelayanan.pendaftaran.store') }}">
        @csrf
        <input type="hidden" name="registration_token" value="{{ session('staff_registration_token') }}">
        <div class="row g-4">
            <div class="col-lg-8">
                <section class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 fw-bold"><i class="fa-solid fa-id-card text-primary me-2"></i>Data Pasien</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama lengkap *</label>
                                <input id="nama" name="nama" class="form-control" value="{{ old('nama') }}" maxlength="255" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label fw-semibold">NIK (16 digit, opsional)</label>
                                <input id="nik" name="nik" class="form-control" value="{{ old('nik') }}" inputmode="numeric" pattern="[0-9]{16}" maxlength="16">
                                <div class="form-text">Jika NIK sudah terdaftar, pasien menggunakan data rekam medis yang ada.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-semibold">Jenis kelamin *</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal lahir *</label>
                                <input id="tanggal_lahir" name="tanggal_lahir" type="date" class="form-control" value="{{ old('tanggal_lahir') }}" max="{{ now('Asia/Jakarta')->toDateString() }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label fw-semibold">Nomor HP *</label>
                                <input id="no_hp" name="no_hp" type="tel" class="form-control" value="{{ old('no_hp') }}" maxlength="20" required>
                            </div>
                            <div class="col-md-6">
                                <label for="alergi" class="form-label fw-semibold">Alergi</label>
                                <input id="alergi" name="alergi" class="form-control" value="{{ old('alergi') }}" maxlength="2000" placeholder="Tidak ada jika kosong">
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label fw-semibold">Alamat *</label>
                                <textarea id="alamat" name="alamat" class="form-control" rows="2" maxlength="2000" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="penjamin" class="form-label fw-semibold">Penjamin *</label>
                                <select id="penjamin" name="penjamin" class="form-select" required>
                                    @foreach (['Umum', 'BPJS', 'Asuransi Swasta'] as $option)
                                        <option value="{{ $option }}" @selected(old('penjamin', 'Umum') === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="no_penjamin" class="form-label fw-semibold">Nomor kartu penjamin</label>
                                <input id="no_penjamin" name="no_penjamin" class="form-control" value="{{ old('no_penjamin') }}" maxlength="50">
                            </div>
                        </div>
                    </div>
                </section>

                <section class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check text-primary me-2"></i>Data Kunjungan</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Poli tujuan</label>
                            <input class="form-control" value="Poli Gigi" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="keluhan" class="form-label fw-semibold">Keluhan utama *</label>
                            <textarea id="keluhan" name="keluhan" class="form-control" rows="3" maxlength="2000" required>{{ old('keluhan') }}</textarea>
                        </div>
                        <div>
                            <label for="pemeriksaan_awal" class="form-label fw-semibold">Informasi awal (opsional)</label>
                            <textarea id="pemeriksaan_awal" name="pemeriksaan_awal" class="form-control" rows="2" maxlength="2000">{{ old('pemeriksaan_awal') }}</textarea>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-4">
                <section class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 fw-bold"><i class="fa-solid fa-circle-info text-primary me-2"></i>Langkah Berikutnya</h5></div>
                    <div class="card-body">
                        <p class="text-muted">Setelah pendaftaran disimpan, kunjungan berstatus <strong>Menunggu</strong> dan dapat dipilih dari menu Pemeriksaan.</p>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pendaftaran</button>
                    </div>
                </section>
            </div>
        </div>
    </form>
</div>
@endsection

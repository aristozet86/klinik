@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <!-- Header & Brand Logo -->
    <div class="text-center">
        <div class="auth-logo-badge">
            <img src="{{ asset('img/denta-love-care-logo.png') }}" alt="Logo Denta Love Care">
        </div>
        <h1 class="auth-title">{{ config('app.name', 'Denta Love Care') }}</h1>
        <p class="auth-subtitle">
            <i class="fa-solid fa-chart-line me-1 text-primary"></i>
            Masuk · Laporan &amp; Analitik
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4 py-2 px-3 small rounded-3" role="alert">
            <i class="fa-solid fa-circle-info me-2 text-primary"></i>
            <div>{{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start mb-4 py-2 px-3 small rounded-3" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2 mt-1 text-danger"></i>
            <div>
                <strong>Gagal Masuk:</strong>
                <ul class="mb-0 ps-3 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Login Form — POST ke laporan.login.store, redirect ke laporan setelah berhasil -->
    <form method="POST" action="{{ route('laporan.login.store') }}" id="loginForm">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fa-solid fa-user me-1 text-primary"></i> Email
            </label>
            <div class="input-group-modern">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@klinik.com"
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fa-solid fa-lock me-1 text-primary"></i> Password
            </label>
            <div class="input-group-modern has-toggle">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password"
                >
                <button type="button" class="btn-toggle-password" id="togglePasswordBtn" aria-label="Toggle password">
                    <i class="fa-regular fa-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label small text-secondary" for="rememberMe">Ingat saya</label>
            </div>
        </div>

        <button type="submit" class="btn-auth-primary" id="btnSubmit">
            <span>Masuk ke Laporan</span>
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('pelayanan.dashboard') }}" class="small text-decoration-none text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Pelayanan
        </a>
    </div>

    <p class="text-center mt-3 mb-0 small text-muted">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </p>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('togglePasswordBtn');
    const inp  = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (btn && inp && icon) {
        btn.addEventListener('click', function () {
            const show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        });
    }
});
</script>
@endpush

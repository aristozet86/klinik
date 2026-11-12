<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OdontogramController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

// ─── URL Utama ──────────────────────────────────────────────────────────────
// Semua langsung redirect ke pelayanan (middleware auth akan tangkap & redirect ke login)
Route::redirect('/', '/pelayanan');
Route::redirect('/dashboard', '/pelayanan');

// ─── Ruang Pelayanan (semua butuh login) ────────────────────────────────────
Route::prefix('pelayanan')->middleware(['auth'])->name('pelayanan.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Pendaftaran Pasien (oleh petugas — butuh login)
    Route::get('/pendaftaran', [PatientRegistrationController::class, 'create'])->name('pendaftaran');
    Route::post('/pendaftaran', [PatientRegistrationController::class, 'store'])
        ->middleware(['throttle:10,1'])
        ->block(10, 10)
        ->name('pendaftaran.store');

    // Data Pasien
    Route::resource('pasien', PatientController::class)
        ->except(['create', 'store'])
        ->parameters(['pasien' => 'patient'])
        ->names([
            'index'   => 'pasien',
            'show'    => 'pasien.show',
            'edit'    => 'pasien.edit',
            'update'  => 'pasien.update',
            'destroy' => 'pasien.destroy',
        ]);

    // Kunjungan & Antrean
    Route::resource('kunjungan', VisitController::class)
        ->except(['create', 'store'])
        ->parameters(['kunjungan' => 'visit'])
        ->names([
            'index'   => 'kunjungan',
            'show'    => 'kunjungan.show',
            'edit'    => 'kunjungan.edit',
            'update'  => 'kunjungan.update',
            'destroy' => 'kunjungan.destroy',
        ]);

    // Pemeriksaan
    Route::get('/pemeriksaan', [VisitController::class, 'examinations'])->name('pemeriksaan');

    // Odontogram
    Route::get('/odontogram', [OdontogramController::class, 'index'])->name('odontogram');
    Route::get('/odontogram/{patient}', [OdontogramController::class, 'show'])->name('odontogram.show');
    Route::post('/odontogram/{patient}/tooth', [OdontogramController::class, 'updateTooth'])->name('odontogram.update_tooth');

    // Riwayat Pasien / Rekam Medis
    Route::get('/riwayat', [MedicalRecordController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{patient}', [MedicalRecordController::class, 'show'])->name('riwayat.show');

    // Profil & Password
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profil.destroy');
});

// ─── Ruang Laporan (semua butuh login) ──────────────────────────────────────
Route::prefix('laporan')->middleware(['auth'])->name('laporan.')->group(function () {

    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/kunjungan', [ReportController::class, 'visits'])->name('kunjungan');
    Route::get('/grafik', [ReportController::class, 'charts'])->name('grafik');
    Route::get('/keuangan', [ReportController::class, 'finance'])->name('keuangan');
    Route::get('/tindakan', [ReportController::class, 'treatments'])->name('tindakan');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profil.destroy');
});

// ─── Profil backward-compat ──────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Logout ──────────────────────────────────────────────────────────────────
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';

<?php

use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;

function clinicPatient(string $suffix): Patient
{
    return Patient::create(['no_rm' => 'RM-'.$suffix, 'nama' => 'Pasien '.$suffix, 'jenis_kelamin' => 'L', 'nik' => 'NIK-'.$suffix, 'no_hp' => 'HP-'.$suffix]);
}

function clinicVisit(Patient $patient, string $poli, array $attributes = []): Visit
{
    return Visit::create(array_merge([
        'patient_id' => $patient->id, 'poli' => $poli,
        'tanggal_kunjungan' => now()->toDateString(), 'status' => 'Menunggu',
    ], $attributes));
}

test('service and report modules use separate routes and sidebars', function () {
    $this->actingAs(User::factory()->create());
    $patient = clinicPatient('Shared');
    clinicVisit($patient, 'Poli Gigi', [
        'tanggal_kunjungan' => now()->startOfMonth()->toDateString(),
        'status_pembayaran' => 'Lunas',
        'total_biaya' => 35000,
    ]);

    $serviceDashboard = $this->get(route('pelayanan.dashboard'))
        ->assertOk()
        ->assertSee('Pendaftaran Pasien')
        ->assertSee(route('pelayanan.pendaftaran'), false)
        ->assertDontSee('Pengelolaan Dokter')
        ->assertDontSee('Laporan Kunjungan');

    $reportDashboard = $this->get(route('laporan.index'))
        ->assertOk()
        ->assertSee('Dashboard Laporan')
        ->assertSee(route('laporan.kunjungan'), false)
        ->assertDontSee('Ringkasan Laporan')
        ->assertDontSee('Laporan dokter')
        ->assertDontSee('Pendaftaran Pasien')
        ->assertViewHas('totalPatients', 1)
        ->assertViewHas('totalVisits', 1)
        ->assertViewHas('visitsThisMonth', 1)
        ->assertViewHas('revenueThisMonth', 35000);

    foreach ([
        'pelayanan.pendaftaran',
        'pelayanan.pasien',
        'pelayanan.kunjungan',
        'pelayanan.odontogram',
        'pelayanan.riwayat',
    ] as $routeName) {
        $serviceDashboard->assertSee(route($routeName), false);
        $this->get(route($routeName))->assertOk();
    }

    foreach ([
        'laporan.kunjungan',
        'laporan.grafik',
        'laporan.keuangan',
        'laporan.tindakan',
    ] as $routeName) {
        $reportDashboard->assertSee(route($routeName), false);
        $this->get(route($routeName))->assertOk();
    }
});

test('doctor management and doctor report are removed', function () {
    $this->actingAs(User::factory()->create());
    $this->get('/pelayanan/dokter')->assertNotFound();
    $this->get('/laporan/dokter')->assertNotFound();
    $visit = clinicVisit(clinicPatient('NoDoctor'), 'Poli Gigi');
    $this->get(route('pelayanan.kunjungan.edit', $visit))
        ->assertOk()
        ->assertDontSee('Dokter Pemeriksa')
        ->assertDontSee('name="doctor_id"', false);
    $this->get(route('laporan.kunjungan'))->assertOk()
        ->assertDontSee('Semua Dokter')
        ->assertDontSee('Dokter Pemeriksa');
    $this->get(route('laporan.grafik'))->assertOk()
        ->assertDontSee('doctorChart')
        ->assertDontSee('Volume Pelayanan Dokter');
});

test('visit search matches multiple fields while respecting date and clinic filters', function () {
    $this->actingAs(User::factory()->create());
    $target = clinicPatient('Target');
    $other = clinicPatient('Other');
    $visit = clinicVisit($target, 'Poli Gigi', ['keluhan' => 'Ngilu', 'diagnosa' => 'Karies']);
    clinicVisit($other, 'Poli Umum');
    foreach (['Target', 'RM-Target', 'NIK-Target', 'HP-Target', 'Ngilu', 'Karies'] as $search) {
        $this->get(route('laporan.kunjungan', ['search' => $search]))->assertOk()
            ->assertViewHas('visits', fn ($visits) => $visits->modelKeys() === [$visit->id])
            ->assertViewHas('totalVisits', 1);
    }
    $this->get(route('laporan.kunjungan', ['search' => 'Target', 'poli' => 'Poli Umum']))
        ->assertViewHas('totalVisits', 0);
    $this->get(route('laporan.kunjungan', ['search' => 'Target', 'start_date' => now()->subDays(5)->toDateString(), 'end_date' => now()->subDay()->toDateString()]))
        ->assertViewHas('totalVisits', 0);
});

test('odontogram includes only patients with noncancelled dental visits', function () {
    $this->actingAs(User::factory()->create());
    $dental = clinicPatient('Dental');
    $general = clinicPatient('General');
    $cancelled = clinicPatient('Cancelled');
    clinicVisit($dental, 'Poli Gigi');
    clinicVisit($dental, 'Poli Umum');
    clinicVisit($general, 'Poli Umum');
    clinicVisit($cancelled, 'Poli Gigi', ['status' => 'Batal']);
    $this->get(route('pelayanan.odontogram'))->assertOk()
        ->assertViewHas('patients', fn ($patients) => $patients->getCollection()->modelKeys() === [$dental->id]);
    $this->get(route('pelayanan.odontogram', ['search' => $general->no_rm]))->assertViewHas('patients', fn ($patients) => $patients->isEmpty());
    $this->get(route('pelayanan.odontogram.show', $dental))->assertOk()->assertSee('function selectTooth', false);
    $this->get(route('pelayanan.odontogram.show', $general))->assertNotFound();
    $this->post(route('pelayanan.odontogram.update_tooth', $general), ['nomor_gigi' => 11, 'kondisi' => 'Karies'])->assertNotFound();
    $this->post(route('pelayanan.odontogram.update_tooth', $dental), ['nomor_gigi' => 11, 'kondisi' => 'Karies'])->assertRedirect();
    $this->assertDatabaseHas('odontograms', ['patient_id' => $dental->id, 'nomor_gigi' => 11]);
});

test('charts use the selected year consistently without doctor data', function () {
    $this->travelTo(Carbon::parse('2026-09-30 10:00:00'));
    $this->actingAs(User::factory()->create());
    $patient = clinicPatient('Charts');
    clinicVisit($patient, 'Poli Gigi', ['tanggal_kunjungan' => '2025-01-31', 'penjamin' => 'BPJS']);
    clinicVisit($patient, 'Poli Gigi', ['tanggal_kunjungan' => '2025-12-31', 'penjamin' => 'Umum']);
    clinicVisit($patient, 'Poli Umum', ['tanggal_kunjungan' => '2026-09-30']);
    $this->get(route('laporan.grafik', ['year' => 2025]))->assertOk()
        ->assertViewHas('monthlyData', [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1])
        ->assertViewHas('poliVisits', ['Poli Gigi' => 2])
        ->assertViewHas('penjaminVisits', ['BPJS' => 1, 'Umum' => 1])
        ->assertDontSee('doctorChart')
        ->assertViewHas('dailyTrend', [0, 0, 0, 0, 0, 0, 1]);
    $this->get(route('laporan.grafik', ['year' => 2024]))->assertOk()
        ->assertViewHas('monthlyData', array_fill(0, 12, 0))->assertSee('Belum ada kunjungan');
    $this->getJson(route('laporan.grafik', ['year' => 'invalid']))->assertUnprocessable();
    $this->getJson(route('laporan.grafik', ['year' => 2027]))->assertUnprocessable();
});

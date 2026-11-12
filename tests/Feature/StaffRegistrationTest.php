<?php

use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;

function staffRegistrationData(): array
{
    return [
        'registration_token' => 'test-token',
        'nama' => 'Pasien Mandiri',
        'nik' => '3273010101900001',
        'jenis_kelamin' => 'L',
        'tanggal_lahir' => '1990-01-01',
        'no_hp' => '081234567890',
        'alamat' => 'Jalan Melati 1',
        'penjamin' => 'Umum',
        'poli' => 'Poli Gigi',
        'keluhan' => 'Batuk sejak kemarin',
        'pemeriksaan_awal' => 'Suhu 37,8 C berdasarkan pemeriksaan di rumah',
    ];
}

test('staff cannot create visits manually', function () {
    $this->actingAs(User::factory()->create())
        ->get('/laporan/kunjungan/create')
        ->assertNotFound();

    $this->post('/laporan/kunjungan')->assertMethodNotAllowed();
});

test('staff can register a patient and examination in one submission', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('pelayanan.pendaftaran'))
        ->assertOk()
        ->assertSee('Pendaftaran Pasien');

    $this->post(route('pelayanan.pendaftaran.store'), [
        'registration_token' => session('staff_registration_token'),
        'nama' => 'Pasien Petugas',
        'nik' => '3171234567890123',
        'jenis_kelamin' => 'P',
        'tanggal_lahir' => '1995-05-12',
        'alamat' => 'Jalan Mawar 2',
        'no_hp' => '081234567890',
        'penjamin' => 'Umum',
        'keluhan' => 'Nyeri gigi geraham',
    ])
        ->assertRedirect(route('pelayanan.pemeriksaan'));

    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseHas('visits', [
        'patient_id' => Patient::first()->id,
        'poli' => 'Poli Gigi',
        'keluhan' => 'Nyeri gigi geraham',
        'status' => 'Menunggu',
    ]);
});

test('staff registration reuses existing patient NIK without overwriting identity', function () {
    $patient = Patient::create([
        'no_rm' => 'RM-STAFF-REUSE',
        'nik' => '3273010101900001',
        'nama' => 'Pasien Mandiri',
        'jenis_kelamin' => 'L',
    ]);
    $this->actingAs(User::factory()->create())
        ->withSession(['staff_registration_token' => 'staff-token'])
        ->post(route('pelayanan.pendaftaran.store'), array_merge(staffRegistrationData(), [
            'registration_token' => 'staff-token',
            'nama' => 'Nama yang tidak boleh mengganti data lama',
        ]))
        ->assertRedirect(route('pelayanan.pemeriksaan'));

    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseCount('visits', 1);
    expect($patient->fresh()->nama)->toBe('Pasien Mandiri');
});

test('patient registration can be submitted without login and redirects to public dashboard', function () {
    $this->withSession(['staff_registration_token' => 'public-token'])
        ->get(route('pelayanan.pendaftaran'))
        ->assertOk();

    $this->post(route('pelayanan.pendaftaran.store'), array_merge(staffRegistrationData(), [
        'registration_token' => 'public-token',
    ]))
        ->assertRedirect(route('pelayanan.dashboard'));

    $this->assertGuest();
    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseHas('visits', [
        'patient_id' => Patient::first()->id,
        'keluhan' => 'Batuk sejak kemarin',
        'status' => 'Menunggu',
    ]);
    $this->post(route('pelayanan.pendaftaran.store'), array_merge(staffRegistrationData(), [
        'registration_token' => 'public-token',
    ]))->assertRedirect(route('pelayanan.dashboard'));
    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseCount('visits', 1);

    $this->get(route('pelayanan.dashboard'))
        ->assertOk()
        ->assertSee('Pendaftaran sudah tersimpan');
});

test('only report login is public and patient data remains protected', function () {
    expect(route('laporan.kunjungan', absolute: false))->toBe('/laporan/kunjungan');
    $this->get('/laporan')->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.pasien'))->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.pendaftaran'))->assertOk();
    $this->get(route('laporan.keuangan'))->assertRedirect(route('laporan.login'));
    $this->get('/daftar')->assertNotFound();
    $this->post('/daftar')->assertNotFound();
    $this->get('/daftar/berhasil')->assertNotFound();
    $this->actingAs(User::factory()->create())
        ->get(route('laporan.kunjungan'))
        ->assertOk()
        ->assertSee('Kunjungan');
    $this->get('/laporan')->assertOk();
});

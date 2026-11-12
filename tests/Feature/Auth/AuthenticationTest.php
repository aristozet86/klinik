<?php

use App\Models\User;

test('report login screen is available only at the report login URL', function () {
    $this->get('/login')->assertNotFound();

    $this->get(route('laporan.login'))
        ->assertOk()
        ->assertSee('Denta Love Care')
        ->assertSee('Laporan & Analitik', false)
        ->assertSee('denta-love-care-logo.png');
});

test('report access sends guests to report login and returns them to the requested report', function () {
    $user = User::factory()->create();

    $this->get(route('laporan.kunjungan'))
        ->assertRedirect(route('laporan.login'));

    $this->get(route('laporan.login'))
        ->assertOk()
        ->assertSee('Laporan & Analitik', false)
        ->assertSee(route('laporan.login.store'), false);

    $this->post(route('laporan.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('laporan.kunjungan', absolute: false));

    $this->get(route('laporan.kunjungan'))->assertOk();
});

test('one staff login grants access to all service and report menus', function () {
    $user = User::factory()->create();

    $this->post(route('laporan.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('laporan.index', absolute: false));

    $this->assertAuthenticatedAs($user);

    foreach ([
        'pelayanan.pasien',
        'pelayanan.kunjungan',
        'pelayanan.pemeriksaan',
        'pelayanan.odontogram',
        'pelayanan.riwayat',
        'laporan.index',
    ] as $routeName) {
        $this->get(route($routeName))->assertOk();
        $this->assertAuthenticatedAs($user);
    }
});

test('public service dashboard does not expose patient data and clinical features still require login', function () {
    $user = User::factory()->create();
    \App\Models\Patient::create([
        'no_rm' => 'RM-PRIVATE',
        'nama' => 'Pasien Rahasia',
        'jenis_kelamin' => 'L',
        'nik' => '3171234567890123',
    ]);

    $this->get('/')->assertOk()->assertSee('hero-banner');
    $dashboard = $this->get(route('pelayanan.dashboard'))
        ->assertOk()
        ->assertSee('Silakan hubungi klinik')
        ->assertDontSee(route('laporan.login'), false)
        ->assertDontSee('Login Laporan')
        ->assertSee('Data Pasien')
        ->assertSee('Kunjungan')
        ->assertSee('Pemeriksaan')
        ->assertSee('Odontogram')
        ->assertSee('Rekam Medis')
        ->assertSee('class="sidebar"', false)
        ->assertSee('hero-banner', false)
        ->assertDontSee('Pasien Rahasia')
        ->assertDontSee('3171234567890123');
    $this->get('/daftar')->assertNotFound();
    $this->get('/daftar/berhasil')->assertNotFound();
    $this->post('/daftar')->assertNotFound();

    $this->get(route('pelayanan.pasien'))->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.kunjungan'))->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.pemeriksaan'))->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.odontogram'))->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.riwayat'))->assertRedirect(route('laporan.login'));
    $this->get(route('pelayanan.pendaftaran'))->assertOk()
        ->assertSee('Pendaftaran Pasien')
        ->assertSee(route('pelayanan.pendaftaran.store'), false);
    $this->get(route('laporan.kunjungan'))->assertRedirect(route('laporan.login'));

    $this->post(route('laporan.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('laporan.kunjungan', absolute: false));
});

test('report login defaults to report dashboard when no report was requested', function () {
    $user = User::factory()->create();

    $this->post(route('laporan.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('laporan.index', absolute: false));
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(route('laporan.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('laporan.index', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('laporan.login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('laporan.login'));
});

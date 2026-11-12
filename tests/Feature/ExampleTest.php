<?php

it('serves the dashboard at the root and removes the dashboard alias', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('hero-banner')
        ->assertSee('Pelayanan Klinik')
        ->assertSee('Pendaftaran Pasien')
        ->assertSee(route('pelayanan.pendaftaran'));
    expect(route('pelayanan.dashboard', absolute: false))->toBe('/');
    $this->get('/pelayanan')->assertNotFound();
    $this->get('/dashboard')->assertNotFound();
});

it('removes the public registration URLs', function () {
    $this->get('/daftar')->assertNotFound();
    $this->post('/daftar')->assertNotFound();
    $this->get('/daftar/berhasil')->assertNotFound();
});

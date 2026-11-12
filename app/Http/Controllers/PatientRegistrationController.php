<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visit;
use App\Services\RegistrationNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PatientRegistrationController extends Controller
{
    public function create(Request $request)
    {
        $request->session()->put('staff_registration_token', $request->session()->get('staff_registration_token', (string) Str::uuid()));

        return view('registration.staff-create');
    }

    public function store(Request $request, RegistrationNumber $numbers)
    {
        $token = $request->input('registration_token');
        $receipt = $request->session()->get('staff_registration_receipt');

        if ($token && $token === ($receipt['token'] ?? null)) {
            $destination = $request->user() ? 'pelayanan.pemeriksaan' : 'pelayanan.dashboard';

            return redirect()->route($destination)->with('success', 'Pendaftaran sudah tersimpan.');
        }

        $data = $request->validate([
            'registration_token' => ['required', 'string'],
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'digits:16'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'alamat' => ['required', 'string', 'max:2000'],
            'no_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9+()\s-]{8,20}$/'],
            'penjamin' => ['required', 'in:Umum,BPJS,Asuransi Swasta'],
            'no_penjamin' => ['nullable', 'required_unless:penjamin,Umum', 'string', 'max:50'],
            'alergi' => ['nullable', 'string', 'max:2000'],
            'keluhan' => ['required', 'string', 'max:2000'],
            'pemeriksaan_awal' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['registration_token'] !== $request->session()->get('staff_registration_token')) {
            throw ValidationException::withMessages([
                'registration_token' => 'Form sudah kedaluwarsa. Muat ulang halaman dan coba kembali.',
            ]);
        }

        $visit = DB::transaction(function () use ($data, $numbers) {
            $now = now('Asia/Jakarta');
            $date = $now->toDateString();
            $patient = ! empty($data['nik']) ? Patient::where('nik', $data['nik'])->lockForUpdate()->first() : null;

            if (! $patient) {
                $noRm = $numbers->nextPatient($date);
                $patient = Patient::create(array_merge(
                    collect($data)->only(['nama', 'nik', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_hp', 'penjamin', 'no_penjamin', 'alergi'])->all(),
                    ['no_rm' => $noRm]
                ));
            }

            $visit = Visit::create([
                'patient_id' => $patient->id,
                'poli' => 'Poli Gigi',
                'tanggal_kunjungan' => $date,
                'jam_kunjungan' => $now->format('H:i'),
                'keluhan' => $data['keluhan'],
                'pemeriksaan_awal' => $data['pemeriksaan_awal'] ?? null,
                'penjamin' => $data['penjamin'],
                'status' => 'Menunggu',
                'biaya_konsultasi' => 0,
                'biaya_tindakan' => 0,
                'biaya_obat' => 0,
                'total_biaya' => 0,
                'status_pembayaran' => 'Belum Lunas',
            ]);

            return $visit;
        }, 3);

        $request->session()->put('staff_registration_receipt', [
            'token' => $data['registration_token'],
            'visit_id' => $visit->id,
        ]);
        $request->session()->forget('staff_registration_token');

        $destination = $request->user() ? 'pelayanan.pemeriksaan' : 'pelayanan.dashboard';
        $message = $request->user()
            ? 'Pendaftaran berhasil disimpan. Kunjungan siap diperiksa.'
            : 'Pendaftaran berhasil diterima. Terima kasih.';

        return redirect()->route($destination)->with('success', $message);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(): View
    {
        $doctors = Doctor::withCount('visits')->orderBy('nama')->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create(): View
    {
        return view('doctors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_sip'       => ['nullable', 'string', 'max:255'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'jasa_dokter'  => ['required', 'integer', 'min:0'],
            'status'       => ['required', 'in:Aktif,Nonaktif'],
        ]);

        Doctor::create($validated);

        return redirect()->route('pelayanan.dokter.index')
            ->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $dokter): View
    {
        return view('doctors.edit', ['doctor' => $dokter]);
    }

    public function update(Request $request, Doctor $dokter): RedirectResponse
    {
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_sip'       => ['nullable', 'string', 'max:255'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'jasa_dokter'  => ['required', 'integer', 'min:0'],
            'status'       => ['required', 'in:Aktif,Nonaktif'],
        ]);

        $dokter->update($validated);

        return redirect()->route('pelayanan.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $dokter): RedirectResponse
    {
        $dokter->delete();

        return redirect()->route('pelayanan.dokter.index')
            ->with('success', 'Dokter berhasil dihapus.');
    }
}

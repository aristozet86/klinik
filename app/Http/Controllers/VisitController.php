<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Visit;
use App\Models\VisitTreatment;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('tanggal', now()->toDateString());
        $status = $request->input('status');
        $search = $request->input('search');

        $query = Visit::with(['patient', 'visitTreatments'])
            ->orderBy('created_at', 'desc');

        if ($date) {
            $query->whereDate('tanggal_kunjungan', $date);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_rm', 'like', "%{$search}%");
            });
        }

        $visits = $query->paginate(15)->withQueryString();

        // Summary counts for today
        $today = now()->toDateString();
        $totalHariIni = Visit::whereDate('tanggal_kunjungan', $today)->count();
        $menungguCount = Visit::whereDate('tanggal_kunjungan', $today)->where('status', 'Menunggu')->count();
        $diperiksaCount = Visit::whereDate('tanggal_kunjungan', $today)->where('status', 'Sedang Diperiksa')->count();
        $selesaiCount = Visit::whereDate('tanggal_kunjungan', $today)->where('status', 'Selesai')->count();

        return view('visits.index', compact(
            'visits', 'date', 'status', 'search',
            'totalHariIni', 'menungguCount', 'diperiksaCount', 'selesaiCount'
        ));
    }

    public function examinations(Request $request)
    {
        $date = $request->input('tanggal', now()->toDateString());
        $search = $request->input('search');

        $query = Visit::with('patient')
            ->whereIn('status', ['Menunggu', 'Sedang Diperiksa'])
            ->orderByRaw("CASE WHEN status = 'Sedang Diperiksa' THEN 0 ELSE 1 END")
            ->orderBy('created_at');

        if ($date) {
            $query->whereDate('tanggal_kunjungan', $date);
        }

        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_rm', 'like', "%{$search}%");
            });
        }

        $visits = $query->paginate(15)->withQueryString();

        return view('visits.examinations', compact('visits', 'date', 'search'));
    }

    public function show(Visit $visit)
    {
        $visit->load(['patient', 'visitTreatments.treatment']);

        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        $visit->load(['patient', 'visitTreatments.treatment']);
        $treatments = Treatment::orderBy('nama')->get();

        return view('visits.edit', compact('visit', 'treatments'));
    }

    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Sedang Diperiksa,Selesai,Batal',
            'diagnosa' => 'nullable|string',
            'tensi_darah' => 'nullable|string',
            'suhu_tubuh' => 'nullable|string',
            'berat_badan' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'biaya_konsultasi' => 'nullable|numeric',
            'biaya_obat' => 'nullable|numeric',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas',
            'metode_pembayaran' => 'nullable|string',
        ]);

        $biayaKonsultasi = $validated['biaya_konsultasi'] ?? $visit->biaya_konsultasi;
        $biayaObat = $validated['biaya_obat'] ?? 0;

        // Process added treatments if any
        $biayaTindakan = 0;
        if ($request->has('treatment_ids') && is_array($request->treatment_ids)) {
            // Remove existing treatments and replace
            $visit->visitTreatments()->delete();
            foreach ($request->treatment_ids as $treatId) {
                $treatment = Treatment::find($treatId);
                if ($treatment) {
                    VisitTreatment::create([
                        'visit_id' => $visit->id,
                        'treatment_id' => $treatment->id,
                        'biaya' => $treatment->tarif,
                        'catatan' => $treatment->nama,
                    ]);
                    $biayaTindakan += $treatment->tarif;
                }
            }
        } else {
            $biayaTindakan = $visit->visitTreatments()->sum('biaya');
        }

        $totalBiaya = $biayaKonsultasi + $biayaTindakan + $biayaObat;

        $visit->update([
            'status' => $validated['status'],
            'diagnosa' => $validated['diagnosa'] ?? $visit->diagnosa,
            'tensi_darah' => $validated['tensi_darah'] ?? $visit->tensi_darah,
            'suhu_tubuh' => $validated['suhu_tubuh'] ?? $visit->suhu_tubuh,
            'berat_badan' => $validated['berat_badan'] ?? $visit->berat_badan,
            'catatan_dokter' => $validated['catatan_dokter'] ?? $visit->catatan_dokter,
            'biaya_konsultasi' => $biayaKonsultasi,
            'biaya_tindakan' => $biayaTindakan,
            'biaya_obat' => $biayaObat,
            'total_biaya' => $totalBiaya,
            'status_pembayaran' => $validated['status_pembayaran'],
            'metode_pembayaran' => $validated['metode_pembayaran'] ?? $visit->metode_pembayaran,
        ]);

        return redirect()->route('pelayanan.kunjungan.show', $visit)->with('success', 'Data pemeriksaan kunjungan berhasil disimpan!');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('pelayanan.kunjungan')->with('success', 'Kunjungan berhasil dihapus.');
    }
}

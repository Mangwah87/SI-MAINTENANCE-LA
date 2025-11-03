<?php

namespace App\Http\Controllers;

use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TindakLanjutController extends Controller
{
    public function index()
    {
        $tindakLanjuts = TindakLanjut::with('user')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('tindak-lanjut.index', compact('tindakLanjuts'));
    }

    public function create()
    {
        return view('tindak-lanjut.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lokasi' => 'required|string|max:255',
            'ruang' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'tindakan_penyelesaian' => 'required|string',
            'hasil_perbaikan' => 'required|string',
            'selesai_tanggal' => 'nullable|date',
            'selesai_jam' => 'nullable',
            'tidak_lanjut' => 'nullable|string',
            'pelaksana_nama' => 'required|string|max:255',
            'pelaksana_department' => 'required|string|max:255',
            'pelaksana_sub_department' => 'nullable|string|max:255',
            'mengetahui_nama' => 'required|string|max:255',
            'mengetahui_nik' => 'required|string|max:255',
        ]);

        TindakLanjut::create([
            'user_id' => auth()->id(),
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'lokasi' => $validated['lokasi'],
            'ruang' => $validated['ruang'],
            'permasalahan' => $validated['permasalahan'],
            'tindakan_penyelesaian' => $validated['tindakan_penyelesaian'],
            'hasil_perbaikan' => $validated['hasil_perbaikan'],
            'department' => $validated['pelaksana_department'],
            'sub_department' => $validated['pelaksana_sub_department'] ?? null,
            'permohonan_tindak_lanjut' => $request->has('permohonan_tindak_lanjut'),
            'pelaksanaan_pm' => $request->has('pelaksanaan_pm'),
            'selesai' => $request->has('selesai'),
            'selesai_tanggal' => $validated['selesai_tanggal'] ?? null,
            'selesai_jam' => $validated['selesai_jam'] ?? null,
            'tidak_selesai' => $request->has('tidak_selesai'),
            'tidak_lanjut' => $validated['tidak_lanjut'] ?? null,
            'pelaksana' => [
                'nama' => $validated['pelaksana_nama'],
                'department' => $validated['pelaksana_department'],
                'sub_department' => $validated['pelaksana_sub_department'] ?? null,
            ],
            'mengetahui' => [
                'nama' => $validated['mengetahui_nama'],
                'nik' => $validated['mengetahui_nik'],
            ],
        ]);

        return redirect()->route('tindak-lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil ditambahkan');
    }

    public function show(TindakLanjut $tindakLanjut)
    {
        return view('tindak-lanjut.show', compact('tindakLanjut'));
    }

    public function edit(TindakLanjut $tindakLanjut)
    {
        return view('tindak-lanjut.edit', compact('tindakLanjut'));
    }

    public function update(Request $request, TindakLanjut $tindakLanjut)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lokasi' => 'required|string|max:255',
            'ruang' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'tindakan_penyelesaian' => 'required|string',
            'hasil_perbaikan' => 'required|string',
            'selesai_tanggal' => 'nullable|date',
            'selesai_jam' => 'nullable',
            'tidak_lanjut' => 'nullable|string',
            'pelaksana_nama' => 'required|string|max:255',
            'pelaksana_department' => 'required|string|max:255',
            'pelaksana_sub_department' => 'nullable|string|max:255',
            'mengetahui_nama' => 'required|string|max:255',
            'mengetahui_nik' => 'required|string|max:255',
        ]);

        $tindakLanjut->tanggal = $validated['tanggal'];
        $tindakLanjut->jam = $validated['jam'];
        $tindakLanjut->lokasi = $validated['lokasi'];
        $tindakLanjut->ruang = $validated['ruang'];
        $tindakLanjut->permasalahan = $validated['permasalahan'];
        $tindakLanjut->tindakan_penyelesaian = $validated['tindakan_penyelesaian'];
        $tindakLanjut->hasil_perbaikan = $validated['hasil_perbaikan'];

        // Set department dari pelaksana
        $tindakLanjut->department = $validated['pelaksana_department'];
        $tindakLanjut->sub_department = $validated['pelaksana_sub_department'] ?? null;

        // Checkbox fields
        $tindakLanjut->permohonan_tindak_lanjut = $request->has('permohonan_tindak_lanjut');
        $tindakLanjut->pelaksanaan_pm = $request->has('pelaksanaan_pm');
        $tindakLanjut->selesai = $request->has('selesai');
        $tindakLanjut->selesai_tanggal = $validated['selesai_tanggal'] ?? null;
        $tindakLanjut->selesai_jam = $validated['selesai_jam'] ?? null;
        $tindakLanjut->tidak_selesai = $request->has('tidak_selesai');
        $tindakLanjut->tidak_lanjut = $validated['tidak_lanjut'] ?? null;

        // JSON fields
        $tindakLanjut->pelaksana = [
            'nama' => $validated['pelaksana_nama'],
            'department' => $validated['pelaksana_department'],
            'sub_department' => $validated['pelaksana_sub_department'] ?? null,
        ];

        $tindakLanjut->mengetahui = [
            'nama' => $validated['mengetahui_nama'],
            'nik' => $validated['mengetahui_nik'],
        ];

        $tindakLanjut->save();

        return redirect()->route('tindak-lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil diupdate');
    }

    public function destroy(TindakLanjut $tindakLanjut)
    {
        $tindakLanjut->delete();

        return redirect()->route('tindak-lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil dihapus');
    }

    public function generatePdf(TindakLanjut $tindakLanjut)
    {
        $pdf = Pdf::loadView('tindak-lanjut.pdf', compact('tindakLanjut'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Tindak-Lanjut-' . $tindakLanjut->id . '.pdf');
    }
}
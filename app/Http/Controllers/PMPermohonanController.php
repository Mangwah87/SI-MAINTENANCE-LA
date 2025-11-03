<?php

namespace App\Http\Controllers;

use App\Models\PMPermohonan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PMPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = PMPermohonan::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pm-permohonan.index', compact('permohonan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pm-permohonan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lokasi' => 'required|string|max:255',
            'ruang' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'usulan_tindak_lanjut' => 'required|string',
            'department' => 'required|string|max:255',
            'sub_department' => 'nullable|string|max:255',
            'ditujukan_department' => 'nullable|string|max:255',
            'ditujukan_sub_department' => 'nullable|string|max:255',
            'diinformasikan_melalui' => 'required|in:email,fax,hardcopy',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        $permohonan = PMPermohonan::create($validated);

        return redirect()->route('pm-permohonan.show', $permohonan->id)
            ->with('success', 'Permohonan tindak lanjut berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permohonan = PMPermohonan::with('user')->findOrFail($id);
        return view('pm-permohonan.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pmPermohonan = PMPermohonan::findOrFail($id);



        return view('pm-permohonan.edit', compact('pmPermohonan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pmPermohonan = PMPermohonan::findOrFail($id);



        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lokasi' => 'required|string|max:255',
            'ruang' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'usulan_tindak_lanjut' => 'required|string',
            'department' => 'required|string|max:255',
            'sub_department' => 'nullable|string|max:255',
            'ditujukan_department' => 'nullable|string|max:255',
            'ditujukan_sub_department' => 'nullable|string|max:255',
            'diinformasikan_melalui' => 'required|in:email,fax,hardcopy',
            'catatan' => 'nullable|string',
        ]);

        $pmPermohonan->update($validated);

        return redirect()->route('pm-permohonan.show', $pmPermohonan->id)
            ->with('success', 'Permohonan tindak lanjut berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pmPermohonan = PMPermohonan::findOrFail($id);

        $pmPermohonan->delete();

        return redirect()->route('pm-permohonan.index')
            ->with('success', 'Permohonan tindak lanjut berhasil dihapus.');
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function pdf(string $id)
    {
        $permohonan = PMPermohonan::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pm-permohonan.pdf', compact('permohonan'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('PM Shelter-FM-LAP-D2-SOP-003-004-' . $permohonan->id . '.pdf');
    }
}
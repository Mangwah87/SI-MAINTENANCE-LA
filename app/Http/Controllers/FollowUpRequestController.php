<?php

namespace App\Http\Controllers;

use App\Models\FollowUpRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FollowUpRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = FollowUpRequest::with('user')
            ->latest()
            ->paginate(10);

        return view('followup.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('followup.create');
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
            'ditujukan_sub_department' => 'nullable|string|max:255',
            'diinformasikan_melalui' => 'required|in:email,fax,hardcopy',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['ditujukan_department'] = 'Operations & Maintenance Support';

        FollowUpRequest::create($validated);

        return redirect()->route('followup.index')
            ->with('success', 'Permohonan tindak lanjut berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = FollowUpRequest::with('user')->findOrFail($id);
        return view('followup.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $followup = FollowUpRequest::findOrFail($id);

        // Check if user owns this request
        if ($followup->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('followup.edit', compact('followup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $followup = FollowUpRequest::findOrFail($id);

        // Check if user owns this request
        if ($followup->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

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
            'ditujukan_sub_department' => 'nullable|string|max:255',
            'diinformasikan_melalui' => 'required|in:email,fax,hardcopy',
            'catatan' => 'nullable|string',
        ]);

        $followup->update($validated);

        return redirect()->route('followup.index')
            ->with('success', 'Permohonan tindak lanjut berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $followup = FollowUpRequest::findOrFail($id);

        // Check if user owns this request
        if ($followup->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $followup->delete();

        return redirect()->route('followup.index')
            ->with('success', 'Permohonan tindak lanjut berhasil dihapus.');
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function pdf(string $id)
    {
        $request = FollowUpRequest::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('followup.pdf', compact('request'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('permohonan-tindak-lanjut-' . $request->id . '.pdf');
    }
}
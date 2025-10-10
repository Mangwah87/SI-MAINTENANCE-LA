<?php

namespace App\Http\Controllers;

use App\Models\PMShelter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PMShelterController extends Controller
{
    public function index()
    {
        $maintenances = PMShelter::with('creator')
            ->latest()
            ->paginate(10);

        return view('pm-shelter.index', compact('maintenances'));
    }

    public function create()
    {
        return view('pm-shelter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'reg_number' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'kondisi_ruangan_result' => 'nullable|string',
            'kondisi_ruangan_status' => 'nullable|string|in:ok,nok',
            'kondisi_kunci_result' => 'nullable|string',
            'kondisi_kunci_status' => 'nullable|string|in:ok,nok',
            'layout_result' => 'nullable|string',
            'layout_status' => 'nullable|string|in:ok,nok',
            'kontrol_keamanan_result' => 'nullable|string',
            'kontrol_keamanan_status' => 'nullable|string|in:ok,nok',
            'aksesibilitas_result' => 'nullable|string',
            'aksesibilitas_status' => 'nullable|string|in:ok,nok',
            'aspek_teknis_result' => 'nullable|string',
            'aspek_teknis_status' => 'nullable|string|in:ok,nok',
            'notes' => 'nullable|string',
            'pelaksana' => 'required|array|min:3',
            'pelaksana.*.nama' => 'required|string|max:255',
            'pelaksana.*.departemen' => 'required|string|max:255',
            'pelaksana.*.sub_departemen' => 'required|string|max:255',
            'mengetahui' => 'required|string|max:255',
        ]);

        // Convert 'ok'/'nok' to boolean
        $validated['kondisi_ruangan_status'] = ($validated['kondisi_ruangan_status'] ?? null) === 'ok';
        $validated['kondisi_kunci_status'] = ($validated['kondisi_kunci_status'] ?? null) === 'ok';
        $validated['layout_status'] = ($validated['layout_status'] ?? null) === 'ok';
        $validated['kontrol_keamanan_status'] = ($validated['kontrol_keamanan_status'] ?? null) === 'ok';
        $validated['aksesibilitas_status'] = ($validated['aksesibilitas_status'] ?? null) === 'ok';
        $validated['aspek_teknis_status'] = ($validated['aspek_teknis_status'] ?? null) === 'ok';

        // Convert pelaksana array to JSON
        $validated['pelaksana'] = json_encode(array_values($validated['pelaksana']));
        $validated['created_by'] = auth()->id();

        PMShelter::create($validated);

        return redirect()->route('pm-shelter.index')
            ->with('success', 'Data preventive maintenance berhasil disimpan.');
    }

    public function show(PMShelter $pmShelter)
    {
        return view('pm-shelter.show', ['shelter' => $pmShelter]);
    }

    public function edit(PMShelter $pmShelter)
    {
        return view('pm-shelter.edit', ['shelter' => $pmShelter]);
    }

    public function update(Request $request, PMShelter $pmShelter)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'reg_number' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'kondisi_ruangan_result' => 'nullable|string',
            'kondisi_ruangan_status' => 'nullable|string|in:ok,nok',
            'kondisi_kunci_result' => 'nullable|string',
            'kondisi_kunci_status' => 'nullable|string|in:ok,nok',
            'layout_result' => 'nullable|string',
            'layout_status' => 'nullable|string|in:ok,nok',
            'kontrol_keamanan_result' => 'nullable|string',
            'kontrol_keamanan_status' => 'nullable|string|in:ok,nok',
            'aksesibilitas_result' => 'nullable|string',
            'aksesibilitas_status' => 'nullable|string|in:ok,nok',
            'aspek_teknis_result' => 'nullable|string',
            'aspek_teknis_status' => 'nullable|string|in:ok,nok',
            'notes' => 'nullable|string',
            'pelaksana' => 'required|array|min:3',
            'pelaksana.*.nama' => 'required|string|max:255',
            'pelaksana.*.departemen' => 'required|string|max:255',
            'pelaksana.*.sub_departemen' => 'required|string|max:255',
            'mengetahui' => 'required|string|max:255',
        ]);

        // Convert 'ok'/'nok' to boolean
        $validated['kondisi_ruangan_status'] = ($validated['kondisi_ruangan_status'] ?? null) === 'ok';
        $validated['kondisi_kunci_status'] = ($validated['kondisi_kunci_status'] ?? null) === 'ok';
        $validated['layout_status'] = ($validated['layout_status'] ?? null) === 'ok';
        $validated['kontrol_keamanan_status'] = ($validated['kontrol_keamanan_status'] ?? null) === 'ok';
        $validated['aksesibilitas_status'] = ($validated['aksesibilitas_status'] ?? null) === 'ok';
        $validated['aspek_teknis_status'] = ($validated['aspek_teknis_status'] ?? null) === 'ok';

        // Convert pelaksana array to JSON
        $validated['pelaksana'] = json_encode(array_values($validated['pelaksana']));

        $pmShelter->update($validated);

        return redirect()->route('pm-shelter.index')
            ->with('success', 'Data preventive maintenance berhasil diupdate.');
    }

    public function destroy(PMShelter $pmShelter)
    {
        $pmShelter->delete();

        return redirect()->route('pm-shelter.index')
            ->with('success', 'Data preventive maintenance berhasil dihapus.');
    }

    public function exportPdf(PMShelter $pmShelter)
    {
        $pdf = Pdf::loadView('pm-shelter.pdf', ['shelter' => $pmShelter])
            ->setPaper('a4')
            ->setOptions([
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ]);

        return $pdf->download('PM-Shelter-' . $pmShelter->location . '-' . date('Ymd', strtotime($pmShelter->date_time)) . '.pdf');
    }
}
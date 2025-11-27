<?php

namespace App\Http\Controllers;

use App\Models\CablePanelMaintenance; // Menggunakan model yang baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class CablePanelMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = CablePanelMaintenance::with('user') // Opsi: sama seperti UPS
            ->where('user_id', auth()->id())               // <--- INI BAGIAN PENTING
            ->latest('maintenance_date')                  // <--- Sortir berdasarkan tanggal
            ->paginate(10);
        return view('cable-panel.index', compact('maintenances')); // Path view baru
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        // Group by area untuk tampilan yang lebih rapi
        $centralsByArea = $centrals->groupBy('area');
        return view('cable-panel.create',compact('centralsByArea')); // Path view baru
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRequest($request);

            // Logika proses gambar (sama seperti grounding)
            $imagesData = $request->input('images', []);
            $savedImages = [];
            if (!empty($imagesData) && is_array($imagesData)) {
                foreach ($imagesData as $imgJson) {
                    try {
                        $imgInfo = json_decode($imgJson, true);
                        if ($imgInfo && isset($imgInfo['data']) && preg_match('/^data:image/', $imgInfo['data'])) {
                            $saved = $this->saveBase64Image($imgInfo['data']);
                            if ($saved) {
                                $savedImages[] = Arr::only($imgInfo, ['category', 'timestamp', 'latitude', 'longitude', 'locationName']) + ['path' => $saved];
                            }
                        }
                    } catch (\Exception $e) { Log::error('Error processing cable-panel image: ' . $e->getMessage()); continue; }
                }
            }
            $validatedData['images'] = !empty($savedImages) ? $savedImages : null;

            // Generate Doc Number (Sesuai PDF Kabel & Panel)
            $date = Carbon::parse($validatedData['maintenance_date']);
            $locationCode = strtoupper(substr(str_replace(' ', '', $validatedData['location']), 0, 5));
            $count = CablePanelMaintenance::whereYear('maintenance_date', $date->year)->count() + 1;
            // Menggunakan Doc Number dari PDF Kabel Panel (FM-LAP-D2-SOP-003-012)
            $validatedData['doc_number'] = sprintf('FM-LAP/%s/%s/%03d/%s', 'D2-SOP-003-012', $locationCode, $count, $date->format('Y'));

            $validatedData['user_id'] = auth()->id();

            $maintenance = CablePanelMaintenance::create($validatedData);
            Log::info('Cable Panel Maintenance Created:', ['id' => $maintenance->id, 'images_count' => count($savedImages)]);
            return redirect()->route('cable-panel.index')->with('success', 'Data Kabel dan Panel berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            Log::error('Error storing cable-panel maintenance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $maintenance = CablePanelMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
        return view('cable-panel.show', compact('maintenance')); // Path view baru
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $maintenance = CablePanelMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');
        return view('cable-panel.edit', compact('maintenance','centralsByArea')); // Path view baru
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       try {
            $maintenance = CablePanelMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
            $validatedData = $this->validateRequest($request); // Reuse validation

            $existingImages = $maintenance->images ?? [];
            if (!is_array($existingImages)) $existingImages = [];

            $imagesToDelete = $request->input('delete_images', []);
            if (!empty($imagesToDelete) && is_array($imagesToDelete)) {
                $existingImages = array_filter($existingImages, function($img) use ($imagesToDelete) {
                    if (isset($img['path']) && in_array($img['path'], $imagesToDelete)) {
                        Storage::disk('public')->delete($img['path']);
                        Log::info("Deleted cable-panel image: " . $img['path']);
                        return false;
                    }
                    return true;
                });
                $existingImages = array_values($existingImages);
            }

            $newImagesData = $request->input('images', []);
            $newSavedImages = [];
            if (!empty($newImagesData) && is_array($newImagesData)) {
                foreach ($newImagesData as $imgJson) {
                    $imgInfo = json_decode($imgJson, true);
                    if ($imgInfo && isset($imgInfo['data']) && preg_match('/^data:image/', $imgInfo['data'])) {
                        $savedPath = $this->saveBase64Image($imgInfo['data']);
                        if ($savedPath) {
                            $category = $imgInfo['category'] ?? 'unknown';
                            foreach ($existingImages as $index => $existingImg) {
                                if (isset($existingImg['category']) && $existingImg['category'] === $category) {
                                    Storage::disk('public')->delete($existingImg['path']);
                                    Log::info("Replaced cable-panel image: " . $existingImg['path']);
                                    unset($existingImages[$index]);
                                }
                            }
                            $newSavedImages[] = Arr::only($imgInfo, ['category', 'timestamp', 'latitude', 'longitude', 'locationName']) + ['path' => $savedPath];
                        }
                    }
                }
            }

            $validatedData['images'] = array_merge(array_values($existingImages), $newSavedImages);
            if (empty($validatedData['images'])) $validatedData['images'] = null;

            $maintenance->update($validatedData);
            return redirect()->route('cable-panel.index')->with('success', 'Data Kabel dan Panel berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            Log::error('Error updating cable-panel maintenance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       try {
            $maintenance = CablePanelMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
            if ($maintenance->images && is_array($maintenance->images)) {
                foreach ($maintenance->images as $img) {
                    if (isset($img['path'])) Storage::disk('public')->delete($img['path']);
                }
            }
            $maintenance->delete();
            return redirect()->route('cable-panel.index')->with('success', 'Data Kabel dan Panel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting cable-panel maintenance: ' . $e->getMessage());
            return redirect()->route('cable-panel.index')->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function pdf($id)
    {
        $maintenance = CablePanelMaintenance::findOrFail($id);
        $pdf = PDF::loadView('cable-panel.pdf_template', compact('maintenance')); // Path view baru
        $pdf->setPaper('a4', 'portrait');
        $safeDocNumber = str_replace(['/', '\\'], '-', $maintenance->doc_number); // Sanitize filename
        $fileName = 'cable-panel-maintenance-' . $safeDocNumber . '.pdf';
        return $pdf->stream($fileName);
    }

    // --- Helper Methods ---

    private function validateRequest(Request $request)
    {
        // Aturan validasi dasar
        $rules = [
            'location' => 'required|string|max:255',
            'maintenance_date' => 'required|date',
            'brand_type' => 'nullable|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'technician_1_name' => 'nullable|string|max:255',
            'technician_1_company' => 'nullable|string|max:255',
            'technician_2_name' => 'nullable|string|max:255',
            'technician_2_company' => 'nullable|string|max:255',
            'technician_3_name' => 'nullable|string|max:255',
            'technician_3_company' => 'nullable|string|max:255',
            'approver_name' => 'nullable|string|max:255',
            'approver_nik' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|json',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|string',
        ];

        // Aturan dinamis untuk field form (berdasarkan migrasi/PDF Kabel Panel)
        $checkFields = [
            // Visual Check
            'visual_indicator_lamp', 'visual_voltmeter_ampere_meter', 'visual_arrester',
            'visual_mcb_input_ups', 'visual_mcb_output_ups', 'visual_mcb_bypass',
            // Performance Measurement (Temp MCB)
            'perf_temp_mcb_input_ups', 'perf_temp_mcb_output_ups', 'perf_temp_mcb_bypass_ups',
            'perf_temp_mcb_load_rack', 'perf_temp_mcb_cooling_unit',
            // Performance Measurement (Temp Cable)
            'perf_temp_cable_input_ups', 'perf_temp_cable_output_ups', 'perf_temp_cable_bypass_ups',
            'perf_temp_cable_load_rack', 'perf_temp_cable_cooling_unit',
            // Performance Check
            'perf_check_cable_connection', 'perf_check_spare_mcb', 'perf_check_single_line_diagram',
        ];

        foreach ($checkFields as $field) {
            $rules[$field . '_result'] = 'nullable|string|max:255';
            $rules[$field . '_status'] = 'required|in:OK,NOK'; // Status wajib diisi
        }

        return $request->validate($rules);
    }

    private function saveBase64Image($imageData)
    {
        // Fungsi sama, hanya ganti nama folder
        if (empty($imageData)) return null;
        if (!preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) { Log::error('Invalid image format'); return null; }
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]);
        if (!in_array($type, ['jpg', 'jpeg', 'png'])) $type = 'jpg';
        $decodedImage = base64_decode($imageData);
        if ($decodedImage === false) { Log::error('Failed to decode base64'); return null; }
        $directory = 'cable_panel_images/' . date('Y/m/d'); // Ganti nama folder
        $filename = uniqid('cable_panel_', true) . '.' . $type; // Ganti prefix
        $path = $directory . '/' . $filename;
        if (!Storage::disk('public')->exists($directory)) { Storage::disk('public')->makeDirectory($directory, 0755, true); }
        if (Storage::disk('public')->put($path, $decodedImage)) { Log::info('Cable panel image saved: ' . $path); return $path; }
        Log::error('Failed to save cable panel image'); return null;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\GroundingMaintenance; // Use the correct model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class GroundingController extends Controller
{
    // --- TAMBAHKAN BAGIAN INI ---
    public function __construct()
    {
        // Naikkan limit memori ke 512MB (atau -1 untuk unlimited jika perlu)
        ini_set('memory_limit', '512M');
        
        // Naikkan waktu eksekusi agar tidak timeout saat memproses gambar/PDF
        ini_set('max_execution_time', 300); // 300 detik = 5 menit
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = GroundingMaintenance::with('user') // Opsi: sama seperti UPS
            ->where('user_id', auth()->id())               // <--- INI BAGIAN PENTING
            ->latest('maintenance_date')                  // <--- Sortir berdasarkan tanggal
            ->paginate(10);
        return view('grounding.index', compact('maintenances')); // View path: grounding.index
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data central dari database
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        // Group by area untuk tampilan yang lebih rapi
        $centralsByArea = $centrals->groupBy('area');
        return view('grounding.create',compact('centralsByArea')); // View path: grounding.create
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRequest($request);

            // Image processing logic (same as Genset)
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
                    } catch (\Exception $e) { Log::error('Error processing grounding image: ' . $e->getMessage()); continue; }
                }
            }
            $validatedData['images'] = !empty($savedImages) ? $savedImages : null;

            // Generate Doc Number (Adapt logic if needed)
            $date = Carbon::parse($validatedData['maintenance_date']);
            $locationCode = strtoupper(substr(str_replace(' ', '', $validatedData['location']), 0, 5));
            $count = GroundingMaintenance::whereYear('maintenance_date', $date->year)->count() + 1;
            // Use correct Doc Number from PDF 
            $validatedData['doc_number'] = sprintf('FM-LAP/%s/%s/%03d/%s', 'D2-SOP-003-011', $locationCode, $count, $date->format('Y'));

            $validatedData['user_id'] = auth()->id();

            $maintenance = GroundingMaintenance::create($validatedData);
            Log::info('Grounding Maintenance Created:', ['id' => $maintenance->id, 'images_count' => count($savedImages)]);
            return redirect()->route('grounding.index')->with('success', 'Data Petir dan Grounding berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            Log::error('Error storing grounding maintenance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) // Use $id directly
    {
        $maintenance = GroundingMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
        return view('grounding.show', compact('maintenance')); // View path: grounding.show
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) // Use $id directly
    {
        $maintenance = GroundingMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
        // Ambil data central untuk dropdown
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');
        return view('grounding.edit', compact('maintenance','centralsByArea')); // View path: grounding.edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) // Use $id directly
    {
       try {
            $maintenance = GroundingMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
            $validatedData = $this->validateRequest($request); // Reuse validation

            $existingImages = $maintenance->images ?? [];
            if (!is_array($existingImages)) $existingImages = [];

            $imagesToDelete = $request->input('delete_images', []);
            if (!empty($imagesToDelete) && is_array($imagesToDelete)) {
                $existingImages = array_filter($existingImages, function($img) use ($imagesToDelete) {
                    if (isset($img['path']) && in_array($img['path'], $imagesToDelete)) {
                        Storage::disk('public')->delete($img['path']);
                        Log::info("Deleted grounding image: " . $img['path']);
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
                                    Log::info("Replaced grounding image: " . $existingImg['path']);
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
            return redirect()->route('grounding.index')->with('success', 'Data Petir dan Grounding berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            Log::error('Error updating grounding maintenance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) // Use $id directly
    {
       try {
            $maintenance = GroundingMaintenance::where('user_id', auth()->id())
                                               ->findOrFail($id);
            if ($maintenance->images && is_array($maintenance->images)) {
                foreach ($maintenance->images as $img) {
                    if (isset($img['path'])) Storage::disk('public')->delete($img['path']);
                }
            }
            $maintenance->delete();
            return redirect()->route('grounding.index')->with('success', 'Data Petir dan Grounding berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting grounding maintenance: ' . $e->getMessage());
            return redirect()->route('grounding.index')->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function pdf($id) // Use $id directly
    {
        $maintenance = GroundingMaintenance::findOrFail($id);
        $pdf = PDF::loadView('grounding.pdf_template', compact('maintenance')); // View path: grounding.pdf_template
        $pdf->setPaper('a4', 'portrait');
        $safeDocNumber = str_replace(['/', '\\'], '-', $maintenance->doc_number); // Sanitize filename
        $fileName = 'grounding-maintenance-' . $safeDocNumber . '.pdf';
        return $pdf->stream($fileName);
    }

    // --- Helper Methods ---

    private function validateRequest(Request $request)
    {
        // Define validation rules based on the migration/form fields
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

        // Add dynamic rules for result and status fields
        $checkFields = [
            'visual_air_terminal', 'visual_down_conductor', 'visual_ground_rod', 'visual_bonding_bar',
            'visual_arrester_condition', 'visual_maksure_equipment', 'visual_maksure_connection', 'visual_ob_light',
            'perf_ground_resistance', 'perf_arrester_cutoff_power', 'perf_arrester_cutoff_data', 'perf_tighten_nut'
        ];
        foreach ($checkFields as $field) {
            $rules[$field . '_result'] = 'nullable|string|max:255';
            $rules[$field . '_status'] = 'required|in:OK,NOK'; // Status is required
        }

        return $request->validate($rules);
    }

    private function saveBase64Image($imageData)
    {
        // Same function as in GensetController, but saves to 'grounding_images'
        if (empty($imageData)) return null;
        if (!preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) { Log::error('Invalid image format'); return null; }
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]);
        if (!in_array($type, ['jpg', 'jpeg', 'png'])) $type = 'jpg';
        $decodedImage = base64_decode($imageData);
        if ($decodedImage === false) { Log::error('Failed to decode base64'); return null; }
        $directory = 'grounding_images/' . date('Y/m/d'); // Change folder name
        $filename = uniqid('grounding_', true) . '.' . $type;
        $path = $directory . '/' . $filename;
        if (!Storage::disk('public')->exists($directory)) { Storage::disk('public')->makeDirectory($directory, 0755, true); }
        if (Storage::disk('public')->put($path, $decodedImage)) { Log::info('Grounding image saved: ' . $path); return $path; }
        Log::error('Failed to save grounding image'); return null;
    }
}
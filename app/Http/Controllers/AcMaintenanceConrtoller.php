<?php

namespace App\Http\Controllers;

use App\Models\AcMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class AcMaintenanceConrtoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = AcMaintenance::with(['user', 'central'])
            ->where('user_id', auth()->id())
            ->latest('date_time')
            ->paginate(10);

        // Calculate statistics
        $stats = [
            'this_month' => AcMaintenance::where('user_id', auth()->id())
                ->whereMonth('date_time', now()->month)
                ->whereYear('date_time', now()->year)
                ->count(),
        ];

        return view('ac.ac', compact('maintenances', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centrals = \App\Models\Central::orderBy('area')->orderBy('id_sentral')->get();
        return view('ac.acform', compact('centrals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('AC Maintenance Store - Request Data:', $request->all());

            $validated = $this->validateRequest($request);

            Log::info('AC Maintenance Store - Validation Passed');

            // Process and save images
            $imagesData = $request->input('images', []);
            $savedImages = [];

            if (!empty($imagesData) && is_array($imagesData)) {
                foreach ($imagesData as $imgJson) {
                    try {
                        $imgInfo = json_decode($imgJson, true);
                        if ($imgInfo && isset($imgInfo['data'])) {
                            $saved = $this->saveBase64Image($imgInfo['data']);
                            if ($saved) {
                                $savedImages[] = [
                                    'path' => $saved,
                                    'category' => $imgInfo['category'] ?? 'unknown',
                                    'timestamp' => $imgInfo['timestamp'] ?? now()->toISOString()
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Error processing image: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            $validated['images'] = !empty($savedImages) ? $savedImages : null;

            // Ensure notes is string
            if (isset($validated['notes']) && is_array($validated['notes'])) {
                $validated['notes'] = implode("\n", $validated['notes']);
            }

            // Add user_id
            $validated['user_id'] = auth()->id();

            Log::info('AC Maintenance Store - Creating record with data:', $validated);

            $maintenance = AcMaintenance::create($validated);

            Log::info('AC Maintenance Created:', ['id' => $maintenance->id, 'images_count' => count($savedImages)]);

            return redirect()->route('ac.show', $maintenance->id)
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('AC Maintenance Store - Validation Error:', $e->errors());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error storing maintenance AC: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $maintenance = AcMaintenance::with('central')->findOrFail($id);
        return view('ac.acdetail', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $maintenance = AcMaintenance::findOrFail($id);
        $centrals = \App\Models\Central::orderBy('area')->orderBy('id_sentral')->get();
        return view('ac.acform', compact('maintenance', 'centrals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $maintenanceAc = AcMaintenance::findOrFail($id);
            $validated = $this->validateRequest($request);

            // Get existing images (keep as indexed array to maintain order)
            $existingImages = $maintenanceAc->images ?? [];
            if (!is_array($existingImages)) {
                $existingImages = [];
            }

            // Handle deleted images
            $imagesToDelete = $request->input('delete_images', []);
            if (!empty($imagesToDelete) && is_array($imagesToDelete)) {
                foreach ($imagesToDelete as $imagePath) {
                    // Find and remove from array BY PATH (maintain order of remaining items)
                    foreach ($existingImages as $index => $img) {
                        if (isset($img['path']) && $img['path'] === $imagePath) {
                            // Delete physical file
                            if (Storage::disk('public')->exists($imagePath)) {
                                Storage::disk('public')->delete($imagePath);
                                Log::info("Deleted image: " . $imagePath);
                            }

                            // Remove from array
                            unset($existingImages[$index]);
                            break;
                        }
                    }
                }

                // Reindex array to fix keys
                $existingImages = array_values($existingImages);
            }

            // Process new images
            $newImagesData = $request->input('images', []);

            if (!empty($newImagesData) && is_array($newImagesData)) {
                foreach ($newImagesData as $imgJson) {
                    try {
                        $imgInfo = json_decode($imgJson, true);

                        // Skip if this is not a new image (doesn't have base64 data)
                        if (!$imgInfo || !isset($imgInfo['data']) || !preg_match('/^data:image/', $imgInfo['data'])) {
                            continue;
                        }

                        // Save new image
                        $saved = $this->saveBase64Image($imgInfo['data']);
                        if ($saved) {
                            $category = $imgInfo['category'] ?? 'unknown';
                            $timestamp = $imgInfo['timestamp'] ?? now()->toISOString();
                            $position = $imgInfo['position'] ?? null;

                            // Find and replace image dengan kategori yang sama atau gunakan posisi
                            $existingImages = $this->replaceImageByCategoryAtSamePosition(
                                $existingImages,
                                $saved,
                                $category,
                                $timestamp,
                                $position
                            );
                        }
                    } catch (\Exception $e) {
                        Log::error('Error processing image in update: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            $validated['images'] = !empty($existingImages) ? $existingImages : null;

            // Ensure notes is string
            if (isset($validated['notes']) && is_array($validated['notes'])) {
                $validated['notes'] = implode("\n", $validated['notes']);
            }

            $maintenanceAc->update($validated);

            return redirect()->route('ac.show', $maintenanceAc->id)
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error updating maintenance AC: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Replace image dengan kategori yang sama DI POSISI YANG SAMA (INDEX DIJAGA)
     */
    private function replaceImageByCategoryAtSamePosition($images, $newImagePath, $category, $timestamp = null, $position = null)
    {
        if (!is_array($images)) {
            return [
                [
                    'path' => $newImagePath,
                    'category' => $category,
                    'timestamp' => $timestamp ?? now()->toISOString()
                ]
            ];
        }

        $found = false;
        $result = $images;

        // Jika position diberikan, gunakan itu untuk replace
        if ($position !== null && isset($result[$position])) {
            // Delete old image file
            if (isset($result[$position]['path']) && Storage::disk('public')->exists($result[$position]['path'])) {
                Storage::disk('public')->delete($result[$position]['path']);
                Log::info("Deleted old image at position {$position}: " . $result[$position]['path']);
            }

            // Replace dengan new image DI POSISI YANG SAMA
            $result[$position] = [
                'path' => $newImagePath,
                'category' => $category,
                'timestamp' => $timestamp ?? now()->toISOString()
            ];

            $found = true;
            Log::info("Replaced image at position {$position} with category: {$category}");
        }

        // Jika tidak ada position, cari berdasarkan category
        if (!$found) {
            foreach ($result as $index => $img) {
                if (isset($img['category']) && $img['category'] === $category) {
                    // Delete old image file
                    if (isset($img['path']) && Storage::disk('public')->exists($img['path'])) {
                        Storage::disk('public')->delete($img['path']);
                        Log::info("Deleted old image at index {$index}: " . $img['path']);
                    }

                    // Replace dengan new image AT THE SAME INDEX
                    $result[$index] = [
                        'path' => $newImagePath,
                        'category' => $category,
                        'timestamp' => $timestamp ?? now()->toISOString()
                    ];

                    $found = true;
                    Log::info("Replaced image at index {$index} with category: {$category}");
                    break;
                }
            }
        }

        // If category doesn't exist yet, add it at the end
        if (!$found) {
            $result[] = [
                'path' => $newImagePath,
                'category' => $category,
                'timestamp' => $timestamp ?? now()->toISOString()
            ];
            Log::info("Added new image with category: {$category}");
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $maintenanceAc = AcMaintenance::findOrFail($id);

            // Delete all images
            if ($maintenanceAc->images && is_array($maintenanceAc->images)) {
                foreach ($maintenanceAc->images as $img) {
                    if (isset($img['path']) && Storage::disk('public')->exists($img['path'])) {
                        Storage::disk('public')->delete($img['path']);
                        Log::info("Deleted image: " . $img['path']);
                    }
                }
            }

            $maintenanceAc->delete();

            return redirect()->route('ac.index')
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting maintenance AC: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Validate request data - FIXED FIELD NAMES
     */
    private function validateRequest(Request $request)
    {
        Log::info('Validating AC Maintenance Request');

        $rules = [
            // Informasi Lokasi dan Perangkat
            'central_id' => 'required|exists:central,id',
            'date_time' => 'required|date',
            'brand_type' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',

            // 1. Visual Check
            'environment_condition' => 'nullable|string|max:255',
            'status_environment_condition' => 'nullable|in:OK,NOK',

            'filter' => 'nullable|string|max:255',
            'status_filter' => 'nullable|in:OK,NOK',

            'evaporator' => 'nullable|string|max:255',
            'status_evaporator' => 'nullable|in:OK,NOK',

            'led_display' => 'nullable|string|max:255',
            'status_led_display' => 'nullable|in:OK,NOK',

            'air_flow' => 'nullable|string|max:255',
            'status_air_flow' => 'nullable|in:OK,NOK',

            // 2. Room Temperature - FIXED FIELD NAMES
            'temp_shelter' => 'nullable|numeric',
            'status_temp_shelter' => 'nullable|in:OK,NOK',

            'temp_outdoor_cabinet' => 'nullable|numeric',
            'status_temp_outdoor_cabinet' => 'nullable|in:OK,NOK',

            // 3. Input Current Air Cond (nullable karena tidak semua AC digunakan)
            'ac1_current' => 'nullable|numeric',
            'status_ac1' => 'nullable|in:OK,NOK',

            'ac2_current' => 'nullable|numeric',
            'status_ac2' => 'nullable|in:OK,NOK',

            'ac3_current' => 'nullable|numeric',
            'status_ac3' => 'nullable|in:OK,NOK',

            'ac4_current' => 'nullable|numeric',
            'status_ac4' => 'nullable|in:OK,NOK',

            'ac5_current' => 'nullable|numeric',
            'status_ac5' => 'nullable|in:OK,NOK',

            'ac6_current' => 'nullable|numeric',
            'status_ac6' => 'nullable|in:OK,NOK',

            'ac7_current' => 'nullable|numeric',
            'status_ac7' => 'nullable|in:OK,NOK',

            // Notes and Personnel
            'notes' => 'nullable|string',

            'executor_1' => 'nullable|string|max:255',
            'executor_2' => 'nullable|string|max:255',
            'executor_3' => 'nullable|string|max:255',

            'supervisor' => 'nullable|string|max:255',
            'supervisor_id_number' => 'nullable|string|max:255',

            'department' => 'nullable|string|max:255',
            'sub_department' => 'nullable|string|max:255',
        ];

        return $request->validate($rules);
    }

    /**
     * Save Base64 image to storage
     */
    private function saveBase64Image($imageData)
    {
        if (empty($imageData)) {
            return null;
        }

        if (!preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            Log::error('Invalid image format');
            return null;
        }

        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]);

        if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $type = 'jpg';
        }

        $decodedImage = base64_decode($imageData);

        if ($decodedImage === false) {
            Log::error('Failed to decode base64');
            return null;
        }

        $directory = 'maintenance_ac_images/' . date('Y/m/d');
        $filename = uniqid('ac_', true) . '.' . $type;
        $path = $directory . '/' . $filename;

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory, 0755, true);
        }

        if (Storage::disk('public')->put($path, $decodedImage)) {
            Log::info('Image saved successfully: ' . $path);
            return $path;
        } else {
            Log::error('Failed to save image');
            return null;
        }
    }

    /**
     * Print maintenance report as PDF
     */
    public function print($id)
    {
        $maintenance = AcMaintenance::with('central')->findOrFail($id);

        // Format date and time for filename
        $date_time = date('Y-m-d', strtotime($maintenance->date_time));
        $centralId = $maintenance->central->id_sentral ?? 'unknown';

        $pdf = PDF::loadView('ac.acpdf', compact('maintenance'));
        return $pdf->stream("FM-LAP-D2-SOP-003-003-{$date_time}-{$centralId}.pdf");
    }
}

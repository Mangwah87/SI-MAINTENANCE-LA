<?php

namespace App\Http\Controllers;

use App\Models\UpsMaintenance1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class UpsMaintenance1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = UpsMaintenance1::orderBy('date_time', 'desc')->paginate(10);

        // Calculate statistics
        $stats = [
            'this_month' => UpsMaintenance1::whereMonth('date_time', now()->month)
                ->whereYear('date_time', now()->year)
                ->count(),
        ];

        return view('ups1.ups_1', compact('maintenances', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ups1.upsform_1');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateRequest($request);

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

            $maintenance = UpsMaintenance1::create($validated);

            Log::info('Maintenance Created:', ['id' => $maintenance->id, 'images_count' => count($savedImages)]);

            return redirect()->route('ups1.show', $maintenance->id)
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error storing maintenance: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UpsMaintenance1 $upsMaintenance1)
    {
        return view('ups1.upsdetail_1', ['maintenance' => $upsMaintenance1]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpsMaintenance1 $upsMaintenance1)
    {
        return view('ups1.upsform_1', ['maintenance' => $upsMaintenance1]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UpsMaintenance1 $upsMaintenance1)
    {
        try {
            $validated = $this->validateRequest($request);

            // Get existing images (keep as indexed array to maintain order)
            $existingImages = $upsMaintenance1->images ?? [];
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
                            break; // Stop after finding the match
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
                            $position = $imgInfo['position'] ?? null; // Ambil posisi dari frontend

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

            $upsMaintenance1->update($validated);

            return redirect()->route('ups1.show', $upsMaintenance1->id)
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error updating maintenance: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Replace image dengan kategori yang sama DI POSISI YANG SAMA (INDEX DIJAGA)
     * Jika position diberikan, gunakan itu; jika tidak, cari berdasarkan category
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
        $result = $images; // Keep original array structure

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
                    break; // Stop after first match to maintain position
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
    public function destroy(UpsMaintenance1 $upsMaintenance1)
    {
        try {
            // Delete all images
            if ($upsMaintenance1->images && is_array($upsMaintenance1->images)) {
                foreach ($upsMaintenance1->images as $img) {
                    if (isset($img['path']) && Storage::disk('public')->exists($img['path'])) {
                        Storage::disk('public')->delete($img['path']);
                        Log::info("Deleted image: " . $img['path']);
                    }
                }
            }

            $upsMaintenance1->delete();

            return redirect()->route('ups1.index')
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting maintenance: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Validate request data
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',

            // Visual Check
            'env_condition' => 'required|string|max:255',
            'status_env_condition' => 'required|in:OK,NOK',
            'led_display' => 'required|string|max:255',
            'status_led_display' => 'required|in:OK,NOK',
            'battery_connection' => 'required|string|max:255',
            'status_battery_connection' => 'required|in:OK,NOK',

            // Performance and Capacity Check
            'ac_input_voltage' => 'required|numeric',
            'status_ac_input_voltage' => 'required|in:OK,NOK',

            'ac_output_voltage' => 'required|numeric',
            'status_ac_output_voltage' => 'required|in:OK,NOK',

            'neutral_ground_voltage' => 'required|numeric',
            'status_neutral_ground_voltage' => 'required|in:OK,NOK',

            'ac_current_input' => 'required|numeric',
            'status_ac_current_input' => 'required|in:OK,NOK',

            'ac_current_output' => 'required|numeric',
            'status_ac_current_output' => 'required|in:OK,NOK',

            'ups_temperature' => 'required|numeric',
            'status_ups_temperature' => 'required|in:OK,NOK',

            'output_frequency' => 'required|numeric',
            'status_output_frequency' => 'required|in:OK,NOK',

            'charging_voltage' => 'required|numeric',
            'status_charging_voltage' => 'required|in:OK,NOK',

            'charging_current' => 'required|numeric',
            'status_charging_current' => 'required|in:OK,NOK',

            'fan' => 'required|string|max:255',
            'status_fan' => 'required|in:OK,NOK',

            // Backup Tests
            'ups_switching_test' => 'required|string|max:255',
            'status_ups_switching_test' => 'required|in:OK,NOK',

            'battery_voltage_measurement_1' => 'required|numeric',
            'status_battery_voltage_measurement_1' => 'required|in:OK,NOK',

            'battery_voltage_measurement_2' => 'required|numeric',
            'status_battery_voltage_measurement_2' => 'required|in:OK,NOK',

            // Power Alarm Monitoring Test
            'simonica_alarm_test' => 'required|string|max:255',
            'status_simonica_alarm_test' => 'required|in:OK,NOK',

            // Notes and Personnel
            'notes' => 'nullable|string',

            'executor_1' => 'required|string|max:255',
            'executor_2' => 'nullable|string|max:255',
            'supervisor' => 'required|string|max:255',
            'supervisor_id_number' => 'nullable|string|max:255',

            'department' => 'nullable|string|max:255',
            'sub_department' => 'nullable|string|max:255',
        ]);
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

        $directory = 'ups1_images/' . date('Y/m/d');
        $filename = uniqid('ups1_', true) . '.' . $type;
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
    public function print(UpsMaintenance1 $upsMaintenance1)
    {
        $maintenance = $upsMaintenance1;
        $pdf = PDF::loadView('ups1.upspdf_1', compact('maintenance'));
        return $pdf->stream('preventive_maintenance_ups1phase_'.$maintenance->id.'.pdf');
    }
}

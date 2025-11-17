<?php

namespace App\Http\Controllers;

use App\Models\UpsMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class UpsMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = UpsMaintenance::with(['user', 'central'])
            ->where('user_id', auth()->id())
            ->latest('date_time')
            ->paginate(10);
        return view('ups3.ups', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centrals = \App\Models\Central::orderBy('area')->orderBy('id_sentral')->get();
        return view('ups3.upsform', compact('centrals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'central_id' => 'required|exists:central,id',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',

            'env_condition' => 'required|string|max:255',
            'led_display' => 'required|string|max:255',
            'battery_connection' => 'required|string|max:255',

            'status_env_condition' => 'nullable|in:OK,NOK',
            'status_led_display' => 'nullable|in:OK,NOK',
            'status_battery_connection' => 'nullable|in:OK,NOK',

            'ac_input_voltage_rs' => 'required|numeric',
            'ac_input_voltage_st' => 'required|numeric',
            'ac_input_voltage_tr' => 'required|numeric',
            'status_ac_input_voltage' => 'required|in:OK,NOK',

            'ac_output_voltage_rs' => 'required|numeric',
            'ac_output_voltage_st' => 'required|numeric',
            'ac_output_voltage_tr' => 'required|numeric',
            'status_ac_output_voltage' => 'required|in:OK,NOK',

            'ac_current_input_r' => 'required|numeric',
            'ac_current_input_s' => 'required|numeric',
            'ac_current_input_t' => 'required|numeric',
            'status_ac_current_input' => 'required|in:OK,NOK',

            'ac_current_output_r' => 'required|numeric',
            'ac_current_output_s' => 'required|numeric',
            'ac_current_output_t' => 'required|numeric',
            'status_ac_current_output' => 'required|in:OK,NOK',

            'ups_temperature' => 'required|numeric',
            'status_ups_temperature' => 'required|in:OK,NOK',

            'output_frequency' => 'required|numeric',
            'status_output_frequency' => 'required|in:OK,NOK',

            'charging_voltage' => 'required|numeric',
            'status_charging_voltage' => 'required|in:OK,NOK',

            'charging_current' => 'required|numeric',
            'status_charging_current' => 'required|in:OK,NOK',

            'notes' => 'nullable|string',

            'executor_1' => 'required|string|max:255',
            'executor_2' => 'nullable|string|max:255',
            'executor_3' => 'nullable|string|max:255',
            'supervisor' => 'required|string|max:255',
            'supervisor_id_number' => 'nullable|string|max:255',

            'department' => 'nullable|string|max:255',
            'sub_department' => 'nullable|string|max:255',
        ]);

        // Debug: Log semua request data
        Log::info('Request All Data:', $request->all());

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
                                'category' => $imgInfo['category'] ?? 'unknown'
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
        Log::info('Final saved images:', $savedImages);

        // Add user_id
        $validated['user_id'] = auth()->id();

        $maintenance = UpsMaintenance::create($validated);

        Log::info('Maintenance Created:', ['id' => $maintenance->id, 'images' => $maintenance->images]);

        return redirect()->route('ups3.show', $maintenance->id)
            ->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UpsMaintenance $upsMaintenance)
    {
        $upsMaintenance->load('central');
        return view('ups3.upsdetail', ['maintenance' => $upsMaintenance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpsMaintenance $upsMaintenance)
    {
        $centrals = \App\Models\Central::orderBy('area')->orderBy('id_sentral')->get();
        return view('ups3.upsform', ['maintenance' => $upsMaintenance, 'centrals' => $centrals]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UpsMaintenance $upsMaintenance)
    {
        $validated = $request->validate([
            'central_id' => 'required|exists:central,id',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',

            'env_condition' => 'required|string|max:255',
            'led_display' => 'required|string|max:255',
            'battery_connection' => 'required|string|max:255',

            'status_env_condition' => 'nullable|in:OK,NOK',
            'status_led_display' => 'nullable|in:OK,NOK',
            'status_battery_connection' => 'nullable|in:OK,NOK',

            'ac_input_voltage_rs' => 'required|numeric',
            'ac_input_voltage_st' => 'required|numeric',
            'ac_input_voltage_tr' => 'required|numeric',
            'status_ac_input_voltage' => 'required|in:OK,NOK',

            'ac_output_voltage_rs' => 'required|numeric',
            'ac_output_voltage_st' => 'required|numeric',
            'ac_output_voltage_tr' => 'required|numeric',
            'status_ac_output_voltage' => 'required|in:OK,NOK',

            'ac_current_input_r' => 'required|numeric',
            'ac_current_input_s' => 'required|numeric',
            'ac_current_input_t' => 'required|numeric',
            'status_ac_current_input' => 'required|in:OK,NOK',

            'ac_current_output_r' => 'required|numeric',
            'ac_current_output_s' => 'required|numeric',
            'ac_current_output_t' => 'required|numeric',
            'status_ac_current_output' => 'required|in:OK,NOK',

            'ups_temperature' => 'required|numeric',
            'status_ups_temperature' => 'required|in:OK,NOK',

            'output_frequency' => 'required|numeric',
            'status_output_frequency' => 'required|in:OK,NOK',

            'charging_voltage' => 'required|numeric',
            'status_charging_voltage' => 'required|in:OK,NOK',

            'charging_current' => 'required|numeric',
            'status_charging_current' => 'required|in:OK,NOK',

            'notes' => 'nullable|string',

            'executor_1' => 'required|string|max:255',
            'executor_2' => 'nullable|string|max:255',
            'executor_3' => 'nullable|string|max:255',
            'supervisor' => 'required|string|max:255',
            'supervisor_id_number' => 'nullable|string|max:255',

            'department' => 'nullable|string|max:255',
            'sub_department' => 'nullable|string|max:255',
        ]);

        // Handle upload images - Preserve existing images
        $imagesData = $request->input('images', []);
        $deleteImages = $request->input('delete_images', []);
        $existingImages = [];

        // Keep existing images from database, excluding those marked for deletion
        if ($upsMaintenance->images && is_array($upsMaintenance->images)) {
            foreach ($upsMaintenance->images as $img) {
                // Get the path whether it's a string or array
                $imagePath = is_array($img) && isset($img['path']) ? $img['path'] : (is_string($img) ? $img : null);

                // Keep image if it's not in delete list
                if ($imagePath && !in_array($imagePath, $deleteImages)) {
                    $existingImages[] = $img;
                } else if ($imagePath && in_array($imagePath, $deleteImages)) {
                    // Delete the file from storage
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                        Log::info("Deleted image during edit: $imagePath");
                    }
                }
            }
        }

        // Process new images from form
        if (!empty($imagesData) && is_array($imagesData)) {
            foreach ($imagesData as $imgJson) {
                try {
                    $imgInfo = json_decode($imgJson, true);
                    if ($imgInfo && isset($imgInfo['data'])) {
                        // This is a new image (base64)
                        $saved = $this->saveBase64Image($imgInfo['data']);
                        if ($saved) {
                            $newImage = [
                                'path' => $saved,
                                'category' => $imgInfo['category'] ?? 'unknown'
                            ];

                            // If position is specified, insert at that position
                            if (isset($imgInfo['position']) && is_numeric($imgInfo['position'])) {
                                $position = (int) $imgInfo['position'];
                                // Make sure position is valid
                                if ($position >= 0 && $position <= count($existingImages)) {
                                    array_splice($existingImages, $position, 0, [$newImage]);
                                } else {
                                    $existingImages[] = $newImage;
                                }
                            } else {
                                $existingImages[] = $newImage;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing image in update: ' . $e->getMessage());
                    continue;
                }
            }
        }

        // Update images field with combined old and new images
        $validated['images'] = !empty($existingImages) ? $existingImages : null;

        $upsMaintenance->update($validated);

        return redirect()->route('ups3.show', $upsMaintenance)
            ->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpsMaintenance $upsMaintenance)
    {
        // Hapus gambar jika ada
        if ($upsMaintenance->images) {
            $this->deleteOldImages($upsMaintenance->images);
        }

        $upsMaintenance->delete();

        return redirect()->route('ups3.index')
            ->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Handle Base64 Images (dari camera atau upload lokal)
     */
    // Simpan satu gambar base64 ke storage, return path jika sukses
    private function saveBase64Image($imageData)
    {
        if (empty($imageData)) return null;
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
        $directory = 'ups_images/' . date('Y/m/d');
        $filename = uniqid('ups_', true) . '.' . $type;
        $path = $directory . '/' . $filename;
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
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
     * Delete old images
     */
    private function deleteOldImages($images)
    {
        if (!is_array($images)) {
            return;
        }

        array_walk_recursive($images, function($item) {
            if (is_string($item) && Storage::disk('public')->exists($item)) {
                Storage::disk('public')->delete($item);
                Log::info("Deleted old image: $item");
            }
        });
    }

    /**
     * Print maintenance report as PDF
     */
    public function print(UpsMaintenance $upsMaintenance)
    {
        $upsMaintenance->load('central');
        $maintenance = $upsMaintenance;
        $pdf = PDF::loadView('ups3.upsdetail_pdf', compact('maintenance'));
        return $pdf->stream('preventive_maintenance_ups_'.$maintenance->id.'.pdf');
    }
}

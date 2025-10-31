<?php

namespace App\Http\Controllers;

use App\Models\RectifierMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RectifierMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = RectifierMaintenance::query();

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Date range filter - Dari Tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('date_time', '>=', $request->date_from);
        }

        // Date range filter - Sampai Tanggal
        if ($request->filled('date_to')) {
            $query->whereDate('date_time', '<=', $request->date_to);
        }

        // Default sorting: newest first (sama seperti sebelumnya)
        $query->orderBy('date_time', 'desc');

        // Pagination
        $maintenances = $query->paginate(15);

        return view('rectifier.index', compact('maintenances'));
    }

    public function create()
    {
        return view('rectifier.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'power_module' => 'required|in:Single,Dual,Three',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',

            // Visual Check
            'env_condition' => 'nullable|string',
            'status_env_condition' => 'required|in:OK,NOK',
            'led_display' => 'nullable|string',
            'status_led_display' => 'required|in:OK,NOK',
            'battery_connection' => 'nullable|string',
            'status_battery_connection' => 'required|in:OK,NOK',

            // Performance and Capacity Check
            'ac_input_voltage' => 'nullable|numeric',
            'status_ac_input_voltage' => 'required|in:OK,NOK',
            'ac_current_input_single' => 'nullable|numeric',
            'ac_current_input_dual' => 'nullable|numeric',
            'ac_current_input_three' => 'nullable|numeric',
            'status_ac_current_input' => 'required|in:OK,NOK',
            'dc_current_output_single' => 'nullable|numeric',
            'dc_current_output_dual' => 'nullable|numeric',
            'dc_current_output_three' => 'nullable|numeric',
            'status_dc_current_output' => 'required|in:OK,NOK',
            'battery_temperature' => 'nullable|numeric',
            'status_battery_temperature' => 'required|in:OK,NOK',
            'charging_voltage_dc' => 'nullable|numeric',
            'status_charging_voltage_dc' => 'required|in:OK,NOK',
            'charging_current_dc' => 'nullable|numeric',
            'status_charging_current_dc' => 'required|in:OK,NOK',

            // Backup Tests
            'backup_test_rectifier' => 'nullable|string',
            'status_backup_test_rectifier' => 'required|in:OK,NOK',
            'backup_test_voltage_measurement1' => 'nullable|numeric',
            'backup_test_voltage_measurement2' => 'nullable|numeric',
            'status_backup_test_voltage' => 'required|in:OK,NOK',

            // Power Alarm
            'power_alarm_test' => 'nullable|string',
            'status_power_alarm_test' => 'required|in:OK,NOK',

            // Notes
            'notes' => 'nullable|string',

            // Personnel
            'executor_1' => 'required|string|max:255',
            'executor_2' => 'nullable|string|max:255',
            'executor_3' => 'nullable|string|max:255',
            'supervisor' => 'required|string|max:255',
            'supervisor_id_number' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'sub_department' => 'nullable|string|max:255',
        ]);

        $images = $this->handleAllImages($request);
        $validated['images'] = $images;

        $validated['user_id'] = auth()->id();

        $maintenance = RectifierMaintenance::create($validated);

        return redirect()->route('rectifier.show', $maintenance->id)
            ->with('success', 'Data preventive maintenance berhasil disimpan!');
    }

    public function show($id)
    {
        $maintenance = RectifierMaintenance::findOrFail($id);
        return view('rectifier.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = RectifierMaintenance::findOrFail($id);
        return view('rectifier.form', compact('maintenance'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = RectifierMaintenance::findOrFail($id);

        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'brand_type' => 'required|string|max:255',
            'power_module' => 'required|in:Single,Dual,Three',
            'reg_number' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'env_condition' => 'nullable|string',
            'status_env_condition' => 'required|in:OK,NOK',
            'led_display' => 'nullable|string',
            'status_led_display' => 'required|in:OK,NOK',
            'battery_connection' => 'nullable|string',
            'status_battery_connection' => 'required|in:OK,NOK',
            'ac_input_voltage' => 'nullable|numeric',
            'status_ac_input_voltage' => 'required|in:OK,NOK',
            'ac_current_input_single' => 'nullable|numeric',
            'ac_current_input_dual' => 'nullable|numeric',
            'ac_current_input_three' => 'nullable|numeric',
            'status_ac_current_input' => 'required|in:OK,NOK',
            'dc_current_output_single' => 'nullable|numeric',
            'dc_current_output_dual' => 'nullable|numeric',
            'dc_current_output_three' => 'nullable|numeric',
            'status_dc_current_output' => 'required|in:OK,NOK',
            'battery_temperature' => 'nullable|numeric',
            'status_battery_temperature' => 'required|in:OK,NOK',
            'charging_voltage_dc' => 'nullable|numeric',
            'status_charging_voltage_dc' => 'required|in:OK,NOK',
            'charging_current_dc' => 'nullable|numeric',
            'status_charging_current_dc' => 'required|in:OK,NOK',
            'backup_test_rectifier' => 'nullable|string',
            'status_backup_test_rectifier' => 'required|in:OK,NOK',
            'backup_test_voltage_measurement1' => 'nullable|numeric',
            'backup_test_voltage_measurement2' => 'nullable|numeric',
            'status_backup_test_voltage' => 'required|in:OK,NOK',
            'power_alarm_test' => 'nullable|string',
            'status_power_alarm_test' => 'required|in:OK,NOK',
            'notes' => 'nullable|string',
            'executor_1' => 'required|string|max:255',
            'executor_2' => 'nullable|string|max:255',
            'executor_3' => 'nullable|string|max:255',
            'supervisor' => 'required|string|max:255',
            'supervisor_id_number' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'sub_department' => 'nullable|string|max:255',
            'deleted_images' => 'nullable|json',
        ]);

        if ($request->has('deleted_images')) {
            $deletedImages = json_decode($request->deleted_images, true);
            if (is_array($deletedImages)) {
                foreach ($deletedImages as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $existingImages = $maintenance->images ?? [];
        $newImages = $this->handleAllImages($request);
        $allImages = array_merge($existingImages, $newImages);

        if ($request->has('deleted_images')) {
            $deletedImages = json_decode($request->deleted_images, true);
            if (is_array($deletedImages)) {
                $allImages = array_filter($allImages, function ($img) use ($deletedImages) {
                    return !in_array($img['path'] ?? '', $deletedImages);
                });
                $allImages = array_values($allImages);
            }
        }

        $validated['images'] = $allImages;
        $maintenance->update($validated);

        return redirect()->route('rectifier.show', $maintenance->id)
            ->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $maintenance = RectifierMaintenance::findOrFail($id);

        if ($maintenance->images && is_array($maintenance->images)) {
            foreach ($maintenance->images as $image) {
                if (isset($image['path'])) {
                    Storage::disk('public')->delete($image['path']);
                }
            }
        }

        $maintenance->delete();

        return redirect()->route('rectifier.index')
            ->with('success', 'Data berhasil dihapus!');
    }

    public function exportPdf($id)
    {
        // Increase memory and time limits
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $maintenance = RectifierMaintenance::findOrFail($id);

        // Process images untuk PDF dengan kompresi dan resize
        $processedImages = [];
        if ($maintenance->images && is_array($maintenance->images)) {
            foreach ($maintenance->images as $image) {
                $imagePath = is_array($image) ? ($image['path'] ?? null) : $image;

                if ($imagePath) {
                    $fullPath = storage_path('app/public/' . $imagePath);

                    if (file_exists($fullPath)) {
                        try {
                            // Compress and resize image untuk PDF
                            $optimizedImage = $this->optimizeImageForPdf($fullPath);

                            if ($optimizedImage) {
                                $processedImages[] = [
                                    'data' => $optimizedImage,
                                    'category' => is_array($image) ? ($image['category'] ?? 'general') : 'general',
                                    'path' => $imagePath
                                ];
                            }
                        } catch (\Exception $e) {
                            Log::error("Error processing image for PDF: " . $e->getMessage());
                        }
                    } else {
                        Log::warning("Image file not found: " . $fullPath);
                    }
                }
            }
        }

        $data = [
            'maintenance' => $maintenance,
            'processedImages' => $processedImages
        ];

        try {
            $pdf = Pdf::loadView('rectifier.pdf', $data)
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('chroot', public_path())
                ->setOption('enable_php', true)
                ->setOption('dpi', 96);

            $filename = 'PM-Rectifier-' . $maintenance->location . '-' . date('Y-m-d', strtotime($maintenance->date_time)) . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Optimize image for PDF rendering
     * Resize dan compress image untuk mengurangi ukuran PDF
     */
    private function optimizeImageForPdf($imagePath)
    {
        try {
            // Read image
            $imageData = file_get_contents($imagePath);
            $image = imagecreatefromstring($imageData);

            if (!$image) {
                return null;
            }

            // Get original dimensions
            $width = imagesx($image);
            $height = imagesy($image);

            // Set max dimensions untuk PDF (A4 landscape safe zone)
            $maxWidth = 800;
            $maxHeight = 600;

            // Calculate new dimensions maintaining aspect ratio
            $ratio = min($maxWidth / $width, $maxHeight / $height);

            // Only resize if image is larger
            if ($ratio < 1) {
                $newWidth = round($width * $ratio);
                $newHeight = round($height * $ratio);

                // Create new image
                $newImage = imagecreatetruecolor($newWidth, $newHeight);

                // Preserve transparency for PNG
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);

                // Resize
                imagecopyresampled(
                    $newImage,
                    $image,
                    0,
                    0,
                    0,
                    0,
                    $newWidth,
                    $newHeight,
                    $width,
                    $height
                );

                $image = $newImage;
            }

            // Output to buffer
            ob_start();
            imagejpeg($image, null, 75); // 75% quality for better compression
            $optimizedData = ob_get_clean();
            imagedestroy($image);

            // Convert to base64
            $base64 = base64_encode($optimizedData);
            return "data:image/jpeg;base64," . $base64;
        } catch (\Exception $e) {
            Log::error('Image optimization error: ' . $e->getMessage());
            return null;
        }
    }

    private function handleAllImages(Request $request)
    {
        $images = [];

        // Handle file uploads
        foreach ($request->allFiles() as $key => $files) {
            if (strpos($key, 'images_') === 0) {
                $category = str_replace('images_', '', $key);

                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    $path = $file->store('rectifier_images', 'public');
                    $images[] = [
                        'category' => $category,
                        'path' => $path,
                    ];
                }
            }
        }

        // Handle camera photos
        $cameraCategories = [
            'visual_check',
            'performance',
            'backup',
            'alarm',
            'ac_voltage',
            'ac_current',
            'dc_current',
            'battery_temp',
            'charging_voltage',
            'charging_current',
            'rectifier_test',
            'battery_voltage'
        ];

        foreach ($cameraCategories as $category) {
            $cameraKey = 'camera_photos_' . $category;

            if ($request->has($cameraKey) && !empty($request->$cameraKey)) {
                $photosJson = $request->$cameraKey;

                if ($photosJson === '[]') {
                    continue;
                }

                $photos = json_decode($photosJson, true);

                if (is_array($photos) && count($photos) > 0) {
                    foreach ($photos as $photo) {
                        if (isset($photo['image'])) {
                            $savedPath = $this->saveBase64Image($photo['image'], $category);

                            if ($savedPath) {
                                $images[] = [
                                    'category' => $category,
                                    'path' => $savedPath,
                                    'lat' => $photo['lat'] ?? null,
                                    'lng' => $photo['lng'] ?? null,
                                    'timestamp' => $photo['timestamp'] ?? null,
                                    'address' => $photo['address'] ?? null,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $images;
    }

    private function saveBase64Image($base64Image, $category)
    {
        try {
            if (!preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                return null;
            }

            $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                return null;
            }

            $extension = strtolower($type[1]);
            $filename = 'rectifier_' . $category . '_' . time() . '_' . Str::random(10) . '.' . $extension;
            $path = 'rectifier_images/' . $filename;

            Storage::disk('public')->put($path, $imageData);

            return $path;
        } catch (\Exception $e) {
            Log::error('Error saving base64 image: ' . $e->getMessage());
            return null;
        }
    }

    public function debugImages($id)
    {
        $maintenance = RectifierMaintenance::findOrFail($id);

        $debug = [
            'raw_images' => $maintenance->images,
            'is_array' => is_array($maintenance->images),
            'count' => is_array($maintenance->images) ? count($maintenance->images) : 0,
            'files_check' => []
        ];

        if ($maintenance->images && is_array($maintenance->images)) {
            foreach ($maintenance->images as $index => $image) {
                $imagePath = is_array($image) ? ($image['path'] ?? null) : $image;

                if ($imagePath) {
                    $fullPath = storage_path('app/public/' . $imagePath);
                    $debug['files_check'][$index] = [
                        'path' => $imagePath,
                        'full_path' => $fullPath,
                        'exists' => file_exists($fullPath),
                        'size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                        'mime' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                        'category' => is_array($image) ? ($image['category'] ?? 'unknown') : 'unknown'
                    ];
                }
            }
        }

        return response()->json($debug);
    }
}

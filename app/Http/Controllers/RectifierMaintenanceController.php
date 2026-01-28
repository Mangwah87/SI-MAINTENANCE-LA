<?php

namespace App\Http\Controllers;

use App\Models\RectifierMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class RectifierMaintenanceController extends Controller
{
    private $maxImageSizeKB = 1024; // 1MB = 1024KB
    private $maxImageSizeBytes;

    public function __construct()
    {
        $this->maxImageSizeBytes = $this->maxImageSizeKB * 1024;
    }

    // Update method index() di RectifierMaintenanceController

    public function index(Request $request)
    {
        $query = RectifierMaintenance::query();
        $query->where('user_id', auth()->id());

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date_time', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date_time', '<=', $request->date_to);
        }

        $query->orderBy('date_time', 'desc');

        // Load relasi 'central' saja, TIDAK ADA 'readings'
        $maintenances = $query->with('central')->paginate(15);

        // Ambil data central untuk filter
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');

        return view('rectifier.index', compact('maintenances', 'centralsByArea'));
    }

    public function create()
    {
        // Ambil data central dari database
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        // Group by area untuk tampilan yang lebih rapi
        $centralsByArea = $centrals->groupBy('area');

        return view('rectifier.form', compact('centralsByArea'));
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

        // Visual Check (Physical Check)
        'env_condition' => 'nullable|string',
        'status_env_condition' => 'required|in:OK,NOK',
        'led_display' => 'nullable|string',
        'status_led_display' => 'required|in:OK,NOK',
        'battery_connection' => 'nullable|string',
        'status_battery_connection' => 'required|in:OK,NOK',
        'rectifier_module_installed' => 'nullable|string', // NEW
        'status_rectifier_module_installed' => 'required|in:OK,NOK', // NEW
        'alarm_modul_rectifier' => 'nullable|string', // NEW
        'status_alarm_modul_rectifier' => 'required|in:OK,NOK', // NEW

        // Performance and Capacity Check
        'ac_input_voltage' => 'nullable|numeric',
        'status_ac_input_voltage' => 'required|in:OK,NOK',
        'ac_current_input' => 'nullable|numeric',
        'status_ac_current_input' => 'required|in:OK,NOK',
        'dc_current_output' => 'nullable|numeric',
        'status_dc_current_output' => 'required|in:OK,NOK',
        'charging_voltage_dc' => 'nullable|numeric',
        'status_charging_voltage_dc' => 'required|in:OK,NOK',
        'charging_current_dc' => 'nullable|numeric',
        'status_charging_current_dc' => 'required|in:OK,NOK',

        // Backup Tests
        'backup_test_rectifier' => 'nullable|string',
        'status_backup_test_rectifier' => 'required|in:OK,NOK',

        // Power Alarm Monitoring Test
        'power_alarm_test' => 'nullable|string',
        'status_power_alarm_test' => 'required|in:OK,NOK',

        // Notes
        'notes' => 'nullable|string',

        // Personnel - Executor
        'executor_1' => 'required|string|max:255',
        'executor_1_department' => 'nullable|string|max:255',
        'executor_1_type' => 'nullable|in:Mitra,Internal', // NEW
        'executor_2' => 'nullable|string|max:255',
        'executor_2_department' => 'nullable|string|max:255',
        'executor_2_type' => 'nullable|in:Mitra,Internal', // NEW
        'executor_3' => 'nullable|string|max:255',
        'executor_3_department' => 'nullable|string|max:255',
        'executor_3_type' => 'nullable|in:Mitra,Internal', // NEW

        // Personnel - Supervisor
        'supervisor' => 'required|string|max:255',
        'supervisor_id_number' => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',

        // Personnel - Verifikator (NEW)
        'verifikator_name' => 'nullable|string|max:255',
        'verifikator_id_number' => 'nullable|string|max:255',

        // Personnel - Head of Sub Department (NEW)
        'head_of_sub_dept_name' => 'nullable|string|max:255',
        'head_of_sub_dept_id' => 'nullable|string|max:255',
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
        $maintenance = RectifierMaintenance::with('central') // Load relasi central
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('rectifier.show', compact('maintenance'));
    }


    public function edit($id)
    {
        $maintenance = RectifierMaintenance::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Ambil data central untuk dropdown
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');

        return view('rectifier.form', compact('maintenance', 'centralsByArea'));
    }

    public function update(Request $request, $id)
    {
            $maintenance = RectifierMaintenance::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        $validated = $request->validate([
        'location' => 'required|string|max:255',
        'date_time' => 'required|date',
        'brand_type' => 'required|string|max:255',
        'power_module' => 'required|in:Single,Dual,Three',
        'reg_number' => 'nullable|string|max:255',
        'sn' => 'nullable|string|max:255',

        // Visual Check (Physical Check)
        'env_condition' => 'nullable|string',
        'status_env_condition' => 'required|in:OK,NOK',
        'led_display' => 'nullable|string',
        'status_led_display' => 'required|in:OK,NOK',
        'battery_connection' => 'nullable|string',
        'status_battery_connection' => 'required|in:OK,NOK',
        'rectifier_module_installed' => 'nullable|string', // NEW
        'status_rectifier_module_installed' => 'required|in:OK,NOK', // NEW
        'alarm_modul_rectifier' => 'nullable|string', // NEW
        'status_alarm_modul_rectifier' => 'required|in:OK,NOK', // NEW

        // Performance and Capacity Check
        'ac_input_voltage' => 'nullable|numeric',
        'status_ac_input_voltage' => 'required|in:OK,NOK',
        'ac_current_input' => 'nullable|numeric',
        'status_ac_current_input' => 'required|in:OK,NOK',
        'dc_current_output' => 'nullable|numeric',
        'status_dc_current_output' => 'required|in:OK,NOK',
        'charging_voltage_dc' => 'nullable|numeric',
        'status_charging_voltage_dc' => 'required|in:OK,NOK',
        'charging_current_dc' => 'nullable|numeric',
        'status_charging_current_dc' => 'required|in:OK,NOK',

        // Backup Tests
        'backup_test_rectifier' => 'nullable|string',
        'status_backup_test_rectifier' => 'required|in:OK,NOK',

        // Power Alarm Monitoring Test
        'power_alarm_test' => 'nullable|string',
        'status_power_alarm_test' => 'required|in:OK,NOK',

        // Notes
        'notes' => 'nullable|string',

        // Personnel - Executor
        'executor_1' => 'required|string|max:255',
        'executor_1_department' => 'nullable|string|max:255',
        'executor_1_type' => 'nullable|in:Mitra,Internal', // NEW
        'executor_2' => 'nullable|string|max:255',
        'executor_2_department' => 'nullable|string|max:255',
        'executor_2_type' => 'nullable|in:Mitra,Internal', // NEW
        'executor_3' => 'nullable|string|max:255',
        'executor_3_department' => 'nullable|string|max:255',
        'executor_3_type' => 'nullable|in:Mitra,Internal', // NEW

        // Personnel - Supervisor
        'supervisor' => 'required|string|max:255',
        'supervisor_id_number' => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',

        // Personnel - Verifikator (NEW)
        'verifikator_name' => 'nullable|string|max:255',
        'verifikator_id_number' => 'nullable|string|max:255',

        // Personnel - Head of Sub Department (NEW)
        'head_of_sub_dept_name' => 'nullable|string|max:255',
        'head_of_sub_dept_id' => 'nullable|string|max:255',
    ]);

        // Handle deleted images
    if ($request->has('deleted_images')) {
        $deletedImages = json_decode($request->deleted_images, true);
        if (is_array($deletedImages)) {
            foreach ($deletedImages as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }
    }

    // Get existing images and merge with new ones
    $existingImages = collect($maintenance->images ?? []);
    $newImages = collect($this->handleAllImages($request));
    $allImages = $existingImages->merge($newImages);

    // Filter out deleted images
    if ($request->has('deleted_images')) {
        $deletedImages = json_decode($request->deleted_images, true);
        if (is_array($deletedImages)) {
            $allImages = $allImages->filter(function ($img) use ($deletedImages) {
                return !in_array($img['path'] ?? '', $deletedImages);
            })->values();
        }
    }

    $validated['images'] = $allImages->toArray();
    $maintenance->update($validated);

    return redirect()->route('rectifier.show', $maintenance->id)
        ->with('success', 'Data berhasil diupdate!');
}

    public function destroy($id)
    {
        $maintenance = RectifierMaintenance::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Delete all images
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
        $maintenance = RectifierMaintenance::where('id', $id)
            ->firstOrFail();

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $data = ['maintenance' => $maintenance];

        try {
            $pdf = Pdf::loadView('rectifier.pdf', $data)
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('chroot', public_path())
                ->setOption('enable_php', true)
                ->setOption('dpi', 96);

            $dateFormatted = date('d-m-Y', strtotime($maintenance->date_time));
            $filename = 'PM-Rectifier-' . $maintenance->location . '-' . $dateFormatted . '.pdf';

            return $pdf->stream($filename);
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Compress image to target size (max 1MB) using native GD
     */
    private function compressImage($imageData, $maxSizeKB = 1024)
    {
        try {
            // Create image from string
            $image = imagecreatefromstring($imageData);

            if ($image === false) {
                Log::error('Failed to create image from string');
                return $imageData;
            }

            // Get original dimensions
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            // Calculate new dimensions (max 1920px)
            $maxDimension = 1920;
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;

            if ($originalWidth > $maxDimension || $originalHeight > $maxDimension) {
                if ($originalWidth > $originalHeight) {
                    $newWidth = $maxDimension;
                    $newHeight = (int) (($originalHeight / $originalWidth) * $maxDimension);
                } else {
                    $newHeight = $maxDimension;
                    $newWidth = (int) (($originalWidth / $originalHeight) * $maxDimension);
                }

                // Create resized image
                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled(
                    $resizedImage,
                    $image,
                    0,
                    0,
                    0,
                    0,
                    $newWidth,
                    $newHeight,
                    $originalWidth,
                    $originalHeight
                );
                imagedestroy($image);
                $image = $resizedImage;
            }

            // Compress dengan kualitas yang bervariasi
            $quality = 90;
            $minQuality = 60;
            $maxSizeBytes = $maxSizeKB * 1024;

            ob_start();
            imagejpeg($image, null, $quality);
            $compressed = ob_get_clean();
            $currentSize = strlen($compressed);

            // Turunkan kualitas bertahap hingga ukuran <= target
            while ($currentSize > $maxSizeBytes && $quality > $minQuality) {
                $quality -= 5;
                ob_start();
                imagejpeg($image, null, $quality);
                $compressed = ob_get_clean();
                $currentSize = strlen($compressed);
            }

            imagedestroy($image);

            $finalSizeKB = round($currentSize / 1024, 2);
            Log::info("Image compressed to {$finalSizeKB}KB with quality {$quality}%");

            return $compressed;

        } catch (\Exception $e) {
            Log::error('Image compression error: ' . $e->getMessage());
            return $imageData;
        }
    }

    /**
     * Handle all images from form (both file uploads and camera photos)
     */
    private function handleAllImages(Request $request)
    {
        $images = [];

        // Handle file uploads dengan kompresi
        foreach ($request->allFiles() as $key => $files) {
            if (strpos($key, 'images_') === 0) {
                $category = str_replace('images_', '', $key);

                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    try {
                        // Baca file dan kompresi
                        $imageData = file_get_contents($file->getRealPath());
                        $compressedImage = $this->compressImage($imageData, $this->maxImageSizeKB);

                        // Generate filename
                        $filename = 'rectifier_' . $category . '_' . time() . '_' . Str::random(10) . '.jpg';
                        $path = 'rectifier_images/' . $filename;

                        // Simpan gambar yang sudah dikompresi
                        Storage::disk('public')->put($path, $compressedImage);

                        // Log ukuran file
                        $sizeKB = strlen($compressedImage) / 1024;
                        Log::info("Uploaded image saved: {$path} ({$sizeKB}KB)");

                        $images[] = [
                            'category' => $category,
                            'path' => $path,
                        ];
                    } catch (\Exception $e) {
                        Log::error('Error uploading file: ' . $e->getMessage());
                    }
                }
            }
        }

        // Handle camera photos dengan kompresi
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
            'battery_voltage',
            'env_condition',
            'led_display',
            'battery_connection',
            'rectifier_module',
            'alarm_modul',
            'battery_voltage_m1',
            'battery_voltage_m2'
        ];

        foreach ($cameraCategories as $category) {
            $cameraKey = 'camera_photos_' . $category;

            if ($request->has($cameraKey) && !empty($request->$cameraKey)) {
                $photosJson = $request->$cameraKey;

                if ($photosJson === '[]') {
                    continue;
                }

                try {
                    $photos = json_decode($photosJson, true);

                    if (is_array($photos) && count($photos) > 0) {
                        foreach ($photos as $photo) {
                            if (isset($photo['image'])) {
                                $savedPath = $this->saveBase64ImageCompressed($photo['image'], $category);

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
                } catch (\Exception $e) {
                    Log::error("Error processing camera photos for {$category}: " . $e->getMessage());
                }
            }
        }

        return $images;
    }

    /**
     * Save base64 encoded image with compression
     */
    private function saveBase64ImageCompressed($base64Image, $category)
    {
        try {
            // Validasi format base64
            if (!preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                Log::error('Invalid base64 image format');
                return null;
            }

            // Decode base64
            $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                Log::error('Failed to decode base64 image');
                return null;
            }

            // Log ukuran sebelum kompresi
            $originalSizeKB = strlen($imageData) / 1024;
            Log::info("Original camera image size: {$originalSizeKB}KB");

            // Kompresi gambar
            $compressedImage = $this->compressImage($imageData, $this->maxImageSizeKB);

            // Log ukuran setelah kompresi
            $compressedSizeKB = strlen($compressedImage) / 1024;
            $savedPercent = round((1 - $compressedSizeKB / $originalSizeKB) * 100, 1);
            Log::info("Compressed camera image size: {$compressedSizeKB}KB (saved {$savedPercent}%)");

            // Generate filename (selalu .jpg karena hasil kompresi)
            $filename = 'rectifier_' . $category . '_' . time() . '_' . Str::random(10) . '.jpg';
            $path = 'rectifier_images/' . $filename;

            // Simpan ke storage
            Storage::disk('public')->put($path, $compressedImage);

            return $path;
        } catch (\Exception $e) {
            Log::error('Error saving base64 image: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Debug endpoint to check images data
     */
    public function debugImages($id)
    {
        $maintenance = RectifierMaintenance::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

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
                        'size_kb' => file_exists($fullPath) ? round(filesize($fullPath) / 1024, 2) : 0,
                        'mime' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                        'category' => is_array($image) ? ($image['category'] ?? 'unknown') : 'unknown',
                        'has_gps' => is_array($image) && isset($image['lat']) && isset($image['lng']),
                        'gps_data' => is_array($image) ? [
                            'lat' => $image['lat'] ?? null,
                            'lng' => $image['lng'] ?? null,
                            'address' => $image['address'] ?? null,
                            'timestamp' => $image['timestamp'] ?? null
                        ] : null
                    ];
                }
            }
        }

        return response()->json($debug);
    }
}

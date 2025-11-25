<?php

namespace App\Http\Controllers;

use App\Models\BatteryMaintenance;
use App\Models\BatteryReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class BatteryController extends Controller
{
    private $maxImageSizeKB = 1024; // 1MB = 1024KB
    private $maxImageSizeBytes;

    public function __construct()
    {
        $this->maxImageSizeBytes = $this->maxImageSizeKB * 1024;
    }

    /**
     * Display a listing of the resource with filtering
     */
    public function index(Request $request)
    {
        $query = BatteryMaintenance::query();

        // FILTER BY USER_ID
        $query->where('user_id', auth()->id());

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('maintenance_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('maintenance_date', '<=', $request->date_to);
        }

        $maintenances = $query->with('readings')
            ->orderBy('maintenance_date', 'desc')
            ->paginate(10);

        // Ambil data central untuk filter
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');

        return view('battery.index', compact('maintenances', 'centralsByArea'));
    }

    public function create()
    {
        // Ambil data central dari database, urutkan berdasarkan area dan nama
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        // Group by area untuk tampilan yang lebih rapi
        $centralsByArea = $centrals->groupBy('area');

        return view('battery.create', compact('centralsByArea'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'location' => 'required|string|exists:central,id',
                'maintenance_date' => 'required|date',
                'battery_temperature' => 'nullable|numeric',
                'company' => 'nullable|string|max:255',
                'notes' => 'nullable|string',

                // Validasi Pelaksana
                'technician_1_name' => 'required|string|max:255',
                'technician_1_company' => 'required|string|max:255',
                'technician_2_name' => 'nullable|string|max:255',
                'technician_2_company' => 'nullable|string|max:255',
                'technician_3_name' => 'nullable|string|max:255',
                'technician_3_company' => 'nullable|string|max:255',

                // Validasi Supervisor
                'supervisor' => 'nullable|string|max:255',
                'supervisor_id' => 'nullable|string|max:100',

                // Validasi Readings
                'readings' => 'required|array|min:1',
                'readings.*.bank_number' => 'required|integer|min:1',
                'readings.*.battery_brand' => 'required|string|max:255',
                'readings.*.battery_number' => 'required|integer|min:1',
                'readings.*.voltage' => 'required|numeric|min:0|max:65|regex:/^\d+(\.\d{1,2})?$/',
                'readings.*.photo_data' => 'nullable|string',
                'readings.*.photo_latitude' => 'nullable|numeric',
                'readings.*.photo_longitude' => 'nullable|numeric',
                'readings.*.photo_timestamp' => 'nullable|date',
            ]);

            DB::beginTransaction();

            $lastMaintenance = BatteryMaintenance::latest('id')->first();
            $nextNumber = $lastMaintenance ? $lastMaintenance->id + 1 : 1;
            $docNumber = 'FM-LAP-D2-SOP-003-013-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $maintenance = BatteryMaintenance::create([
                'location' => $validated['location'],
                'maintenance_date' => $validated['maintenance_date'],
                'battery_temperature' => $validated['battery_temperature'] ?? null,
                'company' => $validated['company'] ?? 'PT. Aplikarusa Lintasarta',
                'notes' => $validated['notes'] ?? null,
                'doc_number' => $docNumber,
                'user_id' => Auth::id(),
                'technician_name' => $validated['technician_1_name'],
                'technician_1_name' => $validated['technician_1_name'],
                'technician_1_company' => $validated['technician_1_company'],
                'technician_2_name' => $validated['technician_2_name'] ?? null,
                'technician_2_company' => $validated['technician_2_company'] ?? null,
                'technician_3_name' => $validated['technician_3_name'] ?? null,
                'technician_3_company' => $validated['technician_3_company'] ?? null,
                'supervisor' => $validated['supervisor'] ?? null,
                'supervisor_id' => $validated['supervisor_id'] ?? null,
            ]);

            foreach ($validated['readings'] as $reading) {
                $readingData = [
                    'battery_maintenance_id' => $maintenance->id,
                    'bank_number' => $reading['bank_number'],
                    'battery_brand' => $reading['battery_brand'],
                    'battery_number' => $reading['battery_number'],
                    'voltage' => $reading['voltage'],
                ];

                if (!empty($reading['photo_data'])) {
                    $savedPath = $this->saveBase64ImageCompressed(
                        $reading['photo_data'],
                        $maintenance->id,
                        $reading['bank_number'],
                        $reading['battery_number']
                    );

                    if ($savedPath) {
                        $readingData['photo_path'] = $savedPath;
                        $readingData['photo_latitude'] = $reading['photo_latitude'] ?? null;
                        $readingData['photo_longitude'] = $reading['photo_longitude'] ?? null;
                        $readingData['photo_timestamp'] = $reading['photo_timestamp'] ?? null;
                    }
                }

                BatteryReading::create($readingData);
            }

            DB::commit();

            return redirect()->route('battery.index')
                ->with('success', 'Data Preventive Maintenance Battery berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving battery maintenance: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        // ✅ LOAD RELASI CENTRAL
        $maintenance = BatteryMaintenance::with([
            'central',
            'readings' => function ($query) {
                $query->orderBy('bank_number')->orderBy('battery_number');
            },
            'user'
        ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('battery.show', compact('maintenance'));
    }

    public function edit(string $id)
    {

        $maintenance = BatteryMaintenance::with(['central', 'readings'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');

        return view('battery.edit', compact('maintenance', 'centralsByArea'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'location' => 'required|string|exists:central,id',
                'maintenance_date' => 'required|date',
                'battery_temperature' => 'nullable|numeric',
                'company' => 'nullable|string|max:255',
                'battery_brand' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'technician_1_name' => 'required|string|max:255',
                'technician_1_company' => 'required|string|max:255',
                'technician_2_name' => 'nullable|string|max:255',
                'technician_2_company' => 'nullable|string|max:255',
                'technician_3_name' => 'nullable|string|max:255',
                'technician_3_company' => 'nullable|string|max:255',
                'supervisor' => 'nullable|string|max:255',
                'supervisor_id' => 'nullable|string|max:100',
                'readings' => 'required|array|min:1',
                'readings.*.id' => 'nullable|integer|exists:battery_readings,id',
                'readings.*.bank_number' => 'required|integer|min:1',
                'readings.*.battery_number' => 'required|integer|min:1',
                'readings.*.voltage' => 'required|numeric|min:0|max:65|regex:/^\d+(\.\d{1,2})?$/',
                'readings.*.battery_brand' => 'required|string|max:255',
                'readings.*.photo_data' => 'nullable|string',
                'readings.*.photo_latitude' => 'nullable|numeric',
                'readings.*.photo_longitude' => 'nullable|numeric',
                'readings.*.photo_timestamp' => 'nullable|date',
                'readings.*.keep_photo' => 'nullable|in:0,1',
            ]);

            DB::beginTransaction();

            $maintenance = BatteryMaintenance::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $maintenance->update([
                'location' => $validated['location'],
                'maintenance_date' => $validated['maintenance_date'],
                'battery_temperature' => $validated['battery_temperature'] ?? null,
                'company' => $validated['company'] ?? 'PT. Aplikarusa Lintasarta',
                'notes' => $validated['notes'] ?? null,
                'technician_1_name' => $validated['technician_1_name'],
                'technician_1_company' => $validated['technician_1_company'],
                'technician_2_name' => $validated['technician_2_name'] ?? null,
                'technician_2_company' => $validated['technician_2_company'] ?? null,
                'technician_3_name' => $validated['technician_3_name'] ?? null,
                'technician_3_company' => $validated['technician_3_company'] ?? null,
                'supervisor' => $validated['supervisor'] ?? null,
                'supervisor_id' => $validated['supervisor_id'] ?? null,
                'technician_name' => $validated['technician_1_name'],
            ]);

            $keptReadingIds = [];

            foreach ($validated['readings'] as $index => $readingData) {
                if (isset($readingData['id']) && !empty($readingData['id'])) {
                    $reading = BatteryReading::find($readingData['id']);

                    if ($reading && $reading->battery_maintenance_id == $maintenance->id) {
                        $keptReadingIds[] = $reading->id;

                        $updateData = [
                            'bank_number' => $readingData['bank_number'],
                            'battery_number' => $readingData['battery_number'],
                            'voltage' => $readingData['voltage'],
                            'battery_brand' => $readingData['battery_brand'],
                        ];

                        $shouldKeepPhoto = isset($readingData['keep_photo']) &&
                            $readingData['keep_photo'] == '1' &&
                            empty($readingData['photo_data']);

                        if ($shouldKeepPhoto) {
                            $reading->update($updateData);
                        } else if (!empty($readingData['photo_data'])) {
                            if ($reading->photo_path && Storage::disk('public')->exists($reading->photo_path)) {
                                Storage::disk('public')->delete($reading->photo_path);
                            }

                            $savedPath = $this->saveBase64ImageCompressed(
                                $readingData['photo_data'],
                                $maintenance->id,
                                $readingData['bank_number'],
                                $readingData['battery_number']
                            );

                            if ($savedPath) {
                                $updateData['photo_path'] = $savedPath;
                                $updateData['photo_latitude'] = $readingData['photo_latitude'] ?? null;
                                $updateData['photo_longitude'] = $readingData['photo_longitude'] ?? null;
                                $updateData['photo_timestamp'] = $readingData['photo_timestamp'] ?? null;
                            }

                            $reading->update($updateData);
                        } else if (isset($readingData['keep_photo']) && $readingData['keep_photo'] == '0') {
                            if ($reading->photo_path && Storage::disk('public')->exists($reading->photo_path)) {
                                Storage::disk('public')->delete($reading->photo_path);
                            }

                            $updateData['photo_path'] = null;
                            $updateData['photo_latitude'] = null;
                            $updateData['photo_longitude'] = null;
                            $updateData['photo_timestamp'] = null;

                            $reading->update($updateData);
                        } else {
                            $reading->update($updateData);
                        }
                    }
                } else {
                    $newReadingData = [
                        'battery_maintenance_id' => $maintenance->id,
                        'bank_number' => $readingData['bank_number'],
                        'battery_number' => $readingData['battery_number'],
                        'voltage' => $readingData['voltage'],
                        'battery_brand' => $readingData['battery_brand'],
                    ];

                    if (!empty($readingData['photo_data'])) {
                        $savedPath = $this->saveBase64ImageCompressed(
                            $readingData['photo_data'],
                            $maintenance->id,
                            $readingData['bank_number'],
                            $readingData['battery_number']
                        );

                        if ($savedPath) {
                            $newReadingData['photo_path'] = $savedPath;
                            $newReadingData['photo_latitude'] = $readingData['photo_latitude'] ?? null;
                            $newReadingData['photo_longitude'] = $readingData['photo_longitude'] ?? null;
                            $newReadingData['photo_timestamp'] = $readingData['photo_timestamp'] ?? null;
                        }
                    }

                    $newReading = BatteryReading::create($newReadingData);
                    $keptReadingIds[] = $newReading->id;
                }
            }

            $deletedReadings = BatteryReading::where('battery_maintenance_id', $maintenance->id)
                ->whereNotIn('id', $keptReadingIds)
                ->get();

            foreach ($deletedReadings as $deletedReading) {
                if ($deletedReading->photo_path && Storage::disk('public')->exists($deletedReading->photo_path)) {
                    Storage::disk('public')->delete($deletedReading->photo_path);
                }
                $deletedReading->delete();
            }

            DB::commit();

            return redirect()->route('battery.index')
                ->with('success', 'Data Preventive Maintenance Battery berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating battery maintenance: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $maintenance = BatteryMaintenance::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            foreach ($maintenance->readings as $reading) {
                if ($reading->photo_path && Storage::disk('public')->exists($reading->photo_path)) {
                    Storage::disk('public')->delete($reading->photo_path);
                }
            }

            $maintenance->delete();

            return redirect()->route('battery.index')
                ->with('success', 'Data battery maintenance berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function pdf(string $id)
    {
        // ✅ LOAD RELASI CENTRAL
        $maintenance = BatteryMaintenance::with([
            'central',
            'readings' => function ($query) {
                $query->orderBy('bank_number')->orderBy('battery_number');
            },
            'user'
        ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('battery.pdf', compact('maintenance'))
            ->setPaper('a4', 'portrait');

        $formattedDate = date('Y-m-d', strtotime($maintenance->maintenance_date));
        $locationName = $maintenance->central ? $maintenance->central->nama : 'Unknown';
        $filename = 'Battery-Maintenance-' . $locationName . '-' . $formattedDate . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Compress image to target size (max 1MB) using native GD
     */
    private function compressImage($imageData, $maxSizeKB = 1024)
    {
        try {
            $image = imagecreatefromstring($imageData);

            if ($image === false) {
                Log::error('Failed to create image from string');
                return $imageData;
            }

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
            Log::info("Battery image compressed to {$finalSizeKB}KB with quality {$quality}%");

            return $compressed;

        } catch (\Exception $e) {
            Log::error('Image compression error: ' . $e->getMessage());
            return $imageData;
        }
    }

    /**
     * Save base64 image with compression
     */
    private function saveBase64ImageCompressed($base64String, $maintenanceId, $bankNumber, $batteryNumber)
    {
        try {
            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $base64String = str_replace(' ', '+', $base64String);
                $imageData = base64_decode($base64String);

                if ($imageData === false) {
                    throw new \Exception('Base64 decode failed');
                }

                // Log ukuran sebelum kompresi
                $originalSizeKB = strlen($imageData) / 1024;
                Log::info("Original battery image size: {$originalSizeKB}KB");

                // Kompresi gambar
                $compressedImage = $this->compressImage($imageData, $this->maxImageSizeKB);

                // Log ukuran setelah kompresi
                $compressedSizeKB = strlen($compressedImage) / 1024;
                $savedPercent = round((1 - $compressedSizeKB / $originalSizeKB) * 100, 1);
                Log::info("Compressed battery image size: {$compressedSizeKB}KB (saved {$savedPercent}%)");

            } else {
                throw new \Exception('Invalid image data');
            }

            // Generate unique filename (selalu .jpg karena hasil kompresi)
            $filename = 'battery_' . $maintenanceId . '_' . $bankNumber . '_' . $batteryNumber . '_' . time() . '.jpg';
            $path = 'battery_photos/' . $filename;

            // Save to storage
            Storage::disk('public')->put($path, $compressedImage);

            return $path;

        } catch (\Exception $e) {
            Log::error('Error saving battery image: ' . $e->getMessage());
            return null;
        }
    }
}

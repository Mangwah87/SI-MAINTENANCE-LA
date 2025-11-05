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
    /**
     * Display a listing of the resource with filtering
     */
    // In your BatteryController.php (or similar)

    public function index(Request $request)
    {
        $query = BatteryMaintenance::query(); // Adjust model name as needed

        // Apply filters if present
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('maintenance_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('maintenance_date', '<=', $request->date_to);
        }

        // Get paginated results with relationships
        $maintenances = $query->with('readings')
            ->orderBy('maintenance_date', 'desc')
            ->paginate(10); // Adjust per page as needed

        return view('battery.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('battery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'location' => 'required|string|max:255',
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

                // Validasi Readings
                'readings' => 'required|array|min:1',
                'readings.*.bank_number' => 'required|integer|min:1',
                'readings.*.battery_brand' => 'required|string|max:255',
                'readings.*.battery_number' => 'required|integer|min:1',
                'readings.*.voltage' => 'required|numeric|min:0|max:20',
                'readings.*.photo_data' => 'nullable|string',
                'readings.*.photo_latitude' => 'nullable|numeric',
                'readings.*.photo_longitude' => 'nullable|numeric',
                'readings.*.photo_timestamp' => 'nullable|date',
            ]);

            DB::beginTransaction();

            // Generate Document Number
            $lastMaintenance = BatteryMaintenance::latest('id')->first();
            $nextNumber = $lastMaintenance ? $lastMaintenance->id + 1 : 1;
            $docNumber = 'FM-LAP-D2-SOP-003-013-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Simpan Maintenance Data
            $maintenance = BatteryMaintenance::create([
                'location' => $validated['location'],
                'maintenance_date' => $validated['maintenance_date'],
                'battery_temperature' => $validated['battery_temperature'] ?? null,
                'company' => $validated['company'] ?? 'PT. Aplikarusa Lintasarta',
                'notes' => $validated['notes'] ?? null,
                'doc_number' => $docNumber,
                'user_id' => Auth::id(),
                'technician_name' => $validated['technician_1_name'],

                // Data Pelaksana Baru
                'technician_1_name' => $validated['technician_1_name'],
                'technician_1_company' => $validated['technician_1_company'],
                'technician_2_name' => $validated['technician_2_name'] ?? null,
                'technician_2_company' => $validated['technician_2_company'] ?? null,
                'technician_3_name' => $validated['technician_3_name'] ?? null,
                'technician_3_company' => $validated['technician_3_company'] ?? null,
            ]);

            // Simpan Readings dengan Photo
            foreach ($validated['readings'] as $reading) {
                $readingData = [
                    'battery_maintenance_id' => $maintenance->id,
                    'bank_number' => $reading['bank_number'],
                    'battery_brand' => $reading['battery_brand'],
                    'battery_number' => $reading['battery_number'],
                    'voltage' => $reading['voltage'],
                ];

                // Process Photo if exists
                if (!empty($reading['photo_data'])) {
                    $photoData = $reading['photo_data'];

                    // Remove data:image/jpeg;base64, prefix
                    if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                        $photoData = substr($photoData, strpos($photoData, ',') + 1);
                        $photoData = base64_decode($photoData);

                        // Generate filename
                        $filename = 'battery_' . $maintenance->id . '_' . $reading['bank_number'] . '_' . $reading['battery_number'] . '_' . time() . '.jpg';
                        $path = 'battery_photos/' . $filename;

                        // Save to storage
                        Storage::disk('public')->put($path, $photoData);

                        $readingData['photo_path'] = $path;
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maintenance = BatteryMaintenance::with(['readings' => function ($query) {
            $query->orderBy('bank_number')->orderBy('battery_number');
        }, 'user'])->findOrFail($id);

        return view('battery.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenance = BatteryMaintenance::with('readings')->findOrFail($id);
        return view('battery.edit', compact('maintenance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'maintenance_date' => 'required|date',
            'battery_brand' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'battery_temperature' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'technician_1_name' => 'required|string|max:255',
            'technician_1_company' => 'required|string|max:255',
            'technician_2_name' => 'nullable|string|max:255',
            'technician_2_company' => 'nullable|string|max:255',
            'technician_3_name' => 'nullable|string|max:255',
            'technician_3_company' => 'nullable|string|max:255',
            'readings' => 'required|array|min:1',
            'readings.*.bank_number' => 'required|integer|min:1',
            'readings.*.battery_number' => 'required|integer|min:1',
            'readings.*.voltage' => 'required|numeric|min:0|max:20',
            'readings.*.battery_brand' => 'required|string|max:255',
        ]);

        $battery = Battery::findOrFail($id);

        // Update main battery data
        $battery->update([
            'location' => $request->location,
            'maintenance_date' => $request->maintenance_date,
            'battery_brand' => $request->battery_brand,
            'company' => $request->company,
            'battery_temperature' => $request->battery_temperature,
            'notes' => $request->notes,
            'technician_1_name' => $request->technician_1_name,
            'technician_1_company' => $request->technician_1_company,
            'technician_2_name' => $request->technician_2_name,
            'technician_2_company' => $request->technician_2_company,
            'technician_3_name' => $request->technician_3_name,
            'technician_3_company' => $request->technician_3_company,
        ]);

        // Track which reading IDs are being kept
        $keptReadingIds = [];

        // Handle readings
        foreach ($request->readings as $index => $readingData) {
            if (isset($readingData['id']) && !empty($readingData['id'])) {
                // Update existing reading
                $reading = BatteryReading::find($readingData['id']);

                if ($reading && $reading->battery_id == $battery->id) {
                    $keptReadingIds[] = $reading->id;

                    // Check if we should keep the existing photo or replace it
                    $shouldKeepPhoto = isset($readingData['keep_photo']) &&
                        $readingData['keep_photo'] == '1' &&
                        empty($readingData['photo_data']);

                    if ($shouldKeepPhoto) {
                        // Keep existing photo - only update battery data
                        $reading->update([
                            'bank_number' => $readingData['bank_number'],
                            'battery_number' => $readingData['battery_number'],
                            'voltage' => $readingData['voltage'],
                            'battery_brand' => $readingData['battery_brand'],
                        ]);
                    } else if (!empty($readingData['photo_data'])) {
                        // Replace with new photo
                        // Delete old photo if exists
                        if ($reading->photo_path && Storage::exists('public/' . $reading->photo_path)) {
                            Storage::delete('public/' . $reading->photo_path);
                        }

                        // Save new photo
                        $photoPath = $this->saveBase64Image($readingData['photo_data']);

                        $reading->update([
                            'bank_number' => $readingData['bank_number'],
                            'battery_number' => $readingData['battery_number'],
                            'voltage' => $readingData['voltage'],
                            'battery_brand' => $readingData['battery_brand'],
                            'photo_path' => $photoPath,
                            'photo_latitude' => $readingData['photo_latitude'] ?? null,
                            'photo_longitude' => $readingData['photo_longitude'] ?? null,
                            'photo_timestamp' => $readingData['photo_timestamp'] ?? null,
                        ]);
                    } else {
                        // No photo data and not keeping photo - just update data
                        $reading->update([
                            'bank_number' => $readingData['bank_number'],
                            'battery_number' => $readingData['battery_number'],
                            'voltage' => $readingData['voltage'],
                            'battery_brand' => $readingData['battery_brand'],
                        ]);
                    }
                }
            } else {
                // Create new reading (for newly added batteries during edit)
                $newReadingData = [
                    'battery_id' => $battery->id,
                    'bank_number' => $readingData['bank_number'],
                    'battery_number' => $readingData['battery_number'],
                    'voltage' => $readingData['voltage'],
                    'battery_brand' => $readingData['battery_brand'],
                ];

                // Handle photo if exists
                if (!empty($readingData['photo_data'])) {
                    $photoPath = $this->saveBase64Image($readingData['photo_data']);
                    $newReadingData['photo_path'] = $photoPath;
                    $newReadingData['photo_latitude'] = $readingData['photo_latitude'] ?? null;
                    $newReadingData['photo_longitude'] = $readingData['photo_longitude'] ?? null;
                    $newReadingData['photo_timestamp'] = $readingData['photo_timestamp'] ?? null;
                }

                $newReading = BatteryReading::create($newReadingData);
                $keptReadingIds[] = $newReading->id;
            }
        }

        // Delete readings that were removed (not in the kept list)
        $deletedReadings = BatteryReading::where('battery_id', $battery->id)
            ->whereNotIn('id', $keptReadingIds)
            ->get();

        foreach ($deletedReadings as $deletedReading) {
            // Delete photo if exists
            if ($deletedReading->photo_path && Storage::exists('public/' . $deletedReading->photo_path)) {
                Storage::delete('public/' . $deletedReading->photo_path);
            }
            $deletedReading->delete();
        }

        return redirect()->route('battery.index')
            ->with('success', 'Data battery maintenance berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $maintenance = BatteryMaintenance::findOrFail($id);

            // Delete all photos
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

    /**
     * Generate PDF for the specified resource.
     */
    public function pdf(string $id)
    {
        $maintenance = BatteryMaintenance::with(['readings' => function ($query) {
            $query->orderBy('bank_number')->orderBy('battery_number');
        }, 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('battery.pdf', compact('maintenance'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Battery-Maintenance-' . $maintenance->doc_number . '.pdf');
    }

    /**
     * Save base64 image to storage
     */
    private function saveBase64Image($base64String)
    {
        // Extract base64 data
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            $base64String = str_replace(' ', '+', $base64String);
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                throw new \Exception('Base64 decode failed');
            }
        } else {
            throw new \Exception('Invalid image data');
        }

        // Generate unique filename
        $filename = 'battery_' . time() . '_' . uniqid() . '.' . $type;
        $path = 'battery_photos/' . $filename;

        // Save to storage
        Storage::put('public/' . $path, $imageData);

        return $path;
    }
}

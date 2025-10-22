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
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = BatteryMaintenance::with('user', 'readings')
            ->orderBy('maintenance_date', 'desc')
            ->paginate(10);

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
                'user_id' => Auth::id(), // ← TAMBAHKAN INI
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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'maintenance_date' => 'required|date',
            'battery_temperature' => 'nullable|numeric|min:-50|max:100',
        ]);

        DB::beginTransaction();
        try {
            $maintenance = BatteryMaintenance::findOrFail($id);

            // Update maintenance record
            $maintenance->update([
                'location' => $validated['location'],
                'maintenance_date' => $validated['maintenance_date'],
                'battery_temperature' => $validated['battery_temperature'],
            ]);

            DB::commit();

            return redirect()->route('battery.show', $id)
                ->with('success', 'Data battery maintenance berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal update data: ' . $e->getMessage());
        }
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

        return $pdf->download('Battery-Maintenance-' . $maintenance->doc_number . '.pdf');
    }

    /**
     * Save base64 image to storage
     */
    private function saveBase64Image($base64String, $directory, $maintenanceId)
    {
        // Remove base64 prefix
        $image = str_replace('data:image/jpeg;base64,', '', $base64String);
        $image = str_replace(' ', '+', $image);
        $imageData = base64_decode($image);

        // Generate unique filename
        $filename = $directory . '/' . $maintenanceId . '/' . uniqid() . '.jpg';

        // Save to storage
        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }
}

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

        return view('battery.index', compact('maintenances'));
    }

    public function create()
    {
        return view('battery.create');
    }

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

                // Validasi Supervisor
                'supervisor' => 'nullable|string|max:255',

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
                'user_id' => Auth::id(), // USER_ID SUDAH ADA
                'technician_name' => $validated['technician_1_name'],
                'technician_1_name' => $validated['technician_1_name'],
                'technician_1_company' => $validated['technician_1_company'],
                'technician_2_name' => $validated['technician_2_name'] ?? null,
                'technician_2_company' => $validated['technician_2_company'] ?? null,
                'technician_3_name' => $validated['technician_3_name'] ?? null,
                'technician_3_company' => $validated['technician_3_company'] ?? null,
                'supervisor' => $validated['supervisor'] ?? null,
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
                    $photoData = $reading['photo_data'];

                    if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                        $photoData = substr($photoData, strpos($photoData, ',') + 1);
                        $photoData = base64_decode($photoData);

                        $filename = 'battery_' . $maintenance->id . '_' . $reading['bank_number'] . '_' . $reading['battery_number'] . '_' . time() . '.jpg';
                        $path = 'battery_photos/' . $filename;

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

    public function show(string $id)
    {
        // CHECK USER_ID
        $maintenance = BatteryMaintenance::with(['readings' => function ($query) {
            $query->orderBy('bank_number')->orderBy('battery_number');
        }, 'user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('battery.show', compact('maintenance'));
    }

    public function edit(string $id)
    {
        // CHECK USER_ID
        $maintenance = BatteryMaintenance::with('readings')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('battery.edit', compact('maintenance'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'location' => 'required|string|max:255',
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
                'readings' => 'required|array|min:1',
                'readings.*.id' => 'nullable|integer|exists:battery_readings,id',
                'readings.*.bank_number' => 'required|integer|min:1',
                'readings.*.battery_number' => 'required|integer|min:1',
                'readings.*.voltage' => 'required|numeric|min:0|max:20',
                'readings.*.battery_brand' => 'required|string|max:255',
                'readings.*.photo_data' => 'nullable|string',
                'readings.*.photo_latitude' => 'nullable|numeric',
                'readings.*.photo_longitude' => 'nullable|numeric',
                'readings.*.photo_timestamp' => 'nullable|date',
                'readings.*.keep_photo' => 'nullable|in:0,1',
            ]);

            DB::beginTransaction();

            // CHECK USER_ID
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

                            $photoData = $readingData['photo_data'];
                            if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                                $photoData = substr($photoData, strpos($photoData, ',') + 1);
                                $photoData = base64_decode($photoData);

                                $filename = 'battery_' . $maintenance->id . '_' . $readingData['bank_number'] . '_' . $readingData['battery_number'] . '_' . time() . '.jpg';
                                $path = 'battery_photos/' . $filename;

                                Storage::disk('public')->put($path, $photoData);

                                $updateData['photo_path'] = $path;
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
                        $photoData = $readingData['photo_data'];

                        if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                            $photoData = substr($photoData, strpos($photoData, ',') + 1);
                            $photoData = base64_decode($photoData);

                            $filename = 'battery_' . $maintenance->id . '_' . $readingData['bank_number'] . '_' . $readingData['battery_number'] . '_' . time() . '.jpg';
                            $path = 'battery_photos/' . $filename;

                            Storage::disk('public')->put($path, $photoData);

                            $newReadingData['photo_path'] = $path;
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
            // CHECK USER_ID
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
        // CHECK USER_ID
        $maintenance = BatteryMaintenance::with(['readings' => function ($query) {
            $query->orderBy('bank_number')->orderBy('battery_number');
        }, 'user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('battery.pdf', compact('maintenance'))
            ->setPaper('a4', 'portrait');

        // Format nama file dengan maintenance_date
        $formattedDate = date('Y-m-d', strtotime($maintenance->maintenance_date));
        $filename = 'Battery-Maintenance-' . $maintenance->location . '-' . $formattedDate . '.pdf';

        return $pdf->stream($filename);
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

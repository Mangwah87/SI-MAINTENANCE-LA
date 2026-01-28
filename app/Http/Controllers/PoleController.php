<?php

namespace App\Http\Controllers;

use App\Models\Pole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PoleController extends Controller
{
    public function index()
    {
        $poles = Pole::with(['user', 'central'])
            ->where('user_id', auth()->id())
            ->latest('date')
            ->paginate(10);

        $stats = [
            'this_month' => Pole::where('user_id', auth()->id())
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
        ];

        return view('pole.index', compact('poles', 'stats'));
    }

    public function create()
    {
        $centrals = \App\Models\Central::orderBy('area')->orderBy('id_sentral')->get();
        return view('pole.create', compact('centrals'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'central_id' => 'required|exists:central,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'type_pole' => 'required|string',

                // Physical Check
                'foundation_condition' => 'nullable|string',
                'status_foundation_condition' => 'nullable|string',
                'pole_tower_foundation_flange' => 'nullable|string',
                'status_pole_tower_foundation_flange' => 'nullable|string',
                'pole_tower_support_flange' => 'nullable|string',
                'status_pole_tower_support_flange' => 'nullable|string',
                'flange_condition_connection' => 'nullable|string',
                'status_flange_condition_connection' => 'nullable|string',
                'pole_tower_condition' => 'nullable|string',
                'status_pole_tower_condition' => 'nullable|string',
                'arm_antenna_condition' => 'nullable|string',
                'status_arm_antenna_condition' => 'nullable|string',
                'availability_basbar_ground' => 'nullable|string',
                'status_availability_basbar_ground' => 'nullable|string',
                'bonding_bar' => 'nullable|string',
                'status_bonding_bar' => 'nullable|string',

                // Performance Measurement
                'inclination_measurement' => 'nullable|string',
                'status_inclination_measurement' => 'nullable|string',

                // Personnel
                'executor_1' => 'nullable|string',
                'mitra_internal_1' => 'nullable|string',
                'executor_2' => 'nullable|string',
                'mitra_internal_2' => 'nullable|string',
                'executor_3' => 'nullable|string',
                'mitra_internal_3' => 'nullable|string',
                'executor_4' => 'nullable|string',
                'mitra_internal_4' => 'nullable|string',
                'verifikator' => 'nullable|string',
                'verifikator_nik' => 'nullable|string',
                'head_of_sub_department' => 'nullable|string',
                'head_of_sub_department_nik' => 'nullable|string',

                'notes' => 'nullable|string',
            ]);

            $validated['user_id'] = auth()->id();

            // Handle image uploads
            $images = $this->handleImageUploads($request);
            if (!empty($images)) {
                $validated['images'] = $images;
            }

            $pole = Pole::create($validated);

            return redirect()->route('pole.show', $pole->id)
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error storing pole: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pole = Pole::with('central')->findOrFail($id);
        return view('pole.show', compact('pole'));
    }

    public function edit($id)
    {
        $pole = Pole::findOrFail($id);
        $centrals = \App\Models\Central::orderBy('area')->orderBy('id_sentral')->get();
        return view('pole.edit', compact('pole', 'centrals'));
    }

    public function update(Request $request, $id)
    {
        try {
            $pole = Pole::findOrFail($id);

            $validated = $request->validate([
                'central_id' => 'required|exists:central,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'type_pole' => 'required|string',

                // Physical Check
                'foundation_condition' => 'nullable|string',
                'status_foundation_condition' => 'nullable|string',
                'pole_tower_foundation_flange' => 'nullable|string',
                'status_pole_tower_foundation_flange' => 'nullable|string',
                'pole_tower_support_flange' => 'nullable|string',
                'status_pole_tower_support_flange' => 'nullable|string',
                'flange_condition_connection' => 'nullable|string',
                'status_flange_condition_connection' => 'nullable|string',
                'pole_tower_condition' => 'nullable|string',
                'status_pole_tower_condition' => 'nullable|string',
                'arm_antenna_condition' => 'nullable|string',
                'status_arm_antenna_condition' => 'nullable|string',
                'availability_basbar_ground' => 'nullable|string',
                'status_availability_basbar_ground' => 'nullable|string',
                'bonding_bar' => 'nullable|string',
                'status_bonding_bar' => 'nullable|string',

                // Performance Measurement
                'inclination_measurement' => 'nullable|string',
                'status_inclination_measurement' => 'nullable|string',

                // Personnel
                'executor_1' => 'nullable|string',
                'mitra_internal_1' => 'nullable|string',
                'executor_2' => 'nullable|string',
                'mitra_internal_2' => 'nullable|string',
                'executor_3' => 'nullable|string',
                'mitra_internal_3' => 'nullable|string',
                'executor_4' => 'nullable|string',
                'mitra_internal_4' => 'nullable|string',
                'verifikator' => 'nullable|string',
                'verifikator_nik' => 'nullable|string',
                'head_of_sub_department' => 'nullable|string',
                'head_of_sub_department_nik' => 'nullable|string',

                'notes' => 'nullable|string',
            ]);

            // Handle image uploads
            $images = $this->handleImageUploads($request);
            if (!empty($images)) {
                $validated['images'] = $images;
            }

            $pole->update($validated);

            return redirect()->route('pole.show', $pole->id)
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            Log::error('Error updating pole: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pole = Pole::findOrFail($id);

            // Delete associated images from storage
            if ($pole->images && is_array($pole->images)) {
                foreach ($pole->images as $field => $paths) {
                    if (is_array($paths)) {
                        foreach ($paths as $path) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                }
            }

            $pole->forceDelete(); // Hard delete - hapus permanen dari database

            return redirect()->route('pole.index')
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting pole: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pdf($id)
    {
        $pole = Pole::with('central')->findOrFail($id);

        $pdf = Pdf::loadView('pole.pdf', compact('pole'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('pole-' . $pole->id . '.pdf');
    }

    /**
     * Handle image uploads from base64 data
     */
    private function handleImageUploads(Request $request)
    {
        $allImages = [];

        // List of all image fields
        $imageFields = [
            'physical_check_foundation_condition',
            'physical_check_foundation_flange',
            'physical_check_support_flange',
            'physical_check_connection_flange',
            'physical_check_pole_tower_condition',
            'physical_check_arm_antenna',
            'physical_check_basbar_ground',
            'physical_check_bonding_bar',
            'performance_inclination',
        ];

        foreach ($imageFields as $field) {
            if ($request->has($field)) {
                $base64Images = json_decode($request->input($field), true);

                if (is_array($base64Images) && !empty($base64Images)) {
                    $uploadedPaths = [];

                    foreach ($base64Images as $index => $base64Data) {
                        // Skip if not valid base64
                        if (!str_starts_with($base64Data, 'data:image')) {
                            continue;
                        }

                        try {
                            // Extract base64 data
                            preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches);
                            $imageType = $matches[1] ?? 'jpeg';
                            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                            $imageData = base64_decode($base64Data);

                            // Generate unique filename
                            $filename = 'pole_' . time() . '_' . uniqid() . '_' . $index . '.' . $imageType;
                            $path = 'poles/' . $filename;

                            // Store image
                            Storage::disk('public')->put($path, $imageData);

                            $uploadedPaths[] = $path;
                        } catch (\Exception $e) {
                            Log::error('Error saving image: ' . $e->getMessage());
                        }
                    }

                    if (!empty($uploadedPaths)) {
                        $allImages[$field] = $uploadedPaths;
                    }
                }
            }
        }

        return $allImages;
    }
}

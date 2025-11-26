<?php

namespace App\Http\Controllers;

use App\Models\GensetMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class GensetController extends Controller
{
    public function index()
    {
        $maintenances = GensetMaintenance::with('user')
            ->where('user_id', auth()->id())
            ->latest('maintenance_date')
            ->paginate(10);



        return view('genset.index', compact('maintenances'));
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

        return view('genset.create', compact('centralsByArea'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRequest($request);

            // Logika Pemrosesan Gambar
            $imagesData = $request->input('images', []);
            $savedImages = [];

            if (!empty($imagesData) && is_array($imagesData)) {
                foreach ($imagesData as $imgJson) {
                    try {
                        $imgInfo = json_decode($imgJson, true);
                        if ($imgInfo && isset($imgInfo['data']) && preg_match('/^data:image/', $imgInfo['data'])) {
                            $saved = $this->saveBase64Image($imgInfo['data']);
                            if ($saved) {
                                $savedImages[] = [
                                    'path' => $saved,
                                    'category' => $imgInfo['category'] ?? 'unknown',
                                    'timestamp' => $imgInfo['timestamp'] ?? now()->toISOString(),
                                    'latitude' => $imgInfo['latitude'] ?? null,
                                    'longitude' => $imgInfo['longitude'] ?? null,
                                    'locationName' => $imgInfo['locationName'] ?? null,
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Error processing image: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            $validatedData['images'] = !empty($savedImages) ? $savedImages : null;

            // Buat Nomor Dokumen
            $date = Carbon::parse($validatedData['maintenance_date']);
            $location = strtoupper(substr(str_replace(' ', '', $validatedData['location']), 0, 5));
            $validatedData['doc_number'] = sprintf(
                'FM-LAP/%s/%s/%s/%s',
                $location,
                'GENSET',
                $date->format('Y'),
                GensetMaintenance::whereYear('maintenance_date', $date->year)->count() + 1
            );

            $validatedData['user_id'] = auth()->id();

            $maintenance = GensetMaintenance::create($validatedData);
            Log::info('Genset Maintenance Created:', ['id' => $maintenance->id, 'images_count' => count($savedImages)]);
            return redirect()->route('genset.index')->with('success', 'Data maintenance genset berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            Log::error('Error storing genset maintenance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $maintenance = GensetMaintenance::where('user_id', auth()->id())
                ->findOrFail($id);
            $validatedData = $this->validateRequest($request);

            // 1. Ambil gambar yang ada di DB
            $existingImages = $maintenance->images ?? [];
            if (!is_array($existingImages))
                $existingImages = [];

            // 2. Hapus gambar yang ditandai untuk dihapus
            $imagesToDelete = $request->input('delete_images', []);
            if (!empty($imagesToDelete) && is_array($imagesToDelete)) {
                $existingImages = array_filter($existingImages, function ($img) use ($imagesToDelete) {
                    if (isset($img['path']) && in_array($img['path'], $imagesToDelete)) {
                        if (Storage::disk('public')->exists($img['path'])) {
                            Storage::disk('public')->delete($img['path']);
                            Log::info("Deleted image: " . $img['path']);
                        }
                        return false; // Hapus dari array
                    }
                    return true; // Simpan di array
                });
                $existingImages = array_values($existingImages); // Re-index
            }

            // 3. Proses gambar baru (base64)
            $newImagesData = $request->input('images', []);
            $newSavedImages = [];

            if (!empty($newImagesData) && is_array($newImagesData)) {
                foreach ($newImagesData as $imgJson) {
                    $imgInfo = json_decode($imgJson, true);

                    // Hanya proses jika ini data base64 baru
                    if ($imgInfo && isset($imgInfo['data']) && preg_match('/^data:image/', $imgInfo['data'])) {
                        $savedPath = $this->saveBase64Image($imgInfo['data']);
                        if ($savedPath) {
                            $category = $imgInfo['category'] ?? 'unknown';

                            // Hapus file lama dari kategori yang sama
                            foreach ($existingImages as $index => $existingImg) {
                                if (isset($existingImg['category']) && $existingImg['category'] === $category) {
                                    if (Storage::disk('public')->exists($existingImg['path'])) {
                                        Storage::disk('public')->delete($existingImg['path']);
                                        Log::info("Replaced image: " . $existingImg['path']);
                                    }
                                    // Hapus dari array $existingImages
                                    unset($existingImages[$index]);
                                }
                            }

                            // Tambahkan gambar baru
                            $newSavedImages[] = [
                                'path' => $savedPath,
                                'category' => $category,
                                'timestamp' => $imgInfo['timestamp'] ?? now()->toISOString(),
                                'latitude' => $imgInfo['latitude'] ?? null,
                                'longitude' => $imgInfo['longitude'] ?? null,
                                'locationName' => $imgInfo['locationName'] ?? null,
                            ];
                        }
                    }
                }
            }

            // 4. Gabungkan gambar lama (yang tersisa) dengan gambar baru
            $validatedData['images'] = array_merge(array_values($existingImages), $newSavedImages);
            if (empty($validatedData['images'])) {
                $validatedData['images'] = null;
            }

            // 5. Update data
            $maintenance->update($validatedData);

            return redirect()->route('genset.index')->with('success', 'Data maintenance genset berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal.');
        } catch (\Exception $e) {
            Log::error('Error updating genset maintenance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $maintenance = GensetMaintenance::where('user_id', auth()->id())
                ->findOrFail($id);

            // Hapus semua gambar terkait dari storage
            if ($maintenance->images && is_array($maintenance->images)) {
                foreach ($maintenance->images as $img) {
                    if (isset($img['path']) && Storage::disk('public')->exists($img['path'])) {
                        Storage::disk('public')->delete($img['path']);
                    }
                }
            }

            // Hapus record dari database
            $maintenance->delete();

            return redirect()->route('genset.index')->with('success', 'Data maintenance genset berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting genset maintenance: ' . $e->getMessage());
            return redirect()->route('genset.index')->with('error', 'Gagal menghapus data.');
        }
    }

    public function show($id)
    {
        $maintenance = GensetMaintenance::where('user_id', auth()->id())
            ->findOrFail($id);
        return view('genset.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = GensetMaintenance::where('user_id', auth()->id())
            ->findOrFail($id);

        // Ambil data central untuk dropdown
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        $centralsByArea = $centrals->groupBy('area');

        return view('genset.edit', compact('maintenance', 'centralsByArea'));
    }

    public function pdf($id)
    {
        $maintenance = GensetMaintenance::findOrFail($id);

        $pdf = PDF::loadView('genset.pdf_template', compact('maintenance'));
        $pdf->setPaper('letter', 'portrait');

        $safeDocNumber = str_replace('/', '-', $maintenance->doc_number);
        $fileName = 'genset-maintenance-' . $safeDocNumber . '.pdf';

        return $pdf->stream($fileName);
    }

    // --- Helper Methods ---

    private function validateRequest(Request $request)
    {
        $rules = [
            'location' => 'required|string|max:255',
            'maintenance_date' => 'required|date',
            'brand_type' => 'nullable|string',
            'capacity' => 'nullable|string',
            'notes' => 'nullable|string',
            'technician_1_name' => 'required|string',
            'technician_1_department' => 'nullable|string',
            'technician_2_name' => 'nullable|string',
            'technician_2_department' => 'nullable|string',
            'technician_3_name' => 'nullable|string',
            'technician_3_department' => 'nullable|string',
            'approver_name' => 'nullable|string',
            'approver_department' => 'nullable|string',
            'approver_nik' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|json',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|string',
        ];

        // Tambahkan aturan untuk semua field dinamis
        $dynamicKeys = array_keys($request->except('_token', '_method', 'images', 'delete_images'));
        foreach ($dynamicKeys as $key) {
            if (!isset($rules[$key])) {
                $rules[$key] = 'nullable|string|max:255';
            }
        }

        return $request->validate($rules);
    }

    private function saveBase64Image($imageData)
    {
        if (empty($imageData))
            return null;
        if (!preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            Log::error('Invalid image format');
            return null;
        }

        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]);
        if (!in_array($type, ['jpg', 'jpeg', 'png']))
            $type = 'jpg';

        $decodedImage = base64_decode($imageData);
        if ($decodedImage === false) {
            Log::error('Failed to decode base64');
            return null;
        }

        $directory = 'genset_images/' . date('Y/m/d');
        $filename = uniqid('genset_', true) . '.' . $type;
        $path = $directory . '/' . $filename;

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory, 0755, true);
        }

        if (Storage::disk('public')->put($path, $decodedImage)) {
            Log::info('Image saved successfully: ' . $path);
            return $path;
        }

        Log::error('Failed to save image');
        return null;
    }
}

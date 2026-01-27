<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InverterController extends Controller
{
    /**
     * Menampilkan daftar inverter dengan fitur search.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $inverter = Inverter::query()
            ->with('user')
            ->where('user_id', Auth::id())
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    // Pencarian untuk field text standar
                    $q->where('nomor_dokumen', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%")
                      ->orWhere('perusahaan', 'like', "%{$search}%")
                      ->orWhere('reg_num', 'like', "%{$search}%")
                      ->orWhere('serial_num', 'like', "%{$search}%")
                      ->orWhere('boss', 'like', "%{$search}%");

                    // Pencarian berdasarkan tanggal (format: dd/mm/yyyy atau yyyy-mm-dd)
                    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $search)) {
                        // Format: dd/mm/yyyy
                        $dateParts = explode('/', $search);
                        if (count($dateParts) == 3) {
                            $formattedDate = $dateParts[2] . '-' . str_pad($dateParts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($dateParts[0], 2, '0', STR_PAD_LEFT);
                            $q->orWhereDate('tanggal_dokumentasi', $formattedDate);
                        }
                    } elseif (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $search)) {
                        // Format: yyyy-mm-dd
                        $q->orWhereDate('tanggal_dokumentasi', $search);
                    }

                    // Pencarian berdasarkan waktu (format: HH:mm)
                    if (preg_match('/^\d{1,2}:\d{2}$/', $search)) {
                        $q->orWhereTime('tanggal_dokumentasi', 'like', "%{$search}%");
                    }

                    // Pencarian dalam JSON field 'pelaksana' (nama dan perusahaan)
                    $q->orWhereRaw("JSON_SEARCH(pelaksana, 'one', ?) IS NOT NULL", ["%{$search}%"]);

                    // Pencarian untuk field numeric (jika input adalah angka)
                    if (is_numeric($search)) {
                        $q->orWhere('dc_input_voltage', 'like', "%{$search}%")
                          ->orWhere('dc_current_input', 'like', "%{$search}%")
                          ->orWhere('ac_current_output', 'like', "%{$search}%")
                          ->orWhere('ac_output_voltage', 'like', "%{$search}%")
                          ->orWhere('equipment_temperature', 'like', "%{$search}%");
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('inverter.index', compact('inverter'));
    }

    /**
     * Form tambah data inverter baru.
     */
    public function create()
    {
        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        // Group by area untuk tampilan yang lebih rapi
        $centralsByArea = $centrals->groupBy('area');
        return view('inverter.create', compact('centralsByArea'));
    }

    /**
     * Simpan data inverter baru.
     */
    public function store(Request $request)
    {
        // Debug: Lihat data yang dikirim
        // dd($request->all());

        // --- VALIDASI ---
        $validated = $request->validate([
            // Info Umum
            'nomor_dokumen' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_dokumentasi' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'reg_num' => 'nullable|string|max:255',
            'serial_num' => 'nullable|string|max:255',

            // Performance Terukur
            'dc_input_voltage' => 'nullable|numeric',
            'dc_current_input' => 'nullable|numeric',
            'ac_current_output' => 'nullable|numeric',
            'ac_output_voltage' => 'nullable|numeric',
            'equipment_temperature' => 'nullable|numeric',

            // Personnel
            'executor_1' => 'nullable|string|max:255',
            'mitra_internal_1' => 'nullable|in:Mitra,Internal',
            'executor_2' => 'nullable|string|max:255',
            'mitra_internal_2' => 'nullable|in:Mitra,Internal',
            'executor_3' => 'nullable|string|max:255',
            'mitra_internal_3' => 'nullable|in:Mitra,Internal',
            'executor_4' => 'nullable|string|max:255',
            'mitra_internal_4' => 'nullable|in:Mitra,Internal',
            'verifikator' => 'nullable|string|max:255',
            'verifikator_nik' => 'nullable|string|max:50',
            'head_of_sub_department' => 'nullable|string|max:255',
            'head_of_sub_department_nik' => 'nullable|string|max:50',

            // Data Checklist
            'data_inverter' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // --- Proses Data Checklist & Foto ---
            $inverterProcessed = [];
            if ($request->has('data_inverter')) {
                foreach ($request->data_inverter as $index => $item) {
                    $photos = [];

                    // Proses array foto jika ada
                    if (isset($item['photos']) && is_array($item['photos'])) {
                        foreach ($item['photos'] as $photoIndex => $photo) {
                            if (!empty($photo['photo_data'])) {
                                $photoPath = $this->saveBase64Photo($photo['photo_data'], 'inverter');

                                $photos[] = [
                                    'photo_path' => $photoPath,
                                    'photo_latitude' => $photo['photo_latitude'] ?? null,
                                    'photo_longitude' => $photo['photo_longitude'] ?? null,
                                    'photo_timestamp' => $photo['photo_timestamp'] ?? null,
                                ];
                            }
                        }
                    }

                    $inverterProcessed[] = [
                        'nama' => $item['nama'] ?? '',
                        'status' => $item['status'] ?? '',
                        'tegangan' => $item['tegangan'] ?? '',
                        'photos' => $photos,
                    ];
                }
            }

            // --- SIMPAN DATA INVERTER ---
            Inverter::create([
                'user_id' => Auth::id(),
                'nomor_dokumen' => $validated['nomor_dokumen'],
                'lokasi' => $validated['lokasi'],
                'tanggal_dokumentasi' => $validated['tanggal_dokumentasi'],
                'waktu' => $validated['waktu'],
                'keterangan' => $request->keterangan,
                'brand' => $request->brand,
                'reg_num' => $request->reg_num,
                'serial_num' => $request->serial_num,
                'dc_input_voltage' => $request->dc_input_voltage,
                'dc_current_input' => $request->dc_current_input,
                'ac_current_output' => $request->ac_current_output,
                'ac_output_voltage' => $request->ac_output_voltage,
                'equipment_temperature' => $request->equipment_temperature,

                // Personnel
                'executor_1' => $request->executor_1,
                'mitra_internal_1' => $request->mitra_internal_1,
                'executor_2' => $request->executor_2,
                'mitra_internal_2' => $request->mitra_internal_2,
                'executor_3' => $request->executor_3,
                'mitra_internal_3' => $request->mitra_internal_3,
                'executor_4' => $request->executor_4,
                'mitra_internal_4' => $request->mitra_internal_4,
                'verifikator' => $request->verifikator,
                'verifikator_nik' => $request->verifikator_nik,
                'head_of_sub_department' => $request->head_of_sub_department,
                'head_of_sub_department_nik' => $request->head_of_sub_department_nik,

                'data_checklist' => $inverterProcessed,

            ]);

            DB::commit();
            return redirect()->route('inverter.index')
                ->with('success', 'Data inverter berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail inverter.
     */
    public function show($id)
    {
        $inverter = Inverter::where('user_id', Auth::id())->findOrFail($id);

        // Model sudah auto-cast ke array
        if (!is_array($inverter->data_checklist)) {
            $inverter->data_checklist = [];
        }
        if (!is_array($inverter->pelaksana)) {
            $inverter->pelaksana = [];
        }
        if (!is_array($inverter->pengawas)) {
            $inverter->pengawas = [];
        }

        return view('inverter.show', compact('inverter'));
    }

    /**
     * Form edit inverter.
     */
    public function edit($id)
    {
        $inverter = Inverter::where('user_id', Auth::id())->findOrFail($id);

        // Model sudah auto-cast ke array
        if (!is_array($inverter->data_checklist)) {
            $inverter->data_checklist = [];
        }
        if (!is_array($inverter->pelaksana)) {
            $inverter->pelaksana = [];
        }
        if (!is_array($inverter->pengawas)) {
            $inverter->pengawas = [];
        }

        $centrals = DB::table('central')
            ->orderBy('area')
            ->orderBy('nama')
            ->get();

        // Group by area untuk tampilan yang lebih rapi
        $centralsByArea = $centrals->groupBy('area');
        return view('inverter.edit', compact('inverter', 'centralsByArea'));
    }

    /**
     * Update data inverter.
     */
    public function update(Request $request, $id)
    {
        $inverter = Inverter::where('user_id', Auth::id())->findOrFail($id);

        // --- VALIDASI ---
        $validated = $request->validate([
            'nomor_dokumen' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_dokumentasi' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'reg_num' => 'nullable|string|max:255',
            'serial_num' => 'nullable|string|max:255',
            'dc_input_voltage' => 'nullable|numeric',
            'dc_current_input' => 'nullable|numeric',
            'ac_current_output' => 'nullable|numeric',
            'ac_output_voltage' => 'nullable|numeric',
            'equipment_temperature' => 'nullable|numeric',

            // Personnel
            'executor_1' => 'nullable|string|max:255',
            'mitra_internal_1' => 'nullable|in:Mitra,Internal',
            'executor_2' => 'nullable|string|max:255',
            'mitra_internal_2' => 'nullable|in:Mitra,Internal',
            'executor_3' => 'nullable|string|max:255',
            'mitra_internal_3' => 'nullable|in:Mitra,Internal',
            'executor_4' => 'nullable|string|max:255',
            'mitra_internal_4' => 'nullable|in:Mitra,Internal',
            'verifikator' => 'nullable|string|max:255',
            'verifikator_nik' => 'nullable|string|max:50',
            'head_of_sub_department' => 'nullable|string|max:255',
            'head_of_sub_department_nik' => 'nullable|string|max:50',

            'data_inverter' => 'nullable|array',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'string',
        ]);

        DB::beginTransaction();
        try {
            // ==================== HANDLE FOTO YANG DIHAPUS ====================
            if ($request->has('delete_photos') && is_array($request->delete_photos)) {
                foreach ($request->delete_photos as $photoPath) {
                    // Hapus file fisik dari storage
                    if (Storage::disk('public')->exists($photoPath)) {
                        Storage::disk('public')->delete($photoPath);
                        \Log::info('Deleted photo: ' . $photoPath);
                    }
                }
            }

            // --- Proses Data Checklist ---
            $inverterProcessed = [];
            if ($request->has('data_inverter')) {
                foreach ($request->data_inverter as $index => $item) {
                    $photos = [];

                    // Proses array foto
                    if (isset($item['photos']) && is_array($item['photos'])) {
                        foreach ($item['photos'] as $photoIndex => $photo) {
                            // Cek apakah foto ini ada di daftar delete
                            $isMarkedForDeletion = false;
                            if ($request->has('delete_photos') && !empty($photo['existing_photo'])) {
                                $isMarkedForDeletion = in_array($photo['existing_photo'], $request->delete_photos);
                            }

                            // Skip foto yang ditandai untuk dihapus
                            if ($isMarkedForDeletion) {
                                continue;
                            }

                            // Cek apakah ada foto baru
                            if (!empty($photo['photo_data'])) {
                                // Hapus foto lama jika ada dan diganti dengan baru
                                if (!empty($photo['existing_photo'])) {
                                    Storage::disk('public')->delete($photo['existing_photo']);
                                }
                                $photoPath = $this->saveBase64Photo($photo['photo_data'], 'inverter');

                                $photos[] = [
                                    'photo_path' => $photoPath,
                                    'photo_latitude' => $photo['photo_latitude'] ?? null,
                                    'photo_longitude' => $photo['photo_longitude'] ?? null,
                                    'photo_timestamp' => $photo['photo_timestamp'] ?? null,
                                ];
                            }
                            // Pertahankan foto lama jika tidak ada upload baru
                            elseif (!empty($photo['existing_photo'])) {
                                $photos[] = [
                                    'photo_path' => $photo['existing_photo'],
                                    'photo_latitude' => $photo['photo_latitude'] ?? null,
                                    'photo_longitude' => $photo['photo_longitude'] ?? null,
                                    'photo_timestamp' => $photo['photo_timestamp'] ?? null,
                                ];
                            }
                        }
                    }

                    $inverterProcessed[] = [
                        'nama' => $item['nama'] ?? '',
                        'status' => $item['status'] ?? '',
                        'tegangan' => $item['tegangan'] ?? '',
                        'photos' => $photos,
                    ];
                }
            }

            // --- UPDATE DATA INVERTER ---
            $inverter->update([
                'nomor_dokumen' => $validated['nomor_dokumen'],
                'lokasi' => $validated['lokasi'],
                'tanggal_dokumentasi' => $validated['tanggal_dokumentasi'],
                'waktu' => $validated['waktu'],
                'keterangan' => $request->keterangan,
                'brand' => $request->brand,
                'reg_num' => $request->reg_num,
                'serial_num' => $request->serial_num,
                'dc_input_voltage' => $request->dc_input_voltage,
                'dc_current_input' => $request->dc_current_input,
                'ac_current_output' => $request->ac_current_output,
                'ac_output_voltage' => $request->ac_output_voltage,
                'equipment_temperature' => $request->equipment_temperature,

                // Personnel
                'executor_1' => $request->executor_1,
                'mitra_internal_1' => $request->mitra_internal_1,
                'executor_2' => $request->executor_2,
                'mitra_internal_2' => $request->mitra_internal_2,
                'executor_3' => $request->executor_3,
                'mitra_internal_3' => $request->mitra_internal_3,
                'executor_4' => $request->executor_4,
                'mitra_internal_4' => $request->mitra_internal_4,
                'verifikator' => $request->verifikator,
                'verifikator_nik' => $request->verifikator_nik,
                'head_of_sub_department' => $request->head_of_sub_department,
                'head_of_sub_department_nik' => $request->head_of_sub_department_nik,

                'data_checklist' => $inverterProcessed,
            ]);

            DB::commit();
            return redirect()->route('inverter.index')
                ->with('success', 'Data inverter berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update Inverter Error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus inverter.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $inverter = Inverter::where('user_id', Auth::id())->findOrFail($id);

            // Data sudah auto-cast ke array oleh model
            $dataChecklist = $inverter->data_checklist ?? [];

            // Hapus semua foto dari storage
            if (is_array($dataChecklist)) {
                foreach ($dataChecklist as $item) {
                    if (isset($item['photos']) && is_array($item['photos'])) {
                        foreach ($item['photos'] as $photo) {
                            if (!empty($photo['photo_path'])) {
                                Storage::disk('public')->delete($photo['photo_path']);
                            }
                        }
                    }
                }
            }

            // Hapus data inverter
            $inverter->delete();

            DB::commit();
            return redirect()->route('inverter.index')
                ->with('success', 'Data inverter berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF untuk data inverter.
     */
    public function generatePdf($id)
    {
        $inverter = Inverter::where('user_id', Auth::id())->findOrFail($id);

        // Data sudah auto-cast ke array oleh model
        if (!is_array($inverter->data_checklist)) {
            $inverter->data_checklist = [];
        }
        if (!is_array($inverter->pelaksana)) {
            $inverter->pelaksana = [];
        }
        if (!is_array($inverter->pengawas)) {
            $inverter->pengawas = [];
        }

        $pdf = Pdf::loadView('inverter.pdf', compact('inverter'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Inverter_' . $inverter->nomor_dokumen . '_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Helper untuk simpan foto base64.
     */
    private function saveBase64Photo($base64Data, $folder)
    {
        // Mendapatkan format dan data image
        if (strpos($base64Data, ';base64,') !== false) {
            list($type, $base64Data) = explode(';', $base64Data);
            list(, $base64Data) = explode(',', $base64Data);
            $imageType = explode('/', $type)[1] ?? 'jpeg';
        } else {
            $imageType = 'jpeg';
        }

        $imageData = base64_decode($base64Data);
        $filename = uniqid() . '_' . time() . '.' . $imageType;
        $path = $folder . '/' . $filename;

        // Simpan ke storage
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }
}

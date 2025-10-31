<?php

namespace App\Http\Controllers;

use App\Models\ScheduleMaintenance; 
use App\Models\ScheduleLocation;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;                   

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal.
     */
    public function index()
    {
        $schedules = ScheduleMaintenance::with('locations')
            ->orderBy('bulan', 'desc')
            ->paginate(10);

        return view('schedule.index', compact('schedules'));
    }

    /**
     * Menampilkan formulir untuk membuat jadwal baru.
     */
    public function create()
    {
        return view('schedule.create');
    }

    /**
     * Menyimpan data jadwal baru ke database.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // 1. Validasi Data Utama dan Lokasi
            $validated = $request->validate([
                'bulan' => 'required|date_format:Y-m',
                'dibuat_oleh_nama' => 'required|string|max:255',
                'dibuat_oleh_nik' => 'nullable|string|max:255', 
                'mengetahui_nama' => 'required|string|max:255',
                'mengetahui_nik' => 'nullable|string|max:255', 
                
                'locations' => 'required|array',
                'locations.*.nama' => 'required|string|max:255',
                'locations.*.petugas_nama' => 'required|string|max:255',
                'locations.*.petugas_nik' => 'nullable|string|max:255',
                
                'locations.*.rencana' => 'nullable|array',
                'locations.*.realisasi' => 'nullable|array',
            ]);

            // --- PERUBAHAN UTAMA: LOGIKA PEMBENTUKAN NOMOR DOKUMEN BARU ---
            // Format Baru: FM-LAP-D2-SOP-003-007-X (Nomor urut global, tidak terikat bulan)
            $newPrefix = 'FM-LAP-D2-SOP-003-007-';
            
            // 1. Cari nomor dokumen terakhir dengan prefix yang sama
            $lastSchedule = ScheduleMaintenance::where('doc_number', 'like', $newPrefix . '%')
                                               ->orderBy('doc_number', 'desc')
                                               ->first();
            
            // 2. Hitung nomor urut baru
            $newSequence = 1;
            if ($lastSchedule) {
                // Ambil bagian angka di akhir string (setelah prefix)
                $lastSequenceString = substr($lastSchedule->doc_number, strlen($newPrefix));
                
                if (is_numeric($lastSequenceString)) {
                    $lastSequence = (int) $lastSequenceString;
                    $newSequence = $lastSequence + 1;
                }
            }
            
            // 3. Gabungkan nomor dokumen baru
            $docNumber = $newPrefix . $newSequence;
            // --- AKHIR LOGIKA NOMOR DOKUMEN ---
            
            $monthYear = Carbon::parse($validated['bulan']); // Tetap butuh untuk kolom 'bulan'

            // 2. Siapkan Data Utama: GABUNGKAN NAMA dan NIK
            $dibuatOleh = $validated['dibuat_oleh_nama'];
            if (!empty($validated['dibuat_oleh_nik'])) {
                $dibuatOleh .= ' (' . $validated['dibuat_oleh_nik'] . ')';
            }
            
            $mengetahui = $validated['mengetahui_nama'];
            if (!empty($validated['mengetahui_nik'])) {
                $mengetahui .= ' (' . $validated['mengetahui_nik'] . ')';
            }

            // 3. Simpan Data Utama
            $schedule = ScheduleMaintenance::create([
                'user_id' => Auth::id(), 
                'doc_number' => $docNumber, // Menggunakan nomor dokumen baru
                'bulan' => $monthYear->startOfMonth(),
                'dibuat_oleh' => $dibuatOleh,
                'mengetahui' => $mengetahui,
            ]);

            // 4. Simpan Detail Lokasi
            foreach ($validated['locations'] as $locationData) {
                // GABUNGKAN NAMA dan NIK Petugas
                $petugas = $locationData['petugas_nama'];
                if (!empty($locationData['petugas_nik'])) {
                    $petugas .= ' (' . $locationData['petugas_nik'] . ')';
                }
                
                $schedule->locations()->create([
                    'nama' => $locationData['nama'],
                    'petugas' => $petugas, // Menggunakan gabungan Nama dan NIK
                    'rencana' => json_encode($locationData['rencana'] ?? []), // Konversi eksplisit ke JSON
                    'realisasi' => json_encode($locationData['realisasi'] ?? []), // Konversi eksplisit ke JSON
                ]);
            }

            DB::commit();

            return redirect()->route('schedule.index')
                ->with('success', 'Jadwal PM Sentral berhasil dibuat!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data jadwal: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail jadwal.
     */
    public function show(string $id)
    {
        $schedule = ScheduleMaintenance::with('locations')->findOrFail($id);
        return view('schedule.show', compact('schedule'));
    }

    /**
     * Menampilkan formulir untuk mengedit jadwal.
     */
    public function edit(string $id)
    {
        $schedule = ScheduleMaintenance::with('locations')->findOrFail($id);
        return view('schedule.edit', compact('schedule'));
    }

    /**
     * Memperbarui data jadwal di database.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            // 1. Validasi Data Utama dan Lokasi
            $validated = $request->validate([
                'bulan' => 'required|date_format:Y-m',
                'dibuat_oleh_nama' => 'required|string|max:255',
                'dibuat_oleh_nik' => 'nullable|string|max:255', 
                'mengetahui_nama' => 'required|string|max:255',
                'mengetahui_nik' => 'nullable|string|max:255', 
                
                'locations' => 'required|array',
                'locations.*.id' => 'nullable|exists:schedule_locations,id', 
                'locations.*.nama' => 'required|string|max:255',
                'locations.*.petugas_nama' => 'required|string|max:255', 
                'locations.*.petugas_nik' => 'nullable|string|max:255', 
                
                'locations.*.rencana' => 'nullable|array', 
                'locations.*.realisasi' => 'nullable|array', 
                'locations.*.rencana.*' => 'integer|min:1|max:31',
                'locations.*.realisasi.*' => 'integer|min:1|max:31',
            ]);

            $schedule = ScheduleMaintenance::findOrFail($id);
            
            // 2. Siapkan Data Utama untuk Update: GABUNGKAN NAMA dan NIK
            $dibuatOleh = $validated['dibuat_oleh_nama'];
            if (!empty($validated['dibuat_oleh_nik'])) {
                $dibuatOleh .= ' (' . $validated['dibuat_oleh_nik'] . ')';
            }
            
            $mengetahui = $validated['mengetahui_nama'];
            if (!empty($validated['mengetahui_nik'])) {
                $mengetahui .= ' (' . $validated['mengetahui_nik'] . ')';
            }
            
            // 3. Update Data Utama
            // Nomor dokumen TIDAK diubah saat update.
            $schedule->update([
                'bulan' => $validated['bulan'] . '-01',
                'dibuat_oleh' => $dibuatOleh, 
                'mengetahui' => $mengetahui, 
            ]);

            // 4. Kelola Detail Lokasi
            $existingLocationIds = $schedule->locations->pluck('id')->toArray();
            $updatedLocationIds = [];
            
            foreach ($validated['locations'] as $locationData) {
                
                // GABUNGKAN NAMA dan NIK Petugas untuk update
                $petugas = $locationData['petugas_nama'];
                if (!empty($locationData['petugas_nik'])) {
                    $petugas .= ' (' . $locationData['petugas_nik'] . ')';
                }
                
                $locationUpdateData = [
                    'nama' => $locationData['nama'],
                    'petugas' => $petugas, // Menggunakan gabungan Nama dan NIK
                ];
                
                // Penanganan rencana dan realisasi
                if (isset($locationData['rencana'])) {
                    $locationUpdateData['rencana'] = json_encode($locationData['rencana']);
                } else {
                    $locationUpdateData['rencana'] = '[]'; 
                }
                
                if (isset($locationData['realisasi'])) {
                    $locationUpdateData['realisasi'] = json_encode($locationData['realisasi']);
                } else {
                    $locationUpdateData['realisasi'] = '[]'; 
                }
                
                if (isset($locationData['id']) && in_array($locationData['id'], $existingLocationIds)) {
                    // Update existing location
                    ScheduleLocation::find($locationData['id'])->update($locationUpdateData);
                    $updatedLocationIds[] = $locationData['id'];
                } else {
                    // Create new location
                    $newLocation = $schedule->locations()->create($locationUpdateData);
                    $updatedLocationIds[] = $newLocation->id;
                }
            }

            // Hapus lokasi yang tidak ada lagi di request
            $deletedIds = array_diff($existingLocationIds, $updatedLocationIds);
            if (!empty($deletedIds)) {
                ScheduleLocation::whereIn('id', $deletedIds)->delete();
            }


            DB::commit();

            return redirect()->route('schedule.index')
                ->with('success', 'Data Jadwal PM Sentral berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data jadwal: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data jadwal.
     */
    public function destroy(string $id)
    {
        try {
            $schedule = ScheduleMaintenance::findOrFail($id);

            // Hapus detail lokasi (ScheduleLocation) terlebih dahulu
            $schedule->locations()->delete();
            
            // Hapus data utama
            $schedule->delete();

            return redirect()->route('schedule.index')
                ->with('success', 'Data Jadwal PM Sentral berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Membuat file PDF untuk jadwal.
     */
    public function pdf(string $id)
    {
        $schedule = ScheduleMaintenance::with('locations')->findOrFail($id);

        $pdf = Pdf::loadView('schedule.pdf', compact('schedule'))
            ->setPaper('letter', 'landscape'); 

        return $pdf->stream('Jadwal PM Sentral - ' . Carbon::parse($schedule->bulan)->format('M Y') . '.pdf');
    }
}
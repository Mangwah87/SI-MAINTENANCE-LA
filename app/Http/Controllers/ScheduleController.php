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

    public function index(Request $request)
    {
        // Query dasar dengan relasi
        $query = ScheduleMaintenance::with('locations')
            ->withCount('locations');

        // === FITUR PENCARIAN ===
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            
            $query->where(function($q) use ($searchTerm) {
                // Cari berdasarkan tanggal pembuatan
                $q->where('tanggal_pembuatan', 'like', '%' . $searchTerm . '%')
                  // Cari berdasarkan dibuat oleh
                  ->orWhere('dibuat_oleh', 'like', '%' . $searchTerm . '%')
                  // Cari berdasarkan nama lokasi
                  ->orWhereHas('locations', function($locationQuery) use ($searchTerm) {
                      $locationQuery->where('nama', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Default: Urutkan berdasarkan tanggal pembuatan terbaru
        $query->orderBy('tanggal_pembuatan', 'desc');

        // Pagination dengan 10 item per halaman
        $schedules = $query->paginate(10);

        return view('schedule.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedule.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // 1. Validasi Data Utama dan Lokasi
            $validated = $request->validate([
                'tanggal_pembuatan' => 'required|date_format:Y-m-d',
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

            // --- LOGIKA PEMBENTUKAN NOMOR DOKUMEN ---
            $newPrefix = 'FM-LAP-D2-SOP-003-007-';
            
            $lastSchedule = ScheduleMaintenance::where('doc_number', 'like', $newPrefix . '%')
                                               ->orderBy('doc_number', 'desc')
                                               ->first();
            
            $newSequence = 1;
            if ($lastSchedule) {
                $lastSequenceString = substr($lastSchedule->doc_number, strlen($newPrefix));
                
                if (is_numeric($lastSequenceString)) {
                    $lastSequence = (int) $lastSequenceString;
                    $newSequence = $lastSequence + 1;
                }
            }
            
            $docNumber = $newPrefix . $newSequence;
            
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
                'doc_number' => $docNumber,
                'tanggal_pembuatan' => $validated['tanggal_pembuatan'],
                'dibuat_oleh' => $dibuatOleh,
                'mengetahui' => $mengetahui,
            ]);

            // 4. Simpan Detail Lokasi
            foreach ($validated['locations'] as $locationData) {
                $petugas = $locationData['petugas_nama'];
                if (!empty($locationData['petugas_nik'])) {
                    $petugas .= ' (' . $locationData['petugas_nik'] . ')';
                }
                
                $schedule->locations()->create([
                    'nama' => $locationData['nama'],
                    'petugas' => $petugas,
                    'rencana' => $locationData['rencana'] ?? [],
                    'realisasi' => $locationData['realisasi'] ?? [],
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

    public function show(string $id)
    {
        $schedule = ScheduleMaintenance::with('locations')->findOrFail($id);
        return view('schedule.show', compact('schedule'));
    }

    public function edit(string $id)
    {
        $schedule = ScheduleMaintenance::with('locations')->findOrFail($id);
        return view('schedule.edit', compact('schedule'));
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            // 1. Validasi Data Utama dan Lokasi
            $validated = $request->validate([
                'tanggal_pembuatan' => 'required|date_format:Y-m-d',
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
            
            // 2. Siapkan Data Utama untuk Update
            $dibuatOleh = $validated['dibuat_oleh_nama'];
            if (!empty($validated['dibuat_oleh_nik'])) {
                $dibuatOleh .= ' (' . $validated['dibuat_oleh_nik'] . ')';
            }
            
            $mengetahui = $validated['mengetahui_nama'];
            if (!empty($validated['mengetahui_nik'])) {
                $mengetahui .= ' (' . $validated['mengetahui_nik'] . ')';
            }
            
            // 3. Update Data Utama
            $schedule->update([
                'tanggal_pembuatan' => $validated['tanggal_pembuatan'],
                'dibuat_oleh' => $dibuatOleh, 
                'mengetahui' => $mengetahui, 
            ]);

            // 4. Kelola Detail Lokasi
            $existingLocationIds = $schedule->locations->pluck('id')->toArray();
            $updatedLocationIds = [];
            
            foreach ($validated['locations'] as $locationData) {
                $petugas = $locationData['petugas_nama'];
                if (!empty($locationData['petugas_nik'])) {
                    $petugas .= ' (' . $locationData['petugas_nik'] . ')';
                }
                
                $locationUpdateData = [
                    'nama' => $locationData['nama'],
                    'petugas' => $petugas,
                ];
                
                // Penanganan rencana dan realisasi
                if (isset($locationData['rencana'])) {
                    $locationUpdateData['rencana'] = $locationData['rencana'];
                } else {
                    $locationUpdateData['rencana'] = []; 
                }

                if (isset($locationData['realisasi'])) {
                    $locationUpdateData['realisasi'] = $locationData['realisasi'];
                } else {
                    $locationUpdateData['realisasi'] = [];
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

    public function destroy(string $id)
    {
        try {
            $schedule = ScheduleMaintenance::findOrFail($id);

            // Hapus detail lokasi terlebih dahulu
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

    public function pdf(string $id)
    {
        $schedule = ScheduleMaintenance::with('locations')->findOrFail($id);

        // Pisahkan Nama dan NIK dari string gabungan
        if (preg_match('/^(.+?)\s*\(([^)]+)\)$/', $schedule->dibuat_oleh, $matches)) {
            $schedule->dibuat_oleh_nama = trim($matches[1]);
            $schedule->dibuat_oleh_nik = trim($matches[2]);
        } else {
            $schedule->dibuat_oleh_nama = $schedule->dibuat_oleh;
            $schedule->dibuat_oleh_nik = '-';
        }
        
        if (preg_match('/^(.+?)\s*\(([^)]+)\)$/', $schedule->mengetahui, $matches)) {
            $schedule->mengetahui_nama = trim($matches[1]);
            $schedule->mengetahui_nik = trim($matches[2]);
        } else {
            $schedule->mengetahui_nama = $schedule->mengetahui;
            $schedule->mengetahui_nik = '-';
        }

        $pdf = Pdf::loadView('schedule.pdf', compact('schedule'))
            ->setPaper('letter', 'landscape'); 

        return $pdf->stream('Jadwal PM Sentral - ' . Carbon::parse($schedule->tanggal_pembuatan)->isoFormat('D MMMM Y') . '.pdf');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\InstalasiKabelHeader; 
use App\Models\InstalasiKabelDetail;
use App\Models\InstalasiKabelSignature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class InstalasiKabelController extends Controller
{
    /**
     * Menampilkan daftar semua formulir (Read Index).
     */
    public function index()
    {
        $jadwal = InstalasiKabelHeader::select('id', 'no_dokumen', 'location', 'date_time', 'dibuat_oleh')
            ->latest()
            ->paginate(10);

        return view('instalasi-kabel.index', compact('jadwal')); 
    }

    /**
     * Menampilkan formulir untuk membuat data baru.
     */
    public function create()
    {
        // Ambil detail items dan kelompokkan
        $grouped_items = $this->getGroupedDetailItems();
        
        // Data Peran Tanda Tangan
        $signature_roles = [
            ['no' => 1, 'id' => 1, 'label' => 'Pelaksana 1', 'required' => true],
            ['no' => 2, 'id' => 2, 'label' => 'Pelaksana 2', 'required' => false],
            ['no' => 3, 'id' => 3, 'label' => 'Pelaksana 3', 'required' => false],
            // BARIS BARU: PERAN 'MENGETAHUI'
            ['no' => 4, 'id' => 4, 'label' => 'Mengetahui', 'required' => true],
        ];

        return view('instalasi-kabel.create', compact('grouped_items', 'signature_roles'));
    }

    /**
     * Menyimpan data formulir baru ke database.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $detail_items = $this->getDetailItems();
            
            // Validasi Input
            $validated = $request->validate([
                'location' => 'required|string|max:255',
                'date_time' => 'required|date',
                'brand_type' => 'required|string|max:255',
                'reg_number' => 'required|string|max:255',
                'serial_number' => 'required|string|max:255',
                'notes' => 'nullable|string',
                
                // Data Detail
                'detail' => 'required|array|min:'.count($detail_items),
                'detail.*.result' => 'nullable|string|max:255',
                'detail.*.status' => 'required|in:OK,NOK',
                'detail.*.photo_base64' => 'nullable|string',
                'detail.*.item_description' => 'required|string',
                'detail.*.operational_standard' => 'required|string',
                'detail.*.category' => 'required|string',
                
                // Data Tanda Tangan
                'pelaksana.1.name' => 'required|string|max:255',
                'pelaksana.1.perusahaan' => 'required|string|max:255',
                'pelaksana.1.role' => 'required|string|max:255',
                'pelaksana.1.no' => 'required|integer',

                'pelaksana.2.name' => 'nullable|string|max:255', // Pelaksana 2 (Optional)
                'pelaksana.2.perusahaan' => 'nullable|string|max:255',
                'pelaksana.2.role' => 'nullable|string|max:255',
                'pelaksana.2.no' => 'nullable|integer',
                
                'pelaksana.3.name' => 'nullable|string|max:255', // Pelaksana 3 (Optional)
                'pelaksana.3.perusahaan' => 'nullable|string|max:255',
                'pelaksana.3.role' => 'nullable|string|max:255',
                'pelaksana.3.no' => 'nullable|integer',

                // VALIDASI BARU UNTUK 'MENGETAHUI' (WAJIB)
                'pelaksana.4.name' => 'required|string|max:255',
                'pelaksana.4.perusahaan' => 'nullable|string|max:255',
                'pelaksana.4.role' => 'required|string|max:255',
                'pelaksana.4.no' => 'required|integer',
            ]);

            // Generate Nomor Dokumen
            $currentYear = Carbon::parse($validated['date_time'])->year;
            $currentMonth = Carbon::parse($validated['date_time'])->month;
            
            $lastDocNumber = InstalasiKabelHeader::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->count();
            
 // New Code
$docNumber = 'FM-LAP-D2-SOP-003-012-' . str_pad($lastDocNumber + 1, 3, '0', STR_PAD_LEFT);
            
            $dibuatOleh = $validated['pelaksana'][1]['name'] . ' (' . $validated['pelaksana'][1]['perusahaan'] . ')';
            $bulan = Carbon::parse($validated['date_time'])->locale('id')->isoFormat('MMMM YYYY');

            // 1. Simpan Header
            $header = InstalasiKabelHeader::create([
                'user_id' => Auth::id(),
                'no_dokumen' => $docNumber,
                'location' => $validated['location'],
                'date_time' => $validated['date_time'],
                'brand_type' => $validated['brand_type'],
                'reg_number' => $validated['reg_number'],
                'serial_number' => $validated['serial_number'], // ðŸ”§ FIXED: Gunakan 'serial_number'
                'notes' => $validated['notes'],
                'bulan' => $bulan,
                'jumlah_lokasi' => 1,
                'dibuat_oleh' => $dibuatOleh,
            ]);

            // 2. Simpan Detail dengan Foto
            foreach ($validated['detail'] as $key => $detailData) {
                $photoPath = null;
                
                // Proses Upload Foto jika ada data Base64
                if (!empty($detailData['photo_base64'])) {
                    $photoPath = $this->saveBase64Image(
                        $detailData['photo_base64'], 
                        $header->id,
                        $key
                    );
                }
                
                $header->details()->create([
                    'item_description' => $detailData['item_description'],
                    'operational_standard' => $detailData['operational_standard'],
                    'category' => $detailData['category'],
                    'result' => $detailData['result'] ?? null,
                    'status' => $detailData['status'],
                    'photo_path' => $photoPath,
                ]);
            }

            // 3. Simpan Tanda Tangan
            foreach ($validated['pelaksana'] as $signatureData) {
                // Pastikan hanya menyimpan data tanda tangan yang memiliki nama
                if (!empty($signatureData['name'])) {
                    $header->signatures()->create([
                        'no' => $signatureData['no'],
                        'role' => $signatureData['role'],
                        'name' => $signatureData['name'],
                        'perusahaan' => $signatureData['perusahaan'] ?? '',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('instalasi-kabel.index')
                ->with('success', 'Formulir Instalasi Kabel ' . $docNumber . ' berhasil dibuat!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saat menyimpan formulir: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Menampilkan detail satu formulir.
     */
    public function show($id)
    {
        $header = InstalasiKabelHeader::with(['details', 'signatures'])->findOrFail($id);
        return view('instalasi-kabel.show', compact('header'));
    }
    
    /**
     * Menampilkan formulir untuk mengedit data.
     */
    public function edit($id)
    {
        $header = InstalasiKabelHeader::with(['details', 'signatures'])->findOrFail($id);
        $grouped_items = $this->getGroupedDetailItems();
        
        $signature_roles = [
            ['no' => 1, 'id' => 1, 'label' => 'Pelaksana 1', 'required' => true],
            ['no' => 2, 'id' => 2, 'label' => 'Pelaksana 2', 'required' => false],
            ['no' => 3, 'id' => 3, 'label' => 'Pelaksana 3', 'required' => false],
            // BARIS BARU: PERAN 'MENGETAHUI'
            ['no' => 4, 'id' => 4, 'label' => 'Mengetahui', 'required' => true],
        ];

        return view('instalasi-kabel.edit', compact('header', 'grouped_items', 'signature_roles'));
    }

    /**
     * Update data formulir yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $header = InstalasiKabelHeader::findOrFail($id);
            $detail_items = $this->getDetailItems();
            
            // Validasi Input
            $validated = $request->validate([
                'location' => 'required|string|max:255',
                'date_time' => 'required|date',
                'brand_type' => 'required|string|max:255',
                'reg_number' => 'required|string|max:255',
                'serial_number' => 'required|string|max:255', // ðŸ”§ FIXED
                'notes' => 'nullable|string',
                
                'detail' => 'required|array|min:'.count($detail_items),
                'detail.*.result' => 'nullable|string|max:255',
                'detail.*.status' => 'required|in:OK,NOK',
                'detail.*.photo_base64' => 'nullable|string',
                'detail.*.existing_photo_path' => 'nullable|string',
                'detail.*.item_description' => 'required|string',
                'detail.*.operational_standard' => 'required|string',
                'detail.*.category' => 'required|string',
                
                'pelaksana.1.name' => 'required|string|max:255',
                'pelaksana.1.perusahaan' => 'required|string|max:255',
                'pelaksana.1.role' => 'required|string|max:255',
                'pelaksana.1.no' => 'required|integer',

                'pelaksana.2.name' => 'nullable|string|max:255', // Diubah menjadi nullable agar konsisten dengan create()
                'pelaksana.2.perusahaan' => 'nullable|string|max:255', // Diubah menjadi nullable agar konsisten dengan create()
                'pelaksana.2.role' => 'nullable|string|max:255', // Diubah menjadi nullable agar konsisten dengan create()
                'pelaksana.2.no' => 'required|integer',
                
                'pelaksana.3.name' => 'nullable|string|max:255',
                'pelaksana.3.perusahaan' => 'nullable|string|max:255',
                'pelaksana.3.role' => 'nullable|string|max:255',
                'pelaksana.3.no' => 'nullable|integer',

                // VALIDASI BARU UNTUK 'MENGETAHUI' (WAJIB)
                'pelaksana.4.name' => 'required|string|max:255',
                'pelaksana.4.perusahaan' => 'nullable|string|max:255',
                'pelaksana.4.role' => 'required|string|max:255',
                'pelaksana.4.no' => 'required|integer',
            ]);

            $dibuatOleh = $validated['pelaksana'][1]['name'] . ' (' . $validated['pelaksana'][1]['perusahaan'] . ')';
            $bulan = Carbon::parse($validated['date_time'])->locale('id')->isoFormat('MMMM YYYY');

            // Update Header
            $header->update([
                'location' => $validated['location'],
                'date_time' => $validated['date_time'],
                'brand_type' => $validated['brand_type'],
                'reg_number' => $validated['reg_number'],
                'serial_number' => $validated['serial_number'], // ðŸ”§ FIXED
                'notes' => $validated['notes'],
                'bulan' => $bulan,
                'dibuat_oleh' => $dibuatOleh,
            ]);

            // Update Details
            $header->details()->delete(); // Hapus semua detail lama
            
            foreach ($validated['detail'] as $index => $detailData) {
                $photoPath = $detailData['existing_photo_path'] ?? null;
                
                // Jika ada foto baru
                if (!empty($detailData['photo_base64'])) {
                    if ($photoPath) {
                        $this->deletePhoto($photoPath);
                    }
                    $photoPath = $this->saveBase64Image(
                        $detailData['photo_base64'], 
                        $header->id, 
                        $index
                    );
                }

                $header->details()->create([
                    'item_description' => $detailData['item_description'],
                    'operational_standard' => $detailData['operational_standard'],
                    'category' => $detailData['category'],
                    'result' => $detailData['result'] ?? null,
                    'status' => $detailData['status'],
                    'photo_path' => $photoPath,
                ]);
            }

            // Update Signatures
            $header->signatures()->delete();
            
            foreach ($validated['pelaksana'] as $signatureData) {
                if (!empty($signatureData['name'])) {
                    $header->signatures()->create([
                        'no' => $signatureData['no'],
                        'role' => $signatureData['role'],
                        'name' => $signatureData['name'],
                        'perusahaan' => $signatureData['perusahaan'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('instalasi-kabel.show', $header->id)
                ->with('success', 'Formulir berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saat update formulir: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus formulir beserta foto-fotonya.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $header = InstalasiKabelHeader::with('details')->findOrFail($id);
            
            // Hapus semua foto terkait
            foreach ($header->details as $detail) {
                if ($detail->photo_path) {
                    $this->deletePhoto($detail->photo_path);
                }
            }
            
            // Hapus folder header jika kosong
            $folderPath = "instalasi_kabel/{$header->id}";
            if (Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->deleteDirectory($folderPath);
            }
            
            // Hapus data dari database
            $header->delete();
            
            DB::commit();
            return redirect()->route('instalasi-kabel.index')
                ->with('success', 'Formulir berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saat menghapus formulir: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghasilkan PDF dari formulir.
     */
    public function pdf($id)
    {
        // Long PDFs with photos can exceed default 128M. Raise limit defensively.
        @ini_set('memory_limit', '512M');

        $header = InstalasiKabelHeader::with(['details', 'signatures'])->findOrFail($id);

        // Filter Detail untuk mengambil item yang memiliki foto
        $detailsWithPhotos = $header->details->filter(function ($detail) {
            return !empty($detail->photo_path);
        });

        // Kelompokkan Detail berdasarkan Category
        $groupedDetails = $header->details->groupBy('category');

        // Siapkan versi foto yang sudah di-resize/di-kompres untuk PDF agar hemat memori
        $detailsWithPhotos = $detailsWithPhotos->map(function ($detail) {
            try {
                if (!empty($detail->photo_path)) {
                    $publicResized = $this->ensureResizedPublicPhoto($detail->photo_path, 1280, 70);
                    // tambahkan properti dinamis untuk dipakai di Blade
                    $detail->pdf_photo_public_path = $publicResized;
                }
            } catch (\Throwable $e) {
                // Abaikan jika gagal resize; gunakan file asli via symlink public
                $detail->pdf_photo_public_path = public_path('storage/' . $detail->photo_path);
            }
            return $detail;
        });

        $data = [
            'header' => $header,
            'groupedDetails' => $groupedDetails,
            'detailsWithPhotos' => $detailsWithPhotos,
            'carbon' => new Carbon(),
            'File' => File::class,
        ];
        
        $documentNumber = $header->no_dokumen ?? $header->id;
        $safeDocumentNumber = str_replace(['/', '\\'], '_', $documentNumber);

        // Ensure temp dirs exist for DomPDF caches
        @mkdir(storage_path('app/temp/dompdf'), 0775, true);
        @mkdir(storage_path('app/dompdf_font_cache'), 0775, true);

        // Configure DomPDF to be lighter on memory and allow local file images
        $pdf = Pdf::loadView('instalasi-kabel.pdf', $data)
                  ->setOptions([
                      // Lower DPI reduces image rasterization memory usage
                      'dpi' => 72,
                      // Allow DOMPDF to read files from public path (for logo and storage symlink)
                      'chroot' => public_path(),
                      'isRemoteEnabled' => false,
                      // Improve parsing compatibility
                      'isHtml5ParserEnabled' => true,
                      // Subset fonts to reduce memory footprint
                      'isFontSubsettingEnabled' => true,
                      // Use storage-backed temp & font cache
                      'tempDir' => storage_path('app/temp/dompdf'),
                      'fontCache' => storage_path('app/dompdf_font_cache'),
                  ])
                  ->setPaper('A4', 'portrait');

        $fileName = 'PM_InstalasiKabel_' . $safeDocumentNumber . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Pastikan ada versi foto yang sudah di-resize & dikompres di disk public,
     * lalu kembalikan absolute public path (untuk dipakai <img src="..."></img> di DomPDF).
     */
    private function ensureResizedPublicPhoto(string $relativePath, int $maxWidth = 1280, int $quality = 70): string
    {
        $sourceAbs = storage_path('app/public/' . ltrim($relativePath, '/'));
        $fallbackPublicAbs = public_path('storage/' . ltrim($relativePath, '/'));

        if (!file_exists($sourceAbs)) {
            return $fallbackPublicAbs; // pakai yang ada saja
        }

        // Bangun path cache di disk 'public', mempertahankan folder asli + suffix ukuran
        $dir = trim(pathinfo($relativePath, PATHINFO_DIRNAME), '/\\');
        $name = pathinfo($relativePath, PATHINFO_FILENAME);
        $cacheRel = ($dir ? $dir . '/' : '') . $name . "-w{$maxWidth}.jpg";
        $cacheAbs = storage_path('app/public/' . $cacheRel);

        // Regenerasi jika tidak ada atau sumber lebih baru
        $needRegen = !file_exists($cacheAbs) || (filemtime($cacheAbs) < filemtime($sourceAbs));
        if (!$needRegen) {
            return public_path('storage/' . $cacheRel);
        }

        // Pastikan GD tersedia
        if (!function_exists('imagecreatefromstring')) {
            return $fallbackPublicAbs;
        }

        $binary = @file_get_contents($sourceAbs);
        if ($binary === false) {
            return $fallbackPublicAbs;
        }

        $src = @imagecreatefromstring($binary);
        if ($src === false) {
            return $fallbackPublicAbs;
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);
        $dstW = $srcW;
        $dstH = $srcH;
        if ($srcW > $maxWidth) {
            $dstW = $maxWidth;
            $dstH = (int) floor($srcH * ($maxWidth / $srcW));
        }

        $dst = imagecreatetruecolor($dstW, $dstH);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);

        // Buffer output JPEG
        ob_start();
        imagejpeg($dst, null, max(1, min(100, $quality)));
        $jpegData = ob_get_clean();

        imagedestroy($dst);
        imagedestroy($src);
        $binary = null;
        if (function_exists('gc_collect_cycles')) { gc_collect_cycles(); }

        if ($jpegData === false) {
            return $fallbackPublicAbs;
        }

        // Simpan ke disk public agar bisa diakses via symlink public/storage
        \Illuminate\Support\Facades\Storage::disk('public')->put($cacheRel, $jpegData);
        return public_path('storage/' . $cacheRel);
    }

    /**
     * Method untuk menyimpan Base64 image ke storage.
     */
    private function saveBase64Image(string $base64String, $headerId, $itemIndex): ?string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $data = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1] ?? 'jpeg');

            $data = str_replace(' ', '+', $data);
            $data = base64_decode($data);

            if ($data === false) {
                return null;
            }
        } else {
            return null;
        }

        $folder = "instalasi_kabel/{$headerId}";

        // Kompres dan resize sebelum simpan untuk hemat storage & memori saat render PDF
        $savedExt = $type;
        if (function_exists('imagecreatefromstring')) {
            $src = @imagecreatefromstring($data);
            if ($src !== false) {
                $srcW = imagesx($src);
                $srcH = imagesy($src);
                $maxW = 1600; // sedikit lebih tinggi dari versi PDF agar cadangan cukup tajam
                $dstW = $srcW > $maxW ? $maxW : $srcW;
                $dstH = (int) floor($srcH * ($dstW / $srcW));
                $dst = imagecreatetruecolor($dstW, $dstH);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
                ob_start();
                imagejpeg($dst, null, 72); // kompresi medium
                $data = ob_get_clean();
                imagedestroy($dst);
                imagedestroy($src);
                $savedExt = 'jpg';
            }
        }

        $fileName = 'item-' . $itemIndex . '-' . Str::random(10) . '.' . $savedExt;
        $path = $folder . '/' . $fileName;

        Storage::disk('public')->put($path, $data);
        return $path;
    }
    
    /**
     * Method untuk menghapus foto dari storage.
     */
    private function deletePhoto(string $path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        }
        return false;
    }

    /**
     * Definisi Item Pemeriksaan (Raw Data)
     */
 private function getDetailItems()
    {
        return [
            // ===================================
            // 1. VISUAL CHECK
            // ===================================
            ['description' => 'Indicator Lamp', 'standard' => 'Normal', 'category' => '1. Visual Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'Voltmeter & Ampere meter', 'standard' => 'Normal', 'category' => '1. Visual Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'Arrester', 'standard' => 'Normal', 'category' => '1. Visual Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'MCB Input UPS', 'standard' => 'Normal', 'category' => '1. Visual Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'MCB Output UPS', 'standard' => 'Normal', 'category' => '1. Visual Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'MCB Bypass', 'standard' => 'Normal', 'category' => '1. Visual Check', 'sub_category' => null, 'is_pm' => false],
            
            // ==========================================================
            // 2. PERFORMANCE MEASUREMENT (Maks 35°C & Maks 65°C)
            // ==========================================================

            // I. MCB Temperature
            ['description' => 'Input UPS', 'standard' => 'Maks 35°C', 'category' => '2. Performance Measurement', 'sub_category' => 'I. MCB Temperature', 'is_pm' => true],
            ['description' => 'Output UPS', 'standard' => 'Maks 35°C', 'category' => '2. Performance Measurement', 'sub_category' => 'I. MCB Temperature', 'is_pm' => true],
            ['description' => 'Bypass UPS', 'standard' => 'Maks 35°C', 'category' => '2. Performance Measurement', 'sub_category' => 'I. MCB Temperature', 'is_pm' => true],
            ['description' => 'Load Rack', 'standard' => 'Maks 35°C', 'category' => '2. Performance Measurement', 'sub_category' => 'I. MCB Temperature', 'is_pm' => true],
            ['description' => 'Cooling unit ( AC )', 'standard' => 'Maks 35°C', 'category' => '2. Performance Measurement', 'sub_category' => 'I. MCB Temperature', 'is_pm' => true], // Diperbaiki: ditambahkan spasi pada ( AC )

            // II. Cable Temperature
            ['description' => 'Input UPS', 'standard' => 'Maks 65°C', 'category' => '2. Performance Measurement', 'sub_category' => 'II. Cable Temperature', 'is_pm' => true],
            ['description' => 'Output UPS', 'standard' => 'Maks 65°C', 'category' => '2. Performance Measurement', 'sub_category' => 'II. Cable Temperature', 'is_pm' => true],
            ['description' => 'Bypass UPS', 'standard' => 'Maks 65°C', 'category' => '2. Performance Measurement', 'sub_category' => 'II. Cable Temperature', 'is_pm' => true],
            ['description' => 'Load Rack', 'standard' => 'Maks 65°C', 'category' => '2. Performance Measurement', 'sub_category' => 'II. Cable Temperature', 'is_pm' => true],
            ['description' => 'Cooling unit ( AC )', 'standard' => 'Maks 65°C', 'category' => '2. Performance Measurement', 'sub_category' => 'II. Cable Temperature', 'is_pm' => true], // Diperbaiki: ditambahkan spasi pada ( AC )
            
            // ===================================
            // 3. PERFORMANCE CHECK
            // ===================================
            ['description' => 'Maksure All Cable Connection', 'standard' => 'Tightened', 'category' => '3. Performance Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'Spare of MCB Load Rack', 'standard' => 'Available', 'category' => '3. Performance Check', 'sub_category' => null, 'is_pm' => false],
            ['description' => 'Single Line Diagram', 'standard' => 'Available', 'category' => '3. Performance Check', 'sub_category' => null, 'is_pm' => false],
        ];
    }

    private function getGroupedDetailItems()
    {
        $items = $this->getDetailItems();
        $grouped = [];

        foreach ($items as $item) {
            $category = $item['category'];
            
            if (!isset($grouped[$category])) {
                $grouped[$category] = [
                    'category' => $category,
                    'items' => []
                ];
            }
            
            $grouped[$category]['items'][] = $item;
        }

        return collect(array_values($grouped));
    }
}

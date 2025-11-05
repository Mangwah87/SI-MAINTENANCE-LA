<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $dokumentasi = Dokumentasi::query()
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('lokasi', 'like', "%{$search}%")
                      ->orWhere('perusahaan', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%")
                      ->orWhereRaw("JSON_SEARCH(pelaksana, 'one', ?, NULL, '$[*].nama') IS NOT NULL", ["%{$search}%"]);
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);
        
        return view('dokumentasi.index', compact('dokumentasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokumentasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nomor_dokumen' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_dokumentasi' => 'required|date',
            'perusahaan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'pengawas' => 'nullable|string|max:255',
            'pelaksana' => 'required|array',
            'pelaksana.*.nama' => 'required|string|max:255',
            'pelaksana.*.perusahaan' => 'required|string|max:255',
            'perangkat_sentral' => 'nullable|array',
            'sarana_penunjang' => 'nullable|array',
        ]);

        // Filter pelaksana yang tidak kosong
        $pelaksanaFiltered = array_filter($request->pelaksana, function($p) {
            return !empty($p['nama']) && !empty($p['perusahaan']);
        });

        // Process Perangkat Sentral
        $perangkatSentralProcessed = [];
        if ($request->has('perangkat_sentral')) {
            foreach ($request->perangkat_sentral as $item) {
                $photoPath = null;
                
                if (!empty($item['photo_data'])) {
                    $photoPath = $this->saveBase64Photo($item['photo_data'], 'perangkat_sentral');
                }
                
                $perangkatSentralProcessed[] = [
                    'nama' => $item['nama'] ?? '',
                    'qty' => $item['qty'] ?? null,
                    'status' => $item['status'] ?? '',
                    'keterangan' => $item['keterangan'] ?? '',
                    'photo_path' => $photoPath,
                    'photo_latitude' => $item['photo_latitude'] ?? null,
                    'photo_longitude' => $item['photo_longitude'] ?? null,
                    'photo_timestamp' => $item['photo_timestamp'] ?? null,
                    'kode' => $item['kode'] ?? '',
                ];
            }
        }

        // Process Sarana Penunjang
        $saranaPenunjangProcessed = [];
        if ($request->has('sarana_penunjang')) {
            foreach ($request->sarana_penunjang as $item) {
                $photoPath = null;
                
                if (!empty($item['photo_data'])) {
                    $photoPath = $this->saveBase64Photo($item['photo_data'], 'sarana_penunjang');
                }
                
                $saranaPenunjangProcessed[] = [
                    'nama' => $item['nama'] ?? '',
                    'qty' => $item['qty'] ?? null,
                    'status' => $item['status'] ?? '',
                    'keterangan' => $item['keterangan'] ?? '',
                    'photo_path' => $photoPath,
                    'photo_latitude' => $item['photo_latitude'] ?? null,
                    'photo_longitude' => $item['photo_longitude'] ?? null,
                    'photo_timestamp' => $item['photo_timestamp'] ?? null,
                    'kode' => $item['kode'] ?? '',
                ];
            }
        }

        // Create dokumentasi
        Dokumentasi::create([
            'user_id' => auth()->id(),
            'nomor_dokumen' => $validated['nomor_dokumen'],
            'lokasi' => $validated['lokasi'],
            'tanggal_dokumentasi' => $validated['tanggal_dokumentasi'],
            'perusahaan' => $request->perusahaan ?? 'PT. Aplikanusa Lintasarta',
            'keterangan' => $request->keterangan,
            'pengawas' => $request->pengawas,
            'pelaksana' => array_values($pelaksanaFiltered),
            'perangkat_sentral' => $perangkatSentralProcessed,
            'sarana_penunjang' => $saranaPenunjangProcessed,
        ]);

        return redirect()->route('dokumentasi.index')
            ->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        // Decode JSON fields
        $dokumentasi->perangkat_sentral = is_string($dokumentasi->perangkat_sentral) 
            ? json_decode($dokumentasi->perangkat_sentral, true) 
            : $dokumentasi->perangkat_sentral;
            
        $dokumentasi->sarana_penunjang = is_string($dokumentasi->sarana_penunjang) 
            ? json_decode($dokumentasi->sarana_penunjang, true) 
            : $dokumentasi->sarana_penunjang;
            
        $dokumentasi->pelaksana = is_string($dokumentasi->pelaksana) 
            ? json_decode($dokumentasi->pelaksana, true) 
            : $dokumentasi->pelaksana;
        
        return view('dokumentasi.show', compact('dokumentasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        // Decode JSON fields
        $dokumentasi->perangkat_sentral = is_string($dokumentasi->perangkat_sentral) 
            ? json_decode($dokumentasi->perangkat_sentral, true) 
            : $dokumentasi->perangkat_sentral;
            
        $dokumentasi->sarana_penunjang = is_string($dokumentasi->sarana_penunjang) 
            ? json_decode($dokumentasi->sarana_penunjang, true) 
            : $dokumentasi->sarana_penunjang;
            
        $dokumentasi->pelaksana = is_string($dokumentasi->pelaksana) 
            ? json_decode($dokumentasi->pelaksana, true) 
            : $dokumentasi->pelaksana;
        
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        // Validasi
        $validated = $request->validate([
            'nomor_dokumen' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_dokumentasi' => 'required|date',
            'perusahaan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'pengawas' => 'nullable|string|max:255',
            'pelaksana' => 'required|array',
            'pelaksana.*.nama' => 'nullable|string|max:255',
            'pelaksana.*.perusahaan' => 'nullable|string|max:255',
            'perangkat_sentral' => 'nullable|array',
            'sarana_penunjang' => 'nullable|array',
        ]);

        // Filter pelaksana yang tidak kosong
        $pelaksanaFiltered = array_filter($request->pelaksana, function($p) {
            return !empty($p['nama']) && !empty($p['perusahaan']);
        });

        // Process Perangkat Sentral
        $perangkatSentralProcessed = [];
        if ($request->has('perangkat_sentral')) {
            foreach ($request->perangkat_sentral as $index => $item) {
                $photoPath = null;
                
                // Check if new photo uploaded
                if (!empty($item['photo_data'])) {
                    // Delete old photo if exists
                    if (!empty($item['existing_photo'])) {
                        Storage::disk('public')->delete($item['existing_photo']);
                    }
                    
                    // Save new photo
                    $photoPath = $this->saveBase64Photo($item['photo_data'], 'perangkat_sentral');
                } 
                // Keep existing photo if no new photo
                elseif (!empty($item['existing_photo'])) {
                    $photoPath = $item['existing_photo'];
                }
                
                $perangkatSentralProcessed[] = [
                    'nama' => $item['nama'] ?? '',
                    'qty' => $item['qty'] ?? null,
                    'status' => $item['status'] ?? '',
                    'keterangan' => $item['keterangan'] ?? '',
                    'photo_path' => $photoPath,
                    'photo_latitude' => $item['photo_latitude'] ?? null,
                    'photo_longitude' => $item['photo_longitude'] ?? null,
                    'photo_timestamp' => $item['photo_timestamp'] ?? null,
                    'kode' => $item['kode'] ?? '',
                ];
            }
        }

        // Process Sarana Penunjang
        $saranaPenunjangProcessed = [];
        if ($request->has('sarana_penunjang')) {
            foreach ($request->sarana_penunjang as $index => $item) {
                $photoPath = null;
                
                // Check if new photo uploaded
                if (!empty($item['photo_data'])) {
                    // Delete old photo if exists
                    if (!empty($item['existing_photo'])) {
                        Storage::disk('public')->delete($item['existing_photo']);
                    }
                    
                    // Save new photo
                    $photoPath = $this->saveBase64Photo($item['photo_data'], 'sarana_penunjang');
                } 
                // Keep existing photo if no new photo
                elseif (!empty($item['existing_photo'])) {
                    $photoPath = $item['existing_photo'];
                }
                
                $saranaPenunjangProcessed[] = [
                    'nama' => $item['nama'] ?? '',
                    'qty' => $item['qty'] ?? null,
                    'status' => $item['status'] ?? '',
                    'keterangan' => $item['keterangan'] ?? '',
                    'photo_path' => $photoPath,
                    'photo_latitude' => $item['photo_latitude'] ?? null,
                    'photo_longitude' => $item['photo_longitude'] ?? null,
                    'photo_timestamp' => $item['photo_timestamp'] ?? null,
                    'kode' => $item['kode'] ?? '',
                ];
            }
        }

        // Update data
        $dokumentasi->update([
            'nomor_dokumen' => $validated['nomor_dokumen'],
            'lokasi' => $validated['lokasi'],
            'tanggal_dokumentasi' => $validated['tanggal_dokumentasi'],
            'perusahaan' => $request->perusahaan ?? 'PT. Aplikanusa Lintasarta',
            'keterangan' => $request->keterangan,
            'pengawas' => $request->pengawas,
            'pelaksana' => array_values($pelaksanaFiltered),
            'perangkat_sentral' => $perangkatSentralProcessed,
            'sarana_penunjang' => $saranaPenunjangProcessed,
        ]);

        return redirect()->route('dokumentasi.index')
            ->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        // Delete photos from perangkat_sentral
        $perangkatSentral = is_string($dokumentasi->perangkat_sentral) 
            ? json_decode($dokumentasi->perangkat_sentral, true) 
            : $dokumentasi->perangkat_sentral;
            
        if (is_array($perangkatSentral)) {
            foreach ($perangkatSentral as $item) {
                if (!empty($item['photo_path'])) {
                    Storage::disk('public')->delete($item['photo_path']);
                }
            }
        }
        
        // Delete photos from sarana_penunjang
        $saranaPenunjang = is_string($dokumentasi->sarana_penunjang) 
            ? json_decode($dokumentasi->sarana_penunjang, true) 
            : $dokumentasi->sarana_penunjang;
            
        if (is_array($saranaPenunjang)) {
            foreach ($saranaPenunjang as $item) {
                if (!empty($item['photo_path'])) {
                    Storage::disk('public')->delete($item['photo_path']);
                }
            }
        }
        
        // Delete dokumentasi record
        $dokumentasi->delete();
        
        return redirect()->route('dokumentasi.index')
            ->with('success', 'Dokumentasi berhasil dihapus!');
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function generatePdf($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        // Decode JSON fields
        $dokumentasi->perangkat_sentral = is_string($dokumentasi->perangkat_sentral) 
            ? json_decode($dokumentasi->perangkat_sentral, true) 
            : $dokumentasi->perangkat_sentral;
            
        $dokumentasi->sarana_penunjang = is_string($dokumentasi->sarana_penunjang) 
            ? json_decode($dokumentasi->sarana_penunjang, true) 
            : $dokumentasi->sarana_penunjang;
            
        $dokumentasi->pelaksana = is_string($dokumentasi->pelaksana) 
            ? json_decode($dokumentasi->pelaksana, true) 
            : $dokumentasi->pelaksana;

        // Calculate total pages for header
        $allPhotos = [];
        foreach($dokumentasi->perangkat_sentral ?? [] as $item) {
            if (!empty($item['photo_path'])) {
                $allPhotos[] = $item;
            }
        }
        foreach($dokumentasi->sarana_penunjang ?? [] as $item) {
            if (!empty($item['photo_path'])) {
                $allPhotos[] = $item;
            }
        }
        
        $photosPerPage = 8;
        $totalPhotoPages = ceil(count($allPhotos) / $photosPerPage);
        $totalPages = 1 + $totalPhotoPages;

        $pdf = Pdf::loadView('dokumentasi.pdf', compact('dokumentasi', 'totalPages'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Dokumentasi_' . $dokumentasi->nomor_dokumen . '_' . date('Ymd_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Helper function to save base64 photo
     */
    private function saveBase64Photo($base64Data, $folder)
    {
        // Remove data:image/jpeg;base64, prefix
        $image = str_replace('data:image/jpeg;base64,', '', $base64Data);
        $image = str_replace(' ', '+', $image);
        $imageData = base64_decode($image);
        
        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.jpg';
        $path = $folder . '/' . $filename;
        
        // Save to storage
        Storage::disk('public')->put($path, $imageData);
        
        return $path;
    }
}
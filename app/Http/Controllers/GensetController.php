<?php

namespace App\Http\Controllers;

use App\Models\GensetMaintenance;
use Intervention\Image\Facades\Image; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting: Tambahkan ini
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GensetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = GensetMaintenance::latest()->paginate(10);
        return view('genset.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genset.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        // (Anda bisa membuat ini lebih ketat, tapi ini adalah awal yang baik)
        $validatedData = $request->validate([
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

            // Validasi untuk semua field result, comment, dan image
            // Gunakan wildcard (*) untuk menangani semua field yang cocok
            '*_result' => 'nullable|string|max:255',
            '*_comment' => 'nullable|string',
            '*_image' => 'nullable|image|max:5120', // Max 5MB
            '*_gps' => 'nullable|string',
        ]);

        // 2. Logika Pemrosesan Gambar & Watermark
        // Daftar ini harus cocok dengan semua nama input gambar di create.blade.php
        $imageFields = [
            // Visual Check
            'environment_condition', 'engine_oil_press_display', 'engine_water_temp_display',
            'battery_connection', 'engine_oil_level', 'engine_fuel_level',
            'running_hours', 'cooling_water_level',
            
            // No Load Test
            'no_load_ac_voltage', 'no_load_output_frequency', 'no_load_battery_charging_current',
            'no_load_engine_cooling_water_temp', 'no_load_engine_oil_press',
            
            // Load Test
            'load_ac_voltage', 'load_ac_current', 'load_output_frequency',
            'load_battery_charging_current', 'load_engine_cooling_water_temp',
            'load_engine_oil_press'
        ];

        foreach ($imageFields as $field) {
            $imageInputName = $field . '_image';
            $gpsInputName = $field . '_gps';

            if ($request->hasFile($imageInputName)) {
                $image = $request->file($imageInputName);
                $gpsCoordinates = $request->input($gpsInputName, 'GPS Not Available');
                
                // Buat teks watermark
                $timestampText = now()->format('d M Y, H:i:s T');
                $fullText = $timestampText . "\n" . $gpsCoordinates;
                
                // Proses gambar dengan Intervention Image v3
                $img = Image::make($image->getRealPath());

                // Tambahkan kotak latar belakang semi-transparan untuk keterbacaan
                $img->rectangle(5, 5, 350, 75, [
                    'background-color' => 'rgba(0, 0, 0, 0.5)'
                ]);

                // Tambahkan teks watermark
                // PERHATIAN: Ini membutuhkan file font.
                $img->text($fullText, 10, 15, function($font) {
                    // Pastikan file font ini ada di folder public/font/
                    $font->file(public_path('font/arial.ttf')); 
                    $font->size(16);
                    $font->color('#ffffff'); // Warna teks putih
                    $font->align('left');
                    $font->valign('top');
                });
                
                // Simpan gambar yang sudah di-watermark ke public storage
                $filename = uniqid($field . '_') . '.jpg';
                $path = 'genset_images/' . $filename;
                
                Storage::disk('public')->put($path, (string) $img->encode('jpg', 80));

                // Simpan path gambar ke dalam data yang akan disimpan ke DB
                $validatedData[$imageInputName] = $path;
            }
        }

        // 3. Buat Nomor Dokumen (Logika Anda yang sudah ada)
        $date = Carbon::parse($validatedData['maintenance_date']);
        $location = strtoupper(substr(str_replace(' ', '', $validatedData['location']), 0, 5));
        $validatedData['doc_number'] = sprintf(
            'FM-LAP/%s/%s/%s/%s',
            $location,
            'GENSET',
            $date->format('Y'),
            GensetMaintenance::whereYear('maintenance_date', $date->year)->count() + 1
        );

        // 4. Simpan ke Database
        GensetMaintenance::create($validatedData);

        // 5. Redirect
        return redirect()->route('genset.index')->with('success', 'Data maintenance genset berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $maintenance = GensetMaintenance::findOrFail($id);
        return view('genset.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $maintenance = GensetMaintenance::findOrFail($id);
        return view('genset.edit', compact('maintenance')); // You'll need to create edit.blade.php
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $maintenance = GensetMaintenance::findOrFail($id);
        $maintenance->update($request->all());

        return redirect()->route('genset.index')->with('success', 'Data maintenance genset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $maintenance = GensetMaintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('genset.index')->with('success', 'Data maintenance genset berhasil dihapus.');
    }
    
    /**
     * Generate PDF for the specified genset maintenance.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        // 1. Ambil data maintenance berdasarkan ID.
        $maintenance = GensetMaintenance::findOrFail($id);

        // 2. Load view blade sebagai template PDF.
        $pdf = PDF::loadView('genset.pdf_template', compact('maintenance'));

        // 3. Atur ukuran kertas dan orientasi.
        $pdf->setPaper('a4', 'portrait');

        // 4. Buat nama file yang aman dengan mengganti karakter '/'
        $safeDocNumber = str_replace('/', '-', $maintenance->doc_number);
        $fileName = 'genset-maintenance-' . $safeDocNumber . '.pdf';

        // 5. Kembalikan PDF sebagai file unduhan di browser.
        return $pdf->download($fileName);
    }
}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Genset Maintenance Report</title>
    <style>
        @page { size: letter; margin: 18mm; }
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #000; margin: 0; padding: 0; } /* Hapus flexbox */
        table { border-collapse: collapse; width: 100%; }
        .header-table td, .main-table th, .main-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; }
        .main-table th { text-align: center; font-weight: bold; }
        .info-table td { border: none; padding: 1px 2px; }
        /* DENGAN INI: (perhatikan titiknya menempel pada 'th' dan 'td') */
th.pelaksana-table, td.pelaksana-table {
    border: 1px solid #000;
    padding: 8px 6px;
    vertical-align: top;
    text-align: left;
    background-color: #fff !important;
    font-weight: normal !important;
}

th.pelaksana-table {
    text-align: center;
}

td.pelaksana-table.center {
    text-align: center;
}
        .mengetahui-section { width: 35%; float: right; text-align: center; margin-top: 15px; }
        .mengetahui-box { border: 1px solid #000; height: 68px; margin-top: 5px; margin-bottom: 2px; position: relative; padding-bottom: 15px; }
        .mengetahui-name-line {
    font-size: 10pt;
    text-align: center;
    padding-bottom: 2px; /* Hapus 'position', 'bottom', 'left', 'right' */
}
.mengetahui-nik-line {
    font-size: 9pt;
    text-align: center; /* Hapus 'position', 'bottom', 'left', 'right' */
}
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .sub-item { padding-left: 10px; }
        .sub-sub-item { padding-left: 20px; }
        .notes-heading { font-weight: bold; margin-top: 10px; margin-bottom: 2px; }
        .notes-box { border: 1px solid #000; padding: 5px; min-height: 30px; }
        .page-break { page-break-after: always; clear: both; }
        .page-break-before { page-break-before: always; clear: both; }
        .avoid-break { page-break-inside: avoid; }
        .page-footer {
            /* Hapus margin-top */
            /* margin-top: 15px; */
            padding-top: 3px;
            border-top: 1px solid #000;
            font-size: 8px;
            text-align: left;
            width: 100%; /* Lebar penuh relatif terhadap area cetak */

            /* [PERUBAHAN] Atur posisi fixed di bawah */
            position: fixed;
            bottom: -10mm; /* Coba nilai negatif dari margin bawah (@page margin: 18mm). Sesuaikan jika perlu */
            left: 0mm; /* Mulai dari margin kiri */
            right: 0mm; /* Sampai margin kanan */
            height: 15mm; /* Beri tinggi agar konten tidak tumpang tindih */
        }
        .image-cell { width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top; }
        .image-cell img { width: 100%; max-height: 180px; object-fit: contain; }
        .image-label { font-size: 10pt; color: #333; margin-top: 2px; font-weight: bold; }
        .error-message { font-size: 7pt; color: red; word-break: break-all; }
        .main-table td[rowspan] { vertical-align: middle; }
    </style>
</head>
<body>

    @php
        $images = $maintenance->images ?? []; $images = is_array($images) ? $images : [];
        $imagesPerPage = 9;
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;

        // [PERBAIKAN] Logika Total Halaman
        // Cek apakah halaman kedua (Notes/Pelaksana) akan dibuat
        $notesPageExists = ($maintenance->notes || $maintenance->technician_1_name || $maintenance->approver_name || $totalImagePages > 0);

        if ($notesPageExists) {
            // Jika halaman kedua ada, total = 1 (Data) + 1 (Notes) + Jumlah Halaman Gambar
            $totalPages = 1 + 1 + $totalImagePages;
        } else {
            // Jika tidak ada halaman kedua, total = 1 (Data) saja
            $totalPages = 1;
        }
    @endphp

    {{-- Konten Halaman Pertama (tanpa wrapper) --}}
    <div class="page-header avoid-break">
        <table class="header-table">
            <tr><td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td><td width="23%" style="font-size: 10pt; vertical-align: top;">: FM-LAP-D2-SOP-003-006</td><td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;"><div style="font-size: 14pt; font-weight: bold;">Formulir</div><div style="font-size: 14pt; font-weight: bold;">Preventive Maintenance</div><div style="font-size: 14pt; font-weight: bold;">Genset</div></td><td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;"><img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;"></td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: 1 dari {{ $totalPages }}</td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
        </table>
    </div>
    <div style="height: 5px;"></div>
    <table class="info-table avoid-break">
        <tr><td width="15%">Location</td><td width="35%">:  {{ $maintenance->central->nama ?? $maintenance->location }}</td><td width="15%">Brand / Type</td><td width="35%">: {{ $maintenance->brand_type ?? '-' }}</td></tr>
        <tr><td>Date / time</td><td>: {{ $maintenance->maintenance_date->format('d M Y / H:i') }}</td><td>Capacity</td><td>: {{ $maintenance->capacity ?? '-' }}</td></tr>
    </table>
    <table class="main-table">
        <thead><tr><th width="5%">No.</th><th width="35%">Descriptions</th><th width="15%">Result</th><th width="30%">Operational Standard</th><th width="15%">Comment</th></tr></thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr><td class="text-center text-bold">1.</td><td colspan="4" class="text-bold">Visual Check</td></tr>
            <tr><td></td><td class="sub-item text-bold">Engine & Generator</td><td></td><td></td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">a. Environment Condition</td><td class="text-center">{{ $maintenance->environment_condition_result }}</td><td>Clean, No dust</td><td>{{ $maintenance->environment_condition_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">b. Engine Oil Press. Display</td><td class="text-center">{{ $maintenance->engine_oil_press_display_result }}</td><td>Normal</td><td>{{ $maintenance->engine_oil_press_display_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">c. Engine Water Temp. Display</td><td class="text-center">{{ $maintenance->engine_water_temp_display_result }}</td><td>Normal</td><td>{{ $maintenance->engine_water_temp_display_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">d. Battery Connection</td><td class="text-center">{{ $maintenance->battery_connection_result }}</td><td>Tight, No Corrosion</td><td>{{ $maintenance->battery_connection_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">e. Engine Oil Level</td><td class="text-center">{{ $maintenance->engine_oil_level_result }}</td><td>High</td><td>{{ $maintenance->engine_oil_level_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">f. Engine Fuel Level</td><td class="text-center">{{ $maintenance->engine_fuel_level_result }}</td><td>High</td><td>{{ $maintenance->engine_fuel_level_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">g. Running Hours</td><td class="text-center">{{ $maintenance->running_hours_result }}</td><td>N/A</td><td>{{ $maintenance->running_hours_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">h. Cooling Water Level</td><td class="text-center">{{ $maintenance->cooling_water_level_result }}</td><td>High</td><td>{{ $maintenance->cooling_water_level_comment }}</td></tr>
            <tr><td class="text-center text-bold">2.</td><td colspan="4" class="text-bold">Engine Running Test</td></tr>
            <tr><td></td><td class="sub-item" colspan="4"><i>I. No Load Test ( 30 minute )</i></td></tr>
            {{-- Perbaikan No Load Voltage --}}
            <tr>
                <td rowspan="2"></td>
                <td class="sub-sub-item text-center" rowspan="2">a. AC Output Voltage</td>
                <td>R–S={{ $maintenance->no_load_ac_voltage_rs }}<br>S–T={{ $maintenance->no_load_ac_voltage_st }}<br>T–R={{ $maintenance->no_load_ac_voltage_tr }}</td>
                <td>360 – 400 VAC</td> {{-- Hapus rowspan --}}
                <td rowspan="2" style="vertical-align: middle;">{{ $maintenance->no_load_ac_voltage_comment }}</td>
            </tr>
            <tr>
                {{-- Deskripsi kosong --}}
                <td>R–N={{ $maintenance->no_load_ac_voltage_rn }}<br>S–N={{ $maintenance->no_load_ac_voltage_sn }}<br>T–N={{ $maintenance->no_load_ac_voltage_tn }}</td>
                <td>180 – 230 VAC</td> {{-- Tambah standar RSN --}}
                {{-- Comment kosong --}}
            </tr>
            <tr><td></td><td class="sub-sub-item">b. Output Frequency</td><td class="text-center">{{ $maintenance->no_load_output_frequency_result }}</td><td>Max 53.00 Hz</td><td>{{ $maintenance->no_load_output_frequency_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">c. Battery Charging Current</td><td class="text-center">{{ $maintenance->no_load_battery_charging_current_result }}</td><td>Max 10 Amp.</td><td>{{ $maintenance->no_load_battery_charging_current_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">d. Engine Cooling Water Temp.</td><td class="text-center">{{ $maintenance->no_load_engine_cooling_water_temp_result }}</td><td>Max 90 deg C</td><td>{{ $maintenance->no_load_engine_cooling_water_temp_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">e. Engine Oil Press.</td><td class="text-center">{{ $maintenance->no_load_engine_oil_press_result }}</td><td>Min 50 Psi</td><td>{{ $maintenance->no_load_engine_oil_press_comment }}</td></tr>
            <tr><td></td><td class="sub-item" colspan="4"><i>II. Load Test ( 30 minute )</i></td></tr>
            {{-- Perbaikan Load Voltage --}}
            <tr>
                <td rowspan="2"></td>
                <td class="sub-sub-item text-center" rowspan="2">a. AC Output Voltage</td>
                <td>R–S={{ $maintenance->load_ac_voltage_rs }}<br>S–T={{ $maintenance->load_ac_voltage_st }}<br>T–R={{ $maintenance->load_ac_voltage_tr }}</td>
                <td>360 – 400 VAC</td> {{-- Hapus rowspan --}}
                <td rowspan="2" style="vertical-align: middle;">{{ $maintenance->load_ac_voltage_comment }}</td>
            </tr>
            <tr>
                {{-- Deskripsi kosong --}}
                <td>R–N={{ $maintenance->load_ac_voltage_rn }}<br>S–N={{ $maintenance->load_ac_voltage_sn }}<br>T–N={{ $maintenance->load_ac_voltage_tn }}</td>
                <td>180 – 230 VAC</td> {{-- Tambah standar RSN --}}
                {{-- Comment kosong --}}
            </tr>

        </tbody>
    </table>
    {{-- [PERUBAHAN] Paksa Page Break Sebelum Notes HANYA jika diperlukan (jika ada notes/pelaksana) --}}
    @if($notesPageExists)
        <div class="page-break-before"></div>

        {{-- [ MANUAL HEADER UNTUK HALAMAN 2 DST. ] --}}
        {{-- Tampilkan header ini jika total halaman > 1 --}}
        @if($totalPages > 1)
            <div class="page-header avoid-break">
                <table class="header-table">
                    <tr><td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td><td width="23%" style="font-size: 10pt; vertical-align: top;">: FM-LAP-D2-SOP-003-006</td><td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;"><div style="font-size: 14pt; font-weight: bold;">Formulir</div><div style="font-size: 14pt; font-weight: bold;">Preventive Maintenance</div><div style="font-size: 14pt; font-weight: bold;">Genset</div></td><td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;"><img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;"></td></tr>
                    <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr>
                    <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: 2 dari {{ $totalPages }}</td></tr> {{-- Asumsikan ini selalu halaman 2 --}}
                    <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
                </table>
            </div>
            <div style="height: 10px;"></div>
        @endif
    @endif
    <table class="main-table">
        <thead style="visibility: hidden; line-height: 0; font-size: 0; border: none;">
                    <tr>
                        <th width="5%">No.</th>
                        <th width="35%">Descriptions</th>
                        <th width="15%">Result</th>
                        <th width="30%">Operational Standard</th>
                        <th width="15%">Comment</th>
                    </tr>
                </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td></td>
                <td class="sub-sub-item text-center" style="vertical-align: middle;">b. AC Output Current</td>
                <td class="sub-sub-item" style="vertical-align: middle;">
                    R={{ $maintenance->load_ac_current_r }}<br>
                    S={{ $maintenance->load_ac_current_s }}<br>
                    T={{ $maintenance->load_ac_current_t }}
                </td>
                <td style="font-size: 10pt; line-height: 1.2;">
                    6 KVA = Max 20 Amp.<br>
                    10 KVA = Max 35 Amp.<br>
                    22 KVA = Max 26 Amp/ph<br>
                    65 KVA = Max 80 Amp/ph<br>
                    100 KVA = Max 120 Amp/ph<br>
                    250 KVA = Max 300 Amp/ph
                </td>
                <td>{{ $maintenance->load_ac_current_comment }}</td>
            </tr>
            <tr><td></td><td class="sub-sub-item">c. Output Frequency</td><td class="text-center">{{ $maintenance->load_output_frequency_result }}</td><td>50.00 Hz</td><td>{{ $maintenance->load_output_frequency_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">d. Battery Charging Current</td><td class="text-center">{{ $maintenance->load_battery_charging_current_result }}</td><td>Max 10 Amp.</td><td>{{ $maintenance->load_battery_charging_current_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">e. Engine Cooling Water Temp.</td><td class="text-center">{{ $maintenance->load_engine_cooling_water_temp_result }}</td><td>Max 90 deg C</td><td>{{ $maintenance->load_engine_cooling_water_temp_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">f. Engine Oil Press.</td><td class="text-center">{{ $maintenance->load_engine_oil_press_result }}</td><td>Min 50 Psi</td><td>{{ $maintenance->load_engine_oil_press_comment }}</td></tr>
        </tbody>
    </table>

    {{-- Notes dan Pelaksana (selalu setelah potensi page break) --}}
    <div class="notes-heading avoid-break">Notes / additional informations :</div>
    <div class="notes-box avoid-break"> {!! nl2br(e($maintenance->notes ?? 'Tidak ada catatan.')) !!} </div><br>
    <div class="signature-section avoid-break">
        {{-- [PERBAIKAN] Menggunakan 1 tabel + 1 kolom pemisah (gutter) --}}
        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td colspan="4" style="vertical-align: top; border: none; padding: 0 0 3px 0;">
                        <div class="text-bold" style="margin-bottom: 3px;">Pelaksana</div>
                    </td>

                    <td style="width: 5%; border: none;">&nbsp;</td>

                    <td style="width: 35%; vertical-align: top; text-align: center; border: none; padding: 0 0 3px 0;">
                         <span class="text-bold">Mengetahui</span>
                    </td>
                </tr>

                <tr>
                    <th class="pelaksana-table" style="width: 5%;">No</th>
                    <th class="pelaksana-table" style="width: 18%;">Nama</th>
                    <th class="pelaksana-table" style="width: 17%;">Departement</th>
                    <th class="pelaksana-table" style="width: 20%;">Sub Departement</th>

                    <td rowspan="4" style="border: none; width: 5%;">&nbsp;</td> <td rowspan="4" style="border: 1px solid #000; text-align: center; vertical-align: bottom; width: 35%;">
                        <div style="padding-bottom: 5px;">
                            <div class="mengetahui-name-line">({{ $maintenance->approver_name ?? '..................' }})</div>
                            <div class="mengetahui-nik-line">(NIK: {{ $maintenance->approver_nik ?? '..................' }})</div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="pelaksana-table center">1</td>
                    <td class="pelaksana-table">{{ $maintenance->technician_1_name }}</td>
                    <td class="pelaksana-table">{{ $maintenance->technician_1_department }}</td>
                    <td class="pelaksana-table"></td>
                </tr>

                <tr>
                    <td class="pelaksana-table center">2</td>
                    <td class="pelaksana-table">{{ $maintenance->technician_2_name ?? '-' }}</td>
                    <td class="pelaksana-table">{{ $maintenance->technician_2_department ?? '-' }}</td>
                    <td class="pelaksana-table"></td>
                </tr>

                <tr>
                    <td class="pelaksana-table center">3</td>
                    <td class="pelaksana-table">{{ $maintenance->technician_3_name ?? '-' }}</td>
                    <td class="pelaksana-table">{{ $maintenance->technician_3_department ?? '-' }}</td>
                    <td class="pelaksana-table"></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Footer Halaman Terakhir Bagian Data --}}
    <div class="page-footer">
         ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia.<br>
         <span style="font-weight: bold;">FM-LAP-D2-SOP-003-006 Formulir Preventive Maintenance Genset</span>
    </div>


    @if(!empty($images) && count($images) > 0)
        @php
            $imageChunks = array_chunk($images, $imagesPerPage);
            // [PERBAIKAN FINAL] Halaman gambar selalu dimulai dari halaman ke-3
            // karena halaman 1 adalah data, halaman 2 adalah notes/pelaksana.
            $startImagePage = 3;
        @endphp
        @foreach($imageChunks as $chunkIndex => $imageChunk)
            <div class="page-break"></div>
            {{-- Header Halaman Gambar --}}
            <div class="page-header avoid-break">
                <table class="header-table">
                   {{-- Konten header halaman gambar --}}
                   <tr><td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td><td width="23%" style="font-size: 10pt; vertical-align: top;">: FM-LAP-D2-SOP-003-006</td><td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;"><div style="font-size: 14pt; font-weight: bold;">Formulir</div><div style="font-size: 14pt; font-weight: bold;">Preventive Maintenance</div><div style="font-size: 14pt; font-weight: bold;">Genset</div></td><td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;"><img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;"></td></tr>
                   <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr>
                   {{-- [PERBAIKAN FINAL] Gunakan $startImagePage + index --}}
                   <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: {{ $startImagePage + $chunkIndex }} dari {{ $totalPages }}</td></tr>
                   <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
                </table>
            </div>
            {{-- Konten Gambar --}}
            <div style="margin-top: 10px; margin-bottom: 10px;">
                <div class="text-bold" style="margin-bottom: 5px;">Documentation Images @if($totalImagePages > 1)(Page {{ $chunkIndex + 1 }} of {{ $totalImagePages }})@endif:</div>
                <table style="width: 100%; border-collapse: collapse;">
                    @foreach(array_chunk($imageChunk, 3) as $rowImages) <tr style="page-break-inside: avoid;">
                        @foreach($rowImages as $image)
                            @if(is_array($image) && isset($image['path']) && !empty($image['path']))
                                <td class="image-cell">
                                    @php
                                        $imagePath = $image['path'];
                                        $fullPath = public_path('storage/' . $imagePath);
                                        $fileExists = is_file($fullPath);

                                        // Optimize image data
                                        $imageData = null;
                                        if ($fileExists) {
                                            try {
                                                // Get image info
                                                $imageInfo = @getimagesize($fullPath);
                                                if ($imageInfo !== false) {
                                                    // Convert to base64 with reduced quality for PDF
                                                    $imageData = 'data:' . $imageInfo['mime'] . ';base64,' . base64_encode(file_get_contents($fullPath));
                                                }
                                            } catch (\Exception $e) {
                                                $fileExists = false;
                                            }
                                        }
                                    @endphp
                                    @if($fileExists && $imageData)
                                        <img src="{{ $imageData }}" alt="{{ $image['category'] ?? 'Genset Image' }}" style="max-width: 100%; max-height: 180px; object-fit: contain;">
                                    @else
                                        <div style="height: 180px; background: #f0f0f0; display: table-cell; vertical-align: middle; color: #999; padding: 5px;"><p class="error-message">Image Not Found!</p></div>
                                    @endif
                                    <div class="image-label">{{ ucwords(str_replace(['_result', '_'], ['', ' '], $image['category'] ?? 'Image')) }}</div>
                                </td>
                            @else
                                <td class="image-cell" style="background: #f8f8f8;"><div style="height: 200px; display: table-cell; vertical-align: middle; color: #ccc;">Invalid Data</div></td>
                            @endif
                        @endforeach
                        @for($i = count($rowImages); $i < 3; $i++) <td style="width: 33.33%; border: none;"></td> @endfor
                    </tr> @endforeach
                </table>
            </div>
            {{-- Footer Halaman Gambar --}}
            <div class="page-footer">
                 ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia.<br>
                 <span style="font-weight: bold;">FM-LAP-D2-SOP-003-006 Formulir Preventive Maintenance Genset</span>
            </div>
        @endforeach
    @endif

</body>
</html>

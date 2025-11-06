<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir Preventive Maintenance Inverter -48VDC/220VAC</title>
    <style>
        @page {
            margin: 15mm 15mm 25mm 15mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.3;
        }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .header-table td {
            border: 1px solid #000;
            padding: 1.5px 4px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            background-color: transparent;
        }

        .info-table td {
            padding: 2px 4px;
            font-size: 9pt;
        }

        .info-table td:nth-child(2) {
            font-weight: bold;
        }

        .page-header {
            margin-bottom: 8px;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 15mm;
            right: 15mm;
            font-size: 8px;
            border-top: 1px solid #ccc;
            text-align: left;
            padding-top: 5px;
        }

        /* ===== TABEL UTAMA ===== */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.main-table th,
        table.main-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 9px;
            vertical-align: middle;
        }

        table.main-table th {
            background: transparent;
            font-weight: bold;
        }

        table.main-table td {
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            text-align: left;
            background: #d3d3d3;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 50px;
            padding: 5px;
            margin-top: 10px;
            font-weight: bold;
        }

        /* Style untuk strikethrough */
        .strikethrough {
            text-decoration: line-through;
        }

        /* ===== PELAKSANA DAN MENGETAHUI ===== */
        .sig-table-wrap {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .pelaksana-inner {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .pelaksana-inner thead th {
            border: 1px solid #000;
            background: transparent;
            padding: 4px;
            text-align: center;
            font-weight: normal;
            font-size: 9px;
        }

        .pelaksana-inner tbody td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
            font-size: 9px;
            font-weight: bold;
        }

        .pelaksana-inner tbody tr.signature-row {
            height: 28px;
        }

        .mengetahui-box-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .mengetahui-box-table td {
            border: 1px solid #000;
            vertical-align: bottom;
            text-align: center;
            padding-bottom: 10px;
            font-size: 10px;
        }

        .ttd-line {
            display: inline-block;
            width: 140px;
            border-bottom: 1px solid #000;
            margin-top: 6px;
        }

        .sig-heading {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 6px;
        }

        /* ===== FOTO ===== */
        .page-break {
            page-break-before: always;
        }

        .photo-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .photo-row {
            display: table-row;
        }

        .photo-cell {
            display: table-cell;
            width: 48%;
            padding: 5px;
            vertical-align: top;
            text-align: center;
        }

        .photo-container {
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 10px;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .photo-container img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
        }

        .photo-code {
            margin-top: 5px;
            font-weight: bold;
            font-size: 9px;
            text-align: center;
        }

        .no-photo {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    @php
        // HITUNG TOTAL HALAMAN DI AWAL
        $dataChecklist = $inverter->data_checklist ?? [];
        
        // Kumpulkan semua foto untuk menghitung total halaman
        $totalPhotos = 0;
        if (is_array($dataChecklist)) {
            foreach($dataChecklist as $item) {
                if (isset($item['photos']) && is_array($item['photos'])) {
                    foreach($item['photos'] as $photo) {
                        if (isset($photo['photo_path']) && !empty($photo['photo_path'])) {
                            $photoFullPath = storage_path('app/public/' . $photo['photo_path']);
                            if (file_exists($photoFullPath)) {
                                $totalPhotos++;
                            }
                        }
                    }
                }
            }
        }
        
        // 6 foto per halaman (3 baris x 2 kolom)
        $photosPerPage = 6;
        $totalPhotoPages = $totalPhotos > 0 ? ceil($totalPhotos / $photosPerPage) : 0;
        $totalPages = 1 + $totalPhotoPages;
    @endphp

    {{-- ========================================
         HALAMAN 1: DATA CHECKLIST
    ======================================== --}}
    
    <!-- Header -->
    <div class="page-header">
        <table class="header-table">
            <tr>
                <td width="15%" style="vertical-align: top;">
                    <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-008</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 12pt;">Inverter -48VDC/220VAC</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    @php
                        $logoPath = public_path('assets/images/logo2.png');
                    @endphp
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Logo" style="width:60px; height:auto;">
                    @else
                        <div style="font-size:8px;">Logo not found</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Versi</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">1.0</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Hal</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">1 dari {{ $totalPages }}</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Label</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Internal</div>
                </td>
            </tr>
        </table>

        <!-- Info Section -->
        <table class="info-table" style="margin-top:5px;">
            <tr>
                <td width="18%">Location</td>
                <td width="82%">: {{ $inverter->lokasi }}</td>
            </tr>
            <tr>
                <td width="18%">Date / time</td>
                <td width="82%">: {{ \Carbon\Carbon::parse($inverter->tanggal_dokumentasi)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td width="18%">Brand / Type</td>
                <td width="82%">: {{ $inverter->brand ?? '-' }}</td>
            </tr>
            <tr>
                <td width="18%">Reg. Number</td>
                <td width="82%">: {{ $inverter->reg_num ?? '-' }}</td>
            </tr>
            <tr>
                <td width="18%">S/N</td>
                <td width="82%">: {{ $inverter->serial_num ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Main Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th style="width:8%;">No.</th>
                <th style="width:35%;">Descriptions</th>
                <th style="width:15%;">Result</th>
                <th style="width:30%;">Operational Standard</th>
                <th style="width:12%;">Status<br>(OK/NOK)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $environmentData = collect($dataChecklist)->firstWhere('nama', 'Environment Condition');
                $ledData = collect($dataChecklist)->firstWhere('nama', 'LED Display');
                $dcVoltageData = collect($dataChecklist)->firstWhere('nama', 'DC Input Voltage');
                $dcCurrentData = collect($dataChecklist)->firstWhere('nama', 'DC Current Input');
                $acCurrentData = collect($dataChecklist)->firstWhere('nama', 'AC Current Output');
                $neutralGroundData = collect($dataChecklist)->firstWhere('nama', 'Neutral - Ground Output Voltage');
                $temperatureData = collect($dataChecklist)->firstWhere('nama', 'Equipment Temperature');
                
                // Tentukan tipe inverter berdasarkan pilihan user
                $dcCurrentType = $inverter->dc_current_inverter_type ?? '500';
                $acCurrentType = $inverter->ac_current_inverter_type ?? '500';
            @endphp
            
            <!-- Visual Check Section -->
            <tr class="section-title">
                <td>1.</td>
                <td colspan="4" style="text-align:left; padding-left:10px;">Visual Check</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">a. Environment Condition</td>
                <td>{{ $environmentData['status'] ?? '' }}</td>
                <td>Clean, No dust</td>
                <td>{{ $environmentData['tegangan'] ?? '' }}</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">b. LED / Display *)</td>
                <td>{{ $ledData['status'] ?? '' }}</td>
                <td>Normal</td>
                <td>{{ $ledData['tegangan'] ?? '' }}</td>
            </tr>

            <!-- Performance and Capacity Check Section -->
            <tr class="section-title">
                <td>2.</td>
                <td colspan="4" style="text-align:left; padding-left:10px;">Performance and Capacity Check</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">a. DC Input Voltage</td>
                <td>{{ $inverter->dc_input_voltage ? number_format($inverter->dc_input_voltage, 1) . ' VDC' : '' }}</td>
                <td>48 - 54 VDC</td>
                <td>{{ $dcVoltageData['status'] ?? '' }}</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">b. DC Current Input *)</td>
                <td>{{ $inverter->dc_current_input ? number_format($inverter->dc_current_input, 1) . ' A' : '' }}</td>
                <td>
                    @if($dcCurrentType == '500')
                        &le; 9 A ( 500 VA )<br><span class="strikethrough">&le; 18 A ( 1000 VA )</span>
                    @else
                        <span class="strikethrough">&le;; 9 A ( 500 VA )</span><br>&le; 18 A ( 1000 VA )
                    @endif
                </td>
                <td>{{ $dcCurrentData['status'] ?? '' }}</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">c. AC Current Output *)</td>
                <td>{{ $inverter->ac_current_output ? number_format($inverter->ac_current_output, 1) . ' A' : '' }}</td>
                <td>
                    @if($acCurrentType == '500')
                        &le; 2 A ( 500 VA )<br><span class="strikethrough">&le; 4 A ( 1000 VA )</span>
                    @else
                        <span class="strikethrough">&le; 2 A ( 500 VA )</span><br>&le; 4 A ( 1000 VA )
                    @endif
                </td>
                <td>{{ $acCurrentData['status'] ?? '' }}</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">d. Neutral – Ground Output Voltage</td>
                <td>{{ $inverter->neutral_ground_output_voltage ? number_format($inverter->neutral_ground_output_voltage, 1) . ' VAC' : '' }}</td>
                <td>&le; 1 Volt AC</td>
                <td>{{ $neutralGroundData['status'] ?? '' }}</td>
            </tr>
            
            <tr>
                <td></td>
                <td style="text-align:left; padding-left:15px;">e. Equipment Temperature</td>
                <td>{{ $inverter->equipment_temperature ? number_format($inverter->equipment_temperature, 0) . ' °C' : '' }}</td>
                <td>0-35 °C</td>
                <td>{{ $temperatureData['status'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <p style="font-size:8px; margin-top:5px;">*) Choose the appropriate</p>

    <!-- Notes -->
    <div style="margin-top:10px;">
        <strong>Notes / additional informations :</strong>
        <div class="notes-box">
            {{ $inverter->keterangan ?? '' }}
        </div>
    </div>

    <!-- Pelaksana & Mengetahui -->
    <table class="sig-table-wrap">
        <tr>
            <td style="width:75%; vertical-align:top; padding-right:10px;">
                <div class="sig-heading">Pelaksana :</div>
                <table class="pelaksana-inner">
                    <thead>
                        <tr>
                            <th style="width:8%;">No</th>
                            <th style="width:38%;">Name</th>
                            <th style="width:32%;">Perusahaan</th>
                            <th style="width:22%;">Tanda Tangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pelaksana = $inverter->pelaksana ?? [];
                            $rows = max(3, count($pelaksana));
                        @endphp
                        @for($r = 0; $r < $rows; $r++)
                            <tr class="signature-row">
                                <td>{{ $r+1 }}.</td>
                                <td style="padding-left:6px;">{{ $pelaksana[$r]['nama'] ?? '' }}</td>
                                <td style="padding-left:6px;">{{ $pelaksana[$r]['perusahaan'] ?? '' }}</td>
                                <td></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>
            <td style="width:25%; vertical-align:top; text-align:center; padding-left:10px;">
    <div class="sig-heading" style="text-align:center;">Mengetahui,</div>
    <table class="mengetahui-box-table" style="height:120px; width:100%;">
        <tr>
            <td>
                <div style="height:66px;"></div>
                (<span style="display:inline-block; width:140px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">{{ $inverter->boss ?? '________________' }}</span>)
            </td>
        </tr>
    </table>
</td>

        </tr>
    </table>

    <!-- Footer Halaman 1 -->
    <div class="footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-008 Formulir Preventive Maintenance Inverter -48VDC/220VAC
    </div>

{{-- ========================================
     HALAMAN 2+: FOTO DOKUMENTASI
======================================== --}}

@php
    // Kumpulkan semua foto dengan kode
    $allPhotos = [];
    
    // Definisi mapping nama field ke kode foto
    $photoCodeMap = [
        'Environment Condition' => '1.a',
        'LED Display' => '1.b',
        'DC Input Voltage' => '2.a',
        'DC Current Input' => '2.b',
        'AC Current Output' => '2.c',
        'Neutral - Ground Output Voltage' => '2.d',
        'Equipment Temperature' => '2.e',
    ];
    
    // Loop through data_checklist
    if (is_array($dataChecklist)) {
        foreach($dataChecklist as $index => $item) {
            $itemName = $item['nama'] ?? 'Unknown';
            $baseCode = $photoCodeMap[$itemName] ?? (($index + 1) . '.x');
            
            // Cek apakah ada array photos
            if (isset($item['photos']) && is_array($item['photos'])) {
                foreach($item['photos'] as $photoIndex => $photo) {
                    // Cek photo_path
                    if (isset($photo['photo_path']) && !empty($photo['photo_path'])) {
                        // Konversi photo_path ke full path
                        $photoFullPath = storage_path('app/public/' . $photo['photo_path']);
                        
                        if (file_exists($photoFullPath)) {
                            $allPhotos[] = [
                                'path' => $photo['photo_path'],
                                'full_path' => $photoFullPath,
                                'code' => $baseCode . '.' . ($photoIndex + 1),
                                'nama' => $itemName,
                                'latitude' => $photo['photo_latitude'] ?? null,
                                'longitude' => $photo['photo_longitude'] ?? null,
                                'timestamp' => $photo['photo_timestamp'] ?? null,
                            ];
                        }
                    }
                }
            }
        }
    }
@endphp

@if(count($allPhotos) > 0)
    @php
        // 9 foto per halaman (3 baris x 3 kolom)
        $photosPerPage = 9;
        $photoChunks = array_chunk($allPhotos, $photosPerPage);
    @endphp
    
    @foreach($photoChunks as $pageIndex => $pagePhotos)
        <div style="page-break-before: always;">
            <!-- Header untuk halaman foto -->
            <div class="page-header">
                <table class="header-table">
                    <tr>
                        <td width="15%" style="vertical-align: top;">
                            <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                        </td>
                        <td width="30%" style="vertical-align: top;">
                            <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-008</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                            <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                            <div style="font-weight: bold; font-size: 12pt;">Inverter -48VDC/220VAC</div>
                        </td>
                        <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            @if(file_exists($logoPath))
                                <img src="{{ $logoPath }}" alt="Logo" style="width:60px; height:auto;">
                            @else
                                <div style="font-size:8px;">Logo not found</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Versi</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">1.0</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Hal</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">{{ $pageIndex + 2 }} dari {{ $totalPages }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Label</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Internal</div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Dokumentasi Foto Section -->
            <div style="margin-top: 8px; margin-bottom: 5px; border: 1px solid #000; border-radius: 4px; padding: 6px;">
                <div style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px; font-weight: bold;">
                    Dokumentasi Foto{{ $pageIndex > 0 ? ' (Lanjutan ' . ($pageIndex + 1) . ')' : '' }}
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    @foreach(array_chunk($pagePhotos, 3) as $rowIndex => $rowPhotos)
                        <tr>
                            @foreach($rowPhotos as $colIndex => $photo)
                                <td style="width: 33.33%; padding: 4px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                                    @if(file_exists($photo['full_path']))
                                        <img src="{{ $photo['full_path'] }}"
                                             alt="Foto {{ $photo['nama'] }}"
                                             style="width: 100%; max-height: 180px; object-fit: contain; margin-bottom: 4px;">
                                        
                                        {{-- Kode dan Judul di bawah foto --}}
                                        <div style="font-size: 8pt; font-weight: bold; color: #000; margin-bottom: 3px; padding: 2px; background: #f5f5f5; border-radius: 2px;">
                                            {{ $photo['code'] }}. {{ $photo['nama'] }}
                                        </div>

                                        {{-- Info foto (opsional) --}}
                                        @if($photo['timestamp'] || ($photo['latitude'] && $photo['longitude']))
                                            <div style="font-size: 7pt; color: #666; text-align: left; padding: 2px;">
                                                @if($photo['timestamp'])
                                                    <div><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($photo['timestamp'])->format('d/m/Y H:i') }}</div>
                                                @endif
                                                @if($photo['latitude'] && $photo['longitude'])
                                                    <div><strong>Koordinat:</strong> {{ number_format($photo['latitude'], 6) }}, {{ number_format($photo['longitude'], 6) }}</div>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div style="width: 100%; height: 180px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt;">
                                            Foto tidak ditemukan
                                        </div>
                                        <div style="font-size: 8pt; font-weight: bold; color: #000; margin-top: 4px;">
                                            {{ $photo['code'] }}. {{ $photo['nama'] }}
                                        </div>
                                    @endif
                                </td>
                            @endforeach

                            {{-- Isi sel kosong jika foto tidak sampai 3 --}}
                            @for($i = count($rowPhotos); $i < 3; $i++)
                                <td style="width: 33.33%; padding: 4px; border: none;"></td>
                            @endfor
                        </tr>
                    @endforeach
                </table>
            </div>

            <!-- Footer untuk halaman foto -->
            <div class="footer">
                ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                FM-LAP-D2-SOP-003-008 Formulir Preventive Maintenance Inverter -48VDC/220VAC
            </div>
        </div>
    @endforeach
@endif

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Formulir Preventive Maintenance Inverter -48VDC/220VAC</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 20mm 30mm 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            color: #000;
            margin: 0;
            padding: 0;
            line-height: 1.3;
            position: relative;
            min-height: 100vh;
        }

        /* Special class for symbols only */
        .unicode-symbol {
            font-family: 'DejaVu Sans', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px 5px;
        }

.header-table {
            margin-bottom: 3px;
            border-collapse: collapse;
            width: 100%;
        }

        .header-table td {
            border: 1px solid #000;
            padding: 2px 4px;
        }

        .info-table {
            margin-bottom: 4px;
        }

        .info-table td {
            border: none;
            padding: 2px 5px;
        }

        /* Footer - Fixed at bottom */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 20px;
            border-top: 1px solid #000;
            font-size: 8.5px;
            text-align: left;
            background: white;
        }

        .main-table th, .main-table td {
            padding: 3px 5px;
            font-size: 8.5pt;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .small-text {
            font-size: 7.5pt;
            line-height: 1.2;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 25px;
            padding: 3px 5px;
            margin-bottom: 3px;
        }

        /* Ensure signature stays together */
        .signature-section {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            display: block;
        }

        /* Page break control */
        .page-break {
            page-break-after: always;
            clear: both;
        }

        .avoid-break {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .keep-together {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        /* Image styling for aspect ratio preservation */
        .image-cell {
            width: 33.33%;
            height: 360px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .image-container {
            height: 330px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container img {
            max-width: 100%;
            max-height: 325px;
            width: auto;
            height: auto;
            object-fit: contain;
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
                    <div style="font-size: 9pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-008</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 13pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 13pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 13pt;">Inverter -48VDC/220VAC</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    @php
                        $logoPath = public_path('assets/images/logo2.png');
                        $logoBase64 = '';
                        if (file_exists($logoPath)) {
                            $logoContent = file_get_contents($logoPath);
                            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);
                        }
                    @endphp
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo" style="width:65px; height:auto;">
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

        {{-- Info Table --}}
        <table class="info-table" style="margin-top: 3px;">
            <tr>
                <td width="18%" style="font-size: 9pt;">Location</td>
                <td width="32%" style="font-size: 9pt; font-weight: bold;">: {{ $inverter->lokasi }}</td>
                <td width="18%" style="font-size: 9pt;">Reg. Number</td>
                <td width="32%" style="font-size: 9pt; font-weight: bold;">: {{ $inverter->reg_num ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-size: 9pt;">Date / Time</td>
                <td style="font-size: 9pt; font-weight: bold;">: {{ \Carbon\Carbon::parse($inverter->tanggal_dokumentasi)->format('d/m/Y') }} {{ $inverter->waktu ?? '' }}</td>
                <td style="font-size: 9pt;">S/N</td>
                <td style="font-size: 9pt; font-weight: bold;">: {{ $inverter->serial_num ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-size: 9pt;">Brand / Type</td>
                <td colspan="3" style="font-size: 9pt; font-weight: bold;">: {{ $inverter->brand ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Main Table --}}
    <table class="main-table" style="margin-bottom: 3px;">
        <thead>
            <tr>
                <th width="18">No.</th>
                <th width="150">Descriptions</th>
                <th width="85">Result</th>
                <th width="110">Operational Standard</th>
                <th width="48">Status<br>(OK/NOK)</th>
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

            {{-- Visual Check --}}
            <tr>
                <td class="center bold">1.</td>
                <td class="bold" colspan="4">Visual Check</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Environment Condition</td>
                <td>{{ $environmentData['status'] ?? '' }}</td>
                <td>Clean, No dust</td>
                <td class="center">{{ $environmentData['tegangan'] ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. LED / Display *)</td>
                <td>{{ $ledData['status'] ?? '' }}</td>
                <td>Normal</td>
                <td class="center">{{ $ledData['tegangan'] ?? '' }}</td>
            </tr>

            {{-- Performance and Capacity Check --}}
            <tr>
                <td class="center bold">2.</td>
                <td class="bold" colspan="4">Performance and Capacity Check</td>
            </tr>
            <tr>
                <td></td>
                <td>a. DC Input Voltage</td>
                <td>{{ $inverter->dc_input_voltage ? number_format($inverter->dc_input_voltage, 1) . ' VDC' : '' }}</td>
                <td>48 - 54 VDC</td>
                <td class="center">{{ $dcVoltageData['status'] ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. DC Current Input *)</td>
                <td>{{ $inverter->dc_current_input ? number_format($inverter->dc_current_input, 1) . ' A' : '' }}</td>
                <td>
                    @if($dcCurrentType == '500')
                        &le; 9 A ( 500 VA )<br><span style="text-decoration: line-through;">&le; 18 A ( 1000 VA )</span>
                    @else
                        <span style="text-decoration: line-through;">&le; 9 A ( 500 VA )</span><br>&le; 18 A ( 1000 VA )
                    @endif
                </td>
                <td class="center">{{ $dcCurrentData['status'] ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>c. AC Current Output *)</td>
                <td>{{ $inverter->ac_current_output ? number_format($inverter->ac_current_output, 1) . ' A' : '' }}</td>
                <td>
                    @if($acCurrentType == '500')
                        &le; 2 A ( 500 VA )<br><span style="text-decoration: line-through;">&le; 4 A ( 1000 VA )</span>
                    @else
                        <span style="text-decoration: line-through;">&le; 2 A ( 500 VA )</span><br>&le; 4 A ( 1000 VA )
                    @endif
                </td>
                <td class="center">{{ $acCurrentData['status'] ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>d. AC Output Voltage</td>
                <td>{{ $inverter->ac_output_voltage ? number_format($inverter->ac_output_voltage, 1) . ' VAC' : '' }}</td>
                <td>&le; 1 Volt AC</td>
                <td class="center">{{ $neutralGroundData['status'] ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>e. Equipment Temperature</td>
                <td>{{ $inverter->equipment_temperature ? number_format($inverter->equipment_temperature, 0) . ' °C' : '' }}</td>
                <td>0-35 °C</td>
                <td class="center">{{ $temperatureData['status'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <div style="font-size:8px; margin-bottom:3px;">*) Choose the appropriate</div>

    {{-- Notes --}}
    <div class="notes-box" style="max-height: 45px; overflow: hidden; page-break-after: avoid;">
        <span class="bold" style="font-size: 9pt;">Notes / additional informations :</span><br>
        <span style="font-size: 8.5pt;">{{ $inverter->keterangan ?? '' }}</span>
    </div>

    {{-- Signature Table --}}
    <div class="signature-section keep-together" style="margin-top: 3px;">
        <table style="border-collapse: collapse; width: 100%; page-break-inside: avoid;">
            <tr>
                {{-- Header Row --}}
                <th colspan="4" style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 9pt; font-weight: bold;">Executor</th>
                <th style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 9pt; font-weight: bold;">Verifikator</th>
                <th style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 9pt; font-weight: bold;">Head Of Sub<br>Departement</th>
            </tr>
            <tr>
                {{-- Sub Header for Executor --}}
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 5%; font-weight: bold;">No</th>
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 25%; font-weight: bold;">Nama</th>
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 15%; font-weight: bold;">Mitra / Internal</th>
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 15%; font-weight: bold;">Signature</th>
                <td rowspan="5" style="border: 1px solid #000; padding: 10px; vertical-align: bottom; text-align: center; width: 20%;">
                    @if($inverter->verifikator)
                        <div style="margin-bottom: 40px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( {{ $inverter->verifikator }} )
                            @if($inverter->verifikator_nik)
                                <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $inverter->verifikator_nik }}</div>
                            @endif
                        </div>
                    @else
                        <div style="margin-bottom: 40px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( _________________ )
                        </div>
                    @endif
                </td>
                <td rowspan="5" style="border: 1px solid #000; padding: 10px; vertical-align: bottom; text-align: center; width: 20%;">
                    @if($inverter->head_of_sub_department)
                        <div style="margin-bottom: 40px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( {{ $inverter->head_of_sub_department }} )
                            @if($inverter->head_of_sub_department_nik)
                                <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $inverter->head_of_sub_department_nik }}</div>
                            @endif
                        </div>
                    @else
                        <div style="margin-bottom: 40px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( _________________ )
                        </div>
                    @endif
                </td>
            </tr>
            {{-- Executor Rows (4 rows) --}}
            @for($i = 1; $i <= 4; $i++)
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 8pt;">{{ $i }}</td>
                <td style="border: 1px solid #000; padding: 3px; font-size: 8pt;">{{ $inverter->{'executor_'.$i} ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-size: 8pt;">{{ $inverter->{'mitra_internal_'.$i} ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: center; height: 25px;"></td>
            </tr>
            @endfor
        </table>
    </div>

    {{-- Footer for Page 1 --}}
    <div class="page-footer">
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

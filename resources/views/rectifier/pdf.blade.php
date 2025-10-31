<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Formulir Preventive Maintenance Battery</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 7.5pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 1px 4px;
        }

        .no-border {
            border: none !important;
        }

        .header-table th,
        .header-table td {
            border: 1px solid #000;
            padding: 1px 4px;
        }

        .header-table {
            margin-bottom: 2px;
            width: 100%;
        }

        .info-table td {
            border: none;
            padding: 1px 4px;
        }

        .info-table {
            margin-bottom: 4px;
            width: 100%;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .bank-container {
            width: 76%;
            margin-bottom: 10px;
        }

        .bank-table {
            width: 32%;
            float: left;
            margin-right: 1.5%;
            border-collapse: collapse;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .bank-table:nth-child(3n) {
            margin-right: 0;
        }

        .bank-header {
            background: #e0e0e0;
            font-weight: bold;
            text-align: left;
            padding: 3px 4px !important;
            border: 1px solid #000;
            font-size: 7.5pt;
            line-height: 1.2;
        }

        .bank-table th,
        .bank-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            font-size: 7.5pt;
        }

        .bank-table th {
            background: #e0e0e0;
            font-weight: bold;
        }

        .no-col {
            width: 25%;
        }

        .voltage-col {
            width: 30%;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 60px;
            padding: 2px 4px;
            margin-bottom: 3px;
            overflow: hidden;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }

        .signature-table th,
        .signature-table td {
            border: 1px solid #000;
            padding: 1px 3px;
        }

        .signature-table th {
            background: #e0e0e0;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
            clear: both;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        .page-header {
            margin-bottom: 3px;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding-top: 2px;
            border-top: 1px solid #000;
            font-size: 6.5px;
            text-align: left;
            background: white;
        }

        .content-wrapper {
            margin-bottom: 50px;
        }

        .clear {
            clear: both;
        }

        .footer-note {
            clear: both;
            font-size: 7pt;
            margin-top: 5px;
            margin-bottom: 8px;
        }

        /* Image Grid Styles - Same as Rectifier */
        .image-grid {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .image-cell {
            width: 33.33%;
            padding: 3px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .image-cell img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
        }

        .image-label {
            font-size: 7pt;
            color: #666;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    @php
    // Calculate total pages
    $hasPhotos = $maintenance->readings->filter(function($reading) {
    return $reading->photo_path && Storage::disk('public')->exists($reading->photo_path);
    })->count() > 0;

    $photoReadings = $hasPhotos ? $maintenance->readings->filter(function($reading) {
    return $reading->photo_path && Storage::disk('public')->exists($reading->photo_path);
    }) : collect();

    $imagesPerPage = 9;
    $totalImagePages = $hasPhotos ? ceil($photoReadings->count() / $imagesPerPage) : 0;
    $totalPages = 1 + $totalImagePages;
    @endphp

    {{-- PAGE 1: Main Content --}}
    <div class="content-wrapper">
        <div class="page-header">
            <table class="header-table">
                <tr>
                    <td width="15%" style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 7pt;">No. Dok.</div>
                    </td>
                    <td width="30%" style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 7pt;">FM-LAP-D2-SOP-003-013</div>
                    </td>
                    <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 9pt;">Formulir</div>
                        <div style="font-weight: bold; font-size: 9pt;">Preventive Maintenance</div>
                        <div style="font-weight: bold; font-size: 9pt;">Battery</div>
                    </td>
                    <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                        @php
                        $logoPath = public_path('assets/images/logo2.png');
                        if (file_exists($logoPath)) {
                        $logoData = base64_encode(file_get_contents($logoPath));
                        $logoSrc = 'data:image/png;base64,' . $logoData;
                        } else {
                        $logoSrc = '';
                        }
                        @endphp
                        @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="Logo" style="width:45px; height:auto;">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Versi</div>
                    </td>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">1.0</div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Hal</div>
                    </td>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">1 dari {{ $totalPages }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Label</div>
                    </td>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Internal</div>
                    </td>
                </tr>
            </table>

            <table class="info-table" style="margin-top: 3px;">
                <tr>
                    <td width="20%">Location</td>
                    <td width="30%">: {{ $maintenance->location }}</td>
                    <td width="20%">Doc Number</td>
                    <td width="30%">: {{ $maintenance->doc_number }}</td>
                </tr>
                <tr>
                    <td>Date / Time</td>
                    <td>: {{ $maintenance->maintenance_date->format('d/m/Y H:i') }}</td>
                    <td>Batt. Temperature</td>
                    <td>: {{ $maintenance->battery_temperature ? $maintenance->battery_temperature . ' °C' : '-' }}</td>
                </tr>
            </table>
        </div>

        @php
        $readingsByBank = $maintenance->readings->groupBy('bank_number')->sortKeys();
        @endphp

        <div class="bank-container">
            @foreach($readingsByBank as $bankNumber => $readings)
            @php
            $sortedReadings = $readings->sortBy('battery_number')->values();
            $totalBatteries = $sortedReadings->count();
            $maxSingleColumn = 16;
            $needsDualColumn = $totalBatteries > $maxSingleColumn;
            @endphp

            @if($needsDualColumn)
            {{-- Dual Column Layout --}}
            <table class="bank-table" style="width: 65%; margin-right: 1.5%;">
                <thead>
                    <tr>
                        <th colspan="4" class="bank-header">
                            Bank : {{ $bankNumber }}<br>Batt. Brand : {{ $readings->first()->battery_brand }}
                        </th>
                    </tr>
                    <tr>
                        <th class="no-col">No</th>
                        <th class="voltage-col">Voltage</th>
                        <th class="no-col">No</th>
                        <th class="voltage-col">Voltage</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < $maxSingleColumn; $i++)
                        <tr>
                        @if(isset($sortedReadings[$i]))
                        <td>{{ $sortedReadings[$i]->battery_number }}</td>
                        <td>{{ number_format($sortedReadings[$i]->voltage, 1) }}</td>
                        @else
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        @endif

                        @php $rightIndex = $i + $maxSingleColumn; @endphp
                        @if(isset($sortedReadings[$rightIndex]))
                        <td>{{ $sortedReadings[$rightIndex]->battery_number }}</td>
                        <td>{{ number_format($sortedReadings[$rightIndex]->voltage, 1) }}</td>
                        @else
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        @endif
                        </tr>
                        @endfor
                </tbody>
            </table>
            @else
            {{-- Single Column Layout --}}
            <table class="bank-table">
                <thead>
                    <tr>
                        <th colspan="2" class="bank-header">
                            Bank : {{ $bankNumber }}<br>Batt. Brand : {{ $readings->first()->battery_brand }}
                        </th>
                    </tr>
                    <tr>
                        <th class="no-col">No</th>
                        <th class="voltage-col">Voltage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sortedReadings as $reading)
                    <tr>
                        <td>{{ $reading->battery_number }}</td>
                        <td>{{ number_format($reading->voltage, 1) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @endforeach
        </div>
        <div class="clear"></div>

        <div class="footer-note">
            * Measurement with load test (backup test UPS)<br>
            * Standard min 10 VDC
        </div>

        <!-- Notes Section -->
        <div class="avoid-break">
            <div class="bold" style="margin-bottom: 2px;">Notes / additional informations :</div>
            <div class="notes-box">
                {{ $maintenance->notes ?? '' }}
            </div>
        </div>

        <!-- Signature Section -->
        <div style="display: table; width: 100%; margin-top: 4px;">
            <!-- Left side: Pelaksana -->
            <div style="display: table-cell; width: 65%; vertical-align: top; padding-right: 10px;">
                <div class="bold" style="margin-bottom: 2px;">Pelaksana :</div>
                <table class="signature-table avoid-break">
                    <tr>
                        <th width="30" style="border: 1px solid #000; background: #e0e0e0; text-align: center;">No</th>
                        <th style="border: 1px solid #000; background: #e0e0e0; text-align: center;">Name</th>
                        <th style="border: 1px solid #000; background: #e0e0e0; text-align: center;">Perusahaan</th>
                        <th style="border: 1px solid #000; background: #e0e0e0; text-align: center;">Tanda Tangan</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; text-align: center; height: 25px;">1</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;">{{ $maintenance->technician_1_name ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;">{{ $maintenance->technician_1_company ?? 'PT. Aplikarusa Lintasarta' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; text-align: center; height: 25px;">2</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;">{{ $maintenance->technician_2_name ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;">{{ $maintenance->technician_2_company ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; text-align: center; height: 25px;">3</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;">{{ $maintenance->technician_3_name ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;">{{ $maintenance->technician_3_company ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 4px;"></td>
                    </tr>
                </table>
            </div>

            <!-- Right side: Mengetahui -->
            <div style="display: table-cell; width: 35%; vertical-align: top;">
                <div class="bold" style="margin-bottom: 2px;">Mengetahui,</div>
                <div style="border: 1px solid #000; height: 95px; padding: 5px; text-align: center;">
                    {{-- Ruang untuk tanda tangan --}}
                    <div style="height: 50px;"></div>
                    <div style="font-size: 7.5pt;">( ____________________________ )</div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-013 Formulir Preventive Maintenance Battery
    </div>

    {{-- IMAGE PAGES - 9 IMAGES PER PAGE (3x3 GRID) --}}
    @if($hasPhotos)
    @php
    $imageChunks = $photoReadings->chunk($imagesPerPage);
    $currentPage = 2;
    @endphp

    @foreach($imageChunks as $chunkIndex => $imageChunk)
    <div class="page-break"></div>

    <div class="content-wrapper">
        {{-- Header for image page --}}
        <div class="page-header">
            <table class="header-table">
                <tr>
                    <td width="15%" style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 7pt;">No. Dok.</div>
                    </td>
                    <td width="30%" style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 7pt;">FM-LAP-D2-SOP-003-013</div>
                    </td>
                    <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 9pt;">Dokumentasi Foto</div>
                        <div style="font-weight: bold; font-size: 9pt;">Preventive Maintenance</div>
                        <div style="font-weight: bold; font-size: 9pt;">Battery</div>
                    </td>
                    <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                        @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="Logo" style="width:45px; height:auto;">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Versi</div>
                    </td>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">1.0</div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Hal</div>
                    </td>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">{{ $currentPage }} dari {{ $totalPages }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Label</div>
                    </td>
                    <td style="vertical-align: top; border: 1px solid #000;">
                        <div style="font-size: 7pt;">Internal</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 5px; margin-bottom: 5px;">
            <div class="bold" style="margin-bottom: 3px;">Documentation Images @if($totalImagePages > 1)(Page {{ $currentPage - 1 }} of {{ $totalImagePages }})@endif:</div>

            <table style="width: 100%; border-collapse: collapse;">
                @foreach($imageChunk->chunk(3) as $rowIndex => $rowImages)
                <tr>
                    @foreach($rowImages as $colIndex => $reading)
                    <td style="width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                        @php
                        $imagePath = storage_path('app/public/' . $reading->photo_path);
                        if (file_exists($imagePath)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $src = 'data:image/jpeg;base64,' . $imageData;
                        } else {
                        $src = '';
                        }
                        @endphp

                        @if($src)
                        <img src="{{ $src }}" alt="Battery {{ $reading->battery_number }}" style="width: 100%; max-height: 200px; object-fit: contain;">
                        <div style="font-size: 7pt; color: #666; margin-top: 2px;">
                            Bank {{ $reading->bank_number }} - No. {{ $reading->battery_number }}<br>
                            Voltage: {{ number_format($reading->voltage, 1) }} VDC
                            @if($reading->photo_latitude && $reading->photo_longitude)
                            <br>📍 {{ number_format($reading->photo_latitude, 6) }}, {{ number_format($reading->photo_longitude, 6) }}
                            @endif
                            @if($reading->photo_timestamp)
                            <br>🕐 {{ \Carbon\Carbon::parse($reading->photo_timestamp)->format('d/m/Y H:i:s') }}
                            @endif
                        </div>
                        @else
                        <div style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt;">
                            Image not available
                        </div>
                        @endif
                    </td>
                    @endforeach

                    {{-- Fill remaining cells --}}
                    @for($i = $rowImages->count(); $i < 3; $i++)
                        <td style="width: 33.33%; padding: 3px; border: none;">
                        </td>
                        @endfor
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-013 Formulir Preventive Maintenance Battery - Dokumentasi Foto
    </div>

    @php $currentPage++; @endphp
    @endforeach
    @endif
</body>

</html>

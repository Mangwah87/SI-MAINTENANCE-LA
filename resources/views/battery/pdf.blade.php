<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Formulir Preventive Maintenance Battery</title>
    <style>
        @page {
            margin: 15mm 15mm 25mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            position: relative;
            min-height: 100vh;
        }

        .header {
            border: 1px solid #000;
            margin-bottom: 10px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            padding: 6px;
            border: 1px solid #000;
            vertical-align: middle;
        }

        .header .left-section {
            width: 50%;
        }

        .header .center-section {
            width: 50%;
            text-align: center;
            font-weight: bold;
        }

        .header .right-section {
            width: 20%;
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo svg {
            width: 100%;
            height: 100%;
        }

        .info-section {
            margin-bottom: 10px;
            font-size: 10px;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section td {
            padding: 2px 5px;
        }

        .bank-container {
            display: table;
            width: 76%;
            margin-bottom: 15px;
        }

        .bank-wrapper {
            width: 100%;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .bank-table {
            width: 32%;
            float: left;
            margin-right: 1.5%;
            border-collapse: collapse;
            margin-bottom: 8px;
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
            font-size: 8px;
            line-height: 1.2;
        }

        .bank-table th,
        .bank-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            font-size: 8px;
        }

        .bank-table th {
            background: #e0e0e0;
            font-weight: bold;
            padding: 3px 2px;
        }

        .no-col {
            width: 25%;
        }

        .voltage-col {
            width: 30%;
        }

        .bank-dual-column {
            width: 100%;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .bank-dual-column .bank-table {
            width: 48%;
        }

        .footer-note {
            clear: both;
            margin-top: 15px;
            font-size: 9px;
            padding-top: 10px;
        }

        .notes-section {
            clear: both;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .notes-section h3 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-decoration: underline;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 80px;
            padding: 8px;
            background: white;
        }

        .pelaksana-section {
            clear: both;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .pelaksana-header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .pelaksana-left {
            float: left;
            width: 60%;
        }

        .pelaksana-right {
            float: right;
            width: 35%;
            text-align: center;
        }

        .pelaksana-left h3 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-decoration: underline;
        }

        .pelaksana-right h3 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            text-decoration: none;
        }

        .signature-box {
            border: 1px solid #000;
            height: 100px;
            width: 100%;
            margin-top: 5px;
            background: white;
        }

        .pelaksana-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pelaksana-table th,
        .pelaksana-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 9px;
        }

        .pelaksana-table th {
            background: #e0e0e0;
            font-weight: bold;
        }

        .company-info {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 9px;
            color: #333;
            padding: 8px 15mm;
            border-top: 1px solid #000;
            background: white;
            text-align: left;
            z-index: 999;
            line-height: 1.4;
        }

        .content-wrapper {
            margin-bottom: 50px;
        }

        .page-break {
            page-break-before: always;
        }

        .photo-section {
            margin-top: 20px;
        }

        .photo-section h2 {
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }

        .photo-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .photo-item {
            width: 48%;
            float: left;
            margin-right: 2%;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
        }

        .photo-item:nth-child(2n) {
            margin-right: 0;
        }

        .photo-item img {
            width: 100%;
            height: auto;
            max-height: 250px;
            object-fit: contain;
            display: block;
            margin-bottom: 5px;
        }

        .photo-info {
            font-size: 8px;
            color: #666;
            text-align: center;
            margin-top: 5px;
        }

        .photo-title {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 8px;
            text-align: center;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <!-- PAGE 1: Data Voltage -->
        <div class="header">
            <table>
                <tr>
                    <td class="left-section">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 35%; border-bottom: 1px solid #000; padding: 4px;">No. Dok.</td>
                                <td style="width: 5%; border-bottom: 1px solid #000; padding: 4px;">:</td>
                                <td style="width: 60%; border-bottom: 1px solid #000; padding: 4px;">FM-LAP- D2-SOP-003-013</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000; padding: 4px;">Versi</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px;">:</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px;">1.0</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000; padding: 4px;">Hal</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px;">:</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px;">1 dari 1</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px;">Label</td>
                                <td style="padding: 4px;">:</td>
                                <td style="padding: 4px;">Internal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="center-section">
                        <div style="font-size: 16px;">Formulir</div>
                        <div style="font-size: 14px;">Preventive Maintenance</div>
                        <div style="font-size: 14px;">Battery</div>
                    </td>
                    <td class="right-section">
                        <div class="logo">
                            @php
                            $logoPath = public_path('images/Lintasarta_Logo_Logogram.png');
                            @endphp

                            @if(file_exists($logoPath))
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" alt="Company Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            @else
                            <div style="font-size:8px; color:red;">Logo not found</div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <table>
                <tr>
                    <td style="width: 20%;">Location</td>
                    <td style="width: 2%;">:</td>
                    <td style="width: 78%;">{{ $maintenance->location }}</td>
                </tr>
                <tr>
                    <td>Date / time</td>
                    <td>:</td>
                    <td>{{ $maintenance->maintenance_date->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Batt. Temperature</td>
                    <td>:</td>
                    <td>{{ $maintenance->battery_temperature ? $maintenance->battery_temperature . ' °C' : '-' }}</td>
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
            {{-- Dual Column dalam 1 Tabel (4 kolom: No | Voltage | No | Voltage) --}}
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
                        {{-- Kolom Kiri (1-16) --}}
                        @if(isset($sortedReadings[$i]))
                        <td>{{ $sortedReadings[$i]->battery_number }}</td>
                        <td>{{ number_format($sortedReadings[$i]->voltage, 1) }}</td>
                        @else
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        @endif

                        {{-- Kolom Kanan (17-32) --}}
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
            {{-- Single Column Layout (2 kolom: No | Voltage) --}}
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
        <div class="notes-section">
            <h3>Notes / additional informations :</h3>
            <div class="notes-box">
                {{ $maintenance->notes ?? '' }}
            </div>
        </div>

        <!-- Pelaksana Section -->
        <div class="pelaksana-section">
            <div class="pelaksana-header">
                <div class="pelaksana-left">
                    <h3>Pelaksana :</h3>
                    <table class="pelaksana-table">
                        <thead>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="width: 45%;">Name</th>
                                <th style="width: 25%;">Perusahaan</th>
                                <th style="width: 20%;">Tanda Tangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Pelaksana 1 (Required) --}}
                            <tr>
                                <td>1.</td>
                                <td>{{ $maintenance->technician_1_name ?? '' }}</td>
                                <td>{{ $maintenance->technician_1_company ?? $maintenance->company ?? 'PT. Aplikarusa Lintasarta' }}</td>
                                <td></td>
                            </tr>

                            {{-- Pelaksana 2 (Optional) --}}
                            @if(!empty($maintenance->technician_2_name))
                            <tr>
                                <td>2.</td>
                                <td>{{ $maintenance->technician_2_name }}</td>
                                <td>{{ $maintenance->technician_2_company ?? '' }}</td>
                                <td></td>
                            </tr>
                            @else
                            <tr>
                                <td>2.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif

                            {{-- Pelaksana 3 (Optional) --}}
                            @if(!empty($maintenance->technician_3_name))
                            <tr>
                                <td>3.</td>
                                <td>{{ $maintenance->technician_3_name }}</td>
                                <td>{{ $maintenance->technician_3_company ?? '' }}</td>
                                <td></td>
                            </tr>
                            @else
                            <tr>
                                <td>3.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="pelaksana-right">
                    <h3>Mengetahui,</h3>
                    <div class="signature-box">
                        <div style="margin-top: 80px; font-size: 9px;">
                            ( ____________________________)
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Footer - Halaman 1 -->
    <div class="company-info">
        <strong>©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia</strong><br>
        FM-LAP- D2-SOP-003-013 Formulir Preventive Maintenance Battery
    </div>

    <!-- PAGE 2: Photos -->
    @php
    $hasPhotos = $maintenance->readings->filter(function($reading) {
    return $reading->photo_path && Storage::disk('public')->exists($reading->photo_path);
    })->count() > 0;
    @endphp

    @if($hasPhotos)
    <div class="page-break"></div>

    <div class="content-wrapper">
        <div class="header">
            <table>
                <tr>
                    <td class="left-section">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td style="width: 35%; border: none; padding: 2px;">No. Dok</td>
                                <td style="width: 5%; border: none; padding: 2px;">:</td>
                                <td style="width: 60%; border: none; padding: 2px;">FM-LAP-D2-SOP-003-013</td>
                            </tr>
                            <tr>
                                <td style="border: none; padding: 2px;">Versi</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px;">1.0</td>
                            </tr>
                            <tr>
                                <td style="border: none; padding: 2px;">Hal</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px;">1 dari 1</td>
                            </tr>
                            <tr>
                                <td style="border: none; padding: 2px;">Label</td>
                                <td style="border: none; padding: 2px;">:</td>
                                <td style="border: none; padding: 2px;">Internal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="center-section">
                        <div style="font-size: 16px;">Dokumentasi Foto</div>
                        <div style="font-size: 14px;">Preventive Maintenance</div>
                        <div style="font-size: 14px;">Battery</div>
                    </td>
                    <td class="right-section">
                        <div class="logo">
                            @php
                            $logoPath = public_path('images/Lintasarta_Logo_Logogram.png');
                            @endphp

                            @if(file_exists($logoPath))
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" alt="Company Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            @else
                            <div style="font-size:8px; color:red;">Logo not found</div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="photo-section">
            <div class="photo-grid">
                @foreach($readingsByBank as $bankNumber => $readings)
                @foreach($readings->sortBy('battery_number') as $reading)
                @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                <div class="photo-item">
                    <div class="photo-title">
                        Bank {{ $bankNumber }} - No. {{ $reading->battery_number }} | Voltage: {{ number_format($reading->voltage, 1) }} VDC
                    </div>
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
                    <img src="{{ $src }}" alt="Battery {{ $reading->battery_number }}">
                    @endif
                    @if($reading->photo_latitude && $reading->photo_longitude)
                    <div class="photo-info">
                        📍 {{ number_format($reading->photo_latitude, 6) }}, {{ number_format($reading->photo_longitude, 6) }}
                        @if($reading->photo_timestamp)
                        <br>🕐 {{ \Carbon\Carbon::parse($reading->photo_timestamp)->format('d/m/Y H:i:s') }}
                        @endif
                    </div>
                    @endif
                </div>
                @endif
                @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <!-- Fixed Footer - Halaman 2 -->
    <div class="company-info">
        <strong>©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia</strong><br>
        FM-LAP- D2-SOP-003-013 Formulir Preventive Maintenance Battery - Dokumentasi Foto
    </div>
    @endif
</body>

</html>

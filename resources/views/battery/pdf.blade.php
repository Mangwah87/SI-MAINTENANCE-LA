<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Preventive Maintenance Battery</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8pt;
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
            padding: 2px 3px;
            font-size: 7.5pt;
        }

        .header-table th,
        .header-table td {
            border: 1px solid #000;
            padding: 2px 4px;
        }

        .header-table {
            margin-bottom: 5px;
            width: 100%;
        }

        .info-table td {
            border: none;
            padding: 2px 4px;
        }

        .info-table {
            margin-bottom: 8px;
            width: 100%;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .section-title {
            margin-top: 20px;
            font-weight: bold;
            font-size: 12px;
            border: none;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding-bottom: 1px;
            margin-bottom: 8px;
        }

        .bank-container {
            margin: 10px 0;
        }

        .bank-table-wide {
            width: 49%;
            float: left;
            margin-right: 2%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        .bank-table-wide:nth-child(2n) {
            margin-right: 0;
        }

        .bank-header {
            background: white;
            font-weight: bold;
            text-align: left;
            padding: 4px 6px;
            border: 1px solid #000;
            font-size: 8pt;
        }

        .bank-table-wide th,
        .bank-table-wide td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            font-size: 7pt;
        }

        .bank-table-wide th {
            background: #e0e0e0;
            font-weight: bold;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 80px;
            padding: 4px;
            margin: 8px 0;
        }

        .signature-section {
            margin-top: 10px;
            clear: both;
        }

        .signature-table th,
        .signature-table td {
            border: 1px solid #000;
            padding: 3px 5px;
        }

        .page-break {
            page-break-after: always;
            clear: both;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 7pt;
            text-align: left;
            border-top: 1px solid #000;
            padding-top: 3px;
            background: white;
        }

        .content-wrapper {
            margin-bottom: 60px;
        }

        .image-container {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
            border: none;
            overflow: hidden;
        }

        .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .clear {
            clear: both;
        }

        .footer-note {
            clear: both;
            margin-top: 10px;
            font-size: 8pt;
            font-style: italic;
        }

        .rectifier-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .rectifier-table th {
            background: #e0e0e0;
            font-weight: bold;
            padding: 4px;
            font-size: 7.5pt;
        }

        .rectifier-table td {
            padding: 3px 5px;
            font-size: 7pt;
        }

        .indent-text {
            padding-left: 15px;
        }
    </style>
</head>

<body>
    @php
        function imageToBase64($imagePath)
        {
            try {
                $fullPath = storage_path('app/public/' . $imagePath);
                if (!file_exists($fullPath)) {
                    return null;
                }
                $imageData = file_get_contents($fullPath);
                if ($imageData === false) {
                    return null;
                }
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $fullPath);
                finfo_close($finfo);
                $base64 = base64_encode($imageData);
                return "data:{$mimeType};base64,{$base64}";
            } catch (\Exception $e) {
                return null;
            }
        }

        $photos = [];
        foreach ($maintenance->readings as $reading) {
            if ($reading->photo_path && Storage::disk('public')->exists($reading->photo_path)) {
                $photos[] = [
                    'path' => $reading->photo_path,
                    'bank' => $reading->bank_number,
                    'battery' => $reading->battery_number,
                    'voltage' => $reading->voltage,
                    'soh' => $reading->soh,
                    'latitude' => $reading->photo_latitude,
                    'longitude' => $reading->photo_longitude,
                    'timestamp' => $reading->photo_timestamp,
                ];
            }
        }

        $imagesPerPage = 6;
        $totalImagePages = !empty($photos) ? ceil(count($photos) / $imagesPerPage) : 0;
        $totalPages = 2 + $totalImagePages; // Halaman 1: Battery, Halaman 2: Rectifier+Notes+TTD, Halaman 3+: Foto
    @endphp

    {{-- PAGE 1: Battery Data Only --}}
    <div class="content-wrapper">
        {{-- Header --}}
        <table class="header-table">
            <tr>
                <td width="15%" style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-013</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 10pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 10pt;">Battery</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo"
                        style="width:50px; height:auto;">
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Versi</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">1.0</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Hal</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">1 dari {{ $totalPages }}</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Label</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Internal</div>
                </td>
            </tr>
        </table>

        {{-- Info Table --}}
        <table class="info-table" style="margin-top: 5px;">
            <tr>
                <td width="20%"><strong>Location</strong></td>
                <td width="80%">: {{ $maintenance->central->nama ?? $maintenance->location }}</td>
            </tr>
            <tr>
                <td><strong>Date / Time</strong></td>
                <td>: {{ $maintenance->maintenance_date->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Batt. Temperature</strong></td>
                <td>: {{ $maintenance->battery_temperature ? $maintenance->battery_temperature . ' °C' : '-' }}</td>
            </tr>
            <tr>
                <td><strong>No. of Battery Bank</strong></td>
                <td>:
                    @php
                        $bankCountTemp = $maintenance->readings->groupBy('bank_number')->count();
                    @endphp
                    {{ $bankCountTemp }}
                </td>
            </tr>
        </table>

        {{-- Battery Voltage Data --}}
        @php
            $readingsByBank = $maintenance->readings->groupBy('bank_number')->sortKeys();
        @endphp

        <div class="bank-container">
            @foreach ($readingsByBank as $bankNumber => $readings)
                @php
                    $sortedReadings = $readings->sortBy('battery_number')->values();
                    $total = $sortedReadings->count();
                    $rows = ceil($total / 2);
                    $firstReading = $sortedReadings->first();
                    $loop_index = $loop->iteration;

                    // Determine styling based on position (1,3,5... left; 2,4,6... right)
                    if ($loop_index % 2 === 1) {
                        // Odd position - left side
                        $tableWidth = '49%';
                        $tableMargin = '2%';
                        $clearFloat = 'left';
                    } else {
                        // Even position - right side
                        $tableWidth = '49%';
                        $tableMargin = '0';
                        $clearFloat = 'none';
                    }
                @endphp

                <table class="bank-table-wide" style="width: {{ $tableWidth }}; margin-right: {{ $tableMargin }}; float: left; @if($clearFloat === 'left') clear: left; @endif">
                    <thead>
                        <tr>
                            <th colspan="6" class="bank-header" style="text-align: left; padding: 2px 2px; font-weight: normal;">
                                Bank: {{ $bankNumber }}<br>
                                Battery Type: {{ $firstReading->battery_type ?? '-' }}<br>
                                Battery Brand: {{ $firstReading->battery_brand ?? '-' }}<br>
                                End Device Batt: {{ $firstReading->end_device_batt ?? '-' }}
                            </th>
                        </tr>
                        <tr>
                            <th width="15%">No</th>
                            <th width="18%">Voltage</th>
                            <th width="17%">SOH</th>
                            <th width="15%">No</th>
                            <th width="18%">Voltage</th>
                            <th width="17%">SOH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $rows; $i++)
                            @php $rightIndex = $i + $rows; @endphp
                            <tr>
                                {{-- Kolom kiri --}}
                                @if (isset($sortedReadings[$i]))
                                    <td>{{ $sortedReadings[$i]->battery_number }}</td>
                                    <td>{{ number_format($sortedReadings[$i]->voltage, 2) }}</td>
                                    <td>{{ $sortedReadings[$i]->soh ? number_format($sortedReadings[$i]->soh, 2) . '%' : '-' }}</td>
                                @else
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                @endif

                                {{-- Kolom kanan --}}
                                @if (isset($sortedReadings[$rightIndex]))
                                    <td>{{ $sortedReadings[$rightIndex]->battery_number }}</td>
                                    <td>{{ number_format($sortedReadings[$rightIndex]->voltage, 2) }}</td>
                                    <td>{{ $sortedReadings[$rightIndex]->soh ? number_format($sortedReadings[$rightIndex]->soh, 2) . '%' : '-' }}</td>
                                @else
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>

                @if ($loop->iteration % 2 == 0)
                    <div class="clear" style="margin-bottom: 10px;"></div>
                @endif
            @endforeach
        </div>

        <div class="clear"></div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-013 Formulir Preventive Maintenance Battery
    </div>

    {{-- PAGE 2: Rectifier Test + Notes + Signatures --}}
    <div class="page-break"></div>

    <div class="content-wrapper">
        {{-- Header Halaman 2 --}}
        <table class="header-table">
            <tr>
                <td width="15%" style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-013</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 10pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 10pt;">Battery</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo"
                        style="width:50px; height:auto;">
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Versi</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">1.0</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Hal</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">2 dari {{ $totalPages }}</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Label</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">Internal</div>
                </td>
            </tr>
        </table>

        {{-- Rectifier Switching Test --}}
        @if($maintenance->rectifier_test_backup_voltage ||
            $maintenance->rectifier_test_measurement_1 ||
            $maintenance->rectifier_test_measurement_2 ||
            $maintenance->rectifier_test_status)
        <div class="section-title" style="margin-top: 10px;">Rectifier Switching Test</div>
        <table class="rectifier-table">
            <thead>
                <tr>
                    <th width="10%">No.</th>
                    <th width="45%">Descriptions</th>
                    <th width="15%">Result</th>
                    <th width="20%">Operational Standard</th>
                    <th width="10%">Status (OK/NOK)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center bold">1.</td>
                    <td><strong>Rectifier Switching test, from the main source (PLN) to back up mode, by turning off Rectifier input MCB</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="center bold"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="indent-text">a. Battery voltage (on Backup Mode)</td>
                    <td class="center">
                        {{ $maintenance->rectifier_test_backup_voltage ? number_format($maintenance->rectifier_test_backup_voltage, 2) . ' VDC' : '-' }}
                    </td>
                    <td class="center"></td>
                    <td class="center bold">
                        @if($maintenance->rectifier_test_backup_voltage_status)
                            {{ $maintenance->rectifier_test_backup_voltage_status }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="indent-text">b. Measurement I (at the beginning)</td>
                    <td class="center">
                        {{ $maintenance->rectifier_test_measurement_1 ? number_format($maintenance->rectifier_test_measurement_1, 2) . ' VDC' : '-' }}
                    </td>
                    <td class="center">Min 49 VDC</td>
                    <td class="center bold">
                        @if($maintenance->rectifier_test_measurement_1_status)
                            {{ $maintenance->rectifier_test_measurement_1_status }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="indent-text">c. Measurement II (15<sup>th</sup> minutes)</td>
                    <td class="center">
                        {{ $maintenance->rectifier_test_measurement_2 ? number_format($maintenance->rectifier_test_measurement_2, 2) . ' VDC' : '-' }}
                    </td>
                    <td class="center">Min 48 VDC</td>
                    <td class="center bold">
                        @if($maintenance->rectifier_test_measurement_2_status)
                            {{ $maintenance->rectifier_test_measurement_2_status }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @endif

        <div class="footer-note">
            * Measurement with load test ( backup test UPS /Rectifier)<br>
            * Standard min 12 VDC/Battery <br>
            * Standard SOH 80%
        </div>

        {{-- Notes --}}
        @if ($maintenance->notes)
            <div class="section-title">Notes / Additional Informations</div>
            <div class="notes-box">
                {{ $maintenance->notes }}
            </div>
        @endif

        {{-- Signature Section --}}
        <div class="signature-section">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                {{-- Main Header Row --}}
                <tr>
                    <td style="width: 50%; border: 2px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Executor
                    </td>
                    <td style="width: 25%; border: 2px solid #000; border-left: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Verifikator
                    </td>
                    <td style="width: 25%; border: 2px solid #000; border-left: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Head Of Sub<br>Department
                    </td>
                </tr>
                {{-- Content Row --}}
                <tr>
                    {{-- Executor Table --}}
                    <td style="width: 50%; border: 1px solid #000; border-top: none; padding: 0; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <th style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 5%;">No</th>
                                <th style="border: 1px solid #000; border-top: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 33%;">Nama</th>
                                <th style="border: 1px solid #000; border-top: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 25%;">Mitra / Internal</th>
                                <th style="border: 1px solid #000; border-top: none; border-right: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 30%;">Signature</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">1</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->technician_1_name ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->technician_1_company ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; padding: 12px 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">2</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->technician_2_name ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->technician_2_company ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; padding: 12px 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">3</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->technician_3_name ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->technician_3_company ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; padding: 12px 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; border-bottom: none; text-align: center; padding: 12px 2px; font-size: 8pt;">4</td>
                                <td style="border: 1px solid #000; border-top: none; border-bottom: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->technician_4_name ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-bottom: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->technician_4_company ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; border-bottom: none; padding: 12px 2px;"></td>
                            </tr>
                        </table>
                    </td>

                    {{-- Verifikator --}}
                    <td style="width: 25%; border: 1px solid #000; border-top: none; border-left: 1px solid #000; padding: 3px; text-align: center; vertical-align: top; font-size: 7.5pt;">
                        <div style="padding-top: 10px; display: flex; flex-direction: column;">
                            <div style="border-bottom: 1px solid #ffffff; height: 110px; margin-bottom: 5px;"></div>
                            <div>{{ $maintenance->verifikator_name ?? '-' }}</div>
                            <div style="border-bottom: 1px solid #000; height: 3px; margin-bottom: 5px;"></div>
                            <div style="font-size: 6.5pt; margin-top: 2px;">NIK: {{ $maintenance->verifikator_nim ?? '-' }}</div>
                        </div>
                    </td>

                    {{-- Head of Sub Department --}}
                    <td style="width: 25%; border: 1px solid #000; border-top: none; border-left: 1px solid #000; padding: 3px; text-align: center; vertical-align: top; font-size: 7.5pt;">
                        <div style="padding-top: 10px; display: flex; flex-direction: column;">
                            <div style="border-bottom: 1px solid #ffffff; height: 110px; margin-bottom: 5px;"></div>
                            <div>{{ $maintenance->head_of_sub_dept ?? '-' }}</div>
                            <div style="border-bottom: 1px solid #000; height: 3px; margin-bottom: 5px;"></div>
                            <div style="font-size: 6.5pt; margin-top: 2px;">NIK: {{ $maintenance->head_of_sub_dept_nim ?? '-' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-013 Formulir Preventive Maintenance Battery
    </div>

    {{-- IMAGE PAGES (Page 3 onwards) --}}
    @if (!empty($photos))
        @php
            $photoChunks = array_chunk($photos, $imagesPerPage);
            $currentPage = 3;
        @endphp

        @foreach ($photoChunks as $chunkIndex => $photoChunk)
            <div class="page-break"></div>

            <div class="content-wrapper">
                {{-- Header for image page --}}
                <table class="header-table">
                    <tr>
                        <td width="15%" style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">No. Dok.</div>
                        </td>
                        <td width="30%" style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-013</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <div style="font-weight: bold; font-size: 10pt;">Dokumentasi Foto</div>
                            <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                            <div style="font-weight: bold; font-size: 10pt;">Battery</div>
                        </td>
                        <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo"
                                style="width:50px; height:auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">Versi</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">1.0</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">Hal</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">{{ $currentPage }} dari {{ $totalPages }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">Label</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 7.5pt;">Internal</div>
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 8px; margin-bottom: 5px; border: 1px solid #000; border-radius: 4px; padding: 6px;">
                    <div class="bold" style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px;">
                        Documentation Images @if ($totalImagePages > 1)
                            (Page {{ $currentPage - 2 }} of {{ $totalImagePages }})
                        @endif
                    </div>

                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach (array_chunk($photoChunk, 3) as $rowImages)
                            <tr>
                                @foreach ($rowImages as $photo)
                                    @php
                                        $imageBase64 = imageToBase64($photo['path']);
                                    @endphp
                                    <td style="width: 33.33%; padding: 2px; text-align: center; border: none; vertical-align: top;">
                                        @if ($imageBase64)
                                            <div style="width: 100%; background: #f9f9f9; margin-bottom: 2px; border-radius: 2px; overflow: hidden; font-size: 0;">
                                                <div style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center; font-size: 0; line-height: 0;">
                                                    <img src="{{ $imageBase64 }}" alt="Bank {{ $photo['bank'] }} - Battery {{ $photo['battery'] }}"
                                                        style="max-width: 100%; max-height: 100%; object-fit: contain; display: block; margin: 0; padding: 0;">
                                                </div>
                                                <div style="font-size: 8pt; font-weight: bold; color: #000; padding: 4px 2px; background: #f5f5f5; text-align: center; line-height: 1.2; margin: 0;">
                                                    Bank {{ $photo['bank'] }} - No. {{ $photo['battery'] }}<br>
                                                    Voltage: {{ number_format($photo['voltage'], 2) }} VDC
                                                    @if($photo['soh'])
                                                        | SOH: {{ number_format($photo['soh'], 2) }}%
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div style="border: 1px solid #000; width: 100%; height: 380px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt; margin-bottom: 2px; border-radius: 2px;">
                                                Image not found
                                            </div>
                                        @endif
                                    </td>
                                @endforeach

                                @for ($i = count($rowImages); $i < 3; $i++)
                                    <td style="width: 33.33%; padding: 2px; border: none;"></td>
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

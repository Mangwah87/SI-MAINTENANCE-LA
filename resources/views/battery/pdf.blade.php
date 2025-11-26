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
            /* hanya garis bawah */
            display: inline-block;
            /* agar garis bawah hanya sepanjang teks */
            padding-bottom: 1px;
            /* jarak kecil antara teks dan garis */
            margin-bottom: 8px;
            /* spasi bawah dari elemen selanjutnya */
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
            background: #e0e0e0;
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
    </style>
</head>

<body>
    @php
        // Function to convert image to base64
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

        // Collect all photos
        $photos = [];
        foreach ($maintenance->readings as $reading) {
            if ($reading->photo_path && Storage::disk('public')->exists($reading->photo_path)) {
                $photos[] = [
                    'path' => $reading->photo_path,
                    'bank' => $reading->bank_number,
                    'battery' => $reading->battery_number,
                    'voltage' => $reading->voltage,
                    'latitude' => $reading->photo_latitude,
                    'longitude' => $reading->photo_longitude,
                    'timestamp' => $reading->photo_timestamp,
                ];
            }
        }

        // Calculate total pages
        $imagesPerPage = 6;
        $totalImagePages = !empty($photos) ? ceil(count($photos) / $imagesPerPage) : 0;
        $totalPages = 1 + $totalImagePages;
    @endphp

    {{-- PAGE 1: Main Content --}}
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
                <td width="35%">: {{ $maintenance->central->nama ?? $maintenance->location }}</td>
            </tr>
            <tr>
                <td><strong>Date / Time</strong></td>
                <td>: {{ $maintenance->maintenance_date->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Batt. Temperature</strong></td>
                <td>: {{ $maintenance->battery_temperature ? $maintenance->battery_temperature . ' °C' : '-' }}</td>
            </tr>
        </table>

        {{-- Battery Voltage Data --}}
        <!-- <div class="section-title">Battery Voltage Readings</div> -->

        @php
            $readingsByBank = $maintenance->readings->groupBy('bank_number')->sortKeys();
        @endphp

        <div class="bank-container">
            @foreach ($readingsByBank as $bankNumber => $readings)
                @php
                    $sortedReadings = $readings->sortBy('battery_number')->values();
                    $total = $sortedReadings->count();

                    // Gunakan 2 kolom: jadi total baris = ceil(total / 2)
                    $columns = 2;
                    $rows = ceil($total / $columns);
                @endphp

                <table class="bank-table-wide">
                    <thead>
                        <tr>
                            <th colspan="4" class="bank-header">
                                Bank: {{ $bankNumber }} | Batt. Brand:
                                {{ $sortedReadings->first()->battery_brand ?? '-' }}
                            </th>
                        </tr>
                        <tr>
                            <th width="25%">No</th>
                            <th width="25%">Voltage</th>
                            <th width="25%">No</th>
                            <th width="25%">Voltage</th>
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
                                @else
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                @endif

                                {{-- Kolom kanan --}}
                                @if (isset($sortedReadings[$rightIndex]))
                                    <td>{{ $sortedReadings[$rightIndex]->battery_number }}</td>
                                    <td>{{ number_format($sortedReadings[$rightIndex]->voltage, 2) }}</td>
                                @else
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @endforeach
        </div>

        <div class="clear"></div>

        <div class="footer-note">
            * Measurement with load test (backup test UPS)<br>
            * Standard min 10 VDC
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
            <div style="width: 65%; float: left;">
                <div class="bold" style="margin-bottom: 5px;">Pelaksana:</div>
                <table class="signature-table">
                    <tr>
                        <th width="10%">No</th>
                        <th width="40%">Name</th>
                        <th width="30%">Perusahaan</th>
                        <th width="20%">Signature</th>
                    </tr>
                    <tr>
                        <td class="center">1</td>
                        <td>{{ $maintenance->technician_1_name ?? '' }}</td>
                        <td>{{ $maintenance->technician_1_company ?? 'PT. Aplikarusa Lintasarta' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="center">2</td>
                        <td>{{ $maintenance->technician_2_name ?? '' }}</td>
                        <td>{{ $maintenance->technician_2_company ?? '' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="center">3</td>
                        <td>{{ $maintenance->technician_3_name ?? '' }}</td>
                        <td>{{ $maintenance->technician_3_company ?? '' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div style="width: 33%; float: right;">
                <div class="bold" style="margin-bottom: 3px; text-align: center;">Mengetahui,</div>
                <div style="border: 1px solid #000; text-align: center; padding: 5px; height: 100px;">
                    <div style="height: 65px;"></div>
                    <div style="border-bottom: 1px solid #000; padding-bottom: 3px; margin: 0 5px;">
                        {{ $maintenance->supervisor ?? '____________________' }}
                    </div>
                    @if ($maintenance->supervisor_id)
                        <div style="font-size: 7pt; color: #000000ff; margin-top: 2px;">
                            {{ $maintenance->supervisor_id }}
                        </div>
                    @endif
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-013 Formulir Preventive Maintenance Battery
    </div>

    {{-- IMAGE PAGES --}}
    @if (!empty($photos))
        @php
            $photoChunks = array_chunk($photos, $imagesPerPage);
            $currentPage = 2;
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

                <div
                    style="margin-top: 8px; margin-bottom: 5px; border: 1px solid #000; border-radius: 4px; padding: 6px;">
                    <div class="bold"
                        style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px;">
                        Documentation Images @if ($totalImagePages > 1)
                            (Page {{ $currentPage - 1 }} of {{ $totalImagePages }})
                        @endif:</div>

                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach (array_chunk($photoChunk, 3) as $rowImages)
                            <tr>
                                @foreach ($rowImages as $photo)
                                    @php
                                        $imageBase64 = imageToBase64($photo['path']);
                                    @endphp
                                    <td
                                        style="width: 33.33%; padding: 2px; text-align: center; border: none; vertical-align: top;">
                                        @if ($imageBase64)
                                            <div
                                                style="width: 100%; background: #f9f9f9; margin-bottom: 2px; border-radius: 2px; overflow: hidden; font-size: 0;">
                                                <div
                                                    style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center; font-size: 0; line-height: 0;">
                                                    <img src="{{ $imageBase64 }}"
                                                        alt="Bank {{ $photo['bank'] }} - Battery {{ $photo['battery'] }}"
                                                        style="max-width: 100%; max-height: 100%; object-fit: contain; display: block; margin: 0; padding: 0;">
                                                </div>
                                                <div
                                                    style="font-size: 8pt; font-weight: bold; color: #000; padding: 4px 2px; background: #f5f5f5; text-align: center; line-height: 1.2; margin: 0;">
                                                    Bank {{ $photo['bank'] }} - No. {{ $photo['battery'] }}<br>
                                                    Voltage: {{ number_format($photo['voltage'], 2) }} VDC
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                style="border: 1px solid #000; width: 100%; height: 380px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt; margin-bottom: 2px; border-radius: 2px;">
                                                Image not found
                                            </div>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Fill remaining cells --}}
                                @for ($i = count($rowImages); $i < 3; $i++)
                                    <td style="width: 33.33%; padding: 2px; border: none;">
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

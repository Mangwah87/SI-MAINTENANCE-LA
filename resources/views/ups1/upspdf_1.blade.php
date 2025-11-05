<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Preventive Maintenance 1 Phase UPS</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 20mm 30mm 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8.2pt;
            color: #000;
            margin: 0;
            padding: 0;
            line-height: 1.25;
        }

        .header-table {
            width: 100%;
            margin-bottom: 2px;
            border-collapse: collapse;
        }

        .header-table td {
            border: 1px solid #000;
            padding: 2px 4px;
        }

        .unicode-symbol {
            font-family: 'DejaVu Sans', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 1.5px 4px;
        }

        .no-border td {
            border: none;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .small-text {
            font-size: 6.5pt;
            line-height: 1.15;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 20px;
            padding: 2px 4px;
            margin-bottom: 3px;
        }

        .page-footer {
            margin-top: 10px;
            padding-top: 2px;
            border-top: 1px solid #000;
            font-size: 7.5px;
            text-align: left;
        }

        .page-break {
            page-break-after: always;
        }

        .image-cell {
            width: 33.33%;
            padding: 3px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: top;
            height: 240px;
        }

        .image-container {
            display: inline-block;
            text-align: center;
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container img {
            max-width: 100%;
            max-height: 205px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .image-label {
            font-size: 7pt;
            color: #666;
            margin-top: 2px;
        }

        .image-placeholder {
            width: 100%;
            height: 200px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 8pt;
        }

        .signature-section {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    @php
        $images = [];
        if (isset($maintenance->images)) {
            if (is_string($maintenance->images)) {
                $images = json_decode($maintenance->images, true) ?? [];
            } elseif (is_array($maintenance->images)) {
                $images = $maintenance->images;
            }
        }

        // Calculate total pages: 1 main page + image pages (9 images per page)
        $imagesPerPage = 9;
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
        $totalPages = 1 + $totalImagePages;

        // Convert logo to base64 for DomPDF
        $logoPath = public_path('assets/images/logo2.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoContent = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);
        }
    @endphp

    {{-- PAGE 1: Main Content --}}
    {{-- Header for Page 1 --}}
    <table class="header-table">
        <tr>
            <td width="15%" style="vertical-align: top;">
                <div style="font-size: 9pt;">No. Dok.</div>
            </td>
            <td width="30%" style="vertical-align: top;">
                <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-001</div>
            </td>
            <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                <div style="font-weight: bold; font-size: 12pt;">1 Phase UPS</div>
            </td>
            <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo" style="width:60px; height:auto;">
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
        <table class="no-border" style="margin-top: 2px; margin-bottom: 3px;">
            <tr>
                <td style="width: 18%;">Location</td>
                <td style="width: 32%;">: {{ $maintenance->location }}</td>
                <td style="width: 18%;">Reg. Number</td>
                <td style="width: 32%;">: {{ $maintenance->reg_number ?? '-' }}</td>
            </tr>
            <tr>
                <td>Date / Time</td>
                <td>: {{ \Carbon\Carbon::parse($maintenance->date_time)->format('d/m/Y H:i') }}</td>
                <td>S/N</td>
                <td>: {{ $maintenance->sn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Brand / Type</td>
                <td>: {{ $maintenance->brand_type }}</td>
                <td>Kapasitas</td>
                <td>: {{ $maintenance->capacity }}</td>
            </tr>
        </table>

        {{-- Main Table --}}
        <table style="margin-bottom: 2px;">
            <tr>
                <th style="width: 16px;">No.</th>
                <th style="width: 132px;">Descriptions</th>
                <th style="width: 72px;">Result</th>
                <th style="width: 98px;">Operational Standard</th>
                <th style="width: 42px;">Status<br>(OK/NOK)</th>
            </tr>

            {{-- Visual Check --}}
            <tr>
                <td class="center bold">1.</td>
                <td class="bold" colspan="4">Visual Check</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Environment Condition</td>
                <td>{{ $maintenance->env_condition }}</td>
                <td>Clean, No dust</td>
                <td class="center">{{ $maintenance->status_env_condition ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. LED / display *)</td>
                <td>{{ $maintenance->led_display }}</td>
                <td>Normal</td>
                <td class="center">{{ $maintenance->status_led_display ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>c. Battery Connection</td>
                <td>{{ $maintenance->battery_connection }}</td>
                <td>Tighten, No Corrosion</td>
                <td class="center">{{ $maintenance->status_battery_connection ?? 'OK' }}</td>
            </tr>

            {{-- Performance and Capacity Check --}}
            <tr>
                <td class="center bold">2.</td>
                <td class="bold" colspan="4">Performance and Capacity Check</td>
            </tr>
            <tr>
                <td></td>
                <td>a. AC input voltage</td>
                <td>{{ $maintenance->ac_input_voltage }} V</td>
                <td>180-240 VAC</td>
                <td class="center">{{ $maintenance->status_ac_input_voltage ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. AC output voltage</td>
                <td>{{ $maintenance->ac_output_voltage }} V</td>
                <td>210-240 VAC</td>
                <td class="center">{{ $maintenance->status_ac_output_voltage ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>c. Neutral – Ground Output Voltage</td>
                <td>{{ $maintenance->neutral_ground_voltage }} V</td>
                <td><span class="unicode-symbol">&lt;</span> 1 VAC</td>
                <td class="center">{{ $maintenance->status_neutral_ground_voltage ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>d. AC current input *)</td>
                <td>{{ $maintenance->ac_current_input }} A</td>
                <td class="small-text">
                    <span class="unicode-symbol">≤</span> 14 A (UPS 3 KVA)<br>
                    <span class="unicode-symbol">≤</span> 23 A (UPS 5 KVA)<br>
                    <span class="unicode-symbol">≤</span> 27 A (UPS 6 KVA)<br>
                    <span class="unicode-symbol">≤</span> 37 A (UPS 8 KVA)
                </td>
                <td class="center">{{ $maintenance->status_ac_current_input ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>e. AC current output *)</td>
                <td>{{ $maintenance->ac_current_output }} A</td>
                <td class="small-text">
                    <span class="unicode-symbol">≤</span> 18 A (UPS 3 KVA)<br>
                    <span class="unicode-symbol">≤</span> 22 A (UPS 5 KVA)<br>
                    <span class="unicode-symbol">≤</span> 27 A (UPS 6 KVA)<br>
                    <span class="unicode-symbol">≤</span> 22 A (UPS 8 KVA)
                </td>
                <td class="center">{{ $maintenance->status_ac_current_output ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>f. UPS temperature</td>
                <td>{{ $maintenance->ups_temperature }} °C</td>
                <td>0-40 °C</td>
                <td class="center">{{ $maintenance->status_ups_temperature ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>g. Output frequency</td>
                <td>{{ $maintenance->output_frequency }} Hz</td>
                <td>49.75-50.25 Hz</td>
                <td class="center">{{ $maintenance->status_output_frequency ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>h. Charging voltage</td>
                <td>{{ $maintenance->charging_voltage }} V</td>
                <td>See Battery Performance table</td>
                <td class="center">{{ $maintenance->status_charging_voltage ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>i. Charging current</td>
                <td>{{ $maintenance->charging_current }} A</td>
                <td>0 Ampere, on-line mode</td>
                <td class="center">{{ $maintenance->status_charging_current ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>j. FAN</td>
                <td>{{ $maintenance->fan }}</td>
                <td>Berputar</td>
                <td class="center">{{ $maintenance->status_fan ?? 'OK' }}</td>
            </tr>

            {{-- Backup Tests --}}
            <tr>
                <td class="center bold">3.</td>
                <td class="bold" colspan="4">Backup Tests</td>
            </tr>
            <tr>
                <td></td>
                <td>a. UPS Switching test, from the main source (PLN) to back up mode, by turning off UPS input MCB</td>
                <td>{{ $maintenance->ups_switching_test }}</td>
                <td>UPS Normal Operations</td>
                <td class="center">{{ $maintenance->status_ups_switching_test ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. Battery Voltage (on Backup Mode)</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 15px;">- Measurement I (at the beginning)</td>
                <td>{{ $maintenance->battery_voltage_measurement_1 }} V</td>
                <td>See Battery Performance table</td>
                <td class="center">{{ $maintenance->status_battery_voltage_measurement_1 ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 15px;">- Measurement II (+/- 15 minutes)</td>
                <td>{{ $maintenance->battery_voltage_measurement_2 }} V</td>
                <td>See Battery Performance table</td>
                <td class="center">{{ $maintenance->status_battery_voltage_measurement_2 ?? 'OK' }}</td>
            </tr>

            {{-- Power Alarm Monitoring Test --}}
            <tr>
                <td class="center bold">4.</td>
                <td class="bold" colspan="4">Power Alarm Monitoring Test</td>
            </tr>
            <tr>
                <td></td>
                <td>Makesure the Simonica alarm monitor, by turn off UPS power input MCB during UPS backup test operation</td>
                <td>{{ $maintenance->simonica_alarm_test }}</td>
                <td>Simonica Alarm</td>
                <td class="center">{{ $maintenance->status_simonica_alarm_test ?? 'OK' }}</td>
            </tr>
        </table>

        <div style="font-size:7.5px; margin-bottom:2px;">*) Choose the appropriate</div>

        {{-- Notes --}}
        <div class="notes-box">
            <span class="bold">Notes / additional informations :</span><br>
            <span>{{ $maintenance->notes ?? '' }}</span>
        </div>

        {{-- Signature Section --}}
        <div class="signature-section" style="margin-top: 3px;">
            <div style="width: 100%;">
                {{-- Pelaksana Table --}}
                <div style="width: 65%; float: left;">
                    <div class="bold" style="margin-bottom: 2px;">Pelaksana</div>
                    <table>
                        <tr>
                            <th style="width: 10%; background: #eee;">No</th>
                            <th style="width: 35%; background: #eee;">Nama</th>
                            <th style="width: 28%; background: #eee;">Departement</th>
                            <th style="width: 27%; background: #eee;">Sub Departement</th>
                        </tr>
                        <tr>
                            <td class="center">1</td>
                            <td>{{ $maintenance->executor_1 }}</td>
                            <td class="center">
                                @if(!empty($maintenance->executor_1) && $maintenance->executor_1 !== '-')
                                    {{ $maintenance->department ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="center">
                                @if(!empty($maintenance->executor_1) && $maintenance->executor_1 !== '-')
                                    {{ $maintenance->sub_department ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="center">2</td>
                            <td>{{ $maintenance->executor_2 ?? '-' }}</td>
                            <td class="center">
                                @if(!empty($maintenance->executor_2) && $maintenance->executor_2 !== '-')
                                    {{ $maintenance->department ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="center">
                                @if(!empty($maintenance->executor_2) && $maintenance->executor_2 !== '-')
                                    {{ $maintenance->sub_department ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="center">3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>

                {{-- Mengetahui Table --}}
                <div style="width: 33%; float: right;">
                    <div class="bold" style="margin-bottom: 2px;">Mengetahui</div>
                    <table>
                        <tr>
                            <td style="height: 87px; vertical-align: bottom; text-align: center; padding: 3px;">
                                <div>{{ $maintenance->supervisor }}</div>
                                <div style="border-top: 1px solid #000; width: 60%; margin: 0 auto 2px auto;"></div>
                                <div style="font-size: 7pt; color: #444;">{{ $maintenance->supervisor_id_number ?? '' }}</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="clear: both;"></div>
            </div>
        </div>
    </div>

    {{-- Footer for Page 1 --}}
    <div class="page-footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-001 Formulir Preventive Maintenance 1 Phase UPS
    </div>

    {{-- IMAGE PAGES - With manual headers for each page --}}
    @if(!empty($images) && count($images) > 0)
        @php
            $imageChunks = array_chunk($images, $imagesPerPage); // 9 images per page
            $currentPageNum = 2; // Start from page 2 (page 1 is main content)
        @endphp

        @foreach($imageChunks as $pageImages)
            <div class="page-break"></div>

            {{-- Header for this image page --}}
            <table class="header-table">
                <tr>
                    <td width="15%" style="vertical-align: top;">
                        <div style="font-size: 9pt;">No. Dok.</div>
                    </td>
                    <td width="30%" style="vertical-align: top;">
                        <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-001</div>
                    </td>
                    <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                        <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                        <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                        <div style="font-weight: bold; font-size: 12pt;">1 Phase UPS</div>
                    </td>
                    <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                        @if($logoBase64)
                            <img src="{{ $logoBase64 }}" alt="Logo" style="width:60px; height:auto;">
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
                        <div style="font-size: 9pt;">{{ $currentPageNum }} dari {{ $totalPages }}</div>
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

            <div style="margin-top: 5px; margin-bottom: 5px;">
                <div class="bold" style="margin-bottom: 3px;">Documentation Images:</div>

                <table style="width: 100%; border-collapse: collapse;">
                    @foreach(array_chunk($pageImages, 3) as $rowIndex => $rowImages)
                        <tr>
                            @foreach($rowImages as $colIndex => $imageData)
                                @php
                                    // Handle both string path and array format
                                    $imagePath = null;
                                    $imageCategory = null;

                                    if (is_string($imageData)) {
                                        $imagePath = $imageData;
                                    } elseif (is_array($imageData) && isset($imageData['path'])) {
                                        $imagePath = $imageData['path'];
                                        $imageCategory = $imageData['category'] ?? null;
                                    }

                                    // Calculate global image index
                                    $globalIndex = (($currentPageNum - 2) * $imagesPerPage) + ($rowIndex * 3) + $colIndex;

                                    // Get full path for file system
                                    $fullPath = $imagePath ? storage_path('app/public/' . $imagePath) : null;

                                    // Convert to base64 for DomPDF compatibility
                                    $imageBase64Img = null;
                                    if ($fullPath && file_exists($fullPath)) {
                                        $imageContent = file_get_contents($fullPath);
                                        $imageType = pathinfo($fullPath, PATHINFO_EXTENSION);
                                        $mimeType = 'image/' . ($imageType === 'jpg' ? 'jpeg' : $imageType);
                                        $imageBase64Img = 'data:' . $mimeType . ';base64,' . base64_encode($imageContent);
                                    }
                                @endphp

                                <td class="image-cell">
                                    @if($imageBase64Img)
                                        <div class="image-container">
                                            <img src="{{ $imageBase64Img }}" alt="Documentation Image {{ $globalIndex + 1 }}">
                                        </div>
                                        <div style="font-size: 7pt; color: #666; margin-top: 2px;">
                                            @if($imageCategory)
                                                {{ ucwords(str_replace('_', ' ', $imageCategory)) }}
                                            @else
                                                Image {{ $globalIndex + 1 }}
                                            @endif
                                        </div>
                                    @else
                                        <div class="image-container">
                                            <div style="color: #999; font-size: 8pt;">Image not found</div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach

                            {{-- Fill remaining cells --}}
                            @for($i = count($rowImages); $i < 3; $i++)
                                <td style="width: 33.33%; padding: 3px; border: none;"></td>
                            @endfor
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Footer for image page --}}
            <div class="page-footer">
                ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                FM-LAP-D2-SOP-003-001 Formulir Preventive Maintenance 1 Phase UPS
            </div>

            @php
                $currentPageNum++; // Increment page number for next image page
            @endphp
        @endforeach
    @endif
</body>
</html>

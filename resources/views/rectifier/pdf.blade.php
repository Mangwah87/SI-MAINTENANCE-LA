<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Preventive Maintenance Rectifier</title>
    <style>
        @page {
            @top-center {
                content: element(pageHeader);
            }

            size: A4;
            margin: 15mm;
            margin-top: 10mm;
        }

        .page-header {
            position: running(pageHeader);
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
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
            padding: 3px 5px;
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

        .main-table th {
            background: #ffff;
            font-weight: bold;
            text-align: center;
            padding: 4px;
        }

        .main-table td {
            padding: 3px 5px;
        }

        .status-ok {
            color: #000000ff;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .status-nok {
            color: #000000ff;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 50px;
            padding: 4px;
            margin: 8px 0;
        }

        .signature-section {
            margin-top: 3px;
        }

        .signature-table th,
        .signature-table td {
            border: 1px solid #000;
            padding: 1px 5px;
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

        .avoid-break {
            page-break-inside: avoid;
        }

        .image-container {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body>
    @php
    // Function to convert image to base64
    function imageToBase64($imagePath) {
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

    // Calculate total pages
    $images = [];

    try {
        if (isset($maintenance->images)) {
            if (is_string($maintenance->images)) {
                $images = json_decode($maintenance->images, true) ?? [];
            } elseif (is_array($maintenance->images)) {
                $images = $maintenance->images;
            } elseif ($maintenance->images instanceof \Illuminate\Support\Collection) {
                $images = $maintenance->images->toArray();
            }
        }

        $images = is_array($images) ? $images : [];

    } catch (\Exception $e) {
        $images = [];
    }

    $imagesPerPage = 6;
    $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
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
                    <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-010</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 10pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 10pt;">Rectifier</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:50px; height:auto;">
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
        <table class="info-table" style="margin-top: 0.1px;">
            <tr>
                <td width="15%"><strong>Location</strong></td>
                <td width="35%">: {{ $maintenance->location }}</td>
                <td width="15%"><strong>Power Module</strong></td>
                <td width="35%">
                    :
                    @php
                        $powerModule = $maintenance->power_module;
                        $options = ['Single', 'Dual', 'Three'];
                    @endphp

                    @foreach($options as $index => $option)
                        @if($powerModule == $option)
                            <strong>{{ $option }}</strong>
                        @else
                            <span style="text-decoration: line-through; color: #000000ff;">{{ $option }}</span>
                        @endif

                        @if($index < count($options) - 1)
                            <span> / </span>
                        @endif
                    @endforeach
                    <span> *)</span>
                </td>
            </tr>
            <tr>
                <td><strong>Date / Time</strong></td>
                <td>: {{ $maintenance->date_time->format('d/m/Y H:i') }}</td>
                <td><strong>Reg. Number</strong></td>
                <td>: {{ $maintenance->reg_number ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Brand / Type</strong></td>
                <td>: {{ $maintenance->brand_type }}</td>
                <td><strong>S/N</strong></td>
                <td>: {{ $maintenance->sn ?? '-' }}</td>
            </tr>
        </table>

        {{-- TABEL GABUNGAN SEMUA SECTION 1-4 --}}
        <table class="main-table" style="margin-top: 3px; ">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="30%">Descriptions</th>
                    <th width="20%">Result</th>
                    <th width="27%">Operational Standard</th>
                    <th width="18%">Status (OK/NOK)</th>
                </tr>
            </thead>
            <tbody>
                {{-- 1. Visual Check --}}
                <tr>
                    <td rowspan="4" class="center" style="vertical-align: top; font-weight: bold; padding: 0; position: relative;">
                        <div style="border-bottom: 1px solid #000; padding: 4px 5px 2px 5px;">1.</div>
                    </td>
                    <td style="font-weight: bold; background: #ffffffff;">Visual Check</td>
                    <td style="background: #ffffffff;"></td>
                    <td style="background: #ffff;"></td>
                    <td style="background: #ffff;"></td>
                </tr>
                <tr>
                    <td style="padding-left: 10px;">a. Environment Condition</td>
                    <td>{{ $maintenance->env_condition }}</td>
                    <td>Clean, No dust</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_env_condition == 'OK' ? 'status-ok' : 'status-nok' }}">
                            {{ $maintenance->status_env_condition }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 10px;">b. LED / display *)</td>
                    <td>{{ $maintenance->led_display }}</td>
                    <td>Normal</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_led_display == 'OK' ? 'status-ok' : 'status-nok' }}">
                            {{ $maintenance->status_led_display }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 10px;">c. Battery Connection</td>
                    <td>{{ $maintenance->battery_connection }}</td>
                    <td>Tighten, No Corrosion</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_battery_connection == 'OK' ? 'status-ok' : 'status-nok' }}">
                            {{ $maintenance->status_battery_connection }}
                        </span>
                    </td>
                </tr>

                {{-- 2. Performance and Capacity Check --}}
                <tr>
                    <td rowspan="11" class="center" style="vertical-align: top; font-weight: bold; padding: 0; position: relative;">
                        <div style="border-bottom: 1px solid #000; padding: 4px 5px 2px 5px;">2</div>
                    </td>
                    <td style="font-weight: bold; background: #ffff;">Performance and Capacity Check</td>
                    <td style="background: #ffff;"></td>
                    <td style="background: #ffff;"></td>
                    <td style="background: #ffff;"></td>
                </tr>
                <tr>
                    <td style="padding-left: 10px;">a. AC Input Voltage</td>
                    <td>{{ $maintenance->ac_input_voltage ?? '-' }} VAC</td>
                    <td>180-240 VAC</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_ac_input_voltage == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_ac_input_voltage }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" style="padding-left: 10px; vertical-align: top;">b. AC Current Input *)</td>
                    <td rowspan="3" style="vertical-align: middle;">{{ $maintenance->ac_current_input ?? '-' }} A</td>
                    <td style="font-size: 7pt; padding: 2px 5px;">≤ 5.5 A ( Single Power Module )</td>
                    <td rowspan="3" class="center" style="vertical-align: middle;">
                        <span class="{{ $maintenance->status_ac_current_input == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_ac_current_input }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 7pt; padding: 2px 5px;">≤ 11 A ( Dual Power Module )</td>
                </tr>
                <tr>
                    <td style="font-size: 7pt; padding: 2px 5px;">≤ 16.5 A ( Three Power Module )</td>
                </tr>

                <tr>
                    <td rowspan="3" style="padding-left: 10px; vertical-align: top;">c. DC Current Output *)</td>
                    <td rowspan="3" style="vertical-align: middle;">{{ $maintenance->dc_current_output ?? '-' }} A</td>
                    <td style="font-size: 7pt; padding: 2px 5px;">≤ 25 A ( Single Power Module )</td>
                    <td rowspan="3" class="center" style="vertical-align: middle;">
                        <span class="{{ $maintenance->status_dc_current_output == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_dc_current_output }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 7pt; padding: 2px 5px;">≤ 50 A ( Dual Power Module )</td>
                </tr>
                <tr>
                    <td style="font-size: 7pt; padding: 2px 5px;">≤ 75 A ( Three Power Module )</td>
                </tr>

                <tr>
                    <td style="padding-left: 10px;">d. Battery Temperature</td>
                    <td>{{ $maintenance->battery_temperature ?? '-' }} °C</td>
                    <td>0-30 °C</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_battery_temperature == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_battery_temperature }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 10px;">e. Charging Voltage DC</td>
                    <td>{{ $maintenance->charging_voltage_dc ?? '-' }} VDC</td>
                    <td>48 ~ 55.3 VDC</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_charging_voltage_dc == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_charging_voltage_dc }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 10px;">f. Charging Current DC</td>
                    <td>{{ $maintenance->charging_current_dc ?? '-' }} A</td>
                    <td>Max 10% Battery Capacity ( AH )</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_charging_current_dc == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_charging_current_dc }}
                        </span>
                    </td>
                </tr>

                 {{-- 3. Backup Tests --}}
                <tr>
                    <td rowspan="4" class="center" style="vertical-align: top; font-weight: bold; padding: 0; position: relative;">
                        <div style="border-bottom: 1px solid #000; padding: 4px 5px 2px 5px;">3</div>
                    </td>
                    <td colspan="4" style="font-weight: bold; background: #ffff;">Backup Tests</td>
                </tr>
                <tr>
                    <td style="padding-left: 10px; font-size: 7.5pt; line-height: 1.3;">
                        a. Rectifier Switching test, from the main source (PLN) to back up mode, by turning off Rectifier input MCB
                    </td>
                    <td></td>
                    <td style="vertical-align: middle;">Rectifier Normal Operations</td>
                    <td class="center" style="vertical-align: middle;">
                        <span class="{{ $maintenance->status_backup_test_rectifier == 'OK' ? 'status-ok' : 'status-nok' }}">
                            {{ $maintenance->status_backup_test_rectifier }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" style="padding-left: 10px; font-size: 7.5pt; line-height: 1.3; vertical-align: middle;">
                        b. Battery voltage (on Backup Mode).
                        <div style="margin-top: 3px; font-size: 6.5pt; line-height: 1.4;">
                            - Measurement I ( at the beginning )<br>
                            - Measurement II ( 15<sup>th</sup> minutes )
                        </div>
                    </td>
                    <td style="vertical-align: middle;"></td>
                    <td style="vertical-align: middle;">Min 48 VDC</td>
                    <td rowspan="2" class="center" style="vertical-align: middle;">
                        <span class="{{ $maintenance->status_backup_test_voltage == 'OK' ? 'status-ok' : 'status-nok' }}">
                            {{ $maintenance->status_backup_test_voltage }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;"></td>
                    <td style="vertical-align: middle;">Min 42 VDC</td>
                </tr>

                {{-- 4. Power Alarm Monitoring Test --}}
                <tr>
                    <td rowspan="2" class="center" style="vertical-align: top; font-weight: bold; padding: 0; position: relative;">
                        <div style="border-bottom: 1px solid #000; padding: 4px 5px 2px 5px;">4</div>
                    </td>
                    <td colspan="4" style="font-weight: bold; background: #ffff;">Power Alarm Monitoring Test</td>
                </tr>
                <tr>
                    <td style="padding-left: 10px; font-size: 7.5pt; line-height: 1.3;">
                        Makesure the Simonica alarm monitor, by turn off UPS power input MCB during Rect backup test operation
                    </td>
                    <td>{{ $maintenance->power_alarm_test ?? '-' }}</td>
                    <td>Simonica Alarm Monitor fault conditions ( Red Sign )</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_power_alarm_test == 'OK' ? 'status-ok' : 'status-nok' }}">
                            {{ $maintenance->status_power_alarm_test }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Notes --}}
        @if($maintenance->notes)
        <div style="margin-top: 8px; margin-bottom: 4px; font-weight: bold;">Notes / Additional Informations:</div>
        <div class="notes-box">
            {{ $maintenance->notes }}
        </div>
        @endif

        {{-- Signature Section --}}
        <div class="signature-section">
            <div style="width: 65%; float: left;">
                <div class="bold" style="margin-bottom: 1px;">Pelaksana:</div>
                <table class="signature-table">
                    <tr>
                        <th width="5%">No</th>
                        <th width="40%">Name</th>
                        <th width="35%">Department</th>
                        <th width="20%">Signature</th>
                    </tr>
                    <tr>
                        <td class="center">1</td>
                        <td>{{ $maintenance->executor_1 ?? '' }}</td>
                        <td>{{ $maintenance->executor_1_department ?? '-' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    @if($maintenance->executor_2)
                    <tr>
                        <td class="center">2</td>
                        <td>{{ $maintenance->executor_2 }}</td>
                        <td>{{ $maintenance->executor_2_department ?? '-' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endif
                    @if($maintenance->executor_3)
                    <tr>
                        <td class="center">3</td>
                        <td>{{ $maintenance->executor_3 }}</td>
                        <td>{{ $maintenance->executor_3_department ?? '-' }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endif
                </table>
            </div>

            <div style="width: 33%; float: right;">
                <div class="bold" style="margin-bottom: 2px;">Mengetahui,</div>
                <div style="border: 1px solid #000; height: 100px; text-align: center; padding: 2px;">
                    <div style="height: 65px;"></div>
                    <div style="border-bottom: 1px solid #000; padding-bottom: 2px; margin: 0 5px;">
                        {{ $maintenance->supervisor ?? '____________________' }}
                    </div>
                   @if($maintenance->supervisor_id_number )
                    <div style="font-size: 7pt; color: #000000ff; margin-top: 2px;">
                        {{ $maintenance->supervisor_id_number ?? '-' }}</div>
                </div>
                @endif
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-010 Formulir Preventive Maintenance Rectifier
    </div>

    {{-- IMAGE PAGES --}}
    @if(!empty($images) && count($images) > 0)
    @php
    $imageChunks = array_chunk($images, $imagesPerPage);
    $currentPage = 2;
    @endphp

    @foreach($imageChunks as $chunkIndex => $imageChunk)
    <div class="page-break"></div>

    <div class="content-wrapper">
        {{-- Header for image page --}}
        <table class="header-table">
            <tr>
                <td width="15%" style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-010</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 10pt;">Dokumentasi Foto</div>
                    <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 10pt;">Rectifier</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:50px; height:auto;">
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
                Documentation Images @if($totalImagePages > 1)(Page {{ $currentPage - 1 }} of {{ $totalImagePages }})@endif:
            </div>

            <table style="width: 100%; border-collapse: collapse;">
                @foreach(array_chunk($imageChunk, 3) as $rowIndex => $rowImages)
                <tr>
                    @foreach($rowImages as $colIndex => $imageData)
                    @php
                    $globalIndex = ($chunkIndex * $imagesPerPage) + ($rowIndex * 3) + $colIndex;

                    // Extract path
                    $imagePath = null;
                    $imageCategory = 'unknown';

                    if (is_array($imageData)) {
                        $imagePath = $imageData['path'] ?? null;
                        $imageCategory = $imageData['category'] ?? 'unknown';
                    } elseif (is_string($imageData)) {
                        $imagePath = $imageData;
                    }

                    // Convert to base64
                    $imageBase64 = null;
                    if ($imagePath) {
                        $imageBase64 = imageToBase64($imagePath);
                    }
                    @endphp

                    <td style="width: 33.33%; padding: 2px; text-align: center; border: none; vertical-align: top;">
                        @if($imageBase64)
                        <div style="width: 100%; background: #f9f9f9; margin-bottom: 2px; border-radius: 2px; overflow: hidden; font-size: 0;">
                            <div style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center; font-size: 0; line-height: 0;">
                                <img src="{{ $imageBase64 }}" alt="{{ ucwords(str_replace('_', ' ', $imageCategory)) }}"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: block; margin: 0; padding: 0;">
                            </div>
                            <div style="font-size: 8pt; font-weight: bold; color: #000; padding: 4px 2px; background: #f5f5f5; text-align: center; line-height: 1.2; margin: 0;">
                                {{ ucwords(str_replace('_', ' ', $imageCategory)) }}
                            </div>
                        </div>
                        @else
                        <div style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt; border: 1px solid #ddd;">
                            Image not found
                            @if($imagePath)
                            <br><span style="font-size: 6pt;">{{ basename($imagePath) }}</span>
                            @endif
                        </div>
                        @endif
                    </td>
                    @endforeach

                    {{-- Fill remaining cells --}}
                    @for($i = count($rowImages); $i < 3; $i++)
                    <td style="width: 33.33%; padding: 2px; border: none;"></td>
                    @endfor
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-010 Formulir Preventive Maintenance Rectifier - Dokumentasi Foto
    </div>

    @php $currentPage++; @endphp
    @endforeach
    @endif
</body>
</html>

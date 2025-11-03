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
            position: relative;
            min-height: 100vh;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 1.5px 4px;
        }

        .header-table {
            margin-bottom: 2px;
        }

        .info-table {
            margin-bottom: 3px;
        }

        .info-table td {
            border: none;
            padding: 1.5px 4px;
        }

        .main-table th, .main-table td {
            padding: 1.5px 4px;
            font-size: 8.2pt;
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

        /* Footer fixed at bottom */
        .page-footer {
            position: fixed;
            bottom: 10mm;
            left: 1mm;
            right: 1mm;
            padding-top: 2px;
            border-top: 1px solid #000;
            font-size: 7.5px;
            text-align: left;
        }

        /* Content wrapper with padding for footer */
        .content-wrapper {
            padding-bottom: 20mm;
        }

        /* Page break control */
        .page-break {
            page-break-after: always;
            clear: both;
        }

        .avoid-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    @php
        // Calculate total pages
        $images = null;
        try {
            if (isset($maintenance->images)) {
                if (is_string($maintenance->images)) {
                    $images = json_decode($maintenance->images, true);
                } elseif (is_array($maintenance->images)) {
                    $images = $maintenance->images;
                }
            }
            $images = is_array($images) ? $images : [];
        } catch (\Exception $e) {
            $images = [];
        }

        $imagesPerPage = 9;
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
        $totalPages = 1 + $totalImagePages;
    @endphp

    {{-- PAGE 1: Main Content --}}
    <div class="content-wrapper">
        {{-- Header --}}
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
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:60px; height:auto;">
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
        <table class="info-table" style="margin-top: 2px;">
            <tr>
                <td width="18%">Location</td>
                <td width="32%">: {{ $maintenance->location }}</td>
                <td width="18%">Reg. Number</td>
                <td width="32%">: {{ $maintenance->reg_number ?? '-' }}</td>
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
        <table class="main-table" style="margin-bottom: 2px;">
            <tr>
                <th width="16">No.</th>
                <th width="132">Descriptions</th>
                <th width="72">Result</th>
                <th width="98">Operational Standard</th>
                <th width="42">Status<br>(OK/NOK)</th>
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
                <td>&lt; 1 VAC</td>
                <td class="center">{{ $maintenance->status_neutral_ground_voltage ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>d. AC current input *)</td>
                <td>{{ $maintenance->ac_current_input }} A</td>
                <td class="small-text">
                    ≤ 14 A (UPS 3 KVA)<br>
                    ≤ 23 A (UPS 5 KVA)<br>
                    ≤ 27 A (UPS 6 KVA)<br>
                    ≤ 37 A (UPS 8 KVA)
                </td>
                <td class="center">{{ $maintenance->status_ac_current_input ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>e. AC current output *)</td>
                <td>{{ $maintenance->ac_current_output }} A</td>
                <td class="small-text">
                    ≤ 18 A (UPS 3 KVA)<br>
                    ≤ 22 A (UPS 5 KVA)<br>
                    ≤ 27 A (UPS 6 KVA)<br>
                    ≤ 22 A (UPS 8 KVA)
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
        <div class="notes-box avoid-break">
            <span class="bold">Notes / additional informations :</span><br>
            <span>{{ $maintenance->notes ?? '' }}</span>
        </div>

        {{-- Signature Table --}}
        <div style="margin-top: 3px;">
            <table style="border-collapse: collapse;">
                <tr>
                    <td width="65%" style="vertical-align: top; border: none; padding-right: 6px;">
                        <div class="bold" style="margin-bottom: 2px;">Pelaksana</div>
                        <table style="border-collapse: collapse;">
                            <tr>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 1.5px;">No</th>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 1.5px;">Nama</th>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 1.5px;">Departement</th>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 1.5px;">Sub Departement</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; text-align: center; padding: 1.5px;">1</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;">{{ $maintenance->executor_1 }}</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;">{{ $maintenance->department ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;">{{ $maintenance->sub_department ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; text-align: center; padding: 1.5px;">2</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;">{{ $maintenance->executor_2 ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;">{{ $maintenance->department ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;">{{ $maintenance->sub_department ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; text-align: center; padding: 1.5px;">3</td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;"></td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;"></td>
                                <td style="border: 1px solid #000; padding: 1.5px 3px;"></td>
                            </tr>
                        </table>
                    </td>
                    <td width="35%" style="vertical-align: top; border: none; padding-left: 6px;">
                        <div class="bold" style="margin-bottom: 2px;">Mengetahui</div>
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td style="border: 1px solid #000; height: 87px; vertical-align: bottom; text-align: center; padding: 3px;">
                                    <div style="border-top: 1px solid #000; width: 60%; margin: 0 auto 2px auto;"></div>
                                    <div>{{ $maintenance->supervisor }}</div>
                                    <div style="font-size: 7pt; color: #444;">{{ $maintenance->supervisor_id_number ?? '' }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Fixed Footer --}}
    <div class="page-footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-001 Formulir Preventive Maintenance 1 Phase UPS
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
                            <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                        </td>
                        <td width="30%" style="vertical-align: top;">
                            <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-001</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                            <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                            <div style="font-weight: bold; font-size: 12pt;">1 Phase UPS</div>
                        </td>
                        <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:60px; height:auto;">
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
                            <div style="font-size: 9pt;">{{ $currentPage }} dari {{ $totalPages }}</div>
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

                {{-- Documentation Images --}}
                <div style="margin-top: 5px;">
                    <div class="bold" style="margin-bottom: 3px;">Documentation Images @if($totalImagePages > 1)(Page {{ $currentPage - 1 }} of {{ $totalImagePages }})@endif:</div>

                    <table style="border-collapse: collapse;">
                        @foreach(array_chunk($imageChunk, 3) as $rowIndex => $rowImages)
                            <tr>
                                @foreach($rowImages as $colIndex => $imagePath)
                                    @php
                                        $globalIndex = ($chunkIndex * $imagesPerPage) + ($rowIndex * 3) + $colIndex;
                                    @endphp

                                    @if(is_string($imagePath))
                                        <td style="width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                                            @php
                                                $fullPath = public_path('storage/' . $imagePath);
                                            @endphp
                                            @if(file_exists($fullPath))
                                                <img src="{{ $fullPath }}"
                                                     alt="Documentation Image {{ $globalIndex + 1 }}"
                                                     style="width: 100%; max-height: 200px; object-fit: contain;">
                                                <div style="font-size: 7pt; color: #666; margin-top: 2px;">Image {{ $globalIndex + 1 }}</div>
                                            @else
                                                <div style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt;">
                                                    Image not found
                                                </div>
                                            @endif
                                        </td>
                                    @elseif(is_array($imagePath) && isset($imagePath['path']))
                                        <td style="width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                                            @php
                                                $fullPath = public_path('storage/' . $imagePath['path']);
                                            @endphp
                                            @if(file_exists($fullPath))
                                                <img src="{{ $fullPath }}"
                                                     alt="{{ $imagePath['category'] ?? 'Documentation' }}"
                                                     style="width: 100%; max-height: 200px; object-fit: contain;">
                                                @if(isset($imagePath['category']))
                                                    <div style="font-size: 7pt; color: #666; margin-top: 2px;">{{ ucwords(str_replace('_', ' ', $imagePath['category'])) }}</div>
                                                @else
                                                    <div style="font-size: 7pt; color: #666; margin-top: 2px;">Image {{ $globalIndex + 1 }}</div>
                                                @endif
                                            @else
                                                <div style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt;">
                                                    Image not found
                                                </div>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach

                                {{-- Fill remaining cells --}}
                                @for($i = count($rowImages); $i < 3; $i++)
                                    <td style="width: 33.33%; padding: 3px; border: none;"></td>
                                @endfor
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            {{-- Fixed Footer --}}
            <div class="page-footer">
                ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                FM-LAP-D2-SOP-003-001 Formulir Preventive Maintenance 1 Phase UPS
            </div>

            @php $currentPage++; @endphp
        @endforeach
    @endif
</body>
</html>

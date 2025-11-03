<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Preventive Maintenance 3 Phase UPS</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 2px 6px; }
        .unicode-symbol { font-family: 'DejaVu Sans', Arial, sans-serif; }
        .no-border { border: none !important; }
        .header-table th, .header-table td { border: 1px solid #000; padding: 2px 6px; }
        .header-table { margin-bottom: 2px; width: 100%; }
        .info-table td { border: none; padding: 2px 6px; }
        .info-table { margin-bottom: 6px; width: 100%; }
        .section-title { background: #eee; font-weight: bold; border: 1px solid #000; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .signature-table th, .signature-table td { border: 1px solid #000; padding: 2px 6px; }
        .signature-table th { background: #eee; }
        .signature-table td { text-align: center; }
        .notes-box { border: 1px solid #000; min-height: 25px; padding: 3px 6px; margin-bottom: 5px; }

        /* Page break control */
        .page-break {
            page-break-after: always;
            clear: both;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        /* Header section - REDUCED SPACING */
        .page-header {
            margin-bottom: 5px;
        }

        /* Footer section - REDUCED SPACING */
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

        /* OPTIMIZED TABLE SPACING */
        .signature-table {
            margin-top: 3px;
        }

        .signature-table td {
            padding: 2px 4px;
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

        $imagesPerPage = 9; // 3 rows x 3 columns per page (INCREASED FROM 6)
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
        $totalPages = 1 + $totalImagePages;
    @endphp

    {{-- PAGE 1: Main Content --}}
    <div class="page-header">
        <table class="header-table">
            <tr>
                <td width="15%" style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-002</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                    <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 12pt;">3 Phase UPS</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:60px; height:auto;">
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-size: 9pt;">Versi</div>
                </td>
                <td style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-size: 9pt;">1.0</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-size: 9pt;">Hal</div>
                </td>
                <td style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-size: 9pt;">1 dari {{ $totalPages }}</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-size: 9pt;">Label</div>
                </td>
                <td style="vertical-align: top; border: 1px solid #000;">
                    <div style="font-size: 9pt;">Internal</div>
                </td>
            </tr>
        </table>

        <table class="info-table" style="margin-top: 5px;">
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
    </div>

    <!-- Main Table -->
    <table width="100%" style="margin-bottom: 4px;">
        <tr>
            <th width="20">No.</th>
            <th width="145">Activity</th>
            <th width="80">Result</th>
            <th width="110">Operational Standard</th>
            <th width="50">Status<br>(OK/NOK)</th>
        </tr>
        <!-- Visual Check -->
        <tr>
            <td class="center bold">1.</td>
            <td class="bold" colspan="4">Visual Check</td>
        </tr>
        <tr>
            <td></td>
            <td>a. Environmental Condition</td>
            <td>{{ $maintenance->env_condition }}</td>
            <td>Clean, No dust</td>
            <td class="center">{{ $maintenance->status_env_condition ?? $maintenance->status_visual_check ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>b. LED / display *)</td>
            <td>{{ $maintenance->led_display }}</td>
            <td>Normal</td>
            <td class="center">{{ $maintenance->status_led_display ?? $maintenance->status_visual_check ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>c. Battery Connection</td>
            <td>{{ $maintenance->battery_connection }}</td>
            <td>Tighten, No Corrosion</td>
            <td class="center">{{ $maintenance->status_battery_connection ?? $maintenance->status_visual_check ?? 'OK' }}</td>
        </tr>
        <!-- Performance and Capacity Check -->
        <tr>
            <td class="center bold">2.</td>
            <td class="bold" colspan="4">Performance and Capacity Check</td>
        </tr>
        <tr>
            <td></td>
            <td>a. AC input voltage</td>
            <td>
                RS = {{ $maintenance->ac_input_voltage_rs }} Volt<br>
                ST = {{ $maintenance->ac_input_voltage_st }} Volt<br>
                TR = {{ $maintenance->ac_input_voltage_tr }} Volt
            </td>
            <td>360 - 400 VAC</td>
            <td class="center">{{ $maintenance->status_ac_input_voltage ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>b. AC output voltage</td>
            <td>
                RS = {{ $maintenance->ac_output_voltage_rs }} Volt<br>
                ST = {{ $maintenance->ac_output_voltage_st }} Volt<br>
                TR = {{ $maintenance->ac_output_voltage_tr }} Volt
            </td>
            <td>370 - 390 VAC</td>
            <td class="center">{{ $maintenance->status_ac_output_voltage ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>c. AC current input *)</td>
            <td>
                R = {{ $maintenance->ac_current_input_r }} Amp<br>
                S = {{ $maintenance->ac_current_input_s }} Amp<br>
                T = {{ $maintenance->ac_current_input_t }} Amp
            </td>
            <td>
                <span class="unicode-symbol">≤</span> 11,1 A ( UPS 10 KVA )<br>
                <span class="unicode-symbol">≤</span> 22,5 A ( UPS 20 KVA )<br>
                <span class="unicode-symbol">≤</span> 44,7 A ( UPS 40 KVA )<br>
                <span class="unicode-symbol">≤</span> 89,3 A ( UPS 80 KVA )<br>
                <span class="unicode-symbol">≤</span> 134,3 A ( UPS 120 KVA )
            </td>
            <td class="center">{{ $maintenance->status_ac_current_input ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>d. AC current output *)</td>
            <td>
                R = {{ $maintenance->ac_current_output_r }} Amp<br>
                S = {{ $maintenance->ac_current_output_s }} Amp<br>
                T = {{ $maintenance->ac_current_output_t }} Amp
            </td>
            <td>
                <span class="unicode-symbol">≤</span> 9,7 A ( UPS 10 KVA )<br>
                <span class="unicode-symbol">≤</span> 19,4 A ( UPS 20 KVA )<br>
                <span class="unicode-symbol">≤</span> 38,9 A ( UPS 40 KVA )<br>
                <span class="unicode-symbol">≤</span> 77,8 A ( UPS 80 KVA )<br>
                <span class="unicode-symbol">≤</span> 116,8 A ( UPS 120 KVA )
            </td>
            <td class="center">{{ $maintenance->status_ac_current_output ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>e. UPS temperature</td>
            <td>{{ $maintenance->ups_temperature }} °C</td>
            <td>0-40 °C</td>
            <td class="center">{{ $maintenance->status_ups_temperature ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>f. Output frequency</td>
            <td>{{ $maintenance->output_frequency }} Hz</td>
            <td>48.75-50.25 Hz</td>
            <td class="center">{{ $maintenance->status_output_frequency ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>g. Charging voltage</td>
            <td>{{ $maintenance->charging_voltage }} Volt</td>
            <td>See Battery Performance table</td>
            <td class="center">{{ $maintenance->status_charging_voltage ?? 'OK' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>h. Charging current</td>
            <td>{{ $maintenance->charging_current }} Ampere</td>
            <td>0 Ampere, on-line mode</td>
            <td class="center">{{ $maintenance->status_charging_current ?? 'OK' }}</td>
        </tr>
    </table>

    <div style="font-size:9px; margin-bottom:5px;">*) Choose the appropriate</div>

    <!-- Notes -->
    <div class="notes-box avoid-break">
        <span class="bold">Notes / additional informations :</span><br>
        {{ $maintenance->notes ?? '' }}
    </div>

    <!-- Signature Table -->
    <div class="bold" style="margin-top: 6px; margin-bottom: 3px;">Pelaksana :</div>
    <table class="signature-table avoid-break" width="100%">
        <tr>
            <th width="15" style="border: 1px solid #000; background: #eee; text-align: center;">No</th>
            <th width="100" style="border: 1px solid #000; background: #eee; text-align: center;">Nama</th>
            <th width="80" style="border: 1px solid #000; background: #eee; text-align: center;">Departement</th>
            <th width="80" style="border: 1px solid #000; background: #eee; text-align: center;">Sub Departement</th>
            <th width="100" style="border: 1px solid #000; background: #eee; text-align: center;">Mengetahui</th>
        </tr>
        <tr>
            <td style="border: 1px solid #000; text-align: center;">1</td>
            <td style="border: 1px solid #000; padding: 2px 6px;">{{ $maintenance->executor_1 }}</td>
            <td style="border: 1px solid #000; padding: 2px 6px;">{{ $maintenance->department ?? '-' }}</td>
            <td style="border: 1px solid #000; padding: 2px 6px;">{{ $maintenance->sub_department ?? '-' }}</td>
            <td rowspan="3" style="border: 1px solid #000; vertical-align: bottom; text-align: center; padding: 3px;">
                <div style="height: 40px;"></div>
                <div style="border-top: 1px solid #000; width: 80%; margin: 0 auto 3px auto;"></div>
                <div style="font-size: 9pt;">{{ $maintenance->supervisor }}</div>
                <div style="font-size: 8pt; color: #444;">{{ $maintenance->supervisor_id_number ?? '-' }}</div>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; text-align: center;">2</td>
            <td style="border: 1px solid #000; padding: 2px 6px;">{{ $maintenance->executor_2 ?? '-' }}</td>
            <td style="border: 1px solid #000; padding: 2px 6px;">{{ $maintenance->department ?? '-' }}</td>
            <td style="border: 1px solid #000; padding: 2px 6px;">{{ $maintenance->sub_department ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; text-align: center;">3</td>
            <td style="border: 1px solid #000; padding: 2px 6px;"></td>
            <td style="border: 1px solid #000; padding: 2px 6px;"></td>
            <td style="border: 1px solid #000; padding: 2px 6px;"></td>
        </tr>
    </table>

    <div class="page-footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-002 Formulir Preventive Maintenance 3 Phase UPS
    </div>

    {{-- IMAGE PAGES - 9 IMAGES PER PAGE (3x3 GRID) --}}
    @if(!empty($images) && count($images) > 0)
        @php
            $imageChunks = array_chunk($images, $imagesPerPage);
            $currentPage = 2;
        @endphp

        @foreach($imageChunks as $chunkIndex => $imageChunk)
            <div class="page-break"></div>

            {{-- Header for image page --}}
            <div class="page-header">
                <table class="header-table">
                    <tr>
                        <td width="15%" style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                        </td>
                        <td width="30%" style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-002</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                            <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                            <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                            <div style="font-weight: bold; font-size: 12pt;">3 Phase UPS</div>
                        </td>
                        <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                            <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:60px; height:auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-size: 9pt;">Versi</div>
                        </td>
                        <td style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-size: 9pt;">1.0</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-size: 9pt;">Hal</div>
                        </td>
                        <td style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-size: 9pt;">{{ $currentPage }} dari {{ $totalPages }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-size: 9pt;">Label</div>
                        </td>
                        <td style="vertical-align: top; border: 1px solid #000;">
                            <div style="font-size: 9pt;">Internal</div>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 5px; margin-bottom: 5px;">
                <div class="bold" style="margin-bottom: 3px;">Documentation Images @if($totalImagePages > 1)(Page {{ $currentPage - 1 }} of {{ $totalImagePages }})@endif:</div>

                <table style="width: 100%; border-collapse: collapse;">
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

            <div class="page-footer">
                ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                FM-LAP-D2-SOP-003-002 Formulir Preventive Maintenance 3 Phase UPS
            </div>

            @php $currentPage++; @endphp
        @endforeach
    @endif
</body>
</html>

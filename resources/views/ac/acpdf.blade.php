<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Formulir Preventive Maintenance AC</title>
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
        .symbol {
            font-family: DejaVu Sans, sans-serif;
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
        }

        .info-table {
            margin-bottom: 4px;
        }

        .info-table td {
            border: none;
            padding: 2px 5px;
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

        /* Footer fixed at bottom */
        .page-footer {
            position: fixed;
            bottom: 10mm;
            left: 1mm;
            right: 1mm;
            padding-top: 3px;
            border-top: 1px solid #000;
            font-size: 8.5px;
            text-align: left;
        }

        /* Content wrapper with padding for footer */
        .content-wrapper {
            padding-bottom: 25mm;
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

        /* Remove horizontal borders for AC rows - KEY FIX */
        .no-bottom-border {
            border-bottom: none !important;
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
                    <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-003</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 13pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 13pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 13pt;">AC</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo" style="width:65px; height:auto;">
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
                <td width="32%" style="font-size: 9pt;">: {{ $maintenance->location }}</td>
                <td width="18%" style="font-size: 9pt;">Reg. Number</td>
                <td width="32%" style="font-size: 9pt;">: {{ $maintenance->reg_number ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-size: 9pt;">Date / Time</td>
                <td style="font-size: 9pt;">: {{ \Carbon\Carbon::parse($maintenance->date_time)->format('d/m/Y H:i') }}</td>
                <td style="font-size: 9pt;">S/N</td>
                <td style="font-size: 9pt;">: {{ $maintenance->sn ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-size: 9pt;">Brand / Type</td>
                <td style="font-size: 9pt;">: {{ $maintenance->brand_type }}</td>
                <td style="font-size: 9pt;">Kapasitas</td>
                <td style="font-size: 9pt;">: {{ $maintenance->capacity }}</td>
            </tr>
        </table>

        {{-- Main Table --}}
        <table class="main-table" style="margin-bottom: 3px;">
            <thead>
            <tr>
                <th width="18">No.</th>
                <th width="150">Activity</th>
                <th width="85">Result</th>
                <th width="110">Operational Standard</th>
                <th width="48">Status<br>(OK/NOK)</th>
            </tr>
            </thead>
            <tbody>

            {{-- Visual Check --}}
            <tr>
                <td class="center bold">1.</td>
                <td class="bold" colspan="4">Visual Check</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Environment Condition</td>
                <td>{{ $maintenance->environment_condition }}</td>
                <td>No dust</td>
                <td class="center">{{ $maintenance->status_environment_condition ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. Filter</td>
                <td>{{ $maintenance->filter }}</td>
                <td>Clean, No dust</td>
                <td class="center">{{ $maintenance->status_filter ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>c. Evaporator</td>
                <td>{{ $maintenance->evaporator }}</td>
                <td>Clean, No dust</td>
                <td class="center">{{ $maintenance->status_evaporator ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>d. LED & display<br>(include remote control)</td>
                <td>{{ $maintenance->led_display }}</td>
                <td>Normal</td>
                <td class="center">{{ $maintenance->status_led_display ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>e. Air Flow</td>
                <td>{{ $maintenance->air_flow }}</td>
                <td>Fan operates normally, cool air flow</td>
                <td class="center">{{ $maintenance->status_air_flow ?? 'OK' }}</td>
            </tr>

            {{-- Room Temperature --}}
            <tr>
                <td class="center bold">2.</td>
                <td class="bold" colspan="4">Room Temperature Shelter/ODC *)</td>
            </tr>
            <tr>
                <td></td>
                <td>Shelter/Ruangan (ODC)</td>
                <td>{{ $maintenance->temp_shelter ?? '-' }} °C</td>
                <td><span class="symbol">&le;</span>22 °C Shelter/Ruangan</td>
                <td class="center">{{ $maintenance->status_temp_shelter ?? 'OK' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Outdoor Cabinet (ODC)</td>
                <td>{{ $maintenance->temp_outdoor_cabinet ?? '-' }} °C</td>
                <td><span class="symbol">&le;</span> 28 °C Outdoor Cabinet (ODC)</td>
                <td class="center">{{ $maintenance->status_temp_outdoor_cabinet ?? 'OK' }}</td>
            </tr>

            {{-- Input Current Air Cond - SHOW ALL 7 AC STANDARDS --}}
            <tr>
                <td class="center bold">3.</td>
                <td class="bold" colspan="4">Input Current Air Cond *)</td>
            </tr>

            @php
                // Define all AC standards
                $acStandards = [
                    1 => ['label' => '¾-1 PK', 'standard' => '<span class="symbol">&frac34;</span>-1 PK <span class="symbol">&le;</span> 4 A'],
                    2 => ['label' => '2 PK', 'standard' => '2 PK <span class="symbol">&le;</span> 10 A'],
                    3 => ['label' => '2.5 PK', 'standard' => '2.5 PK <span class="symbol">&le;</span> 13.5 A'],
                    4 => ['label' => '5-7 PK', 'standard' => '5-7 PK <span class="symbol">&le;</span> 8 A / Phase'],
                    5 => ['label' => '10 PK', 'standard' => '10 PK <span class="symbol">&le;</span> 15 A / Phase'],
                    6 => ['label' => '15 PK', 'standard' => '15 PK <span class="symbol">&le;</span> 25 A / Phase'],
                    7 => ['label' => '', 'standard' => '']
                ];
            @endphp

            {{-- Loop through all 7 AC standards --}}
            @foreach($acStandards as $acNum => $acInfo)
                @php
                    $currentField = "ac{$acNum}_current";
                    $statusField = "status_ac{$acNum}";
                    $currentValue = $maintenance->{$currentField} ?? null;
                    $statusValue = $maintenance->{$statusField} ?? '-';

                    // Determine if this is the last row
                    $isLast = ($acNum === 7);

                    // All rows have no bottom border except the last one
                    if ($isLast) {
                        $borderStyle = 'border-top: none; border-bottom: 1px solid #000;';
                    } else {
                        $borderStyle = 'border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none;';
                    }
                @endphp
                <tr>
                    <td style="{{ $borderStyle }} padding: 3px 5px; font-size: 8.5pt;"></td>
                    <td style="{{ $borderStyle }} padding: 3px 5px; font-size: 8.5pt;">AC {{ $acNum }} = {{ $acInfo['label'] }}</td>
                    <td style="{{ $borderStyle }} padding: 3px 5px; font-size: 8.5pt;">{{ $currentValue ? $currentValue . ' Amp' : '-' }}</td>
                    <td style="{{ $borderStyle }} padding: 3px 5px; font-size: 7.5pt; line-height: 1.2;">
                        {!! $acInfo['standard'] !!}
                    </td>
                    <td style="{{ $borderStyle }} padding: 3px 5px; font-size: 8.5pt; text-align: center;">{{ $currentValue ? $statusValue : '-' }}</td>
                </tr>
            @endforeach


            </tbody>
        </table>

        <div style="font-size:8px; margin-bottom:3px;">*) Choose the appropriate</div>

        {{-- Notes --}}
        <div class="notes-box" style="max-height: 45px; overflow: hidden; page-break-after: avoid;">
            <span class="bold" style="font-size: 9pt;">Notes / additional informations :</span><br>
            <span style="font-size: 8.5pt;">{{ $maintenance->notes ?? '' }}</span>
        </div>

        {{-- Signature Table --}}
        <div class="signature-section keep-together" style="margin-top: 3px;">
            <table style="border-collapse: collapse; page-break-inside: avoid;">
                <tr>
                    <td width="65%" style="vertical-align: top; border: none; padding-right: 6px;">
                        <div class="bold" style="margin-bottom: 2px; font-size: 9pt;">Pelaksana</div>
                        <table style="border-collapse: collapse;">
                            <tr>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 2px; font-size: 8.5pt;">No</th>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 2px; font-size: 8.5pt;">Nama</th>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 2px; font-size: 8.5pt;">Departement</th>
                                <th style="border: 1px solid #000; background: #eee; text-align: center; padding: 2px; font-size: 8.5pt;">Sub Departement</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8.5pt;">1</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->executor_1 ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->department ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->sub_department ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8.5pt;">2</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->executor_2 ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->department ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->sub_department ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8.5pt;">3</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->executor_3 ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->department ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 2px 4px; font-size: 8.5pt;">{{ $maintenance->sub_department ?? '-' }}</td>
                            </tr>
                        </table>
                    </td>
                    <td width="35%" style="vertical-align: top; border: none; padding-left: 6px;">
                        <div class="bold" style="margin-bottom: 2px; font-size: 9pt;">Mengetahui</div>
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td style="border: 1px solid #000; height: 78px; vertical-align: bottom; text-align: center; padding: 4px;">
                                    <div style="border-top: 1px solid #000; width: 60%; margin: 0 auto 2px auto;"></div>
                                    <div style="font-size: 8.5pt;">{{ $maintenance->supervisor ?? '-' }}</div>
                                    <div style="font-size: 7.5pt; color: #444;">{{ $maintenance->supervisor_id_number ?? '' }}</div>
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
        FM-LAP-D2-SOP-003-003 Formulir Preventive Maintenance AC
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
                            <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-003</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                            <div style="font-weight: bold; font-size: 12pt;">Preventive Maintenance</div>
                            <div style="font-weight: bold; font-size: 12pt;">AC</div>
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
                FM-LAP-D2-SOP-003-003 Formulir Preventive Maintenance AC
            </div>

            @php $currentPage++; @endphp
        @endforeach
    @endif
</body>
</html>

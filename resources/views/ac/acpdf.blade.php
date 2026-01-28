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

        /* Fixed Header - appears on all pages */
        .page-header {
            position: fixed;
            top: -10mm;
            left: 0;
            right: 0;
            height: auto;
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

        // Calculate total pages: 1 main page + image pages (6 images per page - 3x2 grid)
        $imagesPerPage = 6;
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
        $totalPages = 1 + $totalImagePages;

        // Base64 encode logo
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
                <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-003</div>
            </td>
            <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                <div style="font-weight: bold; font-size: 13pt;">Formulir</div>
                <div style="font-weight: bold; font-size: 13pt;">Preventive Maintenance</div>
                <div style="font-weight: bold; font-size: 13pt;">AC</div>
            </td>
            <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
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
                <td width="18%" style="font-size: 9pt;">Lokasi Sentral</td>
                <td width="32%" style="font-size: 9pt;">
                    : @if($maintenance->central)
                        {{ $maintenance->central->nama }} - {{ $maintenance->central->area }} ({{ $maintenance->central->id_sentral }})
                    @else
                        -
                    @endif
                </td>
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
                <td style="font-size: 9pt;">: {{ $maintenance->capacity }} PK</td>
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

            {{-- Physical Check --}}
            <tr>
                <td class="center bold">1.</td>
                <td class="bold" colspan="4">Physical Check</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Environment Condition</td>
                <td>{{ $maintenance->environment_condition }}</td>
                <td>No dust</td>
                <td class="center">{{ $maintenance->status_environment_condition ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>b. Filter</td>
                <td>{{ $maintenance->filter }}</td>
                <td>Clean, No dust</td>
                <td class="center">{{ $maintenance->status_filter ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>c. Evaporator</td>
                <td>{{ $maintenance->evaporator }}</td>
                <td>Clean, No dust</td>
                <td class="center">{{ $maintenance->status_evaporator ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>d. LED & display<br>(include remote control)</td>
                <td>{{ $maintenance->led_display }}</td>
                <td>Normal</td>
                <td class="center">{{ $maintenance->status_led_display ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>e. Air Flow</td>
                <td>{{ $maintenance->air_flow }}</td>
                <td>Fan operates normally, cool air flow</td>
                <td class="center">{{ $maintenance->status_air_flow ?? '-' }}</td>
            </tr>

            {{-- PSI Pressure --}}
            <tr>
                <td class="center bold">2.</td>
                <td class="bold" colspan="4">PSI Pressure *)</td>
            </tr>
            <tr>
                <td></td>
                <td>Standard PSI Pressure Form Type Freon</td>
                <td>{{ $maintenance->psi_pressure ?? '-' }} psi</td>
                <td>R32: 140 psi - 150 psi / R410: 140 psi - 150 psi</td>
                <td class="center">{{ $maintenance->status_psi_pressure ?? '-' }}</td>
            </tr>

            {{-- Input Current Air Cond --}}
            <tr>
                <td class="center bold">3.</td>
                <td class="bold" colspan="4">Input Current Air Cond *)</td>
            </tr>
            <tr>
                <td></td>
                <td>Input Current AC</td>
                <td>{{ $maintenance->input_current_ac ?? '-' }} A</td>
                <td><span class="unicode-symbol">&frac34;</span>-1 PK <span class="unicode-symbol">&le;</span> 4 A | 2 PK <span class="unicode-symbol">&le;</span> 10 A</td>
                <td class="center">{{ $maintenance->status_input_current_ac ?? '-' }}</td>
            </tr>

            {{-- Output Temperature AC --}}
            <tr>
                <td class="center bold">4.</td>
                <td class="bold" colspan="4">Output Temperature AC *)</td>
            </tr>
            <tr>
                <td></td>
                <td>Output Temperature AC</td>
                <td>{{ $maintenance->output_temperature_ac ?? '-' }} °C</td>
                <td>16 - 20°C</td>
                <td class="center">{{ $maintenance->status_output_temperature_ac ?? '-' }}</td>
            </tr>


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
                        @if($maintenance->verifikator)
                            <div style="margin-bottom: 40px;"></div>
                            <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                                ( {{ $maintenance->verifikator }} )
                                @if($maintenance->verifikator_nik)
                                    <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $maintenance->verifikator_nik }}</div>
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
                        @if($maintenance->head_of_sub_department)
                            <div style="margin-bottom: 40px;"></div>
                            <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                                ( {{ $maintenance->head_of_sub_department }} )
                                @if($maintenance->head_of_sub_department_nik)
                                    <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $maintenance->head_of_sub_department_nik }}</div>
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
                    <td style="border: 1px solid #000; padding: 3px; font-size: 8pt;">{{ $maintenance->{'executor_'.$i} ?? '' }}</td>
                    <td style="border: 1px solid #000; padding: 3px; text-align: center; font-size: 8pt;">{{ $maintenance->{'mitra_internal_'.$i} ?? '' }}</td>
                    <td style="border: 1px solid #000; padding: 3px; text-align: center; height: 25px;"></td>
                </tr>
                @endfor
            </table>
        </div>
    </div>

    {{-- Footer for Page 1 --}}
    <div class="page-footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-003 Formulir Preventive Maintenance AC
    </div>

    {{-- IMAGE PAGES - With manual headers for each page --}}
    @if(!empty($images) && count($images) > 0)
        @php
            $imageChunks = array_chunk($images, $imagesPerPage); // 6 images per page (3x2 grid)
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
                        <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-003</div>
                    </td>
                    <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                        <div style="font-weight: bold; font-size: 13pt;">Formulir</div>
                        <div style="font-weight: bold; font-size: 13pt;">Preventive Maintenance</div>
                        <div style="font-weight: bold; font-size: 13pt;">AC</div>
                    </td>
                    <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
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
                                    $imagePath = is_array($imageData) ? ($imageData['path'] ?? $imageData) : $imageData;
                                    $imageCategory = is_array($imageData) ? ($imageData['category'] ?? null) : null;
                                    $fullPath = storage_path('app/public/' . $imagePath);

                                    // Calculate global image index
                                    $globalIndex = (($currentPageNum - 2) * $imagesPerPage) + ($rowIndex * 3) + $colIndex;

                                    // Base64 encode image
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
                                            <img src="{{ $imageBase64Img }}" alt="Documentation Image">
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
                FM-LAP-D2-SOP-003-003 Formulir Preventive Maintenance AC
            </div>

            @php
                $currentPageNum++; // Increment page number for next image page
            @endphp
        @endforeach
    @endif
</body>
</html>


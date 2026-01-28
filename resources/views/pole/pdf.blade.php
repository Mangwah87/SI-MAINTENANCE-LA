<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Formulir Preventive Maintenance Pole</title>
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

        /* Remove horizontal borders for rows - KEY FIX */
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
            if (isset($pole->images)) {
                if (is_string($pole->images)) {
                    $images = json_decode($pole->images, true);
                } elseif (is_array($pole->images)) {
                    $images = $pole->images;
                }
            }
            $images = is_array($images) ? $images : [];

            // Image field descriptions mapping
            $imageDescriptions = [
                'foundation_condition' => 'Foundation Condition',
                'pole_tower_foundation_flange' => 'Pole/Tower Foundation Flange Base Plate',
                'pole_tower_support_flange' => 'Pole/Tower Support Flange Base Plate',
                'flange_condition_connection' => 'Flange Condition at Connection Point',
                'pole_tower_condition' => 'Pole/Tower Condition',
                'arm_antenna_condition' => 'Arm Antenna Condition',
                'availability_basbar_ground' => 'BasBar Ground Availability',
                'bonding_bar' => 'Bonding Bar',
                'inclination_measurement' => 'Inclination Measurement',
                'general' => 'General Documentation',
                'overview' => 'Site Overview',
                'other' => 'Additional Documentation'
            ];

            // Flatten images array - convert from ['field' => ['path1', 'path2']] to flat array of paths
            $flatImages = [];
            if (!empty($images)) {
                foreach ($images as $fieldName => $paths) {
                    if (is_array($paths)) {
                        foreach ($paths as $path) {
                            $flatImages[] = [
                                'path' => $path,
                                'field' => $fieldName,
                                'description' => $imageDescriptions[$fieldName] ?? ucwords(str_replace('_', ' ', $fieldName))
                            ];
                        }
                    }
                }
            }
            $images = $flatImages;
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
                <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-010</div>
            </td>
            <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                <div style="font-weight: bold; font-size: 13pt;">Formulir</div>
                <div style="font-weight: bold; font-size: 13pt;">Preventive Maintenance</div>
                <div style="font-weight: bold; font-size: 13pt;">Pole</div>
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
            <td width="18%" style="font-size: 9pt;">Location</td>
            <td width="32%" style="font-size: 9pt;">
                : @if($pole->central)
                    {{ $pole->central->nama }} - {{ $pole->central->area }} ({{ $pole->central->id_sentral }})
                @else
                    -
                @endif
            </td>
            <td width="18%" style="font-size: 9pt;">Type Pole</td>
            <td width="32%" style="font-size: 9pt;">: {{ $pole->type_pole ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-size: 9pt;">Date / Time</td>
            <td style="font-size: 9pt;">: {{ \Carbon\Carbon::parse($pole->date)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($pole->time)->format('H:i') }}</td>
            <td style="font-size: 9pt;"></td>
            <td style="font-size: 9pt;"></td>
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
            <td>a. Foundation Condition</td>
            <td>{{ $pole->foundation_condition }}</td>
            <td>Condition: No cracks and no settlement. Concrete condition: Solid, no cracks</td>
            <td class="center">{{ $pole->status_foundation_condition ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>b. Pole/Tower Foundation Flange Base Plate Condition</td>
            <td>{{ $pole->pole_tower_foundation_flange ?? '-' }}</td>
            <td>No rust, no metal cracks. Check bolt connection and nut lock for looseness</td>
            <td class="center">{{ $pole->status_pole_tower_foundation_flange ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>c. Pole/Tower Support Flange Base Plate Condition</td>
            <td>{{ $pole->pole_tower_support_flange ?? '-' }}</td>
            <td>No rust, no metal cracks. Check bolt connection and nut lock for looseness</td>
            <td class="center">{{ $pole->status_pole_tower_support_flange ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>d. Flange Condition at Each Pole/Sling Connection Point</td>
            <td>{{ $pole->flange_condition_connection ?? '-' }}</td>
            <td>No rust, bolts and nuts are tight</td>
            <td class="center">{{ $pole->status_flange_condition_connection ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>e. Pole / Tower Condition</td>
            <td>{{ $pole->pole_tower_condition ?? '-' }}</td>
            <td>No rust, no cracks</td>
            <td class="center">{{ $pole->status_pole_tower_condition ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>f. Arm Antenna Condition</td>
            <td>{{ $pole->arm_antenna_condition ?? '-' }}</td>
            <td>No rust, no broken parts, all parts are complete</td>
            <td class="center">{{ $pole->status_arm_antenna_condition ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>g. Availability BasBar Ground</td>
            <td>{{ $pole->availability_basbar_ground ?? '-' }}</td>
            <td>Available and in good condition</td>
            <td class="center">{{ $pole->status_availability_basbar_ground ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>h. Bonding Bar</td>
            <td>{{ $pole->bonding_bar ?? '-' }}</td>
            <td>Available and in good condition</td>
            <td class="center">{{ $pole->status_bonding_bar ?? '-' }}</td>
        </tr>

        {{-- Performance Measurement --}}
        <tr>
            <td class="center bold">2.</td>
            <td class="bold" colspan="4">Performance Measurement</td>
        </tr>
        <tr>
            <td></td>
            <td>a. Inclination Measurement</td>
            <td>{{ $pole->inclination_measurement ?? '-' }} °</td>
            <td>Waterpass reading: 90° inclination ±2° tolerance</td>
            <td class="center">{{ $pole->status_inclination_measurement ?? '-' }}</td>
        </tr>

        </tbody>
    </table>

    {{-- Notes --}}
    <div class="notes-box" style="max-height: 45px; overflow: hidden; page-break-after: avoid;">
        <span class="bold" style="font-size: 9pt;">Notes / additional informations :</span><br>
        <span style="font-size: 8.5pt;">{{ $pole->notes ?? '' }}</span>
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
                    @if($pole->verifikator)
                        <div style="margin-bottom: 40px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( {{ $pole->verifikator }} )
                            @if($pole->verifikator_nik)
                                <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $pole->verifikator_nik }}</div>
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
                    @if($pole->head_of_sub_department)
                        <div style="margin-bottom: 40px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( {{ $pole->head_of_sub_department }} )
                            @if($pole->head_of_sub_department_nik)
                                <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $pole->head_of_sub_department_nik }}</div>
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
                <td style="border: 1px solid #000; padding: 3px; font-size: 8pt;">{{ $pole->{'executor_'.$i} ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-size: 8pt;">{{ $pole->{'mitra_internal_'.$i} ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: center; height: 25px;"></td>
            </tr>
            @endfor
        </table>
    </div>

    {{-- Footer for Page 1 --}}
    <div class="page-footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-010 Formulir Preventive Maintenance Pole
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
                        <div style="font-size: 9pt;">FM-LAP-D2-SOP-003-010</div>
                    </td>
                    <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                        <div style="font-weight: bold; font-size: 13pt;">Formulir</div>
                        <div style="font-weight: bold; font-size: 13pt;">Preventive Maintenance</div>
                        <div style="font-weight: bold; font-size: 13pt;">Pole</div>
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
                                    $imageDescription = is_array($imageData) ? ($imageData['description'] ?? null) : null;
                                    $imageField = is_array($imageData) ? ($imageData['field'] ?? null) : null;
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
                                            <img src="{{ $imageBase64Img }}" alt="{{ $imageDescription ?? 'Documentation Image' }}">
                                        </div>
                                        <div style="font-size: 7pt; color: #666; margin-top: 2px; font-weight: bold;">
                                            {{ $imageDescription ?? 'Image ' . ($globalIndex + 1) }}
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
                FM-LAP-D2-SOP-003-010 Formulir Preventive Maintenance Pole
            </div>

            @php
                $currentPageNum++; // Increment page number for next image page
            @endphp
        @endforeach
    @endif
</body>
</html>

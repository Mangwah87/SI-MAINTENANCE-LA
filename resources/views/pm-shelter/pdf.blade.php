<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Preventive Maintenance Ruang Shelter</title>
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

        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 6px;
            vertical-align: middle;
            position: relative;
        }

        .checkbox.checked {
            background: #000;
        }

        .checkbox.checked::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 1px;
            width: 4px;
            height: 7px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .main-table {
            width: 100%;
            margin-top: 8px;
            border-collapse: collapse;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            font-size: 7.5pt;
        }

        .main-table th {
            text-align: center;
            font-weight: bold;
            background: #f0f0f0;
        }

        .section-title {
            background: #e0e0e0;
            font-weight: bold;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 35px;
            padding: 4px;
            margin: 8px 0;
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

        .page-break {
            page-break-after: always;
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
    </style>
</head>

<body>
    @php
        $allPhotos = [];
        if ($pmShelter->photos && is_array($pmShelter->photos)) {
            $allPhotos = $pmShelter->photos;
        }

        $totalPages = 1;
        if (count($allPhotos) > 0) {
            $totalPages += ceil(count($allPhotos) / 6);
        }

        $currentPage = 1;
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
                    <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-009</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 10pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                    <div style="font-weight: bold; font-size: 10pt;">Ruang Shelter</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo"
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

        {{-- Info Table --}}
        <table class="info-table" style="margin-top: 5px;">
            <tr>
                <td width="20%"><strong>Location</strong></td>
                <td width="80%">: 
                    @if ($pmShelter->central)
                        {{ $pmShelter->central->nama }} - {{ $pmShelter->central->area }}
                        ({{ $pmShelter->central->id_sentral }})
                    @else
                        {{ $pmShelter->location ?? '' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Date / Time</strong></td>
                <td>: {{ \Carbon\Carbon::parse($pmShelter->date)->timezone('Asia/Makassar')->format('d/m/Y') ?? '' }}
                / {{ $pmShelter->time ?? '' }} WITA</td>
            </tr>
            <tr>
                <td><strong>Type</strong></td>
                <td>: 
                    @php
                        $brandType = $pmShelter->brand_type ?? '';
                    @endphp
                    <span class="checkbox {{ $brandType == 'Shelter' ? 'checked' : '' }}"></span>
                    Shelter &nbsp;&nbsp;
                    <span class="checkbox {{ $brandType == 'Outdoor Cabinet' ? 'checked' : '' }}"></span>
                    Outdoor Cabinet &nbsp;&nbsp;
                    <span class="checkbox {{ $brandType == 'Pole Outdoor Cabinet' ? 'checked' : '' }}"></span>
                    Pole Outdoor Cabinet
                </td>
            </tr>
        </table>

        {{-- Main Table --}}
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width:5%;">No.</th>
                    <th style="width:40%;">Descriptions</th>
                    <th style="width:20%;">Result</th>
                    <th style="width:25%;">Operational Standard</th>
                    <th style="width:10%;">Status (OK/NOK)</th>
                </tr>
            </thead>
            <tbody>
                {{-- Physical Check --}}
                <tr>
                    <td class="center bold" rowspan="3">1.</td>
                    <td colspan="4" class="section-title">Physical Check</td>
                </tr>
                <tr>
                    <td>a. Room Condition</td>
                    <td>{{ $pmShelter->kondisi_ruangan_result ?? '' }}</td>
                    <td>Clean, free from leaks, and free from contamination</td>
                    <td class="center bold">{{ $pmShelter->kondisi_ruangan_status ?? '' }}</td>
                </tr>
                <tr>
                    <td>b. Room / Shelter Lock Condition</td>
                    <td>{{ $pmShelter->kondisi_kunci_result ?? '' }}</td>
                    <td>Durable and easily operable</td>
                    <td class="center bold">{{ $pmShelter->kondisi_kunci_status ?? '' }}</td>
                </tr>

                {{-- Room Infrastructure --}}
                <tr>
                    <td class="center bold" rowspan="5">2.</td>
                    <td colspan="4" class="section-title">Room Infrastructure</td>
                </tr>
                <tr>
                    <td>a. Room Layout</td>
                    <td>{{ $pmShelter->layout_tata_ruang_result ?? '' }}</td>
                    <td>Functionality, maintainability, user comfort, and aesthetic</td>
                    <td class="center bold">{{ $pmShelter->layout_tata_ruang_status ?? '' }}</td>
                </tr>
                <tr>
                    <td>b. Security Management Control</td>
                    <td>{{ $pmShelter->kontrol_keamanan_result ?? '' }}</td>
                    <td>Secure, *CCTV-monitored (optional)</td>
                    <td class="center bold">{{ $pmShelter->kontrol_keamanan_status ?? '' }}</td>
                </tr>
                <tr>
                    <td>c. Ease Of Access</td>
                    <td>{{ $pmShelter->aksesibilitas_result ?? '' }}</td>
                    <td>Safe and efficient personnel movement, and ease of access to equipment</td>
                    <td class="center bold">{{ $pmShelter->aksesibilitas_status ?? '' }}</td>
                </tr>
                <tr>
                    <td>d. Technical Aspects</td>
                    <td>{{ $pmShelter->aspek_teknis_result ?? '' }}</td>
                    <td>Availability of power supply, lightning protection, grounding system, lighting, air conditioning, fire protection, and *CCTV-monitored (optional)</td>
                    <td class="center bold">{{ $pmShelter->aspek_teknis_status ?? '' }}</td>
                </tr>

                {{-- Room Temperature --}}
                <tr>
                    <td class="center bold" rowspan="4">3.</td>
                    <td colspan="4" class="section-title">Room Temperature</td>
                </tr>
                <tr>
                    <td>{{ $pmShelter->room_temp_1_result ?? '' }}</td>
                    <td></td>
                    <td>&lt;25°C Shelter Room</td>
                    <td class="center bold">{{ $pmShelter->room_temp_1_status ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ $pmShelter->room_temp_2_result ?? '' }}</td>
                    <td></td>
                    <td>&lt;35°C Outdoor Cabinet (ODC)</td>
                    <td class="center bold">{{ $pmShelter->room_temp_2_status ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ $pmShelter->room_temp_3_result ?? '' }}</td>
                    <td></td>
                    <td>&lt;40°C Pole Outdoor Cabinet (ODC)</td>
                    <td class="center bold">{{ $pmShelter->room_temp_3_status ?? '' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Notes --}}
        <div style="margin-top: 8px;">
            <p style="margin: 4px 0; font-size:8pt;"><strong>Notes / additional informations :</strong></p>
            <div class="notes-box" style="min-height: 35px; padding: 4px; font-size:7.5pt;">{{ $pmShelter->notes ?? '' }}</div>
        </div>

        {{-- Signature Section - BATTERY STYLE --}}
        <div style="margin-top: 10px;">
            <table style="width: 100%; border-collapse: collapse;">
                {{-- Main Header Row --}}
                <tr>
                    <td style="width: 50%; border: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Executor
                    </td>
                    <td style="width: 25%; border: 1px solid #000; border-left: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Verifikator
                    </td>
                    <td style="width: 25%; border: 1px solid #000; border-left: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Head Of Sub<br>Department
                    </td>
                </tr>
                {{-- Content Row --}}
                <tr>
                    {{-- Executor Table --}}
                    <td style="width: 50%; border: 1px solid #000; border-top: none; padding: 0; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <th style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 8%;">No</th>
                                <th style="border: 1px solid #000; border-top: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 33%;">Nama</th>
                                <th style="border: 1px solid #000; border-top: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 25%;">Mitra / Internal</th>
                                <th style="border: 1px solid #000; border-top: none; border-right: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 30%;">Signature</th>
                            </tr>
                            @php
                                $executors = $pmShelter->executors ?? [];
                                for ($i = 0; $i < 4; $i++) {
                                    $executor = isset($executors[$i]) ? $executors[$i] : null;
                                    $isLast = ($i === 3);
                                    
                                    echo '<tr>';
                                    echo '<td style="border: 1px solid #000; border-top: none;' . ($isLast ? ' border-bottom: none;' : '') . ' border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">' . ($i + 1) . '</td>';
                                    echo '<td style="border: 1px solid #000; border-top: none;' . ($isLast ? ' border-bottom: none;' : '') . ' text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">' . ($executor['name'] ?? '') . '</td>';
                                    echo '<td style="border: 1px solid #000; border-top: none;' . ($isLast ? ' border-bottom: none;' : '') . ' text-align: left; padding: 2px 3px; font-size: 7.5pt;">' . ($executor['mitra'] ?? '') . '</td>';
                                    echo '<td style="border: 1px solid #000; border-top: none;' . ($isLast ? ' border-bottom: none;' : '') . ' border-right: none; padding: 12px 2px;"></td>';
                                    echo '</tr>';
                                }
                            @endphp
                        </table>
                    </td>

                    {{-- Verifikator --}}
                    <td style="width: 25%; border: 1px solid #000; border-top: none; border-left: 1px solid #000; padding: 3px; text-align: center; vertical-align: top; font-size: 7.5pt;">
                        <div style="padding-top: 10px; display: flex; flex-direction: column;">
                            <div style="border-bottom: 1px solid #ffffff; height: 110px; margin-bottom: 5px;"></div>
                            <div>{{ $pmShelter->verifikator['name'] ?? '-' }}</div>
                            <div style="border-bottom: 1px solid #000; height: 3px; margin-bottom: 5px;"></div>
                            <div style="font-size: 6.5pt; margin-top: 2px;">NIK: {{ $pmShelter->verifikator['nik'] ?? '-' }}</div>
                        </div>
                    </td>

                    {{-- Head of Sub Department --}}
                    <td style="width: 25%; border: 1px solid #000; border-top: none; border-left: 1px solid #000; padding: 3px; text-align: center; vertical-align: top; font-size: 7.5pt;">
                        <div style="padding-top: 10px; display: flex; flex-direction: column;">
                            <div style="border-bottom: 1px solid #ffffff; height: 110px; margin-bottom: 5px;"></div>
                            <div>{{ $pmShelter->head_of_sub_dept['name'] ?? '-' }}</div>
                            <div style="border-bottom: 1px solid #000; height: 3px; margin-bottom: 5px;"></div>
                            <div style="font-size: 6.5pt; margin-top: 2px;">NIK: {{ $pmShelter->head_of_sub_dept['nik'] ?? '-' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT., Indonesia<br>
        FM-LAP-D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter
    </div>

    @php
        $currentPage++;
    @endphp

    {{-- IMAGE PAGES --}}
    @if (count($allPhotos) > 0)
        @php
            $photoChunks = array_chunk($allPhotos, 6);
            $fieldTitles = [
                'kondisi_ruangan_photos' => 'Room Condition',
                'kondisi_kunci_photos' => 'Room / Shelter Lock Condition',
                'layout_tata_ruang_photos' => 'Room Layout',
                'kontrol_keamanan_photos' => 'Security Management Control',
                'aksesibilitas_photos' => 'Ease Of Access',
                'aspek_teknis_photos' => 'Technical Aspects',
                'room_temp_1_photos' => 'Shelter Room Temperature',
                'room_temp_2_photos' => 'ODC Temperature',
                'room_temp_3_photos' => 'Pole ODC Temperature',
            ];
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
                            <div style="font-size: 7.5pt;">FM-LAP-D2-SOP-003-009</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <div style="font-weight: bold; font-size: 10pt;">Dokumentasi Foto</div>
                            <div style="font-weight: bold; font-size: 10pt;">Preventive Maintenance</div>
                            <div style="font-weight: bold; font-size: 10pt;">Ruang Shelter</div>
                        </td>
                        <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo"
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
                    <div class="bold" style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px; font-size: 8pt;">
                        Documentation Images @if (count($photoChunks) > 1)
                            (Page {{ $chunkIndex + 1 }} of {{ count($photoChunks) }})
                        @endif
                    </div>

                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach (array_chunk($photoChunk, 3) as $rowIndex => $rowPhotos)
                            <tr>
                                @foreach ($rowPhotos as $colIndex => $photo)
                                    @php
                                        $possiblePaths = [
                                            storage_path('app/public/' . $photo['path']),
                                            public_path('storage/' . $photo['path']),
                                            storage_path('app/' . $photo['path']),
                                        ];
                                        
                                        $fullPath = null;
                                        foreach ($possiblePaths as $path) {
                                            if (file_exists($path)) {
                                                $fullPath = $path;
                                                break;
                                            }
                                        }
                                        
                                        $sectionTitle = $fieldTitles[$photo['field']] ?? 'Documentation';
                                    @endphp

                                    <td style="width: 33.33%; padding: 2px; text-align: center; border: none; vertical-align: top;">
                                        @if ($fullPath && file_exists($fullPath))
                                            <div style="width: 100%; background: #f9f9f9; margin-bottom: 2px; border-radius: 2px; overflow: hidden;">
                                                <div style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="{{ $fullPath }}" alt="Foto"
                                                        style="max-width: 100%; max-height: 100%; object-fit: contain; display: block;">
                                                </div>
                                                <div style="font-size: 8pt; font-weight: bold; color: #000; padding: 4px 2px; background: #f5f5f5; text-align: center; line-height: 1.2;">
                                                    {{ $sectionTitle }}
                                                </div>
                                            </div>
                                        @else
                                            <div style="border: 1px solid #000; width: 100%; height: 280px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt; margin-bottom: 2px; border-radius: 2px; flex-direction: column;">
                                                <div>Photo not found</div>
                                                <div style="font-size: 7pt; margin-top: 4px;">{{ $photo['path'] ?? 'No path' }}</div>
                                            </div>
                                            <div style="min-height: 16px; background: #f5f5f5; border-radius: 2px; font-size: 8pt; padding: 4px;">
                                                {{ $sectionTitle }}
                                            </div>
                                        @endif
                                    </td>
                                @endforeach

                                @for ($i = count($rowPhotos); $i < 3; $i++)
                                    <td style="width: 33.33%; padding: 2px; border: none;"></td>
                                @endfor
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="page-footer">
                ©HakCipta PT., Indonesia<br>
                FM-LAP-D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter - Dokumentasi Foto
            </div>

            @php $currentPage++; @endphp
        @endforeach
    @endif
</body>

</html>
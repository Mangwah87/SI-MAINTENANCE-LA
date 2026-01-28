<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Formulir Preventive Maintenance Ruang Shelter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            vertical-align: top;
        }

        .center {
            text-align: center;
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

        .bold {
            font-weight: bold;
        }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            margin-bottom: 10px;
        }

        .header-table td {
            border: 1px solid #000;
            vertical-align: middle;
            padding: 0;
        }

        .header-left {
            width: 40%;
        }

        .header-center {
            width: 40%;
            text-align: center;
            padding: 25px 10px;
        }

        .header-right {
            width: 20%;
            text-align: center;
            padding: 25px 10px;
        }

        .header-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-info-table td {
            border: none;
            padding: 5px 8px;
            font-size: 11px;
            border-bottom: 1px solid #000;
        }

        .header-info-table tr:last-child td {
            border-bottom: none;
        }

        .header-info-label {
            font-weight: bold;
            width: 25%;
        }

        .header-info-colon {
            width: 8%;
            text-align: center;
        }

        .header-info-value {
            width: 67%;
        }

        .title-text {
            font-size: 18px;
            font-weight: bold;
            margin: 3px 0;
        }

        .logo-box {
            width: 55px;
            height: 55px;
            margin: auto;
        }

        /* ===== INFO BOX ===== */
        .info-box {
            margin-top: 8px;
            margin-bottom: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        .info-box td {
            padding: 3px 4px;
            font-size: 11px;
            vertical-align: middle;
        }

        .info-box .label {
            width: 20%;
            font-weight: bold;
        }

        .info-box .colon {
            width: 2%;
            text-align: center;
            padding: 0;
        }

        .info-box .value {
            width: 78%;
            padding-left: 4px;
        }

        /* ===== MAIN TABLE ===== */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            font-size: 10px;
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

        .status-ok {
            text-align: center;
        }

        .status-nok {
            text-align: center;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 35px;
            padding: 4px;
            margin-top: 6px;
        }

        /* ===== SIGNATURE ===== */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .sign-table th,
        .sign-table td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 10px;
        }

        .sign-table th {
            text-align: center;
            font-weight: bold;
        }

        /* Signature line styling */
        .signature-line {
            width: 80%;
            height: 1px;
            background-color: #000;
            margin: 3px auto 3px auto;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 20px;
            border-top: 1px solid #ccc;
            font-size: 8px;
            color: gray;
            background: white;
        }

        body {
            margin-bottom: 40px;
        }

        .no-break {
            page-break-inside: avoid;
        }

        .photo-page {
            page-break-before: always;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
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

    <!-- HALAMAN 1: KONTEN UTAMA -->
    <table class="header-table">
        <tr>
            <td class="header-left">
                <table class="header-info-table">
                    <tr>
                        <td class="header-info-label">No. Dok.</td>
                        <td class="header-info-colon">:</td>
                        <td class="header-info-value">FM-LAP-D2-SOP-003-009</td>
                    </tr>
                    <tr>
                        <td class="header-info-label">Versi</td>
                        <td class="header-info-colon">:</td>
                        <td class="header-info-value">1.0</td>
                    </tr>
                    <tr>
                        <td class="header-info-label">Hal</td>
                        <td class="header-info-colon">:</td>
                        <td class="header-info-value">{{ $currentPage }} dari {{ $totalPages }}</td>
                    </tr>
                    <tr>
                        <td class="header-info-label">Label</td>
                        <td class="header-info-colon">:</td>
                        <td class="header-info-value">Internal</td>
                    </tr>
                </table>
            </td>
            <td class="header-center">
                <div class="title-text">Formulir</div>
                <div class="title-text">Preventive Maintenance</div>
                <div class="title-text">Ruang Shelter</div>
            </td>
            <td class="header-right">
                <div class="logo-box">
                    <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo"
                        style="width:55px; height:55px; object-fit:contain;">
                </div>
            </td>
        </tr>
    </table>

    <table class="info-box">
        <tr>
            <td class="label">Location</td>
            <td class="colon">:</td>
            <td class="value">
                @if ($pmShelter->central)
                    {{ $pmShelter->central->nama }} - {{ $pmShelter->central->area }}
                    ({{ $pmShelter->central->id_sentral }})
                @else
                    {{ $pmShelter->location ?? '' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Date / Time</td>
            <td class="colon">:</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($pmShelter->date)->timezone('Asia/Makassar')->format('d/m/Y') ?? '' }}
                / {{ $pmShelter->time ?? '' }} WITA
            </td>
        </tr>
        <tr>
            <td class="label">Type</td>
            <td class="colon">:</td>
            <td class="value">
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

    <table class="main-table">
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th style="width:40%;">Descriptions</th>
                <th style="width:25%;">Result</th>
                <th style="width:30%;">Operational Standard</th>
                <th style="width:10%;">Status (OK/NOK)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center bold" rowspan="3">1.</td>
                <td colspan="4" class="section-title">Physical Check</td>
            </tr>
            <tr>
                <td>a. Room Condition</td>
                <td>{{ $pmShelter->kondisi_ruangan_result ?? '' }}</td>
                <td>Clean, free from leaks, and free from contamination</td>
                <td class="{{ $pmShelter->kondisi_ruangan_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->kondisi_ruangan_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>b. Room / Shelter Lock Condition</td>
                <td>{{ $pmShelter->kondisi_kunci_result ?? '' }}</td>
                <td>Durable and easily operable</td>
                <td class="{{ $pmShelter->kondisi_kunci_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->kondisi_kunci_status ?? '' }}
                </td>
            </tr>

            <tr>
                <td class="center bold" rowspan="5">2.</td>
                <td colspan="4" class="section-title">Room Infrastructure</td>
            </tr>
            <tr>
                <td>a. Room Layout</td>
                <td>{{ $pmShelter->layout_tata_ruang_result ?? '' }}</td>
                <td>Functionality, maintainability, user comfort, and aesthetic</td>
                <td class="{{ $pmShelter->layout_tata_ruang_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->layout_tata_ruang_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>b. Security Management Control</td>
                <td>{{ $pmShelter->kontrol_keamanan_result ?? '' }}</td>
                <td>Secure, *CCTV-monitored (optional)</td>
                <td class="{{ $pmShelter->kontrol_keamanan_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->kontrol_keamanan_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>c. Ease Of Access</td>
                <td>{{ $pmShelter->aksesibilitas_result ?? '' }}</td>
                <td>Safe and efficient personnel movement, and ease of access to equipment</td>
                <td class="{{ $pmShelter->aksesibilitas_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->aksesibilitas_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>d. Technical Aspects</td>
                <td>{{ $pmShelter->aspek_teknis_result ?? '' }}</td>
                <td>Availability of power supply, lightning protection, grounding system, lighting, air conditioning, fire protection, and *CCTV-monitored (optional)</td>
                <td class="{{ $pmShelter->aspek_teknis_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->aspek_teknis_status ?? '' }}
                </td>
            </tr>

            <tr>
                <td class="center bold" rowspan="4">3.</td>
                <td colspan="4" class="section-title">Room Temperature</td>
            </tr>
            <tr>
                <td>a. Shelter Room</td>
                <td>{{ $pmShelter->room_temp_1_result ?? '' }}</td>
                <td>&lt;25°C Shelter Room</td>
                <td class="{{ $pmShelter->room_temp_1_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->room_temp_1_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>b. Outdoor Cabinet (ODC)</td>
                <td>{{ $pmShelter->room_temp_2_result ?? '' }}</td>
                <td>&lt;35°C Outdoor Cabinet (ODC)</td>
                <td class="{{ $pmShelter->room_temp_2_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->room_temp_2_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>c. Pole Outdoor Cabinet (ODC)</td>
                <td>{{ $pmShelter->room_temp_3_result ?? '' }}</td>
                <td>&lt;40°C Pole Outdoor Cabinet (ODC)</td>
                <td class="{{ $pmShelter->room_temp_3_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->room_temp_3_status ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="no-break">
        <p style="margin-top: 8px; margin-bottom: 4px; font-size:10px;"><strong>Notes / additional informations :</strong></p>
        <div class="notes-box" style="min-height: 35px; padding: 4px; font-size:10px;">{{ $pmShelter->notes ?? '' }}</div>
    </div>

    <!-- Signature Table - WITH CLEAR BORDERS -->
    <table class="sign-table">
        <thead>
            <tr>
                <th colspan="4" style="text-align:center; border:1px solid #000; padding:3px;">Executor</th>
                <th style="width:18%; border:1px solid #000; padding:3px;">Verifikator</th>
                <th style="width:18%; border:1px solid #000; padding:3px;">Head Of Sub Departement</th>
            </tr>
            <tr>
                <th style="width:4%; border:1px solid #000; padding:3px;">No</th>
                <th style="width:18%; border:1px solid #000; padding:3px;">Nama</th>
                <th style="width:14%; border:1px solid #000; padding:3px;">Mitra / Internal</th>
                <th style="width:10%; border:1px solid #000; padding:3px;">Signature</th>
                <th rowspan="{{ max(3, count($pmShelter->executors ?? [])) }}" style="vertical-align:bottom; text-align:center; border:1px solid #000; padding:8px 5px;">
                    <div style="height:45px;"></div>
                    <div class="signature-line"></div>
                    @if($pmShelter->verifikator)
                        <div style="font-weight:bold; font-size:9px; margin-top:4px;">{{ $pmShelter->verifikator['name'] ?? '' }}</div>
                        <div style="font-size:8px; color:#666; margin-top:1px;">{{ $pmShelter->verifikator['nik'] ?? '' }}</div>
                    @endif
                </th>
                <th rowspan="{{ max(3, count($pmShelter->executors ?? [])) }}" style="vertical-align:bottom; text-align:center; border:1px solid #000; padding:8px 5px;">
                    <div style="height:45px;"></div>
                    <div class="signature-line"></div>
                    @if($pmShelter->head_of_sub_dept)
                        <div style="font-weight:bold; font-size:9px; margin-top:4px;">{{ $pmShelter->head_of_sub_dept['name'] ?? '' }}</div>
                        <div style="font-size:8px; color:#666; margin-top:1px;">{{ $pmShelter->head_of_sub_dept['nik'] ?? '' }}</div>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $maxRows = max(3, count($pmShelter->executors ?? []));
            @endphp
            @for ($i = 0; $i < $maxRows; $i++)
                @php
                    $executor = isset($pmShelter->executors[$i]) ? $pmShelter->executors[$i] : null;
                @endphp
                <tr>
                    <td class="center" style="border:1px solid #000; padding:3px;">{{ $i + 1 }}</td>
                    <td style="border:1px solid #000; padding:3px; font-size:10px;">{{ $executor['name'] ?? '' }}</td>
                    <td class="center" style="border:1px solid #000; padding:3px; font-size:10px;">{{ $executor['mitra'] ?? '' }}</td>
                    <td style="border:1px solid #000; padding:3px;"></td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer">
        ©HakCipta PT., Indonesia<br>
        FM-LAP-D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter
    </div>

    @php
        $currentPage++;
    @endphp

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
            <div class="photo-page">
                <table class="header-table">
                    <tr>
                        <td class="header-left">
                            <table class="header-info-table">
                                <tr>
                                    <td class="header-info-label">No. Dok.</td>
                                    <td class="header-info-colon">:</td>
                                    <td class="header-info-value">FM-LAP-D2-SOP-003-009</td>
                                </tr>
                                <tr>
                                    <td class="header-info-label">Versi</td>
                                    <td class="header-info-colon">:</td>
                                    <td class="header-info-value">1.0</td>
                                </tr>
                                <tr>
                                    <td class="header-info-label">Hal</td>
                                    <td class="header-info-colon">:</td>
                                    <td class="header-info-value">{{ $currentPage }} dari {{ $totalPages }}</td>
                                </tr>
                                <tr>
                                    <td class="header-info-label">Label</td>
                                    <td class="header-info-colon">:</td>
                                    <td class="header-info-value">Internal</td>
                                </tr>
                            </table>
                        </td>
                        <td class="header-center">
                            <div class="title-text">Formulir</div>
                            <div class="title-text">Preventive Maintenance</div>
                            <div class="title-text">Ruang Shelter</div>
                        </td>
                        <td class="header-right">
                            <div class="logo-box">
                                <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo"
                                    style="width:55px; height:55px; object-fit:contain;">
                            </div>
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 8px; margin-bottom: 5px; border: 1px solid #000; border-radius: 4px; padding: 6px;">
                    <div class="bold" style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px;">
                        Photo Documentation{{ $chunkIndex > 0 ? ' (Continued ' . ($chunkIndex + 1) . ')' : '' }}
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

                                    <td style="width: 33.33%; padding: 4px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                                        @if ($fullPath && file_exists($fullPath))
                                            <div style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; margin-bottom: 4px; overflow: hidden; border-radius: 2px;">
                                                <img src="{{ $fullPath }}" alt="Foto"
                                                    style="max-width: 100%; max-height: 100%; object-fit: contain; image-rendering: auto; display: block;">
                                            </div>

                                            <div style="font-size: 8pt; font-weight: bold; color: #000; padding: 4px 2px; background: #f5f5f5; border-radius: 2px; text-align: center; min-height: 16px; display: flex; align-items: center; justify-content: center; line-height: 1.2;">
                                                {{ $sectionTitle }}
                                            </div>
                                        @else
                                            <div style="width: 100%; height: 280px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt; margin-bottom: 4px; border-radius: 2px; flex-direction: column;">
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
                                    <td style="width: 33.33%; padding: 4px; border: none;"></td>
                                @endfor
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="footer">
                    ©HakCipta PT., Indonesia<br>
                    FM-LAP-D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter
                </div>
            </div>

            @php
                $currentPage++;
            @endphp
        @endforeach
    @endif

</body>

</html>
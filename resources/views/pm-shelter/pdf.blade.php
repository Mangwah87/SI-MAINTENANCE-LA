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
            margin-top: 10px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 5px;
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
            min-height: 50px;
            padding: 6px;
            margin-top: 8px;
        }

        /* ===== SIGNATURE ===== */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .sign-table th,
        .sign-table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .sign-table th {
            text-align: center;
            font-weight: bold;
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

        /* Beri ruang untuk footer di setiap halaman */
        body {
            margin-bottom: 40px;
        }

        /* Prevent breaking inside important sections */
        .no-break {
            page-break-inside: avoid;
        }

        /* ===== PHOTO SECTION ===== */
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
        // Hitung total halaman
        $photosByField = [
            'kondisi_ruangan_photos' => ['title' => 'Kondisi Ruangan', 'photos' => []],
            'kondisi_kunci_photos' => ['title' => 'Kondisi Kunci Ruang/Shelter', 'photos' => []],
            'layout_tata_ruang_photos' => ['title' => 'Layout / Tata Ruang', 'photos' => []],
            'kontrol_keamanan_photos' => ['title' => 'Kontrol Keamanan', 'photos' => []],
            'aksesibilitas_photos' => ['title' => 'Aksesibilitas', 'photos' => []],
            'aspek_teknis_photos' => ['title' => 'Aspek Teknis', 'photos' => []],
        ];

        // Gabungkan semua foto dari semua field
        $allPhotos = [];
        if ($pmShelter->photos && is_array($pmShelter->photos)) {
            foreach ($pmShelter->photos as $photo) {
                $field = $photo['field'] ?? null;
                if ($field && isset($photosByField[$field])) {
                    $photo['section_title'] = $photosByField[$field]['title'];
                    $allPhotos[] = $photo;
                }
            }
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
            <td class="label">Brand / Type</td>
            <td class="colon">:</td>
            <td class="value">{{ $pmShelter->brand_type ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Reg. Number</td>
            <td class="colon">:</td>
            <td class="value">{{ $pmShelter->reg_number ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">S/N</td>
            <td class="colon">:</td>
            <td class="value">{{ $pmShelter->serial_number ?? '' }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th style="width:40%;">Descriptions</th>
                <th style="width:25%;">Result</th>
                <th style="width:20%;">Operational Standard</th>
                <th style="width:10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center bold" rowspan="3">1.</td>
                <td colspan="4" class="section-title">Visual Check</td>
            </tr>
            <tr>
                <td>a. Kondisi Ruangan</td>
                <td>{{ $pmShelter->kondisi_ruangan_result ?? '' }}</td>
                <td>Bersih, tidak bocor, tidak kotor</td>
                <td class="{{ $pmShelter->kondisi_ruangan_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->kondisi_ruangan_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>b. Kondisi Kunci Ruang/Shelter</td>
                <td>{{ $pmShelter->kondisi_kunci_result ?? '' }}</td>
                <td>Kuat, mudah dibuka</td>
                <td class="{{ $pmShelter->kondisi_kunci_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->kondisi_kunci_status ?? '' }}
                </td>
            </tr>

            <tr>
                <td class="center bold" rowspan="5">2.</td>
                <td colspan="4" class="section-title">Fasilitas Ruangan</td>
            </tr>
            <tr>
                <td>a. Layout / Tata Ruang</td>
                <td>{{ $pmShelter->layout_tata_ruang_result ?? '' }}</td>
                <td>Sesuai fungsi, kemudahan perawatan, kenyamanan penggunaan, keindahan dan termonitor</td>
                <td class="{{ $pmShelter->layout_tata_ruang_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->layout_tata_ruang_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>b. Kontrol Keamanan</td>
                <td>{{ $pmShelter->kontrol_keamanan_result ?? '' }}</td>
                <td>Aman dan termonitor</td>
                <td class="{{ $pmShelter->kontrol_keamanan_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->kontrol_keamanan_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>c. Aksesibilitas</td>
                <td>{{ $pmShelter->aksesibilitas_result ?? '' }}</td>
                <td>Alur pergerakan orang mudah dan tidak membahayakan, kemudahan akses ke perangkat</td>
                <td class="{{ $pmShelter->aksesibilitas_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->aksesibilitas_status ?? '' }}
                </td>
            </tr>
            <tr>
                <td>d. Aspek Teknis</td>
                <td>{{ $pmShelter->aspek_teknis_result ?? '' }}</td>
                <td>Tersedia power, grounding, pencahayaan, AC, Fire Protection, Smoke Detector, termonitor</td>
                <td class="{{ $pmShelter->aspek_teknis_status == 'OK' ? 'status-ok' : 'status-nok' }}">
                    {{ $pmShelter->aspek_teknis_status ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="no-break">
        <p style="margin-top: 10px; margin-bottom: 5px;"><strong>Notes / Additional Information:</strong></p>
        <div class="notes-box">{{ $pmShelter->notes ?? '' }}</div>
    </div>

    <table class="sign-table">
        <tr class="center bold">
            <th style="text-align: left; border: none;">Pelaksana</th>
            <th style="width:30%; border: none;">Mengetahui</th>
        </tr>
        <tr>
            <td style="border: none">
                @if ($pmShelter->executors && count($pmShelter->executors) > 0)
                    <table style="width:100%; border-collapse: collapse;">
                        <tr class="center bold" style="background:#f0f0f0;">
                            <td style="border:1px solid #000; width:6%;">No</td>
                            <td style="border:1px solid #000; width:48%;">Nama</td>
                            <td style="border:1px solid #000; width:23%;">Departement</td>
                            <td style="border:1px solid #000; width:33%;">Sub Departement</td>
                        </tr>
                        @foreach ($pmShelter->executors as $i => $ex)
                            <tr>
                                <td class="center" style="border:1px solid #000;">{{ $i + 1 }}</td>
                                <td style="border:1px solid #000;">{{ $ex['name'] ?? '' }}</td>
                                <td style="text-align: center; border:1px solid #000;">{{ $ex['department'] ?? '' }}
                                </td>
                                <td style="text-align: center; border:1px solid #000;">
                                    {{ $ex['sub_department'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div style="text-align:center; padding:20px; color:#999;">Tidak ada data pelaksana</div>
                @endif
            </td>

            <td class="center" style="vertical-align:bottom; padding:5px;">
                <div
                    style="width:60%; height: 100px; margin:auto; text-align:center; position: relative; line-height:1.2;">
                    <div style="margin:0; padding:0; position: absolute; bottom: 0; width: 100%;">
                        <span style="display:block; font-weight:bold; margin:0; padding:0;">
                            {{ $pmShelter->approvers[0]['name'] ?? '' }}
                        </span>
                        <div style="border-bottom:1px solid #000; width:100%; margin:2px 0;"></div>
                        <span style="display:block; margin:0; padding:0;">
                            {{ $pmShelter->approvers[0]['nik'] ?? '' }}
                        </span>
                    </div>
                </div>
            </td>


        </tr>
    </table>

    <div class="footer">
        ©HakCipta PT., Indonesia<br>
        FM-LAP-D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter
    </div>

    @php
        $currentPage++;
    @endphp

    <!-- PHOTO PAGES -->
    @if (count($allPhotos) > 0)
        @php
            $photoChunks = array_chunk($allPhotos, 6);
        @endphp

        @foreach ($photoChunks as $chunkIndex => $photoChunk)
            <div class="photo-page">
                <!-- HEADER untuk halaman foto -->
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

                <div
                    style="margin-top: 8px; margin-bottom: 5px; border: 1px solid #000; border-radius: 4px; padding: 6px;">
                    <div class="bold"
                        style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px;">
                        Dokumentasi Foto{{ $chunkIndex > 0 ? ' (Lanjutan ' . ($chunkIndex + 1) . ')' : '' }}
                    </div>

                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach (array_chunk($photoChunk, 3) as $rowIndex => $rowPhotos)
                            <tr>
                                @foreach ($rowPhotos as $colIndex => $photo)
                                    @php
                                        $fullPath = public_path('storage/' . $photo['path']);
                                    @endphp

                                    <td
                                        style="width: 33.33%; padding: 4px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                                        @if (file_exists($fullPath))
                                            <div
                                                style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; margin-bottom: 4px; overflow: hidden; border-radius: 2px;">
                                                <img src="{{ $fullPath }}" alt="Foto"
                                                    style="max-width: 100%; max-height: 100%; object-fit: contain; image-rendering: auto; display: block;">
                                            </div>

                                            <div
                                                style="font-size: 8pt; font-weight: bold; color: #000; padding: 4px 2px; background: #f5f5f5; border-radius: 2px; text-align: center; min-height: 16px; display: flex; align-items: center; justify-content: center; line-height: 1.2;">
                                                {{ $photo['section_title'] ?? 'Dokumentasi' }}
                                            </div>
                                        @else
                                            {{-- Placeholder jika foto tidak ada --}}
                                            <div
                                                style="width: 100%; height: 180px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt; margin-bottom: 4px; border-radius: 2px;">
                                                Foto tidak ditemukan
                                            </div>
                                            <div style="min-height: 36px; background: #f5f5f5; border-radius: 2px;">
                                            </div>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Isi sel kosong jika foto tidak sampai 3 --}}
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

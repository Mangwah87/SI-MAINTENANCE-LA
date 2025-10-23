<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Formulir Preventive Maintenance Ruang Shelter</title>
    <style>
        @page {
             margin: 50mm 20mm 20mm 20mm; /* atas, kanan, bawah, kiri */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            vertical-align: top;
        }

        .center { text-align: center; }
        .bold { font-weight: bold; }

        /* ===== HEADER (FIXED untuk setiap halaman) ===== */
        #header {
            position: fixed;
            top: -35mm;
            left: 0;
            right: 0;
            height: 130mm;
        }
        .content {
            padding-top: 90px; /* sesuaikan sampai isi tidak menabrak header */
        }

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
            border: 1px solid #000;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            font-weight: bold;
            font-size: 24px;
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

        .main-table th, .main-table td {
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

        .sign-table th, .sign-table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .sign-table th {
            text-align: center;
            font-weight: bold;
        }

        /* ===== FOOTER (FIXED untuk setiap halaman) ===== */
        #footer {
            position: fixed;
            bottom: -30mm;
            left: 0;
            right: 0;
            height: 30mm;
            border-top: 1px solid gray;
            padding-top: 8px;
        }

        .footer-table {
            width: 100%;
            font-size: 8px;
            color: gray;
        }

        .footer-left {
            text-align: left;
            vertical-align: top;
        }

        .footer-right {
            text-align: right;
            vertical-align: top;
        }

        /* Prevent breaking inside important sections */
        .no-break {
            page-break-inside: avoid;
        }

    </style>
</head>
<body>

<!-- HEADER FIXED (akan muncul di setiap halaman) -->
<div id="header">
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
                        <td class="header-info-value">
                            <span style="display:inline-block; min-width: 60px;">
                                <script type="text/php">
                                    if (isset($pdf)) {
                                        $pageNum = $PAGE_NUM;
                                        $pageCount = $PAGE_COUNT;
                                        echo "Hal : {$pageNum} dari {$pageCount}";
                                    }
                                </script>
                            </span>
                        </td>
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
                <div class="logo-box" style="border:none; background:none;">
                    <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo" style="width:55px; height:55px; object-fit:contain;">
                </div>
            </td>
        </tr>
    </table>

    <!-- INFO BOX di dalam header agar muncul di setiap halaman -->
    <table class="info-box">
        <tr>
            <td class="label">Location</td>
            <td class="colon">:</td>
            <td class="value">{{ $pmShelter->location ?? '' }}</td>
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
</div>

<!-- FOOTER FIXED (akan muncul di setiap halaman) -->
<div id="footer">
    <table class="footer-table">
        <tr>
            <td class="footer-left">
                ©HakCipta PT., Indonesia<br>
                FM-LAP-D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter
            </td>
        </tr>
    </table>
</div>

<!-- KONTEN UTAMA -->
<div class="content">
    <!-- MAIN TABLE -->
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

    <!-- NOTES -->
    <div class="no-break">
        <p style="margin-top: 10px; margin-bottom: 5px;"><strong>Notes / Additional Information:</strong></p>
        <div class="notes-box">{{ $pmShelter->notes ?? '' }}</div>
    </div>
    

    <!-- SIGNATURE -->
    <table class="sign-table">
        <tr class="center bold">
            <th style="text-align: left; border: none;">Pelaksana</th>
            <th style="width:30%; border: none;">Mengetahui</th>
        </tr>
        <tr>
            <td style="border: none">
                @if($pmShelter->executors && count($pmShelter->executors) > 0)
                <table style="width:100%; border-collapse: collapse;">
                    <tr class="center bold" style="background:#f0f0f0;">
                        <td style="border:1px solid #000; width:6%;">No</td>
                        <td style="border:1px solid #000; width:48%;">Nama</td>
                        <td style="border:1px solid #000; width:23%;">Departemen</td>
                        <td style="border:1px solid #000; width:23%;">Sub Departemen</td>
                    </tr>
                    @foreach($pmShelter->executors as $i => $ex)
                    <tr>
                        <td class="center" style="border:1px solid #000;">{{ $i + 1 }}</td>
                        <td style="border:1px solid #000;">{{ $ex['name'] ?? '' }}</td>
                        <td style="border:1px solid #000;">{{ $ex['department'] ?? '' }}</td>
                        <td style="border:1px solid #000;">{{ $ex['sub_department'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </table>
                @else
                <div style="text-align:center; padding:20px; color:#999;">Tidak ada data pelaksana</div>
                @endif
            </td>

            <td class="center" style="vertical-align:bottom; padding:10px;">
                <div style="height:60px;"></div>
                <div style="border-top:1px solid #000; width:80%; margin:auto; padding-top:5px;">
                    {{ $pmShelter->approver_name ?? '(_________________)' }}
                </div>
            </td>
        </tr>
    </table>
</div>

<script type="text/php">
    if (isset($pdf)) {
        $font = $fontMetrics->get_font("Arial", "normal");
        $size = 8;

        $pageNum = $PAGE_NUM;
        $pageCount = $PAGE_COUNT;
        $text = "Hal : {$pageNum} dari {$pageCount}";

        // Geser posisi supaya sejajar kolom "Hal" di header tabel
        $x = 127;   // jarak dari kiri halaman
        $y = 90;   // jarak dari atas halaman (atur sesuai posisi tabelmu)

        $pdf->text($x, $y, $text, $font, $size);
    }
</script>



</body>
</html>
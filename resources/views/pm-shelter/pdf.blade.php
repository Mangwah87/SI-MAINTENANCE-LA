<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Formulir Preventive Maintenance Ruang Shelter</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        
       

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            position: relative;
            min-height: 100vh;
            padding-bottom: 60px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* === HEADER === */
        .header-table {
            border: 1px solid #000;
            width: 100%;
        }
        .header-table td {
            border: 1px solid #000;
            vertical-align: middle;
            padding: 8px;
        }
        .header-left { 
            width: 35%; 
            font-size: 9pt;
            line-height: 1.6;
        }
        .header-left div {
            display: flex;
        }
        .header-left div strong {
            display: inline-block;
            width: 80px;
        }
        .header-center {
            width: 45%;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            line-height: 1.4;
        }
        .header-center .title-main {
            font-size: 11pt;
        }
        .header-right { 
            width: 20%; 
            text-align: center; 
            font-size: 9pt;
        }

        /* === INFO UMUM === */
        .info-table { 
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .info-table td { 
            padding: 3px 0; 
            font-size: 10pt; 
        }
        .info-label { 
            width: 25%; 
            font-weight: normal;
        }

        /* === CHECK TABLE === */
        .check-table {
            margin-top: 10px;
        }
        .check-table th, .check-table td {
            border: 1px solid #000;
            padding: 6px;
        }
        .check-table th {
            text-align: center;
            background: #f2f2f2;
            font-size: 10pt;
            font-weight: bold;
        }
        .check-table td { 
            font-size: 10pt; 
            vertical-align: top; 
        }
        .section-title {
            background: #e5e5e5;
            font-weight: bold;
            text-align: left;
            padding: 6px;
            border: 1px solid #000;
        }

        /* === NOTES === */
        .notes-section {
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .notes-label { 
            font-weight: normal; 
            margin-bottom: 5px;
            font-size: 10pt;
        }
        .notes-box {
            border: 1px solid #000;
            min-height: 70px;
            padding: 8px;
        }

        /* === SIGNATURES === */
        .signature-container {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .signature-container td {
            vertical-align: top;
            padding: 0;
        }
        .signature-title {
            font-weight: bold;
            text-align: left;
            margin-bottom: 8px;
            font-size: 10pt;
        }
        .signature-table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
        }
        .signature-table th,
        .signature-table td {
            border: 1px solid #000;
            text-align: center;
            font-size: 9pt;
            padding: 6px 4px;
        }
        .signature-table th {
            background: #f2f2f2;
            font-weight: bold;
        }
        .mengetahui-box {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .mengetahui-space {
            flex-grow: 1;
            min-height: 60px;
        }
        .mengetahui-name {
            padding-top: 8px;
            margin-top: 5px;
            font-size: 9pt;
        }

        /* === FOOTER === */
        .footer {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            font-size: 8pt;
            color: #333;
            border-top: 0.5pt solid #000;
            padding-top: 4px;
        }
        .footer-left { 
            float: left; 
            opacity: 0.7; 
        }
        .footer-center {
            clear: both;
            text-align: left;
            font-size: 8pt;
            opacity: 0.7;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td class="header-left">
                <div><strong>No. Dok. :</strong> FM-LAP- D2-SOP-003-009</div>
                <div><strong>Versi :</strong> 1.0</div>
                <div><strong>Hal :</strong> 1 dari 1</div>
                <div><strong>Label :</strong> Internal</div>
            </td>
            <td class="header-center">
                <div>Formulir</div>
                <div class="title-main">Preventive Maintenance</div>
                <div class="title-main">Ruang Shelter</div>
            </td>
            <td class="header-right">
                <div style="width: 60px; height: 60px; border: 1px solid #000; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 9pt;">logo</div>
            </td>
        </tr>
    </table>

    <!-- INFORMASI UMUM -->
    <table class="info-table">
        <tr><td class="info-label">Location</td><td>: {{ $shelter->location }}</td></tr>
        <tr><td class="info-label">Date / time</td><td>: {{ $shelter->date_time->format('d/m/Y H:i') }}</td></tr>
        <tr><td class="info-label">Brand / Type</td><td>: {{ $shelter->brand_type }}</td></tr>
        <tr><td class="info-label">Reg. Number</td><td>: {{ $shelter->reg_number }}</td></tr>
        <tr><td class="info-label">S/N</td><td>: {{ $shelter->serial_number }}</td></tr>
    </table>

    <!-- TABEL PEMERIKSAAN -->
    <table class="check-table">
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th style="width:30%;">Descriptions</th>
                <th style="width:20%;">Result</th>
                <th style="width:35%;">Operational Standard</th>
                <th style="width:10%;">Status<br>(OK/NOK)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="5" class="section-title">1. Visual Check</td></tr>
            <tr>
                <td style="text-align:center;">a.</td>
                <td>Kondisi Ruangan</td>
                <td>{{ $shelter->kondisi_ruangan_result ?? '-' }}</td>
                <td>Bersih, tidak bocor, tidak kotor</td>
                <td style="text-align:center; font-weight: bold;">
                    {{ $shelter->kondisi_ruangan_status ? 'OK' : 'NOK' }}
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">b.</td>
                <td>Kondisi Kunci Ruang/Shelter</td>
                <td>{{ $shelter->kondisi_kunci_result ?? '-' }}</td>
                <td>Kuat, Mudah dibuka</td>
                <td style="text-align:center; font-weight: bold;">
                    {{ $shelter->kondisi_kunci_status ? 'OK' : 'NOK' }}
                </td>
            </tr>

            <tr><td colspan="5" class="section-title">2. Fasilitas Ruangan</td></tr>
            <tr>
                <td style="text-align:center;">a.</td>
                <td>Layout / Tata Ruang</td>
                <td>{{ $shelter->layout_result ?? '-' }}</td>
                <td>Sesuai fungsi, kemudahan perawatan, kenyamanan penggunaan, keindahan</td>
                <td style="text-align:center; font-weight: bold;">
                    {{ $shelter->layout_status ? 'OK' : 'NOK' }}
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">b.</td>
                <td>Kontrol Keamanan</td>
                <td>{{ $shelter->kontrol_keamanan_result ?? '-' }}</td>
                <td>Aman, dan Termonitor</td>
                <td style="text-align:center; font-weight: bold;">
                    {{ $shelter->kontrol_keamanan_status ? 'OK' : 'NOK' }}
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">c.</td>
                <td>Aksesibilitas</td>
                <td>{{ $shelter->aksesibilitas_result ?? '-' }}</td>
                <td>Alur pergerakan orang mudah dan tidak membahayakan, kemudahan akses ke perangkat</td>
                <td style="text-align:center; font-weight: bold;">
                    {{ $shelter->aksesibilitas_status ? 'OK' : 'NOK' }}
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">d.</td>
                <td>Aspek Teknis</td>
                <td>{{ $shelter->aspek_teknis_result ?? '-' }}</td>
                <td>Tersedia power, penangkal petir, grounding, pencahayaan, AC, Fire Protection, dan Termonitor.</td>
                <td style="text-align:center; font-weight: bold;">
                    {{ $shelter->aspek_teknis_status ? 'OK' : 'NOK' }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- NOTES -->
    <div class="notes-section">
        <div class="notes-label">Notes / additional informations :</div>
        <div class="notes-box">
            {!! nl2br(e($shelter->notes ?? '-')) !!}
        </div>
    </div>

    <!-- SIGNATURE SECTION -->
    <table class="signature-container">
        <tr>
            <td style="width: 70%; padding-right: 15px;">
                <div class="signature-title">Pelaksana</div>
                <table class="signature-table">
                    <tr>
                        <th style="width:8%;">No</th>
                        <th style="width:35%;">Nama</th>
                        <th style="width:28%;">Departement</th>
                        <th style="width:29%;">Sub Departement</th>
                    </tr>
                    @php
                        $pelaksana = is_array($shelter->pelaksana) ? $shelter->pelaksana : json_decode($shelter->pelaksana, true);
                    @endphp
                    @for ($i = 0; $i < 3; $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ isset($pelaksana[$i]['nama']) ? $pelaksana[$i]['nama'] : '' }}</td>
                            <td>{{ isset($pelaksana[$i]['departemen']) ? $pelaksana[$i]['departemen'] : '' }}</td>
                            <td>{{ isset($pelaksana[$i]['sub_departemen']) ? $pelaksana[$i]['sub_departemen'] : '' }}</td>
                        </tr>
                    @endfor
                </table>
            </td>

            <td style="width: 30%;">
                <div class="signature-title">Mengetahui</div>
                <div class="mengetahui-box">
                    <div class="mengetahui-space"></div>
                    <div class="mengetahui-name">
                        {{ $shelter->mengetahui ?? '' }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-left">©HakCipta PT., Indonesia</div>
        <div class="footer-center">
            FM-LAP- D2-SOP-003-009 Formulir Preventive Maintenance Ruang Shelter
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Formulir Tindak Lanjut Preventive Maintenance</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family:  Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table { border-collapse: collapse; width: 100%; }
        td, th { vertical-align: top; }

        .center { text-align: center; }
        .bold { font-weight: bold; }

        /* ===== HEADER ===== */
        .header-table { width: 100%; margin-bottom: 15px; }
        .header-table td { border: 1px solid #000; vertical-align: middle; padding: 0; }
        .header-left { width: 40%; border: none; }
        .header-center { width: 40%; text-align: center; padding: 25px 10px; }
        .header-right { width: 20%; text-align: center; padding: 25px 10px; }

        .header-info-table { width: 100%; border-collapse: collapse; }
        .header-info-table td { border: none; padding: 5px 8px; font-size: 11px; }
        .header-info-label { font-weight: bold; width: 25%; }
        .header-info-colon { width: 8%; text-align: center; }
        .header-info-value { width: 67%; }

        .title-text { font-size: 18px; font-weight: bold; margin: 3px 0; }
 
        .logo-box img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }
        /* ===== FORM CONTENT ===== */
        .form-row, .form-row-double { width: 100%; margin-bottom: 8px; display: table; }
        .form-col { display: table-cell; width: 50%; }
        .form-label { display: table-cell; width: 20%; font-weight: normal; }
        .form-colon { display: table-cell; width: 2%; text-align: center; }
        .form-value { display: table-cell; width: 78%; border-bottom: 0.5px solid #000; padding: 2px 5px; }

        .section-title { font-weight: bold; margin-top: 12px; margin-bottom: 6px; }
        .text-box { height: auto; border: 1px solid #000; padding: 8px; white-space: pre-wrap; word-wrap: break-word; min-height:auto; }
        .notes-box { border: 1px solid #000; padding: 8px; white-space: pre-wrap; word-wrap: break-word; min-height: 40px; }

        /* ===== CHECKBOX STYLE ===== */
        .checkbox-group {
            margin-top: 10px;
            margin-bottom: 8px;
        }

        .checkbox-item {
            display: block;
            margin-bottom: 5px;
        }

        .checkbox-box {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #000;
            margin-right: 8px;
            vertical-align: middle;
            position: relative;
        }

        /* kotak yang dicentang */
        .checkbox-box.checked {
            background-color: #000;
        }

        /* centang putih menggunakan CSS, bukan karakter teks */
        .checkbox-box.checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* ===== PELAKSANA TABLE ===== */
        .pelaksana-table { width: 100%; border-collapse: collapse; margin-top: 12px; font-size: 11px; }
        .pelaksana-table th, .pelaksana-table td { border: 1px solid #000; padding: 6px; text-align: center; }
        .pelaksana-table th { font-weight: bold; background-color: #f0f0f0; }
        .signature-box { height: 50px; margin: 5px 0; }

        /* ===== FOOTER ===== */
        .footer { margin-top: 25px; padding-top: 8px; border-top: 1px solid gray; font-size: 8px; color: gray; text-align: center; }
    </style>
</head>
<body>

<!-- HEADER -->
<table class="header-table">
    <tr>
        <td class="header-left">
            <table class="header-info-table">
                <tr><td class="header-info-label">No. Dok.</td><td class="header-info-colon">:</td><td class="header-info-value">FM-LAP-D2-SOP-003-005</td></tr>
                <tr><td class="header-info-label">Versi</td><td class="header-info-colon">:</td><td class="header-info-value">1.0</td></tr>
                <tr><td class="header-info-label">Hal</td><td class="header-info-colon">:</td><td class="header-info-value">1 dari 1</td></tr>
                <tr><td class="header-info-label">Label</td><td class="header-info-colon">:</td><td class="header-info-value">Internal</td></tr>
            </table>
        </td>
        <td class="header-center">
            <div class="title-text">Formulir</div>
            <div class="title-text">Tindak Lanjut</div>
            <div class="title-text">Preventive Maintenance</div>
        </td>
        <td class="header-right">
            <div class="logo-box">
                <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo">
            </div>
        </td>
    </tr>
</table>

<!-- BERDASARKAN -->
<div class="section-title">Berdasarkan :</div>
<div class="checkbox-group">
    <div class="checkbox-item">
        <span class="checkbox-box {{ $tindakLanjut->permohonan_tindak_lanjut ? 'checked' : '' }}"></span>
        Permohonan Tindak Lanjut Maintenance
    </div>
    <div class="checkbox-item">
        <span class="checkbox-box {{ $tindakLanjut->pelaksanaan_pm ? 'checked' : '' }}"></span>
        Pelaksanaan PM
    </div>
</div>

<!-- INFO PELAKSANAAN -->
<div class="form-row-double">
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Tanggal</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $tindakLanjut->tanggal ? $tindakLanjut->tanggal->format('d/m/Y') : '' }}</span>
        </div>
    </div>
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Jam</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $tindakLanjut->jam }}</span>
        </div>
    </div>
</div>

<div class="form-row-double">
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Lokasi</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $tindakLanjut->lokasi }}</span>
        </div>
    </div>
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Ruang</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $tindakLanjut->ruang }}</span>
        </div>
    </div>
</div>

<!-- PERMASALAHAN -->
<div class="section-title">Permasalahan yang terjadi :</div>
<div class="text-box">{{ $tindakLanjut->permasalahan }}</div>

<!-- TINDAKAN PENYELESAIAN -->
<div class="section-title">Tindakan penyelesaian masalah :</div>
<div class="text-box">{{ $tindakLanjut->tindakan_penyelesaian }}</div>

<!-- HASIL PERBAIKAN -->
<div class="section-title">Hasil perbaikan :</div>
<div class="text-box">{{ $tindakLanjut->hasil_perbaikan }}</div>

<!-- STATUS HASIL -->
<div class="checkbox-group">
    <div class="checkbox-item">
        <span class="checkbox-box {{ $tindakLanjut->selesai ? 'checked' : '' }}"></span>
        Selesai
        <span style="margin-left: 20px;">Tanggal :</span>
        <span style="display:inline-block;width:100px;border-bottom:1px solid #000;">{{ $tindakLanjut->selesai_tanggal ? $tindakLanjut->selesai_tanggal->format('d/m/Y') : '' }}</span>
        <span>Jam :</span>
        <span style="display:inline-block;width:80px;border-bottom:1px solid #000;">{{ $tindakLanjut->selesai_jam ?? '' }}</span>
    </div>
    <div class="checkbox-item">
        <span class="checkbox-box {{ $tindakLanjut->tidak_selesai ? 'checked' : '' }}"></span>
        Tidak selesai, Tindak lanjut :
    </div>
</div>
<div class="notes-box">{{ $tindakLanjut->tidak_lanjut }}</div>

<!-- BAGIAN PELAKSANA & MENGETAHUI (versi proporsional dan terpisah) -->
<table style="width:100%; border-collapse:collapse; margin-top:15px;">
    <tr>
        <!-- Kolom kiri: PELAKSANA -->
        <td style="width:72%; vertical-align:top;">
            <table style="width:100%; border-collapse:collapse; font-size:11px;">
                <tr>
                    <th colspan="4" style="text-align:left; border:1px solid #000; padding:4px;">Pelaksana</th>
                </tr>
                <tr>
                    <th style="width:6%; border:1px solid #000; text-align:center;">No</th>
                    <th style="width:44%; border:1px solid #000; text-align:center;">Nama</th>
                    <th style="width:25%; border:1px solid #000; text-align:center;">Departement</th>
                    <th style="width:25%; border:1px solid #000; text-align:center;">Sub Departement</th>
                </tr>
                @for ($i = 1; $i <= 4; $i++)
                <tr>
                    <td style="border:1px solid #000; text-align:center;">{{ $i }}.</td>
                    <td style="border:1px solid #000;">{{ $tindakLanjut->pelaksana[$i-1]['nama'] ?? '' }}</td>
                    <td style="border:1px solid #000;">{{ $tindakLanjut->pelaksana[$i-1]['department'] ?? '' }}</td>
                    <td style="border:1px solid #000;">{{ $tindakLanjut->pelaksana[$i-1]['sub_department'] ?? '' }}</td>
                </tr>
                @endfor
            </table>
        </td>

        <!-- Kolom kanan: MENGETAHUI -->
        <td style="width:25%; vertical-align:top;">
            <table style="width:100%; border-collapse:collapse; font-size:11px;">
                <tr>
                    <th style="border:1px solid #000; padding:4px; text-align:center;">Mengetahui</th>
                </tr>
                <tr>
                    <td style="border:1px solid #000; text-align:center; height:91px; vertical-align:bottom;">
                        <div style="text-decoration: underline">( {{ $tindakLanjut->mengetahui['nama']  }} )</div>
                        <div>({{ $tindakLanjut->mengetahui['nik'] }})</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


<!-- FOOTER -->
<div style="text-align: left" class="footer">
    © Hak Cipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
    FM-LAP-D2-SOP-003-005 Formulir Tindak Lanjut Preventive Maintenance
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Formulir Permohonan Tindak Lanjut Preventive Maintenance</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .header-table td {
            border: 1px solid #000;
            vertical-align: middle;
            padding: 0;
        }

        .header-left {
            width: 40%;
            border: none;
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

        .logo-box img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        /* ===== FORM CONTENT ===== */
        .form-row, .form-row-double {
            width: 100%;
            margin-bottom: 8px;
            display: table;
        }

        .form-col {
            display: table-cell;
            width: 50%;
        }

        .form-label {
            display: table-cell;
            width: 20%;
            font-weight: normal;
        }

        .form-colon {
            display: table-cell;
            width: 2%;
            text-align: center;
        }

        .form-value {
            display: table-cell;
            width: 78%;
            border-bottom: 0.5px solid #000;
            padding: 2px 5px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        .text-box{
            border: 1px solid #000;
            padding: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 90px;
        }
        .notes-box {
            border: 1px solid #000;
            padding: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 60px;
        }

        .info-section {
            margin-top: 15px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        /* TABEL PEMOHON DAN DITUJUKAN */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: middle;
        }

        .info-table .label {
            width: 14%;
        }

        .info-table .colon {
            width: 2%;
            text-align: center;
        }

        .info-table .value {
            width: 34%;
        }

        .info-table .right-label {
            width: 18%;
            padding-left: 20px;
        }

        .info-table .right-colon {
            width: 2%;
            text-align: center;
        }

        .info-table .right-value {
            width: 30%;
        }

        .section-title-table {
            font-weight: bold;
            padding-bottom: 5px;
        }

        .divider {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }

        /* ===== CHECKBOX STYLE ===== */
        .checkbox-group {
            margin-top: 10px;
        }

        .checkbox-item {
            display: inline-block;
            margin-right: 30px;
            position: relative;
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

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            padding-top: 8px;
            border-top: 1px solid gray;
            font-size: 8px;
            color: gray;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<table class="header-table">
    <tr>
        <td class="header-left">
            <table style="border:none" class="header-info-table">
                <tr><td class="header-info-label">No. Dok.</td><td class="header-info-colon">:</td><td class="header-info-value">FM-LAP-D2-SOP-003-004</td></tr>
                <tr><td class="header-info-label">Versi</td><td class="header-info-colon">:</td><td class="header-info-value">1.0</td></tr>
                <tr><td class="header-info-label">Hal</td><td class="header-info-colon">:</td><td class="header-info-value">1 dari 1</td></tr>
                <tr><td class="header-info-label">Label</td><td class="header-info-colon">:</td><td class="header-info-value">Internal</td></tr>
            </table>
        </td>
        <td class="header-center">
            <div class="title-text">Formulir</div>
            <div class="title-text">Permohonan Tindak Lanjut</div>
            <div class="title-text">Preventive Maintenance</div>
        </td>
        <td class="header-right">
            <div class="logo-box">
                <img src="{{ public_path('assets/images/logo2.jpg') }}" alt="Logo">
            </div>
        </td>
    </tr>
</table>

<!-- KONTEN -->
<div class="form-row-double">
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Tanggal</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $permohonan->tanggal->format('d/m/Y') }}</span>
        </div>
    </div>
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Jam</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $permohonan->jam }}</span>
        </div>
    </div>
</div>

<div class="form-row-double">
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Lokasi</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $permohonan->lokasi }}</span>
        </div>
    </div>
    <div class="form-col">
        <div class="form-row">
            <span class="form-label">Ruang</span>
            <span class="form-colon">:</span>
            <span class="form-value">{{ $permohonan->ruang }}</span>
        </div>
    </div>
</div>

<div class="divider"></div>

<div class="section-title">Permasalahan yang terjadi :</div>
<div class="text-box">{{ $permohonan->permasalahan }}</div>

<div class="section-title">Usulan tindak lanjut :</div>
<div class="text-box">{{ $permohonan->usulan_tindak_lanjut }}</div>

<!-- PEMOHON -->
<div class="info-section">
    <table class="info-table">
        <tr>
            <td colspan="6" class="section-title-table">Pemohon</td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="value">{{ $permohonan->nama }}</td>

            <td class="right-label">Tanda tangan</td>
            <td class="right-colon">:</td>
            <td class="right-value"></td>
        </tr>
        <br>
        <tr>
            <td class="label">Departement</td>
            <td class="colon">:</td>
            <td class="value">{{ $permohonan->department }}</td>

            <td class="right-label">Sub Departement</td>
            <td class="right-colon">:</td>
            <td class="right-value">{{ $permohonan->sub_department ?? '' }}</td>
        </tr>
    </table>
</div>

<!-- DITUJUKAN KEPADA -->
<div class="info-section">
    <table class="info-table">
        <tr>
            <td colspan="6" class="section-title-table">Ditujukan Kepada</td>
        </tr>
        <tr>
            <td class="label">Departement</td>
            <td class="colon">:</td>
            <td class="value">{{ $permohonan->ditujukan_department }}</td>

            <td class="right-label">Sub Departement</td>
            <td class="right-colon">:</td>
            <td class="right-value">{{ $permohonan->ditujukan_sub_department ?? '' }}</td>
        </tr>
    </table>
</div>

<div class="info-section">
    <div class="bold">Diinformasikan melalui :</div>
    <br>
    <div class="checkbox-group">
        <div class="checkbox-item">
            <span class="checkbox-box {{ $permohonan->diinformasikan_melalui == 'email' ? 'checked' : '' }}"></span>Email
        </div>
        <div class="checkbox-item">
            <span class="checkbox-box {{ $permohonan->diinformasikan_melalui == 'fax' ? 'checked' : '' }}"></span>Fax
        </div>
        <div class="checkbox-item">
            <span class="checkbox-box {{ $permohonan->diinformasikan_melalui == 'hardcopy' ? 'checked' : '' }}"></span>Hardcopy
        </div>
    </div>
</div>

<div class="info-section">
    <div class="bold">Catatan :</div>
    <br>
    <div class="notes-box">{{ $permohonan->catatan ?? '' }}</div>
</div>

<!-- FOOTER -->
<div class="footer">
    © Hak Cipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
    FM-LAP-D2-SOP-003-004 Formulir Permohonan Tindak Lanjut Preventive Maintenance
</div>

</body>
</html>

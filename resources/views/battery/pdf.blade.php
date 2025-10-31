<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jadwal PM Sentral - {{ Carbon\Carbon::parse($schedule->bulan)->locale('id')->isoFormat('MMMM YYYY') }}</title>
    <style>
        @page {
            /* Menggunakan Landscape agar 31 kolom muat dengan baik */
            margin: 8mm 5mm 10mm 5mm; 
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 7pt; 
            color: #000;
        }
        
        /* === TATA LETAK HEADER DOKUMEN === */
        .doc-header table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
            /* Border luar tebal */
            border: 2px solid #000; 
        }
        .doc-header td {
            border: 1px solid #000;
            padding: 3px;
        }
        .doc-header .logo-cell { 
            width: 10%; 
            text-align: center;
        }
        .doc-header .title-cell { 
            width: 60%;
            font-weight: bold;
            font-size: 9pt;
            text-align: center;
            background-color: #f0f0f0; /* Warna latar belakang */
        }
        .doc-header .info-cell { 
            width: 30%;
            border: none;
            padding: 0;
        }
        .info-cell table {
            width: 100%;
            border: none;
        }
        .info-cell table td {
            border: none;
            padding: 1px 2px;
            text-align: left;
            border-bottom: 1px solid #000;
        }
        .info-cell table tr:last-child td {
             border-bottom: none;
        }

        /* === TABEL JADWAL UTAMA === */
        .table-container {
            width: 100%;
            margin-top: 5px;
        }
        table.main-schedule {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }
        .main-schedule th, .main-schedule td {
            border: 1px solid #000;
            padding: 1px 0px; 
            text-align: center;
            vertical-align: middle;
            height: 12px;
        }
        .main-schedule th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        /* Penyesuaian Kolom */
        .no-col-main { width: 3%; }
        .lokasi-col-main { width: 10%; text-align: left; padding-left: 3px; }
        .r-c-col { width: 5%; font-weight: bold; font-size: 6pt;}
        .petugas-col { width: 8%; font-size: 6pt; }

        /* Kolom untuk tanggal 1-31 */
        .day-col {
            width: 2.38%; 
            font-size: 6pt;
        }
        .symbol {
            font-weight: bold;
            font-size: 7pt;
            line-height: 1;
        }
        /* Sel untuk hari yang tidak ada (di luar daysInMonth) */
        .main-schedule td.disabled-day {
            background-color: #f0f0f0;
        }

        /* Tanda Tangan */
        .signature-table {
            width: 100%; 
            border-collapse: collapse; 
            font-size: 8pt; 
            table-layout: fixed;
            margin-top: 15px;
        }
        .signature-table td {
            border: 1px solid #000;
            vertical-align: top;
            padding: 5px;
        }
        .ket-header {
            border: none !important; 
            text-align: left !important; 
            font-weight: bold; 
            padding-left: 0 !important; 
        }

    </style>
</head>
<body>

@php
    use Carbon\Carbon;
    $date = Carbon::parse($schedule->bulan);
    $daysInMonth = $date->daysInMonth;
    $monthYear = $date->locale('id')->isoFormat('MMMM YYYY');
    
    // Konfigurasi Kertas untuk 31 hari (sudah di set di Controller: landscape)
@endphp

{{-- ================================================================= --}}
    {{-- HEADER DOKUMEN --}}
    {{-- ================================================================= --}}
    <div class="doc-header" style="margin-bottom: 3px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 7pt; table-layout: fixed;">
            <tr>
                {{-- Kiri: Detail Dokumen (No. Dok, Versi, Hal, Label) --}}
                {{-- Lebar Kolom 35% --}}
                <td style="width: 35%; border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 6.5pt; table-layout: fixed;">
                        
                        {{-- Baris 1: No. Dok. --}}
                        <tr>
                            {{-- Padding dikurangi, Garis Vertikal dan Horizontal --}}
                            <td style="width: 30%; text-align: left; border: none; border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 1px 2px;">No. Dok.</td>
                            <td style="width: 70%; text-align: left; border: none; border-bottom: 1px solid #000; padding: 1px 2px;">
                                {{ $schedule->doc_number ?? 'FM-LAP-D2-SOP-003-007-X' }} 
                            </td>
                        </tr>
                        
                        {{-- Baris 2: Versi --}}
                        <tr>
                            <td style="width: 30%; text-align: left; border: none; border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 1px 2px;">Versi</td>
                            <td style="width: 70%; text-align: left; border: none; border-bottom: 1px solid #000; padding: 1px 2px;">1.0</td>
                        </tr>
                        
                        {{-- Baris 3: Hal --}}
                        <tr>
                            <td style="width: 30%; text-align: left; border: none; border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 1px 2px;">Hal</td>
                            <td style="width: 70%; text-align: left; border: none; border-bottom: 1px solid #000; padding: 1px 2px;">1 dari 1</td>
                        </tr>
                        
                        {{-- Baris 4: Label --}}
                        <tr>
                            <td style="width: 30%; text-align: left; border: none; border-right: 1px solid #000; padding: 1px 2px;">Label</td>
                            <td style="width: 70%; text-align: left; border: none; padding: 1px 2px;">Internal</td>
                        </tr>
                    </table>
                </td>

                {{-- Tengah: Judul Formulir --}}
                <td style="width: 45%; border: 1px solid #000; border-left: none; text-align: center; vertical-align: middle; padding: 2px;">
                    <span style="font-weight: bold; font-size: 10pt;">Formulir</span>
                    <br>
                    <span style="font-weight: bold; font-size: 8pt;">Jadwal Preventive Maintenance Sentral</span>
                </td>

                {{-- Kanan: Logo --}}
                {{-- Kunci: Menggunakan vertical-align: middle dan padding 2px. Tinggi total baris ini akan menyesuaikan tinggi kolom kiri. --}}
                <td style="width: 20%; border: 1px solid #000; border-left: none; text-align: center; vertical-align: middle; padding: 2px;">
                    @if ($logoBase64)
                        {{-- Tinggi logo disesuaikan lebih kecil --}}
                        <img src="{{ $logoBase64 }}" alt="Logo Perusahaan" style="max-width: 90%; max-height: 30px;">
                    @else
                        <div style="width: 35px; height: 35px; background-color: #ccc; margin: 0 auto; line-height: 35px; font-size: 6pt;">NO LOGO</div>
                    @endif
                </td>
            </tr>
        </table>
        
        {{-- Bulan (Diletakkan di bawah tabel header) --}}
        <div style="text-align: center; margin-top: 1px;">
            <span style="font-size: 8pt;">Bulan : {{ Carbon\Carbon::parse($schedule->bulan)->locale('id')->isoFormat('MMMM YYYY') }}</span>
        </div>
    </div>

{{-- ================================================================= --}}
{{-- INFORMASI BULAN --}}
{{-- ================================================================= --}}
<div style="margin-bottom: 3px; margin-top: 5px; font-size: 8pt; font-weight: bold;">
    Bulan : {{ $monthYear }}
</div>


{{-- ================================================================= --}}
{{-- TABEL JADWAL UTAMA --}}
{{-- ================================================================= --}}
<div class="table-container">
    <table class="main-schedule">
        <thead>
            <tr>
                <th rowspan="2" class="no-col-main">No</th>
                <th rowspan="2" class="lokasi-col-main">Lokasi</th>
                <th rowspan="2" class="r-c-col"></th> {{-- Header untuk Rencana/Realisasi --}}
                <th colspan="7">Minggu I</th>
                <th colspan="7">Minggu II</th>
                <th colspan="7">Minggu III</th>
                <th colspan="10">Minggu IV</th>
                <th rowspan="2" class="petugas-col">Petugas</th>
            </tr>
            <tr>
                {{-- Hitung Kolom Per Minggu --}}
                @php
                    $colsM1 = 7; $colsM2 = 7; $colsM3 = 7; 
                    $colsM4 = 31 - ($colsM1 + $colsM2 + $colsM3); 
                @endphp
                
                {{-- Hari 1-7 (M1) --}}
                @for ($i = 1; $i <= $colsM1; $i++) <th class="day-col">{{ $i }}</th> @endfor
                {{-- Hari 8-14 (M2) --}}
                @for ($i = 8; $i <= 14; $i++) <th class="day-col">{{ $i }}</th> @endfor
                {{-- Hari 15-21 (M3) --}}
                @for ($i = 15; $i <= 21; $i++) <th class="day-col">{{ $i }}</th> @endfor
                {{-- Hari 22-31 (M4) --}}
                @for ($i = 22; $i <= 31; $i++) 
                    <th class="day-col">{{ ($i <= $daysInMonth) ? $i : '' }}</th> 
                @endfor
            </tr>
        </thead>
        <tbody>
            @forelse ($schedule->locations as $index => $location)
                @php
                    $loc_no = $index + 1;
                    $rencanaDays = array_map('trim', explode(',', $location->rencana ?? ''));
                    $realisasiDays = array_map('trim', explode(',', $location->realisasi ?? ''));
                @endphp

                {{-- Baris Rencana --}}
                <tr>
                    <td rowspan="2" class="no-col-main">{{ $loc_no }}</td>
                    <td rowspan="2" class="lokasi-col-main">{{ $location->nama }}</td>
                    <td class="r-c-col" style="font-weight: normal; font-size: 6pt;">Rencana</td>
                    
                    {{-- Kolom Tanggal 1-31 (Rencana) --}}
                    @for ($i = 1; $i <= 31; $i++)
                        @if ($i <= $daysInMonth)
                            <td class="day-col">
                                @if (in_array((string)$i, $rencanaDays) && !empty($location->rencana))
                                    <span class="symbol">R</span>
                                @endif
                            </td>
                        @else
                            <td class="day-col disabled-day"></td> 
                        @endif
                    @endfor

                    <td rowspan="2" class="petugas-col">{{ $location->petugas ?? '-' }}</td>
                </tr>

                {{-- Baris Realisasi --}}
                <tr>
                    <td class="r-c-col" style="font-weight: normal; font-size: 6pt;">Realisasi</td>
                    
                    {{-- Kolom Tanggal 1-31 (Realisasi) --}}
                    @for ($i = 1; $i <= 31; $i++)
                        @if ($i <= $daysInMonth)
                            <td class="day-col">
                                @if (in_array((string)$i, $realisasiDays) && !empty($location->realisasi))
                                    <span class="symbol">C</span>
                                @endif
                            </td>
                        @else
                            <td class="day-col disabled-day"></td>
                        @endif
                    @endfor
                </tr>
            @empty
                <tr>
                    <td colspan="34" style="text-align: center; height: 30px;">Tidak ada detail lokasi untuk jadwal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ================================================================= --}}
{{-- KETERANGAN DAN TANDA TANGAN --}}
{{-- ================================================================= --}}
<div style="margin-top: 15px;">
    <table class="signature-table">
        <tr>
            <td colspan="2" class="ket-header" style="width: 30%; border: none;">KETERANGAN</td>
            <td style="border: none; text-align: center; width: 35%;">Dibuat Oleh,</td>
            <td style="border: none; text-align: center; width: 35%;">Mengetahui,</td>
        </tr>
        <tr>
            <td style="width: 5%; height: 15px; text-align: center;">R</td>
            <td style="width: 25%; text-align: left; padding-left: 5px;">Rencana (Plan)</td>
            <td style="height: 50px; vertical-align: bottom; text-align: center;">
                ({{ $schedule->dibuat_oleh ?? '-' }})
                <br>NIK :
            </td>
            <td style="height: 50px; vertical-align: bottom; text-align: center;">
                ({{ $schedule->mengetahui ?? '-' }})
                <br>NIK :
            </td>
        </tr>
        <tr>
            <td style="height: 15px; text-align: center;">C</td>
            <td style="text-align: left; padding-left: 5px;">Check (Realisasi)</td>
            <td colspan="2" style="border: none; height: 20px;"></td>
        </tr>
    </table>
</div>

</body>
</html>
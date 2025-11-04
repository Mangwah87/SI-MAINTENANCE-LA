@php
    // Langkah 1: PHP Script untuk mengambil logo dan mengubahnya ke Base64
    $logoPath = public_path('assets/images/Lintasarta_Logo_Logogram.png'); 
    $logoBase64 = null;
    
    if (file_exists($logoPath)) {
        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION); 
        $logoData = file_get_contents($logoPath); 
        $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
    }
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jadwal PM Sentral - {{ Carbon\Carbon::parse($schedule->bulan)->locale('id')->isoFormat('MMMM YYYY') }}</title>
    <style>
        @page {
            size: letter landscape;
            margin: 2cm 2.25cm 3.5cm 2.25cm; 
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 6.5pt; 
            margin: 0;
            padding: 0;
        }
        
        /* === TATA LETAK TABEL UTAMA === */
        .table-container {
            width: 100%;
            margin-top: 8px;
            overflow: visible;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 0.5pt solid #000;
            padding: 2px 1px; 
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 6.5pt;
        }
        
        /* Style untuk simbol X */
        .symbol {
            font-size: 8pt; 
            font-weight: bold;
            line-height: 1;
        }
        
        /* === HEADER DOKUMEN === */
        .doc-header {
            margin-bottom: 4px;
        }
        .doc-header table {
            width: 100%;
            border-collapse: collapse;
        }
        .doc-header td {
            border: none; 
            padding: 2px 0;
            text-align: left;
        }

        /* Styling khusus untuk baris data */
        .data-row td {
            height: 14px;
            font-size: 6.5pt;
        }
        
        /* Styling untuk kolom lokasi agar text align left */
        .lokasi-col {
            text-align: left !important;
            padding-left: 3px !important;
            font-size: 6.5pt;
        }
        
        /* Styling untuk kolom petugas */
        .petugas-col {
            font-size: 6.5pt;
        }
        
        /* --- STYLING KHUSUS UNTUK KOLOM KETERANGAN --- */
        .keterangan-col-text {
            font-size: 6.5pt; 
            font-weight: bold;
        }

        /* === FOOTER BARU (SESUAI PERMINTAAN) === */
        .footer-section {
            position: fixed;
            bottom: 0.5cm;
            left: 0;
            right: 0;
            width: 100%;
        }
        
        /* Tabel Tanda Tangan */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        
        .signature-table td {
            border: none;
            text-align: center;
            padding: 0;
            font-size: 7pt;
        }
        
        /* Garis Horizontal Tebal */
        .footer-divider {
            border: none;
            border-top: 1.5pt solid #000;
            margin: 8px 0 4px 0;
        }
        
        /* Info Perusahaan & Dokumen */
        .footer-info {
            font-size: 6pt;
            text-align: left;
            line-height: 1.4;
        }
        
        .footer-info strong {
            font-weight: bold;
        }

    </style>
</head>
<body>
    
    {{-- ================================================================= --}}
    {{-- HEADER DOKUMEN --}}
    {{-- ================================================================= --}}
    <div class="doc-header" style="margin-bottom: 4px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 7pt; table-layout: fixed;">
            <tr>
                {{-- Kiri: Detail Dokumen --}}
                <td style="width: 32%; border: 0.5pt solid #000; padding: 0; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 6.5pt; table-layout: fixed;">
                        <tr>
                            <td style="width: 28%; text-align: left; border: none; border-bottom: 0.5pt solid #000; padding: 2px 4px;">No. Dok.</td>
                            <td style="width: 5%; text-align: center; border: none; border-bottom: 0.5pt solid #000; padding: 2px 1px;">:</td>
                            <td style="width: 67%; text-align: left; border: none; border-bottom: 0.5pt solid #000; padding: 2px 4px;">FM-LAP- D2-SOP-003-007</td>
                        </tr>
                        <tr>
                            <td style="width: 28%; text-align: left; border: none; border-bottom: 0.5pt solid #000; padding: 2px 4px;">Versi</td>
                            <td style="width: 5%; text-align: center; border: none; border-bottom: 0.5pt solid #000; padding: 2px 1px;">:</td>
                            <td style="width: 67%; text-align: left; border: none; border-bottom: 0.5pt solid #000; padding: 2px 4px;">1.0</td>
                        </tr>
                        <tr>
                            <td style="width: 28%; text-align: left; border: none; border-bottom: 0.5pt solid #000; padding: 2px 4px;">Hal</td>
                            <td style="width: 5%; text-align: center; border: none; border-bottom: 0.5pt solid #000; padding: 2px 1px;">:</td>
                            <td style="width: 67%; text-align: left; border: none; border-bottom: 0.5pt solid #000; padding: 2px 4px;">1 dari 1</td>
                        </tr>
                        <tr>
                            <td style="width: 28%; text-align: left; border: none; padding: 2px 4px;">Label</td>
                            <td style="width: 5%; text-align: center; border: none; padding: 2px 1px;">:</td>
                            <td style="width: 67%; text-align: left; border: none; padding: 2px 4px;">Internal</td>
                        </tr>
                    </table>
                </td>

                {{-- Tengah: Judul Formulir --}}
                <td style="width: 50%; border: 0.5pt solid #000; border-left: none; text-align: center; vertical-align: middle; padding: 4px;">
                    <span style="font-weight: bold; font-size: 11pt;">Formulir</span>
                    <br>
                    <span style="font-weight: bold; font-size: 9pt;">Jadwal Preventive Maintenance Sentral</span>
                </td>

                {{-- Kanan: Logo --}}
                <td style="width: 18%; border: 0.5pt solid #000; border-left: none; text-align: center; vertical-align: middle; padding: 4px;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo Perusahaan" style="max-width: 85%; max-height: 45px;">
                    @else
                        <div style="width: 45px; height: 45px; background-color: #ccc; margin: 0 auto; line-height: 45px; font-size: 7pt;">NO LOGO</div>
                    @endif
                </td>
            </tr>
        </table>
        
        {{-- Bulan --}}
        <div style="text-align: center; margin-top: 3px;">
            <span style="font-size: 8pt; font-weight: bold;">Bulan : {{ Carbon\Carbon::parse($schedule->bulan)->locale('id')->isoFormat('MMMM YYYY') }}</span>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- DETAIL JADWAL HARIAN --}}
    {{-- ================================================================= --}}
    <div class="table-container">
        <table>
            <thead>
                @php
                    $monthDays = \Carbon\Carbon::parse($schedule->bulan)->daysInMonth;
                    $colNoWidth = '2%';
                    $colLokasiWidth = '11%';
                    $colKetWidth = '7%';
                    $colPetugasWidth = '8%';
                @endphp
                
                <tr>
                    <th rowspan="2" style="width: {{ $colNoWidth }};">No.</th>
                    <th rowspan="2" style="width: {{ $colLokasiWidth }};">Lokasi</th>
                    <th rowspan="2" style="width: {{ $colKetWidth }};">Keterangan</th>
                    
                    @for ($week = 1; $week <= 5; $week++)
                        @php
                            $startDay = ($week - 1) * 7 + 1;
                            $endDay = min($week * 7, $monthDays);
                            $colspan = $endDay - $startDay + 1;
                        @endphp
                        
                        @if ($colspan > 0)
                            <th colspan="{{ $colspan }}" style="font-size: 6.5pt; padding: 1px;">Minggu {{ $week }}</th>
                        @endif
                    @endfor
                    
                    <th rowspan="2" style="width: {{ $colPetugasWidth }};">Petugas</th>
                </tr>
                
                <tr>
                    @for ($day = 1; $day <= $monthDays; $day++)
                        <th style="font-size: 6pt; padding: 1px;">{{ $day }}</th> 
                    @endfor
                </tr>
            </thead>
            
            <tbody>
                @forelse ($schedule->locations as $index => $location)
                    @php
                        $rencanaDays = is_string($location->rencana) ? json_decode($location->rencana, true) : ($location->rencana ?? []);
                        $realisasiDays = is_string($location->realisasi) ? json_decode($location->realisasi, true) : ($location->realisasi ?? []);
                        $rencanaDays = is_array($rencanaDays) ? $rencanaDays : [];
                        $realisasiDays = is_array($realisasiDays) ? $realisasiDays : [];
                    @endphp

                    {{-- Baris Rencana --}}
                    <tr class="data-row">
                        <td rowspan="2" style="width: {{ $colNoWidth }};">{{ $index + 1 }}</td>
                        <td rowspan="2" class="lokasi-col" style="width: {{ $colLokasiWidth }};">{{ $location->nama }}</td>
                        
                        <td style="width: {{ $colKetWidth }}; background-color: #a7a7a7ff; color: #000000ff; padding: 0 1px;">
                            <span class="keterangan-col-text">Rencana</span>
                        </td>
                        
                        @for ($day = 1; $day <= $monthDays; $day++)
                            <td style="background-color: #a7a7a7ff; padding: 0;">
                                @if (in_array($day, $rencanaDays))
                                    <span class="symbol" style="color: #000000ff;">X</span> 
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        @endfor
                        
                        <td rowspan="2" class="petugas-col" style="width: {{ $colPetugasWidth }};">{{ $location->petugas }}</td>
                    </tr>

                    {{-- Baris Realisasi --}}
                    <tr class="data-row">
                        <td style="width: {{ $colKetWidth }}; background-color: #ffffffff; color: #000000ff; padding: 0 1px;">
                            <span class="keterangan-col-text">Realisasi</span>
                        </td>
                        
                        @for ($day = 1; $day <= $monthDays; $day++)
                            <td style="background-color: #ffffffff; padding: 0;">
                                @if (in_array($day, $realisasiDays))
                                    <span class="symbol" style="color: #000000ff;">X</span> 
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 4 + $monthDays }}" style="text-align: center; padding: 10px;">
                            Tidak ada detail lokasi untuk jadwal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

   {{-- ================================================================= --}}
    {{-- FOOTER SECTION (FORMAT BARU SESUAI PERMINTAAN) --}}
    {{-- ================================================================= --}}
    <div class="footer-section">
        {{-- Tabel Tanda Tangan --}}
        <table class="signature-table">
            <tr>
                {{-- Kolom Kiri: Dibuat Oleh --}}
                <td style="width: 50%; padding-right: 10px;">
                    <div style="margin-bottom: 5px;">Dibuat Oleh,</div>
                    <div style="height: 35px;"></div>
                    <div style="height: 35px;"></div> 
                    {{-- AKHIR PENAMBAHAN --}}
                    <div style="border-top: 1pt solid #000; display: inline-block; width: 60%; padding-top: 2px;">
                        NIK : {{ $schedule->dibuat_oleh_nik ?? '-' }}
                    </div>
                </td>
                
                {{-- Kolom Kanan: Mengetahui/Diperiksa --}}
                <td style="width: 50%; padding-left: 10px;">
                    <div style="margin-bottom: 5px;">Mengetahui/Diperiksa,</div>
                    <div style="height: 35px;"></div>
                    <div style="height: 35px;"></div>
                    {{-- AKHIR PENAMBAHAN --}}
                    <div style="border-top: 1pt solid #000; display: inline-block; width: 60%; padding-top: 2px;">
                        NIK : {{ $schedule->mengetahui_nik ?? '-' }}
                    </div>
                </td>
            </tr>
        </table>

        <div style="height: 5px;"></div>

        {{-- Garis Horizontal Tebal --}}
        <hr class="footer-divider">

        {{-- Info Perusahaan & Dokumen --}}
        <div class="footer-info">
            <strong>&copy; Hak Cipta PT. APLIKANUSA LINTASARTA, Indonesia</strong><br>
            <strong>FM-LAP-D2-SOP-003-007 Formulir Jadwal Preventive Maintenance Sentral</strong>
        </div>
    </div>

</body>
</html>
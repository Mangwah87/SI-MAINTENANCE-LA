<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PM Petir & Grounding Report</title>
    <style>
        @page { size: A4; margin: 18mm; } /* Margin sedikit lebih kecil */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt; /* Ukuran font default */
            color: #000;
            margin: 0; padding: 0;
        }
        /* [BARU/UBAH] Style untuk sel judul utama di header */
        .pdf-title-cell {
            text-align: center;      /* Rata tengah */
            vertical-align: middle; /* Rata tengah vertikal */
            font-weight: bold;       /* Bold */
            font-size: 14pt;       /* Ukuran font 14pt */
            font-family: Arial, sans-serif; /* Font Arial */
            line-height: 1.2;        /* Spasi antar baris (opsional) */
        }
        .page-footer {
            /* ... style footer lainnya ... */
            font-size: 8pt; /* Pastikan footer 8pt */
            /* ... style footer lainnya ... */
        }
        /* Pastikan tidak ada background abu di header tabel utama */
        .main-table th { text-align: center; font-weight: bold; }
        /* ... sisa CSS Anda ... */
        .content-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
        .main-content { flex-grow: 1; }
        table { border-collapse: collapse; width: 100%; }
        .header-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; }
        .main-table th { text-align: center; font-weight: bold; }
        .info-table td { border: none; padding: 1px 2px; }
        .text-center {
            text-align: center;
            vertical-align: middle; /* Tambahkan atau pastikan ini ada */
        }
        /* Style Tabel Pelaksana (Mirip PDF Asli) */
        /* --- GANTI DENGAN BLOK INI --- */
        th.pelaksana-table, td.pelaksana-table {
            border: 1px solid #000; 
            padding: 8px 5px; /* <-- Menambah padding atas/bawah agar lebih tinggi */
            vertical-align: middle; 
            text-align: center; 
            font-weight: normal; 
            background-color: #fff;
        }
        td.pelaksana-table.name-col { text-align: left; }
        td.pelaksana-table.center { text-align: center; }

        /* Style Bagian Mengetahui (Mirip PDF Asli) */
        /* Style Bagian Mengetahui */
        /* Style Bagian Mengetahui */
        /* --- GANTI DENGAN BLOK INI --- */
        .mengetahui-name-line {
            font-size: 10pt;
            text-align: center;
            padding-bottom: 2px;
        }
        .mengetahui-nik-line {
            font-size: 9pt; /* NIK sedikit lebih kecil */
            text-align: center;
        }

        /* Style Notes (Mirip PDF Asli) */
        .notes-heading { font-weight: bold; margin-top: 10px; margin-bottom: 2px; }
        .notes-box { border: 1px solid #000; padding: 5px; min-height: 40px; }

        .page-break { page-break-after: always; clear: both; }
        .avoid-break { page-break-inside: avoid; }
        .page-footer {
            padding-top: 3px;
            border-top: 1px solid #000;
            font-size: 8px;
            text-align: left;
            width: 100%; /* Lebar relatif thd area cetak */

            /* Atur posisi fixed di bawah */
            position: fixed;
            bottom: -10mm; /* Jarak dari batas bawah area cetak (sesuaikan jika @page margin berbeda) */
            left: 0mm;
            right: 0mm;
            height: 15mm; /* Tinggi area footer */
        }
        .text-bold {font-weight: bold;}
        .image-cell { width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top; }
        .image-cell img { width: 100%; max-height: 200px; object-fit: contain; }
        .image-label { font-size: 8pt; color: #333; margin-top: 2px; font-weight: bold; }
    </style>
</head>
<body>

    @php
        $images = $maintenance->images ?? []; $images = is_array($images) ? $images : [];
        $imagesPerPage = 9; $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
        $totalPages = 1 + $totalImagePages;
    @endphp

    <div class="content-wrapper">
        <div class="main-content">
            <div class="page-header avoid-break">
                <table class="header-table">
                    <tr>
                        <td width="15%" style="font-size: 8pt; vertical-align: top;">No. Dok.</td>
                        {{-- SESUAI PDF ASLI --}}
                        <td width="25%" style="font-size: 8pt; vertical-align: top;">: FM-LAP-D2-SOP-003-011</td>
                        <td width="35%" rowspan="4" class="pdf-title-cell">
                            {{-- Hapus style inline jika ada --}}
                            <div>Formulir</div>
                            <div>Preventive Maintenance</div>
                            <div>Petir dan Grounding</div>
                        </td>
                        <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                            <img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 70px;"> {{-- Ukuran logo disesuaikan --}}
                        </td>
                    </tr>
                    <tr><td style="font-size: 8pt; vertical-align: top;">Versi</td><td style="font-size: 8pt; vertical-align: top;">: 1.0</td></tr>
                    <tr><td style="font-size: 8pt; vertical-align: top;">Hal</td><td style="font-size: 8pt; vertical-align: top;">: 1 dari {{ $totalPages }}</td></tr>
                    <tr><td style="font-size: 8pt; vertical-align: top;">Label</td><td style="font-size: 8pt; vertical-align: top;">: Internal</td></tr>
                </table>
            </div>
            <div style="height: 8px;"></div>
            <table class="info-table avoid-break">
                <tr>
                    <td width="15%">Location</td>
                    <td width="85%">: {{ $maintenance->location }}</td> {{-- Make value column wider --}}
                </tr>
                <tr>
                    <td>Date / time</td>
                    <td>: {{ $maintenance->maintenance_date->format('d M Y / H:i') }}</td>
                </tr>
                <tr>
                    <td>Brand / Type</td>
                    <td>: {{ $maintenance->brand_type ?? '-' }}</td> {{-- Add null coalescing --}}
                </tr>
                 <tr>
                    <td>Reg. Number</td>
                    <td>: {{ $maintenance->reg_number ?? '-' }}</td> {{-- Add null coalescing --}}
                </tr>
                 <tr>
                    <td>S/N</td>
                    <td>: {{ $maintenance->sn ?? '-' }}</td> {{-- Add null coalescing --}}
                </tr>
            </table>
            <div style="height: 5px;"></div>

            {{-- SESUAI PDF ASLI --}}
            <table class="main-table">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="40%">Descriptions</th>
                        <th width="20%">Result</th>
                        <th width="25%">Operational Standard</th>
                        <th width="10%">Status (OK/NOK)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="text-center text-bold">1.</td><td colspan="4" class="text-bold">Visual Check</td></tr>
                    @php
                    $visualChecksPdf = [
                        ['field' => 'visual_air_terminal', 'label' => 'a. Air Terminal', 'std' => 'Available < 45 with Antenna'],
                        ['field' => 'visual_down_conductor', 'label' => 'b. Down Conductor', 'std' => 'Available (cable > 35 mmsq)'],
                        ['field' => 'visual_ground_rod', 'label' => 'c. Ground Rod', 'std' => 'Available, No Corrosion'],
                        ['field' => 'visual_bonding_bar', 'label' => 'd. Bonding Bar', 'std' => 'Available, No Corrosion'],
                        ['field' => 'visual_arrester_condition', 'label' => 'e. Arrester Condition', 'std' => 'Normal'],
                        ['field' => 'visual_maksure_equipment', 'label' => 'f. Maksure All Equipment to Ground Bar', 'std' => 'Yes'],
                        ['field' => 'visual_maksure_connection', 'label' => 'g. Maksure All Connection Tightened', 'std' => 'Yes'],
                        ['field' => 'visual_ob_light', 'label' => 'h. OB Light Installed if With Tower', 'std' => 'Yes & Normal Operation'],
                    ];
                    @endphp
                    @foreach($visualChecksPdf as $check)
                    @php $fieldName = $check['field']; @endphp
                    <tr>
                        <td></td>
                        <td>{{ $check['label'] }}</td>
                        <td class="text-center">{{ $maintenance->{$fieldName.'_result'} ?? '-' }}</td>
                        <td>{{ $check['std'] }}</td>
                        <td class="text-center">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</td>
                    </tr>
                    @endforeach

                    <tr><td class="text-center text-bold">2.</td><td colspan="4" class="text-bold">Performance Measurement</td></tr>
                     @php
                    $perfChecksPdf = [
                        ['field' => 'perf_ground_resistance', 'label' => 'a. Ground Resistance (R)', 'std' => 'R < 1 Ohm'],
                        ['field' => 'perf_arrester_cutoff_power', 'label' => 'b. Arrester Cutoff Voltage (Power)', 'std' => '280 VAC'],
                        ['field' => 'perf_arrester_cutoff_data', 'label' => 'c. Arrester Cutoff Voltage (Data)', 'std' => '76 VAC'],
                        ['field' => 'perf_tighten_nut', 'label' => 'd. Tighten of Nut', 'std' => 'Tightened'],
                    ];
                    @endphp
                    @foreach($perfChecksPdf as $check)
                     @php $fieldName = $check['field']; @endphp
                     <tr>
                        <td></td>
                        <td>{{ $check['label'] }}</td>
                        <td class="text-center">{{ $maintenance->{$fieldName.'_result'} ?? '-' }}</td>
                        <td>{{ $check['std'] }}</td>
                        <td class="text-center">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="font-size: 8pt; margin-top: 2px;">*) Choose the appropriate</div> {{-- SESUAI PDF ASLI --}}

            {{-- SESUAI PDF ASLI --}}
            <div class="notes-heading avoid-break">Notes / additional informations :</div>
            <div class="notes-box avoid-break">
                {!! nl2br(e($maintenance->notes ?? '')) !!}
            </div><br>

            {{-- SESUAI PDF ASLI --}}
            <table style="width: 100%; border-collapse: collapse;" class="avoid-break">
                <tbody>
                    <tr>
                        <td colspan="4" style="vertical-align: top; border: none; padding: 0 0 3px 0;">
                            <div class="text-bold" style="margin-bottom: 3px;">Pelaksana :</div>
                        </td>
                        <td style="width: 5%; border: none;">&nbsp;</td> 
                        <td style="width: 35%; vertical-align: top; text-align: center; border: none; padding: 0 0 3px 0;">
                             <span class="text-bold">Mengetahui,</span>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="pelaksana-table" style="width: 5%;">No</th>
                        <th class="pelaksana-table" style="width: 20%;">Name</th>
                        <th class="pelaksana-table" style="width: 20%;">Perusahaan</th>
                        <th class="pelaksana-table" style="width: 15%;">Tanda Tangan</th>
                        
                        <td rowspan="4" style="border: none; width: 5%;">&nbsp;</td> 

                        <td rowspan="4" style="border: 1px solid #000; text-align: center; vertical-align: bottom; width: 35%;">
                            {{-- Wrapper ini akan menempel di bagian bawah sel --}}
                            <div style="padding-bottom: 5px;">
                                <div class="mengetahui-name-line">( {{ $maintenance->approver_name ?? '..................' }} )</div>
                                <div class="mengetahui-nik-line">(NIK: {{ $maintenance->approver_nik ?? '..................' }})</div>
                            </div>
                        </td>
                    </tr>
                    
                    @for ($i = 1; $i <= 3; $i++)
                    <tr>
                        <td class="pelaksana-table center">{{ $i }}.</td>
                        <td class="pelaksana-table name-col">{{ $maintenance->{'technician_'.$i.'_name'} ?? '' }}</td>
                        <td class="pelaksana-table">{{ $maintenance->{'technician_'.$i.'_company'} ?? '' }}</td>
                        {{-- Atur tinggi sel tanda tangan di sini jika perlu --}}
                        <td class="pelaksana-table" style="height: 35px;"></td> 
                    </tr>
                    @endfor
                </tbody>
            </table>

            {{-- =============================================== --}}
            {{-- == AWAL BLOK YANG DIHAPUS (PENYEBAB ERROR) == --}}
            {{-- =============================================== --}}
                
                 {{-- 
                    <td style="width: 35%; vertical-align: bottom; border: none;">
                         <div class="mengetahui-section"> 
                             <span class="text-bold"><strong>Mengetahui,</strong></span>
                             <div class="mengetahui-sign-box">
                                 <div class="mengetahui-name">( {{ $maintenance->approver_name ?? '..................' }} )</div>
                                 <div class="mengetahui-nik">(NIK: {{ $maintenance->approver_nik ?? '..................' }})</div>
                             </div>
                         </div>
                    </td>
                </tr>
            </table> 
                 --}}
            {{-- =============================================== --}}
            {{-- == AKHIR BLOK YANG DIHAPUS (PENYEBAB ERROR) == --}}
            {{-- =============================================== --}}

        </div>
    <div class="page-footer">
         ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
         <span style="font-weight: bold;">FM-LAP-D2-SOP-003-011 Formulir Preventive Maintenance Petir dan Grounding</span>
    </div>
    </div> @if(!empty($images) && count($images) > 0)
        @php $imageChunks = array_chunk($images, $imagesPerPage); $currentPage = 2; @endphp
        @foreach($imageChunks as $chunkIndex => $imageChunk)
            <div class="page-break"></div>
            <div class="content-wrapper"> <div class="main-content">
                <div class="page-header avoid-break">
                    <table class="header-table">
                         <tr>
                            <td width="15%" style="font-size: 8pt; vertical-align: top;">No. Dok.</td><td width="25%" style="font-size: 8pt; vertical-align: top;">: FM-LAP-D2-SOP-003-011</td>
                            <td width="35%" rowspan="4" class="text-center" style="vertical-align: middle;"><div style="font-size: 14pt; font-weight: bold;">Formulir</div><div style="font-size: 14pt; font-weight: bold;">Preventive Maintenance</div><div style="font-size: 14pt; font-weight: bold;">Petir dan Grounding</div></td>
                            <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;"><img src="{{ public_path('assets/images/logo2.jpg') }}" style="width: 70px;"></td>
                        </tr>
                        <tr><td style="font-size: 8pt; vertical-align: top;">Versi</td><td style="font-size: 8pt; vertical-align: top;">: 1.0</td></tr>
                        <tr><td style="font-size: 8pt; vertical-align: top;">Hal</td><td style="font-size: 8pt; vertical-align: top;">: {{ $currentPage }} dari {{ $totalPages }}</td></tr>
                        <tr><td style="font-size: 8pt; vertical-align: top;">Label</td><td style="font-size: 8pt; vertical-align: top;">: Internal</td></tr>
                    </table>
                </div>
                <div style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="text-bold" style="margin-bottom: 5px;">Documentation Images @if($totalImagePages > 1)(Page {{ $chunkIndex + 1 }} of {{ $totalImagePages }})@endif:</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach(array_chunk($imageChunk, 3) as $rowImages) <tr style="page-break-inside: avoid;">
                            @foreach($rowImages as $image)
                                @if(is_array($image) && isset($image['path']) && !empty($image['path']))
                                    <td class="image-cell">
                                        @php $fullPath = storage_path('app/public/' . $image['path']); $fileExists = file_exists($fullPath); @endphp
                                        @if($fileExists) <img src="{{ $fullPath }}" alt="{{ $image['category'] ?? 'Image' }}">
                                        @else <div style="height: 180px; background: #f0f0f0; display: table-cell; vertical-align: middle; color: #999; font-size: 8pt; padding: 5px;">Image Not Found!<br><span style="font-size: 7pt; word-break: break-all;">Path: {{ $image['path'] }}</span></div> @endif
                                        <div class="image-label">{{ ucwords(str_replace(['visual_', 'perf_', '_result', '_'], ['', '', '', ' '], $image['category'] ?? 'Image')) }}</div>
                                    </td>
                                @else <td class="image-cell" style="background: #f8f8f8;"><div style="height: 200px; display: table-cell; vertical-align: middle; color: #ccc; font-size: 8pt;">Invalid Data</div></td> @endif
                            @endforeach
                            @for($i = count($rowImages); $i < 3; $i++) <td style="width: 33.33%; border: none;"></td> @endfor
                        </tr> @endforeach
                    </table>
                </div>
            </div> <div class="page-footer">
                 ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                 <span style="font-weight: bold;">FM-LAP-D2-SOP-003-011 Formulir Preventive Maintenance Petir dan Grounding</span>
            </div> </div>
            @php $currentPage++; @endphp
        @endforeach
    @endif

</body>
</html>
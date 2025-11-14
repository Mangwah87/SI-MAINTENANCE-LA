<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PM Kabel & Panel Report - {{ $maintenance->doc_number }}</title>
    
    <style>
        @page { size: letter; margin: 18mm; }
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #000; margin: 0; padding: 0; }
        table { border-collapse: collapse; width: 100%; }
        .header-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; }

        .main-table th, .main-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; }
        .main-table th { text-align: center; font-weight: bold; }
        
        .info-table td { border: none; padding: 1px 2px; }
        
        /* ==================================== */
        /* == AWAL BLOK CSS DIPERBARUI == */
        /* ==================================== */

        /* [HAPUS] CSS Lama .pelaksana-table */
        
        /* [BARU] Style Pelaksana (Model Gabungan Baru) */
        th.pelaksana-table, td.pelaksana-table {
            border: 1px solid #000; 
            padding: 8px 5px; /* Memberi tinggi agar kotak TTD besar */
            vertical-align: middle; 
            text-align: center; 
            font-weight: normal; 
            background-color: #fff;
        }
        td.pelaksana-table.name-col { text-align: left; }
        td.pelaksana-table.center { text-align: center; }


        /* [HAPUS] CSS Lama .mengetahui-section, .mengetahui-box, .mengetahui-name */
        
        /* [BARU] Style Mengetahui (Model Gabungan Baru) */
        .mengetahui-name-line {
            font-size: 10pt;
            text-align: center;
            padding-bottom: 2px;
        }
        .mengetahui-nik-line {
            font-size: 9pt; /* NIK sedikit lebih kecil */
            text-align: center;
        }

        /* ==================================== */
        /* == AKHIR BLOK CSS DIPERBARUI == */
        /* ==================================== */

        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .notes-heading { font-weight: bold; margin-top: 10px; margin-bottom: 2px; }
        .notes-box { border: 1px solid #000; padding: 5px; min-height: 40px; }
        
        .page-break { page-break-after: always; clear: both; }
        .page-break-before { page-break-before: always; clear: both; }
        .avoid-break { page-break-inside: avoid; }
        
        .page-footer {
            padding-top: 3px;
            border-top: 1px solid #000;
            font-size: 8px;
            text-align: left;
            width: 100%;
            position: fixed;
            bottom: -10mm;
            left: 0mm; 
            right: 0mm;
            height: 15mm;
        }
        
        .image-cell { width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top; }
        .image-cell img { width: 100%; max-height: 180px; object-fit: contain; }
        .image-label { font-size: 10pt; color: #333; margin-top: 2px; font-weight: bold; }
    </style>
</head>
<body>

    @php
        $images = $maintenance->images ?? []; $images = is_array($images) ? $images : [];
        $imagesPerPage = 9;
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;
        $notesPageExists = true; 
        if ($notesPageExists) {
            $totalPages = 1 + 1 + $totalImagePages;
        } else {
            $totalPages = 1;
        }
    @endphp

    {{-- HEADER HALAMAN 1 (Data) --}}
    <div class="page-header avoid-break">
        <table class="header-table">
            <tr>
                <td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td>
                <td width="23%" style="font-size: 10pt; vertical-align: top;">: {{ $maintenance->doc_number ?? 'FM-LAP-D2-SOP-003-012' }}</td>
                <td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <div style="font-size: 14pt; font-weight: bold;">Formulir</div>
                    <div style="font-size: 14pt; font-weight: bold;">Preventive Instalasi</div>
                    <div style="font-size: 14pt; font-weight: bold;">Kabel dan Panel</div>
                    <div style="font-size: 14pt; font-weight: bold;">Distribusi</div>
                </td>
                <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;">
                </td>
            </tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: 1 dari {{ $totalPages }}</td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
        </table>
    </div>
    
    <div style="height: 5px;"></div>
    
    <table class="info-table avoid-break">
        <tr>
            <td width="15%">Location</td>
            <td width="85%">: {{ $maintenance->location }}</td>
        </tr>
        <tr>
            <td>Date / time</td>
            <td>: {{ $maintenance->maintenance_date->format('d M Y / H:i') }}</td>
        </tr>
        <tr>
            <td>Brand / Type</td>
            <td>: {{ $maintenance->brand_type ?? '-' }}</td>
        </tr>
            <tr>
            <td>Reg. Number</td>
            <td>: {{ $maintenance->reg_number ?? '-' }}</td>
        </tr>
            <tr>
            <td>S/N</td>
            <td>: {{ $maintenance->sn ?? '-' }}</td>
        </tr>
    </table>

    {{-- Main Table (Konten Kabel Panel) --}}
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
            {{-- 1. Visual Check --}}
            <tr><td class="text-center text-bold">1.</td><td colspan="4" class="text-bold">Visual Check</td></tr>
            @php
            $visualChecksPdf = [
                ['field' => 'visual_indicator_lamp', 'label' => 'a. Indicator Lamp', 'std' => 'Normal'],
                ['field' => 'visual_voltmeter_ampere_meter', 'label' => 'b. Voltmeter & Ampere meter', 'std' => 'Normal'],
                ['field' => 'visual_arrester', 'label' => 'c. Arrester', 'std' => 'Normal'],
                ['field' => 'visual_mcb_input_ups', 'label' => 'd. MCB Input UPS', 'std' => 'Normal'],
                ['field' => 'visual_mcb_output_ups', 'label' => 'e. MCB Output UPS', 'std' => 'Normal'],
                ['field' => 'visual_mcb_bypass', 'label' => 'f. MCB Bypass', 'std' => 'Normal'],
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

            {{-- 2. Performance Measurement --}}
            <tr><td class="text-center text-bold">2.</td><td colspan="4" class="text-bold">Performance Measurement</td></tr>
            
            <tr><td></td><td class="text-bold" colspan="4">I. MCB Temperature</td></tr>
            @php
            $mcbTempChecks = [
                ['field' => 'perf_temp_mcb_input_ups', 'label' => 'a. Input UPS', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_output_ups', 'label' => 'b. Output UPS', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_bypass_ups', 'label' => 'c. Bypass UPS', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_load_rack', 'label' => 'd. Load Rack', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'std' => 'Maks 35°C'],
            ];
            @endphp
            @foreach($mcbTempChecks as $check)
             @php $fieldName = $check['field']; @endphp
             <tr>
                <td></td>
                <td>{{ $check['label'] }}</td>
                <td class="text-center">{{ $maintenance->{$fieldName.'_result'} ? $maintenance->{$fieldName.'_result'} . ' °C' : '-' }}</td>
                <td>{{ $check['std'] }}</td>
                <td class="text-center">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</td>
            </tr>
            @endforeach

            <tr><td></td><td class="text-bold" colspan="4">II. Cable Temperature</td></tr>
             @php
            $cableTempChecks = [
                ['field' => 'perf_temp_cable_input_ups', 'label' => 'a. Input UPS', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_output_ups', 'label' => 'b. Output UPS', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_bypass_ups', 'label' => 'c. Bypass UPS', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_load_rack', 'label' => 'd. Load Rack', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'std' => 'Maks 65°C'],
            ];
            @endphp
            @foreach($cableTempChecks as $check)
             @php $fieldName = $check['field']; @endphp
             <tr>
                <td></td>
                <td>{{ $check['label'] }}</td>
                <td class="text-center">{{ $maintenance->{$fieldName.'_result'} ? $maintenance->{$fieldName.'_result'} . ' °C' : '-' }}</td>
                <td>{{ $check['std'] }}</td>
                <td class="text-center">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</td>
            </tr>
            @endforeach

            {{-- 3. Performance Check --}}
            <tr><td class="text-center text-bold">3.</td><td colspan="4" class="text-bold">Performance Check</td></tr>
             @php
            $perfChecksPdf = [
                ['field' => 'perf_check_cable_connection', 'label' => 'a. Maksure All Cable Connection', 'std' => 'Tightened'],
                ['field' => 'perf_check_spare_mcb', 'label' => 'b. Spare of MCB Load Rack', 'std' => 'Available'],
                ['field' => 'perf_check_single_line_diagram', 'label' => 'c. Single Line Diagram', 'std' => 'Available'],
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
    <div style="font-size: 8pt; margin-top: 2px;">*) Choose the appropriate</div>

    {{-- FOOTER HALAMAN 1 (Akan muncul di semua halaman) --}}
    <div class="page-footer">
         ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
         <span style="font-weight: bold;">FM-LAP-D2-SOP-003-012 Formulir Preventive Maintenance Instalasi Kabel dan Panel Distribusi</span>
    </div>

    {{-- HALAMAN 2 (Notes & TTD) --}}
    <div class="page-break-before"></div>

    {{-- Header Halaman 2 (Manual) --}}
    <div class="page-header avoid-break">
        <table class="header-table">
             <tr>
                <td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td>
                <td width="23%" style="font-size: 10pt; vertical-align: top;">: {{ $maintenance->doc_number ?? 'FM-LAP-D2-SOP-003-012' }}</td>
                <td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <div style="font-size: 14pt; font-weight: bold;">Formulir</div>
                    <div style="font-size: 14pt; font-weight: bold;">Preventive Instalasi</div>
                    <div style="font-size: 14pt; font-weight: bold;">Kabel dan Panel</div>
                    <div style="font-size: 14pt; font-weight: bold;">Distribusi</div>
                </td>
                <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;">
                </td>
            </tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: 2 dari {{ $totalPages }}</td></tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
        </table>
    </div>
    
    <div style="height: 10px;"></div>

    {{-- Notes (dari Genset) --}}
    <div class="notes-heading avoid-break">Notes / additional informations :</div>
    <div class="notes-box avoid-break">
        {!! nl2br(e($maintenance->notes ?? '')) !!}
    </div>

    {{-- ==================================== */ --}}
    {{-- == AWAL BLOK TTD DIPERBARUI == */ --}}
    {{-- ==================================== */ --}}
    
    {{-- [PERBAIKAN] Tabel Tanda Tangan Terpadu (Gaya Genset/Grounding) --}}
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" class="avoid-break">
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
                        {{-- [BARU] Menambahkan NIK --}}
                        <div class="mengetahui-nik-line">(NIK: {{ $maintenance->approver_nik ?? '..................' }})</div>
                    </div>
                </td>
            </tr>
            
            @for ($i = 1; $i <= 3; $i++)
            <tr>
                <td class="pelaksana-table center">{{ $i }}.</td>
                <td class="pelaksana-table name-col">{{ $maintenance->{'technician_'.$i.'_name'} ?? '' }}</td>
                <td class="pelaksana-table">{{ $maintenance->{'technician_'.$i.'_company'} ?? '' }}</td>
                <td class="pelaksana-table" style="height: 35px;"></td> {{-- Sel TTD Kosong --}}
            </tr>
            @endfor
        </tbody>
    </table>
    
    {{-- ==================================== */ --}}
    {{-- == AKHIR BLOK TTD DIPERBARUI == */ --}}
    {{-- ==================================== */ --}}


    {{-- HALAMAN GAMBAR (Logika dari Genset) --}}
    @if(!empty($images) && count($images) > 0)
        @php
            $imageChunks = array_chunk($images, $imagesPerPage);
            $startImagePage = 3;
        @endphp
        
        @foreach($imageChunks as $chunkIndex => $imageChunk)
            <div class="page-break"></div>
            
            @php $currentPageForHeader = $startImagePage + $chunkIndex; @endphp

            {{-- Header Halaman Gambar (Manual) --}}
            <div class="page-header avoid-break">
                <table class="header-table">
                   <tr>
                        <td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td>
                        <td width="23%" style="font-size: 10pt; vertical-align: top;">: {{ $maintenance->doc_number ?? 'FM-LAP-D2-SOP-003-012' }}</td>
                        <td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;">
                            <div style="font-size: 14pt; font-weight: bold;">Formulir</div>
                            <div style="font-size: 14pt; font-weight: bold;">Preventive Instalasi</div>
                            <div style="font-size: 14pt; font-weight: bold;">Kabel dan Panel</div>
                            <div style="font-size: 14pt; font-weight: bold;">Distribusi</div>
                        </td>
                        <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                            <img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;">
                        </td>
                    </tr>
                    <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr>
                    <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: {{ $currentPageForHeader }} dari {{ $totalPages }}</td></tr>
                    <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
                </table>
            </div>
            
            {{-- Konten Gambar --}}
            <div style="margin-top: 10px; margin-bottom: 10px;">
                <div class="text-bold" style="margin-bottom: 5px;">Documentation Images @if($totalImagePages > 1)(Page {{ $chunkIndex + 1 }} of {{ $totalImagePages }})@endif:</div>
                <table style="width: 100%; border-collapse: collapse;">
                    @foreach(array_chunk($imageChunk, 3) as $rowImages) <tr style="page-break-inside: avoid;">
                        @foreach($rowImages as $image)
                            @if(is_array($image) && isset($image['path']) && !empty($image['path']))
                                <td class="image-cell">
                                    @php $imagePath = $image['path']; $fullPath = public_path('storage/' . $imagePath); $fileExists = is_file($fullPath); @endphp
                                    @if($fileExists)
                                        <img src="{{ $fullPath }}" alt="{{ $image['category'] ?? 'Image' }}">
                                    @else
                                        <div style="height: 180px; background: #f0f0f0; display: table-cell; vertical-align: middle; color: #999; padding: 5px;"><p style="font-size: 7pt; color: red; word-break: break-all;">Image Not Found!</p></div>
                                    @endif
                                    <div class="image-label">{{ ucwords(str_replace(['visual_', 'perf_temp_mcb_', 'perf_temp_cable_', 'perf_check_', '_'], ['', 'Temp MCB ', 'Temp Kabel ', 'Check ', ' '], $image['category'] ?? 'Image')) }}</div>
                                </td>
                            @else
                                <td class="image-cell" style="background: #f8f8ff;"><div style="height: 200px; display: table-cell; vertical-align: middle; color: #ccc;">Invalid Data</div></td>
                            @endif
                        @endforeach
                        @for($i = count($rowImages); $i < 3; $i++) <td style="width: 33.33%; border: none;"></td> @endfor
                    </tr> @endforeach
                </table>
            </div>
            
        @endforeach
    @endif

</body>
</html>
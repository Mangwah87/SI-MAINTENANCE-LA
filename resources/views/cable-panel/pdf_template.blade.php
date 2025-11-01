<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    {{-- Menggunakan judul dari PDF Kabel Panel --}}
    <title>PM Kabel & Panel Report - {{ $maintenance->doc_number }}</title>
    
    {{-- 
      --- [STYLE CSS (Disalin dari Genset)] ---
    --}}
    <style>
        @page { size: letter; margin: 18mm; } /* */
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #000; margin: 0; padding: 0; } /* */
        table { border-collapse: collapse; width: 100%; }
        /* Menggunakan style header dari Genset */
        .header-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; } /* */

        .main-table th, .main-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: top; } /* */
        .main-table th { text-align: center; font-weight: bold; } /* */
        
        .info-table td { border: none; padding: 1px 2px; } /* */
        
        /* Style Pelaksana (dari PDF Kabel Panel Ref) */
        .pelaksana-table { margin-bottom: 5px; } /* */
        .pelaksana-table th, .pelaksana-table td { 
            border: 1px solid #000; padding: 3px 5px; vertical-align: middle; text-align: center; font-weight: normal; 
        } /* */
        .pelaksana-table th { text-align: center; } /* */
        .pelaksana-table .name-col { text-align: left; } /* */
        .pelaksana-table .sign-col { height: 35px; } 

        /* Style Mengetahui (dari Genset) */
        .mengetahui-section { width: 35%; float: right; text-align: center; margin-top: 15px; } /* */
        .mengetahui-box { border: 1px solid #000; height: 118px; margin-top: 5px; margin-bottom: 2px; position: relative; padding-bottom: 15px; } /* */
        .mengetahui-name {
            font-size: 8pt;
            position: absolute;
            bottom: 3px;
            left: 0;
            right: 0;
            text-align: center;
            width: 80%;
            margin: 0 auto;
            padding-top: 1px;
        } /* */

        .text-center { text-align: center; } /* */
        .text-bold { font-weight: bold; } /* */
        .notes-heading { font-weight: bold; margin-top: 10px; margin-bottom: 2px; } /* */
        .notes-box { border: 1px solid #000; padding: 5px; min-height: 40px; } /* */
        
        /* Utilities Halaman (dari Genset) */
        .page-break { page-break-after: always; clear: both; } /* */
        .page-break-before { page-break-before: always; clear: both; } /* */
        .avoid-break { page-break-inside: avoid; } /* */
        
        /* --- [FOOTER DINAMIS (dari Genset)] ---
          Ini adalah kunci agar footer ada di setiap halaman
        */
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
        } /* */
        
        /* Style Gambar (dari Genset) */
        .image-cell { width: 33.33%; padding: 3px; text-align: center; border: 1px solid #ddd; vertical-align: top; } /* */
        .image-cell img { width: 100%; max-height: 180px; object-fit: contain; } /* */
        .image-label { font-size: 10pt; color: #333; margin-top: 2px; font-weight: bold; } /* */
    </style>
</head>
<body>

    @php
        // --- [LOGIKA PHP (Disalin dari Genset)] ---
        $images = $maintenance->images ?? []; $images = is_array($images) ? $images : [];
        $imagesPerPage = 9; // Menggunakan 9 gambar/halaman seperti Genset
        $totalImagePages = !empty($images) ? ceil(count($images) / $imagesPerPage) : 0;

        // Logika Total Halaman dari Genset
        // Cek apakah halaman kedua (Notes/Pelaksana) akan dibuat
        // Untuk Kabel Panel, kita anggap Notes/Pelaksana ada di halaman 2
        $notesPageExists = true; 

        if ($notesPageExists) {
            // total = 1 (Data) + 1 (Notes/TTD) + Jumlah Halaman Gambar
            $totalPages = 1 + 1 + $totalImagePages; //
        } else {
            $totalPages = 1; // Seharusnya tidak terjadi
        }
    @endphp

    {{-- 
      --- [HEADER HALAMAN 1 (Data)] ---
      Struktur dari Genset, Konten dari Kabel Panel
    --}}
    <div class="page-header avoid-break">
        <table class="header-table">
            <tr>
                <td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td>
                <td width="23%" style="font-size: 10pt; vertical-align: top;">: {{ $maintenance->doc_number ?? 'FM-LAP-D2-SOP-003-012' }}</td> {{-- --}}
                {{-- Judul dari PDF Kabel Panel --}}
                <td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <div style="font-size: 14pt; font-weight: bold;">Formulir</div> {{-- --}}
                    <div style="font-size: 14pt; font-weight: bold;">Preventive Instalasi</div> {{-- --}}
                    <div style="font-size: 14pt; font-weight: bold;">Kabel dan Panel</div> {{-- --}}
                    <div style="font-size: 14pt; font-weight: bold;">Distribusi</div> {{-- --}}
                </td>
                <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;"> {{-- --}}
                </td>
            </tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr> {{-- --}}
            <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: 1 dari {{ $totalPages }}</td></tr> {{-- --}}
            <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr> {{-- --}}
        </table>
    </div>
    
    <div style="height: 5px;"></div>
    
    {{-- Info Table (Konten Kabel Panel) --}}
    <table class="info-table avoid-break"> {{-- --}}
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
            <tr><td class="text-center text-bold">1.</td><td colspan="4" class="text-bold">Visual Check</td></tr> {{-- --}}
            @php
            $visualChecksPdf = [
                ['field' => 'visual_indicator_lamp', 'label' => 'a. Indicator Lamp', 'std' => 'Normal'],
                ['field' => 'visual_voltmeter_ampere_meter', 'label' => 'b. Voltmeter & Ampere meter', 'std' => 'Normal'],
                ['field' => 'visual_arrester', 'label' => 'c. Arrester', 'std' => 'Normal'],
                ['field' => 'visual_mcb_input_ups', 'label' => 'd. MCB Input UPS', 'std' => 'Normal'],
                ['field' => 'visual_mcb_output_ups', 'label' => 'e. MCB Output UPS', 'std' => 'Normal'],
                ['field' => 'visual_mcb_bypass', 'label' => 'f. MCB Bypass', 'std' => 'Normal'],
            ]; //
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
            <tr><td class="text-center text-bold">2.</td><td colspan="4" class="text-bold">Performance Measurement</td></tr> {{-- --}}
            
            {{-- Sub-bagian I. MCB Temperature --}}
            <tr><td></td><td class="text-bold" colspan="4">I. MCB Temperature</td></tr> {{-- --}}
            @php
            $mcbTempChecks = [
                ['field' => 'perf_temp_mcb_input_ups', 'label' => 'a. Input UPS', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_output_ups', 'label' => 'b. Output UPS', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_bypass_ups', 'label' => 'c. Bypass UPS', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_load_rack', 'label' => 'd. Load Rack', 'std' => 'Maks 35°C'],
                ['field' => 'perf_temp_mcb_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'std' => 'Maks 35°C'],
            ]; //
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

            {{-- Sub-bagian II. Cable Temperature --}}
            <tr><td></td><td class="text-bold" colspan="4">II. Cable Temperature</td></tr> {{-- --}}
             @php
            $cableTempChecks = [
                ['field' => 'perf_temp_cable_input_ups', 'label' => 'a. Input UPS', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_output_ups', 'label' => 'b. Output UPS', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_bypass_ups', 'label' => 'c. Bypass UPS', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_load_rack', 'label' => 'd. Load Rack', 'std' => 'Maks 65°C'],
                ['field' => 'perf_temp_cable_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'std' => 'Maks 65°C'],
            ]; //
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
            <tr><td class="text-center text-bold">3.</td><td colspan="4" class="text-bold">Performance Check</td></tr> {{-- --}}
             @php
            $perfChecksPdf = [
                ['field' => 'perf_check_cable_connection', 'label' => 'a. Maksure All Cable Connection', 'std' => 'Tightened'],
                ['field' => 'perf_check_spare_mcb', 'label' => 'b. Spare of MCB Load Rack', 'std' => 'Available'],
                ['field' => 'perf_check_single_line_diagram', 'label' => 'c. Single Line Diagram', 'std' => 'Available'],
            ]; //
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
    <div style="font-size: 8pt; margin-top: 2px;">*) Choose the appropriate</div> {{-- --}}

    {{-- 
      --- [FOOTER (Tetap)] ---
      Definisi footer (dari Genset) diletakkan di sini.
      CSS 'position: fixed' akan membuatnya muncul di SETIAP HALAMAN.
    --}}
    <div class="page-footer">
         ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br> {{-- --}}
         <span style="font-weight: bold;">FM-LAP-D2-SOP-003-012 Formulir Preventive Maintenance Instalasi Kabel dan Panel Distribusi</span> {{-- --}}
    </div>


    

    {{-- Notes (dari Genset) --}}
    <div class="notes-heading avoid-break">Notes / additional informations :</div> {{-- --}}
    <div class="notes-box avoid-break">
        {!! nl2br(e($maintenance->notes ?? '')) !!}
    </div>

    {{--Pagebreak ke 2--}}
    {{-- 
      --- [HALAMAN 2 (Notes & TTD)] ---
      Menggunakan logika page break dari Genset
    --}}
    <div class="page-break-before"></div>

    {{-- Header Halaman 2 (Manual, dari Genset) --}}
    <div class="page-header avoid-break">
        <table class="header-table">
             <tr>
                <td width="12%" style="font-size: 10pt; vertical-align: top;">No. Dok.</td>
                <td width="23%" style="font-size: 10pt; vertical-align: top;">: {{ $maintenance->doc_number ?? 'FM-LAP-D2-SOP-003-012' }}</td> {{-- --}}
                <td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <div style="font-size: 14pt; font-weight: bold;">Formulir</div> {{-- --}}
                    <div style="font-size: 14pt; font-weight: bold;">Preventive Instalasi</div> {{-- --}}
                    <div style="font-size: 14pt; font-weight: bold;">Kabel dan Panel</div> {{-- --}}
                    <div style="font-size: 14pt; font-weight: bold;">Distribusi</div> {{-- --}}
                </td>
                <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                    <img src="{{ public_path('assets/images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;"> {{-- --}}
                </td>
            </tr>
            <tr><td style="font-size: 10pt; vertical-align: top;">Versi</td><td style="font-size: 10pt; vertical-align: top;">: 1.0</td></tr> {{-- --}}
            <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: 2 dari {{ $totalPages }}</td></tr> {{-- --}}
            <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr> {{-- --}}
        </table>
    </div>
    
    <div style="height: 10px;"></div>

    {{-- TTD (Struktur dari Genset, Konten dari Kabel Panel) --}}
    <div class="signature-section avoid-break">
         <div class="mengetahui-section">
            <span class="text-bold">Mengetahui,</span> {{-- --}}
            <div class="mengetahui-box">
                <div class="mengetahui-name">({{ $maintenance->approver_name ?? '..................' }})</div>
            </div>
         </div>
         <div style="width: 60%; float: left;">
            <div class="text-bold" style="margin-bottom: 3px;">Pelaksana :</div> {{-- --}}
            {{-- Menggunakan tabel TTD dari PDF Kabel Panel --}}
            <table class="pelaksana-table">
                 <thead>
                    <tr>
                        <th width="10%">No</th> {{-- --}}
                        <th width="35%">Name</th> {{-- --}}
                        <th width="30%">Perusahaan</th> {{-- --}}
                        <th width="25%">Tanda Tangan</th> {{-- --}}
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 3; $i++)
                    <tr>
                        <td class="text-center">{{ $i }}.</td>
                        <td class="name-col">{{ $maintenance->{'technician_'.$i.'_name'} ?? '' }}</td>
                        <td>{{ $maintenance->{'technician_'.$i.'_company'} ?? '' }}</td>
                        <td class="sign-col"></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
         </div>
         <div style="clear: both;"></div>
    </div>


    {{-- 
      --- [HALAMAN GAMBAR (Logika dari Genset)] ---
    --}}
    @if(!empty($images) && count($images) > 0)
        @php
            $imageChunks = array_chunk($images, $imagesPerPage);
            // Halaman gambar dimulai dari halaman ke-3 (karena Hal 1=Data, Hal 2=TTD)
            $startImagePage = 3; //
        @endphp
        
        @foreach($imageChunks as $chunkIndex => $imageChunk)
            <div class="page-break"></div> {{-- --}}
            
            @php $currentPageForHeader = $startImagePage + $chunkIndex; @endphp

            {{-- Header Halaman Gambar (Manual, dari Genset) --}}
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
                    {{-- Halaman dinamis --}}
                    <tr><td style="font-size: 10pt; vertical-align: top;">Hal</td><td style="font-size: 10pt; vertical-align: top;">: {{ $currentPageForHeader }} dari {{ $totalPages }}</td></tr>
                    <tr><td style="font-size: 10pt; vertical-align: top;">Label</td><td style="font-size: 10pt; vertical-align: top;">: Internal</td></tr>
                </table>
            </div>
            
            {{-- Konten Gambar (dari Genset) --}}
            <div style="margin-top: 10px; margin-bottom: 10px;">
                <div class="text-bold" style="margin-bottom: 5px;">Documentation Images @if($totalImagePages > 1)(Page {{ $chunkIndex + 1 }} of {{ $totalImagePages }})@endif:</div>
                <table style="width: 100%; border-collapse: collapse;">
                    @foreach(array_chunk($imageChunk, 3) as $rowImages) <tr style="page-break-inside: avoid;"> {{-- --}}
                        @foreach($rowImages as $image)
                            @if(is_array($image) && isset($image['path']) && !empty($image['path']))
                                <td class="image-cell">
                                    @php $imagePath = $image['path']; $fullPath = public_path('storage/' . $imagePath); $fileExists = is_file($fullPath); @endphp
                                    @if($fileExists)
                                        <img src="{{ $fullPath }}" alt="{{ $image['category'] ?? 'Image' }}">
                                    @else
                                        <div style="height: 180px; background: #f0f0f0; display: table-cell; vertical-align: middle; color: #999; padding: 5px;"><p style="font-size: 7pt; color: red; word-break: break-all;">Image Not Found!</p></div>
                                    @endif
                                    {{-- Mengganti nama label agar lebih rapi --}}
                                    <div class="image-label">{{ ucwords(str_replace(['visual_', 'perf_temp_mcb_', 'perf_temp_cable_', 'perf_check_', '_'], ['', 'Temp MCB ', 'Temp Kabel ', 'Check ', ' '], $image['category'] ?? 'Image')) }}</div>
                                </td>
                            @else
                                <td class="image-cell" style="background: #f8f8f8;"><div style="height: 200px; display: table-cell; vertical-align: middle; color: #ccc;">Invalid Data</div></td>
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
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir Dokumentasi dan Pendataan Perangkat</title>
    <style>
        @page {
            margin: 15mm 15mm 25mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
        }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .header-table td {
            border: 1px solid #000;
            padding: 1.5px 4px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            background-color: transparent;
        }

        .info-table td {
            padding: 2px 4px;
            font-size: 9pt;
        }

        .info-table td:nth-child(2) {
            font-weight: bold;
        }

        .page-header {
            margin-bottom: 8px;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 15mm;
            right: 15mm;
            font-size: 8px;
            border-top: 1px solid #ccc;
            text-align: left;
            padding-top: 5px;
        }

        /* ===== TABEL UTAMA ===== */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.main-table th,
        table.main-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 9px;
        }

        table.main-table th {
            background: transparent;
            font-weight: bold;
        }

        table.main-table td {
            font-weight: bold;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 50px;
            padding: 5px;
            margin-top: 10px;
            font-weight: bold;
        }

        /* ===== FOTO - OPTIMIZED 3 COLUMNS ===== */
        .page-break {
            page-break-before: always;
        }

        .photo-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .photo-row {
            display: table-row;
        }

        .photo-cell {
            display: table-cell;
            width: 32%;
            padding: 3px;
            vertical-align: top;
            text-align: center;
        }

        .photo-container {
            border: 1px solid #000;
            padding: 3px;
            margin-bottom: 5px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }

        .photo-container img {
            max-width: 100%;
            max-height: 110px;
            object-fit: contain;
            image-rendering: -webkit-optimize-contrast;
        }

        .photo-code {
            margin-top: 3px;
            font-weight: bold;
            font-size: 8px;
            text-align: center;
            word-wrap: break-word;
        }

        .no-photo {
            color: #999;
            font-style: italic;
            font-size: 9px;
        }

        /* ===== PELAKSANA DAN MENGETAHUI ===== */
        .sig-table-wrap {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .pelaksana-inner {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .pelaksana-inner thead th {
            border: 1px solid #000;
            background: transparent;
            padding: 4px;
            text-align: center;
            font-weight: normal;
            font-size: 9px;
        }

        .pelaksana-inner tbody td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
            font-size: 9px;
            font-weight: bold;
        }

        .pelaksana-inner tbody tr.signature-row {
            height: 28px;
        }

        .mengetahui-box-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            height: 62.7px;
        }

        .mengetahui-box-table td {
            border: 1px solid #000;
            vertical-align: bottom;
            text-align: center;
            padding: 10px 5px;
            font-size: 10px;
            height: 62.7px;
        }

        .sig-heading {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 6px;
        }

        .pengawas-name {
            font-weight: bold;
            font-size: 10px;
        }

        .footer-space {
            height: 60px;
        }
    </style>
</head>
<body>
    {{-- ========================================
         HALAMAN 1
    ======================================== --}}
    <div class="page-header">
        <table class="header-table">
            <tr>
                <td width="15%" style="vertical-align: top;">
                    <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-014</div>
                </td>
                <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                    <div style="font-weight: bold; font-size: 12pt;">Dokumentasi dan</div>
                    <div style="font-weight: bold; font-size: 12pt;">Pendataan Perangkat</div>
                </td>
                <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                    @php
                        $logoPath = public_path('assets/images/logo2.png');
                    @endphp
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Logo" style="width:60px; height:auto;">
                    @else
                        <div style="font-size:8px;">Logo not found</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Versi</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">1.0</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Hal</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">1 dari {{ $totalPages ?? 1 }}</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Label</div>
                </td>
                <td style="vertical-align: top;">
                    <div style="font-size: 9pt;">Internal</div>
                </td>
            </tr>
        </table>

        <table class="info-table" style="margin-top:5px;">
            <tr>
                <td width="18%">Location</td>
                <td width="82%">: {{ $dokumentasi->lokasi }}</td>
            </tr>
            <tr>
                <td width="18%">Date / Time</td>
                <td width="82%">: {{ \Carbon\Carbon::parse($dokumentasi->tanggal_dokumentasi)->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    @php
        function toRoman($num) {
            $map = [
                'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
                'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
                'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
            ];
            $returnValue = '';
            while ($num > 0) {
                foreach ($map as $roman => $int) {
                    if($num >= $int) {
                        $num -= $int;
                        $returnValue .= $roman;
                        break;
                    }
                }
            }
            return $returnValue;
        }

        // Function untuk compress image
        function compressImage($source, $quality = 75) {
            $info = getimagesize($source);
            
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($source);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($source);
            } else {
                return file_get_contents($source);
            }
            
            ob_start();
            imagejpeg($image, null, $quality);
            $compressed = ob_get_clean();
            imagedestroy($image);
            
            return $compressed;
        }
    @endphp

    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="2" style="width:5%;">No.</th>
                <th rowspan="2" style="width:35%;">EQUIPMENT</th>
                <th rowspan="2" style="width:10%;">QTY</th>
                <th colspan="2" style="width:15%;">STATUS</th>
                <th rowspan="2" style="width:35%;">KETERANGAN</th>
            </tr>
            <tr>
                <th style="width:7.5%;">ACTIVE</th>
                <th style="width:7.5%;">SHUTDOWN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dokumentasi->perangkat_sentral ?? [] as $i => $item)
                <tr>
                    <td>{{ toRoman(1) }}.{{ toRoman($i+1) }}</td>
                    <td style="text-align:left;">{{ $item['nama'] ?? '' }}</td>
                    <td>{{ $item['qty'] ?? '' }}</td>
                    <td>@if(strtolower($item['status'] ?? '') == 'active') V @endif</td>
                    <td>@if(strtolower($item['status'] ?? '') == 'shutdown') V @endif</td>
                    <td>{{ $item['keterangan'] ?? '' }}</td>
                </tr>
            @endforeach
            @foreach($dokumentasi->sarana_penunjang ?? [] as $i => $item)
                <tr>
                    <td>{{ toRoman(2) }}.{{ toRoman($i+1) }}</td>
                    <td style="text-align:left;">{{ $item['nama'] ?? '' }}</td>
                    <td>{{ $item['qty'] ?? '' }}</td>
                    <td>@if(strtolower($item['status'] ?? '') == 'active') V @endif</td>
                    <td>@if(strtolower($item['status'] ?? '') == 'shutdown') V @endif</td>
                    <td>{{ $item['keterangan'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:10px;">
        <strong>Notes / additional informations :</strong>
        <div class="notes-box">{{ $dokumentasi->keterangan ?? '' }}</div>
    </div>

    {{-- ================= PELAKSANA DAN MENGETAHUI ================= --}}
    <table class="sig-table-wrap">
        <tr>
            <td style="width:75%; vertical-align:top; padding-right:10px;">
                <div class="sig-heading">Pelaksana :</div>
                <table class="pelaksana-inner">
                    <thead>
                        <tr>
                            <th style="width:8%;">No</th>
                            <th style="width:38%;">Name</th>
                            <th style="width:32%;">Perusahaan</th>
                            <th style="width:22%;">Tanda Tangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pelaksana = $dokumentasi->pelaksana ?? [];
                            $rows = max(3, count($pelaksana));
                        @endphp
                        @for($r = 0; $r < $rows; $r++)
                            <tr class="signature-row">
                                <td>{{ $r+1 }}.</td>
                                <td style="padding-left:6px;">{{ $pelaksana[$r]['nama'] ?? '' }}</td>
                                <td style="padding-left:6px;">{{ $pelaksana[$r]['perusahaan'] ?? '' }}</td>
                                <td></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>
            <td style="width:25%; vertical-align:top; text-align:center; padding-left:10px;">
                <div class="sig-heading" style="text-align:center;">Mengetahui,</div>
                <table class="mengetahui-box-table" style="height:62.7px; width:100%;">
    <!-- ↑ DIUBAH DARI height:120px MENJADI height:100px -->
    <tr>
        <td>
            <div class="pengawas-name">{{ $dokumentasi->pengawas ?? '' }}</div>
        </td>
    </tr>
</table>

            </td>
        </tr>
    </table>

    <div class="footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-014 Formulir Dokumentasi dan Pendataan Perangkat
    </div>

    {{-- ========================================
         HALAMAN 2+: FOTO (3 COLUMNS, 15 PHOTOS PER PAGE)
    ======================================== --}}
    @php
        $allPhotos = [];
        foreach($dokumentasi->perangkat_sentral ?? [] as $index => $item) {
            if (!empty($item['photo_path'])) {
                $allPhotos[] = [
                    'path' => $item['photo_path'],
                    'code' => toRoman(1) . "." . toRoman($index + 1) . "." . ($item['nama'] ?? 'Unknown'),
                    'nama' => $item['nama'] ?? 'Unknown'
                ];
            }
        }
        foreach($dokumentasi->sarana_penunjang ?? [] as $index => $item) {
            if (!empty($item['photo_path'])) {
                $allPhotos[] = [
                    'path' => $item['photo_path'],
                    'code' => toRoman(2) . "." . toRoman($index + 1) . "." . ($item['nama'] ?? 'Unknown'),
                    'nama' => $item['nama'] ?? 'Unknown'
                ];
            }
        }
        // 15 photos per page (5 rows x 3 columns)
        $photosPerPage = 15;
        $totalPhotoPages = ceil(count($allPhotos) / $photosPerPage);
        $totalPages = 1 + $totalPhotoPages;
    @endphp

    @foreach(array_chunk($allPhotos, $photosPerPage) as $pageIndex => $pagePhotos)
        <div class="page-break">
            <div class="page-header">
                <table class="header-table">
                    <tr>
                        <td width="15%" style="vertical-align: top;">
                            <div style="font-weight: bold; font-size: 9pt;">No. Dok.</div>
                        </td>
                        <td width="30%" style="vertical-align: top;">
                            <div style="font-weight: bold; font-size: 9pt;">FM-LAP-D2-SOP-003-014</div>
                        </td>
                        <td width="40%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            <div style="font-weight: bold; font-size: 12pt;">Formulir</div>
                            <div style="font-weight: bold; font-size: 12pt;">Dokumentasi dan</div>
                            <div style="font-weight: bold; font-size: 12pt;">Pendataan Perangkat</div>
                        </td>
                        <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                            @if(file_exists($logoPath))
                                <img src="{{ $logoPath }}" alt="Logo" style="width:60px; height:auto;">
                            @else
                                <div style="font-size:8px;">Logo not found</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Versi</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">1.0</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Hal</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">{{ $pageIndex + 2 }} dari {{ $totalPages }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Label</div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 9pt;">Internal</div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="photo-grid">
                @foreach(array_chunk($pagePhotos, 3) as $rowPhotos)
                    <div class="photo-row">
                        @foreach($rowPhotos as $photo)
                            <div class="photo-cell">
                                <div class="photo-container">
                                    @php
                                        $photoFullPath = storage_path('app/public/' . $photo['path']);
                                    @endphp
                                    @if(file_exists($photoFullPath))
                                        @php
                                            // Compress image dengan quality 70%
                                            $compressedImage = compressImage($photoFullPath, 70);
                                            $base64Image = base64_encode($compressedImage);
                                        @endphp
                                        <img src="data:image/jpeg;base64,{{ $base64Image }}">
                                    @else
                                        <div class="no-photo">Foto tidak ditemukan</div>
                                    @endif
                                </div>
                                <div class="photo-code">{{ $photo['code'] }}</div>
                            </div>
                        @endforeach
                        @php
                            $emptySlots = 3 - count($rowPhotos);
                        @endphp
                        @for($i = 0; $i < $emptySlots; $i++)
                            <div class="photo-cell">
                                <div class="photo-container"><div class="no-photo">-</div></div>
                                <div class="photo-code">-</div>
                            </div>
                        @endfor
                    </div>
                @endforeach
            </div>

            <div class="footer">
                ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                FM-LAP-D2-SOP-003-014 Formulir Dokumentasi dan Pendataan Perangkat
            </div>
        </div>
    @endforeach
</body>
</html>

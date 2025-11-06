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

        /* ===== FOTO - SAMA SEPERTI INVERTER ===== */
        .page-break {
            page-break-before: always;
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
         HALAMAN 2+: FOTO (FORMAT SAMA SEPERTI INVERTER)
         3 COLUMNS, 9 PHOTOS PER PAGE (3 rows x 3 columns)
    ======================================== --}}
    @php
        // Kumpulkan semua foto
        $allPhotos = [];
        
        // Perangkat Sentral
        foreach($dokumentasi->perangkat_sentral ?? [] as $index => $item) {
            if (!empty($item['photo_path'])) {
                $photoFullPath = storage_path('app/public/' . $item['photo_path']);
                if (file_exists($photoFullPath)) {
                    $allPhotos[] = [
                        'path' => $item['photo_path'],
                        'full_path' => $photoFullPath,
                        'code' => toRoman(1) . "." . toRoman($index + 1),
                        'nama' => $item['nama'] ?? 'Unknown'
                    ];
                }
            }
        }
        
        // Sarana Penunjang
        foreach($dokumentasi->sarana_penunjang ?? [] as $index => $item) {
            if (!empty($item['photo_path'])) {
                $photoFullPath = storage_path('app/public/' . $item['photo_path']);
                if (file_exists($photoFullPath)) {
                    $allPhotos[] = [
                        'path' => $item['photo_path'],
                        'full_path' => $photoFullPath,
                        'code' => toRoman(2) . "." . toRoman($index + 1),
                        'nama' => $item['nama'] ?? 'Unknown'
                    ];
                }
            }
        }
        
        // 9 foto per halaman (3 baris x 3 kolom) - SAMA SEPERTI INVERTER
        $photosPerPage = 9;
        $totalPhotoPages = count($allPhotos) > 0 ? ceil(count($allPhotos) / $photosPerPage) : 0;
        $totalPages = 1 + $totalPhotoPages;
    @endphp

    @if(count($allPhotos) > 0)
        @foreach(array_chunk($allPhotos, $photosPerPage) as $pageIndex => $pagePhotos)
            <div style="page-break-before: always;">
                <!-- Header untuk halaman foto -->
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

                <!-- Dokumentasi Foto Section - FORMAT SAMA SEPERTI INVERTER -->
                <div style="margin-top: 8px; margin-bottom: 5px; border: 1px solid #000; border-radius: 4px; padding: 6px;">
                    <div style="margin-bottom: 8px; text-align: center; background: #e0e0e0; padding: 5px; border-radius: 4px; font-weight: bold;">
                        Dokumentasi Foto{{ $pageIndex > 0 ? ' (Lanjutan ' . ($pageIndex + 1) . ')' : '' }}
                    </div>

                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach(array_chunk($pagePhotos, 3) as $rowIndex => $rowPhotos)
                            <tr>
                                @foreach($rowPhotos as $colIndex => $photo)
                                    <td style="width: 33.33%; padding: 4px; text-align: center; border: 1px solid #ddd; vertical-align: top;">
                                        @if(file_exists($photo['full_path']))
                                            @php
                                                // Compress image dengan quality 70%
                                                $compressedImage = compressImage($photo['full_path'], 70);
                                                $base64Image = base64_encode($compressedImage);
                                            @endphp
                                            <img src="data:image/jpeg;base64,{{ $base64Image }}"
                                                 alt="Foto {{ $photo['nama'] }}"
                                                 style="width: 100%; max-height: 180px; object-fit: contain; margin-bottom: 4px;">
                                            
                                            {{-- Kode dan Judul di bawah foto --}}
                                            <div style="font-size: 8pt; font-weight: bold; color: #000; margin-bottom: 3px; padding: 2px; background: #f5f5f5; border-radius: 2px;">
                                                {{ $photo['code'] }}. {{ $photo['nama'] }}
                                            </div>
                                        @else
                                            <div style="width: 100%; height: 180px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 8pt;">
                                                Foto tidak ditemukan
                                            </div>
                                            <div style="font-size: 8pt; font-weight: bold; color: #000; margin-top: 4px;">
                                                {{ $photo['code'] }}. {{ $photo['nama'] }}
                                            </div>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Isi sel kosong jika foto tidak sampai 3 --}}
                                @for($i = count($rowPhotos); $i < 3; $i++)
                                    <td style="width: 33.33%; padding: 4px; border: none;"></td>
                                @endfor
                            </tr>
                        @endforeach
                    </table>
                </div>

                <!-- Footer untuk halaman foto -->
                <div class="footer">
                    ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
                    FM-LAP-D2-SOP-003-014 Formulir Dokumentasi dan Pendataan Perangkat
                </div>
            </div>
        @endforeach
    @endif
</body>
</html>
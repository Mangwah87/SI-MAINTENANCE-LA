<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Inventory Device</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 15mm 25mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            color: #000;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px 5px;
        }

        .header-table {
            margin-bottom: 5px;
        }

        .header-table td {
            border: 1px solid #000;
            padding: 2px 4px;
        }

        .info-table td {
            border: none;
            padding: 2px 5px;
        }

        .main-table th, .main-table td {
            padding: 3px 5px;
            font-size: 8pt;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .bg-gray {
            background-color: #f3f4f6;
        }

        .bg-yellow {
            background-color: #fef3c7;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 20px;
            border-top: 1px solid #000;
            font-size: 8pt;
            text-align: left;
            background: white;
        }

        .signature-section {
            page-break-inside: avoid;
            margin-top: 10px;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 30px;
            padding: 3px 5px;
            margin-bottom: 5px;
        }

        .keep-together {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('assets/images/logo2.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoContent = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);
        }

        // Parse device data
        $deviceSentral = is_string($inventory->device_sentral)
            ? json_decode($inventory->device_sentral, true)
            : ($inventory->device_sentral ?? []);
        $supportingFacilities = is_string($inventory->supporting_facilities)
            ? json_decode($inventory->supporting_facilities, true)
            : ($inventory->supporting_facilities ?? []);
    @endphp

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td width="15%" style="vertical-align: top;">
                <div style="font-size: 9pt;">No. Dok.</div>
            </td>
            <td width="25%" style="vertical-align: top;">
                <div style="font-size: 9pt;">FM-INV-D2-001</div>
            </td>
            <td width="45%" rowspan="4" style="text-align: center; vertical-align: middle;">
                <div style="font-weight: bold; font-size: 14pt;">INVENTORY DEVICE</div>
            </td>
            <td width="15%" rowspan="4" style="text-align: center; vertical-align: middle;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo" style="width:65px; height:auto;">
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
                <div style="font-size: 9pt;">1 dari 1</div>
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

    {{-- Info --}}
    <table class="info-table" style="margin-top: 3px; margin-bottom: 5px;">
        <tr>
            <td width="15%" style="font-size: 9pt;">Location</td>
            <td width="35%" style="font-size: 9pt;">
                : @if($inventory->central)
                    {{ $inventory->central->nama }} - {{ $inventory->central->area }}
                @else
                    {{ $inventory->location ?? '-' }}
                @endif
            </td>
            <td width="15%" style="font-size: 9pt;">Date / Time</td>
            <td width="35%" style="font-size: 9pt;">
                : {{ \Carbon\Carbon::parse($inventory->date)->format('d/m/Y') }}
                {{ \Carbon\Carbon::parse($inventory->time)->format('H:i') }}
            </td>
        </tr>
    </table>

    {{-- Device Sentral Table --}}
    <table class="main-table" style="margin-bottom: 5px;">
        <thead>
            <tr>
                <th colspan="8" class="bold" style="background-color: #fbbf24; text-align: left; padding: 4px 8px;">
                    I. DEVICE SENTRAL
                </th>
            </tr>
            <tr class="bg-gray">
                <th rowspan="2" width="5%">NO</th>
                <th rowspan="2" width="30%">EQUIPMENT</th>
                <th rowspan="2" width="8%">QTY</th>
                <th colspan="2" width="20%">STATUS</th>
                <th colspan="2" width="20%" class="bg-yellow">BONDING GROUND</th>
                <th rowspan="2" width="17%">KETERANGAN</th>
            </tr>
            <tr class="bg-gray">
                <th width="10%">ACTIVE</th>
                <th width="10%">SHUTDOWN</th>
                <th width="10%" class="bg-yellow">CONNECT</th>
                <th width="10%" class="bg-yellow">NOT CONNECT</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($deviceSentral) && count($deviceSentral) > 0)
                @foreach($deviceSentral as $index => $device)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $device['equipment'] ?? '-' }}</td>
                    <td class="center">{{ $device['qty'] ?? '-' }}</td>
                    <td class="center">{{ isset($device['status_active']) && $device['status_active'] ? '✓' : '' }}</td>
                    <td class="center">{{ isset($device['status_shutdown']) && $device['status_shutdown'] ? '✓' : '' }}</td>
                    <td class="center">{{ isset($device['bonding_connect']) && $device['bonding_connect'] ? '✓' : '' }}</td>
                    <td class="center">{{ isset($device['bonding_not_connect']) && $device['bonding_not_connect'] ? '✓' : '' }}</td>
                    <td>{{ $device['keterangan'] ?? '' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="center" style="color: #666;">No data</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Supporting Facilities Table --}}
    <table class="main-table" style="margin-bottom: 5px;">
        <thead>
            <tr>
                <th colspan="8" class="bold" style="background-color: #fbbf24; text-align: left; padding: 4px 8px;">
                    II. SUPPORTING FACILITIES (SARPEN)
                </th>
            </tr>
            <tr class="bg-gray">
                <th rowspan="2" width="5%">NO</th>
                <th rowspan="2" width="30%">EQUIPMENT</th>
                <th rowspan="2" width="8%">QTY</th>
                <th colspan="2" width="20%">STATUS</th>
                <th colspan="2" width="20%" class="bg-yellow">BONDING GROUND</th>
                <th rowspan="2" width="17%">KETERANGAN</th>
            </tr>
            <tr class="bg-gray">
                <th width="10%">ACTIVE</th>
                <th width="10%">SHUTDOWN</th>
                <th width="10%" class="bg-yellow">CONNECT</th>
                <th width="10%" class="bg-yellow">NOT CONNECT</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($supportingFacilities) && count($supportingFacilities) > 0)
                @foreach($supportingFacilities as $index => $device)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $device['equipment'] ?? '-' }}</td>
                    <td class="center">{{ $device['qty'] ?? '-' }}</td>
                    <td class="center">{{ isset($device['status_active']) && $device['status_active'] ? '✓' : '' }}</td>
                    <td class="center">{{ isset($device['status_shutdown']) && $device['status_shutdown'] ? '✓' : '' }}</td>
                    <td class="center">{{ isset($device['bonding_connect']) && $device['bonding_connect'] ? '✓' : '' }}</td>
                    <td class="center">{{ isset($device['bonding_not_connect']) && $device['bonding_not_connect'] ? '✓' : '' }}</td>
                    <td>{{ $device['keterangan'] ?? '' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="center" style="color: #666;">No data</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Notes --}}
    <div class="notes-box" style="max-height: 45px; overflow: hidden; page-break-after: avoid;">
        <span class="bold" style="font-size: 9pt;">Notes / additional informations :</span><br>
        <span style="font-size: 8.5pt;">{{ $inventory->notes ?? '' }}</span>
    </div>

    {{-- Signature Table --}}
    <div class="signature-section keep-together" style="margin-top: 3px;">
        <table style="border-collapse: collapse; width: 100%; page-break-inside: avoid;">
            <tr>
                {{-- Header Row with Yellow Background --}}
                <th colspan="4" style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 9pt; font-weight: bold; background-color: #fbbf24;">Executor</th>
                <th style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 9pt; font-weight: bold; background-color: #fbbf24;">Verifikator</th>
                <th style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 9pt; font-weight: bold; background-color: #fbbf24;">Head Of Sub<br>Departement</th>
            </tr>
            <tr>
                {{-- Sub Header for Executor --}}
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 5%; font-weight: bold;">No</th>
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 20%; font-weight: bold;">Nama</th>
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 15%; font-weight: bold;">Mitra / Internal</th>
                <th style="border: 1px solid #000; text-align: center; padding: 2px; font-size: 8pt; width: 15%; font-weight: bold;">Signature</th>
                <td rowspan="5" style="border: 1px solid #000; padding: 10px; vertical-align: bottom; text-align: center; width: 22.5%;">
                    @if($inventory->verifikator)
                        <div style="margin-bottom: 35px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( {{ $inventory->verifikator }} )
                            @if($inventory->verifikator_nik)
                                <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $inventory->verifikator_nik }}</div>
                            @endif
                        </div>
                    @else
                        <div style="margin-bottom: 35px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( _________________ )
                        </div>
                    @endif
                </td>
                <td rowspan="5" style="border: 1px solid #000; padding: 10px; vertical-align: bottom; text-align: center; width: 22.5%;">
                    @if($inventory->head_of_sub_department)
                        <div style="margin-bottom: 35px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( {{ $inventory->head_of_sub_department }} )
                            @if($inventory->head_of_sub_department_nik)
                                <div style="font-size: 7pt; margin-top: 2px;">NIK: {{ $inventory->head_of_sub_department_nik }}</div>
                            @endif
                        </div>
                    @else
                        <div style="margin-bottom: 35px;"></div>
                        <div style="border-top: 1px solid #000; padding-top: 2px; font-size: 8pt;">
                            ( _________________ )
                        </div>
                    @endif
                </td>
            </tr>
            @for($i = 1; $i <= 4; $i++)
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 3px; font-size: 8pt;">{{ $i }}</td>
                <td style="border: 1px solid #000; padding: 3px; font-size: 8pt;">{{ $inventory->{'executor_'.$i} ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-size: 8pt;">{{ $inventory->{'mitra_internal_'.$i} ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 3px; text-align: center; height: 20px;"></td>
            </tr>
            @endfor
        </table>
    </div>

    {{-- Footer --}}
    <div class="page-footer">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia<br>
        FM-INV-D2-001 Inventory Device
    </div>
</body>
</html>

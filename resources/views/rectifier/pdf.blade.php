<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preventive Maintenance Rectifier</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
            margin-top: 8mm;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7.5pt;
            color: #000;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
        }

        /* Header Table */
        .header-table th,
        .header-table td {
            border: 1px solid #000;
            padding: 2px 4px;
            font-size: 7pt;
        }

        .header-table {
            margin-bottom: 4px;
            width: 100%;
        }

        .header-table .logo-cell {
            text-align: center;
            vertical-align: middle;
        }

        .header-table .logo-cell img {
            width: 50px;
            height: auto;
        }

        .header-table .title-cell {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 10pt;
            line-height: 1.3;
        }

        /* Info Table */
        .info-table td {
            border: none;
            padding: 1px 4px;
            font-size: 7.5pt;
        }

        .info-table {
            margin-bottom: 4px;
            width: 100%;
        }

        /* Main Data Table */
        .main-table {
            margin-top: 3px;
        }

        .main-table th {
            background: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 3px;
            font-size: 7.5pt;
        }

        .main-table td {
            padding: 2px 4px;
            font-size: 7.5pt;
        }

        .main-table .section-header {
            font-weight: bold;
            background: #ffffff;
        }

        .main-table .indent {
            padding-left: 15px;
        }

        .main-table .number-cell {
            text-align: center;
            font-weight: bold;
            vertical-align: top;
            width: 5%;
        }

        /* Status Styling */
        .status-ok {
            color: #000;
            font-weight: bold;
        }

        .status-nok {
            color: #000;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        /* Notes Box */
        .notes-box {
            border: 1px solid #000;
            min-height: 30px;
            padding: 3px;
            margin: 4px 0;
            background: #fafafa;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 6px;
        }
        /* Page Footer */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 6pt;
            text-align: left;
            border-top: 1px solid #000;
            padding-top: 2px;
            background: white;
            line-height: 1.2;
        }

        .content-wrapper {
            margin-bottom: 40px;
        }

        .page-break {
            page-break-after: always;
            clear: both;
        }

        /* Image Styling */
        .image-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .image-cell {
            width: 33.33%;
            padding: 4px;
            border: none;
            vertical-align: top;
        }

        .image-container {
            width: 100%;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 3px;
            overflow: hidden;
        }

        .image-wrapper {
            width: 100%;
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            padding: 3px;
        }

        .image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .image-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #000;
            padding: 6px 5px;
            background: #e8f4f8;
            text-align: center;
            line-height: 1.3;
            border-top: 1px solid #ddd;
        }

        .image-info {
            font-size: 6pt;
            color: #555;
            padding: 5px;
            background: #f9f9f9;
            text-align: left;
            line-height: 1.5;
            border-top: 1px solid #e0e0e0;
        }

        .image-info-row {
            margin-bottom: 2px;
        }

        .image-info-label {
            font-weight: bold;
            color: #000;
        }

        /* Image Not Found Placeholder */
        .image-placeholder {
            width: 100%;
            height: 260px;
            background-color: #f5f5f5;
            border: 1px dashed #ccc;
            border-radius: 3px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #999;
        }

        .image-placeholder-icon {
            margin-bottom: 8px;
        }

        .image-placeholder-text {
            font-size: 8pt;
            font-weight: bold;
        }

        .image-placeholder-filename {
            font-size: 6pt;
            color: #bbb;
            margin-top: 4px;
            padding: 0 8px;
            text-align: center;
            word-break: break-all;
        }

        .image-placeholder-category {
            font-size: 6.5pt;
            color: #aaa;
            margin-top: 6px;
            padding: 4px 8px;
            background: #f0f0f0;
            border-radius: 3px;
        }

        /* Utility Classes */
        .text-strikethrough {
            text-decoration: line-through;
            color: #666;
        }

        .small-text {
            font-size: 7pt;
        }
    </style>
</head>
<body>
    @php
        // Hitung total halaman secara otomatis
        $totalPages = 1; // Halaman data utama

        // Tambah halaman jika ada gambar dokumentasi
        if($maintenance && $maintenance->images && count($maintenance->images) > 0) {
            $totalPages = 2;
        }

        $currentPage = 1;
    @endphp

    <!-- PAGE 1: Main Content -->
    <div class="content-wrapper">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td width="15%">No. Dok.</td>
                <td width="30%">FM-LAP-D2-SOP-003-010</td>
                <td width="40%" rowspan="4" class="title-cell">
                    <div>Formulir</div>
                    <div>Preventive Maintenance</div>
                    <div>Rectifier</div>
                </td>
                <td width="15%" rowspan="4" class="logo-cell">
                    <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td>Versi</td>
                <td>1.0</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>{{ $currentPage }} dari {{ $totalPages }}</td>
            </tr>
            <tr>
                <td>Label</td>
                <td>Internal</td>
            </tr>
        </table>

        <!-- Info Table -->
        <table class="info-table">
            <tr>
                <td width="15%"><strong>Location</strong></td>
                <td width="35%">: {{ $maintenance->central->nama ?? $maintenance->location ?? '-' }}</td>
                <td width="20%"><strong>Kap.Power Module</strong></td>
                <td width="35%">:
                    <span class="{{ $maintenance->power_module === 'Single' ? 'bold' : 'text-strikethrough' }}">Single</span> /
                    <span class="{{ $maintenance->power_module === 'Dual' ? 'bold' : 'text-strikethrough' }}">Dual</span> /
                    <span class="{{ $maintenance->power_module === 'Three' ? 'bold' : 'text-strikethrough' }}">Three</span> *)
                </td>
            </tr>
            <tr>
                <td><strong>Date / Time</strong></td>
                <td>: {{ $maintenance->date_time->format('d/m/Y H:i') ?? '-' }}</td>
                <td><strong>Reg. Number</strong></td>
                <td>: {{ $maintenance->reg_number ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Brand / Type</strong></td>
                <td>: {{ $maintenance->brand_type ?? '-' }}</td>
                <td><strong>S/N</strong></td>
                <td>: {{ $maintenance->sn ?? '-' }}</td>
            </tr>
        </table>

        <!-- Main Data Table -->
        <table class="main-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="30%">Descriptions</th>
                    <th width="20%">Result</th>
                    <th width="27%">Operational Standard</th>
                    <th width="18%">Status (OK/NOK)</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1. Physical Check -->
                <tr>
                    <td rowspan="6" class="number-cell">1.</td>
                    <td class="section-header"><strong>Physical Check</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="indent">a. Environment Condition</td>
                    <td>{{ $maintenance->env_condition ?? '-' }}</td>
                    <td>Clean, No dust</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_env_condition == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_env_condition ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="indent">b. LED / display</td>
                    <td>{{ $maintenance->led_display ?? '-' }}</td>
                    <td>Normal</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_led_display == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_led_display ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="indent">c. Battery Connection</td>
                    <td>{{ $maintenance->battery_connection ?? '-' }}</td>
                    <td>Tighten, No Corrosion</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_battery_connection == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_battery_connection ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="indent">d. Rectifier Module Installed</td>
                    <td>{{ $maintenance->rectifier_module_installed ?? '-' }}</td>
                    <td></td>
                    <td class="center">
                        <span class="{{ $maintenance->status_rectifier_module_installed == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_rectifier_module_installed ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="indent">e. Alarm Modul Rectifier</td>
                    <td>{{ $maintenance->alarm_modul_rectifier ?? '-' }}</td>
                    <td>Normal = Green<br>Alarm = Red</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_alarm_modul_rectifier == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_alarm_modul_rectifier ?? '-' }}
                        </span>
                    </td>
                </tr>

                <!-- 2. Performance and Capacity Check -->
                <tr>
                    <td rowspan="10" class="number-cell">2</td>
                    <td class="section-header"><strong>Performance and Capacity Check</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="indent">a. AC Input Voltage</td>
                    <td>{{ $maintenance->ac_input_voltage ?? '-' }} VAC</td>
                    <td>180-240 VAC</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_ac_input_voltage == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_ac_input_voltage ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" class="indent" style="vertical-align: top;">b. AC Current Input</td>
                    <td rowspan="3">{{ $maintenance->ac_current_input ?? '-' }} A</td>
                    <td>≤ 5.5 A ( Single Power Module )</td>
                    <td rowspan="3" class="center">
                        <span class="{{ $maintenance->status_ac_current_input == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_ac_current_input ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>≤ 11 A ( Dual Power Module )</td>
                </tr>
                <tr>
                    <td>≤ 16.5 A ( Three Power Module )</td>
                </tr>
                <tr>
                    <td rowspan="3" class="indent" style="vertical-align: top;">c. DC Current Output</td>
                    <td rowspan="3">{{ $maintenance->dc_current_output ?? '-' }} A</td>
                    <td>≤ 25 A ( Single Power Module )</td>
                    <td rowspan="3" class="center">
                        <span class="{{ $maintenance->status_dc_current_output == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_dc_current_output ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>≤ 50 A ( Dual Power Module )</td>
                </tr>
                <tr>
                    <td>≤ 75 A ( Three Power Module )</td>
                </tr>
                <tr>
                    <td class="indent">d. Charging Voltage DC</td>
                    <td>{{ $maintenance->charging_voltage_dc ?? '-' }} VDC</td>
                    <td>48 – 55.3 VDC</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_charging_voltage_dc == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_charging_voltage_dc ?? '-' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="indent">e. Charging Current DC</td>
                    <td>{{ $maintenance->charging_current_dc ?? '-' }} A</td>
                    <td>Max 10% Battery Capacity ( AH )</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_charging_current_dc == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_charging_current_dc ?? '-' }}
                        </span>
                    </td>
                </tr>

                <!-- 3. Rectifier Switching Test -->
                <tr>
                    <tr>
                        <td class="number-cell">3</td>
                        <td><strong>Backup Tests</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <td></td>
                    <td><strong>Rectifier Switching test, from the main source (PLN)  to  back up mode, by turning off Rectifier input MCB </strong></td>
                    <td>{{ $maintenance->backup_test_rectifier ?? '-' }}</td>
                    <td>Rectifier Normal Operations</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_backup_test_rectifier == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_backup_test_rectifier ?? '-' }}
                        </span>
                    </td>
                </tr>

                <!-- 4. Power Alarm Monitoring Test -->
                <tr>
                    <td class="number-cell">4</td>
                    <td><strong>Power Alarm Monitoring Test</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Makesure the alarm monitor, by turn off UPS power input MCB during Rect backup test operation</td>
                    <td>{{ $maintenance->power_alarm_test ?? '-' }}</td>
                    <td>Alarm Monitor fault conditions ( Red Sign / Alert "Alarm Input Voltage )</td>
                    <td class="center">
                        <span class="{{ $maintenance->status_power_alarm_test == 'NOK' ? 'status-nok' : '' }}">
                            {{ $maintenance->status_power_alarm_test ?? '-' }}
                        </span>
                    </td>

                </tr>
            </tbody>
        </table>

        <!-- Notes -->
        <div style="margin-top: 4px; margin-bottom: 2px; font-weight: bold; font-size: 7.5pt;">Notes / additional informations:</div>
        <div class="notes-box" style="font-size: 7pt;">
            {{ $maintenance->notes ?? '-' }}
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                {{-- Main Header Row --}}
                <tr>
                    <td style="width: 50%; border: 2px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Executor
                    </td>
                    <td style="width: 25%; border: 2px solid #000; border-left: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Verifikator
                    </td>
                    <td style="width: 25%; border: 2px solid #000; border-left: 1px solid #000; text-align: center; padding: 4px; font-weight: bold; font-size: 9pt;">
                        Head Of Sub<br>Department
                    </td>
                </tr>
                {{-- Content Row --}}
                <tr>
                    {{-- Executor Table --}}
                    <td style="width: 50%; border: 1px solid #000; border-top: none; padding: 0; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <th style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 5%;">No</th>
                                <th style="border: 1px solid #000; border-top: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 33%;">Nama</th>
                                <th style="border: 1px solid #000; border-top: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 33%;">Mitra / Internal</th>
                                <th style="border: 1px solid #000; border-top: none; border-right: none; text-align: center; padding: 2px 3px; font-size: 8pt; font-weight: bold; width: 30%;">Signature</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">1</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->executor_1 ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->executor_1_type ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; padding: 12px 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">2</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->executor_2 ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->executor_2_type ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; padding: 12px 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; text-align: center; padding: 12px 2px; font-size: 8pt;">3</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;">{{ $maintenance->executor_3 ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;">{{ $maintenance->executor_3_type ?? '' }}</td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; padding: 12px 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; border-top: none; border-left: none; border-bottom: none; text-align: center; padding: 12px 2px; font-size: 8pt;">4</td>
                                <td style="border: 1px solid #000; border-top: none; border-bottom: none; text-align: left; padding: 2px 3px; font-size: 7.5pt; height: 20px;"></td>
                                <td style="border: 1px solid #000; border-top: none; border-bottom: none; text-align: left; padding: 2px 3px; font-size: 7.5pt;"></td>
                                <td style="border: 1px solid #000; border-top: none; border-right: none; border-bottom: none; padding: 12px 2px;"></td>
                            </tr>
                        </table>
                    </td>

                    {{-- Verifikator --}}
                    <td style="width: 25%; border: 1px solid #000; border-top: none; border-left: 1px solid #000; padding: 3px; text-align: center; vertical-align: top; font-size: 7.5pt;">
                        <div style="padding-top: 10px; display: flex; flex-direction: column;">
                            <div style="border-bottom: 1px solid #ffffff; height: 110px; margin-bottom: 5px;"></div>
                            <div>{{ $maintenance->verifikator_name ?? '-' }}</div>
                            <div style="border-bottom: 1px solid #000; height: 3px; margin-bottom: 5px;"></div>
                            <div style="font-size: 6.5pt; margin-top: 2px;">NIK: {{ $maintenance->verifikator_id_number ?? '-' }}</div>
                        </div>
                    </td>

                    {{-- Head of Sub Department --}}
                    <td style="width: 25%; border: 1px solid #000; border-top: none; border-left: 1px solid #000; padding: 3px; text-align: center; vertical-align: top; font-size: 7.5pt;">
                        <div style="padding-top: 10px; display: flex; flex-direction: column;">
                            <div style="border-bottom: 1px solid #ffffff; height: 110px; margin-bottom: 5px;"></div>
                            <div>{{ $maintenance->head_of_sub_dept_name ?? '-' }}</div>
                            <div style="border-bottom: 1px solid #000; height: 3px; margin-bottom: 5px;"></div>
                            <div style="font-size: 6.5pt; margin-top: 2px;">NIK: {{ $maintenance->head_of_sub_dept_id ?? '-' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-footer">
        ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
        FM-LAP-D2-SOP-003-010 Formulir Preventive Maintenance Rectifier
    </div>

    <!-- PAGE 2: Image Documentation (Only if images exist) -->
    @if($maintenance && $maintenance->images && count($maintenance->images) > 0)
        @php $currentPage = 2; @endphp

        <div class="page-break"></div>

        <div class="content-wrapper">
            <!-- Header for image page -->
            <table class="header-table">
                <tr>
                    <td width="15%">No. Dok.</td>
                    <td width="30%">FM-LAP-D2-SOP-003-010</td>
                    <td width="40%" rowspan="4" class="title-cell">
                        <div>Dokumentasi Foto</div>
                        <div>Preventive Maintenance</div>
                        <div>Rectifier</div>
                    </td>
                    <td width="15%" rowspan="4" class="logo-cell">
                        <img src="{{ public_path('assets/images/logo2.png') }}" alt="Logo">
                    </td>
                </tr>
                <tr>
                    <td>Versi</td>
                    <td>1.0</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>{{ $currentPage }} dari {{ $totalPages }}</td>
                </tr>
                <tr>
                    <td>Label</td>
                    <td>Internal</td>
                </tr>
            </table>

            <div style="margin-top: 10px; border: 1px solid #000; border-radius: 4px; padding: 8px; background: #fafafa;">
                <div class="bold center" style="margin-bottom: 10px; background: #e0e0e0; padding: 6px; border-radius: 4px;">
                    Documentation Images
                </div>

                <table class="image-grid">
                    @php
                        $imageIndex = 0;
                        $imagesPerRow = 3;
                    @endphp
                    @foreach($maintenance->images as $image)
                        @if($imageIndex % $imagesPerRow == 0)
                            @if($imageIndex > 0)
                                </tr>
                            @endif
                            <tr>
                        @endif

                        <td class="image-cell">
                            <div class="image-container">
                                <div class="image-wrapper">
                                    @php
                                        $imagePath = storage_path('app/public/' . $image['path']);
                                        $imageData = null;
                                    @endphp
                                    @if(file_exists($imagePath))
                                        @php
                                            $imageData = base64_encode(file_get_contents($imagePath));
                                            $mimeType = mime_content_type($imagePath);
                                        @endphp
                                        <img src="data:{{ $mimeType }};base64,{{ $imageData }}" alt="{{ $image['category'] ?? 'Photo' }}" style="max-width: 100%; max-height: 100%;">
                                    @else
                                        <div style="text-align: center; padding: 20px; background: #f0f0f0; color: #999;">
                                            <div style="font-size: 20px; margin-bottom: 5px;"></div>
                                            <div style="font-size: 8pt;">Image Not Found</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="image-label">{{ ucfirst(str_replace('_', ' ', $image['category'] ?? 'Photo')) }}</div>
                                @if(isset($image['timestamp']))
                                    <div class="image-info">
                                        <!-- <div class="image-info-row">
                                            <span class="image-info-label">Time:</span> {{ \Carbon\Carbon::parse($image['timestamp'])->format('d M Y H:i:s') }}
                                        </div> -->
                                    </div>
                                @endif
                            </div>
                        </td>

                        @php $imageIndex++; @endphp
                    @endforeach
                    @if(($imageIndex % $imagesPerRow) != 0)
                        @for($i = $imageIndex % $imagesPerRow; $i < $imagesPerRow; $i++)
                            <td class="image-cell" style="background: #fff;"></td>
                        @endfor
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="page-footer">
            ©HakCipta PT. APLIKARUSA LINTASARTA, Indonesia<br>
            FM-LAP-D2-SOP-003-010 Formulir Preventive Maintenance Rectifier
        </div>
    @endif
</body>
</html>

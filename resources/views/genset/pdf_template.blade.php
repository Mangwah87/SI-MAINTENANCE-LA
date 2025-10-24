<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Genset Maintenance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .header-table td, .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 3px 5px;
        }
        /* PERUBAHAN DI SINI: Menambahkan !important untuk memaksa border tampil */
        .pelaksana-table th, .pelaksana-table td {
            border: 1px solid #000 !important;
            padding: 3px 5px;
        }
        .info-table td {
            border: none;
            padding: 2px;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .sub-item { padding-left: 10px; }
        .sub-sub-item { padding-left: 20px; }
        .notes-section {
            border: 1px solid #000;
            padding: 5px;
            margin: 10px 0;
            min-height: 40px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-table td {
            border: none;
            vertical-align: top;
            padding: 0 5px;
        }
        .signature-box { height: 50px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="12%" style="font-size: 8pt; vertical-align: top;">No. Dok.</td>
            <td width="23%" style="font-size: 8pt; vertical-align: top;">: FM-LAP-D2-SOP-003-006</td>
            <td width="40%" rowspan="4" class="text-center" style="vertical-align: middle;">
                <div style="font-size: 11pt; font-weight: bold;">Formulir</div>
                <div style="font-size: 12pt; font-weight: bold;">Preventive Maintenance</div>
                <div style="font-size: 14pt; font-weight: bold;">Genset</div>
            </td>
            <td width="25%" rowspan="4" class="text-center" style="vertical-align: middle;">
                <img src="{{ public_path('images/Lintasarta_Logo_Logogram.png') }}" style="width: 80px;">
            </td>
        </tr>
        <tr>
            <td style="font-size: 8pt; vertical-align: top;">Versi</td>
            <td style="font-size: 8pt; vertical-align: top;">: 1.0</td>
        </tr>
        <tr>
            <td style="font-size: 8pt; vertical-align: top;">Hal</td>
            <td style="font-size: 8pt; vertical-align: top;">: 1 dari 2</td>
        </tr>
        <tr>
            <td style="font-size: 8pt; vertical-align: top;">Label</td>
            <td style="font-size: 8pt; vertical-align: top;">: Internal</td>
        </tr>
    </table>

    <div style="height: 10px;"></div>

    <table class="info-table">
        <tr>
            <td width="15%">Location</td><td width="35%">: {{ $maintenance->location }}</td>
            <td width="15%">Brand / Type</td><td width="35%">: {{ $maintenance->brand_type }}</td>
        </tr>
        <tr>
            <td>Date / time</td><td>: {{ $maintenance->maintenance_date->format('d M Y / H:i') }}</td>
            <td>Capacity</td><td>: {{ $maintenance->capacity }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="35%">Descriptions</th>
                <th width="15%">Result</th>
                <th width="30%">Operational Standard</th>
                <th width="15%">Comment</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center text-bold">1.</td><td colspan="4" class="text-bold">Visual Check</td></tr>
            <tr><td></td><td class="sub-item text-bold">Engine & Generator</td><td></td><td></td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">a. Environment Condition</td><td class="text-center">{{ $maintenance->environment_condition_result }}</td><td>Clean, No dust</td><td>{{ $maintenance->environment_condition_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">b. Engine Oil Press. Display</td><td class="text-center">{{ $maintenance->engine_oil_press_display_result }}</td><td>Normal</td><td>{{ $maintenance->engine_oil_press_display_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">c. Engine Water Temp. Display</td><td class="text-center">{{ $maintenance->engine_water_temp_display_result }}</td><td>Normal</td><td>{{ $maintenance->engine_water_temp_display_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">d. Battery Connection</td><td class="text-center">{{ $maintenance->battery_connection_result }}</td><td>Tight, No Corrosion</td><td>{{ $maintenance->battery_connection_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">e. Engine Oil Level</td><td class="text-center">{{ $maintenance->engine_oil_level_result }}</td><td>High</td><td>{{ $maintenance->engine_oil_level_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">f. Engine Fuel Level</td><td class="text-center">{{ $maintenance->engine_fuel_level_result }}</td><td>High</td><td>{{ $maintenance->engine_fuel_level_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">g. Running Hours</td><td class="text-center">{{ $maintenance->running_hours_result }}</td><td>N/A</td><td>{{ $maintenance->running_hours_comment }}</td></tr>
            <tr><td></td><td class="sub-sub-item">h. Cooling Water Level</td><td class="text-center">{{ $maintenance->cooling_water_level_result }}</td><td>High</td><td>{{ $maintenance->cooling_water_level_comment }}</td></tr>
            <tr><td class="text-center text-bold">2.</td><td colspan="4" class="text-bold">Engine Running Test</td></tr>
            <tr><td></td><td class="sub-item text-bold" colspan="4">I. No Load Test ( 30 minute )</td></tr>
            <tr><td></td><td class="sub-sub-item">a. AC Output Voltage</td><td>R–S={{ $maintenance->no_load_ac_voltage_rs }} S–T={{ $maintenance->no_load_ac_voltage_st }} T–R={{ $maintenance->no_load_ac_voltage_tr }}</td><td>360 – 400 VAC</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item"></td><td>R–N={{ $maintenance->no_load_ac_voltage_rn }} S–N={{ $maintenance->no_load_ac_voltage_sn }} T–N={{ $maintenance->no_load_ac_voltage_tn }}</td><td>180 – 230 VAC</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">b. Output Frequency</td><td class="text-center">{{ $maintenance->no_load_output_frequency }}</td><td>Max 53.00 Hz</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">c. Battery Charging Current</td><td class="text-center">{{ $maintenance->no_load_battery_charging_current }}</td><td>Max 10 Amp.</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">d. Engine Cooling Water Temp.</td><td class="text-center">{{ $maintenance->no_load_engine_cooling_water_temp }}</td><td>Max 90 deg C</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">e. Engine Oil Press.</td><td class="text-center">{{ $maintenance->no_load_engine_oil_press }}</td><td>Min 50 Psi</td><td></td></tr>
            <tr style="page-break-before: always;"><td class="sub-item text-bold" colspan="5">II. Load Test ( 30 minute )</td></tr>
            <tr><td></td><td class="sub-sub-item">a. AC Output Voltage</td><td>R–S={{ $maintenance->load_ac_voltage_rs }} S–T={{ $maintenance->load_ac_voltage_st }} T–R={{ $maintenance->load_ac_voltage_tr }}</td><td>360 – 400 VAC</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item"></td><td>R–N={{ $maintenance->load_ac_voltage_rn }} S–N={{ $maintenance->load_ac_voltage_sn }} T–N={{ $maintenance->load_ac_voltage_tn }}</td><td>180 – 230 VAC</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">b. AC Output Current</td><td>R={{ $maintenance->load_ac_current_r }} S={{ $maintenance->load_ac_current_s }} T={{ $maintenance->load_ac_current_t }}</td><td style="font-size: 8pt;">6KVA=Max 20A, 10KVA=Max 35A, 22KVA=Max 26A/ph, 65KVA=Max 80A/ph, 100KVA=Max 120A/ph, 250KVA=Max 300A/ph</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">c. Output Frequency</td><td class="text-center">{{ $maintenance->load_output_frequency }}</td><td>50.00 Hz</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">d. Battery Charging Current</td><td class="text-center">{{ $maintenance->load_battery_charging_current }}</td><td>Max 10 Amp.</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">e. Engine Cooling Water Temp.</td><td class="text-center">{{ $maintenance->load_engine_cooling_water_temp }}</td><td>Max 90 deg C</td><td></td></tr>
            <tr><td></td><td class="sub-sub-item">f. Engine Oil Press.</td><td class="text-center">{{ $maintenance->load_engine_oil_press }}</td><td>Min 50 Psi</td><td></td></tr>
        </tbody>
    </table>

    <div class="notes-section">
        <span class="text-bold">Notes / additional informations :</span><br>
        {{ $maintenance->notes ?? 'Tidak ada catatan.' }}
    </div>

    <table class="signature-table">
        <tr>
            <td width="70%">
                <span class="text-bold">Pelaksana</span>
            </td>
            <td width="30%" class="text-center">
                <span class="text-bold">Mengetahui</span>
            </td>
        </tr>
        <tr>
            <td>
                <table class="pelaksana-table">
                   <thead>
                       <tr>
                           <th width="5%">No</th><th width="35%">Nama</th><th width="30%">Departement</th><th width="30%">Sub Departement</th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr>
                           <td class="text-center">1.</td><td>{{ $maintenance->technician_1_name }}</td><td>{{ $maintenance->technician_1_department }}</td><td></td>
                       </tr>
                       <tr>
                           <td class="text-center">2.</td><td>{{ $maintenance->technician_2_name }}</td><td>{{ $maintenance->technician_2_department }}</td><td></td>
                       </tr>
                       <tr>
                           <td class="text-center">3.</td><td>{{ $maintenance->technician_3_name }}</td><td>{{ $maintenance->technician_3_department }}</td><td></td>
                       </tr>
                   </tbody>
                </table>
            </td>
            <td class="text-center">
                <div class="signature-box"></div>
                ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )
            </td>
        </tr>
    </table>

    <div style="height: 20px;"></div>

    <div style="font-size: 8pt; border-top: 1px solid #000; padding-top: 5px;">
        ©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia.
        <br>
        <span style="font-weight: bold;">FM-LAP-D2-SOP-003-006 Formulir Preventive Maintenance Genset</span>
    </div>

</body>
</html>
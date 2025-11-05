<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Preventive Maintenance Inverter') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 sm:px-4 sm:py-3 rounded mb-4 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('inverter.store') }}" method="POST" enctype="multipart/form-data" id="inverter-form">
                        @csrf

                        <!-- Informasi Umum -->
                        <div class="mb-6 sm:mb-8">
                            <h4 class="text-sm sm:text-md font-bold text-gray-700 border-b pb-2 mb-3 sm:mb-4">Informasi Umum</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nomor Dokumen</label>
                                    <input type="text" name="nomor_dokumen" value="FM-LAP-D2-SOP-003-008" readonly
                                           class="mt-1 block w-full text-sm bg-gray-100 border-gray-300 rounded-md shadow-sm px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Masukkan lokasi">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Date / Time <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" name="tanggal_dokumentasi" value="{{ old('tanggal_dokumentasi') }}" required
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Brand / Type</label>
                                    <input type="text" name="brand" value="{{ old('brand') }}"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Contoh: ABB / Delta">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Reg. Number</label>
                                    <input type="text" name="reg_num" value="{{ old('reg_num') }}"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Nomor registrasi">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">S/N (Serial Number)</label>
                                    <input type="text" name="serial_num" value="{{ old('serial_num') }}"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Serial number">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                                    <input type="text" name="perusahaan" value="{{ old('perusahaan', 'PT. Aplikanusa Lintasarta') }}"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2">
                                </div>
                                
                                <!-- TAMBAHAN FIELD BOSS -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pengawas</label>
                                    <input type="text" name="boss" value="{{ old('boss') }}"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2" 
                                           placeholder="Nama Pengawas">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Notes / Additional Info</label>
                                    <textarea name="keterangan" rows="3" class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm px-3 py-2"
                                              placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Performance and Capacity Check -->
                        <div class="mb-6 sm:mb-8">
                            <h4 class="text-sm sm:text-md font-bold text-gray-700 border-b pb-2 mb-3 sm:mb-4">Performance and Capacity Check</h4>
                            
                            <!-- Desktop: Table -->
                            <div class="hidden lg:block overflow-x-auto">
                                <table class="min-w-full border-collapse border border-gray-300">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">No.</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Descriptions</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Result / Photo</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Operational Standard</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Visual Check Header -->
                                        <tr class="bg-blue-50">
                                            <td class="border border-gray-300 px-4 py-2 font-semibold">1.</td>
                                            <td class="border border-gray-300 px-4 py-2 font-semibold" colspan="4">Visual Check</td>
                                        </tr>
                                        
                                        <!-- Environment Condition -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">a. Environment Condition</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="hidden" name="data_inverter[0][nama]" value="Environment Condition">
                                                <input type="text" name="data_inverter[0][status]" id="environment_status"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="Contoh: Clean, No Dust" oninput="syncValue('environment_status')">
                                                <div id="environment-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addEnvironmentPhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto Environment
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">Clean, No dust</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[0][tegangan]" id="environment_tegangan" 
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm" onchange="syncValue('environment_tegangan')">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>
                                        
                                        <!-- LED Display -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">b. LED / Display</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="hidden" name="data_inverter[1][nama]" value="LED Display">
                                                <input type="text" name="data_inverter[1][status]" id="led_status"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="Contoh: Normal" oninput="syncValue('led_status')">
                                                <div id="led-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addLedPhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto LED
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">Normal</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[1][tegangan]" id="led_tegangan"
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm" onchange="syncValue('led_tegangan')">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <!-- Performance Check Header -->
                                        <tr class="bg-blue-50">
                                            <td class="border border-gray-300 px-4 py-2 font-semibold">2.</td>
                                            <td class="border border-gray-300 px-4 py-2 font-semibold" colspan="4">Performance and Capacity Check</td>
                                        </tr>
                                        
                                        <!-- DC Input Voltage -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">a. DC Input Voltage</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" step="0.01" name="dc_input_voltage" id="dc_input_voltage"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="48.00" oninput="validateDcInputVoltage(); syncValue('dc_input_voltage')">
                                                <input type="hidden" name="data_inverter[2][nama]" value="DC Input Voltage">
                                                <div id="dc-voltage-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addDcVoltagePhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto DC Input Voltage
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">48 - 54 VDC</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[2][status]" id="status_dc_voltage" disabled
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm bg-gray-100">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <!-- DC Current Input -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">b. DC Current Input *)</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <label class="block text-xs text-gray-600 mb-1">Select Inverter Type:</label>
                                                <select id="dc_current_type" class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-2" 
                                                        onchange="saveDcCurrentType(); validateDcCurrentInput(); syncValue('dc_current_type');">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="500">500 VA</option>
                                                    <option value="1000">1000 VA</option>
                                                </select>
                                                <input type="number" step="0.01" name="dc_current_input" id="dc_current_input"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="Enter value" oninput="validateDcCurrentInput(); syncValue('dc_current_input')">
                                                <input type="hidden" name="dc_current_inverter_type" id="dc_current_inverter_type">
                                                <input type="hidden" name="data_inverter[3][nama]" value="DC Current Input">
                                                <div id="dc-current-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addDcCurrentPhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto DC Current Input
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">≤ 9 A (500 VA)<br>≤ 18 A (1000 VA)</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[3][status]" id="status_dc_current" disabled
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm bg-gray-100">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <!-- AC Current Output -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">c. AC Current Output *)</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <label class="block text-xs text-gray-600 mb-1">Select Inverter Type:</label>
                                                <select id="ac_current_type" class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-2" 
                                                        onchange="saveAcCurrentType(); validateAcCurrentOutput(); syncValue('ac_current_type');">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="500">500 VA</option>
                                                    <option value="1000">1000 VA</option>
                                                </select>
                                                <input type="number" step="0.01" name="ac_current_output" id="ac_current_output"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="Enter value" oninput="validateAcCurrentOutput(); syncValue('ac_current_output')">
                                                <input type="hidden" name="ac_current_inverter_type" id="ac_current_inverter_type">
                                                <input type="hidden" name="data_inverter[4][nama]" value="AC Current Output">
                                                <div id="ac-current-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addAcCurrentPhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto AC Current Output
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">≤ 2 A (500 VA)<br>≤ 4 A (1000 VA)</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[4][status]" id="status_ac_current" disabled
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm bg-gray-100">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <!-- Neutral Ground -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">d. Neutral - Ground Output Voltage</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" step="0.01" name="neutral_ground_output_voltage" id="neutral_ground_output_voltage"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="1.00" oninput="validateNeutralGround(); syncValue('neutral_ground_output_voltage')">
                                                <input type="hidden" name="data_inverter[5][nama]" value="Neutral - Ground Output Voltage">
                                                <div id="neutral-ground-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addNeutralGroundPhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto Neutral - Ground
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">≤ 1 Volt AC</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[5][status]" id="status_neutral_ground" disabled
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm bg-gray-100">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <!-- Equipment Temperature -->
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">e. Equipment Temperature</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" step="0.01" name="equipment_temperature" id="equipment_temperature"
                                                       class="w-full px-2 py-1 border border-gray-300 rounded text-sm mb-3"
                                                       placeholder="30.00" oninput="validateTemperature(); syncValue('equipment_temperature')">
                                                <input type="hidden" name="data_inverter[6][nama]" value="Equipment Temperature">
                                                <div id="temperature-photos-container" class="space-y-3"></div>
                                                <button type="button" onclick="addTemperaturePhoto()" 
                                                        class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                    + Tambah Foto Equipment Temperature
                                                </button>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">0-35 °C</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="data_inverter[6][status]" id="status_temperature" disabled
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm bg-gray-100">
                                                    <option value="">-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NOK">NOK</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- MOBILE VERSION: Card-based Layout -->
                            <div class="lg:hidden space-y-4">
                                <!-- Visual Check Section -->
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <h5 class="font-bold text-sm">1. Visual Check</h5>
                                </div>

                                <!-- Environment Condition Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">a. Environment Condition</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Result:</label>
                                        <input type="text" id="environment_status_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="Contoh: Clean, No Dust" oninput="syncFromMobile('environment_status')">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="environment-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addEnvironmentPhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto Environment
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: Clean, No dust</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="environment_tegangan_mobile" class="w-full px-2 py-2 border border-gray-300 rounded text-sm" onchange="syncFromMobile('environment_tegangan')">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- LED Display Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">b. LED / Display</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Result:</label>
                                        <input type="text" id="led_status_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="Contoh: Normal" oninput="syncFromMobile('led_status')">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="led-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addLedPhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto LED
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: Normal</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="led_tegangan_mobile" class="w-full px-2 py-2 border border-gray-300 rounded text-sm" onchange="syncFromMobile('led_tegangan')">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Performance Check Section -->
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <h5 class="font-bold text-sm">2. Performance and Capacity Check</h5>
                                </div>

                                <!-- DC Input Voltage Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">a. DC Input Voltage</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Value (VDC):</label>
                                        <input type="number" step="0.01" id="dc_input_voltage_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="48.00" oninput="syncFromMobile('dc_input_voltage'); validateDcInputVoltage();">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="dc-voltage-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addDcVoltagePhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto DC Input Voltage
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: 48 - 54 VDC</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="status_dc_voltage_mobile" disabled
                                                class="w-full px-2 py-2 border border-gray-300 rounded text-sm bg-gray-100">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- DC Current Input Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">b. DC Current Input *)</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Select Inverter Type:</label>
                                        <select id="dc_current_type_mobile" class="w-full px-2 py-2 border border-gray-300 rounded text-sm" 
                                                onchange="syncFromMobile('dc_current_type'); saveDcCurrentType(); validateDcCurrentInput();">
                                            <option value="">-- Select Type --</option>
                                            <option value="500">500 VA</option>
                                            <option value="1000">1000 VA</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Value (A):</label>
                                        <input type="number" step="0.01" id="dc_current_input_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="Enter value" oninput="syncFromMobile('dc_current_input'); validateDcCurrentInput();">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="dc-current-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addDcCurrentPhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto DC Current Input
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: ≤ 9 A (500 VA) / ≤ 18 A (1000 VA)</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="status_dc_current_mobile" disabled
                                                class="w-full px-2 py-2 border border-gray-300 rounded text-sm bg-gray-100">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- AC Current Output Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">c. AC Current Output *)</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Select Inverter Type:</label>
                                        <select id="ac_current_type_mobile" class="w-full px-2 py-2 border border-gray-300 rounded text-sm" 
                                                onchange="syncFromMobile('ac_current_type'); saveAcCurrentType(); validateAcCurrentOutput();">
                                            <option value="">-- Select Type --</option>
                                            <option value="500">500 VA</option>
                                            <option value="1000">1000 VA</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Value (A):</label>
                                        <input type="number" step="0.01" id="ac_current_output_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="Enter value" oninput="syncFromMobile('ac_current_output'); validateAcCurrentOutput();">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="ac-current-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addAcCurrentPhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto AC Current Output
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: ≤ 2 A (500 VA) / ≤ 4 A (1000 VA)</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="status_ac_current_mobile" disabled
                                                class="w-full px-2 py-2 border border-gray-300 rounded text-sm bg-gray-100">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Neutral Ground Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">d. Neutral - Ground Output Voltage</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Value (V AC):</label>
                                        <input type="number" step="0.01" id="neutral_ground_output_voltage_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="1.00" oninput="syncFromMobile('neutral_ground_output_voltage'); validateNeutralGround();">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="neutral-ground-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addNeutralGroundPhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto Neutral - Ground
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: ≤ 1 Volt AC</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="status_neutral_ground_mobile" disabled
                                                class="w-full px-2 py-2 border border-gray-300 rounded text-sm bg-gray-100">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Equipment Temperature Card -->
                                <div class="border border-gray-300 rounded-lg p-3 space-y-3">
                                    <h6 class="font-semibold text-sm">e. Equipment Temperature</h6>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Value (°C):</label>
                                        <input type="number" step="0.01" id="equipment_temperature_mobile"
                                               class="w-full px-2 py-2 border border-gray-300 rounded text-sm"
                                               placeholder="30.00" oninput="syncFromMobile('equipment_temperature'); validateTemperature();">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Photo:</label>
                                        <div id="temperature-photos-container-mobile" class="space-y-3"></div>
                                        <button type="button" onclick="addTemperaturePhoto('mobile')" 
                                                class="w-full mt-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg">
                                            + Tambah Foto Equipment Temperature
                                        </button>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Standard: 0-35 °C</label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status:</label>
                                        <select id="status_temperature_mobile" disabled
                                                class="w-full px-2 py-2 border border-gray-300 rounded text-sm bg-gray-100">
                                            <option value="">-</option>
                                            <option value="OK">OK</option>
                                            <option value="NOK">NOK</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-gray-600 mt-3">*) Choose the appropriate inverter type</p>
                        </div>

                        <!-- Data Pelaksana -->
                        <div class="mb-6 sm:mb-8">
                            <h4 class="text-sm sm:text-md font-bold text-gray-700 border-b pb-2 mb-3 sm:mb-4">Data Pelaksana</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelaksana 1 - Nama <span class="text-red-500">*</span></label>
                                    <input type="text" name="pelaksana[0][nama]" value="{{ old('pelaksana.0.nama') }}" required
                                           placeholder="Nama pelaksana 1"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelaksana 1 - Perusahaan <span class="text-red-500">*</span></label>
                                    <input type="text" name="pelaksana[0][perusahaan]" value="{{ old('pelaksana.0.perusahaan') }}" required
                                           placeholder="Perusahaan pelaksana 1"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelaksana 2 - Nama <span class="text-xs text-gray-500">(Opsional)</span></label>
                                    <input type="text" name="pelaksana[1][nama]" value="{{ old('pelaksana.1.nama') }}"
                                           placeholder="Nama pelaksana 2"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelaksana 2 - Perusahaan <span class="text-xs text-gray-500">(Opsional)</span></label>
                                    <input type="text" name="pelaksana[1][perusahaan]" value="{{ old('pelaksana.1.perusahaan') }}"
                                           placeholder="Perusahaan pelaksana 2"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelaksana 3 - Nama <span class="text-xs text-gray-500">(Opsional)</span></label>
                                    <input type="text" name="pelaksana[2][nama]" value="{{ old('pelaksana.2.nama') }}"
                                           placeholder="Nama pelaksana 3"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelaksana 3 - Perusahaan <span class="text-xs text-gray-500">(Opsional)</span></label>
                                    <input type="text" name="pelaksana[2][perusahaan]" value="{{ old('pelaksana.2.perusahaan') }}"
                                           placeholder="Perusahaan pelaksana 3"
                                           class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-0 mt-6">
                            <a href="{{ route('inverter.index') }}" 
                               class="w-full sm:w-auto px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow text-center text-sm">
                                Kembali
                            </a>
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow text-sm">
                                Simpan Data Inverter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
// ==================== VALUE SYNCHRONIZATION ====================
// Fungsi untuk sync dari desktop ke mobile
function syncValue(baseId) {
    const desktopEl = document.getElementById(baseId);
    const mobileEl = document.getElementById(baseId + '_mobile');
    
    if (desktopEl && mobileEl) {
        mobileEl.value = desktopEl.value;
    }
}

// Fungsi untuk sync dari mobile ke desktop
function syncFromMobile(baseId) {
    const mobileEl = document.getElementById(baseId + '_mobile');
    const desktopEl = document.getElementById(baseId);
    
    if (mobileEl && desktopEl) {
        desktopEl.value = mobileEl.value;
    }
}

// ==================== CONFIGURATION ====================
const PHOTO_CONFIG = {
    size: 800,
    quality: 0.85
};

// counters
let environmentPhotoIndex = 0;
let ledPhotoIndex = 0;
let dcVoltagePhotoIndex = 0;
let dcCurrentPhotoIndex = 0;
let acCurrentPhotoIndex = 0;
let neutralGroundPhotoIndex = 0;
let temperaturePhotoIndex = 0;

// ==================== UTILITY: CROP TO SQUARE ====================
function cropToSquare(sourceCanvas) {
    const size = Math.min(sourceCanvas.width, sourceCanvas.height);
    const x = (sourceCanvas.width - size) / 2;
    const y = (sourceCanvas.height - size) / 2;
    
    const squareCanvas = document.createElement('canvas');
    squareCanvas.width = PHOTO_CONFIG.size;
    squareCanvas.height = PHOTO_CONFIG.size;
    const ctx = squareCanvas.getContext('2d');
    
    ctx.drawImage(
        sourceCanvas,
        x, y, size, size,
        0, 0, PHOTO_CONFIG.size, PHOTO_CONFIG.size
    );
    
    return squareCanvas;
}

// ==================== WATERMARK WITH GEOLOCATION (HANYA UNTUK KAMERA) ====================
async function addWatermarkToCanvas(canvas) {
    const ctx = canvas.getContext('2d');
    const timestamp = new Date();
    const formattedTime = timestamp.toLocaleString('id-ID');
    const hari = timestamp.toLocaleDateString('id-ID', { weekday: 'long' });

    let latitude = null;
    let longitude = null;
    let lokasiText = "Mengambil lokasi...";

    if (navigator.geolocation) {
        await new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(async pos => {
                latitude = pos.coords.latitude;
                longitude = pos.coords.longitude;

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`);
                    const data = await response.json();
                    lokasiText = data.display_name || 'Lokasi tidak diketahui';
                } catch {
                    lokasiText = "Gagal mengambil nama lokasi";
                }
                resolve();
            }, () => {
                lokasiText = "Lokasi tidak diizinkan";
                resolve();
            }, { enableHighAccuracy: true, timeout: 7000, maximumAge: 0 });
        });
    } else {
        lokasiText = "Geolokasi tidak didukung";
    }

    // Draw watermark
    const padding = 12;
    const fontSize = Math.max(14, canvas.width / 50);
    ctx.font = `bold ${fontSize}px Arial`;
    ctx.fillStyle = "rgba(0,0,0,0.6)";
    ctx.fillRect(0, canvas.height - fontSize * 5.5, canvas.width, fontSize * 5.5);
    ctx.fillStyle = "white";

    ctx.fillText(`📍 ${lokasiText}`, padding, canvas.height - fontSize * 4);
    ctx.fillText(`🕓 ${hari}, ${formattedTime}`, padding, canvas.height - fontSize * 2.5);
    ctx.fillText(`🌐 Lat: ${latitude?.toFixed(5) || '-'}, Lng: ${longitude?.toFixed(5) || '-'}`, padding, canvas.height - fontSize);

    return {
        latitude,
        longitude,
        timestamp: timestamp.toISOString(),
        locationText: lokasiText,
        formattedTime,
        hari
    };
}

// ==================== EXIF DATA READER ====================
function getExifData(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const view = new DataView(e.target.result);
            if (view.getUint16(0, false) != 0xFFD8) {
                resolve(null);
                return;
            }
            
            const length = view.byteLength;
            let offset = 2;
            
            while (offset < length) {
                if (view.getUint16(offset + 2, false) <= 8) {
                    resolve(null);
                    return;
                }
                const marker = view.getUint16(offset, false);
                offset += 2;
                
                if (marker == 0xFFE1) {
                    const exifOffset = offset + 10;
                    const little = view.getUint16(exifOffset) == 0x4949;
                    
                    try {
                        let lat = null, lng = null;
                        const tags = view.getUint16(exifOffset + 8, little);
                        
                        for (let i = 0; i < tags; i++) {
                            const tagOffset = exifOffset + 12 + (i * 12);
                            const tag = view.getUint16(tagOffset, little);
                            
                            if (tag === 0x0002) {
                                const latOffset = exifOffset + view.getUint32(tagOffset + 8, little);
                                const d = view.getUint32(latOffset, little) / view.getUint32(latOffset + 4, little);
                                const m = view.getUint32(latOffset + 8, little) / view.getUint32(latOffset + 12, little);
                                const s = view.getUint32(latOffset + 16, little) / view.getUint32(latOffset + 20, little);
                                lat = d + m / 60 + s / 3600;
                            }
                            
                            if (tag === 0x0004) {
                                const lngOffset = exifOffset + view.getUint32(tagOffset + 8, little);
                                const d = view.getUint32(lngOffset, little) / view.getUint32(lngOffset + 4, little);
                                const m = view.getUint32(lngOffset + 8, little) / view.getUint32(lngOffset + 12, little);
                                const s = view.getUint32(lngOffset + 16, little) / view.getUint32(lngOffset + 20, little);
                                lng = d + m / 60 + s / 3600;
                            }
                        }
                        
                        if (lat && lng) {
                            resolve({ latitude: lat, longitude: lng });
                            return;
                        }
                    } catch (e) {
                        console.log('Error parsing EXIF:', e);
                    }
                }
                
                offset += view.getUint16(offset, false);
            }
            
            resolve(null);
        };
        reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
    });
}

// ==================== CREATE PHOTO COMPONENT (NEW FORMAT 1:1) ====================
function createPhotoComponent(description, dataIndex, photoIndex) {
    const div = document.createElement('div');
    div.className = 'border-2 border-dashed border-gray-300 rounded-lg p-3 bg-white relative photo-component';
    div.innerHTML = `
        <button type="button" class="remove-photo absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-lg font-bold z-10 shadow-md">×</button>
        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Foto ${description} #${photoIndex + 1}</label>
        
        <!-- Pilihan Metode Input -->
        <div class="method-buttons flex gap-3 mb-4 justify-center">
            <button type="button" class="method-camera px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">📷 Kamera</button>
            <button type="button" class="method-upload px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg">📁 Upload</button>
        </div>

        <!-- Area Kamera -->
        <div class="camera-area hidden">
            <video class="camera-preview w-full h-48 bg-black rounded-lg mb-2" autoplay playsinline muted></video>
            <div class="flex gap-2 justify-center mb-2">
                <button type="button" class="capture-photo px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg shadow">✓ Ambil Foto</button>
                <button type="button" class="cancel-camera px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-semibold rounded-lg shadow">Batal</button>
            </div>
        </div>

        <!-- Area Upload -->
        <div class="upload-area hidden">
            <input type="file" class="file-input hidden" accept="image/*">
            <div class="border-2 border-dashed border-blue-400 rounded-lg p-6 text-center cursor-pointer hover:bg-blue-50 transition upload-trigger">
                <p class="text-gray-600 text-sm">Klik untuk memilih foto</p>
                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max 10MB)</p>
            </div>
            <button type="button" class="cancel-upload mt-3 px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-semibold rounded-lg shadow">Batal</button>
        </div>

        <!-- Preview Hasil - FOTO 1:1 SQUARE -->
        <img class="captured-image w-full aspect-square object-cover rounded-lg mb-2 hidden" alt="Captured">
        <canvas class="hidden"></canvas>
        <button type="button" class="retake-photo hidden px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg block mx-auto">↻ Foto Ulang</button>
        
        <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-2"></div>
        <input type="hidden" name="data_inverter[${dataIndex}][photos][${photoIndex}][photo_data]">
        <input type="hidden" name="data_inverter[${dataIndex}][photos][${photoIndex}][photo_latitude]">
        <input type="hidden" name="data_inverter[${dataIndex}][photos][${photoIndex}][photo_longitude]">
        <input type="hidden" name="data_inverter[${dataIndex}][photos][${photoIndex}][photo_timestamp]">
    `;
    return div;
}

// ==================== ADD PHOTO FUNCTIONS ====================
function addEnvironmentPhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'environment-photos-container-mobile' : 'environment-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('Environment Condition', 0, environmentPhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    environmentPhotoIndex++;
}

function addLedPhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'led-photos-container-mobile' : 'led-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('LED Display', 1, ledPhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    ledPhotoIndex++;
}

function addDcVoltagePhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'dc-voltage-photos-container-mobile' : 'dc-voltage-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('DC Input Voltage', 2, dcVoltagePhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    dcVoltagePhotoIndex++;
}

function addDcCurrentPhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'dc-current-photos-container-mobile' : 'dc-current-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('DC Current Input', 3, dcCurrentPhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    dcCurrentPhotoIndex++;
}

function addAcCurrentPhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'ac-current-photos-container-mobile' : 'ac-current-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('AC Current Output', 4, acCurrentPhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    acCurrentPhotoIndex++;
}

function addNeutralGroundPhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'neutral-ground-photos-container-mobile' : 'neutral-ground-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('Neutral - Ground Output Voltage', 5, neutralGroundPhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    neutralGroundPhotoIndex++;
}

function addTemperaturePhoto(mode = 'desktop') {
    const containerId = mode === 'mobile' ? 'temperature-photos-container-mobile' : 'temperature-photos-container';
    const container = document.getElementById(containerId);
    const photoDiv = createPhotoComponent('Equipment Temperature', 6, temperaturePhotoIndex);
    container.appendChild(photoDiv);
    setupCameraHandlers(photoDiv);
    temperaturePhotoIndex++;
}

// ==================== SETUP CAMERA HANDLERS (UPDATED) ====================
function setupCameraHandlers(container) {
    if (!container) return;

    const video = container.querySelector('.camera-preview');
    const img = container.querySelector('.captured-image');
    const canvas = container.querySelector('canvas');
    const cameraArea = container.querySelector('.camera-area');
    const uploadArea = container.querySelector('.upload-area');
    const methodButtons = container.querySelector('.method-buttons');
    const fileInput = container.querySelector('.file-input');
    const uploadTrigger = container.querySelector('.upload-trigger');
    
    const methodCamera = container.querySelector('.method-camera');
    const methodUpload = container.querySelector('.method-upload');
    const captureBtn = container.querySelector('.capture-photo');
    const cancelCamera = container.querySelector('.cancel-camera');
    const cancelUpload = container.querySelector('.cancel-upload');
    const retakeBtn = container.querySelector('.retake-photo');
    const photoInfo = container.querySelector('.photo-info');
    
    const photoDataInput = container.querySelector('input[name$="[photo_data]"]');
    const latInput = container.querySelector('input[name$="[photo_latitude]"]');
    const lngInput = container.querySelector('input[name$="[photo_longitude]"]');
    const timeInput = container.querySelector('input[name$="[photo_timestamp]"]');

    let currentStream = null;

    // Remove photo button
    container.querySelector('.remove-photo').addEventListener('click', function() {
        if (confirm('Hapus foto ini?')) {
            if (currentStream) {
                currentStream.getTracks().forEach(t => t.stop());
            }
            container.remove();
        }
    });

    // Show camera
    methodCamera.addEventListener('click', async () => {
        try {
            currentStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment',
                    width: { ideal: 1920 },
                    height: { ideal: 1080 }
                },
                audio: false
            });
            video.srcObject = currentStream;
            methodButtons.classList.add('hidden');
            cameraArea.classList.remove('hidden');
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Gagal membuka kamera: ' + err.message);
        }
    });

    // Show upload
    methodUpload.addEventListener('click', () => {
        methodButtons.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    });

    // Cancel camera
    cancelCamera.addEventListener('click', () => {
        if (currentStream) {
            currentStream.getTracks().forEach(t => t.stop());
            currentStream = null;
        }
        video.srcObject = null;
        cameraArea.classList.add('hidden');
        methodButtons.classList.remove('hidden');
    });

    // Cancel upload
    cancelUpload.addEventListener('click', () => {
        uploadArea.classList.add('hidden');
        methodButtons.classList.remove('hidden');
    });

    // Capture from camera (DENGAN WATERMARK)
    captureBtn.addEventListener('click', async () => {
        if (!video || !video.videoWidth) {
            photoInfo.innerHTML = '❌ Tidak ada gambar dari kamera.';
            return;
        }

        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = video.videoWidth;
        tempCanvas.height = video.videoHeight;
        const tempCtx = tempCanvas.getContext('2d');
        tempCtx.drawImage(video, 0, 0);

        if (currentStream) {
            currentStream.getTracks().forEach(t => t.stop());
            currentStream = null;
        }
        video.srcObject = null;
        cameraArea.classList.add('hidden');

        const squareCanvas = cropToSquare(tempCanvas);
        const metadata = await addWatermarkToCanvas(squareCanvas);
        displayFinalImage(squareCanvas, metadata);
    });

    // Upload file click trigger
    if (uploadTrigger) {
        uploadTrigger.addEventListener('click', () => {
            fileInput.click();
        });
    }

    // Handle file upload (TANPA WATERMARK)
    if (fileInput) {
        fileInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const exifData = await getExifData(file);
            const timestamp = new Date();

            const reader = new FileReader();
            reader.onload = async function(event) {
                const tempImg = new Image();
                tempImg.onload = async function() {
                    const tempCanvas = document.createElement('canvas');
                    tempCanvas.width = tempImg.width;
                    tempCanvas.height = tempImg.height;
                    const tempCtx = tempCanvas.getContext('2d');
                    tempCtx.drawImage(tempImg, 0, 0);

                    const squareCanvas = cropToSquare(tempCanvas);

                    // Metadata tanpa watermark
                    const metadata = {
                        latitude: exifData?.latitude || null,
                        longitude: exifData?.longitude || null,
                        timestamp: timestamp.toISOString(),
                        locationText: exifData?.latitude && exifData?.longitude 
                            ? `${exifData.latitude.toFixed(5)}, ${exifData.longitude.toFixed(5)}` 
                            : 'Tidak ada data lokasi',
                        formattedTime: timestamp.toLocaleString('id-ID'),
                        hari: timestamp.toLocaleDateString('id-ID', { weekday: 'long' })
                    };

                    uploadArea.classList.add('hidden');
                    displayFinalImage(squareCanvas, metadata);
                    fileInput.value = '';
                };
                tempImg.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    // Drag & drop
    if (uploadTrigger) {
        uploadTrigger.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadTrigger.classList.add('bg-blue-100');
        });

        uploadTrigger.addEventListener('dragleave', () => {
            uploadTrigger.classList.remove('bg-blue-100');
        });

        uploadTrigger.addEventListener('drop', async (e) => {
            e.preventDefault();
            uploadTrigger.classList.remove('bg-blue-100');

            const file = e.dataTransfer.files[0];
            if (!file || !file.type.startsWith('image/')) {
                alert('File harus berupa gambar');
                return;
            }

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        });
    }

    // Retake photo
    retakeBtn.addEventListener('click', () => {
        if (photoDataInput) photoDataInput.value = '';
        if (latInput) latInput.value = '';
        if (lngInput) lngInput.value = '';
        if (timeInput) timeInput.value = '';

        img.src = '';
        img.classList.add('hidden');
        retakeBtn.classList.add('hidden');
        methodButtons.classList.remove('hidden');
        photoInfo.innerHTML = '';
    });

    function displayFinalImage(canvas, metadata) {
        const photoData = canvas.toDataURL('image/jpeg', PHOTO_CONFIG.quality);

        img.src = photoData;
        img.classList.remove('hidden');
        retakeBtn.classList.remove('hidden');

        if (photoDataInput) photoDataInput.value = photoData;
        if (latInput) latInput.value = metadata.latitude || '';
        if (lngInput) lngInput.value = metadata.longitude || '';
        if (timeInput) timeInput.value = metadata.timestamp;

        photoInfo.innerHTML = `
            📍 <strong>${metadata.locationText}</strong><br>
            🕓 ${metadata.hari}, ${metadata.formattedTime}<br>
            🌐 ${metadata.latitude?.toFixed(5) || '-'}, ${metadata.longitude?.toFixed(5) || '-'}
        `;
    }
}

// ==================== VALIDATION FUNCTIONS ====================
function setStatus(selectElement, isValid) {
    selectElement.disabled = false;
    if (isValid === true) {
        selectElement.value = 'OK';
        selectElement.classList.remove('bg-gray-100');
    } else if (isValid === false) {
        selectElement.value = 'NOK';
        selectElement.classList.remove('bg-gray-100');
    } else {
        selectElement.value = '';
        selectElement.disabled = true;
        selectElement.classList.add('bg-gray-100');
    }
    
    // Sync ke versi mobile/desktop
    const baseId = selectElement.id.replace('_mobile', '');
    syncStatusFields(baseId);
}

function syncStatusFields(baseId) {
    const desktopEl = document.getElementById(baseId);
    const mobileEl = document.getElementById(baseId + '_mobile');
    
    if (desktopEl && mobileEl) {
        mobileEl.value = desktopEl.value;
        mobileEl.disabled = desktopEl.disabled;
        if (desktopEl.disabled) {
            mobileEl.classList.add('bg-gray-100');
        } else {
            mobileEl.classList.remove('bg-gray-100');
        }
    }
}

function validateDcInputVoltage() {
    const input = document.getElementById('dc_input_voltage');
    const statusSelect = document.getElementById('status_dc_voltage');
    const value = parseFloat(input?.value);
    if (!statusSelect) return;
    if (isNaN(value)) { setStatus(statusSelect, null); }
    else { setStatus(statusSelect, value >= 48 && value <= 54); }
}

function validateDcCurrentInput() {
    const input = document.getElementById('dc_current_input');
    const typeSelect = document.getElementById('dc_current_type');
    const statusSelect = document.getElementById('status_dc_current');
    const value = parseFloat(input?.value);
    const type = typeSelect?.value;
    if (!statusSelect) return;
    if (isNaN(value) || !type) { setStatus(statusSelect, null); return; }
    let isValid = false;
    if (type === '500') isValid = value <= 9;
    else if (type === '1000') isValid = value <= 18;
    setStatus(statusSelect, isValid);
}

function validateAcCurrentOutput() {
    const input = document.getElementById('ac_current_output');
    const typeSelect = document.getElementById('ac_current_type');
    const statusSelect = document.getElementById('status_ac_current');
    const value = parseFloat(input?.value);
    const type = typeSelect?.value;
    if (!statusSelect) return;
    if (isNaN(value) || !type) { setStatus(statusSelect, null); return; }
    let isValid = false;
    if (type === '500') isValid = value <= 2;
    else if (type === '1000') isValid = value <= 4;
    setStatus(statusSelect, isValid);
}

function validateNeutralGround() {
    const input = document.getElementById('neutral_ground_output_voltage');
    const statusSelect = document.getElementById('status_neutral_ground');
    const value = parseFloat(input?.value);
    if (!statusSelect) return;
    if (isNaN(value)) { setStatus(statusSelect, null); }
    else { setStatus(statusSelect, value <= 1); }
}

function validateTemperature() {
    const input = document.getElementById('equipment_temperature');
    const statusSelect = document.getElementById('status_temperature');
    const value = parseFloat(input?.value);
    if (!statusSelect) return;
    if (isNaN(value)) { setStatus(statusSelect, null); }
    else { setStatus(statusSelect, value >= 0 && value <= 35); }
}

function saveDcCurrentType() {
    const typeDesktop = document.getElementById('dc_current_type');
    const typeMobile = document.getElementById('dc_current_type_mobile');
    const type = typeDesktop?.value || typeMobile?.value;
    
    // Sync antar desktop dan mobile
    if (typeDesktop && typeMobile) {
        typeDesktop.value = type;
        typeMobile.value = type;
    }
    
    const hiddenInput = document.getElementById('dc_current_inverter_type');
    if (hiddenInput) hiddenInput.value = type;
    localStorage.setItem('dc_current_inverter_type', type);
}

function saveAcCurrentType() {
    const typeDesktop = document.getElementById('ac_current_type');
    const typeMobile = document.getElementById('ac_current_type_mobile');
    const type = typeDesktop?.value || typeMobile?.value;
    
    // Sync antar desktop dan mobile
    if (typeDesktop && typeMobile) {
        typeDesktop.value = type;
        typeMobile.value = type;
    }
    
    const hiddenInput = document.getElementById('ac_current_inverter_type');
    if (hiddenInput) hiddenInput.value = type;
    localStorage.setItem('ac_current_inverter_type', type);
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.photo-component').forEach(setupCameraHandlers);

    const savedDcType = localStorage.getItem('dc_current_inverter_type');
    const savedAcType = localStorage.getItem('ac_current_inverter_type');
    
    if (savedDcType) {
        const dcDesktop = document.getElementById('dc_current_type');
        const dcMobile = document.getElementById('dc_current_type_mobile');
        if (dcDesktop) dcDesktop.value = savedDcType;
        if (dcMobile) dcMobile.value = savedDcType;
        const hiddenDc = document.getElementById('dc_current_inverter_type');
        if (hiddenDc) hiddenDc.value = savedDcType;
    }
    if (savedAcType) {
        const acDesktop = document.getElementById('ac_current_type');
        const acMobile = document.getElementById('ac_current_type_mobile');
        if (acDesktop) acDesktop.value = savedAcType;
        if (acMobile) acMobile.value = savedAcType;
        const hiddenAc = document.getElementById('ac_current_inverter_type');
        if (hiddenAc) hiddenAc.value = savedAcType;
    }

    validateDcInputVoltage();
    validateDcCurrentInput();
    validateAcCurrentOutput();
    validateNeutralGround();
    validateTemperature();
});
</script>
</x-app-layout>

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
const PHOTO_SCALE = {
    widthRatio: 85 / 210,
    heightRatio: 50 / 297,
    dpi: 300,
    a4WidthPx: Math.round((210 / 25.4) * 300),
    a4HeightPx: Math.round((297 / 25.4) * 300),
    get photoWidthPx() { return Math.round(this.a4WidthPx * this.widthRatio); },
    get photoHeightPx() { return Math.round(this.a4HeightPx * this.heightRatio); }
};

// counters
let environmentPhotoIndex = 0;
let ledPhotoIndex = 0;
let dcVoltagePhotoIndex = 0;
let dcCurrentPhotoIndex = 0;
let acCurrentPhotoIndex = 0;
let neutralGroundPhotoIndex = 0;
let temperaturePhotoIndex = 0;

// ==================== UTILITY: CROP & RESIZE ====================
function cropAndResizePhoto(sourceCanvas, targetWidth, targetHeight) {
    const sourceWidth = sourceCanvas.width;
    const sourceHeight = sourceCanvas.height;
    const sourceAspect = sourceWidth / sourceHeight;
    const targetAspect = targetWidth / targetHeight;
    
    let cropWidth, cropHeight, cropX, cropY;
    
    if (sourceAspect > targetAspect) {
        cropHeight = sourceHeight;
        cropWidth = sourceHeight * targetAspect;
        cropX = (sourceWidth - cropWidth) / 2;
        cropY = 0;
    } else {
        cropWidth = sourceWidth;
        cropHeight = sourceWidth / targetAspect;
        cropX = 0;
        cropY = (sourceHeight - cropHeight) / 2;
    }
    
    const croppedCanvas = document.createElement('canvas');
    croppedCanvas.width = targetWidth;
    croppedCanvas.height = targetHeight;
    const ctx = croppedCanvas.getContext('2d');
    
    ctx.drawImage(sourceCanvas, cropX, cropY, cropWidth, cropHeight, 0, 0, targetWidth, targetHeight);
    return croppedCanvas;
}

// ==================== CREATE PHOTO COMPONENT (reusable) ====================
function createPhotoComponent(description, dataIndex, photoIndex) {
    const div = document.createElement('div');
    div.className = 'border-2 border-dashed border-gray-300 rounded-lg p-3 bg-white relative photo-component';
    div.innerHTML = `
        <button type="button" class="remove-photo absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-lg font-bold z-10 shadow-md">×</button>
        <label class="block text-xs font-semibold text-gray-700 mb-2">Foto ${description} #${photoIndex + 1}</label>
        <video class="camera-preview w-full h-48 bg-black rounded-lg mb-2 hidden object-cover" autoplay playsinline muted></video>
        <img class="captured-image w-full h-auto max-h-64 rounded-lg mb-2 hidden" alt="Captured">
        <canvas class="hidden"></canvas>
        <div class="flex flex-wrap gap-2 justify-center mb-2">
            <button type="button" class="start-camera px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg shadow">📷 Buka Kamera</button>
            <button type="button" class="capture-photo hidden px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg shadow">✓ Ambil Foto</button>
            <button type="button" class="retake-photo hidden px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg shadow">↻ Foto Ulang</button>
        </div>
        <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mb-2"></div>
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

// ==================== CAMERA HANDLERS ====================
function setupCameraHandlers(container) {
    if (!container) return;

    const video = container.querySelector('.camera-preview');
    const img = container.querySelector('.captured-image');
    const canvas = container.querySelector('canvas');
    const startBtn = container.querySelector('.start-camera');
    const captureBtn = container.querySelector('.capture-photo');
    const retakeBtn = container.querySelector('.retake-photo');
    const photoInfo = container.querySelector('.photo-info');
    const photoDataInput = container.querySelector('input[name$="[photo_data]"]');
    const latInput = container.querySelector('input[name$="[photo_latitude]"]');
    const lngInput = container.querySelector('input[name$="[photo_longitude]"]');
    const timeInput = container.querySelector('input[name$="[photo_timestamp]"]');

    let currentStream = null;

    // remove photo button
    container.querySelector('.remove-photo').addEventListener('click', function() {
        if (confirm('Hapus foto ini?')) {
            if (currentStream) {
                currentStream.getTracks().forEach(t => t.stop());
            }
            container.remove();
        }
    });

    startBtn.addEventListener('click', async () => {
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
            video.classList.remove('hidden');
            img.classList.add('hidden');
            startBtn.classList.add('hidden');
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            photoInfo.innerHTML = '📷 Kamera aktif. Arahkan ke objek dan tekan Ambil Foto.';
        } catch (err) {
            console.error('Error accessing camera:', err);
            photoInfo.innerHTML = `❌ Error: ${err.message}`;
            alert('Gagal membuka kamera: ' + err.message);
        }
    });

    captureBtn.addEventListener('click', () => {
        if (!video || !video.videoWidth) {
            photoInfo.innerHTML = '❌ Tidak ada gambar dari kamera.';
            return;
        }

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        if (currentStream) {
            currentStream.getTracks().forEach(t => t.stop());
            currentStream = null;
        }
        video.srcObject = null;

        const finalCanvas = cropAndResizePhoto(canvas, PHOTO_SCALE.photoWidthPx, PHOTO_SCALE.photoHeightPx);
        const ctxFinal = finalCanvas.getContext('2d');

        const timestamp = new Date();
        const formattedTime = timestamp.toLocaleString('id-ID');
        const hari = timestamp.toLocaleDateString('id-ID', { weekday: 'long' });

        let latitude = null, longitude = null;
        let lokasiText = 'Mengambil lokasi...';

        function drawTextToCanvas() {
            const padding = 12;
            const barHeight = 96;
            const fontSize = Math.round(finalCanvas.height * 0.035);
            ctxFinal.fillStyle = "rgba(0,0,0,0.65)";
            ctxFinal.fillRect(0, finalCanvas.height - barHeight, finalCanvas.width, barHeight);

            ctxFinal.fillStyle = "white";
            ctxFinal.font = `bold ${fontSize}px Arial`;
            ctxFinal.textBaseline = 'top';

            const maxWidth = finalCanvas.width - padding*2;
            const lines = wrapTextArray(ctxFinal, `📍 ${lokasiText}`, maxWidth);
            let y = finalCanvas.height - barHeight + 8;
            lines.forEach((line) => {
                ctxFinal.fillText(line, padding, y);
                y += fontSize + 4;
            });

            ctxFinal.fillText(`🕓 ${hari}, ${formattedTime}`, padding, y);
            y += fontSize + 4;
            ctxFinal.fillText(`🌐 Lat: ${latitude ? latitude.toFixed(5) : '-'}, Lng: ${longitude ? longitude.toFixed(5) : '-'}`, padding, y);
        }

        function saveAndDisplay() {
            drawTextToCanvas();
            const photoData = finalCanvas.toDataURL('image/jpeg', 0.85);
            img.src = photoData;
            img.classList.remove('hidden');
            video.classList.add('hidden');
            captureBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');

            if (photoDataInput) photoDataInput.value = photoData;
            if (latInput) latInput.value = latitude || '';
            if (lngInput) lngInput.value = longitude || '';
            if (timeInput) timeInput.value = timestamp.toISOString();

            photoInfo.innerHTML = `
                📍 <strong>${lokasiText}</strong><br>
                🕓 ${hari}, ${formattedTime}<br>
                🌐 ${latitude ? latitude.toFixed(5) : '-'}, ${longitude ? longitude.toFixed(5) : '-'}
            `;
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async (pos) => {
                latitude = pos.coords.latitude;
                longitude = pos.coords.longitude;

                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`);
                    if (res.ok) {
                        const data = await res.json();
                        lokasiText = data.display_name || `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
                    } else {
                        lokasiText = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
                    }
                } catch (err) {
                    lokasiText = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
                }

                saveAndDisplay();
            }, (err) => {
                lokasiText = 'Lokasi tidak diizinkan';
                saveAndDisplay();
            }, { enableHighAccuracy: true, timeout: 7000, maximumAge: 0 });
        } else {
            lokasiText = 'Geolocation tidak didukung';
            saveAndDisplay();
        }
    });

    retakeBtn.addEventListener('click', () => {
        if (photoDataInput) photoDataInput.value = '';
        if (latInput) latInput.value = '';
        if (lngInput) lngInput.value = '';
        if (timeInput) timeInput.value = '';

        img.src = '';
        img.classList.add('hidden');
        captureBtn.classList.add('hidden');
        retakeBtn.classList.add('hidden');
        startBtn.classList.remove('hidden');
        photoInfo.innerHTML = '🔄 Siap mengambil foto ulang.';
    });
}

function wrapTextArray(ctx, text, maxWidth) {
    const words = text.split(' ');
    const lines = [];
    let current = '';
    for (let i=0;i<words.length;i++){
        const test = current ? (current + ' ' + words[i]) : words[i];
        const w = ctx.measureText(test).width;
        if (w > maxWidth && current) {
            lines.push(current);
            current = words[i];
        } else {
            current = test;
        }
    }
    if (current) lines.push(current);
    return lines;
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

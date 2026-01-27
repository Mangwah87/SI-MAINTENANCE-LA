<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                Edit Form Preventive Maintenance Battery
            </h2>
            <a href="{{ route('battery.show', $maintenance->id) }}"
                class="inline-flex items-center px-3 sm:px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm sm:text-base font-semibold rounded-lg transition-colors duration-200 w-full sm:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('battery.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data" id="mainForm">
                @csrf
                @method('PUT')

                <!-- Informasi Umum -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-500 to-blue-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                                <select name="location" id="location-select-edit" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    <option value="">-- Pilih Location --</option>
                                    @foreach($centralsByArea as $area => $centrals)
                                        <optgroup label="AREA {{ $area }}">
                                            @foreach($centrals as $central)
                                                <option value="{{ $central->id }}"
                                                    {{ old('location', $maintenance->location) == $central->id ? 'selected' : '' }}>
                                                    {{ $central->id_sentral }} - {{ $central->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-600">Pilih lokasi central dari daftar</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                                <input type="datetime-local" name="maintenance_date"
                                    value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d\TH:i')) }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Temperature (°C)</label>
                                <input type="number" step="0.1" name="battery_temperature"
                                    value="{{ old('battery_temperature', $maintenance->battery_temperature) }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Contoh: 25.5">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Company</label>
                                <input type="text" name="company"
                                    value="{{ old('company', $maintenance->company ?? 'PT. Aplikarusa Lintasarta') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Nama Perusahaan">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Brand *</label>
                                <input type="text" name="battery_brand" id="main_battery_brand"
                                    value="{{ old('battery_brand', $maintenance->readings->first()->battery_brand ?? 'Ritar') }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Contoh: Ritar, Yuasa, Panasonic">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Type</label>
                                <input type="text" name="battery_type" id="main_battery_type"
                                    value="{{ old('battery_type', $maintenance->readings->first()->battery_type ?? 'VRLA') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Contoh: VRLA, AGM, Gel">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">End Device Battery</label>
                                <input type="text" name="end_device_batt" id="main_end_device_batt"
                                    value="{{ old('end_device_batt', $maintenance->readings->first()->end_device_batt ?? '') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Contoh: UPS, Rectifier, Radio">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                                <textarea name="notes" rows="4"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Catatan tambahan atau informasi penting lainnya...">{{ old('notes', $maintenance->notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rectifier Switching Test -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Rectifier Switching Test</h3>
                        <p class="text-xs text-gray-600 mt-1">From main source (PLN) to backup mode, by turning off Rectifier input MCB</p>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Voltage on Backup Mode (VDC)</label>
                                <input type="number" step="0.01" name="rectifier_test_backup_voltage"
                                    value="{{ old('rectifier_test_backup_voltage', $maintenance->rectifier_test_backup_voltage) }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="49.00">
                                <p class="mt-1 text-xs text-gray-500">Operational Standard: Min 49 VDC</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="rectifier_test_backup_voltage_status"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    <option value="">-- Select Status --</option>
                                    <option value="OK" {{ old('rectifier_test_backup_voltage_status', $maintenance->rectifier_test_backup_voltage_status ?? '') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NOK" {{ old('rectifier_test_backup_voltage_status', $maintenance->rectifier_test_backup_voltage_status ?? '') == 'NOK' ? 'selected' : '' }}>NOK (Not OK)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Measurement I (at the beginning)</label>
                                <input type="number" step="0.01" name="rectifier_test_measurement_1"
                                    value="{{ old('rectifier_test_measurement_1', $maintenance->rectifier_test_measurement_1) }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="59.00">
                                <p class="mt-1 text-xs text-gray-500">Operational Standard: Min 49 VDC</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="rectifier_test_measurement_1_status"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    <option value="">-- Select Status --</option>
                                    <option value="OK" {{ old('rectifier_test_measurement_1_status', $maintenance->rectifier_test_measurement_1_status ?? '') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NOK" {{ old('rectifier_test_measurement_1_status', $maintenance->rectifier_test_measurement_1_status ?? '') == 'NOK' ? 'selected' : '' }}>NOK (Not OK)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Measurement II (15th minutes)</label>
                                <input type="number" step="0.01" name="rectifier_test_measurement_2"
                                    value="{{ old('rectifier_test_measurement_2', $maintenance->rectifier_test_measurement_2) }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="48.00">
                                <p class="mt-1 text-xs text-gray-500">Operational Standard: Min 48 VDC</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="rectifier_test_measurement_2_status"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    <option value="">-- Select Status --</option>
                                    <option value="OK" {{ old('rectifier_test_measurement_2_status', $maintenance->rectifier_test_measurement_2_status ?? '') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NOK" {{ old('rectifier_test_measurement_2_status', $maintenance->rectifier_test_measurement_2_status ?? '') == 'NOK' ? 'selected' : '' }}>NOK (Not OK)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pelaksana & Verifikasi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-50 to-teal-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Data Pelaksana & Verifikasi</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-4">
                            <!-- Executor / Pelaksana -->
                            <div class="border-2 border-blue-200 rounded-lg p-4">
                                <h4 class="text-md font-bold text-blue-700 mb-3">Executor (Pelaksana)</h4>

                                <!-- Pelaksana 1 -->
                                <div class="mb-4 pb-4 border-b">
                                    <h5 class="text-sm font-bold text-gray-700 mb-3">Pelaksana #1 *</h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                                            <input type="text" name="technician_1_name"
                                                value="{{ old('technician_1_name', $maintenance->technician_1_name) }}" required
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama pelaksana 1">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra / Internal *</label>
                                            <input type="text" name="technician_1_company"
                                                value="{{ old('technician_1_company', $maintenance->technician_1_company) }}" required
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama perusahaan">
                                        </div>
                                    </div>
                                </div>

                                <!-- Pelaksana 2 -->
                                <div class="mb-4 pb-4 border-b">
                                    <h5 class="text-sm font-bold text-gray-700 mb-3">Pelaksana #2 (Opsional)</h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                            <input type="text" name="technician_2_name"
                                                value="{{ old('technician_2_name', $maintenance->technician_2_name) }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama pelaksana 2">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra / Internal</label>
                                            <input type="text" name="technician_2_company"
                                                value="{{ old('technician_2_company', $maintenance->technician_2_company) }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama perusahaan">
                                        </div>
                                    </div>
                                </div>

                                <!-- Pelaksana 3 -->
                                <div class="mb-4 pb-4 border-b">
                                    <h5 class="text-sm font-bold text-gray-700 mb-3">Pelaksana #3 (Opsional)</h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                            <input type="text" name="technician_3_name"
                                                value="{{ old('technician_3_name', $maintenance->technician_3_name) }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama pelaksana 3">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra / Internal</label>
                                            <input type="text" name="technician_3_company"
                                                value="{{ old('technician_3_company', $maintenance->technician_3_company) }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama perusahaan">
                                        </div>
                                    </div>
                                </div>

                                <!-- Pelaksana 4 -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-700 mb-3">Pelaksana #4 (Opsional)</h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                            <input type="text" name="technician_4_name"
                                                value="{{ old('technician_4_name', $maintenance->technician_4_name) }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama pelaksana 4">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra / Internal</label>
                                            <input type="text" name="technician_4_company"
                                                value="{{ old('technician_4_company', $maintenance->technician_4_company) }}"
                                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                                placeholder="Nama perusahaan">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Verifikator -->
                            <div class="border-2 border-green-200 rounded-lg p-4">
                                <h4 class="text-md font-bold text-green-700 mb-3">Verifikator</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Verifikator</label>
                                        <input type="text" name="verifikator_name"
                                            value="{{ old('verifikator_name', $maintenance->verifikator_name) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                            placeholder="Nama yang memverifikasi">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                                        <input type="text" name="verifikator_nim"
                                            value="{{ old('verifikator_nim', $maintenance->verifikator_nim) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                            placeholder="Nomor Identitas Verifikator">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra / Internal</label>
                                        <input type="text" name="verifikator_company"
                                            value="{{ old('verifikator_company', $maintenance->verifikator_company) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                            placeholder="Perusahaan verifikator">
                                    </div>
                                </div>
                            </div>

                            <!-- Head of Sub Department -->
                            <div class="border-2 border-purple-200 rounded-lg p-4">
                                <h4 class="text-md font-bold text-purple-700 mb-3">Head of Sub Department</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kepala Sub Departemen</label>
                                        <input type="text" name="head_of_sub_dept"
                                            value="{{ old('head_of_sub_dept', $maintenance->head_of_sub_dept) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                            placeholder="Nama kepala sub departemen (opsional)">
                                        <p class="mt-1 text-xs text-gray-600 italic">Kosongkan jika tidak ada</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                                        <input type="text" name="head_of_sub_dept_nim"
                                            value="{{ old('head_of_sub_dept_nim', $maintenance->head_of_sub_dept_nim) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                            placeholder="Nomor Identitas Kepala">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Battery Configuration -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Konfigurasi Battery</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <p class="text-sm text-yellow-700">
                                <strong>⚠️ Perhatian:</strong> Jika Anda generate ulang, semua data battery yang sudah ada akan diganti dengan konfigurasi baru.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Bank *</label>
                                <input type="number" id="total_banks" min="1" value="{{ old('total_banks', $maintenance->readings->max('bank_number') ?? 1) }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Contoh: 2">
                                <p class="mt-1 text-xs text-gray-600">Berapa bank battery yang akan diinput?</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery per Bank *</label>
                                <input type="number" id="batteries_per_bank" min="1" value="{{ old('batteries_per_bank', $maintenance->readings->where('bank_number', 1)->count() ?? 1) }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                    placeholder="Contoh: 24">
                                <p class="mt-1 text-xs text-gray-600">Berapa battery dalam satu bank?</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                            <button type="button" id="generate-batteries"
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Generate Form Battery
                            </button>
                            <button type="button" id="add-battery-manual"
                                class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" />
                                </svg>
                                Tambah Battery Manual
                            </button>
                        </div>
                        <p class="mt-3 text-sm text-center text-gray-600 italic">
                            Total Battery: <strong><span id="total-batteries">{{ $maintenance->readings->count() }}</span></strong>
                        </p>
                    </div>
                </div>

                <!-- Data Battery Readings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Data Pembacaan Battery</h3>
                    </div>

                    <div class="p-4 sm:p-6">
                        <div id="battery-readings" class="space-y-4 sm:space-y-6">
                            @foreach($maintenance->readings as $index => $reading)
                            <div class="battery-item border-2 border-gray-200 rounded-xl p-4 sm:p-6" data-index="{{ $index }}">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-base sm:text-lg font-bold text-blue-700">Bank {{ $reading->bank_number }} - Battery {{ $reading->battery_number }}</h4>
                                </div>

                                <input type="hidden" name="readings[{{ $index }}][id]" value="{{ $reading->id }}">

                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 sm:gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                                        <input type="number" name="readings[{{ $index }}][bank_number]"
                                            value="{{ old('readings.'.$index.'.bank_number', $reading->bank_number) }}"
                                            required min="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                                        <input type="number" name="readings[{{ $index }}][battery_number]"
                                            value="{{ old('readings.'.$index.'.battery_number', $reading->battery_number) }}"
                                            required min="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                                        <input type="number" step="0.01" name="readings[{{ $index }}][voltage]"
                                            value="{{ old('readings.'.$index.'.voltage', $reading->voltage) }}"
                                            required min="0" max="20" placeholder="13.8"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">SOH (%)</label>
                                        <input type="number" step="0.01" name="readings[{{ $index }}][soh]"
                                            value="{{ old('readings.'.$index.'.soh', $reading->soh) }}"
                                            min="0" max="100" placeholder="95.5"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                        <p class="mt-1 text-xs text-gray-500">State of Health</p>
                                    </div>
                                </div>

                                <input type="hidden" name="readings[{{ $index }}][battery_brand]" class="reading-battery-brand" value="">
                                <input type="hidden" name="readings[{{ $index }}][battery_type]" class="reading-battery-type" value="">
                                <input type="hidden" name="readings[{{ $index }}][end_device_batt]" class="reading-end-device-batt" value="">

                                <!-- Photo Documentation Section - SAMA DENGAN CREATE -->
                                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>

                                    @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                    <div class="existing-photo-container mb-4" data-index="{{ $index }}">
                                        <div class="relative">
                                            <div class="absolute top-2 right-2 bg-green-700 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg z-10">
                                                ✓ Foto Tersedia
                                            </div>
                                            <img src="{{ Storage::url($reading->photo_path) }}"
                                                class="existing-photo w-full h-auto max-h-80 sm:max-h-96 rounded-lg border-4 object-contain shadow-lg"
                                                alt="Battery Photo #{{ $index + 1 }}">
                                        </div>
                                        <div class="mt-3 bg-gray-100 border-l-4 border-green-700 p-3 rounded">
                                            <p class="text-sm text-green-700 font-semibold mb-1">✓ Foto sudah tersimpan untuk battery ini</p>
                                            <p class="text-xs text-gray-600 mt-1">Pilih metode di bawah jika ingin menggantinya.</p>
                                        </div>
                                        <input type="hidden" name="readings[{{ $index }}][keep_photo]" value="1" class="keep-photo-input" data-index="{{ $index }}">
                                    </div>
                                    @else
                                    <div class="existing-photo-container mb-4" data-index="{{ $index }}">
                                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-sm text-gray-600 font-semibold">Belum ada foto untuk battery ini</p>
                                            <p class="text-xs text-gray-500 mt-1">Pilih metode di bawah untuk menambahkan foto</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Upload Method Selection -->
                                    <div class="flex gap-2 mb-3">
                                        <button type="button" class="method-camera flex-1 px-3 py-2 bg-blue-500 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="{{ $index }}">Camera</button>
                                        <button type="button" class="method-upload flex-1 px-3 py-2 bg-gray-300 text-gray-700 text-xs sm:text-sm font-semibold rounded-lg" data-index="{{ $index }}">Upload File</button>
                                    </div>

                                    <!-- Camera & Upload Sections -->
                                    <div class="camera-section" data-index="{{ $index }}">
                                        <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="{{ $index }}" autoplay playsinline></video>
                                        <img class="captured-image w-full h-auto max-h-96 rounded-lg mb-3 hidden" data-index="{{ $index }}" alt="Captured">
                                        <canvas class="hidden" data-index="{{ $index }}"></canvas>
                                        <div class="flex flex-wrap gap-2 justify-center mb-3">
                                            <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="{{ $index }}">Buka Kamera</button>
                                            <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="{{ $index }}">Ambil Foto</button>
                                            <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="{{ $index }}">Foto Ulang</button>
                                        </div>
                                    </div>

                                    <div class="upload-section hidden" data-index="{{ $index }}">
                                        <input type="file" class="file-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" accept="image/*" data-index="{{ $index }}">
                                        <div class="uploaded-preview mt-3 hidden">
                                            <img class="uploaded-image w-full h-auto max-h-96 rounded-lg mb-2" data-index="{{ $index }}" alt="Uploaded">
                                            <button type="button" class="remove-upload px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="{{ $index }}">Hapus Foto</button>
                                        </div>
                                    </div>

                                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3" data-index="{{ $index }}"></div>

                                    <input type="hidden" name="readings[{{ $index }}][photo_data]" data-photo="{{ $index }}">
                                    <input type="hidden" name="readings[{{ $index }}][photo_latitude]" data-lat="{{ $index }}">
                                    <input type="hidden" name="readings[{{ $index }}][photo_longitude]" data-lng="{{ $index }}">
                                    <input type="hidden" name="readings[{{ $index }}][photo_timestamp]" data-time="{{ $index }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                    <a href="{{ route('battery.show', $maintenance->id) }}"
                        class="px-6 sm:px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg text-center">Batal</a>
                    <button type="submit"
                        class="px-6 sm:px-8 py-3 bg-blue-700 hover:bg-blue-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">Update Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // COPY EXACT JAVASCRIPT FROM CREATE.BLADE.PHP
        let streams = {};

        function updateTotalBatteries() {
            const banks = parseInt(document.getElementById('total_banks').value) || 0;
            const perBank = parseInt(document.getElementById('batteries_per_bank').value) || 0;
            const total = banks * perBank;
            document.getElementById('total-batteries').textContent = total;
        }

        document.getElementById('total_banks').addEventListener('input', updateTotalBatteries);
        document.getElementById('batteries_per_bank').addEventListener('input', updateTotalBatteries);

        function compressImageTo1MB(canvas, initialQuality = 0.85) {
            let quality = initialQuality;
            let imageData = canvas.toDataURL('image/jpeg', quality);
            while (imageData.length > 1_000_000 && quality > 0.2) {
                quality -= 0.05;
                imageData = canvas.toDataURL('image/jpeg', quality);
            }
            return imageData;
        }

        async function getAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                return data.display_name || 'Alamat tidak ditemukan';
            } catch (error) {
                return 'Alamat tidak tersedia';
            }
        }

        function addWatermarkToCanvas(canvas, lat, lng, timestamp, address) {
            const ctx = canvas.getContext('2d');
            const fontSize = Math.max(14, canvas.width * 0.018);
            const padding = 15;
            const lineHeight = fontSize * 1.8;
            const startY = canvas.height - (lineHeight * 5.5);
            const dateStr = timestamp.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            const dayStr = timestamp.toLocaleDateString('id-ID', { weekday: 'long' });
            let timezone = 'WITA';
            if (lng >= 120 && lng < 130) timezone = 'WITA';
            else if (lng >= 130) timezone = 'WIT';
            const timeStr = timestamp.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' ' + timezone;
            ctx.shadowColor = 'rgba(0, 0, 0, 0.9)';
            ctx.shadowBlur = 10;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;
            ctx.fillStyle = 'white';
            ctx.font = `${fontSize}px Arial`;
            ctx.fillText(dateStr, padding, startY);
            ctx.fillText(dayStr, padding, startY + lineHeight);
            ctx.font = `bold ${fontSize * 2.5}px Arial`;
            ctx.fillText(timeStr, padding, startY + (lineHeight * 2.3));
            ctx.font = `${fontSize}px Arial`;
            ctx.fillText(`Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`, padding, startY + (lineHeight * 3.5));
            ctx.fillText(address, padding, startY + (lineHeight * 4.5));
        }

        // Generate Batteries - Replacing all existing
        document.getElementById('generate-batteries').addEventListener('click', function() {
            const totalBanks = parseInt(document.getElementById('total_banks').value);
            const batteriesPerBank = parseInt(document.getElementById('batteries_per_bank').value);

            if (!totalBanks || !batteriesPerBank || totalBanks < 1 || batteriesPerBank < 1) {
                alert('Mohon isi jumlah bank dan battery per bank dengan benar!');
                return;
            }

            const total = totalBanks * batteriesPerBank;
            if (!confirm(`Akan membuat ${total} form battery.\n\n⚠️ Data battery yang sudah ada akan diganti!\n\nLanjutkan?`)) return;

            Object.keys(streams).forEach(key => {
                if (streams[key]) streams[key].getTracks().forEach(track => track.stop());
            });
            streams = {};

            const container = document.getElementById('battery-readings');
            container.innerHTML = '';

            let index = 0;
            for (let bank = 1; bank <= totalBanks; bank++) {
                for (let batteryNum = 1; batteryNum <= batteriesPerBank; batteryNum++) {
                    const batteryItem = createBatteryItem(index, bank, batteryNum);
                    container.appendChild(batteryItem);
                    attachCameraEvents(index);
                    index++;
                }
            }
            updateTotalBatteries();
        });

        // Add Battery Manual
        document.getElementById('add-battery-manual').addEventListener('click', function() {
            const container = document.getElementById('battery-readings');
            const existingItems = container.querySelectorAll('.battery-item');

            let nextIndex = 0;
            if (existingItems.length > 0) {
                const lastIndex = parseInt(existingItems[existingItems.length - 1].getAttribute('data-index'));
                nextIndex = lastIndex + 1;
            }

            let defaultBank = 1;
            let defaultBatteryNum = 1;
            if (existingItems.length > 0) {
                const lastItem = existingItems[existingItems.length - 1];
                const lastBankInput = lastItem.querySelector('input[name*="[bank_number]"]');
                const lastBatteryInput = lastItem.querySelector('input[name*="[battery_number]"]');
                if (lastBankInput && lastBatteryInput) {
                    defaultBank = parseInt(lastBankInput.value);
                    defaultBatteryNum = parseInt(lastBatteryInput.value) + 1;
                }
            }

            const newBatteryItem = createBatteryItemManual(nextIndex, defaultBank, defaultBatteryNum);
            container.appendChild(newBatteryItem);
            attachCameraEvents(nextIndex);
            attachRemoveEvent(newBatteryItem);

            const totalBatteries = container.querySelectorAll('.battery-item').length;
            document.getElementById('total-batteries').textContent = totalBatteries;
        });

        function createBatteryItem(index, bankNumber, batteryNumber) {
            // COPY FROM CREATE.BLADE.PHP - EXACT SAME FUNCTION
            const div = document.createElement('div');
            div.className = 'battery-item border-2 border-gray-200 rounded-xl p-4 sm:p-6';
            div.setAttribute('data-index', index);
            div.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-base sm:text-lg font-bold text-blue-700">Bank ${bankNumber} - Battery ${batteryNumber}</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 sm:gap-4 mb-4">
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                        <input type="number" name="readings[${index}][bank_number]" value="${bankNumber}" required readonly class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg bg-gray-100"></div>
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                        <input type="number" name="readings[${index}][battery_number]" value="${batteryNumber}" required readonly class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg bg-gray-100"></div>
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                        <input type="number" step="0.01" name="readings[${index}][voltage]" required min="0" max="20" placeholder="13.8" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg"></div>
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">SOH (%)</label>
                        <input type="number" step="0.01" name="readings[${index}][soh]" min="0" max="100" placeholder="95.5" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg">
                        <p class="mt-1 text-xs text-gray-500">State of Health</p></div>
                </div>
                <input type="hidden" name="readings[${index}][battery_brand]" class="reading-battery-brand" value="">
                <input type="hidden" name="readings[${index}][battery_type]" class="reading-battery-type" value="">
                <input type="hidden" name="readings[${index}][end_device_batt]" class="reading-end-device-batt" value="">
                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>
                    <div class="flex gap-2 mb-3">
                        <button type="button" class="method-camera flex-1 px-3 py-2 bg-blue-500 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Camera</button>
                        <button type="button" class="method-upload flex-1 px-3 py-2 bg-gray-300 text-gray-700 text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Upload File</button>
                    </div>
                    <div class="camera-section" data-index="${index}">
                        <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="${index}" autoplay playsinline></video>
                        <img class="captured-image w-full h-auto max-h-96 rounded-lg mb-3 hidden" data-index="${index}" alt="Captured">
                        <canvas class="hidden" data-index="${index}"></canvas>
                        <div class="flex flex-wrap gap-2 justify-center mb-3">
                            <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Buka Kamera</button>
                            <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Ambil Foto</button>
                            <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Foto Ulang</button>
                        </div>
                    </div>
                    <div class="upload-section hidden" data-index="${index}">
                        <input type="file" class="file-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" accept="image/*" data-index="${index}">
                        <div class="uploaded-preview mt-3 hidden">
                            <img class="uploaded-image w-full h-auto max-h-96 rounded-lg mb-2" data-index="${index}" alt="Uploaded">
                            <button type="button" class="remove-upload px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Hapus Foto</button>
                        </div>
                    </div>
                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3" data-index="${index}"></div>
                    <input type="hidden" name="readings[${index}][photo_data]" data-photo="${index}">
                    <input type="hidden" name="readings[${index}][photo_latitude]" data-lat="${index}">
                    <input type="hidden" name="readings[${index}][photo_longitude]" data-lng="${index}">
                    <input type="hidden" name="readings[${index}][photo_timestamp]" data-time="${index}">
                </div>
            `;
            return div;
        }

        function createBatteryItemManual(index, defaultBank, defaultBatteryNum) {
            // Similar to createBatteryItem but with editable bank/battery number + remove button
            const div = document.createElement('div');
            div.className = 'battery-item border-2 border-green-300 rounded-xl p-4 sm:p-6';
            div.setAttribute('data-index', index);
            div.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-base sm:text-lg font-bold text-green-700">Battery Baru ${index + 1}</h4>
                    <button type="button" class="btn-remove px-2 sm:px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Hapus</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 sm:gap-4 mb-4">
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                        <input type="number" name="readings[${index}][bank_number]" value="${defaultBank}" required min="1" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg"></div>
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                        <input type="number" name="readings[${index}][battery_number]" value="${defaultBatteryNum}" required min="1" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg"></div>
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                        <input type="number" step="0.01" name="readings[${index}][voltage]" required min="0" max="20" placeholder="13.8" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg"></div>
                    <div><label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">SOH (%)</label>
                        <input type="number" step="0.01" name="readings[${index}][soh]" min="0" max="100" placeholder="95.5" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg">
                        <p class="mt-1 text-xs text-gray-500">State of Health</p></div>
                </div>
                <input type="hidden" name="readings[${index}][battery_brand]" class="reading-battery-brand" value="">
                <input type="hidden" name="readings[${index}][battery_type]" class="reading-battery-type" value="">
                <input type="hidden" name="readings[${index}][end_device_batt]" class="reading-end-device-batt" value="">
                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>
                    <div class="flex gap-2 mb-3">
                        <button type="button" class="method-camera flex-1 px-3 py-2 bg-blue-500 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Camera</button>
                        <button type="button" class="method-upload flex-1 px-3 py-2 bg-gray-300 text-gray-700 text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Upload File</button>
                    </div>
                    <div class="camera-section" data-index="${index}">
                        <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="${index}" autoplay playsinline></video>
                        <img class="captured-image w-full h-auto max-h-96 rounded-lg mb-3 hidden" data-index="${index}" alt="Captured">
                        <canvas class="hidden" data-index="${index}"></canvas>
                        <div class="flex flex-wrap gap-2 justify-center mb-3">
                            <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Buka Kamera</button>
                            <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Ambil Foto</button>
                            <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Foto Ulang</button>
                        </div>
                    </div>
                    <div class="upload-section hidden" data-index="${index}">
                        <input type="file" class="file-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" accept="image/*" data-index="${index}">
                        <div class="uploaded-preview mt-3 hidden">
                            <img class="uploaded-image w-full h-auto max-h-96 rounded-lg mb-2" data-index="${index}" alt="Uploaded">
                            <button type="button" class="remove-upload px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg" data-index="${index}">Hapus Foto</button>
                        </div>
                    </div>
                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3" data-index="${index}"></div>
                    <input type="hidden" name="readings[${index}][photo_data]" data-photo="${index}">
                    <input type="hidden" name="readings[${index}][photo_latitude]" data-lat="${index}">
                    <input type="hidden" name="readings[${index}][photo_longitude]" data-lng="${index}">
                    <input type="hidden" name="readings[${index}][photo_timestamp]" data-time="${index}">
                </div>
            `;
            return div;
        }

        function attachRemoveEvent(item) {
            const removeBtn = item.querySelector('.btn-remove');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    const index = item.getAttribute('data-index');
                    if (streams[index]) {
                        streams[index].getTracks().forEach(track => track.stop());
                        delete streams[index];
                    }
                    item.remove();
                    const container = document.getElementById('battery-readings');
                    const totalBatteries = container.querySelectorAll('.battery-item').length;
                    document.getElementById('total-batteries').textContent = totalBatteries;
                });
            }
        }

        function attachCameraEvents(index) {
            const item = document.querySelector(`.battery-item[data-index="${index}"]`);
            if (!item) return;

            const methodCamera = item.querySelector('.method-camera');
            const methodUpload = item.querySelector('.method-upload');
            const cameraSection = item.querySelector('.camera-section');
            const uploadSection = item.querySelector('.upload-section');
            const existingPhotoContainer = item.querySelector('.existing-photo-container');
            const keepPhotoInput = item.querySelector('.keep-photo-input');

            if (methodCamera) {
                methodCamera.addEventListener('click', function() {
                    methodCamera.classList.remove('bg-gray-300', 'text-gray-700');
                    methodCamera.classList.add('bg-blue-500', 'text-white');
                    methodUpload.classList.remove('bg-blue-500', 'text-white');
                    methodUpload.classList.add('bg-gray-300', 'text-gray-700');
                    cameraSection.classList.remove('hidden');
                    uploadSection.classList.add('hidden');
                    if (existingPhotoContainer) existingPhotoContainer.classList.add('hidden');
                    if (keepPhotoInput) keepPhotoInput.value = '0';
                    const fileInput = item.querySelector('.file-input');
                    if (fileInput) fileInput.value = '';
                    const uploadedPreview = item.querySelector('.uploaded-preview');
                    if (uploadedPreview) uploadedPreview.classList.add('hidden');
                });
            }

            if (methodUpload) {
                methodUpload.addEventListener('click', function() {
                    methodUpload.classList.remove('bg-gray-300', 'text-gray-700');
                    methodUpload.classList.add('bg-blue-500', 'text-white');
                    methodCamera.classList.remove('bg-blue-500', 'text-white');
                    methodCamera.classList.add('bg-gray-300', 'text-gray-700');
                    uploadSection.classList.remove('hidden');
                    cameraSection.classList.add('hidden');
                    if (existingPhotoContainer) existingPhotoContainer.classList.add('hidden');
                    if (keepPhotoInput) keepPhotoInput.value = '0';
                    if (streams[index]) {
                        streams[index].getTracks().forEach(track => track.stop());
                        delete streams[index];
                    }
                    const video = item.querySelector('.camera-preview');
                    const capturedImage = item.querySelector('.captured-image');
                    const startBtn = item.querySelector('.start-camera');
                    const captureBtn = item.querySelector('.capture-photo');
                    const retakeBtn = item.querySelector('.retake-photo');
                    if (video) video.classList.add('hidden');
                    if (capturedImage) capturedImage.classList.add('hidden');
                    if (startBtn) startBtn.classList.remove('hidden');
                    if (captureBtn) captureBtn.classList.add('hidden');
                    if (retakeBtn) retakeBtn.classList.add('hidden');
                });
            }

            const video = item.querySelector('.camera-preview');
            const canvas = item.querySelector('canvas');
            const capturedImage = item.querySelector('.captured-image');
            const startBtn = item.querySelector('.start-camera');
            const captureBtn = item.querySelector('.capture-photo');
            const retakeBtn = item.querySelector('.retake-photo');
            const photoInfo = item.querySelector('.photo-info');

            if (startBtn) {
                startBtn.addEventListener('click', async function() {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } },
                            audio: false
                        });
                        streams[index] = stream;
                        video.srcObject = stream;
                        video.classList.remove('hidden');
                        startBtn.classList.add('hidden');
                        captureBtn.classList.remove('hidden');
                    } catch (err) {
                        alert('Error membuka kamera: ' + err.message);
                    }
                });
            }

            if (captureBtn) {
                captureBtn.addEventListener('click', function() {
                    capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, photoInfo);
                });
            }

            if (retakeBtn) {
                retakeBtn.addEventListener('click', function() {
                    capturedImage.classList.add('hidden');
                    video.classList.add('hidden');
                    startBtn.classList.remove('hidden');
                    retakeBtn.classList.add('hidden');
                    photoInfo.innerHTML = '';
                    document.querySelector(`input[data-photo="${index}"]`).value = '';
                    document.querySelector(`input[data-lat="${index}"]`).value = '';
                    document.querySelector(`input[data-lng="${index}"]`).value = '';
                    document.querySelector(`input[data-time="${index}"]`).value = '';
                });
            }

            const fileInput = item.querySelector('.file-input');
            const uploadedPreview = item.querySelector('.uploaded-preview');
            const uploadedImage = item.querySelector('.uploaded-image');
            const removeUploadBtn = item.querySelector('.remove-upload');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    if (!file.type.startsWith('image/')) {
                        alert('File harus berupa gambar!');
                        return;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file maksimal 5MB!');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = new Image();
                        img.onload = function() {
                            const maxWidth = 1280;
                            const maxHeight = 720;
                            let width = img.width;
                            let height = img.height;
                            if (width > maxWidth || height > maxHeight) {
                                const ratio = Math.min(maxWidth / width, maxHeight / height);
                                width = width * ratio;
                                height = height * ratio;
                            }
                            const canvas = document.createElement('canvas');
                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);
                            const imageData = compressImageTo1MB(canvas);
                            uploadedImage.src = imageData;
                            uploadedPreview.classList.remove('hidden');
                            document.querySelector(`input[data-photo="${index}"]`).value = imageData;
                            document.querySelector(`input[data-lat="${index}"]`).value = '';
                            document.querySelector(`input[data-lng="${index}"]`).value = '';
                            document.querySelector(`input[data-time="${index}"]`).value = '';
                            photoInfo.innerHTML = '<p class="text-green-600 font-semibold">✓ Foto berhasil diupload!</p>';
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }

            if (removeUploadBtn) {
                removeUploadBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    uploadedPreview.classList.add('hidden');
                    photoInfo.innerHTML = '';
                    document.querySelector(`input[data-photo="${index}"]`).value = '';
                    document.querySelector(`input[data-lat="${index}"]`).value = '';
                    document.querySelector(`input[data-lng="${index}"]`).value = '';
                    document.querySelector(`input[data-time="${index}"]`).value = '';
                });
            }
        }

        function capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, photoInfo) {
            if (navigator.geolocation) {
                photoInfo.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan lokasi GPS...</p>';
                navigator.geolocation.getCurrentPosition(
                    async function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const timestamp = new Date();
                        photoInfo.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan alamat...</p>';
                        const address = await getAddress(lat, lng);
                        canvas.width = video.videoWidth || 1280;
                        canvas.height = video.videoHeight || 720;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        addWatermarkToCanvas(canvas, lat, lng, timestamp, address);
                        const imageData = compressImageTo1MB(canvas);
                        capturedImage.src = imageData;
                        capturedImage.classList.remove('hidden');
                        video.classList.add('hidden');
                        document.querySelector(`input[data-photo="${index}"]`).value = imageData;
                        document.querySelector(`input[data-lat="${index}"]`).value = lat;
                        document.querySelector(`input[data-lng="${index}"]`).value = lng;
                        document.querySelector(`input[data-time="${index}"]`).value = timestamp.toISOString();
                        if (streams[index]) {
                            streams[index].getTracks().forEach(track => track.stop());
                            delete streams[index];
                        }
                        captureBtn.classList.add('hidden');
                        retakeBtn.classList.remove('hidden');
                        photoInfo.innerHTML = '<p class="text-green-600 font-semibold">✓ Foto berhasil diambil!</p>';
                    },
                    function(error) {
                        photoInfo.innerHTML = '<p class="text-red-600">❌ Gagal mendapatkan lokasi GPS</p>';
                        alert('Tidak dapat mengakses lokasi GPS: ' + error.message);
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                alert('Geolokasi tidak didukung oleh browser ini');
            }
        }

        document.getElementById('mainForm').addEventListener('submit', function(e) {
            const mainBatteryBrand = document.getElementById('main_battery_brand').value;
            const mainBatteryType = document.getElementById('main_battery_type').value;
            const mainEndDeviceBatt = document.getElementById('main_end_device_batt').value;

            document.querySelectorAll('.reading-battery-brand').forEach(function(input) {
                input.value = mainBatteryBrand;
            });
            document.querySelectorAll('.reading-battery-type').forEach(function(input) {
                input.value = mainBatteryType;
            });
            document.querySelectorAll('.reading-end-device-batt').forEach(function(input) {
                input.value = mainEndDeviceBatt;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const existingReadings = document.querySelectorAll('.battery-item');
            existingReadings.forEach(function(item) {
                const index = parseInt(item.getAttribute('data-index'));
                attachCameraEvents(index);
            });
            updateTotalBatteries();
        });
    </script>
</x-app-layout>

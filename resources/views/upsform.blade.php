<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($maintenance) ? 'Edit Data UPS' : 'Input Data Preventive Maintenance UPS' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Modal Camera -->
                    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
                            <h2 class="text-xl font-bold mb-4">Ambil Foto</h2>

                            <div id="geoInfo" class="mb-4 p-3 bg-blue-50 rounded border border-blue-200 text-xs space-y-1">
                                <p><strong>Latitude:</strong> <span id="lat">-</span></p>
                                <p><strong>Longitude:</strong> <span id="lon">-</span></p>
                                <p><strong>Tanggal & Waktu:</strong> <span id="datetime">-</span></p>
                                <p><strong>Lokasi:</strong> <span id="location">-</span></p>
                            </div>

                            <video id="video" class="w-full rounded bg-black mb-4" playsinline autoplay muted style="transform: scaleX(-1);"></video>
                            <canvas id="canvas" class="hidden"></canvas>

                            <div id="capturedImage" class="hidden mb-4">
                                <img id="capturedImg" class="w-full rounded" alt="Captured">
                            </div>

                            <div class="flex gap-2 mb-4">
                                <button id="captureBtn" type="button" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                                    Ambil Foto
                                </button>
                                <button id="switchCameraBtn" type="button" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">
                                    Tukar Kamera
                                </button>
                            </div>

                            <div class="flex gap-2">
                                <button id="retakeBtn" type="button" class="hidden flex-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
                                    Ulangi
                                </button>
                                <button id="usePhotoBtn" type="button" class="hidden flex-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">
                                    Gunakan Foto
                                </button>
                                <button id="closeModalBtn" type="button" class="flex-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>

                    <form action="{{ isset($maintenance) ? route('ups.update', $maintenance->id) : route('ups.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        @if(isset($maintenance))
                            @method('PUT')
                        @endif

                        <div class="mb-6 pb-4 border-b-2 border-gray-200">
                            <div class="text-sm text-gray-600">
                                <p>No. Dok: FM-LAP-D2-SOP-003-002 | Versi: 1.0 | Hal: 1 dari 1 | Label: Internal</p>
                            </div>
                        </div>

                        {{-- Informasi Lokasi dan Perangkat --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-blue-500">Informasi Lokasi dan Perangkat</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                                    <input type="text" name="location" value="{{ old('location', $maintenance->location ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('location') border-red-500 @enderror"
                                           placeholder="DPSTKU (LA Teuku Umar)" required>
                                    @error('location')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date / Time <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" name="date_time" value="{{ old('date_time', isset($maintenance) ? date('Y-m-d\TH:i', strtotime($maintenance->date_time)) : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('date_time') border-red-500 @enderror" required>
                                    @error('date_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand / Type <span class="text-red-500">*</span></label>
                                    <input type="text" name="brand_type" value="{{ old('brand_type', $maintenance->brand_type ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('brand_type') border-red-500 @enderror" required>
                                    @error('brand_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas <span class="text-red-500">*</span></label>
                                    <input type="text" name="capacity" value="{{ old('capacity', $maintenance->capacity ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('capacity') border-red-500 @enderror" required>
                                    @error('capacity')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number</label>
                                    <input type="text" name="reg_number" value="{{ old('reg_number', $maintenance->reg_number ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">S/N</label>
                                    <input type="text" name="sn" value="{{ old('sn', $maintenance->sn ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        {{-- Visual Check --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-blue-500">1. Visual Check</h3>

                            {{-- Environmental Condition --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">a. Environmental Condition <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="text-xs text-gray-600">Result</label>
                                        <input type="text" name="env_condition" value="{{ old('env_condition', $maintenance->env_condition ?? '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Cera" required>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_env_condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_env_condition', $maintenance->status_env_condition ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_env_condition', $maintenance->status_env_condition ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: Clean, No dust</p>
                                <div class="image-upload-section" data-field-name="visual_check_env_condition">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- LED Display --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">b. LED / display <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="text-xs text-gray-600">Result</label>
                                        <input type="text" name="led_display" value="{{ old('led_display', $maintenance->led_display ?? '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Normal" required>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_led_display" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_led_display', $maintenance->status_led_display ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_led_display', $maintenance->status_led_display ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: Normal</p>
                                <div class="image-upload-section" data-field-name="visual_check_led_display">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- Battery Connection --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">c. Battery Connection <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="text-xs text-gray-600">Result</label>
                                        <input type="text" name="battery_connection" value="{{ old('battery_connection', $maintenance->battery_connection ?? '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Kaken" required>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_battery_connection" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_battery_connection', $maintenance->status_battery_connection ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_battery_connection', $maintenance->status_battery_connection ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: Tighten, No Corrosion</p>
                                <div class="image-upload-section" data-field-name="visual_check_battery_connection">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Performance and Capacity Check --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-blue-500">2. Performance and Capacity Check</h3>

                            {{-- AC Input Voltage --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">a. AC input voltage <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="text-xs text-gray-600">RS (Volt)</label>
                                            <input type="number" step="0.1" name="ac_input_voltage_rs"
                                                   value="{{ old('ac_input_voltage_rs', $maintenance->ac_input_voltage_rs ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">ST (Volt)</label>
                                            <input type="number" step="0.1" name="ac_input_voltage_st"
                                                   value="{{ old('ac_input_voltage_st', $maintenance->ac_input_voltage_st ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">TR (Volt)</label>
                                            <input type="number" step="0.1" name="ac_input_voltage_tr"
                                                   value="{{ old('ac_input_voltage_tr', $maintenance->ac_input_voltage_tr ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_ac_input_voltage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="OK" {{ old('status_ac_input_voltage', $maintenance->status_ac_input_voltage ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_ac_input_voltage', $maintenance->status_ac_input_voltage ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: 360-400 VAC</p>
                                <div class="image-upload-section" data-field-name="performance_ac_input_voltage">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- AC Output Voltage --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">b. AC output voltage <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="text-xs text-gray-600">RS (Volt)</label>
                                            <input type="number" step="0.1" name="ac_output_voltage_rs"
                                                   value="{{ old('ac_output_voltage_rs', $maintenance->ac_output_voltage_rs ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">ST (Volt)</label>
                                            <input type="number" step="0.1" name="ac_output_voltage_st"
                                                   value="{{ old('ac_output_voltage_st', $maintenance->ac_output_voltage_st ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">TR (Volt)</label>
                                            <input type="number" step="0.1" name="ac_output_voltage_tr"
                                                   value="{{ old('ac_output_voltage_tr', $maintenance->ac_output_voltage_tr ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_ac_output_voltage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="OK" {{ old('status_ac_output_voltage', $maintenance->status_ac_output_voltage ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_ac_output_voltage', $maintenance->status_ac_output_voltage ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: 370-390 VAC</p>
                                <div class="image-upload-section" data-field-name="performance_ac_output_voltage">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- AC Current Input --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">c. AC current input <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="text-xs text-gray-600">R (Amp)</label>
                                            <input type="number" step="0.1" name="ac_current_input_r"
                                                   value="{{ old('ac_current_input_r', $maintenance->ac_current_input_r ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">S (Amp)</label>
                                            <input type="number" step="0.1" name="ac_current_input_s"
                                                   value="{{ old('ac_current_input_s', $maintenance->ac_current_input_s ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">T (Amp)</label>
                                            <input type="number" step="0.1" name="ac_current_input_t"
                                                   value="{{ old('ac_current_input_t', $maintenance->ac_current_input_t ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_ac_current_input" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="OK" {{ old('status_ac_current_input', $maintenance->status_ac_current_input ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_ac_current_input', $maintenance->status_ac_current_input ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: Sesuai kapasitas UPS</p>
                                <div class="image-upload-section" data-field-name="performance_ac_current_input">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- AC Current Output --}}
                            <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">d. AC current output <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="text-xs text-gray-600">R (Amp)</label>
                                            <input type="number" step="0.1" name="ac_current_output_r"
                                                   value="{{ old('ac_current_output_r', $maintenance->ac_current_output_r ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">S (Amp)</label>
                                            <input type="number" step="0.1" name="ac_current_output_s"
                                                   value="{{ old('ac_current_output_s', $maintenance->ac_current_output_s ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text sm" required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">T (Amp)</label>
                                            <input type="number" step="0.1" name="ac_current_output_t"
                                                   value="{{ old('ac_current_output_t', $maintenance->ac_current_output_t ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Status</label>
                                        <select name="status_ac_current_output" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="OK" {{ old('status_ac_current_output', $maintenance->status_ac_current_output ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_ac_current_output', $maintenance->status_ac_current_output ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Standard: Sesuai kapasitas UPS</p>
                                <div class="image-upload-section" data-field-name="performance_ac_current_output">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                        <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                    </div>
                                    <input type="file" class="file-input hidden" accept="image/*" multiple>
                                    <div class="preview-container flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- Other Measurements --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 border rounded-lg bg-gray-50">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">e. UPS temperature <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.1" name="ups_temperature"
                                           value="{{ old('ups_temperature', $maintenance->ups_temperature ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="°C" required>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Standard: 0-40 °C</p>
                                    <select name="status_ups_temperature" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="OK" {{ old('status_ups_temperature', $maintenance->status_ups_temperature ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ old('status_ups_temperature', $maintenance->status_ups_temperature ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                    <div class="image-upload-section mt-3" data-field-name="performance_ups_temperature">
                                        <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                        <div class="flex gap-2 mb-2">
                                            <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                            <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                        </div>
                                        <input type="file" class="file-input hidden" accept="image/*" multiple>
                                        <div class="preview-container flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                                <div class="p-4 border rounded-lg bg-gray-50">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">f. Output frequency <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="output_frequency"
                                           value="{{ old('output_frequency', $maintenance->output_frequency ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Hz" required>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Standard: 48.75-50.25 Hz</p>
                                    <select name="status_output_frequency" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="OK" {{ old('status_output_frequency', $maintenance->status_output_frequency ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ old('status_output_frequency', $maintenance->status_output_frequency ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                    <div class="image-upload-section mt-3" data-field-name="performance_output_frequency">
                                        <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                        <div class="flex gap-2 mb-2">
                                            <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                            <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                        </div>
                                        <input type="file" class="file-input hidden" accept="image/*" multiple>
                                        <div class="preview-container flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                                <div class="p-4 border rounded-lg bg-gray-50">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">g. Charging voltage <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.1" name="charging_voltage"
                                           value="{{ old('charging_voltage', $maintenance->charging_voltage ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Volt" required>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Standard: See Battery Performance table</p>
                                    <select name="status_charging_voltage" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="OK" {{ old('status_charging_voltage', $maintenance->status_charging_voltage ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ old('status_charging_voltage', $maintenance->status_charging_voltage ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                    <div class="image-upload-section mt-3" data-field-name="performance_charging_voltage">
                                        <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                        <div class="flex gap-2 mb-2">
                                            <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                            <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                        </div>
                                        <input type="file" class="file-input hidden" accept="image/*" multiple>
                                        <div class="preview-container flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                                <div class="p-4 border rounded-lg bg-gray-50">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">h. Charging current <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.1" name="charging_current"
                                           value="{{ old('charging_current', $maintenance->charging_current ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Amp" required>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Standard: 0 Ampere, on-line mode</p>
                                    <select name="status_charging_current" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="OK" {{ old('status_charging_current', $maintenance->status_charging_current ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ old('status_charging_current', $maintenance->status_charging_current ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                    <div class="image-upload-section mt-3" data-field-name="performance_charging_current">
                                        <p class="text-xs font-medium text-gray-600 mb-2">Gambar:</p>
                                        <div class="flex gap-2 mb-2">
                                            <button type="button" class="upload-local-btn px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Lokal</button>
                                            <button type="button" class="camera-btn px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                        </div>
                                        <input type="file" class="file-input hidden" accept="image/*" multiple>
                                        <div class="preview-container flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-blue-500">Notes / additional informations</h3>
                            <textarea name="notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3"
                                      placeholder="Catatan tambahan...">{{ old('notes', $maintenance->notes ?? '') }}</textarea>
                        </div>

                        {{-- Personnel --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-3 text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-blue-500">Pelaksana / Mengetahui</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelaksana 1 <span class="text-red-500">*</span></label>
                                    <input type="text" name="executor_1" value="{{ old('executor_1', $maintenance->executor_1 ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nama pelaksana 1" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelaksana 2</label>
                                    <input type="text" name="executor_2" value="{{ old('executor_2', $maintenance->executor_2 ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nama pelaksana 2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mengetahui (Supervisor) <span class="text-red-500">*</span></label>
                                    <input type="text" name="supervisor" value="{{ old('supervisor', $maintenance->supervisor ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nama supervisor" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Supervisor</label>
                                    <input type="text" name="supervisor_id_number" value="{{ old('supervisor_id_number', $maintenance->supervisor_id_number ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="ID Supervisor">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Departement</label>
                                    <input type="text" name="department" value="{{ old('department', $maintenance->department ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Departement">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub Departement</label>
                                    <input type="text" name="sub_department" value="{{ old('sub_department', $maintenance->sub_department ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Sub Departement">
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t">
                            <a href="{{ route('ups') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ isset($maintenance) ? 'Update Data' : 'Simpan Data' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStream;
        let currentFacingMode = 'environment';
        let capturedPhoto = null;
        let currentImageField = null;
        let geoData = {
            lat: '-',
            lon: '-',
            datetime: '-',
            location: '-'
        };

        // Get Geolocation saat modal dibuka
        function updateGeoLocation() {
            if (!navigator.geolocation) {
                document.getElementById('location').textContent = 'Geolocation tidak didukung';
                return;
            }

            navigator.geolocation.getCurrentPosition(
                pos => {
                    const { latitude, longitude } = pos.coords;
                    const currentDateTime = new Date().toLocaleString('id-ID');

                    // Simpan ke variabel global
                    geoData.lat = latitude.toFixed(6);
                    geoData.lon = longitude.toFixed(6);
                    geoData.datetime = currentDateTime;

                    // Update UI
                    document.getElementById('lat').textContent = geoData.lat;
                    document.getElementById('lon').textContent = geoData.lon;
                    document.getElementById('datetime').textContent = geoData.datetime;

                    // Reverse geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`, {
                        headers: { 'Accept': 'application/json' }
                    })
                        .then(r => r.json())
                        .then(data => {
                            const address = data.address || {};
                            const location = address.city || address.town || address.village || address.suburb || address.county || 'Lokasi tidak teridentifikasi';
                            geoData.location = location;
                            document.getElementById('location').textContent = location;
                        })
                        .catch(err => {
                            console.warn('Reverse geocoding error:', err);
                            geoData.location = 'Lokasi tidak dapat diakses';
                            document.getElementById('location').textContent = geoData.location;
                        });
                },
                err => {
                    console.warn('Geolocation error:', err);
                    geoData.location = 'Izin geolocation ditolak';
                    document.getElementById('location').textContent = geoData.location;
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }

        // Fungsi untuk membuka modal camera
        function openCameraModal(fieldName) {
            if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                alert('Fitur kamera hanya tersedia melalui HTTPS atau localhost.');
                return;
            }

            currentImageField = fieldName;
            document.getElementById('cameraModal').classList.remove('hidden');

            setTimeout(() => {
                updateGeoLocation();
                startCamera();
            }, 100);
        }

        // Fungsi untuk menutup modal camera
        function closeCameraModal() {
            document.getElementById('cameraModal').classList.add('hidden');
            stopCamera();
            resetCameraUI();
        }

        // Reset UI camera
        function resetCameraUI() {
            document.getElementById('video').style.display = 'block';
            document.getElementById('capturedImage').classList.add('hidden');
            document.getElementById('captureBtn').style.display = 'inline-block';
            document.getElementById('switchCameraBtn').style.display = 'inline-block';
            document.getElementById('retakeBtn').classList.add('hidden');
            document.getElementById('usePhotoBtn').classList.add('hidden');
            capturedPhoto = null;
        }

        // Start camera dengan error handling yang lebih baik
        async function startCamera() {
            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    alert('Browser Anda tidak mendukung akses kamera. Gunakan Chrome, Firefox, atau Safari terbaru.');
                    return;
                }

                if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                    alert('Kamera hanya berfungsi melalui HTTPS. Gunakan localhost untuk development atau deploy ke HTTPS.');
                    return;
                }

                currentStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: currentFacingMode,
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    },
                    audio: false
                });

                const videoElement = document.getElementById('video');
                videoElement.srcObject = currentStream;

                videoElement.onloadedmetadata = () => {
                    videoElement.play().catch(err => {
                        console.error('Error playing video:', err);
                        alert('Gagal memulai video kamera. Coba lagi.');
                    });
                };

            } catch (err) {
                console.error('Camera error:', err);

                if (err.name === 'NotAllowedError') {
                    alert('Akses kamera ditolak. Silakan izinkan akses kamera di pengaturan browser Anda.');
                } else if (err.name === 'NotFoundError') {
                    alert('Kamera tidak ditemukan di perangkat Anda.');
                } else if (err.name === 'NotReadableError') {
                    alert('Kamera sedang digunakan oleh aplikasi lain. Tutup aplikasi tersebut terlebih dahulu.');
                } else if (err.name === 'SecurityError') {
                    alert('Akses kamera ditolak untuk alasan keamanan. Pastikan menggunakan HTTPS.');
                } else {
                    alert('Error mengakses kamera: ' + err.message);
                }

                closeCameraModal();
            }
        }

        // Stop camera
        function stopCamera() {
            if (currentStream) {
                currentStream.getTracks().forEach(track => {
                    track.stop();
                });
                currentStream = null;
            }
        }

        // Fungsi untuk menambahkan watermark geolokasi ke canvas
        function addGeoWatermark(ctx, canvas) {
            // Setup text style untuk watermark
            const padding = 20;
            const lineHeight = 30;
            const fontSize = 20;
            const backgroundColor = 'rgba(0, 0, 0, 0.75)';
            const textColor = '#FFFFFF';
            const borderColor = '#FFD700'; // Gold color for border

            // Prepare text lines
            const lines = [
                `📍 Lat: ${geoData.lat} | Long: ${geoData.lon}`,
                `📅 ${geoData.datetime}`,
                `📌 ${geoData.location}`
            ];

            // Calculate text dimensions
            ctx.font = `bold ${fontSize}px Arial, sans-serif`;
            let maxWidth = 0;
            lines.forEach(line => {
                const textWidth = ctx.measureText(line).width;
                if (textWidth > maxWidth) maxWidth = textWidth;
            });

            const boxWidth = maxWidth + (padding * 2);
            const boxHeight = (lines.length * lineHeight) + (padding * 2) - 5;

            // Position: bottom-left corner
            const boxX = 15;
            const boxY = canvas.height - boxHeight - 15;

            // Draw border
            ctx.strokeStyle = borderColor;
            ctx.lineWidth = 3;
            ctx.strokeRect(boxX, boxY, boxWidth, boxHeight);

            // Draw semi-transparent background box
            ctx.fillStyle = backgroundColor;
            ctx.fillRect(boxX, boxY, boxWidth, boxHeight);

            // Draw text with shadow for better readability
            ctx.fillStyle = textColor;
            ctx.font = `bold ${fontSize}px Arial, sans-serif`;
            ctx.textBaseline = 'top';
            ctx.shadowColor = 'rgba(0, 0, 0, 0.8)';
            ctx.shadowBlur = 4;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;

            lines.forEach((line, index) => {
                const textX = boxX + padding;
                const textY = boxY + padding + (index * lineHeight);
                ctx.fillText(line, textX, textY);
            });

            // Reset shadow
            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
        }

        // Event: Capture Photo dengan watermark geolokasi
        document.getElementById('captureBtn').addEventListener('click', () => {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');

            // Set canvas size to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame (flip horizontal untuk mirror effect)
            ctx.save();
            ctx.scale(-1, 1);
            ctx.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
            ctx.restore();

            // Add geolocation watermark
            addGeoWatermark(ctx, canvas);

            // Convert to image
            capturedPhoto = canvas.toDataURL('image/jpeg', 0.92);

            // Update UI
            document.getElementById('video').style.display = 'none';
            document.getElementById('capturedImage').classList.remove('hidden');
            document.getElementById('capturedImg').src = capturedPhoto;
            document.getElementById('captureBtn').style.display = 'none';
            document.getElementById('switchCameraBtn').style.display = 'none';
            document.getElementById('retakeBtn').classList.remove('hidden');
            document.getElementById('usePhotoBtn').classList.remove('hidden');
        });

        // Event: Retake Photo
        document.getElementById('retakeBtn').addEventListener('click', () => {
            resetCameraUI();
            // Update geolocation lagi untuk data terbaru
            updateGeoLocation();
            startCamera();
        });

        // Event: Switch Camera
        document.getElementById('switchCameraBtn').addEventListener('click', async () => {
            currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
            stopCamera();
            await startCamera();
        });

        // Event: Use Photo
        document.getElementById('usePhotoBtn').addEventListener('click', () => {
            if (capturedPhoto && currentImageField) {
                addImageToPreview(capturedPhoto, currentImageField);
                closeCameraModal();
            }
        });

        // Event: Close Modal
        document.getElementById('closeModalBtn').addEventListener('click', closeCameraModal);

        // Fungsi untuk menambah gambar ke preview
        function addImageToPreview(imageData, fieldName) {
            const section = document.querySelector(`[data-field-name="${fieldName}"]`);
            if (!section) return;

            const previewContainer = section.querySelector('.preview-container');
            const img = document.createElement('img');
            img.src = imageData;
            img.className = 'w-20 h-20 rounded object-cover cursor-pointer hover:opacity-75 transition border-2 border-gray-300';
            img.title = 'Klik untuk menghapus';
            img.addEventListener('click', () => {
                if (confirm('Hapus gambar ini?')) {
                    img.remove();
                    const hiddenInput = document.querySelector(`input[name="images[]"][value="${imageData}"]`);
                    if (hiddenInput) hiddenInput.remove();
                }
            });
            previewContainer.appendChild(img);

            // Create image data object with category
            const imageInfo = {
                data: imageData,
                category: fieldName
            };

            // Add hidden input for form submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'images[]';
            hiddenInput.value = JSON.stringify(imageInfo);
            document.getElementById('mainForm').appendChild(hiddenInput);
        }

        // Event: File upload lokal
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', (e) => {
                const files = e.target.files;
                const fieldName = input.closest('.image-upload-section').getAttribute('data-field-name');

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        addImageToPreview(event.target.result, fieldName);
                    };
                    reader.readAsDataURL(file);
                });

                input.value = '';
            });
        });

        // Event: Upload button
        document.querySelectorAll('.upload-local-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const fileInput = btn.closest('.image-upload-section').querySelector('.file-input');
                if (fileInput) fileInput.click();
            });
        });

        // Event: Camera button
        document.querySelectorAll('.camera-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const fieldName = btn.closest('.image-upload-section').getAttribute('data-field-name');
                openCameraModal(fieldName);
            });
        });
    </script>

</x-app-layout>

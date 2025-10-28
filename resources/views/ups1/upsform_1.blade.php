<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg md:text-xl text-gray-800 leading-tight">
            {{ isset($maintenance) ? 'Edit Data UPS 1 Phase' : 'Input Data Preventive Maintenance UPS 1 Phase' }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6">
                    <!-- Modal Camera -->
                    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-0 md:p-4">
                        <div class="bg-white rounded-lg w-full md:max-w-2xl h-screen md:h-auto md:max-h-screen overflow-y-auto flex flex-col">
                            <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                                <h2 class="text-lg font-bold">Ambil Foto</h2>
                                <button id="closeModalBtn" type="button" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
                            </div>

                            <div class="flex-1 flex flex-col overflow-y-auto">
                                <div id="geoInfo" class="m-4 p-3 bg-blue-50 rounded border border-blue-200 text-xs space-y-1">
                                    <p><strong>Latitude:</strong> <span id="lat">-</span></p>
                                    <p><strong>Longitude:</strong> <span id="lon">-</span></p>
                                    <p><strong>Tanggal & Waktu:</strong> <span id="datetime">-</span></p>
                                    <p><strong>Lokasi:</strong> <span id="location">-</span></p>
                                </div>

                                <div id="videoSection" class="flex-1 flex bg-black relative mx-4 mt-2 rounded">
                                    <video id="video" class="w-full" playsinline autoplay muted style="transform: scaleX(-1);"></video>
                                </div>

                                <div id="capturedImage" class="hidden mx-4 mt-2">
                                    <img id="capturedImg" class="w-full rounded" alt="Captured">
                                </div>

                                <div class="m-4 space-y-2">
                                    <div id="captureControls" class="flex gap-2">
                                        <button id="captureBtn" type="button" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">Ambil Foto</button>
                                        <button id="switchCameraBtn" type="button" class="px-4 py-3 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">Tukar</button>
                                    </div>
                                    <div id="retakeControls" class="hidden flex gap-2">
                                        <button id="retakeBtn" type="button" class="flex-1 px-4 py-3 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">Ulangi</button>
                                        <button id="usePhotoBtn" type="button" class="flex-1 px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">Gunakan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <canvas id="canvas" class="hidden"></canvas>

                    @php
                        // Helper function untuk safely get nilai field
                        function safeGetValue($maintenance, $fieldName, $default = '') {
                            if (!isset($maintenance)) {
                                return $default;
                            }

                            if (!isset($maintenance->{$fieldName})) {
                                return $default;
                            }

                            $value = $maintenance->{$fieldName};

                            // Jika array atau object, return default
                            if (is_array($value) || is_object($value)) {
                                return $default;
                            }

                            // Jika null atau empty string (kecuali "0")
                            if (is_null($value) || ($value === '' && $value !== '0')) {
                                return $default;
                            }

                            return $value;
                        }

                        // Helper untuk get notes (bisa array atau string)
                        function safeGetNotes($maintenance) {
                            if (!isset($maintenance) || !isset($maintenance->notes)) {
                                return '';
                            }

                            $notes = $maintenance->notes;

                            // Jika array, gabungkan dengan newline
                            if (is_array($notes)) {
                                return implode("\n", array_filter($notes));
                            }

                            // Jika object, convert ke JSON string
                            if (is_object($notes)) {
                                return json_encode($notes, JSON_PRETTY_PRINT);
                            }

                            // Return as string
                            return (string) $notes;
                        }

                        // Helper untuk get existing images by category
                        function getExistingImages($maintenance, $category) {
                            if (!isset($maintenance) || !isset($maintenance->images)) {
                                return [];
                            }

                            $images = $maintenance->images;

                            if (!is_array($images)) {
                                return [];
                            }

                            return array_filter($images, function($img) use ($category) {
                                return isset($img['category']) && $img['category'] === $category;
                            });
                        }
                    @endphp

                    <form action="{{ isset($maintenance) ? route('ups1.update', $maintenance->id) : route('ups1.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        @if(isset($maintenance)) @method('PUT') @endif

                        <div class="mb-6 pb-4 border-b border-gray-300">
                            <p class="text-xs text-gray-600">No. Dok: FM-LAP-D2-SOP-003-001 | Versi: 1.0 | Label: Internal</p>
                        </div>

                        <!-- Informasi Lokasi dan Perangkat -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-blue-500">
                                Informasi Lokasi dan Perangkat
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Location <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="location"
                                           value="{{ old('location', safeGetValue($maintenance ?? null, 'location')) }}"
                                           placeholder="DPSTKU (LA Teuku Umar)"
                                           class="input-field" required>
                                    @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Date / Time <span class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $dateTimeValue = '';
                                        if (old('date_time')) {
                                            $dateTimeValue = old('date_time');
                                        } elseif (isset($maintenance) && isset($maintenance->date_time)) {
                                            try {
                                                $dateTimeValue = \Carbon\Carbon::parse($maintenance->date_time)->format('Y-m-d\TH:i');
                                            } catch (\Exception $e) {
                                                $dateTimeValue = '';
                                            }
                                        }
                                    @endphp
                                    <input type="datetime-local" name="date_time"
                                           value="{{ $dateTimeValue }}"
                                           class="input-field" required>
                                    @error('date_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Brand / Type <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="brand_type"
                                           value="{{ old('brand_type', safeGetValue($maintenance ?? null, 'brand_type')) }}"
                                           placeholder="Contoh: APC Smart-UPS 3KVA"
                                           class="input-field" required>
                                    @error('brand_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Kapasitas <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="capacity"
                                           value="{{ old('capacity', safeGetValue($maintenance ?? null, 'capacity')) }}"
                                           placeholder="Contoh: 3 KVA"
                                           class="input-field" required>
                                    @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Reg. Number
                                    </label>
                                    <input type="text" name="reg_number"
                                           value="{{ old('reg_number', safeGetValue($maintenance ?? null, 'reg_number')) }}"
                                           placeholder="Contoh: UPS1-001"
                                           class="input-field">
                                    @error('reg_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        S/N
                                    </label>
                                    <input type="text" name="sn"
                                           value="{{ old('sn', safeGetValue($maintenance ?? null, 'sn')) }}"
                                           placeholder="Contoh: ABC123456789"
                                           class="input-field">
                                    @error('sn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Visual Check -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-green-500">
                                1. Visual Check
                            </h3>
                            @php
                                $visualChecks = [
                                    ['env_condition', 'a. Environmental Condition', 'Contoh: Bersih, tidak berdebu', 'Standard: Clean, No dust'],
                                    ['led_display', 'b. LED / Display', 'Contoh: Normal, menyala dengan baik', 'Standard: Normal'],
                                    ['battery_connection', 'c. Battery Connection', 'Contoh: Kencang, tidak ada korosi', 'Standard: Tighten, No Corrosion'],
                                ];
                            @endphp
                            @foreach($visualChecks as $check)
                                <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                                        {{ $check[1] }} <span class="text-red-500">*</span>
                                    </label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Hasil Pemeriksaan:</label>
                                            <input type="text" name="{{ $check[0] }}"
                                                   value="{{ old($check[0], safeGetValue($maintenance ?? null, $check[0])) }}"
                                                   placeholder="{{ $check[2] }}"
                                                   class="input-field" required>
                                            <p class="text-xs text-gray-500 mt-1">{{ $check[3] }}</p>
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Status:</label>
                                            <div class="flex gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="status_{{ $check[0] }}" value="{{ $status }}"
                                                               {{ old("status_{$check[0]}", safeGetValue($maintenance ?? null, "status_{$check[0]}", 'OK')) == $status ? 'checked' : '' }}
                                                               class="form-radio h-4 w-4 text-blue-600" required>
                                                        <span class="ml-2 text-sm text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="visual_check_{{ $check[0] }}">
                                            <label class="block text-xs text-gray-600 mb-1.5">Dokumentasi Foto:</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'visual_check_'.$check[0]) as $img)
                                                        @if(isset($img['path']))
                                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-20 object-cover rounded border">
                                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Performance and Capacity Check -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-purple-500">
                                2. Performance and Capacity Check
                            </h3>

                            <!-- Single Phase Measurements -->
                            @php
                                $singleMeasurements = [
                                    ['a. AC input voltage', 'ac_input_voltage', 'Volt', '220', 'Standard: 180-240 VAC', 'number'],
                                    ['b. AC output voltage', 'ac_output_voltage', 'Volt', '220', 'Standard: 210-230 VAC', 'number'],
                                    ['c. Neutral-Ground voltage', 'neutral_ground_voltage', 'Volt', '0', 'Standard: ≤ 2 VAC', 'number'],
                                    ['d. AC current input', 'ac_current_input', 'Amp', '5', 'Standard: Sesuai kapasitas UPS', 'number'],
                                    ['e. AC current output', 'ac_current_output', 'Amp', '3', 'Standard: Sesuai kapasitas UPS', 'number'],
                                    ['f. UPS temperature', 'ups_temperature', '°C', '25', 'Standard: 0-40 °C', 'number'],
                                    ['g. Output frequency', 'output_frequency', 'Hz', '50', 'Standard: 48.75-50.25 Hz', 'number'],
                                    ['h. Charging voltage', 'charging_voltage', 'Volt', '270', 'Standard: See Battery Performance table', 'number'],
                                    ['i. Charging current', 'charging_current', 'Amp', '0', 'Standard: 0 Ampere, on-line mode', 'number'],
                                    ['j. Fan', 'fan', '', 'Normal', 'Standard: Normal operation, no abnormal noise', 'text'],
                                ];
                            @endphp
                            @foreach($singleMeasurements as $measure)
                                <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                                        {{ $measure[0] }} <span class="text-red-500">*</span>
                                    </label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Hasil Pengukuran:</label>
                                            @if($measure[5] === 'text')
                                                <input type="text" name="{{ $measure[1] }}"
                                                    value="{{ old($measure[1], safeGetValue($maintenance ?? null, $measure[1])) }}"
                                                    placeholder="{{ $measure[3] }}"
                                                    class="input-field" required>
                                            @else
                                                <input type="number" step="0.01" name="{{ $measure[1] }}"
                                                    value="{{ old($measure[1], safeGetValue($maintenance ?? null, $measure[1])) }}"
                                                    placeholder="{{ $measure[3] }}"
                                                    class="input-field" required>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">{{ $measure[4] }}</p>
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Status:</label>
                                            <div class="flex gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="status_{{ $measure[1] }}" value="{{ $status }}"
                                                            {{ old("status_{$measure[1]}", safeGetValue($maintenance ?? null, "status_{$measure[1]}", 'OK')) == $status ? 'checked' : '' }}
                                                            class="form-radio h-4 w-4 text-blue-600" required>
                                                        <span class="ml-2 text-sm text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="performance_{{ $measure[1] }}">
                                            <label class="block text-xs text-gray-600 mb-1.5">Dokumentasi Foto:</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'performance_'.$measure[1]) as $img)
                                                        @if(isset($img['path']))
                                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-20 object-cover rounded border">
                                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Backup Tests -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-orange-500">
                                3. Backup Tests
                            </h3>

                            @php
                                $backupTests = [
                                    ['a. UPS switching test (Normal to Battery)', 'ups_switching_test', 'text', 'Contoh: Success, switchover <10ms', 'Standard: Success'],
                                    ['b. Battery voltage measurement 1 (5 minutes after test)', 'battery_voltage_measurement_1', 'number', '12.5', 'Standard: ≥12.0V per cell'],
                                    ['c. Battery voltage measurement 2 (10 minutes after test)', 'battery_voltage_measurement_2', 'number', '12.3', 'Standard: ≥11.8V per cell'],
                                ];
                            @endphp
                            @foreach($backupTests as $test)
                                <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                                        {{ $test[0] }} <span class="text-red-500">*</span>
                                    </label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Hasil Test:</label>
                                            @if($test[2] === 'number')
                                                <input type="number" step="0.01" name="{{ $test[1] }}"
                                                    value="{{ old($test[1], safeGetValue($maintenance ?? null, $test[1])) }}"
                                                    placeholder="{{ $test[3] }}"
                                                    class="input-field" required>
                                            @else
                                                <input type="text" name="{{ $test[1] }}"
                                                    value="{{ old($test[1], safeGetValue($maintenance ?? null, $test[1])) }}"
                                                    placeholder="{{ $test[3] }}"
                                                    class="input-field" required>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">{{ $test[4] }}</p>
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Status:</label>
                                            <div class="flex gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="status_{{ $test[1] }}" value="{{ $status }}"
                                                            {{ old("status_{$test[1]}", safeGetValue($maintenance ?? null, "status_{$test[1]}", 'OK')) == $status ? 'checked' : '' }}
                                                            class="form-radio h-4 w-4 text-blue-600" required>
                                                        <span class="ml-2 text-sm text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="backup_{{ $test[1] }}">
                                            <label class="block text-xs text-gray-600 mb-1.5">Dokumentasi Foto:</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'backup_'.$test[1]) as $img)
                                                        @if(isset($img['path']))
                                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-20 object-cover rounded border">
                                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Power Alarm Monitoring Test -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-red-500">
                                4. Power Alarm Monitoring Test
                            </h3>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">
                                    SIMONICA Alarm Test <span class="text-red-500">*</span>
                                </label>

                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1.5">Hasil Test:</label>
                                        <input type="text" name="simonica_alarm_test"
                                            value="{{ old('simonica_alarm_test', safeGetValue($maintenance ?? null, 'simonica_alarm_test')) }}"
                                            placeholder="Contoh: Alarm triggered successfully"
                                            class="input-field" required>
                                        <p class="text-xs text-gray-500 mt-1">Standard: Alarm responds correctly</p>
                                    </div>

                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1.5">Status:</label>
                                        <div class="flex gap-4">
                                            @foreach(['OK', 'NOK'] as $status)
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="status_simonica_alarm_test" value="{{ $status }}"
                                                        {{ old('status_simonica_alarm_test', safeGetValue($maintenance ?? null, 'status_simonica_alarm_test', 'OK')) == $status ? 'checked' : '' }}
                                                        class="form-radio h-4 w-4 text-blue-600" required>
                                                    <span class="ml-2 text-sm text-gray-700">{{ $status }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="image-upload-section" data-field-name="alarm_simonica_alarm_test">
                                        <label class="block text-xs text-gray-600 mb-1.5">Dokumentasi Foto:</label>
                                        <div class="flex gap-2 mb-2">
                                            <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                            <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                        </div>
                                        <input type="file" class="file-input hidden" accept="image/*" multiple>
                                        <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                            @if(isset($maintenance))
                                                @foreach(getExistingImages($maintenance, 'alarm_simonica_alarm_test') as $img)
                                                    @if(isset($img['path']))
                                                        <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                            <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-20 object-cover rounded border">
                                                            <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-yellow-500">
                                Notes / Additional Informations
                            </h3>
                            <label class="block text-xs text-gray-600 mb-1.5">Catatan Tambahan:</label>
                            <textarea name="notes" class="input-field" rows="4" placeholder="Tuliskan catatan atau informasi tambahan di sini...">{{ old('notes', safeGetNotes($maintenance ?? null)) }}</textarea>
                        </div>

                        <!-- Personnel -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-indigo-500">
                                Pelaksana / Mengetahui
                            </h3>
                            <div class="space-y-4">
                                @php
                                    $personnel = [
                                        ['executor_1', 'Pelaksana 1', true, 'Nama teknisi pelaksana'],
                                        ['executor_2', 'Pelaksana 2', false, 'Nama teknisi pendamping (opsional)'],
                                        ['supervisor', 'Mengetahui (Supervisor)', true, 'Nama supervisor'],
                                        ['supervisor_id_number', 'ID Supervisor', false, 'Nomor ID supervisor (opsional)'],
                                        ['department', 'Department', false, 'Nama department (opsional)'],
                                        ['sub_department', 'Sub Department', false, 'Nama sub department (opsional)'],
                                    ];
                                @endphp
                                @foreach($personnel as $field)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                            {{ $field[1] }} @if($field[2]) <span class="text-red-500">*</span> @endif
                                        </label>
                                        <input type="text" name="{{ $field[0] }}"
                                               value="{{ old($field[0], safeGetValue($maintenance ?? null, $field[0])) }}"
                                               placeholder="{{ $field[3] }}"
                                               class="input-field" @if($field[2]) required @endif>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-300">
                            <a href="{{ route('ups1.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-semibold text-xs uppercase hover:bg-gray-400 transition">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase hover:bg-blue-700 transition">
                                {{ isset($maintenance) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .input-field {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.5;
            color: #374151;
            background-color: #ffffff;
            transition: all 0.15s ease-in-out;
        }

        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .input-field::placeholder {
            color: #9ca3af;
        }

        .form-radio:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    <script src="{{ asset('js/ups1form.js') }}"></script>
</x-app-layout>

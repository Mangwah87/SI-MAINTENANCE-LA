<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($maintenance) ? 'Edit Data Preventive Maintenance 3 Phase UPS' : 'Input Data Preventive Maintenance 3 Phase UPS' }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
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

                    <form action="{{ isset($maintenance) ? route('ups3.update', $maintenance->id) : route('ups3.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        @if(isset($maintenance)) @method('PUT') @endif

                        <!-- Informasi Lokasi dan Perangkat -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Informasi Lokasi & Perangkat
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Location <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="location"
                                        value="{{ old('location', safeGetValue($maintenance ?? null, 'location')) }}"
                                        placeholder="DPSTKU (LA Teuku Umar)"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                    @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal <span class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $dateValue = old('date');
                                        if (!$dateValue && isset($maintenance->date_time)) {
                                            try {
                                                $dateValue = \Carbon\Carbon::parse($maintenance->date_time)->format('Y-m-d');
                                            } catch (\Exception $e) {
                                                $dateValue = date('Y-m-d');
                                            }
                                        }
                                        if (!$dateValue) {
                                            $dateValue = date('Y-m-d');
                                        }
                                    @endphp
                                    <input type="date" id="ups3_date_input" name="date"
                                        value="{{ $dateValue }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                    @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Waktu <span class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $timeValue = old('time');
                                        if (!$timeValue && isset($maintenance->date_time)) {
                                            try {
                                                $timeValue = \Carbon\Carbon::parse($maintenance->date_time)->format('H:i');
                                            } catch (\Exception $e) {
                                                $timeValue = date('H:i');
                                            }
                                        }
                                        if (!$timeValue) {
                                            $timeValue = date('H:i');
                                        }
                                    @endphp
                                    <input type="time" id="ups3_time_input" name="time"
                                        value="{{ $timeValue }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                    @error('time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Hidden field untuk date_time -->
                                <input type="hidden" id="ups3_date_time_hidden" name="date_time" value="">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Brand / Type <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="brand_type"
                                        value="{{ old('brand_type', safeGetValue($maintenance ?? null, 'brand_type')) }}"
                                        placeholder="Contoh: APC Smart-UPS 10KVA"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                    @error('brand_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kapasitas <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="capacity"
                                        value="{{ old('capacity', safeGetValue($maintenance ?? null, 'capacity')) }}"
                                        placeholder="Contoh: 10 KVA"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                    @error('capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number</label>
                                    <input type="text" name="reg_number"
                                        value="{{ old('reg_number', safeGetValue($maintenance ?? null, 'reg_number')) }}"
                                        placeholder="Contoh: UPS-001"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('reg_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">S/N</label>
                                    <input type="text" name="sn"
                                        value="{{ old('sn', safeGetValue($maintenance ?? null, 'sn')) }}"
                                        placeholder="Contoh: ABC123456789"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('sn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Visual Check -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                1. Visual Check
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                @php
                                    $visualChecks = [
                                        ['env_condition', 'a. Environmental Condition', 'Contoh: Bersih, tidak berdebu', 'Clean, No dust'],
                                        ['led_display', 'b. LED / Display', 'Contoh: Normal, menyala dengan baik', 'Normal'],
                                        ['battery_connection', 'c. Battery Connection', 'Contoh: Kencang, tidak ada korosi', 'Tighten, No Corrosion'],
                                    ];
                                @endphp
                                @foreach($visualChecks as $check)
                                    <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $check[1] }}</label>
                                        <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                            <strong>Operational Standard:</strong> {{ $check[3] }}
                                        </div>

                                        <div class="space-y-3">
                                            <div>
                                                <input type="text" name="{{ $check[0] }}"
                                                       value="{{ old($check[0], safeGetValue($maintenance ?? null, $check[0])) }}"
                                                       placeholder="{{ $check[2] }}"
                                                       class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base" required>
                                            </div>

                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach(['OK', 'NOK'] as $status)
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" name="status_{{ $check[0] }}" value="{{ $status }}"
                                                                   {{ old("status_{$check[0]}", safeGetValue($maintenance ?? null, "status_{$check[0]}", 'OK')) == $status ? 'checked' : '' }}
                                                                   class="form-radio {{ $status === 'OK' ? 'text-blue-600 focus:ring-blue-500' : 'text-blue-600 focus:ring-blue-500' }}" required>
                                                            <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="image-upload-section" data-field-name="visual_check_{{ $check[0] }}">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
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
                        </div>

                        <!-- Performance and Capacity Check -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                2. Performance and Capacity Check
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <!-- AC Measurements with 3 inputs and individual photo uploads -->
                                @php
                                    $acMeasurements = [
                                        ['ac_input_voltage', 'a. AC input voltage', ['RS', 'ST', 'TR'], 'Volt', '360-400 VAC'],
                                        ['ac_output_voltage', 'b. AC output voltage', ['RS', 'ST', 'TR'], 'Volt', '370-390 VAC'],
                                        ['ac_current_input', 'c. AC current input', ['R', 'S', 'T'], 'Amp', 'Sesuai kapasitas UPS'],
                                        ['ac_current_output', 'd. AC current output', ['R', 'S', 'T'], 'Amp', 'Sesuai kapasitas UPS'],
                                    ];
                                @endphp
                                @foreach($acMeasurements as $measure)
                                    <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $measure[1] }}</label>
                                        <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                            <strong>Operational Standard:</strong> {{ $measure[4] }}
                                        </div>

                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1.5">Pengukuran per Phase:</label>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    @foreach($measure[2] as $phase)
                                                        @php
                                                            $fieldName = $measure[0] . '_' . strtolower($phase);
                                                            $photoFieldName = 'performance_' . $measure[0] . '_' . strtolower($phase);
                                                        @endphp
                                                        <div class="border rounded-lg p-3 bg-white">
                                                            <label class="block text-xs font-semibold text-gray-700 mb-2">Phase {{ $phase }}</label>
                                                            <input type="number" step="0.1" name="{{ $fieldName }}"
                                                                value="{{ old($fieldName, safeGetValue($maintenance ?? null, $fieldName)) }}"
                                                                placeholder="0.0"
                                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2" required>

                                                            <!-- Photo upload for this phase -->
                                                            <div class="image-upload-section" data-field-name="{{ $photoFieldName }}">
                                                                <label class="block text-xs text-gray-600 mb-1.5">Foto Phase {{ $phase }}:</label>
                                                                <div class="flex gap-2 mb-2">
                                                                    <button type="button" class="upload-local-btn px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                                                    <button type="button" class="camera-btn px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                                                </div>
                                                                <input type="file" class="file-input hidden" accept="image/*" multiple>
                                                                <div class="preview-container grid grid-cols-2 gap-2">
                                                                    @if(isset($maintenance))
                                                                        @foreach(getExistingImages($maintenance, $photoFieldName) as $img)
                                                                            @if(isset($img['path']))
                                                                                <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                                                    <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-16 object-cover rounded border">
                                                                                    <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status Overall <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach(['OK', 'NOK'] as $status)
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" name="status_{{ $measure[0] }}" value="{{ $status }}"
                                                                {{ old("status_{$measure[0]}", safeGetValue($maintenance ?? null, "status_{$measure[0]}", 'OK')) == $status ? 'checked' : '' }}
                                                                class="form-radio {{ $status === 'OK' ? 'text-blue-600 focus:ring-blue-500' : 'text-blue-600 focus:ring-blue-500' }}" required>
                                                            <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Single measurements -->
                                @php
                                    $singleMeasurements = [
                                        ['e. UPS temperature', 'ups_temperature', '°C', '25', '0-40 °C'],
                                        ['f. Output frequency', 'output_frequency', 'Hz', '50', '48.75-50.25 Hz'],
                                        ['g. Charging voltage', 'charging_voltage', 'Volt', '270', 'See Battery Performance table'],
                                        ['h. Charging current', 'charging_current', 'Amp', '0', '0 Ampere, on-line mode'],
                                    ];
                                @endphp
                                @foreach($singleMeasurements as $measure)
                                    <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $measure[0] }}</label>
                                        <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                            <strong>Operational Standard:</strong> {{ $measure[4] }}
                                        </div>

                                        <div class="space-y-3">
                                            <div>
                                                <input type="number" step="0.01" name="{{ $measure[1] }}"
                                                    value="{{ old($measure[1], safeGetValue($maintenance ?? null, $measure[1])) }}"
                                                    placeholder="{{ $measure[3] }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base" required>
                                            </div>

                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach(['OK', 'NOK'] as $status)
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" name="status_{{ $measure[1] }}" value="{{ $status }}"
                                                                {{ old("status_{$measure[1]}", safeGetValue($maintenance ?? null, "status_{$measure[1]}", 'OK')) == $status ? 'checked' : '' }}
                                                                class="form-radio {{ $status === 'OK' ? 'text-blue-600 focus:ring-blue-500' : 'text-blue-600 focus:ring-blue-500' }}" required>
                                                            <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="image-upload-section" data-field-name="performance_{{ $measure[1] }}">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
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
                        </div>

                        <!-- Notes -->
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan / Additional Informations</label>
                            <textarea name="notes" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                      placeholder="Tambahkan catatan atau informasi tambahan di sini...">{{ old('notes', safeGetNotes($maintenance ?? null)) }}</textarea>
                        </div>

                        <!-- Personnel -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">Pelaksana</h3>
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pelaksana 1 <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="executor_1"
                                           value="{{ old('executor_1', safeGetValue($maintenance ?? null, 'executor_1')) }}"
                                           placeholder="Nama teknisi pelaksana"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelaksana 2</label>
                                    <input type="text" name="executor_2"
                                           value="{{ old('executor_2', safeGetValue($maintenance ?? null, 'executor_2')) }}"
                                           placeholder="Nama teknisi pendamping (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelaksana 3</label>
                                    <input type="text" name="executor_3"
                                           value="{{ old('executor_3', safeGetValue($maintenance ?? null, 'executor_3')) }}"
                                           placeholder="Nama teknisi pendamping (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                    <input type="text" name="department"
                                           value="{{ old('department', safeGetValue($maintenance ?? null, 'department')) }}"
                                           placeholder="Nama department (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub Department</label>
                                    <input type="text" name="sub_department"
                                           value="{{ old('sub_department', safeGetValue($maintenance ?? null, 'sub_department')) }}"
                                           placeholder="Nama sub department (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                </div>
                            </div>
                        </div>

                        <!-- Supervisor -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">Mengetahui</h3>
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Supervisor <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="supervisor"
                                           value="{{ old('supervisor', safeGetValue($maintenance ?? null, 'supervisor')) }}"
                                           placeholder="Nama supervisor"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Supervisor</label>
                                    <input type="text" name="supervisor_id_number"
                                           value="{{ old('supervisor_id_number', safeGetValue($maintenance ?? null, 'supervisor_id_number')) }}"
                                           placeholder="Nomor ID supervisor (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('ups3.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center text-sm sm:text-base">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm sm:text-base">
                                {{ isset($maintenance) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/ups3form.js') }}"></script>
</x-app-layout>

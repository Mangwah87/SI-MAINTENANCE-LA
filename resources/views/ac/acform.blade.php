<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($maintenance) ? 'Edit Data Preventive Maintenance AC' : 'Tambah Data Preventive Maintenance AC' }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

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
                                    <video id="video" class="w-full" playsinline autoplay muted></video>
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
                        function safeGetValue($maintenance, $fieldName, $default = '') {
                            if (!isset($maintenance)) return $default;
                            if (!isset($maintenance->{$fieldName})) return $default;
                            $value = $maintenance->{$fieldName};
                            if (is_array($value) || is_object($value)) return $default;
                            if (is_null($value) || ($value === '' && $value !== '0')) return $default;
                            return $value;
                        }

                        function safeGetNotes($maintenance) {
                            if (!isset($maintenance) || !isset($maintenance->notes)) return '';
                            $notes = $maintenance->notes;
                            if (is_array($notes)) return implode("\n", array_filter($notes));
                            if (is_object($notes)) return json_encode($notes, JSON_PRETTY_PRINT);
                            return (string) $notes;
                        }

                        function getExistingImages($maintenance, $category) {
                            if (!isset($maintenance) || !isset($maintenance->images)) return [];
                            $images = $maintenance->images;
                            if (!is_array($images)) return [];
                            return array_filter($images, function($img) use ($category) {
                                return isset($img['category']) && $img['category'] === $category;
                            });
                        }
                    @endphp

                    <form action="{{ isset($maintenance) ? route('ac.update', $maintenance->id) : route('ac.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="mainForm">
                        @csrf
                        @if(isset($maintenance))
                            @method('PUT')
                        @endif

                        <!-- Informasi Lokasi dan Perangkat -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Informasi Lokasi & Perangkat
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Lokasi Sentral
                                    </label>
                                    <select name="central_id" id="central_id"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                          >
                                        <option value="">-- Pilih Lokasi Sentral --</option>
                                        @foreach($centrals as $central)
                                            <option value="{{ $central->id }}"
                                                    {{ old('central_id', isset($maintenance) ? $maintenance->central_id : '') == $central->id ? 'selected' : '' }}
                                                    data-area="{{ $central->area }}"
                                                    data-id-sentral="{{ $central->id_sentral }}">
                                                {{ $central->nama }} - {{ $central->area }} ({{ $central->id_sentral }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('central_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal
                                    </label>
                                    @php
                                        $dateValue = '';
                                        if (old('date')) {
                                            $dateValue = old('date');
                                        } elseif (isset($maintenance) && isset($maintenance->date_time)) {
                                            try {
                                                $dateValue = \Carbon\Carbon::parse($maintenance->date_time)->format('Y-m-d');
                                            } catch (\Exception $e) {
                                                $dateValue = date('Y-m-d');
                                            }
                                        } else {
                                            $dateValue = date('Y-m-d');
                                        }
                                    @endphp
                                    <input type="date" id="date_input" name="date"
                                        value="{{ $dateValue }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Waktu
                                    </label>
                                    @php
                                        $timeValue = '';
                                        if (old('time')) {
                                            $timeValue = old('time');
                                        } elseif (isset($maintenance) && isset($maintenance->date_time)) {
                                            try {
                                                $timeValue = \Carbon\Carbon::parse($maintenance->date_time)->format('H:i');
                                            } catch (\Exception $e) {
                                                $timeValue = date('H:i');
                                            }
                                        } else {
                                            $timeValue = date('H:i');
                                        }
                                    @endphp
                                    <input type="time" id="time_input" name="time"
                                        value="{{ $timeValue }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Hidden field untuk date_time yang akan dikirim ke controller -->
                                <input type="hidden" id="date_time_hidden" name="date_time">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Brand / Type
                                    </label>
                                    <input type="text" name="brand_type"
                                        value="{{ old('brand_type', safeGetValue($maintenance ?? null, 'brand_type')) }}"
                                        placeholder="Contoh: Daikin Split 2PK"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('brand_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kapasitas (...PK)
                                    </label>
                                    <input type="text" name="capacity"
                                        value="{{ old('capacity', safeGetValue($maintenance ?? null, 'capacity')) }}"
                                        placeholder="Contoh: 2 PK"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number</label>
                                    <input type="text" name="reg_number"
                                        value="{{ old('reg_number', safeGetValue($maintenance ?? null, 'reg_number')) }}"
                                        placeholder="Contoh: AC-001"
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

                        <!-- Physical Check -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                1. Physical Check
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                @php
                                    $physicalChecks = [
                                        ['environment_condition', 'a. Environment Condition', 'Contoh: Bersih, tidak berdebu', 'No dust'],
                                        ['filter', 'b. Filter', 'Contoh: Bersih, tidak tersumbat', 'Clean, No dust'],
                                        ['evaporator', 'c. Evaporator', 'Contoh: Bersih, tidak ada kebocoran', 'Clean, No dust'],
                                        ['led_display', 'd. LED & display (include remote control)', 'Contoh: Normal, menyala dengan baik', 'Normal'],
                                        ['air_flow', 'e. Air Flow', 'Contoh: Normal, cool air flow', 'Fan operates normally, cool air flow'],
                                    ];
                                @endphp
                                @foreach($physicalChecks as $check)
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
                                                       class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base">
                                            </div>

                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach(['OK', 'NOK'] as $status)
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" name="status_{{ $check[0] }}" value="{{ $status }}"
                                                                   {{ old("status_{$check[0]}", safeGetValue($maintenance ?? null, "status_{$check[0]}")) == $status ? 'checked' : '' }}
                                                                   class="form-radio text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="image-upload-section" data-field-name="physical_check_{{ $check[0] }}">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
                                                <div class="flex gap-2 mb-2">
                                                    <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                    <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                                </div>
                                                <input type="file" class="file-input hidden" accept="image/*" multiple>
                                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                    @if(isset($maintenance))
                                                        @foreach(getExistingImages($maintenance, 'physical_check_'.$check[0]) as $img)
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

                        <!-- PSI Pressure -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                2. PSI Pressure
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                @php
                                    $psiPressures = [
                                        ['psi_pressure', 'Standard PSI Pressure Form Type Freon', 'psi', '140-150', 'R32: 140 psi - 150 psi / R410: 140 psi - 150 psi', 'status_psi_pressure'],
                                    ];
                                @endphp
                                @foreach($psiPressures as $psi)
                                    <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $psi[1] }}</label>
                                        <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                            <strong>Operational Standard:</strong> {{ $psi[4] }}
                                        </div>

                                        <div class="space-y-3">
                                            <div>
                                                <input type="number" step="0.01" name="{{ $psi[0] }}"
                                                       value="{{ old($psi[0], safeGetValue($maintenance ?? null, $psi[0])) }}"
                                                       placeholder="Masukkan nilai {{ $psi[3] }} {{ $psi[2] }}"
                                                       class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base">
                                            </div>

                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach(['OK', 'NOK'] as $status)
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" name="{{ $psi[5] }}" value="{{ $status }}"
                                                                   {{ old($psi[5], safeGetValue($maintenance ?? null, $psi[5])) == $status ? 'checked' : '' }}
                                                                   class="form-radio text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="image-upload-section" data-field-name="psi_pressure_{{ $psi[0] }}">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
                                                <div class="flex gap-2 mb-2">
                                                    <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                    <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                                </div>
                                                <input type="file" class="file-input hidden" accept="image/*" multiple>
                                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                    @if(isset($maintenance))
                                                        @foreach(getExistingImages($maintenance, 'psi_pressure_'.$psi[0]) as $img)
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

                        <!-- Input Current Air Cond -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                3. Input Current Air Cond
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Input Current AC</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong><br>
                                        ¾-1 PK ≤ 4 A | 2 PK ≤ 10 A
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <input type="number" step="0.01" name="input_current_ac"
                                                   value="{{ old('input_current_ac', safeGetValue($maintenance ?? null, 'input_current_ac')) }}"
                                                   placeholder="Masukkan nilai dalam Ampere (A)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base">
                                        </div>

                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Status</label>
                                            <div class="flex flex-wrap gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="status_input_current_ac" value="{{ $status }}"
                                                               {{ old('status_input_current_ac', safeGetValue($maintenance ?? null, 'status_input_current_ac')) == $status ? 'checked' : '' }}
                                                               class="form-radio text-blue-600 focus:ring-blue-500">
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="input_current_ac">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'input_current_ac') as $img)
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
                        </div>

                        <!-- Output Temperature AC -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                4. Output Temperature AC
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Output Temperature AC</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> 16 - 20°C
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <input type="number" step="0.01" name="output_temperature_ac"
                                                   value="{{ old('output_temperature_ac', safeGetValue($maintenance ?? null, 'output_temperature_ac')) }}"
                                                   placeholder="Masukkan nilai dalam °C"
                                                   class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base">
                                        </div>

                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Status</label>
                                            <div class="flex flex-wrap gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="status_output_temperature_ac" value="{{ $status }}"
                                                               {{ old('status_output_temperature_ac', safeGetValue($maintenance ?? null, 'status_output_temperature_ac')) == $status ? 'checked' : '' }}
                                                               class="form-radio text-blue-600 focus:ring-blue-500">
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="output_temperature_ac">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'output_temperature_ac') as $img)
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
                            <div class="space-y-4">
                                @for($i = 1; $i <= 4; $i++)
                                    <div class="border rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pelaksana {{ $i }}</label>

                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Nama</label>
                                                <input type="text" name="executor_{{ $i }}"
                                                       value="{{ old('executor_'.$i, safeGetValue($maintenance ?? null, 'executor_'.$i)) }}"
                                                       placeholder="Nama pelaksana (opsional)"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                            </div>

                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Mitra/Internal</label>
                                                <select name="mitra_internal_{{ $i }}"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Mitra" {{ old('mitra_internal_'.$i, safeGetValue($maintenance ?? null, 'mitra_internal_'.$i)) == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                                                    <option value="Internal" {{ old('mitra_internal_'.$i, safeGetValue($maintenance ?? null, 'mitra_internal_'.$i)) == 'Internal' ? 'selected' : '' }}>Internal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Mengetahui -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">Mengetahui</h3>
                            <div class="space-y-4">
                                <!-- Verifikator -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Verifikator</label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Nama</label>
                                            <input type="text" name="verifikator"
                                                   value="{{ old('verifikator', safeGetValue($maintenance ?? null, 'verifikator')) }}"
                                                   placeholder="Nama verifikator (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">NIK</label>
                                            <input type="text" name="verifikator_nik"
                                                   value="{{ old('verifikator_nik', safeGetValue($maintenance ?? null, 'verifikator_nik')) }}"
                                                   placeholder="NIK verifikator (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                    </div>
                                </div>

                                <!-- Head of Sub Department -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Head of Sub Department</label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Nama</label>
                                            <input type="text" name="head_of_sub_department"
                                                   value="{{ old('head_of_sub_department', safeGetValue($maintenance ?? null, 'head_of_sub_department')) }}"
                                                   placeholder="Nama Head of Sub Department (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">NIK</label>
                                            <input type="text" name="head_of_sub_department_nik"
                                                   value="{{ old('head_of_sub_department_nik', safeGetValue($maintenance ?? null, 'head_of_sub_department_nik')) }}"
                                                   placeholder="NIK Head of Sub Department (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('ac.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center text-sm sm:text-base">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm sm:text-base">
                                {{ isset($maintenance) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/acform.js') }}"></script>
</x-app-layout>

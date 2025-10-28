{{-- Key fixes applied:
1. Fixed form method and CSRF token
2. Removed preventDefault that was blocking submission
3. Fixed image handling
4. Added proper error messages display
5. Added loading state management
--}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg md:text-xl text-gray-800 leading-tight">
            {{ isset($maintenance) ? 'Edit Data Preventive Maintenance AC' : 'Input Data Preventive Maintenance AC' }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            {{-- Success Message --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6">
                    <!-- Modal Camera -->
                    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-0 md:p-4">
                        <div class="bg-white rounded-lg w-full md:max-w-2xl h-screen md:h-auto md:max-h-screen overflow-y-auto flex flex-col">
                            <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                                <h2 class="text-lg font-bold">Ambil Foto</h2>
                                <button id="closeModalBtn" type="button" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
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

                        <div class="mb-6 pb-4 border-b border-gray-300">
                            <p class="text-xs text-gray-600">No. Dok: FM-LAP-D2-SOP-003-003 | Versi: 1.0 | Label: Internal</p>
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
                                           placeholder="Contoh: Daikin Split 2PK"
                                           class="input-field" required>
                                    @error('brand_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Kapasitas <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="capacity"
                                           value="{{ old('capacity', safeGetValue($maintenance ?? null, 'capacity')) }}"
                                           placeholder="Contoh: 2 PK"
                                           class="input-field" required>
                                    @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Reg. Number
                                    </label>
                                    <input type="text" name="reg_number"
                                           value="{{ old('reg_number', safeGetValue($maintenance ?? null, 'reg_number')) }}"
                                           placeholder="Contoh: AC-001"
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
                                    ['environment_condition', 'a. Environment Condition', 'Contoh: Bersih, tidak berdebu', 'Standard: No dust'],
                                    ['filter', 'b. Filter', 'Contoh: Bersih, tidak tersumbat', 'Standard: Clean, No dust'],
                                    ['evaporator', 'c. Evaporator', 'Contoh: Bersih, tidak ada kebocoran', 'Standard: Clean, No dust'],
                                    ['led_display', 'd. LED & display (include remote control)', 'Contoh: Normal, menyala dengan baik', 'Standard: Normal'],
                                    ['air_flow', 'e. Air Flow', 'Contoh: Normal, cool air flow', 'Standard: Fan operates normally, cool air flow'],
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
                                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">&times;</button>
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

                        <!-- Room Temperature -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-purple-500">
                                2. Room Temperature Shelter/ODC
                            </h3>

                            @php
                                $temperatures = [
                                    ['temp_shelter', 'a. Shelter/Ruangan (ODC)', '°C', '22', 'Standard: ≤ 22 °C Shelter/Ruangan', 'status_temp_shelter'],
                                    ['temp_outdoor_cabinet', 'b. Outdoor Cabinet (ODC)', '°C', '28', 'Standard: ≤ 28 °C Outdoor Cabinet (ODC)', 'status_temp_outdoor_cabinet'],
                                ];
                            @endphp
                            @foreach($temperatures as $temp)
                                <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                                        {{ $temp[1] }} <span class="text-red-500">*</span>
                                    </label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Suhu ({{ $temp[2] }}):</label>
                                            <input type="number" step="0.01" name="{{ $temp[0] }}"
                                                   value="{{ old($temp[0], safeGetValue($maintenance ?? null, $temp[0])) }}"
                                                   placeholder="{{ $temp[3] }}"
                                                   class="input-field" required>
                                            <p class="text-xs text-gray-500 mt-1">{{ $temp[4] }}</p>
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Status:</label>
                                            <div class="flex gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="{{ $temp[5] }}" value="{{ $status }}"
                                                               {{ old($temp[5], safeGetValue($maintenance ?? null, $temp[5], 'OK')) == $status ? 'checked' : '' }}
                                                               class="form-radio h-4 w-4 text-blue-600" required>
                                                        <span class="ml-2 text-sm text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="temperature_{{ $temp[0] }}">
                                            <label class="block text-xs text-gray-600 mb-1.5">Dokumentasi Foto:</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'temperature_'.$temp[0]) as $img)
                                                        @if(isset($img['path']))
                                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-20 object-cover rounded border">
                                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">&times;</button>
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

                        <!-- Input Current Air Cond -->
                        <div class="mb-8">
                            <h3 class="text-base font-bold mb-4 text-gray-800 pb-2 border-b-2 border-orange-500">
                                3. Input Current Air Cond
                            </h3>

                            @for($i = 1; $i <= 7; $i++)
                                <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                                        AC {{ $i }}
                                    </label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Input Current (Amp):</label>
                                            <input type="number" step="0.01" name="ac{{ $i }}_current"
                                                   value="{{ old("ac{$i}_current", safeGetValue($maintenance ?? null, "ac{$i}_current")) }}"
                                                   placeholder="Contoh: 5.4"
                                                   class="input-field">
                                            <p class="text-xs text-gray-500 mt-1">
                                                Standard:
                                                @if($i == 1) ¾-1 PK  ≤ 4 A
                                                @elseif($i == 2) 2 PK  ≤ 10 A
                                                @elseif($i == 3) 2.5 PK  ≤ 13.5 A
                                                @elseif($i == 4) 5-7 PK  ≤ 8 A / Phase
                                                @elseif($i == 5) 10 PK  ≤ 15 A / Phase
                                                @elseif($i == 6) 15 PK  ≤ 25 A / Phase
                                                @endif
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1.5">Status:</label>
                                            <div class="flex gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="status_ac{{ $i }}" value="{{ $status }}"
                                                               {{ old("status_ac{$i}", safeGetValue($maintenance ?? null, "status_ac{$i}")) == $status ? 'checked' : '' }}
                                                               class="form-radio h-4 w-4 text-blue-600">
                                                        <span class="ml-2 text-sm text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="image-upload-section" data-field-name="ac_current_ac{{ $i }}">
                                            <label class="block text-xs text-gray-600 mb-1.5">Dokumentasi Foto:</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                                @if(isset($maintenance))
                                                    @foreach(getExistingImages($maintenance, 'ac_current_ac'.$i) as $img)
                                                        @if(isset($img['path']))
                                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-20 object-cover rounded border">
                                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">&times;</button>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
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
                                        ['executor_1', 'Pelaksana 1', false, 'Nama teknisi pelaksana (opsional)'],
                                        ['executor_2', 'Pelaksana 2', false, 'Nama teknisi pendamping (opsional)'],
                                        ['executor_3', 'Pelaksana 3', false, 'Nama teknisi tambahan (opsional)'],
                                        ['supervisor', 'Mengetahui (Supervisor)', false, 'Nama supervisor (opsional)'],
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
                            <a href="{{ route('ac.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-semibold text-xs uppercase hover:bg-gray-400 transition">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase hover:bg-blue-700 transition">
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

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script src="{{ asset('js/acform.js') }}"></script>
</x-app-layout>

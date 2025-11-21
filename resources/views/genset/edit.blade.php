<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Form Preventive Maintenance Genset') }}
            </h2>
            <a href="{{ route('genset.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg">
                <i data-lucide="arrow-left" class="h-5 w-5 mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

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
    <div id="fileInputContainer" class="hidden"></div>

    {{-- PHP Helper untuk mengambil gambar lama --}}
    @php
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

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('genset.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data" id="genset-form">
                @csrf
                @method('PUT') {{-- PENTING UNTUK EDIT --}}

                <div id="image-data-container"></div>
                <div id="delete-image-container"></div>

                {{-- ... Bagian Informasi Umum ... --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                       <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
    <select name="location" id="location-select-edit" required
        class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        <option value="">-- Pilih Location --</option>
        @foreach($centralsByArea as $area => $centrals)
            <optgroup label="AREA {{ $area }}">
                @foreach($centrals as $central)
                    <!-- VALUE = ID dari tabel central -->
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
                            <input type="datetime-local" name="maintenance_date" value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d\TH:i')) }}" required class="w-full border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Brand / Type</label>
                            <input type="text" name="brand_type" value="{{ old('brand_type', $maintenance->brand_type) }}" class="w-full border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Capacity</label>
                            <input type="text" name="capacity" value="{{ old('capacity', $maintenance->capacity) }}" class="w-full border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>

                {{-- 1. VISUAL CHECK --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                        $visualChecks = [
                            ['name' => 'environment_condition', 'label' => 'a. Environment Condition', 'std' => 'Clean, No dust'],
                            ['name' => 'engine_oil_press_display', 'label' => 'b. Engine Oil Press. Display', 'std' => 'Normal'],
                            ['name' => 'engine_water_temp_display', 'label' => 'c. Engine Water Temp. Display', 'std' => 'Normal'],
                            ['name' => 'battery_connection', 'label' => 'd. Battery Connection', 'std' => 'Tight, No Corrosion'],
                            ['name' => 'engine_oil_level', 'label' => 'e. Engine Oil Level', 'std' => 'High'],
                            ['name' => 'engine_fuel_level', 'label' => 'f. Engine Fuel Level', 'std' => 'High'],
                            ['name' => 'running_hours', 'label' => 'g. Running Hours', 'std' => 'N/A'],
                            ['name' => 'cooling_water_level', 'label' => 'h. Cooling Water Level', 'std' => 'High'],
                        ];
                        @endphp

                        @foreach($visualChecks as $check)
                        @php $fieldName = $check['name']; @endphp
                        <div class="p-4 border rounded-lg flex flex-col h-full image-upload-section" data-field-name="{{ $fieldName }}">
                            <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                            <p class="text-xs text-gray-500 mb-2">Standard: {{ $check['std'] }}</p>

                            <div class="space-y-2 flex-grow">
                                <input type="text" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full text-sm border-gray-300 rounded-md" placeholder="Result...">
                                <textarea name="{{ $fieldName }}_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment...">{{ old($fieldName.'_comment', $maintenance->{$fieldName.'_comment'}) }}</textarea>
                            </div>

                            <div class="mt-2 space-y-2">
                                <div class="flex gap-2">
                                    <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                    <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 gap-2">
                                    {{-- MENAMPILKAN GAMBAR LAMA --}}
                                    @foreach(getExistingImages($maintenance, $fieldName) as $img)
                                        <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                            <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-24 object-cover rounded border">
                                            <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- 2. ENGINE RUNNING TEST --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">2. Engine Running Test</h3>
                    </div>

                    {{-- I. No Load Test --}}
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="font-bold text-lg text-gray-700 mb-4">I. No Load Test (30 minute)</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- No Load: AC Output Voltage --}}
                            <div class="p-4 border rounded-lg flex flex-col h-full">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">a. AC Output Voltage</label>
                                <div class="space-y-4 flex-grow">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(['rs', 'st', 'tr', 'rn', 'sn', 'tn'] as $phase)
                                        @php $name = 'no_load_ac_voltage_' . $phase; @endphp
                                        <div class="border rounded-lg p-3 bg-gray-50 image-upload-section" data-field-name="{{ $name }}">
                                            <label class="block text-xs font-semibold text-gray-700 mb-2">Phase {{ strtoupper(implode(' - ', str_split($phase))) }}</label>
                                            <input type="text" name="{{ $name }}" value="{{ old($name, $maintenance->{$name}) }}" class="w-full text-sm border-gray-300 rounded-md mb-2" placeholder="Volt">
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                                <button type="button" class="camera-btn px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                            </div>
                                            <div class="preview-container grid grid-cols-2 gap-2">
                                                @foreach(getExistingImages($maintenance, $name) as $img)
                                                    <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                        <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-24 object-cover rounded border">
                                                        <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        <textarea name="no_load_ac_voltage_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment...">{{ old('no_load_ac_voltage_comment', $maintenance->no_load_ac_voltage_comment) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Other No Load Tests --}}
                            @php
                            $noLoadTests = [
                                ['name' => 'no_load_output_frequency', 'label' => 'b. Output Frequency', 'std' => 'Max 53.00 Hz'],
                                ['name' => 'no_load_battery_charging_current', 'label' => 'c. Battery Charging Current', 'std' => 'Max 10 Amp.'],
                                ['name' => 'no_load_engine_cooling_water_temp', 'label' => 'd. Engine Cooling Water Temp.', 'std' => 'Max 90 deg C'],
                                ['name' => 'no_load_engine_oil_press', 'label' => 'e. Engine Oil Press.', 'std' => 'Min 50 Psi'],
                            ];
                            @endphp
                            @foreach($noLoadTests as $test)
                             @php $fieldName = $test['name']; @endphp
                             <div class="p-4 border rounded-lg flex flex-col h-full image-upload-section" data-field-name="{{ $fieldName }}">
                                <label class="block text-sm font-semibold text-gray-700">{{ $test['label'] }}</label>
                                <p class="text-xs text-gray-500 mb-2">Standard: {{ $test['std'] }}</p>
                                <div class="space-y-2 flex-grow">
                                    <input type="text" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full text-sm border-gray-300 rounded-md" placeholder="Result...">
                                    <textarea name="{{ $fieldName }}_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment...">{{ old($fieldName.'_comment', $maintenance->{$fieldName.'_comment'}) }}</textarea>
                                </div>
                                <div class="mt-2 space-y-2">
                                    <div class="flex gap-2">
                                        <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                        <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                    </div>
                                    <div class="preview-container grid grid-cols-3 gap-2">
                                        @foreach(getExistingImages($maintenance, $fieldName) as $img)
                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-24 object-cover rounded border">
                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- II. Load Test --}}
                    <div class="p-6">
                        <h4 class="font-bold text-lg text-gray-700 mb-4">II. Load Test (30 minute)</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Load: AC Output Voltage --}}
                            <div class="p-4 border rounded-lg flex flex-col h-full">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">a. AC Output Voltage</label>
                                <div class="space-y-4 flex-grow">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(['rs', 'st', 'tr', 'rn', 'sn', 'tn'] as $phase)
                                        @php $name = 'load_ac_voltage_' . $phase; @endphp
                                        <div class="border rounded-lg p-3 bg-gray-50 image-upload-section" data-field-name="{{ $name }}">
                                            <label class="block text-xs font-semibold text-gray-700 mb-2">Phase {{ strtoupper(implode(' - ', str_split($phase))) }}</label>
                                            <input type="text" name="{{ $name }}" value="{{ old($name, $maintenance->{$name}) }}" class="w-full text-sm border-gray-300 rounded-md mb-2" placeholder="Volt">
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                                <button type="button" class="camera-btn px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                            </div>
                                            <div class="preview-container grid grid-cols-2 gap-2">
                                                @foreach(getExistingImages($maintenance, $name) as $img)
                                                    <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                        <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-24 object-cover rounded border">
                                                        <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        <textarea name="load_ac_voltage_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment...">{{ old('load_ac_voltage_comment', $maintenance->load_ac_voltage_comment) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Load: AC Output Current --}}
                            <div class="p-4 border rounded-lg flex flex-col h-full">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">b. AC Output Current</label>
                                <div class="space-y-4 flex-grow">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(['r', 's', 't'] as $phase)
                                        @php $name = 'load_ac_current_' . $phase; @endphp
                                        <div class="border rounded-lg p-3 bg-gray-50 image-upload-section" data-field-name="{{ $name }}">
                                            <label class="block text-xs font-semibold text-gray-700 mb-2">Phase {{ strtoupper($phase) }}</label>
                                            <input type="text" name="{{ $name }}" value="{{ old($name, $maintenance->{$name}) }}" class="w-full text-sm border-gray-300 rounded-md mb-2" placeholder="Amp">
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                                <button type="button" class="camera-btn px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                            </div>
                                            <div class="preview-container grid grid-cols-2 gap-2">
                                                @foreach(getExistingImages($maintenance, $name) as $img)
                                                    <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                        <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-24 object-cover rounded border">
                                                        <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        <textarea name="load_ac_current_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment...">{{ old('load_ac_current_comment', $maintenance->load_ac_current_comment) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Other Load Tests --}}
                            @php
                            $loadTests = [
                                ['name' => 'load_output_frequency', 'label' => 'c. Output Frequency', 'std' => '50.00 Hz'],
                                ['name' => 'load_battery_charging_current', 'label' => 'd. Battery Charging Current', 'std' => 'Max 10 Amp.'],
                                ['name' => 'load_engine_cooling_water_temp', 'label' => 'e. Engine Cooling Water Temp.', 'std' => 'Max 90 deg C'],
                                ['name' => 'load_engine_oil_press', 'label' => 'f. Engine Oil Press.', 'std' => 'Min 50 Psi'],
                            ];
                            @endphp
                            @foreach($loadTests as $test)
                             @php $fieldName = $test['name']; @endphp
                             <div class="p-4 border rounded-lg flex flex-col h-full image-upload-section" data-field-name="{{ $fieldName }}">
                                <label class="block text-sm font-semibold text-gray-700">{{ $test['label'] }}</label>
                                <p class="text-xs text-gray-500 mb-2">Standard: {{ $test['std'] }}</p>
                                <div class="space-y-2 flex-grow">
                                    <input type="text" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full text-sm border-gray-300 rounded-md" placeholder="Result...">
                                    <textarea name="{{ $fieldName }}_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment...">{{ old($fieldName.'_comment', $maintenance->{$fieldName.'_comment'}) }}</textarea>
                                </div>
                                <div class="mt-2 space-y-2">
                                    <div class="flex gap-2">
                                        <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                        <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                    </div>
                                    <div class="preview-container grid grid-cols-3 gap-2">
                                        @foreach(getExistingImages($maintenance, $fieldName) as $img)
                                            <div class="relative group existing-image" data-path="{{ $img['path'] }}">
                                                <img src="{{ asset('storage/' . $img['path']) }}" class="w-full h-24 object-cover rounded border">
                                                <button type="button" class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ... Bagian Notes, Pelaksana, Approver ... --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                        <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Catatan tambahan...">{{ old('notes', $maintenance->notes) }}</textarea>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Pelaksana</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Pelaksana #1 *</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_1_name" value="{{ old('technician_1_name', $maintenance->technician_1_name) }}" class="w-full text-sm border-gray-300 rounded-md" required>
                                     <input type="text" name="technician_1_department" value="{{ old('technician_1_department', $maintenance->technician_1_department) }}" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md-col-span-1 font-semibold self-center">Pelaksana #2 (Opsional)</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_2_name" value="{{ old('technician_2_name', $maintenance->technician_2_name) }}" class="w-full text-sm border-gray-300 rounded-md">
                                     <input type="text" name="technician_2_department" value="{{ old('technician_2_department', $maintenance->technician_2_department) }}" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md-col-span-1 font-semibold self-center">Pelaksana #3 (Opsional)</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_3_name" value="{{ old('technician_3_name', $maintenance->technician_3_name) }}" class="w-full text-sm border-gray-300 rounded-md">
                                     <input type="text" name="technician_3_department" value="{{ old('technician_3_department', $maintenance->technician_3_department) }}" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Mengetahui (Approver)</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Approver (Opsional)</span>
                                {{-- [PERUBAHAN] Ubah grid jadi 3 kolom --}}
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                     <input type="text" name="approver_name" placeholder="Nama Atasan" value="{{ old('approver_name', $maintenance->approver_name) }}" class="sm:col-span-1 w-full text-sm border-gray-300 rounded-md">
                                     {{-- [BARU] Input NIK --}}
                                     <input type="text" name="approver_nik" placeholder="NIK Atasan" value="{{ old('approver_nik', $maintenance->approver_nik) }}" class="sm:col-span-1 w-full text-sm border-gray-300 rounded-md">
                                     <input type="text" name="approver_department" placeholder="Departemen" value="{{ old('approver_department', $maintenance->approver_department) }}" class="sm:col-span-1 w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end p-6 gap-4 py-6">
                    <a href="{{ route('genset.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-sm rounded-lg">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:from-blue-600 hover:to-blue-600 text-white font-sm rounded-lg shadow-lg">
                        Update Data
                    </button>
                </div>
                </div>


            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    {{-- Memuat file JS yang SAMA dengan 'create' --}}
    <script src="{{ asset('js/genset-form.js') }}"></script>
    @endpush

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Form PM Kabel & Panel Distribusi') }}
            </h2>
            <a href="{{ route('cable-panel.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg">
                <i data-lucide="arrow-left" class="h-5 w-5 mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    {{-- Modal Kamera --}}
    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-0 md:p-4">
        {{-- ... (Isi Modal Kamera persis sama dengan grounding/edit.blade.php) ... --}}
        <div class="bg-white rounded-lg w-full md:max-w-2xl h-screen md:h-auto md:max-h-screen overflow-y-auto flex flex-col">
            <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center"><h2 class="text-lg font-bold">Ambil Foto</h2><button id="closeModalBtn" type="button" class="text-gray-500 hover:text-gray-700 text-2xl">×</button></div>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <div id="geoInfo" class="m-4 p-3 bg-blue-50 rounded border border-blue-200 text-xs space-y-1"><p><strong>Latitude:</strong> <span id="lat">-</span></p><p><strong>Longitude:</strong> <span id="lon">-</span></p><p><strong>Tanggal & Waktu:</strong> <span id="datetime">-</span></p><p><strong>Lokasi:</strong> <span id="location">-</span></p></div>
                <div id="videoSection" class="flex-1 flex bg-black relative mx-4 mt-2 rounded"><video id="video" class="w-full" playsinline autoplay muted style="transform: scaleX(-1);"></video></div>
                <div id="capturedImage" class="hidden mx-4 mt-2"><img id="capturedImg" class="w-full rounded" alt="Captured"></div>
                <div class="m-4 space-y-2">
                    <div id="captureControls" class="flex gap-2">
                        <button id="captureBtn" type="button" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">Ambil Foto</button>
                        <button id="switchCameraBtn" type="button" class="flex-1 px-4 py-3 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">Tukar</button>
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

    {{-- PHP Helper untuk mengambil gambar lama (Sama seperti Grounding) --}}
    @php
        function getExistingImages($maintenance, $category) {
            if (!isset($maintenance) || !isset($maintenance->images)) { return []; }
            $images = $maintenance->images;
            if (!is_array($images)) { return []; }
            return array_filter($images, function($img) use ($category) {
                return isset($img['category']) && $img['category'] === $category;
            });
        }
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('cable-panel.update', $maintenance->id) }}" method="POST" id="cable-panel-form">
                @csrf
                @method('PUT')
                <div id="image-data-container"></div>
                <div id="delete-image-container"></div> {{-- Penting --}}

                {{-- Informasi Umum (Sama) --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                            <input type="text" name="location" value="{{ old('location', $maintenance->location) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Site Name (Area)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                            <input type="datetime-local" name="maintenance_date" value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d\TH:i')) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Brand / Type</label>
                            <input type="text" name="brand_type" value="{{ old('brand_type', $maintenance->brand_type) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Panel LVMDP">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Reg. Number</label>
                            <input type="text" name="reg_number" value="{{ old('reg_number', $maintenance->reg_number) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Nomor Registrasi (jika ada)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">S/N</label>
                            <input type="text" name="sn" value="{{ old('sn', $maintenance->sn) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Serial Number (jika ada)">
                        </div>
                    </div>
                </div>

                {{-- 1. Visual Check (Sesuai PDF Kabel Panel) --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3></div>
                    <div class="p-6 space-y-6">
                        @php
                        $visualChecks = [
                            ['field' => 'visual_indicator_lamp', 'label' => 'a. Indicator Lamp', 'std' => 'Normal'],
                            ['field' => 'visual_voltmeter_ampere_meter', 'label' => 'b. Voltmeter & Ampere meter', 'std' => 'Normal'],
                            ['field' => 'visual_arrester', 'label' => 'c. Arrester', 'std' => 'Normal'],
                            ['field' => 'visual_mcb_input_ups', 'label' => 'd. MCB Input UPS', 'std' => 'Normal'],
                            ['field' => 'visual_mcb_output_ups', 'label' => 'e. MCB Output UPS', 'std' => 'Normal'],
                            ['field' => 'visual_mcb_bypass', 'label' => 'f. MCB Bypass', 'std' => 'Normal'],
                        ];
                        @endphp
                        @foreach($visualChecks as $check)
                        @php $fieldName = $check['field']; @endphp
                        <div class="border rounded-lg p-4 bg-white image-upload-section" data-field-name="{{ $fieldName }}">
                             <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                             <p class="text-xs text-gray-500 mb-3">Standard: {{ $check['std'] }}</p>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Result</label>
                                    <input type="text" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Hasil pemeriksaan...">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Status *</label>
                                    <div class="flex gap-4 items-center h-full">
                                        @foreach(['OK', 'NOK'] as $status)
                                        <label class="inline-flex items-center"><input type="radio" name="{{ $fieldName }}_status" value="{{ $status }}" {{ old($fieldName.'_status', $maintenance->{$fieldName.'_status'}) == $status ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" required><span class="ml-2 text-sm text-gray-700">{{ $status }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-gray-600 mb-1">Dokumentasi Foto</label>
                                <div class="flex gap-2 mb-2">
                                    <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                    <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 gap-2">
                                    {{-- Menampilkan Gambar Lama --}}
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

                 {{-- 2. Performance Measurement (Sesuai PDF Kabel Panel) --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">2. Performance Measurement</h3></div>
                     <div class="p-6 space-y-6">
                        {{-- I. MCB Temperature --}}
                        <h4 class="text-md font-semibold text-gray-700 -mb-2">I. MCB Temperature</h4>
                        @php
                        $mcbTempChecks = [
                            ['field' => 'perf_temp_mcb_input_ups', 'label' => 'a. Input UPS', 'std' => 'Maks 35°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_mcb_output_ups', 'label' => 'b. Output UPS', 'std' => 'Maks 35°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_mcb_bypass_ups', 'label' => 'c. Bypass UPS', 'std' => 'Maks 35°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_mcb_load_rack', 'label' => 'd. Load Rack', 'std' => 'Maks 35°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_mcb_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'std' => 'Maks 35°C', 'unit' => '°C'],
                        ];
                        @endphp
                        @foreach($mcbTempChecks as $check)
                        @php $fieldName = $check['field']; @endphp
                        <div class="border rounded-lg p-4 bg-white image-upload-section" data-field-name="{{ $fieldName }}">
                             <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                             <p class="text-xs text-gray-500 mb-3">Standard: {{ $check['std'] }}</p>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Result</label>
                                    <div class="flex items-center">
                                        <input type="number" step="0.01" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3 rounded-r-none" placeholder="Hasil...">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md h-[38px]">{{ $check['unit'] }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Status *</label>
                                    <div class="flex gap-4 items-center h-full">
                                        @foreach(['OK', 'NOK'] as $status)
                                        <label class="inline-flex items-center"><input type="radio" name="{{ $fieldName }}_status" value="{{ $status }}" {{ old($fieldName.'_status', $maintenance->{$fieldName.'_status'}) == $status ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" required><span class="ml-2 text-sm text-gray-700">{{ $status }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-gray-600 mb-1">Dokumentasi Foto</label>
                                <div class="flex gap-2 mb-2">
                                     <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                     <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 gap-2">
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
                        
                        {{-- II. Cable Temperature --}}
                        <h4 class="text-md font-semibold text-gray-700 -mb-2 pt-4">II. Cable Temperature</h4>
                        @php
                        $cableTempChecks = [
                            ['field' => 'perf_temp_cable_input_ups', 'label' => 'a. Input UPS', 'std' => 'Maks 65°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_cable_output_ups', 'label' => 'b. Output UPS', 'std' => 'Maks 65°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_cable_bypass_ups', 'label' => 'c. Bypass UPS', 'std' => 'Maks 65°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_cable_load_rack', 'label' => 'd. Load Rack', 'std' => 'Maks 65°C', 'unit' => '°C'],
                            ['field' => 'perf_temp_cable_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'std' => 'Maks 65°C', 'unit' => '°C'],
                        ];
                        @endphp
                        @foreach($cableTempChecks as $check)
                        @php $fieldName = $check['field']; @endphp
                        <div class="border rounded-lg p-4 bg-white image-upload-section" data-field-name="{{ $fieldName }}">
                             <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                             <p class="text-xs text-gray-500 mb-3">Standard: {{ $check['std'] }}</p>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Result</label>
                                    <div class="flex items-center">
                                        <input type="number" step="0.01" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3 rounded-r-none" placeholder="Hasil...">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md h-[38px]">{{ $check['unit'] }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Status *</label>
                                    <div class="flex gap-4 items-center h-full">
                                        @foreach(['OK', 'NOK'] as $status)
                                        <label class="inline-flex items-center"><input type="radio" name="{{ $fieldName }}_status" value="{{ $status }}" {{ old($fieldName.'_status', $maintenance->{$fieldName.'_status'}) == $status ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" required><span class="ml-2 text-sm text-gray-700">{{ $status }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-gray-600 mb-1">Dokumentasi Foto</label>
                                <div class="flex gap-2 mb-2">
                                     <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                     <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 gap-2">
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

                {{-- 3. Performance Check (Sesuai PDF Kabel Panel) --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">3. Performance Check</h3></div>
                    <div class="p-6 space-y-6">
                        @php
                        $perfChecks = [
                            ['field' => 'perf_check_cable_connection', 'label' => 'a. Maksure All Cable Connection', 'std' => 'Tightened'],
                            ['field' => 'perf_check_spare_mcb', 'label' => 'b. Spare of MCB Load Rack', 'std' => 'Available'],
                            ['field' => 'perf_check_single_line_diagram', 'label' => 'c. Single Line Diagram', 'std' => 'Available'],
                        ];
                        @endphp
                        @foreach($perfChecks as $check)
                        @php $fieldName = $check['field']; @endphp
                        <div class="border rounded-lg p-4 bg-white image-upload-section" data-field-name="{{ $fieldName }}">
                             <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                             <p class="text-xs text-gray-500 mb-3">Standard: {{ $check['std'] }}</p>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Result</label>
                                    <input type="text" name="{{ $fieldName }}_result" value="{{ old($fieldName.'_result', $maintenance->{$fieldName.'_result'}) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Hasil pemeriksaan...">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Status *</label>
                                    <div class="flex gap-4 items-center h-full">
                                        @foreach(['OK', 'NOK'] as $status)
                                        <label class="inline-flex items-center"><input type="radio" name="{{ $fieldName }}_status" value="{{ $status }}" {{ old($fieldName.'_status', $maintenance->{$fieldName.'_status'}) == $status ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" required><span class="ml-2 text-sm text-gray-700">{{ $status }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-gray-600 mb-1">Dokumentasi Foto</label>
                                <div class="flex gap-2 mb-2">
                                     <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                     <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 gap-2">
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

                {{-- Notes (Sama) --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / additional informations</label>
                        <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Catatan tambahan...">{{ old('notes', $maintenance->notes) }}</textarea>
                    </div>
                </div>

                 {{-- Pelaksana & Mengetahui (Sama) --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                     <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">Pelaksana & Mengetahui</h3></div>
                     <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4 md:col-span-2">
                             <h4 class="text-md font-semibold text-gray-700 mb-2">Pelaksana</h4>
                            @for ($i = 1; $i <= 3; $i++)
                            <div class="border rounded-md p-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div><label class="block text-xs text-gray-600 mb-1">Nama Pelaksana #{{ $i }}</label><input type="text" name="technician_{{ $i }}_name" value="{{ old('technician_'.$i.'_name', $maintenance->{'technician_'.$i.'_name'}) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Nama"></div>
                                <div><label class="block text-xs text-gray-600 mb-1">Perusahaan Pelaksana #{{ $i }}</label><input type="text" name="technician_{{ $i }}_company" value="{{ old('technician_'.$i.'_company', $maintenance->{'technician_'.$i.'_company'}) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Perusahaan"></div>
                            </div>
                            @endfor
                        </div>
                        <div class="md:col-span-1">
                             <h4 class="text-md font-semibold text-gray-700 mb-2">Mengetahui</h4>
                             <div><label class="block text-xs text-gray-600 mb-1">Nama Approver</label><input type="text" name="approver_name" value="{{ old('approver_name', $maintenance->approver_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Nama Atasan"></div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex justify-center gap-4 py-6">
                    <a href="{{ route('cable-panel.index') }}" class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg shadow-lg">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-bold rounded-lg shadow-lg">Update Data</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script> document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); }); </script>
    <script src="{{ asset('js/cable-panel-form.js') }}"></script>
    @endpush

</x-app-layout>
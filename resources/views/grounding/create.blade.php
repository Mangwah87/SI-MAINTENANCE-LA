<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Form PM Petir & Grounding') }}
            </h2>
            <a href="{{ route('grounding.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg">
                <i data-lucide="arrow-left" class="h-5 w-5 mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    {{-- Modal Kamera (Gaya Tombol Disesuaikan) --}}
    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-0 md:p-4">
        <div class="bg-white rounded-lg w-full md:max-w-2xl h-screen md:h-auto md:max-h-screen overflow-y-auto flex flex-col">
            <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center"><h2 class="text-lg font-bold">Ambil Foto</h2><button id="closeModalBtn" type="button" class="text-gray-500 hover:text-gray-700 text-2xl">×</button></div>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <div id="geoInfo" class="m-4 p-3 bg-blue-50 rounded border border-blue-200 text-xs space-y-1"><p><strong>Latitude:</strong> <span id="lat">-</span></p><p><strong>Longitude:</strong> <span id="lon">-</span></p><p><strong>Tanggal & Waktu:</strong> <span id="datetime">-</span></p><p><strong>Lokasi:</strong> <span id="location">-</span></p></div>
                <div id="videoSection" class="flex-1 flex bg-black relative mx-4 mt-2 rounded"><video id="video" class="w-full" playsinline autoplay muted style="transform: scaleX(-1);"></video></div>
                <div id="capturedImage" class="hidden mx-4 mt-2"><img id="capturedImg" class="w-full rounded" alt="Captured"></div>
                <div class="m-4 space-y-2">
                    {{-- [PERBAIKAN] Menggunakan class Tailwind langsung --}}
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

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('grounding.store') }}" method="POST" id="grounding-form">
                @csrf
                <div id="image-data-container"></div>

                {{-- Informasi Umum --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                            <select name="location" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">-- Pilih Lokasi --</option>
                                @if(isset($centralsByArea))
                                    @foreach($centralsByArea as $area => $centrals)
                                        <optgroup label="{{ $area }}">
                                            @foreach($centrals as $central)
                                                {{-- Value disamakan dengan format Genset: ID (Nama) --}}
                                                <option value="{{ $central->id_sentral }} ({{ $central->nama }})"
                                                    {{ old('location') == $central->id_sentral . ' (' . $central->nama . ')' ? 'selected' : '' }}>
                                                    {{ $central->id_sentral }} - {{ $central->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @else
                                    <option value="" disabled>Data Central tidak ditemukan (Cek Controller)</option>
                                @endif
                            </select>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                            <input type="datetime-local" name="maintenance_date" value="{{ old('maintenance_date', now()->format('Y-m-d\TH:i')) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Brand / Type</label>
                            <input type="text" name="brand_type" value="{{ old('brand_type') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Bakiral, Erico">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Reg. Number</label>
                            <input type="text" name="reg_number" value="{{ old('reg_number') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Nomor Registrasi (jika ada)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">S/N</label>
                            <input type="text" name="sn" value="{{ old('sn') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Serial Number (jika ada)" required>
                        </div>
                    </div>
                </div>

                {{-- 1. Visual Check --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3></div>
                    <div class="p-6 space-y-6">
                        @php
                        $visualChecks = [
                            ['field' => 'visual_air_terminal', 'label' => 'a. Air Terminal', 'std' => 'Available < 45 with Antenna'],
                            ['field' => 'visual_down_conductor', 'label' => 'b. Down Conductor', 'std' => 'Available (cable > 35 mmsq)'],
                            ['field' => 'visual_ground_rod', 'label' => 'c. Ground Rod', 'std' => 'Available, No Corrosion'],
                            ['field' => 'visual_bonding_bar', 'label' => 'd. Bonding Bar', 'std' => 'Available, No Corrosion'],
                            ['field' => 'visual_arrester_condition', 'label' => 'e. Arrester Condition', 'std' => 'Normal'],
                            ['field' => 'visual_maksure_equipment', 'label' => 'f. Maksure All Equipment to Ground Bar', 'std' => 'Yes'],
                            ['field' => 'visual_maksure_connection', 'label' => 'g. Maksure All Connection Tightened', 'std' => 'Yes'],
                            ['field' => 'visual_ob_light', 'label' => 'h. OB Light Installed if With Tower', 'std' => 'Yes & Normal Operation'],
                        ];
                        @endphp
                        @foreach($visualChecks as $check)
                        <div class="border rounded-lg p-4 bg-white image-upload-section" data-field-name="{{ $check['field'] }}">
                             <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                             <p class="text-xs text-gray-500 mb-3">Standard: {{ $check['std'] }}</p>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Result</label>
                                    <input type="text" name="{{ $check['field'] }}_result" value="{{ old($check['field'].'_result') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Hasil pemeriksaan..." required>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Status *</label>
                                    <div class="flex gap-4 items-center h-full">
                                        @foreach(['OK', 'NOK'] as $status)
                                        <label class="inline-flex items-center"><input type="radio" name="{{ $check['field'] }}_status" value="{{ $status }}" {{ old($check['field'].'_status', 'OK') == $status ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" required><span class="ml-2 text-sm text-gray-700">{{ $status }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-gray-600 mb-1">Dokumentasi Foto</label>
                                <div class="flex gap-2 mb-2">
                                    {{-- [PERBAIKAN] Menggunakan class Tailwind langsung dari Genset --}}
                                    <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                    <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                 {{-- 2. Performance Measurement --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">2. Performance Measurement</h3></div>
                     <div class="p-6 space-y-6">
                        @php
                        $perfChecks = [
                            ['field' => 'perf_ground_resistance', 'label' => 'a. Ground Resistance (R)', 'std' => 'R < 1 Ohm', 'unit' => 'Ohm'],
                            ['field' => 'perf_arrester_cutoff_power', 'label' => 'b. Arrester Cutoff Voltage (Power)', 'std' => '280 VAC', 'unit' => 'VAC'],
                            ['field' => 'perf_arrester_cutoff_data', 'label' => 'c. Arrester Cutoff Voltage (Data)', 'std' => '76 VAC', 'unit' => 'VAC'],
                            ['field' => 'perf_tighten_nut', 'label' => 'd. Tighten of Nut', 'std' => 'Tightened', 'unit' => ''],
                        ];
                        @endphp
                        @foreach($perfChecks as $check)
                        <div class="border rounded-lg p-4 bg-white image-upload-section" data-field-name="{{ $check['field'] }}">
                             <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                             <p class="text-xs text-gray-500 mb-3">Standard: {{ $check['std'] }}</p>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Result</label>
                                    <div class="flex items-center">
                                        <input type="{{ $check['unit'] ? 'number' : 'text' }}" {{ $check['unit'] ? 'step=0.01' : ''}} name="{{ $check['field'] }}_result" value="{{ old($check['field'].'_result') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3 {{ !$check['unit'] ? 'rounded-md' : 'rounded-r-none' }}" placeholder="Hasil pengukuran...">
                                        @if($check['unit']) <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md h-[38px]">{{ $check['unit'] }}</span> @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Status *</label>
                                    <div class="flex gap-4 items-center h-full">
                                        @foreach(['OK', 'NOK'] as $status)
                                        <label class="inline-flex items-center"><input type="radio" name="{{ $check['field'] }}_status" value="{{ $status }}" {{ old($check['field'].'_status', 'OK') == $status ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" required><span class="ml-2 text-sm text-gray-700">{{ $status }}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-gray-600 mb-1">Dokumentasi Foto</label>
                                <div class="flex gap-2 mb-2">
                                     {{-- [PERBAIKAN] Menggunakan class Tailwind langsung dari Genset --}}
                                     <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload</button>
                                     <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Kamera</button>
                                </div>
                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Notes --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / additional informations</label>
                        <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                 {{-- Pelaksana & Mengetahui --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                     <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">Pelaksana & Mengetahui</h3></div>
                     <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4 md:col-span-2">
                             <h4 class="text-md font-semibold text-gray-700 mb-2">Pelaksana</h4>
                            @for ($i = 1; $i <= 3; $i++)
                            <div class="border rounded-md p-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div><label class="block text-xs text-gray-600 mb-1">Nama Pelaksana #{{ $i }}</label><input type="text" name="technician_{{ $i }}_name" value="{{ old('technician_'.$i.'_name') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Nama"></div>
                                <div><label class="block text-xs text-gray-600 mb-1">Perusahaan Pelaksana #{{ $i }}</label><input type="text" name="technician_{{ $i }}_company" value="{{ old('technician_'.$i.'_company') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Perusahaan"></div>
                            </div>
                            @endfor
                        </div>
                        <div class="md:col-span-1">
                             <h4 class="text-md font-semibold text-gray-700 mb-2">Mengetahui</h4>
                             <div><label class="block text-xs text-gray-600 mb-1">Nama Approver</label><input type="text" name="approver_name" value="{{ old('approver_name') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="Nama Atasan" required></div>
                             {{-- TAMBAHKAN BLOK INI --}}
                            <div class="mt-4">
                                <label class="block text-xs text-gray-600 mb-1">NIK Approver</label>
                                <input type="text" name="approver_nik" value="{{ old('approver_nik') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" placeholder="NIK Atasan">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end p-6 gap-4 py-6">
                        <a href="{{ route('grounding.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-sm rounded-lg shadow-lg">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:from-blue-600 hover:to-blue-600 text-white font-sm rounded-lg shadow-lg">Simpan Data</button>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                
            </form>
        </div>
    </div>

    {{-- HAPUS BLOK <style> DARI SINI --}}

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    <script src="{{ asset('js/grounding-form.js') }}"></script>
    @endpush

</x-app-layout>
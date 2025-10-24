<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Form Preventive Maintenance Genset') }}
            </h2>
            <a href="{{ route('genset.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg">
                <i data-lucide="arrow-left" class="h-5 w-5 mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('genset.store') }}" method="POST" enctype="multipart/form-data" id="genset-form">
                @csrf

                {{-- ... Bagian Informasi Umum (Tidak ada perubahan) ... --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                            <input type="text" name="location" required class="w-full border-gray-300 rounded-lg" placeholder="Contoh: DPSTKU (La Teuku Umar)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                            <input type="datetime-local" name="maintenance_date" value="{{ now()->format('Y-m-d\TH:i') }}" required class="w-full border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Brand / Type</label>
                            <input type="text" name="brand_type" class="w-full border-gray-300 rounded-lg" placeholder="Contoh: DENYO">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Capacity</label>
                            <input type="text" name="capacity" class="w-full border-gray-300 rounded-lg" placeholder="Contoh: 20 KVA">
                        </div>
                    </div>
                </div>


                {{-- 1. VISUAL CHECK --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3>
                    </div>
                    <div class="p-6 space-y-4">
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
                        <div class="p-4 border rounded-lg">
                            <label class="block text-sm font-semibold text-gray-700">{{ $check['label'] }}</label>
                            <p class="text-xs text-gray-500 mb-2">Standard: {{ $check['std'] }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                                <input type="text" name="{{ $check['name'] }}_result" class="w-full text-sm border-gray-300 rounded-md" placeholder="Result...">
                                <textarea name="{{ $check['name'] }}_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment..."></textarea>
                            </div>
                            <div class="mt-2 flex items-center space-x-2">
                                <label for="{{ $check['name'] }}_image" class="camera-button cursor-pointer p-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white inline-flex items-center" data-gps-target="#{{ $check['name'] }}_gps">
                                    <i data-lucide="camera" class="h-5 w-5"></i>
                                </label>
                                <input type="file" accept="image/*" capture="environment" id="{{ $check['name'] }}_image" name="{{ $check['name'] }}_image" class="hidden" data-preview-target="#{{ $check['name'] }}_preview">
                                <input type="hidden" name="{{ $check['name'] }}_gps" id="{{ $check['name'] }}_gps">
                                
                                {{-- PERUBAHAN DI SINI: Mengganti <img> dan <span> dengan <canvas> --}}
                                <canvas id="{{ $check['name'] }}_preview" width="150" height="112" class="rounded-md hidden" style="border: 1px solid #ddd;"></canvas>
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
                        <div class="space-y-4">
                            {{-- No Load: AC Output Voltage --}}
                            <div class="p-4 border rounded-lg">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">a. AC Output Voltage</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4 items-center">
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">R - S:</label><input type="text" name="no_load_ac_voltage_rs" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">S - T:</label><input type="text" name="no_load_ac_voltage_st" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">T - R:</label><input type="text" name="no_load_ac_voltage_tr" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <p class="text-sm text-gray-500">Std: 360-400 VAC</p>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">R - N:</label><input type="text" name="no_load_ac_voltage_rn" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">S - N:</label><input type="text" name="no_load_ac_voltage_sn" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">T - N:</label><input type="text" name="no_load_ac_voltage_tn" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <p class="text-sm text-gray-500">Std: 180-230 VAC</p>
                                </div>
                                <div class="mt-4">
                                    <textarea name="no_load_ac_voltage_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment..."></textarea>
                                </div>
                                <div class="mt-2 flex items-center space-x-2">
                                    <label for="no_load_ac_voltage_image" class="camera-button cursor-pointer p-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white inline-flex items-center" data-gps-target="#no_load_ac_voltage_gps">
                                        <i data-lucide="camera" class="h-5 w-5"></i>
                                    </label>
                                    <input type="file" accept="image/*" capture="environment" id="no_load_ac_voltage_image" name="no_load_ac_voltage_image" class="hidden" data-preview-target="#no_load_ac_voltage_preview">
                                    <input type="hidden" name="no_load_ac_voltage_gps" id="no_load_ac_voltage_gps">
                                    <canvas id="no_load_ac_voltage_preview" width="150" height="112" class="rounded-md hidden" style="border: 1px solid #ddd;"></canvas>
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
                             <div class="p-4 border rounded-lg">
                                <label class="block text-sm font-semibold text-gray-700">{{ $test['label'] }}</label>
                                <p class="text-xs text-gray-500 mb-2">Standard: {{ $test['std'] }}</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                                    <input type="text" name="{{ $test['name'] }}_result" class="w-full text-sm border-gray-300 rounded-md" placeholder="Result...">
                                    <textarea name="{{ $test['name'] }}_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment..."></textarea>
                                </div>
                                <div class="mt-2 flex items-center space-x-2">
                                    <label for="{{ $test['name'] }}_image" class="camera-button cursor-pointer p-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white inline-flex items-center" data-gps-target="#{{ $test['name'] }}_gps">
                                        <i data-lucide="camera" class="h-5 w-5"></i>
                                    </label>
                                    <input type="file" accept="image/*" capture="environment" id="{{ $test['name'] }}_image" name="{{ $test['name'] }}_image" class="hidden" data-preview-target="#{{ $test['name'] }}_preview">
                                    <input type="hidden" name="{{ $test['name'] }}_gps" id="{{ $test['name'] }}_gps">
                                    <canvas id="{{ $test['name'] }}_preview" width="150" height="112" class="rounded-md hidden" style="border: 1px solid #ddd;"></canvas>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- II. Load Test --}}
                    <div class="p-6">
                        <h4 class="font-bold text-lg text-gray-700 mb-4">II. Load Test (30 minute)</h4>
                        <div class="space-y-4">
                            {{-- Load: AC Output Voltage --}}
                            <div class="p-4 border rounded-lg">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">a. AC Output Voltage</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4 items-center">
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">R - S:</label><input type="text" name="load_ac_voltage_rs" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">S - T:</label><input type="text" name="load_ac_voltage_st" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">T - R:</label><input type="text" name="load_ac_voltage_tr" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <p class="text-sm text-gray-500">Std: 360-400 VAC</p>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">R - N:</label><input type="text" name="load_ac_voltage_rn" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">S - N:</label><input type="text" name="load_ac_voltage_sn" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-12">T - N:</label><input type="text" name="load_ac_voltage_tn" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <p class="text-sm text-gray-500">Std: 180-230 VAC</p>
                                </div>
                                <div class="mt-4">
                                    <textarea name="load_ac_voltage_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment..."></textarea>
                                </div>
                                <div class="mt-2 flex items-center space-x-2">
                                    <label for="load_ac_voltage_image" class="camera-button cursor-pointer p-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white inline-flex items-center" data-gps-target="#load_ac_voltage_gps">
                                        <i data-lucide="camera" class="h-5 w-5"></i>
                                    </label>
                                    <input type="file" accept="image/*" capture="environment" id="load_ac_voltage_image" name="load_ac_voltage_image" class="hidden" data-preview-target="#load_ac_voltage_preview">
                                    <input type="hidden" name="load_ac_voltage_gps" id="load_ac_voltage_gps">
                                    <canvas id="load_ac_voltage_preview" width="150" height="112" class="rounded-md hidden" style="border: 1px solid #ddd;"></canvas>
                                </div>
                            </div>
                            
                            {{-- Load: AC Output Current --}}
                            <div class="p-4 border rounded-lg">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">b. AC Output Current</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4 items-center">
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-8">R:</label><input type="text" name="load_ac_current_r" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-8">S:</label><input type="text" name="load_ac_current_s" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <div class="flex items-center gap-2"><label class="font-medium text-sm w-8">T:</label><input type="text" name="load_ac_current_t" class="w-full text-sm border-gray-300 rounded-md"></div>
                                    <p class="text-xs text-gray-500">Std: Lihat form</p>
                                </div>
                                <div class="mt-4">
                                    <textarea name="load_ac_current_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment..."></textarea>
                                </div>
                                <div class="mt-2 flex items-center space-x-2">
                                    <label for="load_ac_current_image" class="camera-button cursor-pointer p-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white inline-flex items-center" data-gps-target="#load_ac_current_gps">
                                        <i data-lucide="camera" class="h-5 w-5"></i>
                                    </label>
                                    <input type="file" accept="image/*" capture="environment" id="load_ac_current_image" name="load_ac_current_image" class="hidden" data-preview-target="#load_ac_current_preview">
                                    <input type="hidden" name="load_ac_current_gps" id="load_ac_current_gps">
                                    <canvas id="load_ac_current_preview" width="150" height="112" class="rounded-md hidden" style="border: 1px solid #ddd;"></canvas>
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
                             <div class="p-4 border rounded-lg">
                                <label class="block text-sm font-semibold text-gray-700">{{ $test['label'] }}</label>
                                <p class="text-xs text-gray-500 mb-2">Standard: {{ $test['std'] }}</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                                    <input type="text" name="{{ $test['name'] }}_result" class="w-full text-sm border-gray-300 rounded-md" placeholder="Result...">
                                    <textarea name="{{ $test['name'] }}_comment" rows="2" class="w-full text-sm border-gray-300 rounded-md" placeholder="Comment..."></textarea>
                                </div>
                                <div class="mt-2 flex items-center space-x-2">
                                    <label for="{{ $test['name'] }}_image" class="camera-button cursor-pointer p-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white inline-flex items-center" data-gps-target="#{{ $test['name'] }}_gps">
                                        <i data-lucide="camera" class="h-5 w-5"></i>
                                    </label>
                                    <input type="file" accept="image/*" capture="environment" id="{{ $test['name'] }}_image" name="{{ $test['name'] }}_image" class="hidden" data-preview-target="#{{ $test['name'] }}_preview">
                                    <input type="hidden" name="{{ $test['name'] }}_gps" id="{{ $test['name'] }}_gps">
                                    <canvas id="{{ $test['name'] }}_preview" width="150" height="112" class="rounded-md hidden" style="border: 1px solid #ddd;"></canvas>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ... Bagian Notes, Pelaksana, Approver (Tidak ada perubahan) ... --}}
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                        <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Catatan tambahan..."></textarea>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Pelaksana</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Pelaksana #1 *</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_1_name" placeholder="Pelaksana 1" class="w-full text-sm border-gray-300 rounded-md" required>
                                     <input type="text" name="technician_1_department" placeholder="ERO / BNO" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Pelaksana #2 (Opsional)</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_2_name" placeholder="Pelaksana 2" class="w-full text-sm border-gray-300 rounded-md">
                                     <input type="text" name="technician_2_department" placeholder="ERO / BNO" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Pelaksana #3 (Opsional)</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_3_name" placeholder="Pelaksana 3" class="w-full text-sm border-gray-300 rounded-md">
                                     <input type="text" name="technician_3_department" placeholder="Departemen" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Mengetahui (Approver)</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Approver (Opsional)</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="approver_name" placeholder="Nama Atasan" class="w-full text-sm border-gray-300 rounded-md">
                                     <input type="text" name="approver_department" placeholder="Departemen" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="flex justify-center gap-4 py-6">
                    <a href="{{ route('genset.index') }}" class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white font-bold rounded-lg">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK PREVIEW CANVAS --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- Script Aktivasi Lucide Icons ---
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // --- Script untuk Mengambil GPS ---
            const cameraButtons = document.querySelectorAll('.camera-button');
            cameraButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const gpsTargetSelector = event.currentTarget.dataset.gpsTarget;
                    const gpsInput = document.querySelector(gpsTargetSelector);
                    
                    if (!gpsInput || !navigator.geolocation) {
                        console.warn('Geolocation is not supported or GPS input not found.');
                        if(gpsInput) gpsInput.value = 'GPS Not Supported';
                        return;
                    }
                    
                    // Set status default
                    gpsInput.value = 'Getting GPS...';

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lon = position.coords.longitude;
                            gpsInput.value = `${lat.toFixed(6)},${lon.toFixed(6)}`;
                        },
                        (error) => {
                            gpsInput.value = 'GPS Access Denied';
                            console.error(`Geolocation Error: ${error.message}`);
                        }
                    );
                });
            });

            // --- SCRIPT BARU UNTUK PREVIEW CANVAS (MENGGANTIKAN SCRIPT IMG) ---
            const fileInputs = document.querySelectorAll('input[type="file"][data-preview-target]');
            
            fileInputs.forEach(input => {
                input.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Dapatkan elemen canvas
                    const previewTargetSelector = event.target.dataset.previewTarget;
                    const canvas = document.querySelector(previewTargetSelector);
                    if (!canvas) return;

                    // Dapatkan input GPS yang terkait
                    const gpsInputId = '#' + event.target.id.replace('_image', '_gps');
                    const gpsInput = document.querySelector(gpsInputId);
                    const gpsText = gpsInput ? gpsInput.value : 'No GPS Data';

                    // Panggil fungsi untuk menggambar preview
                    drawTimestampPreview(canvas, file, gpsText);
                });
            });

            /**
             * Fungsi untuk menggambar gambar dan timestamp ke canvas
             */
            function drawTimestampPreview(canvas, file, gpsText) {
                const ctx = canvas.getContext('2d');
                const reader = new FileReader();
                const timestamp = new Date();
                
                // Format tanggal dan waktu (sesuaikan dengan timezone Anda)
                const timeZone = 'Asia/Makassar'; // WITA
                const dateString = timestamp.toLocaleDateString('id-ID', { timeZone, day: '2-digit', month: 'short', year: 'numeric' });
                const timeString = timestamp.toLocaleTimeString('id-ID', { timeZone, hour: '2-digit', minute: '2-digit', second: '2-digit' });
                const timestampText = `${dateString}, ${timeString} WITA`;

                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        // Bersihkan canvas
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        // Gambar gambar agar pas (aspect fill)
                        const hRatio = canvas.width / img.width;
                        const vRatio = canvas.height / img.height;
                        const ratio = Math.max(hRatio, vRatio);
                        const centerShift_x = (canvas.width - img.width * ratio) / 2;
                        const centerShift_y = (canvas.height - img.height * ratio) / 2;
                        
                        ctx.drawImage(img, 0, 0, img.width, img.height,
                                      centerShift_x, centerShift_y, img.width * ratio, img.height * ratio);

                        // ---- Tambahkan watermark (simulasi) ----
                        
                        // 1. Latar belakang hitam semi-transparan
                        ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
                        ctx.fillRect(0, 0, canvas.width, 32); // Kotak di atas

                        // 2. Teks Timestamp
                        ctx.fillStyle = 'white';
                        ctx.font = '10px Arial';
                        ctx.textAlign = 'left';
                        ctx.textBaseline = 'top';
                        ctx.fillText(timestampText, 5, 4);

                        // 3. Teks GPS
                        ctx.fillText(gpsText, 5, 18);
                        
                        // Tampilkan canvas-nya
                        canvas.classList.remove('hidden');
                    }
                    img.src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush

</x-app-layout>
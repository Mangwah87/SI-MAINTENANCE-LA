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
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">📋 Informasi Umum</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                                <input type="text" name="location" value="{{ old('location', $maintenance->location) }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                                <input type="datetime-local" name="maintenance_date"
                                    value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d\TH:i')) }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Temperature (°C)</label>
                                <input type="number" step="0.1" name="battery_temperature"
                                    value="{{ old('battery_temperature', $maintenance->battery_temperature) }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Company</label>
                                <input type="text" name="company"
                                    value="{{ old('company', $maintenance->company ?? 'PT. Aplikarusa Lintasarta') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Brand *</label>
                                <input type="text" name="battery_brand" id="main_battery_brand"
                                    value="{{ old('battery_brand', $maintenance->readings->first()->battery_brand ?? 'Ritar') }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                                <textarea name="notes" rows="4"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('notes', $maintenance->notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pelaksana -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-50 to-teal-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">👥 Data Pelaksana</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-4">
                            <!-- Pelaksana 1 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-white-700 mb-3">Pelaksana #1 *</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                                        <input type="text" name="technician_1_name"
                                            value="{{ old('technician_1_name', $maintenance->technician_1_name) }}" required
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan *</label>
                                        <input type="text" name="technician_1_company"
                                            value="{{ old('technician_1_company', $maintenance->technician_1_company) }}" required
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Pelaksana 2 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-white-700 mb-3">Pelaksana #2 (Opsional)</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="technician_2_name"
                                            value="{{ old('technician_2_name', $maintenance->technician_2_name) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                                        <input type="text" name="technician_2_company"
                                            value="{{ old('technician_2_company', $maintenance->technician_2_company) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Pelaksana 3 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-white-700 mb-3">Pelaksana #3 (Opsional)</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="technician_3_name"
                                            value="{{ old('technician_3_name', $maintenance->technician_3_name) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                                        <input type="text" name="technician_3_company"
                                            value="{{ old('technician_3_company', $maintenance->technician_3_company) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Battery Readings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-200 to-blue-50 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800">🔋 Data Pembacaan Battery</h3>
                            <button type="button" id="add-battery"
                                class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm sm:text-base font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Battery
                            </button>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        <div id="battery-readings" class="space-y-4 sm:space-y-6">
                            @foreach($maintenance->readings as $index => $reading)
                            <div class="battery-item border-2 border-purple-300 rounded-xl p-4 sm:p-6 bg-gradient-to-br from-white to-purple-50" data-index="{{ $index }}">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-base sm:text-lg font-bold text-purple-700">Battery #{{ $index + 1 }}</h4>
                                    @if($index > 0)
                                    <button type="button" class="btn-remove px-2 sm:px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                                        Hapus
                                    </button>
                                    @endif
                                </div>

                                <input type="hidden" name="readings[{{ $index }}][id]" value="{{ $reading->id }}">

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                                        <input type="number" name="readings[{{ $index }}][bank_number]"
                                            value="{{ old('readings.'.$index.'.bank_number', $reading->bank_number) }}"
                                            required min="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                                        <input type="number" name="readings[{{ $index }}][battery_number]"
                                            value="{{ old('readings.'.$index.'.battery_number', $reading->battery_number) }}"
                                            required min="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                                        <input type="number" step="0.1" name="readings[{{ $index }}][voltage]"
                                            value="{{ old('readings.'.$index.'.voltage', $reading->voltage) }}"
                                            required min="0" max="20"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                </div>

                                <input type="hidden" name="readings[{{ $index }}][battery_brand]" class="reading-battery-brand">

                                <!-- Camera Section -->
                                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery</label>

                                    @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                    <div class="existing-photo-container mb-3" data-index="{{ $index }}">
                                        <img src="{{ Storage::url($reading->photo_path) }}"
                                            class="existing-photo w-full h-auto max-h-64 sm:max-h-96 rounded-lg border-2 border-green-400 object-contain"
                                            alt="Existing photo"
                                            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%27200%27 height=%27200%27%3E%3Crect fill=%27%23ddd%27 width=%27200%27 height=%27200%27/%3E%3Ctext x=%2750%25%27 y=%2750%25%27 text-anchor=%27middle%27 fill=%27%23999%27 font-size=%2716%27%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E';"
                                            data-index="{{ $index }}">
                                        <input type="hidden" name="readings[{{ $index }}][keep_photo]" value="1" class="keep-photo-input" data-index="{{ $index }}">
                                        <p class="text-xs text-green-600 mt-2 font-semibold">✓ Foto tersimpan. Klik "Ganti Foto" jika ingin menggantinya.</p>
                                    </div>
                                    @else
                                    <div class="existing-photo-container mb-3 hidden" data-index="{{ $index }}">
                                        <p class="text-xs text-gray-500">Belum ada foto</p>
                                    </div>
                                    @endif

                                    <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="{{ $index }}" autoplay playsinline></video>
                                    <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 hidden" data-index="{{ $index }}" alt="Captured">
                                    <canvas class="hidden" data-index="{{ $index }}"></canvas>

                                    <div class="flex flex-wrap gap-2 justify-center mb-3">
                                        <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                            @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                            Ganti Foto
                                            @else
                                            Buka Kamera
                                            @endif
                                        </button>
                                        <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                            Ambil Foto
                                        </button>
                                        <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                            Foto Ulang
                                        </button>
                                        <button type="button" class="cancel-photo hidden px-3 sm:px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                            Batalkan
                                        </button>
                                    </div>

                                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded" data-index="{{ $index }}"></div>

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
                        class="px-6 sm:px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transition-colors duration-200 text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 sm:px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let batteryCount = {
            {
                $maintenance - > readings - > count()
            }
        };
        let streams = {};

        document.getElementById('add-battery').addEventListener('click', function() {
            const container = document.getElementById('battery-readings');
            const newBattery = document.createElement('div');
            newBattery.className = 'battery-item border-2 border-purple-200 rounded-xl p-4 sm:p-6 bg-gradient-to-br from-white to-purple-50';
            newBattery.setAttribute('data-index', batteryCount);

            newBattery.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-base sm:text-lg font-bold text-purple-700">Battery #${batteryCount + 1}</h4>
            <button type="button" class="btn-remove px-2 sm:px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                Hapus
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-4">
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                <input type="number" name="readings[${batteryCount}][bank_number]" value="" required min="1" placeholder="1"
                       class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                <input type="number" name="readings[${batteryCount}][battery_number]" value="" required min="1" placeholder="${batteryCount + 1}"
                       class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                <input type="number" step="0.1" name="readings[${batteryCount}][voltage]" required min="0" max="20" placeholder="13.8"
                       class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
        </div>

        <input type="hidden" name="readings[${batteryCount}][battery_brand]" class="reading-battery-brand">

        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>

            <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="${batteryCount}" autoplay playsinline></video>
            <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 hidden" data-index="${batteryCount}" alt="Captured">
            <canvas class="hidden" data-index="${batteryCount}"></canvas>

            <div class="flex flex-wrap gap-2 justify-center mb-3">
                <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">
                    Buka Kamera
                </button>
                <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">
                    Ambil Foto
                </button>
                <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">
                    Foto Ulang
                </button>
                <button type="button" class="cancel-photo hidden px-3 sm:px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">
                    Batalkan
                </button>
            </div>

            <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded" data-index="${batteryCount}"></div>

            <input type="hidden" name="readings[${batteryCount}][photo_data]" data-photo="${batteryCount}">
            <input type="hidden" name="readings[${batteryCount}][photo_latitude]" data-lat="${batteryCount}">
            <input type="hidden" name="readings[${batteryCount}][photo_longitude]" data-lng="${batteryCount}">
            <input type="hidden" name="readings[${batteryCount}][photo_timestamp]" data-time="${batteryCount}">
        </div>
    `;

            container.appendChild(newBattery);
            attachCameraEvents(batteryCount);
            attachRemoveEvent(newBattery);
            batteryCount++;
        });

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
                });
            }
        }

        function attachCameraEvents(index) {
            const video = document.querySelector(`.camera-preview[data-index="${index}"]`);
            const canvas = document.querySelector(`canvas[data-index="${index}"]`);
            const capturedImage = document.querySelector(`.captured-image[data-index="${index}"]`);
            const startBtn = document.querySelector(`.start-camera[data-index="${index}"]`);
            const captureBtn = document.querySelector(`.capture-photo[data-index="${index}"]`);
            const retakeBtn = document.querySelector(`.retake-photo[data-index="${index}"]`);
            const cancelBtn = document.querySelector(`.cancel-photo[data-index="${index}"]`);
            const photoInfo = document.querySelector(`.photo-info[data-index="${index}"]`);
            const existingPhotoContainer = document.querySelector(`.existing-photo-container[data-index="${index}"]`);
            const keepPhotoInput = document.querySelector(`.keep-photo-input[data-index="${index}"]`);

            if (!video || !canvas || !capturedImage || !startBtn || !captureBtn || !retakeBtn || !photoInfo) {
                console.error('Camera elements not found for index:', index);
                return;
            }

            startBtn.addEventListener('click', async function() {
                try {
                    const constraints = {
                        video: {
                            facingMode: 'environment',
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        },
                        audio: false
                    };

                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    streams[index] = stream;
                    video.srcObject = stream;
                    video.classList.remove('hidden');

                    // Sembunyikan foto yang sudah ada
                    if (existingPhotoContainer) {
                        existingPhotoContainer.classList.add('hidden');
                    }

                    // Set keep_photo menjadi 0 (akan diganti dengan foto baru)
                    if (keepPhotoInput) {
                        keepPhotoInput.value = '0';
                    }

                    startBtn.classList.add('hidden');
                    captureBtn.classList.remove('hidden');
                    if (cancelBtn) {
                        cancelBtn.classList.remove('hidden');
                    }
                } catch (err) {
                    console.error('Camera error:', err);
                    alert('Error membuka kamera: ' + err.message);
                }
            });

            captureBtn.addEventListener('click', function() {
                capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, cancelBtn, photoInfo);
            });

            retakeBtn.addEventListener('click', function() {
                // Reset tampilan
                capturedImage.classList.add('hidden');
                video.classList.remove('hidden');
                captureBtn.classList.remove('hidden');
                retakeBtn.classList.add('hidden');
                if (cancelBtn) {
                    cancelBtn.classList.remove('hidden');
                }
                photoInfo.innerHTML = '';

                // Kosongkan data foto baru
                document.querySelector(`input[data-photo="${index}"]`).value = '';
                document.querySelector(`input[data-lat="${index}"]`).value = '';
                document.querySelector(`input[data-lng="${index}"]`).value = '';
                document.querySelector(`input[data-time="${index}"]`).value = '';

                // Pastikan kamera masih aktif
                if (!streams[index]) {
                    startBtn.click();
                }
            });

            // Event listener untuk tombol Cancel (kembalikan foto lama)
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    // Stop camera stream
                    if (streams[index]) {
                        streams[index].getTracks().forEach(track => track.stop());
                        delete streams[index];
                    }

                    // Sembunyikan kamera dan foto yang baru diambil
                    video.classList.add('hidden');
                    capturedImage.classList.add('hidden');
                    captureBtn.classList.add('hidden');
                    retakeBtn.classList.add('hidden');
                    cancelBtn.classList.add('hidden');

                    // Tampilkan kembali tombol start dan foto lama
                    startBtn.classList.remove('hidden');
                    if (existingPhotoContainer) {
                        existingPhotoContainer.classList.remove('hidden');
                    }

                    // Kembalikan keep_photo menjadi 1 (pertahankan foto lama)
                    if (keepPhotoInput) {
                        keepPhotoInput.value = '1';
                    }

                    // Kosongkan data foto baru
                    document.querySelector(`input[data-photo="${index}"]`).value = '';
                    document.querySelector(`input[data-lat="${index}"]`).value = '';
                    document.querySelector(`input[data-lng="${index}"]`).value = '';
                    document.querySelector(`input[data-time="${index}"]`).value = '';

                    photoInfo.innerHTML = '';
                });
            }
        }

        async function getAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                return data.display_name || 'Alamat tidak ditemukan';
            } catch (error) {
                console.error('Error getting address:', error);
                return 'Alamat tidak tersedia';
            }
        }

        function capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, cancelBtn, photoInfo) {
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

                            const dateStr = timestamp.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                            const dayStr = timestamp.toLocaleDateString('id-ID', {
                                weekday: 'long'
                            });

                            let timezone = 'WIB';
                            if (lng >= 120 && lng < 130) {
                                timezone = 'WITA';
                            } else if (lng >= 130) {
                                timezone = 'WIT';
                            }

                            const timeStr = timestamp.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            }) + ' ' + timezone;

                            const fontSize = Math.max(14, canvas.width * 0.018);
                            const padding = 15;
                            const lineHeight = fontSize * 1.8;
                            const startY = canvas.height - (lineHeight * 5.5);

                            ctx.shadowColor = 'rgba(0, 0, 0, 0.9)';
                            ctx.shadowBlur = 10;
                            ctx.shadowOffsetX = 2;
                            ctx.shadowOffsetY = 2;

                            ctx.fillStyle = 'white';
                            ctx.font = `${fontSize}px Arial`;

                            ctx.fillText(`${dateStr}`, padding, startY);
                            ctx.fillText(`${dayStr}`, padding, startY + lineHeight);

                            ctx.font = `bold ${fontSize * 2.5}px Arial`;
                            ctx.fillText(`${timeStr}`, padding, startY + (lineHeight * 2.3));

                            ctx.font = `${fontSize}px Arial`;
                            ctx.fillText(`Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`, padding, startY + (lineHeight * 3.5));
                            ctx.fillText(`${address}`, padding, startY + (lineHeight * 4.5));

                            const imageData = canvas.toDataURL('image/jpeg', 0.85);
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
                            if (cancelBtn) {
                                cancelBtn.classList.add('hidden');
                            }
                            photoInfo.innerHTML = '<p class="text-green-600 font-semibold">✓ Foto baru berhasil diambil!</p>';
                        },
                        function(error) {
                            console.error('Geolocation error:', error);
                            photoInfo.innerHTML = '<p class="text-red-600">❌ Gagal mendapatkan lokasi GPS</p>';
                            alert('Tidak dapat mengakses lokasi GPS: ' + error.message);
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                );
            } else {
                alert('Geolokasi tidak didukung oleh browser ini');
            }
        }

        document.getElementById('mainForm').addEventListener('submit', function(e) {
            const mainBatteryBrand = document.getElementById('main_battery_brand').value;
            document.querySelectorAll('.reading-battery-brand').forEach(function(input) {
                input.value = mainBatteryBrand;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const existingReadings = document.querySelectorAll('.battery-item');
            existingReadings.forEach(function(item) {
                const index = parseInt(item.getAttribute('data-index'));
                attachCameraEvents(index);
                if (index > 0) {
                    attachRemoveEvent(item);
                }
            });
        });

        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            console.warn('WARNING: Camera and Geolocation require HTTPS or localhost!');
        }
    </script>
</x-app-layout>

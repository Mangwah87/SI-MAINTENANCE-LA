<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Form Preventive Maintenance Battery') }}
            </h2>
            <a href="{{ route('battery.index') }}"
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
            <!-- Alert Messages -->
            <!-- @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 sm:mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm sm:text-base">
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 sm:mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm sm:text-base">
                        <p class="font-semibold mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif -->

            <!-- Form -->
            <form action="{{ route('battery.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                @csrf

                <!-- Informasi Umum -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-500 to-blue-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800"> Informasi Umum</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                                <input type="text" name="location" value="{{ old('location') }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Contoh: DPSTKU (Teuku Umar)">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                                <input type="datetime-local" name="maintenance_date" id="maintenance_date" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Temperature (°C)</label>
                                <input type="number" step="0.1" name="battery_temperature" value="{{ old('battery_temperature') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Contoh: 25.5">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Company</label>
                                <input type="text" name="company" value="{{ old('company', 'PT. Aplikarusa Lintasarta') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Nama Perusahaan">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Brand *</label>
                                <input type="text" name="battery_brand" id="main_battery_brand" value="{{ old('battery_brand', 'Ritar') }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Contoh: Ritar, Yuasa, Panasonic">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                                <textarea name="notes" rows="4"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Catatan tambahan atau informasi penting lainnya...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pelaksana -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-50 to-teal-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800"> Data Pelaksana</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-4">
                            <!-- Pelaksana 1 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-white-700 mb-3">Pelaksana #1 *</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                                        <input type="text" name="technician_1_name" value="{{ old('technician_1_name') }}" required
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent"
                                            placeholder="Nama pelaksana 1">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan *</label>
                                        <input type="text" name="technician_1_company" value="{{ old('technician_1_company', 'PT. Aplikarusa Lintasarta') }}" required
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent"
                                            placeholder="Nama perusahaan">
                                    </div>
                                </div>
                            </div>

                            <!-- Pelaksana 2 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-white-700 mb-3">Pelaksana #2 (Opsional)</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="technician_2_name" value="{{ old('technician_2_name') }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent"
                                            placeholder="Nama pelaksana 2 (kosongkan jika tidak ada)">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                                        <input type="text" name="technician_2_company" value="{{ old('technician_2_company') }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent"
                                            placeholder="Nama perusahaan">
                                    </div>
                                </div>
                            </div>

                            <!-- Pelaksana 3 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-white-700 mb-3">Pelaksana #3 (Opsional)</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="technician_3_name" value="{{ old('technician_3_name') }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent"
                                            placeholder="Nama pelaksana 3 (kosongkan jika tidak ada)">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                                        <input type="text" name="technician_3_company" value="{{ old('technician_3_company') }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent"
                                            placeholder="Nama perusahaan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 text-xs sm:text-sm text-gray-600 italic">
                            <strong>Catatan:</strong> Minimal 1 pelaksana harus diisi. Pelaksana ke-2 dan ke-3 bersifat opsional.
                        </p>
                    </div>
                </div>

                <!-- Data Battery Readings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-200 to-blue-50 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800"> Data Pembacaan Battery</h3>
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
                            <!-- Battery Item #1 -->
                            <div class="battery-item border-2 border-white-300 rounded-xl p-4 sm:p-6 bg-gradient-to-br from-white to-white-50" data-index="0">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-base sm:text-lg font-bold text-white-700">Battery #1</h4>
                                    <button type="button" class="btn-remove hidden px-2 sm:px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                                        Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                                        <input type="number" name="readings[0][bank_number]" value="" required min="1" placeholder="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                                        <input type="number" name="readings[0][battery_number]" value="" required min="1" placeholder="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                                        <input type="number" step="0.1" name="readings[0][voltage]" required min="0" max="20" placeholder="13.8"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-white-500 focus:border-transparent">
                                    </div>
                                </div>

                                <!-- Hidden battery_brand field -->
                                <input type="hidden" name="readings[0][battery_brand]" class="reading-battery-brand">

                                <!-- Camera Section -->
                                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>

                                    <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="0" autoplay playsinline></video>
                                    <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 hidden" data-index="0" alt="Captured">
                                    <canvas class="hidden" data-index="0"></canvas>

                                    <div class="flex flex-wrap gap-2 justify-center mb-3">
                                        <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="0">
                                            Buka Kamera
                                        </button>
                                        <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="0">
                                            Ambil Foto
                                        </button>
                                        <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="0">
                                            Foto Ulang
                                        </button>
                                    </div>

                                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded" data-index="0"></div>

                                    <input type="hidden" name="readings[0][photo_data]" data-photo="0">
                                    <input type="hidden" name="readings[0][photo_latitude]" data-lat="0">
                                    <input type="hidden" name="readings[0][photo_longitude]" data-lng="0">
                                    <input type="hidden" name="readings[0][photo_timestamp]" data-time="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                    <a href="{{ route('battery.index') }}"
                        class="px-6 sm:px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transition-colors duration-200 text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 sm:px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-500 hover:from-blue-600 hover:to-blue-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let batteryCount = 1;
        let streams = {};

        // Add Battery Button
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

                <!-- Hidden battery_brand field -->
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

        // Remove Battery Function
        function attachRemoveEvent(item) {
            const removeBtn = item.querySelector('.btn-remove');
            removeBtn.addEventListener('click', function() {
                const index = item.getAttribute('data-index');

                if (streams[index]) {
                    streams[index].getTracks().forEach(track => track.stop());
                    delete streams[index];
                }

                item.remove();
            });
        }

        // Camera Functions
        function attachCameraEvents(index) {
            const video = document.querySelector(`.camera-preview[data-index="${index}"]`);
            const canvas = document.querySelector(`canvas[data-index="${index}"]`);
            const capturedImage = document.querySelector(`.captured-image[data-index="${index}"]`);
            const startBtn = document.querySelector(`.start-camera[data-index="${index}"]`);
            const captureBtn = document.querySelector(`.capture-photo[data-index="${index}"]`);
            const retakeBtn = document.querySelector(`.retake-photo[data-index="${index}"]`);
            const photoInfo = document.querySelector(`.photo-info[data-index="${index}"]`);

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
                    startBtn.classList.add('hidden');
                    captureBtn.classList.remove('hidden');

                    console.log('Camera started successfully for index:', index);
                } catch (err) {
                    console.error('Camera error:', err);
                    alert('Error membuka kamera: ' + err.message + '\n\nPastikan:\n1. Browser memiliki izin akses kamera\n2. Menggunakan HTTPS atau localhost\n3. Kamera tidak digunakan aplikasi lain');
                }
            });

            captureBtn.addEventListener('click', function() {
                capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, photoInfo);
            });

            retakeBtn.addEventListener('click', function() {
                capturedImage.classList.add('hidden');
                video.classList.add('hidden');
                startBtn.classList.remove('hidden');
                retakeBtn.classList.add('hidden');
                photoInfo.innerHTML = '';
                document.querySelector(`input[data-photo="${index}"]`).value = '';
                document.querySelector(`input[data-lat="${index}"]`).value = '';
                document.querySelector(`input[data-lng="${index}"]`).value = '';
                document.querySelector(`input[data-time="${index}"]`).value = '';
            });
        }

        // Get address from coordinates
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

        function capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, photoInfo) {
            if (navigator.geolocation) {
                photoInfo.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan lokasi GPS...</p>';

                navigator.geolocation.getCurrentPosition(
                    async function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            const timestamp = new Date();

                            // Update info to show getting address
                            photoInfo.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan alamat...</p>';

                            // Get address
                            const address = await getAddress(lat, lng);

                            // Set canvas size to match video
                            canvas.width = video.videoWidth || 1280;
                            canvas.height = video.videoHeight || 720;
                            const ctx = canvas.getContext('2d');

                            // Draw video frame
                            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                            // Format date and time
                            const dateStr = timestamp.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                            const dayStr = timestamp.toLocaleDateString('id-ID', {
                                weekday: 'long'
                            });

                            // Determine timezone based on longitude
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

                            // Draw text with shadow for better readability
                            const fontSize = Math.max(14, canvas.width * 0.018);
                            const padding = 15;
                            const lineHeight = fontSize * 1.8;
                            const startY = canvas.height - (lineHeight * 5.5);

                            // Add text shadow
                            ctx.shadowColor = 'rgba(0, 0, 0, 0.9)';
                            ctx.shadowBlur = 10;
                            ctx.shadowOffsetX = 2;
                            ctx.shadowOffsetY = 2;

                            // Draw text
                            ctx.fillStyle = 'white';
                            ctx.font = `${fontSize}px Arial`;

                            ctx.fillText(`${dateStr}`, padding, startY);
                            ctx.fillText(`${dayStr}`, padding, startY + lineHeight);

                            // Make time bigger and bold
                            ctx.font = `bold ${fontSize * 2.5}px Arial`;
                            ctx.fillText(`${timeStr}`, padding, startY + (lineHeight * 2.3));

                            // Return to normal size for remaining text
                            ctx.font = `${fontSize}px Arial`;
                            ctx.fillText(`Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`, padding, startY + (lineHeight * 3.5));
                            ctx.fillText(`${address}`, padding, startY + (lineHeight * 4.5));

                            // Convert to image
                            const imageData = canvas.toDataURL('image/jpeg', 0.85);
                            capturedImage.src = imageData;
                            capturedImage.classList.remove('hidden');
                            video.classList.add('hidden');

                            // Save data
                            document.querySelector(`input[data-photo="${index}"]`).value = imageData;
                            document.querySelector(`input[data-lat="${index}"]`).value = lat;
                            document.querySelector(`input[data-lng="${index}"]`).value = lng;
                            document.querySelector(`input[data-time="${index}"]`).value = timestamp.toISOString();

                            // Stop camera
                            if (streams[index]) {
                                streams[index].getTracks().forEach(track => track.stop());
                                delete streams[index];
                            }

                            captureBtn.classList.add('hidden');
                            retakeBtn.classList.remove('hidden');

                            //     photoInfo.innerHTML = `
                            //     <p class="text-green-600 font-semibold">✓ Foto berhasil diambil!</p>
                            //     <p><strong>Tanggal:</strong> ${dateStr}</p>
                            //     <p class="mt-1"><strong>Longitude:</strong> ${lng.toFixed(6)}, <strong>Latitude:</strong> ${lat.toFixed(6)}</p>
                            //     <p><strong>Alamat:</strong> ${address}</p>
                            //     <p><strong>Waktu:</strong> ${timeStr}</p>
                            // `;

                            console.log('Photo captured successfully for index:', index);
                        },
                        function(error) {
                            console.error('Geolocation error:', error);
                            photoInfo.innerHTML = '<p class="text-red-600">❌ Gagal mendapatkan lokasi GPS</p>';
                            alert('Tidak dapat mengakses lokasi GPS: ' + error.message + '\n\nPastikan browser memiliki izin akses lokasi.');
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

        // Sync battery_brand to all readings before submit
        document.getElementById('mainForm').addEventListener('submit', function(e) {
            const mainBatteryBrand = document.getElementById('main_battery_brand').value;
            document.querySelectorAll('.reading-battery-brand').forEach(function(input) {
                input.value = mainBatteryBrand;
            });
        });

        // Initialize first battery camera
        document.addEventListener('DOMContentLoaded', function() {
            // Set current datetime in local timezone
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const localDatetime = `${year}-${month}-${day}T${hours}:${minutes}`;

            const datetimeInput = document.getElementById('maintenance_date');
            if (datetimeInput && !datetimeInput.value) {
                datetimeInput.value = localDatetime;
            }

            attachCameraEvents(0);
            console.log('Camera events initialized');
        });

        // Debug: Check if running on HTTPS or localhost
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            console.warn('WARNING: Camera and Geolocation require HTTPS or localhost!');
        }
    </script>
</x-app-layout>

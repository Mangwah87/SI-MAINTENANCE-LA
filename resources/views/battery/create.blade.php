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

            <!-- Form -->
            <form action="{{ route('battery.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                @csrf

                <!-- Informasi Umum -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-500 to-blue-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                                <select name="location" id="location-select" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent">
                                    <option value="">-- Pilih Location --</option>
                                    @foreach($centralsByArea as $area => $centrals)
                                        <optgroup label="AREA {{ $area }}">
                                            @foreach($centrals as $central)
                                                <!-- VALUE = ID dari tabel central (1, 2, 3, dst) -->
                                                <option value="{{ $central->id }}"
                                                    {{ old('location') == $central->id ? 'selected' : '' }}>
                                                    {{ $central->id_sentral }} - {{ $central->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-600">Pilih lokasi central dari daftar</p>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                                <input type="datetime-local" name="maintenance_date" id="maintenance_date" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Temperature (°C)</label>
                                <input type="number" step="0.1" name="battery_temperature" value="{{ old('battery_temperature') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent"
                                    placeholder="Contoh: 25.5">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Company</label>
                                <input type="text" name="company" value="{{ old('company', 'PT. Aplikarusa Lintasarta') }}"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent"
                                    placeholder="Nama Perusahaan">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery Brand *</label>
                                <input type="text" name="battery_brand" id="main_battery_brand" value="{{ old('battery_brand', 'Ritar') }}" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent"
                                    placeholder="Contoh: Ritar, Yuasa, Panasonic">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                                <textarea name="notes" rows="4"
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent"
                                    placeholder="Catatan tambahan atau informasi penting lainnya...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pelaksana -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-white-50 to-teal-50 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Data Pelaksana</h3>
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

                            <!-- Mengetahui (Supervisor) - FIELD BARU -->
                        <div class="border-2 rounded-lg p-3 sm:p-4">
                            <h4 class="text-sm sm:text-md font-bold text-black-700 mb-3">Mengetahui</h4>
                            <div class="grid grid-cols-1 gap-3 sm:gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Supervisor / Atasan</label>
                                    <input type="text" name="supervisor" value="{{ old('supervisor') }}"
                                        class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                        placeholder="Nama supervisor yang mengetahui (opsional)">
                                    <p class="mt-1 text-xs text-gray-600 italic">Kosongkan jika tidak ada supervisor yang mengetahui</p>
                                </div>

                                <!-- ID Supervisor - Field Baru -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">ID Supervisor</label>
                                    <input type="text" name="supervisor_id" value="{{ old('supervisor_id') }}"
                                        class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                                        placeholder="ID atau NIK supervisor (opsional)">
                                    <p class="mt-1 text-xs text-gray-600 italic">Masukkan ID/NIK supervisor jika ada</p>
                                </div>
                            </div>
                        </div>
                        </div>
                        <p class="mt-4 text-xs sm:text-sm text-gray-600 italic">
                            <strong>Catatan:</strong> Minimal 1 pelaksana harus diisi. Pelaksana ke-2 dan ke-3 bersifat opsional.
                        </p>
                    </div>
                </div>

                <!-- Battery Configuration -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Konfigurasi Battery</h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Bank *</label>
                                <input type="number" id="total_banks" min="1" value="1" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent"
                                    placeholder="Contoh: 2">
                                <p class="mt-1 text-xs text-gray-600">Berapa bank battery yang akan diinput?</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Battery per Bank *</label>
                                <input type="number" id="batteries_per_bank" min="1" value="1" required
                                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent"
                                    placeholder="Contoh: 24">
                                <p class="mt-1 text-xs text-gray-600">Berapa battery dalam satu bank?</p>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="button" id="generate-batteries"
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:from-purple-600 hover:to-blue-700 text-white text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Generate Form Battery
                            </button>
                        </div>
                        <p class="mt-3 text-sm text-center text-gray-600 italic">
                            Total Battery: <strong><span id="total-batteries">0</span></strong>
                        </p>
                    </div>
                </div>

                <!-- Data Battery Readings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 border-b border-gray-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Data Pembacaan Battery</h3>
                    </div>

                    <div class="p-4 sm:p-6">
                        <div id="battery-readings" class="space-y-4 sm:space-y-6">
                            <!-- Battery items will be generated here -->
                            <div class="text-center text-gray-500 py-8">
                                <p class="text-lg">👆 Silakan konfigurasi dan generate form battery terlebih dahulu</p>
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
                        class="px-6 sm:px-8 py-3 bg-blue-700 hover:from-blue-600 hover:to-blue-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let streams = {};

        // Calculate and display total batteries
        function updateTotalBatteries() {
            const banks = parseInt(document.getElementById('total_banks').value) || 0;
            const perBank = parseInt(document.getElementById('batteries_per_bank').value) || 0;
            const total = banks * perBank;
            document.getElementById('total-batteries').textContent = total;
        }

        document.getElementById('total_banks').addEventListener('input', updateTotalBatteries);
        document.getElementById('batteries_per_bank').addEventListener('input', updateTotalBatteries);

        // Generate Battery Forms
        document.getElementById('generate-batteries').addEventListener('click', function() {
            const totalBanks = parseInt(document.getElementById('total_banks').value);
            const batteriesPerBank = parseInt(document.getElementById('batteries_per_bank').value);

            if (!totalBanks || !batteriesPerBank || totalBanks < 1 || batteriesPerBank < 1) {
                alert('Mohon isi jumlah bank dan battery per bank dengan benar!');
                return;
            }

            const total = totalBanks * batteriesPerBank;
            const confirm = window.confirm(`Akan membuat ${total} form battery (${totalBanks} bank × ${batteriesPerBank} battery).\n\nLanjutkan?`);

            if (!confirm) return;

            // Stop all existing camera streams
            Object.keys(streams).forEach(key => {
                if (streams[key]) {
                    streams[key].getTracks().forEach(track => track.stop());
                }
            });
            streams = {};

            const container = document.getElementById('battery-readings');
            container.innerHTML = '';

            let index = 0;
            for (let bank = 1; bank <= totalBanks; bank++) {
                for (let batteryNum = 1; batteryNum <= batteriesPerBank; batteryNum++) {
                    const batteryItem = createBatteryItem(index, bank, batteryNum);
                    container.appendChild(batteryItem);
                    attachCameraEvents(index);
                    index++;
                }
            }

            // Scroll to battery readings
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        // Create Battery Item
        function createBatteryItem(index, bankNumber, batteryNumber) {
            const div = document.createElement('div');
            div.className = 'battery-item border-2 border-gray-200 rounded-xl p-4 sm:p-6';
            div.setAttribute('data-index', index);

            div.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-base sm:text-lg font-bold text-blue-700">Bank ${bankNumber} - Battery ${batteryNumber}</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                        <input type="number" name="readings[${index}][bank_number]" value="${bankNumber}" required readonly
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                        <input type="number" name="readings[${index}][battery_number]" value="${batteryNumber}" required readonly
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                        <input type="number" step="0.01" name="readings[${index}][voltage]" required min="0" max="65" placeholder="13.8"
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2  focus:border-transparent">
                    </div>
                </div>

                <input type="hidden" name="readings[${index}][battery_brand]" class="reading-battery-brand">

                <!-- Photo Documentation Section -->
                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>

                    <!-- Upload Method Selection -->
                    <div class="flex gap-2 mb-3">
                        <button type="button" class="method-camera flex-1 px-3 py-2 bg-blue-500 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${index}">
                            Camera
                        </button>
                        <button type="button" class="method-upload flex-1 px-3 py-2 bg-gray-300 text-gray-700 text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${index}">
                            Upload File
                        </button>
                    </div>

                    <!-- Camera Section -->
                    <div class="camera-section" data-index="${index}">
                        <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="${index}" autoplay playsinline></video>
                        <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 hidden" data-index="${index}" alt="Captured">
                        <canvas class="hidden" data-index="${index}"></canvas>

                        <div class="flex flex-wrap gap-2 justify-center mb-3">
                            <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${index}">
                                Buka Kamera
                            </button>
                            <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${index}">
                                Ambil Foto
                            </button>
                            <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${index}">
                                Foto Ulang
                            </button>
                        </div>
                    </div>

                    <!-- Upload Section -->
                    <div class="upload-section hidden" data-index="${index}">
                        <input type="file" class="file-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" accept="image/*" data-index="${index}">
                        <div class="uploaded-preview mt-3 hidden">
                            <img class="uploaded-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-2" data-index="${index}" alt="Uploaded">
                            <button type="button" class="remove-upload px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${index}">
                                Hapus Foto
                            </button>
                        </div>
                    </div>

                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3" data-index="${index}"></div>

                    <input type="hidden" name="readings[${index}][photo_data]" data-photo="${index}">
                    <input type="hidden" name="readings[${index}][photo_latitude]" data-lat="${index}">
                    <input type="hidden" name="readings[${index}][photo_longitude]" data-lng="${index}">
                    <input type="hidden" name="readings[${index}][photo_timestamp]" data-time="${index}">
                </div>
            `;

            return div;
        }
        // Fungsi untuk kompres gambar agar maksimal 1 MB
function compressImageTo1MB(canvas, initialQuality = 0.85) {
    let quality = initialQuality;
    let imageData = canvas.toDataURL('image/jpeg', quality);

    // Maksimum 1 MB = 1,000,000 bytes
    while (imageData.length > 1_000_000 && quality > 0.2) {
        quality -= 0.05;
        imageData = canvas.toDataURL('image/jpeg', quality);
    }

    return imageData;
}

        // Camera Events
        function attachCameraEvents(index) {
            const item = document.querySelector(`.battery-item[data-index="${index}"]`);
            if (!item) return;

            // Method toggle
            const methodCamera = item.querySelector('.method-camera');
            const methodUpload = item.querySelector('.method-upload');
            const cameraSection = item.querySelector('.camera-section');
            const uploadSection = item.querySelector('.upload-section');

            methodCamera.addEventListener('click', function() {
                methodCamera.classList.remove('bg-gray-300', 'text-gray-700');
                methodCamera.classList.add('bg-blue-500', 'text-white');
                methodUpload.classList.remove('bg-blue-500', 'text-white');
                methodUpload.classList.add('bg-gray-300', 'text-gray-700');

                cameraSection.classList.remove('hidden');
                uploadSection.classList.add('hidden');

                // Clear upload data
                const fileInput = item.querySelector('.file-input');
                fileInput.value = '';
                item.querySelector('.uploaded-preview').classList.add('hidden');
            });

            methodUpload.addEventListener('click', function() {
                methodUpload.classList.remove('bg-gray-300', 'text-gray-700');
                methodUpload.classList.add('bg-blue-500', 'text-white');
                methodCamera.classList.remove('bg-blue-500', 'text-white');
                methodCamera.classList.add('bg-gray-300', 'text-gray-700');

                uploadSection.classList.remove('hidden');
                cameraSection.classList.add('hidden');

                // Stop camera if running
                if (streams[index]) {
                    streams[index].getTracks().forEach(track => track.stop());
                    delete streams[index];
                }

                // Hide camera elements
                const video = item.querySelector('.camera-preview');
                const capturedImage = item.querySelector('.captured-image');
                const startBtn = item.querySelector('.start-camera');
                const captureBtn = item.querySelector('.capture-photo');
                const retakeBtn = item.querySelector('.retake-photo');

                video.classList.add('hidden');
                capturedImage.classList.add('hidden');
                startBtn.classList.remove('hidden');
                captureBtn.classList.add('hidden');
                retakeBtn.classList.add('hidden');
            });

            // Camera controls
            const video = item.querySelector('.camera-preview');
            const canvas = item.querySelector('canvas');
            const capturedImage = item.querySelector('.captured-image');
            const startBtn = item.querySelector('.start-camera');
            const captureBtn = item.querySelector('.capture-photo');
            const retakeBtn = item.querySelector('.retake-photo');
            const photoInfo = item.querySelector('.photo-info');

            startBtn.addEventListener('click', async function() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } },
                        audio: false
                    });
                    streams[index] = stream;
                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    startBtn.classList.add('hidden');
                    captureBtn.classList.remove('hidden');
                } catch (err) {
                    alert('Error membuka kamera: ' + err.message);
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

            // File upload
            const fileInput = item.querySelector('.file-input');
            const uploadedPreview = item.querySelector('.uploaded-preview');
            const uploadedImage = item.querySelector('.uploaded-image');
            const removeUploadBtn = item.querySelector('.remove-upload');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar!');
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB!');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        // Resize if needed
                        const maxWidth = 1280;
                        const maxHeight = 720;
                        let width = img.width;
                        let height = img.height;

                        if (width > maxWidth || height > maxHeight) {
                            const ratio = Math.min(maxWidth / width, maxHeight / height);
                            width = width * ratio;
                            height = height * ratio;
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        // Get geolocation
                        if (navigator.geolocation) {
                            photoInfo.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan lokasi GPS...</p>';

                            navigator.geolocation.getCurrentPosition(
                                async function(position) {
                                    const lat = position.coords.latitude;
                                    const lng = position.coords.longitude;
                                    const timestamp = new Date();

                                    photoInfo.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan alamat...</p>';
                                    const address = await getAddress(lat, lng);

                                    // Add watermark
                                    // addWatermarkToCanvas(canvas, lat, lng, timestamp, address);

                                    const imageData = compressImageTo1MB(canvas);

                                    uploadedImage.src = imageData;
                                    uploadedPreview.classList.remove('hidden');

                                    document.querySelector(`input[data-photo="${index}"]`).value = imageData;
                                    document.querySelector(`input[data-lat="${index}"]`).value = lat;
                                    document.querySelector(`input[data-lng="${index}"]`).value = lng;
                                    document.querySelector(`input[data-time="${index}"]`).value = timestamp.toISOString();

                                    photoInfo.innerHTML = '<p class="text-green-600 font-semibold">✓ Foto berhasil diupload dengan data GPS!</p>';
                                },
                                function(error) {
                                    // Upload without GPS
                                    const imageData = compressImageTo1MB(canvas);

                                    uploadedImage.src = imageData;
                                    uploadedPreview.classList.remove('hidden');
                                    document.querySelector(`input[data-photo="${index}"]`).value = imageData;
                                    photoInfo.innerHTML = '<p class="text-yellow-600">⚠️ Foto diupload tanpa data GPS</p>';
                                },
                                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                            );
                        } else {
                            const imageData = compressImageTo1MB(canvas);

                            uploadedImage.src = imageData;
                            uploadedPreview.classList.remove('hidden');
                            document.querySelector(`input[data-photo="${index}"]`).value = imageData;
                            photoInfo.innerHTML = '<p class="text-yellow-600">⚠️ Foto diupload tanpa data GPS</p>';
                        }
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });

            removeUploadBtn.addEventListener('click', function() {
                fileInput.value = '';
                uploadedPreview.classList.add('hidden');
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
                return 'Alamat tidak tersedia';
            }
        }

        // Add watermark to canvas
        function addWatermarkToCanvas(canvas, lat, lng, timestamp, address) {
            const ctx = canvas.getContext('2d');
            const fontSize = Math.max(14, canvas.width * 0.018);
            const padding = 15;
            const lineHeight = fontSize * 1.8;
            const startY = canvas.height - (lineHeight * 5.5);

            const dateStr = timestamp.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
            const dayStr = timestamp.toLocaleDateString('id-ID', { weekday: 'long' });

            let timezone = 'WITA';
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
        }

        // Capture photo from camera
        function capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, photoInfo) {
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

                        addWatermarkToCanvas(canvas, lat, lng, timestamp, address);

                        const imageData = compressImageTo1MB(canvas);
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
                        photoInfo.innerHTML = '<p class="text-green-600 font-semibold">✓ Foto berhasil diambil!</p>';
                    },
                    function(error) {
                        photoInfo.innerHTML = '<p class="text-red-600">❌ Gagal mendapatkan lokasi GPS</p>';
                        alert('Tidak dapat mengakses lokasi GPS: ' + error.message);
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
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

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
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

            updateTotalBatteries();
        });

        // Debug
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            console.warn('WARNING: Camera and Geolocation require HTTPS or localhost!');
        }
    </script>
</x-app-layout>

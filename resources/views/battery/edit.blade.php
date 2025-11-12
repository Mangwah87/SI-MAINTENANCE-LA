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
                <!-- Mengetahui (Supervisor) -->
<div class="border-2 border-green-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-green-50">
    <h4 class="text-sm sm:text-md font-bold text-green-700 mb-3">Mengetahui</h4>
    <div class="grid grid-cols-1 gap-3 sm:gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Supervisor / Atasan</label>
            <input type="text" name="supervisor"
                value="{{ old('supervisor', $maintenance->supervisor) }}"
                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                placeholder="Nama supervisor yang mengetahui (opsional)">
            <p class="mt-1 text-xs text-gray-600 italic">Kosongkan jika tidak ada supervisor yang mengetahui</p>
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
                            <div class="battery-item border-2 border-white-300 rounded-xl p-4 sm:p-6 bg-gradient-to-br from-white to-purple-50" data-index="{{ $index }}">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-base sm:text-lg font-bold text-blue-700">Battery #{{ $index + 1 }}</h4>
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
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-grey-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                                        <input type="number" name="readings[{{ $index }}][battery_number]"
                                            value="{{ old('readings.'.$index.'.battery_number', $reading->battery_number) }}"
                                            required min="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-grey-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                                        <input type="number" step="0.2" name="readings[{{ $index }}][voltage]"
                                            value="{{ old('readings.'.$index.'.voltage', $reading->voltage) }}"
                                            required min="0" max="20"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-grey-500 focus:border-transparent">
                                    </div>
                                </div>

                                <input type="hidden" name="readings[{{ $index }}][battery_brand]" class="reading-battery-brand">

                                <!-- Camera Section -->
                                <!-- Camera Section dengan tampilan foto yang lebih jelas -->
                                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery</label>

                                    @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                    <!-- Container untuk foto yang sudah ada -->
                                    <div class="existing-photo-container mb-4" data-index="{{ $index }}">
                                        <div class="relative">
                                            <!-- Badge status foto -->
                                            <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg z-10">
                                                ✓ Foto Tersedia
                                            </div>

                                            <!-- Gambar yang sudah ada -->
                                            <img src="{{ Storage::url($reading->photo_path) }}"
                                                class="existing-photo w-full h-auto max-h-80 sm:max-h-96 rounded-lg border-4  object-contain shadow-lg"
                                                alt="Battery Photo #{{ $index + 1 }}"
                                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'bg-red-50 border-2 border-red-300 rounded-lg p-4 text-center\'><p class=\'text-red-600 font-semibold\'>⚠️ Gambar tidak dapat dimuat</p><p class=\'text-sm text-gray-600 mt-2\'>Path: {{ $reading->photo_path }}</p></div>';"
                                                data-index="{{ $index }}">
                                        </div>

                                        <!-- Info foto yang sudah ada -->
                                        <div class="mt-3 bg-grey-50 border-l-4 border-grey-500 p-3 rounded">
                                            <p class="text-sm text-grey-700 font-semibold mb-1">
                                                <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Foto sudah tersimpan untuk battery ini
                                            </p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                Klik tombol "Ganti Foto" di bawah jika ingin menggantinya dengan foto baru.
                                            </p>
                                            @if($reading->photo_latitude && $reading->photo_longitude)
                                            <p class="text-xs text-gray-600 mt-2">
                                                📍 Lokasi: {{ number_format($reading->photo_latitude, 6) }}, {{ number_format($reading->photo_longitude, 6) }}
                                            </p>
                                            @endif
                                            @if($reading->photo_timestamp)
                                            <p class="text-xs text-gray-600 mt-1">
                                                🕐 Waktu: {{ \Carbon\Carbon::parse($reading->photo_timestamp)->format('d M Y, H:i:s') }}
                                            </p>
                                            @endif
                                        </div>

                                        <input type="hidden" name="readings[{{ $index }}][keep_photo]" value="1" class="keep-photo-input" data-index="{{ $index }}">
                                    </div>
                                    @else
                                    <!-- Container kosong jika belum ada foto -->
                                    <div class="existing-photo-container mb-4" data-index="{{ $index }}">
                                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-sm text-gray-600 font-semibold">Belum ada foto untuk battery ini</p>
                                            <p class="text-xs text-gray-500 mt-1">Klik "Buka Kamera" untuk mengambil foto</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Video preview untuk kamera -->
                                    <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden shadow-lg" data-index="{{ $index }}" autoplay playsinline></video>

                                    <!-- Gambar hasil capture -->
                                    <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 border-4 border-blue-400 shadow-lg hidden" data-index="{{ $index }}" alt="Captured">

                                    <!-- Canvas tersembunyi -->
                                    <canvas class="hidden" data-index="{{ $index }}"></canvas>

                                    <!-- Tombol kontrol kamera -->
                                    <div class="flex flex-wrap gap-2 justify-center mb-3">
                                        <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105" data-index="{{ $index }}">
                                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                            Ganti Foto
                                            @else
                                            Buka Kamera
                                            @endif
                                        </button>
                                        <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105" data-index="{{ $index }}">
                                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Ambil Foto
                                        </button>
                                        <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105" data-index="{{ $index }}">
                                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Foto Ulang
                                        </button>
                                        <button type="button" class="cancel-photo hidden px-3 sm:px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105" data-index="{{ $index }}">
                                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </div>

                                    <!-- Info foto -->
                                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded" data-index="{{ $index }}"></div>

                                    <!-- Hidden inputs -->
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
      let batteryCount = @json($maintenance->readings ? $maintenance->readings->count() : 0);
    let streams = {};
        document.getElementById('add-battery').addEventListener('click', function() {
            const container = document.getElementById('battery-readings');
            const newBattery = document.createElement('div');
            newBattery.className = 'battery-item border-2 border-gray-70 rounded-xl p-4 sm:p-6  ';
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

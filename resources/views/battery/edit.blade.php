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
                                <h4 class="text-sm sm:text-md font-bold text-gray-700 mb-3">Pelaksana #1 *</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                                        <input type="text" name="technician_1_name"
                                            value="{{ old('technician_1_name', $maintenance->technician_1_name) }}" required
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan *</label>
                                        <input type="text" name="technician_1_company"
                                            value="{{ old('technician_1_company', $maintenance->technician_1_company) }}" required
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Pelaksana 2 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-gray-700 mb-3">Pelaksana #2 (Opsional)</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="technician_2_name"
                                            value="{{ old('technician_2_name', $maintenance->technician_2_name) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                                        <input type="text" name="technician_2_company"
                                            value="{{ old('technician_2_company', $maintenance->technician_2_company) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Pelaksana 3 -->
                            <div class="border-2 border-white-200 rounded-lg p-3 sm:p-4 bg-gradient-to-br from-white to-white-50">
                                <h4 class="text-sm sm:text-md font-bold text-gray-700 mb-3">Pelaksana #3 (Opsional)</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="technician_3_name"
                                            value="{{ old('technician_3_name', $maintenance->technician_3_name) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                                        <input type="text" name="technician_3_company"
                                            value="{{ old('technician_3_company', $maintenance->technician_3_company) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Mengetahui (Supervisor) -->
                            <div class="border-2 border-gray-200 rounded-lg p-3 sm:p-4 bg-white">
                                <h4 class="text-sm sm:text-md font-bold text-gray-700 mb-3">Mengetahui</h4>
                                <div class="grid grid-cols-1 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Supervisor / Atasan</label>
                                        <input type="text" name="supervisor"
                                            value="{{ old('supervisor', $maintenance->supervisor) }}"
                                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Nama supervisor yang mengetahui (opsional)">
                                        <p class="mt-1 text-xs text-gray-600 italic">Kosongkan jika tidak ada supervisor yang mengetahui</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Battery Readings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
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
                            <div class="battery-item border-2 border-blue-300 rounded-xl p-4 sm:p-6 bg-gradient-to-br from-white to-blue-50" data-index="{{ $index }}">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-base sm:text-lg font-bold text-blue-700">Bank {{ $reading->bank_number }} - Battery #{{ $reading->battery_number }}</h4>
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
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                                        <input type="number" name="readings[{{ $index }}][battery_number]"
                                            value="{{ old('readings.'.$index.'.battery_number', $reading->battery_number) }}"
                                            required min="1"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                                        <input type="number" step="0.2" name="readings[{{ $index }}][voltage]"
                                            value="{{ old('readings.'.$index.'.voltage', $reading->voltage) }}"
                                            required min="0" max="20"
                                            class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>

                                <input type="hidden" name="readings[{{ $index }}][battery_brand]" class="reading-battery-brand">

                                <!-- Photo Documentation Section -->
                                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery</label>

                                    @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                    <div class="existing-photo-container mb-4" data-index="{{ $index }}">
                                        <div class="relative">
                                            <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg z-10">
                                                ✓ Foto Tersedia
                                            </div>
                                            <img src="{{ Storage::url($reading->photo_path) }}"
                                                class="existing-photo w-full h-auto max-h-80 sm:max-h-96 rounded-lg border-4 border-green-300 object-contain shadow-lg"
                                                alt="Battery Photo #{{ $index + 1 }}"
                                                data-index="{{ $index }}">
                                        </div>

                                        <div class="mt-3 bg-green-50 border-l-4 border-green-500 p-3 rounded">
                                            <p class="text-sm text-green-700 font-semibold mb-1">
                                                <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Foto sudah tersimpan untuk battery ini
                                            </p>
                                            <p class="text-xs text-gray-600 mt-1">Pilih metode di bawah jika ingin menggantinya.</p>
                                            @if($reading->photo_latitude && $reading->photo_longitude)
                                            <p class="text-xs text-gray-600 mt-2">📍 Lokasi: {{ number_format($reading->photo_latitude, 6) }}, {{ number_format($reading->photo_longitude, 6) }}</p>
                                            @endif
                                            @if($reading->photo_timestamp)
                                            <p class="text-xs text-gray-600 mt-1">🕐 Waktu: {{ \Carbon\Carbon::parse($reading->photo_timestamp)->format('d M Y, H:i:s') }}</p>
                                            @endif
                                        </div>

                                        <input type="hidden" name="readings[{{ $index }}][keep_photo]" value="1" class="keep-photo-input" data-index="{{ $index }}">
                                    </div>
                                    @else
                                    <div class="existing-photo-container mb-4" data-index="{{ $index }}">
                                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-sm text-gray-600 font-semibold">Belum ada foto untuk battery ini</p>
                                            <p class="text-xs text-gray-500 mt-1">Pilih metode di bawah untuk menambahkan foto</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Upload Method Selection -->
                                    <div class="flex gap-2 mb-3">
                                        <button type="button" class="method-camera flex-1 px-3 py-2 bg-blue-500 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                            📷 Camera
                                        </button>
                                        <button type="button" class="method-upload flex-1 px-3 py-2 bg-gray-300 text-gray-700 text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                            📁 Upload File
                                        </button>
                                    </div>

                                    <!-- Camera Section -->
                                    <div class="camera-section" data-index="{{ $index }}">
                                        <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden shadow-lg" data-index="{{ $index }}" autoplay playsinline></video>
                                        <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 border-4 border-blue-400 shadow-lg hidden" data-index="{{ $index }}" alt="Captured">
                                        <canvas class="hidden" data-index="{{ $index }}"></canvas>

                                        <div class="flex flex-wrap gap-2 justify-center mb-3">
                                            <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105" data-index="{{ $index }}">
                                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Buka Kamera
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
                                    </div>

                                    <!-- Upload Section -->
                                    <div class="upload-section hidden" data-index="{{ $index }}">
                                        <input type="file" class="file-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" accept="image/*" data-index="{{ $index }}">
                                        <div class="uploaded-preview mt-3 hidden">
                                            <img class="uploaded-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-2 border-4 border-blue-400 shadow-lg" data-index="{{ $index }}" alt="Uploaded">
                                            <button type="button" class="remove-upload px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="{{ $index }}">
                                                Hapus Foto
                                            </button>
                                        </div>
                                    </div>

                                    <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3" data-index="{{ $index }}"></div>

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
                        class="px-6 sm:px-8 py-3 bg-blue-600 text-white text-sm sm:text-base font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let batteryCount = @json($maintenance->readings ? $maintenance->readings->count() : 0);
        let streams = {};

        // Compress image to max 1MB
        function compressImageTo1MB(canvas, initialQuality = 0.85) {
            let quality = initialQuality;
            let imageData = canvas.toDataURL('image/jpeg', quality);
            while (imageData.length > 1_000_000 && quality > 0.2) {
                quality -= 0.05;
                imageData = canvas.toDataURL('image/jpeg', quality);
            }
            return imageData;
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

            let timezone = 'WIB';
            if (lng >= 120 && lng < 130) timezone = 'WITA';
            else if (lng >= 130) timezone = 'WIT';

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
            ctx.fillText(dateStr, padding, startY);
            ctx.fillText(dayStr, padding, startY + lineHeight);

            ctx.font = `bold ${fontSize * 2.5}px Arial`;
            ctx.fillText(timeStr, padding, startY + (lineHeight * 2.3));

            ctx.font = `${fontSize}px Arial`;
            ctx.fillText(`Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`, padding, startY + (lineHeight * 3.5));
            ctx.fillText(address, padding, startY + (lineHeight * 4.5));
        }

        // Add new battery
        document.getElementById('add-battery').addEventListener('click', function() {
            const container = document.getElementById('battery-readings');
            const newBattery = document.createElement('div');
            newBattery.className = 'battery-item border-2 border-blue-300 rounded-xl p-4 sm:p-6 bg-gradient-to-br from-white to-blue-50';
            newBattery.setAttribute('data-index', batteryCount);

            newBattery.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-base sm:text-lg font-bold text-blue-700">Battery #${batteryCount + 1}</h4>
                    <button type="button" class="btn-remove px-2 sm:px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                        Hapus
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Bank *</label>
                        <input type="number" name="readings[${batteryCount}][bank_number]" value="1" required min="1"
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No *</label>
                        <input type="number" name="readings[${batteryCount}][battery_number]" value="${batteryCount + 1}" required min="1"
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Voltage (VDC) *</label>
                        <input type="number" step="0.1" name="readings[${batteryCount}][voltage]" required min="0" max="20" placeholder="13.8"
                               class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <input type="hidden" name="readings[${batteryCount}][battery_brand]" class="reading-battery-brand">

                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Battery (Opsional)</label>

                    <div class="flex gap-2 mb-3">
                        <button type="button" class="method-camera flex-1 px-3 py-2 bg-blue-500 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">
                            📷 Camera
                        </button>
                        <button type="button" class="method-upload flex-1 px-3 py-2 bg-gray-300 text-gray-700 text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">
                            📁 Upload File
                        </button>
                    </div>

                    <div class="camera-section" data-index="${batteryCount}">
                        <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" data-index="${batteryCount}" autoplay playsinline></video>
                        <img class="captured-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-3 hidden" data-index="${batteryCount}" alt="Captured">
                        <canvas class="hidden" data-index="${batteryCount}"></canvas>

                        <div class="flex flex-wrap gap-2 justify-center mb-3">
                            <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">Buka Kamera</button>
                            <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">Ambil Foto</button>
                            <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">Foto Ulang</button>
                        </div>
                    </div>

                    <div class="upload-section hidden" data-index="${batteryCount}">
                        <input type="file" class="file-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" accept="image/*" data-index="${batteryCount}">
                        <div class="uploaded-preview mt-3 hidden">
                            <img class="uploaded-image w-full h-auto max-h-64 sm:max-h-96 rounded-lg mb-2" data-index="${batteryCount}" alt="Uploaded">
                            <button type="button" class="remove-upload px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200" data-index="${batteryCount}">Hapus Foto</button>
                        </div>
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
            const item = document.querySelector(`.battery-item[data-index="${index}"]`);
            if (!item) return;

            const methodCamera = item.querySelector('.method-camera');
            const methodUpload = item.querySelector('.method-upload');
            const cameraSection = item.querySelector('.camera-section');
            const uploadSection = item.querySelector('.upload-section');
            const existingPhotoContainer = item.querySelector('.existing-photo-container');
            const keepPhotoInput = item.querySelector('.keep-photo-input');

            // Method toggle
            if (methodCamera) {
                methodCamera.addEventListener('click', function() {
                    methodCamera.classList.remove('bg-gray-300', 'text-gray-700');
                    methodCamera.classList.add('bg-blue-500', 'text-white');
                    methodUpload.classList.remove('bg-blue-500', 'text-white');
                    methodUpload.classList.add('bg-gray-300', 'text-gray-700');

                    cameraSection.classList.remove('hidden');
                    uploadSection.classList.add('hidden');
                    if (existingPhotoContainer) existingPhotoContainer.classList.add('hidden');
                    if (keepPhotoInput) keepPhotoInput.value = '0';

                    const fileInput = item.querySelector('.file-input');
                    if (fileInput) fileInput.value = '';
                    const uploadedPreview = item.querySelector('.uploaded-preview');
                    if (uploadedPreview) uploadedPreview.classList.add('hidden');
                });
            }

            if (methodUpload) {
                methodUpload.addEventListener('click', function() {
                    methodUpload.classList.remove('bg-gray-300', 'text-gray-700');
                    methodUpload.classList.add('bg-blue-500', 'text-white');
                    methodCamera.classList.remove('bg-blue-500', 'text-white');
                    methodCamera.classList.add('bg-gray-300', 'text-gray-700');

                    uploadSection.classList.remove('hidden');
                    cameraSection.classList.add('hidden');
                    if (existingPhotoContainer) existingPhotoContainer.classList.add('hidden');
                    if (keepPhotoInput) keepPhotoInput.value = '0';

                    if (streams[index]) {
                        streams[index].getTracks().forEach(track => track.stop());
                        delete streams[index];
                    }

                    const video = item.querySelector('.camera-preview');
                    const capturedImage = item.querySelector('.captured-image');
                    const startBtn = item.querySelector('.start-camera');
                    const captureBtn = item.querySelector('.capture-photo');
                    const retakeBtn = item.querySelector('.retake-photo');

                    if (video) video.classList.add('hidden');
                    if (capturedImage) capturedImage.classList.add('hidden');
                    if (startBtn) startBtn.classList.remove('hidden');
                    if (captureBtn) captureBtn.classList.add('hidden');
                    if (retakeBtn) retakeBtn.classList.add('hidden');
                });
            }

            // Camera controls
            const video = item.querySelector('.camera-preview');
            const canvas = item.querySelector('canvas');
            const capturedImage = item.querySelector('.captured-image');
            const startBtn = item.querySelector('.start-camera');
            const captureBtn = item.querySelector('.capture-photo');
            const retakeBtn = item.querySelector('.retake-photo');
            const cancelBtn = item.querySelector('.cancel-photo');
            const photoInfo = item.querySelector('.photo-info');

            if (startBtn) {
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
                        if (cancelBtn) cancelBtn.classList.remove('hidden');
                    } catch (err) {
                        alert('Error membuka kamera: ' + err.message);
                    }
                });
            }

            if (captureBtn) {
                captureBtn.addEventListener('click', function() {
                    capturePhoto(index, video, canvas, capturedImage, captureBtn, retakeBtn, cancelBtn, photoInfo);
                });
            }

            if (retakeBtn) {
                retakeBtn.addEventListener('click', function() {
                    capturedImage.classList.add('hidden');
                    video.classList.add('hidden');
                    startBtn.classList.remove('hidden');
                    retakeBtn.classList.add('hidden');
                    if (cancelBtn) cancelBtn.classList.add('hidden');
                    photoInfo.innerHTML = '';
                    document.querySelector(`input[data-photo="${index}"]`).value = '';
                    document.querySelector(`input[data-lat="${index}"]`).value = '';
                    document.querySelector(`input[data-lng="${index}"]`).value = '';
                    document.querySelector(`input[data-time="${index}"]`).value = '';
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    if (streams[index]) {
                        streams[index].getTracks().forEach(track => track.stop());
                        delete streams[index];
                    }

                    video.classList.add('hidden');
                    capturedImage.classList.add('hidden');
                    captureBtn.classList.add('hidden');
                    retakeBtn.classList.add('hidden');
                    cancelBtn.classList.add('hidden');
                    startBtn.classList.remove('hidden');

                    if (existingPhotoContainer) existingPhotoContainer.classList.remove('hidden');
                    if (keepPhotoInput) keepPhotoInput.value = '1';

                    document.querySelector(`input[data-photo="${index}"]`).value = '';
                    document.querySelector(`input[data-lat="${index}"]`).value = '';
                    document.querySelector(`input[data-lng="${index}"]`).value = '';
                    document.querySelector(`input[data-time="${index}"]`).value = '';
                    photoInfo.innerHTML = '';
                });
            }

            // File upload
            const fileInput = item.querySelector('.file-input');
            const uploadedPreview = item.querySelector('.uploaded-preview');
            const uploadedImage = item.querySelector('.uploaded-image');
            const removeUploadBtn = item.querySelector('.remove-upload');

            if (fileInput) {
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

                            // Upload file: NO WATERMARK, just compress and save
                            const imageData = compressImageTo1MB(canvas);
                            uploadedImage.src = imageData;
                            uploadedPreview.classList.remove('hidden');
                            document.querySelector(`input[data-photo="${index}"]`).value = imageData;

                            // Clear GPS data for uploaded files
                            document.querySelector(`input[data-lat="${index}"]`).value = '';
                            document.querySelector(`input[data-lng="${index}"]`).value = '';
                            document.querySelector(`input[data-time="${index}"]`).value = '';

                            photoInfo.innerHTML = '<p class="text-green-600 font-semibold">✓ Foto berhasil diupload!</p>';
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }

            if (removeUploadBtn) {
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
                        if (cancelBtn) cancelBtn.classList.add('hidden');
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
    </script>
</x-app-layout>

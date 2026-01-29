<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit PM Ruang Shelter') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    <form action="{{ route('pm-shelter.update', $pmShelter) }}" method="POST" id="pmForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Location & Equipment Info -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Informasi Lokasi & Perangkat
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Lokasi Sentral <span class="text-red-500">*</span>
                                    </label>
                                    <select name="central_id" id="central_id"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        required>
                                        <option value="">-- Pilih Lokasi Sentral --</option>
                                        @foreach ($centrals as $central)
                                            <option value="{{ $central->id }}"
                                                {{ old('central_id', $pmShelter->central_id) == $central->id ? 'selected' : '' }}>
                                                {{ $central->nama }} - {{ $central->area }} ({{ $central->id_sentral }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('central_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('date', $pmShelter->date?->format('Y-m-d')) }}" required>
                                    @error('date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="time"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('time', $pmShelter->time) }}" required>
                                    @error('time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Brand/Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="brand_type"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        required>
                                        <option value="">-- Pilih Type --</option>
                                        <option value="Shelter" {{ old('brand_type', $pmShelter->brand_type) == 'Shelter' ? 'selected' : '' }}>Shelter</option>
                                        <option value="Outdoor Cabinet" {{ old('brand_type', $pmShelter->brand_type) == 'Outdoor Cabinet' ? 'selected' : '' }}>Outdoor Cabinet</option>
                                        <option value="Pole Outdoor Cabinet" {{ old('brand_type', $pmShelter->brand_type) == 'Pole Outdoor Cabinet' ? 'selected' : '' }}>Pole Outdoor Cabinet</option>
                                    </select>
                                    @error('brand_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number</label>
                                    <input type="text" name="reg_number"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('reg_number', $pmShelter->reg_number) }}">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">S/N</label>
                                    <input type="text" name="serial_number"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('serial_number', $pmShelter->serial_number) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Visual Check -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                1. Visual Check
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <!-- Kondisi Ruangan -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">a. Kondisi
                                        Ruangan</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> Bersih, tidak bocor, tidak kotor
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="kondisi_ruangan_result"
                                                placeholder="Result / Hasil pemeriksaan"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('kondisi_ruangan_result', $pmShelter->kondisi_ruangan_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="kondisi_ruangan_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('kondisi_ruangan_status', $pmShelter->kondisi_ruangan_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="kondisi_ruangan_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('kondisi_ruangan_status', $pmShelter->kondisi_ruangan_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="kondisi_ruangan_photos_container"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kondisi Kunci -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">b. Kondisi Kunci
                                        Ruang/Shelter</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> Kuat, Mudah dibuka
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="kondisi_kunci_result"
                                                placeholder="Result / Hasil pemeriksaan"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('kondisi_kunci_result', $pmShelter->kondisi_kunci_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="kondisi_kunci_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('kondisi_kunci_status', $pmShelter->kondisi_kunci_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="kondisi_kunci_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('kondisi_kunci_status', $pmShelter->kondisi_kunci_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="kondisi_kunci_photos_container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fasilitas Ruangan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                2. Fasilitas Ruangan
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <!-- Layout Tata Ruang -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">a. Layout / Tata
                                        Ruang</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> Sesuai fungsi, kemudahan perawatan,
                                        kenyamanan penggunaan, keindahan
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="layout_tata_ruang_result"
                                                placeholder="Result / Hasil pemeriksaan"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('layout_tata_ruang_result', $pmShelter->layout_tata_ruang_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="layout_tata_ruang_status"
                                                        value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('layout_tata_ruang_status', $pmShelter->layout_tata_ruang_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="layout_tata_ruang_status"
                                                        value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('layout_tata_ruang_status', $pmShelter->layout_tata_ruang_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="layout_tata_ruang_photos_container"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kontrol Keamanan -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">b. Kontrol
                                        Keamanan</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> Aman, dan Termonitor
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="kontrol_keamanan_result"
                                                placeholder="Result / Hasil pemeriksaan"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('kontrol_keamanan_result', $pmShelter->kontrol_keamanan_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="kontrol_keamanan_status"
                                                        value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('kontrol_keamanan_status', $pmShelter->kontrol_keamanan_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="kontrol_keamanan_status"
                                                        value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('kontrol_keamanan_status', $pmShelter->kontrol_keamanan_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="kontrol_keamanan_photos_container"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Aksesibilitas -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">c.
                                        Aksesibilitas</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> Alur pergerakan orang mudah dan tidak
                                        membahayakan, kemudahan akses ke perangkat
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="aksesibilitas_result"
                                                placeholder="Result / Hasil pemeriksaan"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('aksesibilitas_result', $pmShelter->aksesibilitas_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="aksesibilitas_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('aksesibilitas_status', $pmShelter->aksesibilitas_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="aksesibilitas_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('aksesibilitas_status', $pmShelter->aksesibilitas_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="aksesibilitas_photos_container"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Aspek Teknis -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">d. Aspek Teknis</label>
                                    <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                        <strong>Operational Standard:</strong> Tersedia power, penangkal petir,
                                        grounding, pencahayaan, AC, Fire Protection, dan Termonitor
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="aspek_teknis_result"
                                                placeholder="Result / Hasil pemeriksaan"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('aspek_teknis_result', $pmShelter->aspek_teknis_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="aspek_teknis_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('aspek_teknis_status', $pmShelter->aspek_teknis_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="aspek_teknis_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('aspek_teknis_status', $pmShelter->aspek_teknis_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="aspek_teknis_photos_container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Room Temperature Section -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                3. Suhu Ruangan
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <!-- Room Temp 1 -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">a. Suhu Ruangan 1</label>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="room_temp_1_result"
                                                placeholder="Result / Hasil pemeriksaan (contoh: 25°C)"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('room_temp_1_result', $pmShelter->room_temp_1_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="room_temp_1_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('room_temp_1_status', $pmShelter->room_temp_1_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="room_temp_1_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('room_temp_1_status', $pmShelter->room_temp_1_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="room_temp_1_photos_container"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Room Temp 2 -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">b. Suhu Ruangan 2</label>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="room_temp_2_result"
                                                placeholder="Result / Hasil pemeriksaan (contoh: 26°C)"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('room_temp_2_result', $pmShelter->room_temp_2_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="room_temp_2_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('room_temp_2_status', $pmShelter->room_temp_2_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="room_temp_2_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('room_temp_2_status', $pmShelter->room_temp_2_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="room_temp_2_photos_container"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Room Temp 3 -->
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">c. Suhu Ruangan 3</label>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="room_temp_3_result"
                                                placeholder="Result / Hasil pemeriksaan (contoh: 24°C)"
                                                class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                value="{{ old('room_temp_3_result', $pmShelter->room_temp_3_result) }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="room_temp_3_status" value="OK"
                                                        class="form-radio text-green-600 focus:ring-green-500"
                                                        {{ old('room_temp_3_status', $pmShelter->room_temp_3_status) == 'OK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="room_temp_3_status" value="NOK"
                                                        class="form-radio text-red-600 focus:ring-red-500"
                                                        {{ old('room_temp_3_status', $pmShelter->room_temp_3_status) == 'NOK' ? 'checked' : '' }}
                                                        required>
                                                    <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Foto (Opsional)
                                            </label>
                                            <div id="room_temp_3_photos_container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan / Additional
                                Informations</label>
                            <textarea name="notes" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                placeholder="Tambahkan catatan atau informasi tambahan di sini...">{{ old('notes', $pmShelter->notes) }}</textarea>
                        </div>

                        <!-- Executors -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Pelaksana</h3>
                            <div id="executors-container">
                                <div class="mb-4">
                                    <button type="button" onclick="addExecutorField()"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm sm:text-base w-full sm:w-auto">
                                        <i data-lucide="user-plus" class="w-4 h-4 inline mr-1"></i> Tambah Pelaksana
                                    </button>
                                </div>
                                <div id="executor-fields" class="space-y-3">
                                    @if ($pmShelter->executors && count($pmShelter->executors) > 0)
                                        @foreach ($pmShelter->executors as $index => $executor)
                                            <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                                <div class="flex justify-between items-center mb-3">
                                                    <h4 class="font-medium text-gray-700 text-sm sm:text-base">
                                                        Pelaksana {{ $index + 1 }}</h4>
                                                    <button type="button"
                                                        onclick="this.closest('.border').remove(); updateExecutorNumbers();"
                                                        class="text-red-500 hover:text-red-700">
                                                        <i data-lucide="x" class="w-5 h-5"></i>
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-1 gap-3">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            Nama <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="text"
                                                            name="executors[{{ $index }}][name]"
                                                            value="{{ $executor['name'] ?? '' }}"
                                                            class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                            placeholder="Nama pelaksana" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Mitra</label>
                                                        <input type="text"
                                                            name="executors[{{ $index }}][mitra]"
                                                            value="{{ $executor['mitra'] ?? '' }}"
                                                            class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                            placeholder="Nama mitra">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Mengetahui (Verifikator & Head of Sub Dept) -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Mengetahui</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Verifikator -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <h4 class="font-medium text-gray-700 mb-3 text-sm">Verifikator</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Nama <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="verifikator[name]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                                value="{{ old('verifikator.name', $pmShelter->verifikator['name'] ?? '') }}"
                                                placeholder="Nama verifikator" required>
                                            @error('verifikator.name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                            <input type="text" name="verifikator[nik]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                                value="{{ old('verifikator.nik', $pmShelter->verifikator['nik'] ?? '') }}"
                                                placeholder="NIK verifikator">
                                            @error('verifikator.nik')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Head of Sub Department -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <h4 class="font-medium text-gray-700 mb-3 text-sm">Head of Sub Department</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Nama <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="head_of_sub_dept[name]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                                value="{{ old('head_of_sub_dept.name', $pmShelter->head_of_sub_dept['name'] ?? '') }}"
                                                placeholder="Nama head of sub dept" required>
                                            @error('head_of_sub_dept.name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                            <input type="text" name="head_of_sub_dept[nik]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                                value="{{ old('head_of_sub_dept.nik', $pmShelter->head_of_sub_dept['nik'] ?? '') }}"
                                                placeholder="NIK head of sub dept">
                                            @error('head_of_sub_dept.nik')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                Update
                            </button>
                            <a href="{{ route('pm-shelter.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 transition ease-in-out duration-150">
                                <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('js/photo-manager.js') }}"></script>
        <script>
            let executorIndex = {{ $pmShelter->executors ? count($pmShelter->executors) : 0 }};

            function addExecutorField() {
                const container = document.getElementById('executor-fields');
                const div = document.createElement('div');
                div.className = 'border rounded-lg p-3 sm:p-4 bg-gray-50';
                div.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-700 text-sm sm:text-base">Pelaksana ${executorIndex + 1}</h4>
                    <button type="button" onclick="this.closest('.border').remove(); updateExecutorNumbers();" 
                            class="text-red-500 hover:text-red-700">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="executors[${executorIndex}][name]" 
                               class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base" 
                               placeholder="Nama pelaksana" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mitra</label>
                        <input type="text" name="executors[${executorIndex}][mitra]" 
                               class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base" 
                               placeholder="Nama mitra">
                    </div>
                </div>
            `;
                container.appendChild(div);
                executorIndex++;
                lucide.createIcons();
            }

            function updateExecutorNumbers() {
                const executorDivs = document.querySelectorAll('#executor-fields > .border');
                executorDivs.forEach((div, index) => {
                    const header = div.querySelector('h4');
                    if (header) {
                        header.textContent = `Pelaksana ${index + 1}`;
                    }
                });
            }

            // Get existing photos filtered by field
            const allPhotos = @json($pmShelter->photos ?? []);
            
            // Initialize photo managers dengan existing photos yang sudah di-filter
            photoManagers['kondisi_ruangan_photos'] = new PhotoManager(
                'kondisi_ruangan_photos_container',
                'kondisi_ruangan_photos',
                allPhotos.filter(p => p.field === 'kondisi_ruangan_photos')
            );
            photoManagers['kondisi_kunci_photos'] = new PhotoManager(
                'kondisi_kunci_photos_container',
                'kondisi_kunci_photos',
                allPhotos.filter(p => p.field === 'kondisi_kunci_photos')
            );
            photoManagers['layout_tata_ruang_photos'] = new PhotoManager(
                'layout_tata_ruang_photos_container',
                'layout_tata_ruang_photos',
                allPhotos.filter(p => p.field === 'layout_tata_ruang_photos')
            );
            photoManagers['kontrol_keamanan_photos'] = new PhotoManager(
                'kontrol_keamanan_photos_container',
                'kontrol_keamanan_photos',
                allPhotos.filter(p => p.field === 'kontrol_keamanan_photos')
            );
            photoManagers['aksesibilitas_photos'] = new PhotoManager(
                'aksesibilitas_photos_container',
                'aksesibilitas_photos',
                allPhotos.filter(p => p.field === 'aksesibilitas_photos')
            );
            photoManagers['aspek_teknis_photos'] = new PhotoManager(
                'aspek_teknis_photos_container',
                'aspek_teknis_photos',
                allPhotos.filter(p => p.field === 'aspek_teknis_photos')
            );
            photoManagers['room_temp_1_photos'] = new PhotoManager(
                'room_temp_1_photos_container',
                'room_temp_1_photos',
                allPhotos.filter(p => p.field === 'room_temp_1_photos')
            );
            photoManagers['room_temp_2_photos'] = new PhotoManager(
                'room_temp_2_photos_container',
                'room_temp_2_photos',
                allPhotos.filter(p => p.field === 'room_temp_2_photos')
            );
            photoManagers['room_temp_3_photos'] = new PhotoManager(
                'room_temp_3_photos_container',
                'room_temp_3_photos',
                allPhotos.filter(p => p.field === 'room_temp_3_photos')
            );

            // Initialize Lucide icons
            lucide.createIcons();
        </script>
    @endpush
</x-app-layout>
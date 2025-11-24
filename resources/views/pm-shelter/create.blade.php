<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah PM Ruang Shelter') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form action="{{ route('pm-shelter.store') }}" method="POST" id="pmForm"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Location & Equipment Info -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Informasi Lokasi & Perangkat
                            </h3>


                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <!-- Dropdown Lokasi Central -->
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
                                                {{ old('central_id') == $central->id ? 'selected' : '' }}>
                                                {{ $central->nama }} - {{ $central->area }} ({{ $central->id_sentral }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('central_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('date') }}" required>
                                    @error('date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Waktu -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="time"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('time') }}" required>
                                    @error('time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Brand/Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand / Type</label>
                                    <input type="text" name="brand_type"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('brand_type') }}" placeholder="Masukkan brand/type">
                                    @error('brand_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Reg. Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number</label>
                                    <input type="text" name="reg_number"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('reg_number') }}" placeholder="Masukkan registration number">
                                    @error('reg_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Serial Number -->
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">S/N</label>
                                    <input type="text" name="serial_number"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                        value="{{ old('serial_number') }}" placeholder="Masukkan serial number">
                                    @error('serial_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                                    value="{{ old('kondisi_ruangan_result') }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="kondisi_ruangan_status"
                                                            value="OK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('kondisi_ruangan_status') == 'OK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                    </label>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="kondisi_ruangan_status"
                                                            value="NOK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('kondisi_ruangan_status') == 'NOK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                    </label>
                                                </div>
                                                @error('kondisi_ruangan_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
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
                                                    value="{{ old('kondisi_kunci_result') }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="kondisi_kunci_status"
                                                            value="OK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('kondisi_kunci_status') == 'OK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                    </label>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="kondisi_kunci_status"
                                                            value="NOK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('kondisi_kunci_status') == 'NOK' ? 'checked' : '' }}
                                                            required>
                                                        <span
                                                            class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                    </label>
                                                </div>
                                                @error('kondisi_kunci_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
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
                                <h3
                                    class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
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
                                                    value="{{ old('layout_tata_ruang_result') }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="layout_tata_ruang_status"
                                                            value="OK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('layout_tata_ruang_status') == 'OK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                    </label>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="layout_tata_ruang_status"
                                                            value="NOK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('layout_tata_ruang_status') == 'NOK' ? 'checked' : '' }}
                                                            required>
                                                        <span
                                                            class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                    </label>
                                                </div>
                                                @error('layout_tata_ruang_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
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
                                                    value="{{ old('kontrol_keamanan_result') }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="kontrol_keamanan_status"
                                                            value="OK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('kontrol_keamanan_status') == 'OK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                    </label>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="kontrol_keamanan_status"
                                                            value="NOK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('kontrol_keamanan_status') == 'NOK' ? 'checked' : '' }}
                                                            required>
                                                        <span
                                                            class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                    </label>
                                                </div>
                                                @error('kontrol_keamanan_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
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
                                                    value="{{ old('aksesibilitas_result') }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="aksesibilitas_status"
                                                            value="OK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('aksesibilitas_status') == 'OK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                    </label>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="aksesibilitas_status"
                                                            value="NOK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('aksesibilitas_status') == 'NOK' ? 'checked' : '' }}
                                                            required>
                                                        <span
                                                            class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                    </label>
                                                </div>
                                                @error('aksesibilitas_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">d. Aspek
                                            Teknis</label>
                                        <div class="mb-3 p-2 bg-blue-50 rounded text-xs sm:text-sm text-gray-600">
                                            <strong>Operational Standard:</strong> Tersedia power, penangkal petir,
                                            grounding, pencahayaan, AC, Fire Protection, dan Termonitor
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <input type="text" name="aspek_teknis_result"
                                                    placeholder="Result / Hasil pemeriksaan"
                                                    class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                                                    value="{{ old('aspek_teknis_result') }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="aspek_teknis_status"
                                                            value="OK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('aspek_teknis_status') == 'OK' ? 'checked' : '' }}
                                                            required>
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">OK</span>
                                                    </label>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="aspek_teknis_status"
                                                            value="NOK"
                                                            class="form-radio text-blue-600 focus:ring-blue-500"
                                                            {{ old('aspek_teknis_status') == 'NOK' ? 'checked' : '' }}
                                                            required>
                                                        <span
                                                            class="ml-2 text-sm sm:text-base text-gray-700">NOK</span>
                                                    </label>
                                                </div>
                                                @error('aspek_teknis_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
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

                            <!-- Notes -->
                            <div class="mb-6 sm:mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan / Additional
                                    Informations</label>
                                <textarea name="notes" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                    placeholder="Tambahkan catatan atau informasi tambahan di sini...">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Executors -->
                            <div class="mb-6 sm:mb-8">
                                <h3
                                    class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                    Pelaksana</h3>
                                <div id="executors-container">
                                    <div class="mb-4">
                                        <button type="button" onclick="addExecutorField()"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm sm:text-base w-full sm:w-auto">
                                            <i data-lucide="user-plus" class="w-4 h-4 inline mr-1"></i> Tambah
                                            Pelaksana
                                        </button>
                                    </div>
                                    <div id="executor-fields" class="space-y-3"></div>
                                </div>
                            </div>

                            <!-- Approver -->
                            <div class="mb-6 sm:mb-8">
                                <h3
                                    class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                    Mengetahui</h3>
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Nama <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="approvers[0][name]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                                value="{{ old('approvers.0.name') }}"
                                                placeholder="Nama yang mengetahui" required>
                                            @error('approvers.0.name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                                            <input type="text" name="approvers[0][nik]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                                value="{{ old('approvers.0.nik') }}" placeholder="ID Approval">
                                            @error('approvers.0.nik')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                    Simpan
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
            let executorIndex = 0;

            // ========== AUTO-SAVE FUNCTIONALITY ==========
            let dbInstance = null;
            const DB_NAME = 'PMShelterFormDB';
            const STORE_NAME = 'formDrafts';
            const STORAGE_KEY = 'pm_shelter_form_draft';
            const AUTO_DELETE_MINUTES = 5;

            // Encryption functions
            function encryptData(data) {
                try {
                    const str = JSON.stringify(data);
                    return btoa(unescape(encodeURIComponent(str)));
                } catch (e) {
                    console.error('Encryption error:', e);
                    return null;
                }
            }

            function decryptData(encryptedData) {
                try {
                    const str = decodeURIComponent(escape(atob(encryptedData)));
                    return JSON.parse(str);
                } catch (e) {
                    console.error('Decryption error:', e);
                    return null;
                }
            }

            // Initialize IndexedDB
            function initDB() {
                return new Promise((resolve, reject) => {
                    if (dbInstance) {
                        resolve(dbInstance);
                        return;
                    }

                    const request = indexedDB.open(DB_NAME, 1);
                    request.onerror = () => reject(request.error);
                    request.onsuccess = () => {
                        dbInstance = request.result;
                        resolve(dbInstance);
                    };

                    request.onupgradeneeded = (event) => {
                        const db = event.target.result;
                        if (!db.objectStoreNames.contains(STORE_NAME)) {
                            db.createObjectStore(STORE_NAME, { keyPath: 'id' });
                        }
                    };
                });
            }

            // Save to IndexedDB
            async function saveToIndexedDB(data) {
                try {
                    const db = await initDB();
                    const encryptedData = encryptData(data);

                    if (!encryptedData) {
                        console.error('Failed to encrypt data');
                        return;
                    }

                    const transaction = db.transaction([STORE_NAME], 'readwrite');
                    const store = transaction.objectStore(STORE_NAME);

                    store.put({
                        id: STORAGE_KEY,
                        data: encryptedData,
                        timestamp: new Date().toISOString()
                    });
                } catch (error) {
                    console.error('Error saving to IndexedDB:', error);
                }
            }

            // Get from IndexedDB
            async function getFromIndexedDB() {
                try {
                    const db = await initDB();
                    const transaction = db.transaction([STORE_NAME], 'readonly');
                    const store = transaction.objectStore(STORE_NAME);

                    return new Promise((resolve, reject) => {
                        const request = store.get(STORAGE_KEY);

                        request.onsuccess = () => {
                            if (request.result && request.result.data) {
                                const decrypted = decryptData(request.result.data);
                                resolve(decrypted);
                            } else {
                                resolve(null);
                            }
                        };

                        request.onerror = () => reject(request.error);
                    });
                } catch (error) {
                    console.error('Error getting from IndexedDB:', error);
                    return null;
                }
            }

            // Delete from IndexedDB
            async function deleteFromIndexedDB() {
                try {
                    const db = await initDB();
                    const transaction = db.transaction([STORE_NAME], 'readwrite');
                    const store = transaction.objectStore(STORE_NAME);
                    store.delete(STORAGE_KEY);
                } catch (error) {
                    console.error('Error deleting from IndexedDB:', error);
                }
            }

            // Save draft
            async function saveDraft() {
                const form = document.getElementById('pmForm');
                if (!form) return;

                const formData = {};

                const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');
                inputs.forEach(input => {
                    if (input.name && !input.name.startsWith('_') && !input.name.includes('photo')) {
                        if (input.type === 'checkbox') {
                            formData[input.name] = input.checked;
                        } else if (input.type === 'radio') {
                            if (input.checked) {
                                formData[input.name] = input.value;
                            }
                        } else {
                            formData[input.name] = input.value;
                        }
                    }
                });

                const images = [];
                if (typeof photoManagers !== 'undefined') {
                    for (const [fieldName, manager] of Object.entries(photoManagers)) {
                        if (manager && manager.photos) {
                            manager.photos.forEach(photo => {
                                images.push({
                                    category: fieldName,
                                    preview: photo.preview,
                                    metadata: photo.metadata || {}
                                });
                            });
                        }
                    }
                }

                const draftData = {
                    formFields: formData,
                    images: images,
                    timestamp: new Date().toISOString()
                };

                await saveToIndexedDB(draftData);
                console.log('PM Shelter draft saved');
            }

            // Trigger auto-save
            function triggerAutoSave() {
                saveDraft();
            }

            // Restore draft
            async function restoreDraft() {
                const savedData = await getFromIndexedDB();
                if (!savedData || !savedData.formFields) return;

                const form = document.getElementById('pmForm');
                if (!form) return;

                for (const [name, value] of Object.entries(savedData.formFields)) {
                    const input = form.querySelector(`[name="${name}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = value;
                        } else if (input.type === 'radio') {
                            const radio = form.querySelector(`[name="${name}"][value="${value}"]`);
                            if (radio) radio.checked = true;
                        } else {
                            input.value = value;
                        }
                    }
                }

                if (savedData.images && savedData.images.length > 0) {
                    savedData.images.forEach(img => {
                        const manager = photoManagers[img.category];
                        if (manager && img.preview) {
                            const file = dataURLtoFile(img.preview, `restored_${Date.now()}.jpg`);
                            manager.addPhoto(file, img.metadata || { taken_at: new Date().toISOString() });
                        }
                    });
                }

                document.querySelectorAll('.fixed.top-4.right-4').forEach(n => n.remove());
                console.log('PM Shelter draft restored');
            }

            // Delete draft
            async function deleteDraft() {
                await deleteFromIndexedDB();
                document.querySelectorAll('.fixed.top-4.right-4').forEach(n => n.remove());
                console.log('PM Shelter draft deleted');
            }

            // Helper function
            function dataURLtoFile(dataurl, filename) {
                const arr = dataurl.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                return new File([u8arr], filename, { type: mime });
            }

            // Initialize auto-save
            async function initAutoSave() {
                const savedData = await getFromIndexedDB();

                if (savedData && savedData.formFields) {
                    // Auto-restore langsung tanpa notifikasi
                    await restoreDraft();
                }

                const form = document.getElementById('pmForm');
                if (!form) return;

                let saveTimeout;
                const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');

                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        clearTimeout(saveTimeout);
                        saveTimeout = setTimeout(() => saveDraft(), 1000);
                    });
                });

                if (savedData && savedData.timestamp) {
                    const savedTime = new Date(savedData.timestamp);
                    const now = new Date();
                    const diffMinutes = (now - savedTime) / (1000 * 60);

                    if (diffMinutes >= AUTO_DELETE_MINUTES) {
                        await deleteFromIndexedDB();
                    } else {
                        const remainingMs = (AUTO_DELETE_MINUTES * 60 * 1000) - (now - savedTime);
                        setTimeout(() => deleteFromIndexedDB(), remainingMs);
                    }
                }

                form.addEventListener('submit', () => {
                    setTimeout(() => deleteFromIndexedDB(), 100);
                });
            }
            // ========== END AUTO-SAVE ==========


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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                        <input type="text" name="executors[${executorIndex}][department]"
                               class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                               placeholder="Nama departemen">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Departemen</label>
                        <input type="text" name="executors[${executorIndex}][sub_department]"
                               class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base"
                               placeholder="Nama sub departemen">
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

            // Add initial executor field
            addExecutorField();

            // Initialize photo managers untuk setiap field
            photoManagers['kondisi_ruangan_photos'] = new PhotoManager('kondisi_ruangan_photos_container',
                'kondisi_ruangan_photos');
            photoManagers['kondisi_kunci_photos'] = new PhotoManager('kondisi_kunci_photos_container', 'kondisi_kunci_photos');
            photoManagers['layout_tata_ruang_photos'] = new PhotoManager('layout_tata_ruang_photos_container',
                'layout_tata_ruang_photos');
            photoManagers['kontrol_keamanan_photos'] = new PhotoManager('kontrol_keamanan_photos_container',
                'kontrol_keamanan_photos');
            photoManagers['aksesibilitas_photos'] = new PhotoManager('aksesibilitas_photos_container', 'aksesibilitas_photos');
            photoManagers['aspek_teknis_photos'] = new PhotoManager('aspek_teknis_photos_container', 'aspek_teknis_photos');

            // Initialize auto-save
            initAutoSave();

            // Initialize Lucide icons
            lucide.createIcons();
        </script>
    @endpush
</x-app-layout>

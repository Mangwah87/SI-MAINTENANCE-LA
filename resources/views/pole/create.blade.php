<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Data Pole Maintenance
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form action="{{ route('pole.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Informasi Lokasi dan Perangkat -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700 border-b pb-2">
                                Informasi Lokasi & Waktu
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Lokasi Sentral <span class="text-red-500">*</span>
                                    </label>
                                    <select name="central_id" id="central_id" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        <option value="">-- Pilih Lokasi Sentral --</option>
                                        @foreach($centrals as $central)
                                            <option value="{{ $central->id }}"
                                                    {{ old('central_id') == $central->id ? 'selected' : '' }}>
                                                {{ $central->nama }} - {{ $central->area }} ({{ $central->id_sentral }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('central_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="date" required
                                        value="{{ old('date', date('Y-m-d')) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="time" required
                                        value="{{ old('time', date('H:i')) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                    @error('time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Type Pole <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type_pole" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        <option value="">-- Pilih Type Pole --</option>
                                        <option value="SST" {{ old('type_pole') == 'SST' ? 'selected' : '' }}>SST</option>
                                        <option value="Pole" {{ old('type_pole') == 'Pole' ? 'selected' : '' }}>Pole</option>
                                        <option value="Tripole" {{ old('type_pole') == 'Tripole' ? 'selected' : '' }}>Tripole</option>
                                        <option value="Triangle" {{ old('type_pole') == 'Triangle' ? 'selected' : '' }}>Triangle</option>
                                        <option value="Triangle Wired" {{ old('type_pole') == 'Triangle Wired' ? 'selected' : '' }}>Triangle Wired</option>
                                    </select>
                                    @error('type_pole') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Physical Check -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-white bg-yellow-400 px-3 py-2 rounded">
                                PHYSICAL CHECK
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                @php
                                    $physicalChecks = [
                                        ['foundation_condition', 'a. Foundation Condition'],
                                        ['pole_tower_foundation_flange', 'b. Pole/Tower Foundation Flange Base Plate Condition'],
                                        ['pole_tower_support_flange', 'c. Pole/Tower Support Flange Base Plate Condition'],
                                        ['flange_condition_connection', 'd. Flange Condition at Each Pole/Sling Connection Point'],
                                        ['pole_tower_condition', 'e. Pole / Tower Condition'],
                                        ['arm_antenna_condition', 'f. Arm Antenna Condition'],
                                        ['availability_basbar_ground', 'g. Availability BasBar Ground'],
                                        ['bonding_bar', 'h. Bonding Bar'],
                                    ];
                                @endphp
                                @foreach($physicalChecks as $check)
                                    <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $check[1] }}</label>

                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Result</label>
                                                <input type="text" name="{{ $check[0] }}"
                                                       value="{{ old($check[0]) }}"
                                                       placeholder="Masukkan hasil pemeriksaan"
                                                       class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base">
                                            </div>

                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                    Status
                                                </label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach(['OK', 'NOK'] as $status)
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" name="status_{{ $check[0] }}" value="{{ $status }}"
                                                                   {{ old('status_'.$check[0]) == $status ? 'checked' : '' }}
                                                                   class="form-radio text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- Image Upload Section --}}
                                            <div class="image-upload-section" data-field-name="physical_check_{{ $check[0] }}" data-category="pole">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
                                                <div class="flex gap-2 mb-2">
                                                    <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                    <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                                </div>
                                                <input type="file" class="file-input hidden" accept="image/*" multiple>
                                                <input type="hidden" name="physical_check_{{ $check[0] }}" value="[]">
                                                <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Performance Measurement -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-white bg-yellow-400 px-3 py-2 rounded">
                                PERFORMANCE MEASUREMENT
                            </h3>

                            <div class="space-y-3 sm:space-y-4">
                                <div class="border rounded-lg p-3 sm:p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">a. Inclination Measurement</label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Result</label>
                                            <input type="text" name="inclination_measurement"
                                                   value="{{ old('inclination_measurement') }}"
                                                   placeholder="Masukkan hasil pengukuran kemiringan"
                                                   class="w-full rounded-md border-gray-300 shadow-sm text-sm sm:text-base">
                                        </div>

                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">
                                                Status
                                            </label>
                                            <div class="flex flex-wrap gap-4">
                                                @foreach(['OK', 'NOK'] as $status)
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio" name="status_inclination_measurement" value="{{ $status }}"
                                                               {{ old('status_inclination_measurement') == $status ? 'checked' : '' }}
                                                               class="form-radio text-blue-600 focus:ring-blue-500">
                                                        <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $status }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Image Upload Section --}}
                                        <div class="image-upload-section" data-field-name="performance_inclination" data-category="pole">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-2">Foto (Opsional)</label>
                                            <div class="flex gap-2 mb-2">
                                                <button type="button" class="upload-local-btn px-3 py-1.5 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">Upload Gambar</button>
                                                <button type="button" class="camera-btn px-3 py-1.5 bg-green-500 text-white rounded text-xs hover:bg-green-600">Ambil Foto</button>
                                            </div>
                                            <input type="file" class="file-input hidden" accept="image/*" multiple>
                                            <input type="hidden" name="performance_inclination" value="[]">
                                            <div class="preview-container grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pelaksana -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-white bg-yellow-400 px-3 py-2 rounded">
                                DATA PELAKSANA
                            </h3>

                            <div class="space-y-4">
                                @for($i = 1; $i <= 4; $i++)
                                    <div class="border rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Executor {{ $i }}</label>

                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Nama</label>
                                                <input type="text" name="executor_{{ $i }}"
                                                       value="{{ old('executor_'.$i) }}"
                                                       placeholder="Nama executor (opsional)"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                            </div>

                                            <div>
                                                <label class="block text-xs text-gray-600 mb-1">Mitra/Internal</label>
                                                <select name="mitra_internal_{{ $i }}"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Mitra" {{ old('mitra_internal_'.$i) == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                                                    <option value="Internal" {{ old('mitra_internal_'.$i) == 'Internal' ? 'selected' : '' }}>Internal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                                <!-- Verifikator -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Verifikator</label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Nama</label>
                                            <input type="text" name="verifikator"
                                                   value="{{ old('verifikator') }}"
                                                   placeholder="Nama verifikator (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">NIK</label>
                                            <input type="text" name="verifikator_nik"
                                                   value="{{ old('verifikator_nik') }}"
                                                   placeholder="NIK verifikator (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                    </div>
                                </div>

                                <!-- Head of Sub Department -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Head of Sub Department</label>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Nama</label>
                                            <input type="text" name="head_of_sub_department"
                                                   value="{{ old('head_of_sub_department') }}"
                                                   placeholder="Nama Head of Sub Department (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">NIK</label>
                                            <input type="text" name="head_of_sub_department_nik"
                                                   value="{{ old('head_of_sub_department_nik') }}"
                                                   placeholder="NIK Head of Sub Department (opsional)"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan / Additional Information</label>
                            <textarea name="notes" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                      placeholder="Tambahkan catatan atau informasi tambahan di sini...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('pole.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center text-sm sm:text-base">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm sm:text-base">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Camera Modal --}}
    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Ambil Foto</h3>
                <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-4">
                <div id="videoSection" class="relative">
                    <video id="video" class="w-full rounded-lg" autoplay playsinline></video>
                </div>

                <div id="capturedImage" class="hidden relative">
                    <img id="capturedImg" class="w-full rounded-lg" alt="Captured">
                </div>

                <canvas id="canvas" class="hidden"></canvas>

                <div id="captureControls" class="flex gap-2 mt-4">
                    <button type="button" id="captureBtn" class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Ambil Foto
                    </button>
                    <button type="button" id="switchCameraBtn" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Putar Kamera
                    </button>
                </div>

                <div id="retakeControls" class="hidden flex gap-2 mt-4">
                    <button type="button" id="retakeBtn" class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Ulangi
                    </button>
                    <button type="button" id="usePhotoBtn" class="flex-1 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Gunakan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/poleform.js') }}"></script>
    @endpush
</x-app-layout>

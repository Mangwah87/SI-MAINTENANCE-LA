<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($maintenance) ? __('Edit Preventive Maintenance') : __('Tambah Preventive Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Terjadi kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ isset($maintenance) ? route('rectifier.update', $maintenance->id) : route('rectifier.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="maintenanceForm">
                        @csrf
                        @if(isset($maintenance))
                        @method('PUT')
                        @endif

                        <!-- Hidden field for deleted images -->
                        <input type="hidden" name="deleted_images" id="deleted_images" value="[]">

                        <!-- Hidden fields for camera photos -->
                        <input type="hidden" name="camera_photos_visual_check" id="camera_photos_visual_check" value="[]">
                        <input type="hidden" name="camera_photos_performance" id="camera_photos_performance" value="[]">
                        <input type="hidden" name="camera_photos_backup" id="camera_photos_backup" value="[]">
                        <input type="hidden" name="camera_photos_alarm" id="camera_photos_alarm" value="[]">
                        <input type="hidden" name="camera_photos_ac_voltage" id="camera_photos_ac_voltage" value="[]">
                        <input type="hidden" name="camera_photos_ac_current" id="camera_photos_ac_current" value="[]">
                        <input type="hidden" name="camera_photos_dc_current" id="camera_photos_dc_current" value="[]">
                        <input type="hidden" name="camera_photos_battery_temp" id="camera_photos_battery_temp" value="[]">
                        <input type="hidden" name="camera_photos_charging_voltage" id="camera_photos_charging_voltage" value="[]">
                        <input type="hidden" name="camera_photos_charging_current" id="camera_photos_charging_current" value="[]">
                        <input type="hidden" name="camera_photos_rectifier_test" id="camera_photos_rectifier_test" value="[]">
                        <input type="hidden" name="camera_photos_battery_voltage" id="camera_photos_battery_voltage" value="[]">

                        <!-- NEW: Hidden inputs untuk kategori baru -->
                        <input type="hidden" name="camera_photos_env_condition" id="camera_photos_env_condition" value="[]">
                        <input type="hidden" name="camera_photos_led_display" id="camera_photos_led_display" value="[]">
                        <input type="hidden" name="camera_photos_battery_connection" id="camera_photos_battery_connection" value="[]">
                        <input type="hidden" name="camera_photos_battery_voltage_m1" id="camera_photos_battery_voltage_m1" value="[]">
                        <input type="hidden" name="camera_photos_battery_voltage_m2" id="camera_photos_battery_voltage_m2" value="[]">

                        <!-- Header Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Dasar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Location Field -->
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
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date/Time <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" name="date_time" value="{{ old('date_time', isset($maintenance) ? $maintenance->date_time->format('Y-m-d\TH:i') : '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 " required>
                                    @error('date_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Reg Number</label>
                                    <input type="text" name="reg_number" value="{{ old('reg_number', $maintenance->reg_number ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none  ">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">S/N</label>
                                    <input type="text" name="sn" value="{{ old('sn', $maintenance->sn ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 ">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand/Type <span class="text-red-500">*</span></label>
                                    <input type="text" name="brand_type" value="{{ old('brand_type', $maintenance->brand_type ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 " required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Power Module <span class="text-red-500">*</span></label>
                                    <select name="power_module" id="power_module" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <option value="">Pilih Power Module</option>
                                        <option value="Single" {{ old('power_module', $maintenance->power_module ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Dual" {{ old('power_module', $maintenance->power_module ?? '') == 'Dual' ? 'selected' : '' }}>Dual</option>
                                        <option value="Three" {{ old('power_module', $maintenance->power_module ?? '') == 'Three' ? 'selected' : '' }}>Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 1. Visual Check -->
                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1. Visual Check</h3>

                            <div class="space-y-6">
                                <div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">a. Environment Condition</label>
                                            <input type="text" name="env_condition" value="{{ old('env_condition', $maintenance->env_condition ?? '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Clean, No dust">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                            <select name="status_env_condition" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="OK" {{ old('status_env_condition', $maintenance->status_env_condition ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                                <option value="NOK" {{ old('status_env_condition', $maintenance->status_env_condition ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    Foto Environment Condition
                                                </span>
                                            </label>
                                            <div id="camera-container-env-condition" class="space-y-3 mb-3"></div>
                                            <button type="button" onclick="addCameraSlot('env_condition')"
                                                class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                                + Tambah Foto
                                            </button>
                                        </div>

                                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                    Upload Gambar (Optional)
                                                </span>
                                            </label>
                                            <input type="file" name="images_env_condition[]" multiple accept="image/jpeg,image/jpg,image/png"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                                onchange="validateImageFiles(this)">
                                            <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                            @if(isset($maintenance))
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                @foreach($maintenance->getImagesByCategory('env_condition') as $image)
                                                <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                    <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                    <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">b. LED/display</label>
                                            <input type="text" name="led_display" value="{{ old('led_display', $maintenance->led_display ?? '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Normal">
                                        </div>
                                        <div>
                                            <select name="status_led_display" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="OK" {{ old('status_led_display', $maintenance->status_led_display ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                                <option value="NOK" {{ old('status_led_display', $maintenance->status_led_display ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    Foto LED/Display
                                                </span>
                                            </label>
                                            <div id="camera-container-led-display" class="space-y-3 mb-3"></div>
                                            <button type="button" onclick="addCameraSlot('led_display')"
                                                class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                                + Tambah Foto
                                            </button>
                                        </div>

                                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                    Upload Gambar (Optional)
                                                </span>
                                            </label>
                                            <input type="file" name="images_led_display[]" multiple accept="image/jpeg,image/jpg,image/png"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                                onchange="validateImageFiles(this)">
                                            <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                            @if(isset($maintenance))
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                @foreach($maintenance->getImagesByCategory('led_display') as $image)
                                                <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                    <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                    <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                            </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">c. Battery Connection</label>
                                            <input type="text" name="battery_connection" value="{{ old('battery_connection', $maintenance->battery_connection ?? '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none "
                                                placeholder="Tighten, No Corrosion">
                                        </div>
                                        <div>
                                            <select name="status_battery_connection" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="OK" {{ old('status_battery_connection', $maintenance->status_battery_connection ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                                <option value="NOK" {{ old('status_battery_connection', $maintenance->status_battery_connection ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    Foto Battery Connection
                                                </span>
                                            </label>
                                            <div id="camera-container-battery-connection" class="space-y-3 mb-3"></div>
                                            <button type="button" onclick="addCameraSlot('battery_connection')"
                                                class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                                + Tambah Foto
                                            </button>
                                        </div>

                                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                    Upload Gambar (Optional)
                                                </span>
                                            </label>
                                            <input type="file" name="images_battery_connection[]" multiple accept="image/jpeg,image/jpg,image/png"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                                onchange="validateImageFiles(this)">
                                            <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                            @if(isset($maintenance))
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                @foreach($maintenance->getImagesByCategory('battery_connection') as $image)
                                                <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                    <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                    <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Performance and Capacity Check -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">2. Performance and Capacity Check</h3>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">a. AC Input Voltage (180-240 VAC)</label>
                                        <input type="number" step="0.01" name="ac_input_voltage" value="{{ old('ac_input_voltage', $maintenance->ac_input_voltage ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="220.00">
                                    </div>
                                    <div>
                                        <select name="status_ac_input_voltage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_ac_input_voltage', $maintenance->status_ac_input_voltage ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_ac_input_voltage', $maintenance->status_ac_input_voltage ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                 <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto AC Input Voltage
                                            </span>
                                        </label>
                                        <div id="camera-container-ac-voltage" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('ac_voltage')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_ac_voltage[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('ac_voltage') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">b. AC Current Input (A)</label>
                                        <input type="number" step="0.01" name="ac_current_input"
                                            value="{{ old('ac_current_input', $maintenance->ac_current_input ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Enter AC Current">
                                        <p class="text-xs text-gray-500 mt-1">
                                            Standard: ≤ 5.5 A (Single) | ≤ 11 A (Dual) | ≤ 16.5 A (Three)
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status_ac_current_input" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_ac_current_input', $maintenance->status_ac_current_input ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_ac_current_input', $maintenance->status_ac_current_input ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto AC Current Input
                                            </span>
                                        </label>
                                        <div id="camera-container-ac-current" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('ac_current')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_ac_current[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('ac_current') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">c. DC Current Output (A)</label>
                                        <input type="number" step="0.01" name="dc_current_output"
                                            value="{{ old('dc_current_output', $maintenance->dc_current_output ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Enter DC Current">
                                        <p class="text-xs text-gray-500 mt-1">
                                            Standard: ≤ 25 A (Single) | ≤ 50 A (Dual) | ≤ 75 A (Three)
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status_dc_current_output" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_dc_current_output', $maintenance->status_dc_current_output ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_dc_current_output', $maintenance->status_dc_current_output ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto DC Current Output
                                            </span>
                                        </label>
                                        <div id="camera-container-dc-current" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('dc_current')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_dc_current[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('dc_current') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">d. Battery Temperature (0-30 °C)</label>
                                        <input type="number" step="0.01" name="battery_temperature" value="{{ old('battery_temperature', $maintenance->battery_temperature ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="25.00">
                                    </div>
                                    <div>
                                        <select name="status_battery_temperature" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_battery_temperature', $maintenance->status_battery_temperature ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_battery_temperature', $maintenance->status_battery_temperature ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto Battery Temperature
                                            </span>
                                        </label>
                                        <div id="camera-container-battery-temp" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('battery_temp')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_battery_temp[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('battery_temp') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">e. Charging Voltage DC (48 ~ 55.3 VDC)</label>
                                        <input type="number" step="0.01" name="charging_voltage_dc" value="{{ old('charging_voltage_dc', $maintenance->charging_voltage_dc ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="54.00">
                                    </div>
                                    <div>
                                        <select name="status_charging_voltage_dc" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_charging_voltage_dc', $maintenance->status_charging_voltage_dc ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_charging_voltage_dc', $maintenance->status_charging_voltage_dc ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto Charging Voltage DC
                                            </span>
                                        </label>
                                        <div id="camera-container-charging-voltage" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('charging_voltage')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_charging_voltage[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('charging_voltage') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">f. Charging Current DC (Max 10% Battery Capacity)</label>
                                        <input type="number" step="0.01" name="charging_current_dc" value="{{ old('charging_current_dc', $maintenance->charging_current_dc ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="5.00">
                                    </div>
                                    <div>
                                        <select name="status_charging_current_dc" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_charging_current_dc', $maintenance->status_charging_current_dc ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_charging_current_dc', $maintenance->status_charging_current_dc ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto Charging Current DC
                                            </span>
                                        </label>
                                        <div id="camera-container-charging-current" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('charging_current')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_charging_current[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('charging_current') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Backup Tests -->
                        <div class="mb-8 ">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">3. Backup Tests</h3>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">a. Rectifier (turnoff test from main source to backup mode)</label>
                                        <input type="text" name="backup_test_rectifier" value="{{ old('backup_test_rectifier', $maintenance->backup_test_rectifier ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Rectifier Normal Operations">
                                    </div>
                                    <div>
                                        <select name="status_backup_test_rectifier" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_backup_test_rectifier', $maintenance->status_backup_test_rectifier ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_backup_test_rectifier', $maintenance->status_backup_test_rectifier ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto Rectifier Switching Test
                                            </span>
                                        </label>
                                        <div id="camera-container-rectifier-test" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('rectifier_test')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_rectifier_test[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($maintenance->getImagesByCategory('rectifier_test') as $image)
                                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-4 text-lg">b. Battery Voltage (on Backup Mode)</label>

                                    <div class="mb-6 p-4  rounded-lg ">
                                        <h4 class="font-semibold text-gray-800 mb-3">Measurement I</h4>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Voltage Reading (Min 48 VDC)</label>
                                                <input type="number" step="0.01" name="backup_test_voltage_measurement1"
                                                    value="{{ old('backup_test_voltage_measurement1', $maintenance->backup_test_voltage_measurement1 ?? '') }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    placeholder="48.00">
                                            </div>
                                            <select name="status_backup_test_voltage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_charging_current_dc', $maintenance->status_charging_current_dc ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_charging_current_dc', $maintenance->status_charging_current_dc ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="border  rounded-lg p-4 bg-white">
                                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                                    <span class="inline-flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        Foto Measurement I
                                                    </span>
                                                </label>
                                                <div id="camera-container-battery-voltage-m1" class="space-y-3 mb-3"></div>
                                                <button type="button" onclick="addCameraSlot('battery_voltage_m1')"
                                                    class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                                    + Tambah Foto
                                                </button>
                                            </div>

                                            <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                                    <span class="inline-flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                        </svg>
                                                        Upload Gambar (Optional)
                                                    </span>
                                                </label>
                                                <input type="file" name="images_battery_voltage_m1[]" multiple accept="image/jpeg,image/jpg,image/png"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                                    onchange="validateImageFiles(this)">
                                                <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                                @if(isset($maintenance))
                                                <div class="mt-3 grid grid-cols-2 gap-2">
                                                    @foreach($maintenance->getImagesByCategory('battery_voltage_m1') as $image)
                                                    <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                        <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                        <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                            class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 p-4  rounded-lg ">
                                        <h4 class="font-semibold text-gray-800 mb-3">Measurement II (15 minutes later)</h4>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Voltage Reading (Min 42 VDC)</label>
                                                <input type="number" step="0.01" name="backup_test_voltage_measurement2"
                                                    value="{{ old('backup_test_voltage_measurement2', $maintenance->backup_test_voltage_measurement2 ?? '') }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    placeholder="42.00">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                                <select name="status_backup_test_voltage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="OK" {{ old('status_backup_test_voltage', $maintenance->status_backup_test_voltage ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                                    <option value="NOK" {{ old('status_backup_test_voltage', $maintenance->status_backup_test_voltage ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                                    <span class="inline-flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        Foto Measurement II
                                                    </span>
                                                </label>
                                                <div id="camera-container-battery-voltage-m2" class="space-y-3 mb-3"></div>
                                                <button type="button" onclick="addCameraSlot('battery_voltage_m2')"
                                                    class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                                    + Tambah Foto
                                                </button>
                                            </div>

                                            <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                                    <span class="inline-flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                        </svg>
                                                        Upload Gambar (Optional)
                                                    </span>
                                                </label>
                                                <input type="file" name="images_battery_voltage_m2[]" multiple accept="image/jpeg,image/jpg,image/png"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                                    onchange="validateImageFiles(this)">
                                                <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                                @if(isset($maintenance))
                                                <div class="mt-3 grid grid-cols-2 gap-2">
                                                    @foreach($maintenance->getImagesByCategory('battery_voltage_m2') as $image)
                                                    <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                        <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                        <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                            class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Power Alarm Monitoring Test -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">4. Power Alarm Monitoring Test</h3>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Measure the on-contact alarm monitor</label>
                                        <input type="text" name="power_alarm_test" value="{{ old('power_alarm_test', $maintenance->power_alarm_test ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Simulated Alarm Monitor fault conditions (Red Sign)">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status_power_alarm_test" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_power_alarm_test', $maintenance->status_power_alarm_test ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_power_alarm_test', $maintenance->status_power_alarm_test ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Camera & Upload Images for Power Alarm Test - SIDE BY SIDE -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Camera for Power Alarm Test -->
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Foto Power Alarm Test
                                            </span>
                                        </label>
                                        <div id="camera-container-alarm" class="space-y-3 mb-3"></div>
                                        <button type="button" onclick="addCameraSlot('alarm')"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                                            + Tambah Foto
                                        </button>
                                    </div>

                                    <!-- Upload Images for Power Alarm Test -->
                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Gambar (Optional)
                                            </span>
                                        </label>
                                        <input type="file" name="images_alarm[]" multiple accept="image/jpeg,image/jpg,image/png"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                            onchange="validateImageFiles(this)">
                                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

                                        @if(isset($maintenance))
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                @foreach($maintenance->getImagesByCategory('alarm') as $image)
                                                    <div class="relative group" data-image-path="{{ $image['path'] }}">
                                                        <img src="{{ Storage::url($image['path']) }}" class="w-full h-24 object-cover rounded border border-gray-200">
                                                        <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                                            class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Notes / Additional Information</h3>
                            <textarea name="notes" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter any additional notes or observations...">{{ old('notes', $maintenance->notes ?? '') }}</textarea>
                        </div>


<!-- Personnel Information -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personnel Information</h3>

    <!-- Executor 1 -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm">1</span>
            Pelaksana 1 (Executor 1) <span class="text-red-500">*</span>
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="executor_1" value="{{ old('executor_1', $maintenance->executor_1 ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama Pelaksana 1"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <input type="text" name="executor_1_department" value="{{ old('executor_1_department', $maintenance->executor_1_department ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Departemen Pelaksana 1">
            </div>
        </div>
    </div>

    <!-- Executor 2 -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm">2</span>
            Pelaksana 2 (Executor 2)
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="executor_2" value="{{ old('executor_2', $maintenance->executor_2 ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama Pelaksana 2 (Optional)">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <input type="text" name="executor_2_department" value="{{ old('executor_2_department', $maintenance->executor_2_department ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Departemen Pelaksana 2 (Optional)">
            </div>
        </div>
    </div>

    <!-- Executor 3 -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm">3</span>
            Pelaksana 3 (Executor 3)
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="executor_3" value="{{ old('executor_3', $maintenance->executor_3 ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama Pelaksana 3 (Optional)">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <input type="text" name="executor_3_department" value="{{ old('executor_3_department', $maintenance->executor_3_department ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Departemen Pelaksana 3 (Optional)">
            </div>
        </div>
    </div>

    <!-- Supervisor Information -->
    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
        <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            Supervisor (Mengetahui) <span class="text-red-500">*</span>
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Supervisor</label>
                <input type="text" name="supervisor" value="{{ old('supervisor', $maintenance->supervisor ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                    placeholder="Nama Supervisor"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ID Number / NIK</label>
                <input type="text" name="supervisor_id_number" value="{{ old('supervisor_id_number', $maintenance->supervisor_id_number ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                    placeholder="ID Number / NIK">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <input type="text" name="department" value="{{ old('department', $maintenance->department ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                    placeholder="Department Supervisor">
            </div>
        </div>
    </div>
</div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-6 border-t">
                            <a href="{{ route('rectifier.index') }}"
                                class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow-sm">
                                {{ isset($maintenance) ? 'Update Data' : 'Save Data' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dynamic field display based on power module selection
        document.addEventListener('DOMContentLoaded', function() {
            const powerModuleSelect = document.getElementById('power_module');

            function updateFieldsVisibility() {
                const selectedModule = powerModuleSelect.value;

                // Hide all dynamic fields
                document.getElementById('ac_single').style.display = 'none';
                document.getElementById('ac_dual').style.display = 'none';
                document.getElementById('ac_three').style.display = 'none';
                document.getElementById('dc_single').style.display = 'none';
                document.getElementById('dc_dual').style.display = 'none';
                document.getElementById('dc_three').style.display = 'none';

                // Show relevant fields
                if (selectedModule === 'Single') {
                    document.getElementById('ac_single').style.display = 'block';
                    document.getElementById('dc_single').style.display = 'block';
                } else if (selectedModule === 'Dual') {
                    document.getElementById('ac_dual').style.display = 'block';
                    document.getElementById('dc_dual').style.display = 'block';
                } else if (selectedModule === 'Three') {
                    document.getElementById('ac_three').style.display = 'block';
                    document.getElementById('dc_three').style.display = 'block';
                }
            }

            powerModuleSelect.addEventListener('change', updateFieldsVisibility);
            updateFieldsVisibility();
        });

        // FUNGSI VALIDASI GAMBAR - TAMBAHAN BARU
        function validateImageFiles(input) {
            const files = input.files;
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const allowedExtensions = ['jpg', 'jpeg', 'png'];
            let invalidFiles = [];
            let oversizedFiles = [];

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                // Check file type
                if (!allowedTypes.includes(file.type) || !allowedExtensions.includes(fileExtension)) {
                    invalidFiles.push(file.name);
                }

                // Check file size
                if (file.size > maxSize) {
                    oversizedFiles.push(file.name);
                }
            }

            // Show alerts if there are invalid files
            if (invalidFiles.length > 0) {
                alert('❌ Format file tidak valid!\n\nFile yang ditolak:\n' + invalidFiles.join('\n') + '\n\nHanya file JPG, JPEG, dan PNG yang diperbolehkan.');
                input.value = ''; // Clear the input
                return false;
            }

            if (oversizedFiles.length > 0) {
                alert('❌ Ukuran file terlalu besar!\n\nFile yang melebihi 5MB:\n' + oversizedFiles.join('\n') + '\n\nMaksimal ukuran file adalah 5MB.');
                input.value = ''; // Clear the input
                return false;
            }

            return true;
        }

        // Handle image deletion
        let deletedImages = [];

        function deleteImage(button, imagePath) {
            if (confirm('Are you sure you want to delete this image?')) {
                deletedImages.push(imagePath);
                document.getElementById('deleted_images').value = JSON.stringify(deletedImages);
                button.closest('[data-image-path]').remove();
            }
        }

        // Camera functionality - Fixed Version
        let cameraStreams = {};
        let cameraCounter = {
            visual_check: 0,
            performance: 0,
            backup: 0,
            alarm: 0,
            ac_voltage: 0,
            ac_current: 0,
            dc_current: 0,
            battery_temp: 0,
            charging_voltage: 0,
            charging_current: 0,
            rectifier_test: 0,
            battery_voltage: 0,
            // TAMBAHKAN KATEGORI BARU
            env_condition: 0,
            led_display: 0,
            battery_connection: 0,
            battery_voltage_m1: 0,
            battery_voltage_m2: 0
        };

        let cameraPhotos = {
            visual_check: [],
            performance: [],
            backup: [],
            alarm: [],
            ac_voltage: [],
            ac_current: [],
            dc_current: [],
            battery_temp: [],
            charging_voltage: [],
            charging_current: [],
            rectifier_test: [],
            battery_voltage: [],
            // TAMBAHKAN KATEGORI BARU
            env_condition: [],
            led_display: [],
            battery_connection: [],
            battery_voltage_m1: [],
            battery_voltage_m2: []
        };

        // Get address from coordinates using reverse geocoding
        async function getAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();

                if (data.address) {
                    const parts = [];
                    if (data.address.road) parts.push(data.address.road);
                    if (data.address.suburb) parts.push(data.address.suburb);
                    if (data.address.city || data.address.city_district) parts.push(data.address.city || data.address.city_district);
                    if (data.address.state) parts.push(data.address.state);

                    return parts.join(', ') || data.display_name;
                }
                return 'Alamat tidak ditemukan';
            } catch (error) {
                console.error('Error getting address:', error);
                return 'Gagal mendapatkan alamat';
            }
        }

        function addCameraSlot(category) {
            const index = cameraCounter[category]++;
            const containerId = `camera-container-${category.replace(/_/g, '-')}`;
            const container = document.getElementById(containerId);

            if (!container) {
                console.error(`Container not found: ${containerId}`);
                alert(`Error: Container ${containerId} tidak ditemukan`);
                return;
            }

            const cameraSlot = document.createElement('div');
            cameraSlot.className = 'border border-gray-300 rounded-lg p-3 bg-white';
            cameraSlot.id = `camera-slot-${category}-${index}`;
            cameraSlot.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <span class="font-medium text-sm">Foto ${index + 1}</span>
            <button type="button" onclick="removeCameraSlot('${category}', ${index})" class="text-red-600 hover:text-red-800 text-sm">
                ✕ Hapus
            </button>
        </div>
        <div class="relative">
            <video id="video-${category}-${index}" class="w-full rounded border border-gray-300" autoplay playsinline style="display: none;"></video>
            <canvas id="canvas-${category}-${index}" class="hidden"></canvas>
            <img id="captured-${category}-${index}" class="w-full rounded border border-gray-300 hidden" />
        </div>
        <div class="mt-2 space-y-2">
            <button type="button" id="start-${category}-${index}" onclick="startCamera('${category}', ${index})"
                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm">
                📹 Buka Kamera
            </button>
            <button type="button" id="capture-${category}-${index}" onclick="capturePhoto('${category}', ${index})"
                class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm hidden">
                📸 Ambil Foto
            </button>
            <button type="button" id="retake-${category}-${index}" onclick="retakePhoto('${category}', ${index})"
                class="w-full px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition text-sm hidden">
                🔄 Ambil Ulang
            </button>
        </div>
        <div id="info-${category}-${index}" class="mt-2 text-xs text-gray-600"></div>
    `;

            container.appendChild(cameraSlot);
        }

        async function startCamera(category, index) {
            const video = document.getElementById(`video-${category}-${index}`);
            const startBtn = document.getElementById(`start-${category}-${index}`);
            const captureBtn = document.getElementById(`capture-${category}-${index}`);
            const infoDiv = document.getElementById(`info-${category}-${index}`);

            // Check if elements exist
            if (!video || !startBtn || !captureBtn || !infoDiv) {
                console.error('Required elements not found');
                alert('Error: Elemen tidak ditemukan');
                return;
            }

            // Check if browser supports getUserMedia
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                infoDiv.innerHTML = '<p class="text-red-600">❌ Browser tidak mendukung akses kamera</p>';
                alert('Browser Anda tidak mendukung akses kamera. Gunakan browser modern seperti Chrome, Firefox, atau Safari.');
                return;
            }

            try {
                infoDiv.innerHTML = '<p class="text-blue-600">⏳ Membuka kamera...</p>';

                // Stop any existing stream first
                if (cameraStreams[`${category}-${index}`]) {
                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                }

                let stream;

                // Try different constraint combinations
                const constraints = [
                    // Try 1: Environment camera with ideal resolution
                    {
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            },
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        }
                    },
                    // Try 2: Any camera with ideal resolution
                    {
                        video: {
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        }
                    },
                    // Try 3: Lower resolution
                    {
                        video: {
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }
                    },
                    // Try 4: Basic video only
                    {
                        video: true
                    }
                ];

                let lastError;
                for (let i = 0; i < constraints.length; i++) {
                    try {
                        console.log(`Trying constraint ${i + 1}...`);
                        stream = await navigator.mediaDevices.getUserMedia(constraints[i]);
                        console.log('Success with constraint', i + 1);
                        break;
                    } catch (e) {
                        console.log(`Constraint ${i + 1} failed:`, e);
                        lastError = e;
                        if (i === constraints.length - 1) {
                            throw lastError;
                        }
                    }
                }

                if (!stream) {
                    throw new Error('Failed to get camera stream');
                }

                video.srcObject = stream;
                cameraStreams[`${category}-${index}`] = stream;

                // Wait for video to be ready
                await new Promise((resolve, reject) => {
                    video.onloadedmetadata = () => {
                        video.play()
                            .then(() => {
                                console.log('Video playing');
                                resolve();
                            })
                            .catch(err => {
                                console.error('Play error:', err);
                                reject(err);
                            });
                    };

                    video.onerror = (err) => {
                        console.error('Video error:', err);
                        reject(err);
                    };

                    // Timeout after 10 seconds
                    setTimeout(() => reject(new Error('Video load timeout')), 10000);
                });

                // Show video and update UI
                video.style.display = 'block';
                startBtn.classList.add('hidden');
                captureBtn.classList.remove('hidden');
                infoDiv.innerHTML = '<p class="text-green-600">✓ Kamera siap</p>';

            } catch (error) {
                console.error('Error accessing camera:', error);
                let errorMessage = 'Tidak dapat mengakses kamera';

                if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                    errorMessage = 'Izin kamera ditolak. Pastikan Anda memberikan izin akses kamera di pengaturan browser.';
                } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                    errorMessage = 'Kamera tidak ditemukan. Pastikan perangkat Anda memiliki kamera.';
                } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                    errorMessage = 'Kamera sedang digunakan aplikasi lain. Tutup aplikasi lain yang menggunakan kamera.';
                } else if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                    errorMessage = 'Resolusi kamera tidak didukung. Mencoba dengan pengaturan lebih rendah...';
                } else if (error.name === 'TypeError') {
                    errorMessage = 'Browser tidak mendukung akses kamera. Pastikan menggunakan HTTPS atau localhost.';
                } else if (error.message) {
                    errorMessage = error.message;
                }

                infoDiv.innerHTML = `<p class="text-red-600">❌ ${errorMessage}</p>`;

                // Show detailed error in console
                console.error('Camera error details:', {
                    name: error.name,
                    message: error.message,
                    constraint: error.constraint
                });

                // Stop any partial stream
                if (cameraStreams[`${category}-${index}`]) {
                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                    delete cameraStreams[`${category}-${index}`];
                }

                // Show start button again
                startBtn.classList.remove('hidden');
                captureBtn.classList.add('hidden');
                video.style.display = 'none';
            }
        }

        async function capturePhoto(category, index) {
            const video = document.getElementById(`video-${category}-${index}`);
            const canvas = document.getElementById(`canvas-${category}-${index}`);
            const capturedImage = document.getElementById(`captured-${category}-${index}`);
            const captureBtn = document.getElementById(`capture-${category}-${index}`);
            const retakeBtn = document.getElementById(`retake-${category}-${index}`);
            const infoDiv = document.getElementById(`info-${category}-${index}`);

            if (!video || !canvas || !capturedImage) {
                alert('Error: Elemen tidak ditemukan');
                return;
            }

            if (navigator.geolocation) {
                infoDiv.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan lokasi GPS...</p>';

                navigator.geolocation.getCurrentPosition(
                    async function(position) {
                            try {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;
                                const timestamp = new Date();

                                infoDiv.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan alamat...</p>';

                                const address = await getAddress(lat, lng);

                                // Set canvas size to match video
                                canvas.width = video.videoWidth || 1280;
                                canvas.height = video.videoHeight || 720;
                                const ctx = canvas.getContext('2d');

                                // Draw video frame to canvas
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

                                // Determine timezone
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

                                // Add text overlay
                                const fontSize = Math.max(14, canvas.width * 0.018);
                                const padding = 15;
                                const lineHeight = fontSize * 1.8;
                                const startY = canvas.height - (lineHeight * 5.5);

                                // Add shadow for better readability
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

                                // Convert to image (HANYA JPEG/PNG)
                                const imageData = canvas.toDataURL('image/jpeg', 0.85);
                                capturedImage.src = imageData;
                                capturedImage.classList.remove('hidden');
                                video.style.display = 'none';

                                // Save photo data
                                cameraPhotos[category].push({
                                    index: index,
                                    image: imageData,
                                    lat: lat,
                                    lng: lng,
                                    timestamp: timestamp.toISOString(),
                                    address: address
                                });

                                // Update hidden input
                                const hiddenInput = document.getElementById(`camera_photos_${category}`);
                                if (hiddenInput) {
                                    hiddenInput.value = JSON.stringify(cameraPhotos[category]);
                                }

                                // Stop camera
                                if (cameraStreams[`${category}-${index}`]) {
                                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                                    delete cameraStreams[`${category}-${index}`];
                                }

                                // Update UI
                                captureBtn.classList.add('hidden');
                                retakeBtn.classList.remove('hidden');
                                infoDiv.innerHTML = `<p class="text-green-600 font-semibold">✓ Foto berhasil diambil!</p>`;

                            } catch (error) {
                                console.error('Error in capture process:', error);
                                infoDiv.innerHTML = '<p class="text-red-600">❌ Gagal memproses foto</p>';
                            }
                        },
                        function(error) {
                            console.error('Geolocation error:', error);
                            let errorMsg = 'Tidak dapat mengakses lokasi GPS';

                            if (error.code === error.PERMISSION_DENIED) {
                                errorMsg = 'Izin lokasi ditolak. Aktifkan GPS di pengaturan browser.';
                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                errorMsg = 'Lokasi tidak tersedia. Pastikan GPS aktif.';
                            } else if (error.code === error.TIMEOUT) {
                                errorMsg = 'Timeout mendapatkan lokasi. Coba lagi.';
                            }

                            infoDiv.innerHTML = `<p class="text-red-600">❌ ${errorMsg}</p>`;
                            alert(errorMsg);
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

        async function retakePhoto(category, index) {
            const video = document.getElementById(`video-${category}-${index}`);
            const capturedImage = document.getElementById(`captured-${category}-${index}`);
            const captureBtn = document.getElementById(`capture-${category}-${index}`);
            const retakeBtn = document.getElementById(`retake-${category}-${index}`);
            const infoDiv = document.getElementById(`info-${category}-${index}`);

            // Remove photo from array
            cameraPhotos[category] = cameraPhotos[category].filter(p => p.index !== index);
            const hiddenInput = document.getElementById(`camera_photos_${category}`);
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(cameraPhotos[category]);
            }

            // Update UI
            capturedImage.classList.add('hidden');
            video.style.display = 'none';
            retakeBtn.classList.add('hidden');

            // Restart camera
            await startCamera(category, index);
        }

        function removeCameraSlot(category, index) {
            if (confirm('Hapus slot kamera ini?')) {
                // Stop camera if active
                if (cameraStreams[`${category}-${index}`]) {
                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                    delete cameraStreams[`${category}-${index}`];
                }

                // Remove photo from array
                cameraPhotos[category] = cameraPhotos[category].filter(p => p.index !== index);
                const hiddenInput = document.getElementById(`camera_photos_${category}`);
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(cameraPhotos[category]);
                }

                // Remove DOM element
                const element = document.getElementById(`camera-slot-${category}-${index}`);
                if (element) {
                    element.remove();
                }
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            Object.values(cameraStreams).forEach(stream => {
                stream.getTracks().forEach(track => track.stop());
            });
        });

        // FUNGSI KOMPRESI GAMBAR - Mengompress gambar menjadi maksimal 1MB
        async function compressImage(file, maxSizeMB = 1) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        // Resize jika terlalu besar (maksimal 1920px untuk sisi terpanjang)
                        const maxDimension = 1920;
                        if (width > maxDimension || height > maxDimension) {
                            if (width > height) {
                                height = (height / width) * maxDimension;
                                width = maxDimension;
                            } else {
                                width = (width / height) * maxDimension;
                                height = maxDimension;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        // Mulai dengan kualitas 0.9, turunkan sampai ukuran < 1MB
                        let quality = 0.9;
                        const maxSizeBytes = maxSizeMB * 1024 * 1024;

                        function tryCompress() {
                            canvas.toBlob(function(blob) {
                                if (blob.size <= maxSizeBytes || quality <= 0.1) {
                                    // Konversi blob ke base64
                                    const reader = new FileReader();
                                    reader.onloadend = function() {
                                        resolve({
                                            base64: reader.result,
                                            size: blob.size,
                                            originalSize: file.size
                                        });
                                    };
                                    reader.readAsDataURL(blob);
                                } else {
                                    quality -= 0.1;
                                    tryCompress();
                                }
                            }, 'image/jpeg', quality);
                        }

                        tryCompress();
                    };
                    img.onerror = reject;
                    img.src = e.target.result;
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

       // FUNGSI VALIDASI DAN PREVIEW GAMBAR UPLOAD - UPDATED
async function validateImageFiles(input) {
    const files = input.files;
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const allowedExtensions = ['jpg', 'jpeg', 'png'];
    let invalidFiles = [];

    // Validasi format file
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedTypes.includes(file.type) || !allowedExtensions.includes(fileExtension)) {
            invalidFiles.push(file.name);
        }
    }

    if (invalidFiles.length > 0) {
        alert('❌ Format file tidak valid!\n\nFile yang ditolak:\n' + invalidFiles.join('\n') + '\n\nHanya file JPG, JPEG, dan PNG yang diperbolehkan.');
        input.value = '';
        return false;
    }

    // Hapus preview container lama jika ada
    const oldPreviewContainer = input.parentElement.querySelector('.upload-preview-container');
    if (oldPreviewContainer) {
        oldPreviewContainer.remove();
    }

    // Buat preview container
    const previewContainer = document.createElement('div');
    previewContainer.className = 'upload-preview-container mt-3 grid grid-cols-2 md:grid-cols-3 gap-2';

    // Status div untuk kompresi
    const statusDiv = document.createElement('div');
    statusDiv.className = 'col-span-full mt-2 p-2 bg-blue-50 border border-blue-200 rounded text-sm';
    statusDiv.innerHTML = '<p class="text-blue-600">⏳ Memproses gambar...</p>';

    input.parentElement.appendChild(previewContainer);
    input.parentElement.appendChild(statusDiv);

    // Kompresi dan preview semua gambar
    const compressedFiles = [];

    for (let i = 0; i < files.length; i++) {
        try {
            statusDiv.innerHTML = `<p class="text-blue-600">⏳ Memproses ${files[i].name} (${i + 1}/${files.length})...</p>`;

            const compressed = await compressImage(files[i]);
            compressedFiles.push({
                name: files[i].name,
                base64: compressed.base64,
                size: compressed.size,
                originalSize: compressed.originalSize
            });

            // Buat preview item
            const previewItem = document.createElement('div');
            previewItem.className = 'relative group';
            previewItem.innerHTML = `
                <img src="${compressed.base64}"
                     class="w-full h-24 object-cover rounded border border-gray-200 cursor-pointer hover:opacity-90 transition"
                     onclick="openImageModal(this.src, '${files[i].name}')"
                     title="Klik untuk melihat ukuran penuh">
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs p-1 rounded-b">
                    <p class="truncate" title="${files[i].name}">${files[i].name}</p>
                    <p>${formatFileSize(compressed.size)}</p>
                </div>
                <button type="button"
                        onclick="removeUploadPreview(this, ${i})"
                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                        title="Hapus gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            previewContainer.appendChild(previewItem);

        } catch (error) {
            console.error('Error processing image:', error);
            alert(`Gagal memproses ${files[i].name}`);
            statusDiv.remove();
            previewContainer.remove();
            return false;
        }
    }

    // Simpan data compressed ke hidden input
    const oldHiddenInput = input.parentElement.querySelector(`input[name="${input.name}_compressed"]`);
    if (oldHiddenInput) {
        oldHiddenInput.remove();
    }

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = input.name + '_compressed';
    hiddenInput.value = JSON.stringify(compressedFiles);
    input.parentElement.appendChild(hiddenInput);

    // Show success message
    const totalOriginal = compressedFiles.reduce((sum, f) => sum + f.originalSize, 0);
    const totalCompressed = compressedFiles.reduce((sum, f) => sum + f.size, 0);
    const savedPercent = ((1 - totalCompressed/totalOriginal) * 100).toFixed(1);

    statusDiv.innerHTML = `
        <p class="text-green-600 font-semibold">✓ ${compressedFiles.length} gambar berhasil diproses!</p>
        <p class="text-gray-600 text-xs mt-1">
            Ukuran asli: ${formatFileSize(totalOriginal)} → Setelah kompresi: ${formatFileSize(totalCompressed)}
            (hemat ${savedPercent}%)
        </p>
    `;

    setTimeout(() => {
        statusDiv.classList.add('opacity-0', 'transition-opacity', 'duration-500');
        setTimeout(() => statusDiv.remove(), 500);
    }, 4000);

    return true;
}

// Fungsi untuk format ukuran file
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

// Fungsi untuk hapus preview gambar upload
function removeUploadPreview(button, index) {
    if (confirm('Hapus gambar ini?')) {
        const previewItem = button.closest('.relative');
        const previewContainer = previewItem.parentElement;
        const uploadInput = previewContainer.closest('.border').querySelector('input[type="file"]');
        const hiddenInput = previewContainer.parentElement.querySelector(`input[name="${uploadInput.name}_compressed"]`);

        // Hapus dari preview
        previewItem.remove();

        // Update hidden input
        if (hiddenInput) {
            let compressedFiles = JSON.parse(hiddenInput.value);
            compressedFiles.splice(index, 1);
            hiddenInput.value = JSON.stringify(compressedFiles);

            // Update indices untuk tombol hapus yang tersisa
            const remainingItems = previewContainer.querySelectorAll('.relative');
            remainingItems.forEach((item, newIndex) => {
                const removeBtn = item.querySelector('button[onclick^="removeUploadPreview"]');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `removeUploadPreview(this, ${newIndex})`);
                }
            });
        }

        // Clear file input jika tidak ada gambar tersisa
        if (previewContainer.children.length === 0) {
            uploadInput.value = '';
            previewContainer.remove();
            if (hiddenInput) hiddenInput.remove();
        }
    }
}

// Fungsi untuk buka modal preview gambar ukuran penuh
function openImageModal(src, filename) {
    // Buat modal overlay
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4';
    modal.onclick = function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    };

    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-full">
            <button onclick="this.closest('.fixed').remove()"
                    class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl font-bold">
                ✕ Tutup
            </button>
            <img src="${src}"
                 class="max-w-full max-h-[80vh] object-contain rounded shadow-2xl"
                 alt="${filename}">
            <p class="text-white text-center mt-2 text-sm">${filename}</p>
        </div>
    `;

    document.body.appendChild(modal);

    // Tambahkan event listener untuk ESC key
    const closeOnEsc = function(e) {
        if (e.key === 'Escape') {
            modal.remove();
            document.removeEventListener('keydown', closeOnEsc);
        }
    };
    document.addEventListener('keydown', closeOnEsc);
}

// FUNGSI KOMPRESI GAMBAR (tetap sama)
async function compressImage(file, maxSizeMB = 1) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;

                // Resize jika terlalu besar (maksimal 1920px untuk sisi terpanjang)
                const maxDimension = 1920;
                if (width > maxDimension || height > maxDimension) {
                    if (width > height) {
                        height = (height / width) * maxDimension;
                        width = maxDimension;
                    } else {
                        width = (width / height) * maxDimension;
                        height = maxDimension;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Mulai dengan kualitas 0.9, turunkan sampai ukuran < 1MB
                let quality = 0.9;
                const maxSizeBytes = maxSizeMB * 1024 * 1024;

                function tryCompress() {
                    canvas.toBlob(function(blob) {
                        if (blob.size <= maxSizeBytes || quality <= 0.1) {
                            // Konversi blob ke base64
                            const reader = new FileReader();
                            reader.onloadend = function() {
                                resolve({
                                    base64: reader.result,
                                    size: blob.size,
                                    originalSize: file.size
                                });
                            };
                            reader.readAsDataURL(blob);
                        } else {
                            quality -= 0.1;
                            tryCompress();
                        }
                    }, 'image/jpeg', quality);
                }

                tryCompress();
            };
            img.onerror = reject;
            img.src = e.target.result;
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}
    </script>
</x-app-layout>

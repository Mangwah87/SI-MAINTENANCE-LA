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
                                                    <option value="{{ $central->id }}"
                                                        {{ old('location', isset($maintenance) ? $maintenance->location : '') == $central->id ? 'selected' : '' }}>
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

            <!-- TAMPILKAN EXISTING CAMERA PHOTOS UNTUK EDIT MODE (HANYA YANG PUNYA GPS) -->
            @if(isset($maintenance))
                @php
                    $existingCameraPhotos = $maintenance->getImagesByCategory('env_condition')->filter(function($img) {
                        return isset($img['lat']) && isset($img['lng']); // HANYA camera photos dengan GPS
                    });
                @endphp
                @if($existingCameraPhotos->count() > 0)
                    <div class="mb-3 space-y-2">
                        <p class="text-xs text-gray-600 font-semibold">Foto yang sudah ada:</p>
                        @foreach($existingCameraPhotos as $index => $image)
                            <div class="relative group border border-gray-300 rounded-lg p-2 bg-white">
                                <img src="{{ Storage::url($image['path']) }}"
                                     class="w-full rounded border border-gray-200 cursor-pointer hover:opacity-90 transition"
                                     onclick="openImageModal(this.src, 'Foto {{ $index + 1 }}')"
                                     title="Klik untuk melihat ukuran penuh">
                                <div class="mt-1 text-xs text-gray-600">
                                    <p>📍 Lat: {{ $image['lat'] }}, Lng: {{ $image['lng'] }}</p>
                                    @if(isset($image['address']))
                                        <p class="truncate" title="{{ $image['address'] }}">{{ $image['address'] }}</p>
                                    @endif
                                    @if(isset($image['timestamp']))
                                        <p>🕐 {{ date('d M Y H:i', strtotime($image['timestamp'])) }}</p>
                                    @endif
                                </div>
                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                                    title="Hapus foto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

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
                onchange="handleImageUpload(this)">
            <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

            <!-- TAMPILKAN EXISTING UPLOAD IMAGES UNTUK EDIT MODE (HANYA YANG TIDAK PUNYA GPS) -->
            @if(isset($maintenance))
                @php
                    $existingUploadImages = $maintenance->getImagesByCategory('env_condition')->filter(function($img) {
                        return !isset($img['lat']) && !isset($img['lng']); // HANYA upload images tanpa GPS
                    });
                @endphp
                @if($existingUploadImages->count() > 0)
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        @foreach($existingUploadImages as $image)
                        <div class="relative group" data-image-path="{{ $image['path'] }}">
                            <img src="{{ Storage::url($image['path']) }}"
                                 class="w-full h-24 object-cover rounded border border-gray-200 cursor-pointer hover:opacity-90 transition"
                                 onclick="openImageModal(this.src, '{{ basename($image['path']) }}')"
                                 title="Klik untuk melihat ukuran penuh">
                            <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                                title="Hapus gambar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

                                <!-- 2. LED Display -->
<div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">b. LED/display</label>
                                        <input type="text" name="led_display" value="{{ old('led_display', $maintenance->led_display ?? '') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Normal">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status_led_display" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_led_display', $maintenance->status_led_display ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_led_display', $maintenance->status_led_display ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
                                    </div>
                                </div>    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- FOTO DARI KAMERA (DENGAN GPS) -->
        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Foto LED/Display (Kamera dengan GPS)
                </span>
            </label>

            <!-- EXISTING CAMERA PHOTOS (HANYA YANG PUNYA GPS) -->
            @if(isset($maintenance))
                @php
                    $existingCameraPhotos = $maintenance->getImagesByCategory('led_display')->filter(function($img) {
                        return isset($img['lat']) && isset($img['lng']); // HANYA yang ada GPS
                    });
                @endphp
                @if($existingCameraPhotos->count() > 0)
                    <div class="mb-3 space-y-2">
                        <p class="text-xs text-gray-600 font-semibold">Foto yang sudah ada ({{ $existingCameraPhotos->count() }}):</p>
                        @foreach($existingCameraPhotos as $index => $image)
                            <div class="relative group border border-gray-300 rounded-lg p-2 bg-white">
                                <img src="{{ Storage::url($image['path']) }}"
                                    class="w-full rounded border border-gray-200 cursor-pointer hover:opacity-90 transition"
                                    onclick="openImageModal(this.src, 'Foto {{ $index + 1 }}')"
                                    title="Klik untuk melihat ukuran penuh">
                                <div class="mt-1 text-xs text-gray-600">
                                    <p>📍 Lat: {{ $image['lat'] }}, Lng: {{ $image['lng'] }}</p>
                                    @if(isset($image['address']))
                                        <p class="truncate" title="{{ $image['address'] }}">{{ $image['address'] }}</p>
                                    @endif
                                    @if(isset($image['timestamp']))
                                        <p>🕐 {{ date('d M Y H:i', strtotime($image['timestamp'])) }}</p>
                                    @endif
                                </div>
                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                                    title="Hapus foto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            <!-- NEW CAMERA SLOTS -->
            <div id="camera-container-led-display" class="space-y-3 mb-3"></div>
            <button type="button" onclick="addCameraSlot('led_display')"
                class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition text-sm font-medium">
                + Tambah Foto Kamera
            </button>
            <!-- <p class="text-xs text-gray-500 mt-2">
                <span class="inline-block mr-1">ℹ️</span>
                Foto akan otomatis menyimpan lokasi GPS
            </p> -->
        </div>

        <!-- UPLOAD GAMBAR (TANPA GPS) -->
        <div class="border border-gray-200 rounded-lg p-4 bg-white">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Upload Gambar dari File (Optional)
                </span>
            </label>
            <input type="file" name="images_led_display[]" multiple accept="image/jpeg,image/jpg,image/png"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                onchange="handleImageUpload(this)">
            <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG (Max: 5MB/file)</p>

            <!-- EXISTING UPLOAD IMAGES (HANYA YANG TIDAK PUNYA GPS) -->
            @if(isset($maintenance))
                @php
                    $existingUploadImages = $maintenance->getImagesByCategory('led_display')->filter(function($img) {
                        return !isset($img['lat']) && !isset($img['lng']); // HANYA yang TIDAK ada GPS
                    });
                @endphp
                @if($existingUploadImages->count() > 0)
                    <div class="mt-3">
                        <p class="text-xs text-gray-600 font-semibold mb-2">Gambar yang sudah ada ({{ $existingUploadImages->count() }}):</p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($existingUploadImages as $image)
                            <div class="relative group" data-image-path="{{ $image['path'] }}">
                                <img src="{{ Storage::url($image['path']) }}"
                                    class="w-full h-24 object-cover rounded border border-gray-200 cursor-pointer hover:opacity-90 transition"
                                    onclick="openImageModal(this.src, '{{ basename($image['path']) }}')"
                                    title="Klik untuk melihat ukuran penuh">
                                <button type="button" onclick="deleteImage(this, '{{ $image['path'] }}')"
                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                                    title="Hapus gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

                                <div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">c. Battery Connection</label>
                                            <input type="text" name="battery_connection" value="{{ old('battery_connection', $maintenance->battery_connection ?? '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Tighten, No Corrosion">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                                                onchange="handleImageUpload(this)">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                                            onchange="handleImageUpload(this)">
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
                                            onchange="handleImageUpload(this)">
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
                                            onchange="handleImageUpload(this)">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                                            onchange="handleImageUpload(this)">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                                            onchange="handleImageUpload(this)">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                                            onchange="handleImageUpload(this)">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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
                                            onchange="handleImageUpload(this)">
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
                                            <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                            <select name="status_backup_test_voltage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="OK" {{ old('status_backup_test_voltage', $maintenance->status_backup_test_voltage ?? 'OK') == 'OK' ? 'selected' : '' }}>OK</option>
                                            <option value="NOK" {{ old('status_backup_test_voltage', $maintenance->status_backup_test_voltage ?? '') == 'NOK' ? 'selected' : '' }}>NOK</option>
                                        </select>
</div>
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
                                                    onchange="handleImageUpload(this)">
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
                                                    onchange="handleImageUpload(this)">
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
                                            onchange="handleImageUpload(this)">
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

    <script src="{{ asset('js/rectifier.js') }}"></script>

    </script>
</x-app-layout>

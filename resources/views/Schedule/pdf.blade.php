<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Form Preventive Maintenance Instalasi Kabel dan Panel Distribusi') }}
            </h2>
            <a href="{{ route('instalasi-kabel.index') }}"
                class="inline-flex items-center px-3 sm:px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm sm:text-base font-semibold rounded-lg transition-colors duration-200 w-full sm:w-auto justify-center">
                <i data-lucide="arrow-left" class="h-4 w-4 sm:h-5 sm:w-5 mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                
                <form id="instalasiKabelForm" action="{{ route('instalasi-kabel.store') }}" method="POST">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Ada masalah dengan input Anda!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- START: DATA PERANGKAT (Sudah Dirapatkan) --}}
                    <h3 class="text-lg font-bold mb-1 border-b pb-0.5 text-gray-700">DATA PERANGKAT</h3>
                    
                    {{-- BARIS ATAS: 3 KOLOM --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-2"> 
                        
                        <div>
                            <label for="location" class="block font-medium text-xs text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1" required>
                        </div>
                        
                        <div>
                            <label for="date_time" class="block font-medium text-xs text-gray-700">Date / Time</label>
                            <input type="datetime-local" name="date_time" id="date_time" value="{{ old('date_time') }}" class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1" required>
                        </div>
                        
                        <div>
                            <label for="brand_type" class="block font-medium text-xs text-gray-700">Brand / Type</label>
                            <input type="text" name="brand_type" id="brand_type" value="{{ old('brand_type') }}" class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1" required>
                        </div>
                    </div>

                    {{-- BARIS BAWAH: 2 KOLOM --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4"> 

                        <div>
                            <label for="reg_number" class="block font-medium text-xs text-gray-700">Reg. Number</label>
                            <input type="text" name="reg_number" id="reg_number" value="{{ old('reg_number') }}" class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1" required>
                        </div>

                        <div>
                            <label for="serial_number" class="block font-medium text-xs text-gray-700">Serial Number</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1">
                        </div>
                    </div>
                    {{-- END: DATA PERANGKAT --}}

                    {{-- START: DETAIL ITEM PEMERIKSAAN (Sudah Dirapatkan dan Ada Header) --}}
<h3 class="text-lg font-bold mb-2 border-b pb-1 mt-4 text-gray-700">DETAIL ITEM PEMERIKSAAN</h3>

@php
    $global_index = 0;
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
        {{-- START: HEADER TABEL --}}
        <thead class="bg-gray-100">
            <tr>
                {{-- No. --}}
                <th scope="col" class="px-3 py-1.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-1/12">
                    No.
                </th>
                {{-- Descriptions --}}
                <th scope="col" class="px-3 py-1.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-4/12">
                    Descriptions
                </th>
                {{-- Result --}}
                <th scope="col" class="px-3 py-1.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-2/12">
                    Result
                </th>
                {{-- Operational Standard --}}
                <th scope="col" class="px-3 py-1.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-2/12">
                    Operational Standard
                </th>
                {{-- Status (OK/NOK) --}}
                <th scope="col" class="px-3 py-1.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-1/12">
                    Status
                </th>
                {{-- Photo (Biarkan kosong/ikon) --}}
                <th scope="col" class="px-3 py-1.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-1/12">
                    <i data-lucide="camera" class="h-4 w-4 mx-auto"></i>
                </th>
            </tr>
        </thead>
        {{-- END: HEADER TABEL --}}
        
        <tbody class="bg-white divide-y divide-gray-200">
            
            {{-- LOOPING LEVEL 1: KATEGORI UTAMA (1., 2., 3.) --}}
            @foreach($grouped_items as $group)
                
                {{-- BARIS KATEGORI UTAMA (LEVEL 1) --}}
                <tr class="bg-gray-200 font-semibold">
                    <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-900">{{ $group['category_no'] }}</td>
                    <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-900" colspan="5">{{ $group['category'] }}</td>
                </tr>

                {{-- CEK APAKAH ADA SUB-KATEGORI (LEVEL 2) --}}
                @if(!empty($group['sub_categories']))
                    
                    {{-- LOOPING LEVEL 2: SUB-KATEGORI (I., II., III.) --}}
                    @foreach($group['sub_categories'] as $sub_category)
                        
                        {{-- BARIS SUB-KATEGORI (LEVEL 2) --}}
                        <tr class="bg-gray-100 font-medium">
                            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-900"></td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-900" style="padding-left: 10px;" colspan="5">
                                {{ $sub_category['sub_category_no'] }} {{ $sub_category['sub_category'] }}
                            </td>
                        </tr>
                        
                        {{-- LOOPING LEVEL 3: ITEM DETAIL DI BAWAH SUB-KATEGORI (a., b., c.) --}}
                        @foreach($sub_category['items'] as $item)
                            <tr class="{{ $item['is_pm'] ? 'bg-yellow-50/50' : '' }}">
                                <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-700"></td>
                                <td class="px-3 py-1 text-sm text-gray-700" style="padding-left: 20px;">
                                    {{ $item['detail_no'] }} {{ $item['description'] }}
                                </td>
                                
                                {{-- Result Column (Input) --}}
                                <td class="px-3 py-1">
                                    <input type="text" name="detail[{{ $global_index }}][result]" id="result-input-{{ $global_index }}"
                                        value="{{ old("detail.{$global_index}.result") }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-0.5 result-input"
                                        placeholder="{{ $item['is_pm'] ? 'Nilai/Angka' : 'Deskripsi' }}"
                                        data-index="{{ $global_index }}"
                                        data-is-pm="{{ $item['is_pm'] ? 'true' : 'false' }}">
                                </td>
                                
                                {{-- Standard Column (Display) --}}
                                <td class="px-3 py-1 text-sm text-gray-700 whitespace-normal">{{ $item['standard'] }}</td>
                                
                                {{-- Status Column (Select) --}}
                                <td class="px-3 py-1 text-sm">
                                    <select name="detail[{{ $global_index }}][status]" id="status-input-{{ $global_index }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-0.5 status-select" 
                                        required data-index="{{ $global_index }}">
                                        <option value="OK" {{ old("detail.{$global_index}.status") == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ old("detail.{$global_index}.status") == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                </td>
                                
                                {{-- Photo Column (Button & Hidden Fields) --}}
                                <td class="px-3 py-1 text-center">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 text-sm take-photo-btn" data-index="{{ $global_index }}">
                                        <i data-lucide="camera" class="h-4 w-4 mx-auto"></i>
                                    </button>
                                    <input type="hidden" name="detail[{{ $global_index }}][photo_base64]" id="photo_base64_{{ $global_index }}" value="{{ old("detail.{$global_index}.photo_base64") }}">
                                    <div id="preview_area_{{ $global_index }}" class="mt-1 {{ old("detail.{$global_index}.photo_base64") ? '' : 'hidden' }}">
                                        <img id="preview_image_{{ $global_index }}" src="{{ old("detail.{$global_index}.photo_base64") }}" class="w-8 h-8 object-cover rounded mx-auto border border-gray-300">
                                        <button type="button" class="delete-photo-btn text-red-500 hover:text-red-700 text-xs mt-0.5 {{ old("detail.{$global_index}.photo_base64") ? '' : 'hidden' }}" data-index="{{ $global_index }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                                
                                {{-- Hidden Fields for Data Integrity --}}
                                <input type="hidden" name="detail[{{ $global_index }}][item_description]" value="{{ $item['description'] }}">
                                <input type="hidden" name="detail[{{ $global_index }}][operational_standard]" value="{{ $item['standard'] }}">
                                <input type="hidden" name="detail[{{ $global_index }}][category]" value="{{ $group['category'] }}">
                                <input type="hidden" name="detail[{{ $global_index }}][sub_category]" value="{{ $sub_category['sub_category'] ?? '' }}">
                            </tr>
                            @php $global_index++; @endphp
                        @endforeach
                        
                    @endforeach
                    
                @else
                    
                    {{-- LOOPING LEVEL 3: ITEM DETAIL LANGSUNG DI BAWAH KATEGORI (a., b., c.) --}}
                    @foreach($group['items'] as $item)
                        <tr class="{{ $item['is_pm'] ? 'bg-yellow-50/50' : '' }}">
                            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-700"></td>
                            <td class="px-3 py-1 text-sm text-gray-700" style="padding-left: 10px;">
                                {{ $item['detail_no'] }} {{ $item['description'] }}
                            </td>
                            
                            {{-- Result Column (Input) --}}
                            <td class="px-3 py-1">
                                <input type="text" name="detail[{{ $global_index }}][result]" id="result-input-{{ $global_index }}"
                                    value="{{ old("detail.{$global_index}.result") }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm p-0.5 result-input"
                                    placeholder="{{ $item['is_pm'] ? 'Nilai/Angka' : 'Deskripsi' }}"
                                    data-index="{{ $global_index }}"
                                    data-is-pm="{{ $item['is_pm'] ? 'true' : 'false' }}">
                            </td>
                            
                            {{-- Standard Column (Display) --}}
                            <td class="px-3 py-1 text-sm text-gray-700 whitespace-normal">{{ $item['standard'] }}</td>
                            
                            {{-- Status Column (Select) --}}
                            <td class="px-3 py-1 text-sm">
                                <select name="detail[{{ $global_index }}][status]" id="status-input-{{ $global_index }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm p-0.5 status-select" 
                                    required data-index="{{ $global_index }}">
                                    <option value="OK" {{ old("detail.{$global_index}.status") == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NOK" {{ old("detail.{$global_index}.status") == 'NOK' ? 'selected' : '' }}>NOK</option>
                                </select>
                            </td>
                            
                            {{-- Photo Column (Button & Hidden Fields) --}}
                            <td class="px-3 py-1 text-center">
                                <button type="button" class="text-indigo-600 hover:text-indigo-900 text-sm take-photo-btn" data-index="{{ $global_index }}">
                                    <i data-lucide="camera" class="h-4 w-4 mx-auto"></i>
                                </button>
                                <input type="hidden" name="detail[{{ $global_index }}][photo_base64]" id="photo_base64_{{ $global_index }}" value="{{ old("detail.{$global_index}.photo_base64") }}">
                                <div id="preview_area_{{ $global_index }}" class="mt-1 {{ old("detail.{$global_index}.photo_base64") ? '' : 'hidden' }}">
                                    <img id="preview_image_{{ $global_index }}" src="{{ old("detail.{$global_index}.photo_base64") }}" class="w-8 h-8 object-cover rounded mx-auto border border-gray-300">
                                    <button type="button" class="delete-photo-btn text-red-500 hover:text-red-700 text-xs mt-0.5 {{ old("detail.{$global_index}.photo_base64") ? '' : 'hidden' }}" data-index="{{ $global_index }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                            
                            {{-- Hidden Fields for Data Integrity --}}
                            <input type="hidden" name="detail[{{ $global_index }}][item_description]" value="{{ $item['description'] }}">
                            <input type="hidden" name="detail[{{ $global_index }}][operational_standard]" value="{{ $item['standard'] }}">
                            <input type="hidden" name="detail[{{ $global_index }}][category]" value="{{ $group['category'] }}">
                            <input type="hidden" name="detail[{{ $global_index }}][sub_category]" value="">
                        </tr>
                        @php $global_index++; @endphp
                    @endforeach
                    
                @endif

            @endforeach
            
        </tbody>
    </table>
</div>
                    {{-- END: DETAIL ITEM PEMERIKSAAN --}}

                    {{-- START: CATATAN DAN PELAKSANA (Sudah Dirapatkan) --}}
                    <h3 class="text-lg font-bold mb-2 border-b pb-1 mt-8 text-gray-700">CATATAN DAN PELAKSANA</h3>
                    <div class="mb-4">
                        <label for="notes" class="block font-medium text-sm text-gray-700">Notes / Catatan</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1">{{ old('notes') }}</textarea>
                    </div>

                    @foreach ($signature_roles as $role)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2 p-3 border rounded-lg {{ $role['required'] ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200 bg-gray-50' }}">
                            <div class="md:col-span-2">
                                <h4 class="font-bold text-sm text-indigo-700">
                                    {{ $role['label'] }} 
                                    @if($role['required'])
                                        <span class="text-red-600">*</span> (Wajib Diisi)
                                    @else
                                        (Opsional)
                                    @endif
                                </h4>
                            </div>
                            
                            {{-- BARIS BARU: HANYA TAMPILKAN INPUT PERUSAHAAN JIKA BUKAN PERAN 'MENGETAHUI' (ID 4) --}}
                            @if ($role['id'] != 4)
                            <div>
                                <label for="pelaksana_{{ $role['id'] }}_perusahaan" class="block font-medium text-sm text-gray-700">
                                    Perusahaan Pelaksana
                                    @if($role['required'] && $role['id'] != 4) <span class="text-red-600">*</span> @endif
                                </label>
                                @php
                                    $defaultPerusahaan = ($role['id'] == 1) ? 'PT. Aplikarusa Lintasarta' : '';
                                    $perusahaanValue = old('pelaksana.' . $role['id'] . '.perusahaan', $defaultPerusahaan);
                                @endphp
                                <input type="text" name="pelaksana[{{ $role['id'] }}][perusahaan]" id="pelaksana_{{ $role['id'] }}_perusahaan" 
                                    value="{{ $perusahaanValue }}" 
                                    class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1" 
                                    {{ ($role['required'] && $role['id'] != 4) ? 'required' : '' }}>
                            </div>
                            @else
                                <input type="hidden" name="pelaksana[{{ $role['id'] }}][perusahaan]" value="">
                            @endif
                            
                            <div>
                                <label for="pelaksana_{{ $role['id'] }}_name" class="block font-medium text-sm text-gray-700">
                                    Nama
                                    @if($role['required']) <span class="text-red-600">*</span> @endif
                                </label>
                                @php
                                    $defaultName = '';
                                    $nameValue = old('pelaksana.' . $role['id'] . '.name', $defaultName);
                                @endphp
                                <input type="text" name="pelaksana[{{ $role['id'] }}][name]" id="pelaksana_{{ $role['id'] }}_name" 
                                    value="{{ $nameValue }}" 
                                    class="mt-0.5 block w-full border-gray-300 rounded-md shadow-sm p-1" 
                                    {{ $role['required'] ? 'required' : '' }}>
                            </div>

                            <input type="hidden" name="pelaksana[{{ $role['id'] }}][no]" value="{{ $role['no'] }}">
                            <input type="hidden" name="pelaksana[{{ $role['id'] }}][role]" value="{{ $role['label'] }}">
                        </div>
                    @endforeach
                    {{-- END: CATATAN DAN PELAKSANA --}}
                    
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                            Simpan Formulir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Camera Modal (Dibiarkan sama) --}}
    <div id="camera-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-1/2 p-6">
            <h4 class="text-lg font-semibold mb-4 border-b pb-2">Ambil Foto Item</h4>
            <video id="camera-feed" class="w-full rounded mb-4" autoplay></video>
            <canvas id="camera-canvas" class="hidden"></canvas>
            <div id="camera-status" class="text-sm text-gray-600 mb-4">Kamera belum aktif.</div>
            
            <div class="flex justify-end gap-3">
                <button type="button" id="capture-btn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Ambil Foto
                </button>
                <button type="button" id="close-camera-btn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                    Tutup Kamera
                </button>
            </div>
        </div>
    </div>

<script>
    let stream = null;
    let currentDetailIndex = null;
    const cameraFeed = document.getElementById('camera-feed');
    const cameraCanvas = document.getElementById('camera-canvas');
    const cameraModal = document.getElementById('camera-modal');
    const captureBtn = document.getElementById('capture-btn');
    const closeCameraBtn = document.getElementById('close-camera-btn');
    const cameraStatus = document.getElementById('camera-status');

    function getPreviewImage(index) {
        return document.getElementById(`preview_image_${index}`);
    }

    function getPreviewArea(index) {
        return document.getElementById(`preview_area_${index}`);
    }
    
    function getDeleteButton(index) {
        return document.querySelector(`#preview_area_${index} .delete-photo-btn`);
    }

    async function startCamera(index) {
        try {
            const constraints = {
                video: { facingMode: { ideal: 'environment' } }
            };
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            cameraFeed.srcObject = stream;
            cameraModal.classList.remove('hidden');
            currentDetailIndex = index;
            cameraStatus.textContent = 'Kamera aktif. Arahkan dan ambil foto.';
        } catch (err) {
            console.error("Error accessing camera: ", err);
            cameraStatus.textContent = 'Gagal mengakses kamera. Pastikan izin telah diberikan.';
            alert('Gagal mengakses kamera. Pastikan izin telah diberikan dan menggunakan HTTPS/localhost.');
            cameraModal.classList.add('hidden');
        }
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }

    document.querySelectorAll('.take-photo-btn').forEach(button => {
        button.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            startCamera(index);
        });
    });

    closeCameraBtn.addEventListener('click', function() {
        stopCamera();
        cameraModal.classList.add('hidden');
        currentDetailIndex = null;
    });

    captureBtn.addEventListener('click', function() {
        if (stream && currentDetailIndex !== null) {
            const context = cameraCanvas.getContext('2d');
            cameraCanvas.width = cameraFeed.videoWidth;
            cameraCanvas.height = cameraFeed.videoHeight;
            context.drawImage(cameraFeed, 0, 0, cameraCanvas.width, cameraCanvas.height);

            const imageData = cameraCanvas.toDataURL('image/jpeg', 0.8);
            document.getElementById(`photo_base64_${currentDetailIndex}`).value = imageData;

            getPreviewImage(currentDetailIndex).src = imageData;
            getPreviewArea(currentDetailIndex).classList.remove('hidden');
            getDeleteButton(currentDetailIndex).classList.remove('hidden');

            stopCamera();
            cameraModal.classList.add('hidden');
            currentDetailIndex = null;
            alert('Foto berhasil diambil dan dilampirkan.');
        } else {
            cameraStatus.textContent = 'Kamera belum aktif atau terjadi kesalahan.';
        }
    });

    document.querySelectorAll('.delete-photo-btn').forEach(button => {
        button.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            document.getElementById(`photo_base64_${index}`).value = '';
            getPreviewImage(index).src = '';
            getPreviewArea(index).classList.add('hidden');
            this.classList.add('hidden');
            alert('Foto berhasil dihapus.');
        });
    });

// VALIDATION LOGIC MODIFIED
    function validateResultInput(index) {
        const resultInput = document.getElementById(`result-input-${index}`);
        const statusSelect = document.getElementById(`status-input-${index}`);
        const isPerformanceMeasurement = resultInput.getAttribute('data-is-pm') === 'true';
        const resultValue = resultInput.value.trim();

        // Mendapatkan elemen Standard
        const standardCell = resultInput.closest('tr').children[3];
        const standardText = standardCell ? standardCell.textContent.trim() : '';

        // Reset pesan validasi browser
        resultInput.setCustomValidity(''); 
        statusSelect.setCustomValidity(''); 

        if (isPerformanceMeasurement) {
            // Logika untuk Performance Measurement (PM)
            const numericResultValue = parseFloat(resultValue.replace(/[^0-9.]/g, ''));
            
            // Mencari angka maksimum dari teks standard, contoh: "Maks 35°C" -> 35
            const maxMatch = standardText.match(/Maks\s*(\d+)/i);
            const maxValue = maxMatch ? parseFloat(maxMatch[1]) : null;
            
            let resultValidationMessage = '';
            let statusValidationMessage = ''; 
            
            // 1. Validasi Result (Wajib diisi Angka)
            if (resultValue === '' || isNaN(numericResultValue)) {
                resultValidationMessage = 'Wajib diisi dengan nilai pengukuran (angka).';
            } 
            
            // Logika Otomasi dan Validasi Status PM
            else if (maxValue !== null) {
                // KONDISI 1: NILAI AMAN (<= MAKS)
                if (numericResultValue <= maxValue) {
                    // Cek apakah Status diubah menjadi NOK
                    if (statusSelect.value === 'NOK') {
                        // Notifikasi untuk mengubah status kembali ke OK
                        resultValidationMessage = `Nilai ${numericResultValue} masih dalam batas aman (${maxValue}). Wajib ubah Status menjadi OK.`;
                        statusValidationMessage = 'Wajib memilih status OK karena nilai masih dalam batas!';
                        // Tidak ada perubahan otomatis Status, hanya notifikasi
                    } 
                    // TIDAK ADA KONDISI KHUSUS JIKA STATUS OK
                } 
                
                // KONDISI 2: NILAI MELEBIHI MAKS (> MAKS)
                else {
                    // Cek apakah Status masih OK
                    if (statusSelect.value === 'OK') {
                        // Notifikasi untuk mengubah status menjadi NOK
                        resultValidationMessage = `Nilai ${numericResultValue} melebihi batas maksimum ${maxValue}. Wajib ubah Status menjadi NOK.`;
                        statusValidationMessage = 'Wajib memilih status NOK karena nilai melebihi batas!';
                        // Tidak ada perubahan otomatis Status, hanya notifikasi
                    }
                    // TIDAK ADA KONDISI KHUSUS JIKA STATUS NOK
                }
            }

            // Tampilkan pesan validasi pada Result Input
            if (resultValidationMessage !== '') {
                resultInput.setCustomValidity(resultValidationMessage);
            }
            
            // Tampilkan pesan validasi pada Status Dropdown
            if (statusValidationMessage !== '') {
                statusSelect.setCustomValidity(statusValidationMessage);
            }


        } else {
            // Logika untuk Non-Performance Measurement (Non-PM) (Visual Check)
            if (statusSelect.value === 'OK') {
                // Status OK (Operational Standard Normal): Result harus dikosongkan.
                if (resultValue !== '') {
                    resultInput.setCustomValidity('Status OK (Operational Standard Normal): Result harus dikosongkan.');
                }
            } else if (statusSelect.value === 'NOK') {
                // Status NOK: Wajib diisi Result dengan deskripsi masalah/temuan.
                if (resultValue === '') {
                    resultInput.setCustomValidity('Status NOK: Wajib diisi Result dengan deskripsi masalah/temuan.');
                }
            }
        }

        // Tampilkan pesan validasi untuk kedua input
        resultInput.reportValidity();
        statusSelect.reportValidity();
    }

    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const index = this.getAttribute('data-index');
            const resultInput = document.getElementById(`result-input-${index}`);
            const isPerformanceMeasurement = resultInput.getAttribute('data-is-pm') === 'true';

            // Jika status diubah, dan ini BUKAN PM, dan statusnya OK, kosongkan Result.
            if (!isPerformanceMeasurement && this.value === 'OK') {
                 resultInput.value = '';
            }

            // Jika status diubah, panggil validasi
            validateResultInput(index);
        });
        // Panggil saat DOMContentLoaded
        validateResultInput(select.getAttribute('data-index'));
    });

    document.querySelectorAll('.result-input').forEach(input => {
        const index = input.getAttribute('data-index');
        input.addEventListener('input', function() {
            validateResultInput(index);
        });
        // Panggil saat DOMContentLoaded
        validateResultInput(index);
    });

    // SET DEFAULT DATETIME
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const localDatetime = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}T${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

        const datetimeInput = document.getElementById('date_time');
        if (datetimeInput && !datetimeInput.value) {
            datetimeInput.value = localDatetime;
        }

        // Panggil validasi untuk memastikan nilai lama juga divalidasi
        document.querySelectorAll('.status-select').forEach(select => {
            validateResultInput(select.getAttribute('data-index'));
        });
    });
</script>
</x-app-layout>
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

                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-700">DATA PERANGKAT</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6"> 
                        
                        <div>
                            <label for="location" class="block font-medium text-sm text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        
                        <div>
                            <label for="date_time" class="block font-medium text-sm text-gray-700">Date / Time</label>
                            <input type="datetime-local" name="date_time" id="date_time" value="{{ old('date_time') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        
                        <div>
                            <label for="brand_type" class="block font-medium text-sm text-gray-700">Brand / Type</label>
                            <input type="text" name="brand_type" id="brand_type" value="{{ old('brand_type') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="reg_number" class="block font-medium text-sm text-gray-700">Reg. Number</label>
                            <input type="text" name="reg_number" id="reg_number" value="{{ old('reg_number') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="serial_number" class="block font-medium text-sm text-gray-700">Serial Number</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <h3 class="text-lg font-bold mb-4 border-b pb-2 mt-8 text-gray-700">DETAIL ITEM PEMERIKSAAN</h3>
                    
                    @php
                        $index = 0;
                    @endphp

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">No.</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-5/12">Descriptions</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Result</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Standard</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Status</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Photo</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                
                                @foreach($grouped_items as $group)
                                    @php 
                                        // Group items by sub_category
                                        $subCategories = collect($group['items'])->groupBy('sub_category');
                                    @endphp
                                    
                                    {{-- Header Kategori Utama --}}
                                    <tr>
                                        <td colspan="6" class="px-3 py-2 bg-gray-200 text-sm font-bold text-gray-900 border-t-2 border-gray-400">
                                            {{ $group['category'] }}
                                        </td>
                                    </tr>
                                    
                                    {{-- Loop Sub-Categories --}}
                                    @foreach($subCategories as $subCategoryName => $items)
                                        @php 
                                            $to_char = 97; // Reset untuk setiap sub-kategori
                                        @endphp
                                        
                                        {{-- Header Sub-Kategori (jika ada) --}}
                                        @if($subCategoryName)
                                            <tr>
                                                <td colspan="6" class="px-3 py-2 bg-gray-100 text-sm font-semibold text-gray-800 pl-8">
                                                    {{ $subCategoryName }}
                                                </td>
                                            </tr>
                                        @endif
                                        
                                        {{-- Items dalam Sub-Kategori --}}
                                        @foreach($items as $item)
                                            @php
                                                $description = $item['description'];
                                                $standard = $item['standard'];
                                                $isPerformanceMeasurement = $item['is_pm'];
                                                $category = $item['category'];
                                                $oldResult = old("detail.{$index}.result");
                                                $prefix = chr($to_char);
                                            @endphp
                                            
                                            <tr>
                                                <td class="px-3 py-2 text-center text-sm text-gray-500">{{ $prefix }}.</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 {{ $subCategoryName ? 'pl-12' : '' }}">
                                                    {{ $description }}
                                                </td>
                                                
                                                <td class="px-3 py-2">
                                                    <input type="text" name="detail[{{ $index }}][result]" id="result-input-{{ $index }}"
                                                        value="{{ $oldResult }}" 
                                                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-1 result-input"
                                                        placeholder="{{ $isPerformanceMeasurement ? 'Nilai/Angka' : 'Deskripsi' }}"
                                                        data-index="{{ $index }}"
                                                        data-is-pm="{{ $isPerformanceMeasurement ? 'true' : 'false' }}">
                                                </td>

                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $standard }}</td>
                                                
                                                <td class="px-3 py-2 text-sm">
                                                    <select name="detail[{{ $index }}][status]" id="status-input-{{ $index }}" 
                                                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-1 status-select" 
                                                        required data-index="{{ $index }}">
                                                        <option value="OK" {{ old("detail.{$index}.status") == 'OK' ? 'selected' : '' }}>OK</option>
                                                        <option value="NOK" {{ old("detail.{$index}.status") == 'NOK' ? 'selected' : '' }}>NOK</option>
                                                    </select>
                                                </td>

                                                <td class="px-3 py-2 text-center">
                                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 text-sm take-photo-btn" data-index="{{ $index }}">
                                                        <i data-lucide="camera" class="h-5 w-5 mx-auto"></i>
                                                    </button>
                                                    <input type="hidden" name="detail[{{ $index }}][photo_base64]" id="photo_base64_{{ $index }}" value="{{ old("detail.{$index}.photo_base64") }}">
                                                    
                                                    <div id="preview_area_{{ $index }}" class="mt-2 {{ old("detail.{$index}.photo_base64") ? '' : 'hidden' }}">
                                                        <img id="preview_image_{{ $index }}" src="{{ old("detail.{$index}.photo_base64") }}" class="w-12 h-12 object-cover rounded mx-auto border border-gray-300">
                                                        <button type="button" class="delete-photo-btn text-red-500 hover:text-red-700 text-xs mt-1 {{ old("detail.{$index}.photo_base64") ? '' : 'hidden' }}" data-index="{{ $index }}">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            {{-- Hidden Fields --}}
                                            <input type="hidden" name="detail[{{ $index }}][item_description]" value="{{ $description }}">
                                            <input type="hidden" name="detail[{{ $index }}][operational_standard]" value="{{ $standard }}">
                                            <input type="hidden" name="detail[{{ $index }}][category]" value="{{ $category }}">
                                            
                                            @php 
                                                $index++; 
                                                $to_char++;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-lg font-bold mb-4 border-b pb-2 mt-8 text-gray-700">CATATAN DAN PELAKSANA</h3>
                    <div class="mb-6">
                        <label for="notes" class="block font-medium text-sm text-gray-700">Notes / Catatan</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                    </div>

                    @foreach ($signature_roles as $role)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4 p-4 border rounded-lg {{ $role['required'] ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200 bg-gray-50' }}">
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
                                    // Logika default: Hanya Pelaksana 1 (ID 1) yang diisi default perusahaan.
                                    $defaultPerusahaan = ($role['id'] == 1) ? 'PT. Aplikarusa Lintasarta' : '';
                                    // Hilangkan old('pelaksana.' . $role['id'] . '.perusahaan') dari $perusahaanValue agar default hanya berlaku saat tidak ada old()
                                    $perusahaanValue = old('pelaksana.' . $role['id'] . '.perusahaan', $defaultPerusahaan);
                                @endphp
                                <input type="text" name="pelaksana[{{ $role['id'] }}][perusahaan]" id="pelaksana_{{ $role['id'] }}_perusahaan" 
                                    value="{{ $perusahaanValue }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                    {{ ($role['required'] && $role['id'] != 4) ? 'required' : '' }}>
                            </div>
                            @else
                                {{-- Jika Peran 'Mengetahui' (ID 4), tambahkan input tersembunyi untuk Perusahaan Pelaksana --}}
                                <input type="hidden" name="pelaksana[{{ $role['id'] }}][perusahaan]" value="">
                            @endif
                            
                            {{-- HAPUS DIV PERUSAHAAN PELAKSANA YANG DUPLIKAT SEBELUMNYA --}}
                            {{-- ... (div yang duplikat dihapus) ... --}}
                            
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
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                    {{ $role['required'] ? 'required' : '' }}>
                            </div>

                            <input type="hidden" name="pelaksana[{{ $role['id'] }}][no]" value="{{ $role['no'] }}">
                            <input type="hidden" name="pelaksana[{{ $role['id'] }}][role]" value="{{ $role['label'] }}">
                        </div>
                    @endforeach
                    
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                            Simpan Formulir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Camera Modal --}}
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
    // CAMERA LOGIC (Dibiarkan sama)
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

// VALIDATION LOGIC MODIFIED (Menerapkan notifikasi wajib ubah status)
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
            const numericResultValue = parseFloat(resultValue.replace(/[^0-9.]/g, ''));
            
            // Mencari angka maksimum dari teks standard, contoh: "Maks 35Â°C" -> 35
            const maxMatch = standardText.match(/Maks\s*(\d+)/i);
            const maxValue = maxMatch ? parseFloat(maxMatch[1]) : null;
            
            let resultValidationMessage = '';
            let statusValidationMessage = ''; 
            
            // 1. Validasi Input Result (Wajib Diisi Angka)
            if (resultValue === '' || isNaN(numericResultValue)) {
                resultValidationMessage = 'Wajib diisi dengan nilai pengukuran (angka).';
            } 
            
            // 2. KONDISI GAGAL: MELEBIHI MAKS, TAPI STATUS OK
            else if (maxValue !== null && numericResultValue > maxValue) {
                if (statusSelect.value === 'OK') {
                    // Blokir submit jika Status masih OK
                    resultValidationMessage = `Nilai ${numericResultValue}Â°C melebihi batas maksimum ${maxValue}Â°C. Wajib ubah Status menjadi NOK.`;
                    statusValidationMessage = 'Wajib memilih status NOK karena nilai melebihi batas!';
                }
            }
            
            // 3. KONDISI GAGAL: DI BAWAH/SAMA DENGAN MAKS, TAPI STATUS NOK (PERMINTAAN BARU)
            else if (maxValue !== null && numericResultValue <= maxValue) {
                if (statusSelect.value === 'NOK') {
                    // Blokir submit jika Status NOK padahal nilai aman
                    resultValidationMessage = `Nilai ${numericResultValue}Â°C masih dalam batas aman (${maxValue}Â°C). Wajib ubah Status menjadi OK.`;
                    statusValidationMessage = 'Wajib memilih status OK karena nilai masih dalam batas!';
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
            // Logika untuk Non-Performance Measurement (Non-PM)
            if (statusSelect.value === 'OK') {
                if (resultValue !== '') {
                    resultInput.setCustomValidity('Status OK: Result harus dikosongkan (kecuali Performance Measurement).');
                }
            } else if (statusSelect.value === 'NOK') {
                if (resultValue === '') {
                    resultInput.setCustomValidity('Status NOK: Wajib diisi dengan deskripsi masalah.');
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
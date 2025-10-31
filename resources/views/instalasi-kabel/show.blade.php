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
            @php 
                $globalIndex = 0;
                $categoryNumber = 0;
                
                // Helper function untuk konversi ke Romawi
                $toRoman = function($num) {
                    $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
                    return $romans[$num - 1] ?? $num;
                };
            @endphp
            
            @foreach($grouped_items as $category => $categoryData)
                @php $categoryNumber++; @endphp
                
                {{-- LEVEL 1: Header Kategori Utama (1., 2., 3.) --}}
                <tr>
                    <td colspan="6" class="px-3 py-2 bg-gray-200 text-sm font-bold text-gray-900 border-t-2 border-gray-400">
                        {{ $categoryNumber }}. {{ $category }}
                    </td>
                </tr>
                
                @php
                    $hasSubCategories = isset($categoryData['sub_categories']);
                    $romanIndex = 0;
                @endphp
                
                @if($hasSubCategories)
                    {{-- Jika ada Sub-Categories --}}
                    @foreach($categoryData['sub_categories'] as $subCategoryName => $subItems)
                        @php $romanIndex++; @endphp
                        
                        {{-- LEVEL 2: Header Sub-Kategori (I., II., III.) --}}
                        <tr>
                            <td colspan="6" class="px-3 py-2 bg-gray-100 text-sm font-semibold text-gray-800 pl-8">
                                {{ $toRoman($romanIndex) }}. {{ $subCategoryName }}
                            </td>
                        </tr>
                        
                        {{-- LEVEL 3: Items (a., b., c.) --}}
                        @php $letterIndex = 0; @endphp
                        @foreach($subItems as $item)
                            @php
                                $letter = chr(97 + $letterIndex); // a, b, c, ...
                                $description = $item['description'];
                                $standard = $item['standard'];
                                $isPerformanceMeasurement = $item['is_pm'];
                                $oldResult = old("detail.{$globalIndex}.result");
                            @endphp
                            
                            <tr>
                                <td class="px-3 py-2 text-center text-sm text-gray-500">{{ $letter }}.</td>
                                <td class="px-3 py-2 text-sm text-gray-900 pl-12">{{ $description }}</td>
                                
                                <td class="px-3 py-2">
                                    <input type="text" name="detail[{{ $globalIndex }}][result]" id="result-input-{{ $globalIndex }}"
                                        value="{{ $oldResult }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-1 result-input"
                                        placeholder="{{ $isPerformanceMeasurement ? 'Nilai/Angka' : 'Deskripsi' }}"
                                        data-index="{{ $globalIndex }}"
                                        data-is-pm="{{ $isPerformanceMeasurement ? 'true' : 'false' }}">
                                </td>

                                <td class="px-3 py-2 text-sm text-gray-500">{{ $standard }}</td>
                                
                                <td class="px-3 py-2 text-sm">
                                    <select name="detail[{{ $globalIndex }}][status]" id="status-input-{{ $globalIndex }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm text-sm p-1 status-select" 
                                        required data-index="{{ $globalIndex }}">
                                        <option value="OK" {{ old("detail.{$globalIndex}.status") == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ old("detail.{$globalIndex}.status") == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                </td>

                                <td class="px-3 py-2 text-center">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 text-sm take-photo-btn" data-index="{{ $globalIndex }}">
                                        <i data-lucide="camera" class="h-5 w-5 mx-auto"></i>
                                    </button>
                                    <input type="hidden" name="detail[{{ $globalIndex }}][photo_base64]" id="photo_base64_{{ $globalIndex }}" value="{{ old("detail.{$globalIndex}.photo_base64") }}">
                                    
                                    <div id="preview_area_{{ $globalIndex }}" class="mt-2 {{ old("detail.{$globalIndex}.photo_base64") ? '' : 'hidden' }}">
                                        <img id="preview_image_{{ $globalIndex }}" src="{{ old("detail.{$globalIndex}.photo_base64") }}" class="w-12 h-12 object-cover rounded mx-auto border border-gray-300">
                                        <button type="button" class="delete-photo-btn text-red-500 hover:text-red-700 text-xs mt-1" data-index="{{ $globalIndex }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- Hidden Fields --}}
                            <input type="hidden" name="detail[{{ $globalIndex }}][item_description]" value="{{ $description }}">
                            <input type="hidden" name="detail[{{ $globalIndex }}][operational_standard]" value="{{ $standard }}">
                            <input type="hidden" name="detail[{{ $globalIndex }}][category]" value="{{ $category }}">
                            <input type="hidden" name="detail[{{ $globalIndex }}][sub_category]" value="{{ $subCategoryName }}">
                            
                            @php 
                                $globalIndex++; 
                                $letterIndex++;
                            @endphp
                        @endforeach
                    @endforeach
                @else
                    {{-- Jika TIDAK ada Sub-Categories, langsung tampilkan items --}}
                    @php $letterIndex = 0; @endphp
                    @foreach($categoryData['items'] as $item)
                        @php
                            $letter = chr(97 + $letterIndex);
                            $description = $item['description'];
                            $standard = $item['standard'];
                            $isPerformanceMeasurement = $item['is_pm'];
                            $oldResult = old("detail.{$globalIndex}.result");
                        @endphp
                        
                        <tr>
                            <td class="px-3 py-2 text-center text-sm text-gray-500">{{ $letter }}.</td>
                            <td class="px-3 py-2 text-sm text-gray-900">{{ $description }}</td>
                            
                            <td class="px-3 py-2">
                                <input type="text" name="detail[{{ $globalIndex }}][result]" id="result-input-{{ $globalIndex }}"
                                    value="{{ $oldResult }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm p-1 result-input"
                                    placeholder="{{ $isPerformanceMeasurement ? 'Nilai/Angka' : 'Deskripsi' }}"
                                    data-index="{{ $globalIndex }}"
                                    data-is-pm="{{ $isPerformanceMeasurement ? 'true' : 'false' }}">
                            </td>

                            <td class="px-3 py-2 text-sm text-gray-500">{{ $standard }}</td>
                            
                            <td class="px-3 py-2 text-sm">
                                <select name="detail[{{ $globalIndex }}][status]" id="status-input-{{ $globalIndex }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm p-1 status-select" 
                                    required data-index="{{ $globalIndex }}">
                                    <option value="OK" {{ old("detail.{$globalIndex}.status") == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NOK" {{ old("detail.{$globalIndex}.status") == 'NOK' ? 'selected' : '' }}>NOK</option>
                                </select>
                            </td>

                            <td class="px-3 py-2 text-center">
                                <button type="button" class="text-indigo-600 hover:text-indigo-900 text-sm take-photo-btn" data-index="{{ $globalIndex }}">
                                    <i data-lucide="camera" class="h-5 w-5 mx-auto"></i>
                                </button>
                                <input type="hidden" name="detail[{{ $globalIndex }}][photo_base64]" id="photo_base64_{{ $globalIndex }}" value="{{ old("detail.{$globalIndex}.photo_base64") }}">
                                    
                                <div id="preview_area_{{ $globalIndex }}" class="mt-2 {{ old("detail.{$globalIndex}.photo_base64") ? '' : 'hidden' }}">
                                    <img id="preview_image_{{ $globalIndex }}" src="{{ old("detail.{$globalIndex}.photo_base64") }}" class="w-12 h-12 object-cover rounded mx-auto border border-gray-300">
                                    <button type="button" class="delete-photo-btn text-red-500 hover:text-red-700 text-xs mt-1" data-index="{{ $globalIndex }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        {{-- Hidden Fields --}}
                        <input type="hidden" name="detail[{{ $globalIndex }}][item_description]" value="{{ $description }}">
                        <input type="hidden" name="detail[{{ $globalIndex }}][operational_standard]" value="{{ $standard }}">
                        <input type="hidden" name="detail[{{ $globalIndex }}][category]" value="{{ $category }}">
                        {{-- <input type="hidden" name="detail[{{ $globalIndex }}][sub_category]" value="{{ null }}"> --}}
                        
                        @php 
                            $globalIndex++; 
                            $letterIndex++;
                        @endphp
                    @endforeach
                @endif
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
                            
                            {{-- TAMPILKAN INPUT PERUSAHAAN JIKA BUKAN PERAN 'MENGETAHUI' (ID 4) --}}
                            @if ($role['id'] != 4)
                                <div>
                                    <label for="pelaksana-{{ $role['id'] }}-perusahaan" class="block font-medium text-sm text-gray-700">Perusahaan</label>
                                    <input type="text" name="pelaksana[{{ $role['id'] }}][perusahaan]" id="pelaksana-{{ $role['id'] }}-perusahaan" 
                                        value="{{ old("pelaksana.{$role['id']}.perusahaan") }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        {{ $role['required'] ? 'required' : '' }}>
                                </div>
                            @endif

                            <div>
                                <label for="pelaksana-{{ $role['id'] }}-name" class="block font-medium text-sm text-gray-700">Nama</label>
                                <input type="text" name="pelaksana[{{ $role['id'] }}][name]" id="pelaksana-{{ $role['id'] }}-name" 
                                    value="{{ old("pelaksana.{$role['id']}.name") }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    {{ $role['required'] ? 'required' : '' }}>
                            </div>

                            <input type="hidden" name="pelaksana[{{ $role['id'] }}][no]" value="{{ $role['no'] }}">
                            <input type="hidden" name="pelaksana[{{ $role['id'] }}][role]" value="{{ $role['label'] }}">
                        </div>
                    @endforeach


                    <div class="mt-6 pt-4 border-t">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-colors duration-200 w-full justify-center">
                            <i data-lucide="save" class="h-5 w-5 mr-2"></i>
                            Simpan Formulir
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
    {{-- MODAL FOTO (Contoh jika menggunakan JavaScript untuk kamera) --}}
    {{-- ... (The original JavaScript/modal part that handles the camera/photo) --}}
    
    <script>
        // FUNGSI JAVASCRIPT LAMA UNTUK VALIDASI RESULT BERDASARKAN STATUS
        function validateResultInput(index) {
            const statusSelect = document.getElementById(`status-input-${index}`);
            const resultInput = document.getElementById(`result-input-${index}`);
            const isPerformanceMeasurement = resultInput.getAttribute('data-is-pm') === 'true';
            
            if (statusSelect.value === 'NOK' && isPerformanceMeasurement) {
                 // Jika PM dan NOK, Result WAJIB diisi
                resultInput.required = true;
                resultInput.placeholder = "Wajib diisi jika Status NOK";
            } else if (statusSelect.value === 'NOK' && !isPerformanceMeasurement) {
                // Jika NON-PM dan NOK, Result WAJIB diisi (Catatan/Deskripsi)
                resultInput.required = true;
                resultInput.placeholder = "Wajib diisi dengan deskripsi kerusakan jika Status NOK";
            } else {
                // Jika OK, Result TIDAK WAJIB diisi
                resultInput.required = false;
                resultInput.placeholder = isPerformanceMeasurement ? 'Nilai/Angka' : 'Deskripsi';
            }
        }

        document.querySelectorAll('.status-select').forEach(select => {
            const index = select.getAttribute('data-index');
            select.addEventListener('change', function() {
                const resultInput = document.getElementById(`result-input-${index}`);
                const isPerformanceMeasurement = resultInput.getAttribute('data-is-pm') === 'true';

                // Jika status diubah ke OK pada NON-PM, kosongkan Result.
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
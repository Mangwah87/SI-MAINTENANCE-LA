<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Edit Jadwal PM Sentral') }}: {{ \Carbon\Carbon::parse($schedule->tanggal_pembuatan)->isoFormat('D MMMM Y') }}
            </h2>
            <a href="{{ route('schedule.index') }}"
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
            <form action="{{ route('schedule.update', $schedule->id) }}" method="POST" id="scheduleForm" class="bg-white p-6 sm:p-8 shadow-xl sm:rounded-lg">
                @csrf
                @method('PUT')
                
                @php
                    $extractNameAndNik = function($combinedString) {
                        $name = $combinedString;
                        $nik = '';
                        if (preg_match('/\s\((.*?)\)$/', $combinedString, $matches)) {
                            $nik = $matches[1];
                            $name = trim(str_replace($matches[0], '', $combinedString));
                        }
                        return ['name' => $name, 'nik' => $nik];
                    };

                    $dibuatOleh = $extractNameAndNik($schedule->dibuat_oleh);
                    $mengetahui = $extractNameAndNik($schedule->mengetahui);
                @endphp

                <h3 class="text-xl font-bold mb-4 border-b pb-2 text-blue-600">Data Utama Jadwal</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"> 
                    
                    {{-- BARIS 1 --}}
                    
                    {{-- Kolom 1: Tanggal Pembuatan --}}
                    <div>
                        <x-input-label for="tanggal_pembuatan" :value="__('Tanggal Pembuatan')" />
                        <x-text-input id="tanggal_pembuatan" name="tanggal_pembuatan" type="date" class="mt-1 block w-full" :value="old('tanggal_pembuatan', $schedule->tanggal_pembuatan ? \Carbon\Carbon::parse($schedule->tanggal_pembuatan)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d'))" required />
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_pembuatan')" />
                    </div>

                    {{-- Kolom 2: Dibuat Oleh (Nama Petugas) --}}
                    <div>
                        <x-input-label for="dibuat_oleh_nama" :value="__('Dibuat Oleh (Nama Petugas)')" />
                        <x-text-input id="dibuat_oleh_nama" name="dibuat_oleh_nama" type="text" class="mt-1 block w-full" :value="old('dibuat_oleh_nama', $dibuatOleh['name'])" required />
                        <x-input-error class="mt-2" :messages="$errors->get('dibuat_oleh_nama')" />
                    </div>

                    {{-- Kolom 3: Mengetahui (Nama Manajer) --}}
                    <div>
                        <x-input-label for="mengetahui_nama" :value="__('Mengetahui (Nama Manajer)')" />
                        <x-text-input id="mengetahui_nama" name="mengetahui_nama" type="text" class="mt-1 block w-full" :value="old('mengetahui_nama', $mengetahui['name'])" placeholder="Nama Manajer" required />
                        <x-input-error class="mt-2" :messages="$errors->get('mengetahui_nama')" />
                    </div>
                    
                    {{-- BARIS 2 --}}
                    
                    {{-- Kolom 1: NIK Petugas --}}
                    <div class="md:col-span-1">
                        <x-input-label for="dibuat_oleh_nik" :value="__('NIK Petugas')" />
                        <x-text-input id="dibuat_oleh_nik" name="dibuat_oleh_nik" type="text" class="mt-1 block w-full" :value="old('dibuat_oleh_nik', $dibuatOleh['nik'])" placeholder="NIK Petugas" />
                        <x-input-error class="mt-2" :messages="$errors->get('dibuat_oleh_nik')" />
                    </div>

                    {{-- Kolom 2: NIK Manajer --}}
                    <div class="md:col-span-1">
                        <x-input-label for="mengetahui_nik" :value="__('NIK Manajer')" />
                        <x-text-input id="mengetahui_nik" name="mengetahui_nik" type="text" class="mt-1 block w-full" :value="old('mengetahui_nik', $mengetahui['nik'])" placeholder="NIK Manajer" />
                        <x-input-error class="mt-2" :messages="$errors->get('mengetahui_nik')" />
                    </div>
                    
                    {{-- Kolom 3: Kosong --}}
                    <div></div>
                    
                </div>
                
                <h3 class="text-xl font-bold mb-4 border-b pb-2 text-blue-600">Detail Lokasi PM</h3>
                <div id="locations-container" class="space-y-4 mb-6">
                    
                    @php
                        $locations_data = old('locations', $schedule->locations->toArray()); 
                    @endphp

                    @foreach ($locations_data as $index => $location)
                        @php
                            $location_id = $location['id'] ?? null;
                            
                            $petugasData = $extractNameAndNik($location['petugas'] ?? '');
                            $petugas_nama_value = old("locations.$index.petugas_nama", $location['petugas_nama'] ?? $petugasData['name']);

                            $nama_value = old("locations.$index.nama", $location['nama'] ?? '');
                            $rencana_old = old("locations.$index.rencana", $location['rencana'] ?? []);
                            $realisasi_old = old("locations.$index.realisasi", $location['realisasi'] ?? []);

                            if (!is_array($rencana_old) && is_string($rencana_old) && $rencana_old) {
                                $rencana_old = json_decode($rencana_old, true) ?: [];
                            }
                            if (!is_array($realisasi_old) && is_string($realisasi_old) && $realisasi_old) {
                                $realisasi_old = json_decode($realisasi_old, true) ?: [];
                            }
                            
                            $is_permanent = $index == 0;
                            $rencana_name = "locations[$index][rencana]";
                            $realisasi_name = "locations[$index][realisasi]";
                        @endphp

                        <div class="location-item border p-4 rounded-lg shadow-sm bg-gray-50 grid grid-cols-1 gap-4" data-index="{{ $index }}" data-permanent="{{ $is_permanent ? 'true' : 'false' }}">
                            <div class="col-span-1 flex justify-between items-center mb-2">
                                <h4 class="location-title font-semibold text-gray-700">Lokasi #{{ $index + 1 }}</h4>
                                
                                @if($location_id)
                                    <input type="hidden" name="locations[{{ $index }}][id]" value="{{ $location_id }}">
                                @endif
                                
                                @if(!$is_permanent)
                                <button type="button" class="remove-location-btn text-red-500 hover:text-red-700 transition-colors duration-200" data-index="{{ $index }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @else
                                <span></span> 
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-1 flex flex-col gap-4"> 
                                    <div>
                                        <x-input-label for="locations[{{ $index }}][nama]" :value="__('Nama Lokasi')" />
                                        <x-text-input id="locations[{{ $index }}][nama]" name="locations[{{ $index }}][nama]" type="text" class="mt-1 block w-full" value="{{ $nama_value }}" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('locations.' . $index . '.nama')" />
                                    </div>

                                    <div>
                                        <x-input-label :value="__('Tanggal Rencana')" class="mb-2" />
                                        <div class="grid grid-cols-6 gap-2 p-3 border border-indigo-200 rounded-md bg-white overflow-y-auto max-h-40"> 
                                            <div class="col-span-6 flex items-center justify-center p-1 border border-indigo-500 rounded-sm w-full h-8 bg-indigo-100 hover:bg-indigo-200 transition duration-150">
                                                <input id="{{ $rencana_name }}_all" type="checkbox" 
                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-indigo-300 rounded" 
                                                    onclick="handleAllToggle(this, '{{ $rencana_name }}')"
                                                    {{ count(array_filter($rencana_old, 'is_numeric')) == 31 ? 'checked' : '' }}>
                                                <label for="{{ $rencana_name }}_all" class="text-xs font-semibold text-indigo-700 ml-1 select-none">PILIH SEMUA</label>
                                            </div>
                                            
                                            @for ($i = 1; $i <= 31; $i++)
                                                <div class="flex items-center justify-center p-1 border border-gray-300 rounded-sm w-8 h-8 hover:bg-gray-100 transition duration-150">
                                                    <input id="{{ $rencana_name }}_{{ $i }}" type="checkbox" 
                                                            name="{{ $rencana_name }}[]" 
                                                            value="{{ $i }}" 
                                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" 
                                                            onclick="handleCheckboxClick(this)"
                                                            {{ in_array($i, $rencana_old) ? 'checked' : '' }}>
                                                    <label for="{{ $rencana_name }}_{{ $i }}" class="text-xs font-medium text-gray-700 ml-1 select-none">{{ $i }}</label>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="md:col-span-1 flex flex-col gap-4">
                                    <div>
                                        <x-input-label for="locations[{{ $index }}][petugas_nama]" :value="__('Petugas Pelaksana')" /> 
                                        <x-text-input id="locations[{{ $index }}][petugas_nama]" name="locations[{{ $index }}][petugas_nama]" type="text" class="mt-1 block w-full" value="{{ $petugas_nama_value }}" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('locations.' . $index . '.petugas_nama')" /> 
                                    </div>

                                    <div>
                                        <x-input-label :value="__('Tanggal Realisasi')" class="mb-2" />
                                        <div class="grid grid-cols-6 gap-2 p-3 border border-green-200 rounded-md bg-white overflow-y-auto max-h-40"> 
                                            <div class="col-span-6 flex items-center justify-center p-1 border border-green-500 rounded-sm w-full h-8 bg-green-100 hover:bg-green-200 transition duration-150">
                                                <input id="{{ $realisasi_name }}_all" type="checkbox" 
                                                    class="focus:ring-green-500 h-4 w-4 text-green-600 border-green-300 rounded" 
                                                    onclick="handleAllToggle(this, '{{ $realisasi_name }}')"
                                                    {{ count(array_filter($realisasi_old, 'is_numeric')) == 31 ? 'checked' : '' }}>
                                                <label for="{{ $realisasi_name }}_all" class="text-xs font-semibold text-green-700 ml-1 select-none">PILIH SEMUA</label>
                                            </div>

                                            @for ($i = 1; $i <= 31; $i++)
                                                <div class="flex items-center justify-center p-1 border border-gray-300 rounded-sm w-8 h-8 hover:bg-gray-100 transition duration-150">
                                                    <input id="{{ $realisasi_name }}_{{ $i }}" type="checkbox" 
                                                            name="{{ $realisasi_name }}[]" 
                                                            value="{{ $i }}" 
                                                            class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded" 
                                                            onclick="handleCheckboxClick(this)"
                                                            {{ in_array($i, $realisasi_old) ? 'checked' : '' }}>
                                                    <label for="{{ $realisasi_name }}_{{ $i }}" class="text-xs font-medium text-gray-700 ml-1 select-none">{{ $i }}</label>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-start mb-8 items-center">
                    <button type="button" id="add-location-btn" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Lokasi
                    </button>
                </div>

                <div class="flex items-center justify-end">
                    <x-primary-button class="ml-4 bg-yellow-600 hover:bg-yellow-700">
                        {{ __('Perbarui Jadwal') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const locationsContainer = document.getElementById('locations-container');
        const initialLocationCount = locationsContainer.querySelectorAll('.location-item').length;
        let locationIndex = initialLocationCount;

        const addLocationBtn = document.getElementById('add-location-btn');
        const MAX_LOCATIONS = 10; // Batas maksimal lokasi
        
        const generateDateCheckboxes = (name, isRencana = true) => {
            const colorClass = isRencana ? 'indigo' : 'green';
            let html = '';
            for (let i = 1; i <= 31; i++) {
                html += `
                    <div class="flex items-center justify-center p-1 border border-gray-300 rounded-sm w-8 h-8 hover:bg-gray-100 transition duration-150">
                        <input id="${name}_${i}" type="checkbox" name="${name}[]" value="${i}" class="focus:ring-${colorClass}-500 h-4 w-4 text-${colorClass}-600 border-gray-300 rounded" onclick="handleCheckboxClick(this)">
                        <label for="${name}_${i}" class="text-xs font-medium text-gray-700 ml-1 select-none">${i}</label>
                    </div>
                `;
            }
            return html;
        };

        window.handleAllToggle = (checkbox, targetName) => {
            const container = checkbox.closest('.location-item');
            if (!container) return;
            const dateCheckboxes = container.querySelectorAll(`input[name="${targetName}[]"]`);
            dateCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        };

        window.handleCheckboxClick = (checkbox) => {
            const container = checkbox.closest('.location-item');
            if (!container) return;
            
            const targetName = checkbox.name.replace(/\[\]$/, '');

            const allCheckbox = container.querySelector(`input[id="${targetName}_all"]`); 
            const dateCheckboxes = container.querySelectorAll(`input[name="${targetName}[]"]`);

            if (!allCheckbox) return;

            const totalCheckboxes = dateCheckboxes.length;
            const checkedCheckboxes = Array.from(dateCheckboxes).filter(cb => cb.checked).length;
            
            allCheckbox.checked = totalCheckboxes === checkedCheckboxes;
        };
        
        const reindexLocations = () => {
            const locationItems = locationsContainer.querySelectorAll('.location-item');
            locationItems.forEach((item, index) => {
                const oldIndex = parseInt(item.getAttribute('data-index'));
                const newIndex = index;

                item.setAttribute('data-index', newIndex);
                const displayNum = newIndex + 1;
                const titleElement = item.querySelector('.location-title');
                if (titleElement) {
                    titleElement.textContent = `Lokasi #${displayNum}`;
                }

                if (oldIndex !== newIndex) {
                    const inputs = item.querySelectorAll('[name],[id]');
                    inputs.forEach(input => {
                        const oldIndexString = `locations[${oldIndex}]`;
                        const newIndexString = `locations[${newIndex}]`;

                        if (input.name) {
                            input.name = input.name.replace(oldIndexString, newIndexString);
                        }
                        if (input.id) {
                            input.id = input.id.replace(oldIndexString, newIndexString);
                        }
                        
                        if (input.getAttribute('onclick') && input.getAttribute('onclick').includes('handleAllToggle')) {
                            let onclick = input.getAttribute('onclick');
                            const regex = new RegExp(`locations\\[${oldIndex}\\]\\[(rencana|realisasi)\\]`, 'g');
                            onclick = onclick.replace(regex, `locations[${newIndex}][$1]`);
                            input.setAttribute('onclick', onclick);
                        }
                    });
                }
            });
            locationIndex = locationItems.length;
        };

        // Fungsi untuk update status tombol dan tampilkan pesan
        const updateAddButtonState = () => {
            const currentCount = locationsContainer.querySelectorAll('.location-item').length;
            
            if (currentCount >= MAX_LOCATIONS) {
                addLocationBtn.disabled = true;
                addLocationBtn.classList.add('opacity-50', 'cursor-not-allowed');
                addLocationBtn.classList.remove('hover:bg-green-700');
                
                // Tambahkan pesan jika belum ada
                if (!document.getElementById('max-location-message')) {
                    const message = document.createElement('p');
                    message.id = 'max-location-message';
                    message.className = 'text-sm text-red-600 mt-2 font-medium';
                    message.textContent = `Maksimal ${MAX_LOCATIONS} lokasi telah tercapai`;
                    addLocationBtn.parentElement.appendChild(message);
                }
            } else {
                addLocationBtn.disabled = false;
                addLocationBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                addLocationBtn.classList.add('hover:bg-green-700');
                
                // Hapus pesan jika ada
                const message = document.getElementById('max-location-message');
                if (message) {
                    message.remove();
                }
            }
            
            // Update info counter
            updateLocationCounter(currentCount);
        };

        // Fungsi untuk menampilkan counter lokasi
        const updateLocationCounter = (count) => {
            let counter = document.getElementById('location-counter');
            if (!counter) {
                counter = document.createElement('span');
                counter.id = 'location-counter';
                counter.className = 'text-sm text-gray-600 ml-3';
                addLocationBtn.parentElement.appendChild(counter);
            }
            counter.textContent = `(${count}/${MAX_LOCATIONS} lokasi)`;
        };

        const locationTemplate = (index) => {
            const displayNum = index + 1;
            const isPermanent = index === 0;
            const rencanaName = `locations[${index}][rencana]`;
            const realisasiName = `locations[${index}][realisasi]`;
            const colorClassRencana = 'indigo';
            const colorClassRealisasi = 'green';
            
            return `
                <div class="location-item border p-4 rounded-lg shadow-sm bg-gray-50 grid grid-cols-1 gap-4" data-index="${index}" data-permanent="${isPermanent}">
                    <div class="col-span-1 flex justify-between items-center mb-2">
                        <h4 class="location-title font-semibold text-gray-700">Lokasi #${displayNum}</h4>
                        <input type="hidden" name="locations[${index}][id]" value="">
                        ${isPermanent ? 
                            `<span></span>` : 
                            `<button type="button" class="remove-location-btn text-red-500 hover:text-red-700 transition-colors duration-200" data-index="${index}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>`
                        }
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-1 flex flex-col gap-4"> 
                            <div>
                                <label for="locations[${index}][nama]" class="block font-medium text-sm text-gray-700">Nama Lokasi</label>
                                <input id="locations[${index}][nama]" name="locations[${index}][nama]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                            </div>
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Tanggal Rencana</label>
                                <div class="grid grid-cols-6 gap-2 p-3 border border-indigo-200 rounded-md bg-white overflow-y-auto max-h-40"> 
                                    <div class="col-span-6 flex items-center justify-center p-1 border border-indigo-500 rounded-sm w-full h-8 bg-indigo-100 hover:bg-indigo-200 transition duration-150">
                                        <input id="${rencanaName}_all" type="checkbox" 
                                            class="focus:ring-${colorClassRencana}-500 h-4 w-4 text-${colorClassRencana}-600 border-${colorClassRencana}-300 rounded" 
                                            onclick="handleAllToggle(this, '${rencanaName}')">
                                        <label for="${rencanaName}_all" class="text-xs font-semibold text-indigo-700 ml-1 select-none">PILIH SEMUA</label>
                                    </div>
                                    
                                    ${generateDateCheckboxes(`${rencanaName}`, true)}
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-1 flex flex-col gap-4">
                            <div>
                                <label for="locations[${index}][petugas_nama]" class="block font-medium text-sm text-gray-700">Petugas Pelaksana</label>
                                <input id="locations[${index}][petugas_nama]" name="locations[${index}][petugas_nama]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                            </div>
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Tanggal Realisasi</label>
                                <div class="grid grid-cols-6 gap-2 p-3 border border-green-200 rounded-md bg-white overflow-y-auto max-h-40"> 
                                    <div class="col-span-6 flex items-center justify-center p-1 border border-green-500 rounded-sm w-full h-8 bg-green-100 hover:bg-green-200 transition duration-150">
                                        <input id="${realisasiName}_all" type="checkbox" 
                                            class="focus:ring-${colorClassRealisasi}-500 h-4 w-4 text-${colorClassRealisasi}-600 border-${colorClassRealisasi}-300 rounded" 
                                            onclick="handleAllToggle(this, '${realisasiName}')">
                                        <label for="${realisasiName}_all" class="text-xs font-semibold text-green-700 ml-1 select-none">PILIH SEMUA</label>
                                    </div>

                                    ${generateDateCheckboxes(`${realisasiName}`, false)}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };
        
        function addLocation() {
            const currentCount = locationsContainer.querySelectorAll('.location-item').length;
            
            // Cek apakah sudah mencapai batas maksimal
            if (currentCount >= MAX_LOCATIONS) {
                alert(`Maksimal ${MAX_LOCATIONS} lokasi. Tidak dapat menambah lokasi lagi.`);
                return;
            }
            
            const newIndex = locationIndex;
            const newLocation = document.createElement('div');
            newLocation.innerHTML = locationTemplate(newIndex).trim();
            locationsContainer.appendChild(newLocation.firstChild);
            
            locationIndex++;
            reindexLocations();
            updateAddButtonState(); // Update status tombol setelah menambah
        }

        addLocationBtn.addEventListener('click', addLocation);
        
        locationsContainer.addEventListener('click', function(e) {
            const button = e.target.closest('.remove-location-btn');
            if (button) {
                const item = button.closest('.location-item');
                if (item && item.getAttribute('data-permanent') !== 'true') {
                    item.remove();
                    reindexLocations();
                    updateAddButtonState(); // Update status tombol setelah menghapus
                }
            }
        });

        reindexLocations();

        document.addEventListener('DOMContentLoaded', () => {
            updateAddButtonState(); // Cek status awal
            
            locationsContainer.querySelectorAll('.location-item').forEach(item => {
                const index = item.getAttribute('data-index');
                if (index !== null) {
                    const rencanaName = `locations[${index}][rencana]`;
                    const realisasiName = `locations[${index}][realisasi]`;
                    
                    const rencanaCheckboxes = item.querySelectorAll(`input[name="${rencanaName}[]"]`);
                    const realisasiCheckboxes = item.querySelectorAll(`input[name="${realisasiName}[]"]`);

                    const rencanaAll = item.querySelector(`input[id="${rencanaName}_all"]`);
                    const realisasiAll = item.querySelector(`input[id="${realisasiName}_all"]`);

                    if (rencanaAll && rencanaCheckboxes.length > 0) {
                        const checkedRencana = Array.from(rencanaCheckboxes).filter(cb => cb.checked).length;
                        rencanaAll.checked = checkedRencana === rencanaCheckboxes.length;
                    }
                    if (realisasiAll && realisasiCheckboxes.length > 0) {
                        const checkedRealisasi = Array.from(realisasiCheckboxes).filter(cb => cb.checked).length;
                        realisasiAll.checked = checkedRealisasi === realisasiCheckboxes.length;
                    }
                }
            });
        });
    </script>
    
    <style>
        .w-8 { width: 2rem; }
        .h-8 { height: 2rem; }
        .rounded-sm { border-radius: 0.125rem; }

        .grid-cols-6 > div:not(.col-span-6) {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 2rem;
            padding: 0.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.125rem;
            transition: background-color 0.15s;
        }
    </style>
</x-app-layout>
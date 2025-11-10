<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Formulir Tindak Lanjut Preventive Maintenance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tindak-lanjut.store') }}" method="POST">
                        @csrf

                        <!-- Berdasarkan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berdasarkan: <span class="text-red-500">*</span></label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" name="berdasarkan" id="permohonan_tindak_lanjut" value="permohonan_tindak_lanjut"
                                           class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('berdasarkan') == 'permohonan_tindak_lanjut' ? 'checked' : '' }}>
                                    <label for="permohonan_tindak_lanjut" class="ml-2 text-sm text-gray-700">Permohonan Tindak Lanjut Maintenance</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="berdasarkan" id="pelaksanaan_pm" value="pelaksanaan_pm"
                                           class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('berdasarkan') == 'pelaksanaan_pm' ? 'checked' : '' }}>
                                    <label for="pelaksanaan_pm" class="ml-2 text-sm text-gray-700">Pelaksanaan PM</label>
                                </div>
                            </div>
                            @error('berdasarkan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal & Jam -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('tanggal') }}">
                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">Jam <span class="text-red-500">*</span></label>
                                <input type="time" name="jam" id="jam" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('jam') }}">
                                @error('jam')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Lokasi & Ruang -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                                <input type="text" name="lokasi" id="lokasi" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('lokasi') }}">
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="ruang" class="block text-sm font-medium text-gray-700 mb-2">Ruang <span class="text-red-500">*</span></label>
                                <input type="text" name="ruang" id="ruang" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('ruang') }}">
                                @error('ruang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permasalahan -->
                        <div class="mb-4">
                            <label for="permasalahan" class="block text-sm font-medium text-gray-700 mb-2">Permasalahan yang terjadi <span class="text-red-500">*</span></label>
                            <textarea name="permasalahan" id="permasalahan" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('permasalahan') }}</textarea>
                            @error('permasalahan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tindakan Penyelesaian -->
                        <div class="mb-4">
                            <label for="tindakan_penyelesaian" class="block text-sm font-medium text-gray-700 mb-2">Tindakan penyelesaian masalah <span class="text-red-500">*</span></label>
                            <textarea name="tindakan_penyelesaian" id="tindakan_penyelesaian" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('tindakan_penyelesaian') }}</textarea>
                            @error('tindakan_penyelesaian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hasil Perbaikan -->
                        <div class="mb-4">
                            <label for="hasil_perbaikan" class="block text-sm font-medium text-gray-700 mb-2">Hasil perbaikan <span class="text-red-500">*</span></label>
                            <textarea name="hasil_perbaikan" id="hasil_perbaikan" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('hasil_perbaikan') }}</textarea>
                            @error('hasil_perbaikan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Penyelesaian -->
                        <div class="mb-6 border-t pt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Penyelesaian: <span class="text-red-500">*</span></label>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <input type="radio" name="status_penyelesaian" id="selesai" value="selesai"
                                           class="mt-1 border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('status_penyelesaian') == 'selesai' ? 'checked' : '' }}
                                           onchange="toggleStatusPenyelesaian(this.value)">
                                    <div class="ml-3 flex-1">
                                        <label for="selesai" class="text-sm text-gray-700">Selesai</label>
                                        <div id="selesai-fields" class="mt-2 grid grid-cols-2 gap-3" style="display: {{ old('status_penyelesaian') == 'selesai' ? 'grid' : 'none' }};">
                                            <div>
                                                <label for="selesai_tanggal" class="block text-xs text-gray-600 mb-1">Tanggal</label>
                                                <input type="date" name="selesai_tanggal" id="selesai_tanggal"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                       value="{{ old('selesai_tanggal') }}">
                                                @error('selesai_tanggal')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="selesai_jam" class="block text-xs text-gray-600 mb-1">Jam</label>
                                                <input type="time" name="selesai_jam" id="selesai_jam"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                       value="{{ old('selesai_jam') }}">
                                                @error('selesai_jam')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <input type="radio" name="status_penyelesaian" id="tidak_selesai" value="tidak_selesai"
                                           class="mt-1 border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('status_penyelesaian') == 'tidak_selesai' ? 'checked' : '' }}
                                           onchange="toggleStatusPenyelesaian(this.value)">
                                    <div class="ml-3 flex-1">
                                        <label for="tidak_selesai" class="text-sm text-gray-700">Tidak selesai, Tindak lanjut</label>
                                        <div id="tidak-selesai-fields" class="mt-2" style="display: {{ old('status_penyelesaian') == 'tidak_selesai' ? 'block' : 'none' }};">
                                            <textarea name="tidak_lanjut" id="tidak_lanjut" rows="2"
                                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                      placeholder="Keterangan tindak lanjut...">{{ old('tidak_lanjut') }}</textarea>
                                            @error('tidak_lanjut')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('status_penyelesaian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pelaksana (Multiple) -->
                        <div class="mb-6 border-t pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm font-medium text-gray-700">Pelaksana <span class="text-red-500">*</span></h3>
                                <button type="button" onclick="addPelaksanaField()" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    <i data-lucide="user-plus" class="w-4 h-4 inline mr-1"></i> Tambah Pelaksana
                                </button>
                            </div>
                            <div id="pelaksana-container" class="space-y-3">
                                <div class="pelaksana-item border rounded-lg p-3 bg-gray-50">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-medium text-gray-700 text-sm">Pelaksana 1</h4>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                                            <input type="text" name="pelaksana[0][nama]" 
                                                   class="w-full rounded-md border-gray-300 shadow-sm text-sm" 
                                                   value="{{ old('pelaksana.0.nama') }}" 
                                                   required>
                                            @error('pelaksana.0.nama')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                                            <input type="text" name="pelaksana[0][department]" 
                                                   class="w-full rounded-md border-gray-300 shadow-sm text-sm" 
                                                   value="{{ old('pelaksana.0.department') }}" 
                                                   required>
                                            @error('pelaksana.0.department')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Sub Department</label>
                                            <input type="text" name="pelaksana[0][sub_department]" 
                                                   class="w-full rounded-md border-gray-300 shadow-sm text-sm" 
                                                   value="{{ old('pelaksana.0.sub_department') }}">
                                            @error('pelaksana.0.sub_department')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mengetahui -->
                        <div class="mb-6 border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Mengetahui <span class="text-red-500">*</span></h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="mengetahui_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                                    <input type="text" name="mengetahui_nama" id="mengetahui_nama" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('mengetahui_nama') }}">
                                    @error('mengetahui_nama')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="mengetahui_nik" class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                                    <input type="text" name="mengetahui_nik" id="mengetahui_nik"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('mengetahui_nik') }}">
                                    @error('mengetahui_nik')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                Simpan
                            </button>
                            <a href="{{ route('tindak-lanjut.index') }}" 
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
<script>
    let pelaksanaIndex = 1;

    // Function untuk toggle status penyelesaian (RADIO BUTTON)
    function toggleStatusPenyelesaian(value) {
        const selesaiFields = document.getElementById('selesai-fields');
        const tidakSelesaiFields = document.getElementById('tidak-selesai-fields');
        const selesaiTanggal = document.getElementById('selesai_tanggal');
        const selesaiJam = document.getElementById('selesai_jam');
        const tidakLanjut = document.getElementById('tidak_lanjut');
        
        if (value === 'selesai') {
            selesaiFields.style.display = 'grid';
            tidakSelesaiFields.style.display = 'none';
            // Set required attributes
            selesaiTanggal.setAttribute('required', 'required');
            selesaiJam.setAttribute('required', 'required');
            tidakLanjut.removeAttribute('required');
            // Clear tidak selesai value
            tidakLanjut.value = '';
        } else if (value === 'tidak_selesai') {
            selesaiFields.style.display = 'none';
            tidakSelesaiFields.style.display = 'block';
            // Set required attributes
            selesaiTanggal.removeAttribute('required');
            selesaiJam.removeAttribute('required');
            tidakLanjut.setAttribute('required', 'required');
            // Clear selesai values
            selesaiTanggal.value = '';
            selesaiJam.value = '';
        }
    }

    function addPelaksanaField() {
        const container = document.getElementById('pelaksana-container');
        const div = document.createElement('div');
        div.className = 'pelaksana-item border rounded-lg p-3 bg-gray-50';
        div.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-medium text-gray-700 text-sm">Pelaksana ${pelaksanaIndex + 1}</h4>
                <button type="button" onclick="removePelaksana(this)" 
                        class="text-red-500 hover:text-red-700">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="pelaksana[${pelaksanaIndex}][nama]" 
                           class="w-full rounded-md border-gray-300 shadow-sm text-sm" 
                           required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                    <input type="text" name="pelaksana[${pelaksanaIndex}][department]" 
                           class="w-full rounded-md border-gray-300 shadow-sm text-sm" 
                           required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sub Department</label>
                    <input type="text" name="pelaksana[${pelaksanaIndex}][sub_department]" 
                           class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
            </div>
        `;
        container.appendChild(div);
        pelaksanaIndex++;
        lucide.createIcons();
    }

    function removePelaksana(button) {
        const pelaksanaItems = document.querySelectorAll('#pelaksana-container > .pelaksana-item');
        if (pelaksanaItems.length > 1) {
            if (confirm('Hapus pelaksana ini?')) {
                button.closest('.pelaksana-item').remove();
                updatePelaksanaNumbers();
            }
        } else {
            alert('Minimal harus ada 1 pelaksana!');
        }
    }

    function updatePelaksanaNumbers() {
        const pelaksanaDivs = document.querySelectorAll('#pelaksana-container > .pelaksana-item');
        pelaksanaDivs.forEach((div, index) => {
            const header = div.querySelector('h4');
            if (header) {
                header.textContent = `Pelaksana ${index + 1}`;
            }
            
            // Update remove button visibility
            const removeButton = div.querySelector('button[onclick^="removePelaksana"]');
            if (removeButton) {
                if (index === 0 && pelaksanaDivs.length === 1) {
                    removeButton.style.display = 'none';
                } else {
                    removeButton.style.display = 'block';
                }
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Hide remove button for first pelaksana if only one exists
        updatePelaksanaNumbers();
    });
</script>
@endpush
</x-app-layout>
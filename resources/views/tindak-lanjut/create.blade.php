<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($tindakLanjut) ? 'Edit' : 'Tambah' }} Formulir Tindak Lanjut Preventive Maintenance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($tindakLanjut) ? route('tindak-lanjut.update', $tindakLanjut) : route('tindak-lanjut.store') }}" method="POST">
                        @csrf
                        @if(isset($tindakLanjut))
                            @method('PUT')
                        @endif

                        <!-- Berdasarkan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berdasarkan:</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="permohonan_tindak_lanjut" id="permohonan_tindak_lanjut" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('permohonan_tindak_lanjut', $tindakLanjut->permohonan_tindak_lanjut ?? false) ? 'checked' : '' }}>
                                    <label for="permohonan_tindak_lanjut" class="ml-2 text-sm text-gray-700">Permohonan Tindak Lanjut Maintenance</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="pelaksanaan_pm" id="pelaksanaan_pm" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('pelaksanaan_pm', $tindakLanjut->pelaksanaan_pm ?? false) ? 'checked' : '' }}>
                                    <label for="pelaksanaan_pm" class="ml-2 text-sm text-gray-700">Pelaksanaan PM</label>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal & Jam -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('tanggal', $tindakLanjut->tanggal ?? '') }}">
                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">Jam <span class="text-red-500">*</span></label>
                                <input type="time" name="jam" id="jam" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('jam', $tindakLanjut->jam ?? '') }}">
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
                                       value="{{ old('lokasi', $tindakLanjut->lokasi ?? '') }}">
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="ruang" class="block text-sm font-medium text-gray-700 mb-2">Ruang <span class="text-red-500">*</span></label>
                                <input type="text" name="ruang" id="ruang" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('ruang', $tindakLanjut->ruang ?? '') }}">
                                @error('ruang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permasalahan -->
                        <div class="mb-4">
                            <label for="permasalahan" class="block text-sm font-medium text-gray-700 mb-2">Permasalahan yang terjadi <span class="text-red-500">*</span></label>
                            <textarea name="permasalahan" id="permasalahan" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('permasalahan', $tindakLanjut->permasalahan ?? '') }}</textarea>
                            @error('permasalahan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tindakan Penyelesaian -->
                        <div class="mb-4">
                            <label for="tindakan_penyelesaian" class="block text-sm font-medium text-gray-700 mb-2">Tindakan penyelesaian masalah <span class="text-red-500">*</span></label>
                            <textarea name="tindakan_penyelesaian" id="tindakan_penyelesaian" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('tindakan_penyelesaian', $tindakLanjut->tindakan_penyelesaian ?? '') }}</textarea>
                            @error('tindakan_penyelesaian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hasil Perbaikan -->
                        <div class="mb-4">
                            <label for="hasil_perbaikan" class="block text-sm font-medium text-gray-700 mb-2">Hasil perbaikan <span class="text-red-500">*</span></label>
                            <textarea name="hasil_perbaikan" id="hasil_perbaikan" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('hasil_perbaikan', $tindakLanjut->hasil_perbaikan ?? '') }}</textarea>
                            @error('hasil_perbaikan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Penyelesaian -->
                        <div class="mb-6 border-t pt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Penyelesaian:</label>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <input type="checkbox" name="selesai" id="selesai" 
                                           class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('selesai', $tindakLanjut->selesai ?? false) ? 'checked' : '' }}
                                           onchange="toggleSelesai(this)">
                                    <div class="ml-3 flex-1">
                                        <label for="selesai" class="text-sm text-gray-700">Selesai</label>
                                        <div id="selesai-fields" class="mt-2 grid grid-cols-2 gap-3" style="display: {{ old('selesai', $tindakLanjut->selesai ?? false) ? 'grid' : 'none' }};">
                                            <div>
                                                <label for="selesai_tanggal" class="block text-xs text-gray-600 mb-1">Tanggal</label>
                                                <input type="date" name="selesai_tanggal" id="selesai_tanggal"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                       value="{{ old('selesai_tanggal', isset($tindakLanjut) && $tindakLanjut->selesai_tanggal ? $tindakLanjut->selesai_tanggal->format('Y-m-d') : '') }}">
                                            </div>
                                            <div>
                                                <label for="selesai_jam" class="block text-xs text-gray-600 mb-1">Jam</label>
                                                <input type="time" name="selesai_jam" id="selesai_jam"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                       value="{{ old('selesai_jam', $tindakLanjut->selesai_jam ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="tidak_selesai" id="tidak_selesai" 
                                           class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ old('tidak_selesai', $tindakLanjut->tidak_selesai ?? false) ? 'checked' : '' }}
                                           onchange="toggleTidakSelesai(this)">
                                    <div class="ml-3 flex-1">
                                        <label for="tidak_selesai" class="text-sm text-gray-700">Tidak selesai, Tindak lanjut</label>
                                        <div id="tidak-selesai-fields" class="mt-2" style="display: {{ old('tidak_selesai', $tindakLanjut->tidak_selesai ?? false) ? 'block' : 'none' }};">
                                            <textarea name="tidak_lanjut" id="tidak_lanjut" rows="2"
                                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                      placeholder="Keterangan tindak lanjut...">{{ old('tidak_lanjut', $tindakLanjut->tidak_lanjut ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Department -->
                        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department <span class="text-red-500">*</span></label>
                                <input type="text" name="department" id="department" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('department', $tindakLanjut->department ?? '') }}">
                                @error('department')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="sub_department" class="block text-sm font-medium text-gray-700 mb-2">Sub Department</label>
                                <input type="text" name="sub_department" id="sub_department"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ old('sub_department', $tindakLanjut->sub_department ?? '') }}">
                                @error('sub_department')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div> --}}

                        <!-- Pelaksana -->
                        <div class="mb-6 border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Pelaksana</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="pelaksana_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                                    <input type="text" name="pelaksana_nama" id="pelaksana_nama" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('pelaksana_nama', isset($tindakLanjut) && $tindakLanjut->pelaksana ? $tindakLanjut->pelaksana['nama'] : '') }}">
                                    @error('pelaksana_nama')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="pelaksana_department" class="block text-sm font-medium text-gray-700 mb-2">Department <span class="text-red-500">*</span></label>
                                    <input type="text" name="pelaksana_department" id="pelaksana_department" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('pelaksana_department', isset($tindakLanjut) && $tindakLanjut->pelaksana ? $tindakLanjut->pelaksana['department'] : '') }}">
                                    @error('pelaksana_department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="pelaksana_sub_department" class="block text-sm font-medium text-gray-700 mb-2">Sub Department</label>
                                    <input type="text" name="pelaksana_sub_department" id="pelaksana_sub_department"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('pelaksana_sub_department', isset($tindakLanjut) && $tindakLanjut->pelaksana ? ($tindakLanjut->pelaksana['sub_department'] ?? '') : '') }}">
                                    @error('pelaksana_sub_department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Mengetahui -->
                        <div class="mb-6 border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Mengetahui</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="mengetahui_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                                    <input type="text" name="mengetahui_nama" id="mengetahui_nama" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('mengetahui_nama', isset($tindakLanjut) && $tindakLanjut->mengetahui ? $tindakLanjut->mengetahui['nama'] : '') }}">
                                    @error('mengetahui_nama')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="mengetahui_nik" class="block text-sm font-medium text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
                                    <input type="text" name="mengetahui_nik" id="mengetahui_nik" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           value="{{ old('mengetahui_nik', isset($tindakLanjut) && $tindakLanjut->mengetahui ? $tindakLanjut->mengetahui['nik'] : '') }}">
                                    @error('mengetahui_nik')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('tindak-lanjut.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($tindakLanjut) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSelesai(checkbox) {
            const fields = document.getElementById('selesai-fields');
            fields.style.display = checkbox.checked ? 'grid' : 'none';
        }

        function toggleTidakSelesai(checkbox) {
            const fields = document.getElementById('tidak-selesai-fields');
            fields.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
</x-app-layout>
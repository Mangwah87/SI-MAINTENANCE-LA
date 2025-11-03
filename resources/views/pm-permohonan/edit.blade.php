<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Permohonan Tindak Lanjut PM') }}
            </h2>
            <a href="{{ route('pm-permohonan.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pm-permohonan.update', $pmPermohonan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Tanggal dan Jam -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal" 
                                       id="tanggal" 
                                       value="{{ old('tanggal', $pmPermohonan->tanggal->format('Y-m-d')) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal') border-red-500 @enderror"
                                       required>
                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam <span class="text-red-500">*</span>
                                </label>
                                <input type="time" 
                                       name="jam" 
                                       id="jam" 
                                       value="{{ old('jam', $pmPermohonan->jam) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jam') border-red-500 @enderror"
                                       required>
                                @error('jam')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Lokasi dan Ruang -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="lokasi" 
                                       id="lokasi" 
                                       value="{{ old('lokasi', $pmPermohonan->lokasi) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('lokasi') border-red-500 @enderror"
                                       required>
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ruang" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ruang <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="ruang" 
                                       id="ruang" 
                                       value="{{ old('ruang', $pmPermohonan->ruang) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('ruang') border-red-500 @enderror"
                                       required>
                                @error('ruang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permasalahan -->
                        <div>
                            <label for="permasalahan" class="block text-sm font-medium text-gray-700 mb-2">
                                Permasalahan yang terjadi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="permasalahan" 
                                      id="permasalahan" 
                                      rows="4"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('permasalahan') border-red-500 @enderror"
                                      required>{{ old('permasalahan', $pmPermohonan->permasalahan) }}</textarea>
                            @error('permasalahan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Usulan Tindak Lanjut -->
                        <div>
                            <label for="usulan_tindak_lanjut" class="block text-sm font-medium text-gray-700 mb-2">
                                Usulan tindak lanjut <span class="text-red-500">*</span>
                            </label>
                            <textarea name="usulan_tindak_lanjut" 
                                      id="usulan_tindak_lanjut" 
                                      rows="4"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('usulan_tindak_lanjut') border-red-500 @enderror"
                                      required>{{ old('usulan_tindak_lanjut', $pmPermohonan->usulan_tindak_lanjut) }}</textarea>
                            @error('usulan_tindak_lanjut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pemohon Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pemohon</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama
                                    </label>
                                    <input type="text" 
                                            name="nama"
                                            id="nama"
                                           value="{{ $pmPermohonan->nama }}"
                                           class="w-full rounded-md border-gray-300  shadow-sm"
                                           required>
                                </div>

                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                                        Department <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="department" 
                                           id="department" 
                                           value="{{ old('department', $pmPermohonan->department) }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('department') border-red-500 @enderror"
                                           required>
                                    @error('department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="sub_department" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sub Department
                                </label>
                                <input type="text" 
                                       name="sub_department" 
                                       id="sub_department" 
                                       value="{{ old('sub_department', $pmPermohonan->sub_department) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Ditujukan kepada Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ditujukan kepada</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Department
                                    </label>
                                    <input type="text"
                                            name="ditujukan_department" 
                                            id="ditujukan_department"
                                           value="{{ old('ditujukan_department',$pmPermohonan->ditujukan_department) }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm"
                                           required>
                                </div>

                                <div>
                                    <label for="ditujukan_sub_department" class="block text-sm font-medium text-gray-700 mb-2">
                                        Sub Department
                                    </label>
                                    <input type="text" 
                                           name="ditujukan_sub_department" 
                                           id="ditujukan_sub_department" 
                                           value="{{ old('ditujukan_sub_department', $pmPermohonan->ditujukan_sub_department) }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Diinformasikan melalui -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Diinformasikan melalui <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="diinformasikan_melalui" 
                                           value="email" 
                                           {{ old('diinformasikan_melalui', $pmPermohonan->diinformasikan_melalui) == 'email' ? 'checked' : '' }}
                                           class="rounded-full border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Email</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="diinformasikan_melalui" 
                                           value="fax" 
                                           {{ old('diinformasikan_melalui', $pmPermohonan->diinformasikan_melalui) == 'fax' ? 'checked' : '' }}
                                           class="rounded-full border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Fax</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="diinformasikan_melalui" 
                                           value="hardcopy" 
                                           {{ old('diinformasikan_melalui', $pmPermohonan->diinformasikan_melalui) == 'hardcopy' ? 'checked' : '' }}
                                           class="rounded-full border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Hardcopy</span>
                                </label>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan
                            </label>
                            <textarea name="catatan" 
                                      id="catatan" 
                                      rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan', $pmPermohonan->catatan) }}</textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                Update Permohonan
                            </button>
                            <a href="{{ route('pm-permohonan.index') }}" 
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
</x-app-layout>
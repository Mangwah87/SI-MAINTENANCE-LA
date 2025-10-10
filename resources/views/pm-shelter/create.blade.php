<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Data Preventive Maintenance Ruang Shelter') }}
            </h2>
            <a href="{{ route('pm-shelter.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pm-shelter.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Informasi Umum -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-blue-900">Informasi Umum</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                                    <input type="text" name="location" value="{{ old('location') }}" required 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date / Time *</label>
                                    <input type="datetime-local" name="date_time" value="{{ old('date_time') }}" required 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('date_time') border-red-500 @enderror">
                                    @error('date_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand / Type *</label>
                                    <input type="text" name="brand_type" value="{{ old('brand_type') }}" required 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number *</label>
                                    <input type="text" name="reg_number" value="{{ old('reg_number') }}" required 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">S/N *</label>
                                    <input type="text" name="serial_number" value="{{ old('serial_number') }}" required 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- 1. Visual Check -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-purple-900">1. Visual Check</h3>

                            <!-- Kondisi Ruangan -->
                            <div class="mb-4 bg-white p-4 rounded border border-purple-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">a. Kondisi Ruangan</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Bersih, tidak bocor, tidak kotor</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="kondisi_ruangan_result" value="{{ old('kondisi_ruangan_result') }}" 
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="kondisi_ruangan_status" value="ok" {{ old('kondisi_ruangan_status') == 'ok' ? 'checked' : '' }} 
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium">OK</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="kondisi_ruangan_status" value="nok" {{ old('kondisi_ruangan_status') == 'nok' ? 'checked' : '' }} 
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm font-medium">NOK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Kondisi Kunci -->
                            <div class="mb-4 bg-white p-4 rounded border border-purple-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">b. Kondisi Kunci Ruang/Shelter</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Kuat, Mudah dibuka</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="kondisi_kunci_result" value="{{ old('kondisi_kunci_result') }}" 
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="kondisi_kunci_status" value="ok" {{ old('kondisi_kunci_status') == 'ok' ? 'checked' : '' }} 
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium">OK</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="kondisi_kunci_status" value="nok" {{ old('kondisi_kunci_status') == 'nok' ? 'checked' : '' }} 
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm font-medium">NOK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Fasilitas Ruangan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-green-900">2. Fasilitas Ruangan</h3>

                            <!-- Layout -->
                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">a. Layout / Tata Ruang</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Sesuai fungsi, kemudahan perawatan, kenyamanan penggunaan, keindahan</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="layout_result" value="{{ old('layout_result') }}" 
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="layout_status" value="ok" {{ old('layout_status') == 'ok' ? 'checked' : '' }} 
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium">OK</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="layout_status" value="nok" {{ old('layout_status') == 'nok' ? 'checked' : '' }} 
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm font-medium">NOK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontrol Keamanan -->
                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">b. Kontrol Keamanan</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Aman dan Termonitor</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="kontrol_keamanan_result" value="{{ old('kontrol_keamanan_result') }}" 
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="kontrol_keamanan_status" value="ok" {{ old('kontrol_keamanan_status') == 'ok' ? 'checked' : '' }} 
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium">OK</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="kontrol_keamanan_status" value="nok" {{ old('kontrol_keamanan_status') == 'nok' ? 'checked' : '' }} 
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm font-medium">NOK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Aksesibilitas -->
                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">c. Aksesibilitas</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Alur pergerakan mudah, aman, dan akses ke perangkat lancar</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="aksesibilitas_result" value="{{ old('aksesibilitas_result') }}" 
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="aksesibilitas_status" value="ok" {{ old('aksesibilitas_status') == 'ok' ? 'checked' : '' }} 
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium">OK</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="aksesibilitas_status" value="nok" {{ old('aksesibilitas_status') == 'nok' ? 'checked' : '' }} 
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm font-medium">NOK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Aspek Teknis -->
                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">d. Aspek Teknis</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Power, grounding, AC, pencahayaan, Fire Protection, dll</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="aspek_teknis_result" value="{{ old('aspek_teknis_result') }}" 
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="aspek_teknis_status" value="ok" {{ old('aspek_teknis_status') == 'ok' ? 'checked' : '' }} 
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium">OK</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="aspek_teknis_status" value="nok" {{ old('aspek_teknis_status') == 'nok' ? 'checked' : '' }} 
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm font-medium">NOK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes / Additional Informations</label>
                            <textarea name="notes" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Pelaksana -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-medium text-gray-700">Pelaksana * (Minimal 3)</label>
                                <button type="button" id="addPelaksana" class="bg-indigo-500 hover:bg-indigo-700 text-white text-sm font-bold py-1 px-3 rounded">
                                    + Tambah Pelaksana
                                </button>
                            </div>
                            <div id="pelaksanaContainer" class="space-y-3">
                                @for($i = 0; $i < 3; $i++)
                                <div class="pelaksana-item bg-white p-3 rounded border border-indigo-200">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                                        <input type="text" name="pelaksana[{{ $i }}][nama]" value="{{ old("pelaksana.{$i}.nama") }}" required 
                                            placeholder="Nama" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <input type="text" name="pelaksana[{{ $i }}][departemen]" value="{{ old("pelaksana.{$i}.departemen") }}" required 
                                            placeholder="Departemen" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <input type="text" name="pelaksana[{{ $i }}][sub_departemen]" value="{{ old("pelaksana.{$i}.sub_departemen") }}" required 
                                            placeholder="Sub Departemen" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="button" class="removePelaksana bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" style="display:none;">×</button>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            @error('pelaksana')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mengetahui -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mengetahui *</label>
                            <input type="text" name="mengetahui" value="{{ old('mengetahui') }}" required 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                            @error('mengetahui')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('pm-shelter.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('pelaksanaContainer');
            const addBtn = document.getElementById('addPelaksana');
            let pelaksanaCount = 3;

            addBtn.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'pelaksana-item bg-white p-3 rounded border border-indigo-200';
                newItem.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                        <input type="text" name="pelaksana[${pelaksanaCount}][nama]" required 
                            placeholder="Nama" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <input type="text" name="pelaksana[${pelaksanaCount}][departemen]" required 
                            placeholder="Departemen" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <input type="text" name="pelaksana[${pelaksanaCount}][sub_departemen]" required 
                            placeholder="Sub Departemen" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="button" class="removePelaksana bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">×</button>
                    </div>
                `;
                container.appendChild(newItem);
                pelaksanaCount++;
                updateButtons();
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('removePelaksana')) {
                    e.target.closest('.pelaksana-item').remove();
                    updateButtons();
                }
            });

            function updateButtons() {
                const items = container.querySelectorAll('.pelaksana-item');
                items.forEach(item => {
                    const removeBtn = item.querySelector('.removePelaksana');
                    if (removeBtn) {
                        removeBtn.style.display = (items.length > 3) ? 'block' : 'none';
                    }
                });
            }

            updateButtons();
        });
    </script>
    @endpush
</x-app-layout>
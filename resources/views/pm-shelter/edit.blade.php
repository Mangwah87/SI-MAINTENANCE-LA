<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Data Preventive Maintenance Ruang Shelter') }}
            </h2>
            <a href="{{ route('pm-shelter.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pm-shelter.update', $shelter) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Header Information -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-blue-900">Informasi Umum</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                                    <input type="text" name="location" value="{{ old('location', $shelter->location) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date / Time *</label>
                                    <input type="datetime-local" name="date_time" value="{{ old('date_time', $shelter->date_time->format('Y-m-d\TH:i')) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('date_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand / Type *</label>
                                    <input type="text" name="brand_type" value="{{ old('brand_type', $shelter->brand_type) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('brand_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reg. Number *</label>
                                    <input type="text" name="reg_number" value="{{ old('reg_number', $shelter->reg_number) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('reg_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">S/N *</label>
                                    <input type="text" name="serial_number" value="{{ old('serial_number', $shelter->serial_number) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('serial_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Visual Check Section -->
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-purple-900">1. Visual Check</h3>
                            
                            <div class="mb-4 bg-white p-4 rounded border border-purple-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">a. Kondisi Ruangan</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Bersih, tidak bocor, tidak kotor</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="kondisi_ruangan_result" value="{{ old('kondisi_ruangan_result', $shelter->kondisi_ruangan_result) }}"
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="kondisi_ruangan_status" value="1" {{ old('kondisi_ruangan_status', $shelter->kondisi_ruangan_status) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium text-gray-700">OK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 bg-white p-4 rounded border border-purple-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">b. Kondisi Kunci Ruang/Shelter</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Kuat, Mudah dibuka</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="kondisi_kunci_result" value="{{ old('kondisi_kunci_result', $shelter->kondisi_kunci_result) }}"
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="kondisi_kunci_status" value="1" {{ old('kondisi_kunci_status', $shelter->kondisi_kunci_status) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium text-gray-700">OK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fasilitas Ruangan Section -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-green-900">2. Fasilitas Ruangan</h3>
                            
                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">a. Layout / Tata Ruang</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Sesuai fungsi, kemudahan perawatan, kenyamanan penggunaan, keindahan</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="layout_result" value="{{ old('layout_result', $shelter->layout_result) }}"
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="layout_status" value="1" {{ old('layout_status', $shelter->layout_status) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium text-gray-700">OK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">b. Kontrol Keamanan</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Aman, dan Termonitor</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="kontrol_keamanan_result" value="{{ old('kontrol_keamanan_result', $shelter->kontrol_keamanan_result) }}"
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="kontrol_keamanan_status" value="1" {{ old('kontrol_keamanan_status', $shelter->kontrol_keamanan_status) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium text-gray-700">OK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">c. Aksesibilitas</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Alur pergerakan orang mudah dan tidak membahayakan, kemudahan akses ke perangkat</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="aksesibilitas_result" value="{{ old('aksesibilitas_result', $shelter->aksesibilitas_result) }}"
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="aksesibilitas_status" value="1" {{ old('aksesibilitas_status', $shelter->aksesibilitas_status) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium text-gray-700">OK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 bg-white p-4 rounded border border-green-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">d. Aspek Teknis</label>
                                <div class="text-xs text-gray-500 mb-2">Standar: Tersedia power, penangkal petir, grounding, pencahayaan, AC, Fire Protection, dan Termonitor</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="aspek_teknis_result" value="{{ old('aspek_teknis_result', $shelter->aspek_teknis_result) }}"
                                            placeholder="Result" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    </div>
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="aspek_teknis_status" value="1" {{ old('aspek_teknis_status', $shelter->aspek_teknis_status) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-sm font-medium text-gray-700">OK</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes / Additional Informations</label>
                            <textarea name="notes" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">{{ old('notes', $shelter->notes) }}</textarea>
                        </div>

                        <!-- Pelaksana Section -->
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-medium text-gray-700">Pelaksana *</label>
                                <button type="button" id="addPelaksana" class="bg-indigo-500 hover:bg-indigo-700 text-white text-sm font-bold py-1 px-3 rounded">
                                    + Tambah Pelaksana
                                </button>
                            </div>
                            <div id="pelaksanaContainer" class="space-y-2">
                                @foreach(old('pelaksana', $shelter->pelaksana ?? ['']) as $index => $pelaksana)
                                <div class="flex gap-2 pelaksana-item">
                                    <input type="text" name="pelaksana[]" value="{{ $pelaksana }}" required placeholder="Nama Pelaksana"
                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <button type="button" class="removePelaksana bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        ×
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @error('pelaksana')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mengetahui Section -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mengetahui *</label>
                            <input type="text" name="mengetahui" value="{{ old('mengetahui', $shelter->mengetahui) }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                            @error('mengetahui')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('pm-shelter.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addPelaksana').addEventListener('click', function() {
                const container = document.getElementById('pelaksanaContainer');
                const newItem = document.createElement('div');
                newItem.className = 'flex gap-2 pelaksana-item';
                newItem.innerHTML = `
                    <input type="text" name="pelaksana[]" required placeholder="Nama Pelaksana"
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="button" class="removePelaksana bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        ×
                    </button>
                `;
                container.appendChild(newItem);
                updateRemoveButtons();
            });

            document.getElementById('pelaksanaContainer').addEventListener('click', function(e) {
                if (e.target.classList.contains('removePelaksana')) {
                    e.target.closest('.pelaksana-item').remove();
                    updateRemoveButtons();
                }
            });

            function updateRemoveButtons() {
                const items = document.querySelectorAll('.pelaksana-item');
                items.forEach((item, index) => {
                    const removeBtn = item.querySelector('.removePelaksana');
                    if (items.length > 1) {
                        removeBtn.style.display = 'block';
                    } else {
                        removeBtn.style.display = 'none';
                    }
                });
            }

            updateRemoveButtons();
        });
    </script>
    @endpush
</x-app-layout>
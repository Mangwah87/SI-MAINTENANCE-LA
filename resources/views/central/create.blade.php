<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i data-lucide="building-2" class="w-6 h-6"></i>
            Tambah Sentral Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('central.store') }}">
                        @csrf

                        <!-- ID Sentral -->
                        <div class="mb-4">
                            <label for="id_sentral" class="block text-sm font-medium text-gray-700 mb-1">
                                ID Sentral <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="id_sentral" name="id_sentral" value="{{ old('id_sentral') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('id_sentral') border-red-500 @enderror"
                                placeholder="Contoh: JKT-001" required>
                            @error('id_sentral')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Format: KODE-NOMOR (contoh: JKT-001, BDG-002)</p>
                        </div>

                        <!-- Nama Sentral -->
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Sentral <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-500 @enderror"
                                placeholder="Contoh: Sentral Jakarta Pusat" required>
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Area -->
                        <div class="mb-6">
                            <label for="area" class="block text-sm font-medium text-gray-700 mb-1">
                                Area <span class="text-red-500">*</span>
                            </label>
                            <select id="area" name="area"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('area') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Area --</option>
                                <option value="BALI" {{ old('area') == 'BALI' ? 'selected' : '' }}>BALI</option>
                                <option value="NTT" {{ old('area') == 'NTT' ? 'selected' : '' }}>NTT</option>
                                <option value="NTB" {{ old('area') == 'NTB' ? 'selected' : '' }}>NTB</option>
                            </select>
                            @error('area')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Simpan
                            </button>

                            <a href="{{ route('central.index') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                                <i data-lucide="x" class="w-4 h-4"></i>
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
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        </script>
    @endpush
</x-app-layout>

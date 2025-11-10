<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Permohonan Tindak Lanjut PM
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
             <div class="mb-6 pb-4 border-b-2">
                <!-- Desktop Layout -->
                <div class="hidden sm:flex justify-between items-center">
                    <!-- Back Button -->
                    <a href="{{ route('pm-permohonan.index') }}" 
                       class="inline-flex items-center bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> 
                        Kembali
                    </a>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <!-- Edit Button -->
                        <a href="{{ route('pm-permohonan.edit', $permohonan) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i> 
                            Edit
                        </a>
                        
                        <!-- Print PDF Button -->
                        <a href="{{ route('pm-permohonan.pdf', $permohonan) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i> 
                            Cetak PDF
                        </a>
                    </div>
                </div>

                <!-- Mobile Layout -->
                <div class="flex sm:hidden justify-between items-center gap-2">
                    <!-- Back Button - Icon Only -->
                    <a href="{{ route('pm-permohonan.index') }}" 
                       class="inline-flex items-center justify-center w-10 h-10 bg-gray-500 text-white rounded-lg hover:bg-gray-700 transition"
                       title="Kembali">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 flex-1">
                        <!-- Edit Button -->
                        <a href="{{ route('pm-permohonan.edit', $permohonan) }}" 
                           class="inline-flex items-center justify-center flex-1 px-3 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm font-medium"
                           title="Edit">
                            <i data-lucide="edit" class="w-4 h-4 mr-1.5"></i> 
                            Edit
                        </a>
                        
                        <!-- Print PDF Button -->
                        <a href="{{ route('pm-permohonan.pdf', $permohonan) }}" target="_blank"
                           class="inline-flex items-center justify-center flex-1 px-3 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium"
                           title="Cetak PDF">
                            <i data-lucide="download" class="w-4 h-4 mr-1.5"></i> 
                            PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- Informasi Umum --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Umum</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-semibold">{{ $permohonan->tanggal->format('d/m/Y') }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Jam</p>
                        <p class="font-semibold">{{ $permohonan->jam }} WITA</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Lokasi</p>
                        <p class="font-semibold">{{ $permohonan->lokasi }}</p>~~
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Ruang</p>
                        <p class="font-semibold">{{ $permohonan->ruang }}</p>
                    </div>
                   
                </div>
            </div>

            {{-- Permasalahan --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Permasalahan yang Terjadi</h3>
                <div class="border p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap">{{ $permohonan->permasalahan }}</p>
                </div>
            </div>

            {{-- Usulan Tindak Lanjut --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Usulan Tindak Lanjut</h3>
                <div class="border p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap">{{ $permohonan->usulan_tindak_lanjut }}</p>
                </div>
            </div>

            {{-- Pemohon --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Data Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Nama Pemohon</p>
                        <p class="font-semibold">{{ $permohonan->nama }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Department</p>
                        <p class="font-semibold">{{ $permohonan->department }}</p>
                    </div>
                    @if($permohonan->sub_department)
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Sub Department</p>
                        <p class="font-semibold">{{ $permohonan->sub_department }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Ditujukan Kepada --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Ditujukan Kepada</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Department</p>
                        <p class="font-semibold">{{ $permohonan->ditujukan_department }}</p>
                    </div>
                    @if($permohonan->ditujukan_sub_department)
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Sub Department</p>
                        <p class="font-semibold">{{ $permohonan->ditujukan_sub_department }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Diinformasikan Melalui --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Diinformasikan Melalui</h3>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                        {{ $permohonan->diinformasikan_melalui == 'email' ? 'bg-blue-100 text-blue-800 border-2 border-blue-300' : 'bg-gray-100 text-gray-400' }}">
                        <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                        Email
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                        {{ $permohonan->diinformasikan_melalui == 'fax' ? 'bg-blue-100 text-blue-800 border-2 border-blue-300' : 'bg-gray-100 text-gray-400' }}">
                        <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                        Fax
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                        {{ $permohonan->diinformasikan_melalui == 'hardcopy' ? 'bg-blue-100 text-blue-800 border-2 border-blue-300' : 'bg-gray-100 text-gray-400' }}">
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        Hardcopy
                    </span>
                </div>
            </div>

            {{-- Catatan --}}
            @if($permohonan->catatan)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Catatan / Informasi Tambahan</h3>
                <div class="border p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap">{{ $permohonan->catatan }}</p>
                </div>
            </div>
            @endif

            
        </div>
    </div>

    @push('scripts')
    <script>
        lucide.createIcons();
    </script>
    @endpush
</x-app-layout>
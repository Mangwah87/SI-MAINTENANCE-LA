<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Formulir Tindak Lanjut Preventive Maintenance
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header Actions -->
            <div class="flex justify-end items-center mb-6 pb-4 border-b-2">
                <div class="flex gap-2">
                    <a href="{{ route('tindak-lanjut.pdf', $tindakLanjut) }}" 
                       class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        <i data-lucide="file-down" class="w-4 h-4 inline mr-1"></i> Download PDF
                    </a>
                    <a href="{{ route('tindak-lanjut.edit', $tindakLanjut) }}" 
                       class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        <i data-lucide="edit" class="w-4 h-4 inline mr-1"></i> Edit
                    </a>
                    <a href="{{ route('tindak-lanjut.index') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i data-lucide="arrow-left" class="w-4 h-4 inline mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Berdasarkan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Berdasarkan</h3>
                <div class="space-y-2">
                    <div class="flex items-center bg-gray-50 p-3 rounded border">
                        <div class="flex items-center justify-center w-6 h-6 mr-3">
                            @if($tindakLanjut->permohonan_tindak_lanjut)
                                <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i>
                            @else
                                <i data-lucide="square" class="w-5 h-5 text-gray-400"></i>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Permohonan Tindak Lanjut Maintenance</span>
                    </div>
                    <div class="flex items-center bg-gray-50 p-3 rounded border">
                        <div class="flex items-center justify-center w-6 h-6 mr-3">
                            @if($tindakLanjut->pelaksanaan_pm)
                                <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i>
                            @else
                                <i data-lucide="square" class="w-5 h-5 text-gray-400"></i>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Pelaksanaan PM</span>
                    </div>
                </div>
            </div>

            <!-- Pelaksanaan PM -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Pelaksanaan PM</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-semibold">{{ $tindakLanjut->tanggal->format('d/m/Y') }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Jam</p>
                        <p class="font-semibold">{{ $tindakLanjut->jam }} WITA</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Lokasi</p>
                        <p class="font-semibold">{{ $tindakLanjut->lokasi }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Ruang</p>
                        <p class="font-semibold">{{ $tindakLanjut->ruang }}</p>
                    </div>
                </div>
            </div>

            <!-- Permasalahan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Permasalahan yang Terjadi</h3>
                <div class="border p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap">{{ $tindakLanjut->permasalahan }}</p>
                </div>
            </div>

            <!-- Tindakan Penyelesaian -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Tindakan Penyelesaian Masalah</h3>
                <div class="border p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap">{{ $tindakLanjut->tindakan_penyelesaian }}</p>
                </div>
            </div>

            <!-- Hasil Perbaikan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Hasil Perbaikan</h3>
                <div class="border p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap">{{ $tindakLanjut->hasil_perbaikan }}</p>
                </div>

                <!-- Status -->
                <div class="mt-4 space-y-3">
                    <div class="flex items-start bg-gray-50 p-3 rounded border">
                        <div class="flex items-center justify-center w-6 h-6 mr-3 mt-0.5">
                            @if($tindakLanjut->selesai)
                                <i data-lucide="check-square" class="w-5 h-5 text-green-600"></i>
                            @else
                                <i data-lucide="square" class="w-5 h-5 text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <span class="text-sm font-medium">Selesai</span>
                            @if($tindakLanjut->selesai && $tindakLanjut->selesai_tanggal)
                                <div class="mt-1 text-sm text-gray-600">
                                    <span class="inline-block mr-4">
                                        <i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>
                                        {{ $tindakLanjut->selesai_tanggal->format('d/m/Y') }}
                                    </span>
                                    @if($tindakLanjut->selesai_jam)
                                        <span class="inline-block">
                                            <i data-lucide="clock" class="w-4 h-4 inline mr-1"></i>
                                            {{ $tindakLanjut->selesai_jam }} WITA
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-start bg-gray-50 p-3 rounded border">
                        <div class="flex items-center justify-center w-6 h-6 mr-3 mt-0.5">
                            @if($tindakLanjut->tidak_selesai)
                                <i data-lucide="check-square" class="w-5 h-5 text-orange-600"></i>
                            @else
                                <i data-lucide="square" class="w-5 h-5 text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <span class="text-sm font-medium">Tidak selesai, Tindak lanjut</span>
                            @if($tindakLanjut->tidak_selesai && $tindakLanjut->tidak_lanjut)
                                <div class="mt-2 bg-orange-50 p-3 rounded border border-orange-200">
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $tindakLanjut->tidak_lanjut }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelaksana & Mengetahui -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Pelaksana</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3 text-center">Pelaksana</h4>
                        <div class="border p-4 rounded bg-gray-50">
                            @if(is_array($tindakLanjut->pelaksana) && count($tindakLanjut->pelaksana) > 0)
                                @foreach($tindakLanjut->pelaksana as $index => $pelaksana)
                                    <div class="mb-3 pb-3 border-b last:border-0 last:mb-0 last:pb-0 text-center">
                                        <p class="font-medium text-gray-800">{{ $pelaksana['nama'] ?? '-' }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $pelaksana['department'] ?? '-' }}</p>
                                        @if(!empty($pelaksana['sub_department']))
                                            <p class="text-sm text-gray-600">{{ $pelaksana['sub_department'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-400 text-center">Tidak ada pelaksana</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3 text-center">Mengetahui</h4>
                        <div class="border p-4 rounded bg-gray-50 text-center">
                            <p class="font-medium text-gray-800">{{ $tindakLanjut->mengetahui['nama'] ?? '-' }}</p>
                            <p class="text-sm text-gray-600 mt-1">NIK: {{ $tindakLanjut->mengetahui['nik'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        lucide.createIcons();
    </script>
    @endpush
</x-app-layout>
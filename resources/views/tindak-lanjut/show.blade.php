<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Formulir Tindak Lanjut Preventive Maintenance
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tindak-lanjut.pdf', $tindakLanjut) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i data-lucide="file-down" class="w-4 h-4 inline mr-2"></i>
                    Download PDF
                </a>
                <a href="{{ route('tindak-lanjut.edit', $tindakLanjut) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i data-lucide="edit" class="w-4 h-4 inline mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('tindak-lanjut.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i data-lucide="arrow-left" class="w-4 h-4 inline mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Document -->
                    <div class="border-b pb-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-600">No. Dok: FM-LAP-D2-SOP-003-005</p>
                                <p class="text-sm text-gray-600">Versi: 1.0</p>
                                <p class="text-sm text-gray-600">Label: Internal</p>
                            </div>
                            <div class="text-right">
                                <h3 class="text-lg font-bold">Formulir Tindak Lanjut</h3>
                                <h3 class="text-lg font-bold">Preventive Maintenance</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Berdasarkan -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Berdasarkan:</h4>
                        <div class="space-y-1 ml-4">
                            <div class="flex items-center">
                                <span class="text-lg mr-2">{{ $tindakLanjut->permohonan_tindak_lanjut ? '☑' : '☐' }}</span>
                                <span class="text-sm">Permohonan Tindak Lanjut Maintenance</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg mr-2">{{ $tindakLanjut->pelaksanaan_pm ? '☑' : '☐' }}</span>
                                <span class="text-sm">Pelaksanaan PM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pelaksanaan PM -->
                    <div class="mb-6 bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-700 mb-3">Pelaksanaan PM</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Tanggal:</span>
                                <p class="font-medium">{{ $tindakLanjut->tanggal->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Jam:</span>
                                <p class="font-medium">{{ $tindakLanjut->jam }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Lokasi:</span>
                                <p class="font-medium">{{ $tindakLanjut->lokasi }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Ruang:</span>
                                <p class="font-medium">{{ $tindakLanjut->ruang }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Permasalahan -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Permasalahan yang terjadi:</h4>
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="text-sm whitespace-pre-wrap">{{ $tindakLanjut->permasalahan }}</p>
                        </div>
                    </div>

                    <!-- Tindakan Penyelesaian -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Tindakan penyelesaian masalah:</h4>
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="text-sm whitespace-pre-wrap">{{ $tindakLanjut->tindakan_penyelesaian }}</p>
                        </div>
                    </div>

                    <!-- Hasil Perbaikan -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Hasil perbaikan:</h4>
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="text-sm whitespace-pre-wrap">{{ $tindakLanjut->hasil_perbaikan }}</p>
                        </div>

                        <!-- Status -->
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center">
                                <span class="text-lg mr-2">{{ $tindakLanjut->selesai ? '☑' : '☐' }}</span>
                                <span class="text-sm">Selesai</span>
                                @if($tindakLanjut->selesai && $tindakLanjut->selesai_tanggal)
                                    <span class="ml-4 text-sm text-gray-600">
                                        Tanggal: {{ $tindakLanjut->selesai_tanggal->format('d/m/Y') }}
                                        @if($tindakLanjut->selesai_jam)
                                            Jam: {{ $tindakLanjut->selesai_jam }}
                                        @endif
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-start">
                                <span class="text-lg mr-2">{{ $tindakLanjut->tidak_selesai ? '☑' : '☐' }}</span>
                                <div class="flex-1">
                                    <span class="text-sm">Tidak selesai, Tindak lanjut</span>
                                    @if($tindakLanjut->tidak_selesai && $tindakLanjut->tidak_lanjut)
                                        <div class="mt-2 bg-yellow-50 p-3 rounded border border-yellow-200">
                                            <p class="text-sm">{{ $tindakLanjut->tidak_lanjut }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Department Info -->
                    <div class="mb-6 bg-blue-50 p-4 rounded">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Department:</span>
                                <p class="font-medium">{{ $tindakLanjut->department }}</p>
                            </div>
                            @if($tindakLanjut->sub_department)
                            <div>
                                <span class="text-sm text-gray-600">Sub Department:</span>
                                <p class="font-medium">{{ $tindakLanjut->sub_department }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pelaksana & Mengetahui -->
                    <div class="grid grid-cols-2 gap-6 border-t pt-6">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3 text-center">Pelaksana</h4>
                            <div class="bg-gray-50 p-4 rounded text-center">
                                <div class="h-20 flex items-center justify-center text-gray-400 mb-2">
                                    [Tanda Tangan]
                                </div>
                                <p class="font-medium">{{ $tindakLanjut->pelaksana['nama'] ?? '-' }}</p>
                                <p class="text-sm text-gray-600">{{ $tindakLanjut->pelaksana['department'] ?? '-' }}</p>
                                @if(isset($tindakLanjut->pelaksana['sub_department']))
                                    <p class="text-sm text-gray-600">{{ $tindakLanjut->pelaksana['sub_department'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3 text-center">Mengetahui</h4>
                            <div class="bg-gray-50 p-4 rounded text-center">
                                <div class="h-20 flex items-center justify-center text-gray-400 mb-2">
                                    [Tanda Tangan]
                                </div>
                                <p class="font-medium">{{ $tindakLanjut->mengetahui['nama'] ?? '-' }}</p>
                                <p class="text-sm text-gray-600">NIK: {{ $tindakLanjut->mengetahui['nik'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-4 border-t text-center text-xs text-gray-500">
                        <p>HakCipta PT. APLIKANUSA LINTASARTA, Indonesia</p>
                        <p class="mt-1">FM-LAP-D2-SOP-003-005 Formulir Tindak Lanjut Preventive Maintenance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
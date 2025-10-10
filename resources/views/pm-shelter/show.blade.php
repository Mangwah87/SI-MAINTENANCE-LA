<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Preventive Maintenance Ruang Shelter') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('pm-shelter.pdf', $shelter) }}" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Download PDF
                </a>
                <a href="{{ route('pm-shelter.edit', $shelter) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('pm-shelter.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Informasi Umum -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-blue-900">Informasi Umum</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <p class="mt-1 text-gray-900">{{ $shelter->location }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date / Time</label>
                                <p class="mt-1 text-gray-900">{{ $shelter->date_time->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Brand / Type</label>
                                <p class="mt-1 text-gray-900">{{ $shelter->brand_type }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Reg. Number</label>
                                <p class="mt-1 text-gray-900">{{ $shelter->reg_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">S/N</label>
                                <p class="mt-1 text-gray-900">{{ $shelter->serial_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Check -->
                    <div class="bg-purple-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-purple-900">1. Visual Check</h3>
                        
                        <div class="space-y-4">
                            <div class="bg-white p-4 rounded border border-purple-200">
                                <h4 class="font-semibold text-gray-700 mb-2">a. Kondisi Ruangan</h4>
                                <p class="text-xs text-gray-500 mb-2">Standar: Bersih, tidak bocor, tidak kotor</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-600">Result:</span>
                                        <span class="text-gray-900">{{ $shelter->kondisi_ruangan_result ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if($shelter->kondisi_ruangan_status)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">OK</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">NOK</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded border border-purple-200">
                                <h4 class="font-semibold text-gray-700 mb-2">b. Kondisi Kunci Ruang/Shelter</h4>
                                <p class="text-xs text-gray-500 mb-2">Standar: Kuat, Mudah dibuka</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-600">Result:</span>
                                        <span class="text-gray-900">{{ $shelter->kondisi_kunci_result ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if($shelter->kondisi_kunci_status)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">OK</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">NOK</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fasilitas Ruangan -->
                    <div class="bg-green-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-green-900">2. Fasilitas Ruangan</h3>
                        
                        <div class="space-y-4">
                            <div class="bg-white p-4 rounded border border-green-200">
                                <h4 class="font-semibold text-gray-700 mb-2">a. Layout / Tata Ruang</h4>
                                <p class="text-xs text-gray-500 mb-2">Standar: Sesuai fungsi, kemudahan perawatan, kenyamanan penggunaan, keindahan</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-600">Result:</span>
                                        <span class="text-gray-900">{{ $shelter->layout_result ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if($shelter->layout_status)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">OK</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">NOK</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded border border-green-200">
                                <h4 class="font-semibold text-gray-700 mb-2">b. Kontrol Keamanan</h4>
                                <p class="text-xs text-gray-500 mb-2">Standar: Aman, dan Termonitor</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-600">Result:</span>
                                        <span class="text-gray-900">{{ $shelter->kontrol_keamanan_result ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if($shelter->kontrol_keamanan_status)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">OK</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">NOK</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded border border-green-200">
                                <h4 class="font-semibold text-gray-700 mb-2">c. Aksesibilitas</h4>
                                <p class="text-xs text-gray-500 mb-2">Standar: Alur pergerakan orang mudah dan tidak membahayakan, kemudahan akses ke perangkat</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-600">Result:</span>
                                        <span class="text-gray-900">{{ $shelter->aksesibilitas_result ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if($shelter->aksesibilitas_status)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">OK</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">NOK</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded border border-green-200">
                                <h4 class="font-semibold text-gray-700 mb-2">d. Aspek Teknis</h4>
                                <p class="text-xs text-gray-500 mb-2">Standar: Tersedia power, penangkal petir, grounding, pencahayaan, AC, Fire Protection, dan Termonitor</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-600">Result:</span>
                                        <span class="text-gray-900">{{ $shelter->aspek_teknis_result ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if($shelter->aspek_teknis_status)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">OK</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">NOK</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-2 text-yellow-900">Notes / Additional Informations</h3>
                        <p class="text-gray-900">{{ $shelter->notes ?? '-' }}</p>
                    </div>

                    <!-- Pelaksana & Mengetahui -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-900">Pelaksana</h3>
                            @if($shelter->pelaksana && is_array($shelter->pelaksana))
                                <ol class="list-decimal list-inside space-y-1">
                                    @foreach($shelter->pelaksana as $pelaksana)
                                        <li class="text-gray-900">{{ $pelaksana }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2 text-gray-900">Mengetahui</h3>
                            <p class="text-gray-900">{{ $shelter->mengetahui }}</p>
                        </div>
                    </div>

                    <!-- Created Info -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Created by: {{ $shelter->creator->name ?? 'Unknown' }} | 
                            {{ $shelter->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
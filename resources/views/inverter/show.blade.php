<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Preventive Maintenance Inverter') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <!-- Header Actions -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Informasi Preventive Maintenance</h3>
                        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                            <a href="{{ route('inverter.index') }}"
                               class="flex-1 sm:flex-none px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg shadow text-center">
                                ← Kembali
                            </a>
                            <a href="{{ route('inverter.edit', $inverter->id) }}"
                               class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow text-center">
                                ✏️ Edit
                            </a>
                            <a href="{{ route('inverter.pdf', $inverter->id) }}"
                               class="flex-1 sm:flex-none px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow text-center">
                                🖨️ Print
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Umum -->
                    <div class="mb-6 sm:mb-8">
                        <h4 class="text-base sm:text-md font-bold text-gray-700 border-b pb-2 mb-4">Informasi Umum</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Nomor Dokumen</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->nomor_dokumen ?? 'FM-LAP-D2-SOP-003-008' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Location</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->lokasi ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Tanggal</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->tanggal_dokumentasi ? \Carbon\Carbon::parse($inverter->tanggal_dokumentasi)->format('d M Y') : '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Waktu</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->waktu ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Brand / Type</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->brand ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Reg. Number</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->reg_num ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">S/N (Serial Number)</label>
                                <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inverter->serial_num ?? '-' }}</p>
                            </div>
                            @if($inverter->keterangan)
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg sm:col-span-2">
                                <label class="block text-xs sm:text-sm font-medium text-gray-600 mb-1">Notes / Additional Info</label>
                                <p class="text-sm sm:text-base text-gray-900">{{ $inverter->keterangan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Performance and Capacity Check -->
                    <div class="mb-6 sm:mb-8">
                        <h4 class="text-base sm:text-md font-bold text-gray-700 border-b pb-2 mb-4">Performance and Capacity Check</h4>

                        <!-- Desktop View - Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">No.</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Descriptions</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Result / Photo</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Operational Standard</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Visual Check Header -->
                                    <tr class="bg-blue-50">
                                        <td class="border border-gray-300 px-4 py-2 font-semibold">1.</td>
                                        <td class="border border-gray-300 px-4 py-2 font-semibold" colspan="4">Visual Check</td>
                                    </tr>

                                    @foreach($inverter->data_checklist ?? [] as $index => $data)
                                        @if($index < 2)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">{{ chr(97 + $index) }}. {{ $data['nama'] ?? '-' }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p class="text-sm mb-2"><strong>Result:</strong> {{ $data['status'] ?? '-' }}</p>
                                                @if(isset($data['photos']) && count($data['photos']) > 0)
                                                    <div class="grid grid-cols-2 gap-2">
                                                        @foreach($data['photos'] as $photo)
                                                            <img src="{{ asset('storage/' . $photo['photo_path']) }}" alt="Photo" class="w-full h-auto rounded border">
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                                @if($index == 0) Clean, No dust
                                                @elseif($index == 1) Normal
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($data['tegangan'] ?? '') == 'OK' ? 'bg-green-100 text-green-800' : (($data['tegangan'] ?? '') == 'NOK' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $data['tegangan'] ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach

                                    <!-- Performance Check Header -->
                                    <tr class="bg-blue-50">
                                        <td class="border border-gray-300 px-4 py-2 font-semibold">2.</td>
                                        <td class="border border-gray-300 px-4 py-2 font-semibold" colspan="4">Performance and Capacity Check</td>
                                    </tr>

                                    @foreach($inverter->data_checklist ?? [] as $index => $data)
                                        @if($index >= 2)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2">{{ chr(97 + ($index - 2)) }}. {{ $data['nama'] ?? '-' }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if($index == 2)
                                                    <p class="text-sm mb-2"><strong>Value:</strong> {{ $inverter->dc_input_voltage ?? '-' }} VDC</p>
                                                @elseif($index == 3)
                                                    <p class="text-sm mb-2"><strong>Type:</strong> {{ $inverter->dc_current_inverter_type ?? '-' }} VA</p>
                                                    <p class="text-sm mb-2"><strong>Value:</strong> {{ $inverter->dc_current_input ?? '-' }} A</p>
                                                @elseif($index == 4)
                                                    <p class="text-sm mb-2"><strong>Type:</strong> {{ $inverter->ac_current_inverter_type ?? '-' }} VA</p>
                                                    <p class="text-sm mb-2"><strong>Value:</strong> {{ $inverter->ac_current_output ?? '-' }} A</p>
                                                @elseif($index == 5)
                                                    <p class="text-sm mb-2"><strong>Value:</strong> {{ $inverter->neutral_ground_output_voltage ?? '-' }} Volt AC</p>
                                                @elseif($index == 6)
                                                    <p class="text-sm mb-2"><strong>Value:</strong> {{ $inverter->equipment_temperature ?? '-' }} °C</p>
                                                @endif

                                                @if(isset($data['photos']) && count($data['photos']) > 0)
                                                    <div class="grid grid-cols-2 gap-2">
                                                        @foreach($data['photos'] as $photo)
                                                            <img src="{{ asset('storage/' . $photo['photo_path']) }}" alt="Photo" class="w-full h-auto rounded border">
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                                @if($index == 2) 48 - 54 VDC
                                                @elseif($index == 3) ≤ 9 A (500 VA)<br>≤ 18 A (1000 VA)
                                                @elseif($index == 4) ≤ 2 A (500 VA)<br>≤ 4 A (1000 VA)
                                                @elseif($index == 5) ≤ 1 Volt AC
                                                @elseif($index == 6) 0-35 °C
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($data['status'] ?? '') == 'OK' ? 'bg-green-100 text-green-800' : (($data['status'] ?? '') == 'NOK' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $data['status'] ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile View - Cards -->
                        <div class="lg:hidden space-y-4">
                            <!-- Visual Check Section -->
                            <div class="bg-blue-50 p-3 rounded-lg font-semibold">
                                1. Visual Check
                            </div>

                            @foreach($inverter->data_checklist ?? [] as $index => $data)
                                @if($index < 2)
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <h5 class="font-semibold text-sm mb-3">{{ chr(97 + $index) }}. {{ $data['nama'] ?? '-' }}</h5>

                                    <div class="space-y-2 text-sm">
                                        <div>
                                            <span class="text-gray-600">Result:</span>
                                            <span class="font-semibold ml-2">{{ $data['status'] ?? '-' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Standard:</span>
                                            <span class="ml-2">
                                                @if($index == 0) Clean, No dust
                                                @elseif($index == 1) Normal
                                                @endif
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Status:</span>
                                            <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold {{ ($data['tegangan'] ?? '') == 'OK' ? 'bg-green-100 text-green-800' : (($data['tegangan'] ?? '') == 'NOK' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $data['tegangan'] ?? '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(isset($data['photos']) && count($data['photos']) > 0)
                                        <div class="mt-3">
                                            <span class="text-xs text-gray-600 block mb-2">Photos:</span>
                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach($data['photos'] as $photo)
                                                    <img src="{{ asset('storage/' . $photo['photo_path']) }}" alt="Photo" class="w-full h-auto rounded border">
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @endif
                            @endforeach

                            <!-- Performance Check Section -->
                            <div class="bg-blue-50 p-3 rounded-lg font-semibold">
                                2. Performance and Capacity Check
                            </div>

                            @foreach($inverter->data_checklist ?? [] as $index => $data)
                                @if($index >= 2)
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <h5 class="font-semibold text-sm mb-3">{{ chr(97 + ($index - 2)) }}. {{ $data['nama'] ?? '-' }}</h5>

                                    <div class="space-y-2 text-sm">
                                        @if($index == 2)
                                            <div>
                                                <span class="text-gray-600">Value:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->dc_input_voltage ?? '-' }} VDC</span>
                                            </div>
                                        @elseif($index == 3)
                                            <div>
                                                <span class="text-gray-600">Type:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->dc_current_inverter_type ?? '-' }} VA</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Value:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->dc_current_input ?? '-' }} A</span>
                                            </div>
                                        @elseif($index == 4)
                                            <div>
                                                <span class="text-gray-600">Type:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->ac_current_inverter_type ?? '-' }} VA</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Value:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->ac_current_output ?? '-' }} A</span>
                                            </div>
                                        @elseif($index == 5)
                                            <div>
                                                <span class="text-gray-600">Value:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->neutral_ground_output_voltage ?? '-' }} Volt AC</span>
                                            </div>
                                        @elseif($index == 6)
                                            <div>
                                                <span class="text-gray-600">Value:</span>
                                                <span class="font-semibold ml-2">{{ $inverter->equipment_temperature ?? '-' }} °C</span>
                                            </div>
                                        @endif

                                        <div>
                                            <span class="text-gray-600">Standard:</span>
                                            <span class="ml-2">
                                                @if($index == 2) 48 - 54 VDC
                                                @elseif($index == 3) ≤ 9 A (500 VA) / ≤ 18 A (1000 VA)
                                                @elseif($index == 4) ≤ 2 A (500 VA) / ≤ 4 A (1000 VA)
                                                @elseif($index == 5) ≤ 1 Volt AC
                                                @elseif($index == 6) 0-35 °C
                                                @endif
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Status:</span>
                                            <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold {{ ($data['status'] ?? '') == 'OK' ? 'bg-green-100 text-green-800' : (($data['status'] ?? '') == 'NOK' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $data['status'] ?? '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(isset($data['photos']) && count($data['photos']) > 0)
                                        <div class="mt-3">
                                            <span class="text-xs text-gray-600 block mb-2">Photos:</span>
                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach($data['photos'] as $photo)
                                                    <img src="{{ asset('storage/' . $photo['photo_path']) }}" alt="Photo" class="w-full h-auto rounded border">
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Data Pelaksana -->
                    <div class="mb-6 sm:mb-8">
                        <h4 class="text-base sm:text-md font-bold text-gray-700 border-b pb-2 mb-4">Data Pelaksana</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Executor 1 -->
                            @if($inverter->executor_1)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        1
                                    </div>
                                    <h5 class="font-semibold text-sm text-gray-700">Pelaksana 1</h5>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 block text-xs">Nama:</span>
                                        <span class="font-semibold text-gray-900">{{ $inverter->executor_1 }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 block text-xs">Status:</span>
                                        <span class="text-gray-900">{{ $inverter->mitra_internal_1 ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Executor 2 -->
                            @if($inverter->executor_2)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        2
                                    </div>
                                    <h5 class="font-semibold text-sm text-gray-700">Pelaksana 2</h5>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 block text-xs">Nama:</span>
                                        <span class="font-semibold text-gray-900">{{ $inverter->executor_2 }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 block text-xs">Status:</span>
                                        <span class="text-gray-900">{{ $inverter->mitra_internal_2 ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Executor 3 -->
                            @if($inverter->executor_3)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        3
                                    </div>
                                    <h5 class="font-semibold text-sm text-gray-700">Pelaksana 3</h5>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 block text-xs">Nama:</span>
                                        <span class="font-semibold text-gray-900">{{ $inverter->executor_3 }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 block text-xs">Status:</span>
                                        <span class="text-gray-900">{{ $inverter->mitra_internal_3 ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Executor 4 -->
                            @if($inverter->executor_4)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        4
                                    </div>
                                    <h5 class="font-semibold text-sm text-gray-700">Pelaksana 4</h5>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 block text-xs">Nama:</span>
                                        <span class="font-semibold text-gray-900">{{ $inverter->executor_4 }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 block text-xs">Status:</span>
                                        <span class="text-gray-900">{{ $inverter->mitra_internal_4 ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Verifikator -->
                            @if($inverter->verifikator)
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        ✓
                                    </div>
                                    <h5 class="font-semibold text-sm text-gray-700">Verifikator</h5>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 block text-xs">Nama:</span>
                                        <span class="font-semibold text-gray-900">{{ $inverter->verifikator }}</span>
                                    </div>
                                    @if($inverter->verifikator_nik)
                                    <div>
                                        <span class="text-gray-600 block text-xs">NIK:</span>
                                        <span class="text-gray-900">{{ $inverter->verifikator_nik }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Head of Sub Department -->
                            @if($inverter->head_of_sub_department)
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-lg border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        H
                                    </div>
                                    <h5 class="font-semibold text-sm text-gray-700">Kepala Sub Bagian</h5>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 block text-xs">Nama:</span>
                                        <span class="font-semibold text-gray-900">{{ $inverter->head_of_sub_department }}</span>
                                    </div>
                                    @if($inverter->head_of_sub_department_nik)
                                    <div>
                                        <span class="text-gray-600 block text-xs">NIK:</span>
                                        <span class="text-gray-900">{{ $inverter->head_of_sub_department_nik }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Actions (Mobile) -->
                    <div class="flex flex-col sm:hidden gap-2 mt-6">
                        <a href="{{ route('inverter.index') }}"
                           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg shadow text-center">
                            ← Kembali
                        </a>
                        <a href="{{ route('inverter.edit', $inverter->id) }}"
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow text-center">
                            ✏️ Edit Data
                        </a>
                        <button onclick="window.print()"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow">
                            🖨️ Print / PDF
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .bg-gray-50 { background-color: #f9fafb !important; }
            .shadow-sm { box-shadow: none !important; }
        }
    </style>
</x-app-layout>

<x-app-layout>
    {{-- Header Slot (Tidak Berubah) --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="hidden sm:inline">{{ __('Detail Genset Maintenance') }}</span>
                <span class="sm:hidden">{{ __('Detail Genset') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2">
                <a href="{{ route('genset.index') }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg text-xs sm:text-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
                <a href="{{ route('genset.edit', $maintenance->id) }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg text-xs sm:text-sm">
                    <i data-lucide="edit-3" class="h-4 w-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Edit</span>
                </a>
                <a href="{{ route('genset.pdf', $maintenance->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-xs sm:text-sm">
                    <i data-lucide="printer" class="h-4 w-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Cetak</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">

                {{-- Informasi Dokumen (Tidak Berubah) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md"><p class="text-sm text-gray-600">No. Dokumen</p><p class="text-lg font-bold text-blue-700">{{ $maintenance->doc_number }}</p></div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md"><p class="text-sm text-gray-600">Location</p><p class="text-lg text-gray-800">{{ $maintenance->central->nama ?? $maintenance->location }}</p></div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md"><p class="text-sm text-gray-600">Date / Time</p><p class="text-lg text-gray-800">{{ $maintenance->maintenance_date->format('d F Y, H:i') }}</p></div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md"><p class="text-sm text-gray-600">Brand / Type</p><p class="text-lg text-gray-800">{{ $maintenance->brand_type ?? '-' }}</p></div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md"><p class="text-sm text-gray-600">Capacity</p><p class="text-lg text-gray-800">{{ $maintenance->capacity ?? '-' }}</p></div>
                    </div>
                </div>

                {{-- Notes (Tidak Berubah) --}}
                @if($maintenance->notes)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Notes / additional informations</h3>
                        <div class="border p-4 rounded bg-yellow-50 border-yellow-200">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{!! nl2br(e($maintenance->notes)) !!}</p>
                        </div>
                    </div>
                @endif

                {{-- [PERBAIKAN] Visual Check (Menggunakan style tabel UPS) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">1. Visual Check</h3>
                    <div class="overflow-x-auto">
                        {{-- Tambahkan class 'w-full border' --}}
                        <table class="min-w-full w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    {{-- Tambahkan class 'border p-2 text-left' --}}
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Descriptions</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $visualChecks = [
                                        ['key' => 'environment_condition', 'label' => 'a. Environment Condition'],
                                        ['key' => 'engine_oil_press_display', 'label' => 'b. Engine Oil Press. Display'],
                                        ['key' => 'engine_water_temp_display', 'label' => 'c. Engine Water Temp. Display'],
                                        ['key' => 'battery_connection', 'label' => 'd. Battery Connection'],
                                        ['key' => 'engine_oil_level', 'label' => 'e. Engine Oil Level'],
                                        ['key' => 'engine_fuel_level', 'label' => 'f. Engine Fuel Level'],
                                        ['key' => 'running_hours', 'label' => 'g. Running Hours'],
                                        ['key' => 'cooling_water_level', 'label' => 'h. Cooling Water Level'],
                                    ];
                                @endphp
                                @foreach($visualChecks as $check)
                                <tr>
                                    {{-- Tambahkan class 'border p-2' --}}
                                    <td class="border p-2 text-sm font-medium text-gray-700 w-1/3">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold w-1/3">{{ $maintenance->{$check['key'].'_result'} ?? '-'}}</td>
                                    <td class="border p-2 text-sm text-gray-600 w-1/3">{{ $maintenance->{$check['key'].'_comment'} ?? '-'}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- [PERBAIKAN] Engine Running Test (Menggunakan style tabel UPS) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. Engine Running Test</h3>
                    <div class="space-y-6">
                        {{-- No Load Test Table --}}
                        <div>
                            <h4 class="font-bold text-md text-gray-700 mb-2">I. No Load Test (30 minute)</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full w-full border">
                                    <thead class="bg-gray-100"><tr><th class="border p-2 text-left text-sm font-semibold text-gray-700">Descriptions</th><th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th><th class="border p-2 text-left text-sm font-semibold text-gray-700">Comment</th></tr></thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="border p-2 text-sm font-medium text-gray-700 w-1/3" rowspan="2">a. AC Output Voltage</td>
                                            <td class="border p-2 text-sm font-semibold w-1/3">R-S: {{ $maintenance->no_load_ac_voltage_rs ?? '-' }} V<br>S-T: {{ $maintenance->no_load_ac_voltage_st ?? '-' }} V<br>T-R: {{ $maintenance->no_load_ac_voltage_tr ?? '-' }} V</td>
                                            <td class="border p-2 text-sm text-gray-600 w-1/3" rowspan="2">{{ $maintenance->no_load_ac_voltage_comment ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border p-2 text-sm font-semibold w-1/3">R-N: {{ $maintenance->no_load_ac_voltage_rn ?? '-' }} V<br>S-N: {{ $maintenance->no_load_ac_voltage_sn ?? '-' }} V<br>T-N: {{ $maintenance->no_load_ac_voltage_tn ?? '-' }} V</td>
                                        </tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">b. Output Frequency</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->no_load_output_frequency_result ?? '-'}} Hz</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->no_load_output_frequency_comment ?? '-'}}</td></tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">c. Battery Charging Current</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->no_load_battery_charging_current_result ?? '-'}} A</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->no_load_battery_charging_current_comment ?? '-'}}</td></tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">d. Engine Cooling Water Temp.</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->no_load_engine_cooling_water_temp_result ?? '-'}} °C</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->no_load_engine_cooling_water_temp_comment ?? '-'}}</td></tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">e. Engine Oil Press.</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->no_load_engine_oil_press_result ?? '-'}} Psi</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->no_load_engine_oil_press_comment ?? '-'}}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Load Test Table --}}
                        <div>
                            <h4 class="font-bold text-md text-gray-700 mb-2">II. Load Test (30 minute)</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full w-full border">
                                    <thead class="bg-gray-100"><tr><th class="border p-2 text-left text-sm font-semibold text-gray-700">Descriptions</th><th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th><th class="border p-2 text-left text-sm font-semibold text-gray-700">Comment</th></tr></thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="border p-2 text-sm font-medium text-gray-700 w-1/3" rowspan="2">a. AC Output Voltage</td>
                                            <td class="border p-2 text-sm font-semibold w-1/3">R-S: {{ $maintenance->load_ac_voltage_rs ?? '-' }} V<br>S-T: {{ $maintenance->load_ac_voltage_st ?? '-' }} V<br>T-R: {{ $maintenance->load_ac_voltage_tr ?? '-' }} V</td>
                                            <td class="border p-2 text-sm text-gray-600 w-1/3" rowspan="2">{{ $maintenance->load_ac_voltage_comment ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border p-2 text-sm font-semibold w-1/3">R-N: {{ $maintenance->load_ac_voltage_rn ?? '-' }} V<br>S-N: {{ $maintenance->load_ac_voltage_sn ?? '-' }} V<br>T-N: {{ $maintenance->load_ac_voltage_tn ?? '-' }} V</td>
                                        </tr>
                                        <tr>
                                            <td class="border p-2 text-sm font-medium text-gray-700 w-1/3">b. AC Output Current</td>
                                            <td class="border p-2 text-sm font-semibold w-1/3">R: {{ $maintenance->load_ac_current_r ?? '-' }} A<br>S: {{ $maintenance->load_ac_current_s ?? '-' }} A<br>T: {{ $maintenance->load_ac_current_t ?? '-' }} A</td>
                                            <td class="border p-2 text-sm text-gray-600 w-1/3">{{ $maintenance->load_ac_current_comment ?? '-' }}</td>
                                        </tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">c. Output Frequency</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->load_output_frequency_result ?? '-'}} Hz</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->load_output_frequency_comment ?? '-'}}</td></tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">d. Battery Charging Current</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->load_battery_charging_current_result ?? '-'}} A</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->load_battery_charging_current_comment ?? '-'}}</td></tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">e. Engine Cooling Water Temp.</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->load_engine_cooling_water_temp_result ?? '-'}} °C</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->load_engine_cooling_water_temp_comment ?? '-'}}</td></tr>
                                        <tr><td class="border p-2 text-sm font-medium text-gray-700">f. Engine Oil Press.</td><td class="border p-2 text-sm font-semibold">{{ $maintenance->load_engine_oil_press_result ?? '-'}} Psi</td><td class="border p-2 text-sm text-gray-600">{{ $maintenance->load_engine_oil_press_comment ?? '-'}}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Images (Tidak Berubah) --}}
                @php $images = $maintenance->images ?? []; @endphp
                @if(!empty($images) && count($images) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">3. Documentation Images</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($images as $image)
                                @if(is_array($image) && isset($image['path']))
                                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                        <a href="{{ asset('storage/' . $image['path']) }}" target="_blank" class="block">
                                            <img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['category'] ?? 'Doc Image' }}" class="w-full h-48 object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500\'>Image not found</div>'">
                                        </a>
                                        <div class="p-3 bg-gray-50">
                                            @if(isset($image['category']))<p class="text-sm font-semibold text-gray-700 mb-1">{{ ucwords(str_replace(['_result', '_'], ['', ' '], $image['category'])) }}</p>@endif
                                            @if(isset($image['locationName']) && $image['locationName'] !== 'Getting...')<p class="text-xs text-gray-500">{{ $image['locationName'] }}</p>
                                            @elseif(isset($image['latitude']))<p class="text-xs text-gray-500">{{ $image['latitude'] }}, {{ $image['longitude'] }}</p>@endif
                                             <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($image['timestamp'])->setTimezone('Asia/Makassar')->format('d M Y, H:i') }} WITA</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Personnel --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">4. Pelaksana & Mengetahui</h3>

                    <!-- Executor Section -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-md mb-2">Pelaksana (Executor)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @for($i = 1; $i <= 4; $i++)
                                @if($maintenance->{'executor_'.$i})
                                    <div class="border p-3 rounded-lg bg-gray-50">
                                        <p class="text-sm text-gray-600">Pelaksana {{ $i }}</p>
                                        <p class="font-semibold mt-1">{{ $maintenance->{'executor_'.$i} }}</p>
                                        @if($maintenance->{'mitra_internal_'.$i})
                                            <p class="text-xs text-gray-500 mt-2">
                                                <span class="px-2 py-1 rounded {{ $maintenance->{'mitra_internal_'.$i} == 'Internal' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $maintenance->{'mitra_internal_'.$i} }}
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>

                    <!-- Verifikator & Head of Sub Department -->
                    <div>
                        <h4 class="font-semibold text-md mb-2">Mengetahui</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($maintenance->verifikator)
                                <div class="border p-3 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-600">Verifikator</p>
                                    <p class="font-semibold mt-1">{{ $maintenance->verifikator }}</p>
                                    @if($maintenance->verifikator_nik)
                                        <p class="text-xs text-gray-500 mt-2">NIK: {{ $maintenance->verifikator_nik }}</p>
                                    @endif
                                </div>
                            @endif

                            @if($maintenance->head_of_sub_department)
                                <div class="border p-3 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-600">Head of Sub Department</p>
                                    <p class="font-semibold mt-1">{{ $maintenance->head_of_sub_department }}</p>
                                    @if($maintenance->head_of_sub_department_nik)
                                        <p class="text-xs text-gray-500 mt-2">NIK: {{ $maintenance->head_of_sub_department_nik }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- [PERBAIKAN] Hapus style block lama dan ganti dengan style UPS --}}
    <style>
        .label-info { @apply text-sm text-gray-600; }
        .data-info { @apply font-semibold text-lg; }
        .info-card { @apply border-l-4 border-blue-500 pl-3 rounded-md; }
        .th-table { @apply border p-2 text-left text-sm font-semibold text-gray-700; }
        .td-table { @apply border p-2 text-sm; }
        .img-error { @apply w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-sm; }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    @endpush
</x-app-layout>

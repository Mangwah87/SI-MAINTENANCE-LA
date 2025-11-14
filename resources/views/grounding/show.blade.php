<x-app-layout>
    {{-- Header Slot (Responsif) --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="hidden sm:inline">{{ __('Detail PM Petir & Grounding') }}</span>
                <span class="sm:hidden">{{ __('Detail Grounding') }}</span>
            </h2>
            <div class="flex gap-1.5 sm:gap-2">
                <a href="{{ route('grounding.index') }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg text-xs sm:text-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
                <a href="{{ route('grounding.edit', $maintenance->id) }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg text-xs sm:text-sm">
                    <i data-lucide="edit-3" class="h-4 w-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Edit</span>
                </a>
                <a href="{{ route('grounding.pdf', $maintenance->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-xs sm:text-sm">
                    <i data-lucide="printer" class="h-4 w-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Cetak</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                
                {{-- [PERBAIKAN] Informasi Dokumen (Class Tailwind Inline) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-teal-50 p-2 rounded">Informasi Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border-l-4 border-teal-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">No. Dokumen</p>
                            <p class="font-semibold text-lg text-teal-700 font-bold">{{ $maintenance->doc_number }}</p>
                        </div>
                        <div class="border-l-4 border-teal-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->location }}</p>
                        </div>
                        <div class="border-l-4 border-teal-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Date / Time</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->maintenance_date->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="border-l-4 border-teal-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Brand / Type</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->brand_type ?? '-' }}</p>
                        </div>
                        <div class="border-l-4 border-teal-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Reg. Number</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->reg_number ?? '-' }}</p>
                        </div>
                        <div class="border-l-4 border-teal-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">S/N</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->sn ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                @if($maintenance->notes)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 bg-teal-50 p-2 rounded">Notes / additional informations</h3>
                        <div class="border p-4 rounded bg-yellow-50 border-yellow-200">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{!! nl2br(e($maintenance->notes)) !!}</p>
                        </div>
                    </div>
                @endif

                {{-- [PERBAIKAN] Visual Check (Class Tailwind Inline) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-teal-50 p-2 rounded">1. Visual Check</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Activity</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Operational Standard</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $visualChecks = [
                                    ['field' => 'visual_air_terminal', 'label' => 'a. Air Terminal', 'standard' => 'Available < 45 with Antenna'],
                                    ['field' => 'visual_down_conductor', 'label' => 'b. Down Conductor', 'standard' => 'Available (cable > 35 mmsq)'],
                                    ['field' => 'visual_ground_rod', 'label' => 'c. Ground Rod', 'standard' => 'Available, No Corrosion'],
                                    ['field' => 'visual_bonding_bar', 'label' => 'd. Bonding Bar', 'standard' => 'Available, No Corrosion'],
                                    ['field' => 'visual_arrester_condition', 'label' => 'e. Arrester Condition', 'standard' => 'Normal'],
                                    ['field' => 'visual_maksure_equipment', 'label' => 'f. Maksure All Equipment to Ground Bar', 'standard' => 'Yes'],
                                    ['field' => 'visual_maksure_connection', 'label' => 'g. Maksure All Connection Tightened', 'standard' => 'Yes'],
                                    ['field' => 'visual_ob_light', 'label' => 'h. OB Light Installed if With Tower', 'standard' => 'Yes & Normal Operation'],
                                ];
                                @endphp
                                @foreach($visualChecks as $check)
                                @php $fieldName = $check['field']; @endphp
                                <tr>
                                    <td class="border p-2 text-sm font-medium text-gray-700">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold">{{ $maintenance->{$fieldName.'_result'} ?? '-'}}</td>
                                    <td class="border p-2 text-sm text-gray-600">{{ $check['standard'] }}</td>
                                    <td class="border p-2 text-sm text-center">
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- [PERBAIKAN] Performance Measurement (Class Tailwind Inline) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-teal-50 p-2 rounded">2. Performance Measurement</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Activity</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Operational Standard</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $perfChecks = [
                                    ['field' => 'perf_ground_resistance', 'label' => 'a. Ground Resistance (R)', 'unit' => 'Ohm', 'standard' => 'R < 1 Ohm'],
                                    ['field' => 'perf_arrester_cutoff_power', 'label' => 'b. Arrester Cutoff Voltage (Power)', 'unit' => 'VAC', 'standard' => '280 VAC'],
                                    ['field' => 'perf_arrester_cutoff_data', 'label' => 'c. Arrester Cutoff Voltage (Data)', 'unit' => 'VAC', 'standard' => '76 VAC'],
                                    ['field' => 'perf_tighten_nut', 'label' => 'd. Tighten of Nut', 'unit' => '', 'standard' => 'Tightened'],
                                ];
                                @endphp
                                @foreach($perfChecks as $check)
                                @php $fieldName = $check['field']; @endphp
                                <tr>
                                    <td class="border p-2 text-sm font-medium text-gray-700">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold">
                                        {{ $maintenance->{$fieldName.'_result'} ?? '-'}} {{ $check['unit'] }}
                                    </td>
                                    <td class="border p-2 text-sm text-gray-600">{{ $check['standard'] }}</td>
                                    <td class="border p-2 text-sm text-center">
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Images --}}
                @php $images = $maintenance->images ?? []; @endphp
                @if(!empty($images) && count($images) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 bg-teal-50 p-2 rounded">3. Documentation Images</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($images as $image)
                                @if(is_array($image) && isset($image['path']))
                                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                        <a href="{{ asset('storage/' . $image['path']) }}" target="_blank" class="block"><img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['category'] ?? 'Doc Image' }}" class="w-full h-48 object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-sm\'>Image not found</div>'"></a>
                                        <div class="p-3 bg-gray-50">
                                            @if(isset($image['category']))<p class="text-sm font-semibold text-gray-700 mb-1">{{ ucwords(str_replace(['visual_', 'perf_', '_'], ['', '', ' '], $image['category'])) }}</p>@endif
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
                    <h3 class="text-lg font-semibold mb-3 bg-teal-50 p-2 rounded">4. Pelaksana & Approver</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border p-3 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-600">Pelaksana 1</p>
                            <p class="font-semibold mt-1">{{ $maintenance->technician_1_name ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $maintenance->technician_1_company ?? '-' }}</p>
                        </div>
                        <div class="border p-3 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-600">Pelaksana 2</p>
                            <p class="font-semibold mt-1">{{ $maintenance->technician_2_name ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $maintenance->technician_2_company ?? '-' }}</p>
                        </div>
                        <div class="border p-3 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-600">Pelaksana 3</p>
                            <p class="font-semibold mt-1">{{ $maintenance->technician_3_name ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $maintenance->technician_3_company ?? '-' }}</p>
                        </div>
                        <div class="border p-3 rounded-lg bg-gray-50 md:col-start-3">
                            <p class="text-sm text-gray-600">Mengetahui (Approver)</p>
                            <p class="font-semibold mt-1">{{ $maintenance->approver_name ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-1">NIK: {{ $maintenance->approver_nik ?? '-' }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- HAPUS BLOK <style> KARENA TIDAK DIGUNAKAN --}}

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
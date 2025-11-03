<x-app-layout>
    {{-- Header Slot (Hanya Judul, seperti UPS) --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail PM Kabel & Panel Distribusi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                
                {{-- Tombol Aksi (Disalin dari UPS) --}}
                <div class="mb-6 pb-4 border-b-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="text-xl font-bold text-gray-800">Detail Maintenance</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('cable-panel.edit', $maintenance->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm font-medium">
                            <i data-lucide="edit-3" class="h-4 w-4 mr-2"></i>
                            Edit
                        </a>
                        <a href="{{ route('cable-panel.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                            <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                            Kembali
                        </a>
                        <a href="{{ route('cable-panel.pdf', $maintenance->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                            <i data-lucide="printer" class="h-4 w-4 mr-2"></i>
                            Cetak PDF
                        </a>
                    </div>
                </div>

                {{-- Informasi Dokumen (Style dari UPS) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">Informasi Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">No. Dokumen</p>
                            <p class="font-semibold text-lg text-blue-700 font-bold">{{ $maintenance->doc_number }}</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->location }}</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Date / Time</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->maintenance_date->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Brand / Type</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->brand_type ?? '-' }}</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">Reg. Number</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->reg_number ?? '-' }}</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                            <p class="text-sm text-gray-600">S/N</p>
                            <p class="font-semibold text-lg text-gray-800">{{ $maintenance->sn ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Notes (Style dari UPS) --}}
                @if($maintenance->notes)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">Notes / additional informations</h3>
                        <div class="border p-4 rounded bg-yellow-50 border-yellow-200">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{!! nl2br(e($maintenance->notes)) !!}</p>
                        </div>
                    </div>
                @endif

                {{-- 1. Visual Check (Tabel bergaris style UPS) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">1. Visual Check</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Activity</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th>
                                    <th class="border p-2 text-sm font-semibold text-gray-700 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $visualChecks = [
                                    ['field' => 'visual_indicator_lamp', 'label' => 'a. Indicator Lamp'],
                                    ['field' => 'visual_voltmeter_ampere_meter', 'label' => 'b. Voltmeter & Ampere meter'],
                                    ['field' => 'visual_arrester', 'label' => 'c. Arrester'],
                                    ['field' => 'visual_mcb_input_ups', 'label' => 'd. MCB Input UPS'],
                                    ['field' => 'visual_mcb_output_ups', 'label' => 'e. MCB Output UPS'],
                                    ['field' => 'visual_mcb_bypass', 'label' => 'f. MCB Bypass'],
                                ];
                                @endphp
                                @foreach($visualChecks as $check)
                                @php $fieldName = $check['field']; @endphp
                                <tr>
                                    <td class="border p-2 text-sm font-medium text-gray-700 w-3/5">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold w-1/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}}</td>
                                    <td class="border p-2 text-sm text-center w-1/5">
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

                {{-- 2. Performance Measurement (Tabel bergaris style UPS) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">2. Performance Measurement</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Activity</th>
                                    <th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th>
                                    <th class="border p-2 text-sm font-semibold text-gray-700 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- I. MCB Temperature --}}
                                <tr><td colspan="3" class="border p-2 bg-gray-50 font-semibold text-gray-700 text-sm">I. MCB Temperature</td></tr>
                                @php
                                $mcbTempChecks = [
                                    ['field' => 'perf_temp_mcb_input_ups', 'label' => 'a. Input UPS', 'unit' => '°C'],
                                    ['field' => 'perf_temp_mcb_output_ups', 'label' => 'b. Output UPS', 'unit' => '°C'],
                                    ['field' => 'perf_temp_mcb_bypass_ups', 'label' => 'c. Bypass UPS', 'unit' => '°C'],
                                    ['field' => 'perf_temp_mcb_load_rack', 'label' => 'd. Load Rack', 'unit' => '°C'],
                                    ['field' => 'perf_temp_mcb_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'unit' => '°C'],
                                ];
                                @endphp
                                @foreach($mcbTempChecks as $check)
                                @php $fieldName = $check['field']; @endphp
                                <tr>
                                    <td class="border p-2 text-sm font-medium text-gray-700 w-3/5 pl-8">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold w-1/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}} {{ $check['unit'] }}</td>
                                    <td class="border p-2 text-sm text-center w-1/5"><span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
                                </tr>
                                @endforeach

                                {{-- II. Cable Temperature --}}
                                <tr><td colspan="3" class="border p-2 bg-gray-50 font-semibold text-gray-700 text-sm">II. Cable Temperature</td></tr>
                                @php
                                $cableTempChecks = [
                                    ['field' => 'perf_temp_cable_input_ups', 'label' => 'a. Input UPS', 'unit' => '°C'],
                                    ['field' => 'perf_temp_cable_output_ups', 'label' => 'b. Output UPS', 'unit' => '°C'],
                                    ['field' => 'perf_temp_cable_bypass_ups', 'label' => 'c. Bypass UPS', 'unit' => '°C'],
                                    ['field' => 'perf_temp_cable_load_rack', 'label' => 'd. Load Rack', 'unit' => '°C'],
                                    ['field' => 'perf_temp_cable_cooling_unit', 'label' => 'e. Cooling unit (AC)', 'unit' => '°C'],
                                ];
                                @endphp
                                @foreach($cableTempChecks as $check)
                                @php $fieldName = $check['field']; @endphp
                                <tr>
                                    <td class="border p-2 text-sm font-medium text-gray-700 w-3/5 pl-8">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold w-1/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}} {{ $check['unit'] }}</td>
                                    <td class="border p-2 text-sm text-center w-1/5"><span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 3. Performance Check (Tabel bergaris style UPS) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">3. Performance Check</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full border">
                            <thead class="bg-gray-100"><tr><th class="border p-2 text-left text-sm font-semibold text-gray-700">Activity</th><th class="border p-2 text-left text-sm font-semibold text-gray-700">Result</th><th class="border p-2 text-sm font-semibold text-gray-700 text-center">Status</th></tr></thead>
                            <tbody>
                                @php
                                $perfChecks = [
                                    ['field' => 'perf_check_cable_connection', 'label' => 'a. Maksure All Cable Connection'],
                                    ['field' => 'perf_check_spare_mcb', 'label' => 'b. Spare of MCB Load Rack'],
                                    ['field' => 'perf_check_single_line_diagram', 'label' => 'c. Single Line Diagram'],
                                ];
                                @endphp
                                @foreach($perfChecks as $check)
                                @php $fieldName = $check['field']; @endphp
                                <tr>
                                    <td class="border p-2 text-sm font-medium text-gray-700 w-3/5">{{ $check['label'] }}</td>
                                    <td class="border p-2 text-sm font-semibold w-1/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}}</td>
                                    <td class="border p-2 text-sm text-center w-1/5"><span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
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
                        <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">4. Documentation Images</h3>
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
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded border-l-4 border-blue-500">5. Pelaksana & Mengetahui</h3>
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
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- HAPUS <style> block --}}

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
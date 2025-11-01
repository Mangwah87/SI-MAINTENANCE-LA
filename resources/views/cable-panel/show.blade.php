<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail PM Kabel & Panel Distribusi') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('cable-panel.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg text-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i> Kembali
                </a>
                <a href="{{ route('cable-panel.edit', $maintenance->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg text-sm">
                    <i data-lucide="edit-3" class="h-4 w-4 mr-2"></i> Edit
                </a>
                <a href="{{ route('cable-panel.pdf', $maintenance->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-sm">
                    <i data-lucide="printer" class="h-4 w-4 mr-2"></i> Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                 <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-cyan-700">Informasi Dokumen</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div><label class="label-info">No. Dokumen</label><p class="data-info text-cyan-800 font-bold">{{ $maintenance->doc_number }}</p></div>
                    <div><label class="label-info">Location</label><p class="data-info">{{ $maintenance->location }}</p></div>
                    <div><label class="label-info">Date / Time</label><p class="data-info">{{ $maintenance->maintenance_date->format('d F Y, H:i') }} WITA</p></div>
                    <div><label class="label-info">Brand / Type</label><p class="data-info">{{ $maintenance->brand_type ?? '-' }}</p></div>
                    <div><label class="label-info">Reg. Number</label><p class="data-info">{{ $maintenance->reg_number ?? '-' }}</p></div>
                    <div><label class="label-info">S/N</label><p class="data-info">{{ $maintenance->sn ?? '-' }}</p></div>
                     @if($maintenance->notes)
                        <div class="md:col-span-2 mt-2">
                            <label class="label-info">Notes</label>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded mt-1">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap">{!! nl2br(e($maintenance->notes)) !!}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3></div>
                <div class="p-6">
                    <table class="min-w-full">
                        <thead class="bg-gray-50"><tr><th class="th-table">Item</th><th class="th-table">Result</th><th class="th-table text-center">Status</th></tr></thead>
                        <tbody class="divide-y divide-gray-200">
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
                                <td class="td-table font-medium text-gray-700 w-2/5">{{ $check['label'] }}</td>
                                <td class="td-table font-semibold w-2/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}}</td>
                                <td class="td-table text-center w-1/5"><span class="status-badge {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                 <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">2. Performance Measurement</h3></div>
                <div class="p-6">
                     <table class="min-w-full">
                         <thead class="bg-gray-50"><tr><th class="th-table">Item</th><th class="th-table">Result</th><th class="th-table text-center">Status</th></tr></thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- I. MCB Temperature --}}
                            <tr><td colspan="3" class="px-4 py-2 bg-gray-100 font-semibold text-gray-700 text-sm">I. MCB Temperature</td></tr>
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
                                <td class="td-table font-medium text-gray-700 w-2/5 pl-8">{{ $check['label'] }}</td>
                                <td class="td-table font-semibold w-2/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}} {{ $check['unit'] }}</td>
                                <td class="td-table text-center w-1/5"><span class="status-badge {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
                            </tr>
                            @endforeach

                            {{-- II. Cable Temperature --}}
                            <tr><td colspan="3" class="px-4 py-2 bg-gray-100 font-semibold text-gray-700 text-sm">II. Cable Temperature</td></tr>
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
                                <td class="td-table font-medium text-gray-700 w-2/5 pl-8">{{ $check['label'] }}</td>
                                <td class="td-table font-semibold w-2/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}} {{ $check['unit'] }}</td>
                                <td class="td-table text-center w-1/5"><span class="status-badge {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">3. Performance Check</h3></div>
                <div class="p-6">
                    <table class="min-w-full">
                        <thead class="bg-gray-50"><tr><th class="th-table">Item</th><th class="th-table">Result</th><th class="th-table text-center">Status</th></tr></thead>
                        <tbody class="divide-y divide-gray-200">
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
                                <td class="td-table font-medium text-gray-700 w-2/5">{{ $check['label'] }}</td>
                                <td class="td-table font-semibold w-2/5">{{ $maintenance->{$fieldName.'_result'} ?? '-'}}</td>
                                <td class="td-table text-center w-1/5"><span class="status-badge {{ ($maintenance->{$fieldName.'_status'} ?? 'OK') === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $maintenance->{$fieldName.'_status'} ?? 'N/A' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @php $images = $maintenance->images ?? []; @endphp
            @if(!empty($images) && count($images) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">4. Documentation Images</h3></div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($images as $image)
                            @if(is_array($image) && isset($image['path']))
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                    <a href="{{ asset('storage/' . $image['path']) }}" target="_blank" class="block"><img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['category'] ?? 'Doc Image' }}" class="w-full h-48 object-cover" onerror="this.parentElement.innerHTML='<div class=\'img-error\'>Image not found</div>'"></a>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                 <div class="p-6 border-b border-gray-200"><h3 class="text-xl font-bold text-gray-800">5. Pelaksana & Mengetahui</h3></div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for ($i = 1; $i <= 3; $i++)
                    <div class="border-l-4 border-teal-500 pl-4">
                        <p class="label-info">Pelaksana #{{ $i }}</p>
                        <p class="data-info font-semibold">{{ $maintenance->{'technician_'.$i.'_name'} ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $maintenance->{'technician_'.$i.'_company'} ?? '-' }}</p>
                    </div>
                    @endfor
                     <div class="border-l-4 border-gray-400 pl-4 md:col-start-3">
                        <p class="label-info">Mengetahui (Approver)</p>
                        <p class="data-info font-semibold">{{ $maintenance->approver_name ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- CSS Styles --}}
     <style>
        .label-info { @apply block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider; }
        .data-info { @apply text-base text-gray-800; }
        .th-table { @apply px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase bg-gray-50; }
        .td-table { @apply px-4 py-3 text-sm; }
        .status-badge { @apply px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full; }
        .status-ok { @apply bg-green-100 text-green-800; }
        .status-nok { @apply bg-red-100 text-red-800; }
        .img-error { @apply w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-sm; }
    </style>

    @push('scripts')
    <script> document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); }); </script>
    @endpush
</x-app-layout>
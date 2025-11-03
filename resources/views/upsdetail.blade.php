<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Preventive Maintenance UPS
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6 pb-4 border-b-2">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Preventive Maintenance UPS</h2>
                    <div class="text-sm text-gray-600 mt-2">
                        <p>No. Dok: FM-LAP-D2-SOP-003-002 | Versi: 1.0 | Hal: 1 dari 1 | Label: Internal</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('ups.edit', $maintenance->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        Edit
                    </a>
                    <a href="{{ route('ups') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Kembali
                    </a>
                    <a href="{{ route('ups.print', $maintenance->id) }}" target="_blank" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Cetak PDF
                    </a>
                </div>
            </div>

            {{-- Informasi Lokasi dan Perangkat --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Lokasi dan Perangkat</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="font-semibold">{{ $maintenance->location }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Date / Time</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($maintenance->date_time)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Brand / Type</p>
                        <p class="font-semibold">{{ $maintenance->brand_type }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Kapasitas</p>
                        <p class="font-semibold">{{ $maintenance->capacity }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Reg. Number</p>
                        <p class="font-semibold">{{ $maintenance->reg_number ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">S/N</p>
                        <p class="font-semibold">{{ $maintenance->sn ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Visual Check --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">1. Visual Check</h3>
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2 text-left">Activity</th>
                            <th class="border p-2 text-left">Result</th>
                            <th class="border p-2 text-left">Operational Standard</th>
                            <th class="border p-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-2">a. Environmental Condition</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->env_condition }}</td>
                            <td class="border p-2 text-sm text-gray-600">Clean, No dust</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_env_condition ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_env_condition ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">b. LED / display</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->led_display }}</td>
                            <td class="border p-2 text-sm text-gray-600">Normal</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_led_display ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_led_display ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">c. Battery Connection</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->battery_connection }}</td>
                            <td class="border p-2 text-sm text-gray-600">Tighten, No Corrosion</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_battery_connection ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_battery_connection ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Performance and Capacity Check --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. Performance and Capacity Check</h3>
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2 text-left">Activity</th>
                            <th class="border p-2 text-left">Result</th>
                            <th class="border p-2 text-left">Operational Standard</th>
                            <th class="border p-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-2">a. AC input voltage</td>
                            <td class="border p-2 font-semibold">
                                RS={{ $maintenance->ac_input_voltage_rs }}V,
                                ST={{ $maintenance->ac_input_voltage_st }}V,
                                TR={{ $maintenance->ac_input_voltage_tr }}V
                            </td>
                            <td class="border p-2 text-sm text-gray-600">360 - 400 VAC</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_input_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_ac_input_voltage ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">b. AC output voltage</td>
                            <td class="border p-2 font-semibold">
                                RS={{ $maintenance->ac_output_voltage_rs }}V,
                                ST={{ $maintenance->ac_output_voltage_st }}V,
                                TR={{ $maintenance->ac_output_voltage_tr }}V
                            </td>
                            <td class="border p-2 text-sm text-gray-600">370 - 390 VAC</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_output_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_ac_output_voltage ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">c. AC current input</td>
                            <td class="border p-2 font-semibold">
                                R={{ $maintenance->ac_current_input_r }}A,
                                S={{ $maintenance->ac_current_input_s }}A,
                                T={{ $maintenance->ac_current_input_t }}A
                            </td>
                            <td class="border p-2 text-sm text-gray-600">Sesuai kapasitas UPS</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_current_input ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_ac_current_input ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">d. AC current output</td>
                            <td class="border p-2 font-semibold">
                                R={{ $maintenance->ac_current_output_r }}A,
                                S={{ $maintenance->ac_current_output_s }}A,
                                T={{ $maintenance->ac_current_output_t }}A
                            </td>
                            <td class="border p-2 text-sm text-gray-600">Sesuai kapasitas UPS</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_current_output ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_ac_current_output ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">e. UPS temperature</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->ups_temperature }} °C</td>
                            <td class="border p-2 text-sm text-gray-600">0-40 °C</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ups_temperature ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_ups_temperature ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">f. Output frequency</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->output_frequency }} Hz</td>
                            <td class="border p-2 text-sm text-gray-600">48.75-50.25 Hz</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_output_frequency ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_output_frequency ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">g. Charging voltage</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->charging_voltage }} V</td>
                            <td class="border p-2 text-sm text-gray-600">See Battery Performance table</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_charging_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_charging_voltage ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">h. Charging current</td>
                            <td class="border p-2 font-semibold">{{ $maintenance->charging_current }} A</td>
                            <td class="border p-2 text-sm text-gray-600">0 Ampere, on-line mode</td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_charging_current ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $maintenance->status_charging_current ?? 'OK' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Notes --}}
            @if($maintenance->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Notes / additional informations</h3>
                    <div class="border p-4 rounded bg-gray-50">
                        <p class="whitespace-pre-wrap">{{ $maintenance->notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Images --}}
            @if($maintenance->images && count($maintenance->images) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Documentation Images</h3>

                    @php
                        $groupedImages = collect($maintenance->images)->groupBy('category');
                        $categoryNames = [
                            'visual_check_env_condition' => 'Environmental Condition',
                            'visual_check_led_display' => 'LED Display',
                            'visual_check_battery_connection' => 'Battery Connection',
                            'performance_ac_input_voltage' => 'AC Input Voltage',
                            'performance_ac_output_voltage' => 'AC Output Voltage',
                            'performance_ac_current_input' => 'AC Current Input',
                            'performance_ac_current_output' => 'AC Current Output',
                            'performance_ups_temperature' => 'UPS Temperature',
                            'performance_output_frequency' => 'Output Frequency',
                            'performance_charging_voltage' => 'Charging Voltage',
                            'performance_charging_current' => 'Charging Current'
                        ];
                    @endphp

                    @foreach($groupedImages as $category => $images)
                        <div class="mb-6">
                            <h4 class="text-md font-medium mb-3 bg-gray-50 p-2 rounded border-l-4 border-blue-400">
                                {{ $categoryNames[$category] ?? ucwords(str_replace('_', ' ', $category)) }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($images as $imageInfo)
                                    <div class="border rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $imageInfo['path']) }}"
                                             alt="{{ $categoryNames[$category] ?? ucwords(str_replace('_', ' ', $category)) }}"
                                             class="w-full h-48 object-cover">
                                        <div class="p-2 text-sm text-gray-600">
                                            <a href="{{ asset('storage/' . $imageInfo['path']) }}"
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800">View Full Size</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Personnel --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Pelaksana / Mengetahui</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 1</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_1 }}</p>
                        <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                    </div>
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 2</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_2 ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                    </div>
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Mengetahui (Supervisor)</p>
                        <p class="font-semibold mt-1">{{ $maintenance->supervisor }}</p>
                        <p class="text-xs text-gray-500 mt-2">ID: {{ $maintenance->supervisor_id_number ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="text-center text-sm text-gray-500 mt-6 pt-4 border-t">
                <p>©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia</p>
                <p>FM-LAP-D2-SOP-003-002 Formulir Preventive Maintenance 3 Phase UPS</p>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Preventive Maintenance UPS 1 Phase
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header section with responsive layout -->
            <div class="mb-6 pb-4 border-b-2">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Detail Preventive Maintenance UPS 1 Phase</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('ups1.edit', $maintenance->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <a href="{{ route('ups1.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kembali
                        </a>
                        <a href="{{ route('ups1.print', $maintenance->id) }}" target="_blank" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Cetak PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- Informasi Lokasi dan Perangkat --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Lokasi dan Perangkat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                <div class="overflow-x-auto">
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
            </div>

            {{-- Performance and Capacity Check --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. Performance and Capacity Check</h3>
                <div class="overflow-x-auto">
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
                                <td class="border p-2 font-semibold">{{ $maintenance->ac_input_voltage }} V</td>
                                <td class="border p-2 text-sm text-gray-600">200 - 240 VAC</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_input_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ac_input_voltage ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. AC output voltage</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ac_output_voltage }} V</td>
                                <td class="border p-2 text-sm text-gray-600">210 - 230 VAC</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_output_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ac_output_voltage ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Neutral - ground voltage</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->neutral_ground_voltage }} V</td>
                                <td class="border p-2 text-sm text-gray-600">< 5 V</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_neutral_ground_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_neutral_ground_voltage ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">d. AC current input</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ac_current_input }} A</td>
                                <td class="border p-2 text-sm text-gray-600">Sesuai kapasitas UPS</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_current_input ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ac_current_input ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">e. AC current output</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ac_current_output }} A</td>
                                <td class="border p-2 text-sm text-gray-600">Sesuai kapasitas UPS</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ac_current_output ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ac_current_output ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">f. UPS temperature</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ups_temperature }} °C</td>
                                <td class="border p-2 text-sm text-gray-600">0-40 °C</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ups_temperature ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ups_temperature ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">g. Output frequency</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->output_frequency }} Hz</td>
                                <td class="border p-2 text-sm text-gray-600">48.75-50.25 Hz</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_output_frequency ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_output_frequency ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">h. Charging voltage</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->charging_voltage }} V</td>
                                <td class="border p-2 text-sm text-gray-600">See Battery Performance table</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_charging_voltage ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_charging_voltage ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">i. Charging current</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->charging_current }} A</td>
                                <td class="border p-2 text-sm text-gray-600">0 Ampere, on-line mode</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_charging_current ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_charging_current ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">j. Fan</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->fan }}</td>
                                <td class="border p-2 text-sm text-gray-600">Normal operation</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_fan ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_fan ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Backup Tests --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">3. Backup Tests</h3>
                <div class="overflow-x-auto">
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
                                <td class="border p-2">a. UPS switching test</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ups_switching_test }}</td>
                                <td class="border p-2 text-sm text-gray-600">Normal, No interruption</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_ups_switching_test ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ups_switching_test ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Battery voltage measurement (start)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->battery_voltage_measurement_1 }} V</td>
                                <td class="border p-2 text-sm text-gray-600">See Battery Performance table</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_battery_voltage_measurement_1 ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_battery_voltage_measurement_1 ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Battery voltage measurement (end)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->battery_voltage_measurement_2 }} V</td>
                                <td class="border p-2 text-sm text-gray-600">See Battery Performance table</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_battery_voltage_measurement_2 ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_battery_voltage_measurement_2 ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Power Alarm Monitoring Test --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">4. Power Alarm Monitoring Test</h3>
                <div class="overflow-x-auto">
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
                                <td class="border p-2">a. Simulated alarm testing (Simonica)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->simonica_alarm_test }}</td>
                                <td class="border p-2 text-sm text-gray-600">Alarm received correctly</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_simonica_alarm_test ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_simonica_alarm_test ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if($maintenance->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Notes / Additional Informations</h3>
                    <div class="border p-4 rounded bg-gray-50">
                        <p class="whitespace-pre-wrap">{{ $maintenance->notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Images --}}
            @php
                // Safely handle images data
                $images = null;

                try {
                    if (isset($maintenance->images)) {
                        if (is_string($maintenance->images)) {
                            // Decode JSON string
                            $images = json_decode($maintenance->images, true);
                        } elseif (is_array($maintenance->images)) {
                            // Already an array
                            $images = $maintenance->images;
                        }
                    }

                    // Ensure $images is an array
                    $images = is_array($images) ? $images : [];

                } catch (\Exception $e) {
                    // If any error occurs, set to empty array
                    $images = [];
                }
            @endphp

            @if(!empty($images) && count($images) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Documentation Images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($images as $index => $imagePath)
                            @if(is_string($imagePath))
                                <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                                    <img src="{{ asset('storage/' . $imagePath) }}"
                                         alt="Documentation Image {{ $index + 1 }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500\'>Image not found</div>'">
                                    <div class="p-2 bg-gray-50">
                                        <p class="text-xs text-gray-600 mb-1">Image {{ $index + 1 }}</p>
                                        <a href="{{ asset('storage/' . $imagePath) }}"
                                           target="_blank"
                                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                                    </div>
                                </div>
                            @elseif(is_array($imagePath) && isset($imagePath['path']))
                                {{-- Support format with category structure --}}
                                <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                                    <img src="{{ asset('storage/' . $imagePath['path']) }}"
                                         alt="{{ $imagePath['category'] ?? 'Documentation Image' }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500\'>Image not found</div>'">
                                    <div class="p-2 bg-gray-50">
                                        @if(isset($imagePath['category']))
                                            <p class="text-xs text-gray-600 mb-1">{{ ucwords(str_replace('_', ' ', $imagePath['category'])) }}</p>
                                        @endif
                                        <a href="{{ asset('storage/' . $imagePath['path']) }}"
                                           target="_blank"
                                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Personnel --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Pelaksana / Mengetahui</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
        </div>
    </div>
</x-app-layout>

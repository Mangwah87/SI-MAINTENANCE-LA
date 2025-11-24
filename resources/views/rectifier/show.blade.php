<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Preventive Maintenance Rectifier
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 md:p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b-2 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Detail Preventive Maintenance Rectifier</h2>

                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('rectifier.edit', $maintenance->id) }}"
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>

                    <a href="{{ route('rectifier.export-pdf', $maintenance->id) }}"
                        target="_blank"
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('rectifier.index') }}"
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm rounded  transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Informasi Lokasi dan Perangkat -->
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Lokasi dan Perangkat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="text-gray-900">
                            @if($maintenance->central)
                                {{ $maintenance->central->id_sentral }} - {{ $maintenance->central->nama }}
                            @else
                                {{ $maintenance->location }}
                            @endif
                        </p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Date / Time</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->date_time->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Brand / Type</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->brand_type }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Power Module</p>
                        <p class="font-semibold text-sm md:text-base">
                            <span class="px-3 py-1 rounded-full text-xs
                                {{ $maintenance->power_module == 'Single' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $maintenance->power_module == 'Dual' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $maintenance->power_module == 'Three' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $maintenance->power_module }}
                            </span>
                        </p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Reg. Number</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->reg_number ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">S/N</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->sn ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- 1. Visual Check -->
            <!-- 1. Visual Check -->
<div class="mb-6">
    <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">1. Visual Check</h3>
    <div class="overflow-x-auto">
        <table class="w-full border text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-left text-xs md:text-sm">Activity</th>
                    <th class="border p-2 text-left text-xs md:text-sm">Result</th>
                    <th class="border p-2 text-left text-xs md:text-sm">Operational Standard</th>
                    <th class="border p-2 text-center text-xs md:text-sm">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">a. Environmental Condition</td>
                    <td class="border p-2 font-semibold">{{ $maintenance->env_condition }}</td>
                    <td class="border p-2 text-xs md:text-sm text-gray-600">Clean, No dust</td>
                    <td class="border p-2 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_env_condition == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $maintenance->status_env_condition }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">b. LED / display</td>
                    <td class="border p-2 font-semibold">{{ $maintenance->led_display }}</td>
                    <td class="border p-2 text-xs md:text-sm text-gray-600">Normal</td>
                    <td class="border p-2 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_led_display == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $maintenance->status_led_display }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">c. Battery Connection</td>
                    <td class="border p-2 font-semibold">{{ $maintenance->battery_connection }}</td>
                    <td class="border p-2 text-xs md:text-sm text-gray-600">Tighten, No Corrosion</td>
                    <td class="border p-2 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_battery_connection == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $maintenance->status_battery_connection }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Environmental Condition Images --}}
    @if(collect($maintenance->images ?? [])->where('category', 'env_condition')->isNotEmpty())
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 mb-2">Environmental Condition Images:</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach(collect($maintenance->images ?? [])->where('category', 'env_condition') as $image)
            <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                @if(isset($image['path']) && file_exists(storage_path('app/public/' . $image['path'])))
                <img src="{{ asset('storage/' . $image['path']) }}"
                    alt="Environmental Condition"
                    class="w-full h-32 md:h-40 object-cover cursor-pointer"
                    onclick="window.open('{{ asset('storage/' . $image['path']) }}', '_blank')">
                @else
                <div class="w-full h-32 md:h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                    Image not found
                </div>
                @endif
                <div class="p-2 bg-gray-50">
                    <a href="{{ asset('storage/' . ($image['path'] ?? '')) }}"
                        target="_blank"
                        class="text-xs text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- LED Display Images --}}
    @if(collect($maintenance->images ?? [])->where('category', 'led_display')->isNotEmpty())
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 mb-2">LED/Display Images:</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach(collect($maintenance->images ?? [])->where('category', 'led_display') as $image)
            <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                @if(isset($image['path']) && file_exists(storage_path('app/public/' . $image['path'])))
                <img src="{{ asset('storage/' . $image['path']) }}"
                    alt="LED Display"
                    class="w-full h-32 md:h-40 object-cover cursor-pointer"
                    onclick="window.open('{{ asset('storage/' . $image['path']) }}', '_blank')">
                @else
                <div class="w-full h-32 md:h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                    Image not found
                </div>
                @endif
                <div class="p-2 bg-gray-50">
                    <a href="{{ asset('storage/' . ($image['path'] ?? '')) }}"
                        target="_blank"
                        class="text-xs text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Battery Connection Images --}}
    @if(collect($maintenance->images ?? [])->where('category', 'battery_connection')->isNotEmpty())
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 mb-2">Battery Connection Images:</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach(collect($maintenance->images ?? [])->where('category', 'battery_connection') as $image)
            <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                @if(isset($image['path']) && file_exists(storage_path('app/public/' . $image['path'])))
                <img src="{{ asset('storage/' . $image['path']) }}"
                    alt="Battery Connection"
                    class="w-full h-32 md:h-40 object-cover cursor-pointer"
                    onclick="window.open('{{ asset('storage/' . $image['path']) }}', '_blank')">
                @else
                <div class="w-full h-32 md:h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                    Image not found
                </div>
                @endif
                <div class="p-2 bg-gray-50">
                    <a href="{{ asset('storage/' . ($image['path'] ?? '')) }}"
                        target="_blank"
                        class="text-xs text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

            <!-- 2. Performance and Capacity Check -->
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. Performance and Capacity Check</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border text-sm md:text-base">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left text-xs md:text-sm">Activity</th>
                                <th class="border p-2 text-left text-xs md:text-sm">Result</th>
                                <th class="border p-2 text-left text-xs md:text-sm">Operational Standard</th>
                                <th class="border p-2 text-center text-xs md:text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">a. AC Input Voltage</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ac_input_voltage ?? '-' }} VAC</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">180-240 VAC</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_ac_input_voltage == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ac_input_voltage }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. AC Current Input *)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->ac_current_input ?? '-' }} A</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">
                                    <div>≤ 5.5 A ( Single Power Module )</div>
                                    <div>≤ 11 A ( Dual Power Module )</div>
                                    <div>≤ 16.5 A ( Three Power Module )</div>
                                </td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_ac_current_input == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_ac_current_input }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. DC Current Output *)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->dc_current_output ?? '-' }} A</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">
                                    <div>≤ 25 A ( Single Power Module )</div>
                                    <div>≤ 50 A ( Dual Power Module )</div>
                                    <div>≤ 75 A ( Three Power Module )</div>
                                </td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_dc_current_output == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_dc_current_output }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">d. Battery Temperature</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->battery_temperature ?? '-' }} °C</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">0-30 °C</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_battery_temperature == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_battery_temperature }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">e. Charging Voltage DC</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->charging_voltage_dc ?? '-' }} VDC</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">48 ~ 55.3 VDC</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_charging_voltage_dc == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_charging_voltage_dc }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">f. Charging Current DC</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->charging_current_dc ?? '-' }} A</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">Max 10% Battery Capacity (AH)</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_charging_current_dc == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_charging_current_dc }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @php
                $performanceCategories = ['performance', 'ac_voltage', 'ac_current', 'dc_current', 'battery_temp', 'charging_voltage', 'charging_current'];
                $performanceImages = collect($maintenance->images ?? [])->whereIn('category', $performanceCategories);
                @endphp

                @if($performanceImages->isNotEmpty())
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Documentation Images:</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($performanceImages as $image)
                        <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                            @if(isset($image['path']) && file_exists(storage_path('app/public/' . $image['path'])))
                            <img src="{{ asset('storage/' . $image['path']) }}"
                                alt="{{ ucwords(str_replace('_', ' ', $image['category'] ?? '')) }}"
                                class="w-full h-32 md:h-40 object-cover cursor-pointer"
                                onclick="window.open('{{ asset('storage/' . $image['path']) }}', '_blank')">
                            @else
                            <div class="w-full h-32 md:h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                Image not found
                            </div>
                            @endif
                            <div class="p-2 bg-gray-50">
                                <p class="text-xs text-gray-600 mb-1">{{ ucwords(str_replace('_', ' ', $image['category'] ?? '')) }}</p>
                                <a href="{{ asset('storage/' . ($image['path'] ?? '')) }}"
                                    target="_blank"
                                    class="text-xs text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- 3. Backup Tests -->
<div class="mb-6">
    <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">3. Backup Tests</h3>
    <div class="overflow-x-auto">
        <table class="w-full border text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-left text-xs md:text-sm">Activity</th>
                    <th class="border p-2 text-left text-xs md:text-sm">Result</th>
                    <th class="border p-2 text-left text-xs md:text-sm">Operational Standard</th>
                    <th class="border p-2 text-center text-xs md:text-sm">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">a. Rectifier (turnoff test)</td>
                    <td class="border p-2 font-semibold">{{ $maintenance->backup_test_rectifier ?? '-' }}</td>
                    <td class="border p-2 text-xs md:text-sm text-gray-600">Rectifier Normal Operations</td>
                    <td class="border p-2 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_backup_test_rectifier == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $maintenance->status_backup_test_rectifier }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">b. Battery Voltage (Backup Mode)
                        <div class="text-xs text-gray-600 mt-1">
                            - Measurement I ( at the beginning ) Min 48 VDC
                        </div>
                        <div class="text-xs text-gray-600">
                            - Measurement II ( 15th minutes )
                        </div>
                    </td>

                    <td class="border p-2 font-semibold">
                        <div>Measurement I: {{ $maintenance->backup_test_voltage_measurement1 ?? '-' }} VDC</div>
                        <div class="mt-1">Measurement II: {{ $maintenance->backup_test_voltage_measurement2 ?? '-' }} VDC</div>
                    </td>
                    <td class="border p-2 text-xs md:text-sm text-gray-600">
                        <div>Min 48 VDC</div>
                        <div class="mt-1">Min 42 VDC</div>
                    </td>
                    <td class="border p-2 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_backup_test_voltage == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $maintenance->status_backup_test_voltage }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Rectifier Test Images --}}
    @php
        $rectifierTestImages = collect($maintenance->images ?? [])->filter(function($image) {
            return isset($image['category']) && $image['category'] === 'rectifier_test';
        });
    @endphp

    @if($rectifierTestImages->isNotEmpty())
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                a. Rectifier Switching Test Images ({{ $rectifierTestImages->count() }})
            </span>
        </p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($rectifierTestImages as $index => $image)
            <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition bg-white">
                @php
                    $imagePath = $image['path'] ?? '';
                    $fullPath = storage_path('app/public/' . $imagePath);
                    $imageExists = !empty($imagePath) && file_exists($fullPath);
                @endphp

                @if($imageExists)
                    <img src="{{ asset('storage/' . $imagePath) }}"
                        alt="Rectifier Test {{ $index + 1 }}"
                        class="w-full h-32 md:h-40 object-cover cursor-pointer hover:opacity-90 transition"
                        onclick="openImageModal(this.src, 'Rectifier Test {{ $index + 1 }}')"
                        loading="lazy">
                @else
                    <div class="w-full h-32 md:h-40 bg-gray-200 flex flex-col items-center justify-center text-gray-500 text-xs">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Image not found
                    </div>
                @endif

                <div class="p-2 bg-gray-50">
                    @if($imageExists)
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">Photo {{ $index + 1 }}</span>
                            @if(isset($image['lat']) && isset($image['lng']))
                                <span class="text-xs text-green-600 font-semibold" title="GPS Tagged">📍 GPS</span>
                            @endif
                        </div>

                        @if(isset($image['timestamp']))
                            <p class="text-[10px] text-gray-500 mb-1">
                                🕐 {{ \Carbon\Carbon::parse($image['timestamp'])->format('d M Y H:i') }}
                            </p>
                        @endif

                        <a href="{{ asset('storage/' . $imagePath) }}"
                            target="_blank"
                            class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 hover:underline">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Full Size
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Battery Voltage Measurement I Images --}}
    @php
        $batteryVoltageM1Images = collect($maintenance->images ?? [])->filter(function($image) {
            return isset($image['category']) && $image['category'] === 'battery_voltage_m1';
        });
    @endphp

    @if($batteryVoltageM1Images->isNotEmpty())
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                b. Battery Voltage - Measurement I (at the beginning) Images ({{ $batteryVoltageM1Images->count() }})
            </span>
        </p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($batteryVoltageM1Images as $index => $image)
            <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition bg-white">
                @php
                    $imagePath = $image['path'] ?? '';
                    $fullPath = storage_path('app/public/' . $imagePath);
                    $imageExists = !empty($imagePath) && file_exists($fullPath);
                @endphp

                @if($imageExists)
                    <img src="{{ asset('storage/' . $imagePath) }}"
                        alt="Battery Voltage M1 {{ $index + 1 }}"
                        class="w-full h-32 md:h-40 object-cover cursor-pointer hover:opacity-90 transition"
                        onclick="openImageModal(this.src, 'Battery Voltage Measurement I - Photo {{ $index + 1 }}')"
                        loading="lazy">
                @else
                    <div class="w-full h-32 md:h-40 bg-gray-200 flex flex-col items-center justify-center text-gray-500 text-xs">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Image not found
                    </div>
                @endif

                <div class="p-2 bg-gray-50">
                    @if($imageExists)
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">Measurement I - Photo {{ $index + 1 }}</span>
                            @if(isset($image['lat']) && isset($image['lng']))
                                <span class="text-xs text-green-600 font-semibold" title="GPS Tagged">📍 GPS</span>
                            @endif
                        </div>

                        @if(isset($image['timestamp']))
                            <p class="text-[10px] text-gray-500 mb-1">
                                🕐 {{ \Carbon\Carbon::parse($image['timestamp'])->format('d M Y H:i') }}
                            </p>
                        @endif

                        @if(isset($image['address']))
                            <p class="text-[10px] text-gray-500 mb-2 truncate" title="{{ $image['address'] }}">
                                📍 {{ $image['address'] }}
                            </p>
                        @endif

                        <a href="{{ asset('storage/' . $imagePath) }}"
                            target="_blank"
                            class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 hover:underline">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Full Size
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Battery Voltage Measurement II Images --}}
    @php
        $batteryVoltageM2Images = collect($maintenance->images ?? [])->filter(function($image) {
            return isset($image['category']) && $image['category'] === 'battery_voltage_m2';
        });
    @endphp

    @if($batteryVoltageM2Images->isNotEmpty())
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                b. Battery Voltage - Measurement II (15th minutes) Images ({{ $batteryVoltageM2Images->count() }})
            </span>
        </p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($batteryVoltageM2Images as $index => $image)
            <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition bg-white">
                @php
                    $imagePath = $image['path'] ?? '';
                    $fullPath = storage_path('app/public/' . $imagePath);
                    $imageExists = !empty($imagePath) && file_exists($fullPath);
                @endphp

                @if($imageExists)
                    <img src="{{ asset('storage/' . $imagePath) }}"
                        alt="Battery Voltage M2 {{ $index + 1 }}"
                        class="w-full h-32 md:h-40 object-cover cursor-pointer hover:opacity-90 transition"
                        onclick="openImageModal(this.src, 'Battery Voltage Measurement II - Photo {{ $index + 1 }}')"
                        loading="lazy">
                @else
                    <div class="w-full h-32 md:h-40 bg-gray-200 flex flex-col items-center justify-center text-gray-500 text-xs">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Image not found
                    </div>
                @endif

                <div class="p-2 bg-gray-50">
                    @if($imageExists)
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">Measurement II - Photo {{ $index + 1 }}</span>
                            @if(isset($image['lat']) && isset($image['lng']))
                                <span class="text-xs text-green-600 font-semibold" title="GPS Tagged">📍 GPS</span>
                            @endif
                        </div>

                        @if(isset($image['timestamp']))
                            <p class="text-[10px] text-gray-500 mb-1">
                                🕐 {{ \Carbon\Carbon::parse($image['timestamp'])->format('d M Y H:i') }}
                            </p>
                        @endif

                        @if(isset($image['address']))
                            <p class="text-[10px] text-gray-500 mb-2 truncate" title="{{ $image['address'] }}">
                                📍 {{ $image['address'] }}
                            </p>
                        @endif

                        <a href="{{ asset('storage/' . $imagePath) }}"
                            target="_blank"
                            class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 hover:underline">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Full Size
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- No Images Message --}}
    @if($rectifierTestImages->isEmpty() && $batteryVoltageM1Images->isEmpty() && $batteryVoltageM2Images->isEmpty())
    <div class="mt-4 p-3 bg-gray-100 border border-gray-300 rounded">
        <p class="text-sm text-gray-600 text-center">No backup test images available</p>
    </div>
    @endif
</div>

            <!-- 4. Power Alarm Monitoring Test -->
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">4. Power Alarm Monitoring Test</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border text-sm md:text-base">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left text-xs md:text-sm">Activity</th>
                                <th class="border p-2 text-left text-xs md:text-sm">Result</th>
                                <th class="border p-2 text-left text-xs md:text-sm">Operational Standard</th>
                                <th class="border p-2 text-center text-xs md:text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">
                                    <div class="text-xs md:text-sm leading-relaxed">
                                        Measure on-contact alarm monitor (turn off UPS power input MCB during backup test)
                                    </div>
                                </td>
                                <td class="border p-2 font-semibold">{{ $maintenance->power_alarm_test ?? '-' }}</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">Simonica Alarm Monitor fault conditions ( Red Sign )</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $maintenance->status_power_alarm_test == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_power_alarm_test }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if(collect($maintenance->images ?? [])->where('category', 'alarm')->isNotEmpty())
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Documentation Images:</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach(collect($maintenance->images ?? [])->where('category', 'alarm') as $image)
                        <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                            @if(isset($image['path']) && file_exists(storage_path('app/public/' . $image['path'])))
                            <img src="{{ asset('storage/' . $image['path']) }}"
                                alt="Alarm Test"
                                class="w-full h-32 md:h-40 object-cover cursor-pointer"
                                onclick="window.open('{{ asset('storage/' . $image['path']) }}', '_blank')">
                            @else
                            <div class="w-full h-32 md:h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                Image not found
                            </div>
                            @endif
                            <div class="p-2 bg-gray-50">
                                <a href="{{ asset('storage/' . ($image['path'] ?? '')) }}"
                                    target="_blank"
                                    class="text-xs text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Notes -->
            @if($maintenance->notes)
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Notes / additional informations</h3>
                <div class="border p-3 md:p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap text-sm md:text-base">{{ $maintenance->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Personnel Information - SHOW VERSION -->
<div class="mb-6">
    <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Personnel Information</h3>

    <!-- Pelaksana Section -->
    <div class="mb-4">
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Pelaksana:</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
            <!-- Pelaksana 1 -->
            <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-3 rounded">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                    <p class="text-xs md:text-sm text-gray-600 font-medium">Pelaksana 1</p>
                </div>
                <p class="font-semibold text-sm md:text-base">{{ $maintenance->executor_1 }}</p>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="inline-block mr-1">📋</span>
                    Dept: {{ $maintenance->executor_1_department ?? '-' }}
                </p>
            </div>

            <!-- Pelaksana 2 -->
            @if($maintenance->executor_2)
            <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-3 rounded">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                    <p class="text-xs md:text-sm text-gray-600 font-medium">Pelaksana 2</p>
                </div>
                <p class="font-semibold text-sm md:text-base">{{ $maintenance->executor_2 }}</p>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="inline-block mr-1">📋</span>
                    Dept: {{ $maintenance->executor_2_department ?? '-' }}
                </p>
            </div>
            @endif

            <!-- Pelaksana 3 -->
            @if($maintenance->executor_3)
            <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-3 rounded">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                    <p class="text-xs md:text-sm text-gray-600 font-medium">Pelaksana 3</p>
                </div>
                <p class="font-semibold text-sm md:text-base">{{ $maintenance->executor_3 }}</p>
                <p class="text-xs text-gray-500 mt-2">
                    <span class="inline-block mr-1">📋</span>
                    Dept: {{ $maintenance->executor_3_department ?? '-' }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Supervisor Section -->
    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <h4 class="text-sm font-semibold text-gray-700">Supervisor (Mengetahui)</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-gray-600">Nama Supervisor</p>
                <p class="font-semibold text-sm md:text-base mt-1">{{ $maintenance->supervisor }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-600">ID Number / NIK</p>
                <p class="font-semibold text-sm md:text-base mt-1">{{ $maintenance->supervisor_id_number ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-600">Department</p>
                <p class="font-semibold text-sm md:text-base mt-1">{{ $maintenance->department ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Preventive Maintenance 3 Phase UPS
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header section with responsive layout -->
            <div class="mb-6 pb-4 border-b-2">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Detail Preventive Maintenance UPS 3 Phase</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('ups3.edit', $maintenance->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <a href="{{ route('ups3.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kembali
                        </a>
                        <a href="{{ route('ups3.print', $maintenance->id) }}" target="_blank" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Cetak PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- Informasi Lokasi dan Perangkat --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Lokasi dan Perangkat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Lokasi Sentral</p>
                        <p class="font-semibold">
                            @if($maintenance->central)
                                {{ $maintenance->central->nama }}
                                <span class="text-sm text-gray-600 font-normal">- {{ $maintenance->central->area }} ({{ $maintenance->central->id_sentral }})</span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Date / Time</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($maintenance->date_time)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Brand / Type</p>
                        <p class="font-semibold">{{ $maintenance->brand_type }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Kapasitas</p>
                        <p class="font-semibold">{{ $maintenance->capacity }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Reg. Number</p>
                        <p class="font-semibold">{{ $maintenance->reg_number ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
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
                                <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $imagePath) }}', 'Image {{ $index + 1 }}')">
                                    <img src="{{ asset('storage/' . $imagePath) }}"
                                         alt="Documentation Image {{ $index + 1 }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500\'>Image not found</div>'">
                                    <div class="p-2 bg-gray-50">
                                        <p class="text-xs text-gray-600 mb-1">Image {{ $index + 1 }}</p>
                                        <span class="text-sm text-blue-600 hover:text-blue-800 hover:underline">Click to view</span>
                                    </div>
                                </div>
                            @elseif(is_array($imagePath) && isset($imagePath['path']))
                                {{-- Support old format with category structure --}}
                                <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $imagePath['path']) }}', '{{ $imagePath['category'] ?? 'Documentation Image' }}')">
                                    <img src="{{ asset('storage/' . $imagePath['path']) }}"
                                         alt="{{ $imagePath['category'] ?? 'Documentation Image' }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500\'>Image not found</div>'">
                                    <div class="p-2 bg-gray-50">
                                        @if(isset($imagePath['category']))
                                            <p class="text-xs text-gray-600 mb-1">{{ ucwords(str_replace('_', ' ', $imagePath['category'])) }}</p>
                                        @endif
                                        <span class="text-sm text-blue-600 hover:text-blue-800 hover:underline">Click to view</span>
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

    {{-- Image Modal --}}
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full w-10 h-10 flex items-center justify-center text-2xl z-10">
                ×
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
            <div id="modalCaption" class="text-white text-center mt-4 text-lg font-medium"></div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc, caption) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');

            modalImage.src = imageSrc;
            modalCaption.textContent = caption.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            modal.classList.remove('hidden');

            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');

            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Preventive Maintenance AC
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header section with responsive layout -->
            <div class="mb-6 pb-4 border-b-2">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Detail Preventive Maintenance AC</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('ac.edit', $maintenance->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <a href="{{ route('ac.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kembali
                        </a>
                        <a href="{{ route('ac.print', $maintenance->id) }}" target="_blank" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
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
                                {{ $maintenance->central->nama }} - {{ $maintenance->central->area }} ({{ $maintenance->central->id_sentral }})
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

            {{-- Physical Check --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">1. Physical Check</h3>
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
                                <td class="border p-2">a. Environment Condition</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->environment_condition }}</td>
                                <td class="border p-2 text-sm text-gray-600">No dust</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_environment_condition ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_environment_condition ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Filter</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->filter }}</td>
                                <td class="border p-2 text-sm text-gray-600">Clean, No dust</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_filter ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_filter ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Evaporator</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->evaporator }}</td>
                                <td class="border p-2 text-sm text-gray-600">Clean, No dust</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_evaporator ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_evaporator ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">d. LED & display (include remote control)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->led_display }}</td>
                                <td class="border p-2 text-sm text-gray-600">Normal</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_led_display ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_led_display ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">e. Air Flow</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->air_flow }}</td>
                                <td class="border p-2 text-sm text-gray-600">Fan operates normally, cool air flow</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_air_flow ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_air_flow ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PSI Pressure --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. PSI Pressure</h3>
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
                                <td class="border p-2">Standard PSI Pressure Form Type Freon</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->psi_pressure ?? '-' }} psi</td>
                                <td class="border p-2 text-sm text-gray-600">R32: 140 psi - 150 psi / R410: 140 psi - 150 psi</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_psi_pressure ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_psi_pressure ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Input Current Air Cond --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">3. Input Current Air Cond</h3>
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
                                <td class="border p-2">Input Current AC</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->input_current_ac ?? '-' }} A</td>
                                <td class="border p-2 text-sm text-gray-600">¾-1 PK ≤ 4 A | 2 PK ≤ 10 A</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_input_current_ac ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_input_current_ac ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Output Temperature AC --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">4. Output Temperature AC</h3>
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
                                <td class="border p-2">Output Temperature AC</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->output_temperature_ac ?? '-' }} °C</td>
                                <td class="border p-2 text-sm text-gray-600">16 - 20°C</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_output_temperature_ac ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_output_temperature_ac ?? '-' }}
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

                // Group images by category for better organization
                $groupedImages = [];
                foreach ($images as $img) {
                    if (is_array($img) && isset($img['category']) && isset($img['path'])) {
                        $category = $img['category'];
                        if (!isset($groupedImages[$category])) {
                            $groupedImages[$category] = [];
                        }
                        $groupedImages[$category][] = $img;
                    }
                }
            @endphp

            @if(!empty($images) && count($images) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 bg-blue-50 p-3 rounded">Documentation Images</h3>

                    {{-- Display all images in horizontal order --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($images as $index => $img)
                            @if(is_string($img))
                                {{-- Handle simple string path --}}
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $img) }}', 'Image {{ $index + 1 }}')">
                                    <div class="relative bg-gray-100 aspect-video">
                                        <img src="{{ asset('storage/' . $img) }}"
                                            alt="Documentation Image {{ $index + 1 }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm\'>Image not found</div>'">
                                    </div>
                                    <div class="p-3 bg-white">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Image {{ $index + 1 }}</p>
                                        <span class="text-sm text-blue-600 hover:text-blue-800 hover:underline inline-block">
                                            Click to view
                                        </span>
                                    </div>
                                </div>
                            @elseif(is_array($img) && isset($img['path']))
                                {{-- Handle array with path and category --}}
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $img['path']) }}', '{{ $img['category'] ?? 'Documentation Image' }}')">
                                    <div class="relative bg-gray-100 aspect-video">
                                        <img src="{{ asset('storage/' . $img['path']) }}"
                                            alt="{{ $img['category'] ?? 'Documentation Image' }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm\'>Image not found</div>'">
                                    </div>
                                    <div class="p-3 bg-white">
                                        @if(isset($img['category']))
                                            <p class="text-sm font-medium text-gray-700 mb-1">
                                                {{ ucwords(str_replace('_', ' ', $img['category'])) }}
                                            </p>
                                        @endif
                                        <span class="text-sm text-blue-600 hover:text-blue-800 hover:underline inline-block">
                                            Click to view
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Personnel --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-indigo-50 p-2 rounded">Pelaksana</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="border p-3 rounded">
                            <p class="text-sm text-gray-600">Pelaksana {{ $i }}</p>
                            <p class="font-semibold mt-1">{{ $maintenance->{'executor_'.$i} ?? '-' }}</p>
                            @if($maintenance->{'executor_'.$i})
                                <p class="text-xs text-gray-500 mt-1">{{ $maintenance->{'mitra_internal_'.$i} ?? '-' }}</p>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Mengetahui --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-indigo-50 p-2 rounded">Mengetahui</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border p-3 rounded bg-blue-50">
                        <p class="text-sm text-gray-600">Verifikator</p>
                        <p class="font-semibold mt-1">{{ $maintenance->verifikator ?? '-' }}</p>
                        @if($maintenance->verifikator_nik)
                            <p class="text-xs text-gray-500 mt-1">NIK: {{ $maintenance->verifikator_nik }}</p>
                        @endif
                    </div>
                    <div class="border p-3 rounded bg-blue-50">
                        <p class="text-sm text-gray-600">Head of Sub Department</p>
                        <p class="font-semibold mt-1">{{ $maintenance->head_of_sub_department ?? '-' }}</p>
                        @if($maintenance->head_of_sub_department_nik)
                            <p class="text-xs text-gray-500 mt-1">NIK: {{ $maintenance->head_of_sub_department_nik }}</p>
                        @endif
                    </div>
                </div>
            </div>
    </div>

    {{-- Image Modal for Full View --}}
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


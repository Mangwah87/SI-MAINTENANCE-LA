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
                <h3 class="text-lg font-semibold mb-3 bg-green-50 p-2 rounded">1. Visual Check</h3>
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
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_environment_condition ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_environment_condition ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Filter</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->filter }}</td>
                                <td class="border p-2 text-sm text-gray-600">Clean, No dust</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_filter ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_filter ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Evaporator</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->evaporator }}</td>
                                <td class="border p-2 text-sm text-gray-600">Clean, No dust</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_evaporator ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_evaporator ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">d. LED & display (include remote control)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->led_display }}</td>
                                <td class="border p-2 text-sm text-gray-600">Normal</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_led_display ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_led_display ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">e. Air Flow</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->air_flow }}</td>
                                <td class="border p-2 text-sm text-gray-600">Fan operates normally, cool air flow</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_air_flow ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_air_flow ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Room Temperature --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-purple-50 p-2 rounded">2. Room Temperature Shelter/ODC</h3>
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
                                <td class="border p-2">a. Shelter/Ruangan (ODC)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->temp_shelter }} °C</td>
                                <td class="border p-2 text-sm text-gray-600">≤ 22 °C Shelter/Ruangan</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_temp_shelter ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_temp_shelter ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Outdoor Cabinet (ODC)</td>
                                <td class="border p-2 font-semibold">{{ $maintenance->temp_outdoor_cabinet }} °C</td>
                                <td class="border p-2 text-sm text-gray-600">≤ 28 °C Outdoor Cabinet (ODC)</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($maintenance->status_temp_outdoor_cabinet ?? 'OK') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $maintenance->status_temp_outdoor_cabinet ?? 'OK' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Input Current Air Cond --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-orange-50 p-2 rounded">3. Input Current Air Cond</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left">AC Unit</th>
                                <th class="border p-2 text-left">Input Current (Amp)</th>
                                <th class="border p-2 text-left">Operational Standard</th>
                                <th class="border p-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 7; $i++)
                                @php
                                    $currentField = "ac{$i}_current";
                                    $statusField = "status_ac{$i}";
                                    $currentValue = $maintenance->{$currentField};
                                    $statusValue = $maintenance->{$statusField};

                                    // Determine standard based on AC number
                                    $standard = match($i) {
                                        1 => '¾-1 PK ≤ 4 A',
                                        2 => '2 PK ≤ 10 A',
                                        3 => '2.5 PK ≤ 13.5 A',
                                        4 => '5-7 PK ≤ 8 A / Phase',
                                        5 => '10 PK ≤ 15 A / Phase',
                                        6 => '15 PK ≤ 25 A / Phase',
                                        7 => 'Sesuai kapasitas AC',
                                        default => 'Sesuai kapasitas AC'
                                    };
                                @endphp

                                @if($currentValue !== null || $statusValue !== null)
                                    <tr>
                                        <td class="border p-2 font-semibold">AC {{ $i }}</td>
                                        <td class="border p-2">{{ $currentValue ?? '-' }} A</td>
                                        <td class="border p-2 text-sm text-gray-600">{{ $standard }}</td>
                                        <td class="border p-2 text-center">
                                            @if($statusValue)
                                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusValue === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $statusValue }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if($maintenance->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-yellow-50 p-2 rounded">Notes / Additional Informations</h3>
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
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Documentation Images</h3>

                    @if(!empty($groupedImages))
                        {{-- Display images grouped by category --}}
                        @foreach($groupedImages as $category => $categoryImages)
                            <div class="mb-6">
                                <h4 class="text-md font-semibold mb-2 text-gray-700 border-l-4 border-blue-500 pl-2">
                                    {{ ucwords(str_replace('_', ' ', $category)) }}
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($categoryImages as $index => $img)
                                        <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                                            <img src="{{ asset('storage/' . $img['path']) }}"
                                                 alt="{{ $category }}"
                                                 class="w-full h-48 object-cover cursor-pointer"
                                                 onclick="openImageModal('{{ asset('storage/' . $img['path']) }}')"
                                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-xs\'>Image not found</div>'">
                                            <div class="p-2 bg-gray-50">
                                                @if(isset($img['timestamp']))
                                                    <p class="text-xs text-gray-500 mb-1">
                                                        {{ \Carbon\Carbon::parse($img['timestamp'])->format('d/m/Y H:i') }}
                                                    </p>
                                                @endif
                                                <a href="{{ asset('storage/' . $img['path']) }}"
                                                   target="_blank"
                                                   class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Fallback: display all images without grouping --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($images as $index => $imagePath)
                                @if(is_string($imagePath))
                                    <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                                        <img src="{{ asset('storage/' . $imagePath) }}"
                                             alt="Documentation Image {{ $index + 1 }}"
                                             class="w-full h-48 object-cover cursor-pointer"
                                             onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')"
                                             onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-xs\'>Image not found</div>'">
                                        <div class="p-2 bg-gray-50">
                                            <p class="text-xs text-gray-600 mb-1">Image {{ $index + 1 }}</p>
                                            <a href="{{ asset('storage/' . $imagePath) }}"
                                               target="_blank"
                                               class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                                        </div>
                                    </div>
                                @elseif(is_array($imagePath) && isset($imagePath['path']))
                                    <div class="border rounded overflow-hidden shadow-sm hover:shadow-md transition">
                                        <img src="{{ asset('storage/' . $imagePath['path']) }}"
                                             alt="{{ $imagePath['category'] ?? 'Documentation Image' }}"
                                             class="w-full h-48 object-cover cursor-pointer"
                                             onclick="openImageModal('{{ asset('storage/' . $imagePath['path']) }}')"
                                             onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-xs\'>Image not found</div>'">
                                        <div class="p-2 bg-gray-50">
                                            @if(isset($imagePath['category']))
                                                <p class="text-xs text-gray-600 mb-1">{{ ucwords(str_replace('_', ' ', $imagePath['category'])) }}</p>
                                            @endif
                                            @if(isset($imagePath['timestamp']))
                                                <p class="text-xs text-gray-500 mb-1">
                                                    {{ \Carbon\Carbon::parse($imagePath['timestamp'])->format('d/m/Y H:i') }}
                                                </p>
                                            @endif
                                            <a href="{{ asset('storage/' . $imagePath['path']) }}"
                                               target="_blank"
                                               class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Full Size</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Personnel --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-indigo-50 p-2 rounded">Pelaksana / Mengetahui</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 1</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_1 ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                    </div>
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 2</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_2 ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                    </div>
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 3</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_3 ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                    </div>
                    <div class="border p-3 rounded bg-blue-50 md:col-span-3">
                        <p class="text-sm text-gray-600">Mengetahui (Supervisor)</p>
                        <p class="font-semibold mt-1">{{ $maintenance->supervisor ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">ID: {{ $maintenance->supervisor_id_number ?? '-' }}</p>
                    </div>
                </div>
            </div>
    </div>

    {{-- Image Modal for Full View --}}
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 z-10">&times;</button>
            <img id="modalImage" src="" alt="Full Size Image" class="max-w-full max-h-screen object-contain">
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>

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
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="font-semibold">{{ $maintenance->location }}</p>
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
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. Room Temperature Shelter/ODC</h3>
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

            {{-- Input Current Air Cond - Show All 7 Standards --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">3. Input Current Air Cond</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 p-2 text-left">AC Unit</th>
                                <th class="border border-gray-300 p-2 text-left">Input Current (Amp)</th>
                                <th class="border border-gray-300 p-2 text-left">Operational Standard</th>
                                <th class="border border-gray-300 p-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Define all AC standards
                                $acStandards = [
                                    1 => ['label' => '', 'standard' => '¾-1 PK ≤ 4 A'],
                                    2 => ['label' => '', 'standard' => '2 PK ≤ 10 A'],
                                    3 => ['label' => '', 'standard' => '2.5 PK ≤ 13.5 A'],
                                    4 => ['label' => '', 'standard' => '5-7 PK ≤ 8 A / Phase'],
                                    5 => ['label' => '', 'standard' => '10 PK ≤ 15 A / Phase'],
                                    6 => ['label' => '', 'standard' => '15 PK ≤ 25 A / Phase'],
                                    7 => ['label' => '', 'standard' => '']
                                ];
                            @endphp

                            @foreach($acStandards as $acNum => $acInfo)
                                @php
                                    $currentField = "ac{$acNum}_current";
                                    $statusField = "status_ac{$acNum}";
                                    $currentValue = $maintenance->{$currentField} ?? null;
                                    $statusValue = $maintenance->{$statusField} ?? '-';

                                    // Determine if this is the last row for border styling
                                    $isLast = ($acNum === 7);
                                    $borderClass = $isLast ? 'border border-gray-300' : 'border-l border-r border-t border-gray-300';
                                @endphp
                                <tr class="{{ $currentValue ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="{{ $borderClass }} p-2 font-semibold">AC {{ $acNum }} = {{ $acInfo['label'] }}</td>
                                    <td class="{{ $borderClass }} p-2">{{ $currentValue ? $currentValue . ' Amp' : '-' }}</td>
                                    <td class="{{ $borderClass }} p-2 text-sm text-gray-600">{{ $acInfo['standard'] }}</td>
                                    <td class="{{ $borderClass }} p-2 text-center">
                                        @if($currentValue)
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusValue === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $statusValue }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="relative bg-gray-100 aspect-video">
                                        <img src="{{ asset('storage/' . $img) }}"
                                            alt="Documentation Image {{ $index + 1 }}"
                                            class="w-full h-full object-cover cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $img) }}')"
                                            onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm\'>Image not found</div>'">
                                    </div>
                                    <div class="p-3 bg-white">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Image {{ $index + 1 }}</p>
                                        <a href="{{ asset('storage/' . $img) }}"
                                        target="_blank"
                                        class="text-sm text-blue-600 hover:text-blue-800 hover:underline inline-block">
                                            View Full Size
                                        </a>
                                    </div>
                                </div>
                            @elseif(is_array($img) && isset($img['path']))
                                {{-- Handle array with path and category --}}
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="relative bg-gray-100 aspect-video">
                                        <img src="{{ asset('storage/' . $img['path']) }}"
                                            alt="{{ $img['category'] ?? 'Documentation Image' }}"
                                            class="w-full h-full object-cover cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $img['path']) }}')"
                                            onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm\'>Image not found</div>'">
                                    </div>
                                    <div class="p-3 bg-white">
                                        @if(isset($img['category']))
                                            <p class="text-sm font-medium text-gray-700 mb-1">
                                                {{ ucwords(str_replace('_', ' ', $img['category'])) }}
                                            </p>
                                        @endif
                                        <a href="{{ asset('storage/' . $img['path']) }}"
                                        target="_blank"
                                        class="text-sm text-blue-600 hover:text-blue-800 hover:underline inline-block">
                                            View Full Size
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Personnel --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-indigo-50 p-2 rounded">Pelaksana / Mengetahui</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 1</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_1 ?? '-' }}</p>
                        @if($maintenance->executor_1)
                            <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                        @endif
                    </div>
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 2</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_2 ?? '-' }}</p>
                        @if($maintenance->executor_2)
                            <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                        @endif
                    </div>
                    <div class="border p-3 rounded">
                        <p class="text-sm text-gray-600">Pelaksana 3</p>
                        <p class="font-semibold mt-1">{{ $maintenance->executor_3 ?? '-' }}</p>
                        @if($maintenance->executor_3)
                            <p class="text-xs text-gray-500 mt-2">Departemen: {{ $maintenance->department ?? '-' }} | Sub Dept: {{ $maintenance->sub_department ?? '-' }}</p>
                        @endif
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

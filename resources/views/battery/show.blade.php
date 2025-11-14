<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Battery Maintenance
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 md:p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b-2 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Detail Battery Maintenance</h2>
                    <div class="text-xs md:text-sm text-gray-600 mt-2">
                        <p>No. Dok: FM-LAP-D2-SOP-003-013 | Versi: 1.0 | Hal: 1 dari 1 | Label: Internal</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('battery.edit', $maintenance->id) }}"
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('battery.pdf', $maintenance->id) }}"
                        target="_blank"
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition" target="_blank">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('battery.index') }}"
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm rounded">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 bg-grey-50 border-l-4 border-grey-500 text-grey-700 p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            <!-- Informasi Dokumen -->
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Dokumen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <!-- <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">No. Dokumen</p>
                        <p class="font-semibold text-sm md:text-base text-blue-700">{{ $maintenance->doc_number }}</p>
                    </div> -->
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Location</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->location }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Date / Time</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->maintenance_date->format('d/m/Y H:i') }} WIB</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Battery Temperature</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->battery_temperature ? $maintenance->battery_temperature . ' °C' : '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Battery Brand</p>
                        <p class="font-semibold text-sm md:text-base">
                            @if($maintenance->readings->isNotEmpty())
                            {{ $maintenance->readings->first()->battery_brand ?? '-' }}
                            @else
                            -
                            @endif
                        </p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Company</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->company ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 bg-gray-50 p-2 rounded">
                        <p class="text-xs md:text-sm text-gray-600">Total Battery</p>
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->readings->count() }} Battery</p>
                    </div>
                </div>
            </div>

            <!-- Battery Readings by Bank -->
            @php
            $readingsByBank = $maintenance->readings->groupBy('bank_number')->sortKeys();
            @endphp

            @foreach($readingsByBank as $bankNumber => $readings)
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Bank {{ $bankNumber }} - {{ $readings->first()->battery_brand }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border text-sm md:text-base">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left text-xs md:text-sm">No</th>
                                <th class="border p-2 text-left text-xs md:text-sm">Voltage (VDC)</th>
                                <th class="border p-2 text-left text-xs md:text-sm">Operational Standard</th>
                                <th class="border p-2 text-center text-xs md:text-sm">Status</th>
                                <th class="border p-2 text-center text-xs md:text-sm">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($readings->sortBy('battery_number') as $reading)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="border p-2 font-semibold">{{ $reading->battery_number }}</td>
                                <td class="border p-2 font-semibold">{{ number_format($reading->voltage, 2) }} VDC</td>
                                <td class="border p-2 text-xs md:text-sm text-gray-600">Min 10.0 VDC</td>
                                <td class="border p-2 text-center">
                                    @if($reading->voltage >= 12.0)
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">Good</span>
                                    @elseif($reading->voltage >= 10.0)
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">Warning</span>
                                    @else
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">Critical</span>
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                    <button type="button" onclick="showPhotoModal('{{ Storage::url($reading->photo_path) }}', '{{ $reading->photo_latitude }}', '{{ $reading->photo_longitude }}', '{{ $reading->photo_timestamp }}', 'Bank {{ $bankNumber }} - No. {{ $reading->battery_number }}')"
                                        class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Lihat Foto
                                    </button>
                                    @else
                                    <span class="text-xs text-gray-400">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            <!-- Notes Section -->
            @if($maintenance->notes)
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Notes / Additional Informations</h3>
                <div class="border p-3 md:p-4 rounded bg-gray-50">
                    <p class="whitespace-pre-wrap text-sm md:text-base">{{ $maintenance->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Pelaksana Information -->
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Pelaksana</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                    @if($maintenance->technician_1_name)
                    <div class="border p-3 rounded bg-gray-50">
                        <p class="text-xs md:text-sm text-gray-600">Pelaksana 1</p>
                        <p class="font-semibold mt-1 text-sm md:text-base">{{ $maintenance->technician_1_name }}</p>
                        <p class="text-xs text-gray-500 mt-2">Department: {{ $maintenance->technician_1_company ?? '-' }}</p>
                    </div>
                    @endif

                    @if($maintenance->technician_2_name)
                    <div class="border p-3 rounded bg-gray-50">
                        <p class="text-xs md:text-sm text-gray-600">Pelaksana 2</p>
                        <p class="font-semibold mt-1 text-sm md:text-base">{{ $maintenance->technician_2_name }}</p>
                        <p class="text-xs text-gray-500 mt-2">Department: {{ $maintenance->technician_2_company ?? '-' }}</p>
                    </div>
                    @endif

                    @if($maintenance->technician_3_name)
                    <div class="border p-3 rounded bg-gray-50">
                        <p class="text-xs md:text-sm text-gray-600">Pelaksana 3</p>
                        <p class="font-semibold mt-1 text-sm md:text-base">{{ $maintenance->technician_3_name }}</p>
                        <p class="text-xs text-gray-500 mt-2">Department: {{ $maintenance->technician_3_company ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <!-- Supervisor/Mengetahui Section -->
            @if($maintenance->supervisor || $maintenance->supervisor_id)
            <div class="mb-6">
                <h3 class="text-base md:text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Mengetahui</h3>
                <div class="border p-3 rounded bg-gray-50">
                    @if($maintenance->supervisor)
                        <p class="font-semibold text-sm md:text-base">{{ $maintenance->supervisor }}</p>
                        <p class="text-xs text-gray-500 mt-1">Supervisor / Atasan</p>
                    @endif

                    @if($maintenance->supervisor_id)
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <p class="text-xs text-gray-600">ID Supervisor</p>
                            <p class="font-medium text-sm">{{ $maintenance->supervisor_id }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full z-50 transition-opacity duration-300" onclick="closePhotoModal()">
        <div class="relative top-10 mx-auto p-6 border w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 shadow-2xl rounded-xl bg-white animate-fade-in-down" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Dokumentasi Foto Battery</h3>
                    <p id="modalTitle" class="text-sm text-gray-600 mt-1"></p>
                </div>
                <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 hover:bg-gray-100 rounded-full">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Image -->
            <div class="mt-4 mb-4">
                <img id="modalImage" src="" alt="Battery Photo" class="w-full h-auto max-h-[70vh] object-contain rounded-lg shadow-lg bg-gray-100">
            </div>

            <!-- Info -->
            <div id="modalInfo" class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200"></div>
        </div>
    </div>

    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.3s ease-out;
        }

        #photoModal.show {
            display: block !important;
        }
    </style>

    <script>
        function showPhotoModal(imageSrc, lat, lng, timestamp, title) {
            document.getElementById('modalTitle').textContent = title || '';
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;

            let infoHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">';

            if (lat && lng) {
                const latitude = parseFloat(lat).toFixed(6);
                const longitude = parseFloat(lng).toFixed(6);
                infoHtml += `
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-700">Koordinat GPS</p>
                            <p class="text-gray-600">Lat: ${latitude}</p>
                            <p class="text-gray-600">Lng: ${longitude}</p>
                            <a href="https://www.google.com/maps?q=${latitude},${longitude}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs mt-1 inline-block">
                                Buka di Google Maps →
                            </a>
                        </div>
                    </div>
                `;
            }

            if (timestamp) {
                const date = new Date(timestamp);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                const formattedTime = date.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });

                infoHtml += `
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-purple-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-700">Waktu Pengambilan</p>
                            <p class="text-gray-600">${formattedDate}</p>
                            <p class="text-gray-600">${formattedTime} WIB</p>
                        </div>
                    </div>
                `;
            }

            infoHtml += '</div>';

            if (!lat && !lng && !timestamp) {
                infoHtml = '<p class="text-gray-500 text-center py-2">Tidak ada informasi tambahan</p>';
            }

            document.getElementById('modalInfo').innerHTML = infoHtml;

            const modal = document.getElementById('photoModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('show'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.remove('show');
            setTimeout(() => modal.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePhotoModal();
            }
        });
    </script>
</x-app-layout>

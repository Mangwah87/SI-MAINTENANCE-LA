<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Battery Maintenance') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('battery.pdf', $maintenance->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors duration-200" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('battery.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            <!-- Header Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-blue-600">Informasi Dokumen</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">No. Dokumen</label>
                            <p class="text-lg font-bold text-blue-700">{{ $maintenance->doc_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Location</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->location }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Date / Time</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->maintenance_date->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Battery Temperature</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->battery_temperature ? $maintenance->battery_temperature . ' °C' : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Battery Brand</label>
                            <p class="text-lg text-gray-800 font-semibold text-grey-600">
                                @if($maintenance->readings->isNotEmpty())
                                {{ $maintenance->readings->first()->battery_brand ?? '-' }}
                                @else
                                -
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Company</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->company ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Total Battery</label>
                            <p class="text-lg text-gray-800 font-bold">{{ $maintenance->readings->count() }} Battery</p>
                        </div>

                        <!-- Technicians Section -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pelaksana</label>
                            <div class="bg-gradient-to-r from-green-50 to-teal-50 p-4 rounded-lg border border-green-200">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @if($maintenance->technician_1_name)
                                    <div class="flex items-start">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-600 text-white font-bold text-sm mr-3 flex-shrink-0">1</span>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $maintenance->technician_1_name }}</p>
                                            <p class="text-xs text-gray-600">{{ $maintenance->technician_1_company ?? '-' }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($maintenance->technician_2_name)
                                    <div class="flex items-start">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-600 text-white font-bold text-sm mr-3 flex-shrink-0">2</span>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $maintenance->technician_2_name }}</p>
                                            <p class="text-xs text-gray-600">{{ $maintenance->technician_2_company ?? '-' }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($maintenance->technician_3_name)
                                    <div class="flex items-start">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-600 text-white font-bold text-sm mr-3 flex-shrink-0">3</span>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $maintenance->technician_3_name }}</p>
                                            <p class="text-xs text-gray-600">{{ $maintenance->technician_3_company ?? '-' }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($maintenance->notes)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Notes / Additional Informations</label>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $maintenance->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Battery Readings by Bank -->
            @php
            $readingsByBank = $maintenance->readings->groupBy('bank_number')->sortKeys();
            @endphp

            @foreach($readingsByBank as $bankNumber => $readings)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Bank {{ $bankNumber }} - {{ $readings->first()->battery_brand }}</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Voltage (VDC)</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Foto</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($readings->sortBy('battery_number') as $reading)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $reading->battery_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($reading->voltage, 1) }} VDC
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reading->voltage >= 12.0)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Good
                                        </span>
                                        @elseif($reading->voltage >= 10.0)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Warning
                                        </span>
                                        @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Critical
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($reading->photo_path && Storage::disk('public')->exists($reading->photo_path))
                                        <button type="button" onclick="showPhotoModal('{{ Storage::url($reading->photo_path) }}', '{{ $reading->photo_latitude }}', '{{ $reading->photo_longitude }}', '{{ $reading->photo_timestamp }}', 'Bank {{ $bankNumber }} - No. {{ $reading->battery_number }}')"
                                            class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-150">
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
            </div>
            @endforeach

            <!-- Notes Section -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-semibold">Catatan:</p>
                        <ul class="text-sm text-yellow-700 mt-1 list-disc list-inside">
                            <li>Measurement with load test (backup test UPS)</li>
                            <li>Standard minimum: <strong>10 VDC</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

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
            // Set title
            document.getElementById('modalTitle').textContent = title || '';

            // Set image
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;

            // Build info HTML
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

            // Show modal with fade effect
            const modal = document.getElementById('photoModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('show'), 10);

            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.remove('show');
            setTimeout(() => modal.classList.add('hidden'), 300);

            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePhotoModal();
            }
        });
    </script>
</x-app-layout>

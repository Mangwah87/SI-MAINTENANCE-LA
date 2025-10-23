<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Battery Maintenance') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('battery.pdf', $maintenance->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors duration-200" target="_blank">
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
                <div class="p-6 bg-gradient-to-r from-blue-50 to-white-450 border-b border-gray-200">
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
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Technician</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->technician_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Company</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->company ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Total Battery</label>
                            <p class="text-lg text-gray-800">{{ $maintenance->readings->count() }} Battery</p>
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
                                        <button onclick="showPhotoModal('{{ Storage::url($reading->photo_path) }}', '{{ $reading->photo_latitude }}', '{{ $reading->photo_longitude }}', '{{ $reading->photo_timestamp }}')"
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
    <div id="photoModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50" onclick="closePhotoModal()">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Dokumentasi Foto Battery</h3>
                <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-2">
                <img id="modalImage" src="" alt="Battery Photo" class="w-full h-auto rounded-lg">
                <div id="modalInfo" class="mt-4 p-3 bg-gray-100 rounded-lg text-sm text-gray-700"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showPhotoModal(imageSrc, lat, lng, timestamp) {
            document.getElementById('modalImage').src = imageSrc;

            let infoHtml = '';
            if (lat && lng) {
                infoHtml += `<p class="mb-2"><strong>📍 Koordinat:</strong> ${parseFloat(lat).toFixed(6)}, ${parseFloat(lng).toFixed(6)}</p>`;
            }
            if (timestamp) {
                const date = new Date(timestamp);
                infoHtml += `<p><strong>🕐 Waktu:</strong> ${date.toLocaleDateString('id-ID')} ${date.toLocaleTimeString('id-ID')}</p>`;
            }

            document.getElementById('modalInfo').innerHTML = infoHtml || '<p class="text-gray-500">Tidak ada informasi tambahan</p>';
            document.getElementById('photoModal').classList.remove('hidden');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>

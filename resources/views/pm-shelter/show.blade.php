<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail PM Ruang Shelter') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pm-shelter.export-pdf', $pmShelter) }}" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg inline-flex items-center text-sm">
                    <i data-lucide="download" class="w-4 h-4 mr-1"></i> Export PDF
                </a>
                <a href="{{ route('pm-shelter.edit', $pmShelter) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg inline-flex items-center text-sm">
                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                </a>
                <a href="{{ route('pm-shelter.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center text-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    
                    <!-- Location & Equipment Info -->
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 text-gray-700 border-b pb-2">
                            Informasi Lokasi & Perangkat
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-semibold">Lokasi:</span> {{ $pmShelter->location ?? '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">Tanggal:</span> {{ $pmShelter->date ? $pmShelter->date->format('d/m/Y') : '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">Waktu:</span> {{ $pmShelter->time ?? '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">Brand/Type:</span> {{ $pmShelter->brand_type ?? '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">Reg. Number:</span> {{ $pmShelter->reg_number ?? '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">S/N:</span> {{ $pmShelter->serial_number ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <!-- Check Results -->
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 text-gray-700 border-b pb-2">
                            Hasil Pemeriksaan
                        </h3>
                        
                        <!-- Visual Check Section -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 mb-3">1. Visual Check</h4>
                            
                            <!-- Kondisi Ruangan -->
                            <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-3">
                                    <div class="sm:col-span-2">
                                        <span class="font-semibold">a. Kondisi Ruangan</span>
                                        <p class="text-gray-600">{{ $pmShelter->kondisi_ruangan_result ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Status:</span>
                                        @if($pmShelter->kondisi_ruangan_status)
                                        <span class="px-2 py-1 text-xs rounded {{ $pmShelter->kondisi_ruangan_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->kondisi_ruangan_status }}
                                        </span>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                @if($pmShelter->kondisi_ruangan_photos && count($pmShelter->kondisi_ruangan_photos) > 0)
                                <div>
                                    <span class="font-semibold text-sm">Foto:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                        @foreach($pmShelter->kondisi_ruangan_photos as $photo)
                                        <div class="relative border rounded-lg overflow-hidden bg-white cursor-pointer group" onclick="viewPhoto('{{ asset('storage/' . $photo['path']) }}', @json($photo))">
                                            <img src="{{ asset('storage/' . $photo['path']) }}" class="w-full h-32 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                <i data-lucide="zoom-in" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-all"></i>
                                            </div>
                                            @if(isset($photo['location_name']) || isset($photo['latitude']))
                                            <div class="p-2 text-xs bg-white">
                                                @if(isset($photo['location_name']))
                                                <div class="truncate" title="{{ $photo['location_name'] }}">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> {{ $photo['location_name'] }}
                                                </div>
                                                @endif
                                                @if(isset($photo['taken_at']))
                                                <div class="text-gray-600 truncate">
                                                    <i data-lucide="clock" class="w-3 h-3 inline"></i> {{ \Carbon\Carbon::parse($photo['taken_at'])->format('d/m/Y H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Kondisi Kunci -->
                            <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-3">
                                    <div class="sm:col-span-2">
                                        <span class="font-semibold">b. Kondisi Kunci Ruang/Shelter</span>
                                        <p class="text-gray-600">{{ $pmShelter->kondisi_kunci_result ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Status:</span>
                                        @if($pmShelter->kondisi_kunci_status)
                                        <span class="px-2 py-1 text-xs rounded {{ $pmShelter->kondisi_kunci_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->kondisi_kunci_status }}
                                        </span>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                @if($pmShelter->kondisi_kunci_photos && count($pmShelter->kondisi_kunci_photos) > 0)
                                <div>
                                    <span class="font-semibold text-sm">Foto:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                        @foreach($pmShelter->kondisi_kunci_photos as $photo)
                                        <div class="relative border rounded-lg overflow-hidden bg-white cursor-pointer group" onclick="viewPhoto('{{ asset('storage/' . $photo['path']) }}', @json($photo))">
                                            <img src="{{ asset('storage/' . $photo['path']) }}" class="w-full h-32 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                <i data-lucide="zoom-in" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-all"></i>
                                            </div>
                                            @if(isset($photo['location_name']) || isset($photo['latitude']))
                                            <div class="p-2 text-xs bg-white">
                                                @if(isset($photo['location_name']))
                                                <div class="truncate" title="{{ $photo['location_name'] }}">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> {{ $photo['location_name'] }}
                                                </div>
                                                @endif
                                                @if(isset($photo['taken_at']))
                                                <div class="text-gray-600 truncate">
                                                    <i data-lucide="clock" class="w-3 h-3 inline"></i> {{ \Carbon\Carbon::parse($photo['taken_at'])->format('d/m/Y H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Fasilitas Ruangan Section -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 mb-3">2. Fasilitas Ruangan</h4>
                            
                            <!-- Layout Tata Ruang -->
                            <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-3">
                                    <div class="sm:col-span-2">
                                        <span class="font-semibold">a. Layout / Tata Ruang</span>
                                        <p class="text-gray-600">{{ $pmShelter->layout_tata_ruang_result ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Status:</span>
                                        @if($pmShelter->layout_tata_ruang_status)
                                        <span class="px-2 py-1 text-xs rounded {{ $pmShelter->layout_tata_ruang_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->layout_tata_ruang_status }}
                                        </span>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                @if($pmShelter->layout_tata_ruang_photos && count($pmShelter->layout_tata_ruang_photos) > 0)
                                <div>
                                    <span class="font-semibold text-sm">Foto:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                        @foreach($pmShelter->layout_tata_ruang_photos as $photo)
                                        <div class="relative border rounded-lg overflow-hidden bg-white cursor-pointer group" onclick="viewPhoto('{{ asset('storage/' . $photo['path']) }}', @json($photo))">
                                            <img src="{{ asset('storage/' . $photo['path']) }}" class="w-full h-32 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                <i data-lucide="zoom-in" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-all"></i>
                                            </div>
                                            @if(isset($photo['location_name']) || isset($photo['latitude']))
                                            <div class="p-2 text-xs bg-white">
                                                @if(isset($photo['location_name']))
                                                <div class="truncate" title="{{ $photo['location_name'] }}">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> {{ $photo['location_name'] }}
                                                </div>
                                                @endif
                                                @if(isset($photo['taken_at']))
                                                <div class="text-gray-600 truncate">
                                                    <i data-lucide="clock" class="w-3 h-3 inline"></i> {{ \Carbon\Carbon::parse($photo['taken_at'])->format('d/m/Y H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Kontrol Keamanan -->
                            <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-3">
                                    <div class="sm:col-span-2">
                                        <span class="font-semibold">b. Kontrol Keamanan</span>
                                        <p class="text-gray-600">{{ $pmShelter->kontrol_keamanan_result ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Status:</span>
                                        @if($pmShelter->kontrol_keamanan_status)
                                        <span class="px-2 py-1 text-xs rounded {{ $pmShelter->kontrol_keamanan_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->kontrol_keamanan_status }}
                                        </span>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                @if($pmShelter->kontrol_keamanan_photos && count($pmShelter->kontrol_keamanan_photos) > 0)
                                <div>
                                    <span class="font-semibold text-sm">Foto:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                        @foreach($pmShelter->kontrol_keamanan_photos as $photo)
                                        <div class="relative border rounded-lg overflow-hidden bg-white cursor-pointer group" onclick="viewPhoto('{{ asset('storage/' . $photo['path']) }}', @json($photo))">
                                            <img src="{{ asset('storage/' . $photo['path']) }}" class="w-full h-32 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                <i data-lucide="zoom-in" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-all"></i>
                                            </div>
                                            @if(isset($photo['location_name']) || isset($photo['latitude']))
                                            <div class="p-2 text-xs bg-white">
                                                @if(isset($photo['location_name']))
                                                <div class="truncate" title="{{ $photo['location_name'] }}">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> {{ $photo['location_name'] }}
                                                </div>
                                                @endif
                                                @if(isset($photo['taken_at']))
                                                <div class="text-gray-600 truncate">
                                                    <i data-lucide="clock" class="w-3 h-3 inline"></i> {{ \Carbon\Carbon::parse($photo['taken_at'])->format('d/m/Y H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Aksesibilitas -->
                            <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-3">
                                    <div class="sm:col-span-2">
                                        <span class="font-semibold">c. Aksesibilitas</span>
                                        <p class="text-gray-600">{{ $pmShelter->aksesibilitas_result ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Status:</span>
                                        @if($pmShelter->aksesibilitas_status)
                                        <span class="px-2 py-1 text-xs rounded {{ $pmShelter->aksesibilitas_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->aksesibilitas_status }}
                                        </span>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                @if($pmShelter->aksesibilitas_photos && count($pmShelter->aksesibilitas_photos) > 0)
                                <div>
                                    <span class="font-semibold text-sm">Foto:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                        @foreach($pmShelter->aksesibilitas_photos as $photo)
                                        <div class="relative border rounded-lg overflow-hidden bg-white cursor-pointer group" onclick="viewPhoto('{{ asset('storage/' . $photo['path']) }}', @json($photo))">
                                            <img src="{{ asset('storage/' . $photo['path']) }}" class="w-full h-32 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                <i data-lucide="zoom-in" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-all"></i>
                                            </div>
                                            @if(isset($photo['location_name']) || isset($photo['latitude']))
                                            <div class="p-2 text-xs bg-white">
                                                @if(isset($photo['location_name']))
                                                <div class="truncate" title="{{ $photo['location_name'] }}">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> {{ $photo['location_name'] }}
                                                </div>
                                                @endif
                                                @if(isset($photo['taken_at']))
                                                <div class="text-gray-600 truncate">
                                                    <i data-lucide="clock" class="w-3 h-3 inline"></i> {{ \Carbon\Carbon::parse($photo['taken_at'])->format('d/m/Y H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Aspek Teknis -->
                            <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-3">
                                    <div class="sm:col-span-2">
                                        <span class="font-semibold">d. Aspek Teknis</span>
                                        <p class="text-gray-600">{{ $pmShelter->aspek_teknis_result ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Status:</span>
                                        @if($pmShelter->aspek_teknis_status)
                                        <span class="px-2 py-1 text-xs rounded {{ $pmShelter->aspek_teknis_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->aspek_teknis_status }}
                                        </span>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                @if($pmShelter->aspek_teknis_photos && count($pmShelter->aspek_teknis_photos) > 0)
                                <div>
                                    <span class="font-semibold text-sm">Foto:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                        @foreach($pmShelter->aspek_teknis_photos as $photo)
                                        <div class="relative border rounded-lg overflow-hidden bg-white cursor-pointer group" onclick="viewPhoto('{{ asset('storage/' . $photo['path']) }}', @json($photo))">
                                            <img src="{{ asset('storage/' . $photo['path']) }}" class="w-full h-32 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                <i data-lucide="zoom-in" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-all"></i>
                                            </div>
                                            @if(isset($photo['location_name']) || isset($photo['latitude']))
                                            <div class="p-2 text-xs bg-white">
                                                @if(isset($photo['location_name']))
                                                <div class="truncate" title="{{ $photo['location_name'] }}">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> {{ $photo['location_name'] }}
                                                </div>
                                                @endif
                                                @if(isset($photo['taken_at']))
                                                <div class="text-gray-600 truncate">
                                                    <i data-lucide="clock" class="w-3 h-3 inline"></i> {{ \Carbon\Carbon::parse($photo['taken_at'])->format('d/m/Y H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($pmShelter->notes)
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Catatan</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 p-4 rounded-lg">{{ $pmShelter->notes }}</p>
                    </div>
                    @endif

                    <!-- Executors -->
                    @if($pmShelter->executors && count($pmShelter->executors) > 0)
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Pelaksana</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departemen</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sub Departemen</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pmShelter->executors as $index => $executor)
                                    <tr>
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">{{ $executor['name'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $executor['department'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $executor['sub_department'] ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Approver -->
                    @if($pmShelter->approver_name)
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Mengetahui</h3>
                        <p class="text-sm bg-gray-50 p-4 rounded-lg">{{ $pmShelter->approver_name }}</p>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closePhotoModal()">
        <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
            <div class="flex justify-end mb-2">
                <button onclick="closePhotoModal()" class="text-white hover:text-gray-300">
                    <i data-lucide="x" class="w-8 h-8"></i>
                </button>
            </div>
            <img id="modalImage" src="" class="w-full h-auto rounded">
            <div id="modalInfo" class="mt-4 bg-white rounded p-4 text-sm"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        function viewPhoto(imageSrc, photoData) {
            const modal = document.getElementById('photoModal');
            const modalImage = document.getElementById('modalImage');
            const modalInfo = document.getElementById('modalInfo');
            
            modalImage.src = imageSrc;
            
            let infoHTML = '';
            if (photoData.location_name) {
                infoHTML += `<div class="mb-2"><i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i> <strong>Lokasi:</strong> ${photoData.location_name}</div>`;
            }
            if (photoData.latitude) {
                infoHTML += `<div class="mb-2"><i data-lucide="navigation" class="w-4 h-4 inline"></i> <strong>Koordinat:</strong> ${photoData.latitude.toFixed(6)}, ${photoData.longitude.toFixed(6)}</div>`;
            }
            if (photoData.taken_at) {
                const date = new Date(photoData.taken_at);
                infoHTML += `<div><i data-lucide="clock" class="w-4 h-4 inline"></i> <strong>Waktu:</strong> ${date.toLocaleString('id-ID', { timeZone: 'Asia/Makassar' })} WITA</div>`;
            }
            
            modalInfo.innerHTML = infoHTML || '<div class="text-gray-500">Tidak ada informasi tambahan</div>';
            
            modal.classList.remove('hidden');
            lucide.createIcons();
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePhotoModal();
            }
        });

        lucide.createIcons();
    </script>
    @endpush
</x-app-layout>
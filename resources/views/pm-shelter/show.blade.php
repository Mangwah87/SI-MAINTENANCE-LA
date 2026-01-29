<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Preventive Maintenance Ruang Shelter
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header with Responsive Buttons -->
            <div class="mb-6 pb-4 border-b-2">
                <!-- Desktop Layout -->
                <div class="hidden sm:flex justify-between items-center">
                    <!-- Back Button -->
                    <a href="{{ route('pm-shelter.index') }}"
                        class="inline-flex items-center bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Kembali
                    </a>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <!-- Edit Button -->
                        <a href="{{ route('pm-shelter.edit', $pmShelter) }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                            Edit
                        </a>

                        <!-- Print PDF Button -->
                        <a href="{{ route('pm-shelter.export-pdf', $pmShelter) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Cetak PDF
                        </a>
                    </div>
                </div>

                <!-- Mobile Layout -->
                <div class="flex sm:hidden justify-between items-center gap-2">
                    <!-- Back Button - Icon Only -->
                    <a href="{{ route('pm-shelter.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 bg-gray-500 text-white rounded-lg hover:bg-gray-700 transition"
                        title="Kembali">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 flex-1">
                        <!-- Edit Button -->
                        <a href="{{ route('pm-shelter.edit', $pmShelter) }}"
                            class="inline-flex items-center justify-center flex-1 px-3 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm font-medium"
                            title="Edit">
                            <i data-lucide="edit" class="w-4 h-4 mr-1.5"></i>
                            Edit
                        </a>

                        <!-- Print PDF Button -->
                        <a href="{{ route('pm-shelter.export-pdf', $pmShelter) }}" target="_blank"
                            class="inline-flex items-center justify-center flex-1 px-3 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium"
                            title="Cetak PDF">
                            <i data-lucide="download" class="w-4 h-4 mr-1.5"></i>
                            PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- Informasi Lokasi dan Perangkat --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Lokasi dan Perangkat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Lokasi</p>
                        @if ($pmShelter->central)
                            <p class="font-semibold"> {{ $pmShelter->central->nama }} -
                                {{ $pmShelter->central->area }} - ({{ $pmShelter->central->id_sentral }})
                            </p>
                            <p class="text-xs text-gray-500 mt-1"></p>
                        @else
                            <p class="font-semibold">{{ $pmShelter->location ?? '-' }}</p>
                        @endif
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-semibold">{{ $pmShelter->date ? $pmShelter->date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Waktu</p>
                        <p class="font-semibold">{{ $pmShelter->time ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Brand / Type</p>
                        <p class="font-semibold">{{ $pmShelter->brand_type ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Reg. Number</p>
                        <p class="font-semibold">{{ $pmShelter->reg_number ?? '-' }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">S/N</p>
                        <p class="font-semibold">{{ $pmShelter->serial_number ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Visual Check --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">1. Visual Check</h3>
                <div class="overflow-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left w-1/4">Item Pemeriksaan</th>
                                <th class="border p-2 text-left w-1/3">Hasil</th>
                                <th class="border p-2 text-center">Status</th>
                                <th class="border p-2 text-center">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">a. Kondisi Ruangan</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->kondisi_ruangan_result ?? '-' }}
                                </td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->kondisi_ruangan_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->kondisi_ruangan_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->kondisi_ruangan_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $kondisiRuanganPhotos = collect($pmShelter->photos ?? [])->where('field', 'kondisi_ruangan_photos');
                                    @endphp
                                    @if ($kondisiRuanganPhotos->count() > 0)
                                        <button onclick="showPhotos('kondisi_ruangan_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $kondisiRuanganPhotos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Kondisi Kunci Ruang/Shelter</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->kondisi_kunci_result ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->kondisi_kunci_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->kondisi_kunci_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->kondisi_kunci_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $kondisiKunciPhotos = collect($pmShelter->photos ?? [])->where('field', 'kondisi_kunci_photos');
                                    @endphp
                                    @if ($kondisiKunciPhotos->count() > 0)
                                        <button onclick="showPhotos('kondisi_kunci_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $kondisiKunciPhotos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Fasilitas Ruangan --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">2. Fasilitas Ruangan</h3>
                <div class="overflow-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left w-1/4">Item Pemeriksaan</th>
                                <th class="border p-2 text-left w-1/3">Hasil</th>
                                <th class="border p-2 text-center">Status</th>
                                <th class="border p-2 text-center">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">a. Layout / Tata Ruang</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->layout_tata_ruang_result ?? '-' }}
                                </td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->layout_tata_ruang_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->layout_tata_ruang_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->layout_tata_ruang_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $layoutPhotos = collect($pmShelter->photos ?? [])->where('field', 'layout_tata_ruang_photos');
                                    @endphp
                                    @if ($layoutPhotos->count() > 0)
                                        <button onclick="showPhotos('layout_tata_ruang_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $layoutPhotos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Kontrol Keamanan</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->kontrol_keamanan_result ?? '-' }}
                                </td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->kontrol_keamanan_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->kontrol_keamanan_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->kontrol_keamanan_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $kontrolPhotos = collect($pmShelter->photos ?? [])->where('field', 'kontrol_keamanan_photos');
                                    @endphp
                                    @if ($kontrolPhotos->count() > 0)
                                        <button onclick="showPhotos('kontrol_keamanan_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $kontrolPhotos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Aksesibilitas</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->aksesibilitas_result ?? '-' }}
                                </td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->aksesibilitas_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->aksesibilitas_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->aksesibilitas_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $aksesibilitasPhotos = collect($pmShelter->photos ?? [])->where('field', 'aksesibilitas_photos');
                                    @endphp
                                    @if ($aksesibilitasPhotos->count() > 0)
                                        <button onclick="showPhotos('aksesibilitas_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $aksesibilitasPhotos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">d. Aspek Teknis</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->aspek_teknis_result ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->aspek_teknis_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->aspek_teknis_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->aspek_teknis_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $aspekTeknisPhotos = collect($pmShelter->photos ?? [])->where('field', 'aspek_teknis_photos');
                                    @endphp
                                    @if ($aspekTeknisPhotos->count() > 0)
                                        <button onclick="showPhotos('aspek_teknis_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $aspekTeknisPhotos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Room Temperature --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">3. Suhu Ruangan</h3>
                <div class="overflow-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left w-1/4">Item Pemeriksaan</th>
                                <th class="border p-2 text-left w-1/3">Hasil</th>
                                <th class="border p-2 text-center">Status</th>
                                <th class="border p-2 text-center">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">a. Shelter Room </td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->room_temp_1_result ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->room_temp_1_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->room_temp_1_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->room_temp_1_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $roomTemp1Photos = collect($pmShelter->photos ?? [])->where('field', 'room_temp_1_photos');
                                    @endphp
                                    @if ($roomTemp1Photos->count() > 0)
                                        <button onclick="showPhotos('room_temp_1_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $roomTemp1Photos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Outdoor Cabinet</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->room_temp_2_result ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->room_temp_2_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->room_temp_2_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->room_temp_2_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $roomTemp2Photos = collect($pmShelter->photos ?? [])->where('field', 'room_temp_2_photos');
                                    @endphp
                                    @if ($roomTemp2Photos->count() > 0)
                                        <button onclick="showPhotos('room_temp_2_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $roomTemp2Photos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Pole Outdoor Cabinet</td>
                                <td class="border p-2 font-semibold">{{ $pmShelter->room_temp_3_result ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    @if ($pmShelter->room_temp_3_status)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $pmShelter->room_temp_3_status == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pmShelter->room_temp_3_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2 text-center">
                                    @php
                                        $roomTemp3Photos = collect($pmShelter->photos ?? [])->where('field', 'room_temp_3_photos');
                                    @endphp
                                    @if ($roomTemp3Photos->count() > 0)
                                        <button onclick="showPhotos('room_temp_3_photos')"
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1.5 shadow-sm hover:bg-blue-200 transition">
                                            <i data-lucide="image" class="w-3 h-3"></i> Lihat
                                            ({{ $roomTemp3Photos->count() }})
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if ($pmShelter->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Catatan / Informasi Tambahan</h3>
                    <div class="border p-4 rounded">
                        <p class="whitespace-pre-wrap">{{ $pmShelter->notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Pelaksana --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Pelaksana</h3>

                @if ($pmShelter->executors && count($pmShelter->executors) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-{{ count($pmShelter->executors) > 2 ? '3' : '2' }} gap-4 mb-4">
                        @foreach ($pmShelter->executors as $index => $executor)
                            <div class="border p-3 rounded">
                                <p class="text-sm text-gray-600">Pelaksana {{ $index + 1 }}</p>
                                <p class="font-semibold mt-1">{{ $executor['name'] ?? '-' }}</p>
                                @if(isset($executor['mitra']))
                                    <p class="text-xs text-gray-500 mt-2">Mitra: {{ $executor['mitra'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Mengetahui (Verifikator & Head of Sub Dept) --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Mengetahui</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Verifikator --}}
                    @if ($pmShelter->verifikator)
                        <div class="border p-3 rounded">
                            <p class="text-sm text-gray-600">Verifikator</p>
                            <p class="font-semibold mt-1">{{ $pmShelter->verifikator['name'] ?? '-' }}</p>
                            @if(isset($pmShelter->verifikator['nik']))
                                <p class="text-xs text-gray-500 mt-2">NIK: {{ $pmShelter->verifikator['nik'] }}</p>
                            @endif
                        </div>
                    @endif

                    {{-- Head of Sub Department --}}
                    @if ($pmShelter->head_of_sub_dept)
                        <div class="border p-3 rounded">
                            <p class="text-sm text-gray-600">Head of Sub Department</p>
                            <p class="font-semibold mt-1">{{ $pmShelter->head_of_sub_dept['name'] ?? '-' }}</p>
                            @if(isset($pmShelter->head_of_sub_dept['nik']))
                                <p class="text-xs text-gray-500 mt-2">NIK: {{ $pmShelter->head_of_sub_dept['nik'] }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Photo Modal --}}
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4"
        onclick="closePhotoModal()">
        <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-white text-xl font-semibold"></h3>
                <button onclick="closePhotoModal()" class="text-white hover:text-gray-300">
                    <i data-lucide="x" class="w-8 h-8"></i>
                </button>
            </div>
            <div id="photoGallery"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[80vh] overflow-y-auto">
                <!-- Photos will be inserted here -->
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Prepare photo data dari struktur baru (photos array dengan field identifier)
            const allPhotos = @json($pmShelter->photos ?? []);
            
            const photoData = {
                kondisi_ruangan_photos: allPhotos.filter(p => p.field === 'kondisi_ruangan_photos'),
                kondisi_kunci_photos: allPhotos.filter(p => p.field === 'kondisi_kunci_photos'),
                layout_tata_ruang_photos: allPhotos.filter(p => p.field === 'layout_tata_ruang_photos'),
                kontrol_keamanan_photos: allPhotos.filter(p => p.field === 'kontrol_keamanan_photos'),
                aksesibilitas_photos: allPhotos.filter(p => p.field === 'aksesibilitas_photos'),
                aspek_teknis_photos: allPhotos.filter(p => p.field === 'aspek_teknis_photos'),
                room_temp_1_photos: allPhotos.filter(p => p.field === 'room_temp_1_photos'),
                room_temp_2_photos: allPhotos.filter(p => p.field === 'room_temp_2_photos'),
                room_temp_3_photos: allPhotos.filter(p => p.field === 'room_temp_3_photos')
            };

            const titleMap = {
                kondisi_ruangan_photos: 'Kondisi Ruangan',
                kondisi_kunci_photos: 'Kondisi Kunci Ruang/Shelter',
                layout_tata_ruang_photos: 'Layout / Tata Ruang',
                kontrol_keamanan_photos: 'Kontrol Keamanan',
                aksesibilitas_photos: 'Aksesibilitas',
                aspek_teknis_photos: 'Aspek Teknis',
                room_temp_1_photos: 'Suhu Ruangan 1',
                room_temp_2_photos: 'Suhu Ruangan 2',
                room_temp_3_photos: 'Suhu Ruangan 3'
            };

            function showPhotos(category) {
                const modal = document.getElementById('photoModal');
                const gallery = document.getElementById('photoGallery');
                const modalTitle = document.getElementById('modalTitle');
                const photos = photoData[category] || [];

                modalTitle.textContent = titleMap[category] || 'Foto Dokumentasi';
                gallery.innerHTML = '';

                photos.forEach((photo, index) => {
                    const photoDiv = document.createElement('div');
                    photoDiv.className = 'border rounded overflow-hidden shadow-sm bg-white';

                    let photoHTML = `
                    <img src="{{ asset('storage/') }}/${photo.path}" 
                         alt="Photo ${index + 1}" 
                         class="w-full h-48 object-cover cursor-pointer"
                         onclick="viewFullPhoto('{{ asset('storage/') }}/${photo.path}')">
                    <div class="p-3">
                        <p class="text-xs text-gray-600 mb-2">Foto ${index + 1}</p>
                `;

                    if (photo.location_name) {
                        photoHTML += `
                        <div class="text-xs text-gray-700 mb-1">
                            <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> 
                            ${photo.location_name}
                        </div>
                    `;
                    }

                    if (photo.taken_at) {
                        const date = new Date(photo.taken_at);
                        photoHTML += `
                        <div class="text-xs text-gray-600">
                            <i data-lucide="clock" class="w-3 h-3 inline"></i> 
                            ${date.toLocaleString('id-ID', { timeZone: 'Asia/Makassar' })} WITA
                        </div>
                    `;
                    }

                    photoHTML += `
                        <a href="{{ asset('storage/') }}/${photo.path}" 
                           target="_blank" 
                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline mt-2 inline-block">
                            Lihat Ukuran Penuh
                        </a>
                    </div>
                `;

                    photoDiv.innerHTML = photoHTML;
                    gallery.appendChild(photoDiv);
                });

                modal.classList.remove('hidden');
                lucide.createIcons();
            }

            function viewFullPhoto(src) {
                window.open(src, '_blank');
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
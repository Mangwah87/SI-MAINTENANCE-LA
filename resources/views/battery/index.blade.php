<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Battery Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 md:mb-6 gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-800">Daftar Battery Maintenance</h3>
                            <p class="text-xs md:text-sm text-gray-600 mt-1">Total: {{ $maintenances->total() }} data</p>
                        </div>

                        <!-- Button Group -->
                        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                            <a href="{{ route('battery.create') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Data
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700 transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="mb-4 md:mb-6 bg-gray-50 rounded-lg p-3 md:p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs md:text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 md:w-5 md:h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter Pencarian
                            </h4>
                            <button type="button" id="toggleFilter" class="text-xs md:text-sm text-blue-600 hover:text-blue-800">
                                <span id="filterText">Tampilkan</span>
                            </button>
                        </div>

                        <form method="GET" action="{{ route('battery.index') }}" id="filterForm" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                                <!-- Location Filter -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Lokasi
                                    </label>
                                    <select name="location" id="location-filter"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">-- Semua Lokasi --</option>
                                        @foreach($centralsByArea as $area => $centrals)
                                            <optgroup label="AREA {{ $area }}">
                                                @foreach($centrals as $central)
                                                    <option value="{{ $central->id }}"
                                                        {{ request('location') == $central->id ? 'selected' : '' }}>
                                                        {{ $central->id_sentral }} - {{ $central->nama }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date From -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Dari Tanggal
                                    </label>
                                    <input type="date"
                                        name="date_from"
                                        value="{{ request('date_from') }}"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Date To -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Sampai Tanggal
                                    </label>
                                    <input type="date"
                                        name="date_to"
                                        value="{{ request('date_to') }}"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="flex flex-wrap gap-2 mt-4">
                                <button type="submit"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Cari
                                </button>
                                <a href="{{ route('battery.index') }}"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-md hover:bg-gray-300 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>

                                @if(request()->hasAny(['location', 'date_from', 'date_to']))
                                <span class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 text-sm text-gray-600 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Filter aktif
                                </span>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Table Section -->
                    @if($maintenances->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-150">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Battery</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($maintenances as $index => $maintenance)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenances->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        @if($maintenance->central)
                                            <div>
                                                <span class="font-semibold">{{ $maintenance->central->id_sentral }}</span>
                                                <span class="text-gray-600">- {{ $maintenance->central->nama }}</span>
                                            </div>
                                            <!-- <span class="text-xs text-gray-500">{{ $maintenance->central->area }}</span> -->
                                        @else
                                            <span class="text-red-500">ID: {{ $maintenance->location }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $maintenance->readings->count() }} Battery
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenance->maintenance_date->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('battery.show', $maintenance->id) }}"
                                                class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                            </a>
                                            <a href="{{ route('battery.edit', $maintenance->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                <i data-lucide="edit" class="w-5 h-5"></i>
                                            </a>
                                            <a href="{{ route('battery.pdf', $maintenance->id) }}"
                                                class="text-green-600 hover:text-green-900" title="Download PDF" target="_blank">
                                                <i data-lucide="file-down" class="w-5 h-5"></i>
                                            </a>
                                            <form action="{{ route('battery.destroy', $maintenance->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($maintenances as $index => $maintenance)
                        <div class="border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <!-- Card Header -->
                            <div class="bg-blue-100 px-4 py-3 border-b border-gray-200 rounded-t-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-600 text-white">
                                                #{{ $maintenances->firstItem() + $index }}
                                            </span>
                                            <span class="px-3 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $maintenance->readings->count() }} Battery
                                            </span>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 text-sm">
                                            @if($maintenance->central)
                                                {{ $maintenance->central->id_sentral }} - {{ $maintenance->central->nama }}
                                            @else
                                                ID: {{ $maintenance->location }}
                                            @endif
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="px-4 py-3 space-y-2.5">
                                <!-- Date -->
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500">Tanggal</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $maintenance->maintenance_date->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500">Lokasi</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            @if($maintenance->central)
                                                {{ $maintenance->central->id_sentral }} - {{ $maintenance->central->nama }}
                                            @else
                                                ID: {{ $maintenance->location }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer - Actions -->
                            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                                <div class="grid grid-cols-4 gap-2">
                                    <a href="{{ route('battery.show', $maintenance->id) }}"
                                        class="flex flex-col items-center justify-center py-2 text-blue-600 hover:bg-blue-50 rounded transition">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="text-xs">Detail</span>
                                    </a>
                                    <a href="{{ route('battery.edit', $maintenance->id) }}"
                                        class="flex flex-col items-center justify-center py-2 text-yellow-600 hover:bg-yellow-50 rounded transition">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    <a href="{{ route('battery.pdf', $maintenance->id) }}"
                                        target="_blank"
                                        class="flex flex-col items-center justify-center py-2 text-green-600 hover:bg-green-50 rounded transition">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-xs">PDF</span>
                                    </a>
                                    <form action="{{ route('battery.destroy', $maintenance->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex flex-col items-center justify-center py-2 text-red-600 hover:bg-red-50 rounded transition">
                                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="text-xs">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination (sisanya tetap sama) -->
                    <div class="mt-6">
                        {{ $maintenances->links() }}
                    </div>

                    @else
                    <!-- Empty State (tetap sama) -->
                    <div class="text-center py-12">
                        <p class="text-gray-500">Belum ada data</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleFilter').addEventListener('click', function() {
            const filterForm = document.getElementById('filterForm');
            const filterText = document.getElementById('filterText');

            if (filterForm.style.display === 'none') {
                filterForm.style.display = 'block';
                filterText.textContent = 'Sembunyikan';
            } else {
                filterForm.style.display = 'none';
                filterText.textContent = 'Tampilkan';
            }
        });
    </script>
</x-app-layout>

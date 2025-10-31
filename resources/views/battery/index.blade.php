<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Battery Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Battery Maintenance</h3>
                            <p class="text-sm text-gray-600 mt-1">Total: {{ $maintenances->total() }} data</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('battery.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Data
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">
                                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter Pencarian
                            </h4>
                            <button type="button" id="toggleFilter" class="text-sm text-blue-600 hover:text-blue-800">
                                <span id="filterText">Sembunyikan</span>
                            </button>
                        </div>

                        <form method="GET" action="{{ route('battery.index') }}" id="filterForm">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <!-- Doc Number -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Doc Number
                                    </label>
                                    <input type="text"
                                        name="doc_number"
                                        value="{{ request('doc_number') }}"
                                        placeholder="Cari doc number..."
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Location -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Lokasi
                                    </label>
                                    <input type="text"
                                        name="location"
                                        value="{{ request('location') }}"
                                        placeholder="Cari berdasarkan lokasi..."
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Cari
                                </button>
                                <a href="{{ route('battery.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-md hover:bg-gray-300 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>

                                @if(request()->hasAny(['doc_number', 'location', 'date_from', 'date_to']))
                                <span class="inline-flex items-center px-3 py-2 text-sm text-gray-600 bg-yellow-50 border border-yellow-200 rounded-md">
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
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <!-- <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Doc Number</th> -->
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
                                    <!-- <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-purple-600">
                                            {{ $maintenance->doc_number }}
                                        </div>
                                    </td> -->
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $maintenance->location }}
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
                                            <!-- View Button -->
                                            <a href="{{ route('battery.show', $maintenance->id) }}"
                                                class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('battery.edit', $maintenance->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                <i data-lucide="edit" class="w-5 h-5"></i>
                                            </a>

                                            <!-- PDF Button -->
                                            <a href="{{ route('battery.pdf', $maintenance->id) }}"
                                                class="text-green-600 hover:text-green-900" title="Download PDF" target="_blank">
                                                <i data-lucide="file-down" class="w-5 h-5"></i>
                                            </a>

                                            <!-- Delete Button -->
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

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $maintenances->appends(request()->query())->links() }}
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            @if(request()->hasAny(['doc_number', 'location', 'date_from', 'date_to']))
                            Tidak ada data yang sesuai dengan filter
                            @else
                            Belum ada data
                            @endif
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request()->hasAny(['doc_number', 'location', 'date_from', 'date_to']))
                            Coba ubah kriteria pencarian Anda.
                            @else
                            Mulai dengan menambahkan data battery maintenance baru.
                            @endif
                        </p>
                        <div class="mt-6">
                            @if(request()->hasAny(['doc_number', 'location', 'date_from', 'date_to']))
                            <a href="{{ route('battery.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 mr-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Filter
                            </a>
                            @endif
                            <a href="{{ route('battery.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle filter visibility
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Genset Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 mb-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Data Genset Maintenance</h3>

                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                            <a href="{{ route('genset.create') }}"
                                class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white text-sm sm:text-base font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <i data-lucide="plus" class="h-4 w-4 sm:h-5 sm:w-5 mr-2"></i>
                                Tambah Data
                            </a>

                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white text-sm sm:text-base font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <i data-lucide="arrow-left" class="h-4 w-4 sm:h-5 sm:w-5 mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
                         <div class="flex items-center">
                            <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="mb-6 relative">
                        <input type="text" id="searchInput" placeholder="Cari berdasarkan No Dok, Lokasi, Brand, Kapasitas..."
                               class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                             <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Doc Number</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Brand / Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Capacity</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @forelse($maintenances as $index => $maintenance)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 data-row"> {{-- Tambah class data-row --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenances->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-purple-600">
                                            {{ $maintenance->doc_number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenance->location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenance->brand_type ?? '-' }} {{-- Tambah null coalescing --}}
                                    </td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenance->capacity ?? '-' }} {{-- Tambah null coalescing --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $maintenance->maintenance_date->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('genset.show', $maintenance->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md shadow-sm" title="Lihat Detail">
                                                <i data-lucide="eye" class="h-4 w-4"></i>
                                            </a>
                                            <a href="{{ route('genset.edit', $maintenance->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded-md shadow-sm" title="Edit">
                                                <i data-lucide="edit-3" class="h-4 w-4"></i>
                                            </a>
                                            <a href="{{ route('genset.pdf', $maintenance->id) }}" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md shadow-sm" title="Download PDF" target="_blank">
                                                <i data-lucide="printer" class="h-4 w-4"></i>
                                            </a>
                                            <form action="{{ route('genset.destroy', $maintenance->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md shadow-sm" title="Hapus">
                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr id="noDataRow"> {{-- Tambah ID --}}
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                         <div class="flex flex-col items-center">
                                            <i data-lucide="database-zap" class="w-16 h-16 text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium">Belum Ada Data</p>
                                            <p class="text-sm mt-1">Klik "Tambah Data" untuk menambahkan data genset maintenance</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                                <tr id="noResultsRow" class="hidden">
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                         <div class="flex flex-col items-center">
                                            <i data-lucide="search-x" class="w-16 h-16 text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium">Tidak Ada Data Ditemukan</p>
                                            <p class="text-sm mt-1">Coba gunakan kata kunci lain.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($maintenances->hasPages())
                    <div class="mt-6">
                        {{ $maintenances->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Script Ikon & Search (BARU) --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Aktifkan Ikon Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // 2. Fungsi Search
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('tableBody');
            const dataRows = tableBody.querySelectorAll('tr.data-row'); // Hanya pilih baris data
            const noDataRow = document.getElementById('noDataRow'); // Baris "Belum Ada Data"
            const noResultsRow = document.getElementById('noResultsRow'); // Baris "Tidak Ditemukan"

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let found = false;

                dataRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = ''; // Tampilkan baris
                        found = true;
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                });

                // Tampilkan/sembunyikan pesan "Tidak Ditemukan"
                if (found) {
                    noResultsRow.classList.add('hidden');
                } else {
                    // Hanya tampilkan "Tidak Ditemukan" jika ada data asli
                    if (dataRows.length > 0) {
                         noResultsRow.classList.remove('hidden');
                    }
                }

                // Sembunyikan pesan "Belum Ada Data" jika ada filter aktif atau ada data
                if (noDataRow) {
                    if (searchTerm || dataRows.length > 0) {
                        noDataRow.style.display = 'none';
                    } else {
                        noDataRow.style.display = ''; // Tampilkan jika tidak ada data sama sekali
                    }
                }
            }

            // Tambahkan event listener ke input search
            if (searchInput) {
                searchInput.addEventListener('keyup', filterTable);
            }
        });
    </script>
    @endpush

</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Genset Maintenance') }}
            </h2>
            {{-- Tombol Add New (Biru, meniru UPS) --}}
            <a href="{{ route('genset.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                <i data-lucide="plus" class="h-4 w-4 mr-1 -ml-1"></i>
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Alert Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 shadow-sm" role="alert">
                    <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3 shadow-sm" role="alert">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Search Bar --}}
            <div class="mb-6 relative">
                <input type="text" id="searchInput" placeholder="Cari berdasarkan No Dok, Lokasi, Brand, Kapasitas..."
                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                     <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>

            <div class="hidden md:block bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Doc Number</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Brand / Type</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Capacity</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider pr-8">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                            @forelse($maintenances as $index => $maintenance)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 data-row">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $maintenances->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-semibold text-purple-600">{{ $maintenance->doc_number }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $maintenance->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $maintenance->brand_type ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $maintenance->capacity ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $maintenance->maintenance_date->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- [PERUBAHAN] Menggunakan ikon --}}
                                        <div class="flex justify-end gap-4 pr-2">
                                            <a href="{{ route('genset.show', $maintenance->id) }}" class="text-blue-600 hover:text-blue-800" title="View">
                                                <i data-lucide="eye" class="h-4 w-4"></i>
                                            </a>
                                            <a href="{{ route('genset.edit', $maintenance->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                                <i data-lucide="edit" class="h-4 w-4"></i>
                                            </a>
                                            <a href="{{ route('genset.pdf', $maintenance->id) }}" target="_blank" class="text-green-600 hover:text-green-800" title="PDF">
                                                <i data-lucide="file-down" class="h-4 w-4"></i>
                                            </a>
                                            <button onclick="deleteRecord({{ $maintenance->id }})" class="text-red-600 hover:text-red-800" title="Delete">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="noDataRow">
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500"><p class="text-lg">Belum ada data</p></td>
                                </tr>
                            @endforelse
                            <tr id="noResultsRow" class="hidden">
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500"><p class="text-lg">Tidak ada data ditemukan</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="md:hidden space-y-3" id="cardContainer">
                @forelse($maintenances as $index => $maintenance)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition data-row">
                        {{-- Baris Atas: Lokasi & Tanggal --}}
                        <div class="space-y-1 mb-3 pb-3 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900 text-base">
                                {{ $maintenance->location }}
                            </h3>
                            <p class="text-xs text-gray-500">{{ $maintenance->maintenance_date->format('d M Y, H:i') }}</p>
                        </div>

                        {{-- Baris Tengah: Details (Disesuaikan untuk Genset) --}}
                        <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                            <div>
                                <span class="text-gray-500 text-xs block">Doc Number:</span>
                                <p class="font-medium text-purple-600 text-xs mt-0.5 break-all">{{ $maintenance->doc_number }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-xs block">Brand:</span>
                                <p class="font-medium text-gray-900 mt-0.5">{{ $maintenance->brand_type ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-xs block">Capacity:</span>
                                <p class="font-medium text-gray-900 mt-0.5">{{ $maintenance->capacity ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Baris Bawah: Actions (Meniru layout UPS) --}}
                        <div class="flex justify-end gap-2 text-xs font-medium">
                            <a href="{{ route('genset.show', $maintenance->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('genset.edit', $maintenance->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <span class="text-gray-300">|</span>
                             <a href="{{ route('genset.pdf', $maintenance->id) }}" target="_blank" class="text-green-600 hover:text-green-800">PDF</a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('genset.destroy', $maintenance->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class_="text-red-600 hover:text-red-800 p-0 m-0 bg-transparent border-none font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div id="cardNoDataRow" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center"><i data-lucide="database-zap" class="w-16 h-16 text-gray-300 mb-4"></i><p class="text-lg font-medium">Belum Ada Data</p></div>
                    </div>
                @endforelse
                <div id="cardNoResultsRow" class="hidden px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center"><i data-lucide="search-x" class="w-16 h-16 text-gray-300 mb-4"></i><p class="text-lg font-medium">Tidak Ada Data Ditemukan</p></div>
                </div>
            </div>

            {{-- Pagination --}}
            @if($maintenances->hasPages())
            <div class="mt-6">
                {{ $maintenances->links() }}
            </div>
            @endif
        </div>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Record</h3>
            <p class="text-gray-600 text-sm mb-6">Are you sure you want to delete this maintenance record? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Ikon & Search (Diperbarui untuk memfilter tabel DAN kartu) --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Aktifkan Ikon Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // 2. Logika Modal Hapus
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            window.deleteRecord = function(id) {
                if (deleteForm) {
                    deleteForm.action = `/genset/${id}`; // [PERBAIKAN] Pastikan path ke 'genset'
                }
                if (deleteModal) {
                    deleteModal.classList.remove('hidden');
                }
            }

            window.closeDeleteModal = function() {
                if (deleteModal) {
                    deleteModal.classList.add('hidden');
                }
            }

            if (deleteModal) {
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeDeleteModal();
                    }
                });
            }


            // 3. Fungsi Search
            const searchInput = document.getElementById('searchInput');

            const tableBody = document.getElementById('tableBody');
            const tableRows = tableBody ? tableBody.querySelectorAll('tr.data-row') : [];
            const tableNoData = document.getElementById('noDataRow');
            const tableNoResults = document.getElementById('noResultsRow');

            const cardContainer = document.getElementById('cardContainer');
            const cardRows = cardContainer ? cardContainer.querySelectorAll('div.data-row') : [];
            const cardNoData = document.getElementById('cardNoDataRow');
            const cardNoResults = document.getElementById('cardNoResultsRow');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let tableFound = 0;
                let cardFound = 0;

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = ''; tableFound++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                cardRows.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = ''; cardFound++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (tableNoResults) tableNoResults.classList.toggle('hidden', tableFound > 0 || tableRows.length === 0);
                if (cardNoResults) cardNoResults.classList.toggle('hidden', cardFound > 0 || cardRows.length === 0);
                
                if (tableNoData) tableNoData.style.display = (searchTerm && tableRows.length > 0) ? 'none' : (tableRows.length > 0 ? 'none' : '');
                if (cardNoData) cardNoData.style.display = (searchTerm && cardRows.length > 0) ? 'none' : (cardRows.length > 0 ? 'none' : '');

                // Sembunyikan pesan "No Data" jika ada hasil pencarian
                if(tableFound > 0 && tableNoData) tableNoData.style.display = 'none';
                if(cardFound > 0 && cardNoData) cardNoData.style.display = 'none';
            }

            if (searchInput) {
                searchInput.addEventListener('keyup', filterTable);
            }
        });
    </script>
    @endpush

</x-app-layout>
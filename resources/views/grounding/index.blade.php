<x-app-layout>
    <x-slot name="header">
        {{-- Header dari PM-Shelter, diubah untuk Grounding --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PM Petir & Grounding') }} {{-- --}}
            </h2>
            <a href="{{ route('grounding.create') }}" {{-- --}}
               class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white 
                      px-4 py-2 rounded-lg text-sm font-medium transition w-full sm:w-auto justify-center sm:justify-start">
                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Alert Notifikasi (Dipertahankan dari file Grounding lama) --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 shadow-sm" role="alert"> {{-- --}}
                    <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3 shadow-sm" role="alert"> {{-- --}}
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Search Bar (Dipertahankan) --}}
            <div class="mb-6 relative">
                {{-- [UBAH] Placeholder disesuaikan --}}
                <input type="text" id="searchInput" placeholder="Cari berdasarkan Lokasi, Tanggal, atau Pelaksana..."
                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition shadow-sm"> {{-- --}}
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                     <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    
                    <div class="block lg:hidden space-y-4" id="cardContainer">
                        @forelse($maintenances as $maintenance) {{-- --}}
                            <div class="border rounded-lg p-4 bg-gray-50 shadow-sm data-row">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                #{{ $maintenances->firstItem() + $loop->index }} {{-- --}}
                                            </span>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1">
                                            <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                                            {{ $maintenance->location ?? '-' }} {{-- --}}
                                        </h3>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                                            {{ $maintenance->maintenance_date->format('d/m/Y • H:i') }} WITA {{-- --}}
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-3 pb-3 border-b">
                                    <p class="text-xs font-medium text-gray-500 mb-1">Pelaksana:</p>
                                    {{-- Adaptasi untuk data teknisi Grounding --}}
                                    @php
                                        $technicians = collect([
                                            ['name' => $maintenance->technician_1_name],
                                            ['name' => $maintenance->technician_2_name],
                                            ['name' => $maintenance->technician_3_name],
                                        ])->filter(fn($tech) => !empty($tech['name']));
                                    @endphp

                                    @if($technicians->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($technicians as $executor)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-50 text-blue-700">
                                                    <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                                    {{ $executor['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-4 gap-2">
                                    {{-- [UBAH] Routes --}}
                                    <a href="{{ route('grounding.show', $maintenance->id) }}" {{-- --}}
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i data-lucide="eye" class="w-4 h-4 mb-1"></i><span class="text-xs">Detail</span>
                                    </a>
                                    <a href="{{ route('grounding.edit', $maintenance->id) }}" {{-- --}}
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                        <i data-lucide="edit" class="w-4 h-4 mb-1"></i><span class="text-xs">Edit</span>
                                    </a>
                                    <a href="{{ route('grounding.pdf', $maintenance->id) }}" target="_blank" {{-- --}}
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                                        <i data-lucide="file-down" class="w-4 h-4 mb-1"></i><span class="text-xs">PDF</span>
                                    </a>
                                    <button type="button" onclick="deleteRecord({{ $maintenance->id }})" {{-- --}}
                                            class="w-full h-full flex flex-col items-center justify-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Hapus</span>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div id="cardNoDataRow" class="text-center py-12">
                                <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Tidak ada data</p>
                                <a href="{{ route('grounding.create') }}" {{-- --}}
                                   class="inline-flex items-center mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                    Tambah Data Pertama
                                </a>
                            </div>
                        @endforelse
                        <div id="cardNoResultsRow" class="hidden text-center py-12"> {{-- --}}
                            <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada data ditemukan</p>
                        </div>
                    </div>

                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal / Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelaksana</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @forelse($maintenances as $maintenance) {{-- --}}
                                    <tr class="hover:bg-gray-50 transition data-row">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $maintenances->firstItem() + $loop->index }} {{-- --}}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-start">
                                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                                                <span>{{ $maintenance->location ?? '-' }}</span> {{-- --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                                                <div>
                                                    <div>{{ $maintenance->maintenance_date->format('d/m/Y') }}</div> {{-- --}}
                                                    <div class="text-xs text-gray-500 mt-0.5">
                                                        {{ $maintenance->maintenance_date->format('H:i') }} WITA
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Kolom Pelaksana (Struktur dari PM-Shelter) --}}
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @php
                                                $technicians = collect([
                                                    ['name' => $maintenance->technician_1_name],
                                                    ['name' => $maintenance->technician_2_name],
                                                    ['name' => $maintenance->technician_3_name],
                                                ])->filter(fn($tech) => !empty($tech['name']));
                                            @endphp

                                            @if($technicians->isNotEmpty())
                                                <div class="space-y-1">
                                                    @foreach($technicians as $executor)
                                                        <div class="flex items-center">
                                                            <i data-lucide="user" class="w-3 h-3 mr-1 text-blue-500"></i>
                                                            <span>{{ $executor['name'] }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- [UBAH] Routes --}}
                                                <a href="{{ route('grounding.show', $maintenance->id) }}" {{-- --}}
                                                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                   title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('grounding.edit', $maintenance->id) }}" {{-- --}}
                                                   class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                   title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('grounding.pdf', $maintenance->id) }}" target="_blank" {{-- --}}
                                                   class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                   title="Download PDF">
                                                    <i data-lucide="file-down" class="w-4 h-4"></i>
                                                </a>
                                                <button type="button" onclick="deleteRecord({{ $maintenance->id }})" {{-- --}}
                                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="noDataRow"> {{-- --}}
                                        {{-- [UBAH] Colspan disesuaikan (5 kolom) --}}
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 mb-4">Tidak ada data</p>
                                            <a href="{{ route('grounding.create') }}" {{-- --}}
                                               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                                Tambah Data Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="noResultsRow" class="hidden"> {{-- --}}
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500"><p class="text-lg">Tidak ada data ditemukan</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($maintenances->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $maintenances->links() }} {{-- --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete (Dipertahankan dari file Grounding lama) --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"> {{-- --}}
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Data</h3>
            <p class="text-gray-600 text-sm mb-6">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1"> {{-- --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        {{-- Script gabungan (Modal, Search, Lucide) --}}
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Aktifkan Ikon Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // 2. Logika Modal Hapus (dari file Grounding lama)
            const deleteModal = document.getElementById('deleteModal'); {{-- --}}
            const deleteForm = document.getElementById('deleteForm'); {{-- --}}

            window.deleteRecord = function(id) {
                if (deleteForm) {
                    deleteForm.action = `/grounding/${id}`; // Path sudah benar
                }
                if (deleteModal) {
                    deleteModal.classList.remove('hidden'); {{-- --}}
                }
            }

            window.closeDeleteModal = function() {
                if (deleteModal) {
                    deleteModal.classList.add('hidden'); {{-- --}}
                }
            }

            if (deleteModal) {
                deleteModal.addEventListener('click', function(e) { {{-- --}}
                    if (e.target === this) {
                        closeDeleteModal();
                    }
                });
            }

            // 3. Fungsi Search (dari file Grounding lama)
            const searchInput = document.getElementById('searchInput'); {{-- --}}

            const tableBody = document.getElementById('tableBody'); {{-- --}}
            const tableRows = tableBody ? tableBody.querySelectorAll('tr.data-row') : []; {{-- --}}
            const tableNoData = document.getElementById('noDataRow'); {{-- --}}
            const tableNoResults = document.getElementById('noResultsRow'); {{-- --}}

            const cardContainer = document.getElementById('cardContainer'); {{-- --}}
            const cardRows = cardContainer ? cardContainer.querySelectorAll('div.data-row') : []; {{-- --}}
            const cardNoData = document.getElementById('cardNoDataRow'); {{-- --}}
            const cardNoResults = document.getElementById('cardNoResultsRow'); {{-- --}}

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim(); {{-- --}}
                let tableFound = 0;
                let cardFound = 0;

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase(); {{-- --}}
                    if (rowText.includes(searchTerm)) {
                        row.style.display = ''; tableFound++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                cardRows.forEach(card => {
                    const cardText = card.textContent.toLowerCase(); {{-- --}}
                    if (cardText.includes(searchTerm)) {
                        card.style.display = ''; cardFound++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (tableNoResults) tableNoResults.classList.toggle('hidden', tableFound > 0 || tableRows.length === 0); {{-- --}}
                if (cardNoResults) cardNoResults.classList.toggle('hidden', cardFound > 0 || cardRows.length === 0); {{-- --}}
                
                if (tableNoData) tableNoData.style.display = (searchTerm && tableRows.length > 0) ? 'none' : (tableRows.length > 0 ? 'none' : ''); {{-- --}}
                if (cardNoData) cardNoData.style.display = (searchTerm && cardRows.length > 0) ? 'none' : (cardRows.length > 0 ? 'none' : ''); {{-- --}}

                if(tableFound > 0 && tableNoData) tableNoData.style.display = 'none'; {{-- --}}
                if(cardFound > 0 && cardNoData) cardNoData.style.display = 'none'; {{-- --}}
            }

            if (searchInput) {
                searchInput.addEventListener('keyup', filterTable); {{-- --}}
            }
        });
    </script>
    @endpush
</x-app-layout>
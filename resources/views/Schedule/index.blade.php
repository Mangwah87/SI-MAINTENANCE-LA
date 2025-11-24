<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                    {{ __('Daftar Jadwal PM Sentral') }}
                </h2>
            </div>
            <a href="{{ route('schedule.create') }}"
                class="inline-flex items-center px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-semibold rounded-lg transition-colors duration-200 w-full sm:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Jadwal Baru
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Search Bar --}}
            <div class="mb-6 relative">
                <input type="text" id="searchInput" placeholder="Cari berdasarkan Lokasi, Tanggal, atau Dibuat Oleh..."
                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Lokasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Pembuatan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Lokasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dibuat Oleh
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @forelse ($schedules as $index => $schedule)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 data-row">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $schedules->firstItem() + $index }}
                                        </td>
                                        {{-- KOLOM NAMA LOKASI - UBAH DISINI --}}
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-md">
                                            <div class="flex items-start">
                                                <i data-lucide="map-pin" class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                                <span class="break-words">{{ $schedule->locations->pluck('nama')->implode(', ') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($schedule->tanggal_pembuatan)->format('d F Y') }}
                                        </td>
                                        {{-- KOLOM JUMLAH LOKASI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i data-lucide="tag" class="w-3 h-3 mr-1"></i>
                                                {{ $schedule->locations_count }} Lokasi
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <i data-lucide="user" class="w-4 h-4 inline text-gray-500"></i>
                                            {{ $schedule->dibuat_oleh }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- Tombol Detail --}}
                                                <a href="{{ route('schedule.show', $schedule->id) }}"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                    title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('schedule.edit', $schedule->id) }}"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                    title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>

                                                {{-- Tombol Download PDF --}}
                                                <a href="{{ route('schedule.pdf', $schedule->id) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                    title="Download PDF">
                                                    <i data-lucide="file-down" class="w-4 h-4"></i>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <button type="button" onclick="deleteRecord({{ $schedule->id }})"
                                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="noDataRow">
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 mb-4">Tidak ada data</p>
                                            <a href="{{ route('schedule.create') }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                                Tambah Data Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="noResultsRow" class="hidden">
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                        <p class="text-lg">Tidak ada data ditemukan</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($schedules->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $schedules->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Data</h3>
            <p class="text-gray-600 text-sm mb-6">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
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
                    deleteForm.action = `/schedule/${id}`;
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

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let tableFound = 0;

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                        tableFound++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (tableNoResults) {
                    tableNoResults.classList.toggle('hidden', tableFound > 0 || tableRows.length === 0);
                }

                if (tableNoData) {
                    tableNoData.style.display = (searchTerm && tableRows.length > 0) ? 'none' : (tableRows.length > 0 ? 'none' : '');
                }

                if (tableFound > 0 && tableNoData) {
                    tableNoData.style.display = 'none';
                }
            }

            if (searchInput) {
                searchInput.addEventListener('keyup', filterTable);
            }
        });
    </script>
    @endpush
</x-app-layout>

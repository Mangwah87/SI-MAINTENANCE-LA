<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Preventive Maintenance Ruang Shelter') }}
            </h2>
            <a href="{{ route('pm-shelter.create') }}"
               class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white
                      px-4 py-2 rounded-lg text-sm font-medium transition w-full sm:w-auto justify-center sm:justify-start">
                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 sm:p-6">
                    <!-- Search & Filter Section -->
                    <form id="filterForm" class="space-y-4">
                        <!-- Search Bar with Sort -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Input -->
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input type="text"
                                       name="search"
                                       id="searchInput"
                                       value="{{ request('search') }}"
                                       placeholder="Cari lokasi atau pelaksana..."
                                       class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <button type="button"
                                        id="clearSearch"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <!-- Sort Dropdown -->
                            <div class="flex gap-2">
                                <select name="sort"
                                        id="sortSelect"
                                        class=" text-left x-6 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>
                                       <i data-lucide="calendar-days"></i>
                                        📅 Terbaru
                                    </option>
                                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                        📅 Terlama
                                    </option>
                                </select>

                                {{-- <!-- Reset Button -->
                                <button type="button"
                                        id="resetFilter"
                                        class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition"
                                        title="Reset Filter">
                                    <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                                </button> --}}
                            </div>
                        </div>


                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="hidden text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <p class="mt-2 text-gray-500">Memuat data...</p>
                    </div>

                    <!-- Content Container -->
                    <div id="contentContainer">
                        <!-- Mobile View - Card Layout -->
                        <div class="block lg:hidden space-y-4" id="mobileView">
                            @forelse($pmShelters as $pm)
                                <div class="pm-card border rounded-lg p-4 bg-gray-50 shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    #{{ $loop->iteration + ($pmShelters->currentPage() - 1) * $pmShelters->perPage() }}
                                                </span>
                                            </div>
                                            <h3 class="font-semibold text-gray-900 mb-1">
                                                <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                                                {{ $pm->location ?? '-' }}
                                            </h3>
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                                                {{ $pm->date ? $pm->date->format('d/m/Y') : '-' }}
                                                <span class="mx-1">•</span>
                                                {{ $pm->time ? \Carbon\Carbon::parse($pm->time)->format('H:i') : '-' }} WITA
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mb-3 pb-3 border-b">
                                        <p class="text-xs font-medium text-gray-500 mb-1">Pelaksana:</p>
                                        @if(!empty($pm->executors))
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($pm->executors as $executor)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-50 text-blue-700">
                                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                                        {{ $executor['name'] ?? '-' }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-4 gap-2">
                                        <a href="{{ route('pm-shelter.show', $pm) }}"
                                           class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                            <i data-lucide="eye" class="w-4 h-4 mb-1"></i>
                                            <span class="text-xs">Detail</span>
                                        </a>
                                        <a href="{{ route('pm-shelter.edit', $pm) }}"
                                           class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                            <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                                            <span class="text-xs">Edit</span>
                                        </a>
                                        <a href="{{ route('pm-shelter.export-pdf', $pm) }}"
                                           class="flex flex-col items-center justify-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                                            <i data-lucide="file-down" class="w-4 h-4 mb-1"></i>
                                            <span class="text-xs">PDF</span>
                                        </a>
                                        <form action="{{ route('pm-shelter.destroy', $pm) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full h-full flex flex-col items-center justify-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                                <i data-lucide="trash-2" class="w-4 h-4 mb-1"></i>
                                                <span class="text-xs">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada data ditemukan</p>
                                    <p class="text-gray-400 text-sm mt-1">Coba ubah kata kunci pencarian</p>
                                    @if(request()->has('search'))
                                    {{-- <button onclick="document.getElementById('resetFilter').click()"
                                            class="inline-flex items-center mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                        <i data-lucide="rotate-ccw" class="w-4 h-4 mr-2"></i>
                                        Reset Filter --}}
                                    </button>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                        <!-- Desktop View - Table Layout -->
                        <div class="hidden lg:block overflow-x-auto" id="desktopView">
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
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($pmShelters as $pm)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loop->iteration + ($pmShelters->currentPage() - 1) * $pmShelters->perPage() }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="flex items-start">
                                                    <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                                                    <span>{{ $pm->location ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                                                    <div>
                                                        <div>{{ $pm->date ? $pm->date->format('d/m/Y') : '-' }}</div>
                                                        <div class="text-xs text-gray-500 mt-0.5">
                                                            {{ $pm->time ? \Carbon\Carbon::parse($pm->time)->format('H:i') : '-' }} WITA
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @if(!empty($pm->executors))
                                                    <div class="space-y-1">
                                                        @foreach($pm->executors as $executor)
                                                            <div class="flex items-center">
                                                                <i data-lucide="user" class="w-3 h-3 mr-1 text-blue-500"></i>
                                                                <span>{{ $executor['name'] ?? '-' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('pm-shelter.show', $pm) }}"
                                                       class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                       title="Lihat Detail">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                    </a>
                                                    <a href="{{ route('pm-shelter.edit', $pm) }}"
                                                       class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                       title="Edit">
                                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                                    </a>
                                                    <a href="{{ route('pm-shelter.export-pdf', $pm) }}"
                                                       class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                       title="Download PDF">
                                                        <i data-lucide="file-down" class="w-4 h-4"></i>
                                                    </a>
                                                    <form action="{{ route('pm-shelter.destroy', $pm) }}" method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                                title="Hapus">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                                <p class="text-gray-500 text-lg font-medium mb-1">Tidak ada data ditemukan</p>
                                                <p class="text-gray-400 text-sm">Coba ubah kata kunci pencarian</p>
                                                @if(request()->has('search'))
                                                {{-- <button onclick="document.getElementById('resetFilter').click()"
                                                        class="inline-flex items-center mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                                    <i data-lucide="rotate-ccw" class="w-4 h-4 mr-2"></i>
                                                    Reset Filter
                                                </button> --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pmShelters->hasPages())
                            <div class="mt-6 border-t pt-4" id="pagination">
                                {{ $pmShelters->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
<script>
    let searchTimeout;
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const sortSelect = document.getElementById('sortSelect');
    // const resetFilter = document.getElementById('resetFilter');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const contentContainer = document.getElementById('contentContainer');

    // Show/hide clear button and perform realtime search
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            clearSearch.classList.remove('hidden');
        } else {
            clearSearch.classList.add('hidden');
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 500);
    });

    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        clearSearch.classList.add('hidden');
        performSearch();
    });

    // Sort change listener
    sortSelect.addEventListener('change', performSearch);

    // // Reset filter
    // resetFilter.addEventListener('click', function() {
    //     filterForm.reset();
    //     clearSearch.classList.add('hidden');
    //     performSearch();
    // });

    // Perform AJAX search
    function performSearch() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        loadingIndicator.classList.remove('hidden');
        contentContainer.style.opacity = '0.5';

        fetch(`{{ route('pm-shelter.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Replace entire content container with new HTML
            contentContainer.innerHTML = data.html;

            loadingIndicator.classList.add('hidden');
            contentContainer.style.opacity = '1';

            // Reinitialize lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Update URL
            const url = new URL(window.location);
            url.search = params.toString();
            window.history.pushState({}, '', url);

            // Reattach pagination handlers
            attachPaginationHandlers();
        })
        .catch(error => {
            console.error('Error:', error);
            loadingIndicator.classList.add('hidden');
            contentContainer.style.opacity = '1';
            alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        });
    }

    // Attach click handlers to pagination links
    function attachPaginationHandlers() {
        const paginationLinks = document.querySelectorAll('#contentContainer .mt-6 a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);

                const page = url.searchParams.get('page');
                if (page) params.set('page', page);

                loadingIndicator.classList.remove('hidden');
                contentContainer.style.opacity = '0.5';

                fetch(`{{ route('pm-shelter.index') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Replace entire content container with new HTML
                    contentContainer.innerHTML = data.html;

                    loadingIndicator.classList.add('hidden');
                    contentContainer.style.opacity = '1';

                    // Reinitialize lucide icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }

                    // Update URL
                    const newUrl = new URL(window.location);
                    newUrl.search = params.toString();
                    window.history.pushState({}, '', newUrl);

                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    // Reattach pagination handlers
                    attachPaginationHandlers();
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingIndicator.classList.add('hidden');
                    contentContainer.style.opacity = '1';
                    alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
                });
            });
        });
    }

    // Initialize
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    attachPaginationHandlers();

    if (searchInput.value.length > 0) {
        clearSearch.classList.remove('hidden');
    }
</script>
@endpush
</x-app-layout>

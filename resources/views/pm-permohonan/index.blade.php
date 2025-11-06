<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permohonan Tindak Lanjut PM') }}
            </h2>
            <a href="{{ route('pm-permohonan.create') }}"
               class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white 
                      px-4 py-2 rounded-lg text-sm font-medium transition w-full sm:w-auto justify-center sm:justify-start">
                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Search & Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 sm:p-6">
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
                                       placeholder="Cari pemohon, lokasi, atau department..." 
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
                                        class="text-left px-6 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>
                                        📅 Terbaru
                                    </option>
                                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                        📅 Terlama
                                    </option>
                                </select>
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
                        @include('pm-permohonan.partials.table')
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

        // Perform AJAX search
        function performSearch() {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);

            loadingIndicator.classList.remove('hidden');
            contentContainer.style.opacity = '0.5';

            fetch(`{{ route('pm-permohonan.index') }}?${params.toString()}`, {
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

                    fetch(`{{ route('pm-permohonan.index') }}?${params.toString()}`, {
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
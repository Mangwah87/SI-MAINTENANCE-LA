{{-- File: resources/views/reports/all-forms.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i data-lucide="folder-open" class="w-6 h-6"></i>
                {{ __('Laporan Semua Form Maintenance') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i data-lucide="filter" class="w-5 h-5"></i>
                        Filter Data
                    </h3>

                    <form method="GET" action="{{ route('reports.all-forms') }}" id="filterForm"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- Filter Tanggal --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="date_from" value="{{ $dateFrom }}" id="dateFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Filter Jenis Form --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Form</label>
                            <select name="form_type" id="formTypeFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="all" {{ $formType == 'all' ? 'selected' : '' }}>Semua Form</option>
                                <option value="battery" {{ $formType == 'battery' ? 'selected' : '' }}>Maintenance
                                    Battery</option>
                                <option value="rectifier" {{ $formType == 'rectifier' ? 'selected' : '' }}>Maintenance
                                    Rectifier</option>
                                <option value="genset" {{ $formType == 'genset' ? 'selected' : '' }}>Maintenance Genset
                                </option>
                                <option value="ups1" {{ $formType == 'ups1' ? 'selected' : '' }}>Maintenance 1 Phase
                                    UPS</option>
                                <option value="ups3" {{ $formType == 'ups3' ? 'selected' : '' }}>Maintenance 3 Phase
                                    UPS</option>
                                <option value="ac" {{ $formType == 'ac' ? 'selected' : '' }}>Maintenance AC
                                </option>
                                <option value="permohonan" {{ $formType == 'permohonan' ? 'selected' : '' }}>Permohonan
                                    Tindak Lanjut PM</option>
                                <option value="tindaklanjut" {{ $formType == 'tindaklanjut' ? 'selected' : '' }}>
                                    Formulir Tindak Lanjut PM</option>
                                <option value="dokumentasi" {{ $formType == 'dokumentasi' ? 'selected' : '' }}>Formulir
                                    Dokumentasi</option>
                                <option value="jadwal" {{ $formType == 'jadwal' ? 'selected' : '' }}>Jadwal PM Sentral
                                </option>
                                <option value="inverter" {{ $formType == 'inverter' ? 'selected' : '' }}>PM Inverter
                                </option>
                                <option value="shelter" {{ $formType == 'shelter' ? 'selected' : '' }}>PM Ruang Shelter
                                </option>
                                <option value="grounding" {{ $formType == 'grounding' ? 'selected' : '' }}>PM Petir &
                                    Grounding</option>
                                <option value="cable" {{ $formType == 'cable' ? 'selected' : '' }}>PM Instalasi Kabel
                                    & Panel</option>
                            </select>
                        </div>

                        {{-- Filter Lokasi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <input type="text" name="location" value="{{ $location }}" id="locationFilter"
                                placeholder="Cari lokasi..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Tombol Filter (Optional - tidak diperlukan lagi) --}}
                        <div style=" padding-top: 25px;">

                            <a href="{{ route('reports.all-forms') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                                <i data-lucide="x" class="w-4 h-4"></i>
                                Reset
                            </a>

                        </div>
                    </form>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Loading Indicator --}}
                    <div id="loadingIndicator" class="hidden text-center py-4">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="text-gray-600 mt-2">Memuat data...</p>
                    </div>

                    {{-- Data Container --}}
                    <div id="dataContainer">
                        <div class="mb-4">
                            <p class="text-gray-600">Total Data: <span class="font-semibold" id="totalData">{{ $total }}</span></p>
                        </div>

                        <div id="tableContainer">
                            @if (count($data) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Form</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelaksana</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($data as $index => $item)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ ($currentPage - 1) * $perPage + $index + 1 }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center gap-2">
                                                            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 text-blue-600"></i>
                                                            <span class="text-sm font-medium text-gray-900">{{ $item['type'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-900">
                                                        {{ Str::limit($item['lokasi'], 30) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $item['teknisi'] }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex gap-2">
                                                            <a href="{{ $item['route_pdf'] }}"
                                                                class="text-red-600 hover:text-red-900 flex items-center gap-1"
                                                                title="Download PDF" target="_blank">
                                                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Simple Pagination --}}
                                @if ($total > $perPage)
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="text-sm text-gray-700">
                                            Menampilkan <span class="font-medium">{{ ($currentPage - 1) * $perPage + 1 }}</span>
                                            sampai <span class="font-medium">{{ min($currentPage * $perPage, $total) }}</span>
                                            dari <span class="font-medium">{{ $total }}</span> hasil
                                        </div>
                                        <div class="flex gap-2">
                                            @if ($currentPage > 1)
                                                <a href="{{ route('reports.all-forms', array_merge(request()->query(), ['page' => $currentPage - 1])) }}"
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                    Previous
                                                </a>
                                            @endif

                                            <span class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md">
                                                Page {{ $currentPage }} of {{ ceil($total / $perPage) }}
                                            </span>

                                            @if ($currentPage < ceil($total / $perPage))
                                                <a href="{{ route('reports.all-forms', array_merge(request()->query(), ['page' => $currentPage + 1])) }}"
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                    Next
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-12">
                                    <i data-lucide="inbox" class="w-16 h-16 mx-auto text-gray-400 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada data ditemukan</p>
                                    <p class="text-gray-400 text-sm mt-2">Coba ubah filter atau tambahkan data baru</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                // Elements
                const filterForm = document.getElementById('filterForm');
                const dateFilter = document.getElementById('dateFilter');
                const formTypeFilter = document.getElementById('formTypeFilter');
                const locationFilter = document.getElementById('locationFilter');
                const loadingIndicator = document.getElementById('loadingIndicator');
                const dataContainer = document.getElementById('dataContainer');
                const tableContainer = document.getElementById('tableContainer');
                const totalDataSpan = document.getElementById('totalData');

                let debounceTimer;

                // Attach pagination handlers on initial load
                attachPaginationHandlers();

                // Function to fetch and display data
                async function loadData(page = 1) {
                    try {
                        // Show loading
                        loadingIndicator.classList.remove('hidden');
                        dataContainer.classList.add('opacity-50');

                        // Get filter values
                        const params = new URLSearchParams({
                            date_from: dateFilter.value || '',
                            form_type: formTypeFilter.value || 'all',
                            location: locationFilter.value || '',
                            page: page
                        });

                        // Fetch data
                        const response = await fetch(`{{ route('reports.all-forms') }}?${params}`);
                        const html = await response.text();

                        // Parse HTML to get data
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Extract data from the response
                        const newTableContainer = doc.getElementById('tableContainer');
                        const newTotalData = doc.getElementById('totalData');

                        if (newTableContainer && newTotalData) {
                            tableContainer.innerHTML = newTableContainer.innerHTML;
                            totalDataSpan.textContent = newTotalData.textContent;

                            // Reinitialize Lucide icons
                            if (typeof lucide !== 'undefined') {
                                lucide.createIcons();
                            }

                            // Update pagination click handlers
                            attachPaginationHandlers();
                        }

                        // Update URL without refresh
                        const newUrl = `{{ route('reports.all-forms') }}?${params}`;
                        window.history.pushState({}, '', newUrl);

                    } catch (error) {
                        console.error('Error loading data:', error);
                    } finally {
                        // Hide loading
                        loadingIndicator.classList.add('hidden');
                        dataContainer.classList.remove('opacity-50');
                    }
                }

                // Attach pagination handlers
                function attachPaginationHandlers() {
                    const paginationLinks = tableContainer.querySelectorAll('a[href*="page="]');
                    paginationLinks.forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = new URL(this.href);
                            const page = url.searchParams.get('page');
                            loadData(page);
                        });
                    });
                }

                // Debounce function
                function debounceLoad() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => loadData(1), 500);
                }

                // Event listeners for filters
                dateFilter.addEventListener('change', () => loadData(1));
                formTypeFilter.addEventListener('change', () => loadData(1));
                locationFilter.addEventListener('input', debounceLoad);

                // Prevent form submit
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    loadData(1);
                });
            });
        </script>
    @endpush
</x-app-layout>

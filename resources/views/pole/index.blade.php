<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pole Maintenance') }}
            </h2>
            <a href="{{ route('pole.create') }}"
               class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white
                      px-4 py-2 rounded-lg text-sm font-medium transition w-full sm:w-auto justify-center sm:justify-start">
                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                Tambah Data Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Stats Card --}}
            @if(isset($stats))
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i data-lucide="bar-chart-3" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Maintenance Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['this_month'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    <!-- Mobile View - Card Layout -->
                    <div class="block lg:hidden space-y-4">
                        @forelse($poles as $pole)
                            <div class="border rounded-lg p-4 bg-gray-50 shadow-sm">
                                <!-- Header Card -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                #{{ $loop->iteration }}
                                            </span>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1">
                                            <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                                            <span>
                                                @if($pole->central)
                                                    {{ $pole->central->nama }} - {{ $pole->central->area }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </span>
                                        </h3>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($pole->date)->format('d/m/Y') }}
                                            <span class="mx-1">•</span>
                                            {{ \Carbon\Carbon::parse($pole->time)->format('H:i') }} WITA
                                        </p>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="mb-3 pb-3 border-b">
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div>
                                            <p class="text-gray-500">Tipe Pole:</p>
                                            <p class="font-medium text-gray-900">{{ $pole->type_pole }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-3 gap-2">
                                    <a href="{{ route('pole.show', $pole) }}"
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i data-lucide="eye" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Detail</span>
                                    </a>
                                    <a href="{{ route('pole.edit', $pole) }}"
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                        <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    <button type="button" onclick="deleteRecord({{ $pole->id }})"
                                            class="flex flex-col items-center justify-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Hapus</span>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Tidak ada data pole maintenance</p>
                                <a href="{{ route('pole.create') }}"
                                   class="inline-flex items-center mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                    Tambah Data Pertama
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop View - Table Layout -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal / Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe Pole
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($poles as $pole)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-start">
                                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                                                <span>
                                                    @if($pole->central)
                                                        {{ $pole->central->nama }} - {{ $pole->central->area }}
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                                                <div>
                                                    <div>{{ \Carbon\Carbon::parse($pole->date)->format('d/m/Y') }}</div>
                                                    <div class="text-xs text-gray-500 mt-0.5">
                                                        {{ \Carbon\Carbon::parse($pole->time)->format('H:i') }} WITA
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $pole->type_pole }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('pole.show', $pole) }}"
                                                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                   title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('pole.edit', $pole) }}"
                                                   class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                   title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
                                                <button type="button" onclick="deleteRecord({{ $pole->id }})"
                                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 mb-4">Tidak ada data pole maintenance</p>
                                            <a href="{{ route('pole.create') }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                                Tambah Data Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($poles->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $poles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
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
    </div>

    @push('scripts')
    <script>
        lucide.createIcons();

        let currentDeleteId = null;

        function deleteRecord(id) {
            currentDeleteId = id;
            const form = document.getElementById('deleteForm');
            form.action = `/pole/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeleteId = null;
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
    @endpush
</x-app-layout>

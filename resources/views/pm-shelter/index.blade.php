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
            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    
                    <!-- Mobile View - Card Layout -->
                    <div class="block lg:hidden space-y-4">
                        @forelse($pmShelters as $pm)
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

                                <!-- Pelaksana -->
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

                                <!-- Action Buttons -->
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
                                <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Tidak ada data</p>
                                <a href="{{ route('pm-shelter.create') }}" 
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
                                        Pelaksana
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pmShelters as $pm)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration }}
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
                                                    <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                                        {{-- <i data-lucide="clock" class="w-3 h-3 mr-1"></i> --}}
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
                                            <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 mb-4">Tidak ada data</p>
                                            <a href="{{ route('pm-shelter.create') }}" 
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
                    @if($pmShelters->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $pmShelters->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        lucide.createIcons();
    </script>
    @endpush
</x-app-layout>
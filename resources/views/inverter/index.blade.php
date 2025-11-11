<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Dokumentasi Inverter') }}
            </h2>
            <a href="{{ route('inverter.create') }}"
               class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white 
                      px-4 py-2 rounded-lg text-sm font-medium transition w-full sm:w-auto justify-center sm:justify-start">
                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Form Pencarian -->
            <div class="mb-6">
                <form action="{{ route('inverter.index') }}" method="GET" class="w-full">
                    <div class="flex gap-2">
                        <input type="text" 
                            name="search" 
                            placeholder="Cari berdasarkan lokasi, brand, reg number, atau serial number..." 
                            value="{{ request('search') }}"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        
                        <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>

                        @if(request('search'))
                            <a href="{{ route('inverter.index') }}" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    
                    <!-- Mobile View - Card Layout -->
                    <div class="block lg:hidden space-y-4">
                        @forelse($inverter as $index => $item)
                            <div class="border rounded-lg p-4 bg-gray-50 shadow-sm">
                                <!-- Header Card -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                #{{ $inverter->firstItem() + $index }}
                                            </span>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-1">
                                            <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                                            {{ $item->lokasi ?? '-' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('d/m/Y') }}
                                            <span class="mx-1">•</span>
                                            {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('H:i') }} WITA
                                        </p>
                                    </div>
                                </div>

                                <!-- Brand & Serial Info -->
                                <div class="mb-3 pb-3 border-b">
                                    <p class="text-xs font-medium text-gray-500 mb-2">Informasi Perangkat:</p>
                                    <div class="space-y-1.5">
                                        <div class="flex items-center text-sm">
                                            <i data-lucide="cpu" class="w-4 h-4 mr-2 text-purple-500"></i>
                                            <span class="text-gray-600 w-24">Brand:</span>
                                            <span class="font-medium text-gray-900">{{ $item->brand ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i data-lucide="hash" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                            <span class="text-gray-600 w-24">Reg. Number:</span>
                                            <span class="font-medium text-gray-900">{{ $item->reg_num ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i data-lucide="tag" class="w-4 h-4 mr-2 text-teal-500"></i>
                                            <span class="text-gray-600 w-24">Serial Number:</span>
                                            <span class="font-medium text-gray-900">{{ $item->serial_num ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pelaksana -->
                                <div class="mb-3 pb-3 border-b">
                                    <p class="text-xs font-medium text-gray-500 mb-1">Pelaksana:</p>
                                    @if(!empty($item->pelaksana) && is_array($item->pelaksana))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($item->pelaksana as $pelaksana)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-50 text-blue-700">
                                                    <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                                    {{ $pelaksana['nama'] ?? '-' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-4 gap-2">
                                    <a href="{{ route('inverter.show', $item->id) }}" 
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i data-lucide="eye" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Detail</span>
                                    </a>
                                    <a href="{{ route('inverter.edit', $item->id) }}" 
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                        <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    <a href="{{ route('inverter.pdf', $item->id) }}" 
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                                        <i data-lucide="file-down" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">PDF</span>
                                    </a>
                                    <form action="{{ route('inverter.destroy', $item->id) }}" method="POST" 
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
                                <p class="text-gray-500">
                                    @if(request('search'))
                                        Tidak ada hasil untuk pencarian "{{ request('search') }}".
                                    @else
                                        Tidak ada data
                                    @endif
                                </p>
                                <a href="{{ route('inverter.create') }}" 
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
                                        Brand
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reg. Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Serial Number
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
                                @forelse($inverter as $index => $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $inverter->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-start">
                                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                                                <span>{{ $item->lokasi ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                                                <div>
                                                    <div>{{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('d/m/Y') }}</div>
                                                    <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                                        <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('H:i') }} WITA
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="cpu" class="w-4 h-4 mr-2 text-purple-500 flex-shrink-0"></i>
                                                <span class="font-medium">{{ $item->brand ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="hash" class="w-4 h-4 mr-2 text-indigo-500 flex-shrink-0"></i>
                                                <span class="font-mono">{{ $item->reg_num ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="tag" class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0"></i>
                                                <span class="font-mono">{{ $item->serial_num ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if(!empty($item->pelaksana) && is_array($item->pelaksana))
                                                <div class="space-y-1">
                                                    @foreach($item->pelaksana as $pelaksana)
                                                        <div class="flex items-center">
                                                            <i data-lucide="user" class="w-3 h-3 mr-1 text-blue-500 flex-shrink-0"></i>
                                                            <span class="text-xs">{{ $pelaksana['nama'] ?? '-' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('inverter.show', $item->id) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                   title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('inverter.edit', $item->id) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                   title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('inverter.pdf', $item->id) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                   title="Download PDF">
                                                    <i data-lucide="file-down" class="w-4 h-4"></i>
                                                </a>
                                                <form action="{{ route('inverter.destroy', $item->id) }}" method="POST" 
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
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 mb-4">
                                                @if(request('search'))
                                                    Tidak ada hasil untuk pencarian "{{ request('search') }}".
                                                @else
                                                    Tidak ada data
                                                @endif
                                            </p>
                                            <a href="{{ route('inverter.create') }}" 
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
                    @if($inverter->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $inverter->appends(['search' => request('search')])->links() }}
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
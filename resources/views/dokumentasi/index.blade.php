<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dokumentasi dan Pendataan Perangkat') }}
            </h2>
            <a href="{{ route('dokumentasi.create') }}"
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
                    
                    <!-- Form Pencarian -->
                    <div class="mb-6">
                        <form action="{{ route('dokumentasi.index') }}" method="GET">
                            <div class="flex flex-col sm:flex-row gap-2">
                                <div class="relative flex-1">
                                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" 
                                        name="search" 
                                        placeholder="Cari berdasarkan nama pelaksana, lokasi..." 
                                        value="{{ request('search') }}"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                
                                <button type="submit" 
                                    class="px-4 sm:px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition inline-flex items-center justify-center">
                                    <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                                    Cari
                                </button>

                                @if(request('search'))
                                    <a href="{{ route('dokumentasi.index') }}" 
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition inline-flex items-center justify-center">
                                        <i data-lucide="x" class="w-4 h-4 mr-1"></i>
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                        
                        @if(request('search'))
                            <div class="mt-3 text-sm text-gray-600 flex items-center">
                                <i data-lucide="info" class="w-4 h-4 mr-1"></i>
                                Menampilkan hasil pencarian untuk: <strong class="ml-1">"{{ request('search') }}"</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Mobile View - Card Layout -->
                    <div class="block lg:hidden space-y-4">
                        @forelse($dokumentasi as $index => $item)
                            @php
                                $pelaksanaArray = is_string($item->pelaksana) ? json_decode($item->pelaksana, true) : $item->pelaksana;
                                $pelaksanaArray = is_array($pelaksanaArray) ? $pelaksanaArray : [];
                            @endphp
                            <div class="border rounded-lg p-4 bg-gray-50 shadow-sm">
                                <!-- Header Card -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                #{{ $dokumentasi->firstItem() + $index }}
                                            </span>
                                        </div>
                                        
                                        <!-- Data Pelaksana -->
                                        <div class="mb-2">
                                            <p class="text-xs font-medium text-gray-500 mb-1">Pelaksana:</p>
                                            @if(count($pelaksanaArray) > 0)
                                                <div class="space-y-1">
                                                    @foreach($pelaksanaArray as $pelaksana)
                                                        <div class="flex items-start text-sm">
                                                            <i data-lucide="user" class="w-4 h-4 mr-1 mt-0.5 text-blue-500 flex-shrink-0"></i>
                                                            <span class="font-semibold text-blue-600">{{ $pelaksana['nama'] ?? '-' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400 italic">Belum ada pelaksana</span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-gray-600 flex items-center mt-2">
                                            <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500 mr-1"></i>
                                            {{ $item->lokasi }}
                                        </p>
                                        <p class="text-sm text-gray-600 flex items-center mt-1">
                                            <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('d/m/Y') }}
                                            <span class="mx-1">•</span>
                                            {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('H:i') }} WITA
                                        </p>
                                    </div>
                                </div>

                                <!-- Perangkat Info -->
                                <div class="mb-3 pb-3 border-b">
                                    <p class="text-xs font-medium text-gray-500 mb-1">Perangkat:</p>
                                    @php
                                        $count_sentral = is_array($item->perangkat_sentral) ? count($item->perangkat_sentral) : 0;
                                        $count_sarana = is_array($item->sarana_penunjang) ? count($item->sarana_penunjang) : 0;
                                    @endphp
                                    <div class="flex flex-wrap gap-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-50 text-blue-700">
                                            <i data-lucide="cpu" class="w-3 h-3 mr-1"></i>
                                            {{ $count_sentral }} Sentral
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-50 text-green-700">
                                            <i data-lucide="wrench" class="w-3 h-3 mr-1"></i>
                                            {{ $count_sarana }} Sarana
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-4 gap-2">
                                    <a href="{{ route('dokumentasi.show', $item->id) }}" 
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i data-lucide="eye" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Detail</span>
                                    </a>
                                    <a href="{{ route('dokumentasi.edit', $item->id) }}" 
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                        <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    <a href="{{ route('dokumentasi.pdf', $item->id) }}" 
                                       class="flex flex-col items-center justify-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                                        <i data-lucide="file-down" class="w-4 h-4 mb-1"></i>
                                        <span class="text-xs">PDF</span>
                                    </a>
                                    <form action="{{ route('dokumentasi.destroy', $item->id) }}" method="POST" 
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
                                        Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                    @else
                                        Tidak ada data
                                    @endif
                                </p>
                                <a href="{{ route('dokumentasi.create') }}" 
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
                                        Data Pelaksana
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal / Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Perangkat
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($dokumentasi as $index => $item)
                                    @php
                                        $pelaksanaArray = is_string($item->pelaksana) ? json_decode($item->pelaksana, true) : $item->pelaksana;
                                        $pelaksanaArray = is_array($pelaksanaArray) ? $pelaksanaArray : [];
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $dokumentasi->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if(count($pelaksanaArray) > 0)
                                                <div class="space-y-1">
                                                    @foreach($pelaksanaArray as $pelaksana)
                                                        <div class="flex items-center">
                                                            <i data-lucide="user" class="w-4 h-4 mr-2 text-blue-500 flex-shrink-0"></i>
                                                            <span class="font-semibold text-blue-600">{{ $pelaksana['nama'] ?? '-' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">Belum ada pelaksana</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-start">
                                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                                                <span>{{ $item->lokasi }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                                                <div>
                                                    <div>{{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('d/m/Y') }}</div>
                                                    <div class="text-xs text-gray-500 mt-0.5">
                                                        {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->format('H:i') }} WITA
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @php
                                                $count_sentral = is_array($item->perangkat_sentral) ? count($item->perangkat_sentral) : 0;
                                                $count_sarana = is_array($item->sarana_penunjang) ? count($item->sarana_penunjang) : 0;
                                            @endphp
                                            <div class="space-y-1">
                                                <div class="flex items-center">
                                                    <i data-lucide="cpu" class="w-3 h-3 mr-1 text-blue-500"></i>
                                                    <span>{{ $count_sentral }} Sentral</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i data-lucide="wrench" class="w-3 h-3 mr-1 text-green-500"></i>
                                                    <span>{{ $count_sarana }} Sarana</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('dokumentasi.show', $item->id) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                   title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('dokumentasi.edit', $item->id) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                   title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('dokumentasi.pdf', $item->id) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                   title="Download PDF">
                                                    <i data-lucide="file-down" class="w-4 h-4"></i>
                                                </a>
                                                <form action="{{ route('dokumentasi.destroy', $item->id) }}" method="POST" 
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
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <i data-lucide="folder-open" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 mb-4">
                                                @if(request('search'))
                                                    Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                                @else
                                                    Tidak ada data
                                                @endif
                                            </p>
                                            <a href="{{ route('dokumentasi.create') }}" 
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
                    @if($dokumentasi->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $dokumentasi->appends(['search' => request('search')])->links() }}
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
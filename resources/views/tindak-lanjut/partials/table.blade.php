<!-- Mobile View - Card Layout -->
<div class="block lg:hidden space-y-4" id="mobileView">
    @forelse($tindakLanjuts as $item)
        <div class="border rounded-lg p-4 bg-gray-50 shadow-sm">
            <!-- Header Card -->
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                            #{{ $loop->iteration + ($tindakLanjuts->currentPage() - 1) * $tindakLanjuts->perPage() }}
                        </span>
                        @if($item->selesai)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                Selesai
                            </span>
                        @elseif($item->tidak_selesai)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                <i data-lucide="alert-circle" class="w-3 h-3 mr-1"></i>
                                Tidak Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                Proses
                            </span>
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">
                        <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                        {{ $item->lokasi ?? '-' }}
                    </h3>
                    
                    <p class="text-sm text-gray-600 flex items-center">
                        <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                        {{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}
                        <span class="mx-1">•</span>
                        {{ $item->jam ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Pelaksana -->
            <div class="mb-3 pb-3 border-b">
                <p class="text-xs font-medium text-gray-500 mb-1">Pelaksana:</p>
                @if($item->pelaksana && is_array($item->pelaksana) && count($item->pelaksana) > 0)
                    <div class="flex flex-wrap gap-1">
                        @foreach($item->pelaksana as $index => $pelaksana)
                            @if($index < 3)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-50 text-blue-700">
                                    <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                    {{ $pelaksana['nama'] ?? '-' }}
                                </span>
                            @endif
                        @endforeach
                        @if(count($item->pelaksana) > 3)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 font-medium">
                                +{{ count($item->pelaksana) - 3 }} lainnya
                            </span>
                        @endif
                    </div>
                @else
                    <span class="text-sm text-gray-400">Tidak ada pelaksana</span>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-4 gap-2">
                <a href="{{ route('tindak-lanjut.show', $item) }}" 
                   class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                    <i data-lucide="eye" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">Detail</span>
                </a>
                <a href="{{ route('tindak-lanjut.edit', $item) }}" 
                   class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                    <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">Edit</span>
                </a>
                <a href="{{ route('tindak-lanjut.pdf', $item) }}" 
                   target="_blank"
                   class="flex flex-col items-center justify-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                    <i data-lucide="file-down" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">PDF</span>
                </a>
                <form action="{{ route('tindak-lanjut.destroy', $item) }}" method="POST" 
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil Tindak Lanjut</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($tindakLanjuts as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $loop->iteration + ($tindakLanjuts->currentPage() - 1) * $tindakLanjuts->perPage() }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="flex items-start">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                            <div>
                                <div class="font-medium">{{ $item->lokasi ?? '-' }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $item->ruang ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                            <div>
                                <div>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $item->jam ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($item->pelaksana && is_array($item->pelaksana) && count($item->pelaksana) > 0)
                            <div class="space-y-1">
                                @foreach($item->pelaksana as $index => $pelaksana)
                                    @if($index < 2)
                                        <div class="flex items-start">
                                            <i data-lucide="user" class="w-3 h-3 mr-1 text-blue-500 mt-0.5 flex-shrink-0"></i>
                                            <div class="flex-1">
                                                <div class="font-medium">{{ $pelaksana['nama'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if(count($item->pelaksana) > 2)
                                    <div class="text-xs text-blue-600 font-medium flex items-center">
                                        <i data-lucide="users" class="w-3 h-3 mr-1"></i>
                                        +{{ count($item->pelaksana) - 2 }} lainnya
                                    </div>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400">Tidak ada pelaksana</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->selesai)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-800">
                                <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                Selesai
                            </span>
                        @elseif($item->tidak_selesai)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-800">
                                <i data-lucide="alert-circle" class="w-3 h-3 mr-1"></i>
                                Tidak Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                Proses
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('tindak-lanjut.show', $item) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                               title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('tindak-lanjut.edit', $item) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                               title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('tindak-lanjut.pdf', $item) }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                               title="Download PDF">
                                <i data-lucide="file-down" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('tindak-lanjut.destroy', $item) }}" method="POST" 
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
                        <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg font-medium mb-1">Tidak ada data ditemukan</p>
                        <p class="text-gray-400 text-sm">Coba ubah kata kunci pencarian</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($tindakLanjuts->hasPages())
    <div class="mt-6 border-t pt-4" id="pagination">
        {{ $tindakLanjuts->links() }}
    </div>
@endif
<!-- Mobile View - Card Layout -->
<div class="block lg:hidden space-y-4" id="mobileView">
    @forelse($permohonan as $item)
        <div class="border rounded-lg p-4 bg-gray-50 shadow-sm">
            <!-- Header Card -->
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            #{{ $loop->iteration + ($permohonan->currentPage() - 1) * $permohonan->perPage() }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">
                        <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                        {{ $item->lokasi ?? '-' }}
                    </h3>
                    <p class="text-sm text-gray-600 flex items-center">
                        <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>
                        {{ $item->tanggal->format('d/m/Y') }}
                        <span class="mx-1">•</span>
                        {{ $item->jam }} WITA
                    </p>
                </div>
            </div>

            <!-- Detail Info -->
            <div class="mb-3 pb-3 border-b space-y-2">
                <div>
                    <p class="text-xs font-medium text-gray-500">Pemohon:</p>
                    <div class="flex items-center">
                        <i data-lucide="user" class="w-3 h-3 mr-1 text-blue-500"></i>
                        <span class="text-sm text-gray-900">{{ $item->nama }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Ditujukan Kepada:</p>
                    <div class="flex items-center">
                        <i data-lucide="book-up-2" class="w-3 h-3 mr-1 text-blue-500"></i>
                        <span class="text-sm text-gray-900">{{ $item->ditujukan_department }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-4 gap-2">
                <a href="{{ route('pm-permohonan.show', $item->id) }}" 
                   class="flex flex-col items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                    <i data-lucide="eye" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">Detail</span>
                </a>
                @if($item->user_id === auth()->id())
                <a href="{{ route('pm-permohonan.edit', $item->id) }}" 
                   class="flex flex-col items-center justify-center px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                    <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">Edit</span>
                </a>
                @else
                <div class="flex flex-col items-center justify-center px-3 py-2 bg-gray-50 text-gray-300 rounded-lg">
                    <i data-lucide="edit" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">Edit</span>
                </div>
                @endif
                <a href="{{ route('pm-permohonan.pdf', $item->id) }}" 
                   target="_blank"
                   class="flex flex-col items-center justify-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                    <i data-lucide="download" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">PDF</span>
                </a>
                @if($item->user_id === auth()->id())
                <form action="{{ route('pm-permohonan.destroy', $item->id) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full h-full flex flex-col items-center justify-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                        <i data-lucide="trash-2" class="w-4 h-4 mb-1"></i>
                        <span class="text-xs">Hapus</span>
                    </button>
                </form>
                @else
                <div class="flex flex-col items-center justify-center px-3 py-2 bg-gray-50 text-gray-300 rounded-lg">
                    <i data-lucide="trash-2" class="w-4 h-4 mb-1"></i>
                    <span class="text-xs">Hapus</span>
                </div>
                @endif
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
                    Pemohon
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ditujukan Kepada
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($permohonan as $index => $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $loop->iteration + ($permohonan->currentPage() - 1) * $permohonan->perPage() }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="flex items-start">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 text-red-500 flex-shrink-0"></i>
                            <div>
                                <div class="font-medium">{{ $item->lokasi }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"></i>
                            <div>
                                <div>{{ $item->tanggal->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                    {{ $item->jam }} WITA
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="flex items-start">
                            <i data-lucide="user" class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0"></i>
                            <div>
                                <div class="font-medium">{{ $item->nama }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="flex items-start">
                            <i data-lucide="book-up-2" class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0"></i>
                            <div>
                                <div class="font-medium">{{ $item->ditujukan_department }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('pm-permohonan.show', $item->id) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                               title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            @if($item->user_id === auth()->id())
                            <a href="{{ route('pm-permohonan.edit', $item->id) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                               title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            @endif
                            <a href="{{ route('pm-permohonan.pdf', $item->id) }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                               title="Download PDF">
                                <i data-lucide="file-down" class="w-4 h-4"></i>
                            </a>
                            @if($item->user_id === auth()->id())
                            <form action="{{ route('pm-permohonan.destroy', $item->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                            @endif
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
@if($permohonan->hasPages())
    <div class="mt-6 border-t pt-4" id="pagination">
        {{ $permohonan->links() }}
    </div>
@endif
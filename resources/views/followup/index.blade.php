<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permohonan Tindak Lanjut PM') }}
            </h2>
            <a href="{{ route('followup.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Buat Permohonan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruang</th> --}}
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> --}}
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($requests as $index => $req)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $requests->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $req->tanggal->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $req->lokasi }}
                                        </td>
                                        {{-- <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $req->ruang }}
                                        </td> --}}
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $req->user->name }}
                                        </td>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        </td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('followup.show', $req->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900" title="Lihat">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </a>
                                                @if($req->user_id === auth()->id())
                                                    <a href="{{ route('followup.edit', $req->id) }}" 
                                                       class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('followup.pdf', $req->id) }}" 
                                                   target="_blank" class="text-green-600 hover:text-green-900" title="Download PDF">
                                                    <i data-lucide="download" class="w-4 h-4"></i>
                                                </a>
                                                @if($req->user_id === auth()->id())
                                                    <form action="{{ route('followup.destroy', $req->id) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data permohonan tindak lanjut.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @forelse($requests as $req)
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $req->lokasi }}</p>
                                        <p class="text-xs text-gray-500">{{ $req->ruang }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </div>
                                <div class="mb-3 text-sm text-gray-600 space-y-1">
                                    <p><span class="font-medium">Tanggal:</span> {{ $req->tanggal->format('d/m/Y') }}</p>
                                    <p><span class="font-medium">Pemohon:</span> {{ $req->nama}}</p>
                                </div>
                                <div class="flex gap-2 pt-3 border-t border-gray-200">
                                    <a href="{{ route('followup.show', $req->id) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                        <i data-lucide="eye" class="w-3 h-3 mr-1"></i>
                                        Lihat
                                    </a>
                                    @if($req->user_id === auth()->id())
                                        <a href="{{ route('followup.edit', $req->id) }}" 
                                           class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-yellow-600 text-white text-xs font-semibold rounded hover:bg-yellow-700">
                                            <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                                            Edit
                                        </a>
                                    @endif
                                    <a href="{{ route('followup.pdf', $req->id) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700">
                                        <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                        PDF
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Belum ada data permohonan tindak lanjut.
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($requests->hasPages())
                        <div class="mt-6">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
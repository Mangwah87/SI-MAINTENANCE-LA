<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('PM Sentral Maintenance Schedules') }}
            </h2>
            <a href="{{ route('schedule.create') }}"
                class="inline-flex items-center px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-semibold rounded-lg transition-colors duration-200 w-full sm:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Jadwal Baru
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">PM Sentral Schedule List</h3>
                </div>
                
                {{-- KOLOM PENCARIAN SEDERHANA --}}
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('schedule.index') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                        <div class="flex-1 w-full">
                            <label for="search" class="sr-only">Cari Jadwal</label>
                            <div class="relative">
                                {{-- Ikon Pencarian SVG --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{-- Input Pencarian --}}
                                <input type="text" name="search" id="search" placeholder="Search by Location Name, Date, or Created By..."
                                    value="{{ request('search') }}"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        
                        {{-- Tombol Cari --}}
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto justify-center">
                            Search
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Creation Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Location
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created By
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($schedules as $index => $schedule)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedules->firstItem() + $index }}
                                    </td>
                                    {{-- KOLOM NAMA LOKASI --}}
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $schedule->locations->pluck('nama')->implode(', ') }}">
                                        <i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i>
                                        {{ $schedule->locations->pluck('nama')->implode(', ') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <i data-lucide="calendar" class="w-4 h-4 inline text-gray-400 mr-1"></i>    
                                        {{ \Carbon\Carbon::parse($schedule->tanggal_pembuatan)->format('d F Y') }}
                                    </td>
                                    {{-- KOLOM JUMLAH LOKASI --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                        <i data-lucide="tag" class="w-4 h-4 inline text-red-500"></i>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $schedule->locations_count }} Location 
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <i data-lucide="user" class="w-4 h-4 inline text-gray-500"></i>
                                        {{ $schedule->dibuat_oleh }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('schedule.show', $schedule->id) }}" 
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                title="Show">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <a href="{{ route('schedule.edit', $schedule->id) }}" 
                                                class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                            <a href="{{ route('schedule.pdf', $schedule->id) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                title="Download PDF">
                                                <i data-lucide="file-down" class="w-4 h-4"></i>
                                            </a>

                                            <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-base font-medium">Belum ada jadwal PM</p>
                                            <p class="text-sm text-gray-400 mt-1">Klik "Buat Jadwal Baru" untuk memulai</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($schedules->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $schedules->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        lucide.createIcons();
    </script>
    @endpush
</x-app-layout>
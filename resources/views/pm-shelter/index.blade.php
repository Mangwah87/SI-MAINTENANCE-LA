<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Preventive Maintenance Ruang Shelter') }}
            </h2>
            <a href="{{ route('pm-shelter.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4 inline mr-1"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Dok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelaksana</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pmShelters as $pm)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pm->document_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pm->location ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pm->date ? $pm->date->format('d/m/Y') : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if(!empty($pm->executors))
                                                @foreach($pm->executors as $executor)
                                                    <span class="block">{{ $executor['name'] ?? '-' }}</span>
                                                @endforeach
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('pm-shelter.show', $pm) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                <i data-lucide="eye" class="w-4 h-4 inline"></i>
                                            </a>
                                            <a href="{{ route('pm-shelter.edit', $pm) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                                <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                            </a>
                                            <a href="{{ route('pm-shelter.export-pdf', $pm) }}" class="text-green-600 hover:text-green-900 mr-3">
                                                <i data-lucide="download" class="w-4 h-4 inline"></i>
                                            </a>
                                            <form action="{{ route('pm-shelter.destroy', $pm) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pmShelters->links() }}
                    </div>
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
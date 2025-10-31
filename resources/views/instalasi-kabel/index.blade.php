<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data PM Instalasi Kabel dan Panel Distribusi') }}
            </h2>
            {{-- Tautan untuk membuat data baru --}}
            <a href="{{ route('instalasi-kabel.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                + Tambah Formulir Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    
                    {{-- Pesan Sukses/Error --}}
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO. DOKUMEN</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BULAN</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JUMLAH LOKASI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DIBUAT OLEH</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jadwal as $index => $data)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $jadwal->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-blue-600 hover:text-blue-800 font-medium">
                                            <a href="{{ route('instalasi-kabel.show', $data->id) }}">
                                                {{ $data->no_dokumen }}
                                            </a>
                                        </td>
                                        {{-- Asumsi kolom 'bulan' adalah objek Carbon atau string yang bisa diformat --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($data->bulan)->format('F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data->jumlah_lokasi }} Lokasi</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data->dibuat_oleh }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            {{-- Tombol View --}}
                                            <a href="{{ route('instalasi-kabel.show', $data->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-white bg-blue-500 hover:bg-blue-600 mx-1" title="Lihat Detail">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('instalasi-kabel.edit', $data->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 mx-1" title="Edit Data">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('instalasi-kabel.destroy', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen {{ $data->no_dokumen }}? Data ini akan dihapus permanen.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center p-2 rounded-lg text-white bg-red-500 hover:bg-red-600 mx-1" title="Hapus Data">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            {{-- Tombol PDF --}}
                                            <a href="{{ route('instalasi-kabel.pdf', $data->id) }}" target="_blank" class="inline-flex items-center justify-center p-2 rounded-lg text-white bg-red-700 hover:bg-red-800 mx-1" title="Download PDF">
                                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Belum ada data Formulir Instalasi Kabel dan Panel Distribusi yang tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $jadwal->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
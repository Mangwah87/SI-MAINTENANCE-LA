<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Permohonan Tindak Lanjut PM') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('followup.pdf', $request->id) }}" 
                   class="inline-flex items-center justify-center px-3 py-2 sm:px-4 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                   target="_blank">
                    <i data-lucide="file-text" class="w-4 h-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Download PDF</span>
                </a>
                <a href="{{ route('followup.index') }}" 
                   class="inline-flex items-center justify-center px-3 py-2 sm:px-4 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    <i data-lucide="arrow-left" class="w-4 h-4 sm:mr-2"></i>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">  
                    
                    <!-- Status Badge -->
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($request->status == 'approved') bg-green-100 text-green-800
                                @elseif($request->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                <i data-lucide="circle" class="w-3 h-3 mr-1 fill-current"></i>
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Dibuat: {{ $request->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <!-- Informasi Dasar -->
                    <div class="border-b pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal</label>
                                <p class="text-gray-900">{{ $request->tanggal->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Jam</label>
                                <p class="text-gray-900">{{ $request->jam }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Lokasi</label>
                                <p class="text-gray-900">{{ $request->lokasi }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Ruang</label>
                                <p class="text-gray-900">{{ $request->ruang }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Permasalahan -->
                    <div class="border-b pb-6 mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Permasalahan yang terjadi</label>
                        <div class="bg-gray-50 rounded-md p-4 border border-gray-200">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $request->permasalahan }}</p>
                        </div>
                    </div>

                    <!-- Usulan Tindak Lanjut -->
                    <div class="border-b pb-6 mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Usulan tindak lanjut</label>
                        <div class="bg-gray-50 rounded-md p-4 border border-gray-200">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $request->usulan_tindak_lanjut }}</p>
                        </div>
                    </div>

                    <!-- Pemohon -->
                    <div class="border-b pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pemohon</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                                <p class="text-gray-900">{{ $request->nama}}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                                <p class="text-gray-900">{{ $request->department }}</p>
                            </div>
                            @if($request->sub_department)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Sub Department</label>
                                <p class="text-gray-900">{{ $request->sub_department }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Ditujukan kepada -->
                    <div class="border-b pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ditujukan kepada</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                                <p class="text-gray-900">{{ $request->ditujukan_department }}</p>
                            </div>

                            @if($request->ditujukan_sub_department)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Sub Department</label>
                                <p class="text-gray-900">{{ $request->ditujukan_sub_department }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Diinformasikan melalui -->
                    <div class="border-b pb-6 mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Diinformasikan melalui</label>
                        <div class="flex gap-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium
                                {{ $request->diinformasikan_melalui == 'email' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                                <i data-lucide="mail" class="w-4 h-4 mr-1"></i>
                                Email
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium
                                {{ $request->diinformasikan_melalui == 'fax' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                                <i data-lucide="printer" class="w-4 h-4 mr-1"></i>
                                Fax
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium
                                {{ $request->diinformasikan_melalui == 'hardcopy' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                                <i data-lucide="file-text" class="w-4 h-4 mr-1"></i>
                                Hardcopy
                            </span>
                        </div>
                    </div>

                    <!-- Catatan -->
                    @if($request->catatan)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Catatan</label>
                        <div class="bg-gray-50 rounded-md p-4 border border-gray-200">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $request->catatan }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-row justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('followup.edit', $request->id) }}" 
                           class="inline-flex items-center justify-center w-10 h-10 sm:w-auto sm:px-6 sm:py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150">
                            <i data-lucide="edit" class="w-4 h-4 sm:mr-2"></i>
                            <span class="hidden sm:inline">Edit Permohonan</span>
                        </a>
                        
                        <form action="{{ route('followup.destroy', $request->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center justify-center w-10 h-10 sm:w-auto sm:px-6 sm:py-3 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-900 focus:ring ring-red-300 transition ease-in-out duration-150">
                                <i data-lucide="trash-2" class="w-4 h-4 sm:mr-2"></i>
                                <span class="hidden sm:inline">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
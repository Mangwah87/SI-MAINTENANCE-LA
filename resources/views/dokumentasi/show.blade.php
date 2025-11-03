<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Dokumentasi') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 mb-6">
                    <h3 class="text-base sm:text-lg font-bold text-gray-800">Detail Dokumentasi</h3>
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        <a href="{{ route('dokumentasi.pdf', $dokumentasi->id) }}" target="_blank"
                           class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base rounded-lg shadow transition duration-150 text-center">
                            📄 Download PDF
                        </a>
                        <a href="{{ route('dokumentasi.index') }}"
                           class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm sm:text-base rounded-lg shadow transition duration-150 text-center">
                            ← Kembali
                        </a>
                    </div>
                </div>

                <!-- Bagian 1: Informasi Umum -->
                <div class="mb-6 sm:mb-8">
                    <h4 class="text-sm sm:text-md font-bold text-gray-700 border-b pb-2 mb-4">Informasi Umum</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">Nomor Dokumen:</span>
                            <p class="mt-1 text-gray-900 text-sm sm:text-base">{{ $dokumentasi->nomor_dokumen }}</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">Lokasi:</span>
                            <p class="mt-1 text-gray-900 text-sm sm:text-base">{{ $dokumentasi->lokasi }}</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">Tanggal Dokumentasi:</span>
                            <p class="mt-1 text-gray-900 text-sm sm:text-base">
                                {{ optional($dokumentasi->tanggal_dokumentasi)->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">Perusahaan:</span>
                            <p class="mt-1 text-gray-900 text-sm sm:text-base">{{ $dokumentasi->perusahaan }}</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">Pengawas:</span>
                            <p class="mt-1 text-gray-900 text-sm sm:text-base">{{ $dokumentasi->pengawas ?? '-' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="font-semibold text-gray-700 text-sm">Keterangan:</span>
                            <p class="mt-1 text-gray-900 text-sm sm:text-base">{{ $dokumentasi->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bagian 2: Data Pelaksana -->
                <div class="mb-6 sm:mb-8">
                    <h4 class="text-sm sm:text-md font-bold text-gray-700 border-b pb-2 mb-4">Data Pelaksana</h4>

                    @if(!empty($dokumentasi->pelaksana))
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($dokumentasi->pelaksana as $index => $pelaksana)
                                <div class="p-3 sm:p-4 border rounded-lg bg-gray-50 shadow-sm">
                                    <p class="text-gray-800 font-semibold mb-2 text-sm sm:text-base">Pelaksana {{ $index + 1 }}</p>
                                    <div class="space-y-1 text-sm sm:text-base">
                                        <p><span class="font-medium text-gray-700">Nama:</span> {{ $pelaksana['nama'] ?? '-' }}</p>
                                        <p><span class="font-medium text-gray-700">Perusahaan:</span> {{ $pelaksana['perusahaan'] ?? '-' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 text-sm sm:text-base">Tidak ada data pelaksana.</p>
                    @endif
                </div>

                <!-- Bagian 3: Data Pendataan -->
                <div>
                    <h4 class="text-sm sm:text-md font-bold text-gray-700 border-b pb-2 mb-4">Data Pendataan</h4>

                    <!-- Perangkat Sentral -->
                    <div class="mb-6">
                        <h5 class="font-semibold text-gray-800 mb-3 text-sm sm:text-base">🔧 Perangkat Sentral</h5>
                        @if(!empty($dokumentasi->perangkat_sentral))
                            <div class="space-y-3 sm:space-y-4">
                                @foreach($dokumentasi->perangkat_sentral as $index => $item)
                                    <div class="border border-gray-300 rounded-lg p-3 sm:p-4 bg-blue-50">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-3">
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Nama:</span>
                                                <p class="text-gray-900 text-sm sm:text-base mt-1">{{ $item['nama'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Qty:</span>
                                                <p class="text-gray-900 text-sm sm:text-base mt-1">{{ $item['qty'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Status:</span>
                                                <p class="text-gray-900 mt-1">
                                                    <span class="px-2 py-1 rounded text-xs font-semibold inline-block
                                                        {{ strtolower($item['status'] ?? '') == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $item['status'] ?? '-' }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Keterangan:</span>
                                                <p class="text-gray-900 text-sm sm:text-base mt-1">{{ $item['keterangan'] ?? '-' }}</p>
                                            </div>
                                        </div>

                                        @if(!empty($item['photo_path']))
                                            <div class="mt-4">
                                                <span class="font-semibold text-gray-700 block mb-2 text-xs sm:text-sm">📷 Foto Dokumentasi:</span>
                                                <div class="border border-gray-300 rounded-lg p-2 bg-white">
                                                    <img src="{{ Storage::url($item['photo_path']) }}" 
                                                         alt="Foto {{ $item['nama'] }}"
                                                         class="w-full h-auto max-w-md mx-auto rounded-lg cursor-pointer hover:opacity-90 transition"
                                                         onclick="openModal(this.src)"
                                                         loading="lazy">
                                                    
                                                    @if(!empty($item['kode']))
                                                        <p class="text-xs text-gray-600 mt-2 text-center font-semibold">
                                                            Kode: {{ $item['kode'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 text-sm sm:text-base">Tidak ada data perangkat sentral.</p>
                        @endif
                    </div>

                    <!-- Sarana Penunjang -->
                    <div>
                        <h5 class="font-semibold text-gray-800 mb-3 text-sm sm:text-base">🧰 Sarana Penunjang</h5>
                        @if(!empty($dokumentasi->sarana_penunjang))
                            <div class="space-y-3 sm:space-y-4">
                                @foreach($dokumentasi->sarana_penunjang as $index => $item)
                                    <div class="border border-gray-300 rounded-lg p-3 sm:p-4 bg-green-50">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-3">
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Nama:</span>
                                                <p class="text-gray-900 text-sm sm:text-base mt-1">{{ $item['nama'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Qty:</span>
                                                <p class="text-gray-900 text-sm sm:text-base mt-1">{{ $item['qty'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Status:</span>
                                                <p class="text-gray-900 mt-1">
                                                    <span class="px-2 py-1 rounded text-xs font-semibold inline-block
                                                        {{ strtolower($item['status'] ?? '') == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $item['status'] ?? '-' }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-700 text-xs sm:text-sm">Keterangan:</span>
                                                <p class="text-gray-900 text-sm sm:text-base mt-1">{{ $item['keterangan'] ?? '-' }}</p>
                                            </div>
                                        </div>

                                        @if(!empty($item['photo_path']))
                                            <div class="mt-4">
                                                <span class="font-semibold text-gray-700 block mb-2 text-xs sm:text-sm">📷 Foto Dokumentasi:</span>
                                                <div class="border border-gray-300 rounded-lg p-2 bg-white">
                                                    <img src="{{ Storage::url($item['photo_path']) }}" 
                                                         alt="Foto {{ $item['nama'] }}"
                                                         class="w-full h-auto max-w-md mx-auto rounded-lg cursor-pointer hover:opacity-90 transition"
                                                         onclick="openModal(this.src)"
                                                         loading="lazy">
                                                    
                                                    @if(!empty($item['kode']))
                                                        <p class="text-xs text-gray-600 mt-2 text-center font-semibold">
                                                            Kode: {{ $item['kode'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 text-sm sm:text-base">Tidak ada data sarana penunjang.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal untuk melihat foto lebih besar -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeModal()">
        <div class="relative w-full h-full flex items-center justify-center">
            <button onclick="closeModal()" class="absolute top-2 right-2 sm:top-4 sm:right-4 text-white text-3xl sm:text-4xl font-bold hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                &times;
            </button>
            <img id="modalImage" src="" alt="Foto Besar" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    <script>
        function openModal(src) {
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('modalImage').src = src;
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('modalImage').src = '';
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Prevent modal close when clicking on image
        document.getElementById('modalImage').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
</x-app-layout>

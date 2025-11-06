<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokumentasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('dokumentasi.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <form action="{{ route('dokumentasi.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- ========== BAGIAN 1: INFORMASI UMUM ========== -->
                        <div class="mb-8">
                            <h4 class="text-base sm:text-lg font-bold text-gray-700 border-b pb-2 mb-4">Informasi Umum</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label for="nomor_dokumen" class="block text-sm font-medium text-gray-700 mb-1">Nomor Dokumen</label>
                                    <input type="text" name="nomor_dokumen" id="nomor_dokumen"
                                           value="{{ old('nomor_dokumen', $dokumentasi->nomor_dokumen) }}" readonly
                                           class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm">
                                </div>

                                <div>
                                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                    <input type="text" name="lokasi" id="lokasi" 
                                           value="{{ old('lokasi', $dokumentasi->lokasi) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Masukkan lokasi dokumentasi" required>
                                </div>

                                <div>
                                    <label for="tanggal_dokumentasi" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dokumentasi</label>
                                    <input type="datetime-local" name="tanggal_dokumentasi" id="tanggal_dokumentasi"
                                           value="{{ old('tanggal_dokumentasi', \Carbon\Carbon::parse($dokumentasi->tanggal_dokumentasi)->format('Y-m-d\TH:i')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>

                                <div>
                                    <label for="perusahaan" class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                                    <input type="text" name="perusahaan" id="perusahaan"
                                           value="{{ old('perusahaan', $dokumentasi->perusahaan ?? 'PT. Aplikanusa Lintasarta') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="pengawas" class="block text-sm font-medium text-gray-700 mb-1">Pengawas</label>
                                    <input type="text" name="pengawas" id="pengawas"
                                           value="{{ old('pengawas', $dokumentasi->pengawas) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Nama pengawas (opsional)">
                                </div>

                                <div>
                                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Tambahkan keterangan (opsional)">{{ old('keterangan', $dokumentasi->keterangan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- ========== BAGIAN 2: DATA PELAKSANA ========== -->
                        <div class="mb-8">
                            <h4 class="text-base sm:text-lg font-bold text-gray-700 border-b pb-2 mb-4">Data Pelaksana</h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                @for($i = 0; $i < 3; $i++)
                                    @php
                                        $pelaksana = isset($dokumentasi->pelaksana[$i]) ? $dokumentasi->pelaksana[$i] : ['nama' => '', 'perusahaan' => ''];
                                    @endphp
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Pelaksana {{ $i + 1 }} - Nama {{ $i > 0 ? '(Opsional)' : '' }}
                                        </label>
                                        <input type="text" name="pelaksana[{{ $i }}][nama]" 
                                               value="{{ old('pelaksana.'.$i.'.nama', $pelaksana['nama']) }}" 
                                               {{ $i == 0 ? 'required' : '' }}
                                               placeholder="Nama pelaksana {{ $i + 1 }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Pelaksana {{ $i + 1 }} - Perusahaan {{ $i > 0 ? '(Opsional)' : '' }}
                                        </label>
                                        <input type="text" name="pelaksana[{{ $i }}][perusahaan]" 
                                               value="{{ old('pelaksana.'.$i.'.perusahaan', $pelaksana['perusahaan']) }}" 
                                               {{ $i == 0 ? 'required' : '' }}
                                               placeholder="Perusahaan pelaksana {{ $i + 1 }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- ========== BAGIAN 3: PERANGKAT SENTRAL ========== -->
                        <div class="mb-8">
                            <h4 class="text-base sm:text-lg font-bold text-gray-700 border-b pb-2 mb-4">Perangkat Sentral</h4>
                            <div id="perangkat-sentral-container" class="space-y-4">
                                @foreach($dokumentasi->perangkat_sentral ?? [] as $index => $item)
                                    <div class="bg-blue-50 rounded-lg shadow-sm p-3 sm:p-4 relative perangkat-sentral-item" data-index="{{ $index }}">
                                        @if($index > 0)
                                        <button type="button" class="remove-item absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center font-bold shadow-lg z-10" title="Hapus item">×</button>
                                        @endif
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                                            <div class="lg:col-span-2">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama Perangkat</label>
                                                <input type="text" name="perangkat_sentral[{{ $index }}][nama]" 
                                                       value="{{ old('perangkat_sentral.'.$index.'.nama', $item['nama'] ?? '') }}"
                                                       placeholder="Nama perangkat" 
                                                       class="nama-perangkat mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                                       {{ $index == 0 ? 'readonly' : 'required' }}>
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Qty <span class="text-xs text-gray-500">(opsional)</span></label>
                                                <input type="number" name="perangkat_sentral[{{ $index }}][qty]" 
                                                       value="{{ old('perangkat_sentral.'.$index.'.qty', $item['qty'] ?? '') }}"
                                                       min="0"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status <span class="text-xs text-gray-500">(opsional)</span></label>
                                                <select name="perangkat_sentral[{{ $index }}][status]" 
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Active" {{ old('perangkat_sentral.'.$index.'.status', $item['status'] ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Shutdown" {{ old('perangkat_sentral.'.$index.'.status', $item['status'] ?? '') == 'Shutdown' ? 'selected' : '' }}>Shutdown</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Keterangan <span class="text-xs text-gray-500">(opsional)</span></label>
                                                <input type="text" name="perangkat_sentral[{{ $index }}][keterangan]" 
                                                       value="{{ old('perangkat_sentral.'.$index.'.keterangan', $item['keterangan'] ?? '') }}"
                                                       placeholder="Keterangan"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <!-- Foto Section -->
                                        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Perangkat (Opsional)</label>
                                            
                                            @if(!empty($item['photo_path']))
                                                <div class="existing-photo mb-3">
                                                    <img src="{{ asset('storage/' . $item['photo_path']) }}" 
                                                         alt="Existing photo" 
                                                         class="w-full aspect-square object-cover rounded-lg border">
                                                    <p class="text-xs text-gray-600 mt-2 text-center">Foto saat ini</p>
                                                    <button type="button" class="change-photo mt-2 w-full px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                        Ganti Foto
                                                    </button>
                                                    <input type="hidden" name="perangkat_sentral[{{ $index }}][existing_photo]" value="{{ $item['photo_path'] }}">
                                                </div>
                                            @endif

                                            <div class="new-photo-section {{ !empty($item['photo_path']) ? 'hidden' : '' }}">
                                                <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" autoplay playsinline></video>
                                                <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
                                                <canvas class="hidden"></canvas>
                                                <div class="flex flex-wrap gap-2 justify-center mb-3">
                                                    <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Buka Kamera</button>
                                                    <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Ambil Foto</button>
                                                    <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Foto Ulang</button>
                                                </div>
                                                <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded"></div>
                                            </div>
                                            
                                            <input type="hidden" name="perangkat_sentral[{{ $index }}][photo_data]">
                                            <input type="hidden" name="perangkat_sentral[{{ $index }}][photo_latitude]">
                                            <input type="hidden" name="perangkat_sentral[{{ $index }}][photo_longitude]">
                                            <input type="hidden" name="perangkat_sentral[{{ $index }}][photo_timestamp]">
                                            <input type="hidden" name="perangkat_sentral[{{ $index }}][kode]" class="kode-perangkat" value="{{ $item['kode'] ?? '1.'.($index+1).'.'.($item['nama'] ?? '') }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-end mt-3">
                                <button type="button" id="add-perangkat-sentral"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow">
                                    + Tambah Perangkat Sentral
                                </button>
                            </div>
                        </div>

                        <!-- ========== BAGIAN 4: SARANA PENUNJANG ========== -->
                        <div class="mb-8">
                            <h4 class="text-base sm:text-lg font-bold text-gray-700 border-b pb-2 mb-4">Sarana Penunjang</h4>
                            <div id="sarana-penunjang-container" class="space-y-4">
                                @foreach($dokumentasi->sarana_penunjang ?? [] as $index => $item)
                                    <div class="bg-green-50 rounded-lg shadow-sm p-3 sm:p-4 relative sarana-penunjang-item" data-index="{{ $index }}">
                                        @if($index > 0)
                                        <button type="button" class="remove-item absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center font-bold shadow-lg z-10" title="Hapus item">×</button>
                                        @endif
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                                            <div class="lg:col-span-2">
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama Sarana</label>
                                                <input type="text" name="sarana_penunjang[{{ $index }}][nama]" 
                                                       value="{{ old('sarana_penunjang.'.$index.'.nama', $item['nama'] ?? '') }}"
                                                       placeholder="Nama sarana" 
                                                       class="nama-sarana mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                                       {{ $index == 0 ? 'readonly' : 'required' }}>
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Qty <span class="text-xs text-gray-500">(opsional)</span></label>
                                                <input type="number" name="sarana_penunjang[{{ $index }}][qty]" 
                                                       value="{{ old('sarana_penunjang.'.$index.'.qty', $item['qty'] ?? '') }}"
                                                       min="0"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status <span class="text-xs text-gray-500">(opsional)</span></label>
                                                <select name="sarana_penunjang[{{ $index }}][status]" 
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Active" {{ old('sarana_penunjang.'.$index.'.status', $item['status'] ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Shutdown" {{ old('sarana_penunjang.'.$index.'.status', $item['status'] ?? '') == 'Shutdown' ? 'selected' : '' }}>Shutdown</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Keterangan <span class="text-xs text-gray-500">(opsional)</span></label>
                                                <input type="text" name="sarana_penunjang[{{ $index }}][keterangan]" 
                                                       value="{{ old('sarana_penunjang.'.$index.'.keterangan', $item['keterangan'] ?? '') }}"
                                                       placeholder="Keterangan"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <!-- Foto Section -->
                                        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
                                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Sarana (Opsional)</label>
                                            
                                            @if(!empty($item['photo_path']))
                                                <div class="existing-photo mb-3">
                                                    <img src="{{ asset('storage/' . $item['photo_path']) }}" 
                                                         alt="Existing photo" 
                                                         class="w-full aspect-square object-cover rounded-lg border">
                                                    <p class="text-xs text-gray-600 mt-2 text-center">Foto saat ini</p>
                                                    <button type="button" class="change-photo mt-2 w-full px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg">
                                                        Ganti Foto
                                                    </button>
                                                    <input type="hidden" name="sarana_penunjang[{{ $index }}][existing_photo]" value="{{ $item['photo_path'] }}">
                                                </div>
                                            @endif

                                            <div class="new-photo-section {{ !empty($item['photo_path']) ? 'hidden' : '' }}">
                                                <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" autoplay playsinline></video>
                                                <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
                                                <canvas class="hidden"></canvas>
                                                <div class="flex flex-wrap gap-2 justify-center mb-3">
                                                    <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Buka Kamera</button>
                                                    <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Ambil Foto</button>
                                                    <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Foto Ulang</button>
                                                </div>
                                                <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded"></div>
                                            </div>
                                            
                                            <input type="hidden" name="sarana_penunjang[{{ $index }}][photo_data]">
                                            <input type="hidden" name="sarana_penunjang[{{ $index }}][photo_latitude]">
                                            <input type="hidden" name="sarana_penunjang[{{ $index }}][photo_longitude]">
                                            <input type="hidden" name="sarana_penunjang[{{ $index }}][photo_timestamp]">
                                            <input type="hidden" name="sarana_penunjang[{{ $index }}][kode]" class="kode-sarana" value="{{ $item['kode'] ?? '2.'.($index+1).'.'.($item['nama'] ?? '') }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-end mt-3">
                                <button type="button" id="add-sarana-penunjang"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow">
                                    + Tambah Sarana Penunjang
                                </button>
                            </div>
                        </div>

                        <!-- ========== BUTTON SIMPAN ========== -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                            <a href="{{ route('dokumentasi.index') }}" 
                               class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg shadow text-center">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow">
                                Update Dokumentasi
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
const PHOTO_CONFIG = {
    size: 800,
    quality: 0.85
};

function cropToSquare(sourceCanvas) {
    const size = Math.min(sourceCanvas.width, sourceCanvas.height);
    const x = (sourceCanvas.width - size) / 2;
    const y = (sourceCanvas.height - size) / 2;
    
    const squareCanvas = document.createElement('canvas');
    squareCanvas.width = PHOTO_CONFIG.size;
    squareCanvas.height = PHOTO_CONFIG.size;
    const ctx = squareCanvas.getContext('2d');
    
    ctx.drawImage(
        sourceCanvas,
        x, y, size, size,
        0, 0, PHOTO_CONFIG.size, PHOTO_CONFIG.size
    );
    
    return squareCanvas;
}

// ==================== WATERMARK WITH GEOLOCATION (REDUCED SIZE) ====================
async function addWatermarkToCanvas(canvas) {
    const ctx = canvas.getContext('2d');
    const timestamp = new Date();
    
    // Format waktu tanpa detik
    const formattedTime = timestamp.toLocaleString('id-ID', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
    const hari = timestamp.toLocaleDateString('id-ID', { weekday: 'long' });

    let latitude = null;
    let longitude = null;
    let lokasiText = "Mengambil lokasi...";

    if (navigator.geolocation) {
        await new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(async pos => {
                latitude = pos.coords.latitude;
                longitude = pos.coords.longitude;

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`);
                    const data = await response.json();
                    
                    // Extract lokasi ringkas: nama jalan, kabupaten, provinsi
                    const address = data.address || {};
                    const parts = [];
                    
                    // Nama jalan/lokasi
                    if (address.road) parts.push(address.road);
                    else if (address.neighbourhood) parts.push(address.neighbourhood);
                    else if (address.suburb) parts.push(address.suburb);
                    
                    // Nomor rumah jika ada
                    if (address.house_number) {
                        parts[parts.length - 1] = `${parts[parts.length - 1]} No.${address.house_number}`;
                    }
                    
                    // Kabupaten/Kota
                    if (address.city) parts.push(address.city);
                    else if (address.county) parts.push(address.county);
                    else if (address.state_district) parts.push(address.state_district);
                    
                    // Provinsi
                    if (address.state) parts.push(address.state);
                    
                    lokasiText = parts.length > 0 ? parts.join(', ') : 'Lokasi tidak diketahui';
                    
                    // Batasi panjang teks max 60 karakter
                    if (lokasiText.length > 60) {
                        lokasiText = lokasiText.substring(0, 57) + '...';
                    }
                } catch {
                    lokasiText = "Gagal mengambil nama lokasi";
                }
                resolve();
            }, () => {
                lokasiText = "Lokasi tidak diizinkan";
                resolve();
            }, { enableHighAccuracy: true, timeout: 7000, maximumAge: 0 });
        });
    } else {
        lokasiText = "Geolokasi tidak didukung";
    }

    // Draw watermark - REDUCED SIZE VERSION (SAMA DENGAN CREATE)
    const padding = 15;
    const fontSize = Math.max(32, canvas.width / 25);
    const lineHeight = fontSize * 1.4;
    
    ctx.font = `bold ${fontSize}px Arial`;
    ctx.textBaseline = 'bottom';
    
    // Teks dengan outline untuk keterbacaan
    const texts = [
        `📍 ${lokasiText}`,
        `🕓 ${hari}, ${formattedTime}`,
        `🌐 ${latitude?.toFixed(5) || '-'}, ${longitude?.toFixed(5) || '-'}`
    ];
    
    let yPosition = canvas.height - padding;
    
    texts.reverse().forEach(text => {
        // Outline hitam lebih tebal untuk keterbacaan
        ctx.strokeStyle = 'rgba(0,0,0,0.9)';
        ctx.lineWidth = 4;
        ctx.strokeText(text, padding, yPosition);
        
        // Teks putih di atas
        ctx.fillStyle = 'white';
        ctx.fillText(text, padding, yPosition);
        
        yPosition -= lineHeight;
    });

    return {
        latitude,
        longitude,
        timestamp: timestamp.toISOString(),
        locationText: lokasiText,
        formattedTime,
        hari
    };
}

function setupCameraHandler(container, itemSelector) {
    if (!container) return;

    container.addEventListener('click', async e => {
        const item = e.target.closest(itemSelector);
        if (!item) return;

        const photoSection = item.querySelector('.new-photo-section');
        const video = photoSection?.querySelector('.camera-preview');
        const img = photoSection?.querySelector('.captured-image');
        const startBtn = photoSection?.querySelector('.start-camera');
        const captureBtn = photoSection?.querySelector('.capture-photo');
        const retakeBtn = photoSection?.querySelector('.retake-photo');
        const photoInfo = photoSection?.querySelector('.photo-info');

        const photoDataInput = item.querySelector('input[name$="[photo_data]"]');
        const latInput = item.querySelector('input[name$="[photo_latitude]"]');
        const lngInput = item.querySelector('input[name$="[photo_longitude]"]');
        const timeInput = item.querySelector('input[name$="[photo_timestamp]"]');

        // Handle "Ganti Foto" button
        if (e.target.classList.contains('change-photo')) {
            const existingPhoto = item.querySelector('.existing-photo');
            const newPhotoSection = item.querySelector('.new-photo-section');
            
            if (existingPhoto) existingPhoto.classList.add('hidden');
            if (newPhotoSection) newPhotoSection.classList.remove('hidden');
        }

        if (e.target.classList.contains('start-camera')) {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    } 
                });
                video.srcObject = stream;
                video.classList.remove('hidden');
                startBtn.classList.add('hidden');
                captureBtn.classList.remove('hidden');
            } catch (err) {
                alert('Gagal membuka kamera: ' + err.message);
            }
        }

        if (e.target.classList.contains('capture-photo')) {
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = video.videoWidth;
            tempCanvas.height = video.videoHeight;
            const tempCtx = tempCanvas.getContext('2d');
            tempCtx.drawImage(video, 0, 0);

            const squareCanvas = cropToSquare(tempCanvas);
            const metadata = await addWatermarkToCanvas(squareCanvas);

            function displayFinalImage(metadata) {
                const photoData = squareCanvas.toDataURL('image/jpeg', PHOTO_CONFIG.quality);

                img.src = photoData;
                img.classList.remove('hidden');
                video.classList.add('hidden');
                captureBtn.classList.add('hidden');
                retakeBtn.classList.remove('hidden');

                if (photoDataInput) photoDataInput.value = photoData;
                if (latInput) latInput.value = metadata.latitude || '';
                if (lngInput) lngInput.value = metadata.longitude || '';
                if (timeInput) timeInput.value = metadata.timestamp;

                photoInfo.innerHTML = `
                    <strong>Lokasi:</strong> ${metadata.locationText}<br>
                    <strong>Koordinat:</strong> ${metadata.latitude?.toFixed(5) || '-'}, ${metadata.longitude?.toFixed(5) || '-'}<br>
                    <strong>Waktu:</strong> ${metadata.formattedTime}
                `;

                video.srcObject?.getTracks().forEach(track => track.stop());
            }

            displayFinalImage(metadata);
        }

        if (e.target.classList.contains('retake-photo')) {
            img.classList.add('hidden');
            retakeBtn.classList.add('hidden');
            startBtn.classList.remove('hidden');
            if (photoInfo) photoInfo.innerHTML = '';
            if (photoDataInput) photoDataInput.value = '';
        }
    });
}

function createNewPerangkatItem(index) {
    const div = document.createElement('div');
    div.className = 'bg-gray-50 rounded-lg shadow-sm p-3 sm:p-4 relative perangkat-sentral-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <button type="button" class="remove-item absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center font-bold shadow-lg z-10" title="Hapus item">×</button>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
            <div class="lg:col-span-2">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama Perangkat</label>
                <input type="text" name="perangkat_sentral[${index}][nama]" placeholder="Nama perangkat" required
                       class="nama-perangkat mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Qty</label>
                <input type="number" name="perangkat_sentral[${index}][qty]" min="1" value="1"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="perangkat_sentral[${index}][status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih --</option>
                    <option value="Active">Active</option>
                    <option value="Shutdown">Shutdown</option>
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <input type="text" name="perangkat_sentral[${index}][keterangan]" placeholder="Keterangan (opsional)"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Perangkat (Opsional)</label>
            <div class="new-photo-section">
                <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" autoplay playsinline></video>
                <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
                <canvas class="hidden"></canvas>
                <div class="flex flex-wrap gap-2 justify-center mb-3">
                    <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Buka Kamera</button>
                    <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Ambil Foto</button>
                    <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Foto Ulang</button>
                </div>
                <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded"></div>
            </div>
            <input type="hidden" name="perangkat_sentral[${index}][photo_data]">
            <input type="hidden" name="perangkat_sentral[${index}][photo_latitude]">
            <input type="hidden" name="perangkat_sentral[${index}][photo_longitude]">
            <input type="hidden" name="perangkat_sentral[${index}][photo_timestamp]">
            <input type="hidden" name="perangkat_sentral[${index}][kode]" class="kode-perangkat">
        </div>
    `;
    return div;
}

function createNewSaranaItem(index) {
    const div = document.createElement('div');
    div.className = 'bg-gray-50 rounded-lg shadow-sm p-3 sm:p-4 relative sarana-penunjang-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <button type="button" class="remove-item absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center font-bold shadow-lg z-10" title="Hapus item">×</button>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
            <div class="lg:col-span-2">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama Sarana</label>
                <input type="text" name="sarana_penunjang[${index}][nama]" placeholder="Nama sarana" required
                       class="nama-sarana mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Qty</label>
                <input type="number" name="sarana_penunjang[${index}][qty]" min="1" value="1"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="sarana_penunjang[${index}][status]"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih --</option>
                    <option value="Active">Active</option>
                    <option value="Shutdown">Shutdown</option>
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <input type="text" name="sarana_penunjang[${index}][keterangan]" placeholder="Keterangan (opsional)"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white">
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Sarana (Opsional)</label>
            <div class="new-photo-section">
                <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3 hidden" autoplay playsinline></video>
                <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
                <canvas class="hidden"></canvas>
                <div class="flex flex-wrap gap-2 justify-center mb-3">
                    <button type="button" class="start-camera px-3 sm:px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Buka Kamera</button>
                    <button type="button" class="capture-photo hidden px-3 sm:px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Ambil Foto</button>
                    <button type="button" class="retake-photo hidden px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs sm:text-sm font-semibold rounded-lg">Foto Ulang</button>
                </div>
                <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded"></div>
            </div>
            <input type="hidden" name="sarana_penunjang[${index}][photo_data]">
            <input type="hidden" name="sarana_penunjang[${index}][photo_latitude]">
            <input type="hidden" name="sarana_penunjang[${index}][photo_longitude]">
            <input type="hidden" name="sarana_penunjang[${index}][photo_timestamp]">
            <input type="hidden" name="sarana_penunjang[${index}][kode]" class="kode-sarana">
        </div>
    `;
    return div;
}

document.addEventListener("DOMContentLoaded", () => {
    const psContainer = document.getElementById('perangkat-sentral-container');
    const saranaContainer = document.getElementById('sarana-penunjang-container');
    const addPS = document.getElementById('add-perangkat-sentral');
    const addSarana = document.getElementById('add-sarana-penunjang');

    setupCameraHandler(psContainer, '.perangkat-sentral-item');
    setupCameraHandler(saranaContainer, '.sarana-penunjang-item');

    // PERANGKAT SENTRAL
    if (addPS && psContainer) {
        addPS.addEventListener('click', () => {
            const index = psContainer.querySelectorAll('.perangkat-sentral-item').length;
            const newItem = createNewPerangkatItem(index);
            psContainer.appendChild(newItem);
            updateKode();
        });

        psContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item')) {
                if (confirm('Yakin ingin menghapus item ini?')) {
                    e.target.closest('.perangkat-sentral-item').remove();
                    reindexPerangkat();
                    updateKode();
                }
            }
        });

        function reindexPerangkat() {
            psContainer.querySelectorAll('.perangkat-sentral-item').forEach((item, idx) => {
                item.setAttribute('data-index', idx);
                item.querySelectorAll('input, select, textarea').forEach(el => {
                    const name = el.getAttribute('name');
                    if (name) {
                        el.setAttribute('name', name.replace(/\[\d+\]/, `[${idx}]`));
                    }
                });
            });
        }

        function updateKode() {
            psContainer.querySelectorAll('.perangkat-sentral-item').forEach((item, idx) => {
                const namaInput = item.querySelector('.nama-perangkat');
                if (namaInput && !namaInput.hasAttribute('readonly')) {
                    const nama = namaInput.value.trim() || 'alat';
                    const kode = `1.${idx + 1}.${nama}`;
                    const kodeInput = item.querySelector('.kode-perangkat');
                    if (kodeInput) kodeInput.value = kode;
                }
            });
        }

        psContainer.addEventListener('input', e => {
            if (e.target.classList.contains('nama-perangkat')) updateKode();
        });
    }

    // SARANA PENUNJANG
    if (addSarana && saranaContainer) {
        addSarana.addEventListener('click', () => {
            const index = saranaContainer.querySelectorAll('.sarana-penunjang-item').length;
            const newItem = createNewSaranaItem(index);
            saranaContainer.appendChild(newItem);
            updateKodeSarana();
        });

        saranaContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item')) {
                if (confirm('Yakin ingin menghapus item ini?')) {
                    e.target.closest('.sarana-penunjang-item').remove();
                    reindexSarana();
                    updateKodeSarana();
                }
            }
        });

        function reindexSarana() {
            saranaContainer.querySelectorAll('.sarana-penunjang-item').forEach((item, idx) => {
                item.setAttribute('data-index', idx);
                item.querySelectorAll('input, select, textarea').forEach(el => {
                    const name = el.getAttribute('name');
                    if (name) {
                        el.setAttribute('name', name.replace(/\[\d+\]/, `[${idx}]`));
                    }
                });
            });
        }

        function updateKodeSarana() {
            saranaContainer.querySelectorAll('.sarana-penunjang-item').forEach((item, idx) => {
                const namaInput = item.querySelector('.nama-sarana');
                if (namaInput && !namaInput.hasAttribute('readonly')) {
                    const nama = namaInput.value.trim() || 'sarana';
                    const kode = `2.${idx + 1}.${nama}`;
                    const kodeInput = item.querySelector('.kode-sarana');
                    if (kodeInput) kodeInput.value = kode;
                }
            });
        }

        saranaContainer.addEventListener('input', e => {
            if (e.target.classList.contains('nama-sarana')) updateKodeSarana();
        });
    }
});
</script>

</x-app-layout>

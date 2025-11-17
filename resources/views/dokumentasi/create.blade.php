<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Dokumentasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

<!-- ========== BAGIAN 1: INFORMASI UMUM ========== -->
                    <div class="mb-8">
                        <h4 class="text-md font-bold text-gray-700 border-b pb-2 mb-4">Informasi Umum</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nomor_dokumen" class="block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                                <input type="text" name="nomor_dokumen" id="nomor_dokumen"
                                       value="FM-LAP-D2-SOP-003-014" readonly
                                       class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <div>
                            
                            <select name="location" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">-- Pilih Lokasi --</option>
                                @if(isset($centralsByArea))
                                    @foreach($centralsByArea as $area => $centrals)
                                        <optgroup label="{{ $area }}">
                                            @foreach($centrals as $central)
                                                {{-- Value disamakan dengan format Genset: ID (Nama) --}}
                                                <option value="{{ $central->id_sentral }} ({{ $central->nama }})"
                                                    {{ old('location') == $central->id_sentral . ' (' . $central->nama . ')' ? 'selected' : '' }}>
                                                    {{ $central->id_sentral }} - {{ $central->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @else
                                    <option value="" disabled>Data Central tidak ditemukan (Cek Controller)</option>
                                @endif
                            </select>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                            </div>

                            <div>
    <label for="tanggal_input" class="block text-sm font-medium text-gray-700">Tanggal Dokumentasi</label>
    <input type="date" name="tanggal_input" id="tanggal_input"
            value="{{ old('tanggal_input') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<input type="hidden" name="waktu_auto" id="waktu_auto" value="">

<input type="hidden" name="tanggal_dokumentasi" id="tanggal_dokumentasi_gabungan" value="">

                            <div>
                                <label for="perusahaan" class="block text-sm font-medium text-gray-700">Perusahaan</label>
                                <input type="text" name="perusahaan" id="perusahaan"
                                       value="{{ old('perusahaan', 'PT. Aplikanusa Lintasarta') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="pengawas" class="block text-sm font-medium text-gray-700">Pengawas</label>
                                <input type="text" name="pengawas" id="pengawas" value="{{ old('pengawas') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       placeholder="Nama pengawas (opsional)">
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="2"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                          placeholder="Tambahkan keterangan (opsional)">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                    </div>

<!-- ========== BAGIAN 2: DATA PELAKSANA ========== -->
<div class="mb-8">
    <h4 class="text-md font-bold text-gray-700 border-b pb-2 mb-4">Data Pelaksana</h4>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Pelaksana 1 - Nama</label>
            <input type="text" name="pelaksana[0][nama]" value="{{ old('pelaksana.0.nama') }}" required
                   placeholder="Nama pelaksana 1"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Pelaksana 1 - Perusahaan</label>
            <input type="text" name="pelaksana[0][perusahaan]" value="{{ old('pelaksana.0.perusahaan') }}" required
                   placeholder="Perusahaan pelaksana 1"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Pelaksana 2 - Nama (Opsional)</label>
            <input type="text" name="pelaksana[1][nama]" value="{{ old('pelaksana.1.nama') }}"
                   placeholder="Nama pelaksana 2"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Pelaksana 2 - Perusahaan (Opsional)</label>
            <input type="text" name="pelaksana[1][perusahaan]" value="{{ old('pelaksana.1.perusahaan') }}"
                   placeholder="Perusahaan pelaksana 2"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Pelaksana 3 - Nama (Opsional)</label>
            <input type="text" name="pelaksana[2][nama]" value="{{ old('pelaksana.2.nama') }}"
                   placeholder="Nama pelaksana 3"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Pelaksana 3 - Perusahaan (Opsional)</label>
            <input type="text" name="pelaksana[2][perusahaan]" value="{{ old('pelaksana.2.perusahaan') }}"
                   placeholder="Perusahaan pelaksana 3"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
    </div>
</div>

{{-- PERANGKAT SENTRAL --}}
<div class="mb-6">
    <h4 class="font-semibold text-lg mb-3">Perangkat Sentral</h4>
    <div id="perangkat-sentral-container" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-blue-50 rounded-lg shadow-sm relative perangkat-sentral-item" data-index="0" data-fixed="true">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Nama Perangkat</label>
                <input type="text" name="perangkat_sentral[0][nama]" value="PERANGKAT SENTRAL" readonly
                       class="nama-perangkat mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Qty <span class="text-xs text-gray-500">(opsional)</span></label>
                <input type="number" name="perangkat_sentral[0][qty]" min="0" value=""
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status <span class="text-xs text-gray-500">(opsional)</span></label>
                <select name="perangkat_sentral[0][status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Pilih --</option>
                    <option value="Active">Active</option>
                    <option value="Shutdown">Shutdown</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan <span class="text-xs text-gray-500">(opsional)</span></label>
                <input type="text" name="perangkat_sentral[0][keterangan]" placeholder="Keterangan"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white md:col-span-5">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Perangkat (Opsional)</label>
                
                <!-- Pilihan Metode Input -->
                <div class="flex gap-3 mb-4 justify-center">
                    <button type="button" class="method-camera px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">📷 Kamera</button>
                    <button type="button" class="method-upload px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg">📁 Upload File</button>
                </div>

                <!-- Area Kamera -->
                <div class="camera-area hidden">
                    <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3" autoplay playsinline></video>
                    <div class="flex gap-2 justify-center mb-3">
                        <button type="button" class="capture-photo px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg">Ambil Foto</button>
                        <button type="button" class="cancel-camera px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
                    </div>
                </div>

                <!-- Area Upload -->
                <div class="upload-area hidden">
                    <input type="file" class="file-input hidden" accept="image/*">
                    <div class="border-2 border-dashed border-blue-400 rounded-lg p-6 text-center cursor-pointer hover:bg-blue-50 transition upload-trigger">
                        <p class="text-gray-600">Klik untuk memilih foto atau drag & drop</p>
                        <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max 10MB)</p>
                    </div>
                    <button type="button" class="cancel-upload mt-3 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
                </div>

                <!-- Preview Hasil - FOTO 1:1 SQUARE -->
                <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
                <canvas class="hidden"></canvas>
                <button type="button" class="retake-photo hidden px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg block mx-auto">Ambil Ulang</button>
                
                <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3"></div>
                <input type="hidden" name="perangkat_sentral[0][photo_data]">
                <input type="hidden" name="perangkat_sentral[0][photo_latitude]">
                <input type="hidden" name="perangkat_sentral[0][photo_longitude]">
                <input type="hidden" name="perangkat_sentral[0][photo_timestamp]">
                <input type="hidden" name="perangkat_sentral[0][kode]" class="kode-perangkat" value="1.1.PERANGKAT SENTRAL">
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-3">
        <button type="button" id="add-perangkat-sentral"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
            + Tambah Perangkat Sentral
        </button>
    </div>
</div>

{{-- SARANA PENUNJANG --}}
<div class="mb-6">
    <h4 class="font-semibold text-lg mb-3">Sarana Penunjang</h4>
    <div id="sarana-penunjang-container" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-green-50 rounded-lg shadow-sm relative sarana-penunjang-item" data-index="0" data-fixed="true">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Nama Sarana</label>
                <input type="text" name="sarana_penunjang[0][nama]" value="SARANA PENUNJANG" readonly
                       class="nama-sarana mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Qty <span class="text-xs text-gray-500">(opsional)</span></label>
                <input type="number" name="sarana_penunjang[0][qty]" min="0" value=""
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status <span class="text-xs text-gray-500">(opsional)</span></label>
                <select name="sarana_penunjang[0][status]"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Pilih --</option>
                    <option value="Active">Active</option>
                    <option value="Shutdown">Shutdown</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan <span class="text-xs text-gray-500">(opsional)</span></label>
                <input type="text" name="sarana_penunjang[0][keterangan]" placeholder="Keterangan"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white md:col-span-5">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Sarana (Opsional)</label>
                
                <!-- Pilihan Metode Input -->
                <div class="flex gap-3 mb-4 justify-center">
                    <button type="button" class="method-camera px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">📷 Kamera</button>
                    <button type="button" class="method-upload px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg">📁 Upload File</button>
                </div>

                <!-- Area Kamera -->
                <div class="camera-area hidden">
                    <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3" autoplay playsinline></video>
                    <div class="flex gap-2 justify-center mb-3">
                        <button type="button" class="capture-photo px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg">Ambil Foto</button>
                        <button type="button" class="cancel-camera px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
                    </div>
                </div>

                <!-- Area Upload -->
                <div class="upload-area hidden">
                    <input type="file" class="file-input hidden" accept="image/*">
                    <div class="border-2 border-dashed border-blue-400 rounded-lg p-6 text-center cursor-pointer hover:bg-blue-50 transition upload-trigger">
                        <p class="text-gray-600">Klik untuk memilih foto atau drag & drop</p>
                        <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max 10MB)</p>
                    </div>
                    <button type="button" class="cancel-upload mt-3 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
                </div>

                <!-- Preview Hasil - FOTO 1:1 SQUARE -->
                <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
                <canvas class="hidden"></canvas>
                <button type="button" class="retake-photo hidden px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg block mx-auto">Ambil Ulang</button>
                
                <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3"></div>
                <input type="hidden" name="sarana_penunjang[0][photo_data]">
                <input type="hidden" name="sarana_penunjang[0][photo_latitude]">
                <input type="hidden" name="sarana_penunjang[0][photo_longitude]">
                <input type="hidden" name="sarana_penunjang[0][photo_timestamp]">
                <input type="hidden" name="sarana_penunjang[0][kode]" class="kode-sarana" value="2.1.SARANA PENUNJANG">
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-3">
        <button type="button" id="add-sarana-penunjang"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
            + Tambah Sarana Penunjang
        </button>
    </div>
</div>

{{-- BUTTON SIMPAN --}}
<div class="flex justify-end mt-6">
    <button type="submit"
            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow">
        Simpan Dokumentasi
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

/// ==================== WATERMARK WITH GEOLOCATION (EXTRA LARGE) ====================
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

    // Draw watermark - REDUCED SIZE VERSION
    const padding = 15;  // ← SIZING #1: Ubah dari 20 menjadi 15 (lebih kecil)
    const fontSize = Math.max(32, canvas.width / 25);  // ← SIZING #2: Ubah dari 48 & /15 menjadi 32 & /25 (LEBIH KECIL)
    const lineHeight = fontSize * 1.4;  // ← SIZING #3: Ubah dari 1.6 menjadi 1.4 (lebih rapat)
    
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
        ctx.lineWidth = 4;  // ← SIZING #4: Ubah dari 6 menjadi 4 (lebih tipis)
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

function getExifData(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const view = new DataView(e.target.result);
            if (view.getUint16(0, false) != 0xFFD8) {
                resolve(null);
                return;
            }
            
            const length = view.byteLength;
            let offset = 2;
            
            while (offset < length) {
                if (view.getUint16(offset + 2, false) <= 8) {
                    resolve(null);
                    return;
                }
                const marker = view.getUint16(offset, false);
                offset += 2;
                
                if (marker == 0xFFE1) {
                    const exifOffset = offset + 10;
                    const little = view.getUint16(exifOffset) == 0x4949;
                    
                    try {
                        let lat = null, lng = null;
                        const tags = view.getUint16(exifOffset + 8, little);
                        
                        for (let i = 0; i < tags; i++) {
                            const tagOffset = exifOffset + 12 + (i * 12);
                            const tag = view.getUint16(tagOffset, little);
                            
                            if (tag === 0x0002) { // GPS Latitude
                                const latOffset = exifOffset + view.getUint32(tagOffset + 8, little);
                                const d = view.getUint32(latOffset, little) / view.getUint32(latOffset + 4, little);
                                const m = view.getUint32(latOffset + 8, little) / view.getUint32(latOffset + 12, little);
                                const s = view.getUint32(latOffset + 16, little) / view.getUint32(latOffset + 20, little);
                                lat = d + m / 60 + s / 3600;
                            }
                            
                            if (tag === 0x0004) { // GPS Longitude
                                const lngOffset = exifOffset + view.getUint32(tagOffset + 8, little);
                                const d = view.getUint32(lngOffset, little) / view.getUint32(lngOffset + 4, little);
                                const m = view.getUint32(lngOffset + 8, little) / view.getUint32(lngOffset + 12, little);
                                const s = view.getUint32(lngOffset + 16, little) / view.getUint32(lngOffset + 20, little);
                                lng = d + m / 60 + s / 3600;
                            }
                        }
                        
                        if (lat && lng) {
                            resolve({ latitude: lat, longitude: lng });
                            return;
                        }
                    } catch (e) {
                        console.log('Error parsing EXIF:', e);
                    }
                }
                
                offset += view.getUint16(offset, false);
            }
            
            resolve(null);
        };
        reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
    });
}

function setupPhotoHandler(container, itemSelector) {
    if (!container) return;

    container.addEventListener('click', async e => {
        const item = e.target.closest(itemSelector);
        if (!item) return;

        const methodCamera = e.target.classList.contains('method-camera');
        const methodUpload = e.target.classList.contains('method-upload');
        const captureBtn = e.target.classList.contains('capture-photo');
        const cancelCamera = e.target.classList.contains('cancel-camera');
        const cancelUpload = e.target.classList.contains('cancel-upload');
        const retakeBtn = e.target.classList.contains('retake-photo');

        const video = item.querySelector('.camera-preview');
        const img = item.querySelector('.captured-image');
        const cameraArea = item.querySelector('.camera-area');
        const uploadArea = item.querySelector('.upload-area');
        const photoInfo = item.querySelector('.photo-info');
        const fileInput = item.querySelector('.file-input');

        const photoDataInput = item.querySelector('input[name$="[photo_data]"]');
        const latInput = item.querySelector('input[name$="[photo_latitude]"]');
        const lngInput = item.querySelector('input[name$="[photo_longitude]"]');
        const timeInput = item.querySelector('input[name$="[photo_timestamp]"]');

        const methodButtons = item.querySelectorAll('.method-camera, .method-upload');

        // Show camera
        if (methodCamera) {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    } 
                });
                video.srcObject = stream;
                methodButtons.forEach(btn => btn.classList.add('hidden'));
                cameraArea.classList.remove('hidden');
            } catch (err) {
                alert('Gagal membuka kamera: ' + err.message);
            }
        }

        // Show upload
        if (methodUpload) {
            methodButtons.forEach(btn => btn.classList.add('hidden'));
            uploadArea.classList.remove('hidden');
        }

        // Cancel camera
        if (cancelCamera) {
            video.srcObject?.getTracks().forEach(track => track.stop());
            cameraArea.classList.add('hidden');
            methodButtons.forEach(btn => btn.classList.remove('hidden'));
        }

        // Cancel upload
        if (cancelUpload) {
            uploadArea.classList.add('hidden');
            methodButtons.forEach(btn => btn.classList.remove('hidden'));
        }

        // Capture from camera (DENGAN WATERMARK)
        if (captureBtn) {
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = video.videoWidth;
            tempCanvas.height = video.videoHeight;
            const tempCtx = tempCanvas.getContext('2d');
            tempCtx.drawImage(video, 0, 0);

            const squareCanvas = cropToSquare(tempCanvas);
            const metadata = await addWatermarkToCanvas(squareCanvas);

            displayFinalImage(squareCanvas, metadata);
            video.srcObject?.getTracks().forEach(track => track.stop());
            cameraArea.classList.add('hidden');
        }

        // Retake photo
        if (retakeBtn) {
            img.classList.add('hidden');
            item.querySelector('.retake-photo').classList.add('hidden');
            methodButtons.forEach(btn => btn.classList.remove('hidden'));
            if (photoInfo) photoInfo.innerHTML = '';
            if (photoDataInput) photoDataInput.value = '';
        }

        function displayFinalImage(canvas, metadata) {
            const photoData = canvas.toDataURL('image/jpeg', PHOTO_CONFIG.quality);

            img.src = photoData;
            img.classList.remove('hidden');
            item.querySelector('.retake-photo').classList.remove('hidden');

            if (photoDataInput) photoDataInput.value = photoData;
            if (latInput) latInput.value = metadata.latitude || '';
            if (lngInput) lngInput.value = metadata.longitude || '';
            if (timeInput) timeInput.value = metadata.timestamp;

            photoInfo.innerHTML = `
                <strong>Lokasi:</strong> ${metadata.locationText}<br>
                <strong>Koordinat:</strong> ${metadata.latitude?.toFixed(5) || '-'}, ${metadata.longitude?.toFixed(5) || '-'}<br>
                <strong>Waktu:</strong> ${metadata.formattedTime}
            `;
        }
    });

    // Handle file upload
    container.addEventListener('click', e => {
        const uploadTrigger = e.target.closest('.upload-trigger');
        if (!uploadTrigger) return;
        
        const item = uploadTrigger.closest(itemSelector);
        const fileInput = item.querySelector('.file-input');
        fileInput.click();
    });

    // Handle file upload (TANPA WATERMARK)
    container.addEventListener('change', async e => {
        if (!e.target.classList.contains('file-input')) return;
        
        const item = e.target.closest(itemSelector);
        const file = e.target.files[0];
        if (!file) return;

        const img = item.querySelector('.captured-image');
        const uploadArea = item.querySelector('.upload-area');
        const photoInfo = item.querySelector('.photo-info');
        const photoDataInput = item.querySelector('input[name$="[photo_data]"]');
        const latInput = item.querySelector('input[name$="[photo_latitude]"]');
        const lngInput = item.querySelector('input[name$="[photo_longitude]"]');
        const timeInput = item.querySelector('input[name$="[photo_timestamp]"]');

        // Get EXIF data
        const exifData = await getExifData(file);
        const timestamp = new Date();

        // Load image
        const reader = new FileReader();
        reader.onload = async function(event) {
            const tempImg = new Image();
            tempImg.onload = async function() {
                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = tempImg.width;
                tempCanvas.height = tempImg.height;
                const tempCtx = tempCanvas.getContext('2d');
                tempCtx.drawImage(tempImg, 0, 0);

                const squareCanvas = cropToSquare(tempCanvas);

                // Metadata tanpa watermark
                const metadata = {
                    latitude: exifData?.latitude || null,
                    longitude: exifData?.longitude || null,
                    timestamp: timestamp.toISOString(),
                    locationText: exifData?.latitude && exifData?.longitude 
                        ? `${exifData.latitude.toFixed(5)}, ${exifData.longitude.toFixed(5)}` 
                        : 'Tidak ada data lokasi',
                    formattedTime: timestamp.toLocaleString('id-ID'),
                    hari: timestamp.toLocaleDateString('id-ID', { weekday: 'long' })
                };

                const photoData = squareCanvas.toDataURL('image/jpeg', PHOTO_CONFIG.quality);

                img.src = photoData;
                img.classList.remove('hidden');
                uploadArea.classList.add('hidden');
                item.querySelector('.retake-photo').classList.remove('hidden');

                if (photoDataInput) photoDataInput.value = photoData;
                if (latInput) latInput.value = metadata.latitude || '';
                if (lngInput) lngInput.value = metadata.longitude || '';
                if (timeInput) timeInput.value = metadata.timestamp;

                photoInfo.innerHTML = `
                    <strong>Lokasi:</strong> ${metadata.locationText}<br>
                    <strong>Koordinat:</strong> ${metadata.latitude?.toFixed(5) || '-'}, ${metadata.longitude?.toFixed(5) || '-'}<br>
                    <strong>Waktu:</strong> ${metadata.hari}, ${metadata.formattedTime}
                `;

                e.target.value = '';
            };
            tempImg.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Drag & drop
    container.addEventListener('dragover', e => {
        const uploadTrigger = e.target.closest('.upload-trigger');
        if (!uploadTrigger) return;
        e.preventDefault();
        uploadTrigger.classList.add('bg-blue-100');
    });

    container.addEventListener('dragleave', e => {
        const uploadTrigger = e.target.closest('.upload-trigger');
        if (!uploadTrigger) return;
        uploadTrigger.classList.remove('bg-blue-100');
    });

    container.addEventListener('drop', async e => {
        const uploadTrigger = e.target.closest('.upload-trigger');
        if (!uploadTrigger) return;
        e.preventDefault();
        uploadTrigger.classList.remove('bg-blue-100');

        const item = uploadTrigger.closest(itemSelector);
        const file = e.dataTransfer.files[0];
        if (!file || !file.type.startsWith('image/')) {
            alert('File harus berupa gambar');
            return;
        }

        const fileInput = item.querySelector('.file-input');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
    });
}

function createNewPerangkatItem(index) {
    const div = document.createElement('div');
    div.className = 'grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-gray-50 rounded-lg shadow-sm relative perangkat-sentral-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <button type="button" class="remove-item absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold shadow-lg z-10" title="Hapus item">×</button>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Nama Perangkat</label>
            <input type="text" name="perangkat_sentral[${index}][nama]" placeholder="Nama perangkat" required
                   class="nama-perangkat mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Qty</label>
            <input type="number" name="perangkat_sentral[${index}][qty]" min="1" value="1"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="perangkat_sentral[${index}][status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="Active">Active</option>
                <option value="Shutdown">Shutdown</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <input type="text" name="perangkat_sentral[${index}][keterangan]" placeholder="Keterangan (opsional)"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white md:col-span-5">
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Perangkat (Opsional)</label>
            
            <div class="flex gap-3 mb-4 justify-center">
                <button type="button" class="method-camera px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">📷 Kamera</button>
                <button type="button" class="method-upload px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg">📁 Upload File</button>
            </div>

            <div class="camera-area hidden">
                <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3" autoplay playsinline></video>
                <div class="flex gap-2 justify-center mb-3">
                    <button type="button" class="capture-photo px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg">Ambil Foto</button>
                    <button type="button" class="cancel-camera px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
                </div>
            </div>

            <div class="upload-area hidden">
                <input type="file" class="file-input hidden" accept="image/*">
                <div class="border-2 border-dashed border-blue-400 rounded-lg p-6 text-center cursor-pointer hover:bg-blue-50 transition upload-trigger">
                    <p class="text-gray-600">Klik untuk memilih foto atau drag & drop</p>
                    <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max 10MB)</p>
                </div>
                <button type="button" class="cancel-upload mt-3 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
            </div>

            <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
            <canvas class="hidden"></canvas>
            <button type="button" class="retake-photo hidden px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg block mx-auto">Ambil Ulang</button>
            
            <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3"></div>
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
    div.className = 'grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-gray-50 rounded-lg shadow-sm relative sarana-penunjang-item';
    div.setAttribute('data-index', index);
    div.innerHTML = `
        <button type="button" class="remove-item absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold shadow-lg z-10" title="Hapus item">×</button>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Nama Sarana</label>
            <input type="text" name="sarana_penunjang[${index}][nama]" placeholder="Nama sarana" required
                   class="nama-sarana mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Qty</label>
            <input type="number" name="sarana_penunjang[${index}][qty]" min="1" value="1"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="sarana_penunjang[${index}][status]"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="Active">Active</option>
                <option value="Shutdown">Shutdown</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <input type="text" name="sarana_penunjang[${index}][keterangan]" placeholder="Keterangan (opsional)"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 bg-white md:col-span-5">
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-3">Dokumentasi Foto Sarana (Opsional)</label>
            
            <div class="flex gap-3 mb-4 justify-center">
                <button type="button" class="method-camera px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">📷 Kamera</button>
                <button type="button" class="method-upload px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg">📁 Upload File</button>
            </div>

            <div class="camera-area hidden">
                <video class="camera-preview w-full h-48 sm:h-64 bg-black rounded-lg mb-3" autoplay playsinline></video>
                <div class="flex gap-2 justify-center mb-3">
                    <button type="button" class="capture-photo px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg">Ambil Foto</button>
                    <button type="button" class="cancel-camera px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
                </div>
            </div>

            <div class="upload-area hidden">
                <input type="file" class="file-input hidden" accept="image/*">
                <div class="border-2 border-dashed border-blue-400 rounded-lg p-6 text-center cursor-pointer hover:bg-blue-50 transition upload-trigger">
                    <p class="text-gray-600">Klik untuk memilih foto atau drag & drop</p>
                    <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max 10MB)</p>
                </div>
                <button type="button" class="cancel-upload mt-3 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg">Batal</button>
            </div>

            <img class="captured-image w-full aspect-square object-cover rounded-lg mb-3 hidden" alt="Captured">
            <canvas class="hidden"></canvas>
            <button type="button" class="retake-photo hidden px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg block mx-auto">Ambil Ulang</button>
            
            <div class="photo-info text-xs text-gray-600 text-center bg-gray-50 p-2 rounded mt-3"></div>
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

    setupPhotoHandler(psContainer, '.perangkat-sentral-item');
    setupPhotoHandler(saranaContainer, '.sarana-penunjang-item');

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
                const isFixed = item.getAttribute('data-fixed') === 'true';
                if (isFixed) return;
                
                const nama = item.querySelector('.nama-perangkat')?.value.trim() || 'alat';
                const kode = `1.${idx + 1}.${nama}`;
                const kodeInput = item.querySelector('.kode-perangkat');
                if (kodeInput) kodeInput.value = kode;
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
                const isFixed = item.getAttribute('data-fixed') === 'true';
                if (isFixed) return;
                
                const nama = item.querySelector('.nama-sarana')?.value.trim() || 'sarana';
                const kode = `2.${idx + 1}.${nama}`;
                const kodeInput = item.querySelector('.kode-sarana');
                if (kodeInput) kodeInput.value = kode;
            });
        }

        saranaContainer.addEventListener('input', e => {
            if (e.target.classList.contains('nama-sarana')) updateKodeSarana();
        });
    }
});
// Function untuk mendapatkan waktu saat ini dalam format HH:mm:ss
function getCurrentTime() {
    const now = new Date();
    // Gunakan toLocaleTimeString untuk format waktu lokal yang benar
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
}

// Function untuk menggabungkan tanggal dan waktu
function updateCombinedDateTime() {
    const tanggalInput = document.getElementById('tanggal_input');
    const waktuAutoInput = document.getElementById('waktu_auto');
    const gabunganInput = document.getElementById('tanggal_dokumentasi_gabungan');

    // 1. Set waktu otomatis ke input tersembunyi
    waktuAutoInput.value = getCurrentTime();

    // 2. Gabungkan tanggal dari user dengan waktu otomatis
    const tanggalUser = tanggalInput.value;
    const waktuOtomatis = waktuAutoInput.value;

    if (tanggalUser) {
        // Format gabungan: YYYY-MM-DD HH:mm:ss (cocok untuk database)
        gabunganInput.value = `${tanggalUser} ${waktuOtomatis}`;
    } else {
        gabunganInput.value = '';
    }
}

// Panggil saat halaman dimuat (untuk inisiasi)
document.addEventListener('DOMContentLoaded', () => {
    updateCombinedDateTime();

    // Panggil lagi setiap kali user mengubah tanggal
    const tanggalInput = document.getElementById('tanggal_input');
    if (tanggalInput) {
        tanggalInput.addEventListener('change', updateCombinedDateTime);
    }
    
    // Opsional: Perbarui waktu setiap 1 menit (jika perlu akurasi yang lebih baru)
    // setInterval(updateCombinedDateTime, 60000); 
});

// Tambahkan listener pada form submit untuk memastikan waktu terbaru terkirim
document.querySelector('form').addEventListener('submit', () => {
    // Pastikan waktu diupdate tepat sebelum form disubmit
    updateCombinedDateTime(); 
});
</script>

</x-app-layout>

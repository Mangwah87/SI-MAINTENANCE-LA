document.addEventListener('DOMContentLoaded', () => {
    // --- Elemen Global ---
    const cameraModal = document.getElementById('cameraModal');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Info Geolocation
    const geoInfo = {
        lat: document.getElementById('lat'),
        lon: document.getElementById('lon'),
        datetime: document.getElementById('datetime'),
        location: document.getElementById('location')
    };

    // Kontrol Kamera
    const videoSection = document.getElementById('videoSection');
    const capturedImage = document.getElementById('capturedImage');
    const capturedImg = document.getElementById('capturedImg');
    const captureControls = document.getElementById('captureControls');
    const retakeControls = document.getElementById('retakeControls');
    const captureBtn = document.getElementById('captureBtn');
    const switchCameraBtn = document.getElementById('switchCameraBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    const fileInputContainer = document.getElementById('fileInputContainer');
    const imageDataContainer = document.getElementById('image-data-container');
    const deleteImageContainer = document.getElementById('delete-image-container');

    // --- State ---
    let currentStream = null;
    let currentFacingMode = 'environment';
    let currentUploadSection = null;

    // --- [PERUBAHAN] Konstanta Ukuran Tetap ---
    const OUTPUT_WIDTH = 640;
    const OUTPUT_HEIGHT = 480;

    // --- Fungsi Format Waktu (Gaya Referensi) ---
    function getFormattedTimestamp() {
        const timestamp = new Date();
        const timeZone = 'Asia/Makassar';
        const dateString = timestamp.toLocaleDateString('id-ID', { timeZone, day: '2-digit', month: 'long', year: 'numeric' }).toUpperCase();
        const dayString = timestamp.toLocaleDateString('id-ID', { timeZone, weekday: 'long' });
        const timeString = timestamp.toLocaleTimeString('id-ID', { timeZone, hour: '2-digit', minute: '2-digit', hour12: false }).replace('.', ':');
        const isoString = timestamp.toISOString();
        return {
            date: dateString, day: dayString, time: timeString, tz: "WITA", iso: isoString,
            modalFull: `${dayString}, ${dateString}, ${timeString} WITA`
        };
    }

    // --- Logika GPS & Reverse Geocoding ---
    let currentGeo = { latitude: 'Getting...', longitude: 'Getting...', locationName: 'Getting...', error: null };
    async function fetchLocationName(lat, lon) {
        if (!lat || !lon || lat === 'Getting...') { geoInfo.location.textContent = 'Menunggu GPS...'; currentGeo.locationName = 'Menunggu GPS...'; return; }
        geoInfo.location.textContent = 'Mencari nama lokasi...'; currentGeo.locationName = 'Mencari nama lokasi...';
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&accept-language=id&zoom=18`);
            if (!response.ok) throw new Error(`Network response error: ${response.statusText}`);
            const data = await response.json();
            if (data && data.address) {
                const addr = data.address;
                let locationParts = [];
                const neighborhood = addr.village || addr.suburb || addr.city_district || addr.neighbourhood;
                if (neighborhood) locationParts.push(neighborhood);
                const cityOrTown = addr.city || addr.town || addr.county;
                if (cityOrTown) locationParts.push(cityOrTown);
                if (addr.state) locationParts.push(addr.state);
                let locationName = locationParts.filter(part => part).slice(0, 3).join(', ');
                if (!locationName) { locationName = data.display_name ? data.display_name.split(',').slice(0, 3).join(',') : 'Lokasi tidak dikenal'; }
                currentGeo.locationName = locationName;
                geoInfo.location.textContent = locationName;
            } else { throw new Error('Lokasi tidak ditemukan'); }
        } catch (error) {
            console.error('Error fetching location name:', error);
            currentGeo.locationName = 'Gagal mengambil lokasi';
            geoInfo.location.textContent = 'Gagal mengambil lokasi (Error)';
        }
    }
    function watchGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(
                (position) => {
                    const newLat = position.coords.latitude.toFixed(7); const newLon = position.coords.longitude.toFixed(7);
                    if (newLat !== currentGeo.latitude || newLon !== currentGeo.longitude) {
                        currentGeo = { ...currentGeo, latitude: newLat, longitude: newLon, locationName: 'Mencari...', error: null };
                        fetchLocationName(newLat, newLon);
                    }
                    if (geoInfo.lat) geoInfo.lat.textContent = newLat;
                    if (geoInfo.lon) geoInfo.lon.textContent = newLon;
                },
                (error) => {
                    console.error(`Geolocation Error: ${error.message}`);
                    currentGeo = { ...currentGeo, error: error.message, latitude: 'Error', longitude: 'Error', locationName: error.message };
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else { currentGeo.error = 'Geolocation not supported'; }
    }
    watchGeolocation();

    // --- [BARU] Fungsi Helper Letterbox/Pillarbox ---
    function drawLetterboxedImage(context, source) {
        const canvasWidth = context.canvas.width;
        const canvasHeight = context.canvas.height;
        const sourceWidth = source.videoWidth || source.width;
        const sourceHeight = source.videoHeight || source.height;
        if (!sourceWidth || !sourceHeight) return;

        const sourceAspect = sourceWidth / sourceHeight;
        const canvasAspect = canvasWidth / canvasHeight;

        let renderWidth, renderHeight, xStart, yStart;

        if (sourceAspect > canvasAspect) {
            // Gambar lebih lebar dari canvas (Letterbox)
            renderWidth = canvasWidth;
            renderHeight = canvasWidth / sourceAspect;
            xStart = 0;
            yStart = (canvasHeight - renderHeight) / 2;
        } else {
            // Gambar lebih tinggi dari canvas (Pillarbox - kasus Anda)
            renderHeight = canvasHeight;
            renderWidth = canvasHeight * sourceAspect;
            xStart = (canvasWidth - renderWidth) / 2;
            yStart = 0;
        }

        // Mirror only for front camera (selfie)
        if (source === video && currentFacingMode === 'user') {
            context.save();
            context.scale(-1, 1);
            context.drawImage(source, -xStart - renderWidth, yStart, renderWidth, renderHeight);
            context.restore();
        } else {
            // Back camera - natural view
            context.drawImage(source, xStart, yStart, renderWidth, renderHeight);
        }
    }

    // --- [PERUBAHAN] Fungsi Watermark (Ukuran Font Tetap + GPS) ---
    function drawWatermark(context, canvas) {
        const timestamp = getFormattedTimestamp();

        // [BARU] Buat string untuk GPS
        const watermarkGps = `Latitude: ${currentGeo.latitude}, Longitude: ${currentGeo.longitude}`;

        // Ukuran font tetap (dari perubahan sebelumnya)
        const basePadding = 15;
        const largeFontSize = 64;
        const mediumFontSize = 24;
        const smallFontSize = 18;
        const font = "sans-serif";

        // [PERUBAHAN] Hitung ulang Posisi Y untuk memberi ruang bagi GPS
        const yPosTime = canvas.height - basePadding;
        const yPosDay = yPosTime - largeFontSize;
        const yPosDate = yPosDay - mediumFontSize;
        const yPosLocation = yPosDate - mediumFontSize;
        const yPosGps = yPosLocation - mediumFontSize; // <-- Baris baru untuk GPS di atas Lokasi

        // [PERUBAHAN] Hitung ulang Lebar Maksimum (termasuk GPS)
        context.font = `bold ${largeFontSize}px ${font}`; const timeWidth = context.measureText(timestamp.time).width;
        context.font = `bold ${smallFontSize}px ${font}`; const witaWidth = context.measureText(timestamp.tz).width;
        context.font = `bold ${mediumFontSize}px ${font}`; const dateWidth = context.measureText(timestamp.date).width;
        context.font = `bold ${mediumFontSize}px ${font}`; const dayWidth = context.measureText(timestamp.day).width;
        context.font = `bold ${mediumFontSize}px ${font}`; const locationWidth = context.measureText(currentGeo.locationName).width;
        context.font = `bold ${smallFontSize}px ${font}`; const gpsWidth = context.measureText(watermarkGps).width; // <-- Lebar baru GPS

        const maxWidth = Math.max(dateWidth, dayWidth, locationWidth, gpsWidth, (timeWidth + witaWidth + (basePadding * 0.5))); // <-- Tambahkan gpsWidth
        const bgWidth = maxWidth + (basePadding * 2);

        // [PERUBAHAN] Hitung ulang Latar Belakang berdasarkan yPosGps
        const bgHeight = (yPosTime + basePadding) - (yPosGps - smallFontSize - (basePadding * 0.5));
        const bgYPos = yPosGps - smallFontSize - (basePadding * 0.5);

        context.fillStyle = 'rgba(0, 0, 0, 0.6)';
        context.fillRect(0, bgYPos, bgWidth, bgHeight);

        // [PERUBAHAN] Gambar semua teks, dimulai dari GPS
        context.fillStyle = 'white';
        context.textBaseline = 'bottom'; context.textAlign = 'left';

        // Baris 1: GPS (BARU)
        context.font = `bold ${smallFontSize}px ${font}`; // Gunakan font kecil untuk GPS
        context.fillText(watermarkGps, basePadding, yPosGps);

        // Baris 2: Lokasi
        context.font = `bold ${mediumFontSize}px ${font}`;
        context.fillText(currentGeo.locationName, basePadding, yPosLocation);

        // Baris 3: Tanggal
        context.font = `bold ${mediumFontSize}px ${font}`;
        context.fillText(timestamp.date, basePadding, yPosDate);

        // Baris 4: Hari
        context.font = `bold ${mediumFontSize}px ${font}`;
        context.fillText(timestamp.day, basePadding, yPosDay);

        // Baris 5: Waktu (Besar)
        context.font = `bold ${largeFontSize}px ${font}`;
        context.fillText(timestamp.time, basePadding, yPosTime);

        // Baris 5: WITA (Kecil)
        context.font = `bold ${smallFontSize}px ${font}`;
        const yPosWita = yPosTime - (largeFontSize - smallFontSize) - (largeFontSize * 0.1);
        context.fillText(timestamp.tz, basePadding + timeWidth + (basePadding * 0.5), yPosWita);
    }

    // --- Logika Kamera ---
    async function startCamera(facingMode = 'environment') {
        if (currentStream) { currentStream.getTracks().forEach(track => track.stop()); }
        try {
            const constraints = { video: { facingMode, width: { ideal: 1280 }, height: { ideal: 720 } }, audio: false };
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = currentStream;
            currentFacingMode = facingMode;
            video.onloadedmetadata = () => video.play();
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Tidak bisa mengakses kamera. Pastikan Anda memberi izin.\n\nError: ' + err.message);
            closeModal();
        }
    }

    function stopCamera() {
        if (currentStream) { currentStream.getTracks().forEach(track => track.stop()); currentStream = null; }
    }

    function showModal() {
        cameraModal.classList.remove('hidden'); document.body.style.overflow = 'hidden';
        const ts = getFormattedTimestamp();
        geoInfo.datetime.textContent = ts.modalFull;
        geoInfo.lat.textContent = currentGeo.latitude;
        geoInfo.lon.textContent = currentGeo.longitude;
        geoInfo.location.textContent = currentGeo.locationName;
        videoSection.classList.remove('hidden'); capturedImage.classList.add('hidden');
        captureControls.classList.remove('hidden'); retakeControls.classList.add('hidden');
        startCamera(currentFacingMode);
    }

    function closeModal() {
        cameraModal.classList.add('hidden'); document.body.style.overflow = 'auto';
        stopCamera(); currentUploadSection = null;
    }

    async function switchCamera() {
        currentFacingMode = (currentFacingMode === 'user') ? 'environment' : 'user';
        await startCamera(currentFacingMode);
    }

    // --- [PERUBAHAN] capturePhoto (Menggunakan Logic Baru) ---
    function capturePhoto() {
        // Update info panel
        const ts = getFormattedTimestamp();
        geoInfo.datetime.textContent = ts.modalFull;
        geoInfo.lat.textContent = currentGeo.latitude;
        geoInfo.lon.textContent = currentGeo.longitude;
        geoInfo.location.textContent = currentGeo.locationName;

        // Set canvas ke ukuran output tetap
        canvas.width = OUTPUT_WIDTH;
        canvas.height = OUTPUT_HEIGHT;

        // 1. Gambar background hitam
        context.fillStyle = 'black';
        context.fillRect(0, 0, canvas.width, canvas.height);

        // 2. Gambar video (di-letterbox)
        drawLetterboxedImage(context, video);

        // 3. Gambar watermark di atas
        drawWatermark(context, canvas);

        // Tampilkan hasil
        const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
        capturedImg.src = dataUrl;

        videoSection.classList.add('hidden'); capturedImage.classList.remove('hidden');
        captureControls.classList.add('hidden'); retakeControls.classList.remove('hidden');
        stopCamera();
    }

    function retakePhoto() {
        videoSection.classList.remove('hidden'); capturedImage.classList.add('hidden');
        captureControls.classList.remove('hidden'); retakeControls.classList.add('hidden');
        startCamera(currentFacingMode);
    }

    function usePhoto() {
        const dataUrl = capturedImg.src;
        const fieldName = currentUploadSection.dataset.fieldName;
        const timestamp = getFormattedTimestamp();
        const imageData = {
            data: dataUrl, category: fieldName, timestamp: timestamp.iso,
            latitude: currentGeo.latitude, longitude: currentGeo.longitude, locationName: currentGeo.locationName
        };
        createHiddenImageInput(imageData, fieldName);
        createPreview(currentUploadSection, dataUrl, fieldName);
        closeModal();
    }

    // --- Logika Upload File Lokal ---
    function createFileInput(section) {
        fileInputContainer.innerHTML = '';
        const fileInput = document.createElement('input');
        fileInput.type = 'file'; fileInput.accept = 'image/*'; fileInput.className = 'hidden-file-input';
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) { handleLocalFile(e.target.files[0], section); }
        });
        fileInputContainer.appendChild(fileInput);
        return fileInput;
    }

    function handleLocalFile(file, section) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const dataUrl = e.target.result;
            addWatermarkToDataUrl(dataUrl, (watermarkedDataUrl) => {
                const fieldName = section.dataset.fieldName;
                const timestamp = getFormattedTimestamp();
                const imageData = {
                    data: watermarkedDataUrl, category: fieldName, timestamp: timestamp.iso,
                    latitude: currentGeo.latitude, longitude: currentGeo.longitude, locationName: currentGeo.locationName
                };
                createHiddenImageInput(imageData, fieldName);
                createPreview(section, watermarkedDataUrl, fieldName);
            });
        };
        reader.readAsDataURL(file);
    }

    // --- [PERUBAHAN] addWatermarkToDataUrl (Menggunakan Logic Baru) ---
    function addWatermarkToDataUrl(dataUrl, callback) {
        const img = new Image();
        img.onload = () => {
            // Set canvas ke ukuran output tetap
            canvas.width = OUTPUT_WIDTH;
            canvas.height = OUTPUT_HEIGHT;

            // 1. Gambar background hitam
            context.fillStyle = 'black';
            context.fillRect(0, 0, canvas.width, canvas.height);

            // 2. Gambar file (di-letterbox)
            drawLetterboxedImage(context, img);

            const watermarkedDataUrl = canvas.toDataURL('image/jpeg', 0.85);
            callback(watermarkedDataUrl);
        };
        img.src = dataUrl;
    }

    // --- Logika DOM (Preview & Input Tersembunyi) ---
    function createHiddenImageInput(imageData, fieldName) {
        const oldInput = document.getElementById('image-input-' + fieldName);
        if (oldInput) { oldInput.remove(); }
        const input = document.createElement('input');
        input.type = 'hidden'; input.name = 'images[]';
        input.value = JSON.stringify(imageData);
        input.id = 'image-input-' + fieldName;
        imageDataContainer.appendChild(input);
    }

    function createPreview(section, dataUrl, fieldName) {
        const previewContainer = section.querySelector('.preview-container');
        previewContainer.innerHTML = '';
        const wrapper = document.createElement('div');
        wrapper.className = 'relative group w-full h-24';
        wrapper.dataset.category = fieldName;
        const img = document.createElement('img');
        img.src = dataUrl; img.className = 'w-full h-full object-cover rounded border';
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button'; deleteBtn.innerHTML = '×';
        deleteBtn.className = 'delete-preview-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition';
        deleteBtn.onclick = () => {
            wrapper.remove();
            const hiddenInput = document.getElementById('image-input-' + fieldName);
            if (hiddenInput) { hiddenInput.remove(); }
        };
        wrapper.appendChild(img);
        wrapper.appendChild(deleteBtn);
        previewContainer.appendChild(wrapper);
    }

    // --- Inisialisasi Event Listeners ---

    // [PERBAIKAN] Mencari class yang benar (dari Genset)
    document.querySelectorAll('.camera-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            currentUploadSection = e.target.closest('.image-upload-section');
            showModal();
        });
    });

    // [PERBAIKAN] Mencari class yang benar (dari Genset)
    document.querySelectorAll('.upload-local-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            currentUploadSection = e.target.closest('.image-upload-section');
            const fileInput = createFileInput(currentUploadSection);
            fileInput.click();
        });
    });

    // Sisa event listener (modal controls)
    closeModalBtn.addEventListener('click', closeModal);
    captureBtn.addEventListener('click', capturePhoto);
    switchCameraBtn.addEventListener('click', switchCamera);
    retakeBtn.addEventListener('click', retakePhoto);
    usePhotoBtn.addEventListener('click', usePhoto);
    cameraModal.addEventListener('click', (e) => {
        if (e.target === cameraModal) { closeModal(); }
    });

    // Fungsi untuk tombol delete di halaman edit
    function initializeExistingDeleteButtons() {
        document.querySelectorAll('.delete-existing-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const previewWrapper = e.target.closest('.existing-image');
                const imagePath = previewWrapper.dataset.path;
                const deleteImageContainer = document.getElementById('delete-image-container');

                if (imagePath && deleteImageContainer) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'delete_images[]';
                    hiddenInput.value = imagePath;
                    deleteImageContainer.appendChild(hiddenInput);
                    previewWrapper.remove();
                }
            });
        });
    }
    initializeExistingDeleteButtons();
});

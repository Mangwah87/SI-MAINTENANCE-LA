// Photo Manager Component untuk PM Shelter - FIXED VERSION
//test123456
class PhotoManager {
    constructor(containerId, fieldName, existingPhotos = []) {
        this.container = document.getElementById(containerId);
        this.fieldName = fieldName;
        this.photos = [];
        this.removedPhotos = [];
        this.stream = null;
        this.currentFacingMode = "environment";
        this.currentMetadata = null;
        this.init();

        if (existingPhotos && existingPhotos.length > 0) {
            this.loadExistingPhotos(existingPhotos);
        }
    }

    init() {
        this.container.innerHTML = `
            <div class="photo-upload-section">
                <div class="flex flex-wrap gap-2 mb-3">
                    <button type="button" onclick="photoManagers['${this.fieldName}'].openCamera()"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm flex items-center gap-1">
                        <i data-lucide="camera" class="w-4 h-4"></i> Ambil Foto
                    </button>
                    <label class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm cursor-pointer flex items-center gap-1">
                        <i data-lucide="upload" class="w-4 h-4"></i> Upload Foto
                        <input type="file" accept="image/*" multiple class="hidden" onchange="photoManagers['${this.fieldName}'].handleFileUpload(event)">
                    </label>
                </div>

                <div id="${this.fieldName}_preview" class="grid grid-cols-2 sm:grid-cols-3 gap-3"></div>

                <!-- Camera Modal -->
                <div id="${this.fieldName}_camera_modal"
                     class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 overflow-y-auto">
                    <div class="min-h-screen flex flex-col p-4 pb-safe">
                        <!-- Header - Fixed at top -->
                        <div class="flex justify-between items-center mb-3 flex-shrink-0">
                            <h3 class="text-lg font-semibold text-white">Ambil Foto</h3>
                            <button type="button" onclick="photoManagers['${this.fieldName}'].closeCamera()"
                                    class="text-white hover:text-gray-300 p-2">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <!-- Video/Captured Section - Scrollable -->
                        <div class="flex-1 flex items-center justify-center mb-3 min-h-0">
                            <div id="${this.fieldName}_video_section" class="relative w-full max-w-4xl">
                                <video id="${this.fieldName}_video"
                                       class="w-full h-auto max-h-[60vh] object-contain rounded-lg"
                                       autoplay playsinline></video>
                                <canvas id="${this.fieldName}_canvas" class="hidden"></canvas>
                            </div>

                            <div id="${this.fieldName}_captured_section" class="hidden relative w-full max-w-4xl">
                                <img id="${this.fieldName}_captured_img"
                                     class="w-full h-auto max-h-[60vh] object-contain rounded-lg"
                                     alt="Captured photo">
                            </div>
                        </div>

                        <!-- Location Info -->
                        <div class="mb-3 text-xs text-white bg-black bg-opacity-50 p-3 rounded flex-shrink-0"
                             id="${this.fieldName}_location_info">
                            <i data-lucide="loader" class="w-4 h-4 inline animate-spin"></i> Memuat informasi lokasi...
                        </div>

                        <!-- Controls - Always visible at bottom -->
                        <div class="flex-shrink-0 space-y-3">
                            <div id="${this.fieldName}_capture_controls" class="flex gap-2">
                                <button type="button" onclick="photoManagers['${this.fieldName}'].capturePhoto()"
                                        class="flex-1 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium">
                                    <i data-lucide="camera" class="w-5 h-5 inline mr-1"></i> Ambil Foto
                                </button>
                                <button type="button" onclick="photoManagers['${this.fieldName}'].switchCamera()"
                                        class="bg-gray-700 hover:bg-gray-600 active:bg-gray-800 text-white px-4 py-3 rounded-lg">
                                    <i data-lucide="repeat" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <div id="${this.fieldName}_retake_controls" class="hidden gap-2">
                                <button type="button" onclick="photoManagers['${this.fieldName}'].retakePhoto()"
                                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 active:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium">
                                    <i data-lucide="refresh-cw" class="w-5 h-5 inline mr-1"></i> Ulangi
                                </button>
                                <button type="button" onclick="photoManagers['${this.fieldName}'].usePhoto()"
                                        class="flex-1 bg-green-500 hover:bg-green-600 active:bg-green-700 text-white px-4 py-3 rounded-lg font-medium">
                                    <i data-lucide="check" class="w-5 h-5 inline mr-1"></i> Gunakan Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        lucide.createIcons();
        this.renderPhotos();
    }

    loadExistingPhotos(existingPhotos) {
        existingPhotos.forEach((photo, index) => {
            const photoId = "existing_" + index;
            this.photos.push({
                id: photoId,
                isExisting: true,
                path: photo.path,
                metadata: {
                    latitude: photo.latitude,
                    longitude: photo.longitude,
                    location_name: photo.location_name,
                    taken_at: photo.taken_at,
                },
                preview: `/storage/${photo.path}`,
            });
        });
        this.renderPhotos();
    }

    async openCamera() {
        const modal = document.getElementById(`${this.fieldName}_camera_modal`);
        const video = document.getElementById(`${this.fieldName}_video`);
        const locationInfo = document.getElementById(
            `${this.fieldName}_location_info`
        );
        const videoSection = document.getElementById(
            `${this.fieldName}_video_section`
        );
        const capturedSection = document.getElementById(
            `${this.fieldName}_captured_section`
        );
        const captureControls = document.getElementById(
            `${this.fieldName}_capture_controls`
        );
        const retakeControls = document.getElementById(
            `${this.fieldName}_retake_controls`
        );

        videoSection.classList.remove("hidden");
        capturedSection.classList.add("hidden");
        captureControls.classList.remove("hidden");
        retakeControls.classList.add("hidden");
        retakeControls.style.display = "none";

        modal.classList.remove("hidden");
        this.currentFacingMode = "environment";

        try {
            await this.startCamera();
            await this.getLocation(locationInfo);
        } catch (err) {
            alert("Tidak dapat mengakses kamera: " + err.message);
            this.closeCamera();
        }
    }

    async startCamera() {
        const video = document.getElementById(`${this.fieldName}_video`);

        if (this.stream) {
            this.stream.getTracks().forEach((track) => track.stop());
        }

        this.stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: this.currentFacingMode,
                width: { ideal: 1920 },
                height: { ideal: 1080 },
            },
            audio: false,
        });
        video.srcObject = this.stream;
        await video.play();
    }

    async switchCamera() {
        this.currentFacingMode =
            this.currentFacingMode === "environment" ? "user" : "environment";
        await this.startCamera();
    }

    closeCamera() {
        const modal = document.getElementById(`${this.fieldName}_camera_modal`);
        const video = document.getElementById(`${this.fieldName}_video`);

        if (this.stream) {
            this.stream.getTracks().forEach((track) => track.stop());
        }
        video.srcObject = null;
        modal.classList.add("hidden");
    }

    async getLocation(infoElement) {
        if (!navigator.geolocation) {
            infoElement.innerHTML =
                '<i data-lucide="alert-circle" class="w-4 h-4 inline"></i> Geolokasi tidak didukung';
            lucide.createIcons();
            return null;
        }

        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    const accuracy = Math.round(position.coords.accuracy);

                    console.log("📍 Geolocation Info:");
                    console.log("  Latitude:", lat.toFixed(6));
                    console.log("  Longitude:", lon.toFixed(6));
                    console.log("  Accuracy:", accuracy, "meters");

                    //  FIX: Coba API alternatif yang lebih reliable
                    let locationName = null;

                    try {
                        // Coba Nominatim (OpenStreetMap) - lebih reliable
                        const nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`;

                        const controller = new AbortController();
                        const timeoutId = setTimeout(
                            () => controller.abort(),
                            8000
                        );

                        const response = await fetch(nominatimUrl, {
                            signal: controller.signal,
                            headers: {
                                Accept: "application/json",
                                "User-Agent": "PM-Shelter-App/1.0", // Required by Nominatim
                            },
                        });

                        clearTimeout(timeoutId);

                        if (response.ok) {
                            const data = await response.json();
                            let locationParts = [];

                            if (data.address) {
                                const addr = data.address;
                                // Prioritas: Jalan > Desa/Kelurahan > Kecamatan > Kota
                                if (addr.road) locationParts.push(addr.road);
                                if (
                                    addr.village ||
                                    addr.suburb ||
                                    addr.neighbourhood ||
                                    addr.hamlet
                                ) {
                                    locationParts.push(
                                        addr.village ||
                                            addr.suburb ||
                                            addr.neighbourhood ||
                                            addr.hamlet
                                    );
                                }
                                if (
                                    addr.municipality ||
                                    addr.city_district ||
                                    addr.county
                                ) {
                                    locationParts.push(
                                        addr.municipality ||
                                            addr.city_district ||
                                            addr.county
                                    );
                                }
                                if (addr.city || addr.town) {
                                    locationParts.push(addr.city || addr.town);
                                }
                            }

                            locationName =
                                locationParts.length > 0
                                    ? locationParts.join(", ")
                                    : data.display_name
                                    ? data.display_name
                                          .split(",")
                                          .slice(0, 3)
                                          .join(",")
                                    : null;
                        }
                    } catch (err) {
                        console.log(
                            "⚠ Nominatim gagal, mencoba geocode.maps.co..."
                        );

                        // Fallback ke geocode.maps.co
                        try {
                            const controller2 = new AbortController();
                            const timeoutId2 = setTimeout(
                                () => controller2.abort(),
                                8000
                            );

                            const url2 = `https://geocode.maps.co/reverse?lat=${lat}&lon=${lon}&format=json`;
                            const response2 = await fetch(url2, {
                                signal: controller2.signal,
                                headers: { Accept: "application/json" },
                            });

                            clearTimeout(timeoutId2);

                            if (response2.ok) {
                                const data2 = await response2.json();
                                let locationParts = [];

                                if (data2.address) {
                                    const addr = data2.address;
                                    if (addr.road)
                                        locationParts.push(addr.road);
                                    if (
                                        addr.village ||
                                        addr.suburb ||
                                        addr.neighbourhood
                                    ) {
                                        locationParts.push(
                                            addr.village ||
                                                addr.suburb ||
                                                addr.neighbourhood
                                        );
                                    }
                                    if (addr.city || addr.town) {
                                        locationParts.push(
                                            addr.city || addr.town
                                        );
                                    }
                                }

                                locationName =
                                    locationParts.length > 0
                                        ? locationParts.join(", ")
                                        : data2.display_name
                                        ? data2.display_name
                                              .split(",")
                                              .slice(0, 3)
                                              .join(",")
                                        : null;
                            }
                        } catch (err2) {
                            console.log(
                                "⚠ Semua API gagal, menggunakan koordinat"
                            );
                        }
                    }

                    const metadata = {
                        latitude: lat,
                        longitude: lon,
                        location_name: locationName, // Bisa null jika gagal
                        taken_at: new Date().toISOString(),
                    };

                    // 🔥 FIX: Tampilkan UI yang lebih jelas
                    if (locationName) {
                        infoElement.innerHTML = `
                            <div class="space-y-1">
                                <div class="font-semibold text-green-400">
                                    <i data-lucide="map-pin" class="w-4 h-4 inline"></i> ${locationName}
                                </div>
                                <div class="text-gray-300">
                                    <i data-lucide="navigation" class="w-4 h-4 inline"></i> ${lat.toFixed(
                                        6
                                    )}, ${lon.toFixed(6)}
                                </div>
                                <div class="text-gray-300">
                                    <i data-lucide="clock" class="w-4 h-4 inline"></i> ${new Date().toLocaleString(
                                        "id-ID",
                                        {
                                            timeZone: "Asia/Makassar",
                                            day: "2-digit",
                                            month: "2-digit",
                                            year: "numeric",
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            second: "2-digit",
                                        }
                                    )} WITA
                                </div>
                            </div>
                        `;
                    } else {
                        // Jika gagal dapat nama lokasi
                        infoElement.innerHTML = `
                            <div class="space-y-1">
                                <div class="text-yellow-400">
                                    <i data-lucide="alert-circle" class="w-4 h-4 inline"></i> Nama lokasi tidak tersedia
                                </div>
                                <div class="text-gray-300">
                                    <i data-lucide="navigation" class="w-4 h-4 inline"></i> ${lat.toFixed(
                                        6
                                    )}, ${lon.toFixed(6)}
                                </div>
                                <div class="text-gray-300">
                                    <i data-lucide="clock" class="w-4 h-4 inline"></i> ${new Date().toLocaleString(
                                        "id-ID",
                                        {
                                            timeZone: "Asia/Makassar",
                                            day: "2-digit",
                                            month: "2-digit",
                                            year: "numeric",
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            second: "2-digit",
                                        }
                                    )} WITA
                                </div>
                            </div>
                        `;
                    }

                    lucide.createIcons();
                    this.currentMetadata = metadata;
                    resolve(metadata);
                },
                (error) => {
                    const metadata = { taken_at: new Date().toISOString() };
                    infoElement.innerHTML = `
                        <div class="text-red-400">
                            <i data-lucide="alert-circle" class="w-4 h-4 inline"></i> Tidak dapat mengakses lokasi
                        </div>
                        <div class="text-gray-300">
                            <i data-lucide="clock" class="w-4 h-4 inline"></i> ${new Date().toLocaleString(
                                "id-ID",
                                {
                                    timeZone: "Asia/Makassar",
                                    day: "2-digit",
                                    month: "2-digit",
                                    year: "numeric",
                                    hour: "2-digit",
                                    minute: "2-digit",
                                    second: "2-digit",
                                }
                            )} WITA
                        </div>
                    `;
                    lucide.createIcons();
                    this.currentMetadata = metadata;
                    resolve(metadata);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0,
                }
            );
        });
    }

    capturePhoto() {
        const video = document.getElementById(`${this.fieldName}_video`);
        const canvas = document.getElementById(`${this.fieldName}_canvas`);
        const capturedImg = document.getElementById(
            `${this.fieldName}_captured_img`
        );
        const videoSection = document.getElementById(
            `${this.fieldName}_video_section`
        );
        const capturedSection = document.getElementById(
            `${this.fieldName}_captured_section`
        );
        const captureControls = document.getElementById(
            `${this.fieldName}_capture_controls`
        );
        const retakeControls = document.getElementById(
            `${this.fieldName}_retake_controls`
        );

        const context = canvas.getContext("2d");

        if (!video.videoWidth || !video.videoHeight) {
            alert("Video belum siap. Tunggu sebentar...");
            return;
        }

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        this.addWatermarkToCanvas(context, canvas.width, canvas.height);

        const imageData = canvas.toDataURL("image/jpeg", 0.92);
        capturedImg.src = imageData;

        videoSection.classList.add("hidden");
        capturedSection.classList.remove("hidden");
        captureControls.classList.add("hidden");
        retakeControls.classList.remove("hidden");
        retakeControls.style.display = "flex";

        if (this.stream) {
            this.stream.getTracks().forEach((track) => track.stop());
        }
    }

    addWatermarkToCanvas(ctx, width, height) {
        if (!this.currentMetadata) return;

        const { latitude, longitude, location_name, taken_at } =
            this.currentMetadata;

        // Konversi waktu ke WITA (UTC+8)
        const date = new Date(taken_at);
        const utcTime = date.getTime() + date.getTimezoneOffset() * 60000;
        const witaDate = new Date(utcTime + 8 * 3600000);

        const day = String(witaDate.getDate()).padStart(2, "0");
        const year = witaDate.getFullYear();
        const hours = String(witaDate.getHours()).padStart(2, "0");
        const minutes = String(witaDate.getMinutes()).padStart(2, "0");

        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        const days = [
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat",
            "Sabtu",
        ];

        const monthName = months[witaDate.getMonth()];
        const dayName = days[witaDate.getDay()];
        const formattedDate = `${dayName}, ${day} ${monthName} ${year}`;

        // Posisi & padding
        const padding = 40;
        const baseY = height - 260;
        const startX = padding;

        // Warna & outline
        ctx.textBaseline = "top";
        ctx.strokeStyle = "#000000";
        ctx.fillStyle = "#FFFFFF";
        ctx.lineJoin = "round";

        const dateFontSize = Math.floor(width / 32);
        ctx.font = `bold ${dateFontSize}px Arial, sans-serif`;
        ctx.lineWidth = 6;
        ctx.strokeText(formattedDate, startX, baseY);
        ctx.fillText(formattedDate, startX, baseY);

        const timeFontSize = Math.floor(width / 13);
        const timeText = `${hours}:${minutes}`;
        const timeY = baseY + dateFontSize + 12;

        ctx.font = `bold ${timeFontSize}px Arial, sans-serif`;
        ctx.lineWidth = 10;
        ctx.strokeText(timeText, startX, timeY);
        ctx.fillText(timeText, startX, timeY);

        // Label WITA di samping jam
        const timeWidth = ctx.measureText(timeText).width;
        const witaFontSize = Math.floor(width / 18);
        ctx.font = `bold ${witaFontSize}px Arial, sans-serif`;
        const witaX = startX + timeWidth + 15;
        const witaY = timeY + (timeFontSize - witaFontSize) / 2;

        ctx.lineWidth = 5;
        ctx.strokeText("WITA", witaX, witaY);
        ctx.fillText("WITA", witaX, witaY);
        
        let currentY = timeY + timeFontSize + 25;
        const coordFontSize = Math.floor(width / 38);
        ctx.font = `bold ${coordFontSize}px Arial, sans-serif`;
        ctx.lineWidth = 4;

        if (latitude && longitude) {
            const lat = latitude.toFixed(6);
            const lon = longitude.toFixed(6);
            const coordText = `${lat}, ${lon}`;
            ctx.strokeText(coordText, startX, currentY);
            ctx.fillText(coordText, startX, currentY);
            currentY += coordFontSize + 10;
        }

        if (location_name) {
            ctx.strokeText(location_name, startX, currentY);
            ctx.fillText(location_name, startX, currentY);
        }
    }

    async retakePhoto() {
        const videoSection = document.getElementById(
            `${this.fieldName}_video_section`
        );
        const capturedSection = document.getElementById(
            `${this.fieldName}_captured_section`
        );
        const captureControls = document.getElementById(
            `${this.fieldName}_capture_controls`
        );
        const retakeControls = document.getElementById(
            `${this.fieldName}_retake_controls`
        );

        capturedSection.classList.add("hidden");
        videoSection.classList.remove("hidden");
        retakeControls.classList.add("hidden");
        retakeControls.style.display = "none";
        captureControls.classList.remove("hidden");

        await this.startCamera();
    }

    usePhoto() {
        const capturedImg = document.getElementById(
            `${this.fieldName}_captured_img`
        );
        const imageData = capturedImg.src;

        const file = this.dataURLtoFile(imageData, `camera_${Date.now()}.jpg`);
        this.addPhoto(
            file,
            this.currentMetadata || { taken_at: new Date().toISOString() }
        );
        this.closeCamera();
    }

    dataURLtoFile(dataurl, filename) {
        const arr = dataurl.split(",");
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, { type: mime });
    }

    handleFileUpload(event) {
        const files = Array.from(event.target.files);
        files.forEach((file) => {
            this.addPhoto(file, { taken_at: new Date().toISOString() });
        });
        event.target.value = "";
    }

    addPhoto(file, metadata) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const photoId = "new_" + Date.now() + "_" + Math.random();
            this.photos.push({
                id: photoId,
                file,
                metadata,
                preview: e.target.result,
                isExisting: false,
            });
            this.renderPhotos();

            // Trigger auto-save if function exists
            if (typeof triggerAutoSave === 'function') {
                triggerAutoSave();
            }
        };
        reader.readAsDataURL(file);
    }

    removePhoto(photoId) {
        const photo = this.photos.find((p) => p.id === photoId);
        if (photo && photo.isExisting) {
            this.removedPhotos.push(photo.path);
        }
        this.photos = this.photos.filter((p) => p.id !== photoId);
        this.renderPhotos();

        // Trigger auto-save if function exists
        if (typeof triggerAutoSave === 'function') {
            triggerAutoSave();
        }
    }

    renderPhotos() {
        const preview = document.getElementById(`${this.fieldName}_preview`);
        if (this.photos.length === 0) {
            preview.innerHTML =
                '<p class="col-span-full text-sm text-gray-500 text-center py-4">Belum ada foto</p>';
            this.updateFormData();
            return;
        }

        preview.innerHTML = this.photos
            .map((photo) => {
                const takenAt = photo.metadata.taken_at
                    ? new Date(photo.metadata.taken_at).toLocaleString(
                          "id-ID",
                          {
                              timeZone: "Asia/Makassar",
                              day: "2-digit",
                              month: "2-digit",
                              year: "numeric",
                              hour: "2-digit",
                              minute: "2-digit",
                              second: "2-digit",
                          }
                      )
                    : "";
                return `
                <div class="relative border rounded-lg overflow-hidden bg-gray-50 group">
                    <img src="${
                        photo.preview
                    }" class="w-full h-32 object-cover cursor-pointer"
                         onclick="photoManagers['${
                             this.fieldName
                         }'].viewPhoto('${photo.id}')">
                    <button type="button" onclick="photoManagers['${
                        this.fieldName
                    }'].removePhoto('${photo.id}')"
                            class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                    ${
                        photo.metadata.location_name ||
                        photo.metadata.latitude ||
                        takenAt
                            ? `
                        <div class="absolute bottom-0 left-0 right-0 p-2 text-xs bg-gradient-to-t from-black/80 to-transparent text-white">
                            ${
                                photo.metadata.location_name
                                    ? `<div class="truncate font-medium mb-1" title="${photo.metadata.location_name}">
                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-red-400"></i> ${photo.metadata.location_name}
                                   </div>`
                                    : ""
                            }
                            ${
                                photo.metadata.latitude &&
                                !photo.metadata.location_name
                                    ? `<div class="truncate text-gray-200 text-[10px]">
                                    <i data-lucide="navigation" class="w-3 h-3 inline"></i> ${photo.metadata.latitude.toFixed(
                                        6
                                    )}, ${photo.metadata.longitude.toFixed(6)}
                                   </div>`
                                    : ""
                            }

                        </div>`
                            : ""
                    }
                </div>`;
            })
            .join("");

        lucide.createIcons();
        this.updateFormData();
    }

    viewPhoto(photoId) {
        const photo = this.photos.find((p) => p.id === photoId);
        if (!photo) return;

        const modal = document.createElement("div");
        modal.className =
            "fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4";
        modal.onclick = () => modal.remove();

        const takenAt = photo.metadata.taken_at
            ? new Date(photo.metadata.taken_at).toLocaleString("id-ID", {
                  timeZone: "Asia/Makassar",
                  day: "2-digit",
                  month: "2-digit",
                  year: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
                  second: "2-digit",
              })
            : "";

        modal.innerHTML = `
            <div class="max-w-4xl w-full">
                <img src="${photo.preview}" class="w-full h-auto rounded">
                ${
                    photo.metadata.location_name ||
                    photo.metadata.latitude ||
                    takenAt
                        ? `
                    <div class="mt-4 bg-white rounded p-4 text-sm">
                        ${
                            photo.metadata.location_name
                                ? `<div class="mb-2"><i data-lucide="map-pin" class="w-4 h-4 inline text-red-500"></i> <strong>Lokasi:</strong> ${photo.metadata.location_name}</div>`
                                : ""
                        }
                        ${
                            photo.metadata.latitude
                                ? `<div class="mb-2"><i data-lucide="navigation" class="w-4 h-4 inline"></i> <strong>Koordinat:</strong> ${photo.metadata.latitude.toFixed(
                                      6
                                  )}, ${photo.metadata.longitude.toFixed(
                                      6
                                  )}</div>`
                                : ""
                        }
                        ${
                            takenAt
                                ? `<div><i data-lucide="clock" class="w-4 h-4 inline"></i> <strong>Waktu:</strong> ${takenAt} WITA</div>`
                                : ""
                        }
                    </div>`
                        : ""
                }
            </div>
        `;

        document.body.appendChild(modal);
        lucide.createIcons();
    }

    updateFormData() {
        const form = document.getElementById("pmForm");
        if (!form) return;

        // Hapus input lama
        form.querySelectorAll(`input[name="${this.fieldName}[]"]`).forEach(
            (el) => el.remove()
        );
        form.querySelectorAll(
            `input[name="${this.fieldName.replace(
                "_photos",
                "_photo_metadata"
            )}[]"]`
        ).forEach((el) => el.remove());
        form.querySelectorAll(
            `input[name="removed_${this.fieldName}[]"]`
        ).forEach((el) => el.remove());

        // Tambah input untuk foto baru
        this.photos.forEach((photo) => {
            if (!photo.isExisting && photo.file) {
                const fileInput = document.createElement("input");
                fileInput.type = "file";
                fileInput.name = `${this.fieldName}[]`;
                fileInput.className = "hidden";

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(photo.file);
                fileInput.files = dataTransfer.files;
                form.appendChild(fileInput);

                const metaInput = document.createElement("input");
                metaInput.type = "hidden";
                metaInput.name = `${this.fieldName.replace(
                    "_photos",
                    "_photo_metadata"
                )}[]`;
                metaInput.value = JSON.stringify(photo.metadata);
                form.appendChild(metaInput);
            }
        });

        // Tambah input untuk removed photos
        this.removedPhotos.forEach((path) => {
            const removedInput = document.createElement("input");
            removedInput.type = "hidden";
            removedInput.name = `removed_${this.fieldName}[]`;
            removedInput.value = path;
            form.appendChild(removedInput);
        });
    }
}

// Global object untuk menyimpan semua photo managers
const photoManagers = {};

// ========== AUTO-SAVE FUNCTIONALITY FOR PM SHELTER ==========
let dbInstance = null;
const DB_NAME = 'PMShelterFormDB';
const STORE_NAME = 'formDrafts';
const STORAGE_KEY = 'pm_shelter_form_draft';
const AUTO_DELETE_MINUTES = 5;

// Encryption functions
function encryptData(data) {
    try {
        const str = JSON.stringify(data);
        return btoa(unescape(encodeURIComponent(str)));
    } catch (e) {
        console.error('Encryption error:', e);
        return null;
    }
}

function decryptData(encryptedData) {
    try {
        const str = decodeURIComponent(escape(atob(encryptedData)));
        return JSON.parse(str);
    } catch (e) {
        console.error('Decryption error:', e);
        return null;
    }
}

// Initialize IndexedDB
function initDB() {
    return new Promise((resolve, reject) => {
        if (dbInstance) {
            resolve(dbInstance);
            return;
        }

        const request = indexedDB.open(DB_NAME, 1);
        request.onerror = () => reject(request.error);
        request.onsuccess = () => {
            dbInstance = request.result;
            resolve(dbInstance);
        };

        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME)) {
                db.createObjectStore(STORE_NAME, { keyPath: 'id' });
            }
        };
    });
}

// Save to IndexedDB
async function saveToIndexedDB(data) {
    try {
        const db = await initDB();
        const encryptedData = encryptData(data);

        if (!encryptedData) {
            console.error('Failed to encrypt data');
            return;
        }

        const transaction = db.transaction([STORE_NAME], 'readwrite');
        const store = transaction.objectStore(STORE_NAME);

        store.put({
            id: STORAGE_KEY,
            data: encryptedData,
            timestamp: new Date().toISOString()
        });
    } catch (error) {
        console.error('Error saving to IndexedDB:', error);
    }
}

// Get from IndexedDB
async function getFromIndexedDB() {
    try {
        const db = await initDB();
        const transaction = db.transaction([STORE_NAME], 'readonly');
        const store = transaction.objectStore(STORE_NAME);

        return new Promise((resolve, reject) => {
            const request = store.get(STORAGE_KEY);

            request.onsuccess = () => {
                if (request.result && request.result.data) {
                    const decrypted = decryptData(request.result.data);
                    resolve(decrypted);
                } else {
                    resolve(null);
                }
            };

            request.onerror = () => reject(request.error);
        });
    } catch (error) {
        console.error('Error getting from IndexedDB:', error);
        return null;
    }
}

// Delete from IndexedDB
async function deleteFromIndexedDB() {
    try {
        const db = await initDB();
        const transaction = db.transaction([STORE_NAME], 'readwrite');
        const store = transaction.objectStore(STORE_NAME);
        store.delete(STORAGE_KEY);
    } catch (error) {
        console.error('Error deleting from IndexedDB:', error);
    }
}

// Save draft
async function saveDraft() {
    const form = document.getElementById('pmForm');
    if (!form) return;

    const formData = {};

    const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');
    inputs.forEach(input => {
        if (input.name && !input.name.startsWith('_') && !input.name.includes('photo')) {
            if (input.type === 'checkbox') {
                formData[input.name] = input.checked;
            } else if (input.type === 'radio') {
                if (input.checked) {
                    formData[input.name] = input.value;
                }
            } else {
                formData[input.name] = input.value;
            }
        }
    });

    const images = [];
    if (typeof photoManagers !== 'undefined') {
        for (const [fieldName, manager] of Object.entries(photoManagers)) {
            if (manager && manager.photos) {
                manager.photos.forEach(photo => {
                    images.push({
                        category: fieldName,
                        preview: photo.preview,
                        metadata: photo.metadata || {}
                    });
                });
            }
        }
    }

    const draftData = {
        formFields: formData,
        images: images,
        timestamp: new Date().toISOString()
    };

    await saveToIndexedDB(draftData);
    console.log('PM Shelter draft saved');
}

// Trigger auto-save
function triggerAutoSave() {
    saveDraft();
}

// Restore draft
async function restoreDraft() {
    const savedData = await getFromIndexedDB();
    if (!savedData || !savedData.formFields) return;

    const form = document.getElementById('pmForm');
    if (!form) return;

    for (const [name, value] of Object.entries(savedData.formFields)) {
        const input = form.querySelector(`[name="${name}"]`);
        if (input) {
            if (input.type === 'checkbox') {
                input.checked = value;
            } else if (input.type === 'radio') {
                const radio = form.querySelector(`[name="${name}"][value="${value}"]`);
                if (radio) radio.checked = true;
            } else {
                input.value = value;
            }
        }
    }

    if (savedData.images && savedData.images.length > 0) {
        savedData.images.forEach(img => {
            const manager = photoManagers[img.category];
            if (manager && img.preview) {
                const file = dataURLtoFile(img.preview, `restored_${Date.now()}.jpg`);
                manager.addPhoto(file, img.metadata || { taken_at: new Date().toISOString() });
            }
        });
    }

    console.log('PM Shelter draft restored');
}

// Show restore notification
function showRestoreNotification(onRestore, onDecline) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-2xl z-[9999] max-w-md';
    notification.innerHTML = `
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <p class="font-semibold mb-2">📦 Data draft ditemukan</p>
                <p class="text-sm mb-3 opacity-90">Ada data dan gambar yang belum tersimpan. Pulihkan?</p>
                <div class="flex gap-2">
                    <button id="restoreBtn" class="px-4 py-2 bg-white text-blue-600 rounded font-medium text-sm hover:bg-blue-50 transition">
                        Pulihkan
                    </button>
                    <button id="declineBtn" class="px-4 py-2 bg-blue-700 text-white rounded font-medium text-sm hover:bg-blue-800 transition">
                        Abaikan
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(notification);

    notification.querySelector('#restoreBtn').addEventListener('click', () => {
        notification.remove();
        onRestore();
    });

    notification.querySelector('#declineBtn').addEventListener('click', () => {
        notification.remove();
        onDecline();
    });
}

// Delete draft
async function deleteDraft() {
    await deleteFromIndexedDB();
    document.querySelectorAll('.fixed.top-4.right-4').forEach(n => n.remove());
    console.log('PM Shelter draft deleted');
}

// Helper function
function dataURLtoFile(dataurl, filename) {
    const arr = dataurl.split(',');
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: mime });
}

// Initialize auto-save
async function initAutoSave() {
    const form = document.getElementById('pmForm');
    if (!form) return;

    // Check if we're in edit mode
    const isEditMode = form.action.includes('/update/') || form.querySelector('input[name="_method"]');

    if (isEditMode) {
        console.log('Edit mode detected, auto-save disabled');
        return;
    }

    const savedData = await getFromIndexedDB();

    if (savedData && savedData.formFields) {
        const savedDate = new Date(savedData.timestamp);
        const minutesSince = (new Date() - savedDate) / (1000 * 60);

        // Auto-delete data older than 5 minutes
        if (minutesSince > AUTO_DELETE_MINUTES) {
            await deleteFromIndexedDB();
            console.log('Auto-Save: Data expired (>5 minutes), cleared');
        } else {
            // Show restore notification with Pulihkan/Abaikan buttons
            showRestoreNotification(async () => {
                // Restore without showing success notification
                await restoreDraft();
                console.log('✅ Auto-Save: Data + Images restored', {
                    fields: savedData.formFields ? Object.keys(savedData.formFields).length : 0,
                    images: savedData.images ? savedData.images.length : 0
                });
            }, async () => {
                await deleteFromIndexedDB();
                console.log('Auto-Save: User declined restore, data cleared');
            });
        }
    }

    let saveTimeout;
    const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => saveDraft(), 1000);
        });
    });

    // Set auto-delete timer
    if (savedData && savedData.timestamp) {
        const savedTime = new Date(savedData.timestamp);
        const now = new Date();
        const diffMinutes = (now - savedTime) / (1000 * 60);

        if (diffMinutes < AUTO_DELETE_MINUTES) {
            const remainingMs = (AUTO_DELETE_MINUTES * 60 * 1000) - (now - savedTime);
            setTimeout(async () => {
                await deleteFromIndexedDB();
                console.log('Draft auto-deleted after ' + AUTO_DELETE_MINUTES + ' minutes');
            }, remainingMs);
        }
    }

    // Clear draft on successful submit
    form.addEventListener('submit', async (e) => {
        setTimeout(async () => {
            await deleteFromIndexedDB();
            console.log('Draft cleared after successful submit');
        }, 100);
    });
}
// ========== END AUTO-SAVE ==========

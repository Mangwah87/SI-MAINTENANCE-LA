// Photo Manager Component untuk PM Shelter
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

        // Load existing photos jika ada (untuk edit mode)
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
                     class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4">
                    <div class="w-full h-full max-w-4xl flex flex-col">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-3 px-2">
                            <h3 class="text-lg font-semibold text-white">Ambil Foto</h3>
                            <button type="button" onclick="photoManagers['${this.fieldName}'].closeCamera()" 
                                    class="text-white hover:text-gray-300">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <!-- Video Section -->
                        <div id="${this.fieldName}_video_section" class="relative flex-1 flex items-center justify-center mb-3">
                            <video id="${this.fieldName}_video" 
                                   class="w-full h-full object-contain rounded-lg" 
                                   autoplay playsinline></video>
                            <canvas id="${this.fieldName}_canvas" class="hidden"></canvas>
                        </div>

                        <!-- Captured Image Section (Hidden by default) -->
                        <div id="${this.fieldName}_captured_section" class="hidden relative flex-1 flex items-center justify-center mb-3">
                            <img id="${this.fieldName}_captured_img" 
                                 class="w-full h-full object-contain rounded-lg" 
                                 alt="Captured photo">
                        </div>

                        <!-- Location Info -->
                        <div class="mb-3 text-xs text-white bg-black bg-opacity-50 p-3 rounded" id="${this.fieldName}_location_info">
                            <i data-lucide="loader" class="w-4 h-4 inline animate-spin"></i> Memuat informasi lokasi...
                        </div>

                        <!-- Capture Controls -->
                        <div id="${this.fieldName}_capture_controls" class="flex gap-2">
                            <button type="button" onclick="photoManagers['${this.fieldName}'].capturePhoto()" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-medium">
                                <i data-lucide="camera" class="w-5 h-5 inline mr-1"></i> Ambil Foto
                            </button>
                            <button type="button" onclick="photoManagers['${this.fieldName}'].switchCamera()" 
                                    class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg">
                                <i data-lucide="repeat" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <!-- Retake Controls (Hidden by default) -->
                        <div id="${this.fieldName}_retake_controls" class="hidden flex gap-2">
                            <button type="button" onclick="photoManagers['${this.fieldName}'].retakePhoto()" 
                                    class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg font-medium">
                                <i data-lucide="refresh-cw" class="w-5 h-5 inline mr-1"></i> Ulangi
                            </button>
                            <button type="button" onclick="photoManagers['${this.fieldName}'].usePhoto()" 
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-medium">
                                <i data-lucide="check" class="w-5 h-5 inline mr-1"></i> Gunakan Foto
                            </button>
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

        // Reset UI state
        videoSection.classList.remove("hidden");
        capturedSection.classList.add("hidden");
        captureControls.classList.remove("hidden");
        retakeControls.classList.add("hidden");

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
                    console.log(
                        "  Source:",
                        accuracy < 100
                            ? "✓ GPS (Akurat)"
                            : "⚠ WiFi/IP (Kurang akurat)"
                    );

                    try {
                        const controller = new AbortController();
                        const timeoutId = setTimeout(
                            () => controller.abort(),
                            10000
                        );

                        const url = `https://geocode.maps.co/reverse?lat=${lat}&lon=${lon}&format=json`;

                        const response = await fetch(url, {
                            signal: controller.signal,
                            headers: { Accept: "application/json" },
                        });

                        clearTimeout(timeoutId);

                        if (!response.ok)
                            throw new Error("API returned non-200 status");

                        const data = await response.json();
                        let locationParts = [];

                        if (data.address) {
                            const addr = data.address;
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

                        const locationName =
                            locationParts.length > 0
                                ? locationParts.join(", ")
                                : data.display_name ||
                                  `${lat.toFixed(6)}, ${lon.toFixed(6)}`;

                        const metadata = {
                            latitude: lat,
                            longitude: lon,
                            location_name: locationName,
                            taken_at: new Date().toISOString(),
                        };

                        infoElement.innerHTML = `
                            <div class="space-y-1">
                                <div><i data-lucide="map-pin" class="w-4 h-4 inline"></i> <strong>Lokasi:</strong> ${locationName}</div>
                                <div><i data-lucide="navigation" class="w-4 h-4 inline"></i> <strong>Koordinat:</strong> ${lat.toFixed(
                                    6
                                )}, ${lon.toFixed(6)}</div>
                                <div><i data-lucide="clock" class="w-4 h-4 inline"></i> <strong>Waktu:</strong> ${new Date().toLocaleString(
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
                                )} WITA</div>
                            </div>
                        `;
                        lucide.createIcons();

                        this.currentMetadata = metadata;
                        resolve(metadata);
                    } catch (err) {
                        const metadata = {
                            latitude: lat,
                            longitude: lon,
                            location_name: `${lat.toFixed(6)}, ${lon.toFixed(
                                6
                            )}`,
                            taken_at: new Date().toISOString(),
                        };

                        infoElement.innerHTML = `
                            <div class="space-y-1">
                                <div><i data-lucide="navigation" class="w-4 h-4 inline"></i> <strong>Koordinat:</strong> ${lat.toFixed(
                                    6
                                )}, ${lon.toFixed(6)}</div>
                                <div><i data-lucide="clock" class="w-4 h-4 inline"></i> <strong>Waktu:</strong> ${new Date().toLocaleString(
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
                                )} WITA</div>
                            </div>
                        `;
                        lucide.createIcons();

                        this.currentMetadata = metadata;
                        resolve(metadata);
                    }
                },
                (error) => {
                    const metadata = { taken_at: new Date().toISOString() };
                    infoElement.innerHTML = `
                        <div><i data-lucide="alert-circle" class="w-4 h-4 inline"></i> Tidak dapat mengakses lokasi</div>
                        <div><i data-lucide="clock" class="w-4 h-4 inline"></i> <strong>Waktu:</strong> ${new Date().toLocaleString(
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
                        )} WITA</div>
                    `;
                    lucide.createIcons();
                    this.currentMetadata = metadata;
                    resolve(this.currentMetadata);
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

        // Mirror image for front camera
        context.save();
        context.scale(-1, 1);
        context.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
        context.restore();

        // Add watermark
        this.addWatermarkToCanvas(context, canvas.width, canvas.height);

        const imageData = canvas.toDataURL("image/jpeg", 0.92);
        capturedImg.src = imageData;

        // Switch UI
        videoSection.classList.add("hidden");
        capturedSection.classList.remove("hidden");
        captureControls.classList.add("hidden");
        retakeControls.classList.remove("hidden");

        // Stop camera stream
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

        // Koordinat dan lokasi
        const lat = latitude ? latitude.toFixed(6) : "-";
        const lon = longitude ? longitude.toFixed(6) : "-";
        const coordText = `${lat}, ${lon}`;
        const location = location_name || `${lat}, ${lon}`;

        // Posisi & padding
        const padding = 40;
        const baseY = height - 260; // 🔽 lebih turun dari sebelumnya
        const startX = padding;

        // Warna & outline
        ctx.textBaseline = "top";
        ctx.strokeStyle = "#000000";
        ctx.fillStyle = "#FFFFFF";
        ctx.lineJoin = "round";

        // 1️⃣ Hari dan tanggal
        const dateFontSize = Math.floor(width / 32);
        ctx.font = `bold ${dateFontSize}px Arial, sans-serif`;
        ctx.lineWidth = 6;
        ctx.strokeText(formattedDate, startX, baseY);
        ctx.fillText(formattedDate, startX, baseY);

        // 2️⃣ Waktu besar
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

        // 3️⃣ Koordinat
        const coordFontSize = Math.floor(width / 38);
        ctx.font = `bold ${coordFontSize}px Arial, sans-serif`;
        const coordY = timeY + timeFontSize + 25;
        ctx.lineWidth = 4;
        ctx.strokeText(coordText, startX, coordY);
        ctx.fillText(coordText, startX, coordY);

        // 4️⃣ Nama lokasi
        const locY = coordY + coordFontSize + 10;
        ctx.strokeText(location, startX, locY);
        ctx.fillText(location, startX, locY);
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
                                    photo.metadata.latitude
                                        ? `<div class="truncate text-gray-200 text-[10px]">
                                            <i data-lucide="navigation" class="w-3 h-3 inline"></i> ${photo.metadata.latitude.toFixed(
                                                6
                                            )}, ${photo.metadata.longitude.toFixed(
                                              6
                                          )}
                                           </div>`
                                        : ""
                                }
                                ${
                                    takenAt
                                        ? `<div class="truncate text-gray-200 text-[10px]">
                                            <i data-lucide="clock" class="w-3 h-3 inline"></i> ${takenAt}
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

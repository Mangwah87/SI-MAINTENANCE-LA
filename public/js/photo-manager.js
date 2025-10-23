// Photo Manager Component untuk PM Shelter
class PhotoManager {
    constructor(containerId, fieldName, existingPhotos = []) {
        this.container = document.getElementById(containerId);
        this.fieldName = fieldName;
        this.photos = [];
        this.removedPhotos = [];
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
                     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-auto">
                    <div class="bg-white rounded-lg max-w-2xl w-full p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold">Ambil Foto</h3>
                            <button type="button" onclick="photoManagers['${this.fieldName}'].closeCamera()" 
                                    class="text-gray-500 hover:text-gray-700">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <div class="relative">
                            <video id="${this.fieldName}_video" 
                                   class="w-full rounded object-contain max-h-[80vh]" 
                                   autoplay playsinline></video>
                            <canvas id="${this.fieldName}_canvas" class="hidden"></canvas>
                        </div>

                        <div class="mt-3 text-xs text-gray-600 bg-gray-50 p-3 rounded" id="${this.fieldName}_location_info">
                            <i data-lucide="loader" class="w-4 h-4 inline animate-spin"></i> Memuat informasi lokasi...
                        </div>

                        <div class="flex gap-2 mt-4">
                            <button type="button" onclick="photoManagers['${this.fieldName}'].capturePhoto()" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                <i data-lucide="camera" class="w-4 h-4 inline mr-1"></i> Ambil Foto
                            </button>
                            <button type="button" onclick="photoManagers['${this.fieldName}'].closeCamera()" 
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Batal
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

        modal.classList.remove("hidden");

        try {
            this.stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "environment" },
                audio: false,
            });
            video.srcObject = this.stream;

            // 🔧 Sesuaikan tinggi video berdasarkan ukuran layar
            const adjustVideoSize = () => {
                const vh = window.innerHeight * 0.8;
                video.style.maxHeight = `${vh}px`;
                video.style.objectFit = "contain";
            };
            adjustVideoSize();
            window.addEventListener("resize", adjustVideoSize);

            // Dapatkan lokasi
            await this.getLocation(locationInfo);
        } catch (err) {
            alert("Tidak dapat mengakses kamera: " + err.message);
            this.closeCamera();
        }
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

                    try {
                        // Reverse geocoding menggunakan Nominatim
                        const response = await fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`,
                            { headers: { "User-Agent": "PM-Shelter-App" } }
                        );
                        const data = await response.json();

                        const locationName =
                            data.display_name || `${lat}, ${lon}`;
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
                                    { timeZone: "Asia/Makassar" }
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
                                    { timeZone: "Asia/Makassar" }
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
                            { timeZone: "Asia/Makassar" }
                        )} WITA</div>
                    `;
                    lucide.createIcons();
                    this.currentMetadata = metadata;
                    resolve(this.currentMetadata);
                }
            );
        });
    }

    capturePhoto() {
        const video = document.getElementById(`${this.fieldName}_video`);
        const canvas = document.getElementById(`${this.fieldName}_canvas`);
        const context = canvas.getContext("2d");

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0);

        canvas.toBlob(
            (blob) => {
                const file = new File([blob], `camera_${Date.now()}.jpg`, {
                    type: "image/jpeg",
                });
                this.addPhoto(
                    file,
                    this.currentMetadata || {
                        taken_at: new Date().toISOString(),
                    }
                );
                this.closeCamera();
            },
            "image/jpeg",
            0.85
        );
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
                            <div class="p-2 text-xs bg-white">
                                ${
                                    photo.metadata.location_name
                                        ? `<div class="truncate font-medium" title="${photo.metadata.location_name}">
                                            <i data-lucide="map-pin" class="w-3 h-3 inline text-red-500"></i> ${photo.metadata.location_name}
                                           </div>`
                                        : ""
                                }
                                ${
                                    photo.metadata.latitude
                                        ? `<div class="text-gray-600 truncate">
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
                                        ? `<div class="text-gray-600 truncate">
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

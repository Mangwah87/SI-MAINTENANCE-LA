        // Dynamic field display based on power module selection
        document.addEventListener('DOMContentLoaded', function() {
            const powerModuleSelect = document.getElementById('power_module');

            function updateFieldsVisibility() {
                const selectedModule = powerModuleSelect.value;

                // Hide all dynamic fields
                document.getElementById('ac_single').style.display = 'none';
                document.getElementById('ac_dual').style.display = 'none';
                document.getElementById('ac_three').style.display = 'none';
                document.getElementById('dc_single').style.display = 'none';
                document.getElementById('dc_dual').style.display = 'none';
                document.getElementById('dc_three').style.display = 'none';

                // Show relevant fields
                if (selectedModule === 'Single') {
                    document.getElementById('ac_single').style.display = 'block';
                    document.getElementById('dc_single').style.display = 'block';
                } else if (selectedModule === 'Dual') {
                    document.getElementById('ac_dual').style.display = 'block';
                    document.getElementById('dc_dual').style.display = 'block';
                } else if (selectedModule === 'Three') {
                    document.getElementById('ac_three').style.display = 'block';
                    document.getElementById('dc_three').style.display = 'block';
                }
            }

            powerModuleSelect.addEventListener('change', updateFieldsVisibility);
            updateFieldsVisibility();
        });

        // FUNGSI VALIDASI GAMBAR - TAMBAHAN BARU
        function handleImageUpload(input) {
            const files = input.files;
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const allowedExtensions = ['jpg', 'jpeg', 'png'];
            let invalidFiles = [];
            let oversizedFiles = [];

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                // Check file type
                if (!allowedTypes.includes(file.type) || !allowedExtensions.includes(fileExtension)) {
                    invalidFiles.push(file.name);
                }

                // Check file size
                if (file.size > maxSize) {
                    oversizedFiles.push(file.name);
                }
            }

            // Show alerts if there are invalid files
            if (invalidFiles.length > 0) {
                alert('❌ Format file tidak valid!\n\nFile yang ditolak:\n' + invalidFiles.join('\n') + '\n\nHanya file JPG, JPEG, dan PNG yang diperbolehkan.');
                input.value = ''; // Clear the input
                return false;
            }

            if (oversizedFiles.length > 0) {
                alert('❌ Ukuran file terlalu besar!\n\nFile yang melebihi 5MB:\n' + oversizedFiles.join('\n') + '\n\nMaksimal ukuran file adalah 5MB.');
                input.value = ''; // Clear the input
                return false;
            }

            return true;
        }

        // Handle image deletion
        let deletedImages = [];

        function deleteImage(button, imagePath) {
            if (confirm('Are you sure you want to delete this image?')) {
                deletedImages.push(imagePath);
                document.getElementById('deleted_images').value = JSON.stringify(deletedImages);
                button.closest('[data-image-path]').remove();
            }
        }

        // Camera functionality - Fixed Version
        let cameraStreams = {};
        let cameraCounter = {
            visual_check: 0,
            performance: 0,
            backup: 0,
            alarm: 0,
            ac_voltage: 0,
            ac_current: 0,
            dc_current: 0,
            battery_temp: 0,
            charging_voltage: 0,
            charging_current: 0,
            rectifier_test: 0,
            battery_voltage: 0,
            // TAMBAHKAN KATEGORI BARU
            env_condition: 0,
            led_display: 0,
            battery_connection: 0,
            battery_voltage_m1: 0,
            battery_voltage_m2: 0
        };

        let cameraPhotos = {
            visual_check: [],
            performance: [],
            backup: [],
            alarm: [],
            ac_voltage: [],
            ac_current: [],
            dc_current: [],
            battery_temp: [],
            charging_voltage: [],
            charging_current: [],
            rectifier_test: [],
            battery_voltage: [],
            // TAMBAHKAN KATEGORI BARU
            env_condition: [],
            led_display: [],
            battery_connection: [],
            battery_voltage_m1: [],
            battery_voltage_m2: []
        };

        // Get address from coordinates using reverse geocoding
        async function getAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();

                if (data.address) {
                    const parts = [];
                    if (data.address.road) parts.push(data.address.road);
                    if (data.address.suburb) parts.push(data.address.suburb);
                    if (data.address.city || data.address.city_district) parts.push(data.address.city || data.address.city_district);
                    if (data.address.state) parts.push(data.address.state);

                    return parts.join(', ') || data.display_name;
                }
                return 'Alamat tidak ditemukan';
            } catch (error) {
                console.error('Error getting address:', error);
                return 'Gagal mendapatkan alamat';
            }
        }

        function addCameraSlot(category) {
            const index = cameraCounter[category]++;
            const containerId = `camera-container-${category.replace(/_/g, '-')}`;
            const container = document.getElementById(containerId);

            if (!container) {
                console.error(`Container not found: ${containerId}`);
                alert(`Error: Container ${containerId} tidak ditemukan`);
                return;
            }

            const cameraSlot = document.createElement('div');
            cameraSlot.className = 'border border-gray-300 rounded-lg p-3 bg-white';
            cameraSlot.id = `camera-slot-${category}-${index}`;
            cameraSlot.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <span class="font-medium text-sm">Foto ${index + 1}</span>
            <button type="button" onclick="removeCameraSlot('${category}', ${index})" class="text-red-600 hover:text-red-800 text-sm font-medium">
                ✕ Hapus Slot
            </button>
        </div>
        <div class="relative">
            <video id="video-${category}-${index}" class="w-full rounded border border-gray-300" autoplay playsinline style="display: none;"></video>
            <canvas id="canvas-${category}-${index}" class="hidden"></canvas>
            <img id="captured-${category}-${index}" class="w-full rounded border border-gray-300 hidden" />
        </div>
        <div class="mt-2 space-y-2">
            <button type="button" id="start-${category}-${index}" onclick="startCamera('${category}', ${index})"
                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                Buka Kamera
            </button>
            <button type="button" id="capture-${category}-${index}" onclick="capturePhoto('${category}', ${index})"
                class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm font-medium hidden">
                Ambil Foto
            </button>
            <div id="captured-controls-${category}-${index}" class="hidden space-y-2">
                <button type="button" id="retake-${category}-${index}" onclick="retakePhoto('${category}', ${index})"
                    class="w-full px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition text-sm font-medium">
                    Ambil Ulang
                </button>
                <button type="button" id="delete-captured-${category}-${index}" onclick="deleteCapturedPhoto('${category}', ${index})"
                    class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-sm font-medium">
                    Hapus Foto
                </button>
            </div>
        </div>
        <div id="info-${category}-${index}" class="mt-2 text-xs text-gray-600"></div>
    `;

            container.appendChild(cameraSlot);
        }

        async function startCamera(category, index) {
            const video = document.getElementById(`video-${category}-${index}`);
            const startBtn = document.getElementById(`start-${category}-${index}`);
            const captureBtn = document.getElementById(`capture-${category}-${index}`);
            const infoDiv = document.getElementById(`info-${category}-${index}`);

            // Check if elements exist
            if (!video || !startBtn || !captureBtn || !infoDiv) {
                console.error('Required elements not found');
                alert('Error: Elemen tidak ditemukan');
                return;
            }

            // Check if browser supports getUserMedia
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                infoDiv.innerHTML = '<p class="text-red-600">❌ Browser tidak mendukung akses kamera</p>';
                alert('Browser Anda tidak mendukung akses kamera. Gunakan browser modern seperti Chrome, Firefox, atau Safari.');
                return;
            }

            try {
                infoDiv.innerHTML = '<p class="text-blue-600">⏳ Membuka kamera...</p>';

                // Stop any existing stream first
                if (cameraStreams[`${category}-${index}`]) {
                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                }

                let stream;

                // Try different constraint combinations
                const constraints = [
                    // Try 1: Environment camera with ideal resolution
                    {
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            },
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        }
                    },
                    // Try 2: Any camera with ideal resolution
                    {
                        video: {
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        }
                    },
                    // Try 3: Lower resolution
                    {
                        video: {
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }
                    },
                    // Try 4: Basic video only
                    {
                        video: true
                    }
                ];

                let lastError;
                for (let i = 0; i < constraints.length; i++) {
                    try {
                        console.log(`Trying constraint ${i + 1}...`);
                        stream = await navigator.mediaDevices.getUserMedia(constraints[i]);
                        console.log('Success with constraint', i + 1);
                        break;
                    } catch (e) {
                        console.log(`Constraint ${i + 1} failed:`, e);
                        lastError = e;
                        if (i === constraints.length - 1) {
                            throw lastError;
                        }
                    }
                }

                if (!stream) {
                    throw new Error('Failed to get camera stream');
                }

                video.srcObject = stream;
                cameraStreams[`${category}-${index}`] = stream;

                // Wait for video to be ready
                await new Promise((resolve, reject) => {
                    video.onloadedmetadata = () => {
                        video.play()
                            .then(() => {
                                console.log('Video playing');
                                resolve();
                            })
                            .catch(err => {
                                console.error('Play error:', err);
                                reject(err);
                            });
                    };

                    video.onerror = (err) => {
                        console.error('Video error:', err);
                        reject(err);
                    };

                    // Timeout after 10 seconds
                    setTimeout(() => reject(new Error('Video load timeout')), 10000);
                });

                // Show video and update UI
                video.style.display = 'block';
                startBtn.classList.add('hidden');
                captureBtn.classList.remove('hidden');
                infoDiv.innerHTML = '<p class="text-green-600">✓ Kamera siap</p>';

            } catch (error) {
                console.error('Error accessing camera:', error);
                let errorMessage = 'Tidak dapat mengakses kamera';

                if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                    errorMessage = 'Izin kamera ditolak. Pastikan Anda memberikan izin akses kamera di pengaturan browser.';
                } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                    errorMessage = 'Kamera tidak ditemukan. Pastikan perangkat Anda memiliki kamera.';
                } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                    errorMessage = 'Kamera sedang digunakan aplikasi lain. Tutup aplikasi lain yang menggunakan kamera.';
                } else if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                    errorMessage = 'Resolusi kamera tidak didukung. Mencoba dengan pengaturan lebih rendah...';
                } else if (error.name === 'TypeError') {
                    errorMessage = 'Browser tidak mendukung akses kamera. Pastikan menggunakan HTTPS atau localhost.';
                } else if (error.message) {
                    errorMessage = error.message;
                }

                infoDiv.innerHTML = `<p class="text-red-600">❌ ${errorMessage}</p>`;

                // Show detailed error in console
                console.error('Camera error details:', {
                    name: error.name,
                    message: error.message,
                    constraint: error.constraint
                });

                // Stop any partial stream
                if (cameraStreams[`${category}-${index}`]) {
                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                    delete cameraStreams[`${category}-${index}`];
                }

                // Show start button again
                startBtn.classList.remove('hidden');
                captureBtn.classList.add('hidden');
                video.style.display = 'none';
            }
        }

        async function capturePhoto(category, index) {
            const video = document.getElementById(`video-${category}-${index}`);
            const canvas = document.getElementById(`canvas-${category}-${index}`);
            const capturedImage = document.getElementById(`captured-${category}-${index}`);
            const captureBtn = document.getElementById(`capture-${category}-${index}`);
            const infoDiv = document.getElementById(`info-${category}-${index}`);

            if (!video || !canvas || !capturedImage) {
                alert('Error: Elemen tidak ditemukan');
                return;
            }

            if (navigator.geolocation) {
                infoDiv.innerHTML = '<p class="text-blue-600">⏳ Mengambil foto...</p>';

                // Helper function untuk proses foto tanpa GPS
                const processPhotoWithoutGPS = () => {
                    try {
                        const timestamp = new Date();

                        // Set canvas size to match video
                        canvas.width = video.videoWidth || 1280;
                        canvas.height = video.videoHeight || 720;
                        const ctx = canvas.getContext('2d');

                        // Draw video frame to canvas
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        // Format date and time
                        const dateStr = timestamp.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });
                        const dayStr = timestamp.toLocaleDateString('id-ID', {
                            weekday: 'long'
                        });

                        const timeStr = timestamp.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });

                        // Add text overlay tanpa GPS
                        const fontSize = Math.max(14, canvas.width * 0.018);
                        const padding = 15;
                        const lineHeight = fontSize * 1.8;
                        const startY = canvas.height - (lineHeight * 2.5);

                        // Add shadow for better readability
                        ctx.shadowColor = 'rgba(0, 0, 0, 0.9)';
                        ctx.shadowBlur = 10;
                        ctx.shadowOffsetX = 2;
                        ctx.shadowOffsetY = 2;

                        ctx.fillStyle = 'white';
                        ctx.font = `${fontSize}px Arial`;
                        ctx.fillText(`${dateStr}`, padding, startY);
                        ctx.fillText(`${dayStr}`, padding, startY + lineHeight);

                        ctx.font = `bold ${fontSize * 2.5}px Arial`;
                        ctx.fillText(`${timeStr}`, padding, startY + (lineHeight * 2));

                        // Convert to image
                        const imageData = canvas.toDataURL('image/jpeg', 0.85);
                        capturedImage.src = imageData;
                        capturedImage.classList.remove('hidden');
                        video.style.display = 'none';

                        // Save photo data tanpa GPS
                        cameraPhotos[category].push({
                            index: index,
                            image: imageData,
                            timestamp: timestamp.toISOString(),
                            address: 'GPS tidak tersedia'
                        });

                        // Update hidden input
                        const hiddenInput = document.getElementById(`camera_photos_${category}`);
                        if (hiddenInput) {
                            hiddenInput.value = JSON.stringify(cameraPhotos[category]);
                        }

                        // Stop camera
                        if (cameraStreams[`${category}-${index}`]) {
                            cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                            delete cameraStreams[`${category}-${index}`];
                        }

                        // Update UI
                        captureBtn.classList.add('hidden');
                        const capturedControls = document.getElementById(`captured-controls-${category}-${index}`);
                        if (capturedControls) {
                            capturedControls.classList.remove('hidden');
                        }
                        infoDiv.innerHTML = `<p class="text-yellow-600 font-semibold">⚠ Foto berhasil diambil (tanpa GPS)</p>`;
                    } catch (error) {
                        console.error('Error processing photo without GPS:', error);
                        infoDiv.innerHTML = '<p class="text-red-600">❌ Gagal memproses foto</p>';
                    }
                };

                // Helper function untuk proses foto dengan GPS
                const processPhotoWithGPS = async (lat, lng) => {
                    try {
                        const timestamp = new Date();
                        infoDiv.innerHTML = '<p class="text-blue-600">⏳ Mendapatkan alamat...</p>';

                        const address = await getAddress(lat, lng);

                        // Set canvas size to match video
                        canvas.width = video.videoWidth || 1280;
                        canvas.height = video.videoHeight || 720;
                        const ctx = canvas.getContext('2d');

                        // Draw video frame to canvas
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        // Format date and time
                        const dateStr = timestamp.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });
                        const dayStr = timestamp.toLocaleDateString('id-ID', {
                            weekday: 'long'
                        });

                        // Determine timezone
                        let timezone = 'WITA';
                        if (lng >= 120 && lng < 130) {
                            timezone = 'WITA';
                        } else if (lng >= 130) {
                            timezone = 'WIT';
                        }

                        const timeStr = timestamp.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        }) + ' ' + timezone;

                        // Add text overlay
                        const fontSize = Math.max(14, canvas.width * 0.018);
                        const padding = 15;
                        const lineHeight = fontSize * 1.8;
                        const startY = canvas.height - (lineHeight * 5.5);

                        // Add shadow for better readability
                        ctx.shadowColor = 'rgba(0, 0, 0, 0.9)';
                        ctx.shadowBlur = 10;
                        ctx.shadowOffsetX = 2;
                        ctx.shadowOffsetY = 2;

                        ctx.fillStyle = 'white';
                        ctx.font = `${fontSize}px Arial`;
                        ctx.fillText(`${dateStr}`, padding, startY);
                        ctx.fillText(`${dayStr}`, padding, startY + lineHeight);

                        ctx.font = `bold ${fontSize * 2.5}px Arial`;
                        ctx.fillText(`${timeStr}`, padding, startY + (lineHeight * 2.3));

                        ctx.font = `${fontSize}px Arial`;
                        ctx.fillText(`Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`, padding, startY + (lineHeight * 3.5));
                        ctx.fillText(`${address}`, padding, startY + (lineHeight * 4.5));

                        // Convert to image
                        const imageData = canvas.toDataURL('image/jpeg', 0.85);
                        capturedImage.src = imageData;
                        capturedImage.classList.remove('hidden');
                        video.style.display = 'none';

                        // Save photo data dengan GPS
                        cameraPhotos[category].push({
                            index: index,
                            image: imageData,
                            lat: lat,
                            lng: lng,
                            timestamp: timestamp.toISOString(),
                            address: address
                        });

                        // Update hidden input
                        const hiddenInput = document.getElementById(`camera_photos_${category}`);
                        if (hiddenInput) {
                            hiddenInput.value = JSON.stringify(cameraPhotos[category]);
                        }

                        // Stop camera
                        if (cameraStreams[`${category}-${index}`]) {
                            cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                            delete cameraStreams[`${category}-${index}`];
                        }

                        // Update UI
                        captureBtn.classList.add('hidden');
                        const capturedControls = document.getElementById(`captured-controls-${category}-${index}`);
                        if (capturedControls) {
                            capturedControls.classList.remove('hidden');
                        }
                        infoDiv.innerHTML = `<p class="text-green-600 font-semibold">✓ Foto berhasil diambil dengan GPS!</p>`;
                    } catch (error) {
                        console.error('Error processing photo with GPS:', error);
                        // Fallback ke foto tanpa GPS jika gagal
                        processPhotoWithoutGPS();
                    }
                };

                // Get geolocation
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        processPhotoWithGPS(lat, lng);
                    },
                    function(error) {
                        // Jika geolocation error, proses foto tanpa GPS
                        console.warn('Geolocation failed:', error.message);
                        processPhotoWithoutGPS();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,  // Timeout 5 detik - lebih singkat
                        maximumAge: 0
                    }
                );
            } else {
                alert('Geolokasi tidak didukung oleh browser ini');
            }
        }

        async function retakePhoto(category, index) {
            const video = document.getElementById(`video-${category}-${index}`);
            const capturedImage = document.getElementById(`captured-${category}-${index}`);
            const captureBtn = document.getElementById(`capture-${category}-${index}`);
            const capturedControls = document.getElementById(`captured-controls-${category}-${index}`);
            const infoDiv = document.getElementById(`info-${category}-${index}`);

            // Remove photo from array
            cameraPhotos[category] = cameraPhotos[category].filter(p => p.index !== index);
            const hiddenInput = document.getElementById(`camera_photos_${category}`);
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(cameraPhotos[category]);
            }

            // Update UI
            capturedImage.classList.add('hidden');
            capturedImage.src = '';
            video.style.display = 'none';
            if (capturedControls) {
                capturedControls.classList.add('hidden');
            }
            captureBtn.classList.remove('hidden');
            infoDiv.innerHTML = '';

            // Restart camera
            await startCamera(category, index);
        }

        function deleteCapturedPhoto(category, index) {
            if (confirm('Hapus foto ini? Tindakan ini tidak dapat dibatalkan.')) {
                const capturedImage = document.getElementById(`captured-${category}-${index}`);
                const capturedControls = document.getElementById(`captured-controls-${category}-${index}`);
                const captureBtn = document.getElementById(`capture-${category}-${index}`);
                const video = document.getElementById(`video-${category}-${index}`);
                const infoDiv = document.getElementById(`info-${category}-${index}`);

                // Remove photo from array
                cameraPhotos[category] = cameraPhotos[category].filter(p => p.index !== index);
                const hiddenInput = document.getElementById(`camera_photos_${category}`);
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(cameraPhotos[category]);
                }

                // Reset UI
                capturedImage.classList.add('hidden');
                capturedImage.src = '';
                video.style.display = 'none';
                if (capturedControls) {
                    capturedControls.classList.add('hidden');
                }
                captureBtn.classList.remove('hidden');
                infoDiv.innerHTML = '<p class="text-gray-600">Foto dihapus. Klik "Buka Kamera" untuk mengambil foto baru.</p>';
            }
        }

        function removeCameraSlot(category, index) {
            if (confirm('Hapus slot kamera ini?')) {
                // Stop camera if active
                if (cameraStreams[`${category}-${index}`]) {
                    cameraStreams[`${category}-${index}`].getTracks().forEach(track => track.stop());
                    delete cameraStreams[`${category}-${index}`];
                }

                // Remove photo from array
                cameraPhotos[category] = cameraPhotos[category].filter(p => p.index !== index);
                const hiddenInput = document.getElementById(`camera_photos_${category}`);
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(cameraPhotos[category]);
                }

                // Remove DOM element
                const element = document.getElementById(`camera-slot-${category}-${index}`);
                if (element) {
                    element.remove();
                }
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            Object.values(cameraStreams).forEach(stream => {
                stream.getTracks().forEach(track => track.stop());
            });
        });

        // FUNGSI KOMPRESI GAMBAR - Mengompress gambar menjadi maksimal 1MB
        async function compressImage(file, maxSizeMB = 1) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        // Resize jika terlalu besar (maksimal 1920px untuk sisi terpanjang)
                        const maxDimension = 1920;
                        if (width > maxDimension || height > maxDimension) {
                            if (width > height) {
                                height = (height / width) * maxDimension;
                                width = maxDimension;
                            } else {
                                width = (width / height) * maxDimension;
                                height = maxDimension;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        // Mulai dengan kualitas 0.9, turunkan sampai ukuran < 1MB
                        let quality = 0.9;
                        const maxSizeBytes = maxSizeMB * 1024 * 1024;

                        function tryCompress() {
                            canvas.toBlob(function(blob) {
                                if (blob.size <= maxSizeBytes || quality <= 0.1) {
                                    // Konversi blob ke base64
                                    const reader = new FileReader();
                                    reader.onloadend = function() {
                                        resolve({
                                            base64: reader.result,
                                            size: blob.size,
                                            originalSize: file.size
                                        });
                                    };
                                    reader.readAsDataURL(blob);
                                } else {
                                    quality -= 0.1;
                                    tryCompress();
                                }
                            }, 'image/jpeg', quality);
                        }

                        tryCompress();
                    };
                    img.onerror = reject;
                    img.src = e.target.result;
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

       // FUNGSI VALIDASI DAN PREVIEW GAMBAR UPLOAD - UPDATED
// FUNGSI VALIDASI GAMBAR UPLOAD - SIMPLIFIED
function validateImageFiles(input) {
    const files = input.files;
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const allowedExtensions = ['jpg', 'jpeg', 'png'];
    let invalidFiles = [];

    // Validasi format file
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedTypes.includes(file.type) || !allowedExtensions.includes(fileExtension)) {
            invalidFiles.push(file.name);
        }
    }

    if (invalidFiles.length > 0) {
        alert('❌ Format file tidak valid!\n\nFile yang ditolak:\n' + invalidFiles.join('\n') + '\n\nHanya file JPG, JPEG, dan PNG yang diperbolehkan.');
        input.value = '';
        return false;
    }

    return true;
}

// Fungsi untuk format ukuran file
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

// Fungsi untuk hapus preview gambar upload
// Fungsi untuk hapus preview gambar upload - UPDATED
function removeUploadPreview(button, index, inputName) {
    if (confirm('Hapus gambar ini?')) {
        const previewItem = button.closest('.relative');
        const previewContainer = previewItem.parentElement;
        const uploadInput = previewContainer.closest('.border').querySelector(`input[name="${inputName}"]`);
        const hiddenInput = previewContainer.parentElement.querySelector(`input[name="${inputName}_compressed"]`);

        // Hapus dari preview
        previewItem.remove();

        // Update hidden input
        if (hiddenInput) {
            let compressedFiles = JSON.parse(hiddenInput.value);
            compressedFiles.splice(index, 1);
            hiddenInput.value = JSON.stringify(compressedFiles);

            // Update indices untuk tombol hapus yang tersisa
            const remainingItems = previewContainer.querySelectorAll('.relative');
            remainingItems.forEach((item, newIndex) => {
                const removeBtn = item.querySelector('button[onclick^="removeUploadPreview"]');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `removeUploadPreview(this, ${newIndex}, '${inputName}')`);
                }
            });
        }

        // Clear file input dan hapus container jika tidak ada gambar tersisa
        if (previewContainer.children.length === 0) {
            uploadInput.value = '';
            previewContainer.remove();
            if (hiddenInput) hiddenInput.remove();
        }
    }
}

// Fungsi untuk buka modal preview gambar ukuran penuh
function openImageModal(src, filename) {
    // Buat modal overlay
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4';
    modal.onclick = function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    };

    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-full">
            <button onclick="this.closest('.fixed').remove()"
                    class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl font-bold">
                ✕ Tutup
            </button>
            <img src="${src}"
                 class="max-w-full max-h-[80vh] object-contain rounded shadow-2xl"
                 alt="${filename}">
            <p class="text-white text-center mt-2 text-sm">${filename}</p>
        </div>
    `;

    document.body.appendChild(modal);

    // Tambahkan event listener untuk ESC key
    const closeOnEsc = function(e) {
        if (e.key === 'Escape') {
            modal.remove();
            document.removeEventListener('keydown', closeOnEsc);
        }
    };
    document.addEventListener('keydown', closeOnEsc);
}

// FUNGSI KOMPRESI GAMBAR (tetap sama)
async function compressImage(file, maxSizeMB = 1) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;

                // Resize jika terlalu besar (maksimal 1920px untuk sisi terpanjang)
                const maxDimension = 1920;
                if (width > maxDimension || height > maxDimension) {
                    if (width > height) {
                        height = (height / width) * maxDimension;
                        width = maxDimension;
                    } else {
                        width = (width / height) * maxDimension;
                        height = maxDimension;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Mulai dengan kualitas 0.9, turunkan sampai ukuran < 1MB
                let quality = 0.9;
                const maxSizeBytes = maxSizeMB * 1024 * 1024;

                function tryCompress() {
                    canvas.toBlob(function(blob) {
                        if (blob.size <= maxSizeBytes || quality <= 0.1) {
                            // Konversi blob ke base64
                            const reader = new FileReader();
                            reader.onloadend = function() {
                                resolve({
                                    base64: reader.result,
                                    size: blob.size,
                                    originalSize: file.size
                                });
                            };
                            reader.readAsDataURL(blob);
                        } else {
                            quality -= 0.1;
                            tryCompress();
                        }
                    }, 'image/jpeg', quality);
                }

                tryCompress();
            };
            img.onerror = reject;
            img.src = e.target.result;
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

async function handleImageUpload(input) {
    // Validasi dulu
    const isValid = await validateImageFiles(input);
    if (!isValid) {
        return;
    }

    // Jika valid, tampilkan preview
    await createUploadPreview(input);
}
// Fungsi untuk membuat preview upload images
async function createUploadPreview(input) {
    const files = input.files;
    if (files.length === 0) return;

    // Hapus preview container lama jika ada
    const oldPreviewContainer = input.parentElement.querySelector('.upload-preview-container');
    if (oldPreviewContainer) {
        oldPreviewContainer.remove();
    }

    // Hapus hidden input lama
    const oldHiddenInput = input.parentElement.querySelector(`input[name="${input.name}_compressed"]`);
    if (oldHiddenInput) {
        oldHiddenInput.remove();
    }

    // Buat preview container
    const previewContainer = document.createElement('div');
    previewContainer.className = 'upload-preview-container mt-3 grid grid-cols-2 md:grid-cols-3 gap-2';

    // Status div untuk kompresi
    const statusDiv = document.createElement('div');
    statusDiv.className = 'col-span-full mt-2 p-2 bg-blue-50 border border-blue-200 rounded text-sm';
    statusDiv.innerHTML = '<p class="text-blue-600">⏳ Memproses gambar...</p>';

    input.parentElement.appendChild(previewContainer);
    input.parentElement.appendChild(statusDiv);

    // Kompresi dan preview semua gambar
    const compressedFiles = [];

    for (let i = 0; i < files.length; i++) {
        try {
            statusDiv.innerHTML = `<p class="text-blue-600">⏳ Memproses ${files[i].name} (${i + 1}/${files.length})...</p>`;

            const compressed = await compressImage(files[i]);
            compressedFiles.push({
                name: files[i].name,
                base64: compressed.base64,
                size: compressed.size,
                originalSize: compressed.originalSize
            });

            // Buat preview item
            const previewItem = document.createElement('div');
            previewItem.className = 'relative group';
            previewItem.innerHTML = `
                <img src="${compressed.base64}"
                     class="w-full h-24 object-cover rounded border border-gray-200 cursor-pointer hover:opacity-90 transition"
                     onclick="openImageModal(this.src, '${files[i].name}')"
                     title="Klik untuk melihat ukuran penuh">
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs p-1 rounded-b">
                    <p class="truncate" title="${files[i].name}">${files[i].name}</p>
                    <p>${formatFileSize(compressed.size)}</p>
                </div>
                <button type="button"
                        onclick="removeUploadPreview(this, ${i}, '${input.name}')"
                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                        title="Hapus gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            previewContainer.appendChild(previewItem);

        } catch (error) {
            console.error('Error processing image:', error);
            alert(`Gagal memproses ${files[i].name}`);
            statusDiv.remove();
            previewContainer.remove();
            return false;
        }
    }

    // Simpan data compressed ke hidden input
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = input.name + '_compressed';
    hiddenInput.value = JSON.stringify(compressedFiles);
    input.parentElement.appendChild(hiddenInput);

    // Show success message
    const totalOriginal = compressedFiles.reduce((sum, f) => sum + f.originalSize, 0);
    const totalCompressed = compressedFiles.reduce((sum, f) => sum + f.size, 0);
    const savedPercent = ((1 - totalCompressed/totalOriginal) * 100).toFixed(1);

    statusDiv.innerHTML = `
        <p class="text-green-600 font-semibold">✓ ${compressedFiles.length} gambar berhasil diproses!</p>
        <p class="text-gray-600 text-xs mt-1">
            Ukuran asli: ${formatFileSize(totalOriginal)} → Setelah kompresi: ${formatFileSize(totalCompressed)}
            (hemat ${savedPercent}%)
        </p>
    `;

    setTimeout(() => {
        statusDiv.classList.add('opacity-0', 'transition-opacity', 'duration-500');
        setTimeout(() => statusDiv.remove(), 500);
    }, 4000);
}

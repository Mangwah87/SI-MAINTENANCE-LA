// ============================================================================
// AC FORM CAMERA HANDLER - WITA VERSION WITH WATERMARK
// File: public/js/acform.js
// MODIFIED: Menggunakan zona waktu WITA (UTC+8) dengan watermark
// ============================================================================
(() => {
  'use strict';

  console.log('AC Form Handler loading...');

  // --------------------------------------------------------------------------
  // GLOBAL VARIABLES
  // --------------------------------------------------------------------------
  let currentStream = null;
  let currentFacingMode = 'environment';
  let currentCategory = null;
  let currentSection = null;
  let currentReplaceTarget = null;
  let currentReplacePosition = null;

  let currentGeoData = {
    lat: '-',
    lon: '-',
    location: '-',
    datetime: '-'
  };

  // IndexedDB for storing images
  let dbInstance = null;
  const DB_NAME = 'ACFormDB';
  const DB_VERSION = 1;
  const STORE_NAME = 'formDrafts';

  // Auto-save trigger function (global scope)
  function triggerAutoSave() {
    const event = new CustomEvent('formImageChanged');
    document.dispatchEvent(event);
  }

  // Simple encryption for client-side storage (obfuscation)
  function encryptData(data) {
    try {
      const str = JSON.stringify(data);
      return btoa(unescape(encodeURIComponent(str)));
    } catch (e) {
      console.error('Encryption failed:', e);
      return data;
    }
  }

  function decryptData(encryptedData) {
    try {
      const str = decodeURIComponent(escape(atob(encryptedData)));
      return JSON.parse(str);
    } catch (e) {
      console.error('Decryption failed:', e);
      return null;
    }
  }

  // --------------------------------------------------------------------------
  // MAIN INITIALIZATION
  // --------------------------------------------------------------------------
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // --------------------------------------------------------------------------
  // INIT FUNCTION
  // --------------------------------------------------------------------------
  function init() {
    console.log('Initializing AC Form Handler...');

    // Initialize Auto-Save FIRST
    initAutoSave();

    // DOM ELEMENTS
    const modal = document.getElementById('cameraModal');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const switchCameraBtn = document.getElementById('switchCameraBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const usePhotoBtn = document.getElementById('usePhotoBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const capturedImage = document.getElementById('capturedImage');
    const capturedImg = document.getElementById('capturedImg');
    const videoSection = document.getElementById('videoSection');
    const captureControls = document.getElementById('captureControls');
    const retakeControls = document.getElementById('retakeControls');

    if (!modal || !video || !canvas) {
      console.error('Required elements not found');
      return;
    }

    // ------------------------------------------------------------------------
    // INITIALIZE IMAGE UPLOAD SECTIONS
    // ------------------------------------------------------------------------
    document.querySelectorAll('.image-upload-section').forEach(section => {
      const categoryName = section.dataset.fieldName;
      const cameraBtn = section.querySelector('.camera-btn');
      const uploadBtn = section.querySelector('.upload-local-btn');
      const fileInput = section.querySelector('.file-input');

      console.log('Initializing section:', categoryName);

      // Camera button handler
      if (cameraBtn) {
        cameraBtn.addEventListener('click', e => {
          e.preventDefault();
          currentCategory = categoryName;
          currentSection = section;
          currentReplaceTarget = null;
          currentReplacePosition = null;
          openCamera();
        });
      }

      // Upload button handler
      if (uploadBtn && fileInput) {
        uploadBtn.addEventListener('click', e => {
          e.preventDefault();
          fileInput.click();
        });
        fileInput.addEventListener('change', e => {
          // Find the section from the file input
          const fileInputElement = e.target;
          const sectionElement = fileInputElement.closest('.image-upload-section');

          if (!sectionElement) {
            console.error('Could not find parent section for file input');
            return;
          }

          const category = sectionElement.dataset.fieldName;
          handleLocalFiles(fileInputElement.files, sectionElement, category);
        });
      }

      // Delete existing images
      section.querySelectorAll('.delete-existing-btn').forEach(btn => {
        btn.addEventListener('click', e => {
          e.preventDefault();

          const imageDiv = btn.closest('.existing-image');
          const imagePath = imageDiv.dataset.path;

          if (confirm('Hapus gambar ini?')) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'delete_images[]';
            hiddenInput.value = imagePath;
            document.getElementById('mainForm').appendChild(hiddenInput);

            imageDiv.remove();
            console.log('Marked image for deletion:', imagePath);

            // Trigger auto-save after deletion
            triggerAutoSave();
          }
        });
      });

      // Edit existing images
      const previewContainer = section.querySelector('.preview-container');
      if (previewContainer) {
        previewContainer.querySelectorAll('.existing-image').forEach((imageDiv, index) => {
          addEditButtonToExisting(imageDiv, section, categoryName, index);
        });
      }
    });

    // Camera control buttons
    captureBtn?.addEventListener('click', e => {
      e.preventDefault();
      capturePhoto();
    });

    retakeBtn?.addEventListener('click', async e => {
      e.preventDefault();
      await retakePhoto();
    });

    usePhotoBtn?.addEventListener('click', e => {
      e.preventDefault();
      usePhoto();
    });

    switchCameraBtn?.addEventListener('click', async e => {
      e.preventDefault();
      await switchCamera();
    });

    closeModalBtn?.addEventListener('click', e => {
      e.preventDefault();
      closeCamera();
    });

    modal.addEventListener('click', e => {
      if (e.target === modal) closeCamera();
    });

    console.log('AC Form Handler initialized successfully');

    // ========================================================================
    // INDEXEDDB INITIALIZATION
    // ========================================================================
    function initIndexedDB() {
      return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);

        request.onerror = () => {
          console.error('IndexedDB: Failed to open database');
          reject(request.error);
        };

        request.onsuccess = () => {
          dbInstance = request.result;
          console.log('✅ IndexedDB: Connected');
          resolve(dbInstance);
        };

        request.onupgradeneeded = (event) => {
          const db = event.target.result;
          if (!db.objectStoreNames.contains(STORE_NAME)) {
            db.createObjectStore(STORE_NAME, { keyPath: 'id' });
            console.log('✅ IndexedDB: Object store created');
          }
        };
      });
    }

    async function saveToIndexedDB(key, data) {
      if (!dbInstance) {
        await initIndexedDB();
      }

      return new Promise((resolve, reject) => {
        const transaction = dbInstance.transaction([STORE_NAME], 'readwrite');
        const store = transaction.objectStore(STORE_NAME);

        // Encrypt data before storing
        const encryptedData = encryptData(data);
        const request = store.put({ id: key, data: encryptedData, timestamp: new Date().toISOString() });

        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
      });
    }

    async function getFromIndexedDB(key) {
      if (!dbInstance) {
        await initIndexedDB();
      }

      return new Promise((resolve, reject) => {
        const transaction = dbInstance.transaction([STORE_NAME], 'readonly');
        const store = transaction.objectStore(STORE_NAME);
        const request = store.get(key);

        request.onsuccess = () => {
          const result = request.result;
          if (result && result.data) {
            // Decrypt data after retrieving
            const decryptedData = decryptData(result.data);
            resolve(decryptedData ? { ...result, data: decryptedData } : null);
          } else {
            resolve(result);
          }
        };
        request.onerror = () => reject(request.error);
      });
    }

    async function deleteFromIndexedDB(key) {
      if (!dbInstance) {
        await initIndexedDB();
      }

      return new Promise((resolve, reject) => {
        const transaction = dbInstance.transaction([STORE_NAME], 'readwrite');
        const store = transaction.objectStore(STORE_NAME);
        const request = store.delete(key);

        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
      });
    }

    // ========================================================================
    // AUTO-SAVE TO INDEXEDDB WITH IMAGES
    // ========================================================================
    async function initAutoSave() {
      console.log('Initializing Auto-Save...');

      // Initialize IndexedDB first
      try {
        await initIndexedDB();
      } catch (error) {
        console.error('Auto-Save: Failed to initialize IndexedDB', error);
        return;
      }

      const form = document.getElementById('mainForm');
      if (!form) {
        console.warn('Auto-Save: Form not found');
        return;
      }

      const STORAGE_KEY = 'ac_form_draft';
      const isEditMode = form.action.includes('/update/');

      // Don't auto-save in edit mode (to avoid overwriting existing data)
      if (isEditMode) {
        console.log('Auto-Save: Skipped (edit mode)');
        return;
      }

      // Restore saved data on page load
      await restoreFormData();

      // Save form data on input change (debounced)
      let saveTimeout;
      const saveDelay = 1000; // 1 second delay

      const fieldsToSave = form.querySelectorAll('input, select, textarea');
      fieldsToSave.forEach(field => {
        // Skip hidden fields, file inputs, and submit buttons
        if (field.type === 'hidden' || field.type === 'file' || field.type === 'submit') {
          return;
        }

        field.addEventListener('input', () => {
          clearTimeout(saveTimeout);
          saveTimeout = setTimeout(() => saveFormData(), saveDelay);
        });

        field.addEventListener('change', () => {
          clearTimeout(saveTimeout);
          saveTimeout = setTimeout(() => saveFormData(), saveDelay);
        });
      });

      // Listen for image changes
      document.addEventListener('formImageChanged', () => {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => saveFormData(), saveDelay);
      });

      // Clear saved data on successful form submission
      form.addEventListener('submit', async function() {
        setTimeout(async () => {
          await deleteFromIndexedDB(STORAGE_KEY);
          console.log('✅ Auto-Save: Cleared after submission');
        }, 500);
      });

      async function saveFormData() {
        const formData = {};
        const fields = form.querySelectorAll('input, select, textarea');

        fields.forEach(field => {
          // Skip certain fields
          if (field.type === 'hidden' ||
              field.type === 'file' ||
              field.type === 'submit' ||
              field.name === '_token' ||
              field.name === '_method' ||
              field.name.startsWith('delete_')) {
            return;
          }

          if (field.type === 'radio' || field.type === 'checkbox') {
            if (field.checked) {
              formData[field.name] = field.value;
            }
          } else {
            if (field.value) {
              formData[field.name] = field.value;
            }
          }
        });

        // Collect all images from preview containers
        const images = [];
        document.querySelectorAll('.image-upload-section').forEach(section => {
          const category = section.dataset.fieldName;
          const previewContainer = section.querySelector('.preview-container');

          if (previewContainer) {
            previewContainer.querySelectorAll('img').forEach(img => {
              // Get image data (base64 or URL)
              const imageData = img.src;

              // Check if it's a new image (base64) or existing (storage path)
              if (imageData.startsWith('data:image')) {
                images.push({
                  category: category,
                  data: imageData,
                  isNew: true
                });
              } else if (imageData.includes('/storage/')) {
                // Existing image - save the path
                const imageDiv = img.closest('.existing-image');
                const path = imageDiv ? imageDiv.dataset.path : null;
                if (path) {
                  images.push({
                    category: category,
                    path: path,
                    url: imageData,
                    isNew: false
                  });
                }
              }
            });
          }
        });

        const draftData = {
          formFields: formData,
          images: images,
          timestamp: new Date().toISOString()
        };

        try {
          await saveToIndexedDB(STORAGE_KEY, draftData);
          console.log('💾 Auto-Save: Data + Images saved', {
            fields: Object.keys(formData).length,
            images: images.length
          });
        } catch (error) {
          console.error('Auto-Save: Failed to save', error);
        }
      }

      async function restoreFormData() {
        try {
          const savedDraft = await getFromIndexedDB(STORAGE_KEY);
          if (!savedDraft) {
            console.log('Auto-Save: No saved data found');
            return;
          }

          const { data, timestamp } = savedDraft;
          const savedDate = new Date(timestamp);
          const minutesSince = (new Date() - savedDate) / (1000 * 60);

          // Auto-delete data older than 5 minutes
          if (minutesSince > 5) {
            await deleteFromIndexedDB(STORAGE_KEY);
            console.log('Auto-Save: Data expired (>5 minutes), cleared');
            return;
          }

          // Show restore notification
          showRestoreNotification(async () => {
            // Restore form fields
            if (data.formFields) {
              Object.keys(data.formFields).forEach(name => {
                const fields = form.querySelectorAll(`[name="${name}"]`);
                fields.forEach(field => {
                  if (field.type === 'radio' || field.type === 'checkbox') {
                    if (field.value === data.formFields[name]) {
                      field.checked = true;
                    }
                  } else {
                    field.value = data.formFields[name];
                  }
                });
              });
            }

            // Restore images
            if (data.images && data.images.length > 0) {
              data.images.forEach(imageInfo => {
                const section = document.querySelector(`.image-upload-section[data-field-name="${imageInfo.category}"]`);
                if (section) {
                  const previewContainer = section.querySelector('.preview-container');
                  if (previewContainer) {
                    if (imageInfo.isNew) {
                      // Restore new images (base64)
                      const imageDiv = document.createElement('div');
                      imageDiv.className = 'relative group';
                      imageDiv.dataset.category = imageInfo.category;

                      const img = document.createElement('img');
                      img.src = imageInfo.data;
                      img.className = 'w-full h-20 object-cover rounded border';

                      const deleteBtn = document.createElement('button');
                      deleteBtn.type = 'button';
                      deleteBtn.innerHTML = '×';
                      deleteBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition';
                      deleteBtn.addEventListener('click', () => {
                        imageDiv.remove();
                        triggerAutoSave();
                      });

                      const mainForm = document.getElementById('mainForm');
                      const hiddenInput = document.createElement('input');
                      hiddenInput.type = 'hidden';
                      hiddenInput.name = 'images[]';
                      hiddenInput.value = JSON.stringify({
                        data: imageInfo.data,
                        category: imageInfo.category,
                        timestamp: new Date().toISOString()
                      });

                      imageDiv.append(img, deleteBtn);
                      mainForm.appendChild(hiddenInput);
                      previewContainer.appendChild(imageDiv);
                    } else {
                      // Restore existing images (from storage)
                      const imageDiv = document.createElement('div');
                      imageDiv.className = 'relative group existing-image';
                      imageDiv.dataset.path = imageInfo.path;
                      imageDiv.dataset.category = imageInfo.category;

                      const img = document.createElement('img');
                      img.src = imageInfo.url;
                      img.className = 'w-full h-20 object-cover rounded border';

                      const deleteBtn = document.createElement('button');
                      deleteBtn.type = 'button';
                      deleteBtn.innerHTML = '×';
                      deleteBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition';
                      deleteBtn.addEventListener('click', () => {
                        const imagePath = imageDiv.dataset.path;
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'delete_images[]';
                        hiddenInput.value = imagePath;
                        document.getElementById('mainForm').appendChild(hiddenInput);
                        imageDiv.remove();
                        triggerAutoSave();
                      });

                      imageDiv.append(img, deleteBtn);
                      previewContainer.appendChild(imageDiv);
                    }
                  }
                }
              });
            }

            console.log('✅ Auto-Save: Data + Images restored', {
              fields: data.formFields ? Object.keys(data.formFields).length : 0,
              images: data.images ? data.images.length : 0
            });
            showNotification(`✔ Draft dipulihkan! (${data.images ? data.images.length : 0} gambar)`);
          }, async () => {
            await deleteFromIndexedDB(STORAGE_KEY);
            console.log('Auto-Save: User declined restore, data cleared');
          });

        } catch (error) {
          console.error('Auto-Save: Error restoring data', error);
          await deleteFromIndexedDB(STORAGE_KEY);
        }
      }

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

      console.log('✅ Auto-Save initialized');
    }

    // ========================================================================
    // CAMERA FUNCTIONS
    // ========================================================================

    async function openCamera() {
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';

      try {
        await updateGeolocation();
        await startCamera();
      } catch (err) {
        alert('Gagal membuka kamera: ' + err.message);
        closeCamera();
      }
    }

    async function startCamera() {
      stopCamera();

      const constraints = {
        video: {
          facingMode: currentFacingMode,
          width: { ideal: 1920 },
          height: { ideal: 1080 }
        },
        audio: false
      };

      try {
        currentStream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = currentStream;
        await video.play();

        // Mirror video preview only for front camera
        if (currentFacingMode === 'user') {
          video.style.transform = 'scaleX(-1)';
        } else {
          video.style.transform = 'none';
        }

        console.log('Camera started successfully');
      } catch (err) {
        throw new Error('Tidak dapat mengakses kamera: ' + err.message);
      }
    }

    function stopCamera() {
      if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
        currentStream = null;
      }
      video.srcObject = null;
    }

    function closeCamera() {
      stopCamera();
      modal.classList.add('hidden');
      document.body.style.overflow = 'auto';
      capturedImage.classList.add('hidden');
      videoSection.classList.remove('hidden');
      retakeControls.classList.add('hidden');
      captureControls.classList.remove('hidden');
      currentCategory = null;
      currentSection = null;
      currentReplaceTarget = null;
      currentReplacePosition = null;
    }

    async function switchCamera() {
      currentFacingMode =
        currentFacingMode === 'environment' ? 'user' : 'environment';
      await startCamera();
    }

    // ========================================================================
    // GEOLOCATION & WATERMARK
    // ========================================================================

    async function updateGeolocation() {
      // Konversi waktu lokal ke WITA (UTC+8)
      const now = new Date();
      const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
      const witaTime = new Date(utcTime + (8 * 3600000)); // UTC+8

      const day = String(witaTime.getDate()).padStart(2, '0');
      const month = String(witaTime.getMonth() + 1).padStart(2, '0');
      const year = witaTime.getFullYear();

      const hours = String(witaTime.getHours()).padStart(2, '0');
      const minutes = String(witaTime.getMinutes()).padStart(2, '0');
      const seconds = String(witaTime.getSeconds()).padStart(2, '0');

      const datetimeText = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;

      document.getElementById('datetime').textContent = datetimeText;
      currentGeoData.datetime = datetimeText;

      if (!('geolocation' in navigator)) {
        setGeoUnavailable('Geolocation tidak didukung browser');
        return;
      }

      try {
        const position = await new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(resolve, reject, {
            enableHighAccuracy: true,  // Paksa gunakan GPS
            timeout: 15000,            // Tunggu lebih lama untuk GPS
            maximumAge: 0              // Jangan gunakan cache
          });
        });

        const lat = position.coords.latitude.toFixed(6);
        const lon = position.coords.longitude.toFixed(6);
        const accuracy = Math.round(position.coords.accuracy);

        console.log('📍 Geolocation Info:');
        console.log('  Latitude:', lat);
        console.log('  Longitude:', lon);
        console.log('  Accuracy:', accuracy, 'meters');
        console.log('  Source:', accuracy < 100 ? '✓ GPS (Akurat)' : '⚠ WiFi/IP (Kurang akurat)');

        document.getElementById('lat').textContent = lat;
        document.getElementById('lon').textContent = lon;
        currentGeoData.lat = lat;
        currentGeoData.lon = lon;

        await getLocationName(lat, lon);
      } catch (error) {
        console.error('Geolocation error:', error);
        setGeoUnavailable('Lokasi tidak dapat diakses');
      }
    }

    function setGeoUnavailable(message) {
      document.getElementById('lat').textContent = 'Tidak tersedia';
      document.getElementById('lon').textContent = 'Tidak tersedia';
      document.getElementById('location').textContent = message;
      currentGeoData.lat = 'Tidak tersedia';
      currentGeoData.lon = 'Tidak tersedia';
      currentGeoData.location = message;
    }

    async function getLocationName(lat, lon) {
      const fallback = `${lat}, ${lon}`;
      document.getElementById('location').textContent = fallback;
      currentGeoData.location = fallback;

      // Daftar API geocoding dengan prioritas (dari yang paling diutamakan)
      const geocodeAPIs = [
        {
          name: 'Geocode.maps.co',
          url: `https://geocode.maps.co/reverse?lat=${lat}&lon=${lon}&format=json`,
          headers: { 'Accept': 'application/json' }
        },
        {
          name: 'Nominatim OpenStreetMap',
          url: `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`,
          headers: {
            'Accept': 'application/json',
            'User-Agent': 'MaintenanceApp/1.0'
          }
        },
        {
          name: 'BigDataCloud',
          url: `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`,
          headers: { 'Accept': 'application/json' }
        }
      ];

      // Coba setiap API secara berurutan sampai ada yang berhasil
      for (let i = 0; i < geocodeAPIs.length; i++) {
        const api = geocodeAPIs[i];
        try {
          console.log(`Mencoba ${api.name}...`);

          const controller = new AbortController();
          const timeoutId = setTimeout(() => controller.abort(), 10000);

          const response = await fetch(api.url, {
            signal: controller.signal,
            headers: api.headers
          });

          clearTimeout(timeoutId);

          if (!response.ok) {
            throw new Error(`${api.name} returned status ${response.status}`);
          }

          const data = await response.json();
          let location = fallback;

          // Parse response berdasarkan API yang digunakan
          if (api.name === 'BigDataCloud') {
            // BigDataCloud format
            let locationParts = [];
            if (data.locality) locationParts.push(data.locality);
            if (data.city) locationParts.push(data.city);
            if (data.principalSubdivision) locationParts.push(data.principalSubdivision);
            location = locationParts.length > 0 ? locationParts.join(', ') : (data.localityInfo?.administrative?.[0]?.name || fallback);
          } else {
            // Geocode.maps.co & Nominatim format (mirip)
            let locationParts = [];
            if (data.address) {
              const addr = data.address;

              if (addr.road) {
                locationParts.push(addr.road);
              }

              if (addr.village || addr.suburb || addr.neighbourhood || addr.hamlet) {
                locationParts.push(addr.village || addr.suburb || addr.neighbourhood || addr.hamlet);
              }

              if (addr.municipality || addr.city_district || addr.county) {
                locationParts.push(addr.municipality || addr.city_district || addr.county);
              }

              if (addr.city || addr.town) {
                locationParts.push(addr.city || addr.town);
              }
            }

            location = locationParts.length > 0
              ? locationParts.join(', ')
              : (data.display_name || fallback);
          }

          document.getElementById('location').textContent = location;
          currentGeoData.location = location;
          console.log(`✓ Berhasil menggunakan ${api.name}`);
          return; // Sukses, keluar dari loop

        } catch (error) {
          console.warn(`✗ ${api.name} gagal:`, error.message);
          // Lanjut ke API berikutnya
          if (i === geocodeAPIs.length - 1) {
            // Ini adalah API terakhir, tampilkan pesan fallback
            console.warn('Semua API geocoding gagal, menggunakan koordinat sebagai fallback');
          }
        }
      }
    }

    // ========================================================================
    // IMAGE CAPTURE & PROCESSING WITH WATERMARK
    // ========================================================================

    function capturePhoto() {
      if (!video.videoWidth || !video.videoHeight) {
        alert('Video belum siap. Tunggu sebentar...');
        return;
      }

      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      const ctx = canvas.getContext('2d');

      // Mirror only for front camera (selfie)
      if (currentFacingMode === 'user') {
        ctx.save();
        ctx.scale(-1, 1);
        ctx.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
        ctx.restore();
      } else {
        // Back camera - natural view
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      }

      // Add watermark
      addWatermarkToCanvas(ctx, canvas.width, canvas.height);

      const imageData = canvas.toDataURL('image/jpeg', 0.92);
      capturedImg.src = imageData;

      videoSection.classList.add('hidden');
      capturedImage.classList.remove('hidden');
      captureControls.classList.add('hidden');
      retakeControls.classList.remove('hidden');

      stopCamera();
      console.log('Photo captured with watermark');
    }

    function addWatermarkToCanvas(ctx, width, height) {
      const { lat, lon, location, datetime } = currentGeoData;

      // Parse datetime
      const parts = datetime.split(' ');
      const datePart = parts[0] || datetime;
      const timePart = parts[1] || '';
      const timeShort = timePart.substring(0, 5);

      // Format date
      const dateArr = datePart.split('/');
      const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      const day = dateArr[0];
      const monthName = months[parseInt(dateArr[1]) - 1] || dateArr[1];
      const year = dateArr[2];
      const formattedDate = `${day} ${monthName} ${year}`;

      const padding = 40;
      const startX = padding;
      const baseY = height - 420;

      // Draw date
      const dateFontSize = Math.floor(width / 30);
      ctx.font = `bold ${dateFontSize}px Arial, sans-serif`;
      ctx.textBaseline = 'top';

      const dateY = baseY;

      // Date with outline
      ctx.strokeStyle = '#000000';
      ctx.lineWidth = 7;
      ctx.lineJoin = 'round';
      ctx.strokeText(formattedDate, startX, dateY);
      ctx.fillStyle = '#FFFFFF';
      ctx.fillText(formattedDate, startX, dateY);

      // Day name
      const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
      const now = new Date();
      const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
      const witaDate = new Date(utcTime + (8 * 3600000));
      const dayName = days[witaDate.getDay()];

      ctx.strokeText(dayName, startX, dateY + dateFontSize + 8);
      ctx.fillText(dayName, startX, dateY + dateFontSize + 8);

      // Draw time
      const timeFontSize = Math.floor(width / 8);
      const startY = dateY + (dateFontSize * 2) + 30;

      ctx.font = `bold ${timeFontSize}px Arial, sans-serif`;

      ctx.strokeStyle = '#000000';
      ctx.lineWidth = 14;
      ctx.strokeText(timeShort, startX, startY);

      ctx.fillStyle = '#FFFFFF';
      ctx.fillText(timeShort, startX, startY);

      // Draw WITA label
      const timeWidth = ctx.measureText(timeShort).width;
      const witaFontSize = Math.floor(width / 20);
      ctx.font = `bold ${witaFontSize}px Arial, sans-serif`;

      const witaX = startX + timeWidth + 20;
      const witaY = startY + (timeFontSize - witaFontSize) / 2;

      ctx.lineWidth = 8;
      ctx.strokeText('WITA', witaX, witaY);
      ctx.fillText('WITA', witaX, witaY);

      // Draw coordinates and location
      const locationFontSize = Math.floor(width / 35);
      ctx.font = `bold ${locationFontSize}px Arial, sans-serif`;
      const locationY = startY + timeFontSize + 35;

      const coordText = `${lat}, ${lon}`;
      ctx.lineWidth = 7;
      ctx.strokeText(coordText, startX, locationY);
      ctx.fillText(coordText, startX, locationY);

      ctx.strokeText(location, startX, locationY + locationFontSize + 12);
      ctx.fillText(location, startX, locationY + locationFontSize + 12);
    }

    async function retakePhoto() {
      capturedImage.classList.add('hidden');
      videoSection.classList.remove('hidden');
      retakeControls.classList.add('hidden');
      captureControls.classList.remove('hidden');
      await startCamera();
    }

    function usePhoto() {
      const imageData = capturedImg.src;
      if (currentSection && currentCategory) {
        // Check if image with same category already exists
        const previewContainer = currentSection.querySelector('.preview-container');
        const existingImageDiv = Array.from(previewContainer.children).find(div => {
          return div.dataset.category === currentCategory;
        });

        if (existingImageDiv) {
          // Replace existing image
          console.log('Auto-replace mode: replacing existing image for category:', currentCategory);
          replaceImageWithData(existingImageDiv, imageData, currentCategory, null);
        } else {
          // Add new image
          console.log('Add mode: menambah gambar baru');
          addImageToPreview(imageData, currentSection, currentCategory);
        }
      }
      closeCamera();
    }

    // ========================================================================
    // FILE UPLOAD HANDLING
    // ========================================================================
    function handleLocalFiles(files, section, category) {
      // Validate inputs
      if (!section) {
        console.error('handleLocalFiles: section is null');
        return;
      }

      if (!files || files.length === 0) {
        console.log('handleLocalFiles: no files provided');
        return;
      }

      // Check if image with same category already exists
      const previewContainer = section.querySelector('.preview-container');

      if (!previewContainer) {
        console.error('handleLocalFiles: preview container not found');
        return;
      }

      const existingImageDiv = Array.from(previewContainer.children).find(div => {
        return div.dataset.category === category;
      });

      if (existingImageDiv && files.length === 1) {
        // Replace existing image
        const file = files[0];
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = e => {
            console.log('Auto-replace from upload: category =', category);
            replaceImageWithData(existingImageDiv, e.target.result, category, null);
          };
          reader.readAsDataURL(file);
        }
      } else {
        // Add new images
        console.log('Add from upload: menambah gambar baru');
        Array.from(files).forEach(file => {
          if (!file.type.startsWith('image/')) return;

          const reader = new FileReader();
          reader.onload = e => addImageToPreview(e.target.result, section, category);
          reader.readAsDataURL(file);
        });
      }
    }

    function showNotification(message) {
      const existingNotif = document.getElementById('editNotification');
      if (existingNotif) existingNotif.remove();

      const notification = document.createElement('div');
      notification.id = 'editNotification';
      notification.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 text-sm font-medium';
      notification.textContent = message;
      document.body.appendChild(notification);

      setTimeout(() => {
        notification.remove();
      }, 4000);
    }

    function replaceImageWithData(imageDiv, newImageData, category, position) {
      // Find the section from the imageDiv being replaced
      const section = imageDiv.closest('.image-upload-section');

      if (!section) {
        console.error('replaceImageWithData: could not find parent section');
        return;
      }

      console.log('replaceImageWithData called with position:', position);

      // Mark old image for deletion if it's an existing image
      if (imageDiv.classList.contains('existing-image')) {
        const imagePath = imageDiv.dataset.path;

        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_images[]';
        deleteInput.value = imagePath;
        document.getElementById('mainForm').appendChild(deleteInput);
      }

      // Remove the old image div from preview
      imageDiv.remove();

      // Add the new image to preview using the section we found
      addImageToPreview(newImageData, section, category);

      console.log('Image replaced - old removed, new added for category:', category, 'position:', position);
      showNotification('✓ Gambar berhasil diganti!');
    }

    function addImageToPreview(imageData, section, category) {
      // Validate inputs
      if (!section) {
        console.error('addImageToPreview: section is null');
        return;
      }

      console.log('addImageToPreview - category:', category);

      const previewContainer = section.querySelector('.preview-container');
      if (!previewContainer) {
        console.error('addImageToPreview: preview container not found');
        return;
      }

      const imageDiv = document.createElement('div');
      imageDiv.className = 'relative group new-image';
      imageDiv.dataset.category = category; // Store category for easy lookup

      const img = document.createElement('img');
      img.src = imageData;
      img.className = 'w-full h-20 object-cover rounded border';

      const deleteBtn = document.createElement('button');
      deleteBtn.type = 'button';
      deleteBtn.innerHTML = '×';
      deleteBtn.className =
        'absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition';
      deleteBtn.addEventListener('click', () => {
        imageDiv.remove();
        console.log('Image preview removed');
        // Trigger auto-save after image deletion
        triggerAutoSave();
      });

      // NO EDIT BUTTON - images auto-replace when adding new one

      const mainForm = document.getElementById('mainForm');
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'images[]';
      hiddenInput.value = JSON.stringify({
        data: imageData,
        category,
        timestamp: new Date().toISOString()
      });

      imageDiv.append(img, deleteBtn);
      mainForm.appendChild(hiddenInput);
      previewContainer.appendChild(imageDiv);

      console.log('Image added to preview for category:', category);

      // Trigger auto-save after image added
      triggerAutoSave();
    }

    function addEditButtonToExisting(imageDiv, section, category, index) {
      // NO LONGER NEEDED - Auto-replace functionality
      console.log('addEditButtonToExisting - skipped (auto-replace enabled)');

      // Add category to existing image div for auto-replace detection
      imageDiv.dataset.category = category;
    }
  }

    // Kombinasikan date dan time menjadi date_time sebelum submit
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('mainForm');
        const dateInput = document.getElementById('date_input');
        const timeInput = document.getElementById('time_input');
        const dateTimeHidden = document.getElementById('date_time_hidden');

        // Function untuk update date_time hidden field
        function updateDateTime() {
            const date = dateInput.value;
            const time = timeInput.value;

            if (date && time) {
                // Format: YYYY-MM-DD HH:MM:SS
                dateTimeHidden.value = date + ' ' + time + ':00';
            }
        }

        // Update saat date atau time berubah
        dateInput.addEventListener('change', updateDateTime);
        timeInput.addEventListener('change', updateDateTime);

        // Update saat form akan di-submit
        form.addEventListener('submit', function(e) {
            updateDateTime();

            // Validasi bahwa date_time sudah terisi
            if (!dateTimeHidden.value) {
                e.preventDefault();
                alert('Mohon isi tanggal dan waktu');
                return false;
            }
        });

        // Set initial value saat load
        updateDateTime();
    });

})();

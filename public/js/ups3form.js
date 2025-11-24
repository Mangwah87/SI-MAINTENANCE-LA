// ============================================================================
// UPS3 FORM HANDLER - COMPLETE VERSION WITH DATETIME FIX
// File: public/js/ups3form.js
// ============================================================================
(() => {
  'use strict';

  console.log('🚀 UPS3 Form Handler loading...');

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
    console.log('Initializing UPS3 Form Handler...');

    // ========================================================================
    // DATE TIME HANDLER - INITIALIZE FIRST!
    // ========================================================================
    initDateTimeHandler();

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
      console.error('Required camera elements not found');
      return;
    }

    // Initialize image upload sections
    document.querySelectorAll('.image-upload-section').forEach(section => {
      const categoryName = section.dataset.fieldName;
      const cameraBtn = section.querySelector('.camera-btn');
      const uploadBtn = section.querySelector('.upload-local-btn');
      const fileInput = section.querySelector('.file-input');

      if (cameraBtn) {
        cameraBtn.addEventListener('click', e => {
          e.preventDefault();
          currentCategory = categoryName;
          currentSection = section;
          openCamera();
        });
      }

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

      section.querySelectorAll('.delete-existing-btn').forEach(btn => {
        btn.addEventListener('click', e => {
          e.preventDefault();
          const imageDiv = btn.closest('.existing-image');
          const imagePath = imageDiv.dataset.path;
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = 'delete_images[]';
          hiddenInput.value = imagePath;
          document.getElementById('mainForm').appendChild(hiddenInput);
          imageDiv.remove();
        });
      });

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

    console.log('✅ UPS3 Form Handler initialized successfully');
  }

  // ==========================================================================
  // DATE TIME HANDLER FUNCTION
  // ==========================================================================
  function initDateTimeHandler() {
    console.log('📅 Initializing DateTime Handler...');

    const form = document.getElementById('mainForm');
    const dateInput = document.getElementById('ups3_date_input');
    const timeInput = document.getElementById('ups3_time_input');
    const dateTimeHidden = document.getElementById('ups3_date_time_hidden');

    if (!form) {
      console.error('❌ Form not found!');
      return;
    }

    if (!dateInput || !timeInput || !dateTimeHidden) {
      console.error('❌ DateTime inputs not found!');
      console.error('dateInput:', !!dateInput, 'timeInput:', !!timeInput, 'dateTimeHidden:', !!dateTimeHidden);
      return;
    }

    function updateDateTime() {
      const date = dateInput.value;
      const time = timeInput.value;

      if (date && time) {
        dateTimeHidden.value = `${date} ${time}:00`;
        console.log('✅ DateTime updated:', dateTimeHidden.value);
      } else {
        dateTimeHidden.value = '';
        console.warn('⚠️ DateTime not complete - date:', date, 'time:', time);
      }
    }

    // Event listeners
    dateInput.addEventListener('change', updateDateTime);
    timeInput.addEventListener('change', updateDateTime);
    dateInput.addEventListener('blur', updateDateTime);
    timeInput.addEventListener('blur', updateDateTime);

    // Form submit handler
    form.addEventListener('submit', function(e) {
      console.log('📤 Form submit event');

      // Force update
      updateDateTime();

      const dateTimeValue = dateTimeHidden.value;
      console.log('date_time value before submit:', dateTimeValue);

      // Validate
      if (!dateTimeValue || dateTimeValue.trim() === '') {
        e.preventDefault();
        e.stopPropagation();

        console.error('❌ Validation failed: date_time empty');
        alert('Mohon isi tanggal dan waktu dengan lengkap');

        if (!dateInput.value) {
          dateInput.focus();
          dateInput.classList.add('border-red-500');
        } else if (!timeInput.value) {
          timeInput.focus();
          timeInput.classList.add('border-red-500');
        }

        return false;
      }

      // Remove error styling
      dateInput.classList.remove('border-red-500');
      timeInput.classList.remove('border-red-500');

      // Disable submit button
      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn && !submitBtn.disabled) {
        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Menyimpan...';

        // Re-enable after 10 seconds (safety)
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.textContent = originalText;
        }, 10000);
      }

      console.log('✅ Form validation passed, submitting...');
      // Form will submit normally
    });

    // Set initial value
    updateDateTime();
    console.log('✅ DateTime Handler initialized');
  }

  // ==========================================================================
  // CAMERA FUNCTIONS
  // ==========================================================================

  async function openCamera() {
    const modal = document.getElementById('cameraModal');
    modal.classList.remove('hidden');

    try {
      await updateGeolocation();
      await startCamera();
    } catch (err) {
      alert('Gagal membuka kamera: ' + err.message);
      closeCamera();
    }
  }

  async function startCamera() {
    const video = document.getElementById('video');
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
    } catch (err) {
      throw new Error('Tidak dapat mengakses kamera: ' + err.message);
    }
  }

  function stopCamera() {
    const video = document.getElementById('video');
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
      currentStream = null;
    }
    video.srcObject = null;
  }

  function closeCamera() {
    const modal = document.getElementById('cameraModal');
    const capturedImage = document.getElementById('capturedImage');
    const videoSection = document.getElementById('videoSection');
    const retakeControls = document.getElementById('retakeControls');
    const captureControls = document.getElementById('captureControls');

    stopCamera();
    modal.classList.add('hidden');
    capturedImage.classList.add('hidden');
    videoSection.classList.remove('hidden');
    retakeControls.classList.add('hidden');
    captureControls.classList.remove('hidden');
    currentCategory = null;
    currentSection = null;
  }

  async function switchCamera() {
    currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
    await startCamera();
  }

  async function updateGeolocation() {
    const now = new Date();
    const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
    const witaTime = new Date(utcTime + (8 * 3600000));

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
          enableHighAccuracy: true,
          timeout: 15000,
          maximumAge: 0
        });
      });

      const lat = position.coords.latitude.toFixed(6);
      const lon = position.coords.longitude.toFixed(6);

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
            if (addr.road) locationParts.push(addr.road);
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

          location = locationParts.length > 0 ? locationParts.join(', ') : (data.display_name || fallback);
        }

        document.getElementById('location').textContent = location;
        currentGeoData.location = location;
        console.log(`✓ Berhasil menggunakan ${api.name}`);
        return; // Sukses, keluar dari loop

      } catch (error) {
        console.warn(`✗ ${api.name} gagal:`, error.message);
        // Lanjut ke API berikutnya
        if (i === geocodeAPIs.length - 1) {
          console.warn('Semua API geocoding gagal, menggunakan koordinat sebagai fallback');
        }
      }
    }
  }

  function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const capturedImg = document.getElementById('capturedImg');
    const videoSection = document.getElementById('videoSection');
    const capturedImage = document.getElementById('capturedImage');
    const captureControls = document.getElementById('captureControls');
    const retakeControls = document.getElementById('retakeControls');

    if (!video.videoWidth || !video.videoHeight) {
      alert('Video belum siap. Tunggu sebentar...');
      return;
    }

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');

    // Always draw without mirror - natural view
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    addWatermarkToCanvas(ctx, canvas.width, canvas.height);

    const imageData = canvas.toDataURL('image/jpeg', 0.92);
    capturedImg.src = imageData;

    videoSection.classList.add('hidden');
    capturedImage.classList.remove('hidden');
    captureControls.classList.add('hidden');
    retakeControls.classList.remove('hidden');

    stopCamera();
  }

  function addWatermarkToCanvas(ctx, width, height) {
    const { lat, lon, location, datetime } = currentGeoData;

    const parts = datetime.split(' ');
    const datePart = parts[0] || datetime;
    const timePart = parts[1] || '';
    const timeShort = timePart.substring(0, 5);

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

    const dateFontSize = Math.floor(width / 30);
    ctx.font = `bold ${dateFontSize}px Arial, sans-serif`;
    ctx.textBaseline = 'top';

    const dateY = baseY;

    ctx.strokeStyle = '#000000';
    ctx.lineWidth = 7;
    ctx.lineJoin = 'round';
    ctx.strokeText(formattedDate, startX, dateY);
    ctx.fillStyle = '#FFFFFF';
    ctx.fillText(formattedDate, startX, dateY);

    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const now = new Date();
    const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
    const witaDate = new Date(utcTime + (8 * 3600000));
    const dayName = days[witaDate.getDay()];

    ctx.strokeText(dayName, startX, dateY + dateFontSize + 8);
    ctx.fillText(dayName, startX, dateY + dateFontSize + 8);

    const timeFontSize = Math.floor(width / 8);
    const startY = dateY + (dateFontSize * 2) + 30;

    ctx.font = `bold ${timeFontSize}px Arial, sans-serif`;
    ctx.strokeStyle = '#000000';
    ctx.lineWidth = 14;
    ctx.strokeText(timeShort, startX, startY);
    ctx.fillStyle = '#FFFFFF';
    ctx.fillText(timeShort, startX, startY);

    const timeWidth = ctx.measureText(timeShort).width;
    const witaFontSize = Math.floor(width / 20);
    ctx.font = `bold ${witaFontSize}px Arial, sans-serif`;

    const witaX = startX + timeWidth + 20;
    const witaY = startY + (timeFontSize - witaFontSize) / 2;

    ctx.lineWidth = 8;
    ctx.strokeText('WITA', witaX, witaY);
    ctx.fillText('WITA', witaX, witaY);

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
    const capturedImage = document.getElementById('capturedImage');
    const videoSection = document.getElementById('videoSection');
    const retakeControls = document.getElementById('retakeControls');
    const captureControls = document.getElementById('captureControls');

    capturedImage.classList.add('hidden');
    videoSection.classList.remove('hidden');
    retakeControls.classList.add('hidden');
    captureControls.classList.remove('hidden');
    await startCamera();
  }

  function usePhoto() {
    const capturedImg = document.getElementById('capturedImg');
    const imageData = capturedImg.src;

    if (currentSection && currentCategory) {
      // Check if image with same category already exists
      const previewContainer = currentSection.querySelector('.preview-container');
      const existingImageDiv = Array.from(previewContainer.children).find(div => {
        return div.dataset.category === currentCategory;
      });

      if (existingImageDiv) {
        // Replace existing image
        replaceImageWithData(existingImageDiv, imageData, currentCategory, null);
      } else {
        // Add new image
        addImageToPreview(imageData, currentSection, currentCategory);
      }
    }
    closeCamera();
  }

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
          replaceImageWithData(existingImageDiv, e.target.result, category, null);
        };
        reader.readAsDataURL(file);
      }
    } else {
      // Add new images
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

    showNotification('✓ Gambar berhasil diganti!');
  }

  function addImageToPreview(imageData, section, category) {
    // Validate inputs
    if (!section) {
      console.error('addImageToPreview: section is null');
      return;
    }

    const previewContainer = section.querySelector('.preview-container');
    if (!previewContainer) {
      console.error('addImageToPreview: preview container not found');
      return;
    }

    const imageDiv = document.createElement('div');
    imageDiv.className = 'relative group';
    imageDiv.dataset.category = category; // Store category for easy lookup

    const img = document.createElement('img');
    img.src = imageData;
    img.className = 'w-full h-20 object-cover rounded border';

    const deleteBtn = document.createElement('button');
    deleteBtn.type = 'button';
    deleteBtn.innerHTML = '×';
    deleteBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition';
    deleteBtn.addEventListener('click', () => imageDiv.remove());

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
  }

  function addEditButtonToExisting(imageDiv, section, category, index) {
    // NO LONGER NEEDED - Auto-replace functionality
    // Add category to existing image div for auto-replace detection
    imageDiv.dataset.category = category;
  }

})();

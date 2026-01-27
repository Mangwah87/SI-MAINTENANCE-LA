// ============================================================================
// POLE FORM CAMERA HANDLER - WITA VERSION WITH WATERMARK
// File: public/js/poleform.js
// ============================================================================
(() => {
  'use strict';

  console.log('Pole Form Handler loading...');

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
  const DB_NAME = 'PoleFormDB';
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
    console.log('Initializing Pole Form Handler...');

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
    initializeImageSections();

    // ------------------------------------------------------------------------
    // CAMERA BUTTON HANDLERS
    // ------------------------------------------------------------------------
    document.querySelectorAll('.camera-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const section = this.closest('.image-upload-section');
        const fieldName = section.dataset.fieldName;
        const category = section.dataset.category || 'pole';
        currentSection = section;
        currentCategory = category;
        currentReplaceTarget = null;
        currentReplacePosition = null;
        openCameraModal();
      });
    });

    // ------------------------------------------------------------------------
    // LOCAL UPLOAD BUTTON HANDLERS
    // ------------------------------------------------------------------------
    document.querySelectorAll('.upload-local-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const section = this.closest('.image-upload-section');
        const fileInput = section.querySelector('.file-input');
        if (fileInput) {
          fileInput.click();
        }
      });
    });

    // ------------------------------------------------------------------------
    // FILE INPUT CHANGE HANDLERS
    // ------------------------------------------------------------------------
    document.querySelectorAll('.file-input').forEach(input => {
      input.addEventListener('change', function(e) {
        const section = this.closest('.image-upload-section');
        handleLocalFiles(e.target.files, section);
        this.value = ''; // Reset input
      });
    });

    // ------------------------------------------------------------------------
    // MODAL CONTROLS
    // ------------------------------------------------------------------------
    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', closeCameraModal);
    }

    if (captureBtn) {
      captureBtn.addEventListener('click', capturePhoto);
    }

    if (switchCameraBtn) {
      switchCameraBtn.addEventListener('click', switchCamera);
    }

    if (retakeBtn) {
      retakeBtn.addEventListener('click', retakePhoto);
    }

    if (usePhotoBtn) {
      usePhotoBtn.addEventListener('click', usePhoto);
    }

    // Close modal on backdrop click
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        closeCameraModal();
      }
    });

    console.log('Pole Form Handler initialized successfully');
  }

  // --------------------------------------------------------------------------
  // INITIALIZE IMAGE SECTIONS
  // --------------------------------------------------------------------------
  function initializeImageSections() {
    document.querySelectorAll('.image-upload-section').forEach(section => {
      const fieldName = section.dataset.fieldName;
      const hiddenInput = section.querySelector(`input[name="${fieldName}"]`);

      if (!hiddenInput) {
        // Create hidden input for storing base64 images
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = fieldName;
        input.value = '[]';
        section.appendChild(input);
      }

      // Initialize delete buttons for new images
      initializeDeleteButtons(section);
    });
  }

  // --------------------------------------------------------------------------
  // DELETE BUTTON HANDLERS
  // --------------------------------------------------------------------------
  function initializeDeleteButtons(section) {
    // For new images
    section.querySelectorAll('.delete-btn').forEach(btn => {
      btn.replaceWith(btn.cloneNode(true));
    });

    section.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const imageDiv = this.closest('.preview-item, .relative');
        const position = parseInt(imageDiv.dataset.position);

        if (!isNaN(position)) {
          removeImageAtPosition(section, position);
        }

        imageDiv.remove();
        triggerAutoSave();
      });
    });

    // For existing images
    section.querySelectorAll('.delete-existing-btn').forEach(btn => {
      btn.replaceWith(btn.cloneNode(true));
    });

    section.querySelectorAll('.delete-existing-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        if (confirm('Hapus gambar ini?')) {
          const imageDiv = this.closest('.existing-image');
          const path = imageDiv.dataset.path;

          // Add to deletion list
          let deletionInput = section.querySelector('input[name$="_deleted"]');
          if (!deletionInput) {
            deletionInput = document.createElement('input');
            deletionInput.type = 'hidden';
            deletionInput.name = section.dataset.fieldName + '_deleted';
            deletionInput.value = '[]';
            section.appendChild(deletionInput);
          }

          let deletedPaths = JSON.parse(deletionInput.value);
          deletedPaths.push(path);
          deletionInput.value = JSON.stringify(deletedPaths);

          imageDiv.remove();
          triggerAutoSave();
        }
      });
    });

    // Replace button handlers
    section.querySelectorAll('.replace-btn').forEach(btn => {
      btn.replaceWith(btn.cloneNode(true));
    });

    section.querySelectorAll('.replace-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const imageDiv = this.closest('.preview-item, .relative');
        const position = parseInt(imageDiv.dataset.position);

        currentSection = section;
        currentCategory = section.dataset.category || 'pole';
        currentReplaceTarget = imageDiv;
        currentReplacePosition = position;

        openCameraModal();
      });
    });
  }

  // --------------------------------------------------------------------------
  // HANDLE LOCAL FILES
  // --------------------------------------------------------------------------
  function handleLocalFiles(files, section) {
    if (files.length === 0) return;

    Array.from(files).forEach(file => {
      if (!file.type.startsWith('image/')) {
        alert('Hanya file gambar yang diperbolehkan');
        return;
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        addImageToSection(section, e.target.result, false);
      };
      reader.readAsDataURL(file);
    });
  }

  // --------------------------------------------------------------------------
  // ADD IMAGE TO SECTION
  // --------------------------------------------------------------------------
  function addImageToSection(section, base64Data, fromCamera = false) {
    const fieldName = section.dataset.fieldName;
    const hiddenInput = section.querySelector(`input[name="${fieldName}"]`);

    if (!hiddenInput) return;

    let images = [];
    try {
      images = JSON.parse(hiddenInput.value);
    } catch (e) {
      images = [];
    }

    if (currentReplaceTarget && !isNaN(currentReplacePosition)) {
      // Replace existing image
      images[currentReplacePosition] = base64Data;

      const img = currentReplaceTarget.querySelector('img');
      if (img) {
        img.src = base64Data;
      }

      currentReplaceTarget = null;
      currentReplacePosition = null;
    } else {
      // Add new image
      images.push(base64Data);

      const previewContainer = section.querySelector('.preview-container');
      if (previewContainer) {
        const position = images.length - 1;
        const imageDiv = document.createElement('div');
        imageDiv.className = 'relative group preview-item';
        imageDiv.dataset.position = position;
        imageDiv.innerHTML = `
          <img src="${base64Data}" class="w-full h-20 object-cover rounded border">
          <button type="button" class="delete-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition">×</button>
          <button type="button" class="replace-btn absolute bottom-1 right-1 bg-blue-500 text-white rounded px-2 py-0.5 text-xs opacity-0 group-hover:opacity-100 transition">Ganti</button>
        `;
        previewContainer.appendChild(imageDiv);

        initializeDeleteButtons(section);
      }
    }

    hiddenInput.value = JSON.stringify(images);
    triggerAutoSave();
  }

  // --------------------------------------------------------------------------
  // REMOVE IMAGE AT POSITION
  // --------------------------------------------------------------------------
  function removeImageAtPosition(section, position) {
    const fieldName = section.dataset.fieldName;
    const hiddenInput = section.querySelector(`input[name="${fieldName}"]`);

    if (!hiddenInput) return;

    let images = [];
    try {
      images = JSON.parse(hiddenInput.value);
    } catch (e) {
      images = [];
    }

    images.splice(position, 1);
    hiddenInput.value = JSON.stringify(images);

    // Update positions
    section.querySelectorAll('.preview-item').forEach((item, index) => {
      item.dataset.position = index;
    });
  }

  // --------------------------------------------------------------------------
  // CAMERA MODAL FUNCTIONS
  // --------------------------------------------------------------------------
  function openCameraModal() {
    const modal = document.getElementById('cameraModal');
    const videoSection = document.getElementById('videoSection');
    const capturedImage = document.getElementById('capturedImage');
    const captureControls = document.getElementById('captureControls');
    const retakeControls = document.getElementById('retakeControls');

    modal.classList.remove('hidden');
    videoSection.classList.remove('hidden');
    capturedImage.classList.add('hidden');
    captureControls.classList.remove('hidden');
    retakeControls.classList.add('hidden');

    startCamera();
    startLocationTracking();
  }

  function closeCameraModal() {
    const modal = document.getElementById('cameraModal');
    modal.classList.add('hidden');
    stopCamera();
  }

  function startCamera() {
    const video = document.getElementById('video');

    const constraints = {
      video: {
        facingMode: currentFacingMode,
        width: { ideal: 1920 },
        height: { ideal: 1080 }
      }
    };

    navigator.mediaDevices.getUserMedia(constraints)
      .then(stream => {
        currentStream = stream;
        video.srcObject = stream;
        video.play();
      })
      .catch(err => {
        console.error('Camera error:', err);
        alert('Tidak dapat mengakses kamera: ' + err.message);
      });
  }

  function stopCamera() {
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
      currentStream = null;
    }
  }

  function switchCamera() {
    currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
    stopCamera();
    startCamera();
  }

  function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const capturedImg = document.getElementById('capturedImg');
    const videoSection = document.getElementById('videoSection');
    const capturedImage = document.getElementById('capturedImage');
    const captureControls = document.getElementById('captureControls');
    const retakeControls = document.getElementById('retakeControls');

    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    // Draw video frame
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Add watermark
    addWatermark(context, canvas);

    // Show captured image
    const imageData = canvas.toDataURL('image/jpeg', 0.85);
    capturedImg.src = imageData;

    videoSection.classList.add('hidden');
    capturedImage.classList.remove('hidden');
    captureControls.classList.add('hidden');
    retakeControls.classList.remove('hidden');

    stopCamera();
  }

  function retakePhoto() {
    const videoSection = document.getElementById('videoSection');
    const capturedImage = document.getElementById('capturedImage');
    const captureControls = document.getElementById('captureControls');
    const retakeControls = document.getElementById('retakeControls');

    videoSection.classList.remove('hidden');
    capturedImage.classList.add('hidden');
    captureControls.classList.remove('hidden');
    retakeControls.classList.add('hidden');

    startCamera();
  }

  function usePhoto() {
    const capturedImg = document.getElementById('capturedImg');
    const imageData = capturedImg.src;

    if (currentSection && imageData) {
      addImageToSection(currentSection, imageData, true);
    }

    closeCameraModal();
  }

  // --------------------------------------------------------------------------
  // ADD WATERMARK
  // --------------------------------------------------------------------------
  function addWatermark(ctx, canvas) {
    const padding = 10;
    const lineHeight = 20;
    const fontSize = 14;

    ctx.font = `${fontSize}px Arial`;
    ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.8)';
    ctx.lineWidth = 3;

    const lines = [
      `📍 ${currentGeoData.lat}, ${currentGeoData.lon}`,
      `📌 ${currentGeoData.location}`,
      `🕒 ${currentGeoData.datetime}`
    ];

    let y = canvas.height - padding - (lines.length * lineHeight);

    lines.forEach(line => {
      ctx.strokeText(line, padding, y);
      ctx.fillText(line, padding, y);
      y += lineHeight;
    });
  }

  // --------------------------------------------------------------------------
  // LOCATION TRACKING
  // --------------------------------------------------------------------------
  function startLocationTracking() {
    if (!navigator.geolocation) {
      console.warn('Geolocation not supported');
      return;
    }

    navigator.geolocation.getCurrentPosition(
      position => {
        currentGeoData.lat = position.coords.latitude.toFixed(6);
        currentGeoData.lon = position.coords.longitude.toFixed(6);

        // Get location name (simplified)
        currentGeoData.location = `${currentGeoData.lat}, ${currentGeoData.lon}`;

        updateDateTime();
      },
      error => {
        console.warn('Geolocation error:', error);
        currentGeoData.lat = '-';
        currentGeoData.lon = '-';
        currentGeoData.location = 'Lokasi tidak tersedia';
        updateDateTime();
      }
    );
  }

  function updateDateTime() {
    const now = new Date();

    // WITA = UTC+8
    const witaOffset = 8 * 60;
    const localOffset = now.getTimezoneOffset();
    const witaTime = new Date(now.getTime() + (witaOffset + localOffset) * 60000);

    const year = witaTime.getFullYear();
    const month = String(witaTime.getMonth() + 1).padStart(2, '0');
    const day = String(witaTime.getDate()).padStart(2, '0');
    const hours = String(witaTime.getHours()).padStart(2, '0');
    const minutes = String(witaTime.getMinutes()).padStart(2, '0');
    const seconds = String(witaTime.getSeconds()).padStart(2, '0');

    currentGeoData.datetime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds} WITA`;
  }

  // --------------------------------------------------------------------------
  // AUTO-SAVE FUNCTIONS
  // --------------------------------------------------------------------------
  function initAutoSave() {
    console.log('Auto-save initialized');

    // Listen for image changes
    document.addEventListener('formImageChanged', () => {
      console.log('Form image changed, triggering auto-save...');
    });
  }

})();

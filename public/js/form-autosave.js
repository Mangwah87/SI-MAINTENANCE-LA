/**
 * Form Auto-Save Module with IndexedDB
 * Menyimpan dan memulihkan data form + foto menggunakan IndexedDB
 */

// Konfigurasi
const FORM_STORAGE_KEY = "pm_shelter_form_draft";
const AUTOSAVE_DELAY = 1000; // 1 detik setelah user berhenti mengetik

// IndexedDB Configuration
let dbInstance = null;
const DB_NAME = "PMShelterDB";
const DB_VERSION = 1;
const STORE_NAME = "formDrafts";

// Debounce timeout
let saveTimeout;

// ============================================================================
// INDEXEDDB INITIALIZATION
// ============================================================================
function initIndexedDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);

        request.onerror = () => {
            console.error("IndexedDB: Failed to open database");
            reject(request.error);
        };

        request.onsuccess = () => {
            dbInstance = request.result;
            console.log("✅ IndexedDB: Connected");
            resolve(dbInstance);
        };

        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME)) {
                db.createObjectStore(STORE_NAME, { keyPath: "id" });
                console.log("✅ IndexedDB: Object store created");
            }
        };
    });
}

async function saveToIndexedDB(key, data) {
    if (!dbInstance) {
        await initIndexedDB();
    }

    return new Promise((resolve, reject) => {
        const transaction = dbInstance.transaction([STORE_NAME], "readwrite");
        const store = transaction.objectStore(STORE_NAME);
        const request = store.put({
            id: key,
            data: data,
            timestamp: new Date().toISOString(),
        });

        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
    });
}

async function getFromIndexedDB(key) {
    if (!dbInstance) {
        await initIndexedDB();
    }

    return new Promise((resolve, reject) => {
        const transaction = dbInstance.transaction([STORE_NAME], "readonly");
        const store = transaction.objectStore(STORE_NAME);
        const request = store.get(key);

        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function deleteFromIndexedDB(key) {
    if (!dbInstance) {
        await initIndexedDB();
    }

    return new Promise((resolve, reject) => {
        const transaction = dbInstance.transaction([STORE_NAME], "readwrite");
        const store = transaction.objectStore(STORE_NAME);
        const request = store.delete(key);

        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
    });
}

// ============================================================================
// FORM AUTO-SAVE FUNCTIONS
// ============================================================================

// Fungsi untuk menyimpan form ke IndexedDB
async function saveFormData() {
    const formData = {};
    const form = document.getElementById("pmForm");

    if (!form) return;

    // Simpan semua input text, textarea, date, time
    form.querySelectorAll(
        'input[type="text"], input[type="date"], input[type="time"], textarea'
    ).forEach((input) => {
        if (input.name && input.name !== "_token" && input.name !== "_method") {
            formData[input.name] = input.value;
        }
    });

    // Simpan semua select
    form.querySelectorAll("select").forEach((select) => {
        if (select.name) {
            formData[select.name] = select.value;
        }
    });

    // Simpan radio buttons yang dipilih
    form.querySelectorAll('input[type="radio"]:checked').forEach((radio) => {
        if (radio.name) {
            formData[radio.name] = radio.value;
        }
    });

    // Simpan executor fields
    const executors = [];
    form.querySelectorAll("#executor-fields > .border").forEach(
        (executorDiv, index) => {
            const executor = {
                name:
                    executorDiv.querySelector(
                        `input[name="executors[${index}][name]"]`
                    )?.value || "",
                department:
                    executorDiv.querySelector(
                        `input[name="executors[${index}][department]"]`
                    )?.value || "",
                sub_department:
                    executorDiv.querySelector(
                        `input[name="executors[${index}][sub_department]"]`
                    )?.value || "",
            };
            executors.push(executor);
        }
    );
    formData.executors = executors;

    // Simpan foto dari photoManagers
    const photosData = await savePhotosData();

    const draftData = {
        formFields: formData,
        images: photosData,
        timestamp: new Date().toISOString(),
    };

    try {
        await saveToIndexedDB(FORM_STORAGE_KEY, draftData);
        console.log("💾 Auto-Save: Data + Photos saved", {
            fields: Object.keys(formData).length,
            images: photosData.length,
        });
    } catch (error) {
        console.error("Auto-Save: Failed to save", error);
    }
}

// Fungsi untuk menyimpan foto
async function savePhotosData() {
    const images = [];

    // Check if photoManagers exists (defined in blade file)
    if (typeof window.photoManagers === "undefined") {
        console.log("photoManagers not yet defined");
        return images;
    }

    // Loop through all photo managers
    Object.keys(window.photoManagers).forEach((managerKey) => {
        const manager = window.photoManagers[managerKey];
        if (manager && manager.photos && manager.photos.length > 0) {
            manager.photos.forEach((photo) => {
                images.push({
                    category: managerKey,
                    name: photo.name || "photo.jpg",
                    data: photo.data,
                    timestamp: photo.timestamp || Date.now(),
                    metadata: photo.metadata || {
                        taken_at: new Date().toISOString(),
                        size: photo.data?.length || 0,
                        type: "image/jpeg",
                    },
                });
            });
        }
    });

    return images;
}

// Fungsi untuk memuat data dari IndexedDB
async function loadFormData() {
    try {
        const savedDraft = await getFromIndexedDB(FORM_STORAGE_KEY);

        if (!savedDraft || !savedDraft.data) {
            console.log("Auto-Save: No saved data found");
            return;
        }

        const { data } = savedDraft;
        const form = document.getElementById("pmForm");

        if (!form) return;

        console.log("📦 Found saved draft:", {
            fields: data.formFields ? Object.keys(data.formFields).length : 0,
            images: data.images ? data.images.length : 0,
        });

        // Restore form fields
        if (data.formFields) {
            Object.keys(data.formFields).forEach((key) => {
                if (key === "executors") return; // Handle executors separately

                const element = form.querySelector(`[name="${key}"]`);
                if (element) {
                    if (element.type === "radio") {
                        const radio = form.querySelector(
                            `[name="${key}"][value="${data.formFields[key]}"]`
                        );
                        if (radio) radio.checked = true;
                    } else {
                        element.value = data.formFields[key];
                    }
                }
            });

            // Restore executors
            if (
                data.formFields.executors &&
                data.formFields.executors.length > 0
            ) {
                if (
                    typeof executorIndex !== "undefined" &&
                    typeof addExecutorField === "function"
                ) {
                    const executorFields =
                        document.getElementById("executor-fields");
                    if (executorFields) {
                        executorFields.innerHTML = "";
                        executorIndex = 0;

                        data.formFields.executors.forEach((executor) => {
                            addExecutorField();
                            const lastExecutor = document.querySelector(
                                "#executor-fields > .border:last-child"
                            );
                            if (lastExecutor) {
                                const nameInput = lastExecutor.querySelector(
                                    'input[name*="[name]"]'
                                );
                                const deptInput = lastExecutor.querySelector(
                                    'input[name*="[department]"]'
                                );
                                const subDeptInput = lastExecutor.querySelector(
                                    'input[name*="[sub_department]"]'
                                );

                                if (nameInput) nameInput.value = executor.name;
                                if (deptInput)
                                    deptInput.value = executor.department;
                                if (subDeptInput)
                                    subDeptInput.value =
                                        executor.sub_department;
                            }
                        });
                    }
                }
            }
        }

        console.log("Form data restored, waiting for PhotoManagers...");

        // Restore photos - tunggu sampai PhotoManager benar-benar ready
        let attempts = 0;
        const maxAttempts = 20;

        const waitForPhotoManagers = setInterval(() => {
            attempts++;

            if (
                typeof window.photoManagers !== "undefined" &&
                Object.keys(window.photoManagers).length > 0
            ) {
                const allReady = Object.keys(window.photoManagers).every(
                    (key) => {
                        const manager = window.photoManagers[key];
                        return manager && manager.container;
                    }
                );

                if (allReady) {
                    clearInterval(waitForPhotoManagers);
                    console.log("PhotoManagers ready, loading photos...");
                    loadPhotosData(data.images);
                }
            }

            if (attempts >= maxAttempts) {
                clearInterval(waitForPhotoManagers);
                console.warn("Timeout waiting for PhotoManagers");
                loadPhotosData(data.images);
            }
        }, 100);
    } catch (e) {
        console.error("Error loading saved form data:", e);
    }
}

// Fungsi untuk memuat foto
function loadPhotosData(images) {
    if (!images || images.length === 0) {
        console.log("No photos to restore");
        return;
    }

    try {
        if (typeof window.photoManagers === "undefined") {
            console.warn("photoManagers not found");
            return;
        }

        let loadedCount = 0;

        images.forEach((imageInfo) => {
            const managerKey = imageInfo.category;

            if (window.photoManagers[managerKey]) {
                const manager = window.photoManagers[managerKey];

                // Add photo to manager
                const photo = {
                    name: imageInfo.name || "photo.jpg",
                    data: imageInfo.data,
                    timestamp: imageInfo.timestamp || Date.now(),
                    metadata: imageInfo.metadata || {
                        taken_at: new Date().toISOString(),
                        size: imageInfo.data?.length || 0,
                        type: "image/jpeg",
                    },
                };

                manager.photos.push(photo);
                loadedCount++;
            }
        });

        // Re-render all photo managers
        Object.keys(window.photoManagers).forEach((key) => {
            const manager = window.photoManagers[key];
            if (manager && manager.photos.length > 0) {
                try {
                    if (typeof manager.renderPhotos === "function") {
                        manager.renderPhotos();
                    } else if (typeof manager.render === "function") {
                        manager.render();
                    }
                } catch (err) {
                    console.error(`Error rendering ${key}:`, err);
                }
            }
        });

        console.log(
            `✅ Photos loaded successfully: ${loadedCount} photos restored`
        );
    } catch (e) {
        console.error("Error loading photos:", e);
    }
}

// Fungsi untuk menghapus data yang tersimpan
async function clearSavedFormData() {
    try {
        await deleteFromIndexedDB(FORM_STORAGE_KEY);
        console.log("✅ Auto-Save: Data cleared");
    } catch (error) {
        console.error("Error clearing saved data:", error);
    }
}

// Debounce function untuk mengurangi frequency penyimpanan
function debouncedSave() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(saveFormData, AUTOSAVE_DELAY);
}

// Listen untuk photo change events
function setupPhotoChangeListener() {
    document.addEventListener("photoChanged", function () {
        debouncedSave();
    });
}

// Initialize auto-save
async function initFormAutoSave() {
    const form = document.getElementById("pmForm");

    if (!form) {
        console.warn(
            'Form with id "pmForm" not found. Auto-save not initialized.'
        );
        return;
    }

    // Initialize IndexedDB
    try {
        await initIndexedDB();
    } catch (error) {
        console.error("Failed to initialize IndexedDB:", error);
        return;
    }

    // Load saved data saat halaman dimuat
    await loadFormData();

    // Auto-save saat user mengetik/memilih
    form.addEventListener("input", debouncedSave);
    form.addEventListener("change", debouncedSave);

    // Setup photo change listener
    setupPhotoChangeListener();

    // Hapus saved data saat form berhasil disubmit
    form.addEventListener("submit", function () {
        setTimeout(clearSavedFormData, 500);
    });

    console.log("✅ Form auto-save initialized successfully");
}

// Auto-initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initFormAutoSave);
} else {
    initFormAutoSave();
}

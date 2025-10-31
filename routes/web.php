<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpsMaintenanceController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\PMShelterController;
use App\Http\Controllers\FollowUpRequestController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\RectifierMaintenanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //PM shelter
    Route::prefix('pm-shelter')->name('pm-shelter.')->group(function () {
        Route::get('/', [PmShelterController::class, 'index'])->name('index');
        Route::get('/create', [PmShelterController::class, 'create'])->name('create');
        Route::post('/', [PmShelterController::class, 'store'])->name('store');
        Route::get('/{pmShelter}', [PmShelterController::class, 'show'])->name('show');
        Route::get('/{pmShelter}/edit', [PmShelterController::class, 'edit'])->name('edit');
        Route::put('/{pmShelter}', [PmShelterController::class, 'update'])->name('update');
        Route::delete('/{pmShelter}', [PmShelterController::class, 'destroy'])->name('destroy');
        Route::delete('/{pmShelter}/photo/{index}', [PmShelterController::class, 'deletePhoto'])->name('photo.delete');
        Route::get('/{pmShelter}/export-pdf', [PmShelterController::class, 'exportPdf'])->name('export-pdf');
    });
    // UPS3 Maintenance routes (Grouped under 'ups3' prefix)
    Route::prefix('ups3')->name('ups3.')->group(function () {
        Route::get('/', [UpsMaintenanceController::class, 'index'])->name('index');
        Route::get('/create', [UpsMaintenanceController::class, 'create'])->name('create');
        Route::post('/', [UpsMaintenanceController::class, 'store'])->name('store');
        Route::get('/{upsMaintenance}', [UpsMaintenanceController::class, 'show'])->name('show');
        Route::get('/{upsMaintenance}/edit', [UpsMaintenanceController::class, 'edit'])->name('edit');
        Route::put('/{upsMaintenance}', [UpsMaintenanceController::class, 'update'])->name('update');
        Route::delete('/{upsMaintenance}', [UpsMaintenanceController::class, 'destroy'])->name('destroy');
        Route::get('/{upsMaintenance}/print', [UpsMaintenanceController::class, 'print'])->name('print');
    });

    // Battery Routes
    Route::prefix('battery')->name('battery.')->group(function () {
        Route::get('/', [BatteryController::class, 'index'])->name('index');
        Route::get('/create', [BatteryController::class, 'create'])->name('create');
        Route::post('/', [BatteryController::class, 'store'])->name('store');
        Route::get('/{id}', [BatteryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BatteryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BatteryController::class, 'update'])->name('update');
        Route::delete('/{id}', [BatteryController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [BatteryController::class, 'pdf'])->name('pdf');
    });

    // Rectifier Maintenance routes
    Route::prefix('rectifier')->name('rectifier.')->middleware('auth')->group(function () {
        Route::get('/', [RectifierMaintenanceController::class, 'index'])->name('index');
        Route::get('/create', [RectifierMaintenanceController::class, 'create'])->name('create');
        Route::post('/', [RectifierMaintenanceController::class, 'store'])->name('store');
        Route::get('/{id}', [RectifierMaintenanceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [RectifierMaintenanceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RectifierMaintenanceController::class, 'update'])->name('update');
        Route::delete('/{id}', [RectifierMaintenanceController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/export-pdf', [RectifierMaintenanceController::class, 'exportPdf'])->name('export-pdf');


        // 🔍 TAMBAHAN UNTUK DEBUGGING
        Route::get('/{id}/debug-images', [RectifierMaintenanceController::class, 'debugImages'])->name('debug-images');
        Route::get('/{id}/preview-pdf', [RectifierMaintenanceController::class, 'previewPdf'])->name('preview-pdf');
    });

    // Follow Up Request Routes
    Route::prefix('followup')->name('followup.')->group(function () {
        Route::get('/', [FollowUpRequestController::class, 'index'])->name('index');
        Route::get('/create', [FollowUpRequestController::class, 'create'])->name('create');
        Route::post('/', [FollowUpRequestController::class, 'store'])->name('store');
        Route::get('/{id}', [FollowUpRequestController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [FollowUpRequestController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FollowUpRequestController::class, 'update'])->name('update');
        Route::delete('/{id}', [FollowUpRequestController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [FollowUpRequestController::class, 'pdf'])->name('pdf');
    });

    // Tindak Lanjut Routes
    Route::resource('tindak-lanjut', TindakLanjutController::class);
    Route::get('tindak-lanjut/{tindakLanjut}/pdf', [TindakLanjutController::class, 'generatePdf'])
        ->name('tindak-lanjut.pdf');
});

require __DIR__ . '/auth.php';

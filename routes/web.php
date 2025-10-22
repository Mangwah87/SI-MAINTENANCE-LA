<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpsMaintenanceController;
use App\Http\Controllers\BatteryController;
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
});

require __DIR__ . '/auth.php';

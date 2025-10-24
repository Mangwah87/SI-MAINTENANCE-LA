<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\GensetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cek-phpinfo', function () {
    phpinfo();
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
    // Genset Routes (NEW)
    Route::prefix('genset')->name('genset.')->group(function () {
        Route::get('/', [GensetController::class, 'index'])->name('index');
        Route::get('/create', [GensetController::class, 'create'])->name('create');
        Route::post('/', [GensetController::class, 'store'])->name('store');
        Route::get('/{id}', [GensetController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GensetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GensetController::class, 'update'])->name('update');
        Route::delete('/{id}', [GensetController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [GensetController::class, 'pdf'])->name('pdf');
    });
    
});

require __DIR__ . '/auth.php';

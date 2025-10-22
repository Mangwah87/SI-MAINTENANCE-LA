<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpsMaintenanceController;
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

    // UPS Maintenance routes
    Route::get('/ups', [UpsMaintenanceController::class, 'index'])->name('ups');
    Route::get('/ups/create', [UpsMaintenanceController::class, 'create'])->name('ups.create');
    Route::post('/ups', [UpsMaintenanceController::class, 'store'])->name('ups.store');
    Route::get('/ups/{upsMaintenance}', [UpsMaintenanceController::class, 'show'])->name('ups.show');
    Route::get('/ups/{upsMaintenance}/edit', [UpsMaintenanceController::class, 'edit'])->name('ups.edit');
    Route::put('/ups/{upsMaintenance}', [UpsMaintenanceController::class, 'update'])->name('ups.update');
    Route::delete('/ups/{upsMaintenance}', [UpsMaintenanceController::class, 'destroy'])->name('ups.destroy');
    Route::get('/ups/{upsMaintenance}/print', [UpsMaintenanceController::class, 'print'])->name('ups.print');
});

require __DIR__.'/auth.php';

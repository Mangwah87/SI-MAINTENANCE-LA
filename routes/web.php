<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PMShelterController;
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

    //PM shelter
    Route::get('pm-shelter/{pmShelter}/pdf', [PMShelterController::class, 'exportPdf'])
        ->name('pm-shelter.pdf');

    Route::resource('pm-shelter', PMShelterController::class);

});



require __DIR__ . '/auth.php';

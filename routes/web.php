<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpsMaintenanceController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\PMShelterController;
use App\Http\Controllers\FollowUpRequestController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\InverterController;
use App\Http\Controllers\DokumentasiController;
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


    // PM Shelter Routes
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


    // UPS3 Maintenance Routes
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


    // Inverter Routes
    Route::prefix('inverter')->name('inverter.')->group(function () {
        Route::get('/', [InverterController::class, 'index'])->name('index');
        Route::get('/create', [InverterController::class, 'create'])->name('create');
        Route::post('/', [InverterController::class, 'store'])->name('store');
        Route::get('/{id}', [InverterController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InverterController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InverterController::class, 'update'])->name('update');
        Route::delete('/{id}', [InverterController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [InverterController::class, 'generatePdf'])->name('pdf');
    });


    // Dokumentasi Routes
    Route::prefix('dokumentasi')->name('dokumentasi.')->group(function () {
        Route::get('/', [DokumentasiController::class, 'index'])->name('index');
        Route::get('/create', [DokumentasiController::class, 'create'])->name('create');
        Route::post('/', [DokumentasiController::class, 'store'])->name('store');
        Route::get('/{id}', [DokumentasiController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DokumentasiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DokumentasiController::class, 'update'])->name('update');
        Route::delete('/{id}', [DokumentasiController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [DokumentasiController::class, 'generatePdf'])->name('pdf');
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

<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GensetController;
use App\Http\Controllers\UpsMaintenanceController;
use App\Http\Controllers\UpsMaintenance1Controller;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\PMShelterController;
use App\Http\Controllers\FollowUpRequestController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\AcMaintenanceConrtoller;
use App\Http\Controllers\GroundingController;
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

    // UPS1 Maintenance routes (Grouped under 'ups1' prefix)
    Route::prefix('ups1')->name('ups1.')->group(function () {
        Route::get('/', [UpsMaintenance1Controller::class, 'index'])->name('index');
        Route::get('/create', [UpsMaintenance1Controller::class, 'create'])->name('create');
        Route::post('/', [UpsMaintenance1Controller::class, 'store'])->name('store');
        Route::get('/{upsMaintenance1}', [UpsMaintenance1Controller::class, 'show'])->name('show');
        Route::get('/{upsMaintenance1}/edit', [UpsMaintenance1Controller::class, 'edit'])->name('edit');
        Route::put('/{upsMaintenance1}', [UpsMaintenance1Controller::class, 'update'])->name('update');
        Route::delete('/{upsMaintenance1}', [UpsMaintenance1Controller::class, 'destroy'])->name('destroy');
        Route::get('/{upsMaintenance1}/print', [UpsMaintenance1Controller::class, 'print'])->name('print');
    });

    // UPS1 Maintenance routes (Grouped under 'ups1' prefix)
    Route::prefix('ups1')->name('ups1.')->group(function () {
        Route::get('/', [UpsMaintenance1Controller::class, 'index'])->name('index');
        Route::get('/create', [UpsMaintenance1Controller::class, 'create'])->name('create');
        Route::post('/', [UpsMaintenance1Controller::class, 'store'])->name('store');
        Route::get('/{upsMaintenance1}', [UpsMaintenance1Controller::class, 'show'])->name('show');
        Route::get('/{upsMaintenance1}/edit', [UpsMaintenance1Controller::class, 'edit'])->name('edit');
        Route::put('/{upsMaintenance1}', [UpsMaintenance1Controller::class, 'update'])->name('update');
        Route::delete('/{upsMaintenance1}', [UpsMaintenance1Controller::class, 'destroy'])->name('destroy');
        Route::get('/{upsMaintenance1}/print', [UpsMaintenance1Controller::class, 'print'])->name('print');
    });

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

    // === GROUNDING ROUTES (BARU) ===
    Route::prefix('grounding')->name('grounding.')->group(function () {
        Route::get('/', [GroundingController::class, 'index'])->name('index');
        Route::get('/create', [GroundingController::class, 'create'])->name('create');
        Route::post('/', [GroundingController::class, 'store'])->name('store');
        Route::get('/{id}', [GroundingController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GroundingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GroundingController::class, 'update'])->name('update');
        Route::delete('/{id}', [GroundingController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [GroundingController::class, 'pdf'])->name('pdf');
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

    // AC Maintenance Routes (Grouped under 'ac' prefix)
    Route::prefix('ac')->name('ac.')->group(function () {
        Route::get('/', [AcMaintenanceConrtoller::class, 'index'])->name('index');
        Route::get('/create', [AcMaintenanceConrtoller::class, 'create'])->name('create');
        Route::post('/', [AcMaintenanceConrtoller::class, 'store'])->name('store');
        Route::get('/{id}', [AcMaintenanceConrtoller::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AcMaintenanceConrtoller::class, 'edit'])->name('edit');
        Route::put('/{id}', [AcMaintenanceConrtoller::class, 'update'])->name('update');
        Route::delete('/{id}', [AcMaintenanceConrtoller::class, 'destroy'])->name('destroy');
        Route::get('/{id}/print', [AcMaintenanceConrtoller::class, 'print'])->name('print');
    });
});

require __DIR__ . '/auth.php';

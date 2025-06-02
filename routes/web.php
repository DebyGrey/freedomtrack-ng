<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InmateController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
// Route::get('/', function () {
//     return redirect()->route('login');
// });


// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Inmates Management
    Route::resource('inmates', InmateController::class);

    // Additional Inmate Actions
    Route::post('/inmates/{inmate}/enroll', [InmateController::class, 'enroll'])->name('inmates.enroll');
    Route::post('/inmates/{inmate}/update-progress', [InmateController::class, 'updateProgress'])->name('inmates.updateProgress');
    Route::post('/inmates/{inmate}/behavior-report', [InmateController::class, 'behaviorReport'])->name('inmates.behaviorReport');

    // Programs Management
    Route::resource('programs', ProgramController::class);
    Route::post('/programs/{program}/enroll-inmates', [ProgramController::class, 'enrollInmates'])->name('programs.enrollInmates');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

require __DIR__ . '/auth.php';
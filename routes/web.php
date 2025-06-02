<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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



Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations have been run successfully.';
});

Route::get('/run-seeders', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return '✅ Seeders executed successfully!';
});

Route::get('/refresh-and-seed', function () {
    Artisan::call('migrate:refresh', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);
    return '✅ Database refreshed and seeded successfully!';
});

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return 'Cache cleared!';
});



require __DIR__ . '/auth.php';
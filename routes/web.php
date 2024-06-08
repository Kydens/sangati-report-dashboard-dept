<?php

use App\Http\Controllers\AllReportITController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Report_terimapinjamController;
use App\Http\Controllers\ReportITController;
use App\Http\Controllers\WeeklyITController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['guest'])->group(function() {
    Route::get('/auth/v1/login', [AuthController::class, 'loginIndex'])->name('login');
    Route::post('/auth/v1/login', [AuthController::class, 'loginPost']);
});

Route::middleware(['auth'])->group(function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Report Terima Pinjam
    Route::get('/dashboard/terimapinjam', [Report_terimapinjamController::class, 'index'])->name('report.index');
    Route::get('/dashboard/terimapinjam/addreport', [Report_terimapinjamController::class, 'create'])->name('report.create');
    Route::post('/dashboard/terimapinjam/addreport', [Report_terimapinjamController::class, 'store'])->name('report.store');
    Route::get('/dashboard/terimapinjam/print/{id}', [Report_terimapinjamController::class, 'show'])->name('report.show');
    Route::get('/dashboard/terimapinjam/export', [Report_terimapinjamController::class, 'export_excel'])->name('report.export');

    // Report Weekly IT
    Route::middleware(['role:4,1'])->group(function() {
        Route::get('/dashboard/weeklyIT', [AllReportITController::class, 'index'])->name('weeklyIT.index');
        Route::get('/dashboard/weeklyIT/editReport/{id}', [AllReportITController::class, 'edit'])->name('weeklyIT.edit');
        Route::post('/dashboard/weeklyIT/editReport/{id}', [AllReportITController::class, 'update'])->name('weeklyIT.update');
        Route::get('/dashboard/weeklyIT/export', [AllReportITController::class, 'export_excel'])->name('weeklyIT.export');
    });

    // Report IT
    Route::middleware(['role:4'])->group(function() {
        Route::get('/dashboard/reportIT', [ReportITController::class, 'index'])->name('reportIT.index');
        Route::get('/dashboard/reportIT/addReport', [ReportITController::class, 'create'])->name('reportIT.create');
        Route::post('/dashboard/reportIT/addReport', [ReportITController::class, 'store'])->name('reportIT.store');
    });

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

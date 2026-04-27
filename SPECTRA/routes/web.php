<?php

use App\Http\Controllers\KorlapController;
use App\Http\Controllers\ManagerAreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'korlap') {
        return redirect()->route('korlap.dashboard');
    }
    if ($user->role === 'manager_area') {
        return redirect()->route('manager.dashboard');
    }
    if ($user->role === 'gm') {
        return redirect()->route('gm.dashboard');
    }
    if ($user->role === 'direksi') {
        return redirect()->route('direksi.dashboard');
    }
    if ($user->role === 'finance') {
        return redirect()->route('finance.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Finance Routes
Route::middleware(['auth', 'role:finance'])->prefix('finance')->name('finance.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\FinanceController::class, 'dashboard'])->name('dashboard');
    Route::get('/payouts', [\App\Http\Controllers\FinanceController::class, 'payoutApproval'])->name('payouts');
    Route::post('/payouts/{id}/realize', [\App\Http\Controllers\FinanceController::class, 'realizePayout'])->name('payouts.realize');
    Route::get('/expenses', [\App\Http\Controllers\FinanceController::class, 'expenses'])->name('expenses');
    Route::post('/expenses', [\App\Http\Controllers\FinanceController::class, 'storeExpense'])->name('expenses.store');
});

// Direksi Routes
Route::middleware(['auth', 'role:direksi'])->prefix('direksi')->name('direksi.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DirectorController::class, 'dashboard'])->name('dashboard');
    Route::get('/financial-reports', [\App\Http\Controllers\DirectorController::class, 'financialReports'])->name('financial');
    Route::get('/balance-sheet', [\App\Http\Controllers\DirectorController::class, 'balanceSheet'])->name('balance-sheet');
    Route::get('/sdm-legal', [\App\Http\Controllers\DirectorController::class, 'employeeLegal'])->name('sdm-legal');
    Route::post('/sdm-legal/upload', [\App\Http\Controllers\DirectorController::class, 'uploadLegal'])->name('sdm-legal.upload');
    
    // Exports
    Route::get('/export/pdf', [\App\Http\Controllers\DirectorController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/excel', [\App\Http\Controllers\DirectorController::class, 'exportExcel'])->name('export.excel');
});

// GM Routes
Route::middleware(['auth', 'role:gm'])->prefix('gm')->name('gm.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\GeneralManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/monitoring', [\App\Http\Controllers\GeneralManagerController::class, 'monitoring'])->name('monitoring');
    Route::get('/contracts', [\App\Http\Controllers\GeneralManagerController::class, 'contracts'])->name('contracts');
    Route::post('/contracts/upload', [\App\Http\Controllers\GeneralManagerController::class, 'uploadContract'])->name('contracts.upload');
    Route::get('/gamification', [\App\Http\Controllers\GeneralManagerController::class, 'gamification'])->name('gamification');
});

Route::middleware(['auth', 'role:korlap'])->prefix('korlap')->name('korlap.')->group(function () {
    Route::get('/dashboard', [KorlapController::class, 'dashboard'])->name('dashboard');
    
    // Attendance
    Route::get('/attendance', [KorlapController::class, 'attendance'])->name('attendance');
    Route::post('/attendance', [KorlapController::class, 'storeAttendance'])->name('attendance.store');
    
    // Reports
    Route::get('/reports', [KorlapController::class, 'reports'])->name('reports');
    Route::post('/reports', [KorlapController::class, 'storeReport'])->name('reports.store');
    
    // Installation Reports
    Route::get('/installation-report', [KorlapController::class, 'installationReport'])->name('installation-report');
    Route::post('/installation-report', [KorlapController::class, 'storeInstallationReport'])->name('installation-report.store');
    
    // Directors
    Route::get('/directors', [KorlapController::class, 'directors'])->name('directors');
    
    // Salaries
    Route::get('/salaries', [KorlapController::class, 'salaries'])->name('salaries');
});

// Manager Area Routes
Route::middleware(['auth', 'role:manager_area'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerAreaController::class, 'dashboard'])->name('dashboard');
    
    // Projects
    Route::get('/projects', [ManagerAreaController::class, 'projects'])->name('projects.index');
    Route::get('/projects/create', [ManagerAreaController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [ManagerAreaController::class, 'storeProject'])->name('projects.store');
    
    // Team
    Route::get('/team', [ManagerAreaController::class, 'team'])->name('team');
    
    // Monitoring
    Route::get('/monitoring', [ManagerAreaController::class, 'monitoring'])->name('monitoring');
    
    // Salary Recap
    Route::get('/salary-recap', [ManagerAreaController::class, 'salaryRecap'])->name('salary-recap');
    Route::post('/salary-recap/approve/{projectId}', [ManagerAreaController::class, 'approveSalary'])->name('salary-recap.approve');
    Route::post('/salary-recap/approve-all', [ManagerAreaController::class, 'approveAllSalaries'])->name('salary-recap.approve-all');
    
    // Monthly Report
    Route::get('/monthly-report', [ManagerAreaController::class, 'monthlyReport'])->name('monthly-report');
    
    // Exports
    Route::get('/export/payouts', [ManagerAreaController::class, 'exportPayouts'])->name('export.payouts');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Gamification Routes (Shared)
Route::middleware(['auth'])->prefix('gamification')->name('gamification.')->group(function () {
    Route::get('/leaderboard', [\App\Http\Controllers\GamificationController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/my-stats', [\App\Http\Controllers\GamificationController::class, 'myStats'])->name('my-stats');
    Route::get('/wall-of-fame', [\App\Http\Controllers\GamificationController::class, 'wallOfFame'])->name('wall-of-fame');
});

// Direksi Gamification Admin
Route::middleware(['auth', 'role:direksi'])->prefix('direksi/gamification')->name('direksi.gamification.')->group(function () {
    Route::get('/settings', [\App\Http\Controllers\GamificationController::class, 'adminSettings'])->name('settings');
});

require __DIR__.'/auth.php';

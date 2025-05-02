<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/technicians', [DashboardController::class, 'storeTech'])->name('dashboard.storeTech');
    Route::put('/technician/{id}/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.updateStatus');
    Route::post('/works', [DashboardController::class, 'storeWork'])->name('dashboard.storeWork');
    Route::put('/dashboard/work/{id}', [DashboardController::class, 'updateWork'])->name('dashboard.updateWork');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\TestigoController;
use App\Http\Controllers\TestigoPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Portal de Testigos (acceso exclusivo para testigos)
    Route::middleware([\App\Http\Middleware\EnsureUserIsTestigo::class])->prefix('testigo')->name('testigo.')->group(function () {
        Route::get('/portal', [TestigoPortalController::class, 'index'])->name('portal');
        Route::get('/reportar/{mesa}', [TestigoPortalController::class, 'reportar'])->name('reportar');
        Route::post('/reportar/{mesa}', [TestigoPortalController::class, 'guardarReporte'])->name('guardar-reporte');
    });

    // CRUD Resources - Solo para administradores
    Route::middleware('admin_only')->group(function () {
        Route::resource('personas', PersonaController::class);
        Route::resource('puestos', PuestoController::class);
    });

    // Testigos - Accesible para admin y editor
    Route::resource('testigos', TestigoController::class);

    // User Management
    Route::middleware('check_permission:manage-users')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});

require __DIR__.'/auth.php';

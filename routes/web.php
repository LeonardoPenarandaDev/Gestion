<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\TestigoController;
use App\Http\Controllers\TestigoPortalController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\EleccionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.stats');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Portal de Testigos (acceso exclusivo para testigos)
    Route::middleware([\App\Http\Middleware\EnsureUserIsTestigo::class])->prefix('testigo')->name('testigo.')->group(function () {
        Route::get('/portal', [TestigoPortalController::class, 'index'])->name('portal');
        Route::get('/reportar/{mesa}/{eleccion}', [TestigoPortalController::class, 'reportar'])->name('reportar');
        Route::post('/reportar/{mesa}/{eleccion}', [TestigoPortalController::class, 'guardarReporte'])->name('guardar-reporte');
        Route::post('/upload-temp', [TestigoPortalController::class, 'uploadTemp'])->name('upload-temp');
    });

    // Vista de actas (fotos) - admin y editor
    Route::get('actas', [\App\Http\Controllers\ResultadoMesaController::class, 'actas'])->name('actas.index');

    // Resultados de votación - admin y editor
    Route::get('resultados', [DashboardController::class, 'resultados'])->name('resultados.index');

    // Municipios estratégicos - admin y editor
    Route::get('municipios-estrategicos', [DashboardController::class, 'municipiosEstrategicos'])->name('municipios.index');

    // CRUD Resources - Solo para administradores
    Route::middleware('admin_only')->group(function () {
        Route::resource('personas', PersonaController::class);
        Route::resource('puestos', PuestoController::class);
        Route::patch('resultados/{resultado}/desbloquear', [\App\Http\Controllers\ResultadoMesaController::class, 'desbloquear'])->name('resultados.desbloquear');

        // Gestión de elecciones y candidatos
        Route::get   ('elecciones',                                              [EleccionController::class, 'index']          )->name('elecciones.index');
        Route::post  ('elecciones',                                              [EleccionController::class, 'store']          )->name('elecciones.store');
        Route::put   ('elecciones/{eleccion}',                                   [EleccionController::class, 'update']         )->name('elecciones.update');
        Route::patch ('elecciones/{eleccion}/toggle',                            [EleccionController::class, 'toggleActiva']   )->name('elecciones.toggle');
        Route::delete('elecciones/{eleccion}',                                   [EleccionController::class, 'destroy']        )->name('elecciones.destroy');
        Route::post  ('elecciones/{eleccion}/candidatos',                        [EleccionController::class, 'storeCandidato'] )->name('elecciones.candidatos.store');
        Route::patch ('elecciones/{eleccion}/candidatos/{candidato}',            [EleccionController::class, 'updateCandidato'])->name('elecciones.candidatos.update');
        Route::patch ('elecciones/{eleccion}/candidatos/{candidato}/toggle',     [EleccionController::class, 'toggleCandidato'])->name('elecciones.candidatos.toggle');
        Route::delete('elecciones/{eleccion}/candidatos/{candidato}',            [EleccionController::class, 'destroyCandidato'])->name('elecciones.candidatos.destroy');
    });

    // Testigos - Accesible para admin y editor
    Route::resource('testigos', TestigoController::class);

    // Coordinadores - Accesible para admin y editor
    Route::resource('coordinadores', CoordinadorController::class)
        ->parameters(['coordinadores' => 'coordinador']);
    Route::get('testigos-importar', [TestigoController::class, 'importForm'])->name('testigos.import.form');
    Route::post('testigos-importar', [TestigoController::class, 'import'])->name('testigos.import');
    Route::get('testigos-plantilla', [TestigoController::class, 'downloadTemplate'])->name('testigos.import.template');

    // User Management
    Route::middleware('check_permission:manage-users')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});

require __DIR__.'/auth.php';

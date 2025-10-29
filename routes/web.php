<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\TablaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ProfesoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlumnoGrupoController; 
use App\Http\Controllers\ReporteController;

// 🏠 Página principal (index.html público)
Route::get('/', function () {
    return File::get(public_path('index.html'));
});


// 🔐 Rutas de autenticación (login, registro, etc.)
Auth::routes();

// 🏡 Página de inicio tras iniciar sesión
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 📊 Listado de tablas (vista general)
Route::get('/tablas', function () {
    return view('tablas.index');
})->name('tablas.index')->middleware('auth');

// 🔒 Rutas protegidas: solo usuarios autenticados pueden acceder
Route::middleware(['auth'])->group(function () {

    // Mostrar registros según el nombre de la tabla
    Route::get('/tabla/{nombre}', [TablaController::class, 'mostrar'])->name('tabla.mostrar');

    // Recursos de cada tabla
    Route::resource('profesores', ProfesoreController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('historials', HistorialController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('carreras', CarreraController::class);
    Route::resource('areas', AreaController::class);

    // ==================================================
    // === RUTA PARA DETALLES DE GRUPOS ===
    // ==================================================
    Route::get('/grupos/{id}/detalles', [GrupoController::class, 'detalles'])->name('grupos.detalles');

    // ==================================================
    // === RUTAS PARA INSCRIPCIÓN DE ALUMNOS A GRUPOS ===
    // ==================================================
    Route::prefix('alumnos/{n_control}')->group(function () {
        // Ruta CORREGIDA: usar 'create' en lugar de 'index'
        Route::get('grupos/create', [AlumnoGrupoController::class, 'create'])->name('alumnos.grupos.create');
        Route::post('grupos', [AlumnoGrupoController::class, 'store'])->name('alumnos.grupos.store');
        Route::delete('grupos/{id_grupo}', [AlumnoGrupoController::class, 'destroy'])->name('alumnos.grupos.destroy');
    });
    
    // ==================================================
    // === RUTA PARA EL REPORTE DE ALUMNOS EN ESPECIAL ===
    // ==================================================
    Route::get('/reportes/alumnos-especial-tics', [ReporteController::class, 'alumnosEspecialTICS'])
         ->name('reportes.alumnos_especial_tics');

        

});
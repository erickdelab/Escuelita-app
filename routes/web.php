<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\{
    TablaController,
    AreaController,
    CarreraController,
    AlumnoController,
    GrupoController,
    HistorialController,
    MateriaController,
    ProfesoreController,
    HomeController,
    AlumnoGrupoController,
    ReporteController,
    PeriodoController,
    AulaController
};

// 🏠 Página principal pública (index.html)
Route::get('/', fn() => File::get(public_path('index.html')));

// 🔐 Rutas de autenticación (login, registro, etc.)
Auth::routes();

// 🏡 Página de inicio tras iniciar sesión
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 📊 Vista general de tablas (solo autenticados)
Route::middleware(['auth'])->group(function () {

    // ==================================================
    // === VISTA GENERAL DE TABLAS ===
    // ==================================================
    Route::view('/tablas', 'tablas.index')->name('tablas.index');
    Route::get('/tabla/{nombre}', [TablaController::class, 'mostrar'])->name('tabla.mostrar');

    // ==================================================
    // === RECURSOS REST PRINCIPALES ===
    // ==================================================
    Route::resources([
        'profesores' => ProfesoreController::class,
        'materias'   => MateriaController::class,
        'historials' => HistorialController::class,
        'alumnos'    => AlumnoController::class,
        'carreras'   => CarreraController::class,
        'areas'      => AreaController::class,
        'periodos'   => PeriodoController::class,
        'aulas'      => AulaController::class,
        'grupos'     => GrupoController::class,
    ]);

    // ==================================================
    // === GRUPOS: ASIGNACIÓN DE HORARIO EN 2 PASOS ===
    // ==================================================

    // Paso 1️⃣: Asignar patrón (L-M / M-J) y hora de inicio
    Route::get('/grupos/{grupo}/asignar-hora', [GrupoController::class, 'showHoraForm'])
        ->name('grupos.hora.show');
    Route::post('/grupos/{grupo}/asignar-hora', [GrupoController::class, 'storeHora'])
        ->name('grupos.hora.store');

    // Paso 2️⃣: Asignar aula según el horario guardado
    Route::get('/grupos/{grupo}/asignar-aula', [GrupoController::class, 'showAulaForm'])
        ->name('grupos.aula.show');
    Route::post('/grupos/{grupo}/asignar-aula', [GrupoController::class, 'storeAula'])
        ->name('grupos.aula.store');

    // ✅ Ruta AJAX para verificar aulas disponibles según patrón y hora
    Route::post('/grupos/verificar-aulas', [GrupoController::class, 'verificarAulas'])
        ->name('grupos.verificarAulas');

    // ✅ Ruta para eliminar el horario desde la vista de detalles
    Route::delete('/grupos/{grupo}/eliminar-horario', [GrupoController::class, 'destroyHorario'])
        ->name('grupos.horario.destroy');

    // ==================================================
    // === MATERIAS - RUTAS ADICIONALES ===
    // ==================================================
    Route::post('materias/{cod_materia}/reactivar', [MateriaController::class, 'reactivar'])
        ->name('materias.reactivar');

    // ==================================================
    // === INSCRIPCIÓN DE ALUMNOS A GRUPOS ===
    // ==================================================
    Route::prefix('alumnos/{n_control}/grupos')->name('alumnos.grupos.')->group(function () {
        Route::get('/create', [AlumnoGrupoController::class, 'create'])->name('create');
        Route::post('/', [AlumnoGrupoController::class, 'store'])->name('store');
        Route::delete('/{grupo}', [AlumnoGrupoController::class, 'destroy'])->name('destroy');
    });

    // ==================================================
    // === REPORTES DEL SISTEMA ===
    // ==================================================
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/alumnos', [ReporteController::class, 'reporteAlumnos'])->name('alumnos');
        Route::get('/grupos', [ReporteController::class, 'reporteGrupos'])->name('grupos');
        Route::get('/profesores', [ReporteController::class, 'reporteProfesores'])->name('profesores');
        Route::get('/estadisticas', [ReporteController::class, 'reporteEstadisticas'])->name('estadisticas');
        Route::get('/alumnos-especial-tics', [ReporteController::class, 'alumnosEspecialTICS'])->name('alumnos_especial_tics');
    });
});
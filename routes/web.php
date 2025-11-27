<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
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
    AulaController,
    KardexController,
    CalificacionController
};

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// 🏠 Página principal pública
Route::get('/', fn() => File::get(public_path('index.html')));

// 🔐 Rutas de autenticación
Auth::routes();

// 🏡 Home después de iniciar sesión
Route::get('/home', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRACIÓN GENERAL Y TABLAS
    |--------------------------------------------------------------------------
    */
    Route::view('/tablas', 'tablas.index')->name('tablas.index');
    Route::get('/tabla/{nombre}', [TablaController::class, 'mostrar'])->name('tabla.mostrar');


    /*
    |--------------------------------------------------------------------------
    | CRUD PRINCIPALES
    |--------------------------------------------------------------------------
    */
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


    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE GRUPOS (Horarios y Calificaciones)
    |--------------------------------------------------------------------------
    */

    // --- Asignación de Horarios ---
    Route::get('/grupos/{grupo}/asignar-hora', [GrupoController::class, 'showHoraForm'])->name('grupos.hora.show');
    Route::post('/grupos/{grupo}/asignar-hora', [GrupoController::class, 'storeHora'])->name('grupos.hora.store');

    Route::get('/grupos/{grupo}/asignar-aula', [GrupoController::class, 'showAulaForm'])->name('grupos.aula.show');
    Route::post('/grupos/{grupo}/asignar-aula', [GrupoController::class, 'storeAula'])->name('grupos.aula.store');

    // --- Utilidades de Horarios ---
    Route::post('/grupos/verificar-aulas', [GrupoController::class, 'verificarAulas'])->name('grupos.verificarAulas');
    Route::delete('/grupos/{grupo}/eliminar-horario', [GrupoController::class, 'destroyHorario'])->name('grupos.horario.destroy');

    // --- Calificaciones ---
    Route::prefix('grupos')->name('grupos.calificar.')->group(function () {
        Route::get('/{id}/calificar', [CalificacionController::class, 'index'])->name('index');
        Route::post('/calificar/guardar', [CalificacionController::class, 'store'])->name('store');
        Route::delete('/calificar/{id}/finalizar', [CalificacionController::class, 'finalizarCurso'])->name('finalizar');
    });


    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE KARDEX
    |--------------------------------------------------------------------------
    */
    Route::get('/kardex/{n_control}', [KardexController::class, 'show'])->name('kardex.show');


    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE MATERIAS (Acciones Extra)
    |--------------------------------------------------------------------------
    */
    Route::post('materias/{cod_materia}/reactivar', [MateriaController::class, 'reactivar'])
        ->name('materias.reactivar');


    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE ALUMNOS (Inscripciones, Calificaciones, Horario)
    |--------------------------------------------------------------------------
    */

    // Inscripciones a grupos
    Route::prefix('alumnos/{n_control}/grupos')->name('alumnos.grupos.')->group(function () {
        Route::get('/create', [AlumnoGrupoController::class, 'create'])->name('create');
        Route::post('/', [AlumnoGrupoController::class, 'store'])->name('store');
        Route::delete('/{grupo}', [AlumnoGrupoController::class, 'destroy'])->name('destroy');
    });

    // Calificaciones del alumno
    Route::get('/alumnos/{n_control}/calificaciones', [AlumnoController::class, 'calificaciones'])
        ->name('alumnos.calificaciones');

    // ⭐ NUEVA RUTA AGREGADA: Horario del alumno
    Route::get('/alumnos/{n_control}/horario', [AlumnoController::class, 'horario'])
        ->name('alumnos.horario');


    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE REPORTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/alumnos', [ReporteController::class, 'reporteAlumnos'])->name('alumnos');
        Route::get('/grupos', [ReporteController::class, 'reporteGrupos'])->name('grupos');
        Route::get('/profesores', [ReporteController::class, 'reporteProfesores'])->name('profesores');
        Route::get('/estadisticas', [ReporteController::class, 'reporteEstadisticas'])->name('estadisticas');
        Route::get('/alumnos-especial-tics', [ReporteController::class, 'alumnosEspecialTICS'])->name('alumnos_especial_tics');
    });

});

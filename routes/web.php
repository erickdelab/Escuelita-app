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
    CalificacionController,
    StudentPortalController
};

use App\Http\Controllers\Auth\ChangePasswordController; // Import necesario


/*
|--------------------------------------------------------------------------
| API: Horario Ocupado del Profesor
|--------------------------------------------------------------------------
*/
Route::get('/api/profesores/{id}/horario-ocupado', [GrupoController::class, 'getHorarioOcupado']);



/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => File::get(public_path('index.html')));

// Autenticación Laravel
Auth::routes(['register' => false]);

// Home después del login
Route::get('/home', [HomeController::class, 'index'])->name('home');



/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (requieren login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Horario profesor en portal
    Route::get('/profesores/{n_trabajador}/horario', 
        [ProfesoreController::class, 'horario']
    )->name('profesores.horario');


    /*
    |--------------------------------------------------------------------------
    | TABLAS
    |--------------------------------------------------------------------------
    */
    Route::view('/tablas', 'tablas.index')->name('tablas.index');
    Route::get('/tabla/{nombre}', [TablaController::class, 'mostrar'])->name('tabla.mostrar');


    /*
    |--------------------------------------------------------------------------
    | ADMIN (solo admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        // CRUDs
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
    });


    /*
    |--------------------------------------------------------------------------
    | ACCESO COMPARTIDO: Admin + Profesor
    |--------------------------------------------------------------------------
    */
    Route::get('/alumnos', [AlumnoController::class, 'index'])
        ->middleware('role:admin|profesor')
        ->name('alumnos.index');


    /*
    |--------------------------------------------------------------------------
    | GRUPOS (Horario y Calificaciones)
    |--------------------------------------------------------------------------
    */

    // Horarios
    Route::get('/grupos/{grupo}/asignar-hora', [GrupoController::class, 'showHoraForm'])->name('grupos.hora.show');
    Route::post('/grupos/{grupo}/asignar-hora', [GrupoController::class, 'storeHora'])->name('grupos.hora.store');

    // Aulas
    Route::get('/grupos/{grupo}/asignar-aula', [GrupoController::class, 'showAulaForm'])->name('grupos.aula.show');
    Route::post('/grupos/{grupo}/asignar-aula', [GrupoController::class, 'storeAula'])->name('grupos.aula.store');

    // Utilidades
    Route::post('/grupos/verificar-aulas', [GrupoController::class, 'verificarAulas'])->name('grupos.verificarAulas');
    Route::delete('/grupos/{grupo}/eliminar-horario', [GrupoController::class, 'destroyHorario'])->name('grupos.horario.destroy');

    // Calificaciones
    Route::prefix('grupos')->name('grupos.calificar.')->group(function () {
        Route::get('/{id}/calificar', [CalificacionController::class, 'index'])->name('index');
        Route::post('/calificar/guardar', [CalificacionController::class, 'store'])->name('store');
        Route::delete('/calificar/{id}/finalizar', [CalificacionController::class, 'finalizarCurso'])->name('finalizar');
    });


    /*
    |--------------------------------------------------------------------------
    | KARDEX
    |--------------------------------------------------------------------------
    */
    Route::get('/kardex/{n_control}', [KardexController::class, 'show'])->name('kardex.show');


    /*
    |--------------------------------------------------------------------------
    | MATERIAS - Acción especial
    |--------------------------------------------------------------------------
    */
    Route::post('materias/{cod_materia}/reactivar', [MateriaController::class, 'reactivar'])
        ->name('materias.reactivar');


    /*
    |--------------------------------------------------------------------------
    | ALUMNOS
    |--------------------------------------------------------------------------
    */
    Route::prefix('alumnos/{n_control}/grupos')->name('alumnos.grupos.')->group(function () {
        Route::get('/create', [AlumnoGrupoController::class, 'create'])->name('create');
        Route::post('/', [AlumnoGrupoController::class, 'store'])->name('store');
        Route::delete('/{grupo}', [AlumnoGrupoController::class, 'destroy'])->name('destroy');
    });

    // Calificaciones del alumno
    Route::get('/alumnos/{n_control}/calificaciones', [AlumnoController::class, 'calificaciones'])
        ->name('alumnos.calificaciones');

    // Horario del alumno
    Route::get('/alumnos/{n_control}/horario', [AlumnoController::class, 'horario'])
        ->name('alumnos.horario');


    /*
    |--------------------------------------------------------------------------
    | REPORTES
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


    /*
    |--------------------------------------------------------------------------
    | PORTAL ESTUDIANTE (solo rol alumno)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:alumno'])
        ->prefix('student')
        ->name('student.')
        ->group(function () {
            Route::get('/dashboard', [StudentPortalController::class, 'dashboard'])->name('dashboard');
            Route::get('/horario', [StudentPortalController::class, 'horario'])->name('horario');
            Route::get('/calificaciones', [StudentPortalController::class, 'calificaciones'])->name('calificaciones');
            Route::get('/kardex', [StudentPortalController::class, 'kardex'])->name('kardex');
            Route::get('/carga-materias', [StudentPortalController::class, 'carga'])->name('carga');
        });


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */
    Route::get('/cambiar-password', [ChangePasswordController::class, 'show'])->name('password.change.form');
    Route::post('/cambiar-password', [ChangePasswordController::class, 'update'])->name('password.change.update');

});

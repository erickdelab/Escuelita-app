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
    HorarioController,
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

    // Vista general de todas las tablas
    Route::view('/tablas', 'tablas.index')->name('tablas.index');

    // Mostrar registros según el nombre de la tabla
    Route::get('/tabla/{nombre}', [TablaController::class, 'mostrar'])->name('tabla.mostrar');

    // Recursos REST principales
    Route::resources([
        'profesores' => ProfesoreController::class,
        'materias'   => MateriaController::class,
        'historials' => HistorialController::class,
        'alumnos'    => AlumnoController::class,
        'carreras'   => CarreraController::class,
        'areas'      => AreaController::class,
        'periodos'   => PeriodoController::class,
        'aulas'      => AulaController::class,
    ]);

    // ==================================================
    // === GRUPOS (con Route Model Binding personalizado) ===
    // ==================================================
    Route::resource('grupos', GrupoController::class);

    // ==================================================
    // === MATERIAS - RUTAS ADICIONALES ===
    // ==================================================
    Route::post('materias/{cod_materia}/reactivar', [MateriaController::class, 'reactivar'])->name('materias.reactivar');

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

    // ==================================================
    // === ASIGNACIÓN DE HORARIOS (MODIFICADO) ===
    // ==================================================
    
    // Rutas para gestionar el horario de UN grupo
    Route::get('/grupos/{grupo}/horario', [GrupoController::class, 'showHorarioForm'])
        ->name('grupos.horario.show');
    Route::post('/grupos/{grupo}/horario', [GrupoController::class, 'storeHorario'])
        ->name('grupos.horario.store');
    Route::delete('/grupos/{grupo}/horario', [GrupoController::class, 'destroyHorario'])
        ->name('grupos.horario.destroy');
        
    // Ruta de AJAX para verificar aulas
    Route::post('/grupos/verificar-aulas', [GrupoController::class, 'verificarAulas'])
           ->name('grupos.verificarAulas');
           
    // (La ruta resource('horarios') que tenías antes ya no es necesaria)

});
<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Grupo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AlumnoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    /**
     * Muestra una lista de los recursos, aplicando filtros de búsqueda y ordenamiento.
     */
    public function index(Request $request): View
    {
        $search = $request->search;
        $situacionFilter = $request->situacion_filter;
        $carreraFilter = $request->carrera_filter;
        $sort = $request->sort ?? 'n_control';
        $direction = $request->direction ?? 'asc';

        // Cargar carreras para el filtro
        $carreras = Carrera::pluck('nombre_carrera', 'id_carrera');

        // ✅ OPTIMIZADO: Búsqueda con agrupación correcta y ordenamiento
        $alumnos = Alumno::with('carrera')
            ->when($search, function ($query, $search) {
                // Agrupación CRÍTICA para evitar resultados incorrectos
                $query->where(function ($q) use ($search) {
                    $q->where('n_control', 'like', "%{$search}%")
                      ->orWhere('nombre', 'like', "%{$search}%")
                      ->orWhere('ap_pat', 'like', "%{$search}%")
                      ->orWhere('ap_mat', 'like', "%{$search}%")
                      ->orWhere('situacion', 'like', "%{$search}%")
                      ->orWhereHas('carrera', function ($q) use ($search) {
                          $q->where('nombre_carrera', 'like', "%{$search}%");
                      });
                });
            })
            ->when($situacionFilter, function ($query, $situacionFilter) {
                $query->where('situacion', $situacionFilter);
            })
            ->when($carreraFilter, function ($query, $carreraFilter) {
                $query->where('FKid_carrera', $carreraFilter);
            })
            ->when($sort == 'carrera', function ($query) use ($direction) {
                $query->join('carreras', 'alumnos.FKid_carrera', '=', 'carreras.id_carrera')
                      ->orderBy('carreras.nombre_carrera', $direction)
                      ->select('alumnos.*');
            })
            ->when($sort != 'carrera', function ($query) use ($sort, $direction) {
                $query->orderBy($sort, $direction);
            })
            ->paginate(20)
            ->withQueryString();

        return view('alumno.index', compact('alumnos', 'carreras'))
            ->with('i', ($alumnos->currentPage() - 1) * $alumnos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $alumno = new Alumno();
        
        // Carga de datos para el SELECT de Carreras (nombre como valor, id como clave)
        $carreras = Carrera::pluck('nombre_carrera', 'id_carrera'); 

        return view('alumno.create', compact('alumno', 'carreras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlumnoRequest $request): RedirectResponse
    {
        Alumno::create($request->validated());

        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($n_control): View
    {
        $alumno = Alumno::with([
            'carrera',
            'grupos.materia', 
            'grupos.profesore'
        ])->findOrFail($n_control);

        // ✅ OPTIMIZADO: Una sola línea eficiente
        $materiasTomadas = $alumno->grupos->pluck('materia')->filter()->unique('cod_materia');

        // ✅ NUEVO: Obtener grupos disponibles (excluyendo los que ya está inscrito)
        $gruposInscritos = $alumno->grupos->pluck('id_grupo')->toArray();
        
        $gruposDisponibles = Grupo::with(['materia', 'profesore'])
                                ->whereNotIn('id_grupo', $gruposInscritos)
                                ->get();

        return view('alumno.show', compact('alumno', 'materiasTomadas', 'gruposDisponibles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($n_control): View
    {
        $alumno = Alumno::findOrFail($n_control);
        
        // Carga de datos para el SELECT de Carreras
        $carreras = Carrera::pluck('nombre_carrera', 'id_carrera'); 

        return view('alumno.edit', compact('alumno', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $alumno->update($request->validated());

        return Redirect::route('alumnos.index')
            ->with('success', 'Cambios guardados correctamente.');
    }

    /**
     * Cambia el estatus del alumno a 'Baja' (Eliminación Lógica) y desvincula la carrera.
     */
    public function destroy($n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);

        // Verificar si el alumno tiene grupos inscritos
        if ($alumno->grupos()->count() > 0) {
            return Redirect::route('alumnos.index')
                ->with('error', 'No se puede dar de baja al alumno porque está inscrito en ' . $alumno->grupos()->count() . ' grupo(s). Primero desinscríbalo de los grupos.');
        }

        // === BAJA LÓGICA Y DESVINCULACIÓN ===
        // 1. Cambia la situación a 'Baja'.
        // 2. Establece la FKid_carrera a NULL (Desvinculación de la carrera).
        // 3. Establece el semestre a NULL.
        // 4. Establece el promedio_general a NULL.
        $alumno->update([
            'situacion' => 'Baja',
            'FKid_carrera' => NULL, // Desvinculación de la carrera
            'semestre' => NULL,
            'promedio_general' => NULL, // ✅ NUEVO: Limpiar promedio al dar de baja
        ]);

        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno dado de BAJA y desvinculado de la carrera.');
    }

    /**
     * Restaurar alumno (cambiar situación a 'Vigente')
     */
    public function restore($n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);
        
        $alumno->update([
            'situacion' => 'Vigente'
        ]);

        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno restaurado exitosamente.');
    }

    /**
     * Eliminación física del alumno (solo si no tiene grupos inscritos)
     */
    public function forceDelete($n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);

        // Verificar si el alumno tiene grupos inscritos
        if ($alumno->grupos()->count() > 0) {
            return Redirect::route('alumnos.index')
                ->with('error', 'No se puede eliminar al alumno porque está inscrito en ' . $alumno->grupos()->count() . ' grupo(s). Primero desinscríbalo de los grupos.');
        }

        $alumno->delete();

        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno eliminado permanentemente.');
    }

    /**
     * ✅ NUEVO: Mostrar formulario para inscribir a grupos
     */
    public function createGrupo($n_control): View
    {
        $alumno = Alumno::findOrFail($n_control);
        
        // Obtener grupos disponibles (excluyendo aquellos en los que ya está inscrito)
        $gruposInscritos = $alumno->grupos->pluck('id_grupo')->toArray();
        
        $gruposDisponibles = Grupo::with(['materia', 'profesore'])
                                ->whereNotIn('id_grupo', $gruposInscritos)
                                ->get();

        return view('alumno.inscribir-grupo', compact('alumno', 'gruposDisponibles'));
    }

    /**
     * ✅ NUEVO: Inscribir alumno a grupo
     */
    public function storeGrupo(Request $request, $n_control): RedirectResponse
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'oportunidad' => 'required|in:Primera,Repite,Especial'
        ]);

        $alumno = Alumno::findOrFail($n_control);
        
        // Verificar que no esté ya inscrito
        $yaInscrito = DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $request->id_grupo)
            ->exists();

        if ($yaInscrito) {
            return redirect()->back()
                ->with('error', 'El alumno ya está inscrito en este grupo.');
        }

        // ✅ Inscribir al grupo con oportunidad
        DB::table('alumno_grupo')->insert([
            'n_control' => $n_control,
            'id_grupo' => $request->id_grupo,
            'oportunidad' => $request->oportunidad,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('alumnos.show', $n_control)
            ->with('success', 'Alumno inscrito al grupo exitosamente.');
    }

    /**
     * ✅ NUEVO: Desinscribir alumno de grupo
     */
    public function destroyGrupo($n_control, $id_grupo): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);
        
        // Verificar que esté inscrito en el grupo
        $inscrito = DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $id_grupo)
            ->exists();

        if (!$inscrito) {
            return redirect()->back()
                ->with('error', 'El alumno no está inscrito en este grupo.');
        }

        // ✅ Desinscribir del grupo
        DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $id_grupo)
            ->delete();

        return redirect()->route('alumnos.show', $n_control)
            ->with('success', 'Alumno desinscrito del grupo exitosamente.');
    }
}
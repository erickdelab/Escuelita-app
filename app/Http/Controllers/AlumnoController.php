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
use Carbon\Carbon;

class AlumnoController extends Controller
{
    /**
     * Muestra una lista de los recursos, aplicando filtros de búsqueda y ordenamiento.
     */
    public function index(Request $request): View
    {
        $search = $request->search;
        $situacionFilter = $request->situacion_filter ?? [];
        $carreraFilter = $request->carrera_filter ?? [];
        $semestreFilter = $request->semestre_filter ?? [];
        $generoFilter = $request->genero_filter;
        $promedioFilter = $request->promedio_filter;
        $sort = $request->sort ?? 'n_control';
        $direction = $request->direction ?? 'asc';

        // Cargar carreras para el filtro
        $carreras = Carrera::pluck('nombre_carrera', 'id_carrera');

        // Búsqueda con filtros múltiples
        $alumnos = Alumno::with('carrera')
            ->when($search, function ($query, $search) {
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
            ->when(!empty($situacionFilter), function ($query) use ($situacionFilter) {
                $query->whereIn('situacion', $situacionFilter);
            })
            ->when(!empty($carreraFilter), function ($query) use ($carreraFilter) {
                $query->whereIn('FKid_carrera', $carreraFilter);
            })
            ->when(!empty($semestreFilter), function ($query) use ($semestreFilter) {
                $query->whereIn('semestre', $semestreFilter);
            })
            ->when($generoFilter, function ($query, $generoFilter) {
                $query->where('genero', $generoFilter);
            })
            ->when($promedioFilter, function ($query, $promedioFilter) {
                switch ($promedioFilter) {
                    case '90-100': $query->where('promedio_general', '>=', 90); break;
                    case '80-89': $query->whereBetween('promedio_general', [80, 89.99]); break;
                    case '70-79': $query->whereBetween('promedio_general', [70, 79.99]); break;
                    case '0-69': $query->where('promedio_general', '<', 70); break;
                    case 'sin_promedio': $query->whereNull('promedio_general'); break;
                }
            })
            ->when($sort == 'carrera', function ($query) use ($direction) {
                $query->join('carreras', 'alumnos.FKid_carrera', '=', 'carreras.id_carrera')
                      ->orderBy('carreras.nombre_carrera', $direction)
                      ->select('alumnos.*');
            })
            ->when($sort != 'carrera', function ($query) use ($sort, $direction) {
                $query->orderBy($sort, $direction);
            })
            ->paginate(50)
            ->withQueryString();

        return view('alumno.index', compact('alumnos', 'carreras'))
            ->with('i', ($alumnos->currentPage() - 1) * $alumnos->perPage());
    }

    public function create(): View
    {
        $alumno = new Alumno();
        $carreras = Carrera::pluck('nombre_carrera', 'id_carrera'); 
        return view('alumno.create', compact('alumno', 'carreras'));
    }

    public function store(AlumnoRequest $request): RedirectResponse
    {
        Alumno::create($request->validated());
        return Redirect::route('alumnos.index')->with('success', 'Alumno creado exitosamente.');
    }

    public function show($n_control): View
    {
        $alumno = Alumno::with(['carrera','grupos.materia','grupos.profesore'])->findOrFail($n_control);
        $materiasTomadas = $alumno->grupos->pluck('materia')->filter()->unique('cod_materia');
        $gruposInscritos = $alumno->grupos->pluck('id_grupo')->toArray();
        $gruposDisponibles = Grupo::with(['materia', 'profesore'])->whereNotIn('id_grupo', $gruposInscritos)->get();

        return view('alumno.show', compact('alumno', 'materiasTomadas', 'gruposDisponibles'));
    }

    public function edit($n_control): View
    {
        $alumno = Alumno::findOrFail($n_control);
        $carreras = Carrera::pluck('nombre_carrera', 'id_carrera'); 
        return view('alumno.edit', compact('alumno', 'carreras'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $alumno->update($request->validated());
        return Redirect::route('alumnos.index')->with('success', 'Cambios guardados correctamente.');
    }

    public function destroy($n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);
        if ($alumno->grupos()->count() > 0) {
            return Redirect::route('alumnos.index')
                ->with('error', 'No se puede dar de baja al alumno porque está inscrito en grupos.');
        }
        $alumno->update([
            'situacion' => 'Baja',
            'FKid_carrera' => NULL,
            'semestre' => NULL,
            'promedio_general' => NULL,
        ]);
        return Redirect::route('alumnos.index')->with('success', 'Alumno dado de BAJA.');
    }

    public function restore($n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);
        $alumno->update(['situacion' => 'Vigente']);
        return Redirect::route('alumnos.index')->with('success', 'Alumno restaurado exitosamente.');
    }

    public function forceDelete($n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);
        if ($alumno->grupos()->count() > 0) {
            return Redirect::route('alumnos.index')->with('error', 'Error: Alumno inscrito en grupos.');
        }
        $alumno->delete();
        return Redirect::route('alumnos.index')->with('success', 'Alumno eliminado permanentemente.');
    }

    public function createGrupo($n_control): View
    {
        $alumno = Alumno::findOrFail($n_control);
        $gruposInscritos = $alumno->grupos->pluck('id_grupo')->toArray();
        $gruposDisponibles = Grupo::with(['materia', 'profesore'])->whereNotIn('id_grupo', $gruposInscritos)->get();
        return view('alumno.inscribir-grupo', compact('alumno', 'gruposDisponibles'));
    }

    public function storeGrupo(Request $request, $n_control): RedirectResponse
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'oportunidad' => 'required|in:Primera,Repite,Especial'
        ]);
        $alumno = Alumno::findOrFail($n_control);
        $yaInscrito = DB::table('alumno_grupo')->where('n_control', $n_control)->where('id_grupo', $request->id_grupo)->exists();
        if ($yaInscrito) {
            return redirect()->back()->with('error', 'El alumno ya está inscrito en este grupo.');
        }
        DB::table('alumno_grupo')->insert([
            'n_control' => $n_control,
            'id_grupo' => $request->id_grupo,
            'oportunidad' => $request->oportunidad,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('alumnos.show', $n_control)->with('success', 'Alumno inscrito al grupo exitosamente.');
    }

    public function destroyGrupo($n_control, $id_grupo): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);
        $inscrito = DB::table('alumno_grupo')->where('n_control', $n_control)->where('id_grupo', $id_grupo)->exists();
        if (!$inscrito) {
            return redirect()->back()->with('error', 'El alumno no está inscrito en este grupo.');
        }
        DB::table('alumno_grupo')->where('n_control', $n_control)->where('id_grupo', $id_grupo)->delete();
        return redirect()->route('alumnos.show', $n_control)->with('success', 'Alumno desinscrito del grupo exitosamente.');
    }

    public function hasActiveFilters(): bool
    {
        $request = request();
        return !empty($request->search) || !empty($request->situacion_filter) || !empty($request->carrera_filter) || 
               !empty($request->semestre_filter) || !empty($request->genero_filter) || !empty($request->promedio_filter);
    }

    /**
     * Muestra la vista detallada de calificaciones actuales, HORARIO VISUAL e historial por periodo.
     */
    public function calificaciones(Request $request, $n_control): View
    {
        $alumno = Alumno::with('carrera')->findOrFail($n_control);

        // 1. CARGA ACADÉMICA ACTUAL
        $cargaActual = \App\Models\AlumnoGrupo::with([
            'grupo.materia',
            'grupo.profesore',
            'grupo.horarios.aula',
            'calificacion'
        ])
        ->where('n_control', $n_control)
        ->get();

        // 2. CONSTRUCCIÓN DEL HORARIO VISUAL (GRID)
        // Definimos el rango de horas a mostrar (07:00 a 20:00)
        $horas = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
        $dias = [1, 2, 3, 4, 5, 6]; // Lunes a Sábado

        // Inicializamos la matriz vacía
        $horarioGrid = [];
        foreach($horas as $h) {
            foreach($dias as $d) {
                $horarioGrid[$h][$d] = null;
            }
        }

        // Paleta de colores para las materias
        $colores = [
            ['bg' => '#cfe2ff', 'border' => '#b6d4fe', 'text' => '#084298'], // Azul
            ['bg' => '#d1e7dd', 'border' => '#badbcc', 'text' => '#0f5132'], // Verde
            ['bg' => '#f8d7da', 'border' => '#f5c2c7', 'text' => '#842029'], // Rojo
            ['bg' => '#fff3cd', 'border' => '#ffecb5', 'text' => '#664d03'], // Amarillo
            ['bg' => '#cff4fc', 'border' => '#b6effb', 'text' => '#055160'], // Cyan
            ['bg' => '#e2e3e5', 'border' => '#d3d6d8', 'text' => '#141619'], // Gris
            ['bg' => '#f3d9fa', 'border' => '#e5bbf5', 'text' => '#581c87'], // Morado
        ];
        
        $materiaMap = []; // Para asignar color consistente a cada materia
        $colorIndex = 0;

        foreach($cargaActual as $inscripcion) {
            $grupo = $inscripcion->grupo;
            $materia = $grupo->materia;
            
            // Asignar color si es materia nueva en el loop
            if(!isset($materiaMap[$materia->cod_materia])) {
                $materiaMap[$materia->cod_materia] = $colores[$colorIndex % count($colores)];
                $colorIndex++;
            }
            $estilo = $materiaMap[$materia->cod_materia];

            foreach($grupo->horarios as $h) {
                $inicio = Carbon::parse($h->hora_inicio);
                $fin = Carbon::parse($h->hora_fin);
                
                // Rellenamos las celdas hora por hora
                // Suponemos bloques de hora en punto (07:00, 08:00...)
                while($inicio < $fin) {
                    $horaStr = $inicio->format('H:i');
                    if(isset($horarioGrid[$horaStr][$h->dia_semana])) {
                        $horarioGrid[$horaStr][$h->dia_semana] = [
                            'nombre' => $materia->nombre,
                            'aula' => $h->aula->nombre ?? 'N/A',
                            'grupo' => $grupo->id_grupo,
                            'estilo' => $estilo
                        ];
                    }
                    $inicio->addHour();
                }
            }
        }

        // 3. HISTORIAL DE PERIODOS
        $periodosDisponibles = \App\Models\Periodo::orderBy('anio', 'desc')
            ->orderBy('id', 'desc')
            ->pluck('codigo_periodo');

        $boletasHistorial = collect();
        $mensajeHistorial = null;
        $periodoSeleccionado = $request->input('periodo_select');

        if ($periodoSeleccionado) {
            $boletasHistorial = \App\Models\Boleta::with(['materia', 'profesor'])
                ->where('n_control', $n_control)
                ->where('periodo', $periodoSeleccionado)
                ->get();

            if ($boletasHistorial->isEmpty()) {
                $mensajeHistorial = "No se encontraron registros de calificaciones para el periodo seleccionado.";
            }
        }

        return view('alumno.calificaciones', compact(
            'alumno', 
            'cargaActual', 
            'horarioGrid', // Variable nueva para la vista
            'horas',       // Variable nueva
            'periodosDisponibles', 
            'boletasHistorial', 
            'mensajeHistorial',
            'periodoSeleccionado'
        ));
    }

    /**
     * Muestra el horario gráfico del alumno.
     */
    public function horario($n_control): View
    {
        $alumno = Alumno::findOrFail($n_control);

        // 1. Obtener grupos del periodo ACTUAL (o los vigentes del alumno)
        // Asumimos que los grupos "Vigentes" son los de la carga actual.
        // Si tienes lógica de periodos activos, agrégala al whereHas('periodo', ...)
        $grupos = $alumno->grupos()
            ->with(['materia', 'profesore', 'horarios.aula'])
            ->get();

        // 2. Estructurar datos para el Grid (Calendario)
        // Formato: $calendario[dia][hora] = InfoClase
        $calendario = [];
        $horasDisponibles = range(7, 20); // De 7:00 AM a 8:00 PM (Ajusta según tu necesidad)
        
        // Colores pastel para diferenciar materias
        $colores = [
            '#FFD1DC', '#D1E8E2', '#FFF4E0', '#E0F7FA', '#F3E5F5', 
            '#F0F4C3', '#FFCCBC', '#CFD8DC', '#E1BEE7', '#B2DFDB'
        ];
        $materiasColor = []; // Para asignar siempre el mismo color a la misma materia
        $colorIndex = 0;

        foreach ($grupos as $grupo) {
            // Asignar color a la materia si no tiene
            if (!isset($materiasColor[$grupo->cod_materia])) {
                $materiasColor[$grupo->cod_materia] = $colores[$colorIndex % count($colores)];
                $colorIndex++;
            }

            foreach ($grupo->horarios as $horario) {
                $dia = $horario->dia_semana; // 1=Lunes, 2=Martes...
                $horaInicio = (int) \Carbon\Carbon::parse($horario->hora_inicio)->format('H');
                $horaFin = (int) \Carbon\Carbon::parse($horario->hora_fin)->format('H');
                
                // Duración en horas (para el rowspan)
                $duracion = $horaFin - $horaInicio;

                // Guardamos la info en el bloque de inicio
                $calendario[$dia][$horaInicio] = [
                    'materia' => $grupo->materia->nombre,
                    'codigo' => $grupo->materia->cod_materia,
                    'profesor' => $grupo->profesore ? $grupo->profesore->nombre . ' ' . $grupo->profesore->ap_paterno : 'N/A',
                    'aula' => $horario->aula->nombre ?? 'N/A',
                    'duracion' => $duracion,
                    'color' => $materiasColor[$grupo->cod_materia],
                    'grupo' => $grupo->id_grupo
                ];

                // Marcar las horas siguientes como "ocupadas" para no pintar celdas vacías
                for ($h = $horaInicio + 1; $h < $horaFin; $h++) {
                    $calendario[$dia][$h] = 'ocupado';
                }
            }
        }

        return view('alumno.horario', compact('alumno', 'calendario', 'horasDisponibles'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Profesore;
use App\Models\Periodo;
use App\Models\Aula;
use App\Models\Horario; // ✅ AÑADIDO
use App\Http\Requests\GrupoRequest;
use App\Services\ScheduleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // ✅ AÑADIDO
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class GrupoController extends Controller
{
    // 4. INYECTAR EL SERVICIO DE HORARIOS
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Muestra una lista de los Grupos.
     */
    public function index(Request $request): View
    {
        // ✅ AÑADIDO withCount('horarios')
        $grupos = Grupo::with(['materia', 'profesore', 'periodo'])
            ->withCount('horarios') // <-- AQUÍ
            ->paginate(30);
            
        return view('grupo.index', compact('grupos'))
            ->with('i', ($request->input('page', 1) - 1) * $grupos->perPage());
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create(): View
    {
        $grupo = new Grupo();
        $materias = Materia::where('materia_estado', 'Activa')
            ->pluck('nombre', 'cod_materia');
        $profesores = Profesore::where('situacion', 'Vigente')
            ->selectRaw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) as full_name, n_trabajador")
            ->pluck('full_name', 'n_trabajador');
        $periodos = Periodo::where('activo', true)
            ->selectRaw("CONCAT(periodo_nombre, ' ', anio, ' (', codigo_periodo, ')') as periodo_full, id")
            ->pluck('periodo_full', 'id');
        
        // --- DATOS DE HORARIO ELIMINADOS DE AQUÍ ---

        return view('grupo.create', compact(
            'grupo', 
            'materias', 
            'profesores', 
            'periodos'
            // --- 'aulas' y 'allowedStartTimes' eliminados ---
        ));
    }

    /**
     * Guarda un nuevo grupo y su horario en la base de datos.
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        // Ya no se necesita transacción ni ScheduleService aquí
        $validated = $request->validated();
        Grupo::create($validated);

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo creado exitosamente. Ahora puedes asignarle un horario.');
    }

    /**
     * Muestra los detalles de un grupo, incluyendo su horario.
     */
    public function show(Grupo $grupo): View
    {
        $grupo->load([
            'materia',      
            'profesore',    
            'periodo',      
            'alumnos',      
            'horarios' => function ($query) {
                $query->orderBy('dia_semana', 'asc')
                      ->orderBy('hora_inicio', 'asc');
            },
            'horarios.materia',
            'horarios.profesore',
            'horarios.aula'
        ]);

        $horariosAgrupados = $grupo->horarios->groupBy('dia_semana');

        $diasSemana = [
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
            4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'
        ];

        return view('grupo.show', compact(
            'grupo', 
            'horariosAgrupados', 
            'diasSemana'
        ));
    }

    /**
     * Muestra el formulario de edición de un grupo.
     */
    public function edit(Grupo $grupo): View
    {
        $grupo->load(['materia', 'profesore', 'periodo']);
        $materias = Materia::where('materia_estado', 'Activa')
            ->pluck('nombre', 'cod_materia');
        $profesores = Profesore::where('situacion', 'Vigente')
            ->selectRaw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) as full_name, n_trabajador")
            ->pluck('full_name', 'n_trabajador');
        $periodos = Periodo::where('activo', true)
            ->selectRaw("CONCAT(periodo_nombre, ' ', anio, ' (', codigo_periodo, ')') as periodo_full, id")
            ->pluck('periodo_full', 'id');
        
        // --- DATOS DE HORARIO ELIMINADOS DE AQUÍ ---

        return view('grupo.edit', compact(
            'grupo', 
            'materias', 
            'profesores', 
            'periodos'
            // --- 'aulas' y 'allowedStartTimes' eliminados ---
        ));
    }

    /**
     * Actualiza la información de un grupo.
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
        // Actualiza solo los datos del grupo
        $grupo->update($request->validated());
        
        return Redirect::route('grupos.index')
            ->with('success', 'Grupo actualizado exitosamente.');
    }

    /**
     * Elimina un grupo si no tiene alumnos asignados.
     */
    public function destroy(Grupo $grupo): RedirectResponse
    {
        $grupo->loadCount('alumnos');

        if ($grupo->alumnos_count > 0) {
            return Redirect::route('grupos.index')
                ->with('error', 'No se puede eliminar el grupo porque tiene ' . $grupo->alumnos_count . ' alumno(s) inscrito(s).');
        }

        try {
            // Eliminar horarios y luego el grupo
            DB::transaction(function() use ($grupo) {
                $grupo->horarios()->delete();
                $grupo->delete();
            });
            
            return Redirect::route('grupos.index')
                ->with('success', 'Grupo y su horario eliminados exitosamente.');
        } catch (\Exception $e) {
            return Redirect::route('grupos.index')
                ->with('error', 'Error al eliminar el grupo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra detalles completos del grupo con profesor y alumnos.
     */
    public function detalles(Grupo $grupo): View
    {
        $grupo->load([
            'materia',
            'profesore.area',
            'alumnos.carrera',
            'periodo'
        ]);

        return view('grupo.detalles', compact('grupo'));
    }
    
    // =================================================================
    // ✅ SECCIÓN DE HORARIOS (CON EL MÉTODO FALTANTE)
    // =================================================================

    /**
     * ✅ MÉTODO FALTANTE: Verifica la disponibilidad de aulas para un horario (AJAX)
     */
    public function verificarAulas(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'materia_id' => 'required|string|exists:materias,cod_materia',
            'patron' => 'required|string|in:L-M,M-J',
            'hora_inicio' => 'required|string',
        ]);

        try {
            // 1. Obtener los créditos
            $materia = Materia::findOrFail($validated['materia_id']);
            $creditos = $materia->creditos ?? 5;

            // 2. Generar los bloques tentativos (usando el método que hicimos público en ScheduleService)
            $bloques = $this->scheduleService->generateBlocks(
                $creditos,
                $validated['patron'],
                $validated['hora_inicio']
            );

            // 3. Encontrar las Aulas Ocupadas en esos bloques
            $occupiedAulaIds = Horario::where(function ($query) use ($bloques) {
                foreach ($bloques as $bloque) {
                    $query->orWhere(function ($q) use ($bloque) {
                        $q->where('dia_semana', $bloque['dia'])
                          ->where('hora_inicio', '<', $bloque['fin'])
                          ->where('hora_fin', '>', $bloque['inicio']);
                    });
                }
            })->pluck('aula_id')->unique();

            // 4. Obtener todas las aulas
            $allAulas = Aula::orderBy('nombre')->get();

            // 5. Separar disponibles de ocupadas
            $disponibles = $allAulas->whereNotIn('id', $occupiedAulaIds);
            $ocupadas = $allAulas->whereIn('id', $occupiedAulaIds);

            return response()->json([
                'disponibles' => $disponibles,
                'ocupadas' => $ocupadas,
            ]);

        } catch (\Exception $e) {
            // Si algo falla (ej. hora_inicio malformada), devuelve un error
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * ✅ NUEVO: Muestra el formulario para asignar/editar el horario de un grupo.
     */
    public function showHorarioForm(Grupo $grupo): View|RedirectResponse
    {
        // Cargar las relaciones necesarias
        $grupo->load(['materia', 'profesore', 'horarios.aula']);

        // Validar que el grupo tenga lo básico para un horario
        if (!$grupo->materia || !$grupo->profesore) {
            return redirect()->route('grupos.index')
                ->with('error', 'El grupo debe tener una materia y un profesor asignados para poder definir un horario.');
        }

        $aulas = Aula::orderBy('nombre')->get();
        $allowedStartTimes = [
            '07:00:00', '09:00:00', '11:00:00', '13:00:00',
            '15:00:00', '17:00:00', '19:00:00'
        ];
        
        // Para mostrar el horario actual si existe
        $horariosAgrupados = $grupo->horarios->groupBy('dia_semana');
        $diasSemana = [
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
            4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'
        ];

        return view('grupo.asignar-horario', compact(
            'grupo',
            'aulas',
            'allowedStartTimes',
            'horariosAgrupados',
            'diasSemana'
        ));
    }

    /**
     * ✅ NUEVO: Almacena el nuevo horario para un grupo.
     */
    public function storeHorario(Request $request, Grupo $grupo): RedirectResponse
    {
        $validated = $request->validate([
            'aula_id' => 'required|integer|exists:aulas,id',
            'patron' => 'required|string|in:L-M,M-J',
            'hora_inicio' => 'required|string',
        ]);
        
        // Datos que vienen del grupo, no del formulario
        $materiaId = $grupo->cod_materia;
        $profesorId = $grupo->n_trabajador;
        $grupoId = $grupo->id_grupo;

        if (!$materiaId || !$profesorId) {
             return redirect()->back()->with('error', 'El grupo no tiene materia o profesor asignado.');
        }

        try {
            // Usamos una transacción para borrar el horario antiguo y crear el nuevo
            DB::transaction(function () use ($grupo, $grupoId, $materiaId, $profesorId, $validated) {
                
                // 1. Borrar cualquier horario existente para este grupo
                $grupo->horarios()->delete();

                // 2. Llamar al servicio para crear el nuevo horario
                $this->scheduleService->assignSchedule(
                    $grupoId,
                    $materiaId, 
                    $profesorId,
                    $validated['aula_id'],
                    $validated['patron'],
                    $validated['hora_inicio']
                );
            });
            
            return redirect()->route('grupos.horario.show', $grupo)
                ->with('success', 'Horario asignado/actualizado exitosamente.');

        } catch (\Exception $e) {
            // Capturar colisiones
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al asignar horario: ' . $e->getMessage());
        }
    }

    /**
     * ✅ NUEVO: Elimina el horario de un grupo.
     */
    public function destroyHorario(Grupo $grupo): RedirectResponse
    {
        $grupo->horarios()->delete();
        
        return redirect()->route('grupos.horario.show', $grupo)
            ->with('success', 'Horario eliminado exitosamente.');
    }
}
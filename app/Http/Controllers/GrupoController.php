<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Profesore;
use App\Models\Periodo;
use App\Models\Aula;
use App\Models\Horario;
use App\Http\Requests\GrupoRequest;
use App\Services\ScheduleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GrupoController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    // =====================================================
    // CRUD BASE DE GRUPOS
    // =====================================================

    /**
     * Muestra la lista de grupos.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        $query = Grupo::with(['materia', 'profesore', 'periodo'])->withCount('horarios');

        // 🔒 FILTRO: Si es profesor, solo ve SUS grupos
        if ($user->hasRole('profesor') && !$user->hasRole('admin')) {
            $query->where('n_trabajador', $user->n_trabajador_link);
        }

        // Si es admin, ve todo (no aplicamos filtro where)

        $grupos = $query->paginate(30);
        
        return view('grupo.index', compact('grupos'))
            ->with('i', ($request->input('page', 1) - 1) * $grupos->perPage());
    }

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

        return view('grupo.create', compact('grupo', 'materias', 'profesores', 'periodos'));
    }

    /**
     * Almacena un nuevo grupo.
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Grupo::create($validated);

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo creado exitosamente. Ahora puedes asignarle un horario.');
    }

    /**
     * Muestra la vista de 'detalles'.
     */
    public function show($id): View
    {
        // 1. Cargar el grupo con TODAS las relaciones anidadas necesarias
        $grupo = Grupo::with([
            'profesore.area.jefe', 
            'materia', 
            'periodo', 
            'alumnos.carrera', 
            'horarios.aula'    
        ])->findOrFail($id);

        // 2. Lógica para "Horario Actual"
        $diasSemana = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes'];
        $horariosAgrupados = $grupo->horarios->sortBy('hora_inicio')->groupBy('dia_semana');

        // 3. Variables para validación visual (opcional si se usa en la vista)
        $allowedStartTimes = ['07:00:00', '09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'];
        
        $horasOcupadasDelProfesor = [];
        if ($grupo->profesore && $grupo->periodo) {
            $horasOcupadasDelProfesor = Grupo::where('n_trabajador', $grupo->n_trabajador)
                ->where('periodo_id', $grupo->periodo_id)
                ->where('id_grupo', '!=', $grupo->id_grupo)
                ->whereNotNull('hora_inicio')
                ->pluck('hora_inicio')
                ->unique()
                ->toArray();
        }

        $aulasDisponibles = [];
        $aulasOcupadas = [];
        
        if ($grupo->patron && $grupo->hora_inicio) {
            $data = $this->scheduleService->verificarDisponibilidad(
                $grupo->cod_materia,
                $grupo->patron,
                $grupo->hora_inicio
            );
            $aulasDisponibles = $data['disponibles'];
            $aulasOcupadas = $data['ocupadas'];
        }

        return view('grupo.show', compact(
            'grupo', 'diasSemana', 'horariosAgrupados', 'allowedStartTimes',
            'horasOcupadasDelProfesor', 'aulasDisponibles', 'aulasOcupadas'
        ));
    }

    /**
     * Muestra el formulario para editar un grupo.
     */
    public function edit(Grupo $grupo): View
    {
        $grupo->load(['materia', 'profesore', 'periodo']);
        $materias = Materia::where('materia_estado', 'Activa')->pluck('nombre', 'cod_materia');
        $profesores = Profesore::where('situacion', 'Vigente')
            ->selectRaw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) as full_name, n_trabajador")
            ->pluck('full_name', 'n_trabajador');
        $periodos = Periodo::where('activo', true)
            ->selectRaw("CONCAT(periodo_nombre, ' ', anio, ' (', codigo_periodo, ')') as periodo_full, id")
            ->pluck('periodo_full', 'id');

        return view('grupo.edit', compact('grupo', 'materias', 'profesores', 'periodos'));
    }

    /**
     * Actualiza un grupo.
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
        $grupo->update($request->validated());

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo actualizado exitosamente.');
    }

    /**
     * Elimina un grupo.
     */
    public function destroy(Grupo $grupo): RedirectResponse
    {
        $grupo->loadCount('alumnos');

        if ($grupo->alumnos_count > 0) {
            return Redirect::route('grupos.index')
                ->with('error', 'No se puede eliminar el grupo porque tiene ' . $grupo->alumnos_count . ' alumno(s) inscrito(s).');
        }

        try {
            DB::transaction(function () use ($grupo) {
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

    public function detalles(Grupo $grupo): RedirectResponse
    {
         return redirect()->route('grupos.show', $grupo);
    }

    // =====================================================
    // GESTIÓN DE HORARIOS (LÓGICA UNIFICADA)
    // =====================================================

    /**
     * Muestra la vista de gestión visual de horario.
     */
    public function editHorario($id)
    {
        $grupo = Grupo::with(['horarios.aula', 'materia', 'profesore', 'periodo'])->findOrFail($id);
        
        // =======================================================================
        // 1. OBTENER HORARIOS DETALLADOS (Tabla 'horarios')
        // =======================================================================
        // Buscamos horarios del profesor en CUALQUIER periodo activo
        $horarioProfesor = \App\Models\Horario::with(['grupo.materia', 'grupo.periodo', 'aula'])
            ->where('profesore_id', $grupo->n_trabajador)
            ->whereHas('grupo.periodo', function($q) {
                $q->where('activo', true); // ✅ CLAVE: Solo periodos activos
            })
            ->get();

        // =======================================================================
        // 2. OBTENER HORARIOS GENERALES (Tabla 'grupos') - RESPALDO
        // =======================================================================
        // Buscamos grupos que tengan patrón/hora pero que quizás no tengan registros en 'horarios'
        $gruposRespaldo = Grupo::with(['materia', 'periodo'])
            ->where('n_trabajador', $grupo->n_trabajador)
            ->whereNotNull('patron')
            ->whereNotNull('hora_inicio')
            ->whereHas('periodo', function($q) {
                $q->where('activo', true);
            })
            ->get();

        // =======================================================================
        // 3. PROCESAR Y FUSIONAR DATOS EN EL MAPA VISUAL
        // =======================================================================
        $mapaHorario = [];
        $ocupadoLM = []; 
        $ocupadoMJ = []; 

        // A) Procesar registros detallados (Tabla Horarios)
        foreach($horarioProfesor as $h) {
            $this->agregarAlMapa($mapaHorario, $ocupadoLM, $ocupadoMJ, $grupo, 
                $h->dia_semana, 
                $h->hora_inicio, 
                $h->hora_fin, 
                $h->grupo
            );
        }

        // B) Procesar registros generales (Tabla Grupos) - Solo si no existen ya en el mapa
        // Esto cubre el caso que mencionas: datos que están en 'grupos' pero no en 'horarios'
        foreach($gruposRespaldo as $g) {
            // Convertir patrón a días
            $dias = [];
            if ($g->patron == 'L-M') $dias = [1, 3]; // Lunes y Miércoles
            if ($g->patron == 'M-J') $dias = [2, 4]; // Martes y Jueves
            
            // Calculamos fin (asumimos bloque de 2 horas por defecto para visualización)
            $inicio = $g->hora_inicio;
            $fin = \Carbon\Carbon::parse($inicio)->addHours(2)->format('H:i:s');

            foreach($dias as $dia) {
                // Solo agregamos si esa celda está vacía (para no duplicar lo que ya trajo 'horarios')
                $horaInt = (int) \Carbon\Carbon::parse($inicio)->format('H');
                if (!isset($mapaHorario[$dia][$horaInt])) {
                    $this->agregarAlMapa($mapaHorario, $ocupadoLM, $ocupadoMJ, $grupo, 
                        $dia, $inicio, $fin, $g, true
                    );
                }
            }
        }

        $horas = range(7, 20);
        $aulas = \App\Models\Aula::orderBy('nombre')->get();

        return view('grupo.gestion-horario', compact(
            'grupo', 'mapaHorario', 'horas', 'aulas', 'ocupadoLM', 'ocupadoMJ'
        ));
    }

    /**
     * Función auxiliar para no repetir lógica de mapeo
     */
    private function agregarAlMapa(&$mapa, &$occLM, &$occMJ, $grupoActual, $dia, $inicio, $fin, $grupoDatos, $esRespaldo = false)
    {
        $horaInt = (int) \Carbon\Carbon::parse($inicio)->format('H');
        $finInt = (int) \Carbon\Carbon::parse($fin)->format('H');
        $duracion = $finInt - $horaInt;
        
        // Corrección para duración mínima visual
        if ($duracion < 1) $duracion = 1;

        $esEsteGrupo = $grupoDatos->id_grupo == $grupoActual->id_grupo;

        // Si ya está ocupado por un rowspan, no sobrescribir
        if (isset($mapa[$dia][$horaInt]) && $mapa[$dia][$horaInt] === 'ocupado') return;

        // Aula: Si viene de 'horarios' la tiene el objeto principal, si es 'grupo' no tiene
        $nombreAula = 'Sin Aula';
        if (!$esRespaldo && $grupoDatos->horarios && $grupoDatos->horarios->isNotEmpty()) {
             // Intentamos buscar el aula específica de ese horario si es posible, o la primera
             $aulaObj = $grupoDatos->horarios->where('dia_semana', $dia)->first()?->aula;
             $nombreAula = $aulaObj->nombre ?? 'N/A';
        }

        $mapa[$dia][$horaInt] = [
            'materia' => $grupoDatos->materia->nombre ?? 'Materia',
            'codigo' => $grupoDatos->materia->cod_materia ?? '---',
            'grupo' => $grupoDatos->id_grupo,
            'semestre' => $grupoDatos->semestre,
            'aula' => $nombreAula,
            'duracion' => $duracion,
            'es_este_grupo' => $esEsteGrupo,
            'es_respaldo' => $esRespaldo // Para saber si vino de la tabla grupos
        ];

        // Bloquear celdas siguientes
        for($i = 1; $i < $duracion; $i++) {
            $mapa[$dia][$horaInt + $i] = 'ocupado';
        }

        // Lógica de bloqueo para el Select
        if (!$esEsteGrupo) {
            $horaStr = sprintf('%02d:00:00', $horaInt);
            if ($dia == 1 || $dia == 3) $occLM[] = $horaStr;
            if ($dia == 2 || $dia == 4) $occMJ[] = $horaStr;
        }
    }

    /**
     * Guarda el horario completo (Patrón, Hora y Aula).
     */
    /**
     * Guarda el horario completo (Patrón, Hora y Aula).
     */
    public function storeHora(Request $request, Grupo $grupo)
    {
        // 1. Validar todo junto
        $validated = $request->validate([
            'patron' => 'required|in:L-M,M-J',
            'hora_inicio' => 'required',
            'aula_id' => 'required|exists:aulas,id'
        ]);

        // ✅ AGREGAMOS EL BLOQUE TRY-CATCH
        try {
            // 2. Guardar en Transacción
            DB::transaction(function () use ($grupo, $validated) {
                // A. Limpiar horario anterior
                $grupo->horarios()->delete();
                
                // B. Actualizar datos base del grupo
                $grupo->update([
                    'patron' => $validated['patron'],
                    'hora_inicio' => $validated['hora_inicio']
                ]);

                // C. Generar los registros en la tabla 'horarios'
                // Esto es lo que lanza la Excepción si hay choque
                $this->scheduleService->assignSchedule(
                    $grupo->id_grupo,
                    $grupo->cod_materia,
                    $grupo->n_trabajador,
                    $validated['aula_id'],
                    $validated['patron'],
                    $validated['hora_inicio']
                );
            });

            // 3. Redirigir al detalle con éxito si no hubo choque
            return redirect()->route('grupos.show', $grupo->id_grupo)
                ->with('success', 'Horario asignado correctamente.');

        } catch (\Exception $e) {
            // ❌ CAPTURAR EL CHOQUE Y REGRESAR
            // Usamos redirect()->back() para volver al formulario
            // withInput() mantiene lo que el usuario seleccionó
            // with('error', ...) manda el mensaje de la excepción (El texto "🚫 CHOQUE DE AULA...")
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Limpia el horario completo.
     */
    public function destroyHorario(Grupo $grupo): RedirectResponse
    {
        DB::transaction(function () use ($grupo) {
            $grupo->horarios()->delete();
            $grupo->update([
                'patron' => null,
                'hora_inicio' => null
            ]);
        });

        return redirect()->route('grupos.horario.edit', $grupo->id_grupo) // Regresa a la misma vista de gestión
            ->with('success', 'Horario eliminado. Puede asignar uno nuevo.');
    }

    // Métodos obsoletos mantenidos por compatibilidad de rutas antiguas (opcional)
    public function showHoraForm(Grupo $grupo): View|RedirectResponse { return redirect()->route('grupos.show', $grupo); }
    public function showAulaForm(Grupo $grupo): View|RedirectResponse { return redirect()->route('grupos.show', $grupo); }
    public function storeAula(Request $request, Grupo $grupo): RedirectResponse { return redirect()->route('grupos.show', $grupo); }
}
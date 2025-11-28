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
    

    
     * Muestra el formulario para crear un nuevo grupo.
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
     * ✅ MÉTODO show() CORREGIDO Y COMPLETO
     * Muestra la vista de 'detalles' con TODA la información y lógica de formularios.
     */
    public function show($id): View
    {
        // 1. Cargar el grupo con TODAS las relaciones anidadas necesarias
        $grupo = Grupo::with([
            'profesore.area.jefe', // Carga profesor, su area, y el jefe de area
            'materia', 
            'periodo', 
            'alumnos.carrera', // Carga alumnos y la carrera de cada uno
            'horarios.aula'    // Carga los horarios y el aula de cada horario
        ])->findOrFail($id);

        // 2. Lógica para "Horario Actual" (de la antigua vista de detalles)
        $diasSemana = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes'];
        // Agrupar horarios por día, ordenados por hora
        $horariosAgrupados = $grupo->horarios->sortBy('hora_inicio')->groupBy('dia_semana');

        // 3. Lógica para "Paso 1: Patrón y Hora" (de showHoraForm)
        $allowedStartTimes = ['07:00:00', '09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'];

        // 4. Lógica de validación de profesor (la que acabamos de agregar)
        $horasOcupadasDelProfesor = [];
        if ($grupo->profesore && $grupo->periodo) {
            $horasOcupadasDelProfesor = Grupo::where('n_trabajador', $grupo->n_trabajador) // del mismo profesor
                ->where('periodo_id', $grupo->periodo_id)   // en el mismo periodo
                ->where('id_grupo', '!=', $grupo->id_grupo) // pero que no sea este mismo grupo
                ->whereNotNull('hora_inicio')               // que tengan una hora asignada
                ->pluck('hora_inicio')                      // obtenemos solo la hora de inicio
                ->unique()                                  // valores únicos
                ->toArray();                                // convertimos a array
        }

        // 5. Lógica para "Paso 2: Aula" (de showAulaForm)
        $aulasDisponibles = [];
        $aulasOcupadas = [];
        
        // Solo buscar aulas si el Paso 1 (patrón y hora) está completo
        if ($grupo->patron && $grupo->hora_inicio) {
            // Usamos el servicio inyectado en el constructor
            // NOTA: Tu servicio 'verificarDisponibilidad' DEBERÍA probablemente aceptar el periodo_id
            // para ser más preciso y evitar bugs entre periodos.
            $data = $this->scheduleService->verificarDisponibilidad(
                $grupo->cod_materia,
                $grupo->patron,
                $grupo->hora_inicio
                // Ej: $this->scheduleService->verificarDisponibilidad(..., $grupo->periodo_id)
            );
            $aulasDisponibles = $data['disponibles'];
            $aulasOcupadas = $data['ocupadas'];
        }

        // 6. Retornar la vista con TODAS las variables
        return view('grupo.show', compact(
            'grupo',
            'diasSemana',
            'horariosAgrupados',
            'allowedStartTimes',
            'horasOcupadasDelProfesor',
            'aulasDisponibles',
            'aulasOcupadas'
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
                $grupo->horarios()->delete(); // Elimina horarios asociados
                $grupo->delete(); // Elimina el grupo
            });

            return Redirect::route('grupos.index')
                ->with('success', 'Grupo y su horario eliminados exitosamente.');
        } catch (\Exception $e) {
            return Redirect::route('grupos.index')
                ->with('error', 'Error al eliminar el grupo: ' . $e->getMessage());
        }
    }

    /**
     * MÉTODO detalles() AHORA OBSOLETO
     * Redirigimos a 'show' para mantener una única ruta de detalles.
     */
    public function detalles(Grupo $grupo): RedirectResponse
    {
         return redirect()->route('grupos.show', $grupo);
    }

    // =====================================================
    // PASO 1: ASIGNAR HORA Y PATRÓN
    // =====================================================

    /**
     * Muestra el formulario independiente para asignar hora (Paso 1).
     * ESTE MÉTODO YA NO ES NECESARIO, la lógica está en show()
     */
    public function showHoraForm(Grupo $grupo): View
    {
        // Esta lógica ahora vive en show()
        // Redirigir por si acaso alguien entra a la ruta antigua
        return redirect()->route('grupos.show', $grupo);
    }

    /**
     * Almacena el patrón/hora y borra el horario antiguo.
     * Redirige a 'grupos.show' (que ahora es 'detalles').
     */
    public function storeHora(Request $request, Grupo $grupo): RedirectResponse
    {
        $validated = $request->validate([
            'patron' => 'required|in:L-M,M-J',
            'hora_inicio' => 'required'
        ]);

        // Validar que la hora no esté ocupada por el profesor
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

        if (in_array($validated['hora_inicio'], $horasOcupadasDelProfesor)) {
            return redirect()->route('grupos.show', $grupo)
                ->with('error', 'Esa hora está ocupada por el profesor en otro grupo.');
        }

        DB::transaction(function () use ($grupo, $validated) {
            // 1. Borrar horario existente (entradas en tabla 'horarios')
            $grupo->horarios()->delete();
            
            // 2. Actualizar el grupo con el nuevo patrón/hora base
            $grupo->update([
                'patron' => $validated['patron'],
                'hora_inicio' => $validated['hora_inicio']
            ]);
        });
        
        // 3. Redirigir de vuelta a la página 'show'
        return redirect()->route('grupos.show', $grupo)
            ->with('success', 'Patrón de hora actualizado. Ahora seleccione un aula.');
    }

    // =====================================================
    // PASO 2: ASIGNAR AULA SEGÚN HORARIO GUARDADO
    // =====================================================

    /**
     * Muestra el formulario independiente para asignar aula (Paso 2).
     * ESTE MÉTODO YA NO ES NECESARIO, la lógica está en show()
     */
    public function showAulaForm(Grupo $grupo): View|RedirectResponse
    {
        // Esta lógica ahora vive en show()
        // Redirigir por si acaso alguien entra a la ruta antigua
        return redirect()->route('grupos.show', $grupo);
    }

    /**
     * Almacena el aula y genera el horario.
     * Redirige a 'grupos.show' (que ahora es 'detalles').
     */
    public function storeAula(Request $request, Grupo $grupo): RedirectResponse
    {
        $validated = $request->validate([
            'aula_id' => 'required|exists:aulas,id'
        ]);

        // 1. Borrar cualquier horario anterior
        $grupo->horarios()->delete();

        // 2. Llamar al servicio para crear las nuevas entradas
        $this->scheduleService->assignSchedule(
            $grupo->id_grupo,
            $grupo->cod_materia,
            $grupo->n_trabajador, // Asumiendo que n_trabajador está en grupo
            $validated['aula_id'],
            $grupo->patron,
            $grupo->hora_inicio
        );

        // 3. Redirigir de vuelta a 'show'
        return redirect()->route('grupos.show', $grupo)
            ->with('success', 'Aula asignada y horario completado correctamente.');
    }

    /**
     * Limpia el horario completo (entradas en 'horarios' y campos en 'grupos')
     * Redirige a 'grupos.show'.
     */
    public function destroyHorario(Grupo $grupo): RedirectResponse
    {
        DB::transaction(function () use ($grupo) {
            // 1. Borrar entradas de la tabla 'horarios'
            $grupo->horarios()->delete();
            
            // 2. Limpiar los campos base en 'grupos'
            $grupo->update([
                'patron' => null,
                'hora_inicio' => null
            ]);
        });

        return redirect()->route('grupos.show', $grupo)
            ->with('success', 'Horario eliminado. Puede asignar uno nuevo.');
    }
}
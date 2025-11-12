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
use Illuminate\Support\Facades\DB; // Importación de DB
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
        $grupos = Grupo::with(['materia', 'profesore', 'periodo'])
            ->withCount('horarios')
            ->paginate(30);

        return view('grupo.index', compact('grupos'))
            ->with('i', ($request->input('page', 1) - 1) * $grupos->perPage());
    }

    /**
     * Muestra el formulario para crear un nuevo grupo.
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
     * ✅ MÉTODO show() MODIFICADO
     * Muestra la vista de 'detalles' con toda la información del grupo y los formularios de horario.
     */
    public function show(Grupo $grupo): View
    {
        $grupo->load([
            'materia',
            'profesore.area', // Cargamos el área del profesor
            'periodo',
            'alumnos.carrera', // Cargamos la carrera de los alumnos
            'horarios' => function ($query) {
                $query->orderBy('dia_semana')->orderBy('hora_inicio');
            },
            'horarios.aula' // Cargamos el aula del horario
        ]);
        
        // Datos para la tabla de horario actual
        $horariosAgrupados = $grupo->horarios->groupBy('dia_semana');
        $diasSemana = [
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
            4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'
        ];

        // Datos para el "Paso 1: Asignar Hora"
        $allowedStartTimes = ['07:00:00', '09:00:00', '11:00:00', '13:00:00', '15:00:00'];

        // Datos para el "Paso 2: Asignar Aula"
        $aulasDisponibles = [];
        $aulasOcupadas = [];

        // Solo buscamos aulas si el grupo YA tiene un patrón y hora definidos
        if ($grupo->patron && $grupo->hora_inicio) {
            $data = $this->scheduleService->verificarDisponibilidad(
                $grupo->cod_materia,
                $grupo->patron,
                $grupo->hora_inicio
            );
            $aulasDisponibles = $data['disponibles'];
            $aulasOcupadas = $data['ocupadas'];
        }

        // ❗️ CAMBIO CLAVE: Apuntamos a 'grupo.detalles'
        return view('grupo.detalles', compact(
            'grupo', 
            'horariosAgrupados', 
            'diasSemana',
            'allowedStartTimes',
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
     * La ruta 'grupos.show' (Route::resources) ahora maneja esta lógica.
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
     */
    public function showHoraForm(Grupo $grupo): View
    {
        $allowedStartTimes = ['07:00:00', '09:00:00', '11:00:00', '13:00:00', '15:00:00'];
        return view('grupo.asignar-hora', compact('grupo', 'allowedStartTimes'));
    }

    /**
     * ✅ MÉTODO storeHora() MODIFICADO
     * Almacena el patrón/hora y borra el horario antiguo.
     * Redirige a 'grupos.show' (que ahora es 'detalles').
     */
    public function storeHora(Request $request, Grupo $grupo): RedirectResponse
    {
        $validated = $request->validate([
            'patron' => 'required|in:L-M,M-J',
            'hora_inicio' => 'required'
        ]);

        DB::transaction(function () use ($grupo, $validated) {
            // 1. Borrar horario existente (entradas en tabla 'horarios')
            $grupo->horarios()->delete();
            
            // 2. Actualizar el grupo con el nuevo patrón/hora base
            $grupo->update([
                'patron' => $validated['patron'],
                'hora_inicio' => $validated['hora_inicio']
            ]);
        });
        
        // 3. Redirigir de vuelta a la página 'show' (que renderiza 'detalles')
        return redirect()->route('grupos.show', $grupo)
            ->with('success', 'Patrón de hora actualizado. Ahora seleccione un aula.');
    }

    // =====================================================
    // PASO 2: ASIGNAR AULA SEGÚN HORARIO GUARDADO
    // =====================================================

    /**
     * Muestra el formulario independiente para asignar aula (Paso 2).
     */
    public function showAulaForm(Grupo $grupo): View|RedirectResponse
    {
        if (!$grupo->patron || !$grupo->hora_inicio) {
            return redirect()->route('grupos.hora.show', $grupo)
                ->with('error', 'Primero debes definir patrón y hora.');
        }

        $data = $this->scheduleService->verificarDisponibilidad(
            $grupo->cod_materia,
            $grupo->patron,
            $grupo->hora_inicio
        );

        return view('grupo.asignar-aula', [
            'grupo' => $grupo,
            'aulasDisponibles' => $data['disponibles'],
            'aulasOcupadas' => $data['ocupadas']
        ]);
    }

    /**
     * ✅ MÉTODO storeAula() MODIFICADO
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
            $grupo->n_trabajador,
            $validated['aula_id'],
            $grupo->patron,
            $grupo->hora_inicio
        );

        // 3. Redirigir de vuelta a 'show' (que renderiza 'detalles')
        return redirect()->route('grupos.show', $grupo)
            ->with('success', 'Aula asignada y horario completado correctamente.');
    }

    /**
     * ✅ NUEVO MÉTODO: destroyHorario()
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
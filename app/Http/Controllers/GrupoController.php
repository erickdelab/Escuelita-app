<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia; // [cite: 50-51]
use App\Models\Profesore; // [cite: 52-55]
use App\Models\Periodo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\GrupoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GrupoController extends Controller
{
    /**
     * Muestra una lista de los Grupos.
     */
    public function index(Request $request): View
    {
        $grupos = Grupo::with(['materia', 'profesore', 'periodo'])->paginate(30);

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

        return view('grupo.create', compact('grupo', 'materias', 'profesores', 'periodos'));
    }

    /**
     * Guarda un nuevo grupo en la base de datos.
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        Grupo::create($request->validated());

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo creado exitosamente.');
    }

    /**
     * --- MÉTODO ACTUALIZADO ---
     * Muestra los detalles de un grupo, incluyendo su horario.
     */
    public function show(Grupo $grupo): View
    {
        // 1. Carga optimizada de todas las relaciones
        $grupo->load([
            'materia',      // Relación que ya tenías
            'profesore',    // Relación que ya tenías
            'periodo',      // Relación que ya tenías
            'alumnos',      // Relación que ya tenías
            
            // --- Nueva Lógica de Horarios ---
            'horarios' => function ($query) {
                // Ordenamos los bloques por día y luego por hora
                $query->orderBy('dia_semana', 'asc')
                      ->orderBy('hora_inicio', 'asc');
            },
            'horarios.materia',    // Materia del bloque de horario
            'horarios.profesore',  // Profesor del bloque de horario
            'horarios.aula'        // Aula del bloque de horario
        ]);

        // 2. Agrupamos la colección de horarios por el 'dia_semana' (1, 2, 3...)
        $horariosAgrupados = $grupo->horarios->groupBy('dia_semana');

        // 3. Un array simple para "traducir" los números de día
        $diasSemana = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            // 6 => 'Sábado' (si lo llegas a usar)
        ];

        // 4. Pasamos todo a la vista (la misma vista 'grupo.show' que ya tenías)
        // La vista `grupos.show.blade.php` que te di antes
        // funcionará con estas variables.
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

        return view('grupo.edit', compact('grupo', 'materias', 'profesores', 'periodos'));
    }

    /**
     * Actualiza la información de un grupo.
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
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
            $grupo->delete();
            return Redirect::route('grupos.index')
                ->with('success', 'Grupo eliminado exitosamente.');
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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profesore;
use App\Models\Grupo;
use App\Models\AlumnoGrupo;   // <-- IMPORTANTE
use Carbon\Carbon;

class TeacherPortalController extends Controller
{
    /**
     * Obtener el objeto Profesor del usuario autenticado.
     */
    private function getProfesor()
    {
        $user = Auth::user();
        if (!$user || !$user->n_trabajador_link) {
            abort(403, 'Usuario no vinculado a un profesor.');
        }
        return Profesore::with('area')->findOrFail($user->n_trabajador_link);
    }

    /**
     * Vista de Inicio (Dashboard).
     */
    public function dashboard()
    {
        $profesor = $this->getProfesor();
        
        $totalGrupos = $profesor->grupos()->count();
        $totalAlumnos = Grupo::where('n_trabajador', $profesor->n_trabajador)
                             ->withCount('alumnos')
                             ->get()
                             ->sum('alumnos_count');

        return view('teacher.dashboard', compact('profesor', 'totalGrupos', 'totalAlumnos'));
    }

    /**
     * Vista de Horario Gráfico.
     */
    public function horario()
    {
        $profesor = $this->getProfesor();
        $grupos = $profesor->grupos()->with(['materia', 'horarios.aula'])->get();

        $calendario = [];
        $horasDisponibles = range(7, 20);

        $colores = ['#FFD1DC', '#D1E8E2', '#FFF4E0', '#E0F7FA', '#F3E5F5', '#F0F4C3', '#FFCCBC', '#CFD8DC', '#E1BEE7', '#B2DFDB'];
        $materiasColor = [];
        $colorIndex = 0;

        foreach ($grupos as $grupo) {
            if (!isset($materiasColor[$grupo->cod_materia])) {
                $materiasColor[$grupo->cod_materia] = $colores[$colorIndex % count($colores)];
                $colorIndex++;
            }

            foreach ($grupo->horarios as $horario) {
                $dia = $horario->dia_semana;
                $horaInicio = (int) Carbon::parse($horario->hora_inicio)->format('H');
                $horaFin = (int) Carbon::parse($horario->hora_fin)->format('H');
                $duracion = $horaFin - $horaInicio;

                $calendario[$dia][$horaInicio] = [
                    'materia' => $grupo->materia->nombre ?? 'Materia N/A',
                    'codigo' => $grupo->materia->cod_materia ?? '---',
                    'semestre' => $grupo->semestre,
                    'grupo_id' => $grupo->id_grupo,
                    'aula' => $horario->aula->nombre ?? 'N/A',
                    'duracion' => $duracion,
                    'color' => $materiasColor[$grupo->cod_materia]
                ];

                for ($h = $horaInicio + 1; $h < $horaFin; $h++) {
                    $calendario[$dia][$h] = 'ocupado';
                }
            }
        }

        return view('teacher.horario', compact('profesor', 'calendario', 'horasDisponibles'));
    }

    /**
     * Listado de Grupos asignados.
     */
    public function grupos()
    {
        $profesor = $this->getProfesor();
        $grupos = Grupo::with(['materia', 'periodo'])
            ->withCount('alumnos')
            ->where('n_trabajador', $profesor->n_trabajador)
            ->orderBy('id_grupo', 'desc')
            ->get();

        return view('teacher.grupos', compact('profesor', 'grupos'));
    }

    /**
     * Detalle de un Grupo específico.
     */
    public function grupoShow($id_grupo)
    {
        $profesor = $this->getProfesor();

        $grupo = Grupo::with(['materia', 'periodo', 'alumnos.carrera', 'horarios.aula'])
            ->where('id_grupo', $id_grupo)
            ->where('n_trabajador', $profesor->n_trabajador)
            ->firstOrFail();

        $diasSemana = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes'];
        $horariosAgrupados = $grupo->horarios->sortBy('hora_inicio')->groupBy('dia_semana');

        return view('teacher.grupo-show', compact('grupo', 'diasSemana', 'horariosAgrupados'));
    }

    /**
     * Vista para calificar alumnos del grupo.
     */
    public function calificar($id_grupo)
    {
        $profesor = $this->getProfesor();

        // 1. Validar que el grupo pertenezca al profesor
        $grupo = Grupo::with(['materia', 'periodo'])
            ->where('id_grupo', $id_grupo)
            ->where('n_trabajador', $profesor->n_trabajador)
            ->firstOrFail();

        // 2. Obtener alumnos inscritos con calificaciones
        $inscripciones = AlumnoGrupo::where('id_grupo', $id_grupo)
            ->with(['alumno', 'calificacion'])
            ->get()
            ->sortBy(fn($q) => $q->alumno->ap_pat);

        return view('teacher.calificar', compact('grupo', 'inscripciones'));
    }
}

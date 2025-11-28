<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use App\Models\Materia;
use Carbon\Carbon;

class StudentPortalController extends Controller
{
    private function getAlumno()
    {
        $user = Auth::user();
        if (!$user || !$user->n_control_link) {
            abort(403, 'Usuario no vinculado a un alumno.');
        }
        return Alumno::with('carrera')->findOrFail($user->n_control_link);
    }

    public function dashboard()
    {
        $alumno = $this->getAlumno();
        return view('student.dashboard', compact('alumno'));
    }

    public function horario()
    {
        $alumno = $this->getAlumno();
        $grupos = $alumno->grupos()->with(['materia', 'profesore', 'horarios.aula'])->get();

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
                $horaInicio = (int) \Carbon\Carbon::parse($horario->hora_inicio)->format('H');
                $horaFin = (int) \Carbon\Carbon::parse($horario->hora_fin)->format('H');
                $duracion = $horaFin - $horaInicio;

                $calendario[$dia][$horaInicio] = [
                    'materia' => $grupo->materia->nombre,
                    'codigo' => $grupo->materia->cod_materia,
                    'profesor' => $grupo->profesore ? $grupo->profesore->nombre . ' ' . $grupo->profesore->ap_paterno : 'N/A',
                    'aula' => $horario->aula->nombre ?? 'N/A',
                    'duracion' => $duracion,
                    'color' => $materiasColor[$grupo->cod_materia],
                    'grupo' => $grupo->id_grupo
                ];

                for ($h = $horaInicio + 1; $h < $horaFin; $h++) {
                    $calendario[$dia][$h] = 'ocupado';
                }
            }
        }

        return view('student.horario', compact('alumno', 'calendario', 'horasDisponibles'));
    }

    public function calificaciones(Request $request)
    {
        $alumno = $this->getAlumno();
        $n_control = $alumno->n_control;

        $cargaActual = \App\Models\AlumnoGrupo::with(['grupo.materia', 'grupo.profesore', 'grupo.horarios.aula', 'calificacion'])
            ->where('n_control', $n_control)
            ->get();

        $periodosDisponibles = \App\Models\Periodo::orderBy('anio', 'desc')->orderBy('id', 'desc')->pluck('codigo_periodo');

        $boletasHistorial = collect();
        $mensajeHistorial = null;
        $periodoSeleccionado = $request->input('periodo_select');

        if ($periodoSeleccionado) {
            $boletasHistorial = \App\Models\Boleta::with(['materia', 'profesor'])
                ->where('n_control', $n_control)
                ->where('periodo', $periodoSeleccionado)
                ->get();

            if ($boletasHistorial->isEmpty()) {
                $mensajeHistorial = "No se encontraron registros para el periodo seleccionado.";
            }
        }

        return view('student.calificaciones', compact('alumno', 'cargaActual', 'periodosDisponibles', 'boletasHistorial', 'mensajeHistorial', 'periodoSeleccionado'));
    }

    // =========================================================
    // 🔥 AQUÍ ESTÁ LA CORRECCIÓN DEL KARDEX
    // =========================================================
    public function kardex()
    {
        $alumno = $this->getAlumno();
        $n_control = $alumno->n_control;

        // 1. Obtener todas las materias (filtrar por prefijo de carrera si es necesario)
        $todasLasMaterias = Materia::where('cod_materia', 'like', 'TICS%') 
                                   ->orderBy('semestre')
                                   ->orderBy('cod_materia')
                                   ->get();

        // 2. Historial de materias aprobadas/reprobadas
        $historial = \App\Models\Boleta::where('n_control', $n_control)
                           ->get()
                           ->keyBy('cod_materia');

        // 3. Materias que está cursando actualmente
        $cargaActual = $alumno->grupos->pluck('cod_materia')->toArray();

        foreach ($todasLasMaterias as $materia) {
            $codigo = trim($materia->cod_materia);
            
            // --- ESTADO POR DEFECTO (PENDIENTE) ---
            $materia->clase_css = 'bg-light text-dark border-secondary'; 
            $materia->calificacion_mostrar = null;
            $materia->aprobada = false; 
            $materia->bloqueada = false;

            // --- A. REVISAR HISTORIAL ---
            if ($historial->has($codigo)) {
                $registro = $historial[$codigo];
                $materia->calificacion_mostrar = $registro->calificacion;

                if ($registro->calificacion >= 70) {
                    $materia->clase_css = 'bg-success text-white'; // Aprobada
                    $materia->aprobada = true;
                } else {
                    // Reprobada
                    if ($registro->oportunidad == 'Especial') {
                        $materia->clase_css = 'bg-danger text-white';
                    } elseif ($registro->oportunidad == 'Repite') {
                        $materia->clase_css = 'bg-warning text-dark';
                    } else {
                        $materia->clase_css = 'bg-secondary text-white';
                    }
                }
            }

            // --- B. REVISAR CARGA ACTUAL ---
            $estaCursando = in_array($codigo, $cargaActual);
            if ($estaCursando && !$materia->aprobada) {
                $materia->clase_css = 'bg-info text-dark border-primary'; // Cursando
            }

            // --- C. 🔥 LÓGICA DE PRERREQUISITOS (BLOQUEO) 🔥 ---
            // Si NO está aprobada y NO la está cursando, verificar si cumple el requisito previo
            if (!$materia->aprobada && !$estaCursando && !empty($materia->prerrequisito)) {
                $codigoPrereq = trim($materia->prerrequisito);
                $prereqCumplido = false;

                // Buscamos si la materia prerrequisito existe en el historial y fue aprobada
                if ($historial->has($codigoPrereq)) {
                    if ($historial[$codigoPrereq]->calificacion >= 70) {
                        $prereqCumplido = true;
                    }
                }

                // Si no cumple el prerrequisito, se bloquea visualmente
                if (!$prereqCumplido) {
                    $materia->bloqueada = true;
                    $materia->clase_css = 'bg-locked text-muted'; // Clase CSS para bloqueada
                }
            }
        }

        $reticula = $todasLasMaterias->groupBy('semestre');
        $maxSemestres = 9; 

        return view('student.kardex', compact('alumno', 'reticula', 'maxSemestres'));
    }

    public function carga()
    {
        $alumno = $this->getAlumno();
        return view('student.carga', compact('alumno'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\AlumnoGrupo;
use App\Models\CalificacionGrupo;
use App\Models\Alumno; // Asegúrate de importar Alumno para la baja
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Boleta;

class CalificacionController extends Controller
{
    // Mostrar la vista de calificación
    public function index($id_grupo)
    {
        $grupo = Grupo::with('materia', 'profesore')->findOrFail($id_grupo);
        
        $inscripciones = AlumnoGrupo::where('id_grupo', $id_grupo)
            ->with(['alumno', 'calificacion']) 
            ->get();

        // ✅ AQUÍ ESTÁ LA CLAVE: La vista debe ser 'grupo.calificar'
        // Esto busca el archivo en resources/views/grupo/calificar.blade.php
        return view('grupo.calificar', compact('grupo', 'inscripciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_grupo_id' => 'required|exists:alumno_grupo,id',
            'u1' => 'nullable|numeric|min:0|max:100',
            'u2' => 'nullable|numeric|min:0|max:100',
            'u3' => 'nullable|numeric|min:0|max:100',
            'u4' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $inscripcion = AlumnoGrupo::findOrFail($request->alumno_grupo_id);
            
            // Calcular Promedio
            $promedio = null;
            if (isset($request->u1, $request->u2, $request->u3, $request->u4)) {
                $promedio = ($request->u1 + $request->u2 + $request->u3 + $request->u4) / 4;
            }

            // Guardar Calificaciones
            CalificacionGrupo::updateOrCreate(
                ['alumno_grupo_id' => $inscripcion->id],
                [
                    'u1' => $request->u1,
                    'u2' => $request->u2,
                    'u3' => $request->u3,
                    'u4' => $request->u4,
                    'promedio' => $promedio
                ]
            );

            // Lógica de Cambio de Oportunidad
            if ($promedio !== null) {
                if ($promedio >= 70) {
                    $inscripcion->oportunidad = 'Aprobada';
                    $inscripcion->save();
                } else {
                    if ($inscripcion->oportunidad == 'Primera') {
                        $inscripcion->oportunidad = 'Repite';
                        $inscripcion->save();
                    } elseif ($inscripcion->oportunidad == 'Repite') {
                        $inscripcion->oportunidad = 'Especial';
                        $inscripcion->save();
                    } elseif ($inscripcion->oportunidad == 'Especial') {
                        $this->ejecutarBajaDefinitiva($inscripcion->n_control);
                    }
                }
            }
        });

        return back()->with('success', 'Calificaciones guardadas correctamente.');
    }

    private function ejecutarBajaDefinitiva($n_control)
    {
        Alumno::where('n_control', $n_control)->update([
            'situacion' => 'Baja',
            'FKid_carrera' => null,
            'semestre' => null,
            'promedio_general' => null
        ]);
        AlumnoGrupo::where('n_control', $n_control)->delete();
    }

    public function finalizarCurso($alumno_grupo_id)
    {
        // 1. Buscar la inscripción con todas las relaciones necesarias
        $inscripcion = AlumnoGrupo::with([
            'calificacion', 
            'grupo.periodo'
        ])->findOrFail($alumno_grupo_id);

        // 2. Crear el registro en la tabla Boletas (Snapshot)
        Boleta::create([
            'n_control'    => $inscripcion->n_control,
            'cod_materia'  => $inscripcion->grupo->cod_materia,
            'periodo'      => $inscripcion->grupo->periodo->codigo_periodo ?? 'N/A',
            'calificacion' => $inscripcion->calificacion->promedio ?? null, // Si no tiene promedio, va null
            'oportunidad'  => $inscripcion->oportunidad,
            'n_trabajador' => $inscripcion->grupo->n_trabajador,
            'id_grupo'     => $inscripcion->id_grupo,
        ]);

        // 3. Eliminar la inscripción activa (y sus calificaciones parciales por cascada)
        // Esto libera al alumno del grupo actual.
        $inscripcion->delete();

        return back()->with('success', 'Curso finalizado y movido a boleta exitosamente.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\AlumnoGrupo;
use App\Models\CalificacionGrupo;
use App\Models\Alumno; // Asegúrate de importar Alumno para la baja
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function desinscribir($alumno_grupo_id)
    {
        AlumnoGrupo::destroy($alumno_grupo_id);
        return back()->with('success', 'Alumno desinscrito del grupo.');
    }
}
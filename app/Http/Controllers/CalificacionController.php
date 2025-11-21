<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\AlumnoGrupo;
use App\Models\CalificacionGrupo;
use App\Models\Boleta;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    public function index($id_grupo)
    {
        $grupo = Grupo::with('materia', 'profesore')->findOrFail($id_grupo);
        
        $inscripciones = AlumnoGrupo::where('id_grupo', $id_grupo)
            ->with(['alumno', 'calificacion']) 
            ->get();

        return view('grupo.calificar', compact('grupo', 'inscripciones'));
    }

    // ✅ Guarda calificaciones y aplica la REGLA DEL CERO
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
            
            $promedio = null;
            
            // Solo calculamos si las 4 unidades tienen valor
            if (isset($request->u1, $request->u2, $request->u3, $request->u4)) {
                
                // 🔥 REGLA DE ORO: Si alguna unidad es < 70, el promedio es 0 automático.
                if ($request->u1 < 70 || $request->u2 < 70 || $request->u3 < 70 || $request->u4 < 70) {
                    $promedio = 0; 
                } else {
                    // Si todas son >= 70, se calcula el promedio matemático
                    $promedio = ($request->u1 + $request->u2 + $request->u3 + $request->u4) / 4;
                }
            }

            // Guardar o Actualizar
            CalificacionGrupo::updateOrCreate(
                ['alumno_grupo_id' => $inscripcion->id],
                [
                    'u1' => $request->u1,
                    'u2' => $request->u2,
                    'u3' => $request->u3,
                    'u4' => $request->u4,
                    'promedio' => $promedio // Se guarda 0 o el cálculo real
                ]
            );
        });

        return back()->with('success', 'Calificaciones guardadas. Si hay una unidad reprobada, el promedio será 0.');
    }

 // ... (resto del código anterior igual) ...

    // ✅ Finaliza y mueve a Boleta (Con lógica de BAJA DEFINITIVA)
    public function finalizarCurso($alumno_grupo_id)
    {
        $inscripcion = AlumnoGrupo::with([
            'calificacion', 
            'grupo.periodo'
        ])->findOrFail($alumno_grupo_id);

        // 1. Validar que ya exista un promedio calculado
        if (!$inscripcion->calificacion || is_null($inscripcion->calificacion->promedio)) {
            return back()->with('error', 'No se puede finalizar. Faltan calificaciones.');
        }

        $calificacionFinal = $inscripcion->calificacion->promedio;
        $n_control = $inscripcion->n_control;

        // 2. Crear registro en Boleta (Guardamos el historial antes de borrar nada)
        Boleta::create([
            'n_control'    => $n_control,
            'cod_materia'  => $inscripcion->grupo->cod_materia,
            'periodo'      => $inscripcion->grupo->periodo->codigo_periodo ?? 'N/A',
            'calificacion' => $calificacionFinal,
            'oportunidad'  => $inscripcion->oportunidad,
            'n_trabajador' => $inscripcion->grupo->n_trabajador,
            'id_grupo'     => $inscripcion->id_grupo,
        ]);

        // 3. 🚨 LÓGICA DE BAJA DEFINITIVA 🚨
        // Si estaba en 'Especial' y reprobó (< 70)
        if ($inscripcion->oportunidad == 'Especial' && $calificacionFinal < 70) {
            
            // A. Cambiar estatus del alumno a 'Baja'
            Alumno::where('n_control', $n_control)->update([
                'situacion' => 'Baja',
                // Opcional: Limpiar otros datos si tu lógica lo requiere
                // 'semestre' => null, 
            ]);

            // B. Dar de baja de TODOS los grupos actuales (incluyendo este y otros que curse)
            AlumnoGrupo::where('n_control', $n_control)->delete();

            return back()->with('error', 'El alumno ha reprobado en Especial. Se aplicó BAJA DEFINITIVA y se eliminaron sus cargas académicas.');
        }

        // 4. Si no fue baja definitiva, solo eliminamos la inscripción actual (la que finalizó)
        $inscripcion->delete();

        return back()->with('success', 'Curso finalizado correctamente. Calificación asentada en Boleta.');
    }
}
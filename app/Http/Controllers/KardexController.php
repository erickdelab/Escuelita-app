<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Boleta;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function show($n_control)
    {
        $alumno = Alumno::findOrFail($n_control);

        // 1. Obtener TODAS las materias del plan (TICS)
        $todasLasMaterias = Materia::where('cod_materia', 'like', 'TICS%')
                                   ->orderBy('semestre')
                                   ->orderBy('cod_materia')
                                   ->get();

        // 2. Obtener historial del alumno
        $historial = Boleta::where('n_control', $n_control)
                           ->get()
                           ->keyBy('cod_materia');

        // 3. Procesar lógica de estados y prerrequisitos
        foreach ($todasLasMaterias as $materia) {
            $codigo = $materia->cod_materia;
            
            // Valores base (Gris / Pendiente)
            $materia->clase_css = 'bg-light text-dark border-secondary'; 
            $materia->calificacion_mostrar = null;
            $materia->bloqueada = false; // Por defecto no está bloqueada

            // A. ¿Ya la cursó el alumno?
            if ($historial->has($codigo)) {
                $registro = $historial[$codigo];
                $materia->calificacion_mostrar = $registro->calificacion;

                if ($registro->calificacion >= 70) {
                    $materia->clase_css = 'bg-success text-white'; // Aprobada
                } else {
                    if ($registro->oportunidad == 'Repite') {
                        $materia->clase_css = 'bg-warning text-dark'; // Repite
                    } elseif ($registro->oportunidad == 'Especial') {
                        $materia->clase_css = 'bg-danger text-white'; // Especial
                    } else {
                        $materia->clase_css = 'bg-secondary text-white'; // Reprobada normal
                    }
                }
            } 
            // B. Si NO la ha cursado, verificamos prerrequisitos
            else {
                if ($materia->prerrequisito) {
                    $codigoPrereq = $materia->prerrequisito;
                    $prereqAprobado = false;

                    // Buscamos si el prerrequisito existe en el historial Y si pasó
                    if ($historial->has($codigoPrereq)) {
                        if ($historial[$codigoPrereq]->calificacion >= 70) {
                            $prereqAprobado = true;
                        }
                    }

                    // Si el prerrequisito NO está aprobado, bloqueamos esta materia
                    if (!$prereqAprobado) {
                        $materia->bloqueada = true;
                        // Opcional: Hacerla visualmente más tenue
                        $materia->clase_css = 'bg-light text-muted border-light opacity-75'; 
                    }
                }
            }
        }

        // 4. Agrupar por columnas (semestres)
        $reticula = $todasLasMaterias->groupBy('semestre');
        $maxSemestres = 9; 

        return view('kardex.show', compact('alumno', 'reticula', 'maxSemestres'));
    }
}
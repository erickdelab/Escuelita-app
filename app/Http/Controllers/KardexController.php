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
        // Cargar alumno con sus grupos actuales para saber qué está cursando
        $alumno = Alumno::with('grupos')->findOrFail($n_control);

        // 1. Obtener materias de TICS ordenadas para el Grid
        $todasLasMaterias = Materia::where('cod_materia', 'like', 'TICS%')
                                   ->orderBy('semestre')
                                   ->orderBy('cod_materia')
                                   ->get();

        // 2. Obtener historial académico (Boleta)
        $historial = Boleta::where('n_control', $n_control)
                           ->get()
                           ->keyBy('cod_materia');

        // 3. Obtener carga actual (IDs de materias que está cursando hoy)
        $cargaActual = $alumno->grupos->pluck('cod_materia')->toArray();

        // 4. Procesar lógica de cada materia
        foreach ($todasLasMaterias as $materia) {
            // Limpiar código de espacios
            $codigo = trim($materia->cod_materia);
            
            // --- ESTADO INICIAL ---
            $materia->clase_css = 'bg-light text-dark border-secondary'; // Gris (Pendiente)
            $materia->calificacion_mostrar = null;
            $materia->bloqueada = false;
            $materia->aprobada = false; // Bandera interna

            // --- A. VERIFICAR HISTORIAL (PASADO) ---
            if ($historial->has($codigo)) {
                $registro = $historial[$codigo];
                $materia->calificacion_mostrar = $registro->calificacion;

                if ($registro->calificacion >= 70) {
                    $materia->clase_css = 'bg-success text-white'; // Verde Fuerte
                    $materia->aprobada = true;
                } else {
                    // Reprobada
                    if ($registro->oportunidad == 'Especial') {
                        $materia->clase_css = 'bg-danger text-white'; // Rojo
                    } elseif ($registro->oportunidad == 'Repite') {
                        $materia->clase_css = 'bg-warning text-dark'; // Amarillo
                    } else {
                        $materia->clase_css = 'bg-secondary text-white'; // Reprobada normal
                    }
                }
            }

            // --- B. VERIFICAR CARGA ACTUAL (PRESENTE) ---
            // Si la está cursando y no la ha aprobado antes, se pone verde claro
            if (in_array($codigo, $cargaActual) && !$materia->aprobada) {
                $materia->clase_css = 'bg-cursando text-dark border-success'; 
                $materia->calificacion_mostrar = null; // Aún no hay calificación final
            }

            // --- C. LÓGICA DE PRERREQUISITOS (FUTURO) ---
            // Si NO está aprobada y NO la está cursando, validamos candados
            $estaCursando = in_array($codigo, $cargaActual);
            
            if (!$materia->aprobada && !$estaCursando && !empty($materia->prerrequisito)) {
                $codigoPrereq = trim($materia->prerrequisito);
                $prereqCumplido = false;

                // Buscamos si el prerrequisito fue aprobado en el historial
                if ($historial->has($codigoPrereq)) {
                    if ($historial[$codigoPrereq]->calificacion >= 70) {
                        $prereqCumplido = true;
                    }
                }

                // Si no cumple, se bloquea
                if (!$prereqCumplido) {
                    $materia->bloqueada = true;
                    $materia->clase_css = 'bg-locked text-muted'; // Estilo especial
                }
            }
        }

        // Agrupar por columnas (Semestres)
        $reticula = $todasLasMaterias->groupBy('semestre');
        $maxSemestres = 9; 

        return view('kardex.show', compact('alumno', 'reticula', 'maxSemestres'));
    }
}
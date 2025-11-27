<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Boleta; 
use App\Models\Profesore;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AlumnoGrupoController extends Controller
{
    /**
     * Mostrar formulario para inscribir alumno a grupos
     */
    public function create($n_control): View|RedirectResponse
    {
        // 1. Cargar al alumno
        $alumno = Alumno::with([
            'grupos.materia',
            'grupos.profesore',
            'grupos.horarios.aula'
        ])->findOrFail($n_control);

        // 🚨 BLOQUEO POR BAJA
        if ($alumno->situacion == 'Baja') {
            return redirect()->route('alumnos.show', $n_control)
                ->with('error', 'ESTUDIANTE EN BAJA: No es posible inscribir materias.');
        }

        // ... (El resto del código de cálculo de oportunidades sigue igual) ...
        // 2. Obtener IDs de grupos...
        $gruposInscritosIds = $alumno->grupos->pluck('id_grupo');
        
        $gruposDisponibles = Grupo::with(['materia', 'profesore'])
            ->whereNotIn('id_grupo', $gruposInscritosIds)
            ->orderBy('id_grupo')
            ->get();

        $historial = Boleta::where('n_control', $n_control)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('cod_materia');

        foreach ($gruposDisponibles as $grupo) {
            $codigo = $grupo->cod_materia;
            $oportunidadCalculada = 'Primera';
            $estadoMateria = 'Disponible';

            if (isset($historial[$codigo])) {
                $ultimoIntento = $historial[$codigo]->first();

                if ($ultimoIntento->calificacion >= 70) {
                    $oportunidadCalculada = 'Aprobada';
                    $estadoMateria = 'Bloqueada'; 
                } else {
                    if ($ultimoIntento->oportunidad == 'Primera') {
                        $oportunidadCalculada = 'Repite';
                    } elseif ($ultimoIntento->oportunidad == 'Repite') {
                        $oportunidadCalculada = 'Especial';
                    } elseif ($ultimoIntento->oportunidad == 'Especial') {
                        // Esto es redundante si el alumno ya está en baja, pero sirve de doble seguridad
                        $oportunidadCalculada = 'Baja Definitiva';
                        $estadoMateria = 'Bloqueada';
                    }
                }
            }
            $grupo->oportunidad_calc = $oportunidadCalculada;
            $grupo->estado_materia = $estadoMateria;
        }

        return view('alumno-grupo.create', compact('alumno', 'gruposDisponibles'));
    }

    
    /**
     * Inscribir alumno a un grupo
     */
    /**
     * Inscribir alumno a un grupo (CON VALIDACIÓN DE HORARIO)
     */
    public function store(Request $request, $n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);

        // 1. BLOQUEO POR BAJA
        if ($alumno->situacion == 'Baja') {
            return redirect()->back()
                ->with('error', 'No se puede inscribir. El alumno está dado de BAJA.');
        }

        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'oportunidad' => 'required|in:Primera,Repite,Especial' 
        ]);

        // 2. VERIFICAR DUPLICADOS (Ya está inscrito en este grupo)
        $yaInscrito = DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $request->id_grupo)
            ->exists();

        if ($yaInscrito) {
            return redirect()->back()->with('error', 'El alumno ya está inscrito en este grupo.');
        }

        // =========================================================================
        // 🚀 NUEVA LÓGICA: VALIDACIÓN DE CHOQUE DE HORARIOS
        // =========================================================================
        
        // A. Obtener datos del grupo al que se quiere inscribir
        $grupoNuevo = Grupo::with('horarios')->findOrFail($request->id_grupo);
        $periodoId = $grupoNuevo->periodo_id; // Solo nos importa chocar con materias de este periodo

        // B. Obtener horarios de los grupos donde YA está inscrito (en este mismo periodo)
        $horariosOcupados = \App\Models\Horario::query()
            ->whereHas('grupo', function($q) use ($periodoId) {
                // Filtramos por el mismo periodo (para no chocar con materias pasadas)
                $q->where('periodo_id', $periodoId);
            })
            ->whereHas('grupo.alumnos', function($q) use ($n_control) {
                // Filtramos que sean grupos de ESTE alumno
                $q->where('alumnos.n_control', $n_control);
            })
            ->with('grupo.materia') // Cargamos materia para el mensaje de error
            ->get();

        // C. Comparar horarios (Nuevo vs Existentes)
        foreach ($grupoNuevo->horarios as $nuevo) {
            foreach ($horariosOcupados as $ocupado) {
                
                // 1. ¿Es el mismo día?
                if ($nuevo->dia_semana == $ocupado->dia_semana) {
                    
                    // 2. ¿Se solapan las horas?
                    // Lógica: (InicioA < FinB) Y (FinA > InicioB)
                    if ($nuevo->hora_inicio < $ocupado->hora_fin && $nuevo->hora_fin > $ocupado->hora_inicio) {
                        
                        // Preparar mensaje amigable
                        $dias = [1=>'Lunes', 2=>'Martes', 3=>'Miércoles', 4=>'Jueves', 5=>'Viernes', 6=>'Sábado'];
                        $diaNombre = $dias[$nuevo->dia_semana] ?? 'Día ' . $nuevo->dia_semana;
                        
                        $horaConflicto = substr($ocupado->hora_inicio, 0, 5) . ' - ' . substr($ocupado->hora_fin, 0, 5);
                        $materiaConflicto = $ocupado->grupo->materia->nombre ?? 'Materia desconocida';

                        return redirect()->back()->with('error', 
                            "⚠️ CHOQUE DE HORARIO: El horario del " . $diaNombre . 
                            " choca con la materia '" . $materiaConflicto . "' (" . $horaConflicto . ")."
                        );
                    }
                }
            }
        }
        // =========================================================================
        // FIN VALIDACIÓN
        // =========================================================================

        // Si pasa todas las validaciones, inscribimos
        DB::table('alumno_grupo')->insert([
            'n_control' => $n_control,
            'id_grupo' => $request->id_grupo,
            'oportunidad' => $request->oportunidad, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('alumnos.show', $n_control)
            ->with('success', 'Alumno inscrito al grupo exitosamente en ' . $request->oportunidad . ' oportunidad.');
    }

    /**
     * Desinscribir alumno de un grupo
     */
    public function destroy($n_control, $id_grupo): RedirectResponse
    {
        DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $id_grupo)
            ->delete();

        return redirect()->route('alumnos.show', $n_control)
            ->with('success', 'Alumno desinscrito del grupo exitosamente.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Boleta; // ✅ Importante: Agregar el modelo Boleta
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
            'grupos.profesore'
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
    public function store(Request $request, $n_control): RedirectResponse
    {
        $alumno = Alumno::findOrFail($n_control);

        // 🚨 BLOQUEO POR BAJA (Doble validación para evitar hacks por URL)
        if ($alumno->situacion == 'Baja') {
            return redirect()->back()
                ->with('error', 'No se puede inscribir. El alumno está dado de BAJA.');
        }

        // ... (El resto del código store sigue igual) ...
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'oportunidad' => 'required|in:Primera,Repite,Especial' 
        ]);
        
        // Verificar duplicados...
        $yaInscrito = DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $request->id_grupo)
            ->exists();

        if ($yaInscrito) {
            return redirect()->back()->with('error', 'El alumno ya está inscrito en este grupo.');
        }

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
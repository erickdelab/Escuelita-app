<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // ✅ Agregado

class AlumnoGrupoController extends Controller
{
    /**
     * Mostrar formulario para inscribir alumno a grupos
     */
    public function create($n_control): View
    {
        // ✅ OPTIMIZADO: Solo 2 consultas eficientes
        $alumno = Alumno::with([
            'grupos.materia',
            'grupos.profesore'
        ])->findOrFail($n_control);

        // Obtener IDs de grupos ya inscritos
        $gruposInscritosIds = $alumno->grupos->pluck('id_grupo');

        // Cargar grupos disponibles con relaciones
        $gruposDisponibles = Grupo::with(['materia', 'profesore'])
            ->whereNotIn('id_grupo', $gruposInscritosIds)
            ->orderBy('id_grupo')
            ->get();

        return view('alumno-grupo.create', compact('alumno', 'gruposDisponibles'));
    }

    /**
     * Inscribir alumno a un grupo
     */
    public function store(Request $request, $n_control): RedirectResponse
{
    $request->validate([
        'id_grupo' => 'required|exists:grupos,id_grupo',
        'oportunidad' => 'required|in:Primera,Repite,Especial' // ✅ Validación
    ]);

    $alumno = Alumno::findOrFail($n_control);
    
    // Verificar que no esté ya inscrito
    $yaInscrito = DB::table('alumno_grupo')
        ->where('n_control', $n_control)
        ->where('id_grupo', $request->id_grupo)
        ->exists();

    if ($yaInscrito) {
        return redirect()->back()
            ->with('error', 'El alumno ya está inscrito en este grupo.');
    }

    // ✅ Inscribir al grupo con oportunidad
    DB::table('alumno_grupo')->insert([
        'n_control' => $n_control,
        'id_grupo' => $request->id_grupo,
        'oportunidad' => $request->oportunidad, // ✅ Nuevo campo
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('alumnos.show', $n_control)
        ->with('success', 'Alumno inscrito al grupo exitosamente.');
}

    /**
     * Desinscribir alumno de un grupo
     */
    public function destroy($n_control, $id_grupo): RedirectResponse
    {
        // ✅ CORREGIDO: Usar eliminación directa
        DB::table('alumno_grupo')
            ->where('n_control', $n_control)
            ->where('id_grupo', $id_grupo)
            ->delete();

        return redirect()->route('alumnos.show', $n_control)
            ->with('success', 'Alumno desinscrito del grupo exitosamente.');
    }
}
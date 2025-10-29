<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ¡Importante importar DB!
use Illuminate\View\View;

class ReporteController extends Controller
{
    /**
     * Muestra los alumnos de TICS en oportunidad Especial.
     */
    public function alumnosEspecialTICS(): View
    {
        // 1. Ejecutar la consulta SQL usando el facade DB
        $alumnosEspecial = DB::table('alumnos as a')
            ->join('historials as h', 'a.n_control', '=', 'h.FKn_control')
            ->join('carreras as c', 'a.FKid_carrera', '=', 'c.id_carrera')
            ->select('a.nombre', 'a.semestre', 'c.nombre_carrera as carrera', DB::raw('COUNT(h.id) as materias_en_especial'))
            ->where('c.nombre_carrera', '=', 'TICS')
            ->where('h.oportunidad', '=', 'Especial')
            ->groupBy('a.nombre', 'a.semestre', 'c.nombre_carrera')
            ->get(); // Obtenemos los resultados como una colección

        // 2. Pasar los resultados a la vista
        return view('reportes.alumnos_especial_tics', compact('alumnosEspecial'));
    }

    // --- Puedes añadir aquí otros métodos para más reportes ---
    /*
    public function otroReporte(): View
    {
        $resultados = DB::select('TU OTRA CONSULTA SQL AQUÍ');
        return view('reportes.otro_reporte', compact('resultados'));
    }
    */
}

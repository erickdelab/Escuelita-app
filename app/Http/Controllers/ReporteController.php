<?php
// app/Http/Controllers/ReporteController.php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Grupo;
use App\Models\Carrera;
use App\Models\Area;
use App\Models\Periodo;
use App\Models\Profesore;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Obtener datos para los filtros
        $periodos = Periodo::orderBy('anio', 'desc')->orderBy('id')->get();
        $carreras = Carrera::all();

        // Estadísticas generales
        $totalAlumnos = Alumno::count();
        $alumnosVigentes = Alumno::where('situacion', 'Vigente')->count();
        $alumnosBaja = Alumno::where('situacion', 'Baja')->count();
        $alumnosEgresados = Alumno::where('situacion', 'Egresado')->count();

        $totalProfesores = Profesore::count();
        $profesoresVigentes = Profesore::where('situacion', 'Vigente')->count();

        $totalGrupos = Grupo::count();
        $gruposActivos = Grupo::whereHas('periodo', function($query) {
            $query->where('activo', true);
        })->count();

        $totalCarreras = Carrera::count();
        $carrerasActivas = Carrera::count(); // Asumiendo que todas están activas

        // Distribuciones para gráficos
        $distribucionCarreras = Carrera::withCount(['alumnos as total' => function($query) {
            $query->where('situacion', 'Vigente');
        }])->get();

        $distribucionAreas = Area::withCount('profesores as total')->get();

        $distribucionSemestres = Grupo::selectRaw('semestre, COUNT(*) as total')
            ->groupBy('semestre')
            ->orderBy('semestre')
            ->get();

        return view('reportes.index', compact(
            'periodos',
            'carreras',
            'totalAlumnos',
            'alumnosVigentes',
            'alumnosBaja',
            'alumnosEgresados',
            'totalProfesores',
            'profesoresVigentes',
            'totalGrupos',
            'gruposActivos',
            'totalCarreras',
            'carrerasActivas',
            'distribucionCarreras',
            'distribucionAreas',
            'distribucionSemestres'
        ));
    }

    public function reporteAlumnos()
    {
        // Lógica para reporte detallado de alumnos
        return view('reportes.alumnos');
    }

    public function reporteGrupos()
    {
        // Lógica para reporte detallado de grupos
        return view('reportes.grupos');
    }

    public function reporteProfesores()
    {
        // Lógica para reporte detallado de profesores
        return view('reportes.profesores');
    }

    public function reporteEstadisticas()
    {
        // Lógica para estadísticas generales
        return view('reportes.estadisticas');
    }
}
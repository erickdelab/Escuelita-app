<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Profesore;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Area;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el panel de control, cargando el conteo de registros.
     */
    public function index(Request $request): View
    {
        // 1. Contamos los registros de cada tabla usando el método count() de Eloquent
        $counts = [
            'alumnos' => Alumno::count(),
            'carreras' => Carrera::count(),
            'profesores' => Profesore::count(),
            'materias' => Materia::count(),
            'grupos' => Grupo::count(),
            'areas' => Area::count(),
            'historials' => Historial::count(),
        ];
        
        // 2. Pasamos los conteos a la vista 'home'
        return view('home', compact('counts'));
    }
}

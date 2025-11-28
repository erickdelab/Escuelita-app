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
use Illuminate\Support\Facades\Auth; // ✅ Importante

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
     * Muestra el panel de control.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Si es ALUMNO, redirigir a su portal
        if ($user->hasRole('alumno')) {
            return redirect()->route('student.dashboard');
        }

        // 2. ✅ AGREGA ESTO: Si es PROFESOR (y no es Admin), redirigir a su portal
        if ($user->hasRole('profesor') && !$user->hasRole('admin')) {
            return redirect()->route('teacher.dashboard');
        }

        // =========================================================
        // 🖥️ DASHBOARD ADMINISTRATIVO (Solo llega aquí si es Admin)
        // =========================================================
        
        $counts = [
            'alumnos' => Alumno::count(),
            'carreras' => Carrera::count(),
            'profesores' => Profesore::count(),
            'materias' => Materia::count(),
            'grupos' => Grupo::count(),
            'areas' => Area::count(),
            'historials' => Historial::count(),
        ];

        return view('home', compact('counts'));
    }
}
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

        // =========================================================
        // 🚀 LÓGICA DE REDIRECCIÓN AUTOMÁTICA
        // =========================================================
        
        // 1. Si es ALUMNO, redirigir a su portal exclusivo
        if ($user->hasRole('alumno')) {
            return redirect()->route('student.dashboard');
        }

        // =========================================================
        // 🖥️ DASHBOARD ADMINISTRATIVO (Para Admins y Profesores)
        // =========================================================
        
        // Si NO es alumno (es Admin o Profe), calculamos las estadísticas
        $counts = [
            'alumnos' => Alumno::count(),
            'carreras' => Carrera::count(),
            'profesores' => Profesore::count(),
            'materias' => Materia::count(),
            'grupos' => Grupo::count(),
            'areas' => Area::count(),
            'historials' => Historial::count(),
        ];
        
        // Y mostramos la vista original del administrador
        return view('home', compact('counts'));
    }
}
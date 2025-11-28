<?php

namespace App\Http\Controllers;

use App\Models\Profesore;
use App\Models\Area; 
use App\Models\User;
use App\Http\Requests\ProfesoreRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // ✅ IMPORTANTE: Para manejar horas

class ProfesoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->search;
        
        $profesores = Profesore::with('area');
        
        $profesores->when($search, function ($query, $search) {
            $query->where('n_trabajador', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('s_nombre', 'like', "%{$search}%")
                  ->orWhere('ap_paterno', 'like', "%{$search}%")
                  ->orWhere('ap_materno', 'like', "%{$search}%")
                  ->orWhere('correo_institucional', 'like', "%{$search}%")
                  ->orWhere('situacion', 'like', "%{$search}%")
                  ->orWhereHas('area', function ($q) use ($search) {
                      $q->where('area', 'like', "%{$search}%");
                  });
        });

        $profesores = $profesores->paginate(10)->withQueryString();

        return view('profesore.index', compact('profesores'))
            ->with('i', ($profesores->currentPage() - 1) * $profesores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $profesore = new Profesore();
        $areas = Area::pluck('area', 'cod_area'); 
        $situaciones = ['Vigente', 'En Asignación', 'Inactivo/Baja'];

        return view('profesore.create', compact('profesore', 'areas', 'situaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfesoreRequest $request): RedirectResponse
    {
        // 1. Crear el Profesor
        $profesore = new Profesore();
        $profesore->fill($request->validated());
        $profesore->save(); 
        
        $n_trabajador = $profesore->n_trabajador;

        // 2. Crear AUTOMÁTICAMENTE el Usuario para Login
        if (!User::where('email', $request->correo_institucional)->exists()) {
            $user = User::create([
                'name' => $profesore->nombre . ' ' . $profesore->ap_paterno,
                'email' => $profesore->correo_institucional,
                'password' => Hash::make($n_trabajador),
                'n_trabajador_link' => $n_trabajador,
            ]);

            // 3. Asignar el Rol de Profesor
            $user->assignRole('profesor');
        }

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor creado y acceso de usuario generado (Pass: N° Trabajador).');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $n_trabajador): View
    {
        $profesore = Profesore::with('area')->findOrFail($n_trabajador); 
        return view('profesore.show', compact('profesore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $n_trabajador): View
    {
        $profesore = Profesore::findOrFail($n_trabajador);
        $areas = Area::pluck('area', 'cod_area'); 
        $situaciones = ['Vigente', 'En Asignación', 'Inactivo/Baja'];

        return view('profesore.edit', compact('profesore', 'areas', 'situaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfesoreRequest $request, Profesore $profesore): RedirectResponse
    {
        $profesore->update($request->validated());

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    /**
     * Elimina el recurso especificado (Baja Lógica).
     */
    public function destroy(string $n_trabajador): RedirectResponse
    {
        $profesore = Profesore::findOrFail($n_trabajador);
        $profesore->update(['situacion' => 'Inactivo/Baja']);

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor dado de BAJA (estado actualizado a Inactivo/Baja).');
    }

    /**
     * ✅ NUEVO MÉTODO: Muestra el horario gráfico del profesor.
     */
    public function horario($n_trabajador): View
    {
        $profesor = Profesore::with('area')->findOrFail($n_trabajador);

        // 1. Obtener grupos del profesor con horarios y aulas
        $grupos = $profesor->grupos()
            ->with(['materia', 'horarios.aula'])
            ->get();

        // 2. Estructurar datos para el Grid (Calendario)
        $calendario = [];
        $horasDisponibles = range(7, 20); // De 7:00 AM a 8:00 PM
        
        // Colores pastel para diferenciar materias visualmente
        $colores = [
            '#FFD1DC', '#D1E8E2', '#FFF4E0', '#E0F7FA', '#F3E5F5', 
            '#F0F4C3', '#FFCCBC', '#CFD8DC', '#E1BEE7', '#B2DFDB'
        ];
        $materiasColor = [];
        $colorIndex = 0;

        foreach ($grupos as $grupo) {
            // Asignar color único a cada materia
            if (!isset($materiasColor[$grupo->cod_materia])) {
                $materiasColor[$grupo->cod_materia] = $colores[$colorIndex % count($colores)];
                $colorIndex++;
            }

            foreach ($grupo->horarios as $horario) {
                $dia = $horario->dia_semana; // 1=Lunes, etc.
                $horaInicio = (int) Carbon::parse($horario->hora_inicio)->format('H');
                $horaFin = (int) Carbon::parse($horario->hora_fin)->format('H');
                
                $duracion = $horaFin - $horaInicio;

                // Guardamos la info en el bloque de inicio
                $calendario[$dia][$horaInicio] = [
                    'materia' => $grupo->materia->nombre ?? 'Materia N/A',
                    'codigo' => $grupo->materia->cod_materia ?? '---',
                    'semestre' => $grupo->semestre,
                    'grupo_id' => $grupo->id_grupo,
                    'aula' => $horario->aula->nombre ?? 'N/A',
                    'duracion' => $duracion,
                    'color' => $materiasColor[$grupo->cod_materia]
                ];

                // Marcar las horas siguientes como "ocupadas" para el rowspan en la vista
                for ($h = $horaInicio + 1; $h < $horaFin; $h++) {
                    $calendario[$dia][$h] = 'ocupado';
                }
            }
        }

        return view('profesore.horario', compact('profesor', 'calendario', 'horasDisponibles'));
    }
}
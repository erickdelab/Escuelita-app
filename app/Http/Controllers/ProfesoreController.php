<?php

namespace App\Http\Controllers;

use App\Models\Profesore;
use App\Models\Area; 
use App\Http\Requests\ProfesoreRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfesoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->search;
        
        // 1. Inicia la consulta cargando la relación 'area'.
        $profesores = Profesore::with('area');
        
        // 2. LÓGICA DE BÚSQUEDA: Aplica filtros si hay término de búsqueda
        $profesores->when($search, function ($query, $search) {
            $query->where('n_trabajador', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('s_nombre', 'like', "%{$search}%")
                  ->orWhere('ap_paterno', 'like', "%{$search}%")
                  ->orWhere('ap_materno', 'like', "%{$search}%")
                  ->orWhere('correo_institucional', 'like', "%{$search}%")
                  ->orWhere('situacion', 'like', "%{$search}%")
                  // Búsqueda en la relación 'area' (por el nombre del área)
                  ->orWhereHas('area', function ($q) use ($search) {
                      // Usamos la columna 'area' de la tabla areas
                      $q->where('area', 'like', "%{$search}%");
                  });
        });

        // 3. PAGINACIÓN: Ejecuta la consulta y pagina, conservando el search
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
        
        // Carga de datos para el SELECT de Áreas
        $areas = Area::pluck('area', 'cod_area'); 
        $situaciones = ['Vigente', 'En Asignación', 'Inactivo/Baja'];

        return view('profesore.create', compact('profesore', 'areas', 'situaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfesoreRequest $request): RedirectResponse
    {
        // ASIGNACIÓN MANUAL PARA GENERAR n_trabajador ÚNICO
        $profesore = new Profesore();
        $profesore->fill($request->validated()); 
        $profesore->save(); 

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $n_trabajador): View
    {
        // Usamos with('area') para cargar la relación
        $profesore = Profesore::with('area')->findOrFail($n_trabajador); 
        
        return view('profesore.show', compact('profesore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $n_trabajador): View
    {
        // Buscamos por n_trabajador
        $profesore = Profesore::findOrFail($n_trabajador);
        
        // Carga de datos para el SELECT de Áreas
        $areas = Area::pluck('area', 'cod_area'); 
        $situaciones = ['Vigente', 'En Asignación', 'Inactivo/Baja'];

        return view('profesore.edit', compact('profesore', 'areas', 'situaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfesoreRequest $request, Profesore $profesore): RedirectResponse
    {
        // Laravel inyecta el modelo por n_trabajador
        $profesore->update($request->validated());

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento (Cambiado a Baja Lógica).
     */
    public function destroy(string $n_trabajador): RedirectResponse
    {
        $profesore = Profesore::findOrFail($n_trabajador);
        
        // === BAJA LÓGICA ===
        $profesore->update(['situacion' => 'Inactivo/Baja']);

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor dado de BAJA (estado actualizado a Inactivo/Baja).');
    }
}

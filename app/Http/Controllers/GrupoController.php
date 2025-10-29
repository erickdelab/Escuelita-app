<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Profesore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\GrupoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GrupoController extends Controller
{
    /**
     * Muestra una lista de los Grupos.
     */
    public function index(Request $request): View
    {
        // Cargar relaciones con nombres correctos
        $grupos = Grupo::with(['materia', 'profesore'])->paginate(10); 

        return view('grupo.index', compact('grupos'))
            ->with('i', ($request->input('page', 1) - 1) * $grupos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $grupo = new Grupo();
        
        $materias = Materia::where('materia_estado', 'Activa')
                          ->pluck('nombre', 'cod_materia');
        
        $profesores = Profesore::where('situacion', 'Vigente')
                              ->selectRaw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) as full_name, n_trabajador")
                              ->pluck('full_name', 'n_trabajador'); 

        return view('grupo.create', compact('grupo', 'materias', 'profesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        // Validar que el ID del grupo no exista
        $exists = Grupo::where('id_grupo', $request->id_grupo)->exists();
        if ($exists) {
            return Redirect::back()
                ->withInput()
                ->with('error', 'El ID del grupo ya existe. Por favor, use un ID diferente.');
        }

        Grupo::create($request->validated());

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_grupo): View
    {
        // Cargar relaciones explícitamente
        $grupo = Grupo::with(['materia', 'profesore'])->findOrFail($id_grupo);

        // DEBUG: Verificar datos
        // dd($grupo->materia, $grupo->profesore);

        return view('grupo.show', compact('grupo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_grupo): View
    {
        $grupo = Grupo::with(['materia', 'profesore'])->findOrFail($id_grupo);
        
        $materias = Materia::where('materia_estado', 'Activa')
                          ->pluck('nombre', 'cod_materia');
        
        $profesores = Profesore::where('situacion', 'Vigente')
                              ->selectRaw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) as full_name, n_trabajador")
                              ->pluck('full_name', 'n_trabajador'); 

        return view('grupo.edit', compact('grupo', 'materias', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
        // Validar que el ID del grupo no exista (excepto para el actual)
        $exists = Grupo::where('id_grupo', $request->id_grupo)
                      ->where('id_grupo', '!=', $grupo->id_grupo)
                      ->exists();
        
        if ($exists) {
            return Redirect::back()
                ->withInput()
                ->with('error', 'El ID del grupo ya existe. Por favor, use un ID diferente.');
        }

        $grupo->update($request->validated());

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_grupo): RedirectResponse
    {
        $grupo = Grupo::withCount('alumnos')->findOrFail($id_grupo);

        if ($grupo->alumnos_count > 0) {
            return Redirect::route('grupos.index')
                ->with('error', 'No se puede eliminar el grupo porque tiene ' . $grupo->alumnos_count . ' alumno(s) inscrito(s).');
        }

        try {
            $grupo->delete();
            return Redirect::route('grupos.index')
                ->with('success', 'Grupo eliminado exitosamente.');
        } catch (\Exception $e) {
            return Redirect::route('grupos.index')
                ->with('error', 'Error al eliminar el grupo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra los detalles completos del grupo con profesor y alumnos.
     */
    public function detalles($id)
    {
        $grupo = Grupo::with([
            'materia', 
            'profesore.area', // CORREGIDO: Cambiado de 'profesor' a 'profesore'
            'alumnos.carrera' // Cargar los alumnos del grupo
        ])->findOrFail($id);
        
        return view('grupo.detalles', compact('grupo'));
    }
}
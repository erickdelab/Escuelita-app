<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MateriaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $materias = Materia::paginate(10); 

        return view('materia.index', compact('materias'))
            ->with('i', ($request->input('page', 1) - 1) * $materias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $materia = new Materia();
        return view('materia.create', compact('materia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MateriaRequest $request): RedirectResponse
    {
        // Establecer estado por defecto como "Activa"
        $data = $request->validated();
        $data['materia_estado'] = 'Activa';
        
        Materia::create($data);

        return Redirect::route('materias.index')
            ->with('success', 'Materia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($cod_materia): View
    {
        $materia = Materia::findOrFail($cod_materia);
        return view('materia.show', compact('materia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($cod_materia): View
    {
        $materia = Materia::findOrFail($cod_materia);
        return view('materia.edit', compact('materia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MateriaRequest $request, $cod_materia): RedirectResponse
    {
        $materia = Materia::findOrFail($cod_materia);
        $materia->update($request->validated());
        return Redirect::route('materias.index')->with('success', 'Materia actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cod_materia): RedirectResponse
    {
        // Cambiar el estado a "Baja" en lugar de eliminar
        $materia = Materia::findOrFail($cod_materia);
        $materia->update(['materia_estado' => 'Baja']);

        return Redirect::route('materias.index')->with('success', 'Materia dada de baja exitosamente');
    }

    /**
     * Reactivar una materia que está en estado "Baja"
     */
    public function reactivar($cod_materia): RedirectResponse
    {
        $materia = Materia::findOrFail($cod_materia);
        $materia->update(['materia_estado' => 'Activa']);

        return Redirect::route('materias.index')->with('success', 'Materia reactivada exitosamente');
    }
}
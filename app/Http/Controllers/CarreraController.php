<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CarreraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $carreras = Carrera::paginate(30);

        return view('carrera.index', compact('carreras'))
            ->with('i', ($request->input('page', 1) - 1) * $carreras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $carrera = new Carrera();
        return view('carrera.create', compact('carrera'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarreraRequest $request): RedirectResponse
    {
        Carrera::create($request->validated());

        return Redirect::route('carreras.index')
            ->with('success', 'Carrera creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_carrera): View
    {
        $carrera = Carrera::findOrFail($id_carrera);
        return view('carrera.show', compact('carrera'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_carrera): View
    {
        $carrera = Carrera::findOrFail($id_carrera);
        return view('carrera.edit', compact('carrera'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarreraRequest $request, Carrera $carrera): RedirectResponse
    {
        // CAMBIO: Usamos inyección de modelo ($carrera) y guardamos
        $carrera->update($request->validated());

        return Redirect::route('carreras.index')
            ->with('success', 'Carrera actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_carrera): RedirectResponse
    {
        $carrera = Carrera::findOrFail($id_carrera);

        // === VERIFICACIÓN DE ALUMNOS INSCRITOS (Ahora funciona) ===
        if ($carrera->alumnos()->exists()) {
            return Redirect::route('carreras.index')
                ->with('error', 'No se puede eliminar la carrera porque hay alumnos inscritos en ella. Desvincúlalos primero.');
        }

        $carrera->delete();

        return Redirect::route('carreras.index')
            ->with('success', 'Carrera eliminada exitosamente.');
    }
}

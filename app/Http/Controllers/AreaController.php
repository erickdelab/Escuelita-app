<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Profesore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // EAGER LOADING: Usamos with('jefe') para cargar el nombre del jefe en la lista.
        $areas = Area::with('jefe')->paginate(10); 

        return view('area.index', compact('areas'))
            ->with('i', ($request->input('page', 1) - 1) * $areas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
{
    $area = new Area();
    
    // ✅ OPTIMIZADO: Solo 1 consulta eficiente
    $profesores = Profesore::whereNotIn('n_trabajador', function($query) {
            $query->select('jefe_area')
                  ->from('areas')
                  ->whereNotNull('jefe_area');
        })
        ->get()
        ->mapWithKeys(function ($profesor) {
            $fullName = trim($profesor->nombre . ' ' . $profesor->ap_paterno . ' ' . $profesor->ap_materno);
            return [$profesor->n_trabajador => $fullName];
        });

    return view('area.create', compact('area', 'profesores'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request): RedirectResponse
    {
        // El campo cod_area es autoincremental y se genera en la DB.
        Area::create($request->validated());

        return Redirect::route('areas.index')
            ->with('success', 'Área creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($cod_area): View
    {
        // EAGER LOADING: Usamos with('jefe') para mostrar el nombre del jefe en el detalle
        $area = Area::with('jefe')->where('cod_area', $cod_area)->firstOrFail();

        return view('area.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($cod_area): View
{
    $area = Area::findOrFail($cod_area);
    
    // ✅ OPTIMIZADO: Solo 1 consulta
    $profesores = Profesore::whereNotIn('n_trabajador', function($query) use ($area) {
            $query->select('jefe_area')
                  ->from('areas')
                  ->whereNotNull('jefe_area')
                  ->where('cod_area', '!=', $area->cod_area);
        })
        ->get()
        ->mapWithKeys(function ($profesor) {
            $fullName = trim($profesor->nombre . ' ' . $profesor->ap_paterno . ' ' . $profesor->ap_materno);
            return [$profesor->n_trabajador => $fullName];
        });

    return view('area.edit', compact('area', 'profesores'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, Area $area): RedirectResponse
    {
        $area->update($request->validated());

        return Redirect::route('areas.index')
            ->with('success', 'Área actualizada exitosamente');
    }

    public function destroy($cod_area): RedirectResponse
    {
        // Usamos where('cod_area', ...) para el borrado
        $area = Area::where('cod_area', $cod_area)->delete();

        return Redirect::route('areas.index')
            ->with('success', 'Área eliminada exitosamente');
    }
}

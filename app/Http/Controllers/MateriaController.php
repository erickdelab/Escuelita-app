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
     * Define el catálogo fijo de materias y sus nombres.
     */
    private function getMateriaCatalogo()
    {
        // El código de materia es la clave y el nombre es el valor
        $catalogo = [
            'AE101' => 'Marketing', 'AE102' => 'Recursos Humanos', 'AE103' => 'Gestión de Proyectos', 'AE104' => 'Planeación Estratégica',
            'ARQ101' => 'Diseño Arquitectónico', 'ARQ102' => 'Urbanismo', 'ARQ103' => 'Materiales de Construcción', 'ARQ104' => 'Historia de la Arquitectura',
            'CIV101' => 'Topografía', 'CIV102' => 'Estructuras I', 'CIV103' => 'Hidráulica', 'CIV104' => 'Geotecnia',
            'ELE101' => 'Circuitos Eléctricos', 'ELE102' => 'Electrónica I', 'ELE103' => 'Máquinas Eléctricas', 'ELE104' => 'Sistemas de Control',
            'ETRO101' => 'Electrónica Digital', 'ETRO102' => 'Microcontroladores', 'ETRO103' => 'Sistemas Embebidos', 'ETRO104' => 'Señales y Sistemas',
            'GE101' => 'Administración', 'GE102' => 'Economía', 'GE103' => 'Contabilidad', 'GE104' => 'Finanzas',
            'INDU101' => 'Procesos de Manufactura', 'INDU102' => 'Diseño Industrial', 'INDU103' => 'Control de Calidad', 'INDU104' => 'Materiales Industriales',
            'MEC101' => 'Mecanica I', 'MEC102' => 'Termodinámica', 'MEC103' => 'Mecanica de Fluidos', 'MEC104' => 'Resistencia de Materiales',
            'QUI101' => 'Química General', 'QUI102' => 'Química Orgánica', 'QUI103' => 'Química Analítica', 'QUI104' => 'Bioquímica',
            'TICS101' => 'Fundamentos de Programación', 'TICS102' => 'Redes I', 'TICS103' => 'Base de Datos', 'TICS104' => 'Ciberseguridad',
        ];
        return $catalogo;
    }

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
        // Cargamos el catálogo de materias para el SELECT
        $catalogoMaterias = $this->getMateriaCatalogo(); 

        return view('materia.create', compact('materia', 'catalogoMaterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MateriaRequest $request): RedirectResponse
    {
        Materia::create($request->validated());

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
        // Cargamos el catálogo de materias para el SELECT
        $catalogoMaterias = $this->getMateriaCatalogo(); 

        return view('materia.edit', compact('materia', 'catalogoMaterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MateriaRequest $request, Materia $materia): RedirectResponse
    {
        $materia->update($request->validated());
        return Redirect::route('materias.index')->with('success', 'Materia actualizada exitosamente');
    }

    public function destroy($cod_materia): RedirectResponse
    {
        Materia::destroy($cod_materia);
        return Redirect::route('materias.index')->with('success', 'Materia eliminada exitosamente');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $periodos = Periodo::orderBy('anio', 'desc')
            ->orderByRaw("FIELD(periodo_nombre, 'Enero-Junio', 'Agosto-Diciembre')")
            ->paginate(20);

        return view('periodos.index', compact('periodos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('periodos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'periodo_nombre' => 'required|string|in:Enero-Junio,Agosto-Diciembre',
            'anio' => 'required|integer|min:2020|max:2030',
            'activo' => 'boolean'
        ]);

        // Generar código del período automáticamente
        $codigo = $this->generarCodigoPeriodo($request->periodo_nombre, $request->anio);

        // Verificar si ya existe el período
        $existe = Periodo::where('codigo_periodo', $codigo)->exists();
        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El período ya existe.');
        }

        Periodo::create([
            'periodo_nombre' => $request->periodo_nombre,
            'anio' => $request->anio,
            'codigo_periodo' => $codigo,
            'activo' => $request->activo ?? false
        ]);

        return redirect()->route('periodos.index')
            ->with('success', 'Período creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Periodo $periodo): View
    {
        return view('periodos.show', compact('periodo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periodo $periodo): View
    {
        return view('periodos.edit', compact('periodo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periodo $periodo): RedirectResponse
    {
        $request->validate([
            'periodo_nombre' => 'required|string|in:Enero-Junio,Agosto-Diciembre',
            'anio' => 'required|integer|min:2020|max:2030',
            'activo' => 'boolean'
        ]);

        // Generar nuevo código del período
        $nuevoCodigo = $this->generarCodigoPeriodo($request->periodo_nombre, $request->anio);

        // Verificar si el nuevo código ya existe (excluyendo el actual)
        if ($nuevoCodigo !== $periodo->codigo_periodo) {
            $existe = Periodo::where('codigo_periodo', $nuevoCodigo)
                ->where('id', '!=', $periodo->id)
                ->exists();
            
            if ($existe) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ya existe un período con estos datos.');
            }
        }

        $periodo->update([
            'periodo_nombre' => $request->periodo_nombre,
            'anio' => $request->anio,
            'codigo_periodo' => $nuevoCodigo,
            'activo' => $request->activo ?? false
        ]);

        return redirect()->route('periodos.index')
            ->with('success', 'Período actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periodo $periodo): RedirectResponse
    {
        $periodo->delete();

        return redirect()->route('periodos.index')
            ->with('success', 'Período eliminado exitosamente.');
    }

    /**
     * Generar código del período automáticamente
     */
    private function generarCodigoPeriodo($periodoNombre, $anio)
    {
        $abreviatura = $periodoNombre === 'Enero-Junio' ? 'ENEJUN' : 'AGODIC';
        $anioCorto = substr($anio, -2);
        
        return $abreviatura . $anioCorto;
    }
}
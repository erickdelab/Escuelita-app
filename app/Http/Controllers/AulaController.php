<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// ✅ Importa la clase de Reglas de Validación
use Illuminate\Validation\Rule;

class AulaController extends Controller
{
    /**
     * Muestra una lista de las aulas.
     */
    public function index(Request $request): View
    {
        $aulas = Aula::paginate(30);
        return view('aula.index', compact('aulas'))
            ->with('i', ($request->input('page', 1) - 1) * $aulas->perPage());
    }

    /**
     * ✅ Muestra el formulario para crear un aula (MODIFICADO).
     */
    public function create(): View
    {
        $aula = new Aula();
        
        // ✅ Preparamos los datos para los dropdowns
        $numeros = range(1, 20);
        $letras = ['A', 'B', 'C'];
        
        // ✅ Pasamos las variables a la vista
        return view('aula.create', compact('aula', 'numeros', 'letras'));
    }

    /**
     * ✅ Almacena un aula nueva (MODIFICADO).
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validar los inputs de los dropdowns
        $request->validate([
            'numero' => ['required', 'integer', Rule::in(range(1, 20))],
            'letra' => ['required', 'string', Rule::in(['A', 'B', 'C'])],
            'capacidad' => 'required|integer|min:1',
        ]);

        // 2. Construir el nombre
        $nombreAula = $request->numero . $request->letra;

        // 3. Validar la unicidad del nombre CONSTRUIDO
        $existing = Aula::where('nombre', $nombreAula)->exists();
        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['numero' => 'El aula ' . $nombreAula . ' ya existe.']);
        }

        // 4. Crear el aula
        Aula::create([
            'nombre' => $nombreAula,
            'capacidad' => $request->capacidad,
        ]);

        return redirect()->route('aulas.index')
            ->with('success', 'Aula creada exitosamente.');
    }

    /**
     * ✅ Muestra el formulario para editar un aula (MODIFICADO).
     */
    public function edit($id): View
    {
        $aula = Aula::findOrFail($id);
        
        // ✅ Preparamos los datos para los dropdowns
        $numeros = range(1, 20);
        $letras = ['A', 'B', 'C'];

        // ✅ lógica para "deconstruir" el nombre (ej. "15A")
        $selectedNumero = null;
        $selectedLetra = null;
        
        // Usamos una expresión regular para separar número y letra
        if (preg_match('/^(\d+)([A-C])$/', $aula->nombre, $matches)) {
            $selectedNumero = (int) $matches[1];
            $selectedLetra = $matches[2];
        }

        // ✅ Pasamos las variables a la vista
        return view('aula.edit', compact(
            'aula', 
            'numeros', 
            'letras', 
            'selectedNumero', 
            'selectedLetra'
        ));
    }

    /**
     * ✅ Actualiza un aula existente (MODIFICADO).
     */
    public function update(Request $request, Aula $aula): RedirectResponse
    {
        // 1. Validar los inputs
        $request->validate([
            'numero' => ['required', 'integer', Rule::in(range(1, 20))],
            'letra' => ['required', 'string', Rule::in(['A', 'B', 'C'])],
            'capacidad' => 'required|integer|min:1',
        ]);

        // 2. Construir el nuevo nombre
        $nombreAula = $request->numero . $request->letra;

        // 3. Validar unicidad (solo si el nombre cambió)
        if ($nombreAula != $aula->nombre) {
            $existing = Aula::where('nombre', $nombreAula)
                            ->where('id', '!=', $aula->id) // Ignorar la propia aula
                            ->exists();
            if ($existing) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['numero' => 'El aula ' . $nombreAula . ' ya existe.']);
            }
        }

        // 4. Actualizar
        $aula->update([
            'nombre' => $nombreAula,
            'capacidad' => $request->capacidad,
        ]);

        return redirect()->route('aulas.index')
            ->with('success', 'Aula actualizada exitosamente.');
    }

    /**
     * Elimina un aula.
     */
    public function destroy(Aula $aula): RedirectResponse
    {
        // Opcional: Verificar si el aula está en uso en horarios antes de borrar
        if ($aula->horarios()->count() > 0) {
            return redirect()->route('aulas.index')
                ->with('error', 'No se puede eliminar el aula, está asignada a ' . $aula->horarios()->count() . ' horario(s).');
        }

        $aula->delete();

        return redirect()->route('aulas.index')
            ->with('success', 'Aula eliminada exitosamente.');
    }
}
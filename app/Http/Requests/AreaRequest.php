<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // === Lógica para Edición y Unicidad ===
        // Obtenemos la clave primaria del área actual para ignorarla en las validaciones unique
        $areaCodArea = $this->route('area'); 
        
        // Regla para el nombre del área (debe ser único, ignorando el área actual si edita)
        $area_unique_rule = Rule::unique('areas', 'area')
                                  ->ignore($areaCodArea, 'cod_area');

        return [
            // CÓDIGO DE ÁREA: Solo se valida si está presente (edición)
            'cod_area' => 'nullable', 
            
            // NOMBRE DE ÁREA: Requerido, string, y único
            'area' => ['required', 'string', 'max:255', $area_unique_rule],
            
            // JEFE DE ÁREA (Clave Foránea): Debe existir en profesores.n_trabajador
            'jefe_area' => 'nullable|string|exists:profesores,n_trabajador',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'area.required' => 'El nombre del área es obligatorio.',
            'area.unique' => 'Ya existe un área registrada con este nombre.',
            
            'jefe_area.exists' => 'El profesor seleccionado como Jefe de Área no existe.',
        ];
    }
}

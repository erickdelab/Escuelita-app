<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cod_materia' => 'required|string|exists:materias,cod_materia',
            'n_trabajador' => 'required|string|exists:profesores,n_trabajador',
            'semestre' => 'required|integer|min:1|max:12',
            'periodo_id' => 'required|integer|exists:periodos,id',
            
            // --- CAMPOS DE HORARIO ELIMINADOS ---
            // 'aula_id' => '...',
            // 'patron' => '...',
            // 'hora_inicio' => '...',
        ];
    }

    public function messages(): array
    {
        return [
            'cod_materia.required' => 'La materia es obligatoria.',
            'n_trabajador.required' => 'El profesor es obligatorio.',
            'semestre.required' => 'El semestre es obligatorio.',
            'periodo_id.required' => 'El periodo es obligatorio.',
            
            // --- MENSAJES DE HORARIO ELIMINADOS ---
        ];
    }
    
    // ... (El método attributes() también debe ser limpiado si existe) ...
}
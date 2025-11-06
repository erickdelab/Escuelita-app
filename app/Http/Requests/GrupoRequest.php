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
            // 'id_grupo' => [...] // ❌ ELIMINADO: No se valida, es autoincremental
            
            'cod_materia' => 'required|string|exists:materias,cod_materia',
            'n_trabajador' => 'required|string|exists:profesores,n_trabajador',
            'semestre' => 'required|integer|min:1|max:12',
            'periodo_id' => 'required|integer|exists:periodos,id', // Asegúrate que la tabla 'periodos' y 'id' sean correctos
        ];
    }

    public function messages(): array
    {
        return [
            // 'id_grupo.required' => 'El ID del grupo es obligatorio.', // ELIMINADO
            // 'id_grupo.unique' => 'El ID del grupo ya existe.', // ELIMINADO
            'cod_materia.required' => 'La materia es obligatoria.',
            'cod_materia.exists' => 'La materia seleccionada no existe.',
            'n_trabajador.required' => 'El profesor es obligatorio.',
            'n_trabajador.exists' => 'El profesor seleccionado no existe.',
            'semestre.required' => 'El semestre es obligatorio.',
            'periodo_id.required' => 'El periodo es obligatorio.',
            'periodo_id.exists' => 'El periodo seleccionado no existe.',
        ];
    }

    public function attributes(): array
    {
        return [
            // 'id_grupo' => 'ID Grupo', // ELIMINADO
            'cod_materia' => 'Materia',
            'n_trabajador' => 'Profesor',
            'semestre' => 'Semestre',
            'periodo_id' => 'Periodo',
        ];
    }
}

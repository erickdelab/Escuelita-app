<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $grupoId = $this->route('grupo') ? $this->route('grupo')->id_grupo : null;

        return [
            'id_grupo' => 'required|string|max:10',
            'cod_materia' => 'required|string|exists:materias,cod_materia',
            'n_trabajador' => 'required|string|exists:profesores,n_trabajador',
            'semestre' => 'required|integer|min:1|max:12'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id_grupo.required' => 'El ID del grupo es obligatorio',
            'id_grupo.string' => 'El ID del grupo debe ser texto',
            'id_grupo.max' => 'El ID del grupo no puede tener más de 10 caracteres',
            
            'cod_materia.required' => 'La materia es obligatoria',
            'cod_materia.string' => 'La materia debe ser texto',
            'cod_materia.exists' => 'La materia seleccionada no existe',
            
            'n_trabajador.required' => 'El profesor es obligatorio',
            'n_trabajador.string' => 'El profesor debe ser texto',
            'n_trabajador.exists' => 'El profesor seleccionado no existe',
            
            'semestre.required' => 'El semestre es obligatorio',
            'semestre.integer' => 'El semestre debe ser un número entero',
            'semestre.min' => 'El semestre debe ser al menos 1',
            'semestre.max' => 'El semestre no puede ser mayor a 12'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'id_grupo' => 'ID Grupo',
            'cod_materia' => 'Materia',
            'n_trabajador' => 'Profesor',
            'semestre' => 'Semestre'
        ];
    }
}
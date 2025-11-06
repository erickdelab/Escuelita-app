<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $area = $this->route('area');
        $cod_area = $area ? $area->cod_area : null;

        return [
            'area' => 'required|string|max:255|unique:areas,area,' . $cod_area . ',cod_area',
            'jefe_area' => 'nullable|string|exists:profesores,n_trabajador',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'area.required' => 'El nombre del área es obligatorio',
            'area.string' => 'El nombre del área debe ser texto',
            'area.max' => 'El nombre del área no puede tener más de 255 caracteres',
            'area.unique' => 'El nombre del área ya existe',
            
            'jefe_area.exists' => 'El profesor seleccionado no existe',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'area' => 'Nombre del Área',
            'jefe_area' => 'Jefe de Área',
        ];
    }
}
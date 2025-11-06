<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaRequest extends FormRequest
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
        // Obtener el parámetro de la ruta (puede ser string o modelo)
        $routeParam = $this->route('materia');
        
        // Determinar si es un string (cod_materia) o un objeto Materia
        if (is_string($routeParam)) {
            $cod_materia = $routeParam;
        } else {
            $cod_materia = $routeParam ? $routeParam->cod_materia : null;
        }

        $rules = [
            'cod_materia' => 'required|string|max:30|unique:materias,cod_materia,' . $cod_materia . ',cod_materia',
            'nombre' => 'required|string|max:255',
            'credito' => 'required|integer|min:1|max:10',
            'cadena' => 'nullable|integer',
            'materia_estado' => 'required|in:Activa,Baja',
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cod_materia.required' => 'El código de materia es obligatorio',
            'cod_materia.unique' => 'El código de materia ya existe',
            'cod_materia.max' => 'El código de materia no puede tener más de 30 caracteres',
            
            'nombre.required' => 'El nombre de la materia es obligatorio',
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres',
            
            'credito.required' => 'El número de créditos es obligatorio',
            'credito.integer' => 'Los créditos deben ser un número entero',
            'credito.min' => 'Los créditos deben ser al menos 1',
            'credito.max' => 'Los créditos no pueden ser mayor a 10',
            
            'materia_estado.required' => 'El estado de la materia es obligatorio',
            'materia_estado.in' => 'El estado debe ser "Activa" o "Baja"',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'cod_materia' => 'Código de Materia',
            'nombre' => 'Nombre',
            'credito' => 'Créditos',
            'cadena' => 'Cadena',
            'materia_estado' => 'Estado de la Materia',
        ];
    }
}
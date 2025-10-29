<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $carreraId = $this->route('carrera'); 

        return [
            // id_carrera es autoincremental en DB
            'id_carrera' => [
                'nullable',
                Rule::unique('carreras', 'id_carrera')->ignore($carreraId, 'id_carrera'),
            ], 
            
            'nombre_carrera' => 'required|string|max:255|unique:carreras,nombre_carrera,' . $carreraId . ',id_carrera',
            
            // CAMBIO CRÍTICO: Volvemos al campo simple 'num_edif'
            'num_edif' => 'required|string|max:20', 
            
            'capacidad' => 'required|integer|min:1',
        ];
    }
    
    public function messages(): array
    {
        return [
            'num_edif.required' => 'El número de edificio es obligatorio.',
            'num_edif.string' => 'El número de edificio debe ser texto o número.',
            'nombre_carrera.unique' => 'Ya existe una carrera con este nombre.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
        ];
    }
}

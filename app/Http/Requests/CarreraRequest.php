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
        // $carreraId es la INSTANCIA del modelo Carrera (ej. /carreras/1)
        $carreraId = $this->route('carrera'); 

        return [
            // id_carrera es autoincremental en DB
            'id_carrera' => [
                'nullable',
                // Esta regla ya estaba correcta
                Rule::unique('carreras', 'id_carrera')->ignore($carreraId, 'id_carrera'),
            ], 
            
            // --- ✨ FIX: REGLA CORREGIDA ---
            // Usamos Rule::unique para que Laravel pueda extraer el ID del objeto $carreraId
            'nombre_carrera' => [
                'required',
                'string',
                'max:255',
                Rule::unique('carreras', 'nombre_carrera')->ignore($carreraId, 'id_carrera')
            ],
            // --- FIN DEL FIX ---
            
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
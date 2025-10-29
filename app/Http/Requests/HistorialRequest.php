<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistorialRequest extends FormRequest
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
    return [
        'calificacion' => 'required|numeric|min:0|max:100', // Agrega tus reglas de calificación
        
        // REGLA CLAVE 1: Valida que el n_control exista en la tabla 'alumnos' en la columna 'n_control'
        'FKn_control'  => 'required|string|exists:alumnos,n_control', 
        
        // REGLA CLAVE 2: Valida que el código de materia exista en la tabla 'materias' en la columna 'cod_materia'
        'FK_materia'   => 'required|string|exists:materias,cod_materia', 
        
        // REGLA CLAVE 3: Valida que la clave de profesor exista en la tabla 'profesores' en la columna 'n_trabajador'
        'FK_prof'      => 'required|string|exists:profesores,n_trabajador', 
        
        'periodo'      => 'required|string|max:10', // Agrega tus reglas de periodo
        'oportunidad'  => 'required|string|max:50', // Agrega tus reglas de oportunidad
    ];
}

// Puedes añadir mensajes de error personalizados para hacerlo más claro
public function messages()
{
    return [
        'FKn_control.exists' => 'El número de control ingresado no existe en la base de datos de alumnos.',
        'FK_materia.exists'  => 'El código de materia no existe.',
        'FK_prof.exists'     => 'La clave de profesor no existe.',
    ];
}
}

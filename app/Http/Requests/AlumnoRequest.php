<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // ✅ IMPORTANTE para la regla unique

class AlumnoRequest extends FormRequest
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
        // Obtenemos el alumno desde la ruta (si estamos editando)
        $alumno = $this->route('alumno'); 

        return [
            'n_control' => [
                'required',
                'string',
                'max:9',
                // ✅ Valida que el número de control sea único
                //    pero permite que el alumno conserve su mismo n_control al editar.
                Rule::unique('alumnos', 'n_control')->ignore($alumno),
            ],
            'nombre' => 'required|string|max:50',
            's_nombre' => 'nullable|string|max:50',
            'ap_pat' => 'required|string|max:50',
            'ap_mat' => 'required|string|max:50',
            'fech_nac' => 'required|date',
            'genero' => 'required|in:M,F',
            'FKid_carrera' => 'required|exists:carreras,id_carrera',
            'situacion' => 'required|in:Vigente,Baja,Egresado',
            'semestre' => 'nullable|integer|min:1|max:12',
            'promedio_general' => 'nullable|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'n_control.required' => 'El número de control es obligatorio.',
            'n_control.max' => 'El número de control no puede tener más de 9 caracteres.',
            'n_control.unique' => 'Este número de control ya está registrado. Intente con otro.', // ✅

            'nombre.required' => 'El primer nombre es obligatorio.',
            'ap_pat.required' => 'El apellido paterno es obligatorio.',
            'ap_mat.required' => 'El apellido materno es obligatorio.',
            'fech_nac.required' => 'La fecha de nacimiento es obligatoria.',
            'genero.required' => 'El género es obligatorio.',
            'FKid_carrera.required' => 'La carrera es obligatoria.',
            'situacion.required' => 'La situación es obligatoria.',
            'promedio_general.numeric' => 'El promedio general debe ser un número.',
            'promedio_general.min' => 'El promedio general no puede ser menor a 0.',
            'promedio_general.max' => 'El promedio general no puede ser mayor a 100.',
        ];
    }
}

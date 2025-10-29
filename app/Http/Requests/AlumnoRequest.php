<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'n_control' => 'required|string|max:20',
            'nombre' => 'required|string|max:50',
            's_nombre' => 'nullable|string|max:50',
            'ap_pat' => 'required|string|max:50',
            'ap_mat' => 'required|string|max:50',
            'fech_nac' => 'required|date',
            'genero' => 'required|in:M,F',
            'FKid_carrera' => 'required|exists:carreras,id_carrera',
            'situacion' => 'required|in:Vigente,Baja,Egresado',
            'semestre' => 'nullable|integer|min:1|max:12',
            'promedio_general' => 'nullable|numeric|min:0|max:100', // ✅ NUEVO
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'n_control.required' => 'El número de control es obligatorio.',
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
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfesoreRequest extends FormRequest
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
        // Lógica para n_trabajador y Correo
        $n_trabajador_rule = 'nullable|string'; 
        
        // Obtenemos la clave primaria del profesor actual para ignorarla en la validación unique (en caso de edición)
        // Usamos $this->route('profesore') porque así se llama el parámetro en las rutas de recurso.
        $profesoreNTrabajador = $this->route('profesore'); 

        $correo_unique_rule = Rule::unique('profesores', 'correo_institucional')
                                  ->ignore($profesoreNTrabajador, 'n_trabajador');
        
        return [
            // n_trabajador: El modelo se encarga de generarlo, por eso es 'nullable'.
            'n_trabajador' => $n_trabajador_rule, 
            
            // Campos obligatorios para la generación de código y para el registro
            'nombre' => 'required|string|max:255',
            'ap_materno' => 'required|string|max:255',
            'ap_paterno' => 'required|string|max:255',
            
            // Regla de unicidad y formato para el correo
            'correo_institucional' => ['required', 'string', 'email', 'max:255', $correo_unique_rule],
            
            // Campo opcional
            's_nombre' => 'nullable|string|max:255', 
            
            // === VALIDACIÓN DE SITUACIÓN ===
            // Los valores deben coincidir exactamente con los definidos en el ENUM/VARCHAR de la BD.
            'situacion' => 'required|in:Vigente,En Asignación,Inactivo/Baja', 
            
            // CLAVE FORÁNEA
            'FKcod_area' => 'required|integer|exists:areas,cod_area', 
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            // Mensajes para campos obligatorios
            'nombre.required' => 'El nombre del profesor es obligatorio.',
            'ap_materno.required' => 'El apellido materno es obligatorio.',
            'ap_paterno.required' => 'El apellido paterno es obligatorio.',

            // Mensajes para la Situación
            'situacion.required' => 'El estatus del profesor es obligatorio.',
            'situacion.in' => 'El estatus seleccionado no es válido (Debe ser Vigente, En Asignación o Inactivo/Baja).',
            
            // Mensajes para el campo FKcod_area
            'FKcod_area.required' => 'La selección del Área es obligatoria.',
            'FKcod_area.exists' => 'El código de área seleccionado no es válido o no existe.',
            
            // Mensajes para el correo
            'correo_institucional.required' => 'El correo institucional es obligatorio.',
            'correo_institucional.email' => 'El formato del correo es inválido.',
            'correo_institucional.unique' => 'Este correo institucional ya está registrado.',
        ];
    }
}

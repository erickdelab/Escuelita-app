<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Historial
 *
 * @property $id
 * @property $calificacion
 * @property $FKn_control
 * @property $FK_materia
 * @property $FK_prof
 * @property $periodo
 * @property $oportunidad
 * @property $created_at
 * @property $updated_at
 *
 * @property Alumno $alumno
 * @property Materium $materium
 * @property Profesore $profesore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Historial extends Model
{
    // Por defecto, Laravel ya incluye 'created_at' y 'updated_at' 
    // y asume que la tabla es 'historials'.

    protected $perPage = 20;

    /**
     * Los atributos que son asignables masivamente (Mass Assignable).
     *
     * NO incluimos 'id', 'created_at', ni 'updated_at' aquí.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'calificacion',
        'FKn_control',
        'FK_materia',
        'FK_prof',
        'periodo',
        'oportunidad'
    ];


    /**
     * Relación con la tabla alumnos.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alumno()
    {
        return $this->belongsTo(\App\Models\Alumno::class, 'FKn_control', 'n_control');
    }
    
    /**
     * Relación con la tabla materias.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materium()
    {
        return $this->belongsTo(\App\Models\Materium::class, 'FK_materia', 'cod_materia');
    }
    
    /**
     * Relación con la tabla profesores.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profesore()
    {
        return $this->belongsTo(\App\Models\Profesore::class, 'FK_prof', 'n_trabajador');
    }
    
}
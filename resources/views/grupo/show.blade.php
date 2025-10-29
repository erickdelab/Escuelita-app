<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $primaryKey = 'id_grupo';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_grupo',
        'cod_materia',
        'n_trabajador',
        'semestre'
    ];

    /**
     * Relación con la tabla materias
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'cod_materia', 'cod_materia');
    }

    /**
     * Relación con la tabla profesores
     */
    public function profesore()
    {
        return $this->belongsTo(Profesore::class, 'n_trabajador', 'n_trabajador');
    }

    /**
     * Relación con alumnos a través de la tabla pivote
     */
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_grupo', 'id_grupo', 'n_control');
    }
}